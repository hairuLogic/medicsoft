<?php
	include_once('../../sschecker.php');
	include_once('../../connect_db.php');
	
	$json=array();
	$ic=$_GET['ic'];
	$compid=$_SESSION['company'];
	$sysno=$_GET['sysno'];
	$state=$_GET['state'];
	if($state=='upd'){
		$result=mysql_query("select newic from membership where newic='$ic' and compcode='$compid' and sysno!='$sysno'");
		$num_rows = mysql_num_rows($result);
		
	}else if($state=='add'){
		$result=mysql_query("select newic from membership where newic='$ic' and compcode='$compid'");
		$num_rows = mysql_num_rows($result);
	}
	
	if($num_rows>0){
		$json="repeat";//ada ic repeat
	}else{
		$json="notrepeat $sysno";//ic baru tak repeat
	}
	echo json_encode($json);
?>
