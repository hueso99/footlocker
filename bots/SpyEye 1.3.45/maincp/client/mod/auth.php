<?
	include_once "../common.php";
	#@header("Content-type: text/html; charset=windows-1251");

	if( !isset($_POST['pass']) ) 
		die('<div id="error">Data send error!</div>');
	else $pswd = $_POST['pass'];

	$logged = $user->GetUser($pswd);
	if( !$logged )
	{
		die("<div class='error'>Wrong password</div>");
	}
	$_SESSION["bncp_user"] = $logged;
?>
<script>location.reload();</script>