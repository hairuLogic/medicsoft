<?php
	include_once('../sschecker.php');
	include_once('../connect_db.php');
		$json=array();
		$table=$_GET['table'];
		function selectfld($x){
			switch($x){
				case "debtormast": return "debtorcode";break;
				case "areacode": return "areacode";break;
				case "occupation": return "occupcode";break;
				case "agent": return "agentcode";break;
				case "relationship": return "relationshipcode";break;
				default: return "code";
			}
		}
		function selectfld2($x){
			switch($x){
				case "debtormast": return "name";break;
				case "agent": return "name";break;
				default: return "description";
			}
		}
		function selectfld3($x,$y){
			if($y=="Code"){
				return selectfld($x);
			}else if($y=="Description"){
				return selectfld2($x);
			}
		}
		
		if(isset($_GET['fld'])&&isset($_GET['txt'])){
			$fld=$_GET['fld'];
			$txt=$_GET['txt'];
			$sql="select ".selectfld($table).",".selectfld2($table)." from $table where ".selectfld3($table,$fld)." like '%$txt%' limit 0,8";
			if($table=="debtormast"){
				$sql="select ".selectfld($table).",".selectfld2($table)." from $table where ".selectfld3($table,$fld)." like '%$txt%' and debtortype <> 'PT' and debtortype <> 'PR' limit 0,8";
			}
		}else{
			$sql="select ".selectfld($table).",".selectfld2($table)." from $table limit 0,8";
			if($table=="debtormast"){
				$sql="select ".selectfld($table).",".selectfld2($table)." from $table where debtortype <> 'PT' and debtortype <> 'PR' limit 0,8";
			}
		}
		
		$res=mysql_query($sql);
		while($obj=mysql_fetch_array($res,MYSQL_NUM)){
				array_push($json,$obj);
		}
		
		echo json_encode($json);
		
?>
