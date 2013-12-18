<?
	include_once "../common.php";
	if( !$user->Check() ) exit;	
	include_once ROOT_PATH."/mod/files.php";
	
	if( !isset($_GET['id']) ) exit;
	$id = (int)$_GET['id']; 	if (!@$id) exit;
	
	echo '<hr color="#dddddd" size="1">';
	if( DeleteFile($id) == 1 ) echo "<font class='ok'>Ok, file deleted!</font>";
	else echo "<font class='error'>Can't delete file</font>";
?>