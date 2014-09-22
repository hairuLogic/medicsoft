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

	$sql="SELECT COUNT(*) AS count FROM pkgdet WHERE compcode='{$compcode}' AND pkgcode='{$pkgcode}'";
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
    $SQL = "SELECT pkgcode,chgcode,description,freqqty,intervl,maxqty FROM pkgdet WHERE compcode='{$compcode}' AND pkgcode='{$pkgcode}' ORDER BY chgcode LIMIT $start , $limit";

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
        echo "<cell><![CDATA[". $row['pkgcode']."]]></cell>";
		echo "<cell><![CDATA[". $row['chgcode']."]]></cell>";		
        echo "<cell><![CDATA[". $row['description']."]]></cell>";
        echo "<cell><![CDATA[". $row['freqqty']."]]></cell>";
        echo "<cell><![CDATA[". $row['intervl']."]]></cell>";
        echo "<cell><![CDATA[". $row['maxqty']."]]></cell>";
        echo "</row>";

    }
    echo "</rows>";        
?>