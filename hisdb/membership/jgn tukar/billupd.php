<?php
	include_once('../../sschecker.php');
	include_once('../../connect_db.php');
	date_default_timezone_set("Asia/Kuala_Lumpur");
	function chgdate($date){
		$tok=explode('-',$date);
		$newrow=$tok[2].'-'.$tok[1].'-'.$tok[0];
		return $newrow;
	}
	$joindate=chgdate($_POST['joindate']);
	$aggdate=chgdate($_POST['aggdate']);
	$expdate=chgdate($_POST['expdate']);
	$auditno=$_POST['auditno'];
	$compid=$_SESSION['company'];
	$adduser=$_SESSION['username'];
	$date = date('Y-m-d');
	
	$sql="update dbacthdr set
			amount='{$_POST['billfees2']}',
			outamount='{$_POST['billfees2']}',
			remark='{$_POST['description']}',
			pkgcode='{$_POST['pkgcode']}',
			agentcode='{$_POST['billagent']}',
			agreementdate='$aggdate',
			entrydate='$joindate',
			expdate='$expdate' 
		where auditno='$auditno'";
	$res=mysql_query($sql)or die("Couldn?t execute query.".mysql_error());
	
	if($_POST['pkgstat']==1){
		$res2=mysql_query("update membership set agentcode='{$_POST['billagent']}', pkgcode='{$_POST['pkgcode']}' where memberno='{$_POST['memberno']}'")or die("Couldn?t execute query.".mysql_error());	
	}
	
	if(!$res){
		die;
		echo mysql_error();
	}else{
		echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
	}
?>