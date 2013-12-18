<?
	include_once "../common.php";
	include_once ROOT_PATH."/mod/tasks.php";
	if( !$user->Check() ) exit;
	
	if( !isset($_GET['lid']) || !(int)$_GET['lid'] ) die("<font class='error'>Data send error!</font>");
	else $lid= (int)$_GET['lid'];
	
	$reports = LoadGetReports($lid);
	
	if( $reports ) $smarty->assign('REPORTS', $reports);
		
	$smarty->display('load_reports.tpl');
?>