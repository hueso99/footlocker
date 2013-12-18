<?php
include('config.php');
$ip=$_GET['uid'];
$port=$_GET['to'];


mysql_query("INSERT INTO socks5 (uid, to)
VALUES ('$uid', '$to')");

 mysql_close($connect);
 ?>