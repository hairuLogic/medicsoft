<?php
	include_once('../../sschecker.php');
	include_once('../../connect_db.php');
		
		$res2=mysql_query("update membership set category='SUBSCRIBER' where category='MEMBER'");

		
?>