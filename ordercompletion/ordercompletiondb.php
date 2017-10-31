<?php
	include "../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType	= $_GET["RequestType"];
$userId			= $_SESSION["UserID"];
$companyId  	= $_SESSION["FactoryID"];

if($RequestType=="competeOrders")
{	
	$styleID=$_GET["styleID"];
	$ResponseXML.="<Details>";
	
	$sql = "UPDATE orders SET intStatus = 16,intCompletedBy='$userId',dtmCompletedDate=now() WHERE strStyleID = '$styleID'";
	//echo $sql;
	$affrows = $db->AffectedExecuteQuery($sql);
	
	 
	if ($affrows > 0)
		$ResponseXML.="<Status><![CDATA[True]]></Status>\n";
	else
		$ResponseXML.="<Status><![CDATA[False]]></Status>\n";
	$ResponseXML.="</Details>";
	echo $ResponseXML;
}
if($RequestType=="confirmOrders")
{	
	$styleID=$_GET["styleID"];
	$ResponseXML.="<Details>";

	$SQLTmpDisp	="SELECT * from stocktransactions_temp  
				 WHERE strType ='DISPOSE' and strStyleNo ='$styleID'";
	$result=$db->RunQuery($SQLTmpDisp);
	$row =@mysql_fetch_array($result);
	
	if($row["strStyleNo"]!=''){
		$ResponseXML.="<Status><![CDATA[Pending]]></Status>\n";
	}
	else{
	
	$sql = "UPDATE orders SET intStatus = 13,intCompletedBy='$userId',dtmCompletedDate=now() WHERE strStyleID = '$styleID'";
	//echo $sql;
	$affrows = $db->AffectedExecuteQuery($sql);
	
	GetStockSum($styleID,$companyId);// get total stock Qty for this style.
	 
	if ($affrows > 0)
		$ResponseXML.="<Status><![CDATA[True]]></Status>\n";
	else
		$ResponseXML.="<Status><![CDATA[False]]></Status>\n";
		
		}
	$ResponseXML.="</Details>";
	echo $ResponseXML;
}
function GetStockSum($styleID,$companyId)
{
global $db;
//hem    $sql="select sum(dblQty)as stockQty,intCompanyId,strStyleNo,strBuyerPoNo,intDocumentNo,intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit from stocktransactions S inner join mainstores M on M.strMainID=S.strMainStoresID where strStyleNo='$styleID' AND strType<>'DISPOSE' GROUP BY strStyleNo,strBuyerPoNo,intMatDetailId,strColor,strSize;";

$sql="select sum(dblQty)as stockQty,intCompanyId,strStyleNo,strBuyerPoNo,intDocumentNo,intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit from stocktransactions S inner join mainstores M on M.strMainID=S.strMainStoresID where strStyleNo='$styleID' GROUP BY strStyleNo,strBuyerPoNo,intMatDetailId,strColor,strSize;";



$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))	
	{
		$year 		= date('Y');
		$stockQty 	= $row["stockQty"];
		$companyId  = $row["intCompanyId"];
		if($stockQty>0)
		{	
			$sql_common = "select strMainID from mainstores where intCompanyId='$companyId' and intCommonBin=1;";
		
			$result_common 	= $db->RunQuery($sql_common);
			while($row_common=mysql_fetch_array($result_common))
			{
				$mainStore	= $row_common["strMainID"];
				$subStore	= 9999; //asign default substore when insert in left overs
				$location	= 9999; //asign default location when insert in left overs
				$bin		= 9999; //asign default bin when insert in left overs
			}		
				SaveLeftOverStock($year,$row["strStyleNo"],$row["strBuyerPoNo"],$row["intDocumentNo"],$row["intDocumentYear"],$row["intMatDetailId"],$row["strColor"],$row["strSize"],$row["strUnit"],$row["stockQty"],$mainStore,$subStore,$location,$bin);//put order completed items in common bin
		}
	}
	CopyDetailsToStockHistory($styleID);
}

function SaveLeftOverStock($year,$styleId,$buyerPoNo,$documentNo,$documentYear,$matdetailId,$color,$size,$unit,$stockQty,$mainStore,$subStore,$location,$bin)
{
global $db;
global $userId;
$sql="insert into stocktransactions 
	(intYear, 
	strMainStoresID, 
	strSubStores, 
	strLocation, 
	strBin, 
	strStyleNo, 
	strBuyerPoNo, 
	intDocumentNo, 
	intDocumentYear, 
	intMatDetailId, 
	strColor, 
	strSize, 
	strType, 
	strUnit, 
	dblQty, 
	dtmDate, 
	intUser)
	values
	('$year',
	'$mainStore', 
	'$subStore', 
	'$location', 
	'$bin', 
	'$styleId', 
	'$buyerPoNo', 
	'$documentNo', 
	'$documentYear', 
	'$matdetailId', 
	'$color', 
	'$size', 
	'LeftOver', 
	'$unit', 
	'$stockQty', 
	now(), 
	'$userId');";
//	echo $sql;
$result=$db->RunQuery($sql);	
}
function CopyDetailsToStockHistory($styleID)
{
global $db;
/* hem $sql="insert into stocktransactions_history 
	(lngTransactionNo, 
	intYear, 
	strMainStoresID, 
	strSubStores, 
	strLocation, 
	strBin, 
	strStyleNo, 
	strBuyerPoNo, 
	intDocumentNo, 
	intDocumentYear, 
	intMatDetailId, 
	strColor, 
	strSize, 
	strType, 
	strUnit, 
	dblQty, 
	dtmDate, 
	intUser)
	select
	lngTransactionNo, 
	intYear, 
	strMainStoresID, 
	strSubStores, 
	strLocation, 
	strBin, 
	strStyleNo, 
	strBuyerPoNo, 
	intDocumentNo, 
	intDocumentYear, 
	intMatDetailId, 
	strColor, 
	strSize, 
	strType, 
	strUnit, 
	dblQty, 
	dtmDate, 
	intUser
	from stocktransactions
	where strStyleNo='$styleID' and strType<>'LeftOver' and strType<>'DISPOSE';";*/
	
	
	
	
$sql="insert into stocktransactions_history 
	(lngTransactionNo, 
	intYear, 
	strMainStoresID, 
	strSubStores, 
	strLocation, 
	strBin, 
	strStyleNo, 
	strBuyerPoNo, 
	intDocumentNo, 
	intDocumentYear, 
	intMatDetailId, 
	strColor, 
	strSize, 
	strType, 
	strUnit, 
	dblQty, 
	dtmDate, 
	intUser)
	select
	lngTransactionNo, 
	intYear, 
	strMainStoresID, 
	strSubStores, 
	strLocation, 
	strBin, 
	strStyleNo, 
	strBuyerPoNo, 
	intDocumentNo, 
	intDocumentYear, 
	intMatDetailId, 
	strColor, 
	strSize, 
	strType, 
	strUnit, 
	dblQty, 
	dtmDate, 
	intUser
	from stocktransactions
	where strStyleNo='$styleID' and strType<>'LeftOver';";
	
	$result=$db->RunQuery($sql);
	if($result)
		DeleteFromMainStock($styleID);
}
function DeleteFromMainStock($styleID)
{
global $db;
//hem $sql="delete from stocktransactions where strStyleNo='$styleID' and strType<>'LeftOver' AND strType<>'DISPOSE';";
//----------update disposal header as confirm------------
		$update_dipHeader="UPDATE itemdisposalheader SET intStatus='2' WHERE strStyleNo='$styleID' ;";
		$resUpH=$db->RunQuery($update_dipHeader);
//-----------------------			

$sql="delete from stocktransactions where strStyleNo='$styleID' and strType<>'LeftOver';";

$result=$db->RunQuery($sql);
}

if($RequestType=="saveDet")
{
	$ResponseXML.="<Details>";

$user				=	$_SESSION["UserID"];
$comID				=	$_SESSION["CompanyID"];
$request			=	$_GET['req'];
$style				=	$_GET['style'];
$buyerPo			=	$_GET['buyerPo'];
$maiID				=	$_GET['maiID'];
$qty				=	$_GET['qty'];
$disposeQty			=	$_GET['disposeQty'];
$mainStores			=	$_GET['mainStores'];
$subStores			=	$_GET['subStores'];
$location			=	$_GET['location'];
$bin				=	$_GET['bin'];
$color				=	$_GET['color'];
$size				=	$_GET['size'];
$unitD				=	$_GET['unitD'];
$date				=	date('Y');
$disNo				= 	$_GET['disNo'];
$balanceQty			= 	$_GET['balanceQty'];

		if($disNo==''){
			$disNo=getdisposeNo($comID);
			
		 $sql_insertHeader="INSERT INTO 	itemdisposalheader(
											  intDisposeNo,
											  intYear,
											  strStyleNo,
											  intStatus,
											  strMainStoresID,
											  dtmDate,
											  intUser)
											VALUES('$disNo',
											'$date',
											'$style',
											'0',
											'$mainStores',
											now(),
											'$user'); ";//status=1 for pending disposals.
		echo $sql_insertHeader;
                 $res1=$db->RunQuery($sql_insertHeader);
			

			}
			
	$sql_insert="INSERT INTO 	stocktransactions_temp(
												  intYear,
												  strMainStoresID,
												  strSubStores,
												  strLocation,
												  strBin,
												  strStyleNo,
												  strBuyerPoNo,
												  intDocumentNo,
												  intDocumentYear,
												  intMatDetailId,
												  strColor,
												  strSize,
												  strType,
												  strUnit,
												  dblQty,
												  dtmDate,
												  intUser)
												VALUES('$date',
													'$mainStores',
													'$subStores',
													'$location',
													'$bin',
													'$style',
													'$buyerPo',
													'".$disNo."',
													'$date',
													'$maiID',
													'$color',
													'$size',
													'DISPOSE',
													'$unitD',
													'-$disposeQty',
													now(),
													'$user'); ";
	//echo $sql_insert;
	$res=$db->RunQuery($sql_insert);
		$ResponseXML.="<disVal><![CDATA[$disNo]]></disVal>\n";
	$ResponseXML.="</Details>";
	echo $ResponseXML;
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
?>