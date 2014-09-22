<?php session_start();
	include_once('connect_db.php');
	$sql="select compid from company where compname='{$_POST['comp']}'";
	$res=mysql_query($sql);
	if (!$res) {
    die('Invalid query: ' . mysql_error());
	}
	
	$comp=mysql_fetch_row($res)[0];
	
	$sql="select * from user where username='{$_POST['usrname']}' and password='{$_POST['pass']}' and compid='$comp'";
	$res=mysql_query($sql);
	
	if (!$res) {
    die('Invalid query: ' . mysql_error());
	}
	
	if(mysql_num_rows($res)){
		$_SESSION['username']=$_POST['usrname'];
		$_SESSION['company']=$comp;
		$_SESSION['companyName']=$_POST['comp'];
		header('Location: http://192.168.0.142/hisdb/main.php');
	}else{
		header('Location: http://192.168.0.142/hisdb/index.php?prc=fail');
	}
?>
