<?php
// connect to the database
include_once('../../sschecker.php');
include_once('../../connect_db.php');
$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction
$tok=explode('-',$_GET['date']);
$date=$tok[2].'-'.$tok[1].'-'.$tok[0];
$compid=$_SESSION['company'];
$adduser=$_SESSION['username'];
if(!$sidx) $sidx =1;

$result = mysql_query("SELECT COUNT(*) AS count FROM apptbook where compcode='$compid' and apptdate='$date'");	

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
		
		
		$SQL = "select sysno,appttime as time,memberno as mbrno,icnum from apptbook where compcode='$compid' and apptdate='$date' ORDER BY time,$sidx $sord LIMIT $start , $limit";
		
		
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
					$res2=mysql_query("select name,telhp from membership where compcode='$compid' and newic='{$row['icnum']}' and memberno='{$row['mbrno']}'");
					$row2 = mysql_fetch_assoc($res2);
					$tok=explode(':',$row['time']);
					$newtime=$tok[0].':'.$tok[1];
					echo "<row id='". $row['sysno']."'>";
					echo "<cell><![CDATA[". $newtime."]]></cell>";
					echo "<cell><![CDATA[". $row['mbrno']."]]></cell>";
					echo "<cell><![CDATA[". $row2['name']."]]></cell>";
					echo "<cell><![CDATA[". $row['icnum']."]]></cell>";
					echo "<cell><![CDATA[". $row2['telhp']."]]></cell>";
					echo "</row>";
				}
			echo "</rows>";
			
}			
?>