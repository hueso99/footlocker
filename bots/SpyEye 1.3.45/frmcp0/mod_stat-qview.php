<?php

require_once 'mod_dbase.php';
require_once 'config.php';

$dbase = @db_open_byname('INFORMATION_SCHEMA');
if (!$dbase) exit;

$sql = ' SELECT SUM(TABLE_ROWS)'
	 . '   FROM TABLES'
	 . " WHERE TABLES.TABLE_SCHEMA = '" . DB_NAME . "'"
	 . "   AND TABLES.TABLE_NAME LIKE 'rep2_%'";
$res = mysqli_query($dbase, $sql);
$cnt = -1;
if ((@($res)) && mysqli_num_rows($res) > 0) {
	list($cnt) = mysqli_fetch_array($res);
}

$sql = ' SELECT TABLE_ROWS'
	 . '   FROM TABLES'
	 . " WHERE TABLES.TABLE_SCHEMA = '" . DB_NAME . "'"
	 . "   AND TABLES.TABLE_NAME LIKE 'rep2_2%'"
	 . " ORDER BY TABLES.CREATE_TIME DESC"
	 . " LIMIT 1";
$res = mysqli_query($dbase, $sql);
$cnt2 = -1;
if ((@($res)) && mysqli_num_rows($res) > 0) {
	list($cnt2) = mysqli_fetch_array($res);
}

$icfg = parse_ini_file('config.ini');
$bugs = $icfg['bugs'];
if (intval($bugs) == 1) {

$sql = ' SELECT TABLE_ROWS'
	 . '   FROM TABLES'
	 . " WHERE TABLES.TABLE_SCHEMA = '" . DB_NAME . "'"
	 . "   AND TABLES.TABLE_NAME LIKE 'exceptions_2%'"
	 . " ORDER BY TABLES.CREATE_TIME DESC"
	 . " LIMIT 1";
$res = mysqli_query($dbase, $sql);
$cnt3 = -1;
if ((@($res)) && mysqli_num_rows($res) > 0) {
	list($cnt3) = mysqli_fetch_array($res);
}

$bugs_cnt = "<br><font style=\"font-size: 9px; color: #b74151;\"><b>+$cnt3</b></font>";
}

$cnt = intval($cnt / 1000);
//$cnt2 = intval($cnt2 / 1000);
echo "<font style=\"font-size: 10px;\"><b>$cnt k</b></font><br><font style=\"font-size: 9px; color: #41b751;\"><b>+$cnt2</b></font>$bugs_cnt";

db_close($dbase);

?>
