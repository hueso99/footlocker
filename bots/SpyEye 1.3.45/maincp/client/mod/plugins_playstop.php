<?
	include_once "../common.php";
	if( !$user->Check() ) exit;
	
	$id = (int)$_GET['id']; if (!@$id) die("Input params error");

	$sql = "SELECT plugins.status FROM plugins WHERE plugins.id = $id LIMIT 1";
	$res = $db->query($sql);
	list($status) = $res->fetch_array();
	($status) ? $status = 0 : $status = 1;
		
	$sql = "UPDATE plugins  SET plugins.status = $status  WHERE plugins.id = $id LIMIT 1";
	$db->query($sql);
	if (!$db->affected_rows) die("Error in query: \"$sql\"");
	else echo $id;
?>