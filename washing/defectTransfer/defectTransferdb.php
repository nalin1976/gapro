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
if($request=='loadQty')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$orderNo = $_GET['orderNo'];
	$color   = $_GET['color'];
	$ResponseXML = "<XMLloadQty>"; 
	$sqlCom = "SELECT DISTINCT companies.intCompanyID,companies.strName FROM was_stocktransactions AS s 
INNER JOIN companies ON s.intFromFactory = companies.intCompanyID WHERE s.intStyleId='$orderNo' and s.strColor='$color'";
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
		}
		$cName .= "<option value=\"".  trim($rowS['intCompanyID']) ."\">".trim($rowS['strName'])."</option>\n";
	}
	$orderQty = getOrderQty($orderNo);
	$ResponseXML.="<stockQty><![CDATA[" .$stockQty. "]]></stockQty>\n";
	$ResponseXML.="<orderQty><![CDATA[" . $orderQty. "]]></orderQty>\n";
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
	$stockQty    = getStockQty($styleId,$color,$sFac,$factory);
	$ResponseXML.="<stockQty><![CDATA[" .$stockQty. "]]></stockQty>\n";
	$ResponseXML.="</XMLloadQtyChangFac>";
	echo $ResponseXML;
	
}
if($request=="getDefectNo")
{
	$No=0;
	$year = date('Y');
	$ResponseXML = "<defectNo>\n";
	
	$sql  = "select dblDefectNo from syscontrol where intCompanyID='$factory'";
	$result = $db->RunQuery($sql);
	$rowCount = mysql_num_rows($result);
	$row = mysql_fetch_array($result);
	if($rowCount>0)
	{
		$No	= $row["dblDefectNo"];
		$sqlUpdate="UPDATE syscontrol SET dblDefectNo=dblDefectNo+1 WHERE intCompanyID='$factory';";
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
	$defectNo 	= $_GET['defectNo'];
	$defectYear = $_GET['defectYear'];
	$PONo 		= $_GET['PONo'];
	$color 		= $_GET['color'];
	$sewingFac 	= $_GET['sewingFac'];
	$sendQty	= $_GET['sendQty'];
	$Remarks 	= $_GET['Remarks'];
	$DefectQty	= $sendQty*-1;
	
	$sql = "insert into was_stocktransactions 
	( intYear, strMainStoresID, intStyleId, intDocumentNo, intDocumentYear, strColor, strType, dblQty, 
	dtmDate, intUser, intCompanyId, intFromFactory, strCategory)
	values
	( '$defectYear', '1', '$PONo', '$defectNo', '$defectYear', '$color', 'Defect', 
	'$DefectQty', now(), '$userId', '$factory', '$sewingFac', 'In'
	);";
	$res = $db->RunQuery($sql);
	if($res)
	{
		$sqlInsert = "insert into was_stocktransactions_defect 
	( intYear, strMainStoresID, intStyleId, intDocumentNo, intDocumentYear, strColor, strType, 
	dblQty, dtmDate, intUser, intCompanyId, intFromFactory, strCategory, strRemarks)
	values
	( '$defectYear', '1', '$PONo', '$defectNo', '$defectYear', '$color', 'Defect', '$sendQty', 
	now(), '$userId', '$factory', '$sewingFac', 'In', '$Remarks');";
		$resInsert = $db->RunQuery($sqlInsert);
		
		if($resInsert)
			echo "Saved";
		else
			echo "Error";
	}		
}
if($request=="loadDetails")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "<loadDetails>\n";
	$defectNoArry = explode('/',$_GET['defectNo']);
	
	$sql = "select 	intStyleId,strColor, dblQty, dtmDate, intFromFactory, strRemarks
			from was_stocktransactions_defect 
			where intDocumentNo='$defectNoArry[1]' and intDocumentYear='$defectNoArry[0]'";
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<styleId><![CDATA[" .$row['intStyleId']. "]]></styleId>\n";
		$ResponseXML.="<color><![CDATA[" . $row['strColor']. "]]></color>\n";
		$ResponseXML.="<Date><![CDATA[" . $row['dtmDate']. "]]></Date>\n";
		$ResponseXML.="<ToFac><![CDATA[" . $row['intFromFactory']. "]]></ToFac>\n";
		$ResponseXML.="<Remarks><![CDATA[" . $row['strRemarks']. "]]></Remarks>\n";
		$ResponseXML.="<Qty><![CDATA[" . $row['dblQty']. "]]></Qty>\n";
	}
	$ResponseXML .="</loadDetails>";
	echo $ResponseXML;
}

function getStockQty($orderNo,$color,$fCom,$factory)
{
	global $db;
	$sql = "select sum(dblQty) as qty 
			from was_stocktransactions 
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

?>