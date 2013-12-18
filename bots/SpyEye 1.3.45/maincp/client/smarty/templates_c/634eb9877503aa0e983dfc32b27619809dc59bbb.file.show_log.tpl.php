<?php /* Smarty version Smarty-3.0.6, created on 2011-02-21 16:35:48
         compiled from "/var/www/maincp/client/templates/show_log.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14682291664d629464b8dc87-06840255%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '634eb9877503aa0e983dfc32b27619809dc59bbb' => 
    array (
      0 => '/var/www/maincp/client/templates/show_log.tpl',
      1 => 1298305936,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14682291664d629464b8dc87-06840255',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (isset($_smarty_tpl->getVariable('CONTARR',null,true,false)->value)){?>
<table style="border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: rgb(255, 255, 240); width:700px;" border="1" cellpadding="3" cellspacing="0">
		
<?php  $_smarty_tpl->tpl_vars['REC'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('CONTARR')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['LOG']['iteration']=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['REC']->key => $_smarty_tpl->tpl_vars['REC']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['LOG']['iteration']++;
?>
<tr><td><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['LOG']['iteration'];?>
</td><td><?php echo $_smarty_tpl->tpl_vars['REC']->value;?>
</td></tr>
<?php }} ?>

</table>

<?php }else{ ?>
<font class='error'>Log is empty</font>
<?php }?>