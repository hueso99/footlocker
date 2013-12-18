<?php /* Smarty version Smarty-3.0.6, created on 2011-02-19 21:05:52
         compiled from "/var/www/maincp/client/templates/botstat.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13377103754d6030b0088e96-36133908%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '32581087f1ba50e7c0d559a1df6905e9418d81b7' => 
    array (
      0 => '/var/www/maincp/client/templates/botstat.tpl',
      1 => 1295021524,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13377103754d6030b0088e96-36133908',
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