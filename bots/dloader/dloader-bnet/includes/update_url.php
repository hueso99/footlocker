<?php
if (!@$pageIncluded) chdir('..');

require_once("config.php");
require_once("ln/ln.php");
require_once("includes/mysql.php");

$db=new odbcClass();

require_once("includes/functions.php");

$config["language"] == "ru" ? $l = "ru" : $l = "en";


if (!isset($_GET['url'])) {$_GET['url']='';}
$url=trim($_GET['url'],',');

mysql_query("UPDATE `tasks` SET  `url` = '".$url."' WHERE `id` = ".$_GET['fid'].";");

?>