<?php
include('config.php');
$ip=$_GET['ip'];
$uid=$_GET['uid'];
$contry=$_GET['contry'];


mysql_query("DELETE FROM `$dbname`.`rdp` WHERE `rdp`.`IP` = '$ip' AND `rdp`.`uid` = '$uid' LIMIT 1;");

 mysql_close($connect);
 ?>