<?	
	include_once "../common.php";
	include_once ROOT_PATH."/mod/functs.php";
	if( !$user->Check() ) exit;
	error_reporting(E_ERROR);
	
	if (function_exists('curl_init') === false)
		die("<font class='error'>ERROR</font> : Plz, install CURL for PHP");

	$_file = $_POST['file'];
	if (!@$_file || !strlen($_file)) 
		$sql = "SELECT fName, fCont FROM files_t WHERE fName NOT LIKE 'config.bin%' ORDER BY fId DESC LIMIT 1";
	else
		$sql = "SELECT fName, fCont FROM files_t WHERE fName='$_file' LIMIT 1";
	$res = $db->query($sql);
	
	if (@$res && $db->affected_rows) list($_file, $filedata) = $res->fetch_row();
	else die('<font class="error">Select correct file</font>');
	
	if (!@$_file || !strlen($_file)) die("<font class='error'>ERROR</font> : file var is empty");	
	
	$icfg = $db->GetConfigs();
	$_login = $icfg['login'];
	$_password = $icfg['password'];
	if (!strlen($_login) || !strlen($_password)) 
		die("<font class='error'>ERROR</font> : login or password to virtest2.com is empty. Plz, check your settings");

	if ($filedata === FALSE) 
		die("<font class='error'>ERROR</font> : cannot read file");

	//$file_upload = ROOT_PATH.'/bin/upload/virtest'.time().'.dat';
	$file_upload = sys_get_temp_dir() . '/virtest'.time().'.dat';
	$upload_res = file_put_contents($file_upload, $filedata);
	$file_absolute = $file_upload;
	if ($upload_res === FALSE) die("<font class='error'>ERROR</font> : cannot save file at \"$file_upload\"");

	//Следующие строки включить вверх вашего скрипта, который будет заниматься передачей данных и парсингом результата
	set_time_limit(0);
	$url="http://virtest2.com/curl.php";
	$avers_arr=array('a'=>'NOD32', 'b'=>'IKARUS', 'c'=>'VirusBuster', 
'd'=>'DrWeb', 'e'=>'Avast', 'f'=>'McAfee', 'g'=>'BitDefender', 'h'=>'Sophos', 'i'=>'eTrust', 
'j'=>'AVG8', 'k'=>'ClamWin', 'l'=>'KAV8', 'm'=>'SAV', 'n'=>'Vba32', 'o'=>'F-Prot', 
'p'=>'A-Squared', 'q'=>'TrendMicro', 'r'=>'F-Secure', 's'=>'OneCare', 't'=>'Avira', 'u'=>'Ewido', 'v'=>'Panda', 'w'=>'Vexira', 'x'=>'Norman', 'y'=>'Solo', 'z'=>'ArcaVir',
'1'=>'Webroot', '2'=>'TrendMicro2010', '3'=>'Comodo', '4'=>'Rising', '5'=>'QuickHeal', '6'=>'DigitalPatrol', '7'=>'GData', '8'=>'AVL', '9'=>'IkarusT3', '0' => 'ZoneAlarm', '!'=>'AhnLabV3', '-' => 'Emsisoft', '+' => 'SAS', '*' => 'ViRobot');

	//Заполнять только эти четыре параметра
	$username=$_login;
	$password=$_password;
	/*В переменную Avers складываются ключи массива $avers_arr, только те, которые соответсвуют антивирусым, которыми надо проверить. Например, нужно проверить Докотор Вебом и касперским. Смотрим ыв массив: 'd'=>'DrWeb',...'l'=>'KAV8'. Передаем 'dl'*/
	$avers='abcdefghijklmnopqrstuvwxyz1234567890!-+*'; //all AV
	//Строго полный путь к файлу. С виндовым стилем написание для винодус-сервера, с линуксовыми путьями для Unix
	$file = $file_absolute;
	//$file = str_replace(' ', '\ ', $file);
	//$file = str_replace('!', '\!', $file);
	
	/*Главная функа. Возвращает результут передачи данных в массиве. Первые элемент массива - Success при удачной проверке, Код ошибки и ее описания, в случае какой-нибудь ошибки. Далее следует массив, первый элемент которого - тип аккаунта, второй - срок его истечения. Далее следует массив из результатов проверки выбранными аверями, включающий сназвание аверя, сигнатуру, результат.
	$res=array('Success|Error', array('тип аккаунта', 'срок истечения'), array('Аверь один - сигнатура - результат', 'Аверь2 -сигнатуры - результат' ....))
	*/
	function get_res($username, $password, $avers, $file) 
	{
		global $avers_arr, $url;

		$ch = curl_init($url);
		$post = array('file'=>"@".$file,'username'=>$username, 'password'=>$password, 'avers'=>$avers);
		//echo "<pre>" . print_r($post) . "</pre>";
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$postResult = curl_exec($ch); 
		echo "<!--$postResult-->";
		curl_close($ch);

		$res=array('', array(), array());
		preg_match('#Error\:\s+(.+)#', $postResult, $arr);
		if ($arr[1])
		{$res[0]=$arr[1];}
		else
		{$res[0]='Success';}
		preg_match('#(Vip|Premium)\:\s+([\.\d]+)#', $postResult, $arr);
		$res[1][0]=$arr[1];
		$res[1][1]=$arr[2];
		
		preg_match_all('#[\w\!\-\+]#', $avers, $arr);
		for ($i=0; $i<count($arr[0]); $i++)
		{
		
		preg_match('#'.$avers_arr[$arr[0][$i]].'(.+)#', $postResult, $arr1);
		$res[2][$i]=$arr1[0];
		
		}
		return $res;
	}

	//выведем для наглядности результат
	$res = get_res($username, $password, $avers, $file);

	$err = "";
	if (!strlen($res[1][0])) $err = "<font class='error'>Plz, check your balance</font>";
	else if (strpos($res[0], 'often') !== false) $err = "<font class='error'>You can't scan that often</font>";

	if (strlen($err))
	{
		echo $err;
		unlink($file_upload);
		exit;
	}
	
	$smarty->assign(array('RES_0'=>$res[0], 'RES_1_0'=>$res[1][0], 'RES_1_1'=>$res[1][1]));

	$fuck = 0;
	$RES = array();
	for ($i=0; $i<count($res[2]); $i++) 
	{
		$str = $res[2][$i];
		$pos0 = 0;
		$pos1 = strpos($str, ' ');
		$av = substr($str, $pos0, $pos1);
		$pos0 = $pos1 + 1;
		$pos1 = strpos($str, ' ', $pos0);
		$pos1 = strpos($str, ' ', $pos1 + 1);
		$sig = substr($str, $pos0, $pos1 - $pos0);
		$pos0 = $pos1 + 1;
		$pos1 = strpos($str, ' ', $pos0);
		$file = '';
		$result = '';
		if ($pos1 == 0) 
		{
			$file = '';
			$result = '-';
			$ok = true;
		}
		else 
		{
			$data = substr($str, $pos0);
			if (substr($data, 0, 10) == 'Scan Error') {
				$file = '';
				$result = $data;
				$ok = true;
			}
			else {
				echo "<!--$data-->";
				$split = preg_split('/<br \/>/', $data);
				for ($j=0; $j<count($split); $j++) {
					$data_sub =  $split[$j];
					$split_sub = preg_split('/ /', $data_sub, 2);
					if (strlen($file)) $file .= '<br>';
					if (strlen($result)) $result .= '<br>';
					$file .= $split_sub[0];
					$result .= $split_sub[1];
				}
				$ok = false;
				$fuck++;
			}
		}
		
		if ($ok) $style = " style='background-color:#D4FBE2;'";
		else $style = " style='background-color:#F9D8DC;'";
		
		$RES[] = array('STYLE'=>$style, 'AV'=>$av, 'SIG'=>$sig, 'FILE'=>$file, 'RESULT'=>$result);
	}
	$smarty->assign('CONT_ARR', $RES);
	
	if ($fuck != 0) $style = " style='color: rgb(250,100,100);'";
	else $style = " style='color: rgb(100,250,100);'";

	$smarty->assign(array('STYLE'=>$style, 'FUCK'=>$fuck, 'I'=>$i));
	$smarty->display('virtestrun.tpl');

	unlink($file_upload);
?>