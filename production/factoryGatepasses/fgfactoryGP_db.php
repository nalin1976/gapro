<?php
session_start();
include_once('../../Connector.php');
$user		=	$_SESSION['UserID'];
$Factory	=	$_SESSION['FactoryID'];

$request=$_GET['req'];

if(strcmp($request,'cancelGatePass')==0){
	$gnNo=$_GET['gpNo'];
	$gpyear=$_GET['gpYear'];
	$cancelReason=$_GET['cancelReason'];
	
	$res=updateFGGPHeaderCancelDet($gnNo,$gpyear,$user,$Factory,$cancelReason);
	echo $res;
}

if(strcmp($request,'cancelGatePassDet')==0){
	$gnNo			=$_GET['gpNo'];
	$gpyear			=$_GET['gpYear'];
	$cutBundleSerial=$_GET['cutBundleSerial'];
	$bundleNo		=$_GET['bundleNo'];
	$qty			=$_GET['qty'];
	
	$res=updateFGGPDetailCancelDet($gnNo,$gpyear,$cutBundleSerial,$bundleNo,$qty);
	echo $res;
}

function updateFGGPHeaderCancelDet($gnNo,$gpyear,$user,$Factory,$cancelReason){
	global $db;
	$sql="update productionfggpheader set strCancelReason='$cancelReason',intCancelUser='$user',intStatus='10'  where intGPYear='$gpyear' AND intGPnumber='$gnNo';";
	//echo $sql;
	$res=$db->RunQuery($sql);
	return $res;
}

function updateFGGPDetailCancelDet($gnNo,$gpyear,$cutBundleSerial,$bundleNo,$qty){
	global $db;
	$sqlBalQty="SELECT max(productionwashreadydetail.dblBalQty) as dblBalQty
				FROM
				productionfggpdetails
				WHERE
				/*productionfggpdetails.intGPYear='$gpyear' AND
				productionfggpdetails.intGPnumber='$gnNo' AND*/
				productionwashreadydetail.dblBundleNo='$bundleNo' AND
				productionwashreadydetail.intCutBundleSerial='$cutBundleSerial';";	
				
	$resBalQty=$db->RunQuery($sqlBalQty);
	$rowResbalQty=mysql_fetch_assoc($resBalQty);
	$balQty=$rowResbalQty['dblBalQty']+$qty;
	
	
	$sqlUpdate="update productionwashreadydetail set dblBalQty='$balQty' 
				where /*intGPYear='$gpyear' AND
				intGPnumber='$gnNo' AND*/
				dblBundleNo='$bundleNo' AND
				intCutBundleSerial='$cutBundleSerial';";
				
	$resUpDet=$db->RunQuery($sqlUpdate);
	return $resUpDet;
			
			
}
?>