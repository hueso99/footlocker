<html>
{if !isset($DIR)}{assign var='DIR' value='../'}{/if}
{include file='header.tpl'}
<body>
<center>
<div id="div_smmain" class="div_smmain">
	
	<noscript>
	<font class="error">Your JavaScript is turned off. Please, enable your JS.</font>
	</noscript>

		<div id="div_ajax" align="center">{include file="$CONTENT"}</div>

</div>
</center>
{literal}	
<script>
if (navigator.userAgent.indexOf("Mozilla/4.0") != -1) {
	alert("Your browser is not support yet. Please, use another (FireFox, Opera, Safari)");
	document.getElementById("div_main").innerHTML = "<font class=\'error\'>ChAnGE YOuR BRoWsEr! Dont use BUGGED Microsoft products!</font>";
}
</script>
{/literal}
</body>
</html>