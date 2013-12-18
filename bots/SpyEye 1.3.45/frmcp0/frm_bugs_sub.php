<?php

set_time_limit(0);

function cutoff($str) {
	$maxlen = 30;
	$pospostfixlen = 10;
	$postfix = '';
	if (strlen($str) > $maxlen)
		$postfix = ' ... ';
	else
		$maxlen = strlen($str);
	$tmp = substr($str, 0, $maxlen) . $postfix;
	if (strlen($postfix)) {
		$diff = strlen($str) - $maxlen;
		if ($diff < $pospostfixlen)
			$pospostfixlen = $diff;
		$tmp .= substr($str, strlen($str) - $pospostfixlen, $pospostfixlen);
	}
	return $tmp;
}

// ~~~

// ...
$bot_guid = urldecode($_GET['bot_guid']);
if (@$bot_guid && $bot_guid) {
	$sqlp1 = " AND bot_guid LIKE '%$bot_guid%'";
}
// ...
$date = $_GET['dt'];
if (!@$date)
	exit;
// ...
$limit = $_GET['lm'];
if ((@$limit) && $limit) {
	$sqlp0 = " LIMIT $limit";
}
// ...
$ReverseSearch = $_POST['ReverseSearch'];
if( $ReverseSearch ) $sql_add_id_order = " ORDER BY `date_rep` DESC, `id` DESC";
else $sql_add_id_order = " ORDER BY `date_rep` ASC, `id` ASC";
// ...
$ex_code = $_POST['ex_code'];
if ($ex_code) {
	if (substr($ex_code, 0, 2) == "0x")
		$ex_code = substr($ex_code, 2);
	$ex_code = hexdec($ex_code);
	$sqlp2 = " AND ex_code = '$ex_code'";
}
// ...
$os_x64 = $_POST['os_x64'];
if ($os_x64) {
	$sqlp3 = " AND os_x64 = '$os_x64'";
}
// ...
$user_type = $_POST['user_type'];
if ($user_type) {
	$sqlp6 = " AND user_type = '$user_type'";
}
// ...
$app_path = $_POST['app_path'];
if ($app_path) {
	if ( strpos($app_path, '*') !== false ) {
		$app_path = str_replace( '*', '%', $app_path );
	}
	if ($_POST['cb_app_path'])
		$sqlp4 = " AND app_path LIKE '%$app_path%'";
	else
		$sqlp4 = " AND app_path = '$app_path'";
}
// ...
$os_version = $_POST['os_version'];
if ($os_version) {
	if ( strpos($os_version, '*') !== false ) {
		$os_version = str_replace( '*', '%', $os_version );
	}
	if ($_POST['cb_os_version'])
		$sqlp5 = " AND os_version LIKE '%$os_version%'";
	else
		$sqlp5 = " AND os_version = '$os_version'";
}

require_once 'mod_dbase.php';
require_once 'mod_strenc.php';
require_once 'mod_file.php';

include_once 'php/geshi/geshi.php';

$dbase = db_open();



$sql = "SELECT *"
     . "  FROM exceptions_$date"
	 . " WHERE 1 = 1"
	 . $sqlp1
	 . $sqlp2
	 . $sqlp3
	 . $sqlp4
	 . $sqlp5
	 . $sqlp6
	 . $sql_add_id_order
	 . $sqlp0;
$res = mysqli_query($dbase, $sql);
if ((!(@($res)) || !mysqli_num_rows($res))) {
	echo "No bugreports were found";
	exit;
}
$cnt = mysqli_num_rows($res);
echo "<table width='720px' cellspacing='0' cellpadding='3'>\n";
$wdisp = 0;
for ( $i=0; $arr = mysqli_fetch_assoc($res); $i++ ) {

$id 				= $arr['id'];
$bot_guid 			= $arr['bot_guid'];
$bot_version 		= $arr['bot_version'];
$system_proc_arch 	= $arr['system_proc_arch'];
$system_dep 		= $arr['system_dep'];
$system_pae 		= $arr['system_pae'];
$system_proc_cnt 	= $arr['system_proc_cnt'];
$os_version 		= $arr['os_version'];
$os_sp_version 		= $arr['os_sp_version'];
$os_suite_mask 		= $arr['os_suite_mask'];
$os_product_type 	= $arr['os_product_type'];
$os_x64 			= $arr['os_x64'];
$app_path 			= $arr['app_path'];
$app_cname 			= $arr['app_cname'];
$app_pver 			= $arr['app_pver'];
$app_fver 			= $arr['app_fver'];
$user_type 			= $arr['user_type'];
$ex_code 			= $arr['ex_code'];
$ex_method 			= $arr['ex_method'];
$ex_pid 			= $arr['ex_pid'];
$ex_addr 			= $arr['ex_addr'];
$ex_reqaddr 		= $arr['ex_reqaddr'];
$ex_aseh 			= $arr['ex_aseh'];
$reg_eax 			= $arr['reg_eax'];
$reg_ecx 			= $arr['reg_ecx'];
$reg_edx 			= $arr['reg_edx'];
$reg_ebx 			= $arr['reg_ebx'];
$reg_esi 			= $arr['reg_esi'];
$reg_edi 			= $arr['reg_edi'];
$reg_ebp 			= $arr['reg_ebp'];
$reg_esp 			= $arr['reg_esp'];
$ticks 				= $arr['ticks'];
$stack_0 			= $arr['stack_0'];
$stack_0_desc 		= $arr['stack_0_desc'];
$stack_1 			= $arr['stack_1'];
$stack_1_desc 		= $arr['stack_1_desc'];
$stack_2 			= $arr['stack_2'];
$stack_2_desc 		= $arr['stack_2_desc'];
$stack_3 			= $arr['stack_3'];
$stack_3_desc 		= $arr['stack_3_desc'];
$stack_4			= $arr['stack_4'];
$stack_4_desc 		= $arr['stack_4_desc'];
$stack_5 			= $arr['stack_5'];
$stack_5_desc 		= $arr['stack_5_desc'];
$stack_6 			= $arr['stack_6'];
$stack_6_desc 		= $arr['stack_6_desc'];
$stack_7 			= $arr['stack_7'];
$stack_7_desc 		= $arr['stack_7_desc'];
$stack_8 			= $arr['stack_8'];
$stack_8_desc 		= $arr['stack_8_desc'];
$stack_9 			= $arr['stack_9'];
$stack_9_desc 		= $arr['stack_9_desc'];
$stack_10 			= $arr['stack_10'];
$stack_10_desc 		= $arr['stack_10_desc'];
$stack_11 			= $arr['stack_11'];
$stack_11_desc 		= $arr['stack_11_desc'];
$stack_12 			= $arr['stack_12'];
$stack_12_desc 		= $arr['stack_12_desc'];
$stack_13 			= $arr['stack_13'];
$stack_13_desc 		= $arr['stack_13_desc'];
$stack_14 			= $arr['stack_14'];
$stack_14_desc 		= $arr['stack_14_desc'];
$stack_15 			= $arr['stack_15'];
$stack_15_desc 		= $arr['stack_15_desc'];
$stack_16 			= $arr['stack_16'];
$stack_16_desc 		= $arr['stack_16_desc'];
$stack_17 			= $arr['stack_17'];
$stack_17_desc 		= $arr['stack_17_desc'];
$stack_18 			= $arr['stack_18'];
$stack_18_desc 		= $arr['stack_18_desc'];
$stack_19 			= $arr['stack_19'];
$stack_19_desc 		= $arr['stack_19_desc'];
$bot_base_addr 		= $arr['bot_base_addr'];
$cmodule_name 		= $arr['cmodule_name'];
$disasm 			= $arr['disasm'];
$date_rep			= $arr['date_rep'];

echo "<table width='730' border='1' cellspacing='0' cellpadding='2' style='border: 1px solid #BBBBBB; font-size: 9px; border-collapse: collapse; background-color: #FFFFFF;'>";

echo "<tr>\n";

echo "<td valign='top' align='center' width='480px'>\n";

echo "<table width='100%' border='1' cellspacing='0' cellpadding='2' style='border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: #FFFFFF;'>";
echo "<th colspan='2' style='background-color: #666666; color: #FFFFFF'>!nfa</th>";
echo "<tr>";
echo "<td align='right' width='100px'><b>num</b></td>";
echo "<td align='left'>" . $i. "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>id</b></td>";
echo "<td align='left'>" . $id . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>date_rep</b></td>";
echo "<td align='left'>" . $date_rep . "</td>";
echo "</tr>";
echo "<tr>";
echo "</table>";

echo "<table width='100%' border='1' cellspacing='0' cellpadding='2' style='border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: #FFFFFF;'>";
echo "<th colspan='2' style='background-color: #666666; color: #FFFFFF'>exception</th>";
echo "<tr>";
echo "<td align='right' width='100px'><b>ex_code</b></td>";
echo "<td align='left'>" . "0x" . strtoupper(base_convert($ex_code, 10, 16)) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>ex_method</b></td>";
echo "<td align='left'>" . "0x" . strtoupper(base_convert($ex_method, 10, 16)) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>ex_pid</b></td>";
echo "<td align='left'>" . "0x" . strtoupper(base_convert($ex_pid, 10, 16)) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>ex_addr</b></td>";
echo "<td align='left'>" . "0x" . strtoupper(base_convert($ex_addr, 10, 16)) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>ex_reqaddr</b></td>";
echo "<td align='left'>" . "0x" . strtoupper(base_convert($ex_reqaddr, 10, 16)) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>ex_aseh</b></td>";
echo "<td align='left'>" . "0x" . strtoupper(base_convert($ex_aseh, 10, 16)) . "</td>";
echo "</tr>";
echo "</table>";

echo "<table width='100%' border='1' cellspacing='0' cellpadding='2' style='border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: #FFFFFF;'>";
echo "<th colspan='2' style='background-color: #666666; color: #FFFFFF'>bot</th>";
echo "<tr>";
echo "<td align='right' width='100px'><b>bot_guid</b></td>";
echo "<td align='left'>" . $bot_guid . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>bot_version</b></td>";
echo "<td align='left'>" . $bot_version . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>current_base</b></td>";
echo "<td align='left'>" . "0x" . strtoupper(base_convert($bot_base_addr, 10, 16)) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>ticks</b></td>";
$hour = intval($ticks / (60 * 60 * 1000));
$msech = intval($hour * (60 * 60 * 1000));
$min = intval(($ticks - $msech) / (60 * 1000));
$msecm = intval($msech + ($min * (60 * 1000)));
$sec = intval(($ticks - $msecm) / 1000);
echo "<td align='left'>$hour:$min:$sec</td>";
echo "</tr>";
echo "</table>";

echo "<table width='100%' border='1' cellspacing='0' cellpadding='2' style='border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: #FFFFFF;'>";
echo "<th colspan='2' style='background-color: #666666; color: #FFFFFF'>system</th>";
echo "<tr>";
echo "<td align='right' width='100px'><b>system_proc_arch</b></td>";
echo "<td align='left'>" . $system_proc_arch . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>system_dep</b></td>";
echo "<td align='left'>" . intval($system_dep) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>system_pae</b></td>";
echo "<td align='left'>" . intval($system_pae) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>system_proc_cnt</b></td>";
echo "<td align='left'>" . $system_proc_cnt . "</td>";
echo "</tr>";
echo "</table>";

echo "<table width='100%' border='1' cellspacing='0' cellpadding='2' style='border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: #FFFFFF;'>";
echo "<th colspan='2' style='background-color: #666666; color: #FFFFFF'>os</th>";
echo "<tr>";
echo "<td align='right' width='100px'><b>os_version</b></td>";
echo "<td align='left'>" . $os_version . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>os_sp_version</b></td>";
echo "<td align='left'>" . $os_sp_version . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>os_suite_mask</b></td>";
echo "<td align='left'>" . $os_suite_mask . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>os_product_type</b></td>";
echo "<td align='left'>" . $os_product_type . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>os_x64</b></td>";
echo "<td align='left'>" . intval($os_x64) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>user_type</b></td>";
echo "<td align='left'>" . $user_type . "</td>";
echo "</tr>";
echo "</table>";

echo "<table width='100%' border='1' cellspacing='0' cellpadding='2' style='border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: #FFFFFF;'>";
echo "<th colspan='2' style='background-color: #666666; color: #FFFFFF'>app</th>";
echo "<tr>";
echo "<td align='right' width='100px'><b>app_path</b></td>";
echo "<td align='left'>" . $app_path . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>app_cname</b></td>";
echo "<td align='left'>" . ucs2html($app_cname) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>app_pname</b></td>";
echo "<td align='left'>" . ucs2html($app_pname) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>app_pver</b></td>";
echo "<td align='left'>" . $app_pver . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>app_fver</b></td>";
echo "<td align='left'>" . $app_fver . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>cmodule_name</b></td>";
echo "<td align='left' title='{$cmodule_name}'>" . cutoff($cmodule_name) . "</td>";
echo "</tr>";
echo "</table>";

echo "<table width='100%' border='1' cellspacing='0' cellpadding='2' style='border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: #FFFFFF;'>";
echo "<th colspan='2' style='background-color: #666666; color: #FFFFFF'>registers</th>";
echo "<tr>";
echo "<td align='right' width='100px'><b>reg_eax</b></td>";
echo "<td align='left'>" . "0x" . strtoupper(base_convert($reg_eax, 10, 16))  . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>reg_ecx</b></td>";
echo "<td align='left'>" . "0x" . strtoupper(base_convert($reg_ecx, 10, 16))  . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>reg_edx</b></td>";
echo "<td align='left'>" . "0x" . strtoupper(base_convert($reg_edx, 10, 16))  . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>reg_ebx</b></td>";
echo "<td align='left'>" . "0x" . strtoupper(base_convert($reg_ebx, 10, 16))  . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>reg_esi</b></td>";
echo "<td align='left'>" . "0x" . strtoupper(base_convert($reg_esi, 10, 16))  . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>reg_edi</b></td>";
echo "<td align='left'>" . "0x" . strtoupper(base_convert($reg_edi, 10, 16))  . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>reg_ebp</b></td>";
echo "<td align='left'>" . "0x" . strtoupper(base_convert($reg_ebp, 10, 16))  . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>reg_esp</b></td>";
echo "<td align='left'>" . "0x" . strtoupper(base_convert($reg_esp, 10, 16))  . "</td>";
echo "</tr>";
echo "</table>";

echo "<table width='100%' border='1' cellspacing='0' cellpadding='2' style='border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: #FFFFFF;'>";
echo "<th colspan='2' style='background-color: #666666; color: #FFFFFF'>stack</th>";
echo "<tr>";
echo "<td align='right' width='100px'><b>" . "0x" . strtoupper(base_convert($stack_0, 10, 16)) . "</b></td>";
echo "<td align='left' title='{$stack_0_desc}'>" . cutoff($stack_0_desc) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>" . "0x" . strtoupper(base_convert($stack_1, 10, 16)) . "</b></td>";
echo "<td align='left' title='{$stack_1_desc}'>" . cutoff($stack_1_desc) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>" . "0x" . strtoupper(base_convert($stack_2, 10, 16)) . "</b></td>";
echo "<td align='left' title='{$stack_2_desc}'>" . cutoff($stack_2_desc) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>" . "0x" . strtoupper(base_convert($stack_3, 10, 16)) . "</b></td>";
echo "<td align='left' title='{$stack_3_desc}'>" . cutoff($stack_3_desc) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>" . "0x" . strtoupper(base_convert($stack_4, 10, 16)) . "</b></td>";
echo "<td align='left' title='{$stack_4_desc}'>" . cutoff($stack_4_desc ). "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>" . "0x" . strtoupper(base_convert($stack_5, 10, 16)) . "</b></td>";
echo "<td align='left' title='{$stack_5_desc}'>" . cutoff($stack_5_desc) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>" . "0x" . strtoupper(base_convert($stack_6, 10, 16)) . "</b></td>";
echo "<td align='left' title='{$stack_6_desc}'>" . cutoff($stack_6_desc) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>" . "0x" . strtoupper(base_convert($stack_7, 10, 16)) . "</b></td>";
echo "<td align='left' title='{$stack_7_desc}'>" . cutoff($stack_7_desc) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>" . "0x" . strtoupper(base_convert($stack_8, 10, 16)) . "</b></td>";
echo "<td align='left' title='{$stack_8_desc}'>" . cutoff($stack_8_desc) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>" . "0x" . strtoupper(base_convert($stack_9, 10, 16)) . "</b></td>";
echo "<td align='left' title='{$stack_9_desc}'>" . cutoff($stack_9_desc ). "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>" . "0x" . strtoupper(base_convert($stack_10, 10, 16)) . "</b></td>";
echo "<td align='left' title='{$stack_10_desc}'>" . cutoff($stack_10_desc) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>" . "0x" . strtoupper(base_convert($stack_11, 10, 16)) . "</b></td>";
echo "<td align='left' title='{$stack_11_desc}'>" . cutoff($stack_11_desc) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>" . "0x" . strtoupper(base_convert($stack_12, 10, 16)) . "</b></td>";
echo "<td align='left' title='{$stack_12_desc}'>" . cutoff($stack_12_desc) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>" . "0x" . strtoupper(base_convert($stack_13, 10, 16)) . "</b></td>";
echo "<td align='left' title='{$stack_13_desc}'>" . cutoff($stack_13_desc) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>" . "0x" . strtoupper(base_convert($stack_14, 10, 16)) . "</b></td>";
echo "<td align='left' title='{$stack_14_desc}'>" . cutoff($stack_14_desc ). "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>" . "0x" . strtoupper(base_convert($stack_15, 10, 16)) . "</b></td>";
echo "<td align='left' title='{$stack_15_desc}'>" . cutoff($stack_15_desc) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>" . "0x" . strtoupper(base_convert($stack_16, 10, 16)) . "</b></td>";
echo "<td align='left' title='{$stack_16_desc}'>" . cutoff($stack_16_desc) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>" . "0x" . strtoupper(base_convert($stack_17, 10, 16)) . "</b></td>";
echo "<td align='left' title='{$stack_17_desc}'>" . cutoff($stack_17_desc) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>" . "0x" . strtoupper(base_convert($stack_18, 10, 16)) . "</b></td>";
echo "<td align='left' title='{$stack_18_desc}'>" . cutoff($stack_18_desc) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='right' width='100px'><b>" . "0x" . strtoupper(base_convert($stack_19, 10, 16)) . "</b></td>";
echo "<td align='left' title='{$stack_19_desc}'>" . cutoff($stack_19_desc ). "</td>";
echo "</tr>";
echo "</table>";

echo "<td valign='top' align='center' width='430px'>";

$geshi = new GeSHi($disasm, 'asm');
echo "<table width='100%' border='1' cellspacing='0' cellpadding='2' style='border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: #FFFFFF;'>";
echo "<th style='background-color: #666666; color: #FFFFFF'>disasm</th>";
echo "<tr>";
echo "<td style='font-size: 11px;'>";
if (strpos($disasm, '[ERROR]') === false) {
	echo $geshi->parse_code();
}
else
	echo $disasm;
echo "</td>";
echo "</tr>";
echo "</table>";

echo "</td>\n";

echo "</tr>\n";
echo "</table>\n";

echo "<hr size=\"1\" color=\"#cccccc\">";

}
echo "</table>\n";

db_close($dbase);

?>