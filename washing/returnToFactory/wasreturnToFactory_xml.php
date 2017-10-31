<?php
session_start();
include "../../Connector.php";
include('../washingCommonScript.php');
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType 		= $_GET["req"];
$intCompanyId		= $_SESSION["FactoryID"];
$userId				= $_SESSION["UserID"];
//------------Load Po No And Style No------------------------------------------------
if(strcmp($RequestType,"getDet")== 0){
	$gpNo=$_GET['gpNo'];
	$gpYear=$_GET['gpYear'];
		
	$ResponseXML.= "<GetDet>";
	$res1=getToComany($gpNo,$gpYear);
	$row1=mysql_fetch_array($res1);
	$ResponseXML.="<ToFac><![CDATA[" . $row1['strFComCode'] . "]]></ToFac>";	
	$ResponseXML.="<StyleId><![CDATA[" . $row1['intStyleId'] . "]]></StyleId>";	
	$ResponseXML.="<OrderNo><![CDATA[" . $row1['strOrderNo'] . "]]></OrderNo>";		
	$ResponseXML.="<Style><![CDATA[" . $row1['strStyle'] . "]]></Style>";	
	$ResponseXML.="<OrderQty><![CDATA[" . getOrderQty($row1['intStyleId']) . "]]></OrderQty>";
	/*$res2=getTransinNos($gpNo,$gpYear);
	while($row2=mysql_fetch_array($res2)){
		$ResponseXML.="<TransInNo><![CDATA[" . $row2['dblTransInNo'] . "]]></TransInNo>";	
		$ResponseXML.="<TransInYear><![CDATA[" . $row2['intGPTYear'] . "]]></TransInYear>";	
	}*/
	
	$res2=getCutNos($gpNo,$gpYear,$color,$po);
	while($row2=mysql_fetch_array($res2)){
		$ResponseXML.="<CutNo><![CDATA[" . $row2['strCutNo'] . "]]></CutNo>";	
	}
	$res3=getShades($gpNo,$gpYear,$color,$po);
	while($row3=mysql_fetch_array($res3)){
		$ResponseXML.="<sCutNo><![CDATA[" . $row3['strCutNo'] . "]]></sCutNo>";	
		$ResponseXML.="<Shade><![CDATA[" . $row3['strShade'] . "]]></Shade>";	
	}
	$ResponseXML.= "</GetDet>";
	 echo $ResponseXML;	
}
else if(strcmp($RequestType,"getColor") == 0)
{

	$ResponseXML= "<GetColor>";
	$pono = $_GET["pono"];

	$sql = "SELECT DISTINCT
productionfinishedgoodsreceivedetails.strColor
FROM
productionfinishedgoodsreceivedetails
Inner Join productionfinishedgoodsreceiveheader ON productionfinishedgoodsreceivedetails.dblTransInNo = productionfinishedgoodsreceiveheader.dblTransInNo AND productionfinishedgoodsreceivedetails.intGPTYear = productionfinishedgoodsreceiveheader.intGPTYear
WHERE
productionfinishedgoodsreceiveheader.intStyleNo =  '$pono'
ORDER BY
productionfinishedgoodsreceivedetails.strColor ASC
";
	$res=$db->RunQuery($sql);
	while($row=mysql_fetch_array($res)){
		$ResponseXML.="<color><![CDATA[" . $row["strColor"]  . "]]></color>";
		$ResponseXML.="<OrderQty><![CDATA[" . getOrderQty($pono) . "]]></OrderQty>";
	}
	$ResponseXML.= "</GetColor>";
	 echo $ResponseXML;	
}
else if(strcmp($RequestType,"loadDets") == 0){
	$pono 	= $_GET["pono"];
	$color	= $_GET["color"];
	$gpNo	= $_GET['gpNo'];
	$gpYear	= $_GET['gpYear'];
	
	$transInNo	= $_GET['transInNo'];
	$transInYear	= $_GET['transInYear'];
	
	$ResponseXML= "<GetDet>";
	$sql="SELECT
			productionfinishedgoodsreceivedetails.strColor,
			productionfinishedgoodsreceivedetails.strCutNo,
			productionfinishedgoodsreceivedetails.strSize,
			sum(productionfinishedgoodsreceivedetails.lngRecQty) as bal,
			productionfinishedgoodsreceivedetails.strShade,
			productionfinishedgoodsreceivedetails.dblBundleNo,
			productionfinishedgoodsreceivedetails.intCutBundleSerial,
			productionfinishedgoodsreceivedetails.strRemarks,
			productionfinishedgoodsreceivedetails.dblTransInNo,
			productionfinishedgoodsreceivedetails.intGPTYear,
			productionbundledetails.strNoRange
			FROM
			productionfinishedgoodsreceiveheader
			Inner Join productionfinishedgoodsreceivedetails ON productionfinishedgoodsreceiveheader.dblTransInNo = productionfinishedgoodsreceivedetails.dblTransInNo AND productionfinishedgoodsreceivedetails.intGPTYear = productionfinishedgoodsreceiveheader.intGPTYear
			Inner Join productionbundledetails ON productionfinishedgoodsreceivedetails.intCutBundleSerial = productionbundledetails.intCutBundleSerial AND productionfinishedgoodsreceivedetails.dblBundleNo = productionbundledetails.dblBundleNo
			WHERE
			productionfinishedgoodsreceiveheader.intStyleNo =  '$pono' AND
			productionfinishedgoodsreceivedetails.strColor =  '$color' ";
			if($transInNo!=""){
		$sql.=" AND productionfinishedgoodsreceivedetails.dblTransInNo='$transInNo' AND productionfinishedgoodsreceivedetails.intGPTYear='$transInYear'";	
			}
		$sql.= "AND
			productionfinishedgoodsreceiveheader.dblGatePassNo =  '$gpNo' AND
			productionfinishedgoodsreceiveheader.intGPYear =  '$gpYear'
			GROUP BY
			productionfinishedgoodsreceivedetails.dblBundleNo,
			productionfinishedgoodsreceivedetails.intCutBundleSerial
			ORDER BY productionfinishedgoodsreceivedetails.dblBundleNo ASC;";
			
//echo $sql;
			$res=$db->RunQuery($sql);
	while($row=mysql_fetch_array($res)){
		$ResponseXML.="<cutno><![CDATA[" . $row["strCutNo"]  . "]]></cutno>";
		$ResponseXML.="<size><![CDATA[" . $row["strSize"]  . "]]></size>";
		$ResponseXML.="<BundleNo><![CDATA[" . $row["dblBundleNo"]  . "]]></BundleNo>";
		$ResponseXML.="<CutBundleSerial><![CDATA[" . $row["intCutBundleSerial"]  . "]]></CutBundleSerial>";
		$ResponseXML.="<bal><![CDATA[" . $row["bal"]  . "]]></bal>";
		$ResponseXML.="<Shade><![CDATA[" . $row["strShade"]  . "]]></Shade>";
		$ResponseXML.="<range><![CDATA[" . $row["strNoRange"]  . "]]></range>";
		$ResponseXML.="<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>";
		$ResponseXML.="<TransNo><![CDATA[" . $row["dblTransInNo"]  . "]]></TransNo>";
		$ResponseXML.="<TransYear><![CDATA[" . $row["intGPTYear"]  . "]]></TransYear>";
	}
	
	$ResponseXML.= "</GetDet>";
	 echo $ResponseXML;	
}

function getOrderQty($pono){
	global $db;
	$sql="SELECT orders.intQty FROM orders WHERE orders.intStyleId =  '$pono';";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['intQty'];
}

function getTransinNos($gpNo,$gpYear){
	global $db;
	$sql="SELECT productionfinishedgoodsreceiveheader.dblTransInNo,productionfinishedgoodsreceiveheader.intGPTYear
			FROM productionfinishedgoodsreceiveheader
			WHERE
			productionfinishedgoodsreceiveheader.dblGatePassNo =  '$gpNo' AND
			productionfinishedgoodsreceiveheader.intGPYear =  '$gpYear';";
	//echo $sql;		
	return $db->RunQuery($sql);
	
}

function getToComany($gpNo,$gpYear){
	global $db;
	$sql="SELECT
			productionfinishedgoodsreceiveheader.strFComCode,
			orders.strStyle,
			orders.intStyleId,
			orders.strOrderNo,
			orders.intQty
			FROM
			productionfinishedgoodsreceiveheader
			Inner Join orders ON orders.intStyleId = productionfinishedgoodsreceiveheader.intStyleNo
			WHERE
			productionfinishedgoodsreceiveheader.dblGatePassNo =  '$gpNo' AND
			productionfinishedgoodsreceiveheader.intGPYear =  '$gpYear';";
		//echo $sql;
		return $res=$db->RunQuery($sql);
}

//get getCutNos//
function getCutNos($gpNo,$gpYear,$color,$po){
	global $db;
	$sql="SELECT
			productionfinishedgoodsreceivedetails.strCutNo
			FROM
			productionfinishedgoodsreceiveheader
			Inner Join productionfinishedgoodsreceivedetails ON productionfinishedgoodsreceiveheader.dblTransInNo = productionfinishedgoodsreceivedetails.dblTransInNo AND productionfinishedgoodsreceivedetails.intGPTYear = productionfinishedgoodsreceiveheader.intGPTYear
			Inner Join productionbundledetails ON productionfinishedgoodsreceivedetails.intCutBundleSerial = productionbundledetails.intCutBundleSerial AND productionfinishedgoodsreceivedetails.dblBundleNo = productionbundledetails.dblBundleNo
			WHERE
			/*productionfinishedgoodsreceiveheader.intStyleNo =  '$po' AND
			productionfinishedgoodsreceivedetails.strColor =  '$color' AND*/
			productionfinishedgoodsreceiveheader.dblGatePassNo =  '$gpNo' AND
			productionfinishedgoodsreceiveheader.intGPYear =  '$gpYear'
			GROUP BY
			productionfinishedgoodsreceivedetails.strCutNo
			ORDER BY productionfinishedgoodsreceivedetails.strCutNo ASC;";
			
	return $res=$db->RunQuery($sql);
}

function getShades($gpNo,$gpYear,$color,$po){
	global $db;
	$sql="	SELECT
			productionfinishedgoodsreceivedetails.strShade,
			productionfinishedgoodsreceivedetails.strCutNo
			FROM
			productionfinishedgoodsreceiveheader
			Inner Join productionfinishedgoodsreceivedetails ON productionfinishedgoodsreceiveheader.dblTransInNo = productionfinishedgoodsreceivedetails.dblTransInNo AND productionfinishedgoodsreceivedetails.intGPTYear = productionfinishedgoodsreceiveheader.intGPTYear
			Inner Join productionbundledetails ON productionfinishedgoodsreceivedetails.intCutBundleSerial = productionbundledetails.intCutBundleSerial AND productionfinishedgoodsreceivedetails.dblBundleNo = productionbundledetails.dblBundleNo
			WHERE
			/*productionfinishedgoodsreceiveheader.intStyleNo =  '$po' AND
			productionfinishedgoodsreceivedetails.strColor =  '$color' AND*/
			productionfinishedgoodsreceiveheader.dblGatePassNo =  '$gpNo' AND
			productionfinishedgoodsreceiveheader.intGPYear =  '$gpYear'
			GROUP BY
			productionfinishedgoodsreceivedetails.strShade
			ORDER BY
			productionfinishedgoodsreceivedetails.strShade ASC;";
			//echo $sql;
			return $res=$db->RunQuery($sql);
}
?>