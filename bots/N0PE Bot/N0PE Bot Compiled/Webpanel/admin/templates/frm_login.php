<?php
	class template_Login
	{
		private $Content = NULL;
		private $Title = 'Login';
		
		public function __construct()
		{
			global $FNC;
			
			$this->Content .= $FNC->Content('
				<form method="post">
					<div style="text-align:center;margin-top:10px">Password:&nbsp;<input type="password" name="password" /> &nbsp; <input type="submit" name="login" value="Login" /></div></td>
						</form>');
		}
		
		public function getContent()
		{
			return $this->Content;
		}
		
		public function getTitle()
		{
			return $this->Title;
		}
	}
?>