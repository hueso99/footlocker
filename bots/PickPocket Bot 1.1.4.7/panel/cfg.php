<?php
include('config.php');
$host    = $dbhost;
$db_name = $dbname;		
$db_user = $dbuser;		
$db_pass = $dbpass;			
$db_table= "tblcountry";	
$db_column = "name";

 $conn = mysql_connect($host,$db_user,$db_pass)or die(mysql_error());
         mysql_select_db($db_name,$conn)or die(mysql_error());

?>