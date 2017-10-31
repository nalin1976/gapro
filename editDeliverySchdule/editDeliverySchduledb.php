<?php
include "../Connector.php";
$id=$_GET["id"];
$userId		= $_SESSION["UserID"];
if ($id=="load_ord_str")
{
	$sql=" select o.strOrderNo from orders o  order by o.strOrderNo ";
		
			$results=$db->RunQuery($sql);
			//$po_arr = "|";
			while($row=mysql_fetch_array($results))
			{
				$po_arr.= $row['strOrderNo']."|";
				 
			}
			echo $po_arr;
}
if ($id=="load_style_str")
{
	$sql="SELECT strStyle FROM  orders O ORDER BY strStyle";
		
			$results=$db->RunQuery($sql);
			//$po_arr = "|";
			while($row=mysql_fetch_array($results))
			{
				$po_arr.= $row['strStyle']."|";
				 
			}
			echo $po_arr;
}
if ($id=="load_styleId")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "<Result>\n";
	
	$orderNo = $_GET["orderNo"];
	$styleId = $_GET["styleId"];
	
	$sql = "select o.intStyleId,strStyle, intQty,reaExPercentage,(select intSRNO from specification s where s.intStyleId = o.intStyleId) as SCNo,o.strOrderNo from orders o ";
	if($orderNo != '')
		$sql .= "  where o.strOrderNo='$orderNo' ";
	if($styleId != '')
		$sql .= "  where o.intStyleId='$styleId' ";	
	//echo $sql;
	$results=$db->RunQuery($sql);
	$row = mysql_fetch_array($results);
	
	$ResponseXML .= "<styleID><![CDATA[" . $row["intStyleId"]  . "]]></styleID>\n";
	$ResponseXML .= "<orderQty><![CDATA[" . $row["intQty"]  . "]]></orderQty>\n";
	$ResponseXML .= "<exPct><![CDATA[" . $row["reaExPercentage"]  . "]]></exPct>\n";
	$ResponseXML .= "<strStyle><![CDATA[" . $row["strStyle"]  . "]]></strStyle>\n";
	$ResponseXML .= "<SCNo><![CDATA[" . $row["SCNo"]  . "]]></SCNo>\n";
	$ResponseXML .= "<orderNo><![CDATA[" . $row["strOrderNo"]  . "]]></orderNo>\n";
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

if ($id=="load_DeliveryData")
{
	$styleId = $_GET["styleId"];
	$ResponseXML="";
	$result=getDeliveryShedule($styleId);
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML.="<Delivery>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<DateofDelivery><![CDATA[" .$row["dtDateofDelivery"]. "]]></DateofDelivery>\n";
		$ResponseXML.="<Qty><![CDATA[" .$row["dblQty"]. "]]></Qty>\n";
		$ResponseXML.="<Remarks><![CDATA[" .$row["strRemarks"]. "]]></Remarks>\n";
		$ResponseXML.="<ShippingModeID><![CDATA[" .$row["strShippingMode"]. "]]></ShippingModeID>\n";
		$ResponseXML.="<ShippingMode><![CDATA[" .getShippingModeByID($row["strShippingMode"]). "]]></ShippingMode>\n";		
		$ResponseXML.="<ExQty><![CDATA[" .$row["dbExQty"]. "]]></ExQty>\n";
		$ResponseXML.="<isBase><![CDATA[" .$row["isDeliveryBase"]. "]]></isBase>\n";
		$ResponseXML.="<LeadTimeID><![CDATA[" .$row["intSerialNO"]. "]]></LeadTimeID>\n";
		$ResponseXML.="<LeadTime><![CDATA[" .$row["reaLeadTime"]. "]]></LeadTime>\n";
		$ResponseXML.="<EstimatedDate><![CDATA[" .$row["estimatedDate"]. "]]></EstimatedDate>\n";
		$ResponseXML.="<intApprovalNo><![CDATA[" .$row["intApprovalNo"]. "]]></intApprovalNo>\n";
		$ResponseXML.="<intDeliveryId><![CDATA[" .$row["intDeliveryId"]. "]]></intDeliveryId>\n";
	}
	$ResponseXML.="</Delivery>";
	echo $ResponseXML;
}
if ($id=="updateDeliveryData")
{
	$delScheduleId = $_GET["delScheduleId"];
	$deliveryDate = $_GET["deliveryDate"];
	$DelQty = $_GET["DelQty"];
	$ExDelQty = $_GET["ExDelQty"];
	$ShippingMode = $_GET["ShippingMode"];
	$remarks = $_GET["remarks"];
	
	$arrDdate = explode('/',$deliveryDate);
	$dDate = $arrDdate[2].'-'.$arrDdate[1].'-'.$arrDdate[0];
	
	$result = updateDeliveryDetails($delScheduleId,$dDate,$DelQty,$ExDelQty,$ShippingMode,$userId,$remarks);
	echo $result;
}
if ($id=="DeleteDeliveryData")
{
	$delScheduleId = $_GET["delScheduleId"];
	deleteDeliverySchedule($delScheduleId);
}
function getDeliveryShedule($styleID)
{
	global $db;
$sql="SELECT d.intStyleId, DATE_FORMAT(dtDateofDelivery, '%d/%m/%Y') as dtDateofDelivery,dblQty,dbExQty,
strRemarks,strShippingMode,isDeliveryBase,d.intSerialNO,o.intApprovalNo,d.intDeliveryId  
FROM deliveryschedule d LEFT JOIN eventtemplateheader e ON d.intSerialNO = e.intSerialNO
inner join orders o on o.intStyleId = d.intStyleId
 where d.intStyleId='$styleID' ";
return $db->RunQuery($sql);
	
}
function getShippingModeByID($shippingModeID)
{
	global $db;
	$sql="SELECT intShipmentModeId,strDescription FROM shipmentmode s where intStatus='1' AND intShipmentModeId='".$shippingModeID."';";
    $result=$db->RunQuery($sql);
    while($row=mysql_fetch_array($result))
    {
		return $row["strDescription"];
	}
}
function  updateDeliveryDetails($delScheduleId,$deliveryDate,$DelQty,$ExDelQty,$ShippingMode,$userId,$remarks)	
{
	global $db;
	$sql="insert into history_deliveryschedule (intDeliveryId,intStyleId,dtDateofDelivery,dblQty,dblBalQty,dtPODate,dtGRNDate, 	strRemarks,intComplete,dtmPlanCutDate,dtmactuCutDate,dtmPlanFabDate,strPPSampleStatus,strTopSampleStatus,intTrimCards, 
	intOffSet,strShippingMode,dbExQty,intMsSql,isDeliveryBase,intSerialNO,estimatedDate,intUserId,dtmDate)
	select * from deliveryschedule where intDeliveryId = '$delScheduleId' ";
	$db->executeQuery($sql);
	
	$sql_d = " update deliveryschedule set dtDateofDelivery = '$deliveryDate' , dblQty = '$DelQty' , 
	strRemarks = '$remarks' ,	strShippingMode = '$ShippingMode' , dbExQty = '$ExDelQty' , intUserId = '$userId' , 
	dtmDate = now()	where 	intDeliveryId = '$delScheduleId' ";
	
	return	$db->RunQuery($sql_d);	
}
function deleteDeliverySchedule($delScheduleId)
{
	global $db;
	$sql="insert into history_deliveryschedule (intDeliveryId,intStyleId,dtDateofDelivery,dblQty,dblBalQty,dtPODate,dtGRNDate, 	strRemarks,intComplete,dtmPlanCutDate,dtmactuCutDate,dtmPlanFabDate,strPPSampleStatus,strTopSampleStatus,intTrimCards, 
	intOffSet,strShippingMode,dbExQty,intMsSql,isDeliveryBase,intSerialNO,estimatedDate,intUserId,dtmDate)
	select * from deliveryschedule where intDeliveryId = '$delScheduleId' ";
	$db->executeQuery($sql);
	
	$sql_d= " delete from deliveryschedule 	where 	intDeliveryId = '$delScheduleId' ";
	$result = $db->RunQuery($sql_d);	
}
?>
