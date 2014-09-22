<?php
	include_once('../sschecker.php');
	include_once('../connect_db.php');
		$json=array();
		$table=$_GET['table'];
		
		
		if(isset($_GET['fld'])&&isset($_GET['txt'])){
			$fld=$_GET['fld'];
			$txt=$_GET['txt'];
			$sql="select distinct pkgcode,description from $table where $fld like '%$txt%' limit 0,8";
			
		}else{
			$sql="select distinct pkgcode,description from $table limit 0,8";
			
		}
		
		$res=mysql_query($sql);
		while($obj=mysql_fetch_array($res,MYSQL_NUM)){
				array_push($json,$obj);
		}
		
		echo json_encode($json);
		
?>
