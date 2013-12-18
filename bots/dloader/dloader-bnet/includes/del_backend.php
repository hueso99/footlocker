<?php
if (!@$pageIncluded) chdir('..');

require_once("config.php");
require_once("ln/ln.php");
require_once("includes/mysql.php");

$db=new odbcClass();

require_once("includes/functions.php");

$config["language"] == "ru" ? $l = "ru" : $l = "en";


$db->query("DELETE FROM `tasks` WHERE `id` = '".$_GET['id']."'");
$db->query("DELETE FROM `finished` WHERE `taskId` = '".$_GET['id']."'");
$db->query("DELETE FROM `ccTaskFilter` WHERE `taskId` = '".$_GET['id']."'");

?>