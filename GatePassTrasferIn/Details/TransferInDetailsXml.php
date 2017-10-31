<?php
//echo "111";
session_start();
include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType=$_GET["RequestType"];
$companyId=$_SESSION["FactoryID"];
$UserID=$_SESSION["UserID"];

if ($RequestType=="LoadSavedDetails")
{
	$chkDate =$_GET["chkDate"];
	$category =$_GET["category"];
	$DateFrom =$_GET["DateFrom"];
		$DateFromArray=explode('/',$DateFrom);
			$formatedFromDate=$DateFromArray[2]."-".$DateFromArray[1]."-".$DateFromArray[0];
	$DateTO =$_GET["DateTO"];
		$DateToArray=explode('/',$DateTO);
			$formatedToDate=$DateToArray[2]."-".$DateToArray[1]."-".$DateToArray[0];
	$TransferInNoFrom =$_GET["TransferInNoFrom"];
		$NoFromArray=explode('/',$TransferInNoFrom);
	$TransferInNoTo =$_GET["TransferInNoTo"];
		$NoToArray=explode('/',$TransferInNoTo);
		
	$ResponseXML .="<LoadSavedDetails>\n";
	
	$SQL="SELECT DISTINCT TIH.intTINYear,TIH.intTransferInNo, ".
		"TIH.dtmDate,concat(TIH.intGPYear,'/',TIH.intGatePassNo) as GatePassno,intStatus ".
		"FROM gategasstransferinheader AS TIH ".
		"Inner Join gategasstransferindetails AS TID ".
		"ON TIH.intTransferInNo = TID.intTransferInNo AND TIH.intTINYear = TID.intTINYear ".		
		"WHERE TIH.intCompanyId ='$companyId' ";
		
		if($TransferInNoFrom!="")
		{
			$SQL .="AND TIH.intTransferInNo >=$NoFromArray[1] AND TIH.intTINYear=$NoFromArray[0] ";
		}
		if($TransferInNoTo!="")
		{
			$SQL .="AND TIH.intTransferInNo <=$NoToArray[1] AND TIH.intTINYear=$NoFromArray[0] ";
		}
		if ($chkDate=="true")
		{
			if ($formatedFromDate!="")
			{
				$SQL .="AND date(dtmDate) >='$formatedFromDate' ";
			}
			if ($formatedToDate!="")
			{
				$SQL .="AND date(dtmDate) <='$formatedToDate' ";
			}
		}
		if($category!="")
		{
			$SQL .="AND intStatus =$category";
		}
	
		$SQL .= " order by GatePassno desc ";
		//echo $SQL;
	$result = $db->RunQuery($SQL);
	while ($row=mysql_fetch_array($result))
		{
			$ResponseXML .="<TranferInNo><![CDATA[".$row["intTransferInNo"]."]]></TranferInNo>\n";
			$ResponseXML .="<Year><![CDATA[".$row["intTINYear"]."]]></Year>\n";
			$ResponseXML .="<Date><![CDATA[".$row["dtmDate"]."]]></Date>\n";
			$ResponseXML .="<GatePassno><![CDATA[".$row["GatePassno"]."]]></GatePassno>\n";
			$ResponseXML .="<Status><![CDATA[".$row["intStatus"]."]]></Status>\n";		
		}
	
	$ResponseXML .="</LoadSavedDetails>";
	echo $ResponseXML;
}
else if($RequestType=="Cancel")
{
	$TransferInNO=$_GET["TransNO"];
		$TransferInNOArray=explode('/',$TransferInNO);
	$ResponseXML .="<Cancel>\n";	
	$SqlUpdate ="update gategasstransferinheader  ".
				"set intCancelledBy =$UserID, ".
				"dtmCancelledDate = now(), ".
				"intStatus =10 ".	
				"where intTransferInNo =$TransferInNOArray[1] ".
				"AND intTINYear =$TransferInNOArray[0]";
	$resultUpdate = $db->RunQuery($SqlUpdate);	
//---------------------------	
  $sql ="SELECT ST.strMainStoresID,ST.strSubStores,ST.strLocation,ST.strBin, ".
		"ST.intStyleId,ST.strBuyerPoNo,ST.intDocumentNo,ST.intDocumentYear,ST.intMatDetailId, ".
		"ST.strColor,ST.strSize,ST.strUnit,ST.dblQty ".
		"FROM stocktransactions AS ST ".
		"WHERE ST.intDocumentNo =$TransferInNOArray[1] AND ST.intDocumentYear =$TransferInNOArray[0] AND ST.strType='TI'";
	
	$result=$db->RunQuery($sql);
		while($row=mysql_fetch_array($result))
		{
			$MainStores=$row["strMainStoresID"];
			$SubStores=$row["strSubStores"];
			$Location=$row["strLocation"];
			$Bin=$row["strBin"];
			$StyleNo=$row["intStyleId"];
			$BuyerPoNo=$row["strBuyerPoNo"];
			$DocumentNo=$row["intDocumentNo"];
			$DocumentYear=$row["intDocumentYear"];
			$MatDetailId=$row["intMatDetailId"];
			$Color=$row["strColor"];
			$Size=$row["strSize"];
			$Unit=$row["strUnit"];
			$Qty=$row["dblQty"];
				$BinQty ="-". $Qty;			
			StockRevise($Year,$MainStores,$SubStores,$Location,$Bin,$StyleNo,$BuyerPoNo,$DocumentNo,$DocumentYear,$MatDetailId,$Color,$Size,$Unit,$BinQty,$UserID);
			ReviseStockAllocation($MainStores,$SubStores,$Location,$Bin,$MatDetailId,$Qty);	
		}				
//----------------------------
  $sql_1 ="select GTIH.intGatePassNo,GTIH.intGPYear,intStyleId,strBuyerPONO,intMatDetailId,strColor,strSize,dblQty from gategasstransferinheader GTIH ".
"INNER JOIN gategasstransferindetails GTID ON GTIH.intTransferInNo=GTID.intTransferInNo AND GTIH.intTINYear=GTID.intTINYear ".
"WHERE GTIH.intTransferInNo='$TransferInNOArray[1]' ".
"AND GTIH.intTINYear='$TransferInNOArray[0]'";

	$result_1=$db->RunQuery($sql_1);
		while($row_1=mysql_fetch_array($result_1))
		{
			$gatePassNo=$row_1["intGatePassNo"];
			$gatePassYear=$row_1["intGPYear"];
			$styleID=$row_1["intStyleId"];
			$matDetailId=$row_1["intMatDetailId"];
			$buyerPoNo=$row_1["strBuyerPONO"];
			$color=$row_1["strColor"];
			$size=$row_1["strSize"];
			$Qty=$row_1["dblQty"];		
			
			ReviseQty($gatePassNo,$gatePassYear,$styleID,$matDetailId,$buyerPoNo,$color,$size,$Qty);
		}	
//------------------------------		
	$ResponseXML .="</Cancel>";
}

function StockRevise($Year,$MainStores,$SubStores,$Location,$Bin,$StyleNo,$BuyerPoNo,$DocumentNo,$DocumentYear,$MatDetailId,$Color,$Size,$Unit,$BinQty,$UserID)
{
	global $db;
	
$sqlInStock="INSERT INTO stocktransactions ".
 "(intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear, ".
 "intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser) VALUES ".
 "($DocumentYear,'$MainStores','$SubStores','$Location','$Bin','$StyleNo','$BuyerPoNo',$DocumentNo,$DocumentYear,$MatDetailId, ".
 "'$Color','$Size','CTI','$Unit',$BinQty,now(),'$UserID')";

$db->executeQuery($sqlInStock);
}
function ReviseQty($gatePassNo,$gatePassYear,$styleID,$matDetailId,$buyerPoNo,$color,$size,$Qty)
{
	global $db;
	
$sql_update="update gatepassdetails  ".
"set ".
"dblBalQty = dblBalQty + $Qty ".
"where ".
"intGatePassNo = '$gatePassNo' ".
"and intGPYear = '$gatePassYear' ".
"and intStyleId = '$styleID' ".
"and strBuyerPONO = '$buyerPoNo' ".
"and intMatDetailId = '$matDetailId' ".
"and strColor = '$color' ".
"and strSize = '$size' "; 

$db->executeQuery($sql_update);
}
function ReviseStockAllocation($MainStores,$SubStores,$Location,$Bin,$MatDetailId,$Qty)
{
global $db;
$sql_allocation="select intSubCatID from matitemlist where intItemSerial='$MatDetailId'";
$result_allocation=$db->RunQuery($sql_allocation);
$row_allocation =mysql_fetch_array($result_allocation);

	$subCatId	= $row_allocation["intSubCatID"];

$sqlbinallocation="update storesbinallocation ".
					"set ".
					"dblFillQty = dblFillQty-$Qty ".
					"where ".
					"strMainID = '$MainStores' ".
					"and strSubID = '$SubStores' ".
					"and strLocID = '$Location' ".
					"and strBinID = '$Bin' ".
					"and intSubCatNo = '$subCatId';";

$db->executeQuery($sqlbinallocation);
}
?>