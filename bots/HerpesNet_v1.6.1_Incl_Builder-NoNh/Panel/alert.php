<?php 
    session_start();
    
	require_once('inc/session.php');
	require_once('inc/config.php');
	include('inc/functions.php');
	include("ip_files/countries.php");
	
	$query_1 = mysql_query("SELECT COUNT(*) FROM clients ");
	$item_count = mysql_result($query_1, 0);
	$query_1 = mysql_query("SELECT * FROM clients ORDER BY id DESC LIMIT 1");
	$row = mysql_fetch_array($query_1);
	


echo '<div id="ajaxdiv" style="width:100%; padding: 10px; background:#d5f3ff">
<a><img src="img/alert.png" width="16" height="16" />&nbsp;Client connected: #'; 
echo $row['id']; 
echo ' '; 
echo $row['userandpc']; 
echo '</a></div>';
?>