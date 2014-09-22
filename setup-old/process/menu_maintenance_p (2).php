<?php
session_start();
    $opStatus=$_POST['opStatus'];
    $id=$_POST['id'];
    $at_where=$_POST['at_where'];
    $lineno=$_POST['lineno'];
    $programname=$_POST['programname'];
    $bmpid=$_POST['bmpid'];
    $condition1=$_POST['condition1'];
    $condition2=$_POST['condition2'];
    $condition3=$_POST['condition3'];
    $remarks=$_POST['remarks'];
    $url=$_POST['url'];
    $compcode=$_SESSION['company'];
    $programid=$_POST['programid'];
    $programtypeA=$_POST['programtypeA'];
    $programmenu=$_POST['programmenu'];
    $date = date('Y-m-d');
    $adduser=$_SESSION['username'];
    $idAfter=isset($_POST['idAfter']);     //lineno after
    //$child=$_POST['child'];
    include '../../config.php';

    if($opStatus == 'program'){
        $array=array();
        $myQuery="SELECT programname,lineno FROM programtab where programmenu='".$id."' and compcode ='".$compcode."' order by lineno";
        $result=mysql_query($myQuery)or die($myQuery."<br/><br/>".mysql_error());
        while($row = mysql_fetch_array($result)){
            $array[$row[lineno]]= $row[programname];
			
        }
        echo $myQuery;
        echo json_encode($array);
    }

    //update operation
    else if($opStatus == 'update'){
        $myquery = "UPDATE programtab 
        SET programname='".$programname."', bmpid='".$bmpid."',condition1='".$condition1."',condition2='".$condition2."',condition3='".$condition3."',remarks='".$remarks."',url='".$url."' 
        WHERE compcode='".$compcode."' and programid='".$programid."'";
        $res=mysql_query($myquery);
        if(!$res){
            die;
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>".mysql_error()."</msg></tab>";
        }else{
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
        }
    }

    //delete operation
    else if($opStatus == 'delete'){
        if($child!="0"){
            mysql_query("START TRANSACTION");
//update delete id jd lineno=0 ; nak elak child jd orphen
            $a1 = mysql_query('UPDATE programtab,(SELECT max(lineno)+1 as maxline FROM programtab WHERE programmenu="" and compcode="'.$compcode.'")subq SET programmenu="" , lineno=subq.maxline WHERE lineno="'.$lineno.'" and programmenu="'.$programmenu.'" and programid="'.$programid.'" and compcode="'.$compcode.'"');

        $a5=mysql_query('DELETE FROM groupacc WHERE lineno="'.$lineno.'" and programmenu="'.$programmenu.'"  and compcode="'.$compcode.'"');
        
            $a2 = mysql_query('UPDATE programtab SET lineno = lineno - 1 WHERE compcode="'.$compcode.'" and programmenu="'.$programmenu.'" and lineno > "'.$lineno.'" order by lineno');

            $a3 = mysql_query('UPDATE groupacc SET lineno = lineno - 1 WHERE compcode="'.$compcode.'" and programmenu="'.$programmenu.'" and lineno > "'.$lineno.'" order by lineno');
        }
        else{
            mysql_query("START TRANSACTION");

            $a1 = mysql_query('DELETE FROM programtab WHERE lineno="'.$lineno.'" and programmenu="'.$programmenu.'" and programid="'.$programid.'" and compcode="'.$compcode.'"');

            
        $a5=mysql_query('DELETE FROM groupacc WHERE lineno="'.$lineno.'" and programmenu="'.$programmenu.'"  and compcode="'.$compcode.'"');
        
            $a2 = mysql_query('UPDATE programtab SET lineno = lineno - 1 WHERE compcode="'.$compcode.'" and programmenu="'.$programmenu.'" and lineno > "'.$lineno.'" order by lineno');

            $a3 = mysql_query('UPDATE groupacc SET lineno = lineno - 1 WHERE compcode="'.$compcode.'" and programmenu="'.$programmenu.'" and lineno > "'.$lineno.'" order by lineno');
        }
        
        if ($a1 and $a2 and $a3 and $a5) {
            mysql_query("COMMIT");
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
        } else {        
            mysql_query("ROLLBACK");
        }
    }
    else if($opStatus == 'insert'){
        if($at_where=='after'){
            mysql_query("START TRANSACTION");

            $a1 = mysql_query('UPDATE programtab SET lineno = lineno + 1 WHERE compcode="'.$compcode.'" and programmenu="'.$programmenu.'" and lineno > "'.$idAfter.'" order by lineno DESC');

            $a3 = mysql_query('UPDATE groupacc SET lineno = lineno + 1 WHERE compcode="'.$compcode.'" and programmenu="'.$programmenu.'" and lineno > "'.$idAfter.'" order by lineno DESC');

            $a2 = mysql_query('INSERT INTO programtab (compcode,programmenu,lineno,programname,programid,programtype,url,remarks,condition1,condition2,condition3,bmpid,adduser)
                VALUES ("'.$compcode.'","'.$programmenu.'","'.$idAfter.'"+1,"'.$programname.'","'.$programid.'","'.$programtypeA.'","'.$url.'","'.$remarks.'","'.$condition1.'","'.$condition2.'","'.$condition3.'","'.$bmpid.'","'.$adduser.'")');
        }
        else if($at_where=='first'){
            mysql_query("START TRANSACTION");

            $a1 = mysql_query('UPDATE programtab SET lineno = lineno + 1 WHERE compcode="'.$compcode.'" and programmenu="'.$programmenu.'" order by lineno DESC');

            $a3 = mysql_query('UPDATE groupacc SET lineno = lineno + 1 WHERE compcode="'.$compcode.'" and programmenu="'.$programmenu.'" order by lineno DESC');

            $a2 = mysql_query('INSERT INTO programtab (compcode,programmenu,lineno,programname,programid,programtype,url,remarks,condition1,condition2,condition3,bmpid,adduser)
                VALUES ("'.$compcode.'","'.$programmenu.'","1","'.$programname.'","'.$programid.'","'.$programtypeA.'","'.$url.'","'.$remarks.'","'.$condition1.'","'.$condition2.'","'.$condition3.'","'.$bmpid.'","'.$adduser.'")');

        }
        else if($at_where=='last'){
            mysql_query("START TRANSACTION");

            $a1 = mysql_query('INSERT INTO programtab (compcode,programmenu,lineno,programname,programid,programtype,url,remarks,condition1,condition2,condition3,bmpid,adduser)
                select "'.$compcode.'","'.$programmenu.'", max(lineno)+1,"'.$programname.'","'.$programid.'","'.$programtypeA.'","'.$url.'","'.$remarks.'","'.$condition1.'","'.$condition2.'","'.$condition3.'","'.$bmpid.'","'.$adduser.'" 
                from programtab
                WHERE compcode="'.$compcode.'" and programmenu="'.$programmenu.'"');


        }
        $a4=mysql_query("SELECT programmenu,lineno FROM `programtab` where compcode='{$compcode}' and programid='{$programmenu}'");
        while($row = mysql_fetch_array($a4)){
            $a5 = mysql_query("SELECT groupid from groupacc where programmenu='{$row['programmenu']}' and lineno='{$row['lineno']}' and compcode='{$compcode}' and yesall='1'");
            while($row1 = mysql_fetch_array($a5)){
                $a6 = mysql_query("INSERT INTO groupacc (compcode,groupid,programmenu,lineno,canrun,yesall) SELECT '{$compcode}','{$row1['groupid']}','{$programmenu}',lineno,1,0 FROM programtab where compcode='{$compcode}' and programid='{$programid}' and programmenu='{$programmenu}'");
            }
        }
        
        if($a2==""){
            if ($a1 ) {
                mysql_query("COMMIT");
                echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
            } else {        
                mysql_query("ROLLBACK");
            }
        }
        else if ($a1 and $a2 and $a3) {
            mysql_query("COMMIT");
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
        } else {        
            mysql_query("ROLLBACK");
        }


    }
?>
