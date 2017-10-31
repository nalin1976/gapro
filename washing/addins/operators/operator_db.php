<?php
session_start();
include_once('../../../Connector.php');
$req=$_GET['req'];

if(strcmp($req,"saveDet")==0){
	$Section=$_GET['Section'];
	$MachineName=$_GET['MachineName'];
	$Shift=$_GET['Shift'];
	$EpfNo=$_GET['EpfNo'];
	$Name=$_GET['Name'];
	$Remarks=$_GET['Remarks'];
	$intStatus=$_GET['intStatus'];
	if(checkIsExist($EpfNo)){
		insertDet($Name,$MachineName,$Shift,$Remarks,$intStatus,$Section,$EpfNo);
	}
	else{
		echo "Employee already exist, Please select the Employee to update.";
	}
}

if(strcmp($req,"updateDet")==0){
	
	$Section=$_GET['Section'];
	$MachineName=$_GET['MachineName'];
	$Shift=$_GET['Shift'];
	$EpfNo=$_GET['EpfNo'];
	$Name=$_GET['Name'];
	$Remarks=$_GET['Remarks'];
	$intStatus=$_GET['intStatus'];
	$Search=$_GET['Search'];
	if(checkIsExist($EpfNo,$Name)){
		updateDet($Search,$Name,$MachineName,$Shift,$Remarks,$intStatus,$Section,$EpfNo);
	}
	else{
		echo "Employee already exist, Please select the Employee to update.";
	}
	
}
function checkIsExist($epfNo,$Name){
  global $db;
  
  $sql="select strEpfNo from was_operators where strEpfNo='$epfNo'";
  if(isset($Name)){
	  $sql.=" AND  strName <> '$Name';";
  }
 
  $res=$db->RunQuery($sql);
  $nRows=mysql_num_rows($res);
 
  if((int)$nRows == 0 )
  	return true;
  else
  	return false;
}

function insertDet($Name,$MachineName,$Shift,$Remarks,$intStatus,$Section,$EpfNo){
	global $db;
	$sql="insert into was_operators(strName,intMachineId,strShift,strRemarks,intStatus,intSection,strEpfNo)
		  value('$Name','$MachineName','$Shift','$Remarks','$intStatus','$Section','$EpfNo');";
		  

    $res=$db->RunQuery($sql);
	if($res==1)
		echo "Successfully saved.";
	else
		echo "Saving fail.";
	
}

function updateDet($Search,$Name,$MachineName,$Shift,$Remarks,$intStatus,$Section,$EpfNo){
	global $db;
	$sql="update was_operators set strName='$Name',intMachineId='$MachineName',strShift='$Shift',strRemarks='$Remarks',intStatus='$intStatus',intSection='$Section',strEpfNo='$EpfNo' where intOperatorId='$Search';";

    $res=$db->RunQuery($sql);
	if($res==1)
		echo "Successfully updated.";
	else
		echo "Updation fail.";
}
?>