<?php
	include_once('../../sschecker.php');
	include_once('../../connect_db.php');
	date_default_timezone_set("Asia/Kuala_Lumpur");
	$tok=explode('-',$_POST['dateappt']);
	$newdate=$tok[2].'-'.$tok[1].'-'.$tok[0];
	$compid=$_SESSION['company'];
	$adduser=$_SESSION['username'];
	$adddate = date('Y-m-d');
	
	$sql="insert into apptbook(
			CompCode,
			memberno,
			icnum,
			apptdate,
			appttime,
			apptstatus,
			remarks,
			AddUser,
			AddDate
		) values (
			'$compid',
			'{$_POST['mbrno']}',
			'{$_POST['icnum']}',
			'$newdate',
			'{$_POST['timeappt']}',
			'{$_POST['statusappt']}',
			'{$_POST['remarksappt']}',
			'$adduser',
			'$adddate'
		)";
	$res=mysql_query($sql);
	if(!$res){
		die;
		echo mysql_error();
	}else{
		echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
	}
?>