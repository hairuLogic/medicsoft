<?php
	include_once('../../sschecker.php');
	include_once('../../connect_db.php');
	
	$othno=$_GET['othno'];
	$ic=$_GET['ic'];
	$json=array();
	if($ic!=''){
		$sql="select MemberNo,name from membership where newic='$ic' and compcode='{$_SESSION['company']}' limit 0,10";
	}else{
		$sql="select MemberNo,name from membership where idnumber='$othno' and compcode='{$_SESSION['company']}'  limit 0,10";
	}
	$res=mysql_query($sql);
	$json['pat']=array();
	if(mysql_num_rows($res)){
		$json['msg']='got';
		while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
			array_push($json['pat'],$row);
		}
	}else{
		$json['msg']='not';
	}
	
	echo json_encode($json);
?>
