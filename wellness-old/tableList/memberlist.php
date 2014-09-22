<?php
session_start();
	
    $compcode=$_SESSION['company'];
	/*$deptcode=$_GET['deptcode'];
	$epistycode=$_GET['epistycode'];*/
    $page = $_GET['page'];  //get the requested page
    $limit = $_GET['rows']; // get how many rows we want to have into the grid
    $sidx = $_GET['sidx']; // get index row - i.e. user click to sort
    $sord = $_GET['sord']; // get the direction
    if(!$sidx) $sidx =1;
	$searchField="";
	$addSql="";
    // connect to the database
    include '../../config.php';
	
	/*if($searchField!="" && $searchString!=""){*/
	if(isset($_GET['searchField']) && isset($_GET['searchString'])){
		$searchField=$_GET['searchField'];
		$searchString=$_GET['searchString'];
		
		$parts = explode(' ', $searchString);
		$partsLength  = count($parts);
		
		if($searchField=='IdNo'){
				while($partsLength>0){
				$partsLength--;
				$addSql .=" AND Newic like '%{$parts[$partsLength]}%' or idnumber like '%{$parts[$partsLength]}%'";
			}
		}
		else{
			while($partsLength>0){
				$partsLength--;
				$addSql .=" AND {$searchField} like '%{$parts[$partsLength]}%'";
			}	
		}		
		$sql = "SELECT COUNT(memberno) AS count FROM membership WHERE compcode='{$compcode}'".$addSql;
	}
	else{
		$sql = "SELECT COUNT(memberno) AS count FROM membership WHERE compcode='{$compcode}'";
	}
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
		$SQL = "SELECT MemberNo,Name,Newic,telhp,DOB,Sex,Category,Address1,Address2,Address3,OffAdd1,OffAdd2,OffAdd3,telh,telo,mrn,pkgcode,agent
 FROM membership WHERE compcode='{$compcode}'".$addSql." order by MemberNo,mrn LIMIT $start , $limit";
	}
	else{
		$SQL = "SELECT MemberNo,Name,Newic,telhp,DOB,Sex,Category,Address1,Address2,Address3,OffAdd1,OffAdd2,OffAdd3,telh,telo,mrn,pkgcode,agent
 FROM membership WHERE compcode='{$compcode}' order by MemberNo,mrn LIMIT $start , $limit";
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
		if($row['Category']=='SUBSCRIBER'){
			$category="<img src='../img/icon/user.png'/>".$row['Category'];
		}else{
			$category="<img src='../img/icon/users.png'/>".$row['Category'];
		}
		
        echo "<row id='". $row['MemberNo']. $row['mrn']."'>"; 
        echo "<cell><![CDATA[". $row['MemberNo']."]]></cell>";
        echo "<cell><![CDATA[". $row['Name']."]]></cell>";
        echo "<cell><![CDATA[". $row['Newic']."]]></cell>";
        echo "<cell><![CDATA[". $row['telhp']."]]></cell>";
        echo "<cell><![CDATA[". $row['DOB']."]]></cell>";
        echo "<cell><![CDATA[". $row['Sex']."]]></cell>";
        echo "<cell><![CDATA[". $category."]]></cell>";//citizen description
		echo "<cell><![CDATA[". $row['Address1']."]]></cell>";//debtor name
		echo "<cell><![CDATA[". $row['Address2']."]]></cell>";//payercode 
        echo "<cell><![CDATA[". $row['Address3']."]]></cell>";
        echo "<cell><![CDATA[". $row['OffAdd1']."]]></cell>";
        echo "<cell><![CDATA[". $row['OffAdd2']."]]></cell>";
		echo "<cell><![CDATA[". $row['OffAdd3']."]]></cell>";		
        echo "<cell><![CDATA[". $row['telh']."]]></cell>";
		echo "<cell><![CDATA[". $row['telo']."]]></cell>";
		echo "<cell><![CDATA[". $row['mrn']."]]></cell>";
		echo "<cell><![CDATA[". $row['pkgcode']."]]></cell>";
		echo "<cell><![CDATA[". $row['agent']."]]></cell>";
        echo "</row>";
    }
    echo "</rows>";        
?>