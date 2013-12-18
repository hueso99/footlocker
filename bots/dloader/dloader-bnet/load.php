<?php

require_once("config.php");
require_once("includes/mysql.php");

$db = new odbcClass();

require_once("includes/functions.php");

if(isset($_GET["module"]) && $_GET["module"] == "grabbers") {
	$db -> query("INSERT INTO `gscounter` (`option`, `value`) VALUES ('grabbers', '1') ON DUPLICATE KEY UPDATE value = value + 1;");
	download_file(GRABBERS_PATH);
}

if(isset($_GET["module"]) && $_GET["module"] == "sniffers") {
	$db -> query("INSERT INTO `gscounter` (`option`, `value`) VALUES ('sniffers', '1') ON DUPLICATE KEY UPDATE value = value + 1;");
	download_file(SNIFFERS_PATH);
}

?>