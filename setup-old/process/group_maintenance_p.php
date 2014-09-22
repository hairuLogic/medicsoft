<?php
session_start();
include_once('../../sschecker.php');
    $opStatus=$_POST['opStatus'];
    $compcode=$_SESSION['company'];
    $groupid=$_POST['groupid'];
    $description=$_POST['description'];
    
    include '../../config.php';

    if($opStatus == 'update'){
        $myquery = "UPDATE groups
        SET description='{$description}'
        WHERE compcode='{$compcode}' and groupid='{$groupid}'";
        $res=mysql_query($myquery);
        
        if(!$res){
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>{$myquery}</msg></tab>";
            die;
        }else{
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
        }
    }

    else if($opStatus == 'delete'){
        $myquery = "DELETE FROM groups WHERE compcode='{$compcode}' and groupid='{$groupid}'";
        $res=mysql_query($myquery);
        if(!$res){
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>{$myquery}</msg></tab>";
            die;
        }else{
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
        }
    }

    else if($opStatus == 'insert'){
        $myquery = "INSERT INTO groups (compcode,groupid,description)
        VALUES ('{$compcode}','{$groupid}','{$description}')";
        $res=mysql_query($myquery);
        
        if(!$res){
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>{$myquery}</msg></tab>";
            die;
        }else{
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
        }
    }
?>
