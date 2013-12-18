<?php 
	session_start();
	require_once('session.php');
	require_once('config.php');
	$botsonline = mysql_num_rows(mysql_query("SELECT * FROM clients WHERE status LIKE 'Online'"));
?>	
<ul id="sddm">
	<li style="float: right; margin-right: 10px;">Bots Online: <?php echo $botsonline; ?> </li>
	<li><a href="stats.php"><img src="img/stats.png" alt="" style="border: 0px;" />&nbsp;Statistics</a></li>
	<li>|</li>
	<li><a href="clients.php"><img src="img/clients.png" alt="" style="border: 0px;" />&nbsp;Clients</a></li>
	<li>|</li>
	<li><a href="tasks.php"><img src="img/tasks.png" alt="" style="border: 0px;" />&nbsp;Task Manager</a></li>
       	<li>|</li>
       	<li><a href="about.php"><img src="img/about.png" alt="" style="border: 0px;" />&nbsp;About</a></li>
       	<li>|</li>
	<li><a href="logout.php"><img src="img/logout.png" alt="" style="border: 0px;" />&nbsp;Log Out</a></li>
</ul>