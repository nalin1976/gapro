<?php
session_start();

if(!isset($_SESSION["Server"]))
{
	include $backwardseperator . 'login.php';
	exit;
}
$authenticationApplied = true;
?>