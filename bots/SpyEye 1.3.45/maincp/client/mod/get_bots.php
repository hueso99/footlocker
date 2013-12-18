<?
	include_once "../common.php";
	include_once ROOT_PATH."/mod/geo.php";
	include_once ROOT_PATH."/mod/functs.php";
	if( !$user->Check() ) exit;
	
	if( isset($_GET['task']) ) $smarty->assign('TASK', (int)$_GET['task']);
	
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
	$smarty->assign('CONT_ARR', $RES2);
	if( $vers = GetBotVers() ) $smarty->assign('VERS', $vers);
	$smarty->display('get_bots.tpl');
?>
