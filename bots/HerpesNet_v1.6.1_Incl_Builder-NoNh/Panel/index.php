<?php
session_start();

require_once('inc/config.php');

	if($_SESSION['login']) { header('Location: stats.php'); exit(); }

	$user = $_POST[user];
	$pass = $_POST[pass];
	if(isset($_POST['login'])){
		if($user == $correctuser && $pass == $correctpass)
			{	
				$_SESSION['login'] = true;
				$_SESSION['username'] = $user;
				header('Location: stats.php');
			}else{
			
				$error = 'Login Incorrect.';
			}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>µBOT</title>

<link rel="stylesheet" type="text/css" href="css/style.css"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>

<div align = 'center'>
<br /><br /><br />
<img src = 'img/herplogo.png' />
<table>
<tr>
	<td id = 'bbord2' align = 'center'>
	<br />
	
		<form action="?" method="post" >
		<label>User:</label><input class = 'tb' type="text" name="user" class="tb" /><br />

		<label>Password:</label><input class = 'tb' type="password" name="pass" class="tb" /><br /><br />
		<input type="submit" name="login" value="Login" class="btn" />
		</form>
		
	<br />
	</td>
</tr>
</table>
</div>


</body>
</html>