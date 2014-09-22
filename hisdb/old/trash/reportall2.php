<?php
include_once('sschecker.php');
include_once('connect_db.php');
$table=$_GET['table'];
$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction
$compid=$_SESSION['company'];
if(!$sidx) $sidx =1;
if($table=='patmast'){
	$result = mysql_query("SELECT COUNT(*) AS count FROM patmast where patmast.Compcode='$compid'");
}else{
	$result = mysql_query("SELECT COUNT(*) AS count FROM $table");
}
$row = mysql_fetch_array($result,MYSQL_ASSOC);
$count = $row['count'];

if( $count >0 ) {
	$total_pages = ceil($count/$limit);
} else {
	$total_pages = 0;
}
if ($page > $total_pages) $page=$total_pages;
$start = $limit*$page - $limit; 
if($table=='patmast'){
	$SQL= "select MRN, Name, idnumber, Newic, Oldic, religion.Description, DOB, citizen.Description, marital.Description, languagecode.Description,
			title.Description, racecode.Description, bloodgroup.Description, AddUser, AddDate, patmast.Lastupdate, patmast.LastUser,Sex  
			from patmast, religion, citizen, marital, languagecode, title, racecode, bloodgroup 
			where 
				patmast.Religion=religion.Code and
				patmast.Citizencode=citizen.Code and
				patmast.MaritalCode=marital.Code and
				patmast.LanguageCode=languagecode.Code and
				patmast.TitleCode=title.Code and
				patmast.RaceCode=racecode.Code and
				patmast.bloodgrp=bloodgroup.Code and
				patmast.Compcode='$compid'
			ORDER BY $sidx $sord LIMIT $start , $limit ";
}else{
	$SQL = "select * from $table ORDER BY $sidx $sord LIMIT $start , $limit";
}
$result = mysql_query( $SQL ) or die("Couldnt execute query.".mysql_error());
$sql="SELECT COUNT(column_name) FROM information_schema.columns WHERE table_name='$table'";
$res=mysql_query($sql);
$col=mysql_fetch_row($res)[0];

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
	echo "<row>";
	for($x=0;$x<$col;$x++){
		echo "<cell><![CDATA[".$row[$x]."]]></cell>";
	}
	echo "</row>";
}
echo "</rows>";	
?>

