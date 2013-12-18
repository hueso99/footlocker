
<?php
include('config.php');
$ip=$_SERVER['REMOTE_ADDR'];
$uid=$_GET['uid'];
$contry=$_GET['contry'];
$port=":21";

mysql_query("INSERT INTO ftp (ip, uid, contry)
VALUES ('$ip$port', '$uid', '$contry')");

 mysql_close($connect);
 ?>