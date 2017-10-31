<?php
session_start();
$backwardseperator = "../../";
include "${backwardseperator}authentication.inc";
include('../../Connector.php');
include("class.washingplan.php");
$wrsr=new washingplan();

$req=$_GET['req'];

if(strcmp($req,"loadPoPool")==0){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$planNo=$_GET['planNo'];
	$res=getPOPoolDets($planNo);
	$ResponseXML .="<loadDet>";
	while($row=mysql_fetch_assoc($res)){
		$ResponseXML .="<PO><![CDATA[" .$row['intStyleId']."]]></PO>";
		$ResponseXML .="<ONo><![CDATA[" .$row['strOrderNo']."]]></ONo>";
		$ResponseXML .="<OQty><![CDATA[" .$row['intQty']."]]></OQty>";
		$ResponseXML .="<ExPercentage><![CDATA[" .$row['reaExPercentage']."]]></ExPercentage>";
		$ResponseXML .="<PlanedQty><![CDATA[" .$row['dblPlanedQty']."]]></PlanedQty>";
		
		$ResponseXML .="<Date><![CDATA[" .$row['dtmDate']."]]></Date>";
		$ResponseXML .="<Shift><![CDATA[" .$row['intShiftId']."]]></Shift>";
	}
	$ResponseXML .="</loadDet>";
	echo $ResponseXML;
}

if(strcmp($req,"loadLotPool")==0){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$planNo=$_GET['planNo'];
	$res=getBatchId($planNo);
	$ResponseXML .="<loadDet>"; 
	while($row=mysql_fetch_assoc($res))
	{
		$batchId = $row["intBatchId"];
		$styleId = getStyleId($batchId);
		$Machine = getMachinId($batchId);
		$costId = getCostId($batchId);
		$lotNo  = getLotNo($batchId);
		$lotQty = getLotQty($batchId);
		$lotWidth = getlotWidth($batchId);
		$planStatus = getStatus($batchId);
	
		$ResponseXML .="<PO><![CDATA[" .$styleId."]]></PO>";
		$ResponseXML .="<Machine><![CDATA[" .$Machine."]]></Machine>";
		$ResponseXML .="<COSTID><![CDATA[" .$costId."]]></COSTID>";
		$ResponseXML .="<LotNo><![CDATA[" .$lotNo."]]></LotNo>";
		$ResponseXML .="<LotQty><![CDATA[" .$lotQty."]]></LotQty>";
		$ResponseXML .="<lotWidth><![CDATA[" .$lotWidth."]]></lotWidth>";
		$ResponseXML .="<PlanStatus><![CDATA[" .$planStatus."]]></PlanStatus>";
	}
	$ResponseXML .="</loadDet>";
	echo $ResponseXML;
}
if($req=="loadSearchPO")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$PONo	  = $_GET['poNo'];
	$poStatus = $_GET['poStatus'];
	$color	  = $_GET['color'];
	$ResponseXML .="<searchPO>";
	
	$sql="SELECT DISTINCT
			o.strOrderNo,
			o.intQty,
			ds.dtDateofDelivery,
			SP.intStyleId,
			o.reaExPercentage,
			SR.strColor,
			(select sum(dblPlanedQty) from was_planlotpool 
			where was_planlotpool.intStyleId=o.intStyleId 
			group by was_planlotpool.intStyleId) as planedQty
			FROM
			specification SP
			INNER JOIN orders AS o ON SP.intStyleId = o.intStyleId
			INNER JOIN styleratio AS SR ON SR.intStyleId=SP.intStyleId
			INNER JOIN deliveryschedule AS ds ON ds.intStyleId = o.intStyleId
			WHERE SP.intStyleId IN (select intStyleId from was_actualcostheader) "; 
	if($PONo!="")
		$sql.="and o.strOrderNo like '%$PONo%' ";
	if($poStatus=="1")
		$sql.="and ws.intStyleId IN (select intStyleId from was_planlotpool) ";
	if($poStatus=="0")
		$sql.="and ws.intStyleId NOT IN (select intStyleId from was_planlotpool) ";
	if($poStatus=="2")
		$sql.="and SR.strColor = '$color' ";
	$sql.="order by planedQty ";
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$tot=round(($row['intQty']+($row['intQty']*($row['reaExPercentage']/100) )),0);
		if($tot==$row['planedQty'])
		{
			continue;
		}
		$ResponseXML .="<styleId><![CDATA[" .$row['intStyleId']."]]></styleId>";
		$ResponseXML .="<Qty><![CDATA[" .$row['intQty']."]]></Qty>";
		$ResponseXML .="<TotQty><![CDATA[" .$tot."]]></TotQty>";
		$ResponseXML .="<OrderNo><![CDATA[" .$row['strOrderNo']."]]></OrderNo>";
		$ResponseXML .="<planedQty><![CDATA[" .$row['planedQty']."]]></planedQty>";
		$ResponseXML .="<EXRate><![CDATA[" .$row['reaExPercentage']."]]></EXRate>";
	}
	$ResponseXML .="</searchPO>";
	echo $ResponseXML;
}
if($req=="loadPONO")
{
	$sql = "SELECT DISTINCT
			o.strOrderNo
			FROM
			specification SP
			INNER JOIN orders AS o ON SP.intStyleId = o.intStyleId
			INNER JOIN styleratio AS SR ON SR.intStyleId=SP.intStyleId
			INNER JOIN deliveryschedule AS ds ON ds.intStyleId = o.intStyleId
			WHERE SP.intStyleId IN (select intStyleId from was_actualcostheader)
			order by o.strOrderNo ";
	$result = $db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
			{
				$pr_arr.= $row['strOrderNo']."|";
				 
			}
			echo $pr_arr;
	
}
if($req=="loadColor")
{
	$sql = "SELECT DISTINCT
			SR.strColor
			FROM
			specification SP
			INNER JOIN orders AS o ON SP.intStyleId = o.intStyleId
			INNER JOIN styleratio AS SR ON SR.intStyleId=SP.intStyleId
			INNER JOIN deliveryschedule AS ds ON ds.intStyleId = o.intStyleId
			WHERE SP.intStyleId IN (select intStyleId from was_actualcostheader)
			order by SR.strColor";
	$result = $db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
			{
				$pr_arr.= $row['strColor']."|";
				 
			}
			echo $pr_arr;
	
}

function getPOPoolDets($planNo){
	global $db;
	$planNo=explode('/',$planNo);
	$sql="SELECT
		was_planlotpool.intStyleId,
		was_planlotpool.dblPlanedQty,
		was_planlotpool.dtmDate,
		was_planlotpool.intShiftId,
		orders.intQty,
		orders.strOrderNo,
		orders.reaExPercentage
		FROM
		was_planlotpool
		INNER JOIN orders ON was_planlotpool.intStyleId = orders.intStyleId
		
		where intPlanYear='$planNo[0]' and intPlanNo='$planNo[1]' order by intPlanYear,intPlanNo ASC;";
		return $db->RunQuery($sql);
}

function getBatchId($planNo){
	global $db;
	$sql="SELECT distinct
			WPMAD.intBatchId
			FROM
			was_planmachineallocationheader WPMAH
			INNER JOIN was_planmachineallocationdetail WPMAD ON WPMAD.intBatchId=WPMAH.intBatchId
			WHERE
			concat(WPMAH.intPlanYear,'/',WPMAH.intPlanNo)='$planNo'
			group by WPMAD.intBatchId;";	
	return $db->RunQuery($sql);
}
function getStyleId($batchId)
{
	global $db;
	$boolCheck = false;
	$sql = "select was_planmachineallocationdetail.intStyleId,O.strOrderNo
from was_planmachineallocationdetail 
inner join orders O on O.intStyleId=was_planmachineallocationdetail.intStyleId
where was_planmachineallocationdetail.intBatchId='$batchId'";
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		if(!$boolCheck)
		{
			$styleId = $row["intStyleId"].'|'.$row["strOrderNo"]; 
		}
		else
		{
			$styleId.="~".$row["intStyleId"].'|'.$row["strOrderNo"]; 
		}
		$boolCheck = true;
	}
	return $styleId;
}
function getMachinId($batchId)
{
	global $db;
	$boolCheck = false;
	$sql = "select intMachine from was_planmachineallocationdetail where intBatchId='$batchId'";
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		if(!$boolCheck)
		{
			$MachineId = $row["intMachine"]; 
		}
		else
		{
			$MachineId.="~".$row["intMachine"]; 
		}
		$boolCheck = true;
	}
	return $MachineId;
}
function getCostId($batchId)
{
	global $db;
	$boolCheck = false;
	$sql = "select concat(intCostYear,'/',dblCostNo) as costNo from was_planmachineallocationdetail where intBatchId='$batchId'";
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		if(!$boolCheck)
		{
			$costId = $row["costNo"]; 
		}
		else
		{
			$costId.="~".$row["costNo"]; 
		}
		$boolCheck = true;
	}
	return $costId;
}
function getLotNo($batchId)
{
	global $db;
	$boolCheck = false;
	$sql = "select distinct strLotNo from was_planmachineallocationdetail where intBatchId='$batchId'";
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		if(!$boolCheck)
		{
			$lotNo = $row["strLotNo"]; 
		}
		else
		{
			$lotNo.="~".$row["strLotNo"]; 
		}
		$boolCheck = true;
	}
	return $lotNo;
}
function getLotQty($batchId)
{
	global $db;
	$boolCheck = false;
	$sql = "select concat(intLotQty,'-',was_machine.intMachineType) as lotQty
			from was_planmachineallocationdetail
			inner join was_machine on was_machine.intMachineId=was_planmachineallocationdetail.intMachine
			where intBatchId='$batchId'";
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		if(!$boolCheck)
		{
			$lotQty = $row["lotQty"]; 
		}
		else
		{
			$lotQty.="~".$row["lotQty"]; 
		}
		$boolCheck = true;
	}
	return $lotQty;
}
function getlotWidth($batchId)
{
	$HandleTime = 0;
	$totlotWidth = 0;
	global $db;
	$boolCheck = false;
	$sql = "SELECT
			WPMAD.intBatchId,
			WPMAD.intLotQty,
			was_actualcostheader.dblHTime,
			(select sum(dblTime) from was_actualcostdetails as WAD where WAD.intYear=WPMAD.intCostYear and WAD.intSerialNo=WPMAD.dblCostNo) as totTime,
			was_actualcostheader.dblQty
			FROM
			was_planmachineallocationheader WPMAH
			INNER JOIN was_planmachineallocationdetail WPMAD ON WPMAD.intBatchId=WPMAH.intBatchId
			INNER JOIN was_actualcostheader ON WPMAD.intCostYear = was_actualcostheader.intYear AND WPMAD.dblCostNo = was_actualcostheader.intSerialNo
			WHERE
			WPMAD.intBatchId='$batchId'
			group by WPMAD.intId";
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$lotTime = round((($row["dblHTime"]+$row["totTime"])/$row["dblQty"]),3);
		$HandleTime = $row["intLotQty"] * $lotTime;
		$totlotWidth += $HandleTime;
	}
	return $totlotWidth;
}
function getStatus($batchId)
{
	global $db;
	$sql = "select intStatus from was_planmachineallocationheader where intBatchId='$batchId'";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["intStatus"];
	
}
?>