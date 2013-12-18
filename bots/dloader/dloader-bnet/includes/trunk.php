<?php
if (!@$pageIncluded) { 
	header ("Content-type: text/html; charset=utf-8");
	chdir('..');
}


require_once("config.php");
require_once("includes/mysql.php");

$db=new odbcClass();

if (isset($_GET['t']) && $_GET['t']=='all') {
	$ids=$db->query("SELECT taskId FROM `ccTaskFilter` LEFT JOIN tasks ON ccTaskFilter.taskId = tasks.id WHERE tasks.stop != '-1'");
	if ($ids[0]!=0) {
		foreach($ids as $v) {
			$db->query("DELETE FROM `ccTaskFilter` WHERE taskId = ".$v['taskId'].";");
		}
	}
	$db->query("DELETE FROM `tasks` WHERE stop != '-1';");
	$db->query("TRUNCATE TABLE `finished`");
	$db->query("TRUNCATE TABLE `bots`");
	$db->query("TRUNCATE TABLE `gscounter`");
	$db->query("UPDATE  `tasks` SET  `count` =  '0'");
} elseif (isset($_GET['t']) && $_GET['t']=='stat') {
	$db->query("TRUNCATE TABLE `finished`");
	$db->query("TRUNCATE TABLE `bots`");
	$db->query("TRUNCATE TABLE `gscounter`");
	$db->query("UPDATE `tasks` SET  `count` = '0'");
} else { exit('no t in GET'); }

echo "ok";
?>