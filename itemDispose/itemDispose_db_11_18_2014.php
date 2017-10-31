<?php
session_start();

require_once('../Connector.php');
$user				=	$_SESSION["UserID"];
$comID				=	$_SESSION["FactoryID"];
$request			=	$_GET['req'];
/*
Item Disposal Status (itemdispose table)
1-Pending
2-Confirm 
*/
if($request=="getDocumentNo")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .="<getDocNo>\n";
	
	$disNo=getdisposeNo($comID);
	$intYear = date('Y');
	//insert data to item disposal data
	insertItemDisposeData($disNo,$intYear);
	
	$ResponseXML .= "<disposeNo><![CDATA[" . $disNo  . "]]></disposeNo>\n";	
	$ResponseXML .= "<disposeYear><![CDATA[" . $intYear  . "]]></disposeYear>\n";	
	$ResponseXML .="</getDocNo>";
	echo $ResponseXML;	
}
else if($request=="saveDetails")
{
$styleId			=	$_GET['styleId'];
$buyerPo			=	trim($_GET['buyerPo']);
$matID				=	$_GET['matID'];
$disposeQty			=	$_GET['disposeQty']*-1;
$mainStores			=	$_GET['mainStores'];
$subStores			=	$_GET['subStores'];
$location			=	$_GET['location'];
$bin				=	$_GET['bin'];
$color				=	$_GET['color'];
$size				=	$_GET['size'];
$strUnit			=	$_GET['strUnit'];
$intYear			=	date('Y');
$docNo				= 	$_GET['docNo'];
$grnNo				=	$_GET['grnNo'];
$grnType			= 	$_GET["grnType"];
$arrGRNno 			=   explode('/',$grnNo);

	$sql_dis = " insert into stocktransactions_temp (intYear,strMainStoresID,strSubStores,strLocation,strBin,	intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,
intUser,intGrnNo,intGrnYear,strGRNType)
	values ('$intYear','$mainStores','$subStores','$location','$bin','$styleId','$buyerPo','$docNo','$intYear','$matID','$color','$size','StyleDispose','$strUnit','$disposeQty',now(),'$user','$arrGRNno[1]','$arrGRNno[0]','$grnType')";
	
	$result_dis = $db->RunQuery($sql_dis);
	
}
else if($request=="confirmDispose"){
$disposeId=$_GET['disposeId'];
$disposeYear = $_GET["disposeYear"];

/*$SQLstock = "INSERT INTO stocktransactions ( 																																																																																																																																																																																			intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,intUser,intGrnNo,IntGrnYear,dtmDate) SELECT intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,intUser,intGrnNo,IntGrnYear,now() FROM stocktransactions_temp  
			where intDocumentNo='$disposeArr[1]' and intDocumentYear='$disposeArr[0]' and strType='DISPOSE'";

			$resultStock = $db->RunQuery($SQLstock);
			
			if($resultStock==1){
				$sqlh="insert into itemdispose(intDocumentNo,intYear,intStatus,intPreparedBy,dtmPDate,intConfirmedBy,dtmCDate) 
				values('".$disposeArr[1]."','".$disposeArr[0]."','1','$userId','$pdate','".$_SESSION["UserID"]."',now());";
				
				$resh=$db->RunQuery($sqlh);
				
					$SQLdel		="delete from stocktransactions_temp 
					where intDocumentNo='$disposeArr[1]' and intDocumentYear='$disposeArr[0]' and strType='DISPOSE'";
					$resultDel	= $db->RunQuery($SQLdel);
					echo $resultDel;
				
			}*/
	//check stock availablity before confirm disposal
	$resStockTemp = getStockTempData($disposeId,$disposeYear);
	while($row = mysql_fetch_array($resStockTemp))
	{
		$strMainStoresID = $row["strMainStoresID"];
		$strSubStores = $row["strSubStores"];
		$strLocation = $row["strLocation"];
		$strBin = $row["strBin"];
		$intStyleId = $row["intStyleId"];
		$strBuyerPoNo = $row["strBuyerPoNo"];
		$intMatDetailId = $row["intMatDetailId"];
		$strColor = $row["strColor"];
		$strSize = $row["strSize"];
		$dblQty = abs($row["dblQty"]);
		$intGrnNo = $row["intGrnNo"];
		$intGrnYear = $row["intGrnYear"];
		$strGRNType = $row["strGRNType"];
		
		$stockQty = getStockQty($strMainStoresID,$strSubStores,$strLocation,$strBin,$intStyleId,$strBuyerPoNo,$intMatDetailId,$strColor,$strSize,$intGrnNo,$intGrnYear,$strGRNType);
		
		//$stockQty = round($stockQty, 2);
		
		if($dblQty>$stockQty)
		//if($stockQty>$dblQty)
		{
			$itemName = getItemName($intMatDetailId);
			echo 'Do not have enough stock to Dipose item :'.$itemName;//." Dispose Qty : ".$dblQty." Stock Qty : ".$stockQty." Color ".$strColor;
			return;
		}
	}
	//insert item dispose data to stocktransaction table
	insertStockDetails($disposeId,$disposeYear);
	//update itemdisposal table
	updateItemDisposeData($disposeId,$disposeYear);
	//insert data to stocktransactions_dispose table
	insertDisposeStockData($disposeId,$disposeYear);
	//delete stocktransaction temp data
	deleteStockTempData($disposeId,$disposeYear);
	
	echo '1';		
}
function getdisposeNo($comID)
{
	global $db;
	$selectMax="SELECT intItemDisposeNo FROM syscontrol WHERE intCompanyID='$comID';";
	$resMax=$db->RunQuery($selectMax);
	$rec2= mysql_fetch_array($resMax);
	$disNo = $rec2['intItemDisposeNo'];
	//echo $selectMax;
	
		$update_SysControl="UPDATE syscontrol SET intItemDisposeNo='".((int)$disNo+1) ."' WHERE intCompanyID='$comID';";
		$resUp=$db->RunQuery($update_SysControl);
		//echo $update_SysControl;
	$max=mysql_fetch_array($resMax);
	return $disNo;
}
function getStockTempData($disposeId,$disposeYear)
{
	global $db;
	$sql = "select * from stocktransactions_temp where intDocumentNo='$disposeId' and intDocumentYear='$disposeYear' and strType = 'StyleDispose'";
	return $db->RunQuery($sql);
}

function getStockQty($strMainStoresID,$strSubStores,$strLocation,$strBin,$intStyleId,$strBuyerPoNo,$intMatDetailId,$strColor,$strSize,$intGrnNo,$intGrnYear,$strGRNType)
{
	global $db;
	$sql ="select  ROUND(COALESCE(sum(dblQty),0),2) as Qty from stocktransactions
where intStyleId='$intStyleId' and strMainStoresID='$strMainStoresID' and strBuyerPoNo='$strBuyerPoNo' and intMatDetailId='$intMatDetailId' and strSubStores='$strSubStores' and strLocation='$strLocation' and strBin='$strBin' and
strColor='$strColor' and strSize='$strSize' and intGrnNo='$intGrnNo' and intGrnYear='$intGrnYear' and strGRNType='$strGRNType'";

		$result = $db->RunQuery($sql);
		$row = mysql_fetch_array($result);
		//echo $sql;
		return $row["Qty"];
}

function insertStockDetails($disposeId,$disposeYear)
{
	global $db;
	
	$sql = "INSERT INTO stocktransactions(intYear, strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,																																																																																																																																																												intDocumentNo,intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate, intUser,intGrnNo, intGrnYear, strGRNType) SELECT intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId, strBuyerPoNo,intDocumentNo, intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,now(),intUser,intGrnNo,intGrnYear,strGRNType FROM stocktransactions_temp where intDocumentNo='$disposeId' and intDocumentYear='$disposeYear' and strType='StyleDispose'";
			
	return $db->RunQuery($sql);
}

function insertItemDisposeData($disNo,$intYear)
{
	global $db;
	global $user;
		
	$sql = "insert into itemdispose	(intDocumentNo,intYear,intStatus,intPreparedBy,dtmPDate) values ('$disNo','$intYear','1','$user',now())";
	
	$res = $db->RunQuery($sql);
}

function updateItemDisposeData($disposeId,$disposeYear)
{
	global $db;
	global $user;
	
	$sql = "update itemdispose 	set intConfirmedBy = '$user' ,intStatus='2',dtmCDate = now()
	where 	intDocumentNo = '$disposeId' and intYear = '$disposeYear' ";
	$res = $db->RunQuery($sql);
}

function insertDisposeStockData($disposeId,$disposeYear)
{
global $db;
	$resStockTemp = getStockTempData($disposeId,$disposeYear);
	while($row = mysql_fetch_array($resStockTemp))
	{
		$strMainStoresID = $row["strMainStoresID"];
		$strSubStores = $row["strSubStores"];
		$strLocation = $row["strLocation"];
		$strBin = $row["strBin"];
		$intStyleId = $row["intStyleId"];
		$strBuyerPoNo = $row["strBuyerPoNo"];
		$intMatDetailId = $row["intMatDetailId"];
		$strColor = $row["strColor"];
		$strSize = $row["strSize"];
		$dblQty = abs($row["dblQty"]);
		$intGrnNo = $row["intGrnNo"];
		$intGrnYear = $row["intGrnYear"];
		$strGRNType = $row["strGRNType"];
		$intYear = $row["intYear"];
		
		insertStocktransactionDispose($intYear,$strMainStoresID,$strSubStores,$strLocation,$strBin,$intStyleId,$strBuyerPoNo,$intMatDetailId,$strColor,$strSize,$dblQty,$intGrnNo,$intGrnYear,$strGRNType,$disposeId,$disposeYear);	
	}
}

function insertStocktransactionDispose($intYear,$mainStores,$subStores,$location,$bin,$styleId,$buyerPo,$matID,$color,$size,$disposeQty,$intGrnNo,$intGrnYear,$grnType,$disposeId,$disposeYear)
{
global $db;
global $user;

	$sql = "insert into stocktransactions_dispose (intYear,strMainStoresID,strSubStores,strLocation,strBin,	intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,
intUser,intGrnNo,intGrnYear,strGRNType)
	values ('$intYear','$mainStores','$subStores','$location','$bin','$styleId','$buyerPo','$disposeId','$disposeYear','$matID','$color','$size','StyleDispose','$strUnit','$disposeQty',now(),'$user','$intGrnNo','$intGrnYear','$grnType')";
	$res = $db->RunQuery($sql);	
}

function deleteStockTempData($disposeId,$disposeYear)
{
	global $db;
	
	$sql = "delete from stocktransactions_temp where intDocumentNo='$disposeId' and  intDocumentYear='$disposeYear' and strType='StyleDispose'";
	
	$res = $db->RunQuery($sql);	
}
function getItemName($intMatDetailId)
{
	global $db;
	
	$sql = "select strItemDescription from matitemlist where intItemSerial='$intMatDetailId'";
	$res = $db->RunQuery($sql);	
	$row = mysql_fetch_array($res);
	
	return $row["strItemDescription"];
}
?>