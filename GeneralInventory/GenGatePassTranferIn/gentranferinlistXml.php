<?php
include "../../Connector.php";
session_start();

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
	
	$SQL="SELECT DISTINCT TIH.intTransferInYear,TIH.intTransferInNo,
		TIH.dtmDate,concat(TIH.intGPYear,'/',TIH.intGatePassNo) as GatePassno,intStatus 
		FROM gengatepasstransferinheader AS TIH 
		Inner Join gengatepasstransferindetails AS TID 
		ON TIH.intTransferInNo = TID.intTransferInNo AND TIH.intTransferInYear = TID.intTransferInYear 		
		WHERE TIH.intCompanyId='$companyId' ";
		
		if($TransferInNoFrom!="")
		{
			$SQL .="AND TIH.intTransferInNo >=$NoFromArray[1] AND TIH.intTransferInYear=$NoFromArray[0] ";
		}
		if($TransferInNoTo!="")
		{
			$SQL .="AND TIH.intTransferInNo <=$NoToArray[1] AND TIH.intTransferInYear=$NoFromArray[0] ";
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
	
		$SQL .= " order by GatePassno ";
		//echo $SQL;
	$result = $db->RunQuery($SQL);
	while ($row=mysql_fetch_array($result))
		{
			$ResponseXML .="<TranferInNo><![CDATA[".$row["intTransferInNo"]."]]></TranferInNo>\n";
			$ResponseXML .="<Year><![CDATA[".$row["intTransferInYear"]."]]></Year>\n";
			$ResponseXML .="<Date><![CDATA[".$row["dtmDate"]."]]></Date>\n";
			$ResponseXML .="<GatePassno><![CDATA[".$row["GatePassno"]."]]></GatePassno>\n";
			$ResponseXML .="<Status><![CDATA[".$row["intStatus"]."]]></Status>\n";		
		}
	
	$ResponseXML .="</LoadSavedDetails>";
	echo $ResponseXML;
}
else if($RequestType=="Cancel")
{
	$TransNO=$_GET["TransNO"];
	$TransferInNOArray=explode('/',$TransNO);
	$ResponseXML .="<Cancel>\n";	
	$SqlUpdate ="update gengatepasstransferinheader
				set intCancelledBy =$UserID, 
				dtmCancelledDate = now(), 
				intStatus =10 	
				where intTransferInNo =$TransferInNOArray[1] 
				AND intTransferInYear =$TransferInNOArray[0];";
	$resultUpdate = $db->RunQuery($SqlUpdate);	
//---------------------------	
  $sql ="SELECT ST.intYear,ST.strMainStoresID,
		ST.intDocumentNo,ST.intDocumentYear,ST.intMatDetailId, 
		ST.strUnit,ST.dblQty ,ST.intGRNNo,ST.intGRNYear
		FROM genstocktransactions AS ST 
		WHERE ST.intDocumentNo =$TransferInNOArray[1] AND ST.intDocumentYear =$TransferInNOArray[0] AND ST.strType='TI';";
	
	$result=$db->RunQuery($sql);
		while($row=mysql_fetch_array($result))
		{
			$intYear=$row["intYear"];
			$strMainStoresID=$row["strMainStoresID"];
			$intDocumentNo=$row["intDocumentNo"];
			$intDocumentYear=$row["intDocumentYear"];
			$intMatDetailId=$row["intMatDetailId"];
			$strUnit=$row["strUnit"];
			$intGRNNo=$row["intGRNNo"];
			$intGRNYear=$row["intGRNYear"];
			$dblQty=$row["dblQty"];
			$Qty ="-". $dblQty;			
			StockRevise($intYear,$strMainStoresID,$intDocumentNo,$intDocumentYear,$intMatDetailId,$strUnit,$Qty,$UserID,$intGRNNo,$intGRNYear);
			
		}				
//----------------------------
  $sql_1 ="select GTIH.intGatePassNo,GTIH.intGPYear,intMatDetailId,dblQty,intGrnNo,intGRNYear
from gengatepasstransferinheader GTIH 
INNER JOIN gengatepasstransferindetails GTID ON GTIH.intTransferInNo=GTID.intTransferInNo AND GTIH.intTransferInYear=GTID.intTransferInYear 
WHERE GTIH.intTransferInNo='$TransferInNOArray[1]' 
AND GTIH.intTransferInYear='$TransferInNOArray[0]';";

	$result_1=$db->RunQuery($sql_1);
		while($row_1=mysql_fetch_array($result_1))
		{
			$gatePassNo=$row_1["intGatePassNo"];
			$gatePassYear=$row_1["intGPYear"];
			$matDetailId=$row_1["intMatDetailId"];
			$Qty=$row_1["dblQty"];
			$GrnNo=$row_1["intGrnNo"];
			$GrnYear=$row_1["intGRNYear"];	
			
			ReviseQty($gatePassNo,$gatePassYear,$matDetailId,$Qty,$GrnNo,$GrnYear);
		}	
//------------------------------		
	$ResponseXML .="</Cancel>";
}

function StockRevise($intYear,$strMainStoresID,$intDocumentNo,$intDocumentYear,$intMatDetailId,$strUnit,$Qty,$UserID,$intGRNNo,$intGRNYear)
{
	global $db;
	
$sqlInStock="INSERT INTO genstocktransactions
		   (intYear, 
			strMainStoresID, 
			intDocumentNo, 
			intDocumentYear, 
			intMatDetailId, 
			strType, 
			strUnit, 
			dblQty, 
			dtmDate, 
			intUser, 
			intGRNNo, 
			intGRNYear) VALUES
		 ($intYear,
		 '$strMainStoresID',
		 $intDocumentNo,
		 $intDocumentYear,
		 $intMatDetailId,
		 'CTI',
		 '$strUnit',
		 '$Qty',
		 now(),
		 '$UserID',
		 '$intGRNNo',
		 '$intGRNYear')";

$db->executeQuery($sqlInStock);
}
function ReviseQty($gatePassNo,$gatePassYear,$matDetailId,$Qty,$GrnNo,$GrnYear)
{
	global $db;
	
$sql_update="update gengatepassdetail  
set 
dblBalQty = dblBalQty + $Qty 
where 
strGatepassID = '$gatePassNo' 
and intYear = '$gatePassYear' 
and intMatDetailID = '$matDetailId' 
and intGrnNo = '$GrnNo' 
and intGrnYear = '$GrnYear' ; "; 

$db->executeQuery($sql_update);
}

function GetMainStoresID($prmCompanyId){
	
	global $db;
	
	$sql = " SELECT * FROM mainstores WHERE intCompanyId = ".$prmCompanyId;
	
	$result = $db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result)){		
		return $row['strMainID'];		
	}
}

?>