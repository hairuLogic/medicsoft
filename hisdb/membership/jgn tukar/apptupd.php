<?php
	include_once('../../sschecker.php');
	include_once('../../connect_db.php');
	date_default_timezone_set("Asia/Kuala_Lumpur");
	$tok=explode('-',$_POST['dateappt']);
	$newdate=$tok[2].'-'.$tok[1].'-'.$tok[0];
	$sysno=$_POST['sysno'];
	$compid=$_SESSION['company'];
	$adduser=$_SESSION['username'];
	$date = date('Y-m-d');
	
	$sql="update apptbook set
			apptdate='$newdate',
			appttime='{$_POST['timeappt']}',
			apptstatus='{$_POST['statusappt']}',
			remarks='{$_POST['remarksappt']}',
			Lastupdate='$date',
			LastUser='$adduser'
		where compcode='$compid' and memberno='{$_POST['mbrno']}' and icnum='{$_POST['icnum']}' and sysno='$sysno'";
	$res=mysql_query($sql);
	if(!$res){
		die;
		echo mysql_error();
	}else{
		echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
	}
?>