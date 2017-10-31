<?php
session_start();
$backwardseperator = "../../";
include "${backwardseperator}authentication.inc";
include('../../Connector.php');
include("class.washingplan.php");
$wrsr=new washingplan();

$req=$_GET['req'];

if($req=="getMacCapacity")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$macId = $_GET['macId'];
	$ResponseXML .="<getMacCapacity>";
	$sql = "SELECT distinct
			was_machine.intCapacity
			FROM
			was_machine
			INNER JOIN was_machinetype ON was_machinetype.intMachineId = was_machine.intMachineType
			WHERE
			was_machinetype.intStatus = '1' and was_machine.intMachineType='$macId'";
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .="<macCapacity><![CDATA[" .$row['intCapacity']."]]></macCapacity>";
	}
	$ResponseXML .="</getMacCapacity>";
	echo $ResponseXML;
	
}
if(strcmp($req,"getStyle")==0){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$po=$_GET['po'];
	$res=$wrsr->getStyle($po);
	$row=mysql_fetch_assoc($res);
	$ResponseXML .="<loadDet>";
	$ResponseXML .="<Style><![CDATA[" .$row['strStyle']."]]></Style>";
	$ResponseXML .="<OQty><![CDATA[" .$row['intQty']."]]></OQty>";
	$ResponseXML .="</loadDet>";
	echo $ResponseXML;
}
if(strcmp($req,"getPo")==0){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
	$ResponseXML .="<loadDet>";
	$style=$_GET['style'];
	$res=$wrsr->getPo($style);
	$row=mysql_fetch_assoc($res);
	$ResponseXML .="<PO><![CDATA[" .$row['intStyleId']."]]></PO>";
	$ResponseXML .="<OQty><![CDATA[" .$row['intQty']."]]></OQty>";
	$ResponseXML .="</loadDet>";
	echo $ResponseXML;
}

if(strcmp($req,'getColor')==0){
	$po=$_GET['po'];
	$res=$wrsr->getColor($po);
	$row=mysql_fetch_assoc($res);
	echo "<option value=\"".$row['strColor']."\">".$row['strColor']."</option>";
}

if(strcmp($req,'getRCVDQty')==0){
	$po=$_GET['po'];
	$color=$_GET['color'];
	$com = $_SESSION['FactoryID'];
	$res=$wrsr->getRCVDQty($po,$color,$com);
	$row=mysql_fetch_assoc($res);
	echo $row['RCVDQty'];
}

if(strcmp($req,'getMachines')==0){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$costID=$_GET['costID'];
	$Machines="<option value=\"\">Select One</option>";
	$res=$wrsr->getMachines($costID);
	while($row=mysql_fetch_assoc($res))
	{
		$Machines.="<option value=\"".$row['intMachineId']."\">".$row['strMachineName']."</option>";
		$machineCat = $row["intMachineType"];
	}
	$ResponseXML .="<loadDet>";
	$ResponseXML .="<Machines><![CDATA[" .$Machines."]]></Machines>\n";
	$ResponseXML .="<MachineCat><![CDATA[" .$machineCat."]]></MachineCat>\n";
	$ResponseXML .="<dblHTime><![CDATA[" .$wrsr->getTotTime($_GET['costID'])."]]></dblHTime>\n";
	$ResponseXML .="<dblQty><![CDATA[" .$wrsr->getQty($_GET['costID'])."]]></dblQty>\n";
	$ResponseXML .="</loadDet>";
	echo $ResponseXML;
}


if(strcmp($req,'getMachineCapacity')==0){
	$mID=$_GET['mID'];
	$res=$wrsr->getMachineCapacity($mID);
	$row=mysql_fetch_assoc($res);
	echo $row['intCapacity'];

}
if(strcmp($req,"getCostingDetails")==0){
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$po=$_GET['po'];
	$res=$wrsr->getCostings($po);
	
	$ResponseXML .="<loadDet>";
	$nOfMcPerCostId=1;
	$gCost='';
	while($row=mysql_fetch_assoc($res)){
		
		if($row['COSTID']==$gCost)
			$nOfMcPerCostId++;
		else
			$nOfMcPerCostId=1;
			
		$ResponseXML .="<costId><![CDATA[" .$row['COSTID']."]]></costId>\n";
		$ResponseXML .="<Machine><![CDATA[" .$row['strMachineName']."]]></Machine>\n";
		$ResponseXML .="<MachineCapacity><![CDATA[" .$row['intCapacity']."]]></MachineCapacity>\n";
		$ResponseXML .="<dblHTime><![CDATA[" .$wrsr->getTotTime($row['COSTID'])."]]></dblHTime>\n";
		$ResponseXML .="<NoOfMc><![CDATA[".$nOfMcPerCostId."]]></NoOfMc>\n";
		
		$gCost=$row['COSTID'];
		
	}
	$ResponseXML .="</loadDet>";
	echo $ResponseXML;
}

if(strcmp($req,"getCostIds")==0){
	$po=$_GET['po'];
	$res=$wrsr->getCostIDs($po);
	$gCost="<option value=\"\">Select One</option>";
	while($row=mysql_fetch_assoc($res)){
		$gCost.="<option value=\"".$row['costIdValue']."\">".$row['COSTID']."</option>";
	}
	echo $gCost;
}

if(strcmp($req,"getWMachineCapacity")==0){
	$costId=$_GET['costId'];
	$res=$wrsr->getWMachineCapacity($costId);
    $row=mysql_fetch_assoc($res);
		echo $row['intCapacity'];
}
?>