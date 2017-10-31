<?php
session_start();
include "../Connector.php";
		
$id = $_GET["id"];

if($id=="savePoDtails")
{
$poNo			= $_GET["poNo"];
$year			= $_GET["year"];
$styleId		= $_GET["styleId"];
$matDetailId	= $_GET["matDetailId"];
$color			= $_GET["color"];
$size			= $_GET["size"];
$buyerPo		= $_GET["buyerPo"];
$qty			= $_GET["qty"];

	$SQL = "SELECT dblPending,dblQty FROM purchaseorderdetails PD WHERE PD.intPoNo ='$poNo' AND PD.intYear =  '$year' AND PD.intStyleId ='$styleId' AND PD.intMatDetailID ='$matDetailId' AND PD.strColor ='$color' AND PD.strSize ='$size' AND PD.strBuyerPONO ='$buyerPo';";
	$dblPending=0;
	$dblQty=0;
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$dblPending = $row["dblPending"];
		$dblQty		= $row["dblQty"];
	}
			
	if(($dblQty - $qty)<0)
	{
		echo "Error-$qty";
		die();
	}
		///////////////////////////////////////// save history table
	$SQL = "select intPoNo,intYear,intStyleId,intMatDetailID,strColor,strSize,strBuyerPONO,strRemarks,strUnit, dblUnitPrice,dblQty,dblPending,dblAdditionalQty,dblAdditionalPendingQty,intDeliverToCompId,dtmItemDeliveryDate,intPOType from purchaseorderdetails PD WHERE PD.intPoNo ='$poNo' AND PD.intYear ='$year' AND PD.intStyleId ='$styleId' AND PD.intMatDetailID ='$matDetailId' AND PD.strColor ='$color' AND PD.strSize ='$size' AND PD.strBuyerPONO ='$buyerPo';";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$compId = $row["intDeliverToCompId"];
		$SQL1= "insert into purchaseorderhistory (intPoNo,intYear,intStyleId,intMatDetailID,strColor,strSize,strBuyerPONO,			strRemarks,strUnit,dblUnitPrice,dblQty,dblPending,dblAdditionalQty,intDeliverToCompId,dtmItemDeliveryDate,intPOType,cancelDate,cancelUser)values('".$row["intPoNo"]."','".$row["intYear"]."','".$row["intStyleId"]."','".$row["intMatDetailID"]."','".$row["strColor"]."','".$row["strSize"]."','".$row["strBuyerPONO"]."','".$row["strRemarks"]."','".$row["strUnit"]."','".$row["dblUnitPrice"]."','".$qty."','".$qty."','".$row["dblAdditionalQty"]."','$compId','".substr($row["dtmItemDeliveryDate"],0,10)."','".$row["intPOType"]."',now(),'".$_SESSION["UserID"]."');";
		$result1 = $db->RunQuery($SQL1);
	}
	//UPDATE PURCHASEORDER TABLE
	$SQL = "update purchaseorderdetails 
	set dblPending=dblPending-$qty , dblQty=dblQty-$qty
	WHERE
	purchaseorderdetails.intPoNo =  '$poNo' AND
	purchaseorderdetails.intYear =  '$year' AND
	purchaseorderdetails.intStyleId =  '$styleId' AND
	purchaseorderdetails.intMatDetailID =  '$matDetailId' AND
	purchaseorderdetails.strColor =  '$color' AND
	purchaseorderdetails.strSize =  '$size' AND
	purchaseorderdetails.strBuyerPONO =  '$buyerPo';";
	$result = $db->RunQuery($SQL);
	
	//UPDATE PURCHASEORDER TABLE
	$SQL = "update materialratio  set dblBalQty=dblBalQty + $qty
	WHERE intStyleId = '$styleId' 
	AND strMatDetailID = '$matDetailId' 
	AND strColor = '$color' 
	AND strSize = '$size' 
	AND strBuyerPONO = '$buyerPo';";
	$result = $db->RunQuery($SQL);			
echo $result;
}
?>