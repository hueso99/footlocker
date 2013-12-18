<?php
require_once('safe.php');

function rechte_abfragen($was){
	if(!$_SESSION['admin']){
		$user = $_SESSION['secuser'];
		$ddos_abfrage = mysql_query("SELECT * FROM users WHERE user = '".safe_sql($user)."' AND rechte LIKE '%".safe_sql($was)."%'");
			
		if(!mysql_num_rows($ddos_abfrage)){
			echo '<h1>Die Funktion wurde vom Administrator gesperrt!</h1>';
			exit();
		}
	}
}

function profil_rechte($was){
	if(!$_SESSION['admin']){
		$user = $_SESSION['secuser'];
		$ddos_abfrage = mysql_query("SELECT * FROM users WHERE user = '".safe_sql($user)."' AND rechte LIKE '%".safe_sql($was)."%'");
			
		if(mysql_num_rows($ddos_abfrage)){
			return true;
		}
	}
}
?>