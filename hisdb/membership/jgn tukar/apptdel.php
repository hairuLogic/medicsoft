<?php
	include_once('../../sschecker.php');
	include_once('../../connect_db.php');
	$sysno=$_POST['sysno'];
	
	$sql="DELETE FROM apptbook WHERE sysno='$sysno'";
	$res=mysql_query($sql);
	if(!$res){
		die;
		echo mysql_error();
	}else{
		echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
	}
?>