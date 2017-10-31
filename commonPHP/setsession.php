<?php
session_start();
include "Connector.php";	

$check_db="select intBaseCurrency,intBaseCountry from systemconfiguration";
$results_check=$db->RunQuery($check_db);
$row_sys=mysql_fetch_array($results_check);
$currency=$row_sys["intBaseCurrency"];
$country=$row_sys["intBaseCountry"];
$_SESSION["sys_currency"] =$currency;
$_SESSION["sys_country"] =$country;
?>
