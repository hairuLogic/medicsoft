<?php
	session_start();
	$chgCode=$_POST["chgCode"];
	$compcode=$_SESSION['company'];
	/*$chgCode="black";//$_POST["chgCode"];
	$compcode="9a";//$_SESSION['company'];*/
	include '../../config.php';
	
	$result=mysql_query("SELECT COUNT(DISTINCT p.chgcode) AS COUNT FROM chgprice AS p, chgmast AS a WHERE p.chgcode=a.chgcode AND p.effdate < CURDATE() AND p.compcode ='$compcode' AND a.chgCode='$chgCode'");
	$row = mysql_fetch_row($result,MYSQL_ASSOC);
    $count = $row['COUNT'];

	
	if($count=="1"){
		$result=mysql_query("SELECT a.chgcode,p.effdate,p.amt1,p.amt2,a.description,a.brandname,a.chgtype,a.chggroup FROM chgprice AS p, chgmast AS a WHERE p.effdate = ( SELECT MAX(effdate) FROM chgprice WHERE chgcode = p.chgcode AND compcode ='9a' AND effdate < CURDATE()) AND a.chgcode=p.chgcode AND a.chgcode='$chgCode'");
		$row = mysql_fetch_row($result,MYSQL_ASSOC);
		echo "<?xml version='1.0' encoding='utf-8'?>
		<tab>
			<msg>".$count."</msg>
			<amt1>".$row['amt1']."</amt1>
			<amt2>".$row['amt2']."</amt2>
			<description>".$row['description']."</description>
			<brandname>".$row['brandname']."</brandname>
			<chgtype>".$row['chgtype']."</chgtype>
			<chggroup>".$row['chggroup']."</chggroup>
		</tab>";
		//<amt1></amt1><amt2></amt2>
		exit();
	}
	else{
		$result1=mysql_query("SELECT COUNT(DISTINCT p.chgcode) AS COUNT FROM chgprice AS p, chgmast AS a WHERE p.chgcode=a.chgcode AND p.effdate < CURDATE() AND p.compcode ='$compcode' and (a.description LIKE '%{$chgCode}%' OR a.brandname LIKE '%{$chgCode}%')");
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