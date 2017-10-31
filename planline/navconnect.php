<?php

include "../navtransfer/msssqlconnect.php";

ini_set('display_errors', 1);

$connectNavision = new ClassConnectMSSQL();

echo phpinfo();

echo $connectNavision->ConnectMSSQLDb();

$res = $connectNavision->ExecuteQuery("SELECT JOBNo, TaskNo, ItemNo 
             FROM   [dbHela].[dbo].[HELA CLOTHING (PVT) LTD$JobTaskPlanning]");

echo mssql_num_rows($res);

echo "C";

?>
