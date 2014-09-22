<?php
// connect to the database
include_once('../../sschecker.php');
include_once('../../connect_db.php');
$compid=$_SESSION['company'];
$adduser=$_SESSION['username'];
$json=array();

$result = mysql_query("select apptdate from apptbook where compcode='$compid'");	

while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
	$tok=explode('-',$row['apptdate']);
	$newdate=$tok[1].'-'.$tok[2].'-'.$tok[0];
	array_push($json,$newdate);
}

echo json_encode($json);
?>