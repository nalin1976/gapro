<?php
include "../Connector.php";
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

$styleId	= $_GET["StyleId"];
$mainCat 	= $_GET["MainCat"];
$subCat 	= $_GET["SubCat"];
$itemDesc 	= $_GET["ItemDesc"];
	$sql="select MIL.strItemDescription,OD.strUnit,MIL.intItemSerial from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId=$styleId ";

if($mainCat!="")	
	$sql .= "and MIL.intMainCatID=$mainCat ";
if($subCat!="")
	$sql .= "and MIL.intSubCatID=$subCat ";
if($itemDesc!="")
	$sql .= "and MIL.strItemDescription like '%$itemDesc%' ";
	
	$sql .= "order by MIL.strItemDescription ";
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

	$sql="select O.intStyleId,O.strOrderNo,SP.strMatDetailID,MIL.strItemDescription,SP.strUnit,MR.strColor,MR.strSize,
	MIL.intSubCatID,  MR.dblBalQty, SP.dblUnitPrice
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
		/*$stockBal = GetStockQty($row["intStyleId"],'#Main Ratio#',$row["strMatDetailID"],$row["strColor"],$row["strSize"],$mainStore);*/
		$ratioQty		= $row["dblBalQty"];	
		$pendingBulkQty = GetPendingBulkAlloQty($MatId,$row["strColor"],$row["strSize"],$companyId,$styleId);
		$pendingLeftQty = GetPendingLeftAlloQty($MatId,$row["strColor"],$row["strSize"],$companyId,$styleId);
		$balanceQty     = $ratioQty-$pendingBulkQty-$pendingLeftQty;
		
		$ResponseXML .= "<OrderId><![CDATA[" . $row["intStyleId"]  . "]]></OrderId>\n";	
		$ResponseXML .= "<OrderNo><![CDATA[" . $row["strOrderNo"]  . "]]></OrderNo>\n";	
		$ResponseXML .= "<MatId><![CDATA[" . $row["strMatDetailID"]  . "]]></MatId>\n";	
		$ResponseXML .= "<ItemDesc><![CDATA[" . $row["strItemDescription"]  . "]]></ItemDesc>\n";	
		$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]  . "]]></Unit>\n";
		$ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";
		$ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
		$ResponseXML .= "<SubCatId><![CDATA[" . $row["intSubCatID"]  . "]]></SubCatId>\n";
		$ResponseXML .= "<StockBal><![CDATA[" . $balanceQty  . "]]></StockBal>\n";
		$ResponseXML .= "<unitPrice><![CDATA[" . $row["dblUnitPrice"]  . "]]></unitPrice>\n";
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
	//get bulk allocation no
		$Sql="select dblBulkAllocationNo from syscontrol where intCompanyID='$companyId'";
		$result =$db->RunQuery($Sql);	
		$rowcount = mysql_num_rows($result);
		
		if ($rowcount > 0)
		{	
				while($row = mysql_fetch_array($result))
				{				
					$No=$row["dblBulkAllocationNo"];
					$NextNo=$No+1;
					$ReturnYear = date('Y');
					$sqlUpdate="UPDATE syscontrol SET dblBulkAllocationNo='$NextNo' WHERE intCompanyID='$companyId';";
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
//insert data to bulk_stock_transfer_header - tempory table to transfer leftover qty from old stock	
	$sql = "insert into bulk_stock_transfer_header 
	(intTransferNo, 
	intTransferYear, 
	intStatus, 
	intUserId, 
	intCompanyId, 
	dtmdate
	)
	values
	('$serialNo', 
	'$serialYear', 
	'1', 
	'$userId', 
	'$companyId', 
	now()
	)";
	$result=$db->RunQuery($sql);
}
elseif($requestType=="URLSaveDetails")
{
$serialNo		= $_GET["SerialNo"];
$serialYear		= $_GET["SerialYear"];
$styleId		= $_GET["StyleID"];
$buyerPoNo		= $_GET["BuyerPoNo"];
$itemDetailId	= $_GET["ItemDetailId"];
$color			= $_GET["Color"];
$size			= $_GET["Size"];
$qty			= $_GET["Qty"];
$unitprice		= $_GET["unitprice"];
$grnNo			= $_GET["grnNo"]; 
$grnYear 		= $_GET["grnYear"];
$poNo			= $_GET["poNo"];
$poYear			= $_GET["poYear"];
$forderNo		= $_GET["forderNo"];

	$sql = "insert into bulk_stock_transfer_details 
	(intTransferNo, intTransferYear, intStyleId,strBuyerPoNo,intMatDetailId,strColor,strSize,dblUnitprice, dblQty,intGrnNo, 
	intGrnYear,intPoNo,intPoYear,strFrmOrderNo)
	values
	('$serialNo','$serialYear','$styleId','$buyerPoNo','$itemDetailId','$color','$size','$unitprice','$qty','$grnNo',
	'$grnYear',$poNo,$poYear,'$forderNo') ";
	
	$result=$db->RunQuery($sql);
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
	$grnNo			= $_GET["grnNo"]; 
	$grnYear 		= $_GET["grnYear"];
	//$AjMark			= $_GET["AjMark"];
	//$binQty			= ($AjMark=='+' ? $binQty:$AjMark.''.$binQty);
	$subCatId		= $_GET["SubCatId"];
	
	SaveBinDetails($grnYear,$msId,$ssId,$locId,$binId,$styleId,$buyerPoNo,$serialNo,$serialYear,$itemDetailId,$color,$size,$units,$binQty,$userId,$grnNo);
	UpdateBinCapacity($msId,$ssId,$locId,$binId,$subCatId,$binQty);
	updateMaterialRatioQty($styleId,$itemDetailId,$binQty,$buyerPoNo,$color,$size);

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

elseif($requestType=="loadSubcategoryDetails")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<XMLLoadOrdersubcat>\n";
$mainStoreID	= $_GET["mainStoreID"];
$styleId		= $_GET["styleId"];
$str = '';
	$sql="select distinct MSC.intSubCatNo,MSC.StrCatName from matsubcategory MSC 
inner join matitemlist MIL on  MIL.intSubCatID=MSC.intSubCatNo
inner join orderdetails OD on OD.intMatDetailID=MIL.intItemSerial
where OD.intStyleId=$styleId and MIL.intMainCatID ='$mainStoreID'  order by MSC.StrCatName";	 
	$result =$db->RunQuery($sql);
		
		$str .=  "<option value =\"".""."\">"."Select One"."</option>";
	while ($row=mysql_fetch_array($result))
	{		
		$str .= "<option value=\"".$row["intSubCatNo"]."\">".$row["StrCatName"]."</option>";
	}
	
	$ResponseXML .= "<subCat><![CDATA[" . $str  . "]]></subCat>\n";
	$ResponseXML .= "</XMLLoadOrdersubcat>\n";
echo $ResponseXML;
}

function SaveBinDetails($grnYear,$msId,$ssId,$locId,$binId,$styleId,$buyerPoNo,$serialNo,$serialYear,$itemDetailId,$color,$size,$units,$binQty,$userId,$grnNo)
{
global $db;
$sysYear = date('Y');
	$sql="insert into stocktransactions (intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,	intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear)	values('$sysYear','$msId','$ssId','$locId','$binId','$styleId','$buyerPoNo','$serialNo','$serialYear','$itemDetailId','$color','$size','BAlloIn','$units',$binQty,now(),'$userId','$grnNo','$grnYear');";
	$result=$db->RunQuery($sql);
}

function GetStockQty($styleId,$buyerPoNo,$matDetailId,$color,$size,$mainStore)
{
global $db;
$qty = 0;
	$sql="select COALESCE(sum(dblQty),0)as StockBal from stocktransactions where intStyleId=$styleId and strBuyerPoNo='$buyerPoNo' and intMatDetailId=$matDetailId and strColor='$color' and strSize='$size' and strMainStoresID='$mainStore'";
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

function GetPendingBulkAlloQty($matDetailId,$color,$size,$companyId,$StyleID)
{
global $db;

	$sql="select sum(BD.dblQty) as AlloQty from commonstock_bulkdetails BD
	inner join commonstock_bulkheader BH on BH.intTransferNo=BD.intTransferNo and BH.intTransferYear=BD.intTransferYear
	where BD.intMatDetailId='$matDetailId'
	and BD.strColor='$color'
	and BD.strSize='$size'
	and BH.intCompanyId='$companyId'
	and BH.intStatus=0 and BH.intToStyleId = '$StyleID' ";
	
	$result=$db->RunQuery($sql);
	$qty = 0;
		while($row=mysql_fetch_array($result))
		{
			$qty = $row["AlloQty"];		
		}
		return $qty;	
}
function GetPendingLeftAlloQty($styleId,$matDetailId,$color,$size,$companyId)
{
global $db;

	$sql="select sum(LD.dblQty)as stockQty from commonstock_leftoverdetails LD
	inner join commonstock_leftoverheader LH on LH.intTransferNo=LD.intTransferNo and LH.intTransferYear=LD.intTransferYear
	where LH.intToStyleId='$styleId'
	and LD.intMatDetailId='$matDetailId'
	and LD.strColor='$color'
	and LD.strSize='$size'
	and LH.intCompanyId='$companyId'
	and LH.intStatus=0 ";
	
	$result=$db->RunQuery($sql);
	$qty = 0;
		while($row=mysql_fetch_array($result))
		{
			$qty = $row["stockQty"];		
		}
		return $qty;	
}

function updateMaterialRatioQty($styleId,$itemDetailId,$binQty,$buyerPoNo,$color,$size)
{
global $db;
	
	$sql = 	"update materialratio 
	set
	dblBalQty = dblBalQty-$binQty
	where
	intStyleId = '$styleId' and strMatDetailID = '$itemDetailId' and strColor = '$color' and strSize = '$size'
	and strBuyerPONO = '$buyerPoNo' ";
	
	$result=$db->RunQuery($sql);
}
?>