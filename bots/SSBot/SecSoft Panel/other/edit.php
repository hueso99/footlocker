<?php session_start(); require_once('../inc/session.php'); require_once('../inc/config.php'); require_once('safe.php'); ?>

<?php
if(!$_SESSION['admin']){
	echo 'Keine Berechtigung!';
	exit();
}

if($_POST['token'] !== $_SESSION['token2']){
    echo 'Token falsch';
	exit();
}else{
	$id		= $_POST['id'];
	$user_e = $_POST['user_e'];
	$user_r = $_POST['user_r'];
	$user_a = $_POST['user_a'];
	
	mysql_query("UPDATE users Set user = '$user_e',rechte = '$user_r', admin = '$user_a' WHERE id = '$id'");
	
	echo 'Bitte warten... <meta http-equiv="refresh" content="2; URL=../benutzer.php">';
}
?>	