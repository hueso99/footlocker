<?php /* Smarty version Smarty-3.0.6, created on 2011-03-26 03:56:29
         compiled from "Z:/home/gate/www/client/templates\enter.tpl" */ ?>
<?php /*%%SmartyHeaderCode:66874d8d39bd29d159-46635253%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '68f02267791b295f8431305fced9a1db674cf41c' => 
    array (
      0 => 'Z:/home/gate/www/client/templates\\enter.tpl',
      1 => 1296429314,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '66874d8d39bd29d159-46635253',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<center>
<form id='login_frm' style='margin:0px;'>
	<label>Please, enter password: </label><input type='password' id='password' name='pass'> <input type='submit' value='Enter'>
	<div id='login_res'></div>
</form>

<script>

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
</script>