<?php
session_start();
include "../../Connector.php";

$id = $_GET["id"];

if($id == "saveHeader"){
    $PoNo = $_GET["PoNo"];
	$CostId= explode('/',$_GET["CostId"]);
	$washtype= $_GET["washtype"];
	$Color= $_GET["Color"];
	$Machine= $_GET["Machine"];
	$MachineType =  $_GET["MachineType"];
	$Shift= $_GET["Shift"];
	$MachineOperator= $_GET["MachineOperator"];
	$Status= $_GET["Status"];
	$LotNo= $_GET["LotNo"];
	$RootCardNo= $_GET["RootCardNo"];
	$rootCardArry = explode('/',$RootCardNo);
	$Qty= $_GET["Qty"];
	$LotWeight= $_GET["LotWeight"];
	$dateIn= $_GET["dateIn"];
	$dateOut= $_GET["dateOut"];
	$timeIn   	   = $_GET["TimeInHours"];
	$TimeInAMPM    = $_GET["TimeInAMPM"];
	//$timeIn = $TimeInHours.".".$TimeInMinutes.".".$TimeInAMPM;
	
	$timeOut	    = $_GET["TimeOutHours"];
	$TimeOutAMPM    = $_GET["TimeOutAMPM"];
	$rewashStatus    = $_GET["rewashStatus"];
	//$timeOut = $TimeOutHours.".".$TimeOutMinutes.".".$TimeOutAMPM;
	
	
	$SQL1 = "SELECT * FROM was_machineloadingheader  WHERE intRootCardNo='$rootCardArry[1]' 
	AND intRootCardYear='$rootCardArry[0]' AND intStyleId='$PoNo' and intLotNo='$LotNo' AND  intStatus='$Status' 
	AND strRewashStatus='$rewashStatus'";
	//echo $SQL1;
    $result1 = $db->RunQuery($SQL1);
	if(mysql_num_rows($result1)>0){
	echo "-1";

	}else{
	$SQL2 = "insert into was_machineloadingheader 
	(intStyleId, intCostId, intWashType, strColor, intMachineType, intMachineId, intShiftId, intOperatorId,
	 intStatus,strRewashStatus ,intLotNo, intRootCardNo, intRootCardYear, dblQty, dblWeight, dtmInDate, 
	dtmOutDate, tmInTime, tmInAmPm, tmOutTime, tmOutAmPm
	)
	values
	('$PoNo', '$CostId[1]', '$washtype', '$Color', '$MachineType', '$Machine', '$Shift', '$MachineOperator',
	 '$Status', '$rewashStatus', '$LotNo', '$rootCardArry[1]', '$rootCardArry[0]', '$Qty', '$LotWeight', '$dateIn', 
	 '$dateOut', '$timeIn', '$TimeInAMPM', '$timeOut', '$TimeOutAMPM');";
	//echo $SQL2;
    $result2 = $db->RunQuery($SQL2);
	if ($result2==1){
	echo "1";
	}else{
	echo "saving-error";
	}
	}
}

if($id == "updateHeader"){
    $PoNo = $_GET["PoNo"];
	$CostId= $_GET["CostId"];
	$washtype= $_GET["washtype"];
	$Color= $_GET["Color"];
	$Machine= $_GET["Machine"];
	$MachineType =  $_GET["MachineType"];
	$Shift= $_GET["Shift"];
	$MachineOperator= $_GET["MachineOperator"];
	$Status= $_GET["Status"];
	$LotNo= $_GET["LotNo"];
	$RootCardNo= $_GET["RootCardNo"];
	$rootCardArry = explode('/',$RootCardNo);
	$Qty= $_GET["Qty"];
	$LotWeight= $_GET["LotWeight"];
	$dateIn= $_GET["dateIn"];
	$dateOut= $_GET["dateOut"];
	$TimeInHours   = $_GET["TimeInHours"];
	$TimeInMinutes = $_GET["TimeInMinutes"];
	$TimeInAMPM = $_GET["TimeInAMPM"];
	$timeIn = $TimeInHours.".".$TimeInMinutes.".".$TimeInAMPM;
	$TimeOutHours   = $_GET["TimeOutHours"];
	$TimeOutMinutes = $_GET["TimeOutMinutes"];
	$TimeOutAMPM    = $_GET["TimeOutAMPM"];
	$timeOut = $TimeOutHours.".".$TimeOutMinutes.".".$TimeOutAMPM;
	$rewashStatus    = $_GET["rewashStatus"];
	
	$SQL1 = "SELECT * FROM was_machineloadingheader  WHERE intRootCardNo='$rootCardArry[1]' AND intRootCardYear='$rootCardArry[0]' AND intStyleId='$PoNo' AND intStatus='$Status' AND strRewashStatus='$rewashStatus'";
    $result1 = $db->RunQuery($SQL1);
	if(mysql_num_rows($result1)){
	$SQL2 = "UPDATE was_machineloadingheader SET intCostId='$CostId',
	                                             intWashType='$washtype',
												 strColor='$Color',
												 intMachineId='$Machine',
												 intMachineType='$MachineType',
												 intShiftId='$Shift',
												 intOperatorId='$MachineOperator',
												 intLotNo='$LotNo',
												 intRootCardNo='$rootCardArry[1]',
												 intRootCardYear='$rootCardArry[0]',
												 dblQty='$Qty',
												 dblWeight='$LotWeight',
												 dtmInDate='$formateddateIn',
												 dtmOutDate='$formateddateOut',
												 tmInTime='$timeIn',
												 tmOutTime='$timeOut'
    WHERE intRootCardNo='$rootCardArry[1]' AND intRootCardYear='$rootCardArry[0]' AND intStyleId='$PoNo' AND intStatus='$Status' AND strRewashStatus='$rewashStatus'";
	//echo $SQL2;
	$result2 = $db->RunQuery($SQL2);
	}else{
	$SQL2 = "INSERT INTO     was_machineloadingheader(intStyleId,intCostId,intWashType,strColor,intMachineId,intMachineType,intShiftId,
intOperatorId ,intStatus,strRewashStatus,intLotNo,intRootCardNo,intRootCardYear,dblQty,dblWeight,dtmInDate,
dtmOutDate,tmInTime)
VALUES('$PoNo','$CostId','$washtype','$Color','$Machine','$MachineType','$Shift','$MachineOperator','$Status',
'$rewashStatus','$LotNo','$rootCardArry[1]','$rootCardArry[0]','$Qty','$LotWeight','$formateddateIn',
'$formateddateOut','$timeIn')";
			//echo $SQL2;
    $result2 = $db->RunQuery($SQL2);
	}
	if ($result2==1){
	echo "1";
	}else{
	echo "saving-error";
	}

}

if($id == "saveDetails"){
 $PoNo = $_GET["PoNo"];
 $color = $_GET["color"];
 $Status = $_GET["Status"];
 $Qty  = $_GET["Qty"];
 if($Status == '1'){
 	$SQL1 = "SELECT intStyleId,strColor,intTotQty FROM was_machineloadingdetails WHERE intStyleId='$PoNo' AND strColor='$color'";
    $result1 = $db->RunQuery($SQL1);
		while($row=mysql_fetch_array($result1))
		{
		 $TotQty = $row["intTotQty"];
		}
	if(mysql_num_rows($result1))
	{
	$intTotQty = $Qty + $TotQty;
	$SQL2 = "UPDATE was_machineloadingdetails SET intTotQty='$intTotQty' WHERE intStyleId='$PoNo' AND strColor='$color'";
	$result2 = $db->RunQuery($SQL2);
	//echo $SQL2;
	}else{
	$SQL2 = "INSERT INTO was_machineloadingdetails(intStyleId,strColor,intTotQty)VALUES('$PoNo','$color','$Qty')";
	//echo $SQL2;
	$result2 = $db->RunQuery($SQL2);
	}
  }	
}

if($id == "updateDetails"){
 $PoNo = $_GET["PoNo"];
 $color = $_GET["color"];
 $Qty  = $_GET["Qty"];
 
 	$SQL1 = "SELECT intStyleId,strColor,intTotQty FROM was_machineloadingdetails WHERE intStyleId='$PoNo' AND strColor='$color'";
    $result1 = $db->RunQuery($SQL1);
		while($row=mysql_fetch_array($result1))
		{
		 $TotQty = $row["intTotQty"];
		}
	if(mysql_num_rows($result1)){
	$intTotQty = $Qty + $TotQty;
	$SQL2 = "UPDATE was_machineloadingdetails SET intTotQty='$intTotQty' WHERE intStyleId='$PoNo' AND strColor='$color'";
	$result2 = $db->RunQuery($SQL2);
	//echo $SQL2;
	}else{
	$SQL2 = "INSERT INTO was_machineloadingdetails(intStyleId,strColor,intTotQty)VALUES('$PoNo','$color','$Qty')";
	$result2 = $db->RunQuery($SQL2);
	}
}
?>