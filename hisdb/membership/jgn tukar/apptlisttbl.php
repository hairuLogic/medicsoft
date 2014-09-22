<?php
// connect to the database
include_once('../../sschecker.php');
include_once('../../connect_db.php');
$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction
$mbrno= $_GET['mbrno'];
$icnum=$_GET['icnum'];
$compid=$_SESSION['company'];
$adduser=$_SESSION['username'];
if(!$sidx) $sidx =1;

$result = mysql_query("SELECT COUNT(*) AS count FROM apptbook where compcode='$compid' and memberno='$mbrno' and icnum='$icnum' ");	

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
		
		
		$SQL = "select sysno,apptdate,appttime,apptstatus,remarks from apptbook where compcode='$compid' and memberno='$mbrno' and icnum='$icnum' ORDER BY $sidx $sord LIMIT $start , $limit";
		
		
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
					$tok=explode('-',$row['apptdate']);
					$newdate=$tok[2].'-'.$tok[1].'-'.$tok[0];
					echo "<row id='". $row['sysno']."'>";
					echo "<cell><![CDATA[". $newdate."]]></cell>";
					echo "<cell><![CDATA[". $row['appttime']."]]></cell>";
					echo "<cell><![CDATA[". $row['apptstatus']."]]></cell>";
					echo "<cell><![CDATA[". $row['remarks']."]]></cell>";
					echo "</row>";
				}
		
			echo "</rows>";
			
}			
?>