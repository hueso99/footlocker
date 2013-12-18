<?php session_start(); 

require_once('inc/session.php'); require_once('inc/body.php'); require_once('inc/config.php'); require_once('other/safe.php');

if(!$_SESSION['admin']){
	echo 'Keine Berechtigung!';
	exit();
}
?>

<table>
<tr>
	<th style="width: 10%;">ID</th>
	<th>String</th>
</tr>
<?php

$auslesen = mysql_query("SELECT * FROM grabberlogs");
while($row = mysql_fetch_array($auslesen)){
	echo '<tr>
			<td>'.$row['id'].'</td>
			<td>'.str_replace("#", "<br>",$row['string']).'</td>
		  </tr>';
}
?>
</table>
	
<?php require_once('inc/footer.php'); ?>