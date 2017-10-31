<?php
	
	session_start();
	
	foreach($_SESSION as $key => $var) {
		echo $key." = ".$var."<br>\n";
	}
	
	
?>