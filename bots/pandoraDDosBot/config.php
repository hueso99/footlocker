<?php
	error_reporting(0);
	$dbhost1="localhost";

	/* User database */
	$dbuname1="aaa";

	/* Database Name */
	$dbname1="aaa";

	/* Password Database */
	$dbpass1="aaa";

	/* GET Login */
	$GET_login="vfvfyz";

	/* Login */
	$login="admin";

	/* Password */
	$password="rjnzhf13";

	/* Interval default (sec) */
	$timeout=60;
	if ($sokol=="1") {
		$ip=$_SERVER['REMOTE_ADDR'];
		if ($bdload!="1") {
			mysql_connect($dbhost1, $dbuname1, $dbpass1) or include"404.php";
			mysql_select_db($dbname1);
		}
	} else {
		include"404.php";
	}
?>