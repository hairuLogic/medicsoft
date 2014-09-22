<?php
	include_once('sschecker.php');
	include_once('connect_db.php');
	$compid=$_SESSION['company'];
	$mrn=$_POST['mrn'];
	$sql = "select 
				Name,
				Newic,
				Oldic,
				idnumber,
				TitleCode,
				Address1,Address2,Address3,Postcode,
				OffAdd1,OffAdd2,OffAdd3,OffAdd4,
				pAdd1,pAdd2,pAdd3,pPostCode,
				Postcode,
				DOB,
				Citizencode,
				MaritalCode,
				RaceCode,
				Religion,
				Sex,
				bloodgrp,
				LanguageCode,
				telh,
				telhp,
				OccupCode,
				CorpComp,
				Email,
				RelateCode,
				Staffid,
				ChildNo,
				Active,
				Confidential,
				MRFolder,
				OldMrn,
				PatStatus
			from patmast where MRN=$mrn and compcode='$compid'";
	$res=mysql_query($sql);
	$row=mysql_fetch_assoc($res);
	
	$tok=explode('-',$row['DOB']);
	$newdob=$tok[2].'-'.$tok[1].'-'.$tok[0];
	if($row['Active']==1){$activenew='Yes';}else{$activenew='No';}
	if($row['Confidential']==1){$confidentialnew='Yes';}else{$confidentialnew='No';}
	if($row['MRFolder']==1){$MRecordnew='Yes';}else{$MRecordnew='No';}
	
	echo "<?xml version='1.0' encoding='utf-8'?>
			<tab><patient>
				<name>{$row['Name']}</name>
				<newic>{$row['Newic']}</newic>
				<oldic>{$row['Oldic']}</oldic>
				<othno>{$row['idnumber']}</othno>
				<title>{$row['TitleCode']}</title>
				<curaddr1>{$row['Address1']}</curaddr1> <curaddr2>{$row['Address2']}</curaddr2> <curaddr3>{$row['Address3']}</curaddr3><postcode>{$row['Postcode']}</postcode>
				<offaddr1>{$row['OffAdd1']}</offaddr1> <offaddr2>{$row['OffAdd2']}</offaddr2> <offaddr3>{$row['OffAdd3']}</offaddr3><postcode2>{$row['OffAdd4']}</postcode2>
				<peraddr1>{$row['pAdd1']}</peraddr1> <peraddr2>{$row['pAdd2']}</peraddr2> <peraddr3>{$row['pAdd3']}</peraddr3><postcode3>{$row['pPostCode']}</postcode3>
				<dob>$newdob</dob>
				<citizen>{$row['Citizencode']}</citizen>
				<marital>{$row['MaritalCode']}</marital>
				<race>{$row['RaceCode']}</race>
				<religion>{$row['Religion']}</religion>
				<sex>{$row['Sex']}</sex>
				<bloodgroup>{$row['bloodgrp']}</bloodgroup>
				<language>{$row['LanguageCode']}</language>
				<house>{$row['telh']}</house>
				<hp>{$row['telhp']}</hp>
				<occupation>{$row['OccupCode']}</occupation>
				<company>{$row['CorpComp']}</company>
				<email>{$row['Email']}</email>
				<relcode>{$row['RelateCode']}</relcode>
				<staffid>{$row['Staffid']}</staffid>
				<chno>{$row['ChildNo']}</chno>
				<active>$activenew</active>
				<confidential>$confidentialnew</confidential>
				<MRecord>$MRecordnew</MRecord>
				<oldmrn>{$row['OldMrn']}</oldmrn>
				<fstatus>{$row['PatStatus']}</fstatus>
			</patient></tab>";

?>