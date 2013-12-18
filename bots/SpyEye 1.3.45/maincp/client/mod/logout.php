<?
	include_once "../common.php";
	session_start();
	$_SESSION = Array();
	
	$smarty->display('enter.tpl');
?>
