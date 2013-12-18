<br><hr color="#cccccc" size="1">
<h2><b>Reports</b></h2>
<table style="border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: rgb(255, 255, 240); width: 600px;" border="1" cellpadding="3" cellspacing="0">
<th width='30'>#</th><th>GUID</th><th>Report data</th><th width='130'>Date</th>

{foreach from=$REPORTS item=REP name=reports}
	<tr>
	<td align='center'>{$smarty.foreach.reports.iteration}</td>
	<td align='center'>{$REP.guid_bot}</td>
	<td align='center'>{$REP.data_rep}</td>
	<td align='center'>{$REP.date_rep}</td>
	</tr>
{foreachelse}
	<tr><td colspan='5' class='error' align='center'>There are no reports</td></tr>	
{/foreach}

</table>
