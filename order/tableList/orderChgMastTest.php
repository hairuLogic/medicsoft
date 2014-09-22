<?php
session_start();

    $compcode=$_SESSION['company'];
	/*$chgCode="";
	$page = "1";//$_GET['page'];  //get the requested page
    $limit = "10";//$_GET['rows']; // get how many rows we want to have into the grid
    $sidx =  "";//$_GET['sidx']; // get index row - i.e. user click to sort
    $sord = "asc";//$_GET['sord']; // get the direction*/
    $page = $_GET['page'];  //get the requested page
    $limit = $_GET['rows']; // get how many rows we want to have into the grid
    $sidx =  $_GET['sidx']; // get index row - i.e. user click to sort
    $sord = $_GET['sord']; // get the direction
    if(!$sidx) $sidx =1;
    // connect to the database

    include '../../config.php';
	//$searchField2='';//$_GET['searchField2'];
	//$searchString2=$_GET['searchString2'];
	
	$searchField2=$_GET['searchField2'];
	$searchString2=$_GET['searchString2'];
	/*$SQL = "SELECT  COUNT(DISTINCT a.chgcode) AS count FROM chgmast a,chgprice b WHERE b.chgcode=a.chgcode AND b.effdate <= CURDATE() AND a.compcode='{$compcode}'";
	$result=mysql_query( $SQL )or die("Couldn't execute query.".mysql_error());
    $row = mysql_fetch_row($result,MYSQL_ASSOC);
    $count = $row['count'];

    if( $count >0 ) {
        $total_pages = ceil($count/$limit);
    } else {
        $total_pages = 0;
    }
    if ($page > $total_pages) $page=$total_pages;
    $start = $limit*$page - $limit; // do not put $limit*($page - 1)*/
	if($searchField2!=""){
		$parts = explode(' ', $searchString2);
		$partsLength  = count($parts);
		while($partsLength>0){
			$partsLength--;
			$addSql .="and (a.description LIKE '%{$parts[$partsLength]}%' OR a.brandname LIKE '%{$parts[$partsLength]}%')";
		}
		
		$SQL="SELECT a.chgcode,p.effdate,p.amt1,p.amt2,a.description,a.brandname,a.chgtype,a.chggroup
FROM chgprice AS p, chgmast AS a
WHERE 
p.effdate = ( SELECT MAX(effdate) FROM chgprice WHERE chgcode = p.chgcode AND compcode ='9a' AND effdate < CURDATE())
AND
a.chgcode=p.chgcode  $addSql 
LIMIT 10";
	}
	else{
		$SQL = "SELECT p.chgcode,p.effdate,p.amt1,p.amt2,a.description,a.brandname,a.chgtype,a.chggroup FROM chgprice AS p, chgmast AS a WHERE p.chgcode=a.chgcode AND p.compcode ='$compcode' AND p.effdate = ( SELECT MAX(effdate) FROM chgprice WHERE chgcode = p.chgcode AND p.compcode ='$compcode' AND effdate < CURDATE()) LIMIT 10";
	}
	$result=mysql_query( $SQL )or die("Couldn't execute query.".mysql_error());
	
    /*$SQL = "SELECT a.chgcode,a.description,a.brandname,b.amt1,b.amt2 FROM chgmast a, chgprice b WHERE a.compcode=b.compcode AND a.chgcode=b.chgcode AND a.compcode='$compcode' ORDER BY a.chgcode LIMIT $start , $limit";
    $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());*/

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
			echo "<cell><![CDATA[".$row['chgcode']."]]></cell>"; 
			echo "<cell><![CDATA[".$row['description']."]]></cell>";
			echo "<cell><![CDATA[".$row['brandname']."]]></cell>";
			echo "<cell><![CDATA[".$row['amt1']."]]></cell>";
			echo "<cell><![CDATA[".$row['amt2']."]]></cell>";
			echo "<cell><![CDATA[".$row['chgtype']."]]></cell>";
			echo "<cell><![CDATA[".$row['chggroup']."]]></cell>";
			echo "</row>";
    }
    echo "</rows>";        
?>