<?php
	include_once('connect_db.php');
	$sql="update religion set
			ReligionCode='{$_POST['rc2']}',
			Description='{$_POST['des2']}'
		where ReligionCode='{$_POST['rc2']}'";
	$res=mysql_query($sql);
?>
