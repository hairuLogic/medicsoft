<?php
// connect to the database
include_once('../../sschecker.php');
include_once('../../connect_db.php');
$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction
if($_GET['first']=='1'||$_GET['searchString']==''){
	$sidx='memberno';$sord='desc';
}
$compid=$_SESSION['company'];
$adduser=$_SESSION['username'];
if(!$sidx) $sidx =1;
if(isset($_GET['searchField'])&&$_GET['searchString']!=''){
	$searchField=$_GET['searchField'];
	$searchString=$_GET['searchString'];
	$searchOper=$_GET['searchOper'];
	if($searchOper=='eq'){
		$result=mysql_query("SELECT COUNT(memberno) AS count FROM membership WHERE $searchField = '$searchString' and compcode='$compid'");
		$result2="SELECT memberno FROM membership WHERE $searchField = '$searchString' and compcode='$compid'";
	}if($searchOper=='ne'){
		$result=mysql_query("SELECT COUNT(memberno) AS count FROM membership WHERE $searchField != '$searchString' and compcode='$compid'");
		$result2="SELECT memberno FROM membership WHERE $searchField != '$searchString' and compcode='$compid'";
	}if($searchOper=='lk'){
		$result=mysql_query("SELECT COUNT(memberno) AS count FROM membership WHERE $searchField LIKE '%$searchString%' and compcode='$compid'");
		$result2="SELECT memberno FROM membership WHERE $searchField LIKE '%$searchString%' and compcode='$compid'";
	}
}else{
	$result = mysql_query("SELECT COUNT(memberno) AS count FROM membership where compcode='$compid'");
	$result2 = "SELECT memberno FROM membership where compcode='$compid'";	
}
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

		$result=mysql_query("select sysno,MemberNo,mrn,agreementno,Name,Newic,telhp,DOB,Sex,category,address1,address2,address3,OffAdd1,OffAdd2,OffAdd3,telh,telo,email,agentcode from membership WHERE memberno in ($result2) and compcode='$compid' ORDER BY $sidx $sord,category desc LIMIT $start , $limit ");
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
					$result3=mysql_query("select sysno from membership where memberno='{$row['MemberNo']}' and compcode='$compid' and category='SUBSCRIBER'");
					$sysno1=mysql_fetch_row($result3);
					$sysno=$sysno1[0];
					if($row['category']=='SUBSCRIBER'){
						$category="<img src='../image/user.png'/>".$row['category'];
					}else{
						$category="<img src='../image/users.png'/>".$row['category'];
					}
					echo "<row id='". $row['sysno']."'>";			
					echo "<cell>". $row['MemberNo']."</cell>";
					echo "<cell><![CDATA[". $row['mrn']."]]></cell>";
					echo "<cell><![CDATA[". $row['agreementno']."]]></cell>";
					echo "<cell><![CDATA[". $row['Name']."]]></cell>";
					echo "<cell><![CDATA[". $row['Newic']."]]></cell>";
					echo "<cell><![CDATA[". $row['telhp']."]]></cell>";
					echo "<cell><![CDATA[". $row['DOB']."]]></cell>";
					echo "<cell><![CDATA[". $row['Sex']."]]></cell>";
					echo "<cell><![CDATA[". $row['category']."]]></cell>";
					echo "<cell><![CDATA[". $category."]]></cell>";
					echo "<cell><![CDATA[". $row['address1']."]]></cell>";
					echo "<cell><![CDATA[". $row['address2']."]]></cell>";
					echo "<cell><![CDATA[". $row['address3']."]]></cell>";
					echo "<cell><![CDATA[". $row['OffAdd1']."]]></cell>";
					echo "<cell><![CDATA[". $row['OffAdd2']."]]></cell>";
					echo "<cell><![CDATA[". $row['OffAdd3']."]]></cell>";
					echo "<cell><![CDATA[". $row['telh']."]]></cell>";
					echo "<cell><![CDATA[". $row['telo']."]]></cell>";
					echo "<cell><![CDATA[". $row['email']."]]></cell>";
					echo "<cell><![CDATA[". $sysno."]]></cell>";
					echo "<cell><![CDATA[". $row['agentcode']."]]></cell>";
					echo "</row>";
				}
			echo "</rows>";	
}
?>