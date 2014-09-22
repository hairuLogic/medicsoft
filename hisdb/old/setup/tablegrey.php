<?php
	include_once('connect_db.php');
		
		$table=$_POST['table'];
		$sql="select * from $table";
		$res=mysql_query($sql);
		echo "<?xml version='1.0' encoding='utf-8'?><tab>";
		while($obj=mysql_fetch_array($res,MYSQL_NUM)){
				echo 
				"<point>
						<code>{$obj[2]}</code>
						<des>{$obj[3]}</des>
				</point>";
		}
		echo "</tab>";
?>
