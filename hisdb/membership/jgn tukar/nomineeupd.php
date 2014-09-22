<?php
	include_once('../../sschecker.php');
	include_once('../../connect_db.php');
	date_default_timezone_set("Asia/Kuala_Lumpur");
	$tok=explode('-',$_POST['nomdob']);
	$newdob=$tok[2].'-'.$tok[1].'-'.$tok[0];
	$compid=$_SESSION['company'];
	$adduser=$_SESSION['username'];
	$date = date('Y-m-d');
	
	$sql="update membership set
			MRN='{$_POST['nommrn']}',
			Name='{$_POST['nomname']}',
			category='{$_POST['nomcat']}',
			Newic='{$_POST['nomnewic']}',
			DOB='$newdob',
			citizencode='{$_POST['nomcitizen']}',
			racecode='{$_POST['nomrace']}',
			religion='{$_POST['nomrel']}',
			patstatus='{$_POST['nomstat']}',
			sex='{$_POST['nomsex']}',
			areacode='{$_POST['nomarea']}',
			relatecode='{$_POST['nomrelate']}',
			languagecode='{$_POST['nomlang']}',
			address1='{$_POST['nomadd1']}',
			address2='{$_POST['nomadd2']}',
			address3='{$_POST['nomadd3']}',
			telh='{$_POST['nomtelh']}',
			telhp='{$_POST['nomtelhp']}',
			telo='{$_POST['nomtelo']}',
			email='{$_POST['nomemail']}',
			remarks='{$_POST['note']}',
			Lastupdate='$date',
			LastUser='$adduser'
		where MemberNo='{$_POST['mbrno']}' and CompCode='$compid' and sysno='{$_POST['nomsysno']}'";
	$res=mysql_query($sql);
	if(!$res){
		die;
		echo mysql_error();
	}else{
		echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
	}
?>