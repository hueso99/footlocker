<?php /* Smarty version Smarty-3.0.6, created on 2011-02-19 20:40:00
         compiled from "/var/www/maincp/client/templates/clock.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5840804354d602aa0dea2d9-89304647%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6130893a6318a457d38d8a84799f84dc146f639f' => 
    array (
      0 => '/var/www/maincp/client/templates/clock.tpl',
      1 => 1297679041,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5840804354d602aa0dea2d9-89304647',
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
