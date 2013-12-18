<?php
	define('IN_BNCP', true);
## ROOT DIR	
	$root_path = str_replace("\\", "/", getcwd());
	$root_path = substr($root_path, 0, strrpos($root_path, '/'));

	define('ROOT_PATH', $root_path);
	
	if( file_exists(ROOT_PATH."/gate.php") )
	{
		include_once "head.html";
		die("<center><div id='content'><font class='error'>gate.php exists!</font> Plz, delete his before installing!</div>");
	}
?>