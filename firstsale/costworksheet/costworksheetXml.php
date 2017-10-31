<?php 
session_start();
//$backwardseperator = "../../";
include "../../Connector.php";
include '../../eshipLoginDB.php';

//-------------Costworksheet status-----------------------------
//0-pending
//1-send to approval
//10-confirm
//11-cancel
//--------------------------------------------------------------
$id=$_GET["id"];
$userId		= $_SESSION["UserID"];
$intCompanyId =$_SESSION["FactoryID"];
if ($id=="load_ord_str")
{
	$sql="select o.strOrderNo
from orders o inner join invoicecostingheader inh on
inh.intStyleId = o.intStyleId
where inh.intStatus=1 and inh.intStyleId not in (select intStyleId from firstsalecostworksheetheader)";
		
			$results=$db->RunQuery($sql);
			//$po_arr = "|";
			while($row=mysql_fetch_array($results))
			{
				$po_arr.= $row['strOrderNo']."|";
				 
			}
			echo $po_arr;
}
if($id=="checkFileUploaded")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "<Result>\n";
	$styleId = $_GET["styleId"];
	$folder ="../../upload files/cws/".$styleId."/BPO";
	
		if(count(glob("$folder/*")) === 0)
			$ResponseXML .= "<checkUpload><![CDATA[False]]></checkUpload>\n";
		else
			$ResponseXML .= "<checkUpload><![CDATA[True]]></checkUpload>\n";
	
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}
if ($id=="load_style_str")
{
	$sql="SELECT strStyle 
	FROM invoicecostingheader I INNER JOIN orders O ON 
	O.intStyleId = I.intStyleId
	ORDER BY strStyle";
		
			$results=$db->RunQuery($sql);
			//$po_arr = "|";
			while($row=mysql_fetch_array($results))
			{
				$po_arr.= $row['strStyle']."|";
				 
			}
			echo $po_arr;
}

if ($id=="load_ord_data")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$responseXml ='<data>';
	
	$orderNo = $_GET["orderNo"];
	$buyerId = $_GET["buyerId"];
	$styleId = $_GET["styleId"];
	
	$sql = "(select id.reaConPc,id.dblUnitPrice,mil.strItemDescription,MSC.StrCatName,
	mil.strUnit,mil.intItemSerial,id.reaWastage,mil.intMainCatID,mil.intSubCatID,id.reaConPc
	from invoicecostingdetails id 
	inner join matitemlist mil on id.strItemCode = mil.intItemSerial
	inner join invoicecostingheader ih on ih.intStyleId = id.intStyleId
	inner join matsubcategory MSC on MSC.intSubCatNo=mil.intSubCatID
	where ih.intStyleId='$styleId')
	union 
	(
	select 0,0,m.strItemDescription,MSC.StrCatName,	m.strUnit,m.intItemSerial,0,m.intMainCatID,m.intSubCatID,0
	from firstsalecompulsaryitem f inner join matitemlist m on m.intItemSerial = f.intmatdetailId
	inner join matsubcategory MSC on MSC.intSubCatNo=m.intSubCatID
	)
	union 
	(
	select o.reaConPc,o.dblUnitPrice,m.strItemDescription,ms.StrCatName,m.strUnit, m.intItemSerial,o.reaWastage,m.intMainCatID,m.intSubCatID,o.reaConPc 
	from orderdetails o inner join matitemlist m on 
	o.intMatDetailID = m.intItemSerial
	inner join matsubcategory ms on ms.intSubCatNo = m.intSubCatID
	 where o.intStyleId='$styleId' and   m.intSubCatID not in
	 (select mil.intSubCatID from invoicecostingdetails ID inner join matitemlist mil on
	 ID.strItemCode = mil.intItemSerial where ID.intStyleId='$styleId')
	)
	order by intMainCatID,strItemDescription ";
	
	$materialCost =0;
	$accCost =0;
	$hanger=0;
	$belts =0;
	$transportCost =0;
	$cmpwCost =0;
	
	$results=$db->RunQuery($sql);
	while($row=mysql_fetch_array($results))
		{
			$conPcFormulaId = '';
			$unitPriceFormulaId = '';
			$mainCatid = '';
			$descriptionType = '';
			$canDeleteItem = 1;
			$displayItem =1;
			 //0- can't delete item if item grn or leftover allocation or inter job transfer, 1- can delete 
			$responseXml .= "<itemID><![CDATA[" . $row["intItemSerial"]  . "]]></itemID>\n";
			$responseXml .= "<unit><![CDATA[" . $row["strUnit"]  . "]]></unit>\n";
			
			$subCategoryName = $row["StrCatName"];			
			$itemDescription = $row["strItemDescription"]; 
			$subCategoryID = $row["intSubCatID"];	 
			
			
			//get first sale fomula allocation details
			$resFs = getFormulaDetails($buyerId,$row["intItemSerial"]);
			while($rwFs = mysql_fetch_array($resFs))
			{
				$conPcFormulaId = $rwFs["intConPcFormulaId"];
				$unitPriceFormulaId = $rwFs["intUnitPriceFormulaId"];
				$mainCatid = $rwFs["intMainCatID"];
				$descriptionType = $rwFs["intType"];
				$displayItem = $rwFs["intDisplayItem"];
				$isOtherPackItem = $rwFs["intOtherPacking"];
			}
			$responseXml .= "<displayItem><![CDATA[" . $displayItem . "]]></displayItem>\n";
			//echo $row["intItemSerial"].'-'.$conPcFormulaId.'\n;';
			if($descriptionType == 0)
				$itemDescription = $row["StrCatName"];
			
			$conPc = conPcCalculation($row["reaConPc"],$conPcFormulaId,$row["reaWastage"],$orderNo,$styleId,$row["intItemSerial"]);
			$responseXml .= "<conPC><![CDATA[" . number_format($conPc,4)  . "]]></conPC>\n";
			
			
			$unitPrice = unitPriceCalculation($styleId,$row["intItemSerial"],$unitPriceFormulaId,$row["dblUnitPrice"],$descriptionType,$subCategoryID,$buyerId);
			$responseXml .= "<unitPrice><![CDATA[" . number_format($unitPrice,4)  . "]]></unitPrice>\n";
			
			$perPcsValue = round($conPc*$unitPrice,4);
			//negative value wont add to the total cost -(other packing cost might be negative value)
			if($perPcsValue<0)
				$perPcsValue=0;
			$responseXml .= "<PcsValue><![CDATA[" . number_format($perPcsValue,4)  . "]]></PcsValue>\n";
			
			$responseXml .= "<itemDetail><![CDATA[" . $itemDescription . "]]></itemDetail>\n";
			$responseXml .= "<categoryId><![CDATA[" . $mainCatid  .  "]]></categoryId>\n";
			
			//if item not display in the cws wont add to material cost
			if($displayItem==0)
				$perPcsValue =0;
			//Description Id 
			//1- material, 2-Accessories, 3-hanger, 4-belts, 5-transport, 6-cmpw
			switch($mainCatid)
			{
				case 1:
				{
					$materialCost += $perPcsValue;
					$descriptionId =1;
					break;
				}
				case 2:
				{
					$accCost += $perPcsValue;
					$descriptionId =2;	
					break;
					 
				}
				case 3:
				{
					$transportCost += $perPcsValue;
					$descriptionId =3;
					
					break;
				}
				case 4:
				{
					$cmpwCost += $perPcsValue;	
					$descriptionId =4;
					break;
				}
				case 5:
				{
					$hanger += $perPcsValue;
					$descriptionId =5;
					break;
				}
				case 6:
				{
					$belts += $perPcsValue;
					$descriptionId =6;
					break;
				}
			}
			
			$responseXml .= "<decriptionID><![CDATA[" . $descriptionId  .  "]]></decriptionID>\n";
			
			$canDeleteSubCat = checkCanDeleteSubCategory($subCategoryID);
			
			
			if($unitPrice >0)
				$canDeleteItem=0;
			
			if($canDeleteSubCat>0)	
				$canDeleteItem=1;
			//2011-06-06----------------------------check availability of leftover and interjob transfer -------
			$checkLeftAlloAv = checkLeftoverAvailability($styleId,$row["intItemSerial"]);
			$chkInterjobTransferAv = checkInterjobTransferAvailability($styleId,$row["intItemSerial"]);
			
			if($unitPrice == 0 &&($checkLeftAlloAv ==1||$chkInterjobTransferAv==1))
				$canDeleteItem=0;
			
			$responseXml .= "<canDeleteItem><![CDATA[" . $canDeleteItem  .  "]]></canDeleteItem>\n";
			
			$color = 'bcgcolor-tblrowWhite';
			if($checkLeftAlloAv ==1)
				$color = 'bcgcolor-leftAllo';
			if($chkInterjobTransferAv ==1)
				$color = 'bcgcolor-interjobAllo';
			//check item in invoice costing
			
			$chkInvItem = checkInvoiceCostItem($styleId,$row["intItemSerial"]);
			if($chkInvItem ==1)
				$color = 'bcgcolor-onlyPreorderItem';
			//fiest sale formula not allocated	
			if($mainCatid == '')
				$color = 'bcgcolor-InvoiceCostICNA';			
			$responseXml .= "<bgcolor><![CDATA[" . $color  .  "]]></bgcolor>\n";
						
			//check item in other packing - 2011-08-11
			$responseXml .= "<OtherPackItem><![CDATA[" . $isOtherPackItem  .  "]]></OtherPackItem>\n";
			//end  check item in other packing
		}
		$totCostpcs = $materialCost+$hanger+$belts+$accCost+$transportCost+$cmpwCost;
		$responseXml .= "<matCost><![CDATA[" . number_format($materialCost,4)  . "]]></matCost>\n";
		$responseXml .= "<hangerCost><![CDATA[" . number_format($hanger,4)  . "]]></hangerCost>\n";
		$responseXml .= "<beltsCost><![CDATA[" . number_format($belts,4)  . "]]></beltsCost>\n";
		$responseXml .= "<accCost><![CDATA[" . number_format($accCost,4)  . "]]></accCost>\n";
		$responseXml .= "<transportCost><![CDATA[" . number_format($transportCost,4)  . "]]></transportCost>\n";
		$responseXml .= "<cmpwCost><![CDATA[" . number_format($cmpwCost,4)  . "]]></cmpwCost>\n";
		$responseXml .= "<totCostpcs><![CDATA[" . number_format($totCostpcs,4)  . "]]></totCostpcs>\n";
		$responseXml.='</data>';
	echo $responseXml;
}
if ($id=="load_ordHeader_data")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$responseXml ='<data>';
	
	$orderNo = $_GET["orderNo"];
	
	/*$arrShipmentDetails =  getPCSperCarton($orderNo);
	$shipmentDet = explode('/',$arrShipmentDetails);
	$PCSperCarton = $shipmentDet[0];
	$shipQty = $shipmentDet[1];*/
	
	$sql = "select o.intBuyerID,o.intQty,o.strStyle,o.reaSMV,o.reaSMVRate,o.reaFOB,ih.dblTotalCostValue,
o.intStyleId,date(o.dtmDate) as orderDate,ih.dblFOB as invFob,o.strOrderColorCode,ih.dblNewCM
			from orders o inner join  invoicecostingheader ih on
			ih.intStyleId = o.intStyleId 
			where o.strOrderNo='$orderNo' and ih.intStatus= 1 ";
		//echo $sql;	
		$results=$db->RunQuery($sql);
	$FsCostingAv = 2;
	$chkinvAv =2;	
	while($row=mysql_fetch_array($results))
		{
			$invFOB = $row["reaFOB"]; 
			$buyerInvFob = getBuyerInvFOBStatus($row["intBuyerID"]);
			if($buyerInvFob == '1')
				$invFOB = $row["dblTotalCostValue"]; 
			$responseXml .= "<styleId><![CDATA[" . $row["intStyleId"]  . "]]></styleId>\n";
			$responseXml .= "<buyerId><![CDATA[" . $row["intBuyerID"]  . "]]></buyerId>\n";
			$responseXml .= "<orderQty><![CDATA[" . $row["intQty"]  . "]]></orderQty>\n";
			$responseXml .= "<style><![CDATA[" . $row["strStyle"]  . "]]></style>\n";
			$responseXml .= "<smv><![CDATA[" . $row["reaSMV"]  . "]]></smv>\n";
			$responseXml .= "<smvRate><![CDATA[" . $row["reaSMVRate"]  . "]]></smvRate>\n";
			$responseXml .= "<fob><![CDATA[" . $row["reaFOB"]  . "]]></fob>\n";
			$responseXml .= "<orderDate><![CDATA[" . $row["orderDate"]  . "]]></orderDate>\n";
			$responseXml .= "<invFob><![CDATA[" . $invFOB  . "]]></invFob>\n";
			//$responseXml .= "<noOfCarton><![CDATA[" . $PCSperCarton  . "]]></noOfCarton>\n";
			$responseXml .= "<colorCode><![CDATA[" . $row["strOrderColorCode"]  . "]]></colorCode>\n";
			$responseXml .= "<dblNewCM><![CDATA[" . $row["dblNewCM"]  . "]]></dblNewCM>\n";
			
			$chkFsCostingAv = checkFirstSaleCostingAvailable($row["intStyleId"]);
			$chkinvAv = checkPendingInvoiceCostingAv($row["intStyleId"]);
			
		}
		$responseXml .= "<chkFsCostingAv><![CDATA[" . $chkFsCostingAv  . "]]></chkFsCostingAv>\n";	
		$responseXml .= "<chkinvAv><![CDATA[" . $chkinvAv  . "]]></chkinvAv>\n";	
			
	
	$responseXml.='</data>';
	echo $responseXml;
}

if($id=="saveCostHeader")
{
	$orderNo  = $_GET["orderNo"];
	$styleId  = $_GET["styleId"];
	$buyerFOB = $_GET["buyerFOB"];
	$orderQty = $_GET["orderQty"];
	$txtSMV   = $_GET["txtSMV"];
	$txtpcsCarton = $_GET["txtpcsCarton"];
	$txtCMV  = $_GET["txtCMV"];
	$txtOTLdate = $_GET["txtOTLdate"];
	$txtOrderDate = $_GET["txtOrderDate"];
	$txtFacDate = $_GET["txtFacDate"];
	$txtPreorderFob = $_GET["txtPreorderFob"];
	$txtInvFOB = $_GET["txtInvFOB"];
	$strColor  = $_GET["strColor"];
	$fsaleFob = $_GET["fsaleFob"];
	$reqApparelApprov = $_GET["reqApparelApprov"];
	
	if($txtOTLdate == '')
		$txtOTLdate = '0000-00-00';
	
	if($txtOrderDate == '')
		$txtOrderDate = '0000-00-00';
		
	if($txtFacDate == '')
		$txtFacDate = '0000-00-00';
	$ckStyleAv = checkPengingCostWSavailability($styleId);
	
	if(trim($txtpcsCarton) == '' || is_null($txtpcsCarton))
		$txtpcsCarton=0;
		
	if(trim($buyerFOB) == '' || is_null($buyerFOB))
		$buyerFOB=0;
	
	$strOrderNo = $orderNo;
	if($strColor != '')
	{
		$colorLen = strlen($strColor)+1;
		$strOrderNo = substr($orderNo,0,($colorLen*-1));
	}
			
	if($ckStyleAv == '1')
	{
		$result = updateCostWSheaderData($strOrderNo,$styleId,$buyerFOB,$orderQty,$txtSMV,$txtpcsCarton,$txtCMV,$txtOTLdate,$txtOrderDate,$txtFacDate,$txtPreorderFob,$txtInvFOB,$strColor,$fsaleFob,$reqApparelApprov);
		
		deleteCostWSdata($styleId);
	}
	else
	{
		$result = insertCostHeaderData($strOrderNo,$styleId,$buyerFOB,$orderQty,$txtSMV,$txtpcsCarton,$txtCMV,$txtOTLdate,$txtOrderDate,$txtFacDate,$txtPreorderFob,$txtInvFOB,$strColor,$fsaleFob,$reqApparelApprov);
	}
			
	
	
	if($result == '1')
		echo true;
	else
		echo false;
}

if($id=="saveCostDetails")
{
	$styleId  = $_GET["styleId"];
	$matDetailID = $_GET["matDetailID"];
	$matDetailDes = $_GET["matDetailDes"];
	$unitPrice = $_GET["unitPrice"];
	$conPc = $_GET["conPc"];
	$value = $_GET["value"];
	$categoryId = $_GET["categoryId"];
	
	$chkRecAv = checkCWSdetailsAvailability($styleId,$matDetailID);
	if($chkRecAv == 1)
		$result = updateCWSdetails($styleId,$matDetailID,$matDetailDes,$unitPrice,$conPc,$value,$categoryId);
	else
		$result = insertCostDetailData($styleId,$matDetailID,$matDetailDes,$unitPrice,$conPc,$value,$categoryId);
	
	if($result == '1')
		echo true;
	else
		echo false;
}
if($id=="load_costwsPending_HeaderData")
{
	
	$styleId = $_GET["styleId"];
	$invoiceID = $_GET["invoiceID"];
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$responseXml ='<data>';
	
	$result = getPendingCostWSData($styleId);
	while($row=mysql_fetch_array($result))
		{
			$responseXml .= "<styleId><![CDATA[" . $row["intStyleId"]  . "]]></styleId>\n";
			$responseXml .= "<strOrderNo><![CDATA[" . $row["strOrderNo"]  . "]]></strOrderNo>\n";
			$responseXml .= "<colorCode><![CDATA[" . $row["strColor"]  . "]]></colorCode>\n";
			$responseXml .= "<buyerId><![CDATA[" . $row["intBuyerID"]  . "]]></buyerId>\n";
			$responseXml .= "<orderQty><![CDATA[" . $row["intOrderQty"]  . "]]></orderQty>\n";
			$responseXml .= "<style><![CDATA[" . $row["strStyle"]  . "]]></style>\n";
			$responseXml .= "<smv><![CDATA[" . $row["dblSMV"]  . "]]></smv>\n";
			$responseXml .= "<noOfCarton><![CDATA[" . round($row["dblPCScarton"],2)  . "]]></noOfCarton>\n";
			$responseXml .= "<smvRate><![CDATA[" . $row["reaSMVRate"]  . "]]></smvRate>\n";
			$responseXml .= "<invFob><![CDATA[" . $row["dblInvFob"]  . "]]></invFob>\n";
			$responseXml .= "<preorderfob><![CDATA[" . $row["dblPreorderFob"]  . "]]></preorderfob>\n";
			$responseXml .= "<buyerFob><![CDATA[" . $row["buyerFOB"]  . "]]></buyerFob>\n";
			$responseXml .= "<CMvalue><![CDATA[" . $row["dblCMvalue"]  . "]]></CMvalue>\n";
			$responseXml .= "<OTLPoDate><![CDATA[" . $row["dtmOTLdate"]  . "]]></OTLPoDate>\n";
			$responseXml .= "<BuyerPoDate><![CDATA[" . $row["dtmBPOdate"]  . "]]></BuyerPoDate>\n";
			$responseXml .= "<exFacDate><![CDATA[" . $row["dtmExFactorydate"]  . "]]></exFacDate>\n";
			$responseXml .= "<isApparelAppReq><![CDATA[" . $row["intExtraApprovalRequired"]  . "]]></isApparelAppReq>\n";
			
		}
	if($invoiceID !=1)
		$consignee = getBuyerConsigneeID($styleId,$invoiceID);	
	else		
		$consignee = '';	
	
	$responseXml .= "<consignee><![CDATA[" . $consignee  . "]]></consignee>\n";	
	$responseXml.='</data>';
	echo $responseXml;	
}

if($id=="load_pendingCostWS_details")
{
	
	$styleId = $_GET["styleId"];
	$buyer = $_GET["buyer"];
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$responseXml ='<data>';
	
	$result = getPendingCostWSdetails($styleId,$buyer);
	while($row=mysql_fetch_array($result))
		{
			$canDeleteItem=1;
			$responseXml .= "<itemID><![CDATA[" . $row["intMatDetailID"]  . "]]></itemID>\n";
			$responseXml .= "<unit><![CDATA[" . $row["strUnit"]  . "]]></unit>\n";
			
			$subCategoryName = $row["StrCatName"];
			$descriptionType = $row["intType"];
			
			$itemDescription = $row["strItemDescription"]; 
			/*if($descriptionType == 0)
				$itemDescription = $row["StrCatName"];*/
				
			$subCategoryID = $row["intSubCatID"];	 
			$responseXml .= "<itemDetail><![CDATA[" . $itemDescription . "]]></itemDetail>\n";
			
			$mainCatid = $row["strType"];
			$responseXml .= "<categoryId><![CDATA[" . $mainCatid  .  "]]></categoryId>\n";
			/*$conPcFormulaId = $row["intConPcFormulaId"];
			
			$conPc = conPcCalculation($row["reaConPc"],$conPcFormulaId,$row["reaWastage"],$orderNo);*/
			$responseXml .= "<conPC><![CDATA[" . number_format($row["reaConPc"],4)  . "]]></conPC>\n";
			
			/*$unitPriceFormulaId = $row["intUnitPriceFormulaId"];
			$unitPrice = unitPriceCalculation($styleId,$row["intItemSerial"],$unitPriceFormulaId,$row["dblUnitPrice"],$descriptionType,$subCategoryID,$buyerId);*/
			$responseXml .= "<unitPrice><![CDATA[" . number_format($row["dblUnitPrice"],4)  . "]]></unitPrice>\n";
			
			$perPcsValue = $row["dblValue"];
			$responseXml .= "<PcsValue><![CDATA[" . number_format($perPcsValue,4)  . "]]></PcsValue>\n";
			
			
			$descriptionId = $mainCatid;
			$responseXml .= "<decriptionID><![CDATA[" . $descriptionId  .  "]]></decriptionID>\n";
			
			//load first sale category
			$str = '';
			$res = getMainCategoryDetails();
			$str .= "<select name=\"cboAllocate\" id=\"cboAllocate\" style=\"width:80px\" onchange=\"AllocateFSCategory(this);\">";
			$str .=  "<option value="."null".">".""."</option>";
			while($rw = mysql_fetch_array($res))
			{
				if($rw["intCategoryId"] == $mainCatid)
					$str .= "<option selected=\"selected\" value=\"". $rw["intCategoryId"] ."\">" . trim($rw["intCategoryName"]) ."</option>" ;	
				else			
					$str .= "<option value=\"". $rw["intCategoryId"] ."\">" . $rw["intCategoryName"] ."</option>";
			}
			$str .= "</select> ";
			
			$responseXml .= "<FScategory><![CDATA[" . $str  .  "]]></FScategory>\n";
			//end load first sale category
			$unitPrice = $row["dblUnitPrice"];
			$canDeleteSubCat = checkCanDeleteSubCategory($subCategoryID);
			
			if($unitPrice >0)
				$canDeleteItem=0;
			if($canDeleteSubCat>0)
				$canDeleteItem=1;	
			
			//2011-06-06----------------------------check availability of leftover and interjob transfer -------
			$checkLeftAlloAv = checkLeftoverAvailability($styleId,$row["intMatDetailID"]);
			$chkInterjobTransferAv = checkInterjobTransferAvailability($styleId,$row["intMatDetailID"]);
			
			if($unitPrice == 0 &&($checkLeftAlloAv ==1||$chkInterjobTransferAv==1))
				$canDeleteItem=0;
							
			$responseXml .= "<canDeleteItem><![CDATA[" . $canDeleteItem  .  "]]></canDeleteItem>\n";
			
			$color = 'bcgcolor-tblrowWhite';
			if($checkLeftAlloAv ==1)
				$color = 'bcgcolor-leftAllo';
			if($chkInterjobTransferAv ==1)
				$color = 'bcgcolor-interjobAllo';
			//check item in invoice costing
			//$chkInvItem=0;
			$chkInvItem = checkInvoiceCostItem($styleId,$row["intMatDetailID"]);
			//echo $chkInvItem;
			if($chkInvItem ==1)
			{
				$color='';
				$color = 'bcgcolor-onlyPreorderItem';
			}
						
			$responseXml .= "<bgcolor><![CDATA[" . $color  .  "]]></bgcolor>\n";
			$responseXml .= "<OtherPackItem><![CDATA[" . $row["intOtherPacking"]  .  "]]></OtherPackItem>\n";
		}
	$responseXml.='</data>';
	echo $responseXml;	
}
if($id=="SendtoAppCWS")
{
	
	$styleId = $_GET["styleId"];
	$reqApparelApprov = $_GET["reqApparelApprov"];
	$OCno = 'Null';	

	if($reqApparelApprov ==1)
	{
		$OCNoAvailable = gatOrderContractDetails($styleId);
		$rowO = mysql_fetch_array($OCNoAvailable);
		
		if($rowO["dblOrderContractNo"] == '')
		{
			$buyerCode = getBuyerCode($styleId);
			$countryCode = getCountryCode($styleId);
			$comanyCode = getManufactureCompany($styleId);
			$OCno = getOrderContractNo($intCompanyId);
			$tdate = date('y-m-d');
			$arrDate = explode('-',$tdate);
		
			$strOrderContractNo = $buyerCode.'/'.$countryCode.'/'.$comanyCode.'/'.'PO/'.$OCno.'/'.$arrDate[1].'/'.$arrDate[0];
		}
		else
		{
			$OCno = $rowO["dblOrderContractNo"];
			$strOrderContractNo = $rowO["strOrderContractNo"];
		}
		
	}
	$intStatus=1;
	if($reqApparelApprov ==1 && $OCno =='')
		echo 'Order Contract not generated. Saved failed';
	else	
		$res = updateCWSstatus($styleId,$intStatus,$reqApparelApprov,$OCno,$strOrderContractNo);
	echo $res;
}
if($id=="ApproveCWS")
{
	
	$styleId = $_GET["styleId"];
	$invID = $_GET["invID"];
	$intStatus = 10;
	$reason = '';
	$type='';
	
	$cwsAppStatus = getCWSApprovalStatus($styleId);
	/*
		update the firstsalecostworksheetheader, when order send to approval
		if order <> ship Qty generate another invoce from shippig department
		newly generated invoice doesn't need update the firstsalecostworksheetheader becoz order already updated
	*/
	if($cwsAppStatus == 1)
		$res = updateCWSDataStatus($styleId,$invID,$intStatus,$userId,$reason,$type);
	$result = updateShippingCWSstatus($styleId,$invID);
	echo $result;
}
if($id=="RejectCWS")
{
	
	$styleId = $_GET["styleId"];
	$invID = $_GET["invID"];
	$intStatus = 0;
	$reason = $_GET["reason"];
	$type = $_GET["type"];
	$res = updateCWSDataStatus($styleId,$invID,$intStatus,$userId,$reason,$type);
	echo $res;
}

if ($id=="calOTLDate")
{
	$buyerPODate = $_GET["buyerPODate"];
	$arrBPOdate = explode('-',$buyerPODate);
	$buyerPOday = $arrBPOdate[2];
	
	$OTLday = $arrBPOdate[2]+5;
	$OTLmonth = $arrBPOdate[1];
	$OTLYear  =$arrBPOdate[0]; 
	$DaysInMonth = cal_days_in_month(CAL_GREGORIAN, $arrBPOdate[1] ,$arrBPOdate[0]);
	
		
	for($i=$buyerPOday;$i<=$OTLday;$i++)
		{
			
			$d=$i;
			if($i<10)
				$d='0'.$i;
			
			if($i>$DaysInMonth)	
			{
				if($arrBPOdate[1] != 12)
				{
					$OTLmonth =$arrBPOdate[1]+1;
				}	
				else
				{
					$OTLmonth = '01';
					$OTLYear =$arrBPOdate[0]+1;
				}
				$d = $i-$DaysInMonth;
				
				$otlDate = $OTLYear.'-'.$OTLmonth.'-'.'0'.$d;
				$strDate = $OTLmonth.'/'.$d.'/'.$OTLYear;
			}	
			else
			{
				$otlDate = $arrBPOdate[0].'-'.$arrBPOdate[1].'-'.$d;
				$strDate = $arrBPOdate[1].'/'.$d.'/'.$arrBPOdate[0];
			} 
				
			$strDay = date("l", strtotime($strDate));
			//echo $OTLday.'</br>';
			$chkDateAv = checkDateAvailability($otlDate);
			
			if($chkDateAv == '1')
				$OTLday++;
			
			if($strDay == 'Sunday')	
				$OTLday++;
				
				
		}
		echo $otlDate;
			
}
if ($id=="RemoveFile")
{
	$url	= $_GET["url"];
	$fh = fopen($url, 'a');
	fclose($fh);	
	unlink($url);
}
if($id=="loadSubcategoryDetails")
{

	header('Content-Type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<XMLLoadOrdersubcat>\n";
$mainStoreID	= $_GET["mainStoreID"];
$styleId		= $_GET["styleId"];
$str = '';
	$sql="select distinct MSC.intSubCatNo,MSC.StrCatName from matsubcategory MSC 
inner join matitemlist MIL on  MIL.intSubCatID=MSC.intSubCatNo
inner join orderdetails OD on OD.intMatDetailID=MIL.intItemSerial
where OD.intStyleId=$styleId and MIL.intMainCatID ='$mainStoreID'  order by MSC.StrCatName";	 
	$result =$db->RunQuery($sql);
		
		$str .=  "<option value =\"".""."\">"."Select One"."</option>";
	while ($row=mysql_fetch_array($result))
	{		
		$str .= "<option value=\"".$row["intSubCatNo"]."\">".$row["StrCatName"]."</option>";
	}
	
	$ResponseXML .= "<subCat><![CDATA[" . $str  . "]]></subCat>\n";
	$ResponseXML .= "</XMLLoadOrdersubcat>\n";
echo $ResponseXML;
}
if($id=="LoadPopItems")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<XMLURLLoadPopItems>";

$styleId	= $_GET["StyleId"];
$mainCat 	= $_GET["MainCat"];
$subCat 	= $_GET["SubCat"];
$itemDesc 	= $_GET["ItemDesc"];
	$sql="select MIL.strItemDescription,OD.strUnit,MIL.intItemSerial from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId=$styleId ";

if($mainCat!="")	
	$sql .= "and MIL.intMainCatID=$mainCat ";
if($subCat!="")
	$sql .= "and MIL.intSubCatID=$subCat ";
if($itemDesc!="")
	$sql .= "and MIL.strItemDescription like '%$itemDesc%' ";
	
	$sql .= "order by MIL.strItemDescription ";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<ItemId><![CDATA[" . $row["intItemSerial"]  . "]]></ItemId>\n";	
		$ResponseXML .= "<ItemDesc><![CDATA[" . $row["strItemDescription"]  . "]]></ItemDesc>\n";	
		$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]  . "]]></Unit>\n";	
	}
$ResponseXML .= "</XMLURLLoadPopItems>\n";
echo $ResponseXML;
}

if($id == "getPreorderItemDetails")
{
	header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$responseXml = "<data>";

	$styleId = $_GET["styleId"];
	$matID = $_GET["matID"];
	$buyerId = $_GET["buyerId"];
	
	$sql="select id.reaConPc,id.dblUnitPrice,mil.strItemDescription,MSC.StrCatName,ffa.intType,ffa.intSubCatId,
	mil.strUnit,mil.intItemSerial,ffa.intMainCatID ,
	ffa.intUnitPriceFormulaId,ffa.intConPcFormulaId,id.reaWastage
	from orderdetails id 
	inner join matitemlist mil on id.intMatDetailID = mil.intItemSerial
	inner join firstsale_formulaallocation ffa on ffa.intMatDetailId = id.intMatDetailID
	inner join matsubcategory MSC on MSC.intSubCatNo=ffa.intSubCatId
	where id.intStyleId='$styleId' and ffa.intBuyerId='$buyerId' and id.intMatDetailID=$matID";
	
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
		{
			$canDeleteItem=1;
			$responseXml .= "<itemID><![CDATA[" . $row["intItemSerial"]  . "]]></itemID>\n";
			$responseXml .= "<unit><![CDATA[" . $row["strUnit"]  . "]]></unit>\n";
			
			$subCategoryName = $row["StrCatName"];
			$descriptionType = $row["intType"];
			
			$itemDescription = $row["strItemDescription"]; 
			if($descriptionType == 0)
				$itemDescription = $row["StrCatName"];
				
			$subCategoryID = $row["intSubCatId"];	 
			$responseXml .= "<itemDetail><![CDATA[" . $itemDescription . "]]></itemDetail>\n";
			$canDeleteSubCat = checkCanDeleteSubCategory($subCategoryID);
			
			$mainCatid = $row["intMainCatID"];
			$responseXml .= "<categoryId><![CDATA[" . $mainCatid  .  "]]></categoryId>\n";
			$color = 'bcgcolor-tblrowWhite';
			$responseXml .= "<bgcolor><![CDATA[" . $color  .  "]]></bgcolor>\n";
			
			$conPcFormulaId = $row["intConPcFormulaId"];
			
			$conPc = conPcCalculation($row["reaConPc"],$conPcFormulaId,$row["reaWastage"],$orderNo,$styleId,$row["intItemSerial"]);
			$responseXml .= "<conPC><![CDATA[" . number_format($conPc,4)  . "]]></conPC>\n";
			
			$unitPriceFormulaId = $row["intUnitPriceFormulaId"];
			$unitPrice = unitPriceCalculation($styleId,$row["intItemSerial"],$unitPriceFormulaId,$row["dblUnitPrice"],$descriptionType,$subCategoryID,$buyerId);
			$responseXml .= "<unitPrice><![CDATA[" . number_format($unitPrice,4)  . "]]></unitPrice>\n";
			
			$perPcsValue = round($conPc*$unitPrice,4);
			$responseXml .= "<PcsValue><![CDATA[" . number_format($perPcsValue,4)  . "]]></PcsValue>\n";
			
			if($unitPrice >0)
				$canDeleteItem=0;
			
			if($canDeleteSubCat>0)	
				$canDeleteItem=1;
			$responseXml .= "<canDeleteItem><![CDATA[" . $canDeleteItem  .  "]]></canDeleteItem>\n";	
			//Description Id 
			//1- material, 2-Accessories, 3-hanger, 4-belts, 5-transport, 6-cmpw
			switch($mainCatid)
			{
				case 1:
				{
					$materialCost += $perPcsValue;
					$descriptionId =1;
					break;
				}
				case 2:
				{
					$str = strtoupper($subCategoryName);
					if(strstr($str,'HANGER'))
					{
						$hanger += $perPcsValue;
						$descriptionId =3;
					}
					else if(strstr($str,'BELTS'))
					{
						$belts += $perPcsValue;
						$descriptionId =5;
					}
					else
					{
						$accCost += $perPcsValue;
						$descriptionId =6;
					}	
					break;
					 
				}
				case 3:
				{
					$transportCost += $perPcsValue;
					$descriptionId =3;
					break;
				}
				case 4:
				{
					$cmpwCost += $perPcsValue;
					$descriptionId =4;
					break;
				}
			}
			
			$responseXml .= "<decriptionID><![CDATA[" . $row["intMainCatID"]  .  "]]></decriptionID>\n";
			$str = '';
		$res = getMainCategoryDetails();
		$str .= "<select name=\"cboAllocate\" id=\"cboAllocate\" style=\"width:80px\" onchange=\"AllocateFSCategory(this);\">";
		$str .=  "<option value="."null".">".""."</option>";
		while($rw = mysql_fetch_array($res))
		{
			if($rw["intCategoryId"] == $mainCatid)
				$str .= "<option selected=\"selected\" value=\"". $rw["intCategoryId"] ."\">" . trim($rw["intCategoryName"]) ."</option>" ;	
			else			
				$str .= "<option value=\"". $rw["intCategoryId"] ."\">" . $rw["intCategoryName"] ."</option>";
		}
		$str .= "</select> ";
		
		$responseXml .= "<FScategory><![CDATA[" . $str  .  "]]></FScategory>\n";
		}
	$responseXml.='</data>';
	echo $responseXml;	
	
}
if($id == "getWashdryProcess")
{
	header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$responseXml = "<WashdryProcess>";

	$styleId = $_GET["styleId"];
	$result = getInvWashDryProcess($styleId);
	while($row = mysql_fetch_array($result))
	{
		$responseXml .= "<intProcessId><![CDATA[" . $row["intProcessId"]  .  "]]></intProcessId>\n";
		$unitprice = $row["dblUnitPrice"]/12;
		$conpc = 1;
		$unit = 'PCS';
		$mainCatid = $row["FScategory"];
		
		$responseXml .= "<unitprice><![CDATA[" . number_format($unitprice,4)   .  "]]></unitprice>\n";
		$responseXml .= "<conpc><![CDATA[" . number_format($conpc,4)   .  "]]></conpc>\n";
		$responseXml .= "<unit><![CDATA[" . $unit  .  "]]></unit>\n";
		$responseXml .= "<strDescription><![CDATA[" . $row["strDescription"]  .  "]]></strDescription>\n";
		$str = '';
		$res = getMainCategoryDetails();
		
		$str .= "<select name=\"cboAllocate\" id=\"cboAllocate\" style=\"width:80px\" onchange=\"AllocateMaterials(this);\" disabled=\"disabled\">";
		$str .=  "<option value="."null".">".""."</option>";
		while($rw = mysql_fetch_array($res))
		{
			if($rw["intCategoryId"] == $mainCatid)
				$str .= "<option selected=\"selected\" value=\"". $rw["intCategoryId"] ."\">" . trim($rw["intCategoryName"]) ."</option>" ;	
			else			
				$str .= "<option value=\"". $rw["intCategoryId"] ."\">" . $rw["intCategoryName"] ."</option>";
			//$str .= "<option value=\"". $rw["intCategoryId"] ."\">" . $rw["intCategoryName"] ."</option>";
		}
		
		$str .= "</select> ";
		$fsCategoryId = $mainCatid;
		if($fsCategoryId>2)
			$fsCategoryId +=2;
		$responseXml .= "<FScategoryId><![CDATA[" . $mainCatid .  "]]></FScategoryId>\n";
		$responseXml .= "<FScategory><![CDATA[" . $str  .  "]]></FScategory>\n";
	}
	
	$responseXml.='</WashdryProcess>';
	echo $responseXml;	
}
if($id == "saveWashDryProcessDetails")
{
	$styleId = $_GET["styleId"];
	$processId = $_GET["processId"];
	$strUnit = $_GET["strUnit"];
	$unitprice = $_GET["unitprice"];
	$conpc = $_GET["conpc"];
	$fsCategoryId = $_GET["fsCategoryId"];
	
	$chkRecAv = checkInvProcessAv($styleId,$processId);
	echo $chkRecAv;
	if($chkRecAv == 1)
		updateInvProcessData($styleId,$processId,$strUnit,$unitprice,$conpc,$fsCategoryId);
	else	
		insertInvProcessData($styleId,$processId,$strUnit,$unitprice,$conpc,$fsCategoryId);
}
if($id == "savedInvProcessDetails")
{
	header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$responseXml = "<WashdryProcess>";

	$styleId = $_GET["styleId"];
	$result = getSavedInvProcessDetails($styleId);
	while($row = mysql_fetch_array($result))
	{
		$responseXml .= "<intProcessId><![CDATA[" . $row["intProcessId"]  .  "]]></intProcessId>\n";
		$unitprice = $row["dblUnitprice"];
		$conpc =$row["dblConpc"];
		$unit = $row["strUnit"];
		$fsCategoryId = $row["intFScategoryId"];
		
		$responseXml .= "<unitprice><![CDATA[" . number_format($unitprice,4)   .  "]]></unitprice>\n";
		$responseXml .= "<conpc><![CDATA[" . number_format($conpc,4)   .  "]]></conpc>\n";
		$responseXml .= "<unit><![CDATA[" . $unit  .  "]]></unit>\n";
		$responseXml .= "<strDescription><![CDATA[" . $row["strDescription"]  .  "]]></strDescription>\n";
		$str = '';
		$res = getMainCategoryDetails();
		$str .= "<select name=\"cboAllocate\" id=\"cboAllocate\" style=\"width:80px\" onchange=\"AllocateMaterials(this);\" disabled=\"disabled\">";
		$str .=  "<option value="."null".">".""."</option>";
		while($rw = mysql_fetch_array($res))
		{
			if($rw["intCategoryId"] == $fsCategoryId)
				$str .= "<option selected=\"selected\" value=\"". $rw["intCategoryId"] ."\">" . trim($rw["intCategoryName"]) ."</option>" ;	
			else			
				$str .= "<option value=\"". $rw["intCategoryId"] ."\">" . $rw["intCategoryName"] ."</option>";
		}
		$str .= "</select> ";
		
		$responseXml .= "<FScategory><![CDATA[" . $str  .  "]]></FScategory>\n";
		$responseXml .= "<FScategoryId><![CDATA[" . $fsCategoryId  .  "]]></FScategoryId>\n";
	}
	
	$responseXml.='</WashdryProcess>';
	echo $responseXml;	
}
if ($id=="getAppOrderNoList")
{
	$sql="select strOrderNo from firstsalecostworksheetheader where intStatus=10";
		
			$results=$db->RunQuery($sql);
			//$po_arr = "|";
			while($row=mysql_fetch_array($results))
			{
				$po_arr.= $row['strOrderNo']."|";
				 
			}
			echo $po_arr;
}
if($id == "getApprovedDetails")
{
	header('Content-Type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$responseXml = '';
	$responseXml = "<AppCwsData>";
	
	$orderNo = $_GET["orderNo"];
	$buyer = $_GET["buyer"];
	$taxStatus = $_GET["taxStatus"];
	$appDfrom = $_GET["appDfrom"];
	$appDto = $_GET["appDto"];
	$ocStatus = $_GET["ocStatus"];
	
	$tyear = date('Y');
	$tmonth = date('m');
	
	$deci=2;
	$result = getApprovedCWSdetails($orderNo,$tyear,$tmonth,$buyer,$taxStatus,$appDfrom,$appDto,$ocStatus);
	while($row = mysql_fetch_array($result))
	{
		$StyleId = $row["intStyleId"];
		$orderNo = $row["strOrderNo"];	
		$color 	 = $row["strColor"];
		$ocInvoiceNo = $row["ocInvoiceNo"];
		if($row["intTaxInvoiceConfirmBy"] != '')
			$cls = 'grid_raw_white';
		else
			$cls = 'grid_raw_pink';
				
		if($color != '')
			$orderNo = $orderNo.'-'.$color;
		
		$threadConpc = getFSThreadConpc($StyleId);
			
		$responseXml .= "<StyleId><![CDATA[" . $StyleId  .  "]]></StyleId>\n";
		$responseXml .= "<orderNo><![CDATA[" . $orderNo  .  "]]></orderNo>\n";
		$responseXml .= "<color><![CDATA[" . $color  .  "]]></color>\n";
		$shipQty = getShipQty($StyleId,$row["strComInvNo"]);
		
		$responseXml .= "<intOrderQty><![CDATA[" . $shipQty  .  "]]></intOrderQty>\n";
		$responseXml .= "<preOederSMV><![CDATA[" . $row["dblSMV"]  .  "]]></preOederSMV>\n";
		$responseXml .= "<dblPCScarton><![CDATA[" . $row["dblPCScarton"]  .  "]]></dblPCScarton>\n";
		$responseXml .= "<dblCMvalue><![CDATA[" . $row["dblCMvalue"]  .  "]]></dblCMvalue>\n";
		$responseXml .= "<buyerCode><![CDATA[" . $row["buyerCode"]  .  "]]></buyerCode>\n";
		
		$responseXml .= "<buyerFOB><![CDATA[" . round($row["buyerFOB"],$deci)  .  "]]></buyerFOB>\n";
		$invFob = round(($row["intinvFOB"]==1?$row["dblInvFob"]:$row["dblPreorderFob"]),$deci);
		$responseXml .= "<dblPreorderFob><![CDATA[" . round($row["dblPreorderFob"],$deci)  .  "]]></dblPreorderFob>\n";
		$responseXml .= "<dblInvFob><![CDATA[" . round($invFob,$deci)  .  "]]></dblInvFob>\n";
		$responseXml .= "<dblFsaleFob><![CDATA[" . round($row["dblFsaleFob"],$deci)  .  "]]></dblFsaleFob>\n";
		$comFOB = round(getComInvFOB($StyleId,$row["strComInvNo"]),$deci); 
		$responseXml .= "<comFOB><![CDATA[" . $comFOB  .  "]]></comFOB>\n";
		
		$responseXml .= "<dblInvoiceId><![CDATA[" . $row["dblInvoiceId"]  .  "]]></dblInvoiceId>\n";
		$responseXml .= "<strComInvNo><![CDATA[" . $row["strComInvNo"]  .  "]]></strComInvNo>\n";
		$responseXml .= "<actFabConPC><![CDATA[" . round($row["actFabConPC"],$deci)  .  "]]></actFabConPC>\n";
		$responseXml .= "<actPocConpc><![CDATA[" . round($row["actPocConpc"],$deci)  .  "]]></actPocConpc>\n";
		$responseXml .= "<actThreadConpc><![CDATA[" . round($row["actThreadConpc"],$deci)  .  "]]></actThreadConpc>\n";
		$responseXml .= "<threadConpc><![CDATA[" . round($threadConpc,$deci)  .  "]]></threadConpc>\n";
		$responseXml .= "<actSMV><![CDATA[" . round($row["actSMV"],$deci)  .  "]]></actSMV>\n";
		$responseXml .= "<actDryWashPrice><![CDATA[" . round($row["actDryWashPrice"],$deci)  .  "]]></actDryWashPrice>\n";
		$responseXml .= "<actWetWashPrice><![CDATA[" . round($row["actWetWashPrice"],$deci)  .  "]]></actWetWashPrice>\n";
		
		//get fistsale fabric and pocketing details 
		$result_fabric = getFabricDetails($StyleId,1);//invoice costing category 1 - fabric ,2-pocketing
		while($row_fabric = mysql_fetch_array($result_fabric))
			{
				$fabConpc = $row_fabric["reaConPc"];
				$fabUnitprice = $row_fabric["dblUnitPrice"]; 
				$fabMatId = $row_fabric["intMatDetailID"];
			}
		$res_FabInv = getCommercialInvDetails($StyleId,$fabMatId);
		$fabNumrows =  mysql_num_rows($res_FabInv);
		$fabInvStr = '&nbsp;';	
		
		if($fabNumrows>1)
		{	
			$fabInvStr = "<img src=\"../../images/pdf.png\" onclick=\"viewFabInvoice($StyleId,$fabMatId);\"/>";
		}
		else if($fabNumrows == 1)
		{
			$file="";
		$rowFab = mysql_fetch_array($res_FabInv);
		$url = "../../upload files/bulk grn/". $rowFab["intYear"].'-'.$rowFab["intBulkGrnNo"]."/";
		$serverRoot = $_SERVER['DOCUMENT_ROOT'];
		$dh = opendir($url);
		
			if(file_exists($url))
			{		
				while (($file = readdir($dh)) != false)
				{
				
					if($file!='.' && $file!='..')
					{
						$boo = true;
						$file1	= $url.rawurlencode($file);
					}
					else
					{
						$boo = false;
					}
				}
				$folder = "../../upload files/bulk grn/". $rowFab["intYear"].'-'.$rowFab["intBulkGrnNo"];
			if(count(glob("$folder/*")) === 0)
				$fabInvStr = '&nbsp;';	
			else
				$fabInvStr = "<a href=\"$file1\" target=\"_blank\"><img src=\"../../images/pdf.png\" border=\"0\" /></a>";	
			}
			/*if($boo)
				$fabInvStr = "<a href=\"$url$file1 \" target=\"_blank\"><img src=\"../../images/pdf.png\" border=\"0\" /></a>";			*/
			
		}
		
		$responseXml .= "<FSfabConpc><![CDATA[" . round($fabConpc,$deci)  .  "]]></FSfabConpc>\n";
		$responseXml .= "<FSfabUnitprice><![CDATA[" . round($fabUnitprice,$deci)  .  "]]></FSfabUnitprice>\n";
		
		$result_pocket = getFabricDetails($StyleId,'2');
			while($row_pocket = mysql_fetch_array($result_pocket))
			{
				$fsPocConpc = $row_pocket["reaConPc"];
				$fsPocUnitprice =$row_pocket["dblUnitPrice"];
				$pocMatDetailId = $row_pocket["intMatDetailID"];  
			}
			
		$res_PocInv = getCommercialInvDetails($StyleId,$pocMatDetailId);
		$PocNumrows =  mysql_num_rows($res_PocInv);
		$PocInvStr = '&nbsp;';	
		
		if($PocNumrows>1)
		{	
			$PocInvStr = "<img src=\"../../images/pdf.png\" onclick=\"viewFabInvoice($StyleId,$fabMatId);\"/>";
		}
		else if($PocNumrows == 1)
		{
			$file="";
		$rowFab = mysql_fetch_array($res_PocInv);
		$url = "../../upload files/bulk grn/". $rowFab["intYear"].'-'.$rowFab["intBulkGrnNo"]."/";
		$serverRoot = $_SERVER['DOCUMENT_ROOT'];
		$dh = opendir($url);
		
			if(file_exists($url))
			{		
				while (($file = readdir($dh)) != false)
				{
				
					if($file!='.' && $file!='..')
					{
						$boo = true;
						$file1	= $url.rawurlencode($file);
					}
					else
					{
						$boo = false;
					}
				}
				$folder = "../../upload files/bulk grn/". $rowFab["intYear"].'-'.$rowFab["intBulkGrnNo"];
			if(count(glob("$folder/*")) === 0)
				$PocInvStr = '&nbsp;';	
			else
				$PocInvStr = "<a href=\"$file1\" target=\"_blank\"><img src=\"../../images/pdf.png\" border=\"0\" /></a>";
			}
			/*if($boo)
				$PocInvStr = "<a href=\"$url$file1 \" target=\"_blank\"><img src=\"../../images/pdf.png\" border=\"0\" /></a>";			*/
		}	
		$responseXml .= "<FSfsPocConpc><![CDATA[" . round($fsPocConpc,$deci)  .  "]]></FSfsPocConpc>\n";
		$responseXml .= "<FSfsPocUnitprice><![CDATA[" . round($fsPocUnitprice,$deci)  .  "]]></FSfsPocUnitprice>\n";
		//end get fistsale fabric and pocketing details 	
		
		$dryWashprice = getWashprice($StyleId,'WASHING - DRY COST');
		$wetWashPrice = getWashprice($StyleId,'WASHING - WET COST');
		$responseXml .= "<FSdryWashprice><![CDATA[" . round($dryWashprice,$deci)  .  "]]></FSdryWashprice>\n";
		$responseXml .= "<FSwetWashPrice><![CDATA[" . round($wetWashPrice,$deci)  .  "]]></FSwetWashPrice>\n";
		
		$responseXml .= "<fabInvStr><![CDATA[" . $fabInvStr  .  "]]></fabInvStr>\n";
		$responseXml .= "<PocInvStr><![CDATA[" . $PocInvStr  .  "]]></PocInvStr>\n";
		
		$bpoStr = '&nbsp;';
		 $file = "";
		$url = "../../upload files/cws/". $StyleId."/BPO/";
			
			$serverRoot = $_SERVER['DOCUMENT_ROOT'];
			$dh = opendir($url);
			
			if(file_exists($url))
			{
			
				while (($file = readdir($dh)) != false)
				{
				
					if($file!='.' && $file!='..')
					{
						$boo = true;
						$file1	= rawurlencode($file);
					}
					else
					{
						$boo = false;
					}
				}
			}
			if(count(glob("$folder/*")) === 0)
				$bpoStr = "&nbsp;";
			else
				$bpoStr = "<a href=\"$url$file1 \" target=\"_blank\"><img src=\"../../images/pdf.png\" border=\"0\" /></a>";
		$responseXml .= "<bpoStr><![CDATA[" . $bpoStr  .  "]]></bpoStr>\n";
		$responseXml .= "<cls><![CDATA[" . $cls  .  "]]></cls>\n";
		$responseXml .= "<TaxInvoiceConfirmBy><![CDATA[" . $row["intTaxInvoiceConfirmBy"]  .  "]]></TaxInvoiceConfirmBy>\n";
		$responseXml .= "<ocInvoiceNo><![CDATA[" . $row["ocInvoiceNo"]  .  "]]></ocInvoiceNo>\n";
		$responseXml .= "<extraApprovalNeed><![CDATA[" . $row["intExtraApprovalRequired"]  .  "]]></extraApprovalNeed>\n";					
	}
		
	$responseXml.="</AppCwsData>";
	echo $responseXml;	
}
if($id == "chkPackingItem")
{
	header('Content-Type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$responseXml = '';
	$responseXml = "<otherPackingID>";
	$styleID = $_GET["styleID"];
	$buyerID = $_GET["buyerID"];
	$otherPackId = getCompulsoryItemId('intOtherPackingMaterialID');
	$hangerAv = checkHangerAvailability($styleID,$buyerID);
	
	$responseXml .= "<otherPackId><![CDATA[" . $otherPackId  .  "]]></otherPackId>\n";	
	$responseXml .= "<hangerAv><![CDATA[" . $hangerAv  .  "]]></hangerAv>\n";	
	$responseXml.="</otherPackingID>";
	echo $responseXml;	
}
if($id == "chkActualDataAv")
{
	$styleId = $_GET["styleId"];
	$res = 0;
	$sql = "select * from firstsale_actualdata where intStyleId='$styleId' ";
	$res = $db->CheckRecordAvailability($sql);
	echo $res;
}
if($id == "delFSItem")
{
	$styleID = $_GET["styleID"];
	$matId = $_GET["matId"];
	
	$sql = " delete from firstsalecostworksheetdetail where 	intStyleId = '$styleID' and intMatDetailID = '$matId'  ";
	
	$res = $db->RunQuery($sql);
	echo $res;
}
if($id=="URLConfirmFirstApproval")
{
	$styleId = $_GET["styleId"];
	$invoiceId = $_GET["invoiceId"];
	$ApprovalRemarks = $_GET["ApprovalRemarks"];
	
	$sql = "update firstsalecostworksheetheader 
			set
			intExtraApprovalStatus = '1' , 
			intFirstApproveBy = '$userId' , 
			dtmFirstApproveDate = now()  
			where
			intStyleId = '$styleId'";
	$result = $db->RunQuery($sql);
	
	if($result)
		echo "true";
	else
		echo "false";
}
if($id=="URLCheckedOC")
{
	$styleId = $_GET["styleId"];
	$invoiceId = $_GET["invoiceId"];
	$ApprovalRemarks = $_GET["ApprovalRemarks"];
	
	$sql = "update firstsalecostworksheetheader 
			set
			intOCcheckStatus = '1' , 
			intOCcheckedBy = '$userId' , 
			dtmOCcheckedDate = now() , 
			strOCRemarks = '$ApprovalRemarks',
			strFirstApproveRemarks = '$ApprovalRemarks'  
			where
			intStyleId = '$styleId'";
	$result = $db->RunQuery($sql);
	
	if($result)
		echo "true";
	else
		echo "false";
}
if($id=="URLConfirmSecondApproval")
{
	$styleId = $_GET["styleId"];
	$invoiceId = $_GET["invoiceId"];
	$ApprovalRemarks = $_GET["ApprovalRemarks"];
	
	$sql = "update firstsalecostworksheetheader 
			set
			intExtraApprovalStatus = '2' , 
			intSecondApproveBy = '$userId' , 
			dtmSecondApproveDate = now() , 
			strSecondApproveRemarks = '$ApprovalRemarks' 
			where
			intStyleId = '$styleId'";
	$result = $db->RunQuery($sql);
	
	if($result)
		echo "true";
	else
		echo "false";
}
if($id=="deleteFistSaleDetails")
{
	$styleId = $_GET["styleId"];
	$result='';
	$sql = "select dblInvoiceId from firstsale_shippingdata where intStyleId='$styleId' ";
	$result = $db->CheckRecordAvailability($sql);
	
	if($result=='')
	{
		$sql_d = " delete from firstsalecostworksheetheader where intStyleId = '$styleId' ";
		$res_d =$db->RunQuery($sql_d);
		
		$sql_Fsd = " delete from firstsalecostworksheetdetail where intStyleId = '$styleId' ";
		$res_Fsd =$db->RunQuery($sql_Fsd);
		echo "TRUE";	
	}
	else
		echo "FALSE";	
	
}


function insertCostHeaderData($orderNo,$styleId,$buyerFOB,$orderQty,$txtSMV,$txtpcsCarton,$txtCMV,$txtOTLdate,$txtOrderDate,$txtFacDate,$txtPreorderFob,$txtInvFOB,$strColor,$fsaleFob,$reqApparelApprov)
{
	global $db;
	global $userId;
	
	$tdate = date('Y-m-d');
	$sql = "insert into firstsalecostworksheetheader 
			(intStyleId, 
			strOrderNo,
			strColor, 
			buyerFOB, 
			intOrderQty, 
			dblSMV, 
			dblPCScarton, 
			dblCMvalue, 
			dtmOTLdate, 
			dtmBPOdate, 
			dtmExFactorydate, 
			dblPreorderFob, 
			dblInvFob,
			dblFsaleFob,
			intStatus,
			dtmDate,
			intUserId,
			intExtraApprovalRequired
			)
			values
			('$styleId', 
			'$orderNo',
			'$strColor', 
			'$buyerFOB', 
			'$orderQty', 
			'$txtSMV', 
			'$txtpcsCarton', 
			'$txtCMV', 
			'$txtOTLdate', 
			'$txtOrderDate', 
			'$txtFacDate', 
			'$txtPreorderFob', 
			'$txtInvFOB',
			'$fsaleFob',
			0,
			'$tdate',
			'$userId',
			'$reqApparelApprov'
			)";
			
	return 	$db->RunQuery($sql);
}

function insertCostDetailData($styleId,$matDetailID,$matDetailDes,$unitPrice,$conPc,$value,$categoryId)
{
	global $db;
	
	$sql = "insert into firstsalecostworksheetdetail 
			(intStyleId, 
			intMatDetailID, 
			dblUnitPrice, 
			reaConPc, 
			dblValue, 
			strItemDescription, 
			strType
			)
			values
			('$styleId', 
			'$matDetailID', 
			'$unitPrice', 
			'$conPc', 
			'$value', 
			'$matDetailDes', 
			'$categoryId'
			) ";
			
	return 	$db->RunQuery($sql);
}

function conPcCalculation($conPc,$formulaId,$wastage,$orderno,$styleId,$matDetailID)
{
	switch($formulaId)
	{
		case 11:
		{
			$conPc = (($conPc/12)+ ($conPc/12)*$wastage/100);
			break;
		}
		case 12:
		{
			$conPc =1;
			break;
		}
		case 15:
		{
			$preorderConPc = getPreorderConPc($styleId,$matDetailID);
			$conPc = (($preorderConPc)+ ($preorderConPc)*$wastage/100);
			break;
		}
		case 17:
		{
			$conPc = getCartonConPc($orderno,$styleId);
			break;
		}
		case 18:
		{
			$conPc = 0;
			break;
		}
		case 19:
		{
			//$conPc = getPreorderThreadConpc($styleId);
			$conPc = getThreadConpc($styleId);
			break;
		}
		case 23:
		{
			$conPc = getZipperConpcCalculation($styleId);
			break;
		}
		default :
		{
			$conPc =0;
			break;
		}
	}
	//echo $conPc;
	return round($conPc,4);
}
function unitPriceCalculation($styleId,$matDetailId,$formulaId,$invUintPrice,$type,$subCatId,$buyerID)
{
	switch($formulaId)
	{
		case 1:
		{	 
			$unitPrice = grnWAPrice($styleId,$matDetailId);
			break;
		}
		case 2:
		{
			$unitPrice = getZipperWAprice($styleId,$buyerID);
			break;
		}
		case 3:
		{
			$unitPrice = $invUintPrice;
			break;
		}
		case 4:
		{
			/*$unitPrice = getGrnWAprice($styleId,$matDetailId,$type,$subCatId);
			$leftoverPrice = getLeftoverWAprice($styleId,$matDetailId);
			$interJobPrice = getInterJobWAprice($styleId,$matDetailId);
			$comInvPrice = getCommercialINVprice($styleId,$matDetailId);
			if($leftoverPrice>0)
			{
				if($unitPrice>0)
					$unitPrice = ($unitPrice+$leftoverPrice)/2;
				else
					$unitPrice = $leftoverPrice;	
			}
			if($interJobPrice>0)
			{
				if($unitPrice>0)
					$unitPrice = ($unitPrice+$interJobPrice)/2;
				else
					$unitPrice = $interJobPrice;	
			}
			if($comInvPrice>0)
			{
				if($unitPrice>0)
					$unitPrice = ($unitPrice+$comInvPrice)/2;
				else
					$unitPrice = $comInvPrice;	
			}	*/
			$unitPrice = grnWAPrice($styleId,$matDetailId);
			break;
		}
		case 5:
		{
			$unitPrice = $invUintPrice/12;
			break;
		}
		case 9:
		{
			$unitPrice = getGrnWApriceCarton($styleId,$matDetailId,$subCatId);
			break;
		}
		case 13:
		{
			$smv = getSMV($styleId);
			$directLbCost = getCompulsoryItemId('intDirectLabourCostId');
			$marginId = getCompulsoryItemId('intMarginId'); 
			$otherPackId = getCompulsoryItemId('intOtherPackingMaterialID'); 
			if($directLbCost == $matDetailId)
				$unitPrice = $smv*0.085*0.9;
			elseif($marginId == $matDetailId)
				$unitPrice = $smv*0.085*0.9*0.1;
			else if($otherPackId == $matDetailId)
				$unitPrice = getOtherPackingCost($styleId,$buyerID);
			else
				$unitPrice = $invUintPrice/12;			
			break;
		}
		case 14:
		{
			$smv = getSMV($styleId);
			$unitPrice = ($smv*0.085 - $smv*0.085*0.9);
			break;
		}
		case 16:
		{
			$unitPrice = getOtherPackingCost($styleId,$buyerID);
			break;
		}
		case 20:
		{
			/*$unitPriceWA = getPreorderThreadWAprice($styleId);
			$arrPrice = explode('|',$unitPriceWA);
			$unitPrice = $arrPrice[0];*/
			$unitPrice = getThreadWAPriceCal($styleId);
			break;
		}
		case 21:
		{
			$unitPrice = getGrnWApriceCartonSeparator($styleId,$matDetailId,$subCatId);
			break;
		}
		case 22:
		{
			$unitPrice = getGrnWApriceSubCategory($styleId,$matDetailId,$subCatId);
			break;
		}
	}
	
	return round($unitPrice,4);
}

function getCommercialINVprice($styleId,$matDetailId)
{
	global $db;
	
	$sql = " select bpo.dblUnitPrice/bgh.dblRate as uintprice,bpoh.strSupplierID,cbd.strUnit,cbd.dblQty
			from commonstock_bulkheader cbh inner join commonstock_bulkdetails cbd on
			cbh.intTransferNo = cbd.intTransferNo and 
			cbh.intTransferYear = cbd.intTransferYear
			inner join bulkgrnheader bgh on 
			bgh.intBulkGrnNo = cbd.intBulkGrnNo and 
			bgh.intYear = cbd.intBulkGRNYear 
			inner join bulkpurchaseorderdetails bpo on
			bpo.intBulkPoNo = cbd.intBulkPoNo and
			bpo.intYear = cbd.intBulkPOYear and 
			bpo.intBulkPoNo = bgh.intBulkPoNo and 
			bpo.intYear = bgh.intBulkPoYear
			inner join bulkpurchaseorderheader bpoh on bpoh.intBulkPoNo = bpo.intBulkPoNo
			and bpoh.intYear = bpo.intYear and bpoh.intBulkPoNo = cbd.intBulkPoNo  and
			bpoh.intYear = cbd.intBulkPOYear
			inner join suppliers s on s.strSupplierID = bpoh.strSupplierID
			where cbh.intStatus = 1 and cbh.intToStyleId='$styleId' and bpo.intMatDetailId='$matDetailId' ";
			
	$result = $db->RunQuery($sql);
	$totPrice =0;
	$totQty =0;
	while($row = mysql_fetch_array($result))
	{
		$totPrice += round($row["uintprice"],4)*$row["dblQty"];
		$totQty   +=  $row["dblQty"];
	}	
	//$waPrice = round($totPrice/$totQty,4);
	return $totPrice.'*'.$totQty;
}

function getGrnWAprice($styleId,$matDetailId,$type,$subCatID)
{
	global $db;
	
	//$subCatID = getSubCategoryID($matDetailId);
	
	/*$sql = "select st.dblQty,grd.dblPaymentPrice/gh.dblExRate as unitPrice
			from stocktransactions st inner join grnheader gh on
			st.intGrnNo = gh.intGrnNo and st.intGrnYear = gh.intGRNYear
			inner join grndetails grd on
			grd.intGrnNo = st.intGrnNo and 
			grd.intGRNYear = st.intGrnYear
			inner join matitemlist mil on mil.intItemSerial = st.intMatDetailId
			and st.intMatDetailId = grd.intMatDetailID  and 
			mil.intItemSerial = grd.intMatDetailID 
			where st.intStyleId='$styleId'  ";
			
		if($type == 1)
			$sql .= " and mil.intItemSerial = '$matDetailId' ";
		else
			$sql .= " and mil.intSubCatID='$subCatID' ";*/
			
			$sql = "select gd.dblQty, gd.dblInvoicePrice/gh.dblExRate as unitPrice
				from grndetails gd inner join grnheader gh on
				gh.intGrnNo = gd.intGrnNo and gh.intGRNYear = gd.intGRNYear
				where gh.intStatus =1 and gd.intStyleId='$styleId' and gd.intMatDetailID='$matDetailId' ";
		
			
		$result = $db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{
			$totPrice += round($row["unitPrice"],4)*$row["dblQty"];
			$totQty   +=  $row["dblQty"];
		}
		
	$waPrice = round($totPrice/$totQty,4);
	
	return $waPrice;		
}

function getGrnWApriceSubCategory($styleId,$matDetailId,$subCatID)
{
	global $db;
	$sql = "select gd.dblQty, gd.dblPaymentPrice/gh.dblExRate as unitPrice
from grndetails gd inner join grnheader gh on
gh.intGrnNo = gd.intGrnNo and gh.intGRNYear = gd.intGRNYear
inner join matitemlist mil on mil.intItemSerial= gd.intMatDetailID
where gh.intStatus =1 and gd.intStyleId='$styleId' and mil.intSubCatID='$subCatID' ";
	$result = $db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{
			$totPrice += round($row["unitPrice"],4)*$row["dblQty"];
			$totQty   +=  $row["dblQty"];
		}
		
	$waPrice = round($totPrice/$totQty,4);
	
	return $waPrice;	
}
function getGRNDetails($styleId,$intMatDetailID)
{
	global $db;
	$sql = "select gd.dblQty, gd.dblInvoicePrice/gh.dblExRate as unitPrice
				from grndetails gd inner join grnheader gh on
				gh.intGrnNo = gd.intGrnNo and gh.intGRNYear = gd.intGRNYear
				where gh.intStatus =1 and gd.intStyleId='$styleId' and gd.intMatDetailID='$intMatDetailID' ";
		
			
		$result = $db->RunQuery($sql);
		$totPrice =0;
		$totQty =0;
		while($row = mysql_fetch_array($result))
		{
			$totPrice += round($row["unitPrice"],4)*$row["dblQty"];
			$totQty   +=  $row["dblQty"];
		}
		
		return $totPrice.'*'.$totQty;
}

function getGrnWApriceCarton($styleId,$matDetailId,$subCatID)
{
	global $db;
	$sql = "select sp.strMatDetailID
from specificationdetails sp 
 inner join matitemlist mil on  mil.intItemSerial = sp.strMatDetailID
inner join matpropertyvaluesinitems mpi on mpi.intMatItemSerial=sp.strMatDetailID
inner join matpropertyvalues mp on mp.intSubPropertyNo= mpi.intMatPropertyValueId
where sp.intStyleId='$styleId' and mil.intSubCatID='$subCatID'
 and  mp.strSubPropertyName='STD' ";
 $result = $db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{
			$matDetailId = $row["strMatDetailID"];
			
			$grn = getGRNDetails($styleId,$matDetailId);
			$arrgrn = explode('*',$grn);
			$totPrice += $arrgrn[0];
			$totQty += 	$arrgrn[1];
			
			$interJob = getInterJobWAprice($styleId,$matDetailId);
			$arrInterjob =  explode('*',$interJob);	
			$totPrice += $arrInterjob[0];
			$totQty += 	$arrInterjob[1];
			
			$leftover = getLeftoverWAprice($styleId,$matDetailId);
			$arrleftover = explode('*',$leftover);
			$totPrice += $arrleftover[0];
			$totQty += 	$arrleftover[1];
			
		}
	
	
	
	
	
	$waPrice = round($totPrice/$totQty,4);
	
	return $waPrice;
}
function getGrnWApriceCartonSeparator($styleId,$matDetailId,$subCatID)
{
	global $db;
	$sql = "select gd.dblQty, gd.dblPaymentPrice/gh.dblExRate as unitPrice
from grndetails gd inner join grnheader gh on
gh.intGrnNo = gd.intGrnNo and gh.intGRNYear = gd.intGRNYear
 inner join matitemlist mil on  mil.intItemSerial = gd.intMatDetailID
inner join matpropertyvaluesinitems mpi on mpi.intMatItemSerial=gd.intMatDetailID
inner join matpropertyvalues mp on mp.intSubPropertyNo= mpi.intMatPropertyValueId
where gh.intStatus =1 and gd.intStyleId='$styleId' and mil.intSubCatID='$subCatID'
 and  mp.strSubPropertyName='SEPARATOR'";
 $result = $db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{
			$totPrice += round($row["unitPrice"],4)*$row["dblQty"];
			$totQty   +=  $row["dblQty"];
		}
		
	$waPrice = round($totPrice/$totQty,4);
	
	return $waPrice;
}

function getSubCategoryID($matDetailId)
{
	global $db;
	
	$sql = "select intSubCatID from matitemlist where intItemSerial='$matDetailId' ";
	
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["intSubCatID"];
}

function getSMV($styleId)
{
	global $db;
	
	$sql = "select reaSMV from orders where intStyleId='$styleId' ";
	
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["reaSMV"];
}

function getOtherPackingCost($styleId,$buyerID)
{
	
	
	$chkHangerAv = checkHangerAvailability($styleId,$buyerID);
	$packingCost = getPackingMaterialCost($styleId,$buyerID);
	
	if($chkHangerAv == 1)
		$otherPackingCost = 2/12- $packingCost;
	else
		$otherPackingCost = 1.5/12- $packingCost;	
		
	return 	round($otherPackingCost,4);
}

function checkHangerAvailability($styleId,$buyerID)
{
	global $db;
	//$fieldName = 'intHangerId';
//	$hangerSubCatList = getSelectedSubID($fieldName);
//	$sql = "select o.intMatDetailID 
//			from orderdetails o inner join matitemlist m on 
//			m.intItemSerial = o.intMatDetailID 
//			where o.intStyleId='$styleId' and m.intSubCatID in ($hangerSubCatList)";
//	
//	$result = $db->RunQuery($sql);
//	$row = mysql_fetch_array($result);
//	
//	$retVal =1;
//	if ($row["intMatDetailID"] == '' || is_null($row["intMatDetailID"]))
//		$retVal =0;
	//echo $retVal;
	
	//check Hanger available in the order - fs category(5)
	
	$sql = " select o.intMatDetailID 
			from orderdetails o inner join firstsale_formulaallocation ffa on 
			ffa.intMatDetailId = o.intMatDetailID 
			where o.intStyleId='$styleId' and ffa.intBuyerId='$buyerID' and intMainCatID=5 ";
	
	return $db->CheckRecordAvailability($sql);		

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

function getCartonConPc($orderno,$styleId)
{
	$strColor = getOrderColorLen($styleId);
	if($strColor != '')
	{
		$colorLen = strlen($strColor)+1;
		$strOrderNo = substr($orderno,0,($colorLen*-1));
		$orderno = $strOrderNo;
	}	
	$eshipDB = new eshipLoginDB();
	
	$sql = "select sum(sd.dblNoofCTNS)/sum(sd.dblQtyPcs) as conpc 
			from shipmentpldetail sd inner join shipmentplheader sh on
			sh.strPLNo = sd.strPLNo
			where sh.intStyleId='$styleId'";
	/*if($strColor != '')
		$sql .= " and sd.strColor = '$strColor' ";	*/
	//echo $sql;	
	$result = $eshipDB->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["conpc"];
}

function getOrderColorLen($styleId)
{
	global $db;
	$sql = "select strOrderColorCode from orders where intStyleId='$styleId' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["strOrderColorCode"];
}
function getPackingMaterialCost($styleId,$buyerID)
{
	global $db;
	$fieldName = 'packingMaterialID';
	$packingSubCat_list = getSelectedSubID($fieldName);
	
	$sql = "select od.intMatDetailID, ffa.intSubCatId,ffa.intUnitPriceFormulaId,ffa.intConPcFormulaId,
ffa.intType,o.strOrderNo,o.strColorCode,od.reaConPc,od.reaWastage
from orderdetails od inner join firstsale_formulaallocation ffa on 
ffa.intMatDetailId = od.intMatDetailID 
inner join orders o on o.intStyleId = od.intStyleId
where o.intStyleId='$styleId' and ffa.intBuyerId='$buyerID' and intOtherPacking=1 ";
	
	$result = $db->RunQuery($sql);
	$value =0;
	//echo $sql;
	while($row = mysql_fetch_array($result))
	{
		$intMatDetailID = $row["intMatDetailID"];
		$intSubCatID    = $row["intSubCatId"];
				
		$unitformulaId = $row["intUnitPriceFormulaId"];
		$conpcFormulaId = $row["intConPcFormulaId"];		
		$intType     = $row["intType"];
		
		$resInvDetails = getInvoiceCostDetails($styleId,$intMatDetailID);
		$rowI = mysql_fetch_array($resInvDetails);
		$invConpc = $rowI["reaConPc"];
		$invWastage = $rowI["reaWastage"];
		if($invConpc == '')
		{
			$invConpc =  $row["reaConPc"];
			$invWastage = $row["reaWastage"];
		}
			//$invConpc =  $row["reaConPc"];
		
		$unitPrice = unitPriceCalculation($styleId,$intMatDetailID,$unitformulaId,'0',$intType,$intSubCatID,$buyerID);
		$conPc = conPcCalculation($invConpc,$conpcFormulaId,$invWastage,$row["strOrderNo"],$styleId,$intMatDetailID);
		//echo $intMatDetailID.' - '.round($unitPrice*$conPc,4).'<br>';
		$value += round($unitPrice*$conPc,4);
				//echo $intMatDetailID.'-'.$value.' '.'unitprice - '.$unitPrice.'conpc - '.$conPc.'</br>';
		
	}
//	$stickerValue = getStickerValue($styleId,$buyerID);
	//$value += $stickerValue;
	//echo $value;
	return $value;
	
}

function getStickerValue($styleId,$buyerID)
{
	global $db;
	$resSticker =  getStickerDetails($styleId);
	$value =0;
	
	while($rowS = mysql_fetch_array($resSticker))
	{
		$intMatDetailID = $rowS["strItemCode"];
		$conpc =$rowS["reaConPc"];
		$wastage = $rowS["reaWastage"];
		$price = $rowS["dblUnitPrice"];
		 
		$sqlDetail = " select ffa.intUnitPriceFormulaId,ffa.intConPcFormulaId,ffa.intType
						from firstsale_formulaallocation ffa 
						where ffa.intMatDetailId='$intMatDetailID' and ffa.intBuyerId='$buyerID'";
						
		$result_det = $db->RunQuery($sqlDetail);
		
		$rowD = mysql_fetch_array($result_det);
		
		$unitformulaId = $rowD["intUnitPriceFormulaId"];
		$conpcFormulaId = $rowD["intConPcFormulaId"];		
		$intType     = $rowD["intType"];
		$unitPrice = unitPriceCalculation($styleId,$intMatDetailID,$unitformulaId,$price,$intType,$intSubCatID,$buyerID);
		$conPc = conPcCalculation($conpc,$conpcFormulaId,$wastage,$rowS["strOrderNo"],$styleId,$intMatDetailID);
		
		$value += $unitPrice*$conPc;
	}
 	return $value;
}

function getStickerDetails($styleId)
{
	global $db;
	$sql = "select id.strItemCode,id.reaConPc,id.reaWastage,id.dblUnitPrice,ih.strOrderNo from invoicecostingdetails id
inner join  invoicecostingheader ih on ih.intStyleId = id.intStyleId
inner join matitemlist mil on  mil.intItemSerial = id.strItemCode
inner join matpropertyvaluesinitems mpi on mpi.intMatItemSerial=id.strItemCode
inner join matpropertyvalues mp on mp.intSubPropertyNo= mpi.intMatPropertyValueId
where id.intStyleId='$styleId' and  (mp.strSubPropertyName='CARTON STICKER' or
 mp.strSubPropertyName='POLY BAG STICKER')";
 	
	return $db->RunQuery($sql);
}
function getPCSperCarton($orderno)
{
	$strColor = getOrderColorLen($styleId);
	if($strColor != '')
	{
		$colorLen = strlen($strColor)+1;
		$strOrderNo = substr($orderNo,0,($colorLen*-1));
		$orderNo = $strOrderNo;
	}	
	$eshipDB = new eshipLoginDB();
	
	$sql = "select sum(sd.dblQtyPcs)/sum(sd.dblNoofCTNS) as conpc,sum(sd.dblQtyPcs) as qty  
			from shipmentpldetail sd inner join shipmentplheader sh on
			sh.strPLNo = sd.strPLNo
			where sh.strStyle='$orderno'";
	if($strColor != '')	
		$sql .= "and sd.strColor = '$strColor' ";	
		
	$result = $eshipDB->RunQuery($sql);
	$row = mysql_fetch_array($result);
	$shipmentDetails = $row["conpc"].'/'.$row["qty"];
	return $shipmentDetails;
}

function getPendingCostWSData($styleId)
{
	global $db;
	
	$sql = "select fsh.intStyleId,fsh.strOrderNo,fsh.strColor,fsh.buyerFOB,fsh.intOrderQty,fsh.dblSMV,
			fsh.dblPCScarton,fsh.dblCMvalue,fsh.dblPreorderFob,fsh.dblInvFob,fsh.dblFsaleFob,o.intBuyerID,o.strStyle,
			fsh.dtmOTLdate,fsh.dtmBPOdate,fsh.dtmExFactorydate,fsh.intExtraApprovalRequired
			from firstsalecostworksheetheader fsh inner join orders o on 
			o.intStyleId = fsh.intStyleId 
			where fsh.intStatus=0 and fsh.intStyleId='$styleId'";
	
	$result = $db->RunQuery($sql);
	
	return $result;
}

function getPendingCostWSdetails($styleId,$buyer)
{
	global $db;
	
	$sql = "select fsd.intMatDetailID,fsd.dblUnitPrice,fsd.reaConPc,fsd.dblValue,fsd.strItemDescription,
			fsd.strType,m.strUnit,m.intSubCatID,msc.StrCatName,ffa.intOtherPacking
			from firstsalecostworksheetdetail fsd inner join matitemlist m on
			fsd.intMatDetailID = m.intItemSerial inner join matsubcategory msc on
			msc.intSubCatNo = m.intSubCatID
inner join firstsale_formulaallocation ffa on ffa.intMatDetailId= fsd.intMatDetailID 
			where fsd.intStyleId='$styleId' and ffa.intBuyerId='$buyer' 
			order by fsd.strType,fsd.strItemDescription";
			
	return $db->RunQuery($sql);
}
function checkPengingCostWSavailability($styleId)
{
	global $db;
	
	$sql = "select * from firstsalecostworksheetheader where intStyleId='$styleId' ";
	
	return $db->CheckRecordAvailability($sql);
}

function updateCostWSheaderData($orderNo,$styleId,$buyerFOB,$orderQty,$txtSMV,$txtpcsCarton,$txtCMV,$txtOTLdate,$txtOrderDate,$txtFacDate,$txtPreorderFob,$txtInvFOB,$strColor,$fsaleFob,$reqApparelApprov)
{
	global $db;
	
	$tdate = date('Y-m-d');
	$sql_update = "update firstsalecostworksheetheader 
				set
				strOrderNo = '$orderNo' , 
				strColor = '$strColor' , 
				buyerFOB = '$buyerFOB' , 
				intOrderQty = '$orderQty' , 
				dblSMV = '$txtSMV' , 
				dblPCScarton = '$txtpcsCarton' , 
				dblCMvalue = '$txtCMV' , 
				dtmOTLdate = '$txtOTLdate' , 
				dtmBPOdate = '$txtOrderDate' , 
				dtmExFactorydate = '$txtFacDate' , 
				dblPreorderFob = '$txtPreorderFob' , 
				dblInvFob = '$txtInvFOB' , 
				dblFsaleFob = '$fsaleFob' , 
				intStatus = '0',
				dtmDate = '$tdate',
				intExtraApprovalRequired = '$reqApparelApprov'
				where
				intStyleId = '$styleId' ";
				
				return $db->RunQuery($sql_update);
}

function deleteCostWSdata($styleId)
{
	global $db;
	
	$sql = " delete from firstsalecostworksheetdetail 
		where
		intStyleId = '$styleId' ";
		
	$res = 	$db->RunQuery($sql);
}

function updateCWSstatus($styleId,$intStatus,$reqApparelApprov,$OCno,$strOrderContractNo)
{
	global $db;
	global $userId;
	
	$sql = "update firstsalecostworksheetheader 
	set
	intStatus = '$intStatus' , intExtraApprovalRequired='$reqApparelApprov' ,dblOrderContractNo=$OCno,
	strOrderContractNo = '$strOrderContractNo',intSendToApprovUser='$userId',dtmSendToApprove=now()
	where
	intStyleId = '$styleId' ";
	
	return	$db->RunQuery($sql);
}

function checkDateAvailability($otlDate)
{
	global $db;
	
	$sql = "select * from calendar where dtmdate='$otlDate' ";
	return $db->CheckRecordAvailability($sql);
}

function getPreorderThreadWAprice($styleId)
{
	global $db;
	
	$fieldName = 'intThreadSubcatID';
	$threadSubcatID = getSelectedSubID($fieldName);
	
	$sql = "select  sum(dblTotalQty*o.dblUnitPrice)/sum(dblTotalQty)as totval,sum(dblTotalQty) as totQty 
from orderdetails o inner join matitemlist mil on
o.intMatDetailID = mil.intItemSerial 
where o.intStyleId='$styleId' and mil.intSubCatID=$threadSubcatID ";

	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["totval"].'|'.$row["totQty"];
}

function getPreorderThreadConpc($styleId)
{
	global $db;
	
	$treadWAprice = getPreorderThreadWAprice($styleId);
	$arrThreadPrice = explode('|',$treadWAprice);
	$threadQty  = $arrThreadPrice[1];
	
	$orderQty = getOrderQty($styleId);
	
	return $threadQty/$orderQty;
}

function getOrderQty($styleId)
{
	global $db;
	
	$sql = " select intQty from orders where intStyleId='$styleId' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["intQty"];
}

function getPreorderConPc($styleId,$matDetailID)
{
	global $db;
	$sql = "select reaConPc from orderdetails where intStyleId=$styleId and intMatDetailID = '$matDetailID' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["reaConPc"];
}

function updateCWSDataStatus($styleId,$invID,$intStatus,$userId,$reason,$type)
{
	global $db;
	$sql = "update firstsalecostworksheetheader 
	set
	intStatus = '$intStatus', ";
	
	$status = (int)$intStatus;
	switch($status)
	{
		case 0;
		{
			if($type == 'reject')
				$sql .= " intRejectBy ='$userId',strRejectReason='$reason', dtmReject = now() ";
			else
				$sql .= " intReviseBy ='$userId', strReviseReason='$reason', dtmRevise=now() ";
			break;
		}
		case 10:
		{
			$sql .= " intApprovedBy = '$userId' , dtmConfirm = now() , intApprovalNo= intApprovalNo+1 ";
			break;
		}
	}
	$sql .= " where
	intStyleId = '$styleId' ";
	
	return	$db->RunQuery($sql);
}

function getLeftoverWAprice($styleId,$matDetailId)
{
	global $db;
	$sql = "SELECT COALESCE(sum(LCD.dblQty)) as LeftAlloqty, LCD.intGrnNo,LCD.intGrnYear, LCD.strGRNType,LCD.strColor,LCD.strSize,LCD.intFromStyleId
						FROM commonstock_leftoverdetails LCD INNER JOIN commonstock_leftoverheader LCH ON
						LCH.intTransferNo = LCD.intTransferNo AND 
						LCH.intTransferYear = LCD.intTransferYear
						WHERE LCH.intToStyleId = '$styleId'  and 
						LCD.intMatDetailId = '$matDetailId' and LCH.intStatus=1
group by LCD.intGrnNo,LCD.intGrnYear,LCD.strGRNType,LCD.strColor,LCD.strSize";
						
	$result = $db->RunQuery($sql);
	$price =0;
	$leftOverQty =0;
	$waPrice =0;
	while($row = mysql_fetch_array($result))
	{
		$lQty = $row["LeftAlloqty"];
		$totQty += $lQty;
		$intGrnNo = $row["intGrnNo"];
		if($intGrnNo>30)
		{
			$strGRNType = $row["strGRNType"];
			switch($strGRNType)
			{
				case 'S':
				{
					$LOprice = getGRNprice($intGrnNo,$row["intGrnYear"],$row["strColor"],$row["strSize"],$row["intFromStyleId"],$matDetailId);
					$price += $LOprice*$lQty;
					break;
				}
				case 'B':
				{
					$BAprice = getBulkGRNprice($intGrnNo,$row["intGrnYear"],$row["strColor"],$row["strSize"],$matDetailId);
					$price += $BAprice*$lQty;
					break;
				}
			}
		}
		else
		{
			$LAprice = getLeftoverPrice($matDetailId,$intGrnNo,$row["intGrnYear"],$row["strColor"],$row["strSize"],$row["strGRNType"]);
			$price += $LAprice*$lQty;
		}
	}	
	
	if($price>0)
	{
		$waPrice = $price/$totQty;
	}
	
	return $price.'*'.$totQty;				
}

function getGRNprice($intGrnNo,$grnYear,$strColor,$strSize,$styleId,$matDetailId)
{
	global $db;
	
	$sql = "select gd.dblInvoicePrice/gh.dblExRate as unitPrice
from grndetails gd inner join grnheader gh on
gh.intGrnNo = gd.intGrnNo and gh.intGRNYear = gd.intGRNYear
where gh.intStatus =1 and gd.intStyleId='$styleId' and gd.intMatDetailID='$matDetailId' and gd.strColor='$strColor' and gd.strSize = '$strSize' and  gd.intGrnNo='$intGrnNo' and gd.intGRNYear='$grnYear'";

	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["unitPrice"];
}
function getBulkGRNprice($intGrnNo,$grnYear,$strColor,$strSize,$matDetailId)
{
	global $db;
	
	$sql = "select bpo.dblInvoicePrice/bgh.dblRate as uintprice
from  bulkgrnheader bgh inner join bulkgrndetails bgd on
bgh.intBulkGrnNo = bgd.intBulkGrnNo and bgh.intYear = bgd.intYear		
inner join bulkpurchaseorderdetails bpo on
bpo.intBulkPoNo = bgh.intBulkPoNo and 
bpo.intYear = bgh.intBulkPoYear and 
bpo.intMatDetailId = bgd.intMatDetailID
where bgh.intStatus=1 and  bgd.intMatDetailID='$matDetailId' and bgh.intBulkGrnNo='$intGrnNo' and bgh.intYear='$grnYear' and bgd.strColor='$strColor' and  bgd.strSize='$strSize'";

	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["uintprice"];
}
function getInterJobWAprice($styleId,$matDetailId)
{
	global $db;
	
	$sql = "select COALESCE(Sum(ID.dblQty),0) as interJobQty,ID.strColor,ID.strSize,ID.intGrnNo, ID.intGrnYear,ID.strGRNType,intStyleIdFrom,ID.dblUnitPrice from itemtransfer IH 
inner join itemtransferdetails ID on IH.intTransferId=ID.intTransferId and IH.intTransferYear=ID.intTransferYear
where IH.intStyleIdTo='$styleId'
and  ID.intMatDetailId='$matDetailId'
and IH.intStatus=3
group by ID.strColor,ID.strSize,ID.intGrnNo,ID.intGrnYear,ID.strGRNType";

	$result = $db->RunQuery($sql);
	$price =0;
	$leftOverQty =0;
	$waPrice =0;
	while($row = mysql_fetch_array($result))
	{
		$lQty = $row["interJobQty"];
		$totQty += $lQty;
		$intGrnNo = $row["intGrnNo"];
		$fromStyleID = $row["intStyleIdFrom"];
		if($intGrnNo>30)
		{
			$strGRNType = $row["strGRNType"];
			switch($strGRNType)
			{
				case 'S':
				{
					$LOprice = $row["dblUnitPrice"];
					//getGRNprice($intGrnNo,$row["intGrnYear"],$row["strColor"],$row["strSize"],$fromStyleID,$matDetailId);
					$price += $LOprice*$lQty;
					break;
				}
				case 'B':
				{
					$BAprice = getBulkGRNprice($intGrnNo,$row["intGrnYear"],$row["strColor"],$row["strSize"],$matDetailId);
					$price += $BAprice*$lQty;
				}
			}
		}
	}	
	
	if($price>0)
	{
		$waPrice = $price/$totQty;
	}
	
	return $price.'*'.$totQty;
}
function getInvWashDryProcess($styleId)
{
	global $db;
	
	$sql = "select id.intProcessId,id.dblUnitPrice,wd.strDescription,wd.FScategory
from invoicecostingproceses id inner join was_dryprocess wd on
id.intProcessId = wd.intSerialNo
where id.intStyleId='$styleId'";
	
	return $db->RunQuery($sql);
}
function getSavedInvProcessDetails($styleId)
{
	global $db;
	
	$sql = "select fs.intProcessId,fs.intFScategoryId,fs.dblConpc,fs.dblUnitprice,fs.strUnit,wd.strDescription
from firstsale_invprocessdetails fs inner join was_dryprocess wd on
fs.intProcessId = wd.intSerialNo
where fs.intStyleId='$styleId' ";
	return $db->RunQuery($sql);
}

function getMainCategoryDetails()
{
	global $db;
	
	$sql = "select intCategoryId,intCategoryName from firstsalecostingcategory order by intCategoryId ";
	return $db->RunQuery($sql);
}
function insertInvProcessData($styleId,$processId,$strUnit,$unitprice,$conpc,$fsCategoryId)
{
	global $db;
	
	$sql = "insert into firstsale_invprocessdetails (intStyleId,intProcessId,intFScategoryId,dblConpc,dblUnitprice,strUnit
	) values ('$styleId','$processId','$fsCategoryId','$conpc','$unitprice','$strUnit')";
	
	$result =  $db->RunQuery($sql);
}
function updateCWSdetails($styleId,$matDetailID,$matDetailDes,$unitPrice,$conPc,$value,$categoryId)
{
	global $db;
	
	$sql = " update firstsalecostworksheetdetail 
	set
	dblUnitPrice = '$unitPrice' , 
	reaConPc = '$conPc' , 
	dblValue = '$value' , 
	strItemDescription = '$matDetailDes' , 
	strType = '$categoryId'
	where
	intStyleId = '$styleId' and intMatDetailID = '$matDetailID' ";
	
	return $db->RunQuery($sql);
}
function checkCWSdetailsAvailability($styleId,$matDetailID)
{
	global $db;
	
	$sql = "select * from firstsalecostworksheetdetail where intStyleId='$styleId' and intMatDetailID='$matDetailID' ";
	return $db->CheckRecordAvailability($sql);
}
function checkInvProcessAv($styleId,$processId)
{
	global $db;
	
	$sql = "select * from firstsale_invprocessdetails where intStyleId='$styleId' and intProcessId = '$processId'";
	return $db->CheckRecordAvailability($sql);
}
function updateInvProcessData($styleId,$processId,$strUnit,$unitprice,$conpc,$fsCategoryId)
{
	global $db;
	
	$sql = "update firstsale_invprocessdetails 
	set
	intFScategoryId = '$fsCategoryId' , 
	dblConpc = '$conpc' , 
	dblUnitprice = '$unitprice' , 
	strUnit = '$strUnit'
	where
	intStyleId = '$styleId' and intProcessId = '$processId' ";
	return $db->RunQuery($sql);
}

function getCompulsoryItemId($categoryName)
{
	global $db;
	
	$sql = "select strValue from firstsale_settings where strFieldName='$categoryName'";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["strValue"];
}
function checkLeftoverAvailability($styleId,$matDetailId)
{
	global $db;
	
	$sql = "SELECT *
						FROM commonstock_leftoverdetails LCD INNER JOIN commonstock_leftoverheader LCH ON
						LCH.intTransferNo = LCD.intTransferNo AND 
						LCH.intTransferYear = LCD.intTransferYear
						WHERE LCH.intToStyleId = '$styleId'  and 
						LCD.intMatDetailId = '$matDetailId' and LCH.intStatus=1";
	return $db->CheckRecordAvailability($sql);					
	
}

function checkInterjobTransferAvailability($styleId,$matDetailId)
{
	global $db;
	$sql = "select * from itemtransfer IH 
inner join itemtransferdetails ID on IH.intTransferId=ID.intTransferId and IH.intTransferYear=ID.intTransferYear
where IH.intStyleIdTo='$styleId'
and  ID.intMatDetailId='$matDetailId'
and IH.intStatus=3";
	return $db->CheckRecordAvailability($sql);		
}

function getApprovedCWSdetails($orderNo,$tyear,$tmonth,$buyer,$taxStatus,$appDfrom,$appDto,$ocStatus)
{
	global $db;
	$tdate = date('Y-m-d');
	$sql = "select fsh.intStyleId,fsh.strOrderNo,fsh.strColor,fsh.buyerFOB,fsh.intOrderQty,fsh.dblSMV,
fsh.dblPCScarton,fsh.dblCMvalue,fsh.dblPreorderFob,fsh.dblInvFob,fsh.dblFsaleFob,b.buyerCode,
fss.dblInvoiceId,fss.strComInvNo,fss.intStatus,fsa.dblFabricConpc as actFabConPC,fsa.dblPocketConpc as actPocConpc,
fsa.dblThreadConpc as actThreadConpc, fsa.dblSMV as actSMV, fsa.dblDryWashPrice actDryWashPrice, fsa.dblWetWashPrice as actWetWashPrice,b.intinvFOB,fss.intTaxInvoiceConfirmBy,fsh.dblInvoiceId as ocInvoiceNo,fsh.intExtraApprovalRequired
from firstsalecostworksheetheader fsh inner join orders o on 
o.intStyleId = fsh.intStyleId inner join buyers b on
b.intBuyerID = o.intBuyerID 
inner join  firstsale_shippingdata fss on fss.intStyleId = fsh.intStyleId
inner join firstsale_actualdata fsa on fsa.intStyleId = fsh.intStyleId
where fsh.intStatus =10  and fss.intStatus =1 ";

	if($orderNo !='')
		$sql .= " and fsh.strOrderNo like '%$orderNo%' ";
	if($buyer != '')
		$sql .= " and b.intBuyerID = '$buyer' ";
	if($taxStatus == '0')	
		$sql .= " and fss.intTaxInvoiceConfirmBy is null ";
	if($taxStatus == '1')	
		$sql .= " and fss.intTaxInvoiceConfirmBy <> '' ";		
	if($orderNo =='' && $buyer =='' && $taxStatus=='' && $appDfrom=='' && $appDto=='' && $ocStatus=='')
		$sql .= " and date(fsh.dtmConfirm)='$tdate' ";	
	if($appDfrom != '')	
		$sql .= " and date(fsh.dtmConfirm) >= '$appDfrom' ";
	if($appDto != '')	
		$sql .= " and date(fsh.dtmConfirm) <= '$appDto' ";
	if($ocStatus !='')
		$sql .= " and fsh.intExtraApprovalRequired =1 and fsh.intExtraApprovalStatus='$ocStatus' ";		
	$sql .= " order by fsh.strOrderNo ";
		//////echo $sql;
	return $db->RunQuery($sql);	
}
function getFabricDetails($styleID,$category)
{
	global $db;
	$sql = "select fsd.dblUnitPrice,fsd.reaConPc,fsd.intMatDetailID
from firstsalecostworksheetdetail fsd inner join invoicecostingdetails id on id.strItemCode=fsd.intMatDetailID and 
id.intStyleId = fsd.intStyleId
where id.strType='$category' and fsd.intStyleId='$styleID'";
	return $db->RunQuery($sql);
}
function getComInvFOB($styleID,$commInvNo)
{
	$eshipDB = new eshipLoginDB();
	
	$sqlF = " select cid.dblUnitPrice from commercial_invoice_detail cid inner join shipmentplheader plh on
cid.strPLNo = plh.strPLNo  where strInvoiceNo='$commInvNo' and plh.intStyleId='$styleID' ";
	
	$result_fob= $eshipDB->RunQuery($sqlF);
	$rowF = mysql_fetch_array($result_fob);
	
	return $rowF["dblUnitPrice"];
	
}
function getWashprice($styleID,$itemLike)
{
	global $db;
	
	$sql = "select fsd.dblUnitPrice as WashPrice
from firstsalecostworksheetdetail fsd inner join matitemlist mil on mil.intItemSerial=fsd.intMatDetailID
where mil.strItemDescription like'%$itemLike%' and fsd.intStyleId='$styleID'";
	
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["WashPrice"];
}
function checkInvoiceCostItem($styleId,$matDetailId)
{
	global $db;
	
	$sql = "select od.intMatDetailID from orderdetails od where od.intStyleId='$styleId' and od.intMatDetailID ='$matDetailId' and od.intMatDetailID
not in (select id.strItemCode from invoicecostingdetails id where id.intStyleId='$styleId' )";

	return $db->CheckRecordAvailability($sql);	
	
}
function getThreadWAPriceCal($styleId)
{
	$totThreadVal = getTotalThreadValue($styleId);
	$arrVal = explode('|',$totThreadVal);
	$threadVal = $arrVal[0];
	$usedQty = $arrVal[1];
	$threadWAprice = $threadVal/$usedQty;
	//echo $totThreadVal.''.$usedQty;
	return $threadWAprice;
}

function getTreadIssueItmeDetails($styleId,$threadSubcatID)
{
	global $db;
	
	
	$sql = "select st.dblQty as issueQty,st.intGrnNo,st.intGrnYear,st.strGRNType,st.intMatDetailId, st.strColor,st.strSize
 from stocktransactions st inner join matitemlist mil on mil.intItemSerial= st.intMatDetailId
where  st.intStyleId='$styleId' and mil.intSubCatID=$threadSubcatID and st.strType='ISSUE'";
//echo $sql;
	return $db->RunQuery($sql);
}

function getThreadReturnQty($styleId,$matDetailId,$grnNo,$grnYear,$grnType,$threadSubcatID,$color,$size)
{
	global $db;
	
	$sql = "select COALESCE(sum(st.dblQty),0) as Qty   
 from stocktransactions st inner join matitemlist mil on mil.intItemSerial= st.intMatDetailId
where  st.intStyleId='$styleId' and mil.intSubCatID=$threadSubcatID and st.strType in ('SRTS','CSRTS')  and st.intGrnNo='$grnNo' and 
 st.intGrnYear='$grnYear' and st.strGRNType='$grnType'  and st.intMatDetailId='$matDetailId'  and st.strColor='$color' and st.strSize = '$size' ";
	 $result = $db->RunQuery($sql);
	 $row = mysql_fetch_array($result);
	 //echo $sql;
	 return $row["Qty"];
}

function getTotalThreadValue($styleId)
{
	$fieldName = 'intThreadSubcatID';
	$threadSubcatID = getSelectedSubID($fieldName);
	
	$issueItems = getTreadIssueItmeDetails($styleId,$threadSubcatID);
	$totUsedQty =0;
	$totUsedVal =0;
	$returnQty=0;
	while($row = mysql_fetch_array($issueItems))
	{
		$issueQty = abs($row["issueQty"]);
		$grnType = $row["strGRNType"];
		$returnQty = getThreadReturnQty($styleId,$row["intMatDetailId"],$row["intGrnNo"],$row["intGrnYear"],$grnType,$threadSubcatID,$row["strColor"],$row["strSize"]);
		$usedItemQty = $issueQty-$returnQty;
		$totUsedQty += $usedItemQty;
		//echo $issueQty.'*';
		switch($grnType)
		{
			case 'S':
			{
				$grnprice = getGRNprice($row["intGrnNo"],$row["intGrnYear"],$row["strColor"],$row["strSize"],$styleId,$row["intMatDetailId"]);
				$totUsedVal += $usedItemQty*$grnprice;
				break;
			}
			case 'B':
			{
				$bulkGRN = getBulkGRNprice($row["intGrnNo"],$row["intGrnYear"],$row["strColor"],$row["strSize"],$row["intMatDetailId"]);
				$totUsedVal += $usedItemQty*$bulkGRN;
			}
		}
		
	}
	
	return $totUsedVal.'|'.$totUsedQty;
}

function getThreadConpc($styleId)
{
	$totThreadVal = getTotalThreadValue($styleId);
	$arrVal = explode('|',$totThreadVal);
	$threadVal = $arrVal[1];
	$orderQty = getOrderQty($styleId);
	//echo $threadVal.'-'.$orderQty.'\n';
	return $threadVal/$orderQty;
	//return $threadVal;
}

function getThreadSubCatId()
{
	global $db;
	
	$sql = "select strValue from firstsale_settings where strFieldName='intThreadSubcatID' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["strValue"];
}
function getCartonSubCatId()
{
	global $db;
	
	$sql = "select strValue from firstsale_settings where strFieldName='intCartonID' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["strValue"];
}
function getCommercialInvDetails($StyleId,$fabMatId)
{
	global $db;
	$sql = "select bgh.intBulkGrnNo,bgh.intYear 
from bulkgrnheader bgh inner join commonstock_bulkdetails cbd on 
bgh.intBulkGrnNo = cbd.intBulkGrnNo and bgh.intYear=cbd.intBulkGRNYear inner join commonstock_bulkheader cbh on
cbh.intTransferNo = cbd.intTransferNo and cbh.intTransferYear = cbd.intTransferYear
where cbh.intToStyleId='$StyleId' and cbd.intMatDetailId='$fabMatId'";

	return $db->RunQuery($sql);
}
function getFormulaDetails($buyerId,$itemId)
{
	global $db;
	
	$sql = "select * from firstsale_formulaallocation where intBuyerId='$buyerId' and intMatDetailId='$itemId' ";
	return $db->RunQuery($sql);
}
function getZipperWAprice($styleId,$buyerID)
{
	global $db;
	$fieldName = 'intZipperID';
	$zipper_list = getSelectedSubID($fieldName);
	
	$sql = "select o.intMatDetailID,m.intSubCatID,o.strOrderNo   
			from orderdetails o inner join matitemlist m on 
			m.intItemSerial = o.intMatDetailID 
			where o.intStyleId='$styleId' and m.intSubCatID in ($zipper_list)";
	
	$result = $db->RunQuery($sql);
	$value =0;
	$qty =0;
	$numrows = mysql_num_rows($result);
	while($row = mysql_fetch_array($result))
	{
		$intMatDetailID = $row["intMatDetailID"];
		$intSubCatID    = $row["intSubCatID"];
		
		if($intMatDetailID != '')
		{
			//$uprice += getGrnWAprice($styleId,$intMatDetailID,'0',$intSubCatID);
			$grnDet =  getGRNDetails($styleId,$intMatDetailID);
			$arrDet = explode('*',$grnDet);
			$value +=$arrDet[0];
			$qty +=$arrDet[1];
		}
	}
	$orderQty = getOrderQty($styleId);
	if($value>0)
		$waPrice = round($value/$orderQty,4);
	else
		$waPrice =0;	
	return $waPrice;	
}
function getLeftoverPrice($matDetailId,$intGrnNo,$grnYear,$color,$size,$grnType)
{
	global $db;
	$sql = "select dblUnitPrice from stocktransactions_leftover where intMatDetailId='$matDetailId' and
 strColor='$color' and strSize='$size' and intGrnNo='$intGrnNo' and intGrnYear='$grnYear' and strGRNType='$grnType' and strType='Leftover' ";
 	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["dblUnitPrice"];
}
function getSubcatId($matId)
{
	global $db;
	$sql = " select intSubCatID from matitemlist where intItemSerial='$matId' ";
	
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["intSubCatID"];
}

function getBuyerInvFOBStatus($buyerID)
{
	global $db;
	$sql = " select intinvFOB from buyers where intBuyerID = '$buyerID' ";
	
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["intinvFOB"];
}
function getFSThreadConpc($StyleId)
{
	global $db;
	$threadSubcat = getThreadSubCatId();
	
	$sql = "select fsd.reaConPc from firstsalecostworksheetdetail fsd inner join matitemlist mil on 
fsd.intMatDetailID = mil.intItemSerial
where mil.intSubCatID='$threadSubcat' and fsd.intStyleId='$StyleId' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["reaConPc"];
}
function checkCanDeleteSubCategory($subCategoryID)
{
	$hangerIdList = getCompulsoryItemId('canDeleteSubCategory');
	$arr_hangerList = array();
	$hangeID = explode(",",$hangerIdList);
	$loop=0;
	$canDelete =0;
	foreach($hangeID as $value)
	{
		if($subCategoryID == $value)
			$canDelete = 1;
	}
	return $canDelete;
}
function getInvoiceCostDetails($styleId,$intMatDetailID)
{
	global $db;
	$sql = "select * from invoicecostingdetails where intStyleId='$styleId' and strItemCode='$intMatDetailID' ";
	return $db->RunQuery($sql);
}
function getZipperConpcCalculation($styleId)
{
	global $db;
	$fieldName = 'intZipperID';
	$zipper_list = getSelectedSubID($fieldName);
	
	$sql = " select id.reaConPc,id.reaWastage
from invoicecostingdetails id inner join matitemlist m on 
m.intItemSerial = id.strItemCode 
where id.intStyleId='$styleId' and m.intSubCatID in ($zipper_list)";

	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	$conpc = $row["reaConPc"]/12 + (($row["reaConPc"]/12)*$row["reaWastage"]/100);
	//echo $conpc;
	return $conpc;
}

function updateShippingCWSstatus($styleId,$invID)
{
	global $db;
	$sql = " update firstsale_shippingdata 	set	intStatus = '1',intApprovalNo = intApprovalNo+1 where 	dblInvoiceId = '$invID' ";
	return $db->RunQuery($sql);
}
function getShipQty($styleID,$commInvNo)
{
	$eshipDB = new eshipLoginDB();
	
	$sql = " select cid.dblQuantity from commercial_invoice_detail cid inner join shipmentplheader plh on
cid.strPLNo = plh.strPLNo  where strInvoiceNo='$commInvNo' and plh.intStyleId='$styleID' ";
	
	$result_qty= $eshipDB->RunQuery($sql);
	$rowQ = mysql_fetch_array($result_qty);
	
	return $rowQ["dblQuantity"];
	
}
function getCWSApprovalStatus($styleId)
{
	global $db;
	$sql = " select intStatus from firstsalecostworksheetheader where intStyleId='$styleId' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["intStatus"];
	
}
function checkFirstSaleCostingAvailable($styleID)
{
	global $db;
	$sql = " select * from firstsalecostworksheetheader where intStyleId='$styleID' ";
	return $db->CheckRecordAvailability($sql);
	
}
function checkPendingInvoiceCostingAv($styleID)
{
	global $db;
	$sql = " select * from invoicecostingheader where intStyleId='$styleID' and intStatus=0 ";
	return $db->CheckRecordAvailability($sql);
}
function grnWAPrice($styleId,$matDetailId)
{
	$totValue=0;
	$totQty=0;
	$comInv = getCommercialINVprice($styleId,$matDetailId);
	$leftover = getLeftoverWAprice($styleId,$matDetailId);
	$interJob = getInterJobWAprice($styleId,$matDetailId);
	$grn = getGRNDetails($styleId,$matDetailId);
	
	$arrComInv = explode('*',$comInv);
	$arrleftover = explode('*',$leftover);
	$arrInterjob =  explode('*',$interJob);
	$arrgrn = explode('*',$grn);
	
	$totValue = $arrComInv[0];
	$totValue += $arrleftover[0];
	$totValue += $arrInterjob[0];
	$totValue += $arrgrn[0];
	
	$totQty=$arrComInv[1];
	$totQty += $arrleftover[1];
	$totQty += $arrInterjob[1];
	$totQty += $arrgrn[1];
	
	$waPrice = $totValue/$totQty;
	
	return $waPrice;
	
}
function getBuyerConsigneeID($styleId,$invoiceID)
{
	global $db;
	$sql = " select cih.strFinalDest from firstsale_shippingdata fss inner join eshipping.shipmentplheader plh on 
plh.intStyleId = fss.intStyleId
inner join eshipping.commercial_invoice_detail cid on cid.strPLno = plh.strPLno
inner join eshipping.commercial_invoice_header cih on cih.strInvoiceNo = cid.strInvoiceNo and
cid.strInvoiceNo = fss.strComInvNo
where fss.intStyleId='$styleId' and fss.dblInvoiceId='$invoiceID' ";
//echo $sql;
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["strFinalDest"];
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
function getCountryCode($styleId)
{
	global $db;
	$sql = "select distinct c.strCountryCode from eshipping.commercial_invoice_header cih 
inner join eshipping.commercial_invoice_detail cid on cid.strInvoiceNo = cih.strInvoiceNo
inner join eshipping.shipmentplheader plh on plh.strPLNo = cid.strPLNo
inner join eshipping.city c on c.strCityCode = cih.strFinalDest
inner join firstsale_shippingdata fss on fss.intStyleId= plh.intStyleId and fss.strComInvNo= cid.strInvoiceNo
where plh.intStyleId='$styleId' order by cih.dtmInvoiceDate ";
	
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["strCountryCode"];
}
function getManufactureCompany($styleId)
{
	global $db;
	$sql = " select c.strCompanyCode from eshipping.commercial_invoice_header cih 
inner join eshipping.commercial_invoice_detail cid on cid.strInvoiceNo = cih.strInvoiceNo
inner join eshipping.shipmentplheader plh on plh.strPLNo = cid.strPLNo
inner join eshipping.customers c on c.strCustomerID = cih.strCompanyID
inner join firstsale_shippingdata fss on fss.intStyleId= plh.intStyleId and fss.strComInvNo= cid.strInvoiceNo
where plh.intStyleId='$styleId' order by cih.dtmInvoiceDate ";

	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["strCompanyCode"];
}

function getOrderContractNo($intCompanyId)
{
	global $db;
	
	$sql = "select dblOrderContractNo from syscontrol where intCompanyID='$intCompanyId' ";
	$result = $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	
	//update syscontrol
	$sql1 = " update syscontrol 
			set 
			dblOrderContractNo = dblOrderContractNo+1
			 where intCompanyID='$intCompanyId' ";
	$res = $db->RunQuery($sql1);	
			 
	return $row["dblOrderContractNo"];
}
function gatOrderContractDetails($styleId)
{
	global $db;
	$sql = " select fsh.dblOrderContractNo,fsh.strOrderContractNo  from firstsalecostworksheetheader fsh where intStyleId='$styleId' ";
	
	return $db->RunQuery($sql);	
}
?>