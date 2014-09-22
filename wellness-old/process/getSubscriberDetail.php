<?php
include_once('../../sschecker.php');
    $MemberNo=$_POST['MemberNo'];
    $compcode=$_SESSION['company'];

    include '../../config.php';
	
	$myquery = "SELECT a.MemberNo,a.name,a.Newic,a.telhp,a.DOB,TIMESTAMPDIFF(YEAR,a.DOB,NOW()) AS age,Sex,Category,
Address1,Address2,Address3,OffAdd1,OffAdd2,OffAdd3,telh,telo,mrn,b.name AS agent,c.description as pakage
 FROM membership AS a,agent AS b,pkgmast AS c WHERE c.pkgcode=a.pkgcode AND b.agentcode=a.agent AND a.compcode='{$compcode}' AND MemberNo='{$MemberNo}' AND category='subscriber'";

	$res=mysql_query($myquery);
	$row=mysql_fetch_row($res,MYSQL_ASSOC);
	if(!$res){
		echo "<?xml version='1.0' encoding='utf-8'?>\n<tab><msg>fail</msg></tab>";
		die;
	}else{
		 
		echo "<?xml version='1.0' encoding='utf-8'?>";
		echo "<tab>";
		echo "<MemberNo>". $row['MemberNo']."</MemberNo>";
        echo "<Name>". $row['name']."</Name>";
        echo "<Newic>". $row['Newic']."</Newic>";
        echo "<telhp>". $row['telhp']."</telhp>";
        echo "<DOB>". $row['DOB']."</DOB>";
        echo "<Sex>". $row['Sex']."</Sex>";
        echo "<Category>". $row['Category']."</Category>";//citizen description
		echo "<Address1>". $row['Address1']."</Address1>";//debtor name
		echo "<Address2>". $row['Address2']."</Address2>";//payercode 
        echo "<Address3>". $row['Address3']."</Address3>";
        echo "<OffAdd1>". $row['OffAdd1']."</OffAdd1>";
        echo "<OffAdd2>". $row['OffAdd2']."</OffAdd2>";
		echo "<OffAdd3>". $row['OffAdd3']."</OffAdd3>";		
        echo "<telh>". $row['telh']."</telh>";
		echo "<telo>". $row['telo']."</telo>";
		echo "<mrn>". $row['mrn']."</mrn>";
		echo "<age>". $row['age']."</age>";
		echo "<agent>". $row['agent']."</agent>";
		echo "<pakage>". $row['pakage']."</pakage>";
		echo "</tab>";
	}
?>
