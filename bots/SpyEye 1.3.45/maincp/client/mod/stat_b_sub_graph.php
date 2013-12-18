<?
	include_once "../common.php";
	include_once ROOT_PATH.'/plugins/ofc/php-ofc-library/open_flash_chart_object.php';

	if( !$user->Check() ) exit;

	$tid = (int)$_GET['tid'];
	if (!@$tid) exit;

	$sql = "SELECT UNIX_TIMESTAMP( CONVERT_TZ(tskDate,@@time_zone,'+0:00')) FROM tasks_t WHERE tskId = '$tid'"; 
	$res = $db->query($sql);

	if( $db->affected_rows && is_object($res) )
	{
		list($date) = $res->fetch_array();
		$create_date = gmdate("m/d/y H:i", $date);
		$smarty->assign('CREATE_DATE', $create_date);
	}
	$smarty->assign('TID',  $tid);
	$smarty->display('stat_b_sub_graph.tpl');
?>

		<?php open_flash_chart_object( 300, 300, './mod/stat_graph.php?by=os&status=good&tid='.$tid, true, 'plugins/ofc/');?>
</td><td align='center' width="50%">
		<?php open_flash_chart_object( 300, 300, './mod/stat_graph.php?by=os&status=fail&tid='.$tid, true, 'plugins/ofc/');?></td>
		
</tr><tr><td colspan="2" align='center'><h2><b>Statistic by Countries</b></h2></td></tr><tr><td align='center' width="50%">

		<?php open_flash_chart_object( 300, 300, './mod/stat_graph.php?by=country&status=good&tid='.$tid, true, 'plugins/ofc/');?>
</td><td align='center' width="50%">
		<?php open_flash_chart_object( 300, 300, './mod/stat_graph.php?by=country&status=fail&tid='.$tid, true, 'plugins/ofc/');?></td>
</tr></table>

