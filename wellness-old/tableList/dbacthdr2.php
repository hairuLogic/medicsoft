<?php
session_start();

    $compcode=$_SESSION['company'];
    $page = $_GET['page'];  //get the requested page
    $limit = $_GET['rows']; // get how many rows we want to have into the grid
    $sidx =  $_GET['sidx']; // get index row - i.e. user click to sort
    $sord = $_GET['sord']; // get the direction
	$memberno=$_GET['memberno'];		

	if(!$sidx) $sidx =1;
	// connect to the database
    include '../../config.php';
	
	$SQL = "SELECT COUNT(*) as COUNT FROM dbacthdr WHERE source='pb' AND trantype='in' AND memberno='$memberno'";
	
	$result=mysql_query( $SQL )or die("Couldn't execute query.".mysql_error());
    $row = mysql_fetch_row($result,MYSQL_ASSOC);
    $count = $row['COUNT'];

    if( $count >0 ) {
        $total_pages = ceil($count/$limit);
    } else {
        $total_pages = 0;
    }
    if ($page > $total_pages) $page=$total_pages;
    $start = $limit*$page - $limit; // do not put $limit*($page - 1)	
	
	$SQL = "SELECT entrydate,auditno,remark,amount,outamount FROM dbacthdr WHERE source='pb' AND trantype='in' AND memberno='$memberno' AND outamount order by memberno,mrn LIMIT $start , $limit";
	
	$result=mysql_query( $SQL )or die("Couldn't execute query.".mysql_error());

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
			echo "<row id='$x'>";
			echo "<cell><![CDATA[".$row['entrydate']."]]></cell>"; 
			echo "<cell><![CDATA[".$row['auditno']."]]></cell>";
			echo "<cell><![CDATA[".$row['remark']."]]></cell>";
			echo "<cell><![CDATA[".$row['outamount']."]]></cell>"; 
			echo '<cell><![CDATA[]]></cell>';
			echo "<cell><![CDATA[".$row['outamount']."]]></cell>";
			echo "</row>";
			$x++;
    }
    echo "</rows>";        
?>