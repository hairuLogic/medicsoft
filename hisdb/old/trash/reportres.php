<?php
	include_once('connect_db.php');
	$table=$_POST['table'];
	$que="SELECT column_name FROM information_schema.columns WHERE table_name='$table'";
	$res=mysql_query($que);
	
	echo "<?xml version='1.0' encoding='utf-8'?><tab>";
	if($table=='patmast'){
		echo "<row><column>MRN</column><name>MRN</name><checked>yes</checked></row>
			<row><column>Name</column><name>Name</name><checked>yes</checked></row>
			<row><column>Other number</column><name>idnumber</name><checked>no</checked></row>
			<row><column>New i/c</column><name>Newic</name><checked>no</checked></row>
			<row><column>Old i/c</column><name>Oldic</name><checked>no</checked></row>
			<row><column>Religion</column><name>religion.Description</name><checked>yes</checked></row>
			<row><column>DOB</column><name>DOB</name><checked>yes</checked></row>
			<row><column>Citizen</column><name>citizen.Description</name><checked>no</checked></row>
			<row><column>Marital</column><name>marital.Description</name><checked>no</checked></row>
			<row><column>Language</column><name>languagecode.Description</name><checked>yes</checked></row>
			<row><column>Title</column><name>title.Description</name><checked>no</checked></row>
			<row><column>Race</column><name>racecode.Description</name><checked>yes</checked></row>
			<row><column>Blood Group</column><name>bloodgroup.Description</name><checked>no</checked></row>
			<row><column>Add User</column><name>AddUser</name><checked>no</checked></row>
			<row><column>Add Date</column><name>AddDate</name><checked>no</checked></row>
			<row><column>Last Update</column><name>patmast.Lastupdate</name><checked>no</checked></row>
			<row><column>Last User</column><name>patmast.LastUser</name><checked>no</checked></row>
			<row><column>Sex</column><name>patmast.Sex</name><checked>yes</checked></row>
		";
	}else{
		while($row=mysql_fetch_array($res,MYSQL_BOTH)){
			if(
				$row[0]=='Code'||$row[0]=='Description'||$row[0]=='createdBy'||$row[0]=='createdDate'||$row[0]=='LastUpdate'
				||$row[0]=='LastUser'||$row[0]=='MRN'||$row[0]=='Name'||$row[0]=='Lastupdate'||$row[0]=='AddUser'||$row[0]=='AddDate'||$row[0]=='Citizencode'
				||$row[0]=='OccupCode'||$row[0]=='idnumber'||$row[0]=='Newic'||$row[0]=='Religion'||$row[0]=='TitleCode'
			){
				echo 
					"<row>
						<column>{$row[0]}</column>
						<name>{$row[0]}</name>
						<checked>yes</checked>
					</row>";		
			}else{
				echo 
					"<row>
						<column>{$row[0]}</column>
						<name>{$row[0]}</name>
						<checked>no</checked>
					</row>";
			}
		}
		echo "</tab>";	
	}
		
?>