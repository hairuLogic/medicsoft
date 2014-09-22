
<?php
	include_once('connect_db.php');
	$sql="select MRN,Name,Newic from patmast where MRN='{$_POST['mrn']}'";
	$res=mysql_query($sql);
	$row=mysql_fetch_row($res);
	
	print "<?xml version='1.0' encoding='utf-8'?>
		<tab>
			<mrn>$row[0]</mrn>
			<name>$row[1]</name>
			<newic>$row[2]</newic>
		</tab>"; 
?>