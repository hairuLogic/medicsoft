<?php
session_start();
    $opStatus=$_POST['opStatus'];
    $compcode=$_SESSION['company'];
	
		$mrn=$_POST['mrn'];
	

    include '../../config.php';

	if($opStatus =='delete'){
		$parts = explode('.', $_POST['id']);
		
		$episno  = "$parts[1]";
		$myquery = "";
		$myquery = "SELECT COUNT(*) AS COUNT FROM chargetrx  WHERE mrn='$mrn' AND episno='$episno' AND compcode='{$compcode}'";
        $res=mysql_query($myquery);
		$row=mysql_fetch_row($res,MYSQL_ASSOC);
		$COUNT=$row['COUNT'];
		if($COUNT=='0'){
			$myquery = "DELETE FROM episode WHERE mrn='$mrn' AND episno='$episno' AND compcode='{$compcode}'";
			$res=mysql_query($myquery);
			$myquery = "UPDATE membership SET episno = episno-1 WHERE mrn='{$mrn}' AND compcode='{$compcode}'";
			$res=mysql_query($myquery);
			if(!$res){
				echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>fail</msg></tab>";
				die;
			}else{
				echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
			}
		}
		else{
			echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>delete</msg></tab>";
		}
        
    }

    if($opStatus == 'new'){
		$myquery = "SELECT episno FROM episode WHERE mrn='{$mrn}' AND compcode='{$compcode}' AND dischargedate IS NULL ";

        $res=mysql_query($myquery);
		$row=mysql_fetch_row($res,MYSQL_ASSOC);
		$episno=$row['episno'];
		if($episno==''||$episno==0){
			$myquery = "INSERT INTO episode(compcode,mrn,episno,reg_date) SELECT '{$compcode}', '{$mrn}',episno+1, CURDATE() FROM membership WHERE mrn='{$mrn}' AND compcode='{$compcode}'";

			$res=mysql_query($myquery);
			$myquery = "UPDATE membership SET episno = episno+1 WHERE mrn='{$mrn}' AND compcode='{$compcode}'";
			$res=mysql_query($myquery);

			if(!$res){
				echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>fail</msg></tab>";
				die;
			}else{
				echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg><id>".$mrn.".".$episno."</id></tab>";
				die;
			}
		}
		else{
			echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>".$mrn.".".$episno."</msg></tab>";	
		}
    }
?>
