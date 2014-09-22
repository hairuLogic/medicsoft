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
*/
    $opStatus=$_POST['opStatusDetail'];
    $compcode=$_SESSION['company'];
	$username=$_SESSION['username'];
    $pkgCode=$_POST['pkgCodeDetail'];
	$chgCode=$_POST['chgCodeDetail'];
    $pkgDescription=$_POST['pkgDetailDescription'];
    $freqqty=$_POST['freqqty'];
	$intervl=$_POST['intervl'];
	$maxqty=$_POST['maxqty'];
	$remark=$_POST['remarkDetail'];
	$detailType=$_POST['detailType'];
	$parts = explode('/', $_POST['pkgEffectDateDetail']);
	$effectdate  = "$parts[2]-$parts[1]-$parts[0]";

    include '../../config.php';

    if($opStatus == 'update'){
		$myquery = "SELECT COUNT(*) AS count FROM pkgpat WHERE chgcode='{$chgCode}' AND agreementdate >= '{$effectdate}' AND compcode='{$compcode}'";
        $res=mysql_query($myquery)  or die("Couldn't execute query.".mysql_error());
		$row = mysql_fetch_array($res);
    	$count = $row['count'];
		
		if($count=='0'){
			/*$myquery = "UPDATE chgmast SET description='$pkgDescription' WHERE compcode='{$compcode}' and chgcode='{$chgCode}'";
			$res=mysql_query($myquery)  or die("Couldn't execute query.".mysql_error());*/
			$myquery = "UPDATE pkgdet SET description='$pkgDescription',freqqty='$freqqty',intervl='$intervl',maxqty='$maxqty',remark='$remark' ,lastuser='$username',lastupdate=now() WHERE compcode='{$compcode}' and pkgCode='{$pkgCode}' and chgcode='{$chgCode}' and effectdate='{$effectdate}'";
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
			$myquery = "INSERT INTO pkgdet (compcode,pkgcode,chgcode,description,freqqty,intervl,maxqty,remark,effectdate,adduser,adddate) VALUES ('{$compcode}','{$pkgCode}',LPAD('{$lastId}',7,'0'),'{$pkgDescription}','{$freqqty}','{$intervl}','{$maxqty}','{$remark}','{$effectdate}','{$username}',now())";
			$res=mysql_query($myquery)  or die("Couldn't execute query.".mysql_error());
			if(!$res){
				echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>fail</msg></tab>";
				die;
			}else{
				echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
			}			
		}
		else{
			$myquery = "INSERT INTO pkgdet (compcode,pkgcode,chgcode,description,freqqty,intervl,maxqty,remark,effectdate,adduser,adddate) 
			VALUES ('{$compcode}','{$pkgCode}','{$chgCode}','{$pkgDescription}','{$freqqty}','{$intervl}','{$maxqty}','{$remark}',
			'{$effectdate}','{$username}',now())";
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
