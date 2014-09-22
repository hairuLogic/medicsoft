<?php
	session_start();
	$amtpay=$_POST["amtpay"];
	$id=$_POST["id"];
	$compcode=$_SESSION['company'];
	include '../../config.php';
	
	$sql="UPDATE dbacthdr SET outamount=outamount-$amtpay WHERE compcode='$compcode' AND auditno='$id'";
	$res=mysql_query($sql);
	if(!$res){
		echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>fail</msg></tab>";
		die;
	}else{
		echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
	}
?>