<?
	if( !file_exists("config.php") && file_exists("installer")) define('CONF_FAIL', 1);
	include_once "common.php";
	
?><HTML>
<?
	$smarty->display("header.tpl");
	if( !file_exists("config.php") ) die("<div class='error' align='center'><b>config.php</b> not found. Plz reinstall system!</div>");
?>
<NOSCRIPT>
	<font class='error'>Your JavaScript is turned off. Please, enable your JS.</font>
</NOSCRIPT>
<script src='./scripts/jquery.js'></script>
<BODY><center><DIV id='content'>
<?
	if ( (is_dir('installer') === TRUE) && !file_exists("config.php") )
		die("Dude, you need to <font class='error'><a href='./installer/'>install system</a> before using !</font>");
	//if (is_dir('installer') === TRUE)
	//	die("Dude, you need to <font class='error'>delete <b>\"installer\"</b> folder!</font>");
	if (!file_exists("config.php"))
			die("<font class='error'>ERROR : System corrupted! Please reinstall system!</font>");
?>
<!-- POPUP WINDOW -->
	<div id='popup_wnd'></div> 
	<div id='popup_cont'><table class='popup_cont'><tr><td align='center'>
	<table class='popup_data' cellspacing=0><tr><td><div id='ptitle'>title</div><div id='close'>Close</div></td></tr>
	<tr><td><div id='pdata' style='text-align:center;'></div></td></tr></table>
	</td></tr></table></div>
<!-- POPUP END -->
	
<?
	$user = new user();
	if( $user->Check() ) 

	{
		include_once ROOT_PATH."/mod/bots-qview.php";
		$reload_panel = (int)$db->config('auto_reload_panels');
		if( $reload_panel ) $smarty->assign('RELOAD_PANEL', 1);
		$smarty->display('index.tpl');
	}
?>
</DIV>
</BODY>
<script src='./scripts/main.js'></script>
</HTML>