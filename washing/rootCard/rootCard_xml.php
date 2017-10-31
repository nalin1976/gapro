<?php
session_start();
$backwardseperator = "../../";
$user=$_SESSION["UserID"];
$factory=$_SESSION['FactoryID'];
include "${backwardseperator}authentication.inc";
include("${backwardseperator}Connector.php");
$requestType= $_GET["RequestType"];

if(strcmp($requestType,"loadBatchCard")==0){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$planId=$_GET['planId'];
	//$planId=split('/',$planId);
	$sql="SELECT
was_planmachineallocationheader.intBatchId,was_planmachineallocationdetail.intMachine,
concat(DATE_FORMAT(was_planheader.dtmDate,'%Y/%m/%d'),'-',was_shift.strShiftName,'-',was_planmachineallocationdetail.strLotNo) AS batch
FROM
was_planheader
Inner Join was_planmachineallocationheader ON was_planheader.intPlanYear = was_planmachineallocationheader.intPlanYear AND was_planheader.intPlanNo = was_planmachineallocationheader.intPlanNo
Inner Join was_planmachineallocationdetail ON was_planmachineallocationdetail.intBatchId = was_planmachineallocationheader.intBatchId
Inner Join was_shift ON was_planheader.intShiftId = was_shift.intShiftId 
Inner Join was_operators ON was_operators.intMachineId = was_planmachineallocationdetail.intMachine 
WHERE
concat(was_planheader.intPlanYear,'/',was_planheader.intPlanNo) ='$planId' and was_planmachineallocationheader.intStatus=0
group by was_planmachineallocationheader.intBatchId
order by was_planmachineallocationdetail.strLotNo";
//echo $sql;
	$res=$db->RunQuery($sql);
	$ResponseXML = "<XMLLoadHeader>"; 
	$opt="<option value=\"\">Select Batch</option>";
	while($row=mysql_fetch_array($res))
	{
		  $opt .= "<option value=\"".$row['intBatchId']."\">".$row['batch']."</option>"; 
	}
	$ResponseXML .="<Batch><![CDATA[".$opt."]]></Batch>\n";
	$ResponseXML .= "</XMLLoadHeader>"; 
	echo $ResponseXML;
}

if($requestType=='loadRootCardheader'){
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$batch  = $_GET['batchId'];
	$planId	= $_GET['planId'];
	$planIdArray = explode('/',$_GET['planId']);
	$costId = getCostId($planId,$batch);
	//$costId=split('/',$costId);
	
		$sql="SELECT
			orders.strStyle,
			orders.strOrderNo,
			orders.intStyleId,
			was_actualcostheader.strColor,
			was_actualcostheader.dblWeight,
			was_actualcostheader.dblQty,
			was_actualcostheader.intMachineType,
			was_planmachineallocationdetail.intMachine,
			was_planheader.intShiftId
			FROM
			was_actualcostheader
			Inner Join orders ON was_actualcostheader.intStyleId = orders.intStyleId
			Inner Join was_machinetype ON was_actualcostheader.intMachineType = was_machinetype.intMachineId
			Inner Join was_planheader on was_planheader.intPlanYear='$planIdArray[0]' and was_planheader.intPlanNo='$planIdArray[1]'
			Inner join was_planmachineallocationheader on was_planmachineallocationheader.intBatchId='$batch'
			Inner join was_planmachineallocationdetail on was_planmachineallocationheader.intBatchId=was_planmachineallocationdetail.intBatchId
			WHERE
			concat(was_actualcostheader.intYear,'/',was_actualcostheader.intSerialNo) ='$costId'";
	$res=$db->RunQuery($sql);
	//echo $sql;
	$ResponseXML = "<XMLLoadHeader>"; 
	$row=mysql_fetch_array($res);
		$ResponseXML .= "<strStyle><![CDATA[" . $row['strStyle'] . "]]></strStyle>\n";
		$ResponseXML .= "<CINPO><![CDATA[" . $row['strOrderNo'] . "]]></CINPO>\n";
		$ResponseXML .= "<intMachineType><![CDATA[" . $row['intMachineType']. "]]></intMachineType>\n";
		/*$ResponseXML .= "<intMachine><![CDATA[<option value=\"" .$row['intMachineId']. "\">".$row['strMachineName']."</option>]]></intMachine>\n";*/
		$ResponseXML .= "<PO><![CDATA[<option value=\"" . $row['intStyleId']. "\">" . $row['strOrderNo'] . "</option>]]></PO>\n";
		$ResponseXML .= "<strColor><![CDATA[" . $row['strColor'] . "]]></strColor>\n";
		$ResponseXML .= "<dblWeight><![CDATA[" . $row['dblWeight'] . "]]></dblWeight>\n";
		$ResponseXML .= "<dblQty><![CDATA[" .$row['dblQty'] . "]]></dblQty>\n";
		$ResponseXML .= "<costId><![CDATA[" .$costId . "]]></costId>\n";
		$ResponseXML .= "<RootCard><![CDATA[" . getRootCardNo($planId,$batch). "]]></RootCard>\n";
		$ResponseXML .= "<intShiftId><![CDATA[" . $row['intShiftId'] . "]]></intShiftId>\n";
		$ResponseXML .= "<intMachine><![CDATA[" . $row['intMachine'] . "]]></intMachine>\n";
		
 	$sqlGetmachines="SELECT DISTINCT w.intMachineId,w.strMachineName 
FROM was_machine AS w 
Inner Join was_planmachineallocationdetail WPD ON WPD.intMachine = w.intMachineId
WHERE WPD.intBatchId ='$batch'";
	//echo $sqlGetmachines;
	$Machine="<![CDATA[";/*<option value=\"\">Select Machine</option>*/
	$resM=$db->RunQuery($sqlGetmachines);
	$ResponseXML .="<Machines>";
	while($rowM=mysql_fetch_array($resM)){

		$Machine .= "<option value=\"" . $rowM['intMachineId']. "\">" . $rowM['strMachineName'] . "</option>";
	
	}
	$ResponseXML .= $Machine;
	$ResponseXML .="]]></Machines>";
	$ResponseXML .= "</XMLLoadHeader>"; 
	echo $ResponseXML;
}

else if($requestType=='loadProccessors'){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$costId=$_GET['costId'];
	$costId=split('/',$costId);
	
	$ResponseXML = "<XMLLoadCINP>"; 
	$sql="SELECT was_actualcostdetails.intProcessId,was_washformula.strProcessName,was_actualcostdetails.intRowID FROM
			was_actualcostdetails
			INNER JOIN was_washformula ON was_actualcostdetails.intProcessId = was_washformula.intSerialNo
			WHERE
			was_actualcostdetails.intSerialNo = '".$costId[1]."' AND
			was_actualcostdetails.intYear = '".$costId[0]."'";
	
	$res=$db->RunQuery($sql);
	while($row=mysql_fetch_array($res))
	{
		$sqlC = "SELECT
				genmatitemlist.strItemDescription,
				genmatitemlist.intItemSerial,
				WACC.dblQty,
				WACC.strUnit
				FROM
				was_actcostchemicals WACC
				INNER JOIN genmatitemlist ON WACC.intChemicalId = genmatitemlist.intItemSerial
				WHERE
				WACC.intProcessId = '".$row['intProcessId']."' AND
				WACC.intSerialNo = '".$costId[1]."' AND
				WACC.intYear = '".$costId[0]."' and
				WACC.intRowOder='".$row['intRowID']."'";	
		$resC=$db->RunQuery($sqlC);
		while($rowC=mysql_fetch_array($resC))
		{
			$ResponseXML .="<ProcessId><![CDATA[" . $row["intProcessId"] . "]]></ProcessId>\n";
			$ResponseXML .="<ProcessorName><![CDATA[" . $row["strProcessName"] . "]]></ProcessorName>\n";
			$ResponseXML .="<ChemicalDes><![CDATA[" . $rowC["strItemDescription"] . "]]></ChemicalDes>\n";
			$ResponseXML .="<Qty><![CDATA[" . $rowC["dblQty"] . "]]></Qty>\n";
			$ResponseXML .="<Unit><![CDATA[" . $rowC["strUnit"] . "]]></Unit>\n";
		}
	}
	$ResponseXML .= "</XMLLoadCINP>"; 
	echo $ResponseXML;
}

/*else if($requestType == 'loadChemicals'){
header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$costId	=	$_GET['costId'];
	$costId	=	split('/',$costId);
	$pId	=	$_GET['pId'];
	$pName	=	$_GET['pName'];
	$rowId	= $_GET["RowId"];
	$booAvail = false;
$sql="SELECT
		genmatitemlist.strItemDescription,
		genmatitemlist.intItemSerial,
		WACC.dblQty,
		WACC.strUnit
		FROM
		was_actcostchemicals WACC
		INNER JOIN genmatitemlist ON WACC.intChemicalId = genmatitemlist.intItemSerial
		WHERE
		WACC.intProcessId = '".$pId."' AND
		WACC.intSerialNo = '".$costId[1]."' AND
		WACC.intYear = '".$costId[0]."' and
		WACC.intRowOder='$rowId';";	
		$res=$db->RunQuery($sql);
		$ResponseXML .= "<XMLLoadCmcls>"; 
			
		while($row=mysql_fetch_array($res))
		{
			$ResponseXML .="<ProcessorName><![CDATA[" . $pName . "]]></ProcessorName>\n";
			$ResponseXML .="<ChemicalDes><![CDATA[" . $row["strItemDescription"] . "]]></ChemicalDes>\n";
			$ResponseXML .="<Qty><![CDATA[" . $row["dblQty"] . "]]></Qty>\n";
			$ResponseXML .="<Unit><![CDATA[" . $row["strUnit"] . "]]></Unit>\n";
		}
		$ResponseXML .= "</XMLLoadCmcls>";
		echo $ResponseXML;

}
*/
else if($requestType=="loadOperator")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$shiftId   = $_GET["shiftId"];
	$machineId = $_GET["machineId"];
	$ResponseXML .= "<XMLLoadDepartment>"; 
	
	$sql = "select strName,strEpfNo,intSection
			from was_operators
			where strShift='$shiftId' and intMachineId='$machineId'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<intSection><![CDATA[" . $row['intSection'] . "]]></intSection>\n";
		$ResponseXML .= "<strEpfNo><![CDATA[" . $row['strEpfNo'] . "]]></strEpfNo>\n";
		$ResponseXML .= "<operatorName><![CDATA[" . $row['strName'] . "]]></operatorName>\n";
	}
	$ResponseXML .= "</XMLLoadDepartment>";
	echo $ResponseXML;
	
}
function getCostId($planId,$batch){
	global $db;
	$sql="SELECT DISTINCT concat(WPMAD.intCostYear,'/',WPMAD.dblCostNo) AS CostID
FROM was_planmachineallocationheader AS WPMAH
Inner join was_planmachineallocationdetail WPMAD on WPMAD.intBatchId=WPMAH.intBatchId
WHERE concat(WPMAH.intPlanYear,'/',WPMAH.intPlanNo)='$planId' and WPMAH.intBatchId='$batch'";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['CostID'];
}

function getRootCardNo($palnId,$batch){
	global $db;
	$palnId=explode('/',$palnId);
	$sql="select COALESCE(max(intRootCardNo),1) as rt from was_rootcard where intYear='$palnId[0]' AND intPlanId='$palnId[1]' AND intBatch='$batch';";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['rt'];
}
?>
