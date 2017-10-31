<?php 
session_start();
// LC Request Status ---------------------------------------------
// 0 - Pending
// 1- Send to approval
// 2 - First approval
// 3 - Approved
// 10 - Cancel
//----------------------------------------------------------------
include "../Connector.php";
$userId			= $_SESSION["UserID"];
$companyId				= $_SESSION["FactoryID"];
$id=$_GET["id"];
if ($id=="load_BulkPO")
{
	$intYear = $_GET["intYear"];
	$intYear = ($intYear == '' ?date('Y'):$intYear);
	$sql = "select intBulkPoNo from bulkpurchaseorderheader where intStatus=1 and intYear='$intYear' order by intBulkPoNo desc ";
	$results=$db->RunQuery($sql);
			
	while($row=mysql_fetch_array($results))
	{
		$po_arr.= $row['intBulkPoNo']."|";
		 
	}
	echo $po_arr;
}
if ($id=="load_PIList")
{
	$sql = "select distinct bpo.strPINO from bulkpurchaseorderheader bpo inner join lcrequestheader lc on 
lc.intBulkPoNo = bpo.intBulkPoNo and 
lc.intYear = bpo.intYear where bpo.strPINO <>''";
	$results=$db->RunQuery($sql);
			
	while($row=mysql_fetch_array($results))
	{
		$po_arr.= $row['strPINO']."|";
		 
	}
	echo $po_arr;
}
if ($id=="load_PINo")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
	$ResponseXML .= "<viewBulkPI>";
	$bulkPONo = $_GET["bulkPONo"];
	$bulkPOYear = $_GET["bulkPOYear"];
	
	$sql = "select strPINO from bulkpurchaseorderheader where intBulkPoNo='$bulkPONo' and intYear='$bulkPOYear' ";
	$results=$db->RunQuery($sql);
	$row = mysql_fetch_array($results);
	$ResponseXML .= "<strPINO><![CDATA[" . $row["strPINO"]  . "]]></strPINO>\n";
	$ResponseXML .= "</viewBulkPI>";
	echo $ResponseXML;
}
if ($id=="load_BulkPODetails")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
	$ResponseXML .= "<viewBulkPO>";
	$bulkPONo = $_GET["bulkPONo"];
	$bulkPOYear = $_GET["bulkPOYear"];
	
	$sql = "select pd.intMatDetailId,mil.strItemDescription
from  bulkpurchaseorderdetails pd inner join matitemlist mil on mil.intItemSerial= pd.intMatDetailId
where pd.intBulkPoNo='$bulkPONo' and pd.intYear='$bulkPOYear'";
	
	$results=$db->RunQuery($sql);
	while($row=mysql_fetch_array($results))
	{
		$ResponseXML .= "<intMatDetailId><![CDATA[" . $row["intMatDetailId"]  . "]]></intMatDetailId>\n";
		$ResponseXML .= "<strItemDescription><![CDATA[" . $row["strItemDescription"]  . "]]></strItemDescription>\n";
	}
	$ResponseXML .= "</viewBulkPO>";
	echo $ResponseXML;
}
if ($id=="load_OrderDetails")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
	$ResponseXML .= "<viewOrderDetails>";
	$intMatDetailID = $_GET["intMatDetailID"];
	$styleName = $_GET["styleName"];
	$styleId  = $_GET["styleId"];
	
	$sql = "select o.strStyle, o.strOrderNo, od.reaConPc,od.dblUnitPrice,o.intStyleId,o.intQty
from orders o inner join orderdetails od on
o.intStyleId = od.intStyleId
where od.intMatDetailID='$intMatDetailID'";
	if($styleName != '')
		$sql .= " and o.strStyle = '$styleName' ";
	if($styleId != '')
		$sql .= " and o.intStyleId = '$styleId' ";
	
	$results=$db->RunQuery($sql);
	while($row=mysql_fetch_array($results))
	{
		$ResponseXML .= "<strStyle><![CDATA[" . $row["strStyle"]  . "]]></strStyle>\n";
		$ResponseXML .= "<strOrderNo><![CDATA[" . $row["strOrderNo"]  . "]]></strOrderNo>\n";
		$ResponseXML .= "<reaConPc><![CDATA[" . $row["reaConPc"]  . "]]></reaConPc>\n";
		$ResponseXML .= "<dblUnitPrice><![CDATA[" . $row["dblUnitPrice"]  . "]]></dblUnitPrice>\n";
		$ResponseXML .= "<intStyleId><![CDATA[" . $row["intStyleId"]  . "]]></intStyleId>\n";
		$ResponseXML .= "<intQty><![CDATA[" . $row["intQty"]  . "]]></intQty>\n";
		
		$res_delivery = getDeliveryDetails($row["intStyleId"]);
		$str_del = '';
		$str_del .= "<select name='cboDelivery'  style='width:120px;' >";
			
			while($rw = mysql_fetch_array($res_delivery))
			{
					$str_del .= "<option value=\"". $rw["intDeliveryId"] ."\">" . $rw["deliveryDate"] ."</option>";
			}
			$str_del .= "</select> ";
		$ResponseXML .= "<deliveryDates><![CDATA[" . $str_del  . "]]></deliveryDates>\n";	
	}		
	$ResponseXML .= "</viewOrderDetails>";
	echo $ResponseXML;
}
if ($id=="saveHeader")
{
	$bulkPOno = $_GET["bulkPOno"];
	$bulkPOyear = $_GET["bulkPOyear"];
	
	$chkHeaderAv = checkLCHeaderAv($bulkPOno,$bulkPOyear);
	if($chkHeaderAv == 1)
	{
		$sql = "update lcrequestheader 	set intUserID = '$userId' , dtmDate = now()
	where	intBulkPoNo = '$bulkPOno' and intYear = '$bulkPOyear' ";
	}
	else
	{
		$sql = " insert into lcrequestheader (intBulkPoNo,intYear, intUserID, dtmDate)	values ('$bulkPOno', '$bulkPOyear', '$userId',	now()) ";
	}
	$results=$db->RunQuery($sql);
}
if ($id=="saveItemDetails")
{
	$intMatDetailID = $_GET["intMatDetailID"];
	$styleId = $_GET["styleId"];
	$conpc = $_GET["conpc"];
	$uprice = $_GET["uprice"];
	$delDateId = $_GET["delDateId"];
	$prodInDate = $_GET["prodInDate"];
	$bulkPOno = $_GET["bulkPOno"];
	$bulkPOyear = $_GET["bulkPOyear"];
	$remarks = $_GET["remarks"];
	if($prodInDate =='')
		$prodInDate = '0000-00-00';
	
	$chkDetAv = checkLCdetailsAv($styleId,$intMatDetailID,$bulkPOno,$bulkPOyear);	
	if($chkDetAv == 1)
	{
		$sql = "update lcrequestdetail 	set	intDelDateId = '$delDateId' ,	dtmProdutLineDate = '$prodInDate', strRemarks='$remarks'
	where 	intBulkPoNo = '$bulkPOno' and intYear = '$bulkPOyear' and  intStyleId = '$styleId' and 	intMatDetailID = '$intMatDetailID' ";
	}
	else
	{
		$sql = "insert into lcrequestdetail (intBulkPoNo,intYear,intStyleId,intMatDetailID,reaConPc, dblUnitPrice, intDelDateId, 	dtmProdutLineDate,strRemarks ) values
		('$bulkPOno', '$bulkPOyear', '$styleId','$intMatDetailID','$conpc', '$uprice','$delDateId',	'$prodInDate','$remarks')";
	}
	$results=$db->RunQuery($sql);
}
if ($id=="check_lc_dataAv")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
	$ResponseXML .= "<viewSavedItemDetails>";
	
	$itemID = $_GET["itemID"];
	$bulkPONo = $_GET["bulkPONo"];
	$bulkPOYear = $_GET["bulkPOYear"];
	
	$sql = "select o.strOrderNo,o.strStyle,lc.reaConPc,lc.dblUnitPrice, date(lc.dtmProdutLineDate) as prodDate, 
date(dd.dtDateofDelivery) as delDate,lc.intDelDateId,lc.intStyleId,o.intQty,lc.strRemarks   
from lcrequestdetail lc inner join deliveryschedule dd on 
dd.intDeliveryId = lc.intDelDateId
inner join orders o on o.intStyleId = lc.intStyleId
where intBulkPoNo='$bulkPONo' and intYear='$bulkPOYear' and intMatDetailID='$itemID'";
	$results=$db->RunQuery($sql);
	$numrows = mysql_num_rows($results);
	
	while($row = mysql_fetch_array($results))
	{
		$prodDate = $row["prodDate"];
		if($prodDate == '0000-00-00')
			$prodDate = '';
		$ResponseXML .= "<intStyleId><![CDATA[" . $row["intStyleId"]  . "]]></intStyleId>\n";
		$ResponseXML .= "<orderno><![CDATA[" . $row["strOrderNo"]  . "]]></orderno>\n";
		$ResponseXML .= "<strStyle><![CDATA[" . $row["strStyle"]  . "]]></strStyle>\n";
		$ResponseXML .= "<dblUnitPrice><![CDATA[" . $row["dblUnitPrice"]  . "]]></dblUnitPrice>\n";
		$ResponseXML .= "<prodDate><![CDATA[" . $prodDate . "]]></prodDate>\n";
		$ResponseXML .= "<delDate><![CDATA[" . $row["delDate"]  . "]]></delDate>\n";
		$ResponseXML .= "<intMatDetailID><![CDATA[" . $row["intMatDetailID"]  . "]]></intMatDetailID>\n";	
		$ResponseXML .= "<reaConPc><![CDATA[" . $row["reaConPc"]  . "]]></reaConPc>\n";
		$ResponseXML .= "<Qty><![CDATA[" . $row["intQty"]  . "]]></Qty>\n";
		$ResponseXML .= "<intDelDateId><![CDATA[" . $row["intDelDateId"]  . "]]></intDelDateId>\n";
		$ResponseXML .= "<strRemarks><![CDATA[" . $row["strRemarks"]  . "]]></strRemarks>\n";
	}
	$ResponseXML .= "<numrows><![CDATA[" . $numrows  . "]]></numrows>\n";	
	$ResponseXML .= "</viewSavedItemDetails>";
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
if ($id=="save_lcAlloDetails")
{
	$piNo = $_GET["piNo"];
	$lcAlloNo = $_GET["lcAlloNo"];
	$lcAlloYear = $_GET["lcAlloYear"];
	
	$sql_p = "select intBulkPoNo,intYear from bulkpurchaseorderheader where strPINO='$piNo'";
	$result_p =  $db->RunQuery($sql_p);
	
	while($rowP = mysql_fetch_array($result_p))
	{
		insertPIAlloDetails($lcAlloNo,$lcAlloYear,$rowP["intBulkPoNo"],$rowP["intYear"]);
	}
}
if ($id=="get_LCreqNoList")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
	$ResponseXML .= "<getLCAlloNoList>";
	$sql = "select intLCRequestNo,intRequestYear from lcrequest_pialloheader where intStatus =0 ";
	$str ="";
		$result =  $db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{
			$str .= "<option value=\"". $row["intRequestYear"].'/'.$row["intLCRequestNo"] ."\">" . $row["intRequestYear"].'/'.$row["intLCRequestNo"]."</option>";
		}
	$ResponseXML .= "<lcRequestNoList><![CDATA[" . $str  . "]]></lcRequestNoList>\n";	
	$ResponseXML .= "</getLCAlloNoList>";
	echo $ResponseXML;
}
if ($id=="updateSendToStatus")
{
	$lcNo = $_GET["lcNo"];
	$lCyear = $_GET["lCyear"];
	$sql = " update lcrequest_pialloheader 	set  intStatus = '1' 
	where
	intLCRequestNo = '$lcNo' and intRequestYear = '$lCyear' ";
	$result =  $db->RunQuery($sql);
}
if ($id=="load_lc_name")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .= "<getLCName>";
	$lcNo = $_GET["lcNo"];
	$arrLcNo = explode('/',$lcNo);
	
	$sql = "select lcRequestName,intStatus from lcrequest_pialloheader where intLCRequestNo ='$arrLcNo[1]' and  intRequestYear = '$arrLcNo[0]'";
	$result =  $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	$ResponseXML .= "<lcRequestName><![CDATA[" . $row["lcRequestName"]  . "]]></lcRequestName>\n";	
	$ResponseXML .= "<lcRequestStatus><![CDATA[" . $row["intStatus"]  . "]]></lcRequestStatus>\n";	
	$ResponseXML .= "</getLCName>";
	echo $ResponseXML;
}
if ($id=="load_LC_Fabric_Details")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
	$ResponseXML .= "<viewBulkPO>";
	$lcNo = $_GET["lcNo"];
	$arrLcNo = explode('/',$lcNo);
	
	$sql = "select bpd.intMatDetailId,mil.strItemDescription,lcd.intBulkPoNo,lcd.intYear,bph.strPINO  
from lcrequest_piallodetails lcd inner join bulkpurchaseorderdetails bpd on
lcd.intBulkPoNo =bpd.intBulkPoNo and lcd.intYear = bpd.intYear
inner join matitemlist mil on  mil.intItemSerial = bpd.intMatDetailId
inner join bulkpurchaseorderheader bph on bph.intBulkPoNo = bpd.intBulkPoNo and bph.intYear= bpd.intYear
where lcd.intLCRequestNo='$arrLcNo[1]' and lcd.intRequestYear='$arrLcNo[0]' ";
	
	$results=$db->RunQuery($sql);
	while($row=mysql_fetch_array($results))
	{
		$ResponseXML .= "<intMatDetailId><![CDATA[" . $row["intMatDetailId"]  . "]]></intMatDetailId>\n";
		$ResponseXML .= "<strItemDescription><![CDATA[" . $row["strItemDescription"]  . "]]></strItemDescription>\n";
		$ResponseXML .= "<intBulkPoNo><![CDATA[" . $row["intBulkPoNo"]  . "]]></intBulkPoNo>\n";
		$ResponseXML .= "<bulkPOYear><![CDATA[" . $row["intYear"]  . "]]></bulkPOYear>\n";
		$ResponseXML .= "<strPINO><![CDATA[" . $row["strPINO"]  . "]]></strPINO>\n";
	}
	$ResponseXML .= "</viewBulkPO>";
	echo $ResponseXML;
}
if ($id=="updateProdLineDate")
{
	$bulkPO = $_GET["bulkPO"];
	$bulkPOYear = $_GET["bulkPOYear"];
	$matDetailID = $_GET["matDetailID"];
	$styleID = $_GET["styleID"];
	$prodDate = $_GET["prodDate"];
	
	$sql = "update lcrequestdetail 
	set
	dtmProdutLineDate = '$prodDate' 	where 	intBulkPoNo = '$bulkPO' and 	intYear = '$bulkPOYear' and 
	intStyleId = '$styleID' and 
	intMatDetailID = '$matDetailID'  ";
	$results=$db->RunQuery($sql);
}
if ($id=="updateFirstAppData")
{
	$lCyear = $_GET["lCyear"];
	$lcNo = $_GET["lcNo"];
	
	$sql = "update lcrequest_pialloheader 
	set
	intFirstApprovedBy = '$userId' , 
	intStatus= 2,
	dtmFirstAppDate = now() 
	where
	intLCRequestNo = '$lcNo' and intRequestYear = '$lCyear' ";	
	$results=$db->RunQuery($sql);
}
if ($id=="updateRejectStatus")
{
	$lCyear = $_GET["lCyear"];
	$lcNo = $_GET["lcNo"];
	
	$sql = "update lcrequest_pialloheader 
	set
	intFirstApprovedBy = Null , 
	intStatus= 0,
	dtmFirstAppDate = Null	
	where
	intLCRequestNo = '$lcNo' and intRequestYear = '$lCyear' ";	
	$results=$db->RunQuery($sql);
}
if ($id=="confirmLCRequest")
{
	$lCyear = $_GET["lCyear"];
	$lcNo = $_GET["lcNo"];
	
	$sql = "update lcrequest_pialloheader 
	set
	intConfirmedBy = '$userId' , 
	intStatus= 3,
	dtmConfirmedDate = now() 
	where
	intLCRequestNo = '$lcNo' and intRequestYear = '$lCyear' ";	
	$results=$db->RunQuery($sql);
}
if ($id=="deleteItem")
{
	$bulkPOno = $_GET["bulkPOno"];
	$bulkPOyear = $_GET["bulkPOyear"];
	$delDateId = $_GET["delDateId"];
	$intMatDetailID = $_GET["intMatDetailID"];
	$styleId = $_GET["styleId"];
	
	$sql = "delete from lcrequestdetail 	where 	intBulkPoNo = '$bulkPOno' and 
	intYear = '$bulkPOyear' and  	intStyleId = '$styleId' and 	intMatDetailID = '$intMatDetailID' and 
	intDelDateId = '$delDateId' ";
	$results=$db->RunQuery($sql);
	
}
function getDeliveryDetails($styleId)
{
	global $db;
	$sql = "select intDeliveryId,date(dtDateofDelivery) as deliveryDate from deliveryschedule where intStyleId='$styleId'";
	return $db->RunQuery($sql);
}

function checkLCHeaderAv($bulkPOno,$bulkPOyear)
{
	global $db;
	$sql = "Select * from lcrequestheader Where intBulkPoNo ='$bulkPOno' and intYear = '$bulkPOyear' ";
	return $db->CheckRecordAvailability($sql);
}

function checkLCdetailsAv($styleId,$intMatDetailID,$bulkPOno,$bulkPOyear)
{
	global $db;
	$sql = "select * from lcrequestdetail where intBulkPoNo='$bulkPOno' and intYear='$bulkPOyear' and intStyleId='$styleId' and intMatDetailID='$intMatDetailID' ";
	return $db->CheckRecordAvailability($sql);
}
function insertPIAlloDetails($lcAlloNo,$lcAlloYear,$bulkPOno,$bulkPOyear)
{
	global $db;
	$sql = "insert into lcrequest_piallodetails (intLCRequestNo,intRequestYear,intBulkPoNo, intYear)
	values 	('$lcAlloNo','$lcAlloYear','$bulkPOno','$bulkPOyear') ";
	
	$result =  $db->RunQuery($sql);	
}
?>
