<?php /* Smarty version Smarty-3.0.6, created on 2011-03-26 03:56:32
         compiled from "Z:/home/gate/www/client/templates\clock.tpl" */ ?>
<?php /*%%SmartyHeaderCode:294934d8d39c0b5e738-75510587%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd38c5e5371eb5f2c7ec1121557fdc5819b5ca2d2' => 
    array (
      0 => 'Z:/home/gate/www/client/templates\\clock.tpl',
      1 => 1297679041,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '294934d8d39c0b5e738-75510587',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<table border="0" cellpadding="0" cellspacing="0" height="50px" width="100%">
			<tbody><tr>
			<td align="left"><table border="0" cellpadding="0" cellspacing="0" height="50px" width="100px">
<tbody><tr>
	<td style="background: url(&quot;img/p-clock-p1.png&quot;) no-repeat scroll 0% 0% transparent;" title="Server's time" width="39px"></td>
	<td style="background: url(&quot;img/p-clock-p2.png&quot;) no-repeat scroll 0% 0% transparent;" id="time" title="Server's time" width="61px"><font style="font-size: 8px;"><div style='text-align:center;' id='clock'><b><?php echo $_smarty_tpl->getVariable('YEAR')->value;?>
<br><?php echo $_smarty_tpl->getVariable('MONTH')->value;?>
/<?php echo $_smarty_tpl->getVariable('DAY')->value;?>
<br><?php echo $_smarty_tpl->getVariable('TIME')->value;?>
</b></div></font></td>

</tr>
</tbody></table>
