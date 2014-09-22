<?php
session_start();
	/*$compcode="9a";//$_SESSION['company'];
	$mrn="42";//$_GET['mrn'];
	$episno="3";//$_GET['episno'];
    $page = "1";//$_GET['page'];  //get the requested page
    $limit = "10";//$_GET['rows']; // get how many rows we want to have into the grid
    $sidx = "";//$_GET['sidx']; // get index row - i.e. user click to sort
    $sord = "asc";//$_GET['sord']; // get the direction
	$searchField="description";
	$searchString="him";
	$searchDate="09/10/2013";*/
    $compcode=$_SESSION['company'];
	$mrn=$_GET['mrn'];
	$episno=$_GET['episno'];
    $page = $_GET['page'];  //get the requested page
    $limit = $_GET['rows']; // get how many rows we want to have into the grid
    $sidx = $_GET['sidx']; // get index row - i.e. user click to sort
    $sord = $_GET['sord']; // get the direction
	$searchField="";
	$addSql='';
	
    if(!$sidx) $sidx =1;
    // connect to the database

    include $_SERVER['DOCUMENT_ROOT'] .'/medicsoft/config.php';
	/*if($searchField!=""){*/
	if(isset($_GET['searchField1'])){
		$searchField=$_GET['searchField1'];
		
		if($searchField!="trxdate"){
			$searchString=$_GET['searchString1'];
			$parts = explode(' ', $searchString);
			$partsLength  = count($parts);
			
			while($partsLength>0){
				$partsLength--;
				$addSql .=" AND b.{$searchField} like '%{$parts[$partsLength]}%'";
			}
			$sql = "SELECT COUNT(*) AS count FROM chargetrx a, chgmast b WHERE b.compcode=a.compcode AND b.chgcode = a.chgcode AND a.compcode ='{$compcode}' AND a.mrn='{$mrn}' AND a.episno='{$episno}'".$addSql;			
		}
		else{
			$searchDate=$_GET['searchDate'];
			$parts = explode('/', $searchDate);
			$trxdate  = "$parts[2]-$parts[1]-$parts[0]";
			
			$sql = "SELECT COUNT(*) AS count FROM chargetrx a, chgmast b WHERE b.compcode=a.compcode AND b.chgcode = a.chgcode AND a.compcode ='{$compcode}' AND a.mrn='{$mrn}' AND a.episno='{$episno}' AND a.trxdate between '{$trxdate}' and '{$trxdate} 23:59:59'";
		}
		
	}
	else{
		$sql = "SELECT COUNT(*) AS count FROM chargetrx a, chgmast b WHERE b.compcode=a.compcode AND b.chgcode = a.chgcode AND a.compcode ='{$compcode}' AND a.mrn='{$mrn}' AND a.episno='{$episno}'";
	}
$addSql="";
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
	
	if($searchField!=""){
		if($searchField!="trxdate"){
			$parts = explode(' ', $searchString);
			$partsLength  = count($parts);
			
			while($partsLength>0){
				$partsLength--;
				$addSql .=" AND b.{$searchField} like '%{$parts[$partsLength]}%'";
			}
			$SQL = "SELECT a.trxtype,DATE_FORMAT(a.trxdate, '%d/%m/%Y') as trxdate,a.chgcode,a.quantity,a.isudept,a.amount, b.description, a.isudept FROM chargetrx a, chgmast b WHERE b.compcode=a.compcode AND b.chgcode = a.chgcode AND a.compcode ='{$compcode}' AND a.mrn='{$mrn}' AND a.episno='{$episno}'".$addSql." order by a.trxdate LIMIT $start , $limit";
		}
		else{
			$parts = explode('/', $searchDate);
			$trxdate  = "$parts[2]-$parts[1]-$parts[0]";
			
			$SQL = "SELECT a.trxtype,DATE_FORMAT(a.trxdate, '%d/%m/%Y') as trxdate,a.chgcode,a.quantity,a.isudept,a.amount, b.description, a.isudept FROM chargetrx a, chgmast b WHERE b.compcode=a.compcode AND b.chgcode = a.chgcode AND a.compcode ='{$compcode}' AND a.mrn='{$mrn}' AND a.episno='{$episno}' AND a.trxdate='{$trxdate}' order by a.trxdate LIMIT $start , $limit";
		}
		
	}
	else{
		$SQL = "SELECT a.trxtype,DATE_FORMAT(a.trxdate, '%d/%m/%Y') as trxdate,a.chgcode,a.quantity,a.isudept,a.amount,b.description,a.isudept,a.trxtime FROM chargetrx a, chgmast b WHERE b.compcode=a.compcode AND b.chgcode = a.chgcode AND a.compcode ='{$compcode}' AND a.mrn='{$mrn}' AND a.episno='{$episno}' order by a.trxdate desc LIMIT $start , $limit";
	}
	
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
		$totalamount+=$row['amount'];
        echo "<row id='".$x."'>"; 
		echo "<cell><![CDATA[". $row['chgcode']."]]></cell>";
        echo "<cell><![CDATA[". $row['description']."]]></cell>";
        echo "<cell><![CDATA[". $row['quantity']."]]></cell>";
        
     
        echo "</row>";
		$x=$x+1;
    }
	echo "<userdata name='totalamount'>$totalamount</userdata>";
    echo "</rows>";        
?>