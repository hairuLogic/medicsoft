<?php
// connect to the database
include_once('../../sschecker.php');
include_once('../../connect_db.php');
function chgdate($date){
	$tok=explode('-',$date);
	$newrow=$tok[2].'-'.$tok[1].'-'.$tok[0];
	return $newrow;
}
$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction
$mbrno=$_GET['mbrno'];
$compid=$_SESSION['company'];
$adduser=$_SESSION['username'];
if(!$sidx) $sidx =1;

$result = mysql_query("SELECT COUNT(*) AS count FROM dbacthdr where compcode='$compid' and memberno='$mbrno'");	

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
		
		
		$SQL = "select pkgcode,dbacthdr.agentcode,auditno,remark,agent.name as name,entrydate,expdate,amount,memberno,agreementdate from dbacthdr,agent where dbacthdr.compcode='$compid' and memberno='$mbrno' and agent.agentcode=dbacthdr.agentcode ORDER BY auditno desc LIMIT $start , $limit";
		
		
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
					echo "<row id='". $row['auditno']."'>";	
					echo "<cell><![CDATA[". $row['remark']."]]></cell>";
					echo "<cell><![CDATA[". $row['name']."]]></cell>";
					echo "<cell><![CDATA[". chgdate($row['entrydate'])."]]></cell>";
					echo "<cell><![CDATA[". chgdate($row['agreementdate'])."]]></cell>";
					echo "<cell><![CDATA[". chgdate($row['expdate'])."]]></cell>";
					echo "<cell><![CDATA[". $row['amount']."]]></cell>";
					echo "<cell><![CDATA[". $row['memberno']."]]></cell>";
					echo "<cell><![CDATA[". $row['agentcode']."]]></cell>";
					echo "<cell><![CDATA[". $row['pkgcode']."]]></cell>";
					echo "</row>";
				}
			echo "</rows>";
			
}			
?>