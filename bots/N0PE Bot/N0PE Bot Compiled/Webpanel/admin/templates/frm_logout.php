<?php
	class template_Logout
	{
		private $Content = NULL;
		private $Title = 'Logout';
		
		public function __construct()
		{
			global $FNC;
			
			$this->Content .= $FNC->Content('<center><b>You have successfully logged out !</b></center>');
			$this->Content .= $FNC->Content('<script language ="javascript">
				function refresh(){ location.href="index.php"; }
				setTimeout(\'refresh()\', 1500);
				</script>');
		}
		
		public function getContent()
		{
			global $Session;
			$Session->destroySession();
			
			return $this->Content;
		}
		
		public function getTitle()
		{
			return $this->Title;
		}
	}
?>