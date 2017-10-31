<?php

	//$styleID = $_GET["styleID"];
	//$invoiceId = $_GET["invoiceID"];
 
	$sql_fs = " select intStatus,intTaxInvoiceConfirmBy from  firstsale_shippingdata where intStyleId='$styleID' 
	and dblInvoiceId= '$invoiceId' ";
	$result_fs = $db->RunQuery($sql_fs);
	$rowFSS = mysql_fetch_array($result_fs);
	
	$fsStatus = $rowFSS["intStatus"];
	$pendingStatus = $fsStatus;
	if($fsStatus == 0)
		$pendingStatus =0;
	else if($fsStatus == 1 && $rowFSS["intTaxInvoiceConfirmBy"] =='')	
		$pendingStatus =0;
		
	if($pendingStatus == 0)
	{
?>
<div style="position:absolute;top:300px;left:100px;">
<img src="../../images/pending.png">

</div>
<?php 
	}
	if($pendingStatus == 11)
	{
?>
<div style="position:absolute;top:200px;left:200px;"><img src="../../../../images/cancelled.png" style="-moz-opacity:0.20;opacity:0.20;filter:alpha(opacity=20);" /></div>
<?php 
	}
	

	$sql_fsData= "Select fss.strOrderNo,fss.strOrderColorCode,fss.strComInvNo,fss.strInvoiceNo,
				date_format(fsh.dtmOTLdate,'%d-%M-%Y') as invDate,
				fss.intPaytermId,fss.intShipmentTermId,fss.dblVatRate,fsh.intStyleId 
				from  firstsale_shippingdata fss inner join firstsalecostworksheetheader fsh on
				fss.intStyleId = fsh.intStyleId
				where fss.intStyleId='$styleID' and fss.dblInvoiceId='$invoiceId' ";

	$res_fsData =$db->RunQuery($sql_fsData);
	$rowFS = mysql_fetch_array($res_fsData); 
	
	$orderNo = $rowFS["strOrderNo"];
	$color  = $rowFS["strOrderColorCode"];
	$commInvNo = $rowFS["strComInvNo"];
	$invoiceNo = $rowFS["strInvoiceNo"];
	//$invoiceDate = $rowFS["invDate"];
	$payTermId = $rowFS["intPaytermId"];
	$shipTermId = $rowFS["intShipmentTermId"];
	$vatRate = $rowFS["dblVatRate"];
	$intStyleId = $rowFS["intStyleId"];
	
	$sql_shipTerm = "select strShipmentTerm from shipmentterms where strShipmentTermId='$shipTermId'";
	$res_shipTerm = $eshipDB->RunQuery($sql_shipTerm);
	$rowST = mysql_fetch_array($res_shipTerm); 
	
	$shipmentTerm = $rowST["strShipmentTerm"];
	
	$sql_payTerm = "select strPaymentTerm from paymentterm where strPaymentTermID='$payTermId' ";
	$res_payTerm = $eshipDB->RunQuery($sql_payTerm);
	$rowPT = mysql_fetch_array($res_payTerm); 
	
	$payTerm = $rowPT["strPaymentTerm"];
	//get shipping details
	
	$sql_shipData= "select splh.strProductCode,sum(cid.dblQuantity) as dblQuantity,cih.strCarrier,
			cid.strFabric,cid.strDescOfGoods,cid.strBuyerPONo,
			date_format(DATE_SUB(cih.dtmSailingDate,INTERVAL 3 DAY),'%d-%M-%Y') AS invoiceDate,
			cih.strLCBankID,cih.strDeliverTo,cid.dblUnitPrice,fi.strGender,
			c.strName as customer,c.strAddress1 as cutomerAdd1,c.strAddress2 as cutomerAdd2,c.strCountry custCountry,
			c.strTIN as customerVatRegNo,c.strTQBNo as customerTQBNo,
			c.strPhone as custPhoneNo,c.strFax as custFaxNo,
			b.strName as buyer,b.strAddress1 as buyerAdd1,b.strAddress2 as buyerAdd2,b.strCountry as buyerCountry,
			b.strPhone as buyerPhoneNo, b.strFax as buyerFaxNo,
			city.strCity as destination,
			cid.strHSCode as HTSdata,bank.strName as bankName,bank.strAddress1 as bankAdd1,
			bank.strAddress2 as bankAdd2,bank.strCountry as bankCountry,bank.strRefNo as bankACno,
			fi.strGarmentType,fi.strBTM, fi.strCat as quataCat,u.strTitle as QtyUnit
			from shipmentplheader splh inner join commercial_invoice_detail cid on
			cid.strPLno = splh.strPLNo --  and cid.strBuyerPONo = splh.strStyle 
			inner join commercial_invoice_header cih on cih.strInvoiceNo = cid.strInvoiceNo
			inner join finalinvoice fi on fi.strInvoiceNo = cih.strInvoiceNo
			inner join customers c on  c.strCustomerID = cih.strCompanyID
			inner join buyers b on b.strBuyerID = cih.strBuyerID
			inner join city on city.strCityCode = cih.strFinalDest
			inner join bank on bank.strBankCode = cih.intBankId
			inner join units u on u.strUnit = cid.strUnitID
			where cid.strInvoiceNo ='$commInvNo'  and splh.intStyleId='$intStyleId' group by  splh.intStyleId ";
			 
			
		//echo $sql_shipData;	 
	$res_ShipData = $eshipDB->RunQuery($sql_shipData);
	$rowS = mysql_fetch_array($res_ShipData); 
	
	$strBuyerPONo = $rowS["strBuyerPONo"];
	$customer = $rowS["customer"];
	$customer_add1 = $rowS["cutomerAdd1"];
	$cutomerAdd2 = $rowS["cutomerAdd2"];
	$customer_country = $rowS["custCountry"];
	$customerPhoneNo = $rowS["custPhoneNo"];
	$custFaxNo = $rowS["custFaxNo"];
	$custVatNo = $rowS["customerVatRegNo"];
	$custTQBNo = $rowS["customerTQBNo"];
	
	$strGender = $rowS["strGender"];
	
	$buyer = 	$rowS["buyer"];
	$buyer_add1 = $rowS["buyerAdd1"];
	$buyer_add2 = $rowS["buyerAdd2"];
	$buyer_country	 = $rowS["buyerCountry"]; 
	$buyerPhoneNo = $rowS["buyerPhoneNo"]; 
	$buyerFax = $rowS["buyerFaxNo"]; 
	
	$itemDesc = $rowS["strFabric"]; 
	$itemDescOther = $rowS["strDescOfGoods"]; 
	
	$styleNo = $rowS["strProductCode"]; 
	$shipQty = $rowS["dblQuantity"]; 
	$usHTSdata = $rowS["HTSdata"]; 
	
	$bankName = $rowS["bankName"]; 
	$bankAdd1= $rowS["bankAdd1"]; 
	$bankAdd2 = $rowS["bankAdd2"];
	$bankCountry =  $rowS["bankCountry"];
	$bankAcc_str = $rowS["bankACno"];
	$arrBank_str = explode('-',$bankAcc_str);
	$arrBank_Acc = explode(':',$arrBank_str[0]);
	$arrBank_Swift = explode(':',$arrBank_str[1]);
	
	$finalDestination = $rowS["destination"];
	$garmentType =  $rowS["strGarmentType"];
	$BTM = $rowS["strBTM"];
	$QuataCat = $rowS["quataCat"];
	$qtyUnit = $rowS["QtyUnit"];
	$invoiceDate = $rowS["invoiceDate"];
	
	$bankSwiftCode = $arrBank_Swift[1];
	
	//$sailingDate = $rowS["SailingDate"]; 
	
	
	//LOAD COMPANY details
	
	
					$comName = $xmlObj->Name->CompanyName;
					$comAddress1= $xmlObj->Address->AddressLine1;
					$comAddress2= $xmlObj->Address->AddressLine2;
					$comStreet= $xmlObj->Address->Street;
					$comCity= $xmlObj->Address->City;
					$comCountry= $xmlObj->Address->Country;
					$comstrPhone= $xmlObj->Address->Telephone;
					$comEMail= $xmlObj->Address->Email;
					$comFax= $xmlObj->Address->Fax;
					$comWeb= $xmlObj->Address->Web;
					$comVatNo = $xmlObj->Address->VatRegNo;
					$comTQBNo = $xmlObj->Address->TQBRegNo;
					
					
	//cmpw Cost
	
	$sql_cmpw = "select sum(fsd.dblValue) as cmpwprice 
				from firstsalecostworksheetdetail fsd 
				where fsd.intStyleId = '$styleID' and fsd.strType=4 ";
				
				$result_cmpw  =$db->RunQuery($sql_cmpw);
				$row_cmpw = mysql_fetch_array($result_cmpw);
				
				$CmpwPrice = $row_cmpw["cmpwprice"];				
?>
<table width="850" border="0" cellspacing="0" cellpadding="0" align="center">
<tr><td>&nbsp;</td></tr>
  <tr>
    <td class="head2BLCK">ORIT APPARELS LANKA (PVT) LTD</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="head2BLCK">SUSPENDED TAX INVOICE</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="head2BLCK">FIRST SALE INVOICE</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table  border="0" cellspacing="0" cellpadding="2" style="width:100%; line-height:17PX;" align="center">
      <tr>
        <td colspan="4" class="border-top-bottom-left-fntsize12" style="font-weight:bold;">MANUFACTURER</td>
        <td colspan="2" class="border-top-bottom-left-fntsize12" style="font-weight:bold">INVOICE NO</td>
        <td colspan="2" class="border-All-fntsize12" style="font-weight:bold">DATE</td>
        </tr>
      <tr>
        <td colspan="4" class="border-left-fntsize12"><?php echo $customer; ?></td>
        <td colspan="2" class="border-left-fntsize12" ><?php echo $invoiceNo; ?></td>
        <td colspan="2" class="border-left-right-fntsize12" ><?php echo $invoiceDate; ?></td>
        </tr>
      <tr>
        <td colspan="4" class="border-left-fntsize12"><?php echo $customer_add1.' '.$cutomerAdd2; ?></td>
        <td colspan="2" class="border-bottom-left-fntsize12" style="font-weight:bold">BUYER'S ORDER NO</td>
        <td colspan="2" class="border-Left-bottom-right-fntsize12" style="font-weight:bold">STYLE NO</td>
        </tr>
      <tr>
        <td colspan="4" class="border-left-fntsize12"><?php echo $customer_country; ?></td>
        <td colspan="2" class="border-bottom-left-fntsize12"><?php echo $strBuyerPONo; ?></td>
        <td colspan="2" class="border-Left-bottom-right-fntsize12"><?php echo $style; ?></td>
        </tr>
      <tr>
        <td width="108" class="border-left-fntsize12">TEL#</td>
        <td colspan="3" style="font-family:Verdana; font-size:12px;"><?php echo $customerPhoneNo; ?></td>
        <td colspan="2" class="border-left-fntsize12" style="font-weight:bold">VAT REGISTRATION#</td>
        <td colspan="2" class="border-right-fntsize12"><?php $custVatNo = ($custVatNo == '' ?'&nbsp;' :$custVatNo);
		echo $custVatNo; ?></td>
        </tr>
      <tr>
        <td class="border-bottom-left-fntsize12">FAX # </td>
        <td colspan="3" class="border-bottom-fntsize12"><?php  echo ($custFaxNo ==''?'&nbsp;':$custFaxNo);		
		 ?></td>
        <td colspan="2" class="border-bottom-left-fntsize12" style="font-weight:bold">SVAT REGISTRATION#</td>
        <td colspan="2" class="border-bottom-right-fntsize12">SVAT000014</td>
        </tr>
      <tr>
        <td colspan="4" class="border-left-fntsize12" style="font-weight:bold">SOLD TO </td>
        <td colspan="4" class="border-left-right-fntsize10 ">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4" class="border-left-fntsize12"><?php echo $comName; ?></td>
        <td colspan="2" class="border-left-fntsize12" style="font-weight:bold">PATMENT TERM </td>
        <td colspan="2" class="border-right-fntsize12"><?php echo $payTermId; ?></td>
        </tr>
      <tr>
        <td colspan="4" class="border-left-fntsize12"><?php echo $comAddress1.','.$comAddress2; ?></td>
        <td colspan="2" class="border-left-fntsize12" style="font-weight:bold">SHIPPING TERM </td>
        <td colspan="2" class="border-right-fntsize12"><?php echo $shipmentTerm; ?></td>
        </tr>
      <tr>
        <td colspan="4" class="border-left-fntsize12"><?php echo $comStreet.','.$comCity; ?></td>
        <td colspan="4" class="border-left-right">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4" class="border-left-fntsize12"><?php echo $comCountry; ?></td>
        <td colspan="2" class="border-left-fntsize12" style="font-weight:bold">VAT REGISTRATION #</td>
        <td colspan="2" class="border-right-fntsize12">114192600-7000<?php //echo $comVatNo; ?></td>
        </tr>
      <tr>
        <td colspan="4" class="border-left-fntsize12">TEL # <?php echo '  '.$comstrPhone; ?></td>
        <td colspan="2" class="border-left-fntsize12" style="font-weight:bold">SVAT REGISTRATION #</td>
        <td colspan="2" class="border-right-fntsize12">SVAT000023</td>
        </tr>
      <tr>
        <td colspan="4" class="border-bottom-left-fntsize12">FAX # <?php echo '  '.$comFax; ?></td>
        <td colspan="2" class="border-bottom-left-fntsize12" style="font-weight:bold">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize10">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4" class="border-left-fntsize12" style="font-weight:bold">CONSIGNEE/IMPORTER</td>
        <td colspan="4" class="border-left-right-fntsize12" style="font-weight:bold">BANK DETAILS </td>
        </tr>
      <tr>
        <td colspan="4" class="border-left-fntsize12"><?php echo $buyer; ?></td>
        <td colspan="4" class="border-left-right"><?php echo $bankName; ?></td>
        </tr>
      <tr>
        <td colspan="4" class="border-left-fntsize12"><?php echo $buyer_add1.' '.$buyer_add2; ?></td>
        <td colspan="4" class="border-left-right"><?php echo $bankAdd1; ?></td>
        </tr>
      <tr>
        <td colspan="4" class="border-left-fntsize12"><?php echo ($buyer_country==''?'&nbsp;':$buyer_country); ?></td>
        <td colspan="4" class="border-left-right"><?php echo $bankAdd2.','.$bankCountry; ?></td>
        </tr>
      <tr>
	  <td class="border-left-fntsize12">TEL # </td>
        <td colspan="3" style="font-family:Verdana; font-size:12px;"><?php echo $buyerPhoneNo; ?></td>
        <td colspan="2" class="border-left-fntsize12" style="font-weight:bold">A/C #</td>
        <td colspan="2" class="border-right-fntsize12"><?php echo $arrBank_Acc[1]; ?></td>
        </tr>
      <tr>
	  <td  class="border-bottom-left">FAX # </td>
        <td colspan="3" class="border-bottom-fntsize12"><?php if($buyerFax == '')
																	$buyerFax= '&nbsp;';
																	echo $buyerFax;		 ?></td>
        <td colspan="2" class="border-bottom-left-fntsize12" style="font-weight:bold">SWIFT CODE</td>
        <td colspan="2" class="border-bottom-right-fntsize12"><?php echo ($bankSwiftCode == ''?'&nbsp;':$bankSwiftCode); ?></td>
        </tr>
      <tr>
        <td colspan="4" class="border-bottom-left-fntsize12" style="font-weight:bold">FINAL DESTINATION  <span style="font-weight:normal"><?php echo '&nbsp;&nbsp;'.$finalDestination; ?></span></td>
        <td colspan="2" class="border-bottom-left-fntsize12" style="font-weight:bold">COUNTRY OF ORIGIN </td>
        <td colspan="2" class="border-bottom-right-fntsize12">SRI LANKA</td>
        </tr>
      <tr>
        <td class="border-bottom-left-fntsize12" style="font-weight:bold; text-align:center">STYLE NO </td>
        <td width="94" class="border-bottom-left-fntsize12" style="font-weight:bold; text-align:center">PO NO </td>
        <td colspan="2" class="border-bottom-left-fntsize12" style="font-weight:bold; text-align:center">DESCRIPTION</td>
        <td width="103" class="border-bottom-left-fntsize12" style="font-weight:bold; text-align:center">UNIT</td>
        <td width="87" class="border-bottom-left-fntsize12" style="font-weight:bold; text-align:center">QUANTITY</td>
        <td width="149" class="border-bottom-left-fntsize12" style="font-weight:bold; text-align:center">U/PRICE $ </td>
        <td width="52" class="border-Left-bottom-right-fntsize12" style="font-weight:bold; text-align:center">VALUE # </td>
      </tr>
      <tr>
        <td class="border-left-fntsize12"><?php echo $style; ?></td>
        <td class="border-left-fntsize12"><?php echo $strBuyerPONo; ?></td>
        <td rowspan="2" colspan="2"  class="border-left-fntsize12"><?php echo $strGender.' WEARING APPARELS -'; ?><span style="font-weight:bold">CMPW</span></td>
        <td class="border-left-fntsize12"><?php echo $qtyUnit ?></td>
        <td class="border-left-fntsize12" style="text-align:right"><?php echo number_format($shipQty,0); ?></td>
        <td class="border-left-fntsize12" style="text-align:right"><?php echo number_format($CmpwPrice,2); ?></td>
        <td class="border-left-right-fntsize12" style="text-align:right"><?php $totVal = $shipQty*round($CmpwPrice,2);
		echo number_format($totVal,2);?></td>
      </tr>
      <?php 
 $totVarValue=convert_number(round($totVal,2));
//$convrt=substr(round($totVALUE,2),-2);
$convrt = explode(".",round(trim($totVal),2));

$cents =  (int)$convrt[1];
if($cents<10)
	$cents = $cents.'0';
//$cents = intval($cents);
?>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">VAT</td>
        <td class="border-left-right-fntsize12" style="text-align:right">0.00</td>
      </tr>
      <tr>
       <td class="border-left-fntsize12">&nbsp;</td>
       <td class="border-left-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-bottom-left-fntsize12"><b>CHARGES</b></td>
         <td class="border-bottom-left-fntsize12">&nbsp;</td>
          <td class="border-bottom-left-fntsize12">&nbsp;</td>
          <td class="border-bottom-left-fntsize12">&nbsp;</td>
       <td class="border-Left-bottom-right" style="text-align:right">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-bottom-left">&nbsp;</td>
        <td class="border-bottom-left">&nbsp;</td>
        <td width="100" class="border-bottom-left"  >&nbsp;</td>
          <td width="125" class="border-bottom-fntsize12">Total Amount</td>
        <td class="border-bottom-left">&nbsp;</td>
        <td class="border-bottom-left">&nbsp;</td>
        <td class="border-bottom-left">&nbsp;</td>
        <td class="border-Left-bottom-right " style="text-align:right; font-weight:bold"><?php echo number_format($totVal,2);?></td>
      </tr>
      <tr>
        <td colspan="8" class="border-left-right-fntsize12" style="font-weight:bold">TOTAL US DOLLAR (IN WORDS) : <?php echo strtoupper($totVarValue); ?>&nbsp;AND&nbsp;<?php echo $cents; ?>&nbsp;/&nbsp;100 ONLY</td>
      </tr>
      <tr>
      <?php $vatAmout = $vatRate*$totVal/100; 
	  $totVatValue=convert_number(round($vatAmout,2));  
	  $convrt_vat = explode(".",round($vatAmout,2));
	  ?>
        <td colspan="8" class="border-Left-bottom-right">Suspended VAT amount (US$) : <?php echo strtoupper($totVatValue); ?> AND <?php echo $convrt_vat[1];?> / 100</td>
        </tr>
      <tr>
        <td colspan="8" class="border-left-right-fntsize12" style="font-weight:bold">DESCRIPTION OF GOODS </td>
        </tr>
      <!--<tr>
        <td colspan="7" class="border-left-right-fntsize12">&nbsp;</td>
      </tr>-->
      <tr>
        <td colspan="8" class="border-Left-bottom-right"><table width="73%" border="0">
          <tr>
            <td width="26%" class="normalfnBLD1">GENDER</td>
            <td width="74%" class="normalfnt"><?php echo $strGender.' WEARING APPARELS'; ?></td>
          </tr>
          <tr>
            <td class="normalfnBLD1">FIBER CONTENT </td>
            <td class="normalfnt"><?php echo $itemDesc; ?></td>
          </tr>
          <tr>
            <td class="normalfnBLD1">GARMENT TYPE </td>
            <td class="normalfnt"><?php echo $garmentType; ?></td>
          </tr>
          <tr>
            <td class="normalfnBLD1">BTM/TOPS</td>
            <td class="normalfnt"><?php echo $BTM; ?></td>
          </tr>
          <tr>
            <td class="normalfnBLD1">QUOTA CAT </td>
            <td class="normalfnt"><?php echo $QuataCat; ?></td>
          </tr>
          <tr>
            <td class="normalfnBLD1">HTS CODE </td>
            <td class="normalfnt"><?php echo $usHTSdata; ?></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="8" class="border-Left-bottom-right "><table width="100%" border="0">
          <tr>
            <td colspan="4" class="normalfnBLD1">This order is with in 5% of ordered quantity </td>
            </tr>
          <tr>
            <td colspan="4" class="normalfnBLD1">Title and risk of loss pass to Orit Trading Lanka (Pvt) Ltd at the factory's door. </td>
            </tr>
          <tr>
            <td colspan="4" class="normalfnBLD1">These goods must be directly to the United States </td>
            </tr>
          <tr>
            <td width="19%">&nbsp;</td>
            <td width="48%">&nbsp;</td>
            <td width="7%">&nbsp;</td>
            <td width="26%">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" class="normalfnt">Declaration</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" class="normalfnt">We declare that this invoice show the actual price of goods described &amp; that all particulars are true and correct </td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="normalfnt">Signature</td>
            <?php 
			if($rowFSS["intTaxInvoiceConfirmBy"] != '' && $fsStatus ==1)
			{
			?>
            <td><img src="<?php echo '../../../../upload files/approvalImg/'. $rowFSS["intTaxInvoiceConfirmBy"].'.jpg'; ?>" width="241" height="115"></td>
            <?php 
			}
			else
			{
			?>
             <td>&nbsp;</td>
            <?php 
			}
			?>
            <td class="normalfnt">Date : </td>
            <td ><table width="80%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="normalfntTAB2" style="text-align:left"><?php echo $invoiceDate; ?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td class="normalfnt">Gamini Fernando </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
</table>

