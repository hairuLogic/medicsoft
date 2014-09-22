<?php
session_start();
    $compcode=$_SESSION['company'];
    $pkgcode=$_GET['pkgcode'];

    $page = $_GET['page'];  //get the requested page
    $limit = $_GET['rows']; // get how many rows we want to have into the grid
    $sidx = $_GET['sidx']; // get index row - i.e. user click to sort
    $sord = $_GET['sord']; // get the direction
    if(!$sidx) $sidx =1;
    // connect to the database

    include '../../config.php';

	$sql="SELECT COUNT(*) AS count FROM pkgbenefit a WHERE  a.compcode='{$compcode}' AND a.pkgcode='{$pkgcode}'";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result,MYSQL_ASSOC);
    $count = $row['count'];
    if( $count >0 ) {
        $total_pages = ceil($count/$limit);
    } else {
        $total_pages = 0;
    }
    if ($page > $total_pages) $page=$total_pages;
    $start = $limit*$page - $limit;
    $SQL = "SELECT a.pkgcode,a.chgcode,a.description,a.freqqty,a.intervl,a.maxqty,a.remark,DATE_FORMAT(a.effectdate, '%d/%m/%Y') as effectdate,DATE_FORMAT(a.expirydate, '%d/%m/%Y') as expirydate FROM pkgbenefit a WHERE a.compcode='{$compcode}' AND a.pkgcode='{$pkgcode}' ORDER BY effectdate desc,a.chgcode LIMIT $start , $limit";

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
	$x=1;
    while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
        echo "<row id='". $x."'>"; 
        echo "<cell><![CDATA[". $row['effectdate']."]]></cell>";	
		echo "<cell><![CDATA[". $row['expirydate']."]]></cell>";	
        echo "<cell><![CDATA[". $row['description']."]]></cell>";
		echo "<cell><![CDATA[". $row['remark']."]]></cell>";
        echo "<cell><![CDATA[". $row['freqqty']."]]></cell>";
        echo "<cell><![CDATA[". $row['intervl']."]]></cell>";
        echo "<cell><![CDATA[". $row['maxqty']."]]></cell>";
		echo "<cell><![CDATA[". $row['chgcode']."]]></cell>";
        echo "</row>";
		$x++;
    }
    echo "</rows>";        
?>