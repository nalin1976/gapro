<?php
require_once('../../Connector.php');
$request=$_GET['req'];

$issuedId= $_GET['issuedId'];
$styId=$_GET['styId'];
$dtmDate=$_GET['dtmDate'];
$Qty=$_GET['Qty'];
$rQty=$_GET['rQty'];
$wQty=$_GET['wQty'];
$iQty=$_GET['iQty'];
$mode=$_GET['mode'];
$dtmFrom=$_GET['dtmFrom'];
$dtmTO=$_GET['dtmTO'];
$color=$_GET['color'];
$factory=$_GET['factory'];

$chkBalance		=	chkBalanceQty($styId,$color);
$chkBalanceQty	= (int)$chkBalance['intTotQty'] - (int)$chkBalance['dblIssueQty'];

if($request=="saveDet")
{
	if($chkBalanceQty >= $iQty)
	{
		$sql_GetMax="SELECT MAX(dblWasIssueNo) SERIALNO FROM syscontrol;";
		$resMax=$db->RunQuery($sql_GetMax);
		$row=mysql_fetch_array($resMax);
		$issueNo=$row['SERIALNO']+1;
		$upSysControl="UPDATE syscontrol SET dblWasIssueNo='$issueNo';";
		$sqlUpSys=$db->RunQuery($upSysControl);
		
		/*$sql_save="INSERT INTO 
					was_issuedheader(intIssueId,intStyleId,dtmDate,dblQty,dblRQty,dblWQty,dblIQty,intMode)
					VALUE
					('$issueNo','$styId','$dtmDate','$Qty','$rQty','$wQty','$iQty','$mode')";	*/
					//echo $sql_save;
		$sql_save="insert into was_issuedheader(intIssueId,intYear,intStyleId,strColor,dtmDate,dblQty,dblRQty,dblWQty,dblIQty,intMode,intStatus)
value('$issueNo','".date('Y')."','$styId','$color','$dtmDate','$Qty','$rQty','$wQty','$iQty','$mode',1);";
		$res=$db->RunQuery($sql_save);
		if($res==1)
		{
			addToStockTrans($color,$factory,$issueNo,date('Y'),$iQty);
			$uQty=(int)$chkBalance['dblIssueQty']+$iQty;
			
			$updateMachineLoadingDet="UPDATE was_machineloadingdetails SET dblIssueQty='$uQty' WHERE intStyleId='$styId' AND strColor='$color';";
			//echo $updateMachineLoadingDet;
			$resUp=$db->RunQuery($updateMachineLoadingDet);
			if($resUp==1)
			{
				echo "1~".date('Y')."/$issueNo";
			}
		}
		else
		{
			echo "0~".date('Y')."/$issueNo";
		}
	}
	else
	{
		echo "3~$chkBalanceQty";
	}
}
if($request=="updateDet")
{
/*	if($chkBalanceQty >= $iQty)
	{*/
	$No=split('/',$issuedId);
	$iPQty=getIQty($No[1],$No[0]);
		$sql_Update="UPDATE 
					was_issuedheader SET intStyleId='$styId',dtmDate='$dtmDate',dblQty='$Qty',dblRQty='$rQty',dblWQty='$wQty',dblIQty='$iQty',intMode='$mode' WHERE intIssueId='".$No[1]."' and intYear='".$No[0]."';";
					//echo $sql_Update;
		$res=$db->RunQuery($sql_Update);
		if($res==1)
		{
			
			$dif=$iQty-$iPQty;
			$sql="update was_stocktransactions set dblQty='$iQty' where intDocumentNo='".$No[1]."' and intDocumentYear='".$No[0]."' and strType='IFin';";
			$res=$db->RunQuery($sql);
			$uQty=0;
			if($dif<0){
				$uQty=$dif;
			}
			else if($dif>0){
				$uQty=$dif;
			}
			else{
				$uQty=$dif;
			}
			$updateMachineLoadingDet="UPDATE was_machineloadingdetails SET dblIssueQty=dblIssueQty+($uQty) WHERE intStyleId='$styId' AND strColor='$color';";
			//echo $updateMachineLoadingDet;
			$resUp=$db->RunQuery($updateMachineLoadingDet);
			if($resUp==1)
			{
				echo "2~$issuedId";
			}
		}
		else
		{
			echo "0~$issuedId";
		}
/*	}
	else
	{
		echo "3~$chkBalanceQty";
	}*/
}

function chkBalanceQty($styId,$color)
{
	global $db;
	$select_balance="SELECT intTotQty,dblIssueQty FROM was_machineloadingdetails WHERE intStyleId='$styId' AND strColor='$color';";
	$res=$db->RunQuery($select_balance);
	$row=mysql_fetch_array($res);
	return $row;
}
function getIQty($iNo,$iYear){
	global $db;
	$sql="select dblIQty from was_issuedheader where intIssueId='$iNo' and intYear='$iYear';";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['dblIQty'];
}
function addToStockTrans($color,$factory,$iNo,$iYear,$iQty){
	global $db;
	$year=date('Y');
	$sql_insertToTrans="insert into was_stocktransactions(intYear,strMainStoresID,intStyleId,intDocumentNo,intDocumentYear,strColor,
strType,dblQty,dtmDate,intUser,intCompanyId,strCategory)
select '$year','1',intStyleId,intIssueId,intYear,'$color','IFin',dblIQty,dtmDate,'".$_SESSION['UserID']."','$factory','In' 
from was_issuedheader where intIssueId='$iNo' and intYear='$iYear';";
//echo $sql_insertToTrans;
	$res=$db->RunQuery($sql_insertToTrans);
		$sql_insertToTransM="insert into was_stocktransactions(intYear,strMainStoresID,intStyleId,intDocumentNo,intDocumentYear,strColor,
strType,dblQty,dtmDate,intUser,intCompanyId,strCategory)
select '$year','1',intStyleId,intIssueId,intYear,'$color','IFin',-$iQty,dtmDate,'".$_SESSION['UserID']."','$factory','In' 
from was_issuedheader where intIssueId='$iNo' and intYear='$iYear';";
//echo $sql_insertToTrans;
	$res=$db->RunQuery($sql_insertToTransM);
}
?>