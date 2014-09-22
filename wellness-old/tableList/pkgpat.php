<?php
session_start();	
    $compcode=$_SESSION['company'];
	$MemberNo=$_GET['MemberNo'];
    $page = $_GET['page'];  //get the requested page
    $limit = $_GET['rows']; // get how many rows we want to have into the grid
    $sidx = $_GET['sidx']; // get index row - i.e. user click to sort
    $sord = $_GET['sord']; // get the direction
    if(!$sidx) $sidx =1;
	
    // connect to the database
    include '../../config.php';
	
	$sql = "SELECT COUNT(*) as count FROM pkgpat a, pkgdet b WHERE b.chgcode=a.chgcode AND a.compcode='$compcode' AND a.memberno='$MemberNo'";

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
	
	$SQL = "SELECT b.chgcode,b.remark,b.description,a.pkgqty,(a.pkgqty-a.qtyused) AS balance FROM pkgpat a, pkgdet b WHERE b.chgcode=a.chgcode AND a.compcode='$compcode' AND a.memberno='$MemberNo'";

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
		
        echo "<row id='". $row['chgcode']."'>";
		echo "<cell><![CDATA[". $row['description']."]]></cell>";
		echo "<cell><![CDATA[". $row['remark']."]]></cell>"; 
        echo "<cell><![CDATA[". $row['pkgqty']."]]></cell>";
        echo "<cell><![CDATA[". $row['balance']."]]></cell>";
        echo "</row>";
    }
    echo "</rows>";        
?>