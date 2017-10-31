<?php
session_start();
$backwardseperator = "../../";
$user=$_SESSION["UserID"];
$factory=$_SESSION['FactoryID'];
include "${backwardseperator}authentication.inc";
include("${backwardseperator}Connector.php");
$req= $_GET["req"];
if(strcmp($req,'saveRootCard')==0){
	$plan		= explode('/',$_GET['plan']);	
	$date		= $_GET['date'];	
	$batch		= $_GET['batch'];	
	$po			= $_GET['po'];	
	$color		= $_GET['color'];	
	$rootCardNo	= $_GET['rootCardNo'];	
	$shade		= $_GET['shade'];	
	$machine	= $_GET['machine'];
	$ActualQty 	= $_GET['ActualQty'];	
	$rottcardno	= getRootCardNo($factory)+1;
	$sql="insert into was_rootcard(intRYear,dblRootCartNo,intYear,intPlanId,intBatch,intStyleId,strColor,strShade,dtmDate,intUser,intStatus,intFactory,intActualQty)
	values('".date('Y')."','$rottcardno','$plan[0]','$plan[1]','$batch','$po','$color','$shade','$date','$user','1','$factory','$ActualQty');";

	$res=$db->RunQuery($sql);
	if($res==1)
	{
		updadeBatchHeader($batch);
		setRootCardNo($factory);
		echo "1~".date('Y').'/'.$rottcardno;
	}
	else
		echo "2~0";
	
}
if($req=="saveRootCardDetail")
{
	$departId = $_GET['departId'];
	$rootCrdNo = explode('/',$_GET['rootCrdNo']);
	$noOfPcs = ($_GET['noOfPcs']==''?'null':$_GET['noOfPcs']);
	$operatorName = $_GET['operatorName'];
	$EPFNo = $_GET['EPFNo'];
	$TimeInHours = ($_GET['TimeInHours']==''?'null':'"'.$_GET['TimeInHours'].'"');
	$TimeInAMPM = $_GET['TimeInAMPM'];
	$TimeOutHours = ($_GET['TimeOutHours']==''?'null':'"'.$_GET['TimeOutHours'].'"');
	$TimeOutAMPM = $_GET['TimeOutAMPM'];
	$Remarks = $_GET['Remarks'];
	
	$sql = "insert into was_rootcard_detail 
	(intRYear, intRootCardNo, intDepatmentId, dblNoOfPcs, strOperatorName, strEPFNo, strTimeIN,strTimeInAMPM, 
	strTimeOut, srtTimeOutAMPM,strRemarks)
	values
	(
	'$rootCrdNo[0]', '$rootCrdNo[1]', '$departId', $noOfPcs, '$operatorName', '$EPFNo', $TimeInHours, '$TimeInAMPM', 
	$TimeOutHours, '$TimeOutAMPM', '$Remarks');";
	$res=$db->RunQuery($sql);
	if($res)
		echo 1;
	else
		echo 0;
}
function getRootCardNo($factory){
	global $db;
	$sql="select dblWasRootCardNo from syscontrol where intCompanyId='$factory';";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_assoc($res);
	return $row['dblWasRootCardNo'];
	
}

function setRootCardNo($factory){
	global $db;
	$sql="update syscontrol set dblWasRootCardNo=dblWasRootCardNo+1 where intCompanyId='$factory';";
	$res=$db->RunQuery($sql);	
}
function updadeBatchHeader($batch)
{
	global $db;
	$sql="update was_planmachineallocationheader set intStatus ='1' where intBatchId ='$batch' ";
	$res=$db->RunQuery($sql);	
}
?>