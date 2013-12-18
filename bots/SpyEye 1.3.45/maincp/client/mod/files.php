<?
	if (!defined('IN_BNCP')) exit;
	
function GetFile($name)
{
	global $db;	
	$sql = "SELECT * FROM files_t WHERE fName='$name'";
	$res = $db->query($sql);
	if( $db->affected_rows && is_object($res)  ) return $res->fetch_array();
	return FALSE;
}
function GetFileById($fid)
{
	global $db;	
	$sql = "SELECT * FROM files_t WHERE fId=$fid";
	$res = $db->query($sql);
	if( $db->affected_rows && is_object($res) ) return $res->fetch_array();
	return FALSE;
}
function LastFileId()
{
	global $db;
	$sql = "SELECT fId FROM files_t ORDER BY fId DESC LIMIT 1";
	$res = $db->query($sql);
	if( $db->affected_rows && is_object($res) )
	{
		list($id) = $res->fetch_array();
		return $id;
	}
	else return 0;
}
define('FRAG_SIZE', 50000);
function AddFile($name, $cont, $md5, $type)
{
	global $db;
	$sql = "INSERT INTO files_t VALUES(NULL, '$name','$cont', '$md5', '$type')";
	$db->query($sql);
	return $db->affected_rows;
}
function UpdateFile($name, $cont)
{
	global $db;
	$sql = "UPDATE files_t SET fCont=CONCAT(fCont, '$cont') WHERE fName='$name'";
	//echo $sql.";\n";
	$db->query($sql);
	return $db->affected_rows;
}
function FileExist($name)
{
	global $db;	
	$sql = "SELECT fId FROM files_t WHERE fName='$name'";
	$res = $db->query($sql);
	if( $db->affected_rows && is_object($res) ) 
	{
		list($fid) = $res->fetch_array();
		return $fid;
	}
 	return FALSE;
}
function ContExist($id)
{
	global $db;	
	$sql = "SELECT fMd5 FROM files_t WHERE fId=$id";
	$res = $db->query($sql);
	if( $db->affected_rows && is_object($res) )
		list($fMd5) = $res->fetch_array();
	else return FALSE;

	$sql = "SELECT fId FROM files_t WHERE fMd5='$fMd5' ORDER BY fId ASC LIMIT 1";
	$res = $db->query($sql);
	if( $db->affected_rows && is_object($res) ) 
	{
		list($id) = $res->fetch_array();
		return $id;
	}
 	return FALSE;
}
function FileId($name)
{
	global $db;	
	$sql = "SELECT fId FROM files_t WHERE fName='$name'";
	$res = $db->query($sql);
	if( $db->affected_rows && is_object($res) ) 
	{
		list($id) = $res->fetch_array();
		return $id;
	}
 	return FALSE;
}
## get file from db | $type = b|c|e
function GetFiles()
{
	global $db;
	$sql = "SELECT fId, fName, fMd5, length(fCont) as fSize, fType FROM files_t ORDER BY fId";
	$res = $db->query($sql);
	if( $db->affected_rows && is_object($res) )
	{
		$result = Array();
		while( $row = $res->fetch_array() )
		{
			$result[] = $row;
		}
		return $result;
	}
	else return Array();
}
function DeleteFile($id)
{
	global $db;
    $result = $db->query("DELETE FROM files_t WHERE fId=$id") === TRUE;
    # delete all loads
    $db->query("DELETE FROM loads_t WHERE fk_task_id in (SELECT tskId FROM tasks_t WHERE fk_file_id = $id)");
    # delete all tasks
    $db->query("DELETE FROM tasks_t WHERE fk_file_id = $id");
	# 
	return $result;
}
?>