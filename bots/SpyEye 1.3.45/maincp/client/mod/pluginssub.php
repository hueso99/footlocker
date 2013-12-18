<?
	include_once "../common.php";
	if( !$user->Check() ) exit;
	
	$act = $_GET['act'];	$plugin = $_GET['plugin'];

	foreach ($_POST as $varname => $varvalue) 
	{
		$sql = "UPDATE plugins SET status = $act WHERE fk_bot = $varvalue and plugin='$plugin' LIMIT 1";
		$db->query($sql);
	}
?>
