<?php
	define('IN_BNCP', true);
	session_start();
	
	if( !defined('INSTALLER') ) 
	{
		@include_once "config.php";
		if( !isset($root_path) ) 
		{
			include_once "templates/head.tpl";
			die("<center><div id='content'><font class='error'>System corrupted</font>. Plz reinstall!</div>");
		}
	}
	
## ROOT DIR	
	if( !isset($root_path) ) $root_path = str_replace("\\", "/", getcwd());
	if( defined('INSTALLER') ) $root_path = substr($root_path, 0, strrpos($root_path, '/'));
	$pos = strlen($root_path)-1;
	if( $root_path[$pos] === '/' ) $root_path = substr($root_path, 0, $pos);	
	define('ROOT_PATH', $root_path);	

## SMARTY 
	$smarty_path = ROOT_PATH."/smarty";
	define('SMARTY_PATH', $smarty_path);
	ini_set("include_path", ini_get("include_path").";".$smarty_path);
	require_once SMARTY_PATH."/smarty.class.php"; 
	
	$smarty = new Smarty();
	$smarty->template_dir = ROOT_PATH."/templates";
	$smarty->compile_dir = SMARTY_PATH."/templates_c";
	$smarty->config_dir = SMARTY_PATH."/configs";
	$smarty->cache_dir = SMARTY_PATH."/cache";
	
	if( !defined('INSTALLER') && !defined('CONF_FAIL') )
	{
		include_once ROOT_PATH."/mod/db.php";
		include_once ROOT_PATH."/mod/users.php";
		
		$db = new DB();
		$user = new user();
	}
?>