<?php /* Smarty version Smarty-3.0.6, created on 2011-03-26 03:56:55
         compiled from "Z:/home/gate/www/client/templates\show_files.tpl" */ ?>
<?php /*%%SmartyHeaderCode:205324d8d39d7c73ef7-92296719%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0786b17df820574b2817a195d3b50ec76a0e8224' => 
    array (
      0 => 'Z:/home/gate/www/client/templates\\show_files.tpl',
      1 => 1299414903,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '205324d8d39d7c73ef7-92296719',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('upload_file.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<hr color="#dddddd" size="1"><br>
<?php if (isset($_smarty_tpl->getVariable('CONTARR',null,true,false)->value)){?>
<h2><b>Existing files</b></h2>
	<table style="border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: rgb(255, 255, 240);" border="1" cellpadding="3" cellspacing="0">
	<tr><th>ID</th><th>Name</th><th>Hash</th><th>Size (KB)</th><th>Type</th><th> </th></tr>
	<?php  $_smarty_tpl->tpl_vars['REC'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('CONTARR')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['REC']->key => $_smarty_tpl->tpl_vars['REC']->value){
?>
	<tr id='t<?php echo $_smarty_tpl->tpl_vars['REC']->value['ID'];?>
' align='center'><td><?php echo $_smarty_tpl->tpl_vars['REC']->value['ID'];?>
</td><td align='center'><?php echo $_smarty_tpl->tpl_vars['REC']->value['NAME'];?>
</td><td align='center'><?php echo $_smarty_tpl->tpl_vars['REC']->value['MD5'];?>
</td>
	<td align='center'><?php echo $_smarty_tpl->tpl_vars['REC']->value['SIZE'];?>
</td><td align='center'>
		<img src='img/<?php if ($_smarty_tpl->tpl_vars['REC']->value['TYPE']=='b'){?>icos/botsexe_16px.png<?php }elseif($_smarty_tpl->tpl_vars['REC']->value['TYPE']=='c'){?>icos/settings_16px.png<?php }else{ ?>icos/thirdpartysoftware_16px.png<?php }?>' title='<?php if ($_smarty_tpl->tpl_vars['REC']->value['TYPE']=='b'){?>Bots exe<?php }elseif($_smarty_tpl->tpl_vars['REC']->value['TYPE']=='c'){?>Settings<?php }else{ ?>Third party software<?php }?>'>	
	</td>
	<td><a href='javascript:void();' onclick="if (!confirm('Do you really want to delete this file?')) return false; DeleteFile(<?php echo $_smarty_tpl->tpl_vars['REC']->value['ID'];?>
); return false;"><img src='img/icos/delete.png' style='border:0px;'></a></td></tr>
	<?php }} ?>
	</table>
<?php }else{ ?>
	<font class='error'>There are no files</font>
<?php }?>
	<div id='del_file'></div>
	

<script>
function DeleteFile(id)
{
	var el = document.getElementById('t' + id);
	if (el) el.innerHTML = '';
	load2('./mod/file_del.php?id=' + id, 'del_file');
}
</script>
