<?php
	include_once('../../sschecker.php');
	include_once('../../connect_db.php');
	//date_default_timezone_set("Asia/Kuala_Lumpur");
	function chgdate($date){
		$tok=explode('-',$date);
		$newrow=$tok[2].'-'.$tok[1].'-'.$tok[0];
		return $newrow;
	}
	$joindate=chgdate($_POST['joindate']);
	$aggdate=chgdate($_POST['aggdate']);
	$expdate=chgdate($_POST['expdate']);
	$compid=$_SESSION['company'];
	$adduser=$_SESSION['username'];
	$adddate = date('Y-m-d');
	$addtime = date('h:i:s');
	
	$res=mysql_query("select pvalue1 from sysparam where source='PB' and tratype='IN' and compcode='$compid'")or die("Couldn?t execute query.".mysql_error());
	$row=mysql_fetch_assoc($res);
	$docno=$row['pvalue1']+1;
	$res=mysql_query("update sysparam set PValue1 = '$docno' where source='PB' and tratype='IN' and compcode='$compid'")or die("Couldn?t execute query.".mysql_error());
	$res=mysql_query("select agreementno from membership where memberno='{$_POST['memberno']}' and category='SUBSCRIBER' ")or die("Couldn?t execute query.".mysql_error());
	$row=mysql_fetch_assoc($res);
	
	$sql="insert into dbacthdr(
			CompCode,
			source,
			trantype,
			amount,
			outamount,
			remark,
			memberno,
			agentcode,
			agreementdate,
			entrydate,
			entrytime,
			entryuser,
			joindate,
			expdate,
			pkgcode,
			docno,
			agreementno
		) values (
			'$compid',
			'PB',
			'IN',
			'{$_POST['billfees2']}',
			'{$_POST['billfees2']}',
			'{$_POST['description']}',
			'{$_POST['memberno']}',
			'{$_POST['billagent']}',
			'$aggdate',
			'$aggdate',
			'$addtime',
			'$adduser',
			'$joindate',
			'$expdate',
			'{$_POST['pkgcode']}',
			'$docno',
			'{$row['agreementno']}'
		)";
	$res=mysql_query($sql)or die("Couldn?t execute query.".mysql_error());
	
	
	if($_POST['pkgstat']==1){
		$res2=mysql_query("update membership set agentcode='{$_POST['billagent']}' ,pkgcode='{$_POST['pkgcode']}' where memberno='{$_POST['memberno']}'")or die("Couldn?t execute query.".mysql_error());
		
		$res5=mysql_query("select mrn from membership where compcode='$compid' and memberno='{$_POST['memberno']}' and category='SUBSCRIBER'")or die(mysql_error());
		$mrn1=mysql_fetch_assoc($res5);
		$mrn=$mrn1['mrn'];
		
		$res3=mysql_query("
			INSERT INTO pkgpat (compcode,mrn,memberno,pkgcode,chgcode,pkgqty,adduser,adddate,agreementdate,expirydate) 
			SELECT '$compid','$mrn','{$_POST['memberno']}','{$_POST['pkgcode']}',chgcode,maxqty,'$adduser','$adddate','$aggdate','$expdate' 
			FROM pkgdet 
			WHERE compcode='$compid' AND pkgcode='{$_POST['pkgcode']}' 
			AND effectdate = (
				SELECT MAX(effectdate) FROM pkgdet 
				WHERE effectdate <= '$aggdate' 
				AND (expirydate > '$aggdate' OR expirydate IS NULL) 
				AND pkgcode='{$_POST['pkgcode']}' 
				AND compcode='$compid'
			)")or die(mysql_error());
		
		if($_POST['bflag']==1){
			$res4=mysql_query("
				INSERT INTO pkgpat (compcode,mrn,memberno,pkgcode,chgcode,pkgqty,adduser,adddate,agreementdate,expirydate) 
				SELECT '$compid','$mrn','{$_POST['memberno']}','{$_POST['pkgcode']}',chgcode,maxqty,'$adduser','$adddate' ,'$aggdate','$expdate'
				FROM pkgbenefit 
				WHERE compcode='$compid' AND pkgcode='{$_POST['pkgcode']}' 
				AND effectdate = (
					SELECT MAX(effectdate) FROM pkgdet 
					WHERE effectdate <= '$aggdate' 
					AND (expirydate > '$aggdate' OR expirydate IS NULL) 
					AND pkgcode='{$_POST['pkgcode']}' 
					AND compcode='$compid'
				)")or die(mysql_error());
		}
		
	}
	
	
	
	if(!$res){
		die;
		echo mysql_error();
	}else{
		echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
	}
?>