<?php

require_once 'mod_dbase.php';
require_once 'config.php';
require_once 'mod_file.php';

function getDbTime()
{
	$dbase = db_open($dbase);
	if (!$dbase) {
		echo "<font class='error'>ERROR</font> : cannot open DB<br>";
		exit;
	}

	$sql = "SELECT UNIX_TIMESTAMP( CONVERT_TZ(now(),@@time_zone,'+0:00') )";
	$res = mysqli_query($dbase, $sql);
	if (!(@($res))) {
		writelog("error.log", "Wrong query : \" $sql \"");
		echo "<font class='error'>ERROR</font> : Wrong query : $sql<br><br>";
		exit;
	}

	list($date) = mysqli_fetch_row($res);
	
	db_close($dbase);
	
	return $date;
}

?>