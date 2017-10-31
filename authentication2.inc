<?php
session_start();

$main_url_project = substr($_SERVER["REQUEST_URI"],1,strpos($_SERVER["REQUEST_URI"],'/',1)-1);

if(!isset($_SESSION["Server"]) || !($main_url_project==$_SESSION["Project"]))
{
	include 'login.php';
	exit;
}
$authenticationApplied = true;
?>