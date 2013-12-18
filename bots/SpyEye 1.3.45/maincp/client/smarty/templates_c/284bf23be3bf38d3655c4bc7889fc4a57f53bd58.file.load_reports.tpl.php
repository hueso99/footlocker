<?php /* Smarty version Smarty-3.0.6, created on 2011-02-20 02:36:00
         compiled from "/var/www/maincp/client/templates/load_reports.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6907077794d607e103679f6-10979881%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '284bf23be3bf38d3655c4bc7889fc4a57f53bd58' => 
    array (
      0 => '/var/www/maincp/client/templates/load_reports.tpl',
      1 => 1298135552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6907077794d607e103679f6-10979881',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<br><hr color="#cccccc" size="1">
<h2><b>Reports</b></h2>
<table style="border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: rgb(255, 255, 240); width: 600px;" border="1" cellpadding="3" cellspacing="0">
<th width='30'>#</th><th>GUID</th><th>Report data</th><th width='130'>Date</th>

<?php  $_smarty_tpl->tpl_vars['REP'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('REPORTS')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['reports']['iteration']=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['REP']->key => $_smarty_tpl->tpl_vars['REP']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['reports']['iteration']++;
?>
	<tr>
	<td align='center'><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['reports']['iteration'];?>
</td>
	<td align='center'><?php echo $_smarty_tpl->tpl_vars['REP']->value['guid_bot'];?>
</td>
	<td align='center'><?php echo $_smarty_tpl->tpl_vars['REP']->value['data_rep'];?>
</td>
	<td align='center'><?php echo $_smarty_tpl->tpl_vars['REP']->value['date_rep'];?>
</td>
	</tr>
<?php }} else { ?>
	<tr><td colspan='5' class='error' align='center'>There are no reports</td></tr>	
<?php } ?>

</table>
