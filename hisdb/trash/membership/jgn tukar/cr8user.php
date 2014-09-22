<?php
	include_once('../../sschecker.php');
	include_once('../../connect_db.php');
	date_default_timezone_set("Asia/Kuala_Lumpur");
	$tok=explode('-',$_POST['dob']);
	$newdob=$tok[2].'-'.$tok[1].'-'.$tok[0];
	if($_POST['active']=='Yes'){$activenew=1;}else{$activenew=0;}
	if($_POST['confidential']=='Yes'){$confidentialnew=1;}else{$confidentialnew=0;}
	if($_POST['MRecord']=='Yes'){$MRecordnew=1;}else{$MRecordnew=0;}
	$compid=$_SESSION['company'];
	$adduser=$_SESSION['username'];
	$adddate = date('Y-m-d');
	
	$sql="select PValue1 from sysparam where Compcode='$compid' and tratype='member'";
	$res=mysql_query($sql);
	if(!$res){
		die;
		echo mysql_error();
	}else{
		$row=mysql_fetch_assoc($res);
		$newmrn=$row['PValue1']+1;
	}
	$sql="update sysparam set PValue1 = '$newmrn' where Compcode='$compid' and tratype='member'";
	$res=mysql_query($sql);
	$sql="insert into membership(
			MRN,
			CompCode,
			Name,
			Newic,
			Oldic,
			idnumber,
			TitleCode,
			Address1,Address2,Address3,Postcode,
			OffAdd1,OffAdd2,OffAdd3,OffAdd4,
			pAdd1,pAdd2,pAdd3,pPostCode,
			DOB,
			areacode,
			Citizencode,
			MaritalCode,
			RaceCode,
			Religion,
			Sex,
			bloodgrp,
			LanguageCode,
			telh,
			telhp,
			telo,
			OccupCode,
			CorpComp,
			Email,
			RelateCode,
			Staffid,
			ChildNo,
			Active,
			Confidential,
			MRFolder,
			NewMrn,
			OldMrn,
			PatStatus,
			AddUser,
			AddDate
		) values (
			'$newmrn',
			'$compid',
			'{$_POST['name']}',
			'{$_POST['newic']}',
			'{$_POST['oldic']}',
			'{$_POST['othno']}',
			'{$_POST['title']}',
			'{$_POST['curaddr1']}','{$_POST['curaddr2']}','{$_POST['curaddr3']}','{$_POST['postcode']}',
			'{$_POST['offaddr1']}','{$_POST['offaddr2']}','{$_POST['offaddr3']}','{$_POST['postcode2']}',
			'{$_POST['peraddr1']}','{$_POST['peraddr2']}','{$_POST['peraddr3']}','{$_POST['postcode3']}',
			'$newdob',
			'{$_POST['area']}',
			'{$_POST['citizen']}',
			'{$_POST['marital']}',
			'{$_POST['race']}',
			'{$_POST['religion']}',
			'{$_POST['sex']}',
			'{$_POST['bloodgroup']}',
			'{$_POST['language']}',
			'{$_POST['house']}',
			'{$_POST['hp']}',
			'{$_POST['telo']}',
			'{$_POST['occupation']}',
			'{$_POST['company']}',
			'{$_POST['email']}',
			'{$_POST['relcode']}',
			'{$_POST['staffid']}',
			'{$_POST['chno']}',
			'$activenew',
			'$confidentialnew',
			'$MRecordnew',
			'0',
			'{$_POST['oldmrn']}',
			'{$_POST['fstatus']}',
			'$adduser',
			'$adddate'
		)" ;
	$res=mysql_query($sql);
	if(!$res){
		die;
		echo mysql_error();
	}else{
		echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg><mrn>$newmrn</mrn></tab>";
	}
?>
