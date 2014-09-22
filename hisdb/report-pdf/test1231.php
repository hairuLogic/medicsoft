<?php
// connect to the database
include_once('../sschecker.php');
include_once('../connect_db.php');
$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction
$compid=$_SESSION['company'];
$adduser=$_SESSION['username'];
if(!$sidx) $sidx =1;
if(isset($_GET['searchField'])&&$_GET['searchString']!=''){
	$searchField=$_GET['searchField'];
	$searchString=$_GET['searchString'];
	$searchOper=$_GET['searchOper'];
	if($searchOper=='eq'){
		$result=mysql_query("SELECT COUNT(*) AS count FROM patmast WHERE $searchField = '$searchString' and compcode='$compid'");
	}if($searchOper=='ne'){
		$result=mysql_query("SELECT COUNT(*) AS count FROM patmast WHERE $searchField != '$searchString' and compcode='$compid'");
	}if($searchOper=='lk'){
		$result=mysql_query("SELECT COUNT(*) AS count FROM patmast WHERE $searchField LIKE '%$searchString%' and compcode='$compid'");
	}
}else{
	$result = mysql_query("SELECT COUNT(*) AS count FROM patmast where compcode='$compid'");	
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

if(isset($_GET['searchField'])&&$_GET['searchString']!=''){
		if($searchOper=='eq'){
			$SQL="select MRN, Name,Newic,Oldic,DOB,Sex,idnumber from patmast WHERE $searchField = '$searchString' and compcode='$compid' ORDER BY $sidx $sord LIMIT $start , $limit ";
		}if($searchOper=='ne'){
			$SQL="select MRN, Name,Newic,Oldic,DOB,Sex,idnumber from patmast WHERE $searchField != '$searchString' and compcode='$compid' ORDER BY $sidx $sord LIMIT $start , $limit";
		}if($searchOper=='lk'){
			$SQL="select MRN, Name,Newic,Oldic,DOB,Sex,idnumber from patmast WHERE $searchField LIKE '%$searchString%' and compcode='$compid' ORDER BY $sidx $sord LIMIT $start , $limit ";
		}
}else{
	$SQL = "select MRN, Name,Newic,Oldic,DOB,Sex,idnumber from patmast where compcode='$compid' ORDER BY $sidx $sord LIMIT $start , $limit";
}

$result = mysql_query( $SQL ) or die("Couldnt execute query.".mysql_error());
if($count==0){
	echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>nodata</msg></tab>";
}else{
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
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			echo "<row id='". $row['MRN']."'>";			
			echo "<cell>". $row['MRN']."</cell>";
			echo "<cell><![CDATA[". $row['Name']."]]></cell>";
			echo "<cell><![CDATA[". $row['Newic']."]]></cell>";
			echo "<cell><![CDATA[". $row['Oldic']."]]></cell>";
			echo "<cell><![CDATA[". $row['DOB']."]]></cell>";
			echo "<cell><![CDATA[". $row['Sex']."]]></cell>";
			echo "<cell><![CDATA[". $row['idnumber']."]]></cell>";
			echo "</row>";
		}

	echo "</rows>";	


}	
?>