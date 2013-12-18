<?
	include_once "../common.php";
	include_once ROOT_PATH."/mod/tasks.php";
	if( !$user->Check() ) exit;
	
	if( !isset($_GET['tid']) || !(int)$_GET['tid'] ) die("<font class='error'>Data send error!</font>");
	else $tid= (int)$_GET['tid'];
	
	$smarty->assign('TASK', $tid);
	$bots = TaskGetBotInfo($tid);
	
	if( $bots ) $smarty->assign('BOTS', $bots);
		
	$smarty->display('task_info_sub.tpl');
?>