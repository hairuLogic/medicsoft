<?php
	include_once('../../sschecker.php');
	include_once('../../connect_db.php');
	
	function chgdate($date){
		$tok=explode('-',$date);
		$newrow=$tok[2].'-'.$tok[1].'-'.$tok[0];
		return $newrow;
	}
	
	$mbrno=$_GET['mbrno'];
	$aggdate= new DateTime(chgdate($_GET['aggdate']));
	$expdate= new DateTime(chgdate($_GET['expdate']));
	$json=array();
	
	$sql="select agreementdate,expdate from dbacthdr where memberno='$mbrno' and compcode='{$_SESSION['company']}' and source='PB' and trantype='IN' ";
	
	$res=mysql_query($sql);
	if(mysql_num_rows($res)==0){
		$json=true;
	}else{
		while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
			$dateexp= new DateTime($row['expdate']);
			$dateagg= new DateTime($row['agreementdate']);
			if($aggdate<$dateexp){
				if($expdate>$dateagg){
					$json=false;break;
				}
			}else{
				$json=true;	
			}
		}
	}
	echo json_encode($json);
?>
