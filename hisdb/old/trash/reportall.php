<?php
	include_once('connect_db.php');
	$table=$_GET['table'];
	$sql="SELECT COUNT(column_name) FROM information_schema.columns WHERE table_name='$table'";
	$res=mysql_query($sql);
	$col=mysql_fetch_row($res)[0];
	$sql="SELECT column_name FROM information_schema.columns WHERE table_name='$table'";
	$colname=mysql_query($sql);
	$sql="select * from $table";
	$res=mysql_query($sql);
	echo "<?xml version='1.0' encoding='utf-8'?><tab>";
	if($table=='patmast'){
		echo "<tab><col><many>$col</many></col><theadx>";
		echo "<thx><val>MRN</val><name>MRN</name></thx>
			<thx><val>Name</val><name>Name</name></thx>
			<thx><val>idnumber</val><name>Other number</name></thx>
			<thx><val>Newic</val><name>New i/c</name></thx>
			<thx><val>Oldic</val><name>Old i/c</name></thx>
			<thx><val>religion.Description</val><name>Religion</name></thx>
			<thx><val>DOB</val><name>DOB</name></thx>
			<thx><val>citizen.Description</val><name>Citizen</name></thx>
			<thx><val>marital.Description</val><name>Marital</name></thx>
			<thx><val>languagecode.Description</val><name>Language</name></thx>
			<thx><val>title.Description</val><name>Title</name></thx>
			<thx><val>racecode.Description</val><name>Race</name></thx>
			<thx><val>bloodgroup.Description</val><name>Blood Group</name></thx>
			<thx><val>AddUser</val><name>Add User</name></thx>
			<thx><val>AddDate</val><name>Add Date</name></thx>
			<thx><val>patmast.Lastupdate</val><name>Last Update</name></thx>
			<thx><val>patmast.LastUser</val><name>Last User</name></thx>
			<thx><val>patmast.Sex</val><name>Sex</name></thx>";
		echo "</theadx></tab>";
	}else{
		echo "<tab><col><many>$col</many></col><theadx>";
		while($row=mysql_fetch_array($colname)){
			echo "<thx><val>$row[0]</val><name>$row[0]</name></thx>";
		}echo "</theadx></tab>";

	}
	?>