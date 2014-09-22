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
	$mrn=$_GET['mrn'];
    $page = $_GET['page'];  //get the requested page
    $limit = $_GET['rows']; // get how many rows we want to have into the grid
    $sidx = $_GET['sidx']; // get index row - i.e. user click to sort
    $sord = $_GET['sord']; // get the direction
    if(!$sidx) $sidx =1;
	
    // connect to the database
    include $_SERVER['DOCUMENT_ROOT'] .'/medicsoft/config.php';
	
	/*if($searchField!="" && $searchString!=""){*/
	$sql = "SELECT COUNT(*) AS count FROM episode WHERE mrn='{$mrn}' and compcode='{$compcode}'";
	
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
	
	$SQL = "SELECT DATE_FORMAT(reg_date, '%d/%m/%Y') as reg_date ,DATE_FORMAT(dischargedate, '%d/%m/%Y') as dischargedate ,episno FROM episode WHERE compcode='{$compcode}' and mrn='{$mrn}' order by episno desc,reg_date desc LIMIT $start , $limit";

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
		
        echo "<row id='".$mrn.".".$row['episno']."'>"; 
        echo "<cell><![CDATA[". $row['reg_date']."]]></cell>";
		if($row['dischargedate']=='00/00/0000' || $row['dischargedate']==''){
			echo "<cell><![CDATA[]]></cell>";
			echo "<cell><![CDATA[1]]></cell>";
		}
		else {
			echo "<cell><![CDATA[". $row['dischargedate']."]]></cell>";
			echo "<cell><![CDATA[0]]></cell>";
		}
			echo "<cell><![CDATA[". $row['episno']."]]></cell>";
		
        echo "</row>";
    }
    echo "</rows>";        
?>