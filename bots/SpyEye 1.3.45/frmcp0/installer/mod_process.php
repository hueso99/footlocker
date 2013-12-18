<div align='left' width='100%'>
<fieldset style="background: #FCFCFC none repeat scroll 0% 0%; width: 720px; -moz-background-clip: border; -moz-background-origin: padding; -moz-background-inline-policy: continuous;"><legend align="center"><b>LOGS</b>:</legend>
<ul>

<?php

function sh_GetMainDir() {
	$cfile = $_SERVER['SCRIPT_FILENAME'];
	$pos = strrpos($cfile, '/');
	$cdir = substr($cfile, 0, $pos);
	$pos = strrpos($cdir, '/');
	$mdir = substr($cdir, 0, $pos);
	//$mdir = '/..';
	return $mdir;
}

?>

<hr size='1' color='#CCC'>
<font style='font-size:8px;color:gray;'><i>If you have smth troubles with file-access, just do smth like (example for Apache Webserver):<br>
&gt; chown -R www-data *<br>
&gt; chmod -R 777 *</i>
</font><br>
<hr size='1' color='#CCC'>
<br>

<?php

// inputs
$DB_SERVER = $_POST['DB_SERVER'];
$DB_NAME = $_POST['DB_NAME'];
$DB_USER = $_POST['DB_USER'];
$DB_PASSWORD = $_POST['DB_PASSWORD'];
$ADMIN_PASSWORD = $_POST['ADMIN_PASSWORD'];

echo "<b>" . gmdate('Y.m.d H:i:s') . "</b> : start install<br><br>";

// checking php
if (!function_exists('mysql_connect'))
	die("<font class='error'>ERROR</font> : mysql_connect() is not exists!");
if (!function_exists('mysqli_connect'))
	die("<font class='error'>ERROR</font> : mysqli_connect() is not exists!");
if (!function_exists('file_get_contents'))
	die("<font class='error'>ERROR</font> : file_get_contents () is not exists!");
if (!function_exists('file_put_contents'))
	die("<font class='error'>ERROR</font> : file_put_contents() is not exists!");

// install stuff
$db = @mysql_connect($DB_SERVER, $DB_USER, $DB_PASSWORD);
if (!$db)
	die("<font class='error'>ERROR</font> : mysql_connect fails : " . mysql_error());

// dumping config.php
echo '<br><li> dumping <b>config.php</b><br>';
$config = file_get_contents('templates/config.php');
$config = str_replace('!DB_SERVER!', $DB_SERVER, $config);
$config = str_replace('!DB_NAME!', $DB_NAME, $config);
$config = str_replace('!DB_USER!', $DB_USER, $config);
$config = str_replace('!DB_PASSWORD!', $DB_PASSWORD, $config);
$config = str_replace('!ADMIN_PASSWORD!', $ADMIN_PASSWORD, $config);
$file = sh_GetMainDir() . "/config.php";
if (!@file_put_contents($file, $config))
	die("<font class='error'>ERROR</font> : file_put_contents() fails on \"$file\"");
echo "<font class='ok'>OK</font> : \"$file\" was dumped successfully <br>";

?>

</ul>
</fieldset>
</div>