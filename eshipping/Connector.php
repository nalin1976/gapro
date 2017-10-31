<?php
session_start();
include "DBManager.php";
$db =  new DBManager();
$db->SetConnectionString($_SESSION["Server"],$_SESSION["UserName"],$_SESSION["Password"],$_SESSION["Database"]);

/*$msdb = new DBManager();
$msdb->SetConnectionStringMS('localhost','root','','export_data');*/

//$branchdb = new DBManager();
//$branchdb->SetConnectionStringBranch('',$_SESSION["UserName"],$_SESSION["Password"],$_SESSION["Database"]);

$msdb = new DBManager();
$msdb->SetConnectionStringMS('192.168.1.5','exportuser','export123','EXPORT_DATA');

?>