<?php

	include_once('connect_db.php');
	$sql="select PValue1 from sysparam where Compcode='1'";
	$res=mysql_query($sql);
	if(!$res){
		die;
		echo mysql_error();
	}else{
		$row=mysql_fetch_assoc($res);
		$newmrn=$row['PValue1'];
		echo $newmrn;
	}
	$x=$newmrn+1;
	$sql="update sysparam set PValue1 = '$x' where Compcode='1'";
	$res=mysql_query($sql);
	
?>