<?php
	include_once('connect_db.php');
	$sql="delete from patmast where MRN='{$_POST['mrn']}'";
	$res=mysql_query($sql);
	if (!$res) {
    die('Invalid query: ' . mysql_error());
	}
	
	header('Location: http://localhost/hisdb/patregistration.php');
?>