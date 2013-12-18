<?
	if (!defined('IN_BNCP')) exit;
	if( !$user->Check() ) exit;

## add new screen
	function AddScreen($height, $width, $depth)
	{
		global $db;
		$sql = "INSERT IGNORE INTO screens_t VALUES(NULL, $height, $width, $depth)";
		$db->query($sql);
		return $db->affected_rows;
	}
	
## get screen info from db
	function GetScreenId($height, $width, $depth)
	{
		AddScreen($height, $width, $depth);
		global $db;
		$sql = "SELECT scrId FROM screens_t WHERE scrHeight=$height AND scrWidth=$width AND scrDepth=$depth";
		$res = $db->query($sql);
		if( $db->affected_rows && is_object($res) )
		{
			list($scrId) = $res->fetch_array();
			return $scrId;
		}
		return 0;
	}	
?>