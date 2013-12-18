<?php
include("config.php");
include("geoip.inc");
$gi = geoip_open("GeoIP.dat",GEOIP_STANDARD);
$country_name = geoip_country_name_by_addr($gi,$_SERVER['REMOTE_ADDR']);
geoip_close($gi);
$uid=$_GET['uid'];

session_start();
$session=session_id();
$time=time();
$time_check=$time-1500; //SET TIME 10 Minute
$ip=$_SERVER['REMOTE_ADDR'];

$host=$dbhost; // Host name
$username=$dbuser; // Mysql username
$password=$dbpass; // Mysql password
$db_name=$dbname; // Database name
$tbl_name="bot_online"; // Table name

// Connect to server and select databse
mysql_connect("$host", "$username","$password")or die("cannot connect to server");
mysql_select_db("$db_name")or die("cannot select DB");

$sql="SELECT * FROM $tbl_name WHERE session='$session'";
$result=mysql_query($sql);

$count=mysql_num_rows($result);

if($count=="0"){
$sql1="INSERT INTO $tbl_name(session, time, contry, ip, uid)VALUES('$session', '$time', '$country_name', '$ip', '$uid')";
$result1=mysql_query($sql1);
}
else {$sql2="UPDATE $tbl_name SET time='$time' WHERE session = '$session'";
$result2=mysql_query($sql2);
}

$sql3="SELECT * FROM $tbl_name";
$result3=mysql_query($sql3);

$count_user_online=mysql_num_rows($result3);

//echo "User online : $count_user_online ";

// if over 10 minute, delete session 
$sql4="DELETE FROM $tbl_name WHERE time<$time_check";
$result4=mysql_query($sql4);

mysql_close();

// Open multiplebrowser page for result
?>