<?
	include_once "../common.php";
	include_once ROOT_PATH."/mod/tasks.php";
	if( !$user->Check() ) exit;
	
	if( !isset($_GET['ps']) || !isset($_GET['task']) ) die('Data send error!');
	
	$ps = (int)$_GET['ps'];
	$tid = (int)$_GET['task'];
	
	TaskChangeState($tid, $ps);
?>