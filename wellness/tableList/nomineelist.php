<?php
session_start();
	/*$compcode="9a";//$_SESSION['company'];
	$deptcode="all";//$_GET['deptcode'];
	$epistycode="op";//$_GET['epistycode'];
	$searchField="Name";//$_GET['searchField'];
	$searchString="q a";//$_GET['searchString'];
    $page ="1";// $_GET['page'];  //get the requested page
    $limit = "50";//$_GET['rows']; // get how many rows we want to have into the grid
    $sidx ="";// $_GET['sidx']; // get index row - i.e. user click to sort
    $sord = "asc";//$_GET['sord']; // get the direction*/
	
	
    $compcode=$_SESSION['company'];
	//$MemberNo=$_GET['MemberNo'];
	$mrn=$_GET['mrn'];
    $page = $_GET['page'];  //get the requested page
    $limit = $_GET['rows']; // get how many rows we want to have into the grid
    $sidx = $_GET['sidx']; // get index row - i.e. user click to sort
    $sord = $_GET['sord']; // get the direction
    if(!$sidx) $sidx =1;
	
    // connect to the database
    include '../../config.php';
	
	$sql = "SELECT COUNT(memberno) AS count FROM membership WHERE compcode='{$compcode}' and mrn='{$mrn}'";
		
	$addSql="";
   	$result = mysql_query( $sql ) or die("Couldn't execute query.".mysql_error());
    $row = mysql_fetch_array($result,MYSQL_ASSOC);
    $count = $row['count'];

    if( $count >0 ) {
        $total_pages = ceil($count/$limit);
    } else {
        $total_pages = 0;
    }
    if ($page > $total_pages) $page=$total_pages;
    $start = $limit*$page - $limit; // do not put $limit*($page - 1)
	
	$SQL = "SELECT MemberNo,Name,Newic,telhp,DOB,Sex,Category,Address1,Address2,Address3,OffAdd1,OffAdd2,OffAdd3,telh,telo,mrn FROM membership WHERE compcode='{$compcode}' and mrn='{$mrn}' order by MemberNo,mrn LIMIT $start , $limit";
	
    $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());

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
		
        echo "<row id='". $row['MemberNo']. $row['mrn']."'>";
		echo "<cell><![CDATA[". $row['mrn']."]]></cell>"; 
        echo "<cell><![CDATA[". $row['Name']."]]></cell>";
        echo "<cell><![CDATA[". $row['Newic']."]]></cell>";
        echo "<cell><![CDATA[". $row['telhp']."]]></cell>";
        echo "<cell><![CDATA[". $row['DOB']."]]></cell>";
        echo "<cell><![CDATA[". $row['Sex']."]]></cell>";
        echo "<cell><![CDATA[". $row['Category']."]]></cell>";//citizen description
		echo "<cell><![CDATA[". $row['Address1']."]]></cell>";//debtor name
		echo "<cell><![CDATA[". $row['Address2']."]]></cell>";//payercode 
        echo "<cell><![CDATA[". $row['Address3']."]]></cell>";
        echo "<cell><![CDATA[". $row['OffAdd1']."]]></cell>";
        echo "<cell><![CDATA[". $row['OffAdd2']."]]></cell>";
		echo "<cell><![CDATA[". $row['OffAdd3']."]]></cell>";		
        echo "<cell><![CDATA[". $row['telh']."]]></cell>";
		echo "<cell><![CDATA[". $row['telo']."]]></cell>";		
        echo "<cell><![CDATA[". $row['MemberNo']."]]></cell>";
        echo "</row>";
    }
    echo "</rows>";        
?>