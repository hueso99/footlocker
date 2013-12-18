<?php
function safe_sql($value){
   return mysql_real_escape_string($value);
} 

function safe_xss($value){
	return htmlspecialchars($value);
}
?>