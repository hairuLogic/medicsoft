<?php
	include_once('../../sschecker.php');
    $opStatus=$_POST['opStatusEffect'];
    $compcode=$_SESSION['company'];
	$username=$_SESSION['username'];
    $pkgCode=$_POST['pkgCodeEffect'];
    $pkgDescription=$_POST['pkgDescriptionEffect'];
    $pkgTerm=$_POST['pkgTermEffect'];
	$pkgPrice=$_POST['pkgPrice'];
	$parts = explode('/', $_POST['pkgEffectDate']);
	$pkgDate  = "$parts[2]-$parts[1]-$parts[0]";
	$parts = explode('/', $_POST['pkgEffectDateOld']);
	$pkgDateOld  = "$parts[2]-$parts[1]-$parts[0]";
	/*	
	$opStatus="update";
    $compcode="9a";
    $pkgCode="0009383";
    $pkgDescription="Test1";
    $pkgTerm="10";*/

    include '../../config.php';

    if($opStatus == 'update'){
		$myquery = "SELECT COUNT(*) AS count FROM pkgpat WHERE pkgcode='{$pkgCode}' AND agreementdate >= '{$pkgDateOld}' AND compcode='{$compcode}'";
        $res=mysql_query($myquery)  or die("Couldn't execute query.".mysql_error());
		$row = mysql_fetch_array($res);
    	$count = $row['count'];
				
		if($count=='0'){
			$myquery = "UPDATE pkgmast SET price='$pkgPrice',effectdate='$pkgDate',lastupdate=NOW(),lastuser='{$username}' WHERE compcode='{$compcode}' and pkgCode='{$pkgCode}' and effectdate='{$pkgDateOld}'";
			$res=mysql_query($myquery)  or die("Couldn't execute query.".mysql_error());
			if(!$res){
				echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>fail</msg></tab>";
				die;
			}else{
				echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
			}
		}
		else echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>countfail</msg></tab>";
    }

    else if($opStatus == 'insert'){
		$myquery = "INSERT INTO pkgmast (compcode,pkgcode,description,term,effectdate,price,lastupdate,lastuser) VALUES ('{$compcode}','{$pkgCode}','{$pkgDescription}','{$pkgTerm}','{$pkgDate}','{$pkgPrice}',NOW(),'{$username}')";
		$res=mysql_query($myquery)  or die("Couldn't execute query.".mysql_error());
        if(!$res){
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>fail</msg></tab>";
            die;
        }else{
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
        }
    }
?>
