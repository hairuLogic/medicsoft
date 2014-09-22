<?php
	include_once('../../sschecker.php');
	include_once('../../connect_db.php');
	date_default_timezone_set("Asia/Kuala_Lumpur");
	$tok=explode('-',$_POST['nomdob']);
	$newdob=$tok[2].'-'.$tok[1].'-'.$tok[0];
	$compid=$_SESSION['company'];
	$adduser=$_SESSION['username'];
	$adddate = date('Y-m-d');
	
	$sql="insert into membership(
			MemberNo,
			MRN,
			Category,
			CompCode,
			Name,
			Newic,
			DOB,
			citizencode,
			racecode,
			religion,
			patstatus,
			sex,
			areacode,
			relatecode,
			languagecode,
			address1,
			address2,
			address3,
			telh,
			telhp,
			telo,
			email,
			remarks,
			AddUser,
			AddDate
		) values (
			'{$_POST['mbrno']}',
			'{$_POST['nommrn']}',
			'{$_POST['nomcat']}',
			'$compid',
			'{$_POST['nomname']}',
			'{$_POST['nomnewic']}',
			'$newdob',
			'{$_POST['nomcitizen']}',
			'{$_POST['nomrace']}',
			'{$_POST['nomrel']}',
			'{$_POST['nomstat']}',
			'{$_POST['nomsex']}',
			'{$_POST['nomarea']}',
			'{$_POST['nomrelate']}',
			'{$_POST['nomlang']}',
			'{$_POST['nomadd1']}',
			'{$_POST['nomadd2']}',
			'{$_POST['nomadd3']}',
			'{$_POST['nomtelh']}',
			'{$_POST['nomtelhp']}',
			'{$_POST['nomtelo']}',
			'{$_POST['nomemail']}',
			'{$_POST['note']}',
			'$adduser',
			'$adddate'
		)" ;
	$res=mysql_query($sql);
	if(!$res){
		die;
		echo mysql_error();
	}else{
		echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg><lastsysno>".mysql_insert_id()."</lastsysno></tab>";
	}
?>