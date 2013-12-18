<?
	include_once "../common.php";
	if( !$user->Check() ) exit;

	$sql = "SELECT fName FROM files_t WHERE fName NOT LIKE 'config.bin%' ORDER BY fId DESC";
	$res = $db->query($sql);
	if (@$res && $db->affected_rows)
	{
		$dbpath = array();
		while(list($item) = $res->fetch_row()) $dbpath[] = $item;
		$smarty->assign('DBPATH', $dbpath);
	}
	$smarty->display('virtest.tpl');	
?>