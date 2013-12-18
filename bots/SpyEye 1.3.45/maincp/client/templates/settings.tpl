<form id='frm_settings2'>
<input type=hidden name=isIni value=1>
<table>

{foreach from=$CONT_ARR key=KEY item=VALUE name=CFG}
	{if (strlen($VALUE)+5) > 60}{assign var='SIZE' value='60'}{else}{assign var='SIZE' value=strlen($VALUE)+5}{/if}
	{if $smarty.foreach.CFG.iteration == 1} {assign var='CATEGORY' value='default'}{include file='sett_cat.tpl'} {/if}
	{if $smarty.foreach.CFG.iteration == 4} {assign var='CATEGORY' value='update'}{include file='sett_cat.tpl'} {/if}
	{if $smarty.foreach.CFG.iteration == 6} {assign var='CATEGORY' value='interface'}{include file='sett_cat.tpl'} {/if}
	{if $smarty.foreach.CFG.iteration == 8} {assign var='CATEGORY' value='virtest'}{include file='sett_cat.tpl'} {/if}
	{if $smarty.foreach.CFG.iteration == 10} {assign var='CATEGORY' value='rdp:'}{include file='sett_cat.tpl'} {/if}
	{if $smarty.foreach.CFG.iteration == 16} {assign var='CATEGORY' value='bc:'}{include file='sett_cat.tpl'} {/if}	
	{if $smarty.foreach.CFG.iteration == 21} {assign var='CATEGORY' value='bc_stuff:'}{include file='sett_cat.tpl'} {/if}	
	{if $smarty.foreach.CFG.iteration == 24} {assign var='CATEGORY' value='jabber_notifier:'}{include file='sett_cat.tpl'} {/if}	
	<tr align="left"><td>{$KEY}:</td><td><input name="{$CATEGORY}|{$KEY}" id="{$CATEGORY}|{$KEY}" value="{$VALUE}" size="{$SIZE}"><br></td></tr>
{/foreach}

<tr><td colspan="2" align="center"><input type='submit' style='width:140px;' value='Save'></td></tr>
</table>
</form>


{if isset($MSG)}
<div align='left' height='30px' style='border-top: 1px solid black; padding: 2px; position: relative; background-color: rgb(231, 231, 231); bottom: -10px; left: -10px; right: -10px; margin-right: -20px; margin-bottom: 0px;'><font class='comment'><small><b>info: </b>{$MSG}</div>
{/if}

{literal}<script>
$(document).ready(function()
{
	$("#frm_settings2").submit(function()
	{
		pdata = $('#frm_settings2').serialize(true);
		$.post('./mod/settings.php', pdata, function(data) { $("#page_content").html(data); });
		return false;
	});
});
</script>{/literal}