<?php

require_once '../config.php';

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/tr/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title>Installer of SpyEye</title>
		<link href="../css/style.css" type=text/css rel=stylesheet>
		<script type="text/javascript" src="../js/ajax.js"></script>
	</head>
	<body>

	<center>
	<div id="div_main" class="div_main">
		
		<noscript>
		<font class='error'>Your JavaScript is turned off. Please, enable your JS.</font>
		</noscript>
	
		<!-- ajax main panel -->
		<div id='div_mainp'>
		<table cellspacing="0" cellpadding="0" border="0" width='100%' height="50px">
			<tr>
			<td width='1%'><img src='img/install-128px.png' title='install' alt='install'></td>
			<td align='center'><img src='img/spylogo.png' title='logo' alt='logo'></td>
			</tr>
			<tr>
			<td align='center' colspan='2'><h1><b>Installer</b></h1></td>
			</tr>
		</table>
		</div>
		
		<hr size='1' color='#CCC'>
		
		<div align='center'>
		
		<form id='frm_config' name='frm_config' method='post' onsubmit='return false;'>
		<fieldset style="background: #FCFCFC none repeat scroll 0% 0%; width: 560px; -moz-background-clip: border; -moz-background-origin: padding; -moz-background-inline-policy: continuous;"><legend align="center"><b>config.php</b>:</legend>
		<table>
		<tr>
			<td colspan='2'><hr size='1' color='#CCC'></td>
		</tr>
		<tr>
			<td colspan='2' align='center'><b>mySQL</b></td>	
		</tr>
		<tr>
			<td width='200px'>host <b>:</b></td>
			<td><input size='15' name='DB_SERVER' value='<?php echo DB_SERVER; ?>'></td>
		</tr>
		<tr>
			<td width='200px'>db <b>:</b></td>
			<td><input size='20' name='DB_NAME' value='<?php echo DB_NAME; ?>'></td>
		</tr>
		<tr>
			<td width='200px'>user <b>:</b></td>
			<td><input size='30' name='DB_USER' value='<?php echo DB_USER; ?>'></td>
		</tr>
		<tr>
			<td width='200px'>password <b>:</b></td>
			<td><input size='30' name='DB_PASSWORD' value='<?php echo DB_PASSWORD; ?>'></td>
		</tr>
		<tr>
			<td colspan='2'><hr size='1' color='#CCC'></td>
		</tr>
		<tr>
			<td colspan='2' align='center'><b>Admin</b></td>	
		</tr>
		<tr>
			<td width='200px'>password<br><i>(for CP)</i> <b>:</b></td>
			<td><input size='30' name='ADMIN_PASSWORD' value='<?php echo ADMIN_PASSWORD; ?>'></td>
		</tr>
		<tr>
			<td colspan='2'><hr size='1' color='#CCC'></td>
		</tr>
		</table>
		</fieldset>
		
		<input type='submit' value='install' onclick='var pdata = ajax_getInputs("frm_config"); ajax_pload("mod_process.php", pdata, "div_results"); return false;'>
		</form>
		
		</div>
		
		<hr size='1' color='#CCC'>
	
		<!-- ajax container -->
		<div id='div_results' align='center'>
		</div>
	
	</div>
	</center>
	
	
		
		<script>
		if (navigator.userAgent.indexOf('Mozilla/4.0') != -1) {
			alert('Your browser is not support yet. Please, use another (FireFox, Opera, Safari)');
			document.getElementById('div_main').innerHTML = '<font class="error">ChAnGE YOuR BRoWsEr! Dont use BUGGED Microsoft products!</font>';
			}
		</script>
	
	</body>
</html>