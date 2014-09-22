<?php
	session_start();
	$paymode=$_POST["paymode"];
	$compcode=$_SESSION['company'];
	include '../../config.php';
	
	$parts = explode(' ', $paymode);
	$partsLength  = count($parts);
	while($partsLength>0){
		$partsLength--;
		$addSql .=" and (description LIKE '%{$parts[$partsLength]}%' or paymode LIKE '%{$parts[$partsLength]}%')";
	}
		
	$result=mysql_query("SELECT COUNT(*) AS COUNT FROM paymode WHERE compcode ='$compcode' $addSql");
	$row = mysql_fetch_row($result,MYSQL_ASSOC);
    $count = $row['COUNT'];
	
	if($count=="1"){
		$result=mysql_query("SELECT paymode,cardflag FROM paymode WHERE compcode ='$compcode' $addSql");
		$row = mysql_fetch_row($result,MYSQL_ASSOC);
		echo "<?xml version='1.0' encoding='utf-8'?>
		<tab>
			<msg>".$count."</msg>
			<paymode>".$row['paymode']."</paymode>
			<cardflag>".$row['cardflag']."</cardflag>
		</tab>";
		//<amt1></amt1><amt2></amt2>
		exit();
	}
	else{
		$result1=mysql_query("SELECT COUNT(*) AS COUNT FROM paymode WHERE compcode ='$compcode' and a.description LIKE '%{$paymode}%'");
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