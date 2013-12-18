<?
	if (!defined('IN_BNCP')) exit;
	include_once ROOT_PATH."/mod/db.php";
	
class user
{
	var $db;
	function __construct()
	{
		global $db;
		if( !isset($db) ) $db = new DB();
		$this->db = &$db;
	}
	function Check()
	{
		if(isset($_SESSION["bncp_user"])) return $_SESSION["bncp_user"]; 
		else 
		{
			global $smarty;
			$smarty->display('enter.tpl');
			return 0; 
		}
	}
	function GetUser($pswd)
	{
		$query = "SELECT * FROM users_t WHERE uPswd='".md5($pswd)."'";
		if($this->db->connected) $res = $this->db->query($query);
		if($res && $this->db->affected_rows)  return $res->fetch_array(MYSQLI_ASSOC);
		return 0;
	}
	function AddUser($login, $pass, $ip='')
	{
		$query = "INSERT INTO users_t (uLogin, uPswd, uLastTime, uIp) VALUES('$login', md5('$pass'), CONVERT_TZ(now(),@@time_zone,'+0:00'), '$ip')";
		return $this->db->query($query);
	}
}

?>