<?php

$id = $_GET['id'];
if (!@$id)
	exit;
$dt = $_GET['dt'];
if (!@$dt)
	exit;

require_once 'mod_dbase.php';

header("Content-Type: image/png");

$dbase = db_open();

$sql = "SELECT img FROM scr_$dt WHERE id = $id LIMIT 1";
$res = mysqli_query($dbase, $sql);
if ((!(@($res))) || !mysqli_num_rows($res)) {
	exit;
}
list($img) = mysqli_fetch_row($res);

db_close($dbase);

echo $img;

?>