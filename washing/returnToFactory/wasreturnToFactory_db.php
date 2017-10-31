<?php
session_start();
include "../../Connector.php";
include('../washingCommonScript.php');
include "../../production/production.php";
$req=$_GET['req'];
$intCompanyId		= $_SESSION["FactoryID"];
if($req=='chkAvl'){
	$po=$_GET['po'];
	$color=$_GET['color'];
	$qty=$_GET['qty'];
	$tFac=$_GET['tFac'];
	
	$AQty=getAvlQty($po,$color,$intCompanyId,$tFac)- getPendingIssueQty($po,$color);
	//die($AQty);
	if($AQty < $qty){
		echo $AQty;
	}
	else{
		echo $AQty;
	}
}
else if($req=='saveHeader'){

	$po=$_GET['po'];
	$color=$_GET['color'];
	$qty=$_GET['qty'];
	$tFac=$_GET['tFac'];
	$fFac=$_GET['fFac'];
	$gpNo=$_GET['gpNo'];
	$gpYear=$_GET['gpYear'];
	$factory=$_SESSION['FactoryID'];
	$remarks	= $_GET["Remarks"];
	$serialNo= getSerial($factory);
	$sql="insert into was_returntofactoryheader(dblSerial,intYear,intStyleId,strColor,dblQty,intToFac,intFromFac,dtmDate,dblGPNo,intGPYear,intUser,strRemarks)values('$serialNo','".date('Y')."','$po','$color','$qty','$tFac','$fFac',now(),'$gpNo','$gpYear','".$_SESSION['UserID']."','$remarks');";
	//echo $sql;
	$res=$db->RunQuery($sql);
	if($res==1){
		sysControl($factory);
		update_production_wip_withoutBserial($fFac,$tFac,$po,$color,'intFGReturnsBeforeWash',$qty);
		//updatewashReceive($tNo,$tYear,);
		echo "1~".date('Y')."/".$serialNo;
	}
	else{
		echo "2~".date('Y')."/".$serialNo;
	}

}
else if($req=='saveDat'){
	$serial=$_GET['serial'];
	$year=$_GET['year'];
	$cNo=$_GET['cNo'];
	$size=$_GET['size'];
	$bundle=$_GET['bundle'];
	$range=$_GET['range'];
	$shade=$_GET['shade'];
	$qty=$_GET['qty'];
	$rm=$_GET['rm'];
	$tNo=$_GET['transinNo'];
	$tYear=$_GET['transinYear'];
	$bundleSerial=$_GET['bundleSerial'];
	$gpNo=$_GET['gpNo'];
	$gpYear=$_GET['gpYear'];
	$loop=$_GET['loop'];
	$sql="insert into was_returntofactorydetails(dblSerial,intYear,strCutNo,strSize,dblBundlde,strRange,strShade,dblQty,strRemarks,dblTransInNo,intTransInYear)values('$serial','$year','$cNo','$size','$bundle','$range','$shade','$qty','$rm','$tNo','$tYear');";
	//echo $sql;
	$res=$db->RunQuery($sql);
	
	if($res==1){
			updatewashReceiveDet($tNo,$tYear,$bundle,$bundleSerial,$qty);
			updatewashReceive($tNo,$tYear,$gpNo,$gpYear,$qty);
			
		echo  1;
	}else{
		echo 2;
	}
}
//add new reacord to wash ready header table

else if($req=='updateWashReady'){
	$styleID=$_GET['po'];
	$factory=$_GET['tFac'];
	$totQty=$_GET['qty'];
	
	$pattern=getpattern($bundleSerial);
	$WashreadySerial=SelectMaxWashreadySerial();
	//echo $WashreadySerial;
	$WashReadyYear	= date('Y');
	$sql= "INSERT INTO productionwashreadyheader(intWashreadySerial ,intFactory ,intWashReadyYear ,intStyleId, strTeamNo ,strPatternNo ,strCutNo, dblTotQty, dblBalQty, intStatus, dtmDate) VALUES($WashreadySerial, $factory, $WashReadyYear, $styleID, '$teamID', '$pattern', 'Return-Cut','$totQty','$totQty', 0,now())";
	//echo $sql;
	$res = $db->RunQuery($sql);
	if($res==1){
		updateSysControl();
		echo "1~$WashreadySerial";
	}
	else{
		echo '2';
	}
}

else if($req=='updateWashReadyDet'){
$serial=$_GET['serial'];
$cutBundleSerial=$_GET['cutBundleSerial'];
$bundleNo=$_GET['bundleNo'];
$qty=$_GET['qty'];	
$rm=$_GET['rm'];
$rFac=$_GET['tFac'];
$max=getMaxbalQty($cutBundleSerial,$bundleNo,$rFac);
$sql="insert into productionwashreadydetail(intWashreadySerial,intWashReadyYear,intCutBundleSerial,dblBundleNo,dblQty,dblBalQty,intStatus,strRemarks)
values('$serial','".date('Y')."','$cutBundleSerial','$bundleNo','$qty','$qty',0,'$rm');";
$res = $db->RunQuery($sql);
updateWashReadyDetails($cutBundleSerial,$bundleNo,$rFac,$qty,$max);
}
//======================
//confirm return to factory data

else if($req=='confirmData'){

	$docNo=$_GET['docNo'];
	$docYear=$_GET['docYear'];
	$po=$_GET['po'];
	$color=$_GET['color'];
	$qty=$_GET['qty'];
	$fFac=$_GET['fFac'];
	$factory=$_SESSION['FactoryID'];
	
	$sql="insert into was_stocktransactions (intYear,strMainStoresID,intStyleId,intDocumentNo,intDocumentYear,strColor,strType,dblQty,dtmDate,intUser,intCompanyId,intFromFactory,strCategory)
values('".date('Y')."',1,'$po','$docNo','$docYear','$color','RtnToFac',-$qty,now(),'".$_SESSION['UserID']."','$intCompanyId','$fFac','In');";
//echo $sql;
	return $db->RunQuery($sql);

}

function getAvlQty($po,$color,$intCompanyId,$fFac){
	global $db;
	$sql="SELECT Sum(was_stocktransactions.dblQty) as Qty,was_stocktransactions.strColor,was_stocktransactions.intStyleId FROM was_stocktransactions WHERE was_stocktransactions.intStyleId =  '$po' AND was_stocktransactions.strColor =  '$color' AND was_stocktransactions.strMainStoresID =  '1' AND intCompanyId='$intCompanyId' and was_stocktransactions.intFromFactory='$fFac' GROUP BY was_stocktransactions.strColor,was_stocktransactions.intStyleId";
	//die($sql); 
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['Qty'];
}

function getPendingIssueQty($po,$color){
	global $db;
	$sql="SELECT Sum(was_issuedtowashheader.dblQty) AS Qty FROM was_issuedtowashheader WHERE was_issuedtowashheader.intStatus =  '0' AND was_issuedtowashheader.intStyleNo =  '$po' AND was_issuedtowashheader.strColor =  '$color' GROUP BY was_issuedtowashheader.intIssueYear,was_issuedtowashheader.strColor";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['Qty'];
}

function getSerial($factory){
	global $db;
	$sql="select dblWasFacRtn from syscontrol where intCompanyID='$factory'";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['dblWasFacRtn']+1;	
}

function sysControl($factory){
global $db;
	$sql="update syscontrol set dblWasFacRtn=dblWasFacRtn+1 where intCompanyID='$factory'";
	$res=$db->RunQuery($sql);
}

function updatewashReceive($tNo,$tYear,$gpNo,$gpYear,$qty){
	global $db;
	$sql="update productionfinishedgoodsreceiveheader set dblBalQty=dblBalQty-'$qty' where dblGatePassNo='$gpNo' and intGPYear='$gpYear' and dblTransInNo='$tNo' and intGPTYear='$tYear';";
	//echo $sql;
	$res=$db->RunQuery($sql);
}

function updatewashReceiveDet($tNo,$tYear,$bundle,$bundleSerial,$qty){
	global $db;

	$sql="update productionfinishedgoodsreceivedetails set dblBalQty=dblBalQty-'$qty',lngRecQty=lngRecQty-'$qty' where dblTransInNo='$tNo' and intGPTYear='$tYear' and dblBundleNo='$bundle' and intCutBundleSerial='$bundleSerial' ;";
	$res=$db->RunQuery($sql);
}

function getpattern($bundleSerial){
	global $db;
	$sql="SELECT productionbundleheader.strPatternNo FROM productionbundleheader WHERE productionbundleheader.intCutBundleSerial =  '$bundleSerial';";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['strPatternNo'];
}

//-------retrieve existing  intLineOutputSerial & update it by adding 1---------------------------------------
function SelectMaxWashreadySerial(){
global $db;
$intCompanyId =	$_SESSION["FactoryID"];
	$sql="select intWashreadySerial from syscontrol where intCompanyID='$intCompanyId';";
	//echo $sql; 
	$result= $db->RunQuery($sql);

	$row = mysql_fetch_array($result);
	return $row["intWashreadySerial"]+1;
	

}
//--------update syscontrol for intWashreadySerial(by Adding 1)----------------------
function updateSysControl(){
global $db;
$intCompanyId =	$_SESSION["FactoryID"];
	$sqls= "UPDATE syscontrol SET intWashreadySerial=intWashreadySerial+1 WHERE intCompanyID='$intCompanyId'";
	 $db->executeQuery($sqls);
}

function updateWashReadyDetails($cutBundleSerial,$bundleNo,$tFac,$qty,$max){
	global $db;

	//$max=getMaxbalQty($cutBundleSerial,$bundleNo,$tFac);
	/*if($max==$qty)
		$balQty=$qty;
	else*/
		$balQty=$max+$qty;
	
	$sqlView="create view washrtnupview as SELECT productionwashreadyheader.intFactory,productionwashreadydetail.dblBalQty,productionwashreadydetail.dblBundleNo,productionwashreadydetail.intCutBundleSerial FROM productionwashreadyheader Inner Join productionwashreadydetail ON productionwashreadyheader.intWashreadySerial = productionwashreadydetail.intWashreadySerial AND productionwashreadyheader.intWashReadyYear = productionwashreadydetail.intWashReadyYear WHERE productionwashreadydetail.intCutBundleSerial =  '$cutBundleSerial' AND productionwashreadydetail.dblBundleNo =  '$bundleNo' AND productionwashreadyheader.intFactory =  '$tFac';";
	//echo $sqlView;
	$resView=$db->RunQuery($sqlView);
	
	$sql="update washrtnupview set dblBalQty='$balQty' where intFactory =  '$tFac';";
	//echo $sql;
	$res=$db->RunQuery($sql);
	
	$sqlDropView="drop view washrtnupview;";
	$resDropView=$db->RunQuery($sqlDropView);
	
}

function getMaxbalQty($cutBundleSerial,$bundleNo,$tFac){
	global $db;
	$sql="SELECT Max(productionwashreadydetail.dblBalQty) as Qty FROM productionwashreadyheader Inner Join productionwashreadydetail ON productionwashreadyheader.intWashreadySerial = productionwashreadydetail.intWashreadySerial AND productionwashreadyheader.intWashReadyYear = productionwashreadydetail.intWashReadyYear WHERE productionwashreadydetail.intCutBundleSerial =  '$cutBundleSerial' AND productionwashreadydetail.dblBundleNo =  '$bundleNo ' AND productionwashreadyheader.intFactory =  '$tFac' GROUP BY productionwashreadyheader.intFactory;";
 //echo $sql;
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['Qty'];

}
?>