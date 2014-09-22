<?php
session_start();
$compcode=$_SESSION['company'];
$username=$_SESSION['username'];
$rowAmtpay=$_POST["rowAmtpay"];
$idAmtpay=$_POST["idAmtpay"];
$outAmt=$_POST["outAmt"];
$agentcode=$_POST["agent"];
$memberno=$_POST["member"];
$paymode=$_POST["payMode"];
$amount=$_POST["totalamt"];
$totalamtaloc=$_POST["totalamtaloc"];
$recptno=$_POST["receiptno"];
$manualreceipt=$_POST["receiptManual"];
$remark=$_POST["remark"];

if($_POST["cardFlag"]=="1"){
	$reference=$_POST["cardno"];
	$expdate=$_POST["carddate"];
}
else if($_POST["cardFlag"]=="2"){
	$reference=$_POST["checkno"];
	$expdate=$_POST["checkdate"];
}
else{
	$reference="00/00/0000";
	$expdate="00/00/0000";
}


$parts = explode('/', $expdate);
$expdate="$parts[2]-$parts[1]-$parts[0]";
$parts = explode('/', $_POST["dateHIS"]);
$entrydate="$parts[2]-$parts[1]-$parts[0]";
$parts = explode('/', $_POST["dateManual"]);
$manualdate="$parts[2]-$parts[1]-$parts[0]";

include '../../config.php';
$test=0;

mysql_query("START TRANSACTION");

$sql="INSERT INTO dbacthdr (compcode,source,trantype,amount,outamount,entrydate,recptno,expdate,reference,paymode,entryuser,remark,docno,agentcode,memberno,manualdate,manualreceipt) VALUES('$compcode','PB','RC','$amount',$amount-$totalamtaloc,'$entrydate','$recptno','$expdate','$reference','$paymode','$username','$remark',(select pvalue1 from sysparam where compcode='$compcode' and source='PB' and tratype='RC'),'$agentcode','$memberno','$manualdate','$manualreceipt')";
if(!$a=mysql_query($sql)){
	mysql_query("ROLLBACK");
	echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>$sql</msg></tab>";
	die;
}
$lastId=mysql_insert_id();
for($i=0;$i<count( $rowAmtpay );$i++){
	$balance=$outAmt[$i]-$rowAmtpay[$i];
	$sql="UPDATE dbacthdr SET outamount ='$balance' , upddate=now() , upduser='$username' WHERE auditno = '$idAmtpay[$i]' AND compcode='$compcode'";
	if(!$a = mysql_query($sql))
	{
		mysql_query("ROLLBACK");
		echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>2</msg></tab>";
		die;
	}
}
for($i=0;$i<count( $rowAmtpay );$i++){
	if(!$a = mysql_query("INSERT INTO dballoc	(compcode,source,trantype,lineno_,docno,docsource,doctrantype,docauditno,refsource,reftrantype,refauditno,recptno,amount,allocdate,remark,allocsts,paymode)	VALUES ('$compcode','AR','AL',$i+1,(select pvalue1 from sysparam where compcode='$compcode' and source='AR' and tratype='AL'),'PB','RC','$lastId','PB','IN','$idAmtpay[$i]','$recptno','$rowAmtpay[$i]',now(),'$username','a','$paymode')"))
	{
		mysql_query("ROLLBACK");
		echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>3</msg></tab>";
		die;
	}
}


if(!$a = mysql_query("UPDATE sysparam SET pvalue1=pvalue1+1 WHERE compcode='$compcode' AND (source='PB' OR source='AR') AND (tratype='AL' OR tratype='RC')")){
	mysql_query("ROLLBACK");
	echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>4</msg></tab>";
	die;
}
mysql_query("COMMIT");
echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
?>