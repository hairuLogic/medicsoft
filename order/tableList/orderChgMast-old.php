<?php
session_start();

    $compcode=$_SESSION['company'];
	$chgCode="";
	$page = "1";//$_GET['page'];  //get the requested page
    $limit = "50";//$_GET['rows']; // get how many rows we want to have into the grid
    $sidx =  "";//$_GET['sidx']; // get index row - i.e. user click to sort
    $sord = "asc";//$_GET['sord']; // get the direction
	
   /* $page = $_GET['page'];  //get the requested page
    $limit = $_GET['rows']; // get how many rows we want to have into the grid
    $sidx =  $_GET['sidx']; // get index row - i.e. user click to sort
    $sord = $_GET['sord']; // get the direction*/
    if(!$sidx) $sidx =1;
	
	if(isset($_GET['chgCode']))	$chgCode=$_GET['chgCode'];
	if(isset($_GET['searchField2'])){
		/*$searchField2=$_GET['searchField2'];
		$searchString2=$_GET['searchString2'];*/
		
	}
	$searchField2="word";//$_GET['searchField2'];
	$searchString2="FLUIMUCIL";//$_GET['searchString2'];
    // connect to the database

    include '../../config.php';
	if($chgCode!='' || $searchField2!=""){
		if($searchField2==""){		
			$SQL="SELECT COUNT(*) AS count FROM chgmast a WHERE a.description LIKE '%$chgCode%' OR a.brandname LIKE '%$chgCode%' and a.compcode='{$compcode}'";
		}
		else{
			if($searchField2=="chgcode"){
				while($partsLength>0){
					$partsLength--;
					$addSql .=" AND chgcode='$searchString2'";
				}
			}	
			else{
				$parts = explode(' ', $searchString2);
				$partsLength  = count($parts);
				while($partsLength>0){
					$partsLength--;
					$addSql .=" AND a.description like '%{$parts[$partsLength]}%' OR a.brandname like '%{$parts[$partsLength]}%'";
				}
			}		
			$SQL="SELECT COUNT(*) AS count FROM chgmast a WHERE a.compcode='{$compcode}'".$addSql;
		}
	}
	else{
		$SQL = "SELECT COUNT(*) AS count FROM chgmast a WHERE a.compcode='{$compcode}'";
	}
	echo $SQL;
	$addSql="";
	$result=mysql_query( $SQL )or die("Couldn't execute query.".mysql_error());
    $row = mysql_fetch_row($result,MYSQL_ASSOC);
    $count = $row['count'];

    if( $count >0 ) {
        $total_pages = ceil($count/$limit);
    } else {
        $total_pages = 0;
    }
    if ($page > $total_pages) $page=$total_pages;
    $start = $limit*$page - $limit; // do not put $limit*($page - 1)

	if($chgCode!='' || $searchField2!=""){
		if($searchField2==""){	
			$SQL="SELECT a.chgcode,a.description,a.brandname,a.chgtype,b.amt1,b.amt2,a.chgtype,a.chggroup FROM chgmast a INNER JOIN chgprice b USING (chgcode) WHERE  a.description LIKE '%$chgCode%' OR a.brandname LIKE '%$chgCode%' and a.compcode='".$compcode."' ORDER BY a.chgcode LIMIT $start , $limit";
		}
		else{
			if($searchField2=="chgcode"){
				$parts = explode(' ', $searchString2);
				$partsLength  = count($parts);
				while($partsLength>0){
					$partsLength--;
					$addSql .=" AND chgcode='$searchString2'";
				}
			}	
			else{
				$parts = explode(' ', $searchString2);
				$partsLength  = count($parts);
				while($partsLength>0){
					$partsLength--;
					$addSql .=" AND a.description like '%{$parts[$partsLength]}%' OR a.brandname like '%{$parts[$partsLength]}%'";
				}
			}		
			$SQL="SELECT a.chgcode,a.description,a.brandname,a.chgtype,b.amt1,b.amt2,a.chgtype,a.chggroup FROM chgmast a INNER JOIN chgprice b USING (chgcode) WHERE a.compcode='".$compcode."'".$addSql." ORDER BY a.chgcode LIMIT $start , $limit";
		}
	}
	else{
		$SQL = "SELECT a.chgcode,a.description,a.brandname,a.chgtype,b.amt1,b.amt2,a.chgtype,a.chggroup FROM chgmast a INNER JOIN chgprice b USING (chgcode) WHERE   a.compcode='$compcode' ORDER BY a.chgcode LIMIT $start , $limit";
	}
	echo $SQL;
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