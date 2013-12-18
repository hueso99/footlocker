<?php

//echo gmdate('YmdHis');

require_once 'mod_dbtime.php';

$date = getDbTime();
if (!$date) {
	echo "<font class='error'>ERROR</font> : cannot get time";
	exit;
}

echo gmdate("YmdHis", $date);

?>
