<?
	include_once "../common.php";
	include_once ROOT_PATH."/mod/functs.php";
	
	refresh_bot_info();
	
	$date = getDbTime();
	if (!$date) die( "<font class='error'>ERROR</font> : cannot get time" );

	$YEAR = gmdate('Y', $date);
	$MONTH = gmdate('m', $date);
	$DAY = gmdate('d', $date);
	$TIME = gmdate('H:i:s', $date);
	
	
	echo "<b>$YEAR<br>$MONTH/$DAY<br>$TIME</b>";
	
	
	$sql = 'SELECT COUNT(id_bot) FROM bots_t WHERE status_bot <> \'offline\'';
	$res =  $db->query($sql);
	$cnt = -1;
	if ((@($res)) && $db->affected_rows > 0) list($cnt) = $res->fetch_array();

	$sql = 'SELECT COUNT(id_bot) FROM bots_t';
	$res =  $db->query($sql);
	$cnt2 = -1;
	if ((@($res)) && $db->affected_rows > 0) list($cnt2) = $res->fetch_array();

	echo "<script>$('#bot_info').html('<b>$cnt<br>$cnt2</b>');</script>"; // 
?>