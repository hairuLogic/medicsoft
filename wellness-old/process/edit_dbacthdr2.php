<?php
session_start();
$compcode=$_SESSION['company'];
$rowAmtpay=$_POST["rowAmtpay"];
$idAmtpay=$_POST["idAmtpay"];
$outAmt=$_POST["outAmt"];
 include '../../config.php';
$test=0;
for($i=1;$i<count( $rowAmtpay );$i++){
	$balance=$outAmt[$i]-$rowAmtpay[$i];
	 $a = mysql_query('UPDATE dbacthdr SET outamount ="'.$balance.'"  WHERE auditno = "'.$idAmtpay[$i].'" AND compcode="'.$compcode.'"');
}

echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
?>