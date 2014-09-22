<?php
// connect to the database
include_once('../../sschecker.php');
include_once('../../connect_db.php');
$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction
$pkgcode=$_GET['pkgcode'];
$compid=$_SESSION['company'];
$adduser=$_SESSION['username'];
$adddate = date('Y-m-d');
if(!$sidx) $sidx =1;

$result = mysql_query("SELECT COUNT(*) AS count FROM pkgmast where compcode='$compid' and pkgcode='$pkgcode'");	

$row = mysql_fetch_array($result,MYSQL_ASSOC);
$count = $row['count'];
if($count==0){
		if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
		header("Content-type: application/xhtml+xml;charset=utf-8"); } else {
		header("Content-type: text/xml;charset=utf-8");}
		$et = ">";
		echo "<?xml version='1.0' encoding='utf-8'?$et\n";
		echo "<rows>";
		echo "<page>0</page>";
		echo "<total>0</total>";
		echo "<records>0</records>";
		echo "</rows>";
	}else{
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; 
		
		
		$SQL = "select pkgcode,description,effectdate,price from pkgmast where compcode='$compid' and pkgcode='$pkgcode'";
		
		
		$result = mysql_query( $SQL ) or die("Couldn?t execute query.".mysql_error());
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
					echo "<row id='". $row['price']."'>";
					echo "<cell><![CDATA[". $row['pkgcode']."]]></cell>";
					echo "<cell><![CDATA[". $row['description']."]]></cell>";
					echo "<cell><![CDATA[". $row['effectdate']."]]></cell>";
					echo "<cell><![CDATA[". $row['price']."]]></cell>";
					echo "</row>";
				}
		
			echo "</rows>";
			
}			
?>