<?php
include_once('../../sschecker.php');

	/*$opStatus='insert';
    $compcode='9a';
    $pkgCode='0009383';
	$chgCode='';
    $pkgDescription='test Detail';
    $freqqty='1';
	$intervl='3';
	$maxqty='2';
	
benefitType:new
pkgBenefitDescription:d
maxqtyBenefit:m
remarkBenefit:r
benefitEffectDate:01/12/2013
benefitExpiredDate:31/12/2013
pkgCodeBenefit:0010027
chgCodeBenefit:
opStatusBenefit:insert

*/
    $opStatus=$_POST['opStatusBenefit'];
    $compcode=$_SESSION['company'];
	$username=$_SESSION['username'];
    $pkgCode=$_POST['pkgCodeBenefit'];
	$chgCode=$_POST['chgCodeBenefit'];
    $pkgDescription=$_POST['pkgBenefitDescription'];
    /*$freqqty=$_POST['freqqty'];
	$intervl=$_POST['intervl'];*/
	$maxqty=$_POST['maxqtyBenefit'];
	$remark=$_POST['remarkBenefit'];
	$detailType=$_POST['benefitType'];
	$parts = explode('/', $_POST['benefitEffectDate']);
	$effectdate  = "$parts[2]-$parts[1]-$parts[0]";
	$parts = explode('/', $_POST['benefitExpiredDate']);
	$expireddate  = "$parts[2]-$parts[1]-$parts[0]";

    include '../../config.php';

    if($opStatus == 'update'){
		$myquery = "SELECT COUNT(*) AS count FROM pkgpat WHERE chgcode='{$chgCode}' AND agreementdate >= '{$effectdate}' AND compcode='{$compcode}'";
        $res=mysql_query($myquery)  or die("Couldn't execute query.".mysql_error());
		$row = mysql_fetch_array($res);
    	$count = $row['count'];
		
		if($count=='0'){
			/*$myquery = "UPDATE chgmast SET description='$pkgDescription' WHERE compcode='{$compcode}' and chgcode='{$chgCode}'";
			$res=mysql_query($myquery)  or die("Couldn't execute query.".mysql_error());*/
			$myquery = "UPDATE pkgbenefit SET description='$pkgDescription',maxqty='$maxqty',remark='$remark',lastuser='$username', lastupdate=now() WHERE compcode='{$compcode}' and pkgCode='{$pkgCode}' and chgcode='{$chgCode}' and effectdate='{$effectdate}'";
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
		
		if($detailType=='new'){
			$myquery = "INSERT INTO chgmast (compcode,description,adduser,adddate) VALUES ('{$compcode}','{$pkgDescription}','{$username}',now())";
			$res=mysql_query($myquery)  or die("Couldn't execute query.".mysql_error());
			$lastId=mysql_insert_id();
			$myquery = "UPDATE chgmast SET chgcode=LPAD('{$lastId}',7,'0') WHERE compcode='{$compcode}' and id='{$lastId}'";
			$res=mysql_query($myquery)  or die("Couldn't execute query.".mysql_error());
			$myquery = "INSERT INTO pkgbenefit (compcode,pkgcode,chgcode,description,maxqty,remark,effectdate,expirydate,adduser,adddate) 
			VALUES ('{$compcode}','{$pkgCode}',LPAD('{$lastId}',7,'0'),'{$pkgDescription}','{$maxqty}','{$remark}','{$effectdate}',
			'{$expireddate}','{$username}',now())";
			$res=mysql_query($myquery)  or die("Couldn't execute query.".mysql_error());
			if(!$res){
				echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>fail</msg></tab>";
				die;
			}else{
				echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
			}			
		}
		else{
			$myquery = "INSERT INTO pkgdet (compcode,pkgcode,chgcode,description,maxqty,remark,effectdate,expirydate,adduser,adddate) 
			VALUES ('{$compcode}','{$pkgCode}','{$chgCode}','{$pkgDescription}','{$maxqty}','{$remark}',
			'{$effectdate}','{$expireddate}','{$username}',now())";
			$res=mysql_query($myquery)  or die("Couldn't execute query.".mysql_error());
			if(!$res){
				echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>fail</msg></tab>";
				die;
			}else{
				echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
			}	
		}
		
        
    }
?>
