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

<div class="content"><h3 style="color:red;">We have error: {errorCode}</h3></div>