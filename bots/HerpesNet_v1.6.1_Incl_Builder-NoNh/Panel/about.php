<?php 
    session_start();
    
	require_once('inc/session.php');
	require_once('inc/config.php');
	require_once('inc/html_grund.php');
	include('inc/functions.php');
	include("ip_files/countries.php");
	
	$query_1 = mysql_query("SELECT COUNT(*) FROM clients ");
	$item_count = mysql_result($query_1, 0);
	$query_1 = mysql_query("SELECT * FROM clients ORDER BY id DESC");
	$query1rows = mysql_num_rows($query_1);
	$query_2 = mysql_query("SELECT DISTINCT cc FROM clients");
	
	echo '<link rel="stylesheet" type="text/css" href="css/style.css"/>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		
	<script type="text/javascript">
    	$(document).ready(function(){
      		refreshBotsOnline();
    	});
    	
    	function refreshBotsOnline(){
        	$(\'#navi\').load(\'inc/html_menu.php\');
        	setTimeout(refreshBotsOnline, 5000);
    	}
	</script>';
	echo "	<font color = '#0099FF'>Herpes</font> is a simplistic <font color = '#0099FF'>HTTP/C++ Bot</font>.<br /> 
	It can hold <font color = '#0099FF'>thousands of bots</font> with no problems.<br />
	<br />
	Based on µBot, binary totally recoded in <font color = '#0099FF'>C++</font> for granting the best <font color = '#0099FF'>performances</font> with the best <font color = '#0099FF'>stability</font>.
	<br />

	<br />
	<br />
	<font color = '#0099FF'>Never lose a bot again..</font>
	<p>";
	
	require_once('inc/html_footer.php');
?>