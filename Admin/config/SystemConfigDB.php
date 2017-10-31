<?php
session_start();
include "../../Connector.php";	
$option=$_GET["opt"];

	
if($option=="save")
{	
	$currency=$_GET["currency"];
	$country=$_GET["country"];
	$_SESSION["sys_currency"] =$currency;
	$_SESSION["sys_country"] =$country;
	$check_db="select intBaseCurrency from systemconfiguration ";
	$results_check=$db->RunQuery($check_db);
	if(mysql_num_rows($results_check)>0)
		$str="update systemconfiguration set intBaseCurrency = '$currency',intBaseCountry='$country'";
	else
		$str="insert into systemconfiguration (intBaseCurrency,intBaseCountry)values('$currency','$country');";
	$results=$db->RunQuery($str);
	if($results)
		echo"Saved successfully.";
	else
		echo"error!";

	$sql="select currencyID from exchangerate where currencyID='$currency' and dateFrom=now()";
	$result=$db->RunQuery($sql);
	$booAvailable = false;
	while($row=mysql_fetch_array($result))
	{
		$booAvailable = true;
	}
	$dateFrom =  date(Y.'-'.m.'-'.d);
	updateStatus($currency,$dateFrom);
	if($booAvailable)
	{
		$sql="update exchangerate set intStatus=1 where currencyID='$currency' and dateFrom=now();";
		$results=$db->RunQuery($sql);
	}
	else
	{
		$sql="insert into exchangerate (currencyID,dateFrom,rate,intStatus)values ('$currency',now(),'1','1');";
		$results=$db->RunQuery($sql);
	}
}
function updateStatus($CurrencyID,$Dfrom)
{
	$SQL = "update exchangerate 
	set
	intStatus = '0'
	
	where
	currencyID = '$CurrencyID' and dateFrom<>'$Dfrom'";
	
	global $db;
	$db->RunQuery($SQL);
	
}	
?>