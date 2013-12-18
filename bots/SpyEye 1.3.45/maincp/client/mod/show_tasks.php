<?
	include_once "../common.php";
	include_once ROOT_PATH."/mod/tasks.php";
	if( !$user->Check() ) exit;

	$tasks = GetTasks();
	if($tasks) $smarty->assign('TASKS', $tasks);
	$smarty->display('show_tasks.tpl');
?>