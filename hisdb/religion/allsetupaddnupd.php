<?php
	include_once('../sschecker.php');
	include_once('../connect_db.php');
	date_default_timezone_set("Asia/Kuala_Lumpur");
	$oper=$_GET['oper'];
	$code=$_GET['code'];
	$des=$_GET['des'];
	$table=$_GET['table'];
	$name=$_GET['username'];
	$date = date('Y-m-d');
	
	if($oper=='add'){
		$sql="INSERT into $table (Code,Description,createdBy,createdDate) values ('$code','$des','$name','$date')";
	}else if($oper=='upd'){
		$id=$_GET['id'];
		$sql="UPDATE $table set Code='$code',Description='$des',LastUpdate='$date',LastUser='$name' where sysno='$id'";
	}else if($oper=='del'){
		$id=$_GET['id'];
		$sql="DELETE from $table where sysno='$id'";
	}
	$res=mysql_query($sql);
	if(!$res){
		echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>failure</msg></tab>";
	}else{
		echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
	}
?>
