<?php /* Smarty version Smarty-3.0.6, created on 2011-03-26 03:54:05
         compiled from "D:\Web\home\gate\www\client/templates\enter.tpl" */ ?>
<?php /*%%SmartyHeaderCode:313494d8d392d3e8e78-14764006%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a7aa92c7d3ec87c0e5323570c12b4a1c99b6d23b' => 
    array (
      0 => 'D:\\Web\\home\\gate\\www\\client/templates\\enter.tpl',
      1 => 1296429314,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '313494d8d392d3e8e78-14764006',
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