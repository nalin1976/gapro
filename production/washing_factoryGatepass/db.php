<?php
session_start();
include "../../Connector.php";
include "../production.php";	

$RequestType = $_GET["RequestType"];
//----------------------------
$intCompanyId =	$_SESSION["FactoryID"];
$userId		= $_SESSION['UserID'];
if($RequestType=='confirmReq'){
	
	$po=$_GET['po'];
	$gpass=$_GET['gpass'];
	$gpYear=$_GET['searchYear'];
		
		$sqlChk="select pfggph.intConfirmedBy as C  from productionfggpheader pfggph where  pfggph.intGPnumber='$gpass' and pfggph.intGPYear='$gpYear';";
		$resChk=$db->RunQuery($sqlChk);
		$rowChk=mysql_fetch_assoc($resChk);
		if(!isset($rowChk['C'])){
		
		$sqlWRF="SELECT DISTINCT productionwashreadyheader.intFactory FROM productionwashreadyheader WHERE productionwashreadyheader.intStyleId = '$po';";

		$resWRF=$db->RunQuery($sqlWRF);
		$wrFac=array();
			while($row=mysql_fetch_array($resWRF)){
				$wrFac[]=$row['intFactory'];
			}
			
			for($i=0;$i<count($wrFac);$i++){
				$cutBNo=array();
				$bNo=array();
				$color='';
		
				$SQLDV="DROP VIEW wrview;";
				$resDV=$db->RunQuery($SQLDV);
				
				$SQLCV="CREATE VIEW wrview AS SELECT DISTINCT pwr.intFactory,pwr.intStyleId,productionbundleheader.strColor FROM productionwashreadyheader AS pwr
INNER JOIN productionbundleheader ON pwr.intStyleId = productionbundleheader.intStyleId WHERE pwr.intStyleId='$po';";
				//echo $SQLCV;
				$resCV=$db->RunQuery($SQLCV);
				
				$sqlQ="SELECT
						productionfggpheader.intGPYear,
						productionfggpheader.intGPnumber,
						productionfggpdetails.strCutNo,
						productionfggpdetails.dblBundleNo,
						productionfggpdetails.intCutBundleSerial,
						Sum(productionfggpdetails.dblQty) AS QTY,
						wrview.intFactory,
						wrview.intStyleId,
						wrview.strColor
						FROM
						productionfggpheader
						INNER JOIN productionfggpdetails ON productionfggpheader.intGPnumber = productionfggpdetails.intGPnumber AND productionfggpheader.intGPYear = productionfggpdetails.intGPYear
						INNER JOIN wrview ON productionfggpheader.intStyleId = wrview.intStyleId
						WHERE
						productionfggpheader.intGPnumber = '$gpass' AND
						productionfggpheader.intGPYear = '$gpYear' AND
						productionfggpheader.intStyleId = '$po' AND
						wrview.intFactory='$wrFac[$i]'
						GROUP BY
						productionfggpheader.intGPYear,
						productionfggpheader.intGPnumber,
						wrview.intFactory,
						wrview.intStyleId";
						//echo $sqlQ;
						$resQ=$db->RunQuery($sqlQ);
						$qtyW=0;
						while($rowQ=mysql_fetch_array($resQ)){
							$qtyW+=$rowQ['QTY'];
							$color=$rowQ['strColor'];
						}
						if($qtyW > 0){
							InsertToWasStock($qtyW,$gpass,$gpYear,$color,$po,$wrFac[$i]);
						}
				$SQLDV="DROP VIEW wrview;";
				$resDV=$db->RunQuery($SQLDV);
			}
			
			
			}
			$sql="update productionfggpheader pfggph set pfggph.intConfirmedBy = '".$_SESSION['UserID']."',pfggph.dtmConfirmedOn=now(),pfggph.intStatus='0' where pfggph.intGPnumber='$gpass' and pfggph.intGPYear='$gpYear';";
				if($db->RunQuery($sql))
					echo "Successfully confirmed.";
				else
					echo "error";
}	

if(strcmp($RequestType,"cancelGP")==0){
	$gnNo=$_GET['gpNo'];
	$gpyear=$_GET['gpYear'];
	$cancelReason=$_GET['cancelReason'];
	
	$res=updateWGPCancelDet($gnNo,$gpyear,$_SESSION['UserID'],$_SESSION['FactoryID'],$cancelReason);
	echo $res;
	
	
}
if(strcmp($RequestType,'cancelGatePassDet')==0){
	$gnNo			=$_GET['gpNo'];
	$gpyear			=$_GET['gpYear'];
	$cutBundleSerial=$_GET['cutBundleSerial'];
	$bundleNo		=$_GET['bundleNo'];
	$qty			=$_GET['qty'];
	
	$res=updateFGGPDetailCancelDet($gnNo,$gpyear,$cutBundleSerial,$bundleNo,$qty);
	echo $res;
}

function updateWGPCancelDet($gnNo,$gpyear,$user,$Factory,$cancelReason){
	global $db;
	$sql="update productionfggpheader set strCancelReason='$cancelReason',intCancelUser='$user',intStatus='10'  where intGPYear='$gpyear' AND intGPnumber='$gnNo';";
	//echo $sql;
	$res=$db->RunQuery($sql);
	return $res;
}

function updateFGGPDetailCancelDet($gnNo,$gpyear,$cutBundleSerial,$bundleNo,$qty){
	global $db;
	$sqlBalQty="SELECT
				Max(p.dblBalQty) AS dblBalQty
				FROM
				productionfinishedgoodsreceivedetails AS p
				INNER JOIN productionfinishedgoodsreceiveheader AS ph ON p.dblTransInNo = ph.dblTransInNo 
				AND p.intGPTYear = ph.intGPTYear
				WHERE
				p.dblBundleNo='$bundleNo' AND
				p.intCutBundleSerial='$cutBundleSerial'
				AND ph.strTComCode = '".$_SESSION['FactoryID']."';";	
		//echo $sqlBalQty;		
		
	$sqlCV="CREATE VIEW tblCancelGP as SELECT
			p.dblBundleNo,
			p.intCutBundleSerial,
			p.dblBalQty AS dblBalQty
			FROM
			productionfinishedgoodsreceivedetails AS p
			INNER JOIN productionfinishedgoodsreceiveheader AS ph ON p.dblTransInNo = ph.dblTransInNo AND p.intGPTYear = ph.intGPTYear
			WHERE
			ph.strTComCode = '".$_SESSION['FactoryID']."';";
	$resCV=$db->RunQuery($sqlCV);
	
	$resBalQty=$db->RunQuery($sqlBalQty);
	$rowResbalQty=mysql_fetch_assoc($resBalQty);
	$balQty=$rowResbalQty['dblBalQty']+$qty;
	
	
	$sqlUpdate="update tblCancelGP set dblBalQty='$balQty' 
				where 
				dblBundleNo='$bundleNo' AND
				intCutBundleSerial='$cutBundleSerial';";
			
			
	$resUpDet=$db->RunQuery($sqlUpdate);	
	$Dv=$db->RunQuery("drop VIEW tblCancelGP;");
	
	return $resUpDet;
			
			
}
//--------------------------------------------------------------------------------
function InsertToWasStock($totQty,$fgRcvTrsfInNo,$year,$color,$styleId,$fromFactory)
{
global $userId;
global $intCompanyId;
global $db;
$year = date('Y');
$sql="insert into was_stocktransactions (intYear,strMainStoresID,intStyleId,intDocumentNo,intDocumentYear,strColor,strType,dblQty,dtmDate,intUser,intCompanyId,intFromFactory,strCategory) values ('$year ',1,'$styleId','$fgRcvTrsfInNo','$year','$color','FTransIn','-$totQty',now(),'$userId','$intCompanyId','$fromFactory','In');";
$result=$db->RunQuery($sql);
}
//----------------------------------------------------------------------------------
				/*if($resCV==1){
					echo $SQLCV;
				}*/
				/*$sqlQ="SELECT DISTINCT
						sum(productionfggpdetails.dblQty) AS QTY,
						productionfggpheader.intGPYear,
						productionfggpheader.intGPnumber,
						productionfggpheader.intStyleId,
						productionfggpdetails.strCutNo,
						productionfggpdetails.dblBundleNo,
						productionfggpdetails.intCutBundleSerial,
						productionbundleheader.strColor,
						productionwashreadyheader.intFactory
						FROM
						productionfggpheader
						INNER JOIN productionfggpdetails ON productionfggpheader.intGPnumber = productionfggpdetails.intGPnumber AND productionfggpheader.intGPYear = productionfggpdetails.intGPYear
						INNER JOIN productionwashreadyheader ON productionwashreadyheader.intStyleId = productionfggpheader.intStyleId
						INNER JOIN productionwashreadydetail ON productionwashreadydetail.intWashreadySerial = productionwashreadyheader.intWashreadySerial AND productionwashreadyheader.intWashReadyYear = productionwashreadydetail.intWashReadyYear AND productionfggpdetails.intCutBundleSerial = productionwashreadydetail.intCutBundleSerial AND productionfggpdetails.dblBundleNo = productionwashreadydetail.dblBundleNo
						INNER JOIN productionbundleheader ON productionwashreadydetail.intCutBundleSerial = productionbundleheader.intCutBundleSerial
						WHERE
						productionfggpheader.intGPnumber = '$GatePassNo' AND
						productionfggpheader.intGPYear = '$year' AND
						productionfggpheader.intStyleId = '$po' AND
						productionwashreadyheader.intFactory='$wrFac[$i]'
						group by productionfggpheader.intGPnumber,productionfggpheader.intGPYear,
						productionfggpheader.intStyleId,productionwashreadyheader.intFactory ;";*/
					//echo $sqlQ;
?>