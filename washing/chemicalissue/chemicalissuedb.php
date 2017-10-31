<?php
session_start();
include "../../Connector.php";
$requestType = $_GET["RequestType"];
$userId		= $_SESSION["UserID"];
$factoryId = $_SESSION["FactoryID"];

if($requestType=="SaveHeader")
{
$mrnNo		= explode('/',$_GET["MrnNo"]);
$costNo		= explode('/',$_GET["CostNo"]);
$issueNo	= $_GET["IssueNo"];
$issueYear	= $_GET["IssueYear"];
$orderId	= $_GET["OrderId"];

	$sql="insert into was_chemissueheader (intIssueNo,intIssueYear,intMRNNo,intMRNYear,intCostNo,intCostYear,intStyleId,intUserId,dtmDate,intStatus)values($issueNo,$issueYear,$mrnNo[1],$mrnNo[0],$costNo[1],$costNo[0],$orderId,$userId,now(),1);";
	$result=$db->RunQuery($sql);
}
elseif($requestType=="SaveDetails")
{
$issueNo		= $_GET["IssueNo"];
$issueYear		= $_GET["IssueYear"];
$chemId			= $_GET["ChemId"];
$unitId			= $_GET["UnitId"];
$isssueQty		= $_GET["IsssueQty"];
$mrnNo			= explode('/',$_GET["MRNNo"]);
$year 			= date('Y');
$sql="insert into was_chemissuedetails (intIssueNo,intIssueYear,intChemicalId,intUnitId,dblQty,dblBalQty)values($issueNo,$issueYear,$chemId,'$unitId',$isssueQty,$isssueQty);";
$result=$db->RunQuery($sql);

$sql="update was_matrequisitiondetails set dblMrnBalQty = dblMrnBalQty-$isssueQty where intMRNNo=$mrnNo[1] and intMRNYear=$mrnNo[0] and intChemicalId=$chemId";
$result=$db->RunQuery($sql);

$sql="insert into genstocktransactions (intYear,strMainStoresID,strSubStores,strLocation,strBin,intDocumentNo,intDocumentYear,intMatDetailId,strType,strUnit,dblQty,dtmDate,intUser)values ('$year', '$factoryId','99','99','99','$issueNo','$issueYear','$chemId','CHEMISSUE','$unitId',-$isssueQty,now(),'$userId');";
$result=$db->RunQuery($sql);
echo "Saved Successfully.";
}
?>