<?php
session_start();
include "../../Connector.php";
$requestType = $_GET["RequestType"];
$userId		= $_SESSION["UserID"];
if($requestType=="SaveHeader")
{
$costNo		= explode('/',$_GET["CostNo"]);
$mrnNo		= $_GET["MRNNo"];
$mrnYear	= $_GET["MRNYear"];
$orderId	= $_GET["OrderId"];
	$sql="insert into was_matrequisitionheader (intMRNNo,intMRNYear,intCostNo,intCostYear,intStyleId,intUserId,dtmDate)values('$mrnNo','$mrnYear','$costNo[1]','$costNo[0]',$orderId,$userId,now());";
	$result=$db->RunQuery($sql);
}
elseif($requestType=="SaveDetails")
{
$mrnNo		= $_GET["MRNNo"];
$mrnYear	= $_GET["MRNYear"];
$chemId		= $_GET["ChemId"];
$unitId		= $_GET["UnitId"];
$mrnQty		= $_GET["MrnQty"];
$sql="insert into was_matrequisitiondetails(intMRNNo,intMRNYear,intChemicalId,intUnitId,dblMrnQty,dblMrnBalQty)values('$mrnNo','$mrnYear','$chemId','$unitId','$mrnQty','$mrnQty');";
$result=$db->RunQuery($sql);
echo "Saved Successfully.";
}
?>