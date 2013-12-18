<?php /* Smarty version Smarty-3.0.6, created on 2011-02-19 21:05:58
         compiled from "/var/www/maincp/client/templates/virtest.tpl" */ ?>
<?php /*%%SmartyHeaderCode:582566314d6030b6ae27b3-24135005%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5958d99d5bd8a0e5e54580c251e01f3a59fd9b2e' => 
    array (
      0 => '/var/www/maincp/client/templates/virtest.tpl',
      1 => 1296947333,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '582566314d6030b6ae27b3-24135005',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<form name="frm_checkbot" id="frm_checkbot" >
<table>
<tr align="left">
	<td align='left'><label>File to check (<b>*.exe</b>):</label></td>
	<td align='left'>
		<select name="file" style="width:500px;font-size:10px;">
<?php  $_smarty_tpl->tpl_vars['PATH'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('DBPATH')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['PATH']->key => $_smarty_tpl->tpl_vars['PATH']->value){
?>
	<option value='<?php echo $_smarty_tpl->tpl_vars['PATH']->value;?>
'><?php echo $_smarty_tpl->tpl_vars['PATH']->value;?>
</option>
<?php }} else { ?>
<option>There are no uploaded files for testing</option>
<?php } ?>
		</select>
	
<!--	<input name="file" value="<?php echo $_smarty_tpl->getVariable('DBPATH')->value;?>
" style="width:500px;"></td> -->
</tr>
<tr>
	<td colspan='2' align='center'><input type='submit' value='submit'  style="width:140px;"></td>
</tr>
</table>

<hr size='1' color='#CCC'><div name='ajax_checkbot' id='ajax_checkbot'></div>
</form>


<script>
$(document).ready(function()
{
	$("#frm_checkbot").submit(function()
	{
		SetLoading('ajax_checkbot');
		pdata = $('#frm_checkbot').serialize(true);
		$.post('./mod/virtestrun.php', pdata, function(data) { $("#ajax_checkbot").html(data); });
		return false;
	});
});
</script>

