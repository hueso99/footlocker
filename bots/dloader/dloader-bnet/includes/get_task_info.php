<?php
if (!@$pageIncluded) chdir('..');

require_once("config.php");
require_once("ln/ln.php");
require_once("includes/mysql.php");

$db=new odbcClass();

require_once("includes/functions.php");

$config["language"] == "ru" ? $l = "ru" : $l = "en";

if (!isset($_GET['fid'])) die();
$v=$db->query("SELECT * FROM ccTaskFilter WHERE `taskId` = '".$_GET['fid']."'") or die(mysql_errno().' '.mysql_error().' in '.__LINE__);

foreach($v as $r) {
	$out[]=$r['cc'];
}

echo implode(",",$out);

?>