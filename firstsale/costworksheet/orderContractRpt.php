<?php
	session_start();
	include("../../Connector.php");
	$backwardseperator = "../../";
	include "../../eshipLoginDB.php";
	include $backwardseperator."authentication.inc";
	
	$eshipDB = new eshipLoginDB();	
	$styleID = $_GET["styleID"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>ORDER CONTRACT</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<?php 
	$sql_fs = " select intStatus,intExtraApprovalStatus,intExtraApprovalRequired,intFirstApproveBy,intSecondApproveBy from  firstsalecostworksheetheader where intStyleId='$styleID' ";
	$result_fs = $db->RunQuery($sql_fs);
	$rowFS = mysql_fetch_array($result_fs);
	
	$fsStatus = $rowFS["intStatus"];
	$reqExApp = $rowFS["intExtraApprovalRequired"];
	$exAppStatus = $rowFS["intExtraApprovalStatus"];
	$firstAppBy = $rowFS["intFirstApproveBy"];
	$secondAppBy = $rowFS["intSecondApproveBy"];
	
	$pendingStatus = $fsStatus;
	
	if($fsStatus == 0 || $fsStatus==1)
		$pendingStatus = 0;
	else if($fsStatus == 10 && $reqExApp==1 && $exAppStatus !=2)
		$pendingStatus = 0;	
	
	if($pendingStatus == 0)
	{
?>
<div style="position:absolute;top:300px;left:90px;">
<img src="../../images/pending.png">
</div>
<?php 
	}
	if($fsStatus ==11)
	{
?>
<div style="position:absolute;top:200px;left:170px;"><img src="../../images/cancelled.png" style="-moz-opacity:0.20;opacity:0.20;filter:alpha(opacity=20);" /></div>
<?php 
}
	
	$invoiceId = $_GET["invoiceID"];

	$sql_fsData= "Select fss.strOrderNo,fss.strOrderColorCode,fss.strComInvNo,fss.strInvoiceNo,
				date_format(fsh.dtmOTLdate,'%d-%M-%Y') as invDate,fsh.intStyleId,fsh.strOrderContractNo,
date_format(fsh.dtmBPOdate,'%d-%M-%Y') as BPOdate,date_format(fsh.dtmExFactorydate,'%m/%d/%Y') as deliveryDate,
				fss.intPaytermId,fss.intShipmentTermId,fss.dblVatRate,o.intQty,fsh.strFirstApproveRemarks,
				fsh.strSecondApproveRemarks
				from  firstsale_shippingdata fss inner join firstsalecostworksheetheader fsh on
				fss.intStyleId = fsh.intStyleId
				inner join orders o on o.intStyleId = fss.intStyleId and
				o.intStyleId = fsh.intStyleId
				where fss.intStyleId='$styleID' and fss.dblInvoiceId='$invoiceId' ";

	$res_fsData =$db->RunQuery($sql_fsData);
	$rowFS = mysql_fetch_array($res_fsData); 
	
	$orderNo = $rowFS["strOrderNo"];
	$color  = $rowFS["strOrderColorCode"];
	$commInvNo = $rowFS["strComInvNo"];
	$invoiceNo = $rowFS["strInvoiceNo"];
	$invoiceDate = $rowFS["invDate"];
	$BPOdate =$rowFS["BPOdate"];
	$deliveryDate = $rowFS["deliveryDate"];
	
	$payTermId = $rowFS["intPaytermId"];
	$shipTermId = $rowFS["intShipmentTermId"];
	$vatRate = $rowFS["dblVatRate"];
	$shipQty = $rowFS["intQty"]; 
	$intStyleId = $rowFS["intStyleId"]; 
	$orderContractNo = $rowFS["strOrderContractNo"]; 
	
	$sql_shipTerm = "select strShipmentTerm from shipmentterms where strShipmentTermId='$shipTermId'";
	$res_shipTerm = $eshipDB->RunQuery($sql_shipTerm);
	$rowST = mysql_fetch_array($res_shipTerm); 
	
	$shipmentTerm = $rowST["strShipmentTerm"];
	
	$sql_payTerm = "select strPaymentTerm from paymentterm where strPaymentTermID='$payTermId' ";
	$res_payTerm = $eshipDB->RunQuery($sql_payTerm);
	$rowPT = mysql_fetch_array($res_payTerm); 
	
	$payTerm = $rowPT["strPaymentTerm"];
	
	$sql_shipData= "select splh.strProductCode,cid.dblQuantity,cid.strFabric,cid.strDescOfGoods,
			c.strName as customer,c.strAddress1 as cutomerAdd1,c.strAddress2 as cutomerAdd2,c.strCountry custCountry,
			c.strPhone as custPhoneNo,c.strFax as custFaxNo,cid.strBuyerPONo,
			b.strName as buyer,b.strAddress1 as buyerAdd1, b.strAddress2 as buyerAdd2, b.strCountry as buyerCountry,
			b.strPhone as buyerPhoneNo, b.strFax as buyerFaxNo
			from shipmentplheader splh inner join commercial_invoice_detail cid on
			cid.strPLno = splh.strPLNo -- and cid.strBuyerPONo = splh.strStyle 
			inner join commercial_invoice_header cih on cih.strInvoiceNo = cid.strInvoiceNo
			inner join customers c on  c.strCustomerID = cih.strCompanyID
			inner join buyers b on b.strBuyerID = cih.strBuyerID
			where cid.strInvoiceNo ='$commInvNo'  and splh.intStyleId='$intStyleId' ";
			 
			/* if($color != '')
			 	$sql_shipData .= " and splh.strColor = '$color' ";*/
			 
	$res_ShipData = $eshipDB->RunQuery($sql_shipData);
	$rowS = mysql_fetch_array($res_ShipData); 
	
	$customer = $rowS["customer"];
	$customer_add1 = $rowS["cutomerAdd1"];
	$customer_add2 = $rowS["cutomerAdd2"];
	$customer_country = $rowS["custCountry"];
	$customerPhoneNo = $rowS["custPhoneNo"];
	$custFaxNo = $rowS["custFaxNo"];
	
	$buyer = 	$rowS["buyer"];
	$buyer_add1 = $rowS["buyerAdd1"];
	$buyer_add2 = $rowS["buyerAdd2"];
	$buyer_country	 = $rowS["buyerCountry"]; 
	$buyerPhoneNo = $rowS["buyerPhoneNo"]; 
	$buyerFax = $rowS["buyerFaxNo"]; 
	
	$itemDesc = $rowS["strFabric"]; 
	$itemDescOther = $rowS["strDescOfGoods"];
	$strBuyerPONo = $rowS["strBuyerPONo"];
	
	$styleNo = $rowS["strProductCode"]; 
	//$shipQty = $rowS["dblQuantity"];  
	
	$sql_cmpw = "select sum(fsd.dblValue) as cmpwprice 
				from firstsalecostworksheetdetail fsd 
				where fsd.intStyleId = '$styleID' and fsd.strType=4 ";
				
				$result_cmpw  =$db->RunQuery($sql_cmpw);
				$row_cmpw = mysql_fetch_array($result_cmpw);
				
				$CmpwPrice = $row_cmpw["cmpwprice"];
				
	$xmlObj = simplexml_load_file('../../company.xml');
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
?>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>

  <tr>
    <td class="head2BLCK"><?php echo strtoupper($comName); ?></td>
  </tr>
 <!-- <tr>
    <td>&nbsp;</td>
  </tr>-->
  <tr>
    <td height="25" class="bigfntnm1mid" ><?php echo strtoupper($comAddress1).', '.strtoupper($comAddress2).', '.strtoupper($comStreet).', '.strtoupper($comCity).'. '.strtoupper($comCountry); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="head2BLCK">ORDER CONTRACT</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="800" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td colspan="2" class="border-top-bottom-left-fntsize12 " style="font-weight:bold">MANUFACTURER NAME &amp; ADDRESS</td>
        <td colspan="2" height="25" class="border-top-left-fntsize12" style="font-weight:bold">PURCHASE ORDER NO</td>
        <td colspan="2" class="border-top-right-fntsize12"><?php echo ($orderContractNo ==''?'&nbsp;':$orderContractNo); ?></td>
        </tr>
      <tr>
        <td colspan="2" rowspan="5" class="border-bottom-left"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:Verdana; font-size:12px;">
          <tr>
            <td height="28"><?php echo strtoupper($customer); ?></td>
          </tr>
          <tr>
            <td height="28"><?php echo strtoupper($customer_add1).' '.strtoupper($customer_add2); ?></td>
          </tr>
          <tr>
            <td height="28"><?php echo strtoupper($customer_country); ?></td>
          </tr>
          <tr>
            <td height="25"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:Verdana; font-size:12px;">
              <tr>
                <td width="22%" height="28">TEL #</td>
                <td width="78%"><?php echo $customerPhoneNo; ?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="25"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:Verdana; font-size:12px;">
              <tr>
                <td width="22%" height="28">FAX #</td>
                <td width="78%"><?php echo $custFaxNo; ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td colspan="2" class="border-left-fntsize12" style="font-weight:bold">DATE</td>
        <td colspan="2" class="border-right-fntsize12"><?php echo $invoiceDate; ?></td>
        </tr>
      
      <tr>
        <td colspan="4" class="border-Left-bottom-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td height="39" colspan="4" class="border-left-right-fntsize12"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:Verdana; font-size:12px;">
          <tr>
            <td width="34%" height="25" style="font-weight:bold">ULTIMATE BUYER</td>
            <td width="66%"><?php echo $buyer; ?></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td height="36" colspan="2" class="border-left-fntsize12" style="font-weight:bold">ULTIMATE BUYER PO NO</td>
        <td colspan="2" class="border-right-fntsize12"><?php echo $strBuyerPONo; ?></td>
        </tr>
      <tr>
        <td colspan="2" class="border-bottom-left-fntsize12" style="font-weight:bold">PO DATE</td>
        <td colspan="2" class="border-bottom-right-fntsize12"><?php echo $BPOdate; ?></td>
        </tr>
      <tr>
        <td colspan="6">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2" class="border-top-bottom-left-fntsize12 " style="font-weight:bold">BUYER NAME &amp; ADDRESS</td>
        <td colspan="2" class="border-top-left-fntsize12" height="22" style="font-weight:bold">TERMS OF PAYMENT</td>
        <td colspan="2" class="border-top-right-fntsize12"><?php echo $payTermId; ?></td>
        </tr>
      <tr>
        <td colspan="2" rowspan="8" class="border-bottom-left-fntsize12" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:Verdana; font-size:12px">
          <tr>
            <td height="25"><?php echo strtoupper($comName); ?></td>
          </tr>
          <tr>
            <td height="25"><?php echo strtoupper($comAddress1).','.strtoupper($comAddress2);?></td>
          </tr>
          <tr>
            <td height="25"><?php echo strtoupper($comStreet).','.strtoupper($comCity); ?></td>
          </tr>
          <tr>
            <td height="25"><?php echo strtoupper($comCountry); ?></td>
          </tr>
          <tr>
            <td height="25">TEL # <?php echo '&nbsp;'.$comstrPhone; ?></td>
          </tr>
          <tr>
            <td height="25">FAX # <?php echo '&nbsp;'.$comFax; ?></td>
          </tr>
        </table></td>
        <td colspan="2" class="border-left-fntsize12" style="font-weight:bold">SHIPPING TERMS</td>
        <td colspan="2" class="border-right-fntsize12"><?php echo $shipmentTerm; ?></td>
        </tr>
      <tr>
        <td colspan="4" class="border-Left-bottom-right-fntsize12"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:Verdana; font-size:12px;">
          <tr>
            <td width="27%" height="20" style="font-weight:bold">PRICE</td>
            <td width="73%">CMPW $/<?php echo number_format($CmpwPrice,2); ?> PER PRICE</td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="4" class="border-Left-bottom-right-fntsize12" height="25" style="font-weight:bold">ULTIMATE CONSINGNEE</td>
        </tr>
      <tr>
        <td colspan="4" height="25" class="border-left-right-fntsize12"><?php echo $buyer; ?></td>
        </tr>
      <tr>
        <td colspan="4" height="25" class="border-left-right-fntsize12"><?php echo $buyer_add1.' '.$buyer_add2; ?></td>
        </tr>
      <tr>
        <td colspan="4" height="25" class="border-left-right-fntsize12"><?php echo ($buyer_country==''?'&nbsp;':$buyer_country); ?></td>
        </tr>
      <tr>
        <td colspan="2" height="25" class="border-left-fntsize12">TEL #</td>
        <td colspan="2" height="25" class="border-right-fntsize12"><?php 
		if($buyerPhoneNo == '')
			$buyerPhoneNo='&nbsp;';
		echo $buyerPhoneNo; ?></td>
        </tr>
      <tr>
        <td colspan="2" height="25" class="border-bottom-left-fntsize12">FAX #</td>
        <td colspan="2" class="border-bottom-right-fntsize12"><?php 
		if($buyerFax == '')
			$buyerFax='&nbsp;';
		echo $buyerFax; ?></td>
        </tr>
      <tr>
        <td width="209">&nbsp;</td>
        <td width="119">&nbsp;</td>
        <td width="118">&nbsp;</td>
        <td width="110">&nbsp;</td>
        <td width="117">&nbsp;</td>
        <td width="103">&nbsp;</td>
      </tr>
      <tr>
        <td height="56" class="border-top-bottom-left-fntsize12" style="font-weight:bold; text-align:center">DESCRIPTION</td>
        <td class="border-top-bottom-left-fntsize12" style="font-weight:bold; text-align:center">STYLE NO</td>
        <td class="border-top-bottom-left-fntsize12" style="font-weight:bold; text-align:center">ORDER QUANTITY (PCS)</td>
        <td class="border-top-bottom-left-fntsize12" style="font-weight:bold; text-align:center">UNIT PRICE(US$)</td>
        <td class="border-top-bottom-left-fntsize12" style="font-weight:bold; text-align:center">TOTAL PRICE(US$)</td>
        <td class="border-All-fntsize12" style="font-weight:bold; text-align:center">DELIVERY DATE</td>
      </tr>
      <tr>
        <td height="45" class="border-bottom-left"><?php echo $itemDesc.' '.$itemDescOther; ?></td>
        <td class="border-bottom-left"><?php echo getStyleName($styleID); ?></td>
        <td class="border-bottom-left" style="text-align:right"><?php echo number_format($shipQty); ?></td>
        <td class="border-bottom-left" style="text-align:right"><?php echo number_format($CmpwPrice,2); ?></td>
        <td class="border-bottom-left" style="text-align:right"><?php 
		$totPrice = round($CmpwPrice,2)*$shipQty;
		echo number_format($totPrice,2);
		?></td>
        <td class="border-Left-bottom-right"><?php echo $deliveryDate; ?></td>
      </tr>
      <tr>
        <td colspan="6" height="5"></td>
        </tr>
      <tr>
        <td colspan="6" class="border-All-fntsize12"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:Verdana; font-size:12px;">
          <tr>
            <td width="17%" height="26" style="font-style:italic">APPAREL REMARKS :</td>
            <td width="83%" class="normalfntTAB2" style="text-align:left">&nbsp;<?php echo $rowFS["strFirstApproveRemarks"]; ?></td>
          </tr>
          <tr>
            <td height="20">&nbsp;</td>
            <td class="normalfntTAB2">&nbsp;</td>
          </tr>
        </table></td>
        </tr>
        <tr><td colspan="6" height="5"></td></tr>
         <tr>
        <td colspan="6" class="border-All-fntsize12"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:Verdana; font-size:12px;">
          <tr>
            <td width="17%" height="28" style="font-style:italic">TRADING REMARKS :</td>
            <td width="83%" class="normalfntTAB2" style="text-align:left">&nbsp;<?php echo $rowFS["strSecondApproveRemarks"]; ?></td>
          </tr>
          <tr>
            <td height="20">&nbsp;</td>
            <td class="normalfntTAB2">&nbsp;</td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="6" height="5"></td>
        </tr>
      <tr>
        <td colspan="6" class="border-All-fntsize12"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt_size12">
          <tr>
            <td colspan="4"  height="20">NOTES</td>
            </tr>
          <tr>
            <td width="15%">&nbsp;</td>
            <td width="34%">&nbsp;</td>
            <td width="15%">&nbsp;</td>
            <td width="36%">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" height="20">1. This Merchandise must be send directly to the United States.</td>
            </tr>
          <tr>
            <td colspan="4" height="20">2. Orit Trading Lanka (Pvt) Ltd will accept merchandise within 5% of the quantity listed on this contract.</td>
            </tr>
          <tr>
            <td colspan="4" height="20" style="font-weight:bold">3. Title &amp; Risk of Loss pass the factory to Orit Trading Lanka(Pvt) Ltd at the factory's door.</td>
            </tr>
          <tr>
            <td height="20">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          
         
         
          <tr>
            <td height="20">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="20" valign="bottom">CONFIRMED BY</td>
            <td><table width="76%" border="0" cellspacing="0" cellpadding="0" height="115">
              <tr>
              <?php 
			  if($reqExApp == 1 && ($exAppStatus==2))
			  {
			 			  
			  ?>
                <td width="73%" height="20" class="normalfntTAB2"><img src="<?php echo '../../upload files/approvalImg/'. $secondAppBy.'.jpg'; ?>" width="241" height="115"></td>
                <?php 
				}
				else
				{	
				?>
                 <td width="14%" height="20" valign="bottom" class="normalfntTAB2" >&nbsp;</td>
                <?php 
				}
				?>
              
              </tr>
            </table></td>
            <td valign="bottom">RECEIVED BY</td>
            <td valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
              <?php 
			  if($reqExApp == 1 && $exAppStatus ==1 || $exAppStatus==2)
			  {
			 
			  
			  ?>
                <td width="80%" height="20" class="normalfntTAB2"><img src="<?php echo '../../upload files/approvalImg/'.$firstAppBy.'.jpg'; ?>" width="241" height="115"></td>
                <?php 
				}
				else
				{	
				?>
                <td width="80%" height="20" valign="bottom" class="normalfntTAB2" >&nbsp;</td>
                <?php 
				}
				?>
                <td width="20%">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="20" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt_size12">
              <tr>
                <td width="61%" height="20">AUTHORISED SIGNATORY NAME BY</td>
                <td width="39%">&nbsp;</td>
              </tr>
            </table></td>
            <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt_size12">
              <tr>
                <td width="65%" height="20">AUTHORISED SIGNATORY NAME BY</td>
                <td width="35%">&nbsp;</td>
              </tr>
            </table></td>
            </tr>
          <tr>
            <td height="20" colspan="2">ORIT TRADING LANKA (PVT) LTD</td>
            <td colspan="2">ORIT APPARELS LANKA (PVT) LTD</td>
            </tr>
          <tr>
            <td height="20">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php 
function getStyleName($styleID)
{
	global $db;
	$sql = "select strStyle from orders where intStyleId='$styleID'";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["strStyle"];
}
?>
</body>
</html>
