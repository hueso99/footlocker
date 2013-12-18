<?
	define('INSTALLER', 1);
	include_once "../common.php";

	$smarty->assign('DIR', '../');	
	if( file_exists(ROOT_PATH."/config.php") ) 
	{
		$smarty->display("header.tpl");
		die("<center><div id='content'><font class='error'>ERROR : Delete config.php before installing!</font></div>");
	}
	
	$smarty->assign('ROOT_PATH', $root_path);
	$smarty->display('install.tpl');
?>