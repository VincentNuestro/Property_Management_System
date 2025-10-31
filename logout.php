<?php 
	session_start();
	unset($_SESSION['MMS-UserID']);
	unset($_SESSION['MMS-Access']);
	unset($_SESSION['MMS-Designation']);
	header('Location:loginpage.php');
	exit();
?>