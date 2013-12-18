<?php /* Smarty version Smarty-3.0.6, created on 2011-02-19 20:39:47
         compiled from "/var/www/maincp/client/templates/enter.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1754999304d602a93c3e592-56529195%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'edc22c786b1c361d7ee3fa128f2b248e7cc3a166' => 
    array (
      0 => '/var/www/maincp/client/templates/enter.tpl',
      1 => 1296429314,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1754999304d602a93c3e592-56529195',
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