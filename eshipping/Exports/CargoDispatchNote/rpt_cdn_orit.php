<?php 
	$invoiceno=$_GET["invoiceno"];
	$pono=$_GET["pono"];
	session_start();
	include "../../Connector.php";
$str="select 	ih.strBuyerID as consigneeid, 
	ih.strCompanyID as exporterid, 
	ih.strNotifyID1 as NotifyID, 
	cdn.strCDNNo, 
	cdn.strInvoiceNo, 
	cdn.strVoyageNo, 
	cdn.strCarrier,
	date(cdn.dtmSailingDate)as dtmSailingDate, 
	(SELECT strCity FROM city C WHERE C.strCityCode=ih.strFinalDest)AS ihdestination,
	cdn.strPortOfDischarge, 
	cdn.strExVesel, 
	cdn.strPlaceOfDelivery, 
	cdn.strAuthorisedS, 
	cdn.strDescriptionOfGoods, 
	cdn.dblGrossWt, 
	cdn.dblNetWt as dblNetWt, 
	cdn.dblCBM, 
	cdn.strLorryNo, 
	cdn.strBLNo, 
	cdn.dblTareWt, 
	cdn.strSealNo, 
	cdn.strDriverName, 
	cdn.strCleanerName, 
	cdn.strOthres, 
	cdn.strDeclarentName, 
	cdn.strCustomerEntry, 
	cdn.strMarks, 
	cdn.dblHieght, 
	cdn.dblLength, 
	cdn.strType, 
	cdn.dblTemperature, 
	cdn.strDelivery, 
	cdn.strReciept, 
	cdn.strRemarks, 
	cdn.strUserId, 
	cdn.dtmCreateDate, 
	cdn.strVSLOPRCode, 
	cdn.strCNTOPRCode,
	sn.strSLPANo,
	ih.strMarksAndNos as ihmarks,
	ih.strPortOfLoading as ihportofloading,
	ih.strGenDesc as ihdesc
	 
	
	from 
	cdn cdn
	inner join invoiceheader ih on ih.strInvoiceNo=cdn.strInvoiceNo
	left join shippingnote sn on sn.strInvoiceNo=cdn.strInvoiceNo
	where cdn.strInvoiceNo='$invoiceno'";
	
$result=$db->RunQuery($str);
$row=mysql_fetch_array($result);
											$consigneeid=$row["consigneeid"];
											$exporterid=$row["exporterid"];
											$LorryNo=$row["strLorryNo"];
											$BLNo=$row["strBLNo"];
											$TareWt=$row["dblTareWt"];
											$SLPANo=$row["strSLPANo"];
											$SealNo=$row["strSealNo"];
											$CustomerEntry=$row["strCustomerEntry"];
											$DriverName=$row["strDriverName"];
											$CleanerName=$row["strCleanerName"];
											$SailingDate=explode("-",$row["dtmSailingDate"]);
											$SailingDate=$SailingDate[2]."/".$SailingDate[1]."/".$SailingDate[0];
											$VoyegeNo=$row["strVoyageNo"];
											$marks=$row["strMarks"];
											$gendesc=$row["strDescriptionOfGoods"];
											$strCarrier=$row["strCarrier"];
											$ihdesc=$row["ihdesc"];
											$ihportofloading=$row["ihportofloading"];
											$ihdestination=$row["strPortOfDischarge"];
											$ihmarks=$row["ihmarks"];
											if ($marks=="")
												$marks=$ihmarks;
											if ($gendesc=="")
												$gendesc=$ihdesc;
											$ctnoprCode=$row["strCNTOPRCode"];
											$vsloprCode=$row["strVSLOPRCode"];
											$signatory=$row["strAuthorisedS"];
											$height=$row["dblHieght"];
											$length=$row["dblLength"];
											$type=$row["strType"];
											$temperature=$row["dblTemperature"];
											$gross=$row["dblGrossWt"];
											$net=$row["dblNetWt"];
											$exvessel=$row["strExVesel"];
											$cbm=$row["dblCBM"];
											$DeclarentName=$row["strDeclarentName"];
		$str_signatory="select 	strName, strPhone, strIdNo from	wharfclerks where intWharfClerkID='$signatory'";
		$results_signatury=$db->RunQuery($str_signatory);
		$row_signatury=mysql_fetch_array($results_signatury);
		$signatory_name=$row_signatury["strName"]; 
		$signatory_Phone=$row_signatury["strPhone"]; 
		$signatory_id=$row_signatury["strIdNo"]; 
		
		$str_Declarent="select 	strName, strPhone, strIdNo from	wharfclerks where intWharfClerkID='$DeclarentName'";
		$results_Declarent=$db->RunQuery($str_Declarent);
		$row_Declarent=mysql_fetch_array($results_Declarent);
		$Declarent_name=$row_signatury["strName"]; 
		$Declarent_Phone=$row_signatury["strPhone"]; 
		$Declarent_id=$row_signatury["strIdNo"]; 
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>eShipping Web - Export CDN :: Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.latter{
font-family: Verdana;
	font-size: 12px;
	color: #000000;
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:600;
}
</style>

</head>

<body>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="900"class="cusdec-normalfnt2bldBLACK"align="center" height="33" valign="bottom">CARGO DISPATCH NOTE / FCL CONTAINER LOAD PLAN - EXP 3b </td>
  </tr>
  <tr>
    <td  valign="top"><table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td height="100"colspan="4" rowspan="4" class="border-top-left-fntsize12" style="vertical-align:top" ><table width="447" height="92" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="450" height="5">&nbsp;&nbsp;1. a Shipper(Name and Address) </td>
            </tr>
          <?php
  		$sqlExporter="select 	strCustomerID, 
								intSequenceNo, 
								strName, 
								strAddress1, 
								strAddress2, 
								strCountry, 
								strPhone, 
								strFax, 
								strEMail, 
								strRemarks, 
								strTIN, 
								strCode, 
								strLocation, 
								strTQBNo, 
								strExportRegNo, 
								strRefNo, 
								strCompanyCode, 
								RecordType, 
								strPPCCode, 
								bitLocatedAtAZone, 
								strAuthorizedPerson, 
								strVendorCode, 
								strMIDCode, 
								bitMailClearanceInfo, 
								intDelStatus 
								from 
								customers 
								where strCustomerID='$exporterid';";
		$sqlResultEx=$db->RunQuery($sqlExporter);
		$rowExporter=mysql_fetch_array($sqlResultEx);
		$exportername=$rowExporter["strName"];
		$exporteraddress1=$rowExporter["strAddress1"];
		$exporteraddress2=$rowExporter["strAddress2"];
		$exportercountry=$rowExporter["strCountry"];
  ?>
            <tr>
              <td height="15">&nbsp;&nbsp;<strong><?php echo $exportername1."ORIT TRADING LANKA (PVT) LTD" ; ?></strong></td>
            </tr>
            <tr>
              <td height="15">&nbsp;&nbsp;<strong><?php echo $exporteraddress1; ?></strong></td>
            </tr>
            <tr>
              <td height="15">&nbsp;&nbsp;<strong><?php echo $exporteraddress2; ?></strong></td>
            </tr>
            <tr>
              <td height="15">&nbsp;&nbsp;<strong><?php echo $exportercountry; ?></strong></td>
            </tr>
        </table></td>
        <td height="100" colspan="2" class="border-top-left-fntsize12">&nbsp;&nbsp;7. Lorry Trailer No </td>
        <td colspan="2" class="border-Left-Top-right-fntsize12">&nbsp;&nbsp;8. SN / (B/L) No. </td>
      </tr>
      <tr>
        <td height="25" colspan="2" class="border-left-fntsize12">&nbsp;&nbsp;<strong><?php echo $LorryNo; ?></strong></td>
        <td colspan="2"  class="border-left-right-fntsize12">&nbsp;&nbsp;<strong><?php echo $BLNo; ?></strong></td>
      </tr>
      <tr>
        <td height="25" colspan="2" class="border-top-left-fntsize12">&nbsp;&nbsp;9. Tare Wt.(Kg) </td>
        <td colspan="2" class="border-Left-Top-right-fntsize12">&nbsp;&nbsp;10. SLPA No </td>
      </tr>
      <tr>
        <td height="18" colspan="2" class="border-left-fntsize12">&nbsp;&nbsp;<strong><?php echo $TareWt; ?></strong></td>
        <td colspan="2" class="border-left-right-fntsize12">&nbsp;&nbsp;<strong><?php echo $SLPANo; ?></strong></td>
      </tr>
      <tr>
        <td height="100" colspan="4" rowspan="8" style="vertical-align:top" class="border-top-left-fntsize12"><table width="447" height="100" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="447" height="5">&nbsp;&nbsp;1. b Consignee(Name and Address)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; OUR REF. EX-1030.</td>
            </tr>
            <?php 
  	$sqlConsignee="select 	strBuyerID, 
	strName, 
	strAddress1, 
	strAddress2, 
	strCountry, 
	strPhone, 
	strFax, 
	strEMail, 
	strRemarks, 
	strTINNo
	 
	from 
	buyers 
	where strBuyerID='$consigneeid'";	
	$resultConsignee=$db->RunQuery($sqlConsignee);
	$rowConsignee=mysql_fetch_array($resultConsignee);	
	
				$ConsigneeName=$rowConsignee["strName"];
				$ConsigneeAddress1=$rowConsignee["strAddress1"];
				$ConsigneeAddress2=$rowConsignee["strAddress2"];
				$ConsigneeCountry=$rowConsignee["strCountry"];
  ?>
            <tr>
              <td height="15">&nbsp;&nbsp;<strong><?php echo $ConsigneeName; ?></strong></td>
            </tr>
            <tr>
              <td height="15">&nbsp;&nbsp;<strong><?php echo $ConsigneeAddress1; ?></strong></td>
            </tr>
            <tr>
              <td height="15">&nbsp;&nbsp;<strong><?php echo $ConsigneeAddress2; ?></strong></td>
            </tr>
           <tr>
              <td height="15">&nbsp;&nbsp;<strong><?php echo $ConsigneeCountry; ?></strong></td>
            </tr>
            <tr>
              <td height="15"><table width="100" border="0" cellspacing="0" cellpadding="0" align="right">
                <tr>
                  <td class="border-All">&nbsp;</td>
                </tr>
              </table></td>
            </tr> 
        </table></td>
        <td height="100"colspan="2" class="border-top-left-fntsize12">&nbsp;&nbsp;11. Seal No. 9308 </td>
        <td height="100"colspan="2" class="border-Left-Top-right-fntsize12">&nbsp;&nbsp;11 B Customer Entry </td>
      </tr>
      <tr>
        <td height="25"colspan="2" class="border-left-fntsize12">&nbsp;&nbsp;<?php 
		$sealno_array=explode("/",$SealNo);
		$SealNo1=$sealno_array[0]."/";
		$SealNo2=$sealno_array[1];
		echo $SealNo1; ?><strong><?php echo $SealNo2;?></strong></td>
        <td height="25"colspan="2" class="border-left-right-fntsize12">&nbsp;&nbsp;<strong><?php echo $CustomerEntry; ?></strong></td>
      </tr>
      <tr>
        <td height="12" colspan="4" class="border-Left-Top-right-fntsize12">&nbsp;&nbsp;12. Name of Driver </td>
      </tr>
      <tr>
        <td height="25" colspan="4" class="border-left-right-fntsize12">&nbsp;&nbsp;<strong><?php echo $DriverName; ?></strong></td>
      </tr>
	 
      <tr>
        <td height="12" colspan="4" class="border-Left-Top-right-fntsize12">&nbsp;&nbsp;13. Name of Cleaner </td>
      </tr>
      <tr>
        <td height="25" colspan="4" class="border-left-right-fntsize12">&nbsp;&nbsp;<strong><?php echo $CleanerName; ?></strong></td>
      </tr>
      <tr>
        <td height="12" colspan="4" class="border-Left-Top-right-fntsize12">&nbsp;&nbsp;14. Any Others Accompanying </td>
      </tr>
      <tr>
        <td height="18" colspan="4" class="border-left-right-fntsize12">&nbsp;&nbsp;<strong><?php echo ""; ?></strong></td>
      </tr>
      <tr>
        <td width="114" height="50" rowspan="4" class="border-top-left-fntsize12" valign="top"><div  class="normalfnt">&nbsp;&nbsp;&nbsp;2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; B </div></td>
        <td width="114" rowspan="4" class="border-top-left-fntsize12" valign="top"><div  class="normalfnt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; R </div></td>
        <td width="114" rowspan="4" class="border-top-left-fntsize12" valign="top"><div  class="normalfnt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; S </div></td>
        <td width="113" rowspan="4" class="border-top-left-fntsize12" valign="top"><div  class="normalfnt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; L </div></td>
        <td colspan="4" class="border-Left-Top-right-fntsize12">&nbsp;&nbsp;15. Time of Departure from Stores/CFS . </td>
      </tr>
      <tr>
        <td colspan="4" class="border-left-right-fntsize12"   >&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" class="border-left-right-fntsize12"  style="text-align:justify" >&nbsp;&nbsp; The container/lorry was stuffed/loaded under strict strict security&nbsp;condition &amp; I certify that this container/lorry is safe to behandled in&nbsp;the port. </td>
      </tr>
      <tr>
        <td colspan="4" class="border-left-right-fntsize12"   >&nbsp;</td>
      </tr>
      <tr>
        <td height="15" colspan="2" class="border-top-left-fntsize12">&nbsp;&nbsp;3.a Voyge No./Date 8228</td>
        <td colspan="2" class="border-top-left-fntsize12">&nbsp;&nbsp;3. b Ex-Vessel </td>
        <td colspan="4" class="border-left-right-fntsize12" >&nbsp;&nbsp;16. Name of Certifying security officer/authorized signatory.</td>
      </tr>
      <tr>
        <td height="32" colspan="2"  class="border-left-fntsize12">&nbsp;&nbsp;<strong><?php echo $VoyegeNo." ".$SailingDate;?></strong></td>
        <td colspan="2" class="border-left-fntsize12">&nbsp;&nbsp;<strong><?php echo $exvessel;?></strong></td>
        <td colspan="4" class="border-left-right-fntsize12" >
          <div align="center"><strong><?php echo $signatory_name." ".$signatory_id; ?></strong> </div></td>
      </tr>
      <tr>
        <td height="15" colspan="2" class="border-top-left-fntsize12">&nbsp;&nbsp;4. Veessel 8122/3</td>
        <td colspan="2" class="border-top-left-fntsize12">&nbsp;&nbsp;6. Port of loading</td>
        <td colspan="4" class="border-left-right-fntsize12"  >
          <div align="center"><strong><?php echo $signatory_Phone; ?></strong></div></td>
      </tr>
      <tr>
        <td height="29" colspan="2" class="border-left-fntsize12" >&nbsp;&nbsp;<strong><?php echo $strCarrier; ?></strong></td>
        <td colspan="2" class="border-left-fntsize12">&nbsp;&nbsp;<strong><?php echo $ihportofloading; ?></strong></td>
        <td colspan="4" class="border-left-right-fntsize12"  >&nbsp;&nbsp;17. Signature, Designation and Date</td>
      </tr>
      <tr>
        <td height="15" colspan="2" class="border-top-left-fntsize12">&nbsp;&nbsp;5. Port of Discharge 3424/5 </td>
        <td class="border-top-left-fntsize12">&nbsp;&nbsp;VSL.OPR.CODE</td>
        <td class="border-top-left-fntsize12">&nbsp;&nbsp;CTN.OPR.CODE</td>
        <td colspan="4" class="border-left-right-fntsize12" >&nbsp;</td>
      </tr>
      <tr>
        <td height="29" colspan="2" class="border-left-fntsize12" >&nbsp;&nbsp;<strong><?php echo $ihdestination; ?></strong></td>
        <td class="border-left-fntsize12">&nbsp;&nbsp;<strong><?php echo $vsloprCode; ?></strong></td>
        <td class="border-left-fntsize12">&nbsp;&nbsp;<strong><?php echo $ctnoprCode; ?></strong></td>
        <td   class="border-left-fntsize12">&nbsp;</td>
        <td   ><?php echo date("d/m/Y");?></td>
        <td   >&nbsp;</td>
        <td   class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="border-top-left-fntsize12">18. Marks &amp; Numbers/Container </td>
        <td colspan="2" class="border-top-fntsize12">&nbsp;&nbsp;
          19. Number &amp; Kind of packages </td>
        <td colspan="2" class="border-top-fntsize12">&nbsp;&nbsp;
          20. Description of Codes*</td>
        <td width="84" height="21" class="border-top-left-fntsize12">&nbsp;21.(a)Gross Wt.</td>
        <td width="113" class="border-Left-Top-right-fntsize12">&nbsp;22. Cube CBM </td>
      </tr>
      <tr>
        <td height="10" colspan="2" class="border-left-fntsize12">&nbsp;No.</td>
        <td >&nbsp; &nbsp; 224 </td>
        <td ><div align="right">7064/5 &nbsp; &nbsp; </div></td>
        <td colspan="2" >&nbsp;&nbsp;&nbsp;&nbsp;7002</td>
        <td height="10" class="border-left-fntsize12"><div align="center">(Kg.)6292</div></td>
        <td width="113"  class="border-left-right-fntsize12"><div align="center">6324</div></td>
      </tr>
      <tr>
        <td colspan="2" class="border-left-fntsize12">&nbsp;&nbsp;7102</td>
        <td colspan="2" align="center" ><table width="67" height="15" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="67" class="border-All-fntsize12"><div align="center" >NOSE</div></td>
            </tr>
        </table></td>
        <td colspan="2" >&nbsp;</td>
        <td height="10" class="border-left-fntsize12"><div align="center"><strong><?php echo number_format($gross,2); ?></strong></div></td>
        <td width="113"  class="border-left-right-fntsize12"><div align="center"><strong><?php echo $cbm; ?></strong></div></td>
      </tr>
      <tr>
        <td colspan="6" rowspan="10" valign="top" class="border-left-fntsize12"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
          <tr>
            <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
          <tr>
            <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td class="border-bottom-fntsize12" style="text-align:center">P.O. #</td>
                <td class="border-bottom-fntsize12" style="text-align:center">ISD</td>
                <td class="border-bottom-fntsize12" style="text-align:center">PCS</td>
                <td class="border-bottom-fntsize12" style="text-align:center">CTNS</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
          <tr>
            <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
          <?php $str__powise_desc="select 	strInvoiceNo, 
							strPONO, 
							strISDNo, 
							strPCS, 
							strCTNS, 
							dblNetWt, 
							dblGrossWt, 
							strCBM
							 
							from 
							powisecdn
							where
							strInvoiceNo='$invoiceno' and strPONO='$pono'";
							
							$result_powise_desc=$db->RunQuery($str__powise_desc);
							while($row_wise_cdn=mysql_fetch_array($result_powise_desc)){
							?>
          <tr>
            <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td style="text-align:center"><?php echo $row_wise_cdn["strPONO"];?></td>
                <td style="text-align:center"><?php echo $row_wise_cdn["strISDNo"];?></td>
                <td style="text-align:center"><?php echo $row_wise_cdn["strPCS"];?></td>
                <td style="text-align:center"><?php echo $row_wise_cdn["strCTNS"];?></td>
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
                <td>&nbsp;</td>
              </tr><?php }?>
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
                <td>&nbsp;</td>
              </tr>
              <tr>
            <td width="12%">&nbsp;</td>
                <td width="12%">&nbsp;</td>
                <td width="12%">&nbsp;</td>
                <td width="12%">&nbsp;</td>
                <td width="12%">&nbsp;</td>
                <td width="12%">&nbsp;</td>
                <td width="12%">&nbsp;</td>
                <td width="12%">&nbsp;</td>
              </tr>
        </table></td>
        <td height="10" class="border-left-fntsize12">&nbsp;</td>
        <td  class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td height="10" class="border-top-left-fntsize12">&nbsp;21.(b)Net Wt.</td>
        <td width="113"  class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td height="10" class="border-left-fntsize12"><div align="center">(Kg.)6160</div></td>
        <td width="113"  class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td height="10" class="border-left-fntsize12"><div align="center"><strong><?php echo number_format($net,2)?></strong></div></td>
        <td width="113"  class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td height="10" class="border-left-fntsize12">&nbsp;</td>
        <td  class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td height="10" class="border-top-left-fntsize12">&nbsp;21.(c) 6294</td>
        <td width="113"  class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td height="10" class="border-left-fntsize12">&nbsp;</td>
        <td width="113"  class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td height="10" class="border-left-fntsize12">&nbsp;&nbsp;</td>
        <td width="113"  class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td height="10"  class="border-left-fntsize12">&nbsp;</td>
        <td  class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      
      
      <tr>
        <td height="10" class="border-left-fntsize12">&nbsp;</td>
        <td width="113"  class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="2" class="border-left-fntsize12"><div align="center"><?php echo $invoiceno;?></div></td>
        <td colspan="4" valign="top">&nbsp;</td>
        <td height="5" class="border-left-fntsize12">&nbsp;</td>
        <td width="113"  class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="2" align="center" ><table width="67" height="15" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="67" class="border-All-fntsize12"><div align="center" >DOOR</div></td>
            </tr>
        </table></td>
        <td colspan="2" >&nbsp;</td>
        <td height="5" class="border-left-fntsize12">&nbsp;</td>
        <td width="113"  class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td height="26" colspan="3" class="border-top-left-fntsize12">&nbsp;&nbsp;21. Type of container </td>
        <td colspan="2" class="border-top-left-fntsize12" >&nbsp;31. Custom Export Office</td>
        <td colspan="3" class="border-Left-Top-right-fntsize12">&nbsp;&nbsp;&nbsp;Received ....................... Packages / Container </td>
      </tr>
      <tr>
        <td height="20" colspan="3" class="border-left-fntsize12">&nbsp;&nbsp;&nbsp;Height :<?php echo $height;?> Length :<?php echo $length;?> Type : <?php echo $type;?></td>
        <td colspan="2" class="border-left-fntsize12" >&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;&nbsp;&nbsp;trailer in apparent good order and condition. </td>
      </tr>
      <tr>
        <td height="10" colspan="3" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize12" >&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;</td>
      </tr>
      <tr>
        <td height="10" colspan="3" class="border-left-fntsize12">&nbsp;&nbsp;24. Reefer Temperature Required </td>
        <td colspan="2" class="border-left-fntsize12" >&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;&nbsp;&nbsp;33. SLPA Supervising Officer/ Pier Clerk </td>
      </tr>
      <tr>
        <td height="10" class="border-left-fntsize12"><div align="right"><?php echo $temperature;?></div></td>
        <td height="10" ><sup>o</sup>F</td>
        <td height="10" ><sup>o</sup>C</td>
        <td colspan="2"  class="border-left-fntsize12">&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;</td>
      </tr>
      <tr>
        <td height="10" colspan="3" class="border-left-fntsize12">&nbsp;&nbsp;</td>
        <td colspan="2"  class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;Date</td>
        <td >&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;Signature</td>
      </tr>
      <tr>
        <td height="10" colspan="3" class="border-left-fntsize12">&nbsp;&nbsp;25. Place of Delivery </td>
        <td colspan="2"  class="border-left-fntsize12" >&nbsp;</td>
        <td colspan="3"  class="border-Left-Top-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td height="15" colspan="3" rowspan="2" class="border-left-fntsize12">&nbsp;
            <table width="340" height="18" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="30" height="18"><div align="right">
                  <table width="20" height="15" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="10" class="border-All-fntsize12"><div align="center" >&nbsp;</div></td>
                      </tr>
                    </table>
                </div></td>
                <td width="50"><div align="center">CY</div></td>
                <td width="50"><div align="right">
                  <table width="20" height="15" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="10" class="border-All-fntsize12"><div align="center" >&nbsp;</div></td>
                      </tr>
                    </table>
                </div></td>
                <td width="50"><div align="center">CYS</div></td>
                <td width="50"><div align="right">
                  <table width="20" height="15" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="10" class="border-All-fntsize12"><div align="center" >&nbsp;</div></td>
                      </tr>
                    </table>
                </div></td>
                <td width="50"><div align="center">DOOR</div></td>
              </tr>
          </table></td>
        <td colspan="2" rowspan="2"  class="border-left-fntsize12">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature</td>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;&nbsp;&nbsp;I certify that the commoditiea loaded into </td>
      </tr>
      <tr>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;&nbsp;&nbsp;trailer/lorry mentioned above at our premises </td>
      </tr>
      <tr>
        <td height="10" colspan="3" class="border-left-fntsize12">&nbsp;&nbsp;</td>
        <td colspan="2" class="border-top-left-fntsize12" ><span >&nbsp;32. SLPA Export Office </span></td>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;&nbsp;&nbsp;were packed in our stores under strict security</td>
      </tr>
      <tr>
        <td height="5" colspan="3" class="border-left-fntsize12">&nbsp;&nbsp;26. Place of Receipt </td>
        <td colspan="2" class="border-left-fntsize12" >&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;&nbsp;&nbsp;condition and it is safe for handling </td>
      </tr>
      <tr>
        <td height="2" colspan="3" class="border-left-fntsize12">&nbsp;
            <table width="340" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><div align="right">
                  <table width="20" height="15" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="10" class="border-All-fntsize12"><div align="center" >&nbsp;</div></td>
                      </tr>
                    </table>
                </div></td>
                <td width="40"><div align="center">CY</div></td>
                <td width="43"><div align="right">
                  <table width="20" height="15" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="10" class="border-All-fntsize12"><div align="center" >&nbsp;</div></td>
                      </tr>
                    </table>
                </div></td>
                <td width="43"><div align="center">PORT</div></td>
                <td width="40"><div align="right">
                  <table width="20" height="15" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="10" class="border-All-fntsize12"><div align="center" >&nbsp;</div></td>
                      </tr>
                    </table>
                </div></td>
                <td width="43"><div align="center">CFS</div></td>
                <td><div align="right">
                  <table width="20" height="15" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="10" class="border-All-fntsize12"><div align="center" >&nbsp;</div></td>
                      </tr>
                    </table>
                </div></td>
                <td><div align="center">DOOR</div></td>
              </tr>
          </table></td>
        <td colspan="2" class="border-left-fntsize12" >&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;</td>
      </tr>
      <tr>
        <td height="3" colspan="3" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize12" >&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;&nbsp;&nbsp;34. Name of Company Preparing this note</td>
      </tr>
      <tr>
        <td height="2" colspan="3" class="border-left-fntsize12">&nbsp;&nbsp;27. Remarks </td>
        <td colspan="2" class="border-left-fntsize12" >&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12" ><dd><strong><?php echo $exportername1."ORIT TRADING LANKA (PVT) LTD" ; ?></strong></td>
      </tr>
      
      <tr>
        <td height="5" colspan="3" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize12" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature</td>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;&nbsp;&nbsp;35. Names of declarent 3140/1 </td>
      </tr>
      <tr>
        <td height="5" colspan="3" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize12" >&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12" ><dd><strong><?php echo $Declarent_name." ".$Declarent_id;	?></strong></td>
      </tr>
      <tr>
        <td height="10" colspan="3" class="border-top-left-fntsize12">&nbsp;28(a). Time of Arrival at Customs Gate </td>
        <td colspan="2" class="border-top-left-fntsize12">&nbsp;28(b). Customs Officer </td>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;</td>
      </tr>
      <tr>
        <td height="10" colspan="3" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;&nbsp;&nbsp;36. Telephone No.</td>
      </tr>
      <tr>
        <td height="10" colspan="3" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12" ><dd>077-0301574 / 0773237253</td>
      </tr>
      <tr>
        <td height="10" colspan="3" class="border-top-left-fntsize12">&nbsp;29(a). Time of Arrival Alongside </td>
        <td colspan="2" class="border-top-left-fntsize12">&nbsp;29(b) Pier Clerk </td>
        <td colspan="3" class="border-left-right-fntsize12" >&nbsp;</td>
      </tr>
      <tr>
        <td height="10" colspan="3" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="3"class="border-left-right-fntsize12" >&nbsp;&nbsp;&nbsp;37. Signature of Declarant</td>
      </tr>
      <tr>
        <td height="10" colspan="3" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
        <td colspan="3"class="border-left-right-fntsize12" ><div align="right">Date&nbsp;&nbsp;</div></td>
      </tr>
      <tr>
        <td height="10" colspan="3" class="border-top-left-fntsize12">&nbsp;30(a). Time &amp; Date Dc..Loanted/Dish </td>
        <td colspan="2" class="border-top-left-fntsize12">&nbsp;30(b). Superviser/Pier Clerk </td>
        <td colspan="3" class="border-left-right-fntsize12" ><div align="center"><?php echo date("d/m/Y");?></div></td>
      </tr>
      
      <tr>
        <td height="10" colspan="3" class="border-bottom-left-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-bottom-left-fntsize12">&nbsp;</td>
        <td colspan="3" class="border-Left-bottom-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td height="10" ></td>
        <td height="10" ></td>
        <td height="10" ></td>
        <td height="10" ></td>
        <td width="111" height="10" ></td>
        <td width="137" height="10" ></td>
        <td height="10" ></td>
        <td height="10" ></td>
      </tr>
    </table></td>
  </tr>
</table>

</body>
</html>
