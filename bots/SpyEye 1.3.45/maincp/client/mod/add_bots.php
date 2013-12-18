<?
	include_once "../common.php";
	if( !$user->Check() ) exit;

	$smarty->display('add_bots.tpl')
?>