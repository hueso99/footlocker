<?php require_once('inc/session.php'); require_once('inc/body.php'); require_once('inc/config.php'); require_once('other/safe.php'); require_once('other/code2country.php'); require_once('other/pagenavigation.class.php');

$time_now = date('Y-m-d H:i:s');
	
echo '<h3>Deine Bots</h3>
	 <table>
	  <tr>
		<th>ID</th>
		<th>Land</th>
		<th>Name@HWID@IP Adresse</th>
		<th>Installiert</th>
		<th>Letzte Verbindung</th>
		<th>Status</th>
	  </tr>';

$query1 = mysql_query("SELECT COUNT(*) FROM bots");
$item_count = mysql_result($query1, 0);
$nav = new PageNavigation($item_count, 50);
$query1 = mysql_query("SELECT * FROM bots ORDER BY id ASC LIMIT ".safe_sql($nav->sql_limit));
$item_number = $nav->first_item_id;

  //$query1 = mysql_query("SELECT * FROM bots");
while($row = mysql_fetch_array($query1)){
  $hwid	 = safe_xss($row['hwid']);
  $status = safe_xss($row['status']);
	  
echo '<tr>
	  <td style="">'.safe_xss($row['id']).'</td>';
		if(empty($row['country'])){
			echo '<td style=""><img src="img/flags/00.gif" /></td>';
		}else{
			echo '<td style=""><img src="img/flags/'.safe_xss($row['country']).'.gif" />&nbsp;'.$options[strtoupper(safe_xss($row['country']))].'</td>';
		}
					
echo  '
	   <td style="">'.safe_xss($row['pc']).'@'.safe_xss($row['hwid']).'@'.safe_xss($row['ip']).'</td>
	   <td style="">'.safe_xss($row['install']).'</td>
	   <td style="">'.safe_xss($row['time']).'</td>';
	
if($status == '1'){
	echo '<td style="color: green;">Online</td>';
}else{
	echo '<td style="color: red;">Offline</td>';
}

}
	  
echo '</table><br /><div style="float: right; font-size: 11px;">'.$nav->createPageBar().'</div><br />';  

$query = "UPDATE bots SET status = 0 WHERE DATE_SUB('$time_now', INTERVAL ".$seconds." SECOND) > time";
    mysql_query($query) OR die(mysql_error());
	
require_once('inc/footer.php'); ?>