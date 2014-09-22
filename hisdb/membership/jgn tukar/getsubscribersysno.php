<?php
	include_once('../../sschecker.php');
	include_once('../../connect_db.php');
	$compid=$_SESSION['company'];
	$adduser=$_SESSION['username'];
	
	$res=mysql_query("select sysno from membership where memberno='{$_GET['mbrno']}' and compcode='$compid' and category='MEMBER'");
	$sysno=mysql_fetch_row($res)[0];
	if(!$res){
		die;
		echo mysql_error();
	}else{
		echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>$sysno</msg></tab>";
	}
?>