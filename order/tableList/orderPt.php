<?php
session_start();
	
	$deptcode="all";//$_GET['deptcode'];
	$epistycode="op";//$_GET['epistycode'];
    $page ="1";// $_GET['page'];  //get the requested page
    $limit = "50";//$_GET['rows']; // get how many rows we want to have into the grid
    $sidx ="";// $_GET['sidx']; // get index row - i.e. user click to sort
    $sord = "asc";//$_GET['sord']; // get the direction
	$searchField="Name";//$_GET['searchField'];
	$searchString="q a";//$_GET['searchString'];
	
    $compcode=$_SESSION['company'];
	/*$deptcode=$_GET['deptcode'];
	$epistycode=$_GET['epistycode'];
    $page = $_GET['page'];  //get the requested page
    $limit = $_GET['rows']; // get how many rows we want to have into the grid
    $sidx = $_GET['sidx']; // get index row - i.e. user click to sort
    $sord = $_GET['sord']; // get the direction*/
    if(!$sidx) $sidx =1;
	
    // connect to the database
    include $_SERVER['DOCUMENT_ROOT'] .'/medicsoft/config.php';
	
	/*if($searchField!="" && $searchString!=""){*/
	if(isset($_GET['searchField']) && isset($_GET['searchString'])){
		$searchField=$_GET['searchField'];
		$searchString=$_GET['searchString'];
		
		$parts = explode(' ', $searchString);
		$partsLength  = count($parts);
		
		while($partsLength>0){
			$partsLength--;
			$addSql .=" AND a.{$searchField} like '%{$parts[$partsLength]}%'";
		}
		$sql = "SELECT COUNT(*) AS count FROM queue a, patmast b, episode c WHERE a.compcode = b.compcode AND b.compcode=c.compcode AND a.mrn=b.mrn AND b.mrn=c.mrn AND a.episno=b.episno AND b.episno=c.episno AND a.deptcode='{$deptcode}' AND a.compcode='{$compcode}' AND c.epistycode='{$epistycode}'".$addSql;
	}
	else{
		$sql = "SELECT COUNT(*) AS count FROM queue a, patmast b, episode c WHERE a.compcode = b.compcode AND b.compcode=c.compcode AND a.mrn=b.mrn AND b.mrn=c.mrn AND a.episno=b.episno AND b.episno=c.episno AND a.deptcode='{$deptcode}' AND a.compcode='{$compcode}' AND c.epistycode='{$epistycode}'";
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
	
	if($searchField!="" && $searchString!=""){
		$SQL = "SELECT DATE_FORMAT(a.reg_date, '%d/%m/%Y') as reg_date,a.memberno,b.name,b.telh,b.telhp,DATE_FORMAT(b.DOB, '%d/%m/%Y') as DOB,b.Citizencode,c.case_code,b.Newic, a.ageyy,a.mrn,CASE WHEN b.Sex = 'M' THEN 'Male' ELSE 'Female' END AS Sex,c.episno,c.epistycode FROM queue a, patmast b, episode c WHERE a.compcode = b.compcode AND b.compcode=c.compcode AND a.mrn=b.mrn AND b.mrn=c.mrn AND a.episno=b.episno AND b.episno=c.episno AND a.deptcode='{$deptcode}' AND a.compcode='{$compcode}' AND c.epistycode='{$epistycode}'".$addSql." order by c.reg_date LIMIT $start , $limit";
	}
	else{
		$SQL = "SELECT DATE_FORMAT(a.reg_date, '%d/%m/%Y') as reg_date,a.memberno,b.name,b.telh,b.telhp,DATE_FORMAT(b.DOB, '%d/%m/%Y') as DOB,b.Citizencode,c.case_code,b.Newic, a.ageyy,a.mrn,CASE WHEN b.Sex = 'M' THEN 'Male' ELSE 'Female' END AS Sex,c.episno,c.epistycode FROM queue a, patmast b, episode c WHERE a.compcode = b.compcode AND b.compcode=c.compcode AND a.mrn=b.mrn AND b.mrn=c.mrn AND a.episno=b.episno AND b.episno=c.episno AND a.deptcode='{$deptcode}' AND a.compcode='{$compcode}' AND c.epistycode='{$epistycode}' order by c.reg_date LIMIT $start , $limit";
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
    while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
		$SQL1 = "SELECT a.Description AS citiDes,b.Description AS caseDes
FROM citizen a
JOIN casetype b
ON a.compcode=b.compcode
WHERE b.compcode='{$compcode}' AND a.CODE='{$row['Citizencode']}' AND b.case_code ='{$row['case_code']}'";
        $result1 = mysql_query( $SQL1 ) or die("Couldn't execute query.".mysql_error());
        $row1 = mysql_fetch_array($result1);
		
		$SQL2 = "SELECT a.name as debtorName,b.payercode FROM debtormast a, epispayer b WHERE a.CompCode=b.CompCode AND a.debtorcode=TRIM(LEADING '0' FROM b.payercode) AND b.compcode='{$compcode}' AND b.mrn='{$row['mrn']}' AND b.episno='{$row['episno']}' AND lineno_='1'";
        $result2 = mysql_query( $SQL2 ) or die("Couldn't execute query.".mysql_error());
        $row2 = mysql_fetch_array($result2);
		
        echo "<row id='". $row['mrn']."'>"; 
        echo "<cell><![CDATA[". $row['reg_date']."]]></cell>";
        echo "<cell><![CDATA[". $row['memberno']."]]></cell>";
        echo "<cell><![CDATA[". $row['name']."]]></cell>";
        echo "<cell><![CDATA[". $row['telh']."]]></cell>";
        echo "<cell><![CDATA[". $row['telhp']."]]></cell>";
        echo "<cell><![CDATA[". $row['DOB']."]]></cell>";
        echo "<cell><![CDATA[". $row1['citiDes']."]]></cell>";//citizen description
		echo "<cell><![CDATA[". $row2['debtorName']."]]></cell>";//debtor name
		echo "<cell><![CDATA[". $row2['payercode']."]]></cell>";//payercode 
        echo "<cell><![CDATA[". $row['Newic']."]]></cell>";
        echo "<cell><![CDATA[". $row['ageyy']."]]></cell>";
        echo "<cell><![CDATA[". $row['Sex']."]]></cell>";
		echo "<cell><![CDATA[". $row1['caseDes']."]]></cell>";		
        echo "<cell><![CDATA[". $row['mrn']."]]></cell>";
		echo "<cell><![CDATA[". $row['episno']."]]></cell>";
		echo "<cell><![CDATA[". $row['epistycode']."]]></cell>";
        echo "</row>";
    }
    echo "</rows>";        
?>