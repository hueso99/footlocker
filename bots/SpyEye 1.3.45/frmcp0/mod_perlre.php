<?php

$data = $_POST['data'];
$data2 = $_POST['data2'];
$re = $_POST['re'];
if (function_exists('preg_match') == false) {
	echo "<font class='error'>ERROR</font> : preg_match() is not exists!";
	exit;
}

$re = str_replace("\\\\", "\\", $re);
$re = '/' . $re . '/';
//echo "<pre>$re</pre><br>";

if (preg_match($re, $data))
	echo "<font class='ok'>OK</font>";
else
	echo "<font class='error'>NOPE</font>";
	
if (strlen($data2)) {
	if (preg_match($re, $data2))
		echo "<br><font class='ok'>OK</font>";
	else
		echo "<br><font class='error'>NOPE</font>";
}

?>