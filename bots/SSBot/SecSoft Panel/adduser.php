<?php session_start(); require_once('inc/session.php'); require_once('inc/body.php'); require_once('inc/config.php'); require_once('other/safe.php'); ?>

<?php
if(!$_SESSION['admin']){
	echo 'Keine Berechtigung!';
	exit();
}

if(isset($_POST['adduser'])){
	if($_POST['token'] !== $_SESSION['token3']){
		echo 'Token falsch';
		exit();
	}else{
		$user_add = safe_xss($_POST['user']);
		$pass_add = safe_xss(sha1(md5($_POST['pass'])));
		$rechte_add = safe_xss($_POST['rechte']);
		$admin_add = safe_xss($_POST['admin']);

		mysql_query("INSERT INTO users (user, pw, rechte, admin) VALUES ('".safe_sql($user_add)."', '".safe_sql($pass_add)."', '".safe_sql($rechte_add)."', '".safe_sql($admin_add)."')");
		
		echo 'Bitte warten... <meta http-equiv="refresh" content="2; URL=benutzer.php">';
	}
}else{
	$_SESSION['token3'] = uniqid(md5(microtime()), true);
	?>
	<form action="adduser.php" method="post">
	  <b>Benutzer</b><p><input type="text" name="user" /></p>
	  <b>Passwort</b><p><input type="pass" name="pass" /></p>
	  <b>Rechte</b><p><input type="text" name="rechte" value="z.B http,tcp,dlex" /></p>
	  <input type="hidden" name="token" value="<?php echo $_SESSION['token3']; ?>" />
	  
	  <br />
	  <input type="radio" name="admin" value="1" />Administrator
	  <input type="radio" name="admin" value="0" />Eingeschr&auml;nkter Benutzer<br />
	  
	  <input type="submit" name="adduser" style="float: right;" value="Benutzer hinzuf&uuml;gen" /><br /><br />
	</form>
	<?php
}

require_once('inc/footer.php'); ?>