<?php
	if(!defined('__CP__')) { die(); }
	
	class Session
	{
		private $SessionKey;
		
		public function __construct()
		{
			session_start();
		}
		
		public function checkSession()
		{
			if($this->hasSession() == false)
			{
				if($this->checkLogin() == true)
				{
					header('Location: index.php');
					return true;
				} else {
					return false;
				}
			} else { return true; }
		}
		
		private function checkLogin()
		{
			if($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$sPassword = $_POST['password'];

				if($sPassword == ADMIN_PASSWORD)
				{
					$this->createSession();
					return true;
				} else {
					return false;
				}
			} else { return false; }
		}
		
		private function createSession()
		{
			$Value = md5(ADMIN_PASSWORD . $_SERVER['REMOTE_ADDR']);
			$_SESSION[SESSION_NAME] = $Value;
		}
		
		public function destroySession()
		{
			$this->SessionKey = $_SESSION[SESSION_NAME];
			
			if($this->SessionKey)
			{
				unset($this->SessionKey);
				unset($_SESSION[SESSION_NAME]);
				session_destroy();
			}
		}
		
		public function hasSession()
		{
			$this->SessionKey = $_SESSION[SESSION_NAME];
			$Value = md5(ADMIN_PASSWORD . $_SERVER['REMOTE_ADDR']);
			
			if($this->SessionKey == $Value)
			{
				return true;
			} else {
				return false;
			}
		}
	}
?>