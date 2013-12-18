<?php
if (!@$pageIncluded) { 
	header ("Content-type: text/html; charset=utf-8");
	chdir('..');
}


require_once("config.php");
require_once("ln/ln.php");
require_once("includes/mysql.php");

$db=new odbcClass();

require_once("includes/functions.php");

$config["language"] == "ru" ? $l = "ru" : $l = "en";

?>
<div style="text-align:center;font-weight:bold;">
	<span style="color:blue;text-decoration:underline;cursor:pointer;" onClick="trunk();">TRUNCATE DB</span><br><br>
	<span style="color:blue;text-decoration:underline;cursor:pointer;" onClick="trunkStat();">TRUNCATE STAT ONLY</span>
</div>