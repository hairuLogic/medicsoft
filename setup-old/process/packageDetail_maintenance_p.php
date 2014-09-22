<?php
include_once('../../sschecker.php');

	/*$opStatus='insert';
    $compcode='9a';
    $pkgCode='0009383';
	$chgCode='';
    $pkgDescription='test Detail';
    $freqqty='1';
	$intervl='3';
	$maxqty='2';*/
	
    $opStatus=$_POST['opStatusDetail'];
    $compcode=$_SESSION['company'];
    $pkgCode=$_POST['pkgCodeDetail'];
	$chgCode=$_POST['chgCodeDetail'];
    $pkgDescription=$_POST['pkgDetailDescription'];
    $freqqty=$_POST['freqqty'];
	$intervl=$_POST['intervl'];
	$maxqty=$_POST['maxqty'];

    include '../../config.php';

    if($opStatus == 'update'){
        $myquery = "UPDATE chgmast SET description='$pkgDescription' WHERE compcode='{$compcode}' and chgcode='{$chgCode}'";
        $res=mysql_query($myquery)  or die("Couldn't execute query.".mysql_error());
		$myquery = "UPDATE pkgdet SET description='$pkgDescription',freqqty='$freqqty',intervl='$intervl',maxqty='$maxqty' WHERE compcode='{$compcode}' and pkgCode='{$pkgCode}' and chgcode='{$chgCode}'";
        $res=mysql_query($myquery)  or die("Couldn't execute query.".mysql_error());
        if(!$res){
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>fail</msg></tab>";
            die;
        }else{
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
        }
    }

    else if($opStatus == 'delete'){
    }

    else if($opStatus == 'insert'){
        $myquery = "INSERT INTO chgmast (compcode,description,chggroup) VALUES ('{$compcode}','{$pkgDescription}','{$pkgCode}')";
        $res=mysql_query($myquery)  or die("Couldn't execute query.".mysql_error());
		$lastId=mysql_insert_id();
		$myquery = "UPDATE chgmast SET chgcode=LPAD('{$lastId}',7,'0') WHERE compcode='{$compcode}' and id='{$lastId}'";
        $res=mysql_query($myquery)  or die("Couldn't execute query.".mysql_error());
		$myquery = "INSERT INTO pkgdet (compcode,pkgcode,chgcode,description,freqqty,intervl,maxqty) VALUES ('{$compcode}','{$pkgCode}',LPAD('{$lastId}',7,'0'),'{$pkgDescription}','{$freqqty}','{$intervl}','{$maxqty}')";
		$res=mysql_query($myquery)  or die("Couldn't execute query.".mysql_error());
        if(!$res){
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>fail</msg></tab>";
            die;
        }else{
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
        }
    }
?>
