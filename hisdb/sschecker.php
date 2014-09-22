<?php session_start();
	if(!isset($_SESSION['username'])){
		header('Location: http://localhost/hisdb/login.php?lgn=nt');
	}
?>