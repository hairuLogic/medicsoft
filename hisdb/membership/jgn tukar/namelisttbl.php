<?php
// connect to the database
include_once('../../sschecker.php');
include_once('../../connect_db.php');
$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction
$mbrno= $_GET['mbrno'];
$compid=$_SESSION['company'];
$adduser=$_SESSION['username'];
if(!$sidx) $sidx =1;

$result = mysql_query("SELECT COUNT(*) AS count FROM membership where compcode='$compid' and memberno='$mbrno' ");	

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
		
		
		$SQL = "select sysno,MemberNo,Name,DOB,Newic,telh,telhp,telo,email from membership where compcode='$compid' and memberno='$mbrno' ORDER BY category,$sidx $sord LIMIT $start , $limit";
		
		
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
					$tok=explode('-',$row['DOB']);
					$newdob=$tok[2].'-'.$tok[1].'-'.$tok[0];
					echo "<row id='". $row['sysno']."'>";			
					echo "<cell>". $row['MemberNo']."</cell>";
					echo "<cell><![CDATA[". $row['Name']."]]></cell>";
					echo "<cell><![CDATA[". $newdob."]]></cell>";
					echo "<cell><![CDATA[". $row['Newic']."]]></cell>";
					echo "<cell><![CDATA[". $row['telh']."]]></cell>";
					echo "<cell><![CDATA[". $row['telhp']."]]></cell>";
					echo "<cell><![CDATA[". $row['telo']."]]></cell>";
					echo "<cell><![CDATA[". $row['email']."]]></cell>";
					echo "</row>";
				}
		
			echo "</rows>";
			
}			
?>