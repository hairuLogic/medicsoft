<?php 

	include_once('config.php');
	ob_start();
   session_start();
	$myQuery="select a.groupid,a.username,a.compcode,b.bgpic,b.logo1,b.logo2,b.logo1width from users a,company b where a.username='{$_POST['username']}' and a.password='{$_POST['password']}' and a.compcode='{$_POST['comp']}'";
	$result=mysql_query($myQuery)or die($myQuery."<br/><br/>".mysql_error());
    
	if($row= mysql_fetch_array($result)){
        $_SESSION['groupid']=$row['groupid'];
		$_SESSION['username']=$row['username'];
		$_SESSION['company']=$row['compcode'];
		$_SESSION['bgpic']=$row['bgpic'];
		$_SESSION['logo1']=$row['logo1'];
		$_SESSION['logo2']=$row['logo2'];
		$_SESSION['logo1width']=$row['logo1width'];
		header('Location: index.php');
        
	}else{
		header('Location: login.php#');
	}
    
?>
