<?php
	session_start();
include "HeaderDBManager.php";
$dbheader =  new HeaderDBManager();
$dbheader->SetConnectionString($_SESSION["Server"],$_SESSION["UserName"],$_SESSION["Password"],$_SESSION["Database"]);

?>