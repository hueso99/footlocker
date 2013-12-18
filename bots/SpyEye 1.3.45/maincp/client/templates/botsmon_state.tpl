<table width='100%' border='1' cellspacing='0' cellpadding='0' style='border: 1px solid gray; font-size: 9px; border-collapse: collapse; background-color: #F4F4F4;'>
<th width='200px' style='background-color: #DDD;'>State</th>
<th style='background-color: #DDD;'>Online Bots/All Bots</td></th>

	{foreach from=$CONT_ARR item=REC}
		<tr align='center'><td> {$REC.MRES_ST}</td><td>({$REC.ACTB_CNT}/{$REC.ALLB_CNT})</td></tr>
	{/foreach}
	
</table>