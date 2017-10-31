<?php
include "../../Connector.php";
include '../../eshipLoginDB.php';
//header('Content-Type: text/xml'); 
//-------------Shipping Costworksheet status-----------------------------
//0-pending
//1-approved
//--------------------------------------------------------------
$id=$_GET["id"];
$intCompanyId		=$_SESSION["FactoryID"];
$userId		= $_SESSION["UserID"];
if ($id=="load_comm_invNo")
{

$eshipDB = new eshipLoginDB();
	
	$sql="select strInvoiceNo from commercial_invoice_header order by dtmInvoiceDate desc ";
		
			$results=$eshipDB->RunQuery($sql);
			//$po_arr = "|";
			while($row=mysql_fetch_array($results))
			{
				$inv_arr .= $row['strInvoiceNo']."|";
				 
			}
			echo $inv_arr;
}
if ($id=="load_AppOrder_list")
{
	$sql = "select distinct strOrderNo from firstsale_shippingdata where intStatus=1 ";
	$results=$db->RunQuery($sql);
			//$po_arr = "|";
			while($row=mysql_fetch_array($results))
			{
				$inv_arr .= $row['strOrderNo']."|";
				 
			}
			echo $inv_arr;
}
if ($id=="load_Order_list")
{
	$sql = " select o.strOrderNo from orders o inner join firstsalecostworksheetheader fsh on fsh.intStyleId=o.intStyleId
where fsh.intStatus<>11 ";

	$results=$db->RunQuery($sql);
			//$po_arr = "|";
			while($row=mysql_fetch_array($results))
			{
				$inv_arr .= $row['strOrderNo']."|";
				 
			}
			echo $inv_arr;
}
if ($id=="load_orderNo_list")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$responseXml ='<data>';
	
	$comInvNo = $_GET["comInvNo"];
	$result = getComInvwiseOrderList($comInvNo);
	
	$str = '';
	while($row = mysql_fetch_array($result))
	{
		$str .= "<option value=\"". $row["strBuyerPONo"] ."\">" . $row["strBuyerPONo"] ."</option>";
	}
	
	$responseXml .= "<orderNoList><![CDATA[" . $str  .  "]]></orderNoList>\n";
	$responseXml.='</data>';
	echo $responseXml;
}

if ($id=="load_orderNo_Colorlist")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$responseXml ='<data>';
	
	$comInvNo = $_GET["comInvNo"];
	$orderNo = $_GET["orderNo"];
	
	$result = getOrderwiseColorList($comInvNo,$orderNo);
	
	$str = '';
	while($row = mysql_fetch_array($result))
	{
		$str .= "<option value=\"". $row["strColor"] ."\">" . $row["strColor"] ."</option>";
	}
	
	$responseXml .= "<orderNoColorList><![CDATA[" . $str  .  "]]></orderNoColorList>\n";
	$responseXml.='</data>';
	echo $responseXml;
}

if ($id=="load_confirm_OrderNoList")
{
	
	$sql = " select distinct o.strOrderNo from orders o inner join firstsale_shippingdata fs on 
fs.intStyleId = o.intStyleId where fs.intStatus=1 ";
	$result = $db->RunQuery($sql);	
	$str = '';
	while($row = mysql_fetch_array($result))
	{
			$str .= $row["strOrderNo"].'|';	
	}
	echo $str;
	
}

//---------------------------------------------------------------------
if ($id=="load_ComInv_list")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$responseXml ='<data>';
	
	$orderNo = $_GET["orderNo"];
	$styleId = $_GET["styleId"];
	
	$color = getOrderColor($styleId);
	$colorlen = strlen($color);
	
	if($colorlen !=0)
		$orderNo = substr($orderNo,0,(($colorlen+1)*-1));
	
	$styleName = getStyleName($styleId);	
	$result = getOrderwiseComInvList($styleId);
	
	$str = '';
	while($row = mysql_fetch_array($result))
	{
		$str .= "<option value=\"". $row["strInvoiceNo"] ."\">" . $row["strInvoiceNo"] ."</option>";
	}
	
	$responseXml .= "<comInvList><![CDATA[" . $str  .  "]]></comInvList>\n";
	$responseXml .= "<color><![CDATA[" . $color  .  "]]></color>\n";
	$responseXml.='</data>';
	echo $responseXml;
}
//------------------------------------------------------------------
if ($id=="load_orderNoDetails")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$responseXml ='<data>';
	
	$comInvNo = $_GET["comInvNo"];
	$orderNo = $_GET["orderNo"];
	$strColor = $_GET["strColor"];
	$styleId  = $_GET["styleId"];
	
	$colorlen = strlen($strColor);
	
	if($colorlen !=0)
		$orderNo = substr($orderNo,0,(($colorlen+1)*-1));
		
	$result = getOrderDetails($comInvNo,$styleId);
	
	while($row = mysql_fetch_array($result))
	{
		$styleName = getStyleName($styleId);
		$responseXml .= "<styleNo><![CDATA[" . $styleName  .  "]]></styleNo>\n";
		$responseXml .= "<sailingDate><![CDATA[" . $row["SailingDate"]  .  "]]></sailingDate>\n";
		$responseXml .= "<Qty><![CDATA[" . $row["dblQuantity"]  .  "]]></Qty>\n";
		$responseXml .= "<carrier><![CDATA[" . $row["strCarrier"]  .  "]]></carrier>\n";
		$responseXml .= "<fabric><![CDATA[" . $row["strFabric"]  .  "]]></fabric>\n";
		$responseXml .= "<otherDetails><![CDATA[" . $row["strDescOfGoods"]  .  "]]></otherDetails>\n";
		$responseXml .= "<companyId><![CDATA[" . $row["strCompanyID"]  .  "]]></companyId>\n";
		$responseXml .= "<buyerID><![CDATA[" . $row["strBuyerID"]  .  "]]></buyerID>\n";
		$responseXml .= "<destination><![CDATA[" . $row["strFinalDest"]  .  "]]></destination>\n";
		$responseXml .= "<bankId><![CDATA[" . $row["intBankId"]  .  "]]></bankId>\n";
		$delAdd  = $row["strDeliverTo"];
		 if($delAdd == '' || is_null($delAdd))
		 	$delAdd =  $row["strCSCId"];
		//$responseXml .= "<deliverTo><![CDATA[" . $row["strDeliverTo"]  .  "]]></deliverTo>\n";
		$responseXml .= "<deliverTo><![CDATA[" . $delAdd  .  "]]></deliverTo>\n";
		$responseXml .= "<commFob><![CDATA[" . $row["dblUnitPrice"]  .  "]]></commFob>\n";
		$responseXml .= "<gender><![CDATA[" . $row["strGender"]  .  "]]></gender>\n";
		$responseXml .= "<strPayTerm><![CDATA[" . $row["strPayTerm"]  .  "]]></strPayTerm>\n";
		$responseXml .= "<HTSdata><![CDATA[" . $row["HTSdata"]  .  "]]></HTSdata>\n";
	}
	
	$invFob = getInvFob($styleId);
	$responseXml .= "<invFob><![CDATA[" . $invFob  .  "]]></invFob>\n";
	$strInvoiceNo ='';
	$strInvoiceNo = getShippingInvoiceNo($styleId,$comInvNo);
	$responseXml .= "<strInvoiceNo><![CDATA[" . $strInvoiceNo  .  "]]></strInvoiceNo>\n";
	$responseXml .='</data>';
	echo $responseXml;
}
if ($id=="load_AppOrderComInv_list")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$responseXml ='<data>';
	
	$orderNo = $_GET["orderNo"];
		
	$styleId = getStyleId($orderNo);	
	$styleName = getStyleName($styleId);	
	$result = getOrderwiseComInvList($styleId);
	
	$str = '';
	while($row = mysql_fetch_array($result))
	{
		$str .= "<option value=\"". $row["strInvoiceNo"] ."\">" . $row["strInvoiceNo"] ."</option>";
	}
	
	$responseXml .= "<comInvList><![CDATA[" . $str  .  "]]></comInvList>\n";
	$responseXml .= "<styleId><![CDATA[" . $styleId  .  "]]></styleId>\n";
	$responseXml.='</data>';
	echo $responseXml;
}
if ($id=="saveShippingCWSdetails")
{
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$responseXml ='<data>';
	
	$comInvNo = $_GET["comInvNo"];
	$orderNo = $_GET["orderNo"];
	$strColor = $_GET["strColor"];
	$styleId  = $_GET["styleId"];
	$invoiceNo = $_GET["invoiceNo"];
	$paytermId = $_GET["paytermId"];
	$shiptermId = $_GET["shiptermId"];
	$vatRate = $_GET["vatRate"];
	$buyerCode = trim($_GET["buyerCode"]);
	$fDestinationId = $_GET["fDestinationId"];
	$companyId = $_GET["companyId"];
	$buyerID = $_GET["buyerID"];
	
	$cityCode = getFdetinationCode($fDestinationId);
	$companyCode = getCompanyCode($companyId);
	
	$colorlen = strlen($strColor);
	
	if($colorlen !=0)
		$orderNo = substr($orderNo,0,(($colorlen+1)*-1));
		
	if(trim($vatRate) == '' || is_null($vatRate))
		$vatRate =0;
	
	if($invoiceNo == '' || is_null($invoiceNo))
	{
		
		
		/*$invAv = checkPendingInvAvailability($styleId,$orderNo,$strColor);
		if($invAv == '1')
		{
			$result = '0';
		}
		else
		{*/
			$buyerCode = getBuyerCode($styleId);
			$invoiceId = getInvoiceID($intCompanyId);
			$tdate = date('y-m-d');
			$arrDate = explode('-',$tdate);
			$invoiceNo = $buyerCode.'/'.$cityCode.'/'.$companyCode.'/'.$invoiceId.'/'.$arrDate[1].'/'.$arrDate[0];
		
			if($buyerCode =='')
				$result = 'Buyer Code not available';
			if($invoiceId == '')
				$result = 'Invoice ID not generated. Saved failed';	
			if($buyerCode !='' && $invoiceId !='')	
				$result = saveShippingData($styleId,$orderNo,$strColor,$invoiceId,$invoiceNo,$comInvNo,$paytermId,$shiptermId,$vatRate,$userId);
			//check invoice no saved in FScostworksheet header	
			$FSinvoiceNo = getFSInvoiceNo($styleId);
			//if FS shipping invoice no (dblInvoiceId) not available update shipping invoice no in FS 
			if(($FSinvoiceNo =='' || is_null($FSinvoiceNo)) && $invoiceId !='')
				updateFSInvoiceNo($styleId,$invoiceId);
			//update Pcs per Carton in fistsalecostworksheetheader 
			updatePcsPerCarton($styleId,$comInvNo);
			
			//update packing material conpc in firstsale_cwsDetail
			//updateCWSpackingMaterialConpc($styleId,$orderNo,$strColor,$comInvNo);
			//updateOtherPackingConpc($styleId,$buyerID);
		//}
		
	}
	else
	{
		$arrInvNo = explode('/',$invoiceNo);
		$invoiceId = $arrInvNo[3];
		updatePcsPerCarton($styleId,$comInvNo);
		$result = updateShippingData($styleId,$orderNo,$strColor,$invoiceId,$invoiceNo,$comInvNo,$paytermId,$shiptermId,$vatRate,$userId);
	}
	
	if($result == '1')
		$response = 'TRUE';
	else 
		$response = $result;
			
	$responseXml .= "<invNo><![CDATA[" . $invoiceNo  .  "]]></invNo>\n";
	$responseXml .= "<result><![CDATA[" . $response  .  "]]></result>\n";
	
	$responseXml .='</data>';
	echo $responseXml;	
}
if ($id=="load_pending_orderNoDetails")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$responseXml ='<data>';
	
	$invID = $_GET["invID"];
	//get shippingCWS details
	$result_ship = getPendingShipData($invID);
	
	while($rowS = mysql_fetch_array($result_ship))
	{
		$comInvNo = $rowS["strComInvNo"];
		$orderNo = $rowS["strOrderNo"];
		$strColor = $rowS["strOrderColorCode"];
		$styleId  = $rowS["intStyleId"];
		$invoiceNo =  $rowS["strInvoiceNo"];
	
		$shipterm = $rowS["intShipmentTermId"];
		$payterm = $rowS["intPaytermId"];
		$vatRate = $rowS["dblVatRate"];
		$styleNo = $rowS["strStyle"];
	}
//	
	$strOrderNo = $orderNo;
	if($strColor != '')
	 $strOrderNo = $orderNo.'-'.$strColor;
	/*$colorlen = strlen($strColor);
	
	if($colorlen !=0)
		$orderNo = substr($orderNo,0,(($colorlen+1)*-1));*/
	$resComInvData = getOrderwiseComInvList($styleId);
		
	$result = getOrderDetails($comInvNo,$styleId);
	while($row = mysql_fetch_array($result))
	{
		
		$responseXml .= "<sailingDate><![CDATA[" . $row["SailingDate"]  .  "]]></sailingDate>\n";
		$responseXml .= "<Qty><![CDATA[" . $row["dblQuantity"]  .  "]]></Qty>\n";
		$responseXml .= "<carrier><![CDATA[" . $row["strCarrier"]  .  "]]></carrier>\n";
		$responseXml .= "<fabric><![CDATA[" . $row["strFabric"]  .  "]]></fabric>\n";
		$responseXml .= "<otherDetails><![CDATA[" . $row["strDescOfGoods"]  .  "]]></otherDetails>\n";
		$responseXml .= "<companyId><![CDATA[" . $row["strCompanyID"]  .  "]]></companyId>\n";
		$responseXml .= "<buyerID><![CDATA[" . $row["strBuyerID"]  .  "]]></buyerID>\n";
		$responseXml .= "<destination><![CDATA[" . $row["strFinalDest"]  .  "]]></destination>\n";
		$responseXml .= "<bankId><![CDATA[" . $row["intBankId"]  .  "]]></bankId>\n";
		$delAdd = $row["strDeliverTo"];
		if($delAdd == '' || is_null($delAdd))
		 	$delAdd =  $row["strCSCId"];
		$responseXml .= "<deliverTo><![CDATA[" . $delAdd  .  "]]></deliverTo>\n";
		//$responseXml .= "<deliverTo><![CDATA[" . $row["strDeliverTo"]  .  "]]></deliverTo>\n";
		$responseXml .= "<commFob><![CDATA[" . $row["dblUnitPrice"]  .  "]]></commFob>\n";
		$responseXml .= "<gender><![CDATA[" . $row["strGender"]  .  "]]></gender>\n";
		$responseXml .= "<HTSdata><![CDATA[" . $row["HTSdata"]  .  "]]></HTSdata>\n";
	}
	
	$invFob = getInvFob($styleId);
	$responseXml .= "<invFob><![CDATA[" . $invFob  .  "]]></invFob>\n";
	$responseXml .= "<styleNo><![CDATA[" . $styleNo  .  "]]></styleNo>\n";
	$responseXml .= "<styleId><![CDATA[" . $styleId  .  "]]></styleId>\n";
	$responseXml .= "<orderNo><![CDATA[" . $strOrderNo  .  "]]></orderNo>\n";
	$responseXml .= "<strColor><![CDATA[" . $strColor  .  "]]></strColor>\n";
	$responseXml .= "<invoiceNo><![CDATA[" . $invoiceNo  .  "]]></invoiceNo>\n";
	$responseXml .= "<shipterm><![CDATA[" . $shipterm  .  "]]></shipterm>\n";
	$responseXml .= "<payterm><![CDATA[" . $payterm  .  "]]></payterm>\n";
	$responseXml .= "<vatRate><![CDATA[" . $vatRate  .  "]]></vatRate>\n";
	
	$str = '';
	while($rowC = mysql_fetch_array($resComInvData))
	{
		if($rowC["strInvoiceNo"] == $comInvNo)
			$str .= "<option value=\"". $rowC["strInvoiceNo"] ."\" selected=\"selected\">" . $rowC["strInvoiceNo"] ."</option>";
		else	
			$str .= "<option value=\"". $rowC["strInvoiceNo"] ."\">" . $rowC["strInvoiceNo"] ."</option>";
	}
	$responseXml .= "<comInvNo><![CDATA[" . $str  .  "]]></comInvNo>\n";
	$responseXml .='</data>';
	echo $responseXml;
}
if ($id=="confirmTaxInvoice")
{
	$invoiceID = $_GET["invoiceID"];
	
	$sql = " update firstsale_shippingdata 	set 	intTaxInvoiceConfirmBy = '$userId' , 
	dtmTaxInvoiceConfirmed = now()
	where
	dblInvoiceId = '$invoiceID' ";
	
	$result = $db->RunQuery($sql);	
	echo $result;
}

if ($id=="load_AppShipping_data")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$responseXml ='<data>';
	
	$orderNo = $_GET["orderNo"];
	$result = getAppShippingOrderData($orderNo);
	
	while($row = mysql_fetch_array($result))
	{
		$invStatus = $row["intStatus"];
		$cls = 'grid_raw_white';//($rw%2 ==0 ?'grid_raw' :'grid_raw2');
		$comInvNo = $row["strComInvNo"];
		$color = $row["strOrderColorCode"];
		$shipOrderNo = $row["strOrderNo"];
		$preOrderNo = $row["strOrderNo"];
		if($color != '')
			$preOrderNo = $preOrderNo.'-'.$color;
		$styleId = 	$row["intStyleId"];
		$invoiceID = $row["invoiceID"];
		//$strUrl  = "shippingCWS.php?id=1&invoiceID=".$row["invoiceID"];
		
		$strUrlCVWS = "cvwsReport.php?invoiceID=".$row["invoiceID"]."&styleID=".$row["intStyleId"];
		$CVWSUrlStr = "<a href=\"$strUrlCVWS \" target=\"cvwsReport.php\">".$row["strInvoiceNo"]."</a>";
		$taxStr = "<img src=\"../../images/pdf.png\" width=\"16\" height=\"16\" onclick=\"viewInvoiceRpt(".$row["invoiceID"].",".$row["intStyleId"]."); \")>";
		
		$responseXml .= "<invoiceID><![CDATA[" . $row["invoiceID"]  .  "]]></invoiceID>\n";
		$responseXml .= "<CVWSUrlStr><![CDATA[" . $CVWSUrlStr  .  "]]></CVWSUrlStr>\n";
		$responseXml .= "<taxStr><![CDATA[" . $taxStr  .  "]]></taxStr>\n";
		$responseXml .= "<preOrderNo><![CDATA[" . $preOrderNo  .  "]]></preOrderNo>\n";
		$responseXml .= "<color><![CDATA[" . $color  .  "]]></color>\n";
		
		$res = getApprovedComInvData($comInvNo,$styleId);
		$rowS = mysql_fetch_array($res);
		$responseXml .= "<SailingDate><![CDATA[" . $rowS["SailingDate"]  .  "]]></SailingDate>\n";
		$responseXml .= "<shiQty><![CDATA[" . $rowS["dblQuantity"]  .  "]]></shiQty>\n";
		$responseXml .= "<strBuyerCode><![CDATA[" . $rowS["strBuyerCode"]  .  "]]></strBuyerCode>\n";
		$responseXml .= "<comInvNo><![CDATA[" . $comInvNo  .  "]]></comInvNo>\n";
		
		$responseXml .= "<recDate><![CDATA[" . $row["recDate"]  .  "]]></recDate>\n";
		$responseXml .= "<summeryDate><![CDATA[" . $row["summeryDate"]  .  "]]></summeryDate>\n";
		if($row["intTaxInvoiceConfirmBy"] != '')
			$cls = 'grid_raw_white';
		else
			$cls = 'grid_raw_pink';
		$responseXml .= "<cls><![CDATA[" . $cls  .  "]]></cls>\n";
	}
	
	$responseXml .='</data>';
	echo $responseXml;
}
if ($id=="getStyleDetails")
{
	$orderno = $_GET["orderno"];
	$sql = " select intStyleId from orders where strOrderNo='$orderno' ";
	$result = $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	
	echo $row["intStyleId"];
}
if ($id=="checkApprovedOrderAvailable")
{
	$styleId = $_GET["styleId"];
	$ComInvNo = $_GET["ComInvNo"];
	$response='';
	$sql = " select * from firstsale_shippingdata where intStyleId='$styleId' and strComInvNo='$ComInvNo' and intStatus=1";
	$response = $db->CheckRecordAvailability($sql);
	
	echo $response;
}
if ($id=="checkOrderSendtoApproval")
{
	$styleId = $_GET["styleId"];
	$response='';
	$sql = " select * from firstsalecostworksheetheader where intStatus=1 and intStyleId='$styleId' ";
	$response = $db->CheckRecordAvailability($sql);
	
	echo $response;
}
if ($id=="checkFSCostingAvailable")
{
	$styleId = $_GET["styleId"];
	$response='N/A';
	$sql = " select * from firstsalecostworksheetheader where intStatus <> 11 and intStyleId='$styleId' ";
	$response = $db->CheckRecordAvailability($sql);
	
	echo $response;
}
function getComInvwiseOrderList($invNo)
{
	$eshipDB = new eshipLoginDB();
	
	$sql = " Select distinct strBuyerPONo 
			from commercial_invoice_detail 
			where strInvoiceNo='$invNo' ";
			
		return $eshipDB->RunQuery($sql);	
}

function getOrderwiseColorList($invNo,$orderNo)
{
	$eshipDB = new eshipLoginDB();
	
	$sql = " select plh.strColor 
			from shipmentplheader plh inner join commercial_invoice_detail cid on
			cid.strPLno = plh.strPLNo 
			 and cid.strBuyerPONo = plh.strStyle 
			where plh.strStyle='$orderNo'  and cid.strInvoiceNo ='$invNo'";
			
		return $eshipDB->RunQuery($sql);	
}

function getOrderDetails($comInvNo,$styleId)
{
	$eshipDB = new eshipLoginDB();
	
	$sql = "select splh.strProductCode,date(cih.dtmSailingDate) as SailingDate,sum(cid.dblQuantity) as dblQuantity,cih.strCarrier,
			cid.strFabric,cid.strSpecDesc as strDescOfGoods,cih.strCompanyID,cih.strBuyerID,cih.strFinalDest,
			cih.intBankId,cih.strDeliverTo,cid.dblUnitPrice,fi.strGender,cih.strCSCId,cih.strPayTerm,
			cid.strHSCode as HTSdata
			from shipmentplheader splh inner join commercial_invoice_detail cid on
			cid.strPLno = splh.strPLNo  -- and cid.strBuyerPONo = splh.strStyle 
			inner join commercial_invoice_header cih on cih.strInvoiceNo = cid.strInvoiceNo
			inner join finalinvoice fi on fi.strInvoiceNo = cih.strInvoiceNo
			where cid.strInvoiceNo ='$comInvNo'   and splh.intStyleId='$styleId' group by splh.intStyleId ";
		
		return $eshipDB->RunQuery($sql);		 
}

function getOrderwiseComInvList($styleId)
{
	$eshipDB = new eshipLoginDB();
	
	$sql = "select distinct cid.strInvoiceNo from commercial_invoice_detail cid inner join shipmentplheader slph on
slph.strPLNo = cid.strPLNo
inner join commercial_invoice_header cih on  cih.strInvoiceNo = cid.strInvoiceNo
 where slph.intStyleId='$styleId'  and cih.strInvoiceType='F'";
	//echo $sql;
	return $eshipDB->RunQuery($sql);	
}

function getOrderColor($styleId)
{
	global $db;
	
	$sql = " select strOrderColorCode from orders where intStyleId='$styleId' ";
	
	$result = $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	
	return $row["strOrderColorCode"];
	
}

function getInvFob($styleId)
{
	global $db;
	
	$sql = "select dblFOB from invoicecostingheader where intStyleId='$styleId' ";
	$result = $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	
	return $row["dblFOB"];
}

function getFdetinationCode($fdestId)
{
	$eshipDB = new eshipLoginDB();
	
	$sql = "select strCountryCode from city where strCityCode='$fdestId' ";
	$result = $eshipDB->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	
	return $row["strCountryCode"];
}

function getCompanyCode($comID)
{
	$eshipDB = new eshipLoginDB();
	
	$sql = "select strCompanyCode from customers where strCustomerID='$comID' ";
	$result = $eshipDB->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	
	return $row["strCompanyCode"];
}

function getInvoiceID($companyCode)
{
	global $db;
	
	$sql = "select dblShippingInvNo from syscontrol where intCompanyID='$companyCode' ";
	$result = $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	
	//update syscontrol
	$sql1 = " update syscontrol 
			set 
			dblShippingInvNo = dblShippingInvNo+1
			 where intCompanyID='$companyCode' ";
	$res = $db->RunQuery($sql1);	
			 
	return $row["dblShippingInvNo"];
}

function saveShippingData($styleId,$orderNo,$strColor,$invoiceId,$invoiceNo,$comInvNo,$paytermId,$shiptermId,$vatRate,$userId)
{
	global $db;
	$tdate = date('Y-m-d');
	$sql = "insert into firstsale_shippingdata 
		(intStyleId,
		strOrderNo,
		strOrderColorCode, 
		dblInvoiceId, 
		strInvoiceNo, 
		strComInvNo, 
		intPaytermId, 
		intShipmentTermId,
		dblVatRate,
		dtmDate,
		intStatus,
		intUserId
		)
		values
		('$styleId',
		'$orderNo',
		'$strColor', 
		'$invoiceId', 
		'$invoiceNo', 
		'$comInvNo', 
		'$paytermId', 
		'$shiptermId',
		'$vatRate',
		'$tdate',
		'0',
		'$userId'
		)";
		
		return $db->RunQuery($sql);	
}

function updateShippingData($styleId,$orderNo,$strColor,$invoiceId,$invoiceNo,$comInvNo,$paytermId,$shiptermId,$vatRate,$userId)
{
	global $db;
	$tdate = date('Y-m-d');
	$sql = "update firstsale_shippingdata 
			set
			intStyleId = '$styleId' , 
			strOrderNo = '$orderNo',
			strOrderColorCode = '$strColor',
			strInvoiceNo = '$invoiceNo' , 
			strComInvNo = '$comInvNo' , 
			intPaytermId = '$paytermId' , 
			intShipmentTermId = '$shiptermId',
			dblVatRate = '$vatRate',
			dtmDate = '$tdate',
			intUserId = '$userId'
			where
			dblInvoiceId = '$invoiceId' ";
		return $db->RunQuery($sql);		
			
}

function checkPendingInvAvailability($styleId,$orderNo,$strColor)
{
	global $db;
	
	$sql = " select * from firstsale_shippingdata 
where intStyleId='$styleId' and strOrderNo='$orderNo' and strOrderColorCode='$strColor'";

	return $db->CheckRecordAvailability($sql);
}

function updatePcsPerCarton($styleId,$comInvNo)
{
	global $db;
	
	$pcsPerCarton = getPCSperCarton($styleId,$comInvNo);
	
	$sql = "update firstsalecostworksheetheader 
			set
			dblPCScarton = '$pcsPerCarton'  	
			where
			intStyleId = '$styleId' ";
	$res = $db->RunQuery($sql);
}

function getPCSperCarton($styleId,$comInvNo)
{
	$eshipDB = new eshipLoginDB();
	
	$sql = " SELECT cid.dblQuantity/cid.intNoOfCTns as pcsPerCarton
			FROM commercial_invoice_detail cid inner join shipmentplheader plh on
			plh.strPLNo = cid.strPLno 
			WHERE cid.strInvoiceNo = '$comInvNo' AND plh.intStyleId = '$styleId' ";
			
		$result = $eshipDB->RunQuery($sql);	
		
		$row = mysql_fetch_array($result);
		
		return round($row["pcsPerCarton"],0);		
}

function updateCWSpackingMaterialConpc($styleId,$orderNo,$strColor,$comInvNo)
{
	global $db;
	$packingMatConpc = getPackingMtConpc($orderNo,$strColor,$comInvNo);
	
	$fieldName = 'packingMaterialID';
	$packingSubCat_list = getSelectedSubID($fieldName);
	
	$sql_cwsDetails = "select fsd.intMatDetailID,fsd.dblUnitPrice
				from firstsalecostworksheetdetail fsd inner join matitemlist m on
				m.intItemSerial = fsd.intMatDetailID
				where fsd.strType=2 and fsd.intStyleId='$styleId' and m.intSubCatID in ($packingSubCat_list) ";
		
		$result = $db->RunQuery($sql_cwsDetails);
		
		while($row = mysql_fetch_array($result))
		{
			$value = round(($packingMatConpc*$row["dblUnitPrice"]),4);
			updatePackingMaterialData($styleId,$packingMatConpc,$value,$row["intMatDetailID"]);
		}
	
}

function getPackingMtConpc($orderNo,$strColor,$comInvNo)
{
	$eshipDB = new eshipLoginDB();
	
	$sql = " SELECT cid.intNoOfCTns/cid.dblQuantity as pckingConpc
			FROM commercial_invoice_detail cid inner join shipmentplheader plh on
			plh.strPLNo = cid.strPLno and plh.strStyle = cid.strBuyerPONo
			WHERE cid.strInvoiceNo = '$comInvNo' AND cid.strBuyerPONo = '$orderNo' ";
		
		if($strColor != '')
			$sql .= " and plh.strColor='$strColor'";
		$result = $eshipDB->RunQuery($sql);	
		
		$row = mysql_fetch_array($result);
		
		return round($row["pckingConpc"],4);	
}

function updatePackingMaterialData($styleId,$packingMatConpc,$value,$matDetailID)
{
	global $db;
	
	$sql = "update firstsalecostworksheetdetail 
		set
		reaConPc = '$packingMatConpc' , 
		dblValue = '$value' 
		where
		intStyleId = '$styleId' and intMatDetailID = '$matDetailID' ";
	
	$result = $db->RunQuery($sql);
}

function getSelectedSubID($fieldName)
{
	global $db;
	
	$sql = "select strValue from firstsale_settings where strFieldName='$fieldName' ";
	
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	$hangerIdList = $row["strValue"];
	$arr_hangerList = array();
	$hangeID = explode(",",$hangerIdList);
	$loop=0;
	foreach($hangeID as $value)
	{
		$arr_hangerList[$loop] ="'" . $value . "'";
		$loop++;
	}
		
	
	$hangerID_List = implode(",",$arr_hangerList);
	
	return $hangerID_List;
}

function getPendingShipData($invID)
{
	global $db;
	
	$sql = "select fs.intStyleId,fs.strOrderNo,fs.strOrderColorCode,fs.strInvoiceNo,
fs.strComInvNo,fs.intPaytermId,fs.intShipmentTermId,fs.dblVatRate,o.strStyle
from firstsale_shippingdata fs inner join orders o on
o.intStyleId = fs.intStyleId where fs.dblInvoiceId='$invID' ";
			 
		 
	return $db->RunQuery($sql);		 
	
}
function updateOtherPackingConpc($styleId,$buyerID)
{
	
	$chkHangerAv = checkHangerAvailability($styleId);
	$packingCost = getPackingMaterialCost($styleId,$buyerID);
	
	$fieldName = 'intOtherPackingMaterialID';
	$otherPackingID = getSelectedSubID($fieldName);
	if($chkHangerAv == 1)
		$otherPackingCost = 2/12- $packingCost;
	else
		$otherPackingCost = 1.5/12- $packingCost;	
		
	updateOtherPackingValue($styleId,$otherPackingID,$otherPackingCost);		
}

function checkHangerAvailability($styleId)
{
	global $db;
	$fieldName = 'intHangerId';
	$hangerSubCatList = getSelectedSubID($fieldName);
	$sql = "select o.intMatDetailID 
			from orderdetails o inner join matitemlist m on 
			m.intItemSerial = o.intMatDetailID 
			where o.intStyleId='$styleId' and m.intSubCatID in ($hangerSubCatList)";
	
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	$retVal =1;
	if ($row["intMatDetailID"] == '' || is_null($row["intMatDetailID"]))
		$retVal =0;
	//echo $retVal;
	return $retVal;
}

function getPackingMaterialCost($styleId,$buyerID)
{
	global $db;
	$fieldName = 'packingMaterialID';
	$packingSubCat_list = getSelectedSubID($fieldName);
	$totValue = 0;
	$sql = "select fsd.dblValue
				from firstsalecostworksheetdetail fsd inner join matitemlist m on
				m.intItemSerial = fsd.intMatDetailID
				where fsd.strType=2 and fsd.intStyleId='$styleId' and m.intSubCatID in ($packingSubCat_list) ";
	
	$result = $db->RunQuery($sql);			
	while($row = mysql_fetch_array($result))
	{
		$totValue += $row["dblValue"];
	} 
	
	return $totValue;			
}

function updateOtherPackingValue($styleId,$otherPackingID,$otherPackingCost)
{
	global $db;
	$sql = "update firstsalecostworksheetdetail 
		set
		dblUnitPrice = '$otherPackingCost',
		dblValue = '$otherPackingCost' 
		where
		intStyleId = '$styleId' and intMatDetailID = $otherPackingID ";
	
	$result = $db->RunQuery($sql);
	
}
function getStyleName($styleId)
{
	global $db;
	
	$sql = "select strStyle from orders where intStyleId='$styleId' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["strStyle"];
}
function getBuyerCode($styleId)
{
	global $db;
	$sql = "select b.buyerCode from buyers b inner join orders o on o.intBuyerID= b.intBuyerID
where o.intStyleId='$styleId' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["buyerCode"];
}
function getStyleId($orderNo)
{
	global $db;
	
	$sql = "select intStyleId from firstsale_shippingdata where strOrderNo='$orderNo' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["intStyleId"];
}
function getAppShippingOrderData($orderNo)
{
	global $db;
	$sql = "Select  fsship.intStyleId,fsship.strOrderNo,fsship.strOrderColorCode,
					fsship.dblInvoiceId as invoiceID,fsship.strInvoiceNo,fsship.strComInvNo,fsship.dtmDate as summeryDate,
					fsh.dtmDate as recDate,fsship.intStatus,fsship.intTaxInvoiceConfirmBy
					from firstsale_shippingdata fsship inner join firstsalecostworksheetheader fsh on
					fsship.intStyleId = fsh.intStyleId 
					where fsship.intStatus =1 ";
		if($orderNo !='')
			$sql .= " and fsship.strOrderNo = '$orderNo' ";			
		$sql .= "order by fsship.dblInvoiceId";
		
		return $db->RunQuery($sql);
}

function getApprovedComInvData($comInvNo,$styleId)
{
	$eshipDB = new eshipLoginDB();
	$sql_ship_data = "select date(cih.dtmSailingDate) as SailingDate,sum(cid.dblQuantity) as dblQuantity,b.strBuyerCode
			from shipmentplheader splh inner join commercial_invoice_detail cid on
			cid.strPLno = splh.strPLNo  -- and cid.strBuyerPONo = splh.strStyle 
			inner join commercial_invoice_header cih on cih.strInvoiceNo = cid.strInvoiceNo
			inner join buyers b on b.strBuyerID = cih.strBuyerID
			where cid.strInvoiceNo ='$comInvNo'   and splh.intStyleId = '$styleId' group by splh.intStyleId ";
			 		
			 return  $eshipDB->RunQuery($sql_ship_data);
}

function getShippingInvoiceNo($styleId,$comInvNo)
{
	global $db;
	$sql = " select strInvoiceNo from firstsale_shippingdata where intStyleId='$styleId' and strComInvNo='$comInvNo' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["strInvoiceNo"];
}
function getFSInvoiceNo($styleId)
{
	global $db;
	$sql = " select dblInvoiceId from firstsalecostworksheetheader where intStyleId='$styleId' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);

	return $row["dblInvoiceId"];
}
function updateFSInvoiceNo($styleId,$invoiceId)
{
	global $db;
	$sql = " update firstsalecostworksheetheader set dblInvoiceId='$invoiceId' where intStyleId='$styleId' ";
	$result = $db->RunQuery($sql);
}
?>