<?php 
include "../../Connector.php";
$userId			= $_SESSION["UserID"];
$companyId				= $_SESSION["FactoryID"];
$id=$_GET["id"];
if ($id=="viewLCRequestData")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$orderNo = $_GET["orderNo"];
	$supplier = $_GET["supplier"];
	$oritRefNo = $_GET["oritRefNo"];
	$piNo = $_GET["piNo"];
	$factory = $_GET["factory"];
	$shipMode = $_GET["shipMode"];
	$status = $_GET["status"];
	
	$ResponseXML .= "<viewLCData>";
	
	$result = getLCRequestData($orderNo,$supplier,$oritRefNo,$piNo,$factory,$shipMode,$status);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<recNo><![CDATA[" . $row["intRecordNo"]  . "]]></recNo>\n";
		$ResponseXML .= "<factory><![CDATA[" . $row["strfactory"]  . "]]></factory>\n";
		$ResponseXML .= "<orderno><![CDATA[" . $row["strOrderNo"]  . "]]></orderno>\n";
		$ResponseXML .= "<strPINo><![CDATA[" . $row["strPINo"]  . "]]></strPINo>\n";
		$ResponseXML .= "<strOritRefNo><![CDATA[" . $row["strOritRefNo"]  . "]]></strOritRefNo>\n";
		$ResponseXML .= "<SupplierPINo><![CDATA[" . $row["strSupplierPINo"]  . "]]></SupplierPINo>\n";
		$ResponseXML .= "<strDNNo><![CDATA[" . $row["strDNNo"]  . "]]></strDNNo>\n";
		$ResponseXML .= "<ShipMode><![CDATA[" . $row["strShipMode"]  . "]]></ShipMode>\n";
		$ResponseXML .= "<ItemCode><![CDATA[" . $row["strItemCode"]  . "]]></ItemCode>\n";
		$ResponseXML .= "<strColor><![CDATA[" . $row["strColor"]  . "]]></strColor>\n";
		$ResponseXML .= "<strSize><![CDATA[" . $row["strSize"]  . "]]></strSize>\n";
		$ResponseXML .= "<dblQty><![CDATA[" . $row["dblQty"]  . "]]></dblQty>\n";
		$ResponseXML .= "<dblAmount><![CDATA[" . $row["dblAmount"]  . "]]></dblAmount>\n";
		$ResponseXML .= "<strGW><![CDATA[" . $row["strGW"]  . "]]></strGW>\n";
		$ResponseXML .= "<dblCM><![CDATA[" . $row["dblCM"]  . "]]></dblCM>\n";
		$ResponseXML .= "<strPayment><![CDATA[" . $row["strPayment"]  . "]]></strPayment>\n";
		$ResponseXML .= "<strHandleBy><![CDATA[" . $row["strHandleBy"]  . "]]></strHandleBy>\n";
		$ResponseXML .= "<dtmReadyDate><![CDATA[" . $row["dtmReadyDate"]  . "]]></dtmReadyDate>\n";
		$ResponseXML .= "<dtmPIConfirmDate><![CDATA[" . $row["dtmPIConfirmDate"]  . "]]></dtmPIConfirmDate>\n";
		$ResponseXML .= "<dtmHandoverDate><![CDATA[" . $row["dtmHandoverDate"]  . "]]></dtmHandoverDate>\n";
		$ResponseXML .= "<strRemarks><![CDATA[" . $row["strRemarks"]  . "]]></strRemarks>\n";
		$ResponseXML .= "<supplier><![CDATA[" . $row["supplier"]  . "]]></supplier>\n";
		$ResponseXML .= "<intStatus><![CDATA[" . $row["intStatus"]  . "]]></intStatus>\n";
	}
	
	$ResponseXML .= "</viewLCData>";
	echo $ResponseXML;
}
if ($id=="save_lcAlloNo")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
	$ResponseXML .= "<getLCAlloNo>";
	$intYear=date("Y");
	$lcName = $_GET["lcName"];
	
	$SQL="SELECT intLCRequestNo FROM syscontrol WHERE intCompanyID='$companyId'";
	$result =  $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$lcRequestNo =  $row["intLCRequestNo"];
		$SQL = "UPDATE syscontrol set intLCRequestNo=intLCRequestNo+1 where intCompanyID='$companyId'";
		$result = $db->RunQuery($SQL);
		
	}
	
	$sql_insert = " insert into lcrequest_pialloheader 	(intLCRequestNo,intRequestYear,lcRequestName,intUserId, dtmDate,intStatus)
	values	('$lcRequestNo', '$intYear','$lcName','$userId',now(),'0')";
	$result_insert =  $db->RunQuery($sql_insert);
	
	$ResponseXML .= "<lcRequestNo><![CDATA[" . $lcRequestNo  . "]]></lcRequestNo>\n";
	$ResponseXML .= "<lcRequestYear><![CDATA[" . $intYear  . "]]></lcRequestYear>\n";
	$ResponseXML .= "</getLCAlloNo>";
	echo $ResponseXML;
}
if ($id=="update_LCallocateHeader")
{
	$intLCNo = $_GET["intLCNo"];
	$intLCYear = $_GET["intLCYear"];
	$lcName = $_GET["lcName"];
	
	$sql = "update lcrequest_pialloheader 
	set
	lcRequestName = '$lcName' 
	where
	intLCRequestNo = '$intLCNo' and intRequestYear = '$intLCYear' ";
	
	$result =  $db->RunQuery($sql);
	
	deletePIAllocationData($intLCNo,$intLCYear);
	
}	
if ($id=="save_lcAlloDetails")
{
	$no = $_GET["no"];
	$lcNo = $_GET["lcNo"];
	$lcYear = $_GET["lcYear"];
	
	insertLCAllocationDetails($lcNo,$lcYear,$no);
	updateLCSupplierData($no);
}
if ($id=="getSavedLCAllocatedData")
{
	$lcNo = $_GET["lcNo"];
	$lcYear = $_GET["lcYear"];
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .= "<getLCAlloData>";
	$result = getSavedLCAllocatedData($lcNo,$lcYear);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<recNo><![CDATA[" . $row["intRecordNo"]  . "]]></recNo>\n";
		$ResponseXML .= "<factory><![CDATA[" . $row["strfactory"]  . "]]></factory>\n";
		$ResponseXML .= "<orderno><![CDATA[" . $row["strOrderNo"]  . "]]></orderno>\n";
		$ResponseXML .= "<strPINo><![CDATA[" . $row["strPINo"]  . "]]></strPINo>\n";
		$ResponseXML .= "<strOritRefNo><![CDATA[" . $row["strOritRefNo"]  . "]]></strOritRefNo>\n";
		$ResponseXML .= "<SupplierPINo><![CDATA[" . $row["strSupplierPINo"]  . "]]></SupplierPINo>\n";
		$ResponseXML .= "<strDNNo><![CDATA[" . $row["strDNNo"]  . "]]></strDNNo>\n";
		$ResponseXML .= "<ShipMode><![CDATA[" . $row["strShipMode"]  . "]]></ShipMode>\n";
		$ResponseXML .= "<ItemCode><![CDATA[" . $row["strItemCode"]  . "]]></ItemCode>\n";
		$ResponseXML .= "<strColor><![CDATA[" . $row["strColor"]  . "]]></strColor>\n";
		$ResponseXML .= "<strSize><![CDATA[" . $row["strSize"]  . "]]></strSize>\n";
		$ResponseXML .= "<dblQty><![CDATA[" . $row["dblQty"]  . "]]></dblQty>\n";
		$ResponseXML .= "<dblAmount><![CDATA[" . $row["dblAmount"]  . "]]></dblAmount>\n";
		$ResponseXML .= "<strGW><![CDATA[" . $row["strGW"]  . "]]></strGW>\n";
		$ResponseXML .= "<dblCM><![CDATA[" . $row["dblCM"]  . "]]></dblCM>\n";
		$ResponseXML .= "<strPayment><![CDATA[" . $row["strPayment"]  . "]]></strPayment>\n";
		$ResponseXML .= "<strHandleBy><![CDATA[" . $row["strHandleBy"]  . "]]></strHandleBy>\n";
		$ResponseXML .= "<dtmReadyDate><![CDATA[" . $row["dtmReadyDate"]  . "]]></dtmReadyDate>\n";
		$ResponseXML .= "<dtmPIConfirmDate><![CDATA[" . $row["dtmPIConfirmDate"]  . "]]></dtmPIConfirmDate>\n";
		$ResponseXML .= "<dtmHandoverDate><![CDATA[" . $row["dtmHandoverDate"]  . "]]></dtmHandoverDate>\n";
		$ResponseXML .= "<strRemarks><![CDATA[" . $row["strRemarks"]  . "]]></strRemarks>\n";
		$ResponseXML .= "<supplier><![CDATA[" . $row["supplier"]  . "]]></supplier>\n";
		$ResponseXML .= "<intStatus><![CDATA[" . $row["intStatus"]  . "]]></intStatus>\n";
	}
	
	$ResponseXML .= "</getLCAlloData>";
	echo $ResponseXML;
}

if ($id=="getSavedLCAllocatedHeaderData")
{
	$lcNo = $_GET["lcNo"];
	$lcYear = $_GET["lcYear"];
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .= "<getLCAlloData>";
	
	$sql = "select lcRequestName from lcrequest_pialloheader where intLCRequestNo=$lcNo and intRequestYear=$lcYear ";
	$result = $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	
	$ResponseXML .= "<lcRequestName><![CDATA[" . $row["lcRequestName"]  . "]]></lcRequestName>\n";
	$ResponseXML .= "</getLCAlloData>";
	echo $ResponseXML;
}
if ($id=="updateLCDetails")
{
	$no = $_GET["no"];
	$supplier = $_GET["supplier"];
	$fac = $_GET["fac"];
	$orderNo = $_GET["orderNo"];
	$piNo = $_GET["piNo"];
	$oritRef = $_GET["oritRef"];
	$suppPI = $_GET["suppPI"];
	$DNno = $_GET["DNno"];
	$shipmode = $_GET["shipmode"];
	$itemCode = $_GET["itemCode"];
	$color = $_GET["color"];
	$size = $_GET["size"];
	$qty = $_GET["qty"];
	$amount = $_GET["amount"];
	$gw = $_GET["gw"];
	$cm = $_GET["cm"];
	$pay = $_GET["pay"];
	$handle = $_GET["handle"];
	$readydate = $_GET["readydate"];
	$piConfirm = $_GET["piConfirm"];
	$handoverDate = $_GET["handoverDate"];
	$remarks = $_GET["remarks"];
	
	 $qty = ($qty == ''?'Null':$qty);
	 $amount = ($amount == ''?'Null':$amount);
	 $cm = ($cm == ''?'Null':$cm);
	
	$sql = " update lc_supplierdetails 
	set
	strfactory = '$fac' , 
	strOrderNo = '$orderNo' , 
	strPINo = '$piNo' , 
	strOritRefNo = '$oritRef' , 
	strSupplierPINo = '$suppPI' , 
	strDNNo = '$DNno' , 
	strShipMode = '$shipmode' , 
	strItemCode = '$itemCode' , 
	strColor = '$color' , 
	strSize = '$size' , 
	dblQty = $qty, 
	dblAmount = $amount, 
	strGW = '$gw' , 
	dblCM = $cm , 
	strPayment = '$pay' , 
	strHandleBy = '$handle' , 
	dtmReadyDate = '$readydate' , 
	dtmPIConfirmDate = '$piConfirm' , 
	dtmHandoverDate = '$handoverDate' , 
	strRemarks = '$remarks' , 
	supplier = '$supplier' 
	where
	intRecordNo = '$no' ";
	
	$result = $db->RunQuery($sql);	
}
function getLCRequestData($orderNo,$supplier,$oritRefNo,$piNo,$factory,$shipMode,$status)
{
	global $db;
	$sql = "select * from lc_supplierdetails where supplier<>''  ";
	if($orderNo != '')
		$sql .= " and  strOrderNo like '%$orderNo%' ";
	if($supplier !='')
		$sql .= " and supplier like '%$supplier%' ";
	if($oritRefNo != '')
		$sql .= " and strOritRefNo like '%$oritRefNo%' ";
	if($piNo != '')
		$sql .= " and strPINo like '%$piNo%' ";
	if($factory != '')
		$sql .= " and strfactory like '%$factory%' ";
	if($shipMode != '')
		$sql .= " and strShipMode like '%$shipMode%' ";			
	if($status !='')
		$sql .= " and intStatus='$status' ";
	return $db->RunQuery($sql);	
}
function insertLCAllocationDetails($lcNo,$lcYear,$no)
{
	global $db;
	$sql = " insert into lcrequest_piallodetails (intLCRequestNo,intRequestYear,intRecordNo)
values ('$lcNo','$lcYear','$no') ";
	$result =  $db->RunQuery($sql);	
}

function updateLCSupplierData($no)
{
	global $db;
	$sql = " update lc_supplierdetails 	set  intStatus = '1' where	intRecordNo = '$no' ";
	$result =  $db->RunQuery($sql);	
}

function getSavedLCAllocatedData($lcNo,$lcYear)
{
	global $db;
	$sql = " select lc.* from lc_supplierdetails lc inner join lcrequest_piallodetails lcd on 
lc.intRecordNo = lcd.intRecordNo 
where lcd.intLCRequestNo='$lcNo' and lcd.intRequestYear = '$lcYear' ";
	return  $db->RunQuery($sql);	
}

function deletePIAllocationData($intLCNo,$intLCYear)
{
	global $db;
	$sql = " delete from lcrequest_piallodetails 	where
	intLCRequestNo = '$intLCNo' and 	intRequestYear = '$intLCYear' ";
	
	$result = $db->RunQuery($sql);	
}
?>
