<?php
session_start();
include "../../../Connector.php";
$requestType = $_GET["RequestType"];

if($requestType=="AddToMainGrid")
{
$chemId 	= $_GET["ChemId"];
$unitId 	= $_GET["UnitId"];
$unitPrice 	= $_GET["UnitPrice"];
$prossId 	= $_GET["ProssId"];

	$sql="insert into was_chemical (intProcessId,intChemicalId,strUnit,dblQty,dblUnitPrice) values('$prossId','$chemId','$unitId','0','$unitPrice');";
	$results=$db->RunQuery($sql);
}
elseif($requestType=="RemoveItem")
{
$processId	= $_GET["ProcessId"];
$chemiId	= $_GET["ChemiId"];

	$sql="delete from was_chemical where intProcessId=$processId and intChemicalId=$chemiId";
	$results=$db->RunQuery($sql);
}
elseif($requestType=="UpdateRow")
{
$processId	= $_GET["ProssId"];
$chemiId	= $_GET["ChemId"];
$unitPrice	= $_GET["UnitPrice"];

	$sql="update was_chemical set dblUnitPrice=$unitPrice where intProcessId=$processId and intChemicalId=$chemiId";
	$results=$db->RunQuery($sql);
}
?>
