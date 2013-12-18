<h2><b>Server</b>: {$HOST}</h2>
<hr size='1' color='#CCCCCC'>

<table width="720px" cellspacing="0" cellpadding="0" border="1" style="border: 1px solid gray; font-size: 9px; border-collapse: collapse; background-color: white;">

<th width='20px' style='background: rgb(80,80,80); color: rgb(232,232,232);'>#</th>
<th width='480px' style='background: rgb(80,80,80); color: rgb(232,232,232);'>Bot GUID</th>
{if isset($SHOW_BOTS_IP)}
	<th width='180px' style='background: rgb(80,80,80); color: rgb(232,232,232);'>Bot Ip</th>
{/if}
<th width='220px' style='background: rgb(80,80,80); color: rgb(232,232,232);'>IP:Port for use</th>

{$GEOIP}

{foreach from=$CONT_ARR item=REC}
<tr><td align='center'>{$REC.I}</td><td align='center'>{$REC.GUID}</td>
{if isset($SHOW_BOTS_IP)}
	<td align='center'>{$REC.IP}</td>
{/if}
<td align='center'><input readonly value='{$REC.HOST}:{$REC.PORT}' style='width: 140px; background: rgb(0,0,0); color: rgb(0,255,0);'></td>{$REC.SCGEO}</tr>
{foreachelse}
<tr><td colspan='{$COLS}' class='error' style='text-align:center;'>There are no FTPs</td></tr>
{/foreach}

</table>