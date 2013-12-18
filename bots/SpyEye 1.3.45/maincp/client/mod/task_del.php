<?
	include_once "../common.php";
	include_once ROOT_PATH."/mod/tasks.php";
	if( !$user->Check() ) exit;	
	
	if (isset($_GET['del'])) 
	{
		$id = (int)$_GET['del'];
	
		if( DeleteTask($id) == -1) die("<br><font class='error'>Can\'t deleted task #$id</font>");
		echo "<br><font class='ok'>Deleted task #$id</font>";
	}
?>