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
	$table='agent';
	$name=$_GET['username'];
	$date = date('Y-m-d');
	
	if($oper=='add'){
		$sql="INSERT into $table (agentcode,name,adduser,addDate) values ('$code','$des','$name','$date')";
	}else if($oper=='upd'){
		$id=$_GET['id'];
		$sql="UPDATE $table set agentCode='$code',name='$des',upddate='$date',upduser='$name' where sysno='$id'";
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
