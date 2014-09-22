<?php
session_start();
include_once('../../sschecker.php');
    $canrun=$_POST['canrun'];
	$yesall=$_POST['yesall'];
	$canrunold=$_POST['canrunold'];
	$yesallold=$_POST['yesallold'];
    $groupid=$_POST['groupid'];
    $programid=$_POST['programid'];
    $programmenu=$_POST['programmenu'];
    $lineno=$_POST['lineno'];

    include '../../config.php';
	
	if($canrun=="Yes" && $canrunold=="No"){//insert into groupacc
	
mysql_query("START TRANSACTION");
       	$q1 =mysql_query("INSERT INTO groupacc (compcode,groupid,programmenu,lineno,canrun) VALUES ('{$_SESSION['company']}', '{$groupid}', '{$programmenu}', '{$lineno}','1')");
		$a="INSERT INTO groupacc (compcode,groupid,programmenu,lineno,canrun) VALUES ('{$_SESSION['company']}', '{$groupid}', '{$programmenu}', '{$lineno}','1')";
		if($yesall=="Yes" && $yesallold=="No"){//update groupacc and insert child
			$q2=mysql_query("UPDATE groupacc SET yesall=1 WHERE lineno='{$lineno}' and groupid='{$groupid}' and programmenu='{$programmenu}' and compcode='{$_SESSION['company']}'");
			$q3=mysql_query("INSERT INTO groupacc (compcode,groupid,programmenu,lineno,canrun) SELECT compcode,'{$groupid}',programmenu,lineno,'1' FROM programtab WHERE programmenu='{$programid}' AND compcode='{$_SESSION['company']}'");			
		}
		if ($q1) {
			if ($q2 and $q3) {
				mysql_query("COMMIT");
				echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
			} 
			else if ($q1){        
				mysql_query("COMMIT");
				echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
			}
			else {        
				mysql_query("ROLLBACK");
				echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>'{$a}'</msg></tab>";
			}
        } else {        
            mysql_query("ROLLBACK");
			echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>'{$a}'</msg></tab>";
        }
    }
	
	else if($canrun=="Yes" && $canrunold=="Yes"){//check yesall
	
mysql_query("START TRANSACTION");
		if($yesall=="Yes" && $yesallold=="No"){//update groupacc and insert child
			$q1=mysql_query("UPDATE groupacc SET yesall=1 WHERE lineno='{$lineno}' and groupid='{$groupid}' and programmenu='{$programmenu}' and compcode='{$_SESSION['company']}'");
			$q2=mysql_query("INSERT INTO groupacc(compcode,groupid,programmenu,lineno,canrun) SELECT compcode,'{$groupid}',programmenu,lineno,'1' FROM programtab WHERE programmenu='{$programid}' AND compcode='{$_SESSION['company']}'");
		}
		else if($yesall=="No" && $yesallold=="Yes"){//update from groupacc
			$q1=mysql_query("UPDATE groupacc SET yesall=0 WHERE lineno='{$lineno}' and groupid='{$groupid}' and programmenu='{$programmenu}' and compcode='{$_SESSION['company']}'");
			$q2 = mysql_query("DELETE FROM groupacc WHERE groupid='{$groupid}' and programmenu='{$programid}' and compcode='{$_SESSION['company']}'");
			
		}
		if ($q1) {
            mysql_query("COMMIT");
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
        } else {        
            mysql_query("ROLLBACK");
			echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>fail</msg></tab>";
        }
    }
	
	else if($canrun=="No" && $canrunold=="Yes"){//delete from groupacc
	
mysql_query("START TRANSACTION");
       $q1 = mysql_query("DELETE FROM groupacc WHERE lineno='{$lineno}' and groupid='{$groupid}' and programmenu='{$programmenu}' and compcode='{$_SESSION['company']}'");
	   $q2 = mysql_query("DELETE FROM groupacc WHERE groupid='{$groupid}' and programmenu='{$programid}' and compcode='{$_SESSION['company']}'");
	   if ($q1 and $q2) {
            mysql_query("COMMIT");
            echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>success</msg></tab>";
        } else {        
            mysql_query("ROLLBACK");
			echo "<?xml version='1.0' encoding='utf-8'?><tab><msg>fail</msg></tab>";
        }
    }	
	
	
?>
