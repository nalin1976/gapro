<?php
session_start();
require_once('../../Connector.php');
$request=$_GET['req'];
$company	= $_SESSION['FactoryID'];

if($request="saveDet")
{
$orderId	= $_GET['OrderId'];
$color		= $_GET['Color'];
$mrnDate	= $_GET['mrnDate'];
$store		= $_GET['Store'];
$department	= $_GET['Department'];
$qty		= $_GET['IssueQty'];
$user		= $_SESSION['UserID'];
$fFac		= $_GET['fFac'];
$mrnNo		= explode('/',$_GET['mrnNo']);
$Remarks	= $_GET['remarks'];

	$mrnBal=getAvlQty($_GET['mrnNo'],$company);
	
	if($mrnBal < $qty){
		$avl= $qty-$mrnBal;
		if($avl < 1)
			echo "Not available.".'~'.'';
		else
			echo "Avalable Qty : ".$mrnBal.'~'.'';
	}
	else{
		$issueNo=getIssueNo($company);
		$sql_save="insert into was_issue(intIssueNo,intIssueYear,intStyleId,strColor,dtmDate,intStore,intDepartment,dblQty,intUser,intCompanyId,intSFac,intMrnyear,dblMrnNo,strRemarks)
					values('$issueNo','".date('Y')."','$orderId','$color',now(),'$store','$department','$qty','$user','$company','$fFac','$mrnNo[0]','$mrnNo[1]','$Remarks')";
					//echo $sql_save;
		$res=$db->RunQuery($sql_save);
		if($res)
		{
			$sql="update was_mrn set dblBalQty=dblBalQty-$qty  where was_mrn.dblMrnNo='".$mrnNo[1]."' AND was_mrn.intMrnYear='".$mrnNo[0]."' AND was_mrn.intCompanyId='$company';";//  AND was_mrn.intCompanyId='';.
			$db->RunQuery($sql);
			updateSyscontrol($company);
			
				$sqlT="insert into was_stocktransactions (intYear,strMainStoresID,intStyleId,intDocumentNo,intDocumentYear,strColor,strType,dblQty,dtmDate,intUser,intCompanyId,intFromFactory,strCategory)values('".date('Y')." ','1','$orderId','$issueNo','".date('Y')."','$color','mrnIssue','-$qty',now(),'$user','$company','$fFac','In');";
	$resultU=$db->RunQuery($sqlT);
	
			echo "Issue No : ".date('Y')."/$issueNo saved successfully".'~'.date('Y')."/$issueNo";
			
		}
		else
		{
			echo "Error in Saving";
		}
	}
}

if($request="upDateDet")
{
	$iNo=$_GET['iNo'];
	
}
function getIssueNo($company){
	global $db;
	$sql="select dblWashIssueNo from syscontrol where intCompanyId='$company'";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['dblWashIssueNo']+1;
	
}

function updateSyscontrol($company){
	global $db;
	$sql="update syscontrol set dblWashIssueNo=dblWashIssueNo+1 where intCompanyId='$company'";
	$res=$db->RunQuery($sql);
}

function getAvlQty($mrnNo,$company){
	global $db;
	$sql="SELECT
		was_mrn.dblBalQty
		FROM
		was_mrn
		WHERE
		concat(was_mrn.intMrnYear,'/',was_mrn.dblMrnNo) ='$mrnNo' and was_mrn.intCompanyId='$company'";
		//echo $sql;
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['dblBalQty'];
}

?>