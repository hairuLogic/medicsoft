<?php
	session_start();
	$agent=$_POST["agent"];
	$compcode=$_SESSION['company'];
	include '../../config.php';
	
	$result=mysql_query("SELECT COUNT(*) AS COUNT FROM agent WHERE compcode ='$compcode' AND (agentcode='$agent' or name='$agent')");
	$row = mysql_fetch_row($result,MYSQL_ASSOC);
    $count = $row['COUNT'];

	
	if($count=="1"){
		$result=mysql_query("SELECT agentcode,name FROM agent WHERE compcode ='$compcode' AND (agentcode='$agent' or name='$agent')");
		$row = mysql_fetch_row($result,MYSQL_ASSOC);
		echo "<?xml version='1.0' encoding='utf-8'?>
		<tab>
			<msg>".$count."</msg>
			<agentcode>".$row['agentcode']."</agentcode>
			<name>".$row['name']."</name>
		</tab>";
		//<amt1></amt1><amt2></amt2>
		exit();
	}
	else{
		$result1=mysql_query("SELECT COUNT(*) AS COUNT FROM agent WHERE compcode ='$compcode' and a.name LIKE '%{$agent}%'");
		$row1 = mysql_fetch_array($result1);
		$count1 = $row1['COUNT'];
		if($count1=='0'){
			echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>empty</msg></tab>";	
		}
		else{
			echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>pop</msg></tab>";	
		}
	}
?>