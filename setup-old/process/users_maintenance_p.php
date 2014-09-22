<?php
session_start();
include_once('../../sschecker.php');
    $opStatus=$_POST['opStatus'];
    $compcode=$_SESSION['company'];
    $username=$_POST['username'];
    $password=$_POST['password'];
    $name=$_POST['name'];
    $groupid=$_POST['groupid'];
    $programmenu=$_POST['programmenu'];
    $deptcode=$_POST['deptcode'];
    $cashier=$_POST['cashier'];
    $priceview=$_POST['priceview'];
    
    if($cashier=='Yes'){
        $cashier="1";
    }else{
        $cashier="0";
    }
    
    if($priceview=='Yes'){
        $priceview="1";
    }else{
        $priceview="0";
    }

    include '../../config.php';

    if($opStatus == 'update'){
        $myquery = "UPDATE users
        SET password='{$password}',name='{$name}',groupid='{$groupid}',programmenu='{$programmenu}',deptcode='{$deptcode}',cashier='{$cashier}',priceview='{$priceview}'
        WHERE compcode='{$compcode}' and username='{$username}'";
        $res=mysql_query($myquery);
        
        if(!$res){
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>fail</msg></tab>";
            die;
        }else{
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
        }
    }

    else if($opStatus == 'delete'){
        $myquery = "DELETE FROM users WHERE compcode='{$compcode}' and username='{$username}'";
        $res=mysql_query($myquery);
        if(!$res){
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>fail</msg></tab>";
            die;
        }else{
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
        }
    }

    else if($opStatus == 'insert'){
        $myquery = "INSERT INTO users (compcode,username,password,name,groupid,programmenu,deptcode,cashier,priceview)
        VALUES ('{$compcode}','{$username}','{$password}','{$name}','{$groupid}','{$programmenu}','{$deptcode}','{$cashier}','{$priceview}')";
        $res=mysql_query($myquery);
        
        if(!$res){
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>fail</msg></tab>";
            die;
        }else{
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
        }
    }
?>
