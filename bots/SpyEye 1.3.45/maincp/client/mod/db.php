<?
	if (!defined('IN_BNCP')) exit;
	
	if (function_exists('mysqli_query') === false) 
	{
		$smarty->display('header.tpl');
		die("<center><font class='error'>Plz, install <font color='green'>MySQLi</font></center>");
	}
	define('_MYSQL_SHOW_ERRORS_', 'true');

## DATABASE class	
class DB extends mysqli
{
// properties
	var $connected;
// constructor
	function __construct() 
	{
		global $db_host, $db_user, $db_pswd, $db_database;	
		$this->connected = false;
		@ parent::__construct($db_host, $db_user, $db_pswd, $db_database);
		if( mysqli_connect_errno() )  
		{  
			if(defined(_MYSQL_SHOW_ERRORS_))
				die(  '<div class="error">Cannot connect to database : ' . mysqli_connect_error() .'</div>' ); // 
			return $this->connected;
		}
		$this->connected = true;
	}
// destructor
	function __destruct() 
	{
		//if($this->connected) $this->close();
	}
	function GetConfigs()
	{
		$sql = "SELECT * FROM configs_t";
		$res = $this->query($sql);
		if( !$this->affected_rows ) return 0;
		for($resarr=array(); $row = $res->fetch_assoc(); )
		{
			$key = $row['cKey'];
			$resarr[$key] = $row['cValue'];
		}
		return  $resarr;
	}
	function UpdateConfigs($ini)
	{
		$count = 0;
		if( is_array($ini) ) foreach($ini as $k=>$v)
		{
			$sql = "UPDATE configs_t SET cValue='$v' WHERE cKey='$k'";
			$this->query($sql);
			if( $this->affected_rows == 1 ) $count++;
		}	
		return $count;
	}
	function InstallConfigs($ini)
	{
		$count = 0;
		if( is_array($ini) ) foreach($ini as $k=>$v)
		{
			$sql = "INSERT INTO configs_t (cKey, cValue) VALUES('$k','$v')";
			$this->query($sql);
			if( $this->affected_rows == 1 ) $count++;
		}	
		return $count;
	}
	function config($key)
	{
		$sql = "SELECT cValue FROM configs_t WHERE cKey='$key' LIMIT 1";
		$res = $this->query($sql);
		if( !(@$res) ) return '';
		$conf = $res->fetch_assoc();
		return $conf['cValue'];
	}
	function SetConfig($key, $val)
	{
		$sql = "UPDATE configs_t SET cValue='$val' WHERE cKey='$key' LIMIT 1";
		$this->query($sql);
		return $this->affected_rows;
	}
};
?>