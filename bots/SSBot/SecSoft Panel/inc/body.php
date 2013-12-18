<?php require_once('inc/config.php'); require_once('other/safe.php'); require_once('other/top.php'); 

function deutsch($aktuell){
$tage_de = array("Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag", "Sonntag");
$tage_en = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");

return $tage_de[array_search($aktuell, $tage_en)];
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>Secure-Soft Panel</title>
<link rel="shortcut icon" href="favicon.ico" />
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="css/stats.css"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
	<div id="headerwrap">
	  <div id="header">
	    <!-- <img src="img/header.png" /> -->
		
		<div id="stats">
			<label>Alle:</label><?php echo $all2; ?><br />
		    <label>Online:</label> <font color="green"><?php echo $on; ?></font><br />
			<label>Offline:</label> <font color="red"><?php echo $off; ?></font>
		</div>
		
		<div id="infos">
		  <label>Datum:</label> <i><?php echo date('d.m.Y') .' ('.deutsch(strftime("%A")); ?>)</i> <br />
		  <label>Serverzeit:</label> <i><?php echo date('H:i:s'); ?></i><br />
		  <label>Benutzer:</label> <b><?php echo $_SESSION['secuser'].'</b>'; if($_SESSION['admin']){ echo ' (<font color="red">Admin</font>) '; }else{ echo ' (Eingeschr&auml;nkt) '; } ?></b>
		</div>
	  </div>
	</div>
	
	<div id="wrapper">
	  <div id="navibox">
	  <div id="navigation">
	    <ul>
		  <li><a href="index.php">Statistiken</a></li>
		  <li><a href="bots.php">Deine Bots</a></li>
		  <li><a href="grabber.php">Grabber Logs</a></li>
		  <li><a href="befehle.php">Befehle</a></li>
		  <li><a href="benutzer.php">Benutzer</a></li>
		  <li><a href="profil.php">Dein Profil</a></li>
		  <li><a href="entwickler.php">Entwickler</a></li>
		  <li><a href="index.php?ausloggen">Ausloggen</a></li>
		</ul>
	  </div>
	  </div>
	
	  <div id="content">