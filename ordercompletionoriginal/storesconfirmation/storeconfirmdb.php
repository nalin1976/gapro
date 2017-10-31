<?php 
session_start();
include "../../Connector.php";
include "../../EmailSender.php";
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType=$_GET["RequestType"];
$companyId=$_SESSION["FactoryID"];
$UserID=$_SESSION["UserID"];

if($RequestType=="loadPendingCompleteData")
{
	$styleId = $_GET["styleId"];
	$ResponseXML .="<LoadPendingOrderData>\n";
	
	$sql = "SELECT st.strBuyerPoNo, st.strColor, st.strSize, st.strUnit, storeslocations.strLocName, storesbins.strBinName, substores.strSubStoresName, mainstores.strName, matitemlist.strItemDescription, concat(st.intGrnYear,'/',st.intGrnNo) AS GRN, orders.strOrderNo, st.intStyleId, Sum(st.dblQty) AS QTY, st.strBin, st.strLocation, st.strSubStores, st.strMainStoresID, matitemlist.intSubCatID, matitemlist.intItemSerial,st.strGRNType
 FROM stocktransactions AS st Inner Join storeslocations ON storeslocations.strLocID = st.strLocation
  Inner Join storesbins ON storesbins.strBinID = st.strBin Inner Join substores ON substores.strSubID = st.strSubStores 
  Inner Join mainstores ON st.strMainStoresID = mainstores.strMainID 
  Inner Join matitemlist ON st.intMatDetailId = matitemlist.intItemSerial
 Inner Join orders ON st.intStyleId = orders.intStyleId 
WHERE st.intStyleId='$styleId'  and mainstores.intCompanyId ='$companyId' 
group by st.strBuyerPoNo, st.strColor, st.strSize, storeslocations.strLocName, storesbins.strBinName,
 substores.strSubStoresName, mainstores.strName, matitemlist.strItemDescription, st.intGrnNo, st.intGrnYear, orders.strOrderNo, 
st.intStyleId 
having QTY > 0 ";

	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$grnType = $row["strGRNType"];
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
		$ResponseXML.="<BuyerPoNo><![CDATA[" .$row["strBuyerPoNo"]. "]]></BuyerPoNo>\n";
		$ResponseXML.="<strColor><![CDATA[" .$row["strColor"]. "]]></strColor>\n";
		$ResponseXML.="<strSize><![CDATA[" .$row["strSize"]. "]]></strSize>\n";
		$ResponseXML.="<strUnit><![CDATA[" .$row["strUnit"]. "]]></strUnit>\n";
		$ResponseXML.="<strLocName><![CDATA[" .$row["strLocName"]. "]]></strLocName>\n";
		$ResponseXML.="<strBinName><![CDATA[" .$row["strBinName"]. "]]></strBinName>\n";
		$ResponseXML.="<strSubStoresName><![CDATA[" .$row["strSubStoresName"]. "]]></strSubStoresName>\n";
		$ResponseXML.="<strName><![CDATA[" .$row["strName"]. "]]></strName>\n";
		$ResponseXML.="<strItemDescription><![CDATA[" .$row["strItemDescription"]. "]]></strItemDescription>\n";
		$ResponseXML.="<GRN><![CDATA[" .$row["GRN"]. "]]></GRN>\n";
		$ResponseXML.="<intSubCatID><![CDATA[" .$row["intSubCatID"]. "]]></intSubCatID>\n";
		$ResponseXML.="<intItemSerial><![CDATA[" .$row["intItemSerial"]. "]]></intItemSerial>\n";
		$ResponseXML.="<strOrderNo><![CDATA[" .$row["strOrderNo"]. "]]></strOrderNo>\n";
		$ResponseXML.="<QTY><![CDATA[" .$row["QTY"]. "]]></QTY>\n";
		$ResponseXML.="<strBin><![CDATA[" .$row["strBin"]. "]]></strBin>\n";
		$ResponseXML.="<strLocation><![CDATA[" .$row["strLocation"]. "]]></strLocation>\n";
		$ResponseXML.="<strSubStores><![CDATA[" .$row["strSubStores"]. "]]></strSubStores>\n";
		$ResponseXML.="<strMainStoresID><![CDATA[" .$row["strMainStoresID"]. "]]></strMainStoresID>\n";
		$ResponseXML.="<grnType><![CDATA[" .$grnType. "]]></grnType>\n";
		$ResponseXML.="<strGRNType><![CDATA[" .$strGRNType. "]]></strGRNType>\n";
		
	}
	$ResponseXML.="</LoadPendingOrderData>";
echo $ResponseXML;
}
else if($RequestType=="getDocumentNo")
{
	$ResponseXML .="<loadDocNo>\n";
	$docNo=getDocNo($companyId);
	$ResponseXML.="<docNo><![CDATA[" .$docNo. "]]></docNo>\n";
	$ResponseXML.="</loadDocNo>";
echo $ResponseXML;
	
}

else if($RequestType=="saveItemDisposeHeader")
{
	$docNo = $_GET["docNo"];
	$intYear = date('Y');
	insertItemDisposeData($docNo,$intYear);
}
else if($RequestType=="saveDisposeData")
{
	$matId = $_GET["matId"];
	$styleID = $_GET["styleID"];
	$color  = $_GET["color"];
	$size	= $_GET["size"];
	$units  = $_GET["units"];
	$disposeQty = $_GET["disposeQty"];
	$buyerPoNo = $_GET["buyerPoNo"];
	$grnNo = $_GET["grnNo"];
	$arrGRN = explode('/',$grnNo);
	$docNo = $_GET["docNo"];
	$grnType = $_GET["grnType"];
	$strType = 'leftoverDisposal';
	$tbl = 'stocktransactions_temp';
	
	$MainStoresID = $_GET["MainStoresID"];
	$strSubStores = $_GET["strSubStores"];
	$locationId = $_GET["locationId"];
	$binId  = $_GET["binId"];
	//insert disposal data to stocktransaction temp table
	//strType = leftoverDisposal
	insertDataStocktrans($tbl,$matId,$styleID,$color,$size,$units,$disposeQty,$buyerPoNo,$docNo,$strType,$arrGRN[1],$arrGRN[0],$grnType,$MainStoresID,$strSubStores,$locationId,$binId);
}
else if($RequestType=="saveLeftoverData")
{
	$matId = $_GET["matId"];
	$styleID = $_GET["styleID"];
	$color  = $_GET["color"];
	$size	= $_GET["size"];
	$units  = $_GET["units"];
	$binQty = $_GET["binQty"];
	$buyerPoNo = $_GET["buyerPoNo"];
	$grnNo = $_GET["grnNo"];
	$arrGRN = explode('/',$grnNo);
	$docNo = $_GET["docNo"];
	
	$grnType = $_GET["grnType"];
	$strType = 'Leftover';
	$tbl = 'stocktransactions_leftover';
	
	$MainStoresID = $_GET["mainStoreId"];
	$strSubStores = $_GET["subStoreId"];
	$locationId = $_GET["LocId"];
	$binId  = $_GET["BinId"];
	//insert disposal data to stocktransaction leftover table
	//strType = Leftover
	if($binQty>0)
	{
		insertDataStocktrans($tbl,$matId,$styleID,$color,$size,$units,$binQty,$buyerPoNo,$docNo,$strType,$arrGRN[1],$arrGRN[0],$grnType,$MainStoresID,$strSubStores,$locationId,$binId);
	}
}

else if($RequestType=="saveStockHistory")
{
	$styleID = $_GET["styleID"];
	//check availability of stock in other mainstores in relavent style
	$stockQty = getOtherMainstoresStockQty($styleID);
	
	if($stockQty == '0')
	{
		//save stocktransaction data to stocktransactions_history table
		moveStockDetailsToHistory($styleID);
		//delete stocktransaction data
		deleteStockData($styleID);
	}
	else
	{
		//save company wise stock data to history details
		moveStockDetailsToHistoryCompanyWise($styleID);
		//delete relavent stock data from stocktransactions
		$tbl = 'stocktransactions';
		$res = deleteStockDataCompanyWise($styleID,$tbl);
	}
	
	
}
else if($RequestType=="ConfiremDisposeItems"){
	
	$disposeNo = $_GET['disposeNo'];
	$disposeYear = $_GET["disposeYear"];
	global $db;
	$sqlMove= "INSERT INTO stocktransactions_dispose (intYear,strMainStoresID,strSubStores,strLocation, strBin, intStyleId, strBuyerPoNo,intDocumentNo,intDocumentYear,intMatDetailId,strColor,strSize, strType,strUnit ,dblQty,dtmDate, intUser, intGrnNo,intGrnYear,strGRNType)
select intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,
intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear,strGRNType
 from stocktransactions_temp  where intDocumentNo='$disposeNo' and intDocumentYear = '$disposeYear' and  strType='leftoverDisposal'";
					//echo $sqlMove;
	$resTR=$db->RunQuery($sqlMove);
	//echo $resTR;
	if($resTR==1){
		
		//echo $sqlDelete;
		$res=deleteLeftoverDisposeData($disposeNo,$disposeYear);
		updateItemDisposeData($disposeNo,$disposeYear);
		$ResponseXML.="<RESULT>";	
		$ResponseXML.="<Res><![CDATA[" .$res. "]]></Res>\n";
		$ResponseXML.="</RESULT>";
		
	}
	echo $ResponseXML;

}
function getDocNo($comID)
{
global $db;
	$selectMax="SELECT dblCompleteOrderId FROM syscontrol WHERE intCompanyID='$comID';";
	$resMax=$db->RunQuery($selectMax);
	$max=mysql_fetch_array($resMax);
	
	$update_SysControl="UPDATE syscontrol SET dblCompleteOrderId= dblCompleteOrderId+1 WHERE intCompanyID='$comID';";
	$resUp=$db->RunQuery($update_SysControl);
	
	return $max['dblCompleteOrderId'];
}

function insertDataStocktrans($tbl,$matId,$styleID,$color,$size,$units,$disposeQty,$buyerPoNo,$docNo,$strType,$intGrnNo,$intGrnYear,$grnType,$MainStoresID,$strSubStores,$locationId,$binId)
{
	global $db;
	global $UserID;
	$intYear = date('Y');
	$sql = " insert into $tbl(intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo, 
	intDocumentNo,intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear,strGRNType)
	values('$intYear','$MainStoresID','$strSubStores','$locationId','$binId','$styleID','$buyerPoNo','$docNo','$intYear', 
	'$matId','$color','$size','$strType','$units','$disposeQty',now(),'$UserID','$intGrnNo','$intGrnYear','$grnType')";
	
	$res=$db->RunQuery($sql);
}
function moveStockDetailsToHistory($styleID)
{
	global $db;
	
	$sql = "INSERT INTO stocktransactions_history (intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId, strBuyerPoNo,intDocumentNo,intDocumentYear,intMatDetailId,strColor, strSize, strType, strUnit, dblQty, dtmDate, intUser, intGrnNo,intGrnYear,strGRNType)	
	SELECT 	intYear,strMainStoresID,strSubStores,strLocation, strBin, intStyleId, strBuyerPoNo,	intDocumentNo, intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear,strGRNType
FROM stocktransactions	WHERE intStyleId='$styleID'";
$res=$db->RunQuery($sql);
}

function deleteStockData($styleID)
{
	global $db;
	
	$sql = "delete from stocktransactions where intStyleId='$styleID' ";
	$res=$db->RunQuery($sql);
}

function getOtherMainstoresStockQty($styleID)
{
	global $db;
	global $companyId;
	
	$sql = "select COALESCE(sum(st.dblQty),0) as Qty 
from stocktransactions st inner join mainstores ms on 
ms.strMainID = st.strMainStoresID where st.intStyleId='$styleID' and ms.intCompanyId<>'$companyId' ";
	$res=$db->RunQuery($sql);
	$row = mysql_fetch_array($res);
	return $row["Qty"];
}

function moveStockDetailsToHistoryCompanyWise($styleID)
{
	global $db;
	global $companyId;
	
	$sql = "INSERT INTO stocktransactions_history (intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId, strBuyerPoNo,intDocumentNo,intDocumentYear,intMatDetailId,strColor, strSize, strType, strUnit, dblQty, dtmDate, intUser, intGrnNo,intGrnYear,strGRNType)	select intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,
intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear,strGRNType
 from stocktransactions st inner join mainstores ms on 
ms.strMainID = st.strMainStoresID where st.intStyleId='$styleID' and ms.intCompanyId='$companyId'";

	$res=$db->RunQuery($sql);
}

function deleteStockDataCompanyWise($styleID,$tbl)
{
	global $db;
	global $companyId;
	
	$storeId = getMainstoreIdList();
	
	$sql_del = "delete from $tbl where intStyleId='$styleID' and strMainStoresID in ($storeId)"; 
	//echo $sql_del;
	return $db->RunQuery($sql_del);
}

function deleteLeftoverDisposeData($disposeNo,$disposeYear)
{
	global $db;
	global $companyId;
	//$storeId = getMainstoreIdList();
	
	$sqlDelete="delete  from stocktransactions_temp where  strType='leftoverDisposal' and intDocumentNo='$disposeNo' and intDocumentYear = '$disposeYear' ";
	return $db->RunQuery($sqlDelete);
}

function getMainstoreIdList()
{
	global $db;
	global $companyId;
	$loop1 =0;
	
	//get all mainstores assign to relavent company
	$sql_s = "select strMainID from mainstores where intCompanyId='$companyId' ";
	$res=$db->RunQuery($sql_s);
	while($row = mysql_fetch_array($res))
	{
		$store_array[$loop1] = "'" . $row["strMainID"] . "'";
		$loop1++;
	}
	
	$storeId	= implode(",", $store_array);
	
	return $storeId;
}
function insertItemDisposeData($disNo,$intYear)
{
	global $db;
	global $UserID;
		
	$sql = "insert into itemdispose	(intDocumentNo,intYear,intStatus,intPreparedBy,dtmPDate) values ('$disNo','$intYear','1','$UserID',now())";
	
	$res = $db->RunQuery($sql);
}
function updateItemDisposeData($disposeNo,$disposeYear)
{
	global $db;
	global $UserID;
	
	$sql = "update itemdispose 	set intConfirmedBy = '$UserID' ,intStatus='2',dtmCDate = now()
	where 	intDocumentNo = '$disposeNo' and intYear = '$disposeYear' ";
	
	$res = $db->RunQuery($sql);
}
?>