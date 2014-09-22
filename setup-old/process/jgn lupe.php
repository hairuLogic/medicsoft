<?php
	include_once('../../sschecker.php');
    $opStatus=$_POST['opStatusEffect'];
    $compcode=$_SESSION['company'];
    $pkgCode=$_POST['pkgCodeEffect'];
    $pkgDescription=$_POST['pkgDescriptionEffect'];
    $pkgTerm=$_POST['pkgTermEffect'];
	$pkgPrice=$_POST['pkgPrice'];
	$pkgDate=$_POST['pkgEffectDate'];
	/*	
	$opStatus="update";
    $compcode="9a";
    $pkgCode="0009383";
    $pkgDescription="Test1";
    $pkgTerm="10";*/

    include '../../config.php';

    if($opStatus == 'update'){
		$myquery = "UPDATE pkgmast SET description='$pkgDescription',term='$pkgTerm' WHERE compcode='{$compcode}' and pkgCode='{$pkgCode}'";
        $res=mysql_query($myquery)  or die("Couldn't execute query.".mysql_error());
        if(!$res){
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>fail</msg></tab>";
            die;
        }else{
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
        }
    }

    else if($opStatus == 'delete'){
        $myquery = "DELETE FROM users WHERE compcode='{$compcode}' and username='{$username}'";
        $res=mysql_query($myquery);
        if(!$res){
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>fail</msg></tab>";
            die;
        }else{
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
        }
    }

    else if($opStatus == 'insert'){
        $myquery = "INSERT INTO chgmast (compcode,description) VALUES ('{$compcode}','{$pkgDescription}')";
        $res=mysql_query($myquery)  or die("Couldn't execute query.".mysql_error());
		$lastId=mysql_insert_id();
		$myquery = "UPDATE chgmast SET chgcode=LPAD('{$lastId}',7,'0') WHERE compcode='{$compcode}' and id='{$lastId}'";
        $res=mysql_query($myquery)  or die("Couldn't execute query.".mysql_error());
		$myquery = "INSERT INTO pkgmast (compcode,pkgcode,description,term) VALUES ('{$compcode}',LPAD('{$lastId}',7,'0'),'{$pkgDescription}','{$pkgTerm}')";
		$res=mysql_query($myquery)  or die("Couldn't execute query.".mysql_error());
        if(!$res){
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>fail</msg></tab>";
            die;
        }else{
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
        }
    }
?>
