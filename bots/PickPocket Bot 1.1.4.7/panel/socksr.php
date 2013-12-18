<?php
include('config.php');
$ip=$_GET['ip'];
$uid=$_GET['uid'];
$contry=$_GET['contry'];


mysql_query("DELETE FROM `$dbname`.`socks5` WHERE `socks5`.`IP` = '$ip' AND `socks5`.`uid` = '$uid' LIMIT 1;");

 mysql_close($connect);
 ?>