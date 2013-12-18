<?php

class odbcClass
{
	public $status = array('connected' => 0);
	public $link; 
	public $queryCount = 0;
	
	
	public function error($line,$file,$mySQLError)
	{
		$errorMsg = date("Y/m/d H:i.s",time()).": Error in ".$file." line ".$line." ".$mySQLError;
		file_put_contents('logs/db_error.log', date("Y/m/d H:i.s", time()) . " | " . $mySQLError . "\r\n", FILE_APPEND);
		$this -> status['lastError'] = $errorMsg;
		$this -> status['connected'] = 0;
		die($errorMsg); 
	}
	
	function __construct()
	{
		global $config;
		
		$this->link = @mysql_connect($config["dbhost"], $config["dbuser"], $config["dbpass"]) or $this -> error(__LINE__,__FILE__,mysql_error());
		@mysql_select_db($config["dbname"]) or $this -> error(__LINE__,__FILE__,mysql_error());
		mysql_query("SET NAMES 'utf8'"); 
		mysql_query("SET character_set_client='utf8'");		// перевод вывода клиента в utf8
		mysql_query("SET character_set_results='utf8'");		// при запросе из базы
		mysql_query("SET collation_connection='utf8_general_ci'");	// в кодировку utf-8		
		$this -> status['connected'] = 1;
	}
	
	public function query($query) {
		if (empty($query)) {
			$this -> error(__LINE__,__FILE__,"MySQL query is empty!");
			return Array(0);
		}
		$r=mysql_query($query) or $this -> error(__LINE__,__FILE__,mysql_error());
		if (DEBUG==1) $this->queryCount++;
		if (DEBUG==1) file_put_contents('./logs/sql.sql',date("Y/m/d H:i.s", time()).': '.$query."\r\n",FILE_APPEND);
		
		
		// get query type
		$queryType=explode(" ",$query);
		$queryType=strtoupper($queryType[0]);
		
		if ($queryType=="SELECT" || $queryType=="SHOW") {
			$queryResultCount=mysql_num_rows($r);
			if ($queryResultCount<=0) return Array(0);
			while ($row=mysql_fetch_assoc($r)) {
				$out[]=$row;
			}
			return $out;			
		}
		
		if ($queryType=="DELETE" || $queryType=="INSERT" || $queryType=="UPDATE" || $queryType=="REPLACE" || $queryType=="CREATE") {
			return mysql_insert_id($this->link);
		}
		

	}
} // end class
?>