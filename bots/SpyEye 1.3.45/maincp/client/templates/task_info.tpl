<br><hr color="#cccccc" size="1"><br>
{if isset($TASK)}

<table style="border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: rgb(255, 255, 240); width: 700px;" border="1" cellpadding="3" cellspacing="0">
<th width='40'>ID</th><th>FILE</th><th>HASH</th><th width='30'>Bots</th><th width='75'>Status</th>
<th width='50'>pe loader</th><th width='60'>replace exe</th><th>Info</th>
<tr>
	<td align='center'>{$TASK.tskId}</td>
	<td align='center'>{$TASK.fName}</td>
	<td align='center'>{$TASK.fMd5}</td>
	<td align='center'>{$TASK.bots_count}</td>
	<td><img src='./mod/progress.php?per={$TASK.COMPLETE}&per2={$TASK.FAILED}' title='{$TASK.oknum} ok : {$TASK.errnum} errors'></td>
	<td align='center'>{if $TASK.fType!='c'}{if $TASK.tskPeLoader == 1}yes{else}no{/if}{else}n/a{/if}</td>
	<td align='center'>{if $TASK.fType=='b'}{if $TASK.tskReplExe == 1}yes{else}no{/if}{else}n/a{/if}</td>
	<td align='center'>
		<img src='./img/icos/info.png' title='Show bots' onClick='load2("./mod/task_info_sub.php?tid={$TASK.tskId}","bots_info");'>
	</td>	
</tr>
</table>

<div id='bots_info'></div>

{else}
	<font class='error'>Task not found!</font>
{/if}