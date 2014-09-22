<?php
// connect to the database
include_once('../../sschecker.php');
include_once('../../connect_db.php');
$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction
$compid=$_SESSION['company'];
$adduser=$_SESSION['username'];
$adddate = date('Y-m-d');

if(!$sidx) $sidx =1;

$result = mysql_query("SELECT COUNT(*) AS count FROM billtype where compcode='$compid' ");	

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
		
		
		$SQL = "select pkgcode,description,pkgflag from billtype where compcode='$compid'";
		
		
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
					
					$res3=mysql_query("select price,term from pkgmast where pkgcode='{$row['pkgcode']}' and effectdate <= CURDATE() ORDER BY effectdate desc")or die(mysql_error());
					$row3=mysql_fetch_row($res3);
					$term=$row3[1];$price=$row3[0];
					
					echo "<row id='". $row['pkgcode']."'>";
					echo "<cell><![CDATA[". $row['pkgcode']."]]></cell>";
					echo "<cell><![CDATA[". $row['description']."]]></cell>";
					echo "<cell><![CDATA[". $row['pkgflag']."]]></cell>";
					echo "<cell><![CDATA[". $price."]]></cell>";
					echo "<cell><![CDATA[". $term."]]></cell>";
					echo "<cell><![CDATA[1]]></cell>";
					echo "</row>";
				}
		
			echo "</rows>";
			
}			
?>