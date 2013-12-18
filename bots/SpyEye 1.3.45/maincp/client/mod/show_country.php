<?
	include_once "../common.php";
	include_once ROOT_PATH."/mod/geo.php";		
	if( !$user->Check() ) exit;
	
	$res = $db->query("SELECT count(*) FROM country_t");
	$mres = $res->fetch_array();
	$num = ceil($mres[0]/3);
	
	$RES = Array();
	for ($i=0; $i<3; $i++) 
	{
		$start = $i*$num;
		$res = $db->query("SELECT * FROM country_t ORDER BY name_country limit $start, $num");
		$ELEM = Array();
		while ($mres = $res->fetch_array()) 
		{
			$ccode = 'null';
			$ccode = CountryCode($mres['name_country']);
			
			$ELEM[] = array('ID_COUNTRY'=>$mres['id_country'], 'CCODE'=>$ccode, 'NAME_COUNTRY'=>$mres['name_country']);
		}
		$RES[] = $ELEM;
	}
	$smarty->assign('CONT_ARR', $RES);
	if ($all_country) $smarty->assign('ICCHECK','checked');
	
#	$smarty->display('show_country.tpl');
?>