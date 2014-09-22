<?php
session_start();

    $compcode=$_SESSION['company'];
    $page = $_GET['page'];  //get the requested page
    $limit = $_GET['rows']; // get how many rows we want to have into the grid
    $sidx =  $_GET['sidx']; // get index row - i.e. user click to sort
    $sord = $_GET['sord']; // get the direction
$paymode="";
$searchField2="";
$addSql="";
	if(isset($_GET['paymode']))	{
		$paymode=$_GET['paymode'];
		$parts = explode(' ', $paymode);
		$partsLength  = count($parts);
	}
	if(isset($_GET['searchField'])){
		$searchField2=$_GET['searchField'];
		$searchString2=$_GET['searchString'];
		$parts = explode(' ', $searchString2);
		$partsLength  = count($parts);
	}

	if(!$sidx) $sidx =1;
	// connect to the database
    include '../../config.php';
	
	if($paymode!='' || $searchField2!=""){
		if($searchField2=="chgcode"){
			$SQL="SELECT COUNT(*) AS COUNT FROM paymode WHERE compcode ='$compcode' AND paymode like '%$searchString2%' ";
		}	
		else{
			while($partsLength>0){
				$partsLength--;
				$addSql .=" and description LIKE '%{$parts[$partsLength]}%'";
			}
			$SQL="SELECT COUNT(*) AS COUNT FROM paymode WHERE compcode ='$compcode' $addSql ";
		}		

	}
	else{
		$SQL = "SELECT COUNT(*) AS COUNT FROM paymode WHERE compcode='$compcode' ";
	}
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
	
	if($paymode!='' || $searchField2!=""){
		if($searchField2=="chgcode"){
			$SQL="SELECT paymode,description,cardflag FROM paymode WHERE compcode ='$compcode'  AND paymode like '%$searchString2%' order by paymode LIMIT $start , $limit";
		}	
		else{
			$SQL="SELECT paymode,description,cardflag FROM paymode WHERE compcode='$compcode' {$addSql} order by paymode LIMIT $start , $limit";
		}		

	}
	else{
		$SQL = "SELECT paymode,description,cardflag FROM paymode WHERE compcode ='$compcode' order by paymode LIMIT $start , $limit";
	}
	
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
    while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			echo "<row id='". $row['paymode']."'>";
			echo "<cell><![CDATA[".$row['paymode']."]]></cell>"; 
			echo "<cell><![CDATA[".$row['description']."]]></cell>";
			echo "<cell><![CDATA[".$row['cardflag']."]]></cell>";
			echo "</row>";

    }
    echo "</rows>";        
?>