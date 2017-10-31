<?php
session_start();
include "DBManager.php";
$db =  new DBManager();
$db->SetConnectionString($_SESSION["Server"],$_SESSION["UserName"],$_SESSION["Password"],$_SESSION["Database"]);

?>