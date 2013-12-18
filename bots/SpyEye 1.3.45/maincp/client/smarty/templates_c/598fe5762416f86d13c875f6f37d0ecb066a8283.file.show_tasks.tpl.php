<?php /* Smarty version Smarty-3.0.6, created on 2011-03-26 04:18:43
         compiled from "Z:/home/gate/www/client/templates\show_tasks.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21774d8d3ef3b4cb96-88234807%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '598fe5762416f86d13c875f6f37d0ecb066a8283' => 
    array (
      0 => 'Z:/home/gate/www/client/templates\\show_tasks.tpl',
      1 => 1298073461,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21774d8d3ef3b4cb96-88234807',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1>Task list</h1>
<table style="border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: rgb(255, 255, 240); width: 700px;" border="1" cellpadding="3" cellspacing="0">
<th style='width:30px;'>#</th>
<th style='width:40px;'>ID</th>
<th style='width:30px;'>Type</th>
<th>Note</th>
<th style='width:130px;'>Date</th>
<th style='width:40px;'>Control</th>
<th style='width:20px;'>Info</th>
<th style='width:20px;'>Stat</th>
<th style='width:20px;'>Del</th>

<?php  $_smarty_tpl->tpl_vars['TASK'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('TASKS')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['tasks']['iteration']=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['TASK']->key => $_smarty_tpl->tpl_vars['TASK']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['tasks']['iteration']++;
?>
	<tr id='t<?php echo $_smarty_tpl->tpl_vars['TASK']->value['tskId'];?>
'>
	<td style='text-align:center;'><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['tasks']['iteration'];?>
</td>
	<td style='text-align:center;'><?php echo $_smarty_tpl->tpl_vars['TASK']->value['tskId'];?>
</td>
	<td align='center'><img src='img/<?php if ($_smarty_tpl->tpl_vars['TASK']->value['fType']=='b'){?>icos/botsexe_16px.png<?php }elseif($_smarty_tpl->tpl_vars['TASK']->value['fType']=='c'){?>icos/settings_16px.png<?php }else{ ?>icos/thirdpartysoftware_16px.png<?php }?>' title='<?php if ($_smarty_tpl->tpl_vars['TASK']->value['fType']=='b'){?>Bots exe<?php }elseif($_smarty_tpl->tpl_vars['TASK']->value['fType']=='c'){?>Settings<?php }else{ ?>Third party software<?php }?>'></td>
	<td><?php echo $_smarty_tpl->tpl_vars['TASK']->value['tskComment'];?>
</td>
	<td align='center'><?php echo $_smarty_tpl->tpl_vars['TASK']->value['tskDate'];?>
</td>
	<td align='center'>
	<?php if ($_smarty_tpl->tpl_vars['TASK']->value['tskState']==1){?>
		<div style='cursor:pointer;' id='playstop<?php echo $_smarty_tpl->tpl_vars['TASK']->value['tskId'];?>
' onClick='PlayStop(<?php echo $_smarty_tpl->tpl_vars['TASK']->value['tskId'];?>
)'><img src='img/icos/stop_16px.png' title='Stop'></div>
	<?php }else{ ?>
		<div style='cursor:pointer;' id='playstop<?php echo $_smarty_tpl->tpl_vars['TASK']->value['tskId'];?>
' onClick='PlayStop(<?php echo $_smarty_tpl->tpl_vars['TASK']->value['tskId'];?>
)'><img src='img/icos/play_16px.png' title='Play'></div>
	<?php }?></td>
	<td align='center'>
		<img src='./img/icos/info.png' title='Task #<?php echo $_smarty_tpl->tpl_vars['TASK']->value['tskId'];?>
 Info' onClick='load2("./mod/task_info.php?tid=<?php echo $_smarty_tpl->tpl_vars['TASK']->value['tskId'];?>
","task_info");'>
	</td>
	<td align='center'>
		<img src='./img/icos/stat.png' title='Task #<?php echo $_smarty_tpl->tpl_vars['TASK']->value['tskId'];?>
 Info' onClick='load2("./mod/stat_b_sub_graph.php?tid=<?php echo $_smarty_tpl->tpl_vars['TASK']->value['tskId'];?>
","task_info");'>
	</td>	
	<td align='center'>
		<a href="javascript:void();" onclick="if (!confirm('Do you really want to delete this task?')) return false; 
		DeleteTask(<?php echo $_smarty_tpl->tpl_vars['TASK']->value['tskId'];?>
); return false;"><img src='./img/icos/delete.png'></a></td>
	</tr>
<?php }} else { ?>
	<tr><td colspan='9' class='error' align='center'>There are no tasks</td></tr>
<?php } ?>
</table>

<div id='actions' class='error'></div>
<div id='task_info'></div>


<style>
img {border:0px; vertical-align:middle;}
</style>

<script>
function DeleteTask(id)
{
	var el = document.getElementById('t' + id);
	if (el) el.innerHTML = '';
	load('./mod/task_del.php?del=' + id, 'task_info');
}
function PlayStop(id)
{ 
	status = $('#playstop'+id).html();
	if( status.indexOf('stop') != -1)
	{
		$('#playstop'+id).html("<img src='img/icos/play_16px.png' title='Play'>");
		$('#actions').load('./mod/task_playstop.php?ps=0&task='+id, 'actions');
	}
	else
	{
		$('#playstop'+id).html("<img src='img/icos/stop_16px.png' title='Stop'>");
		$('#actions').load('./mod/task_playstop.php?ps=1&task='+id, 'actions');
	}
}
</script>
