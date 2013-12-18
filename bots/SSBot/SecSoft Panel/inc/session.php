<?php
	session_start(); 
	
    if(!$_SESSION['seclogin']) {
    	header('Location: login.php'); exit();
    }
?>