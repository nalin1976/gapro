<?php
session_start();
include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType = $_GET["RequestType"];

if($RequestType=="GetStyleWiseOrderNoInReports")
{
$status = $_GET["status"];
$styleNo = $_GET["styleNo"];
$booUser = $_GET["booUser"];

$ResponseXML.="<XMLGetOrderWiseCopyData>\n";
	$sql= "select O.intStyleId,O.strOrderNo from orders O where intStatus in ($status)";
	if($styleNo!="")
		$sql .=" and o.strStyle='".$styleNo ."'";
	
	if($booUser=='true')
		$sql .=" and o.intUserID=" . $_SESSION["UserID"] . " ";
		
		$sql .=" order by O.strOrderNo";
	$result=$db->RunQuery($sql);
		$ResponseXML .= "<option value="."".">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=".$row["intStyleId"].">".$row["strOrderNo"]."</option>";
	}
	
$ResponseXML.= "</XMLGetOrderWiseCopyData>";
echo $ResponseXML;
}
elseif($RequestType=="GetStyleWiseScNoInReports")
{
$status = $_GET["status"];
$styleNo = $_GET["styleNo"];
$booUser = $_GET["booUser"];

$ResponseXML.="<XMLGetOrderWiseCopyData>\n";
	$sql= "select S.intStyleId,S.intSRNO from specification S inner join orders O on S.intStyleId = O.intStyleId AND O.intStatus in ($status)";
	if($styleNo!="")
		$sql .= " and o.strStyle='".$styleNo ."'";
	
	if($booUser=='true')
		$sql .= " and o.intUserID=" . $_SESSION["UserID"] . " ";
		
		$sql .= " order by S.intSRNO desc";
	$result=$db->RunQuery($sql);
		$ResponseXML .= "<option value="."".">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=".$row["intStyleId"].">".$row["intSRNO"]."</option>";
	}
	
$ResponseXML.= "</XMLGetOrderWiseCopyData>";
echo $ResponseXML;
}
elseif($RequestType=="GetScWiceStylenoinReports")
{
$status = $_GET["status"];
$styleNo = $_GET["styleNo"];
$booUser = $_GET["booUser"];

$ResponseXML.="<XMLGetScWiseCopyData>\n";
	$sql= "select S.intStyleId,S.intSRNO,O.strStyle from specification S inner join orders O on S.intStyleId = O.intStyleId AND O.intStatus in ($status)";
	if($styleNo!="")
		$sql .= " and S.intStyleId='".$styleNo ."'";
	
	if($booUser=='true')
		$sql .= " and o.intUserID=" . $_SESSION["UserID"] . " ";
		
		$sql .= " order by S.intSRNO desc";
		
	$result=$db->RunQuery($sql);
	//echo $sql;
		//$ResponseXML .= "<option value="."".">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		//$ResponseXML .= "<option value=".$row["strStyle"].">".$row["strStyle"]."</option>";
                $ResponseXML .= "<option value=".$row["intStyleId"].">".$row["strStyle"]."</option>";
	}
	
$ResponseXML.= "</XMLGetScWiseCopyData>";
echo $ResponseXML;
}
elseif($RequestType=="URLStyleWiseOrderNoInReports_Variation")
{
$styleNo = $_GET["styleNo"];

$ResponseXML.="<XMLGetOrderWiseCopyData>\n";
	$sql = "select O.intStyleId,O.strOrderNo 
			from orders O 
			inner join history_invoicecostingheader HICH on HICH.intStyleId=O.intStyleId ";
	
	if($styleNo!="")
		$sql .= " and O.strStyle='$styleNo' ";
		
		$sql .= " order by O.strOrderNo";
	$result=$db->RunQuery($sql);
		$ResponseXML .= "<option value="."".">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=".$row["intStyleId"].">".$row["strOrderNo"]."</option>";
	}
	
$ResponseXML.= "</XMLGetOrderWiseCopyData>";
echo $ResponseXML;
}
elseif($RequestType=="URLStyleWiseScNoInReports_Variation")
{
$styleNo = $_GET["styleNo"];

$ResponseXML.="<XMLGetOrderWiseCopyData>\n";
	$sql = "select S.intStyleId,S.intSRNO 
			from specification S 
			inner join orders O on S.intStyleId = O.intStyleId
			inner join history_invoicecostingheader HICH on HICH.intStyleId=O.intStyleId
			where O.intStatus = 11 ";
	
	if($styleNo!="")
		$sql .= " and O.strStyle='$styleNo' ";
		
	$sql .= "order by S.intSRNO desc";
	$result=$db->RunQuery($sql);
		$ResponseXML .= "<option value="."".">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=".$row["intStyleId"].">".$row["intSRNO"]."</option>";
	}
	
$ResponseXML.= "</XMLGetOrderWiseCopyData>";
echo $ResponseXML;
}
?>