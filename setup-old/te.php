<?php
$opStatus="program";//$_POST['opStatus'];
    $id="setup";//$_POST['id'];
		 include $_SERVER['DOCUMENT_ROOT'] .'/medicsoft/config.php';
        $myQuery="SELECT programname,lineno FROM programtab where programmenu='".$id."' and compcode ='".$_SESSION['company']."' order by lineno";
        $result=mysql_query($myQuery)or die($myQuery."<br/><br/>".mysql_error());

        while($row = mysql_fetch_array($result)){
            $array[$row[lineno]]= $row[programname];

        }

        echo json_encode($array);
       
?>