{if isset($CONTARR)}
<table style="border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: rgb(255, 255, 240); width:700px;" border="1" cellpadding="3" cellspacing="0">
		
{foreach from=$CONTARR item=REC name=LOG}
<tr><td>{$smarty.foreach.LOG.iteration}</td><td>{$REC}</td></tr>
{/foreach}

</table>

{else}
<font class='error'>Log is empty</font>
{/if}