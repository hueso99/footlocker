<?php session_start(); 

require_once('inc/session.php'); require_once('inc/body.php'); require_once('inc/config.php'); require_once('other/safe.php');

if(!$_SESSION['admin']){
	echo 'Keine Berechtigung!';
	exit();
}
?>

<table>
<tr>
	<th>Gruppe</th>
	<th>User</th>
	<th>Rechte</th>
	<th>L&ouml;schen</th>
	<th>Editieren</th>
</tr>
<?php
if(isset($_GET['delid'])){

$id = safe_xss($_GET['delid']);

if($_GET['token'] !== $_SESSION['token']){
    echo 'Token falsch';
	exit();
}else{
	mysql_query("DELETE FROM users WHERE id = '".safe_sql($id)."'");
}
}else if(isset($_GET['editid'])){

$_SESSION['token2'] = uniqid(md5(microtime()), true);
$id = safe_xss($_GET['editid']);
	
$auslesen = mysql_query("SELECT * FROM users WHERE id = '".safe_sql($id)."'");
while($row = mysql_fetch_array($auslesen)){
	$user_e = safe_xss($row['user']);
	$user_r = safe_xss($row['rechte']);
    $user_a = safe_xss($row['admin']);
}
	
echo '<form action="other/edit.php" method="post">
		Benutzer: <input type="text" name="user_e" value="'.safe_xss($user_e).'" />
		Rechte: <input type="text" name="user_r" value="'.safe_xss($user_r).'" />
		Gruppe: <input type="text" id="gruppe" name="user_a" value="'.$user_a.'" />&nbsp;('.safe_xss(admin($user_a)).') <input type="submit" name="editieren" value="Editieren" />
		<input type="hidden" name="token" value="'.$_SESSION['token2'].'" />
		<input type="hidden" name="id" value="'.safe_xss($id).'" />
		<p><b>Zum &auml;ndern entweder <b>1</b> (F&uuml;r Admin Rechte) oder 0 (F&uuml;r User) schreiben bei Gruppe</b></p>
	   </form>';
}else{
	$_SESSION['token'] = uniqid(md5(microtime()), true);

	$query1 = mysql_query("SELECT * FROM users");
	while($row = mysql_fetch_array($query1))
	{
	  echo '<tr>
			  <td>'.admin($row['admin']).'</td>
			  <td>'.safe_xss($row['user']).'</td>
			  <td>'.safe_xss($row['rechte']).'</td>
			  <td><a href="benutzer.php?delid='.safe_xss($row['id']).'&token='.$_SESSION['token'].'" onClick="javascript:return(confirm(\'Benutzer wirklich entfernen?\'))"><img src="img/del.png" /></a></td>
			  <td><a href="benutzer.php?editid='.safe_xss($row['id']).'"><img src="img/edit.png" /></a></td>
			</tr>';
	}
	
	echo '<img src="img/add.png" />&nbsp;<a href="adduser.php" style="color: black; text-decoration: none;">Benutzer hinzuf&uuml;gen</a>';
}

function admin($a){
if($a == '1'){
	return 'Admin';
}else{
	return 'User';
}
}
?>
</table>
	
<?php require_once('inc/footer.php'); ?>