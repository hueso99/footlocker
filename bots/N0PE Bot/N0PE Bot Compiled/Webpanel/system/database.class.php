<?php
	if(!defined('__CP__')) { die(); }
	
	class Database
	{
		private $conID;
		private $conStatus;
		
		public function __construct()
		{
			$this->Connect();
		}
		
		public function __destruct()
		{
			$this->Disconnect();
		}
		
		private function Connect()
		{
			$this->conID = @mysql_connect(MYSQL_SERVER, MYSQL_USERNAME, MYSQL_PASSWORD, true);
			
			if(!$this->conID || !@mysql_select_db(MYSQL_DATABASE, $this->conID))
			{
				$this->conStatus = false;
				$mError = @mysql_error();
				if(!$this->mError) { $this->mError = '# MySQL Connection Error'; }
				die($this->mError);
			}
			
			$this->conStatus = true;
			$this->setEncoding(MYSQL_ENCODING);
		}
		
		private function setEncoding($sCharSet)
		{
			@mysql_set_charset($sCharSet, $this->conID);
		}
		
		private function Disconnect()
		{
			if($this->conStatus) { @mysql_close($this->conID); }
			$this->conStatus = false;
		}
		
		public function Query($SQL)
		{
			return @mysql_query($SQL);
		}
		
		public function getRow($qID)
		{
			return @mysql_fetch_assoc($qID);
		}
		
		public function numRows($qID)
		{
			return @mysql_num_rows($qID);
		}
		
		public function getRowArray($qID)
		{
			return @mysql_fetch_array($qID);
		}
		
		public function getResult($qID, $sID)
		{
			return @mysql_result($qID, $sID);
		}
		
		public function dRead($String)
		{
			return @mysql_real_escape_string($String);
		}
	}
?>