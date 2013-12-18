<?php 
// Start MySQL Connection Information

error_reporting(0);

// MySQL Server IP - Default: 'localhost'
$server = 'localhost';
// MySQL Server Username - Default: 'root'
$user = 'root';
// MySQL Server Password - Default: 'root'
$pass = '';
// MySQL Server Database Name - Default: 'database'
$db = 'boatnet';

// End MySQL Connection Information

// Start Web Panel Login Information

// Web Panel Username - Default: 'admin'
$correctuser = "admin";
// Web Panel Password - Default: 'password'
$correctpass = "password";

// End Web Panel Login Information

// DO NOT EDIT BELOW THIS LINE
mysql_connect($server, $user, $pass);
mysql_select_db($db);
?>