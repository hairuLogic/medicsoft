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
if(!$sidx) $sidx =1;
if(isset($_GET['searchField'])&&$_GET['searchString']!=''){
	$searchField=$_GET['searchField'];
	$searchString=$_GET['searchString'];
	$searchOper=$_GET['searchOper'];
	if($searchOper=='eq'){
		$result=mysql_query("SELECT COUNT(*) AS count FROM membership WHERE $searchField = '$searchString' and compcode='$compid' and category='member'");
	}if($searchOper=='ne'){
		$result=mysql_query("SELECT COUNT(*) AS count FROM membership WHERE $searchField != '$searchString' and compcode='$compid' and category='member'");
	}if($searchOper=='lk'){
		$result=mysql_query("SELECT COUNT(*) AS count FROM membership WHERE $searchField LIKE '%$searchString%' and compcode='$compid' and category='member'");
	}
}else{
	$result = mysql_query("SELECT COUNT(*) AS count FROM membership where compcode='$compid' and category='member'");	
}
$row = mysql_fetch_array($result,MYSQL_ASSOC);
$count = $row['count'];

if($count==0){
	$result=mysql_query("SELECT memberno,COUNT(DISTINCT memberno) AS count FROM membership WHERE $searchField LIKE '%$searchString%' AND compcode='$compid' AND category='nominee'");
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
	
		$array=array();
		$result=mysql_query("select distinct memberno from membership where $searchField LIKE '%$searchString%' AND compcode='$compid' AND category='nominee'");
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)){
			array_push($array,$row['memberno']);
		}
		$ids = join("','",$array); 
		$result=mysql_query("select MemberNo,Name,Newic,telhp,DOB,Sex,category,address1,address2,address3,OffAdd1,OffAdd2,OffAdd3,telh,telo from membership WHERE memberno in ('$ids') and compcode='$compid' ORDER BY memberno,category $sord LIMIT $start , $limit ");
		if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
			header("Content-type: application/xhtml+xml;charset=utf-8"); } else {
			header("Content-type: text/xml;charset=utf-8");}
			$et = ">";
			echo "<?xml version='1.0' encoding='utf-8'?$et\n";
			echo "<rows>";
			echo "<page>".$page."</page>";
			echo "<total>".$total_pages."</total>";
			echo "<records>".$count."</records>";
			// be sure to put text data in CDATA
				while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
					echo "<row id='". $row['MemberNo']."'>";			
					echo "<cell>". $row['MemberNo']."</cell>";
					echo "<cell><![CDATA[". $row['Name']."]]></cell>";
					echo "<cell><![CDATA[". $row['Newic']."]]></cell>";
					echo "<cell><![CDATA[". $row['telhp']."]]></cell>";
					echo "<cell><![CDATA[". $row['DOB']."]]></cell>";
					echo "<cell><![CDATA[". $row['Sex']."]]></cell>";
					echo "<cell><![CDATA[". $row['category']."]]></cell>";
					echo "<cell><![CDATA[". $row['address1']."]]></cell>";
					echo "<cell><![CDATA[". $row['address2']."]]></cell>";
					echo "<cell><![CDATA[". $row['address3']."]]></cell>";
					echo "<cell><![CDATA[". $row['OffAdd1']."]]></cell>";
					echo "<cell><![CDATA[". $row['OffAdd2']."]]></cell>";
					echo "<cell><![CDATA[". $row['OffAdd3']."]]></cell>";
					echo "<cell><![CDATA[". $row['telh']."]]></cell>";
					echo "<cell><![CDATA[". $row['telo']."]]></cell>";
					echo "</row>";
				}
		
			echo "</rows>";	
	}
	
}else{
	if( $count >0 ) {
		$total_pages = ceil($count/$limit);
	} else {
		$total_pages = 0;
	}
	if ($page > $total_pages) $page=$total_pages;
	$start = $limit*$page - $limit; 
	
	if(isset($_GET['searchField'])&&$_GET['searchString']!=''){
			if($searchOper=='eq'){
				$SQL="select MemberNo, Name,Newic,telhp,DOB,Sex,category,address1,address2,address3,OffAdd1,OffAdd2,OffAdd3,telh,telo from membership WHERE $searchField = '$searchString' and compcode='$compid' ORDER BY memberno,category $sord LIMIT $start , $limit ";
			}if($searchOper=='ne'){
				$SQL="select MemberNo, Name,Newic,telhp,DOB,Sex,category,address1,address2,address3,OffAdd1,OffAdd2,OffAdd3,telh,telo from membership WHERE $searchField != '$searchString' and compcode='$compid' ORDER BY memberno,category $sord LIMIT $start , $limit";
			}if($searchOper=='lk'){
				$SQL="select MemberNo, Name,Newic,telhp,DOB,Sex,category,address1,address2,address3,OffAdd1,OffAdd2,OffAdd3,telh,telo from membership WHERE $searchField LIKE '%$searchString%' and compcode='$compid' ORDER BY memberno,category $sord LIMIT $start , $limit ";
			}
	}else{
		$SQL = "select sysno,MemberNo, Name,Newic,telhp,DOB,Sex,category,address1,address2,address3,OffAdd1,OffAdd2,OffAdd3,telh,telo from membership where compcode='$compid' ORDER BY memberno,category $sord LIMIT $start , $limit";
	}
	
	$result = mysql_query( $SQL ) or die("Couldnt execute query.".mysql_error());
	
	if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
	header("Content-type: application/xhtml+xml;charset=utf-8"); } else {
	header("Content-type: text/xml;charset=utf-8");}
	$et = ">";
	echo "<?xml version='1.0' encoding='utf-8'?$et\n";
	echo "<rows>";
	echo "<page>".$page."</page>";
	echo "<total>".$total_pages."</total>";
	echo "<records>".$count."</records>";
	// be sure to put text data in CDATA
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			echo "<row id='". $row['MemberNo']."'>";			
			echo "<cell>". $row['MemberNo']."</cell>";
			echo "<cell><![CDATA[". $row['Name']."]]></cell>";
			echo "<cell><![CDATA[". $row['Newic']."]]></cell>";
			echo "<cell><![CDATA[". $row['telhp']."]]></cell>";
			echo "<cell><![CDATA[". $row['DOB']."]]></cell>";
			echo "<cell><![CDATA[". $row['Sex']."]]></cell>";
			echo "<cell><![CDATA[". $row['category']."]]></cell>";
			echo "<cell><![CDATA[". $row['address1']."]]></cell>";
			echo "<cell><![CDATA[". $row['address2']."]]></cell>";
			echo "<cell><![CDATA[". $row['address3']."]]></cell>";
			echo "<cell><![CDATA[". $row['OffAdd1']."]]></cell>";
			echo "<cell><![CDATA[". $row['OffAdd2']."]]></cell>";
			echo "<cell><![CDATA[". $row['OffAdd3']."]]></cell>";
			echo "<cell><![CDATA[". $row['telh']."]]></cell>";
			echo "<cell><![CDATA[". $row['telo']."]]></cell>";
			echo "</row>";
		}

	echo "</rows>";	
	



}

?>