<?php
session_start();
include "../Connector.php";
ob_start();
header('Content-Type: text/xml'); 

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$userID=$_SESSION["UserID"];
$RequestType = $_GET["RequestType"];

if (strcmp($RequestType,"getMaterial") == 0)
{
	ob_get_clean();
	
	$styleID = $_GET["styleID"];
	$sql = "SELECT DISTINCT matmaincategory.strDescription, matmaincategory.intID FROM purchaseorderdetails INNER JOIN matitemlist ON purchaseorderdetails.intMatDetailID  = matitemlist.intItemSerial INNER JOIN matmaincategory ON  matitemlist.intMainCatID= matmaincategory.intID  ";
	
	if ($styleID)
	{
		$sql = $sql."WHERE purchaseorderdetails.intStyleId = '$styleID' ";
	} 
	$sql = $sql." ORDER BY matmaincategory.strDescription";
	
	$result = $db->RunQuery($sql);
	echo "<option value=\"\"></option>";
	while ($row = mysql_fetch_array($result))
	{
		echo "<option value=\"" . $row["intID"]  . "\">" . $row["strDescription"]  . "</option>";
	}
}
else if (strcmp($RequestType,"getCategory") == 0)
{
	ob_get_clean();
	
	$styleID = $_GET["styleID"];
	$materialNo =$_GET["materialNo"];
	$sql = "SELECT DISTINCT matsubcategory.StrCatName,  matsubcategory.intSubCatNo
			FROM bulkpurchaseorderdetails 
			INNER JOIN matitemlist ON bulkpurchaseorderdetails.intMatDetailId  = matitemlist.intItemSerial 
			INNER JOIN matsubcategory ON  matitemlist.intSubCatID= matsubcategory.intSubCatNo  WHERE matitemlist.intItemSerial<>0 ";
	
	/*if ($styleID)
	{
		$sql = $sql." and purchaseorderdetails.intStyleId = '$styleID' ";
	}*/ 
	
	if ($materialNo!="")
	{
		$sql = $sql." and matitemlist.intMainCatID=$materialNo";
	}
	
	$sql = $sql." ORDER BY matsubcategory.StrCatName";
	
	//echo $sql;
	$result = $db->RunQuery($sql);
	echo "<option value=\"\"></option>";
	while ($row = mysql_fetch_array($result))
	{
		echo "<option value=\"" . $row["intSubCatNo"]  . "\">" . $row["StrCatName"]  . "</option>";
	}
}
else if (strcmp($RequestType,"getItemDetails") == 0)
{
	$materialNo =$_GET["materialNo"];
	$categoryNo=$_GET["categoryNo"]; 
	
	$sql = "SELECT distinct MIL.intItemSerial, MIL.strItemDescription FROM bulkpurchaseorderdetails PD INNER JOIN matitemlist MIL ON PD.intMatDetailID  = MIL.intItemSerial  WHERE MIL.intItemSerial<>0 ";
	
	if ($materialNo!="")
	{
		$sql = $sql." and MIL.intMainCatID=$materialNo ";
	}

	if ($categoryNo!="")
	{
		$sql = $sql." and MIL.intSubCatID=$categoryNo ";
	}
	$sql = $sql." ORDER BY MIL.strItemDescription ";
	
	$result = $db->RunQuery($sql);
	echo "<option value=\"\"></option>";
	while ($row = mysql_fetch_array($result))
	{
		echo "<option value=\"" . $row["intItemSerial"]  . "\">" . $row["strItemDescription"]  . "</option>";
	}	
}

else if (strcmp($RequestType,"CompleteOpenPO") == 0)
{

	$styleID = $_GET["StyleId"];
	$intYear =$_GET["intYear"];
	$intPO=$_GET["intPO"]; 
	
	$res = getOpenPOdetails($styleID,$intYear,$intPO);
	//echo $res; 
	while($row=mysql_fetch_array($res))
	{
		$MatId = $row["intMatDetailID"];
		$BuyerPo = $row["strBuyerPONO"];
		$strColor = $row["strColor"];
		$strSize = $row["strSize"];
		$intPOType =  $row["intPOType"];
		$PendingQty = $row["dblPending"];
		$OrderQty = $row["dblQty"];
		$MatNameList = '';
		//echo $MatId;
		if($PendingQty<$OrderQty && $PendingQty>0)
		{
			UpdatePOPendingQty($styleID,$intYear,$intPO,$MatId,$BuyerPo,$strColor,$strSize,$intPOType,$PendingQty);
		}
		else
		{
			$MatName = getMatName($MatId);
			$MatNameList .= $MatName.'/';
			//echo $MatName;
		}
		
	}
	$ResponseXML .= "<OpenPO>";
	if($MatNameList == '')
	{
		$Status = 1;
		$ResponseXML .= "<POstatus><![CDATA[" . $Status . "]]></POstatus>\n";	
	}
	else
	{
		$Status = 2;
		$ResponseXML .= "<POstatus><![CDATA[" . $Status . "]]></POstatus>\n";	
		$ResponseXML .= "<UncompletePOItems><![CDATA[" . $MatNameList . "]]></UncompletePOItems>\n";
	}
	$ResponseXML .= "</OpenPO>";
			//echo $SQL;
			echo $ResponseXML;
}
else if($RequestType=="GetStyleWiseOrderNoInReports")
{
$status = $_GET["status"];
$styleNo = $_GET["styleNo"];
$booUser = $_GET["booUser"];

$ResponseXML.="<XMLGetOrderWiseCopyData>\n";
	$sql= "select specification.intStyleId,orders.strOrderNo from specification INNER JOIN orders on specification.intStyleId = orders.intStyleId where specification.intOrdComplete =0 ";
	
	if($styleNo!="")
		$sql .=" and orders.strStyle='".$styleNo ."'";
	
	$sql .= " order by strOrderNo";
	//echo $sql;
	$result=$db->RunQuery($sql);
		$ResponseXML .= "<option value="."".">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=".$row["intStyleId"].">".$row["strOrderNo"]."</option>";
	}
	
$ResponseXML.= "</XMLGetOrderWiseCopyData>";
echo $ResponseXML;
}
else if($RequestType=="GetStyleWiseScNoInReports")
{
$status = $_GET["status"];
$styleNo = $_GET["styleNo"];
$booUser = $_GET["booUser"];

$ResponseXML.="<XMLGetOrderWiseCopyData>\n";
	$sql= "select intSRNO,orders.intStyleId from specification INNER JOIN orders on specification.intStyleId = orders.intStyleId where intOrdComplete =0 ";
	
	if($styleNo!="")
		$sql .= " and orders.strStyle='".$styleNo ."'";

		$sql .= " order by intSRNO DESC";
	
	$result=$db->RunQuery($sql);
		$ResponseXML .= "<option value="."".">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=".$row["intStyleId"].">".$row["intSRNO"]."</option>";
	}
	
$ResponseXML.= "</XMLGetOrderWiseCopyData>";
echo $ResponseXML;
}

function getOpenPOdetails($styleID,$intYear,$intPO)
{
	$SQL = " SELECT * FROM purchaseorderdetails
		WHERE intPoNo='$intPO' AND intYear='$intYear' AND intStyleId='$styleID' AND dblPending<>0";
		
		global $db;
		
		
		return  $db->RunQuery($SQL);
}

function UpdatePOPendingQty($styleID,$intYear,$intPO,$MatId,$BuyerPo,$strColor,$strSize,$intPOType,$PendingQty)
{
	$SQL = " update purchaseorderdetails 
			set
			dblPending = '0' , 
			dblCompletedQty = '$PendingQty'
			where
			intPoNo = '$intPO' and intYear = '$intYear' and intStyleId = '$styleID' and intMatDetailID = '$MatId' and strColor = '$strColor' and strSize = '$strSize' and strBuyerPONO = '$BuyerPo' and intPOType = '$intPOType' ";
			global $db;
			$db->ExecuteQuery($SQL);
}

function  getMatName($MatId)
{
	$SQL = "select * from matitemlist
where intItemSerial = '$MatId'";
global $db;
	$result = $db->RunQuery($SQL);
	
	while($row=mysql_fetch_array($result))
	{
		$ItemName = $row["strItemDescription"];
	}
	
	return $ItemName;
}
?>