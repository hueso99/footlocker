<?php

$host = $_POST['host'];
if ( (!isset($host)) || !strlen($host) ) {
	exit;
}
$host = str_replace("\r", "", $host);

$dt = $_GET['dt'];
if ( (!isset($dt)) || !strlen($dt) ) {
	exit;
}

require_once 'mod_dbase.php';

$dbase = db_open();

$sql = "DELETE FROM rep2_$dt"
	 . " WHERE rep2_$dt.url LIKE '%$host%'";
$res = mysqli_query($dbase, $sql);
if (!(@($res)))
	$content .= "<font class='error'>ERROR SQL</font> : ' $sql '";
else {
	$cnt = mysqli_affected_rows($dbase);
	$content .= "<font class='ok'>OK</font> : $cnt items of '$host' was successfully deleted";
}

db_close($dbase);

//require_once 'frm_skelet.php';
//echo get_skelet('Host delete', $content);

echo $content;

?>