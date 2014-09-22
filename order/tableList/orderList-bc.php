<?php
session_start();
    $compcode=$_SESSION['company'];
	$mrn=$_GET['mrn'];
	$episno=$_GET['episno'];
    $page = $_GET['page'];  //get the requested page
    $limit = $_GET['rows']; // get how many rows we want to have into the grid
    $sidx = $_GET['sidx']; // get index row - i.e. user click to sort
    $sord = $_GET['sord']; // get the direction
    if(!$sidx) $sidx =1;
    // connect to the database

    include $_SERVER['DOCUMENT_ROOT'] .'/medicsoft/config.php';

    $result = mysql_query("SELECT COUNT(*) AS count FROM chargetrx a, chgmast b WHERE b.compcode=a.compcode AND b.chgcode = a.chgcode AND a.compcode ='{$compcode}' AND a.mrn='{$mrn}' AND a.episno='{$episno}'");
    $row = mysql_fetch_array($result,MYSQL_ASSOC);
    $count = $row['count'];

    if( $count >0 ) {
        $total_pages = ceil($count/$limit);
    } else {
        $total_pages = 0;
    }
    if ($page > $total_pages) $page=$total_pages;
    $start = $limit*$page - $limit; // do not put $limit*($page - 1)
    $SQL = "SELECT a.trxtype,DATE_FORMAT(a.trxdate, '%d/%m/%Y') as trxdate,a.chgcode,a.quantity,a.isudept,a.amount,b.description,a.isudept FROM chargetrx a, chgmast b WHERE b.compcode=a.compcode AND b.chgcode = a.chgcode AND a.compcode ='{$compcode}' AND a.mrn='{$mrn}' AND a.episno='{$episno}' order by a.trxdate LIMIT $start , $limit";
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
		
        echo "<row id='".$x."'>"; 
		echo "<cell><![CDATA[". $row['trxdate']."]]></cell>";
		   echo "<cell><![CDATA[". $row['chgcode']."]]></cell>";
        echo "<cell><![CDATA[". $row['description']."]]></cell>";
		echo "<cell><![CDATA[". $row['isudept']."]]></cell>";
        echo "<cell><![CDATA[". $row['quantity']."]]></cell>";
        echo "<cell><![CDATA[". $row['amount']."]]></cell>";
        echo "<cell><![CDATA[". $row['trxtype']."]]></cell>";
        
     
        echo "</row>";
		$x=$x+1;
    }
    echo "</rows>";        
?>