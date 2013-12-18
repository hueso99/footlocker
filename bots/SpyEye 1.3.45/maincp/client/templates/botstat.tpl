{literal}
<script type="text/javascript" src="scripts/scroll.js"></script>

<script type="text/javascript">
function ajaxScrollToRep(fromel) {
	scrollIt(fromel, 'trep');
}

function ajaxScrollToGT(toel) {
	scrollIt('gtlink', toel);
}
</script>
{/literal}

<table align='center' border='1' cellspacing='0' cellpadding='3' style='border: 1px solid gray; font-size: 9px; border-collapse: collapse; background-color: white;'>
<tr>
	<td align="left" width="150"><b>Online Bots for week</b></td>
	<td align="center" width="150">{$NUM_WEEK} ({$NUM_WEEK_PERC}%)</td>
</tr>
<tr>
	<td align="left"><b>Online Bots for 24 hours</b></td>
	<td align="center">{$NUM_24} ({$NUM_24_PREC}%)</td>
</tr>
<tr>
	<td align="left"><b>Activity Date</b></td>
	<td align="center">{$ACTIVITY_DATE}</td>
</tr>
</table>
<br>