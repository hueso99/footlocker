<?php
//////... DataBase ...////// 
$dbhost ='localhost';
$dbname='pickpocket';
$dbuser='root';
$dbpass='';

//////... Admin ...//////
$username="admin";
$password="pass";

//\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
$connect = mysql_connect($dbhost, $dbuser, $dbpass) or die("Cannot connect to db!");
mysql_select_db($dbname, $connect) or die("Cannot select db!");
?>
