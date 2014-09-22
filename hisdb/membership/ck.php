<?php
	include_once('../sschecker.php');
	include_once('../connect_db.php');
		$json=array();
		$table=$_GET['table'];
		$txt=$_GET['txt'];
		
		function selectfld($x){
			switch($x){
				case "debtormast": return "debtorcode";break;
				case "areacode": return "areacode";break;
				case "occupation": return "occupcode";break;
				case "agent": return "agentcode";break;
				case "relationship": return "relationshipcode";break;
				default: return "code";break;
			}
		}
		function selectfld2($x){
			switch($x){
				case "debtormast": return "name";break;
				case "agent": return "name";break;
				default: return "description";break;
			}
		}
		
		$sql="select ".selectfld2($table)." from $table where ".selectfld($table)." = '$txt'";
		
		$res=mysql_query($sql);
		if(mysql_num_rows($res)){
			$json=mysql_fetch_row($res);
		}else{
			$json="fail";
		}
		
		echo json_encode($json);
		
?>