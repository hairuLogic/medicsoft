<?php

// connect to the database
include_once('../../sschecker.php');
include_once('../../connect_db.php');
$compid=$_SESSION['company'];
$adduser=$_SESSION['username'];
$id = $_GET['id'];

$SQL = "select MemberNo,Name,Newic from membership where MemberNo='$id' and compcode='$compid' and category='nominee'";
$result = mysql_query( $SQL ) or die("Couldnt execute query.".mysql_error());

if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
header("Content-type: application/xhtml+xml;charset=utf-8"); } else {
header("Content-type: text/xml;charset=utf-8");
}
$et = ">";
echo "<?xml version='1.0' encoding='utf-8'?$et\n";
echo "<rows>";
// be sure to put text data in CDATA
while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
	echo "<row>";			
	echo "<cell><![CDATA[". $row['MemberNo']."]]></cell>";
	echo "<cell><![CDATA[". $row['Name']."]]></cell>";
	echo "<cell><![CDATA[". $row['Newic']."]]></cell>";
	echo "</row>";
}
echo "</rows>";


?>