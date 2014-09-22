<?php
	include_once('../sschecker.php');
	include_once('../connect_db.php');
	date_default_timezone_set("Asia/Kuala_Lumpur");
	function yesno($data){
		if($data=='1')return 'Yes';
		else if($data=='0')return 'No';
		else if($data=='Yes')return '1';
		else if($data=='No')return '0';
	}
	function chgdate($date){
		$tok=explode('-',$date);
		$newrow=$tok[2].'-'.$tok[1].'-'.$tok[0];
		return $newrow;
	}
	$oper=$_GET['oper'];
	$code=$_GET['code'];
	$des=$_GET['des'];
	$ok=$_GET['pkgstat'];
	$pkgstat=yesno($ok);
	$table='billtype';
	$compid=$_SESSION['company'];
	$adduser=$_SESSION['username'];
	$date = date('Y-m-d');
	
	if($oper=='add'){
		$sql="INSERT into $table (pkgCode,compcode,Description,pkgflag,addBy,addDate) values ('$code','$compid','$des','$pkgstat','$adduser','$date')";
	}else if($oper=='upd'){
		$id=$_GET['id'];
		$sql="UPDATE $table set pkgCode='$code',Description='$des',pkgflag='$pkgstat',updatedate='$date',updateby='$adduser' where sysno='$id'";
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
