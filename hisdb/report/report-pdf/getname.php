<?php
	include_once('../sschecker.php');
	include_once('../connect_db.php');

	$mrn=$_GET['mrn'];
	$json=array();
	$sql="select Name from patmast where CompCode='".$_SESSION['company']."' and MRN='$mrn'";
	$res=mysql_query($sql);
	if(mysql_num_rows($res)<1){
		$msg='no rows';	
	}else{
		$msg='success';
		while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
			$json[]=$row;
		}
	}
	
	$bigjson=array();
	$bigjson['data']=$json;
	$bigjson['msg']=$msg;
	
	echo json_encode($bigjson);
?>
