<?php
session_start();

if(!isset($_SESSION["Server"]))
{
	//header('Location:' . $backwardseperator . 'login.php');
	include $backwardseperator . 'mobilogin.php';
	exit;
}
$authenticationApplied = true;
?>