<?php
	include_once('../sschecker.php');
	include_once('../connect_db.php');
	date_default_timezone_set("Asia/Kuala_Lumpur");
	$tok=explode('-',$_POST['dob']);
	$newdob=$tok[2].'-'.$tok[1].'-'.$tok[0];
	if($_POST['active']=='Yes'){$activenew=1;}else{$activenew=0;}
	if($_POST['confidential']=='Yes'){$confidentialnew=1;}else{$confidentialnew=0;}
	if($_POST['MRecord']=='Yes'){$MRecordnew=1;}else{$MRecordnew=0;}
	$compid=$_SESSION['company'];
	$adduser=$_SESSION['username'];
	$date = date('Y-m-d');
	
	$sql="update patmast set
			Name='{$_POST['name']}',
			Newic='{$_POST['newic']}',
			Oldic='{$_POST['oldic']}',
			idnumber='{$_POST['othno']}',
			TitleCode='{$_POST['title']}',
			Address1='{$_POST['curaddr1']}',Address2='{$_POST['curaddr2']}',Address3='{$_POST['curaddr3']}',Postcode='{$_POST['postcode']}',
			OffAdd1='{$_POST['offaddr1']}',OffAdd2='{$_POST['offaddr2']}',OffAdd3='{$_POST['offaddr3']}',OffAdd4='{$_POST['postcode2']}',
			pAdd1='{$_POST['peraddr1']}',pAdd2='{$_POST['peraddr2']}',pAdd3='{$_POST['peraddr3']}',pPostCode='{$_POST['postcode3']}',
			Postcode='{$_POST['postcode']}',
			DOB='$newdob',
			areacode='{$_POST['area']}',
			Citizencode='{$_POST['citizen']}',
			MaritalCode='{$_POST['marital']}',
			RaceCode='{$_POST['race']}',
			Religion='{$_POST['religion']}',
			Sex='{$_POST['sex']}',
			bloodgrp='{$_POST['bloodgroup']}',
			LanguageCode='{$_POST['language']}',
			telh='{$_POST['house']}',
			telhp='{$_POST['hp']}',
			telo='{$_POST['telo']}',
			OccupCode='{$_POST['occupation']}',
			CorpComp='{$_POST['company']}',
			Email='{$_POST['email']}',
			RelateCode='{$_POST['relcode']}',
			Staffid='{$_POST['staffid']}',
			ChildNo='{$_POST['chno']}',
			Active='$activenew',
			Confidential='$confidentialnew',
			MRFolder='$MRecordnew',
			NewMrn='0',
			OldMrn='{$_POST['oldmrn']}',
			PatStatus='{$_POST['fstatus']}',
			Lastupdate='$date',
			LastUser='$adduser'
		where MRN='{$_POST['mrn']}' and CompCode='$compid'";
	$res=mysql_query($sql);
	if(!$res){
		die;
		echo mysql_error();
	}else{
		echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
	}
?>