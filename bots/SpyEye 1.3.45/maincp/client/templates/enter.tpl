<center>
<form id='login_frm' style='margin:0px;'>
	<label>Please, enter password: </label><input type='password' id='password' name='pass'> <input type='submit' value='Enter'>
	<div id='login_res'></div>
</form>

{literal}<script>

$(document).ready(function()
{
	$("#login_frm").submit(function()
	{
		pdata = $('#login_frm').serialize(true);
		$.post('./mod/auth.php', pdata, function(data) { $("#login_res").html(data); });
		return false;
	});

	$("#password").focus();

});
</script>{/literal}