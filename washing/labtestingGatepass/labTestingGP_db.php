<?php 
session_start();
$backwardseperator = "../../";	
include("{$backwardseperator}Connector.php");
$req=$_GET['req'];


if($req="saveDet")
{
	$po	        = $_GET['po'];
	$color		= $_GET['color'];
	$sFac   	= $_GET['sFac'];
	$toFac		= $_GET['toFac'];
	$vNo	    = $_GET['vNo'];
	$qty		= $_GET['qty'];	
	$fFac		= $_GET['fFac'];
	$mrnNo		= explode('/',$_GET['rqNo']);
	$remarks	= $_GET['remarks'];
	$toFac	    = $_GET['toFac'];
	$user		= $_SESSION['UserID'];
	$gpNo       = getGPNo($fFac);
	
	$sql="insert into was_labtestinggp(intLabGPYear,dblLabGPNo,intStyleNo,strColor,strVehicalNo,intRequestYear,dblRequestNo,intToFac,intSFac,strRemarks,intUserId,intFromFac,dblQty,dtmDate)
	values('".date('Y-m-d')."','$gpNo','$po','$color','$vNo','$mrnNo[0]','$mrnNo[1]','$toFac','$sFac','$remarks','$user','$fFac','$qty',now());";
	$res=$db->RunQuery($sql);
	if($res){
		updateGPNo($fFac);
		$sqlT="insert into was_stocktransactions (intYear,strMainStoresID,intStyleId,intDocumentNo,intDocumentYear,strColor,strType,dblQty,dtmDate,intUser,intCompanyId,intFromFactory,strCategory)values('".date('Y')." ','1','$po','$gpNo','".date('Y')."','$color','labTest','-$qty',now(),'$user','$toFac','$sFac','In');";
	$resultU=$db->RunQuery($sqlT);
		echo date('Y')."/".$gpNo."~Sucessfully saved.";
	}
	else
		echo "0~Saving Fail.";
}

function  getGPNo($fFac){
	global $db;
	$sql="select dblLabGPNo from syscontrol where intCompanyId='".$fFac."';";
	$res=$db->RunQuery($sql);	
	$row=mysql_fetch_assoc($res);
	return ($row['dblLabGPNo']);
}

function  updateGPNo($fFac){
	global $db;
	$sql="update syscontrol set dblLabGPNo=dblLabGPNo+1 where intCompanyId='".$fFac."';";
	$res=$db->RunQuery($sql);	
}