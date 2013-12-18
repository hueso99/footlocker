<?
	include_once "../common.php";
	include_once ROOT_PATH."/mod/functs.php";
	if( !$user->Check() ) exit;

	if( !isset($_GET['log']) ) 
	{
		$smarty->display('view_logs.tpl');
		die();
	}
	else $type = $_GET['log'];
	if( !strlen($type) ) die();
	
	$logs = GetLogs($type[0]);
	
	$RESULT = array();
	if( count($logs) ) 
	{
		foreach($logs as $v) $RESULT[] = $v['logData'];
		$smarty->assign('CONTARR', $RESULT);
	}
	$smarty->display('show_log.tpl');	
?>