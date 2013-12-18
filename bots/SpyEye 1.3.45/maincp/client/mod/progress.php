<?
	if(!isset($_GET['per'])) $per = 0; else $per = $_GET['per'];
	$im = ImageCreateFromPng("../img/progress.png");
	$green = ImageColorAllocate($im, 100, 255, 100);
	$red = ImageColorAllocate($im, 255, 100, 100);
	$black = ImageColorAllocate($im, 0, 0, 0);
	$text = ($per*100)."%";
	$x = 38 - strlen($text)*3;
	
	ImageFilledRectangle($im,4,4,($per==0 ? 4 : 4+round(68*$per)),10,$green);
	
	if(isset($_GET['per2']))
	{
		$per2 = $_GET['per2'];
		$pos2 = $per==0 ? 4 : 4+round(68*$per);
		ImageFilledRectangle($im, $pos2, 4, $pos2+round(68*$per2),10, $red);
	}
	else ImageString($im, 3, $x, 0, $text, $black);		
	Header("Content-type: image/png");
	ImagePng($im);
	ImageDestroy($im);
?>