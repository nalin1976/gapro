<?php 
include "Connector.php";
include "HeaderConnector.php";
include "permissionProvider.php";


//$id="loadGrnHeader";
$id=$_GET["id"];

if($id == "loadMrnHeader")
{
	$mrnNo = $_GET["intMrnNo"];
	$mrnYear = $_GET["intYear"];
	$mrnStatus = $_GET["intStatus"];
	$mainStore = $_GET["mainStore"];
	
	header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .= "<MRNhead>";
		
		$result = getMrnHeaderDetails($mrnNo,$mrnYear,$mainStore);
		
		while($row = mysql_fetch_array($result))
			{
				$dtmDate = $row["mrnDate"];
				$userId  = $row["intRequestedBy"];
				$userName = getUserName($userId);
				$mrnDate = str_replace('-','/',$dtmDate);
				$ResponseXML .= "<mrnNo><![CDATA[" . $row["intMatRequisitionNo"]  . "]]></mrnNo>\n";
				$ResponseXML .= "<mrnDate><![CDATA[" . $mrnDate  . "]]></mrnDate>\n";
				$ResponseXML .= "<mrnUser><![CDATA[" . $userName  . "]]></mrnUser>\n";
				$ResponseXML .= "<DeptCode><![CDATA[" . $row["strDepartmentCode"]  . "]]></DeptCode>\n";
				$ResponseXML .= "<mainStoreID><![CDATA[" . $row["strMainStoresID"]  . "]]></mainStoreID>\n";
			}
		$ResponseXML .= "</MRNhead>";
	
			echo $ResponseXML;
}

function getMrnHeaderDetails($mrnNo,$mrnYear,$storeID)
{
	$SQL = " Select intMatRequisitionNo,DATE(dtmDate) as mrnDate,strDepartmentCode,strMainStoresID,intRequestedBy
			from matrequisition
			where intMatRequisitionNo='$mrnNo' and intMRNYear='$mrnYear' and strMainStoresID='$storeID'";
			
		 global $db;
		 
		 return $db->RunQuery($SQL);	
}

function getUserName($userID)
{
	$SQL = " Select Name as UserName
			from useraccounts
			where intUserID='$userID' and status=1";
			
			 global $db;
			 $result = $db->RunQuery($SQL);	
			 
			 while($row = mysql_fetch_array($result))
			{
				$userName = $row["UserName"];
			}
			
			return $userName;
}

if($id == "loadMrnItems")
{
	$mrnNo = $_GET["intMrnNo"];
	$mrnYear = $_GET["intYear"];
	$mrnStatus = $_GET["intStatus"];
	$mainStore = $_GET["mainStore"];
	
	 global $db;
	header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
	 $ResponseXML .= "<MatInfo>\n";	
		$SQL = "Select md.intStyleId,md.strBuyerPONO,md.strMatDetailID,md.strColor,
				md.strSize,md.dblQty,o.strStyle,mat.strItemDescription,md.strNotes, o.strOrderNo,
				md.intGrnNo, md.intGrnYear,md.strGRNType
				from matrequisitiondetails md inner join matrequisition m on
				md.intMatRequisitionNo = m.intMatRequisitionNo inner join orders o  on
				md.intStyleId = o.intStyleId inner join matitemlist mat on
				mat.intItemSerial = md.strMatDetailID
				and md.intYear = m.intMRNYear
				where m.intMatRequisitionNo='$mrnNo' and m.intMRNYear='$mrnYear' and m.strMainStoresID='$mainStore'
				and   m.intStatus='$mrnStatus'";
				
				 $result=$db->RunQuery($SQL);
	
		 while($row = mysql_fetch_array($result))
		 {
			$StyleID = $row["intStyleId"];
			$buyerPOname =  $row["strBuyerPONO"];
			$buyerPOid   = $row["strBuyerPONO"];
			$matID    =  $row["strMatDetailID"];
			$strColor =  $row["strColor"];
			$size     =  $row["strSize"];
			$mrnQty   =  $row["dblQty"];
			$styleName =  $row["strStyle"];
			$itemName  =  $row["strItemDescription"];
			$qty       = $row["dblQty"];
			$note      = $row["strNotes"];
			$orderNo   = $row["strOrderNo"];
			
			$grnNo = $row["intGrnNo"];
			$grnYear = $row["intGrnYear"];
			$grnType   = $row["strGRNType"];
			
			if($buyerPOid != "#Main Ratio#")
				$buyerPOname = GetBuyerPoName($buyerPOid,$StyleID);
			
			$stockQty=getStockqty($StyleID,$buyerPOid,$matID,$strColor,$size,$mainStore,$grnNo,$grnYear,$grnType);
	
	
			$issueQty=getIssueQty($StyleID,$mrnYear,$buyerPOid,$matID,$strColor,$size,"Qty",$mainStore,$grnNo,$grnYear,$grnType) * -1;
					
			$mrnReq=getMRNQuantity($StyleID,$buyerPOid,$matID,$strColor,$size,$mainStore,$grnNo,$grnYear,$grnType);
			
			$balQty=($issueQty + $stockQty)-$mrnReq;
			
			$SCno = getSCNo($StyleID);
			switch($grnType)
			{
				case 'S':
				{
					$strGRNType = 'Style';
					break;
				}
				case 'B':
				{
					$strGRNType = 'Bulk';
					break;
				}
			}
			$invoiceNo = getInvoiceNo($grnNo,$grnYear,$grnType);
			
			$ResponseXML .= "<StyleID><![CDATA[" .$StyleID. "]]></StyleID>\n";
			$ResponseXML .= "<StyleName><![CDATA[" .$styleName. "]]></StyleName>\n";
			$ResponseXML .= "<BuyePoid><![CDATA[" .$buyerPOid. "]]></BuyePoid>\n";
			$ResponseXML .= "<BuyerPOName><![CDATA[" .$buyerPOname. "]]></BuyerPOName>\n";
			$ResponseXML .= "<Item><![CDATA[" .$itemName. "]]></Item>\n";
			$ResponseXML .= "<color><![CDATA[" . $strColor  . "]]></color>\n";
			$ResponseXML .= "<size><![CDATA[" . $size  . "]]></size>\n";
			$ResponseXML .= "<qty><![CDATA[" .round($qty,2). "]]></qty>\n";
			$ResponseXML .= "<MatDetailID><![CDATA[" . $matID . "]]></MatDetailID>\n";
			$ResponseXML .= "<BalQty><![CDATA[" .round($balQty,2). "]]></BalQty>\n";
			$ResponseXML .= "<note><![CDATA[" . $note  . "]]></note>\n";
			$ResponseXML .= "<SCno><![CDATA[" . $SCno  . "]]></SCno>\n";
			$ResponseXML .= "<OrderNo><![CDATA[" . $orderNo  . "]]></OrderNo>\n";
			$ResponseXML .= "<grnNo><![CDATA[" . $grnNo  . "]]></grnNo>\n";
			$ResponseXML .= "<grnYear><![CDATA[" . $grnYear  . "]]></grnYear>\n";
			$ResponseXML .= "<grnType><![CDATA[" . $grnType  . "]]></grnType>\n";
			$ResponseXML .= "<strGRNType><![CDATA[" . $strGRNType  . "]]></strGRNType>\n";
			$ResponseXML .= "<invoiceNo><![CDATA[" . $invoiceNo  . "]]></invoiceNo>\n";
		 }
		 
		 $ResponseXML .= "</MatInfo>";
	echo $ResponseXML;
}

function getIssueQty($styleID,$year,$buyerPo,$MatID,$color,$size,$type,$storeID,$grnNo,$grnYear,$grnType)
{
	global $db;
	$Qty =0;
	$sql= "";
	if($type=="Qty")
	{
		$sql="SELECT SUM(dblQty)AS dblQty FROM stocktransactions s WHERE intStyleId='$styleID' AND strBuyerPoNo='$buyerPo' AND intMatDetailId='$MatID' AND strColor='$color' AND strSize='$size' AND strMainStoresID = '$storeID' AND strType = 'ISSUE'  and intGrnNo = '$grnNo' and intGrnYear = '$grnYear' and strGRNType = '$grnType'";
		
	}
	else if($type=="BalQty")
	{
		$sql="SELECT sum(dblBalanceQty) as dblQty FROM issuesdetails WHERE intStyleId='$styleID' AND strBuyerPONO='$buyerPo' AND  strColor='$color' AND strSize='$size' AND intMatDetailID='$MatID' and intGrnNo = '$grnNo' and intGrnYear = '$grnYear' and strGRNType = '$grnType'";
	}
	
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$Qty= $row["dblQty"];
		
		if($Qty=="" || $Qty==NULL)
		{
			$Qty=0;
		}
		
	}
return $Qty;

}

function getStockqty($styleNo,$buyerPO,$matDetaiID,$color,$size,$storeID,$grnNo,$grnYear,$grnType)
{
global $db;
$stockQty=0;
$sql="SELECT SUM(dblQty)AS stockQty FROM stocktransactions s WHERE intStyleId='$styleNo' AND strBuyerPoNo='$buyerPO' AND intMatDetailId='$matDetaiID' AND strColor='$color' AND strSize='$size' AND strMainStoresID = '$storeID' and  intGrnNo='$grnNo' and intGrnYear='$grnYear' and strGRNType = '$grnType' ";


//echo $sql;
$result=$db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
$stockQty=$row["stockQty"];

	if($stockQty=="" || $stockQty==NULL)
	{
	$stockQty=-100;
	}

}

return $stockQty;


}

function getMRNQuantity($styleID,$buyerPo,$MatID,$color,$size,$stores,$grnNo,$grnYear,$grnType)
{
	global $db;
	$sql="SELECT sum(dblQty) as dblQty FROM matrequisitiondetails inner join matrequisition on matrequisitiondetails.intMatRequisitionNo = matrequisition.intMatRequisitionNo AND matrequisitiondetails.intYear = matrequisition.intMRNYear WHERE intStyleId='$styleID' AND strBuyerPONO='$buyerPo' 
AND strColor='$color' AND strSize='$size' AND strMatDetailID='$MatID' AND matrequisition.strMainStoresID='$stores' and intGrnNo = '$grnNo' and intGrnYear = '$grnYear' and strGRNType = '$grnType' ";

	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$Qty= $row["dblQty"];
		if($Qty=="" || $Qty==NULL)
		{
			$Qty=0;
		}
	}
return $Qty;
}

function GetBuyerPoName($buyerPoNo,$StyleId)
{
global $db;
	$sql="select distinct strBuyerPoName from style_buyerponos where strBuyerPONO='$buyerPoNo' and intStyleId='$StyleId'";
	
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["strBuyerPoName"];	
}

function getSCNo($styleID)
{
	global $db;
	$SQL = "SELECT intSRNO FROM specification WHERE intStyleId='$styleID' ";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["intSRNO"];	
}
function getInvoiceNo($grnNo,$grnYear,$grnType)
{
	global $db;
	if($grnType == 'B')
		$sql = "select strInvoiceNo from bulkgrnheader where intBulkGrnNo='$grnNo' and  intYear = '$grnYear'";
	else if($grnType == 'S')	
		$sql = "select strInvoiceNo from grnheader where intGrnNo = '$grnNo' and  intGRNYear = '$grnYear' ";


	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["strInvoiceNo"];	
}
?>