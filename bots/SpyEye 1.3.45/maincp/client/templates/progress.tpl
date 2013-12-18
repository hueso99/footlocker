<style>body { font-family: Verdana; font-size: 10px; background-color: #F7F7F7; }</style>
<div style='text-align:center;'>Complete : <span><img id='ref_to' src='./progress.php' style='vertical-align:middle;'></span></div>
<div id='progress' style='visibility:hidden;'><img src='1' id='ref_from'></div>
<script type="text/javascript" src="../scripts/jquery.js"></script>
<script>
function r(per)
{
	$("#progress").html("<img id='ref_from' src='./progress.php?per="+per+"' style='vertical-align:middle;'>");
	var x = $("#ref_from").attr('src');
	$("#ref_to").attr('src', x);
}
function SetResult(text)
{
	x = parent.document.getElementById('uploadResult');
	x.innerHTML = text;
	// show create task link/button
	t = parent.document.getElementById('task_div');
	t.style.visibility = 'visible';
}
ifrm = parent.document.getElementById('hiddenframe');
ifrm.style.height = 30;
</script>