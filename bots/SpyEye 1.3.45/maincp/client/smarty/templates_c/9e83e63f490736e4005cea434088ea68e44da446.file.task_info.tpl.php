<?php /* Smarty version Smarty-3.0.6, created on 2011-02-20 02:35:55
         compiled from "/var/www/maincp/client/templates/task_info.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8375912004d607e0b956d61-15231778%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9e83e63f490736e4005cea434088ea68e44da446' => 
    array (
      0 => '/var/www/maincp/client/templates/task_info.tpl',
      1 => 1298073570,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8375912004d607e0b956d61-15231778',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<br><hr color="#cccccc" size="1"><br>
<?php if (isset($_smarty_tpl->getVariable('TASK',null,true,false)->value)){?>

<table style="border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: rgb(255, 255, 240); width: 700px;" border="1" cellpadding="3" cellspacing="0">
<th width='40'>ID</th><th>FILE</th><th>HASH</th><th width='30'>Bots</th><th width='75'>Status</th>
<th width='50'>pe loader</th><th width='60'>replace exe</th><th>Info</th>
<tr>
	<td align='center'><?php echo $_smarty_tpl->getVariable('TASK')->value['tskId'];?>
</td>
	<td align='center'><?php echo $_smarty_tpl->getVariable('TASK')->value['fName'];?>
</td>
	<td align='center'><?php echo $_smarty_tpl->getVariable('TASK')->value['fMd5'];?>
</td>
	<td align='center'><?php echo $_smarty_tpl->getVariable('TASK')->value['bots_count'];?>
</td>
	<td><img src='./mod/progress.php?per=<?php echo $_smarty_tpl->getVariable('TASK')->value['COMPLETE'];?>
&per2=<?php echo $_smarty_tpl->getVariable('TASK')->value['FAILED'];?>
'></td>
	<td align='center'><?php if ($_smarty_tpl->getVariable('TASK')->value['fType']!='c'){?><?php if ($_smarty_tpl->getVariable('TASK')->value['tskPeLoader']==1){?>yes<?php }else{ ?>no<?php }?><?php }else{ ?>n/a<?php }?></td>
	<td align='center'><?php if ($_smarty_tpl->getVariable('TASK')->value['fType']=='b'){?><?php if ($_smarty_tpl->getVariable('TASK')->value['tskReplExe']==1){?>yes<?php }else{ ?>no<?php }?><?php }else{ ?>n/a<?php }?></td>
	<td align='center'>
		<img src='./img/icos/info.png' title='Show bots' onClick='load2("./mod/task_info_sub.php?tid=<?php echo $_smarty_tpl->getVariable('TASK')->value['tskId'];?>
","bots_info");'>
	</td>	
</tr>
</table>

<div id='bots_info'></div>

<?php }else{ ?>
	<font class='error'>Task not found!</font>
<?php }?>