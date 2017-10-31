<?php
include "../../Connector.php";
$requestType 	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];
if($requestType=="URLLoadSubStore")
{
	$mSId	= $_GET["MSId"];
	$sql="select strSubID,strSubStoresName from substores where intStatus=1 and strMainID=$mSId order by strSubStoresName";
	$result = $db->RunQuery($sql);
		echo "<option value="."".">"."Select One"."</option>\n";
	while($row=mysql_fetch_array($result))
	{
		echo "<option value=".$row["strSubID"].">".$row["strSubStoresName"]."</option>\n";
	}
}
if($requestType=="URLLoadSubCat")
{
	header('Content-Type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "<XMLURLLoadSubCat>";
	
	$mainCatId	= $_GET["mainCatId"];
	
	$sql="select intSubCatNo,StrCatName 
			from matsubcategory 
			where intStatus <>'a' ";
	
	if($mainCatId!="")
	$sql.=" and intCatNo='$mainCatId' ";
	$sql.="order by StrCatName ";
	echo $sql;
	$result = $db->RunQuery($sql);
	
	$ResponseXML .= "<option value=\"". "" ."\">"."Select One"."</option>\n";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=\"". $row["intSubCatNo"] ."\">".$row["StrCatName"]."</option>\n";
	}
	$ResponseXML .= "</XMLURLLoadSubCat>\n";
	echo $ResponseXML;
}
if($requestType=="getStockQty")
{
	header('Content-Type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "<XMLURLgetStockQty>";
	$qty = 0;
	$matId 		  = $_GET["matId"];
	$mainStoresId = $_GET["mainStoresId"];
	
	$sql = "select coalesce(sum(StockQty),0) as StockQty
			from(
			select intMatDetailId,strMainStoresID,round(sum(dblQty),2) as StockQty
			from stocktransactions
			where strMainStoresID='$mainStoresId' and intMatDetailId='$matId'
			group by intMatDetailId,strMainStoresID
			union 
			select intMatDetailId,strMainStoresID,round(sum(dblQty),2) as StockQty
			from stocktransactions_leftover
			where strMainStoresID='$mainStoresId' and intMatDetailId='$matId'
			group by intMatDetailId,strMainStoresID
			union 
			select intMatDetailId,strMainStoresID,round(sum(dblQty),2)as StockQty
			from stocktransactions_bulk
			where strMainStoresID='$mainStoresId' and intMatDetailId='$matId'
			group by intMatDetailId,strMainStoresID
			) as stkQty
			group by intMatDetailId,strMainStoresID";
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$qty = $row["StockQty"];
		$pendingAllowQty = PendingAllocation($matId,$mainStoresId);
		$qty	= $qty - $pendingAllowQty;
	}
	$ResponseXML .= "<stockQty><![CDATA[" .  round($qty,2) . "]]></stockQty>\n";	
	$ResponseXML .= "</XMLURLgetStockQty>\n";
	echo $ResponseXML;
}
elseif($requestType=="URLColor")
{
	$styleId	= $_GET["StyleId"];
	$sql = "select distinct strColor from styleratio where intStyleId=$styleId";
	$result = $db->RunQuery($sql);
		echo "<option value="."".">".""."</option>\n";
	while($row=mysql_fetch_array($result))
	{
		echo "<option value=".$row["strColor"].">".$row["strColor"]."</option>\n";
	}
}
elseif($requestType=="URLSize")
{
	$styleId	= $_GET["StyleId"];
	$sql = "select distinct strSize from styleratio where intStyleId=$styleId";
	$result = $db->RunQuery($sql);
		echo "<option value="."".">".""."</option>\n";
	while($row=mysql_fetch_array($result))
	{
		echo "<option value=".$row["strSize"].">".$row["strSize"]."</option>\n";
	}
}
elseif($requestType=="URLLoadPopItems")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<XMLURLLoadPopItems>";

//$styleId	= $_GET["StyleId"];
$mainCat 	= $_GET["MainCat"];
$subCat 	= $_GET["SubCat"];
$itemDesc 	= $_GET["ItemDesc"];
$itemCode 	= $_GET["ItemCode"];
	$sql="SELECT
matitemlist.strItemDescription,
matitemlist.strUnit,
matitemlist.intItemSerial
FROM matitemlist
			where intStatus <> 'a' ";

if($mainCat!="")	
	$sql .= "and intMainCatID=$mainCat ";
if($subCat!="")
	$sql .= "and intSubCatID=$subCat ";
if($itemDesc!="")
	$sql .= "and strItemDescription like '%$itemDesc%' ";
if($itemCode!="")
	$sql .= "and intItemSerial = '$itemCode' ";
	
	$sql .= "order by strItemDescription ";
	//echo $sql; 
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<ItemId><![CDATA[" . $row["intItemSerial"]  . "]]></ItemId>\n";	
		$ResponseXML .= "<ItemDesc><![CDATA[" . $row["strItemDescription"]  . "]]></ItemDesc>\n";	
		$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]  . "]]></Unit>\n";
	}
$ResponseXML .= "</XMLURLLoadPopItems>\n";
echo $ResponseXML;
}
elseif($requestType=="URLAddToMainPage")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<XMLURLLoadPopItems>";

$styleId	= $_GET["StyleId"];
$MatId 		= $_GET["MatId"];
$mainStore 	= $_GET["MainStore"];
$color		= $_GET["Color"];
$size		= $_GET["Size"];

	$sql="select O.intStyleId,O.strOrderNo,SP.strMatDetailID,MIL.strItemDescription,SP.strUnit,MR.strColor,MR.strSize,MIL.intSubCatID
		from specificationdetails SP
		inner join orders O on O.intStyleId=SP.intStyleId
		inner join matitemlist MIL on MIL.intItemSerial=SP.strMatDetailID
		inner join materialratio MR on MR.intStyleId=SP.intStyleId and MR.strMatDetailID=SP.strMatDetailID  
		where SP.intStyleId=$styleId and SP.strMatDetailID=$MatId ";
	if($color!="")
		$sql .= "and MR.strColor='$color' ";
	if($size!="")
		$sql .= "and MR.strSize='$size' ";
	
	$sql .= "order by MIL.strItemDescription,MR.strColor,MR.strSize";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$stockBal = GetStockQty($row["intStyleId"],'#Main Ratio#',$row["strMatDetailID"],$row["strColor"],$row["strSize"],$mainStore);
		$ResponseXML .= "<OrderId><![CDATA[" . $row["intStyleId"]  . "]]></OrderId>\n";	
		$ResponseXML .= "<OrderNo><![CDATA[" . $row["strOrderNo"]  . "]]></OrderNo>\n";	
		$ResponseXML .= "<MatId><![CDATA[" . $row["strMatDetailID"]  . "]]></MatId>\n";	
		$ResponseXML .= "<ItemDesc><![CDATA[" . $row["strItemDescription"]  . "]]></ItemDesc>\n";	
		$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]  . "]]></Unit>\n";
		$ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";
		$ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
		$ResponseXML .= "<SubCatId><![CDATA[" . $row["intSubCatID"]  . "]]></SubCatId>\n";
		$ResponseXML .= "<StockBal><![CDATA[" . $stockBal  . "]]></StockBal>\n";
	}
$ResponseXML .= "</XMLURLLoadPopItems>\n";
echo $ResponseXML;
}
elseif($requestType=="URLGetNewSerialNo")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";	
    $No=0;
	$ResponseXML = "<XMLGetNewSerialNo>\n";
	
		$Sql="select intCompanyID,dblSopenStockNo from syscontrol where intCompanyID='$companyId'";		
		$result =$db->RunQuery($Sql);	
		$rowcount = mysql_num_rows($result);
		
		if ($rowcount > 0)
		{	
				while($row = mysql_fetch_array($result))
				{				
					$No=$row["dblSopenStockNo"];
					$NextNo=$No+1;
					$ReturnYear = date('Y');
					$sqlUpdate="UPDATE syscontrol SET dblSopenStockNo='$NextNo' WHERE intCompanyID='$companyId';";
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
	$ResponseXML .="</XMLGetNewSerialNo>";
	echo $ResponseXML;
}
elseif($requestType=="URLSaveHeader")
{
$serialNo	= $_GET["SerialNo"];
$serialYear	= $_GET["SerialYear"];

	$sql="insert into openstock_header (intSerialNo,intSerialYear,intStatus,intUserId,intCompanyId,dtmSaved)values('$serialNo','$serialYear','0','$userId','$companyId',now());";
	$result=$db->RunQuery($sql);
}
elseif($requestType=="URLSaveDetails")
{
	$serialNo		= $_GET["SerialNo"];
	$serialYear		= $_GET["SerialYear"];
	$matId			= $_GET["matId"];
	$ajMark			= $_GET["ajMark"];
	$unitprice		= $_GET["unitprice"];
	$binQty			= $_GET["binQty"];
	$mainStoreId	= $_GET["mainStoreId"];
	$subStoreId		= $_GET["subStoreId"];
	$locationId		= $_GET["locationId"];
	$binId			= $_GET["binId"];
	$StyleId		= $_GET["StyleId"];
	$Color			= $_GET["Color"];
	$Size			= $_GET["Size"];
	$grnNo			= $_GET["grnNo"];
	$grnYear		= $_GET["grnYear"];
	$grnType		= $_GET["grnType"];
	$stockType		= $_GET["stockType"];
	$buyerPoNo		= $_GET["buyerPoNo"];
	$Unit			= $_GET["Unit"];
	$StockQty			= ($ajMark=='+' ? $binQty:$ajMark.''.$binQty);

	$sql="insert into openstock_details 
			(
			intSerialNo, 
			intSerialYear, 
			intStyleId, 
			strBuyerPoNo, 
			intMatDetailId, 
			strColor, 
			strSize, 
			dblQty, 
			strAdjustMark, 
			dblUnitprice, 
			intMainStoreId, 
			intSubStoreId, 
			intLocationId, 
			intBinId, 
			intGrnNo, 
			intGrnYear, 
			strGrnType, 
			strStockType
			)
			values
			(
			'$serialNo', 
			'$serialYear', 
			'$StyleId', 
			'$buyerPoNo', 
			'$matId', 
			'$Color', 
			'$Size', 
			'$binQty', 
			'$ajMark', 
			'$unitprice', 
			'$mainStoreId', 
			'$subStoreId', 
			'$locationId', 
			'$binId', 
			'$grnNo', 
			'$grnYear', 
			'$grnType', 
			'$stockType'
			);";
	$result=$db->RunQuery($sql);
	if($result)
	{
		$booCheck = updateStockTransactionTables($serialNo,$serialYear,$matId,$mainStoreId,$subStoreId,$locationId,$binId,$StyleId,$Color,$Size,$grnNo,$grnYear,$grnType,$buyerPoNo,$Unit,$stockType,$StockQty);
		if($booCheck)
			echo "Saved";
		else
			echo "Error";
		
	}
}
elseif($requestType=="URLSaveDetails1")
{
	$serialNo		= $_GET["SerialNo"];
	$serialYear		= $_GET["SerialYear"];
	$matId			= $_GET["matId"];
	$ajMark			= $_GET["ajMark"];
	$unitprice		= $_GET["unitprice"];
	$binQty			= $_GET["binQty"];
	$mainStoreId	= $_GET["mainStoreId"];
	$subStoreId		= $_GET["subStoreId"];
	$locationId		= $_GET["locationId"];
	$binId			= $_GET["binId"];
	$StyleId		= $_GET["StyleId"];
	$Color			= $_GET["Color"];
	$Size			= $_GET["Size"];
	$grnNo			= $_GET["grnNo"];
	$grnYear		= $_GET["grnYear"];
	$grnType		= $_GET["grnType"];
	$stockType		= $_GET["stockType"];
	$buyerPoNo		= $_GET["buyerPoNo"];
	$Unit			= $_GET["Unit"];
	$StockQty			= ($ajMark=='+' ? $binQty:$ajMark.''.$binQty);

	$sql="insert into openstock_details 
			(
			intSerialNo, 
			intSerialYear, 
			intStyleId, 
			strBuyerPoNo, 
			intMatDetailId, 
			strColor, 
			strSize, 
			dblQty, 
			strAdjustMark, 
			dblUnitprice, 
			intMainStoreId, 
			intSubStoreId, 
			intLocationId, 
			intBinId, 
			intGrnNo, 
			intGrnYear, 
			strGrnType, 
			strStockType
			)
			values
			(
			'$serialNo', 
			'$serialYear', 
			'$StyleId', 
			'$buyerPoNo', 
			'$matId', 
			'$Color', 
			'$Size', 
			'$binQty', 
			'$ajMark', 
			'$unitprice', 
			'$mainStoreId', 
			'$subStoreId', 
			'$locationId', 
			'$binId', 
			'$grnNo', 
			'$grnYear', 
			'$grnType', 
			'$stockType'
			);";
	$result=$db->RunQuery($sql);
	if($result)
	{
		$booCheck = updateStockTransactionTables1($serialNo,$serialYear,$matId,$mainStoreId,$subStoreId,$locationId,$binId,$StyleId,$Color,$Size,$grnNo,$grnYear,$grnType,$buyerPoNo,$Unit,$stockType,$StockQty);
		if($booCheck)
			echo "Saved";
		else
			echo "Error";
		
	}
}
elseif($requestType=="URLSaveBinDetails")
{
$serialNo		= $_GET["SerialNo"];
$serialYear		= $_GET["SerialYear"];
$styleId		= $_GET["StyleID"];
$buyerPoNo		= $_GET["BuyerPoNo"];
$itemDetailId	= $_GET["ItemDetailId"];
$color			= $_GET["Color"];
$size			= $_GET["Size"];
$units			= $_GET["Units"];
$binQty			= $_GET["BinQty"];
$msId			= $_GET["MSId"];
$ssId			= $_GET["SSId"];
$locId			= $_GET["LocId"];
$binId			= $_GET["BinId"];
$sysYear		= date("Y");
$AjMark			= $_GET["AjMark"];
$binQty			= ($AjMark=='+' ? $binQty:$AjMark.''.$binQty);
$subCatId		= $_GET["SubCatId"];

SaveBinDetails($sysYear,$msId,$ssId,$locId,$binId,$styleId,$buyerPoNo,$serialNo,$serialYear,$itemDetailId,$color,$size,$units,$binQty,$userId,$AjMark	);
UpdateBinCapacity($msId,$ssId,$locId,$binId,$subCatId,$binQty);
}
elseif($requestType=="URLLoadOrderAndScNo")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$styleNo	= $_GET["StyleNo"];
$status		= $_GET["Status"];
$ResponseXML = "<XMLLoadOrderAndScNo>\n";
	$sql="select O.intStyleId,O.strOrderNo from orders O where O.intStatus = $status ";
	if($styleNo!="")
		$sql .= "and O.strStyle='$styleNo' ";
		$sql .= "order by O.strOrderNo";
	$result=$db->RunQuery($sql);
		$orderNo = "<option value="."".">".""."</option>\n";
	while($row=mysql_fetch_array($result))
	{
		$orderNo .= "<option value=".$row["intStyleId"].">".$row["strOrderNo"]."</option>\n";
	}
	
		$sql="select S.intSRNO,S.intStyleId from specification S inner join orders O on O.intStyleId=S.intStyleId where O.intStatus =$status ";
	if($styleNo!="")
		$sql .= "and O.strStyle='$styleNo' ";
		$sql .= "order by S.intSRNO desc";
	$result=$db->RunQuery($sql);
		$ScNo = "<option value="."".">".""."</option>\n";
	while($row=mysql_fetch_array($result))
	{
		$ScNo .= "<option value=".$row["intStyleId"].">".$row["intSRNO"]."</option>\n";
	}
		$ResponseXML .= "<OrderNo><![CDATA[" . $orderNo  . "]]></OrderNo>\n";
		$ResponseXML .= "<ScNo><![CDATA[" . $ScNo  . "]]></ScNo>\n";
$ResponseXML .= "</XMLLoadOrderAndScNo>\n";
echo $ResponseXML;
}
elseif($requestType=="URLIsRatioAvilable")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<XMLLoadOrderAndScNo>\n";
$styleId	= $_GET["StyleNo"];
$booAvailable	= 'false';
	$sql="select intStyleId from styleratio where intStyleId='$styleId'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$booAvailable = 'true';
	}
		$ResponseXML .= "<Available><![CDATA[" . $booAvailable  . "]]></Available>\n";
$ResponseXML .= "</XMLLoadOrderAndScNo>\n";
echo $ResponseXML;
}
function SaveBinDetails($sysYear,$msId,$ssId,$locId,$binId,$styleId,$buyerPoNo,$serialNo,$serialYear,$itemDetailId,$color,$size,$units,$binQty,$userId,$AjMark)
{
global $db;
	$sql="insert into stocktransactions (intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,	intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear)	values('$sysYear','$msId','$ssId','$locId','$binId','$styleId','$buyerPoNo','$serialNo','$serialYear','$itemDetailId','$color','$size','SOpStock','$units',$binQty,now(),'$userId','0','$sysYear');";
	$result=$db->RunQuery($sql);
}

function GetStockQty($styleId,$buyerPoNo,$matDetailId,$color,$size,$mainStore)
{
global $db;
$qty = 0;
	echo $sql="select COALESCE(sum(dblQty),0)as StockBal from stocktransactions where intStyleId=$styleId and strBuyerPoNo='$buyerPoNo' and intMatDetailId=$matDetailId and strColor='$color' and strSize='$size' and strMainStoresID='$mainStore'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$qty = $row["StockBal"];
	}
return $qty;
}

function UpdateBinCapacity($msId,$ssId,$locId,$binId,$subCatId,$binQty)
{
global $db;
	$sql="update storesbinallocation set dblFillQty=dblFillQty + $binQty
	where strMainID='$msId' and strSubID='$ssId' and strLocID='$locId' and strBinID='$binId' and intSubCatNo='$subCatId';";
	$result=$db->RunQuery($sql);
}
function updateStockTransactionTables($serialNo,$serialYear,$matId,$mainStoreId,$subStoreId,$locationId,$binId,$StyleId,$Color,$Size,$grnNo,$grnYear,$grnType,$buyerPoNo,$Unit,$stockType,$StockQty)
{
	global $db;
	global $userId;	
	if($stockType=='L')
	{
		 $sqlLeftOver = "insert into stocktransactions_leftover 
				(
				intYear, strMainStoresID, strSubStores, strLocation, strBin, intStyleId, strBuyerPoNo, intDocumentNo,
				intDocumentYear, intMatDetailId, strColor, strSize, strType, strUnit, dblQty, dtmDate, intUser, 
				intGrnNo, intGrnYear, strGRNType)
				values
				(
				'$serialYear', '$mainStoreId', '$subStoreId', '$locationId', '$binId', '$StyleId', '$buyerPoNo',
				'$serialNo', '$serialYear', '$matId', '$Color', '$Size', 'AdjustStock', '$Unit', 
				'$StockQty', now(), '$userId', '$grnNo', '$grnYear', '$grnType')";
		
		$resultLeftOver=$db->RunQuery($sqlLeftOver);
		if($resultLeftOver)
			return true;
		else
			return false;
	}
	if($stockType=='B')
	{
		$sqlBulk = "insert into stocktransactions_bulk 
						(
						intYear, strMainStoresID, strSubStores, strLocation, strBin, intDocumentNo, intDocumentYear,
						intMatDetailId, strColor, strSize, strType, strUnit, dblQty, dtmDate, intUser, intBulkGrnNo,
						intBulkGrnYear )
						values
						( 
						'$serialYear', '$mainStoreId', '$subStoreId', '$locationId', '$binId', '$serialNo',
						'$serialYear', '$matId', '$Color', '$Size', 'AdjustStock', '$Unit', '$StockQty', 
						now(), '$userId', '$grnNo','$grnYear' )";
		
		$resultBulk=$db->RunQuery($sqlBulk);
		if($resultBulk)
			return true;
		else
			return false;
	}
	if($stockType=='S')
	{
		$sqlStyle = "insert into stocktransactions 
					( 
					intYear, strMainStoresID, strSubStores, strLocation, strBin, intStyleId, strBuyerPoNo, 
					intDocumentNo, intDocumentYear, intMatDetailId, strColor, strSize, strType, strUnit, dblQty,
					dtmDate, intUser, intGrnNo, intGrnYear, strGRNType
					)
					values
					(
					'$serialYear', '$mainStoreId', '$subStoreId', '$locationId', '$binId', '$StyleId', '$buyerPoNo',
					'$serialNo', '$serialYear', '$matId', '$Color', '$Size', 'AdjustStock', '$Unit',
					'$StockQty', now(), '$userId', '$grnNo', '$grnYear', '$grnType')";
		
		$resultStyle=$db->RunQuery($sqlStyle);
		if($resultStyle)
			return true;
		else
			return false;
	}
}
function updateStockTransactionTables1($serialNo,$serialYear,$matId,$mainStoreId,$subStoreId,$locationId,$binId,$StyleId,$Color,$Size,$grnNo,$grnYear,$grnType,$buyerPoNo,$Unit,$stockType,$StockQty)
{
	global $db;
	global $userId;	
	if($stockType=='L')
	{
		 $sqlLeftOver = "insert into stocktransactions 
					( 
					intYear, strMainStoresID, strSubStores, strLocation, strBin, intStyleId, strBuyerPoNo, 
					intDocumentNo, intDocumentYear, intMatDetailId, strColor, strSize, strType, strUnit, dblQty,
					dtmDate, intUser, intGrnNo, intGrnYear, strGRNType
					)
					values
					(
					'$serialYear', '$mainStoreId', '$subStoreId', '$locationId', '$binId', '$StyleId', '$buyerPoNo',
					'$serialNo', '$serialYear', '$matId', '$Color', '$Size', 'AdjustStock', '$Unit',
					'$StockQty', now(), '$userId', '$grnNo', '$grnYear', '$grnType')";
		
		$resultLeftOver=$db->RunQuery($sqlLeftOver);
		if($resultLeftOver)
			return true;
		else
			return false;
	}
	if($stockType=='B')
	{
		$sqlBulk = "insert into stocktransactions_bulk 
						(
						intYear, strMainStoresID, strSubStores, strLocation, strBin, intDocumentNo, intDocumentYear,
						intMatDetailId, strColor, strSize, strType, strUnit, dblQty, dtmDate, intUser, intBulkGrnNo,
						intBulkGrnYear )
						values
						( 
						'$serialYear', '$mainStoreId', '$subStoreId', '$locationId', '$binId', '$serialNo',
						'$serialYear', '$matId', '$Color', '$Size', 'AdjustStock', '$Unit', '$StockQty', 
						now(), '$userId', '$grnNo','$grnYear' )";
		
		$resultBulk=$db->RunQuery($sqlBulk);
		if($resultBulk)
			return true;
		else
			return false;
	}
	if($stockType=='S')
	{
		$sqlStyle = "insert into stocktransactions 
					( 
					intYear, strMainStoresID, strSubStores, strLocation, strBin, intStyleId, strBuyerPoNo, 
					intDocumentNo, intDocumentYear, intMatDetailId, strColor, strSize, strType, strUnit, dblQty,
					dtmDate, intUser, intGrnNo, intGrnYear, strGRNType
					)
					values
					(
					'$serialYear', '$mainStoreId', '$subStoreId', '$locationId', '$binId', '$StyleId', '$buyerPoNo',
					'$serialNo', '$serialYear', '$matId', '$Color', '$Size', 'AdjustStock', '$Unit',
					'$StockQty', now(), '$userId', '$grnNo', '$grnYear', '$grnType')";
		
		$resultStyle=$db->RunQuery($sqlStyle);
		if($resultStyle)
			return true;
		else
			return false;
	}
}

function PendingAllocation($matId,$mainStoresId)
{
global $db;
$qty	= 0;
	$sql="select coalesce(sum(A),0) as pendingQty
		from (
		select round(sum(CLD.dblQty),2)as A from commonstock_leftoverdetails CLD
		inner join commonstock_leftoverheader CLH on CLH.intTransferNo=CLD.intTransferNo and CLH.intTransferYear=CLD.intTransferYear
		where CLD.intMatDetailId='$matId' and CLH.intStatus=0 and CLH.intMainStoresId='$mainStoresId'
		group by CLD.intMatDetailId,CLH.intMainStoresId
		union
		select round(sum(CBD.dblQty),2)as A from commonstock_bulkdetails CBD 
		inner join commonstock_bulkheader CBH on CBH.intTransferNo=CBD.intTransferNo and CBH.intTransferYear=CBD.intTransferYear
		where CBD.intMatDetailId='$matId' and CBH.intStatus=0 and CBH.intMainStoresId='$mainStoresId'
		group by CBD.intMatDetailId,CBH.intMainStoresId
		union 
		SELECT round(sum(MRD.dblBalQty),2) AS A
		FROM matrequisitiondetails AS MRD 
		Inner Join matrequisition AS MR ON MR.intMatRequisitionNo = MRD.intMatRequisitionNo AND MR.intMRNYear = MRD.intYear 
		WHERE 
		MRD.strMatDetailID =  '$matId' AND 
		MR.strMainStoresID ='$mainStoresId' and
		dblBalQty>0 
		Group By MRD.strMatDetailID,MR.strMainStoresID
		)as pendingQty";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$qty	= $row["pendingQty"];
	}
return $qty;
}
?>