<?php
session_start();
include_once('../../../Connector.php');
$req=$_GET['req'];

if(strcmp($req,"saveDet")==0){
	$poNo=$_GET['poNo'];
	$lineRec=$_GET['lineRec'];
	$color=$_GET['color'];
	$epfNo=$_GET['epfNo'];
	$Shift=$_GET['Shift'];
	$SewingFac=$_GET['SewingFac'];
	$chkQty =$_GET['chkQty'];
	$dmgQty = $_GET['dmgQty'];
	
	if(checkValueExist($poNo,$lineRec,$color,$epfNo,$Shift)){
		saveDet($poNo,$lineRec,$color,$epfNo,$Shift,$SewingFac,$chkQty,$dmgQty);
	}	
	else{
		echo 2;
	}
}

function checkValueExist($poNo,$lineRec,$color,$epfNo,$Shift){
	global $db;
	$sql="SELECT was_qc_checkfinish.intLineRecoder from was_qc_checkfinish WHERE was_qc_checkfinish.intLineRecoder='$lineRec' AND was_qc_checkfinish.intPoNo='$poNo' AND
was_qc_checkfinish.dtmDate='".date('Y-m-d')."' AND was_qc_checkfinish.intShift='$Shift'";
	$res=$db->RunQuery($sql);
	$nRows=mysql_num_rows($res);
	if($nRows==0)
		return true;
	else
		return false;
}

function saveDet($poNo,$lineRec,$color,$epfNo,$Shift,$SewingFac,$chkQty,$dmgQty){
	global $db;
	$sql="insert into was_qc_checkfinish(intLineRecoder,strEpfNo,intShift,intPoNo,strColor,intSewingFactory,dtmDate,intChkQty,intDmgQty,intUser,intCompanyId)
	values($lineRec,$epfNo,$Shift,$poNo,$color,$SewingFac,'".date('Y-m-d')."','$chkQty','$dmgQty','".$_SESSION['UserID']."','".$_SESSION['FactoryID']."')";
	$res=$db->RunQuery($sql);
	if($res==1)
		echo "Successfully saved.";
	else
		echo "Saving fail.";
}

function updateDet($poNo,$lineRec,$color,$epfNo,$Shift,$SewingFac,$chkQty,$dmgQty){
	global $db;
	
}
?>