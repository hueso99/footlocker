<?
	include_once "../common.php";
	if( !$user->Check() ) exit;
	include_once ROOT_PATH."/mod/files.php";
	
	$files = GetFiles();
	
	if( count($files) )
	{
		echo "<table>";	
		$RES = Array();
		foreach($files as $v)
		{
			list($id, $name, $md5, $size, $type) = $v;
			$RES[] = array('ID'=>$id, 'NAME'=>$name, 'MD5'=>$md5, 'SIZE'=>round($size/1024), 'TYPE'=>$type);
		}
		echo "</table>";
		$smarty->assign('CONTARR', $RES);
	}
	$smarty->display('show_files.tpl');
	
	
?>