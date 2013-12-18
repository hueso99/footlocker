<?
	include_once "../common.php";
	if( !$user->Check() ) exit;
	
	if( !isset($_GET['log'])) die();
	else $type = $_GET['log'];
	if( !strlen($type) ) die();
	
	$sql = "DELETE FROM logs_t WHERE logType='".$type[0]."'";
	$db->query($sql);
	if( $db->affected_rows > -1 ) echo "<font class='ok'>Ok, nice</font>";
	else echo "<font class='error'>Clearing error</font>";	
?>