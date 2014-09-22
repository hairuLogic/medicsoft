<?php
	include_once('sschecker.php');
	include_once('connect_db.php');
	$col=$_GET['col'];
	$sectbl=$_GET['sectbl'];
	$json=array();
	$sql="select $sectbl.description,count($col) from patmast,$sectbl where patmast.CompCode='".$_SESSION['company']."' and patmast.$col=$sectbl.code group by patmast.$col";
	$res=mysql_query($sql);
	while($row=mysql_fetch_array($res,MYSQL_NUM)){
		$json[]=$row;
	}
	echo json_encode($json,JSON_NUMERIC_CHECK);
?>