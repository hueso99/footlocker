<form id='frm_getlog'>
Select log: 
<select name='log'>
	<option value='e'>Error log</option>
	<option value='d'>Debug log</option>
	<option value='t'>Tasks log</option>
</select>
<input type='button' value=' Get Log ' id='btn_getlog'> 
<input type='button' value=' Clear Log ' id='btn_clearlog'> 
</form>
<div id='log_content'></div>
{literal}
<script>
	$("#btn_getlog").click(function() 
	{
		pdata = $('#frm_getlog').serialize(true);
		load('./mod/view_logs.php?'+pdata, 'log_content');
	});
	$("#btn_clearlog").click(function() 
	{
		pdata = $('#frm_getlog').serialize(true);
		load('./mod/clear_log.php?'+pdata, 'log_content');
	});	
</script>
{/literal}
