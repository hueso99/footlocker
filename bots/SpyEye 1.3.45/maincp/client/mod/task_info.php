<?
	include_once "../common.php";
	include_once ROOT_PATH."/mod/tasks.php";
	if( !$user->Check() ) exit;
	
	if( !isset($_GET['tid']) || !(int)$_GET['tid'] ) die("<font class='error'>Data send error!</font>");
	else $tid= (int)$_GET['tid'];
	
	$task = GetTask($tid);
	$bots = TaskGetBotCount($tid);
	$updated = TaskGetBotCount($tid, 3);
	$failed = TaskGetBotCount($tid, 2);
	
	$task['bots_count'] = $bots;
	$task['COMPLETE'] = $updated/($bots+0.00001);
	$task['FAILED'] = $failed/($bots+0.00001);
	$task['oknum'] = $updated;
	$task['errnum'] = $failed;
		
	if($task) $smarty->assign('TASK', $task);
		
	$smarty->display('task_info.tpl');
?>