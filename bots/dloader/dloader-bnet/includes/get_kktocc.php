<?php
header('Content-Type: text/html; charset=utf-8');

if (!@$pageIncluded) chdir('..');

require_once("config.php");
require_once("ln/ln.php");
require_once("includes/mysql.php");

$db=new odbcClass();

require_once("includes/functions.php");

$config["language"] == "ru" ? $l = "ru" : $l = "en";



if (!function_exists('geoip_country_name_by_name')) include('includes/geoip.php');
$gip = new GeoIP;
$line=explode(',',strtoupper($_GET['line']));
$cc = Array();
foreach($line as $lk=>$lcc) {
	if (isset($gip->GEOIP_COUNTRY_CODE_TO_NUMBER[trim($lcc)])) $cc[]=$gip->GEOIP_COUNTRY_CODE_TO_NUMBER[trim($lcc)];
}
if (isset($cc))	{ echo implode(",",$cc); } else { echo 0; }
?>