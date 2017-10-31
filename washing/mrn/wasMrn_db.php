<?php
session_start();
require_once('../../Connector.php');
$request=$_GET['req'];

if($request=="saveDet"){
	$orderNo=$_GET['orderNo'];
	$color=$_GET['color'];
	$mrnDate=$_GET['mrnDate'];
	$store=$_GET['store'];
	$department=$_GET['department'];
	$QTY=$_GET['qty'];
	$user=$_SESSION['UserID'];
	$company=$_SESSION['FactoryID'];
	$remarks=$_GET['remarks'];
	
	$mrnNo=getMrnNo($company);
	$sql_save="insert into was_mrn(dblMrnNo,intMrnYear,intStyleId,strColor,dtmMrnDate,intStore,intDepartment,dblQty,dblBalQty,intUser,intCompanyId,strRemarks)
				values('$mrnNo','".date('Y')."','$orderNo','$color',now(),'$store','$department','$QTY','$QTY','$user','$company','$remarks')";
				//echo $sql_save;
	$res=$db->RunQuery($sql_save);
	if($res==1){
	updateSyscontrol($company);
		echo "1~".date('Y')."/".$mrnNo;
		
	}
	else{
		echo 2;
	}
}
else if(strcmp($request,"updateDet")==0){
	$orderNo=$_GET['orderNo'];
	$color=$_GET['color'];
	$mrnDate=$_GET['mrnDate'];
	$store=$_GET['store'];
	$department=$_GET['department'];
	$QTY=$_GET['qty'];
	$user=$_SESSION['UserID'];
	$company=$_SESSION['FactoryID'];
	$remarks=$_GET['remarks'];
	$mrnU=$_GET['mrnNo'];
	$mrnNo=explode('/',$mrnU);
	
	$sql_update="update was_mrn set dblQty='$QTY',dblBalQty='$QTY',intUser='$user',intCompanyId='$company',strRemarks='$remarks' WHERE dblMrnNo='$mrnNo[1]' AND intMrnYear='$mrnNo[0]';";
				//echo $sql_update;
	$res=$db->RunQuery($sql_update);
	if($res==1){
		echo "1~$mrnU";
		
	}
	else{
		echo 2;
	}
}
function getMrnNo($company){
	global $db;
	$sql="select dblWashMrnNo from syscontrol where intCompanyId='$company'";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['dblWashMrnNo']+1;
	
}
function updateSyscontrol($company){
	global $db;
	$sql="update syscontrol set dblWashMrnNo=dblWashMrnNo+1 where intCompanyId='$company'";
	$res=$db->RunQuery($sql);
}
?>