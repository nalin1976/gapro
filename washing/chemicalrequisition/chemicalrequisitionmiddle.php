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
elseif($requestType=="LoadCostHeaderDetails")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<data>\n";

$costNo	= explode('/',$_GET["CostNo"]);
$sql="select WACH.intMachineType,WACH.dblQty,O.intQty,O.intStyleId,O.strOrderNo,O.strStyle from was_actualcostheader WACH inner join orders O on O.intStyleId=WACH.intStyleId where WACH.intYear='$costNo[0]' and WACH.intSerialNo='$costNo[1]'";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$ResponseXML .= "<MachineType><![CDATA[" . $row["intMachineType"] . "]]></MachineType>\n";
	$ResponseXML .= "<Qty><![CDATA[" . $row["dblQty"] . "]]></Qty>\n";
	$ResponseXML .= "<OrderQty><![CDATA[" . $row["intQty"] . "]]></OrderQty>\n";
	$ResponseXML .= "<StyleId><![CDATA[" . $row["intStyleId"] . "]]></StyleId>\n";	
	$ResponseXML .= "<OrderNo><![CDATA[" . $row["strOrderNo"] . "]]></OrderNo>\n";
	$ResponseXML .= "<StyleNo><![CDATA[" . $row["strStyle"] . "]]></StyleNo>\n";
}

$ResponseXML .= "</data>";
echo $ResponseXML;
}
elseif($requestType=="LoadCostDetails")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<data>\n";

$costNo	= explode('/',$_GET["CostNo"]);
$styleId	= $_GET["StyleId"];
//$sql="select WACC.intChemicalId,GMIL.strItemDescription from was_actcostchemicals WACC inner join genmatitemlist GMIL on GMIL.intItemSerial=WACC.intChemicalId where WACC.intSerialNo='$costNo[1]' and WACC.intYear='$costNo[0]' ";

$sql="select WACC.intChemicalId,GMIL.strItemDescription,sum(dblQty)as totQty,WACC.strUnit from was_actcostchemicals WACC ".
"inner join genmatitemlist GMIL on GMIL.intItemSerial=WACC.intChemicalId ".
"where WACC.intSerialNo='$costNo[1]' and WACC.intYear='$costNo[0]' ".
"group by WACC.intChemicalId,WACC.strUnit";

$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$stockBal	= GetStockBalQty($row["intChemicalId"],$row["strUnit"],$companyId);
	$mrnRaised	= GetMRNRaisedQty($row["intChemicalId"],$styleId);
	$issuedQty	= GetIssuedQty($row["intChemicalId"],$styleId);
	$ResponseXML .= "<ChemicalId><![CDATA[" . $row["intChemicalId"] . "]]></ChemicalId>\n";
	$ResponseXML .= "<ChemDesc><![CDATA[" . $row["strItemDescription"] . "]]></ChemDesc>\n";
	$ResponseXML .= "<MRNRaised><![CDATA[" . $mrnRaised . "]]></MRNRaised>\n";
	$ResponseXML .= "<IssuedQty><![CDATA[" . $issuedQty . "]]></IssuedQty>\n";
	$ResponseXML .= "<StockBal><![CDATA[" . $stockBal . "]]></StockBal>\n";
	$ResponseXML .= "<TotQty><![CDATA[" . $row["totQty"] . "]]></TotQty>\n";
	$ResponseXML .= "<UnitId><![CDATA[" . $row["strUnit"] . "]]></UnitId>\n";
	$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"] . "]]></Unit>\n";
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
	
	$Sql="select intCompanyID,dblWasMRNNo from syscontrol where intCompanyID='$companyId'";
	$result =$db->RunQuery($Sql);	
	$rowcount = mysql_num_rows($result);
	if ($rowcount > 0)
	{	
		while($row = mysql_fetch_array($result))
		{				
			$No=$row["dblWasMRNNo"];
			$NextNo=$No+1;
			$ReturnYear = date('Y');
			$sqlUpdate="UPDATE syscontrol SET dblWasMRNNo='$NextNo' WHERE intCompanyID='$companyId';";
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

	$sql="select concat(WMRH.intMRNYear,'/',WMRH.intMRNNo)as mrnNo,concat(WMRH.intCostYear,'/',WMRH.intCostNo)as costNo,WMRH.dtmDate,UA.Name as requestBy from was_matrequisitionheader WMRH inner join useraccounts UA on UA.intUserID=WMRH.intUserId";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<MRNNo><![CDATA[" . $row["mrnNo"] . "]]></MRNNo>\n";
		$ResponseXML .= "<CostNo><![CDATA[" . $row["costNo"] . "]]></CostNo>\n";
		$ResponseXML .= "<Date><![CDATA[" . $row["dtmDate"] . "]]></Date>\n";
		$ResponseXML .= "<RequestBy><![CDATA[" . $row["requestBy"] . "]]></RequestBy>\n";
	}
$ResponseXML .="</data>";
echo $ResponseXML;
}
//Start - Functions
function GetStockBalQty($chemId,$unitId,$companyId)
{
global $db;
	$sql="select COALESCE(sum(ST.dblQty),0)as stockBal from genstocktransactions ST  where ST.intMatDetailId=$chemId and ST.strUnit='$unitId' and ST.strMainStoresID=$companyId group by ST.strUnit";
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
