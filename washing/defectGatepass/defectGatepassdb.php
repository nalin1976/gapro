<?php
session_start();
require_once('../../Connector.php');
include('../washingCommonScript.php');
header('Content-Type: text/xml'); 

$request = $_GET['request'];
$factory = $_SESSION['FactoryID'];
$userId	 = $_SESSION["UserID"];

if($request=='loadColor')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";	
	
	$orderNo = $_GET['orderNo'];
	$ResponseXML = "<XMLloadColor>"; 
	$sql = "select distinct strColor from was_stocktransactions where intStyleId='$orderNo' order by strColor;";
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<Color><![CDATA[<option value=\"".$row["strColor"]."\">".$row["strColor"]."</option>]]></Color>\n";

	}
	$ResponseXML .= "</XMLloadColor>"; 
	echo $ResponseXML;
	
}
if($request=="loadQty")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$orderNo = $_GET['orderNo'];
	$color   = $_GET['color'];
	$ResponseXML = "<XMLloadQty>"; 
	$sqlCom = "SELECT DISTINCT companies.intCompanyID,companies.strName FROM was_stocktransactions_defect AS wsd 
				INNER JOIN companies ON wsd.intFromFactory = companies.intCompanyID WHERE wsd.intStyleId='$orderNo' 
				and wsd.strColor='$color'";
	$fCom = '';
	$resCom = $db->RunQuery($sqlCom);
	$Nr = mysql_num_rows($resCom);
	
	if($Nr>1)
	{
		$cName .= "<option value=\"\"></option>\n";
		$stockQty = 0;
	}
	
	while($rowS=mysql_fetch_array($resCom))
	{
		if($Nr==1)
		{
			$fCom = $rowS['intCompanyID'];
			$stockQty = getStockQty($orderNo,$color,$fCom,$factory);
			$checkQty = getGatePassQty($orderNo,$color,$fCom);
			if($checkQty==false)
				$gpQty    = 0;
			else
				$gpQty    = $checkQty;
			
		}
		$cName .= "<option value=\"".  trim($rowS['intCompanyID']) ."\">".trim($rowS['strName'])."</option>\n";
	}
	$orderQty = getOrderQty($orderNo);
	$ResponseXML.="<stockQty><![CDATA[" .$stockQty. "]]></stockQty>\n";
	$ResponseXML.="<orderQty><![CDATA[" . $orderQty. "]]></orderQty>\n";
	$ResponseXML.="<gatepassQty><![CDATA[" . $gpQty. "]]></gatepassQty>\n";
	$ResponseXML.="<cName><![CDATA[" . trim($cName)  . "]]></cName>\n";
	$ResponseXML.="<Nr><![CDATA[" . trim($Nr)  . "]]></Nr>";
	$ResponseXML.="</XMLloadQty>";
	echo $ResponseXML;
}
if($request=="LoadQtyWhenChangeSewFactory")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$styleId = $_GET['styleId'];
	$color   = $_GET['color'];
	$sFac    = $_GET['sFac'];
	$ResponseXML = "<XMLloadQtyChangFac>"; 
	$gpQty    = getGatePassQty($styleId,$color,$sFac);
	$ResponseXML.="<gatePassQty><![CDATA[" .$gpQty. "]]></gatePassQty>\n";
	$ResponseXML.="</XMLloadQtyChangFac>";
	echo $ResponseXML;
}
if($request=="getDefectGatepassNo")
{
	$No=0;
	$year = date('Y');
	$ResponseXML = "<defectNo>\n";
	
	$sql  = "select dblDefectGatePassNo from syscontrol where intCompanyID='$factory'";
	$result = $db->RunQuery($sql);
	$rowCount = mysql_num_rows($result);
	$row = mysql_fetch_array($result);
	if($rowCount>0)
	{
		$No	= $row["dblDefectGatePassNo"];
		$sqlUpdate="UPDATE syscontrol SET dblDefectGatePassNo=dblDefectGatePassNo+1 WHERE intCompanyID='$factory';";
		$db->executeQuery($sqlUpdate);			
		$ResponseXML .= "<Admin><![CDATA[TRUE]]></Admin>\n";		
		$ResponseXML .= "<No><![CDATA[".$No."]]></No>\n";
		$ResponseXML .= "<Year><![CDATA[".$year."]]></Year>\n";
	}
	else
	{
		$ResponseXML .= "<Admin><![CDATA[FALSE]]></Admin>\n";
	}
	$ResponseXML .="</defectNo>";
	echo $ResponseXML;
}
if($request=="saveData")
{
	$defectGPNo 	= $_GET['defectGPNo'];
	$defectGPYear 	= $_GET['defectGPYear'];
	$PONo 			= $_GET['PONo'];
	$color 			= $_GET['color'];
	$vehicleNo 		= $_GET['vehicleNo'];
	$sewingFac 		= $_GET['sewingFac'];
	$sendQty		= $_GET['sendQty'];
	$toFactory 		= $_GET['toFactory'];
	$Remarks 		= $_GET['Remarks'];
	$DefectGPQty	= $sendQty*-1;
	
	$sql = "insert into was_defectgatepass 
	(intDefectGPNo, intDefectGPYear, intStyleId, strColour, strVehicleNo, intFromFactory, intSewingFactory, 
	dblGatePassQty, strToFactory, strRemarks, intUserId, dtmDate)
	values
	('$defectGPNo', '$defectGPYear', '$PONo', '$color', '$vehicleNo', '$factory', 
	'$sewingFac', '$sendQty', '$toFactory', '$Remarks', '$userId', now());";
	$res = $db->RunQuery($sql);
	if($res)
	{
		$sql_insert = "insert into was_stocktransactions_defect 
	(intYear, strMainStoresID, intStyleId, intDocumentNo, intDocumentYear, strColor, 
	strType, dblQty, dtmDate, intUser, intCompanyId, intFromFactory, strCategory)
	values
	('$defectGPYear', '1', '$PONo', '$defectGPNo', '$defectGPYear', '$color', 
	'DefectGP', '$DefectGPQty', now(), '$userId', '$factory', '$sewingFac', 'In');";
		$res_Insert = $db->RunQuery($sql_insert);
		
		if($res_Insert)
			echo "Saved";
		else
			echo "Error";
	}
}
function getStockQty($orderNo,$color,$fCom,$factory)
{
	global $db;
	$sql = "select sum(dblQty) as qty 
			from was_stocktransactions_defect 
			where intStyleId = '$orderNo' and
			intCompanyId = '$factory' and
			intFromFactory = '$fCom' and
			strColor = '$color'
			group by intStyleId,intCompanyId,intFromFactory,strColor";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['qty'];
}
function getOrderQty($orderNo)
{
	global $db;
	$sql = "select intQty from orders where intStyleId='$orderNo'";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['intQty'];
}
function getGatePassQty($orderNo,$color,$fCom)
{
	global $db;
	$sql = "select sum(dblGatePassQty) as gpqty 
			from was_defectgatepass
			where intStyleId = '$orderNo' and
			intSewingFactory = '$fCom' and
			strColour = '$color'
			group by intStyleId,intSewingFactory,strColour ";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	if($res)
		return $row['gpqty'];
	else
		return false;
}
?>