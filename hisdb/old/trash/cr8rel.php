<?php
	include_once('connect_db.php');
	$sql="insert into religion(ReligionCode, Description) values ('{$_POST['rc']}','{$_POST['des']}')" ;
	$res=mysql_query($sql);
?>
