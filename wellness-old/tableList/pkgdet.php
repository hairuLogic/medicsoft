<?php
session_start();

    $compcode=$_SESSION['company'];
	$chgCode="";
    $page = $_GET['page'];  //get the requested page
    $limit = $_GET['rows']; // get how many rows we want to have into the grid
    $sidx =  $_GET['sidx']; // get index row - i.e. user click to sort
    $sord = $_GET['sord']; // get the direction

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
			$SQL="SELECT COUNT(DISTINCT p.chgcode) AS COUNT FROM chgprice AS p, chgmast AS a WHERE p.chgcode=a.chgcode AND p.effdate < CURDATE() AND p.compcode ='$compcode' AND a.chgcode like '%$searchString2%' ";
		}	
		else{
			while($partsLength>0){
				$partsLength--;
				$addSql .=" and (a.description LIKE '%{$parts[$partsLength]}%' OR a.brandname LIKE '%{$parts[$partsLength]}%')";
			}
			$SQL="SELECT COUNT(DISTINCT p.chgcode) AS COUNT FROM chgprice AS p, chgmast AS a WHERE p.chgcode=a.chgcode AND p.effdate < CURDATE() AND p.compcode ='$compcode' $addSql ";
		}		

	}
	else{
		$SQL = "SELECT COUNT(*) AS COUNT FROM pkgdet WHERE compcode ='{$compcode}'";
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
			$SQL="SELECT a.chgcode,p.effdate,p.amt1,p.amt2,a.description,a.brandname,a.chgtype,a.chggroup FROM chgprice AS p, chgmast AS a
		WHERE p.effdate = ( SELECT MAX(effdate) FROM chgprice WHERE chgcode = p.chgcode AND compcode ='9a' AND effdate < CURDATE())
		AND a.chgcode=p.chgcode AND a.chgcode like '%$searchString2%' LIMIT $start , $limit";
		}	
		else{
			$SQL="SELECT a.chgcode,p.effdate,p.amt1,p.amt2,a.description,a.brandname,a.chgtype,a.chggroup FROM chgprice AS p, chgmast AS a
		WHERE p.effdate = ( SELECT MAX(effdate) FROM chgprice WHERE chgcode = p.chgcode AND compcode ='9a' AND effdate < CURDATE())
		AND a.chgcode=p.chgcode $addSql LIMIT $start , $limit";
		}		

	}
	else{
		$SQL = "SELECT chgcode,description,freqqty,intervl,maxqty FROM pkgdet WHERE compcode='{$compcode}' LIMIT $start , $limit";
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
			//echo "<cell><![CDATA[".$row['amt2']."]]></cell>";
			echo "<cell><![CDATA[".$row['description']."]]></cell>"; 
			echo "<cell><![CDATA[".$row['freqqty']."]]></cell>";
			echo "<cell><![CDATA[".$row['intervl']."]]></cell>";
			echo "<cell><![CDATA[".$row['maxqty']."]]></cell>";
			echo "</row>";

    }
    echo "</rows>";        
?>