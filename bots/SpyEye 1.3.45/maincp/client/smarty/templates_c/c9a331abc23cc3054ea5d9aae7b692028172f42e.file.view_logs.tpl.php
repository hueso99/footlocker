<?php /* Smarty version Smarty-3.0.6, created on 2011-02-19 21:06:20
         compiled from "/var/www/maincp/client/templates/view_logs.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17666257504d6030cca7bda0-42007192%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c9a331abc23cc3054ea5d9aae7b692028172f42e' => 
    array (
      0 => '/var/www/maincp/client/templates/view_logs.tpl',
      1 => 1298061679,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17666257504d6030cca7bda0-42007192',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<form id='frm_getlog'>
Select log: 
<select name='log'>
	<option value='e'>Error log</option>
	<option value='d'>Debug log</option>
	<option value='t'>Tasks log</option>
</select>
<input type='button' value=' Get Log ' id='btn_getlog'> 
<input type='button' value=' Clear Log ' id='btn_clearlog'> 
</form>
<div id='log_content'></div>

<script>
	$("#btn_getlog").click(function() 
	{
		pdata = $('#frm_getlog').serialize(true);
		load('./mod/view_logs.php?'+pdata, 'log_content');
	});
	$("#btn_clearlog").click(function() 
	{
		pdata = $('#frm_getlog').serialize(true);
		load('./mod/clear_log.php?'+pdata, 'log_content');
	});	
</script>

