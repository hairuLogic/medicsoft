<?php
session_start();
include_once('../../sschecker.php');
    $canrun=$_POST['canrun'];
    $groupid=$_POST['groupid'];
    $programid=$_POST['programid'];
    $programmenu=$_POST['programmenu'];
    $lineno=$_POST['lineno'];
    
    
    include '../../config.php';

    if($canrun=="Yes"){//insert
        $myquery = "INSERT INTO groupacc (compcode,groupid,programmenu,lineno,canrun) VALUES ('{$_SESSION['company']}','{$groupid}','{$programmenu}','{$lineno}','1')";
        $res=mysql_query($myquery);
        if(!$res){
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>fail</msg></tab>";
            die;
        }else{
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
        }
    }
    else{//delete
        $myquery = "DELETE FROM groupacc WHERE lineno='{$lineno}' and programmenu='{$programmenu}' and compcode='{$_SESSION['company']}'";
        $res=mysql_query($myquery);
        if(!$res){
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>fail</msg></tab>";
            die;
        }else{
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
        }
    }

?>
