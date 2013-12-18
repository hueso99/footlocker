<?php
if (!@$pageIncluded) chdir('..');

require_once("config.php");
require_once("ln/ln.php");
require_once("includes/mysql.php");

$db=new odbcClass();

require_once("includes/functions.php");

$config["language"] == "ru" ? $l = "ru" : $l = "en";


if (!isset($_GET['fid'])) {$_GET['fid']='';}
$fid=$_GET['fid'];

$v=$db->query("SELECT * FROM `tasks` WHERE `id` = '".$fid."'");

if ($v[0]==0) exit('-1');

if ($v[0]['stop']=='0') {
	$db->query("UPDATE `tasks` SET  `stop` = '1' WHERE `id` = ".$fid.";");
	exit("1");
} else {
	$db->query("UPDATE `tasks` SET  `stop` = '0' WHERE `id` = ".$fid.";");
	exit("0");
}

?>