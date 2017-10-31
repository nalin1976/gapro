<?php
session_start();
include "../../Connector.php";
$requestType = $_GET["RequestType"];
$companyId=$_SESSION["FactoryID"];

if($requestType=="LoadCostNo")
{
	$sql="select concat(intYear,'/',intSerialNo)as costNo from was_actualcostheader where intStatus=1";
	$results=$db->RunQuery($sql);
	while($row=mysql_fetch_array($results))
	{
		$po_arr.= $row['costNo']."|";
		 
	}
	echo $po_arr;
}
elseif($requestType=="LoadHeaderDetails")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<data>\n";

$mrnNo	= explode('/',$_GET["MrnNo"]);
$sql="select  WACH.intMachineType,O.intQty,O.intStyleId,O.strOrderNo,O.strStyle,concat(WACH.intYear,'/',WMRH.intCostNo)as costNo
from was_matrequisitionheader WMRH 
inner join was_actualcostheader WACH on WACH.intSerialNo=WMRH.intCostNo and WACH.intYear=WMRH.intCostYear 
inner join orders O on O.intStyleId=WMRH.intStyleId where WMRH.intMRNYear='$mrnNo[0]' and WMRH.intMRNNo=$mrnNo[1]";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$ResponseXML .= "<MachineType><![CDATA[" . $row["intMachineType"] . "]]></MachineType>\n";
	$ResponseXML .= "<OrderQty><![CDATA[" . $row["intQty"] . "]]></OrderQty>\n";
	$ResponseXML .= "<StyleId><![CDATA[" . $row["intStyleId"] . "]]></StyleId>\n";	
	$ResponseXML .= "<OrderNo><![CDATA[" . $row["strOrderNo"] . "]]></OrderNo>\n";
	$ResponseXML .= "<StyleNo><![CDATA[" . $row["strStyle"] . "]]></StyleNo>\n";
	$ResponseXML .= "<CostNo><![CDATA[" . $row["costNo"] . "]]></CostNo>\n";
}

$ResponseXML .= "</data>";
echo $ResponseXML;
}
elseif($requestType=="LoadDetails")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<data>\n";

$mrnNo	= explode('/',$_GET["MrnNo"]);
$styleId	= $_GET["StyleId"];

$sql="select WMRD.intChemicalId,GMIL.strItemDescription,WMRD.intUnitId,dblMrnQty,dblMrnBalQty from was_matrequisitionheader WMRH inner join was_matrequisitiondetails WMRD on WMRD.intMRNNo=WMRH.intMRNNo and WMRD.intMRNYear=WMRH.intMRNYear inner join genmatitemlist GMIL on GMIL.intItemSerial=WMRD.intChemicalId where WMRH.intMRNNo=$mrnNo[1] and WMRH.intMRNYear=$mrnNo[0]";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$stockBal	= GetStockBalQty($row["intChemicalId"],$row["intUnitId"]);
	$issuedQty	= round($row["dblMrnQty"]-$row["dblMrnBalQty"],4);
	$ResponseXML .= "<ChemicalId><![CDATA[" . $row["intChemicalId"] . "]]></ChemicalId>\n";
	$ResponseXML .= "<ChemDesc><![CDATA[" . $row["strItemDescription"] . "]]></ChemDesc>\n";
	$ResponseXML .= "<UnitId><![CDATA[" . $row["intUnitId"] . "]]></UnitId>\n";
	$ResponseXML .= "<Unit><![CDATA[" . $row["intUnitId"] . "]]></Unit>\n";
	$ResponseXML .= "<MRNRaised><![CDATA[" . $row["dblMrnQty"] . "]]></MRNRaised>\n";
	$ResponseXML .= "<BalToMRN><![CDATA[" . $row["dblMrnBalQty"] . "]]></BalToMRN>\n";
	$ResponseXML .= "<IssuedQty><![CDATA[" . $issuedQty . "]]></IssuedQty>\n";
	$ResponseXML .= "<StockBal><![CDATA[" . $stockBal . "]]></StockBal>\n";
}
$ResponseXML .= "</data>";
echo $ResponseXML;
}
elseif($requestType=="LoadNo")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
    $No=0;
	$ResponseXML .="<LoadNo>\n";
	
	$Sql="select intCompanyID,dblWasChemIssueNo from syscontrol where intCompanyID='$companyId'";
	$result =$db->RunQuery($Sql);	
	$rowcount = mysql_num_rows($result);
	if ($rowcount > 0)
	{	
		while($row = mysql_fetch_array($result))
		{				
			$No=$row["dblWasChemIssueNo"];
			$NextNo=$No+1;
			$ReturnYear = date('Y');
			$sqlUpdate="UPDATE syscontrol SET dblWasChemIssueNo='$NextNo' WHERE intCompanyID='$companyId';";
			$db->executeQuery($sqlUpdate);
			$ResponseXML .= "<admin><![CDATA[TRUE]]></admin>\n";
			$ResponseXML .= "<No><![CDATA[".$No."]]></No>\n";
			$ResponseXML .= "<Year><![CDATA[".$ReturnYear."]]></Year>\n";
		}
	}
	else
	{
		$ResponseXML .= "<admin><![CDATA[FALSE]]></admin>\n";
	}	
	$ResponseXML .="</LoadNo>";
	echo $ResponseXML;
}
elseif($requestType=="LoadList")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<data>\n";

	$sql="select concat(WCIH.intIssueYear,'/',WCIH.intIssueNo)as IssueNo,concat(WCIH.intMRNYear,'/',WCIH.intMRNNo)as mrnNo,WCIH.dtmDate,UA.Name as requestBy from was_chemissueheader WCIH inner join useraccounts UA on UA.intUserID=WCIH.intUserId";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<MRNNo><![CDATA[" . $row["IssueNo"] . "]]></MRNNo>\n";
		$ResponseXML .= "<CostNo><![CDATA[" . $row["mrnNo"] . "]]></CostNo>\n";
		$ResponseXML .= "<Date><![CDATA[" . $row["dtmDate"] . "]]></Date>\n";
		$ResponseXML .= "<RequestBy><![CDATA[" . $row["requestBy"] . "]]></RequestBy>\n";
	}
$ResponseXML .="</data>";
echo $ResponseXML;
}
elseif($requestType=="LoadMrnNo")
{
	$sql="select concat(MH.intMRNYear,'/',MH.intMRNNo)as MrnNo from was_matrequisitionheader MH inner join was_matrequisitiondetails MD on MD.intMRNYear=MH.intMRNYear and MD.intMRNNo=MH.intMRNNo where MH.intStatus=0 and MD.dblMrnBalQty>0 order by MH.intMRNYear,MH.intMRNNo DESC";
	$result=$db->RunQuery($sql);
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row=mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["MrnNo"] ."\">" . $row["MrnNo"] ."</option>" ;
	}
}
//Start - Functions
function GetStockBalQty($chemId,$unitId)
{
global $db;
	$sql="select COALESCE(sum(ST.dblQty),0)as stockBal from genstocktransactions ST  where ST.intMatDetailId=$chemId and ST.strUnit='$unitId' group by ST.strUnit";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["stockBal"];
	}
	return 0;
}

function GetMRNRaisedQty($chemId,$styleId)
{
global $db;
	$sql="select COALESCE(sum(dblMrnQty),0)as mrnQty from was_matrequisitiondetails WMRD 
inner join was_matrequisitionheader WMRH on WMRH.intMRNNo=WMRD.intMRNNo and WMRH.intMRNYear=WMRD.intMRNYear
where WMRH.intStyleId=$styleId and WMRD.intChemicalId=$chemId";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["mrnQty"];
	}
	return 0;
}
function GetIssuedQty($chemId,$styleId)
{
global $db;
	$sql="select COALESCE(sum(dblQty),0)as issuedQty from was_chemissueheader WCIH 
inner join was_chemissuedetails WCID on WCIH.intIssueNo=WCID.intIssueNo and WCIH.intIssueYear=WCID.intIssueYear
where WCIH.intStyleId=$styleId and WCID.intChemicalId=$chemId";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["issuedQty"];
	}
	return 0;
}
//End - Function
?>
