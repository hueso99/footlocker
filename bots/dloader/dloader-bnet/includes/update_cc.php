<?php
if (!@$pageIncluded) chdir('..');

require_once("config.php");
require_once("ln/ln.php");
require_once("includes/mysql.php");

$db=new odbcClass();

require_once("includes/functions.php");

$config["language"] == "ru" ? $l = "ru" : $l = "en";


if (!isset($_GET['cc'])) {$_GET['cc']='all';}
$cc=explode(',',trim($_GET['cc'],','));

$db->query("DELETE FROM `ccTaskFilter` WHERE `taskId` = ".$_GET['fid'].";");

foreach($cc as $v) {
	$db->query("INSERT `ccTaskFilter` (`taskId` , `cc`) VALUES ('".$_GET['fid']."','".$v."');");
}


?>