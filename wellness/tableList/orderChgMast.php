<?php
session_start();

    $compcode=$_SESSION['company'];
	$pkgcode=$_GET['pkgcode'];
    $page = $_GET['page'];  //get the requested page
    $limit = $_GET['rows']; // get how many rows we want to have into the grid
    $sidx =  $_GET['sidx']; // get index row - i.e. user click to sort
    $sord = $_GET['sord']; // get the direction
	$chgCode="";
	$searchField2="";
	$addSql="";
	if(isset($_GET['chgCode']))	{
		$chgCode=$_GET['chgCode'];
		$parts = explode(' ', $chgCode);
		$partsLength  = count($parts);
	}
	if(isset($_GET['searchField2'])){
		$searchField2=$_GET['searchField2'];
		$searchString2=$_GET['searchString2'];
		$parts = explode(' ', $searchString2);
		$partsLength  = count($parts);
	}

	/*$page = "1";//$_GET['page'];  //get the requested page
    $limit = "50";//$_GET['rows']; // get how many rows we want to have into the grid
    $sidx =  "";//$_GET['sidx']; // get index row - i.e. user click to sort
    $sord = "asc";//$_GET['sord']; // get the direction
	/*$searchField2="word";//$_GET['searchField2'];
	$searchString2="black";//$_GET['searchString2'];
	$parts = explode(' ', $searchString2);
	$partsLength  = count($parts);*/

	if(!$sidx) $sidx =1;
	// connect to the database
    include '../../config.php';
	
	if($chgCode!='' || $searchField2!=""){
		if($searchField2=="chgcode"){
			$SQL="SELECT COUNT(DISTINCT a.chgcode) AS COUNT FROM pkgdet AS a WHERE a.compcode ='$compcode' and a.pkgcode='{$pkgcode}' AND a.chgcode like '%$searchString2%' ";
		}	
		else{
			while($partsLength>0){
				$partsLength--;
				$addSql .=" and (a.description LIKE '%{$parts[$partsLength]}%' )";
			}
			$SQL="SELECT COUNT(DISTINCT a.chgcode) AS COUNT FROM pkgdet AS a WHERE a.compcode ='$compcode' and a.pkgcode='{$pkgcode}' $addSql ";
		}		

	}
	else{
		$SQL = "SELECT COUNT(DISTINCT a.chgcode) AS COUNT FROM pkgdet AS a WHERE a.compcode ='$compcode' and a.pkgcode='{$pkgcode}'";
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
	
	if($chgCode!='' || $searchField2!=""){
		if($searchField2=="chgcode"){
			$SQL="SELECT a.chgcode,a.description FROM  pkgdet AS a
		WHERE a.compcode ='$compcode' and a.pkgcode='{$pkgcode}' AND a.chgcode like '%$searchString2%' LIMIT $start , $limit";
		}	
		else{
			$SQL="SELECT a.chgcode,a.description FROM pkgdet AS a
		WHERE a.compcode ='$compcode' and a.pkgcode='{$pkgcode}' {$addSql} LIMIT $start , $limit";
		}		

	}
	else{
		$SQL = "SELECT a.chgcode,a.description FROM pkgdet AS a WHERE a.compcode ='$compcode' and a.pkgcode='{$pkgcode}' LIMIT $start , $limit";
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
			echo "<row id='". $row['chgcode']."'>";
			echo "<cell><![CDATA[".$row['chgcode']."]]></cell>"; 
			echo "<cell><![CDATA[".$row['description']."]]></cell>";
			echo "<cell><![CDATA[".$row['brandname']."]]></cell>";
			echo "</row>";
    }
    echo "</rows>";        
?>