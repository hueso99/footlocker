<?php /* Smarty version Smarty-3.0.6, created on 2011-03-26 04:40:54
         compiled from "Z:/home/gate/www/client/templates\botstat.tpl" */ ?>
<?php /*%%SmartyHeaderCode:65494d8d44265b28b4-50254766%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b3937405a8fca8974c3b6b9856be6c5ca501ccf2' => 
    array (
      0 => 'Z:/home/gate/www/client/templates\\botstat.tpl',
      1 => 1295021524,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '65494d8d44265b28b4-50254766',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<script type="text/javascript" src="scripts/scroll.js"></script>

<script type="text/javascript">
function ajaxScrollToRep(fromel) {
	scrollIt(fromel, 'trep');
}

function ajaxScrollToGT(toel) {
	scrollIt('gtlink', toel);
}
</script>


<table align='center' border='1' cellspacing='0' cellpadding='3' style='border: 1px solid gray; font-size: 9px; border-collapse: collapse; background-color: white;'>
<tr>
	<td align="left" width="150"><b>Online Bots for week</b></td>
	<td align="center" width="150"><?php echo $_smarty_tpl->getVariable('NUM_WEEK')->value;?>
 (<?php echo $_smarty_tpl->getVariable('NUM_WEEK_PERC')->value;?>
%)</td>
</tr>
<tr>
	<td align="left"><b>Online Bots for 24 hours</b></td>
	<td align="center"><?php echo $_smarty_tpl->getVariable('NUM_24')->value;?>
 (<?php echo $_smarty_tpl->getVariable('NUM_24_PREC')->value;?>
%)</td>
</tr>
<tr>
	<td align="left"><b>Activity Date</b></td>
	<td align="center"><?php echo $_smarty_tpl->getVariable('ACTIVITY_DATE')->value;?>
</td>
</tr>
</table>
<br>