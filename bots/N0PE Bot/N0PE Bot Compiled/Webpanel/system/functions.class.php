<?php
	if(!defined('__CP__')) { die(); }
	
	class Functions
	{
		public function __construct()
		{
		}
		
		public function Title($sTitle)
		{
			return '<div class="title">' . $sTitle . '</div>';
		}
		
		public function Content($sContent, $bStyle = false)
		{
			return '<div class="content' . ($bStyle ? ' ' . $bStyle : '') . '">' . $sContent . '</div>';
		}
		
		public function Seperate($sContent, $bStyle = false)
		{
			return '<div class="seperate' . ($bStyle ? ' ' . $bStyle : '') . '">' . $sContent . '</div>';
		}
		
		public function addBot($rHWID, $rPCName, $rIP, $rFlag, $rCountry, $rSystem, $rVersion, $rRequest)
		{
			global $DB;
			$DB->Query("INSERT INTO bots (HWID, PCName, IP, Flag, Country, System, Version, Request) VALUES ('" . 
				$DB->dRead($rHWID) . "', '" . $DB->dRead($rPCName) . "', '" . $DB->dRead($rIP) . "', '" . $DB->dRead($rFlag) . "', '" . $DB->dRead($rCountry) . "', '" . $DB->dRead($rSystem) . "', '" .
					$DB->dRead($rVersion) . "', '" . $rRequest . "')");
		}
		
		public function updateBot($rHWID, $rPCName, $rIP, $rFlag, $rCountry, $rSystem, $rVersion, $rRequest)
		{
			global $DB;
			$DB->Query("UPDATE bots SET PCName = '" . $DB->dRead($rPCName) . "', IP = '" . $DB->dRead($rIP) . "', Flag = '" . $DB->dRead($rFlag) . "', Country = '" . $DB->dRead($rCountry) .
				"', System = '" . $DB->dRead($rSystem) . "', Version = '" . $DB->dRead($rVersion) . "', Request = '" . $DB->dRead($rRequest) . "' WHERE HWID = '" . $DB->dRead($rHWID) . "'");
		}
	}
?>