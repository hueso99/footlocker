<?php 
error_reporting(0);
$FileType = $_FILES['upfile']['name'];
If (strpos($FileType , ".txt") !== false) {$FileType = ".txt";}Else{$FileType = ".jpg";}
$dir = getcwd();
$dir = $dir."/";
$tmp_name = $_FILES['upfile']['tmp_name'];
$new_name = $_SERVER['REMOTE_ADDR']."-".date("Y-m-d-h-i-s").$FileType;
move_uploaded_file($tmp_name,$dir.$new_name);
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data"><input type="file" name="upfile" /></form> 