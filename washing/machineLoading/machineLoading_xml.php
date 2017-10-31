<?php
session_start();
include "../../Connector.php";
$req =  $_GET["req"];

$factory=$_SESSION['FactoryID'];
$user	=$_SESSION['UserID'];

if(strcmp($req,'loadData')==0){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$rootCardNo=$_GET['rNo'];
	$res=getDetails($rootCardNo);
	$row=mysql_fetch_assoc($res);
	$ResponseXML ="<loadDet>";
	$ResponseXML .= "<OrderNo><![CDATA[<option value=\"".$row["intStyleId"]."\">" . trim($row["strOrderNo"])  . "</option>]]></OrderNo>\n";
	$ResponseXML .= "<CostID><![CDATA[<option value=\"".$row["CostID"]."\">".$row["CostID"]."</option>]]></CostID>\n";
	$ResponseXML .= "<Lot><![CDATA[" . trim($row["strLotNo"])  . "]]></Lot>\n";	
	$ResponseXML .= "<LotQty><![CDATA[" . trim($row["intActualQty"])  . "]]></LotQty>\n";
	$ResponseXML .= "<MachineType><![CDATA[" . trim($row["intMachineType"])  . "]]></MachineType>\n";	
	$ResponseXML .= "<Machine><![CDATA[<option value=\"".$row["intMachineId"]."\">" . trim($row["strMachineName"])  . "</option>]]></Machine>\n";	
	$ResponseXML .= "<ShiftId><![CDATA[" . trim($row["intShiftId"])  . "]]></ShiftId>\n";
	$ResponseXML .= "<BatchId><![CDATA[" . trim($row["intBatchId"])  . "]]></BatchId>\n";
	$ResponseXML .= "<LotWeight><![CDATA[" . getlotWeight($row["CostID"],$row["intLotQty"])  . "]]></LotWeight>\n";
	$ResponseXML .= "<WashType><![CDATA[" . getWashType($row["CostID"])  . "]]></WashType>\n";
	$ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";
	$ResponseXML .= "<Operator><![CDATA[" . getOperators($row["intMachineId"],$row["intShiftId"]) . "]]></Operator>\n";
		
	$ResponseXML .="</loadDet>";
	
	echo $ResponseXML;
	
}
function getDetails($rootCardNo){	
  $sql="SELECT
		wr.strColor,
		wr.intActualQty,
		o.strStyle,
		o.strOrderNo,
		concat(wpd.intCostYear,'/',wpd.dblCostNo) AS CostID,
		wpd.strLotNo,
		wpd.intLotQty,
		wm.intMachineId,
		wm.strMachineName,
		wm.intMachineType,
		was_shift.intShiftId,
		wpp.dtmDate,
		o.intStyleId,
		wp.intBatchId
		FROM
		was_rootcard AS wr
		Inner Join orders AS o ON wr.intStyleId = o.intStyleId
		Inner Join was_planmachineallocationheader AS wp ON wr.intPlanId = wp.intPlanNo AND wr.intYear = wp.intPlanYear  AND wr.intBatch = wp.intBatchId
		Inner Join was_planmachineallocationdetail AS wpd ON wpd.intBatchId = wp.intBatchId
		Inner Join was_machine AS wm ON wpd.intMachine = wm.intMachineId
		Inner Join was_planlotpool AS wpp ON wp.intPlanYear = wpp.intPlanYear AND wpp.intPlanNo = wp.intPlanNo
		Inner Join was_shift ON was_shift.intShiftId = wpp.intShiftId
		WHERE
		concat(wr.intRYear,'/',wr.dblRootCartNo) = '$rootCardNo';";
		global $db;
		return $db->RunQuery($sql);
		
}

function getlotWeight($CostID,$intLotQty){
	global $db;
	$sql="SELECT
			was_actualcostheader.dblWeight,was_actualcostheader.dblQty
			FROM
			was_actualcostheader
			WHERE concat(was_actualcostheader.intYear,'/',was_actualcostheader.intSerialNo)='$CostID';";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_assoc($res);
	return ($row['dblWeight']/$row['dblQty'])*$intLotQty ;
}

function getWashType($CostID){
	global $db;
	  $sql="SELECT
			was_washtype.intWasID,
			was_washtype.strWasType
			FROM
			was_actualcostheader
			Inner Join was_washtype ON was_actualcostheader.intWashType = was_washtype.intWasID
			WHERE concat(was_actualcostheader.intYear,'/',was_actualcostheader.intSerialNo)='$CostID';";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_assoc($res);
	return $row['intWasID'].'/'.$row['strWasType'];
}

function getOperators($machine,$shift){
	global $db;
	  $sql="SELECT DISTINCT
			was_operators.intOperatorId,
			was_operators.strName
			FROM
			was_operators
			WHERE
			was_operators.intMachineId ='$machine' AND
			was_operators.strShift = '$shift'
			ORDER BY
			was_operators.strName ASC;";
		
	$res=$db->RunQuery($sql);
	$opt='';
	while($row=mysql_fetch_assoc($res)){
		$opt.="<option value=\"".$row['intOperatorId']."\">".$row['strName']."</option>";
	}
	return $opt;
}
?>
