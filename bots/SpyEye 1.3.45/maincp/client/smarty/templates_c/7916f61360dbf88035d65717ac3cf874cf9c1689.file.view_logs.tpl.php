<?php /* Smarty version Smarty-3.0.6, created on 2011-03-26 03:57:01
         compiled from "Z:/home/gate/www/client/templates\view_logs.tpl" */ ?>
<?php /*%%SmartyHeaderCode:173624d8d39ddb28cb8-80884708%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7916f61360dbf88035d65717ac3cf874cf9c1689' => 
    array (
      0 => 'Z:/home/gate/www/client/templates\\view_logs.tpl',
      1 => 1298061679,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '173624d8d39ddb28cb8-80884708',
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

