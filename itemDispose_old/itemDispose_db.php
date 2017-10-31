<?php
session_start();

require_once('../Connector.php');
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
$tag				=	$_GET['tag'];
if($request=="saveDet")
{	
	$docNO="";
	if($tag==0)
	{
		$disNo=0;
		$disNo=disposeNo($comID);
		$update_SysControl="UPDATE syscontrol SET intItemDisposeNo='".((int)$disNo+1) ."' WHERE intCompanyID='$comID';";
		//echo $update_SysControl;
		$resUp=$db->RunQuery($update_SysControl);
	}
	$selectMax="SELECT intItemDisposeNo FROM syscontrol WHERE intCompanyID='$comID';";
	//echo $selectMax;
	$resMax=$db->RunQuery($selectMax);
	$max=mysql_fetch_array($resMax);
	$docNO=disposeNo($comID);
	
	$sql_insert="INSERT INTO 	stocktransactions(
												  intYear,
												  strMainStoresID,
												  strSubStores,
												  strLocation,
												  strBin,
												  intStyleId,
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
													'".$docNO."',
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
	if($res=='1')
	{
		echo $tag;
	}
}
function disposeNo($comID)
{
	global $db;
	$selectMax="SELECT intItemDisposeNo FROM syscontrol WHERE intCompanyID='$comID';";
	//echo $selectMax;
	$resMax=$db->RunQuery($selectMax);
	$max=mysql_fetch_array($resMax);
	return $max['intItemDisposeNo'];
}
?>