<?php 
	session_start();
	require_once('inc/config.php');
	require_once('other/safe.php');
	
	if($_SESSION['seclogin']) { header('Location: index.php'); exit(); }

	if(isset($_POST['login'])){
		$user = $_POST['user'];
		$pass = sha1(md5(safe_xss($_POST['pass'])));
		
		$exist = mysql_query("SELECT * FROM users WHERE user = '".safe_sql($user)."' AND pw = '".safe_sql($pass)."'");
		
		if(mysql_num_rows($exist)){
			$_SESSION['seclogin'] = true;
			$_SESSION['secuser'] = $user;
			
			$q = mysql_query("SELECT * FROM users WHERE user = '".safe_sql($user)."' AND pw = '".safe_sql($pass)."'");
			while($row = mysql_fetch_array($q))
			{
			  if($row['admin'] == '1'){
				$_SESSION['admin'] = true;
			  }
			}
			
			$error = '<img src="img/accept.png" />&nbsp;Bitte warten...<meta http-equiv="refresh" content="3; URL=index.php">';
		}else{
			$error = '<img src="img/del.png" />&nbsp;Fehlgeschlagen';
		}
	}
?>

<link rel="stylesheet" type="text/css" href="css/style.css"/>

<div id="login">
	<img src="img/header.png" style="margin-left: 33px; border-bottom: 1px dotted #AEAEAE;" />
	<form action="login.php" method="post">
		<p><label>Benutzer:</label><input type="text" class="tb" name="user" /></p>
		<p><label>Passwort:</label><input type="password" class="tb" name="pass" /></p>
		<p><input type="submit" name="login" class="btn" value="Anmelden" style="float: right;" /></p><br />
		<?php echo $error; ?>
	</form>
</div>