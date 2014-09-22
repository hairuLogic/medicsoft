<?php
	include_once("../connect_db.php");

	$datefromx=explode('/',$_GET['datefrom']);
	$datefrom=$datefromx[2].'-'.$datefromx[1].'-'.$datefromx[0];
	$dateuntilx=explode('/',$_GET['dateuntil']);
	$dateuntil=$dateuntilx[2].'-'.$dateuntilx[1].'-'.$dateuntilx[0];
	
	$sql="truncate statistics";
	$res=mysql_query($sql);
	
	$sql="select compcode,sex,citizencode,areacode,racecode,religion,languagecode,adddate from patmast where adddate between '$datefrom' and '$dateuntil'";
	$res=mysql_query($sql);
	
	$count=0;
	while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
		$tok=explode('-',$row['adddate']);
		$sql="insert into statistics (compcode,sex,citizencode,area,racecode,religion,languagecode,year,month,day) values (
			'{$row['compcode']}',
			'{$row['sex']}',
			'{$row['citizencode']}',
			'{$row['areacode']}',
			'{$row['racecode']}',
			'{$row['religion']}',
			'{$row['languagecode']}',
			'{$tok[0]}',
			'{$tok[1]}',
			'{$tok[2]}')";
		$res2=mysql_query($sql);
		$count++;
	}
	
	$json=array();
	$json['count']=$count;
	
	echo json_encode($json);
?>
