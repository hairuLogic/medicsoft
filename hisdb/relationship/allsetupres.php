<?php
include_once('../sschecker.php');
include_once('../connect_db.php');
$table=$_GET['table'];
$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction
if(!$sidx) $sidx =1;
$result = mysql_query("SELECT COUNT(*) AS count FROM $table");
$row = mysql_fetch_array($result,MYSQL_ASSOC);
$count = $row['count'];

if( $count >0 ) {
	$total_pages = ceil($count/$limit);
} else {
	$total_pages = 0;
}
if ($page > $total_pages) $page=$total_pages;
$start = $limit*$page - $limit; 

$SQL = "select sysno,relationshipcode,description,lastuser,lastupdate from $table ORDER BY $sidx $sord LIMIT $start , $limit";
$result = mysql_query( $SQL ) or die("Couldnt execute query.".mysql_error());

if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
header("Content-type: application/xhtml+xml;charset=utf-8"); } else {
header("Content-type: text/xml;charset=utf-8");
}

$et = ">";

echo "<?xml version='1.0' encoding='utf-8'?$et\n";
echo "<rows>";
echo "<page>".$page."</page>";
echo "<total>".$total_pages."</total>";
echo "<records>".$count."</records>";
// be sure to put text data in CDATA
while($row = mysql_fetch_array($result,MYSQL_NUM)) {
	$tok=explode('-',$row[4]);
	$newrow=$tok[2].'-'.$tok[1].'-'.$tok[0];
	echo "<row id='". $row[0]."'>";
	echo "<cell><![CDATA[". $row[1]."]]></cell>";
	echo "<cell><![CDATA[". $row[2]."]]></cell>";
	echo "<cell><![CDATA[". $row[3]."]]></cell>";
	echo "<cell><![CDATA[". $newrow."]]></cell>";
	echo "</row>";
}
echo "</rows>";	
?>
