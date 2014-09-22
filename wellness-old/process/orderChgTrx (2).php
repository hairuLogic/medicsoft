<?php
session_start();
	/*$opStatus="insert";//$_POST['opStatus'];
	$compcode="9a";//$_SESSION['company'];
    $mrn="42";//$_POST['mrn'];
    $episno="3";//$_POST['episno'];
    $epistype="OP";//$_POST['epistype'];
    $trxtype="5908";//$_POST['chgtype'];	
    $trxdate="09/10/2013";//$_POST['chgDate'];
    $chgCode="002459AR-A";//$_POST['chgCode'];
    $isudept="test";//$_POST['chgDept'];
	$amt1="203";//$_POST['amt1'];
	$amt2="203";//$_POST['amt2'];
    $quantity="1";//$_POST['chgQuantity'];
    $amount="203";//$_POST['chgAmount'];
	$chggroup="PHKL";//$_POST['chggroup'];*/
    $opStatus=$_POST['opStatus'];
	$compcode=$_SESSION['company'];
    $mrn=$_POST['mrn'];
    $episno=$_POST['episno1'];
    $epistype=$_POST['epistycode1'];
    $trxtype=$_POST['chgtype'];	
    
	$trxtime=$_POST['chgTime'];
    $chgCode=$_POST['chgCode'];
    //$isudept=$_POST['chgDept'];	
	$amt1=$_POST['amt1'];
	$amt2=$_POST['amt2'];
    $quantity=$_POST['chgQuantity'];
    //$amount=$_POST['chgAmount'];
	$chggroup=$_POST['chggroup'];

	$unitprce=$amt1;
	
	//$trxdate=$_POST['chgDate'];
	$parts = explode('/', $trxdate);
	//$trxdate  = "$parts[2]-$parts[1]-$parts[0]";
	
	if($trxtype!="pkg"){
		$trxtype="oe";
	}
    include '../../config.php';

    if($opStatus == 'insert'){
		$myquery = "UPDATE pkgpat SET qtyused = qtyused+$quantity WHERE mrn='{$mrn}' AND compcode='{$compcode}' AND chgcode='$chgCode'";
		$res=mysql_query($myquery);
        //$myquery = "INSERT INTO chargetrx (compcode,mrn,episno,$trxdate,trxtype,chgcode,quantity) VALUES ('$compcode','$mrn','$episno','$trxdate','$trxtype','$chgCode','$quantity')";
		$myquery = "INSERT INTO chargetrx (compcode,mrn,episno,trxtype,chgcode,quantity) VALUES ('$compcode','$mrn','$episno','$trxtype','$chgCode','$quantity')";
        /*echo $myquery;*/
		$res=mysql_query($myquery);
		
        if(!$res){
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>".mysql_error()."</msg></tab>";
			die;
        }else{
			
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
			die;
        }
    }
	else if($opStatus == 'delete'){
		$myquery = "UPDATE pkgpat SET qtyused = qtyused-$quantity WHERE mrn='{$mrn}' AND compcode='{$compcode}' AND chgcode='$chgCode'";
		$res=mysql_query($myquery);
        $myquery = "DELETE FROM chargetrx WHERE compcode='$compcode' AND mrn='$mrn' AND episno='$episno' AND chgcode='$chgCode' ";
        /*echo $myquery;*/
		$res=mysql_query($myquery);
		
        if(!$res){
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>".mysql_error()."</msg></tab>";
			die;
        }else{			
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
			die;
        }
    }
  
?>
