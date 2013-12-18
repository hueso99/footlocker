<?php /* Smarty version Smarty-3.0.6, created on 2011-02-19 18:58:27
         compiled from "/var/www/maincp/client/templates/settings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6508617714d6012d3aadb59-91130733%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e9f969a4ae2d4b160ee408deb3a806f984811390' => 
    array (
      0 => '/var/www/maincp/client/templates/settings.tpl',
      1 => 1298141697,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6508617714d6012d3aadb59-91130733',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<form id='frm_settings2'>
<input type=hidden name=isIni value=1>
<table>

<?php  $_smarty_tpl->tpl_vars['VALUE'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['KEY'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('CONT_ARR')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['CFG']['iteration']=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['VALUE']->key => $_smarty_tpl->tpl_vars['VALUE']->value){
 $_smarty_tpl->tpl_vars['KEY']->value = $_smarty_tpl->tpl_vars['VALUE']->key;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['CFG']['iteration']++;
?>
	<?php if ((strlen($_smarty_tpl->tpl_vars['VALUE']->value)+5)>60){?><?php $_smarty_tpl->tpl_vars['SIZE'] = new Smarty_variable('60', null, null);?><?php }else{ ?><?php $_smarty_tpl->tpl_vars['SIZE'] = new Smarty_variable(strlen($_smarty_tpl->tpl_vars['VALUE']->value)+5, null, null);?><?php }?>
	<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['CFG']['iteration']==1){?> <?php $_smarty_tpl->tpl_vars['CATEGORY'] = new Smarty_variable('default', null, null);?><?php $_template = new Smarty_Internal_Template('sett_cat.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?> <?php }?>
	<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['CFG']['iteration']==4){?> <?php $_smarty_tpl->tpl_vars['CATEGORY'] = new Smarty_variable('update', null, null);?><?php $_template = new Smarty_Internal_Template('sett_cat.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?> <?php }?>
	<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['CFG']['iteration']==6){?> <?php $_smarty_tpl->tpl_vars['CATEGORY'] = new Smarty_variable('interface', null, null);?><?php $_template = new Smarty_Internal_Template('sett_cat.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?> <?php }?>
	<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['CFG']['iteration']==8){?> <?php $_smarty_tpl->tpl_vars['CATEGORY'] = new Smarty_variable('virtest', null, null);?><?php $_template = new Smarty_Internal_Template('sett_cat.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?> <?php }?>
	<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['CFG']['iteration']==10){?> <?php $_smarty_tpl->tpl_vars['CATEGORY'] = new Smarty_variable('Rdp:', null, null);?><?php $_template = new Smarty_Internal_Template('sett_cat.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?> <?php }?>
	<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['CFG']['iteration']==16){?> <?php $_smarty_tpl->tpl_vars['CATEGORY'] = new Smarty_variable('bc:', null, null);?><?php $_template = new Smarty_Internal_Template('sett_cat.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?> <?php }?>	
	<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['CFG']['iteration']==21){?> <?php $_smarty_tpl->tpl_vars['CATEGORY'] = new Smarty_variable('bc_stuff:', null, null);?><?php $_template = new Smarty_Internal_Template('sett_cat.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?> <?php }?>	
	<tr align="left"><td><?php echo $_smarty_tpl->tpl_vars['KEY']->value;?>
:</td><td><input name="<?php echo $_smarty_tpl->getVariable('CATEGORY')->value;?>
|<?php echo $_smarty_tpl->tpl_vars['KEY']->value;?>
" id="<?php echo $_smarty_tpl->getVariable('CATEGORY')->value;?>
|<?php echo $_smarty_tpl->tpl_vars['KEY']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['VALUE']->value;?>
" size="<?php echo $_smarty_tpl->getVariable('SIZE')->value;?>
"><br></td></tr>
<?php }} ?>

<tr><td colspan="2" align="center"><input type='submit' style='width:140px;' value='Save'></td></tr>
</table>
</form>


<?php if (isset($_smarty_tpl->getVariable('MSG',null,true,false)->value)){?>
<div align='left' height='30px' style='border-top: 1px solid black; padding: 2px; position: relative; background-color: rgb(231, 231, 231); bottom: -10px; left: -10px; right: -10px; margin-right: -20px; margin-bottom: 0px;'><font class='comment'><small><b>info: </b><?php echo $_smarty_tpl->getVariable('MSG')->value;?>
</div>
<?php }?>

<script>
$(document).ready(function()
{
	$("#frm_settings2").submit(function()
	{
		pdata = $('#frm_settings2').serialize(true);
		$.post('./mod/settings.php', pdata, function(data) { $("#page_content").html(data); });
		return false;
	});
});
</script>