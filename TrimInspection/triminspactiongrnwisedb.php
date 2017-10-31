<?php
session_start();
include "../Connector.php";

$requestType	= $_GET["RequestType"];
$companyId		= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

if($requestType=="SaveHeader")
{
	$grnNo 			= $_GET["intGrnNo"];
	$grnArray 		= explode('/',$grnNo);
	$sql="update grnheader set intTrimIStatus=1,intTrimIBy='$userId',dtmTrimIDate=now() where intGrnNo=$grnArray[1] and intGRNYear=$grnArray[0]";
	$result = $db->RunQuery($sql);	
}
elseif($requestType=="SaveGrnTrimInsDetails")
{
	$grnNo 			= $_GET["intGrnNo"];
	$grnArray 		= explode('/',$grnNo);
	$StyleId 		= $_GET["strStyleId"];
	$buyerPoNo 		= $_GET["BuyerPoNo"];
	$MatDetailID 	= $_GET["intMatDetailID"];
	$Color 			= $_GET["strColor"];
	$Size 			= $_GET["strSize"];	
	$PreIns 		= $_GET["PreIns"];
	$PreInsQty 		= $_GET["PreInsQty"];	
	$visIns 		= $_GET["visIns"];
	$visInsQty 		= $_GET["visInsQty"];
	$visInsQty 		= explode('%',$visInsQty);	
	$approved 		= $_GET["approved"];
	$approvedQty 	= $_GET["approvedQty"];
	$approvedRemark = $_GET["approvedRemark"];	
	$reject 		= $_GET["reject"];
	$rejectQty 		= $_GET["rejectQty"];
	$rejectRemark 	= $_GET["rejectRemark"];	
	$spApp 			= $_GET["spApp"];
	$spAppQty 		= $_GET["spAppQty"];
	$spAppRemark 	= $_GET["spAppRemark"];	
	$saveCount 		= $_GET["saveCount"];		
	
	$SQL="UPDATE grndetails SET intPreInsp =$PreIns,intPreInspQty=$PreInsQty,intInspected=$visIns,dblInspPercentage=$visInsQty[0],intInspApproved=$approved,intApprovedQty=$approvedQty,strComment='$approvedRemark',intReject=$reject,intRejectQty=$rejectQty,strReason='$rejectRemark',intSpecialApp=$spApp,intSpecialAppQty=$spAppQty,strSpecialAppReason='$spAppRemark',intTrimIStatus=1,intTrimIBy='$userId',dtmTrimIDate=now() WHERE intGrnNo=$grnArray[1] AND intGRNYear=$grnArray[0] AND intStyleId='$StyleId' AND strBuyerPONO='$buyerPoNo' AND intMatDetailID=$MatDetailID AND strColor='$Color' AND strSize='$Size'";	
	$result = $db->RunQuery($SQL);	
	
	 if($result!="")
	 	echo "Saved successfully.";
	 else
		echo "Error in saving. Please save it again.";
}
elseif($requestType=="ConfirmHeader")
{
	$grnNo 			= $_GET["intGrnNo"];
	$grnArray 		= explode('/',$grnNo);
	
	$sql="update grnheader set intTrimIStatus=2,intTrimIConfirmBy='$userId',intTrimIConfirmDate=now() where intGrnNo=$grnArray[1] and intGRNYear=$grnArray[0]";
	$result = $db->RunQuery($sql);	
}
elseif ($requestType=="ConfirmGrnTrimInsDetails")
{
	$grnNo 			= $_GET["intGrnNo"];
	$grnArray 		= explode('/',$grnNo);
	$StyleId 		= $_GET["strStyleId"];
	$buyerPoNo 		= $_GET["BuyerPoNo"];
	$MatDetailID 	= $_GET["intMatDetailID"];
	$Color 			= $_GET["strColor"];
	$Size 			= $_GET["strSize"];	
	$approvedQty 	= $_GET["approvedQty"];
		
//BEGIN
UpdateGrnDetails($grnArray[0],$grnArray[1],$StyleId,$buyerPoNo,$MatDetailID,$Color,$Size);
//END
//Start - 08-12-2010 - Reduce the approved qty from the stock_temp and insert to stock table
$a1 		= $approvedQty;
$year 		= date('Y');
$sql = "select * from stocktransactions_temp ST_Twmp where intGrnNo='$grnArray[1]' and intGrnYear='$grnArray[0]' and intStyleId=$StyleId and strBuyerPoNo='$buyerPoNo' and intMatDetailId=$MatDetailID and strColor='$Color' and strSize='$Size' and strType='GRN'";
$result=$db->RunQuery($sql);

while($row=mysql_fetch_array($result))
{	
	$temp_qty 	= $row["dblQty"];	
	if($temp_qty < $a1)
	{
		$a 	= $temp_qty;			
	}
	else
	{
		 $a = $a1;
	}
	$a1 	= $a1 - $a;
	$qty	= $a;
	if($a!=0)	
	{
		UpdateTemp($qty,$grnArray[1],$grnArray[0],$row["intStyleId"],$row["strBuyerPoNo"],$MatDetailID,$Color,$Size,$row["strMainStoresID"],$row["strSubStores"],$row["strLocation"],$row["strBin"]);	
		
		InsertToStock($year,$row["strMainStoresID"],$row["strSubStores"],$row["strLocation"],$row["strBin"],$row["intStyleId"],$row["strBuyerPoNo"],$grnArray[1],$grnArray[0],$MatDetailID,$Color,$Size,$row["strType"],$row["strUnit"],$qty,$row["intUser"]);
			
		DeleteZeroStock($grnArray[1],$grnArray[0],$row["intStyleId"],$row["strBuyerPoNo"],$MatDetailID,$Color,$Size,$row["strMainStoresID"],$row["strSubStores"],$row["strLocation"],$row["strBin"]);
	}	
}
echo "Confirmed successfully.";
//Start - 08-12-2010 - Reduce the approves qty from the stock_temp ans insert to stock table
}

function UpdateTemp($qty1,$docNo,$docYear,$orderId,$buyerPo,$matId,$Color,$Size,$mainId,$subId,$locationId,$binId)
{
global $db;
$sql="update stocktransactions_temp set dblQty = dblQty - $qty1 where intGrnNo='$docNo' and intGrnYear='$docYear' and intStyleId=$orderId and strBuyerPoNo='$buyerPo' and intMatDetailId=$matId and strColor='$Color' and strSize='$Size' and strtype='GRN' and  strMainStoresID=$mainId and strSubStores=$subId and strLocation=$locationId and strBin=$binId";
$result=$db->RunQuery($sql);
}

function InsertToStock($year,$mainId,$subId,$locationId,$binId,$orderId,$buyerPo,$docNo,$docYear,$matId,$color,$size,$type,$unit,$qty,$userId)
{
global $db;

	$sql="insert into stocktransactions (intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear,strGRNType)
		values('$year', 
		'$mainId', 
		'$subId', 
		'$locationId', 
		'$binId', 
		'$orderId', 
		'$buyerPo', 
		'$docNo', 
		'$docYear', 
		'$matId', 
		'$color', 
		'$size', 
		'$type', 
		'$unit', 
		'$qty', 
		now(), 
		'$userId', 
		'$docNo', 
		'$docYear','S');";
	$result=$db->RunQuery($sql);

	$sql_stn = "select intSTNno from grnheader where intGrnNo=$docNo and intGRNYear=$docYear";
	$result_stn = $db->RunQuery($sql_stn);
	$row_stn = mysql_fetch_array($result_stn);
	if($row_stn["intSTNno"]!="")
	{
		SaveStockTransaction($year,$mainId,$subId,$locationId,$binId,$orderId,$buyerPo,$docNo,$docYear,$matId,$color,$size,"STNF",$unit,$qty*-1,$userId);
		$v_mainId 		= GetVirtualMainstore($mainId);
		$v_subId 		= GetVertualSubStore($subId);
		$v_locationId	= GetVertualLocation($locationId);
		$v_binId 		= GetVertualBin($binId);
		SaveStockTransaction($year,$v_mainId,$v_subId,$v_locationId,$v_binId,$orderId,$buyerPo,$docNo,$docYear,$matId,$color,$size,"STNT",$unit,$qty,$userId);
	}
}

function SaveStockTransaction($year,$mainId,$subId,$locationId,$binId,$orderId,$buyerPo,$docNo,$docYear,$matId,$color,$size,$type,$unit,$qty,$userId)
{
global $db;
$sql="insert into stocktransactions (intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear,strGRNType)values('$year','$mainId','$subId','$locationId','$binId','$orderId','$buyerPo','$docNo','$docYear','$matId','$color','$size','$type','$unit','$qty',now(),'$userId','$docNo','$docYear','S');";
$result=$db->RunQuery($sql);
}

function DeleteZeroStock($docNo,$docYear,$orderId,$buyerPo,$matId,$Color,$Size,$mainId,$subId,$locationId,$binId)
{
global $db;
$sql="delete from stocktransactions_temp where intGrnNo='$docNo' and intGrnYear='$docYear' and intStyleId=$orderId and strBuyerPoNo='$buyerPo' and intMatDetailId=$matId and strColor='$Color' and strSize='$Size' and strtype='GRN' and strMainStoresID=$mainId and strSubStores=$subId and strLocation=$locationId and strBin=$binId and dblQty <=0
";
$result=$db->RunQuery($sql);
}

function GetVirtualMainstore($mainStore)
{
	global $db;
	$sql="select strMainID from mainstores where intSourceStores='$mainStore' and intStatus=1";
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["strMainID"];
}

function GetVertualSubStore($subStoreId)
{
	global $db;
	$sql="select strSubID from substores where intSourceStores='$subStoreId'";
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["strSubID"];
}

function GetVertualLocation($location)
{
	global $db;
	$sql="select strLocID from storeslocations where intSourceStores='$location'";
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["strLocID"];
}

function GetVertualBin($bin)
{
global $db;
	$sql="select strBinID from storesbins where intSourceStores='$bin'";
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["strBinID"];
}

function UpdateGrnDetails($grnYear,$grnNo,$styleId,$buyerPoNo,$MatDetailID,$color,$size)
{
global $db;
global $userId;
$sql="update grndetails set intTrimIStatus=2,intTrimIConfirmBy='$userId',intTrimIConfirmDate=now() where intGRNYear='$grnYear' and intGrnNo='$grnNo' and intStyleId='$styleId' and strBuyerPONO='$buyerPoNo' and intMatDetailID='$MatDetailID' and strColor='$color' and strSize='$size' ";
$result=$db->RunQuery($sql);
}
?>