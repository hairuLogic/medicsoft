<?php
	session_start();
	$chgCode=$_POST["chgCode"];
	$compcode=$_SESSION['company'];
	/*$chgCode="black";//$_POST["chgCode"];
	$compcode="9a";//$_SESSION['company'];*/
	include '../../config.php';
	
	$result=mysql_query("SELECT COUNT(DISTINCT a.chgcode) AS COUNT FROM chgmast AS a WHERE a.compcode ='$compcode' AND a.chgCode='$chgCode'");
	$row = mysql_fetch_row($result,MYSQL_ASSOC);
    $count = $row['COUNT'];

	
	if($count=="1"){
		$result=mysql_query("SELECT a.chgcode,a.description,a.brandname FROM chgmast AS a WHERE a.chgcode='$chgCode' and a.compcode ='$compcode'");
		$row = mysql_fetch_row($result,MYSQL_ASSOC);
		echo "<?xml version='1.0' encoding='utf-8'?>
		<tab>
			<msg>".$count."</msg>
			<description>".$row['description']."</description>
			<brandname>".$row['brandname']."</brandname>
		</tab>";
		//<amt1></amt1><amt2></amt2>
		exit();
	}
	else{
		$result1=mysql_query("SELECT COUNT(DISTINCT a.chgcode) AS COUNT FROM chgmast AS a WHERE  a.compcode ='$compcode' and (a.description LIKE '%{$chgCode}%' OR a.brandname LIKE '%{$chgCode}%')");
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