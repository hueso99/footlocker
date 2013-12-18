<?php /* Smarty version Smarty-3.0.6, created on 2011-03-26 03:56:32
         compiled from "Z:/home/gate/www/client/templates\bots-qview.tpl" */ ?>
<?php /*%%SmartyHeaderCode:255464d8d39c0c36db4-58538043%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'da87ef7ec7b99dad90608c8566bcde26d93181a3' => 
    array (
      0 => 'Z:/home/gate/www/client/templates\\bots-qview.tpl',
      1 => 1298151407,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '255464d8d39c0c36db4-58538043',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<table cellspacing="0" cellpadding="0" border="0" width="100px" height="50px">
<tr>
	<td width="43px" style='background: url("img/p-botsqview-p1.png"); background-repeat: no-repeat;' title="Online bots and All bots"></td>
	<td width="57px" style='background: url("img/p-botsqview-p2.png"); background-repeat: no-repeat;' id='bstat' title="Online bots and All bots">
	<div style='font-weight:bold;text-align:center' id='bot_info'><b><?php echo $_smarty_tpl->getVariable('COUNT1')->value;?>
<br><?php echo $_smarty_tpl->getVariable('COUNT2')->value;?>
</b></div>
	</td>
</tr>
</table>
