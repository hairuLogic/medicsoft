<?php session_start();
	if(!isset($_SESSION['username'])){
		header('Location: http://192.168.0.142/hisdb/index.php?lgn=nt');
	}
?>