<?php /* Smarty version Smarty-3.0.6, created on 2011-02-20 11:14:48
         compiled from "/var/www/maincp/client/templates/botsmon_state.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6758688354d60f7a83de5a1-40649106%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '46e126d94b332f570ad98e15018540bd5a86d8a2' => 
    array (
      0 => '/var/www/maincp/client/templates/botsmon_state.tpl',
      1 => 1294960216,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6758688354d60f7a83de5a1-40649106',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<table width='100%' border='1' cellspacing='0' cellpadding='0' style='border: 1px solid gray; font-size: 9px; border-collapse: collapse; background-color: #F4F4F4;'>
<th width='200px' style='background-color: #DDD;'>State</th>
<th style='background-color: #DDD;'>Online Bots/All Bots</td></th>

	<?php  $_smarty_tpl->tpl_vars['REC'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('CONT_ARR')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['REC']->key => $_smarty_tpl->tpl_vars['REC']->value){
?>
		<tr align='center'><td> <?php echo $_smarty_tpl->tpl_vars['REC']->value['MRES_ST'];?>
</td><td>(<?php echo $_smarty_tpl->tpl_vars['REC']->value['ACTB_CNT'];?>
/<?php echo $_smarty_tpl->tpl_vars['REC']->value['ALLB_CNT'];?>
)</td></tr>
	<?php }} ?>
	
</table>