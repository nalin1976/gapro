<?php 
	session_start();
	include "../../../Connector.php";
	$invoiceNo=$_GET['InvoiceNo'];
	
	   $str="SELECT
				sn.strShippingNoteNo,
				ih.strInvoiceNo,
				ih.strBuyerID AS consigneeid,
				ih.strCompanyID AS exporterid,
				ih.strNotifyID1 AS NotifyID,
				ih.strPortOfLoading,
				ih.strCarrier,
				ih.strVoyegeNo,
				date(ih.dtmSailingDate) AS dtmSailingDate,
				sn.strWarehouseNo,
				sn.strPlaceOfDelivery,
				ih.strE_No,
				sn.strShippingLineName,
				sn.dtmShNoteDate,
				sn.strExporterRegNo,
				ih.strSLPANo,
				ih.strPortOfDischarge,
				ih.strBLNo,
				ih.strVslOprCode,
				ih.strCtnOprCode,
				sn.strNameOfDeclarent,
				sn.strUserId,
				soldto.strName AS soldtoName,
				soldto.strAddress1 AS soldtoADD1,
				soldto.strAddress2 AS soldtoADD2,
				soldto.strCountry AS soldtoCountry,
				ih.strE_No,
				ih.strMarksAndNos,
				ih.strVesselName AS preV_name,
				ih.dtmVesselDate AS preV_date,
				ih.strVoyegeNo AS preV_no,
				invoicedetail.dblGrossMass,
				invoicedetail.dblNetMass,
				invoicedetail.intCBM,
				invoicedetail.strDescOfGoods,
				ih.strFinalDest,
				city.strCity
				FROM
				invoiceheader AS ih
				LEFT JOIN shippingnote AS sn ON sn.strInvoiceNo = ih.strInvoiceNo
				LEFT JOIN buyers AS soldto ON soldto.strBuyerID = ih.strSoldTo
				INNER JOIN invoicedetail ON invoicedetail.strInvoiceNo = ih.strInvoiceNo
				INNER JOIN city ON ih.strFinalDest = city.strCityCode
				where 	ih.strInvoiceNo='$invoiceNo'";
//die($str);	
$result=$db->RunQuery($str);
$row=mysql_fetch_array($result);			
											$SailingDate=explode("-",$row["dtmSailingDate"]);
											$SailingDate=$SailingDate[2]."/".$SailingDate[1]."/".$SailingDate[0];
											$consigneeid=$row["consigneeid"];
											$exporterid=$row["exporterid"];
											$NotifyID=$row["NotifyID"];
											$CustomEntryNo=$row["strCustomEntryNo"];
											$BLNo=$row["strBLNo"];
											$ShippingLineName=$row["strShippingLineName"];
											$PlcOfAcceptence=$row["strPlcOfAcceptence"];
											$PlaceOfDelivery=$row["strPlaceOfDelivery"];
											$SLPANo=$row["strSLPANo"];
											$VoyageNo=$row["strVoyageNo"]." ".$SailingDate;
											$WarehouseNo=$row["strWarehouseNo"];
											$Carrier=$row["strCarrier"];
											$PortOfDischarge=$row["strPortOfDischarge"];
											$VslOprCode=$row["strVslOprCode"];
											$CtnOprCode=$row["strCtnOprCode"];
											$MarksNo=$row["strMarksNo"];
											$DescriptionOfGoods=$row["strDescriptionOfGoods"];
											$GrossWt=$row["dblGrossMass"];
											$NetWt=$row["dblNetMass"];
											$CBM=$row["intCBM"];
											$PortOfLoading=$row["strPortOfLoading"];
											$Declarent=$row["strNameOfDeclarent"];
											$v_name=$row["preV_name"];
											$v_date=$row["preV_date"];
											$v_no=$row["preV_no"];
											$Eno=$row["strE_No"];
											$FinalDes=$row["soldtoCountry"];
											$MarksAndNos=$row["strMarksAndNos"];
											$FinalDel=$row["strCity"];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>eShipping Web - Export Shipping Note :: Report</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" /><style type="text/css">
<!--
.overlap {
    position: absolute;
    left: 25%;
    top: 25%;
    width: 25%;
}
.l1 {
    z-index:1;
}
.l2 {
    z-index:2;
}
.l3 {
    z-index:3;
}
-->
</style>

</head>

<body>
<table width="940" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td width="930">
<table width="888" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr height="5">
    <td colspan="23" ></td>
  </tr>
  
  <tr>
    <td height="26" colspan="23"><div align="right" class="cusdec-normalfnt2bldBLACK">SHIPPING NOTE /BOAT NOTE -EXP 3a &nbsp;&nbsp;</div></td>
  </tr><?php
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
    <td height="20" colspan="11" class="border-top-left-fntsize12" >&nbsp;&nbsp;1.Shipper (Name and Address) 3336/7 &nbsp;</td>
    <td colspan="6" class="border-top-left-fntsize12">&nbsp;&nbsp;9. Customer Entry No </td>
    <td colspan="6" class="border-Left-Top-right-fntsize12"><div align="center">10. SN (BL) No. </div></td>
  </tr>
  <tr>
    <td height="15" colspan="11" class="border-left-fntsize12">&nbsp;&nbsp;&nbsp;&nbsp;<strong>HELA CLOTHING PVT(LTD)</strong></td>
    <td colspan="6" rowspan="2"  class="border-left-fntsize12"><div align="center">&nbsp;&nbsp;&nbsp;<strong><font size="+1">E</font></strong> &nbsp;<strong><?php echo $Eno ; ?></strong></div></td>
    <td colspan="6" rowspan="2"  class="border-left-right-fntsize12"><div align="center">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $BLNo ; ?></div></td>
  </tr>
    <tr>
    <td height="18" colspan="11" class="border-left-fntsize12">&nbsp;&nbsp;&nbsp;&nbsp;<strong>309/11, NEGOMBO ROAD</strong></td>
    </tr>
  <tr>
    <td colspan="11" height="12" class="border-left-fntsize12">&nbsp;&nbsp;&nbsp;&nbsp;<strong>WELISARA</strong></td>
    <td colspan="6" rowspan="2"  class="border-top-left-fntsize12">&nbsp;&nbsp;11. Exporter Registrayion No. </td>
    <td colspan="6" rowspan="2"  class="border-Left-Top-right-fntsize12"><div align="center">12. SLPA No. </div></td>
  </tr>
  <tr>
    <td colspan="11" height="13" class="border-left-fntsize12">&nbsp;&nbsp;&nbsp;&nbsp;<strong>SRI LANKA</strong></td>
  </tr>
  <tr>
    <td colspan="11" height="15" class="border-left-fntsize12">&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td rowspan="2"  class="border-left-fntsize12">&nbsp;</td>
    <td rowspan="2"  class="border-left-fntsize12">&nbsp;</td>
    <td rowspan="2"  class="border-left-fntsize12">&nbsp;</td>
    <td rowspan="2"  class="border-left-fntsize12">&nbsp;</td>
    <td rowspan="2"  class="border-left-fntsize12">&nbsp;</td>
    <td rowspan="2"  class="border-left-fntsize12">&nbsp;</td>
    <td colspan="6" rowspan="2"  class="border-left-right-fntsize12"><div align="center">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $SLPANo; ?></div></td>
  </tr>
  <tr>
    <td colspan="11" height="15" class="border-left-fntsize12">&nbsp;</td>
  </tr>
  
  <tr>
    <td height="20" colspan="11" class="border-top-left-fntsize12">&nbsp;&nbsp;2. Consignee (Name and Address) 3132/3 </td>
    <td colspan="12" class="border-Left-Top-right-fntsize12">&nbsp;&nbsp;13. Name of Shipping Line / MTO 3126/7 </td>
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
    <td colspan="11" height="" class="border-left-fntsize12">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ConsigneeName ; ?></td>
    <td colspan="12" height="0" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="11" height="" class="border-left-fntsize12">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ConsigneeAddress1 ; ?></td>
    <td colspan="12" class="border-left-right-fntsize12">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ShippingLineName ; ?></td>
  </tr>
  <tr>
    <td colspan="11" height="" class="border-left-fntsize12">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ConsigneeAddress2 ; ?></td>
    <td colspan="12" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="11" height="" class="border-left-fntsize12">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ConsigneeCountry ; ?></td>
    <td colspan="12" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="11" height="" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="8"  class="border-left-fntsize12">&nbsp;</td>
    <td  class="border-top-left-fntsize12">&nbsp;</td>
    <td  class="border-top-left-fntsize12">&nbsp;</td>
    <td  class="border-top-left-fntsize12">&nbsp;</td>
    <td   class="border-Left-Top-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
 
  <tr>
    <td colspan="11" class="border-top-left-fntsize12">&nbsp;&nbsp;3. Notify Address 3180/1 </td>
    <td colspan="12" class="border-Left-Top-right-fntsize12">&nbsp;&nbsp;14. (a) Place of Acceptance 3348/9 </td>
  </tr>
  <tr>
  		 <?php $notifyParty1Id = $row['NotifyID'];
		 $sql_NotPty=" SELECT buyers.strBuyerID,
						buyers.strBuyerCode,
						buyers.strName,
						buyers.strAddress1,
						buyers.strAddress2,
						buyers.strCountry
						FROM buyers
						WHERE strBuyerID='$notifyParty1Id'";
		
				
	$result=$db->RunQuery($sql_NotPty);
	$notyfy=mysql_fetch_array($result);		 
	?>
    <td colspan="11" class="border-left-fntsize12">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $notyfy['strBuyerCode'];?></td>
    <td colspan="12" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td class="border-left-fntsize12" colspan="11">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo  $notyfy['strAddress1'];?></td>
        <td colspan="12" class="border-left-right-fntsize12">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $PlcOfAcceptence ; ?></td>
  </tr>
  <tr>
    <td colspan="11" class="border-left-fntsize12">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo  $notyfy['strAddress2'];?></td>
    <td colspan="12" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="11" class="border-left-fntsize12">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo  $notyfy['strCountry'];?></td>
    <td colspan="12"class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="border-top-left-fntsize12">&nbsp;&nbsp;4. Voyage No./Date 8228 </td>
    <td colspan="6" class="border-top-left-fntsize12">&nbsp;&nbsp;5. Warehouse No. 3156 </td>
    <td colspan="12" class="border-Left-Top-right-fntsize12">&nbsp;&nbsp;14. (b) Place of Delivery 3246/7 </td>
  </tr>
  <tr>
    <td height="30" colspan="5" class="border-left-fntsize12">&nbsp;&nbsp;<strong><?php echo $v_no." / ".$v_date ; ?></strong></td>
    <td colspan="6" class="border-left-fntsize12">&nbsp;&nbsp;<strong><?php echo $WarehouseNo ; ?></strong></td>
    <td colspan="12" rowspan="2" class="border-left-right-fntsize12">
      <div align="left">&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo $FinalDel ; ?></strong></div></td>
  </tr>
  
  <tr>
    <td colspan="5" class="border-top-left-fntsize12">&nbsp;&nbsp;6.Vessel 8122/3 </td>
    <td colspan="6" class="border-top-left-fntsize12">&nbsp;&nbsp;47. Port of Loading 3231/1 </td>
    </tr>
  <tr>
    <td height="30" colspan="5" class="border-left-fntsize12">&nbsp;&nbsp;<strong><?php echo $v_name ; ?></strong></td>
    <td colspan="6" class="border-left-fntsize12"><strong>&nbsp;&nbsp;<?php echo $PortOfLoading ; ?></strong></td>
    <td colspan="12" rowspan="3" valign="top" class="border-Left-Top-right-fntsize12"><table><tr><td></td><td><div class="normalfnt">
The Company Preparing this note declares that, to the best of belief, the goods have been accurately described their quantities, weights and mesures are correct and at the same time of dispatch they were in good condition and at the same time of dispatch they were in good order and condition.
    </div></td></tr></table></td>
  </tr>
  
  <tr>
    <td colspan="5" class="border-top-left-fntsize12">&nbsp;&nbsp;8. Port of Discharge 3414/5 </td>
    <td colspan="3" class="border-top-left-fntsize12"><div class="normalfnt">VSL OPR.CODE</div> </td>
    <td colspan="3" class="border-top-left-fntsize12"><div class="normalfnt">CTN OPR.CODE</div> </td>
    </tr>
  <tr>
    <td height="30" colspan="5" class="border-left-fntsize12">&nbsp;&nbsp;<strong><?php echo $PortOfDischarge ; ?></strong></td>
    <td colspan="3" class="border-left-fntsize12" ><div align="center"><strong><?php echo $VslOprCode ; ?></strong></div></td>
    <td colspan="3" class="border-left-fntsize12"><div align="center"><strong><?php echo $CtnOprCode ; ?></strong></div></td>
  </tr>
  
  <tr>
    <td height="15" colspan="5" class="border-top-left-fntsize12"><div class="normalfnt">&nbsp;&nbsp;<sup>15. Marks &amp; Nos. 7102 </sup></div></td>
    <td colspan="4" class="border-top-fntsize12" ><div class="normalfnt"><sup>16.Number  Kind of Packages</sup></div> </td>
    <td colspan="5" class="border-top-fntsize12"><div class="normalfnt">&nbsp;&nbsp;&nbsp;<sup>17.Decription of Packages</sup></div> </td>
    <td colspan="3" class="border-top-left-fntsize12">
      <div align="left"  class="normalfnt">18.CCCN No </div></td>
    <td colspan="3" class="border-top-left-fntsize12"><div class="normalfnt">&nbsp;19.(a)Gross Wt.</div> </td>
    <td colspan="3" class="border-Left-Top-right-fntsize12"><div class="normalfnt">&nbsp;&nbsp;20. (a) Cube m</div> </td>
  </tr>

  
  
  <tr>
    <td colspan="5" class="border-left-fntsize12" ><div  class="normalfntMid"><sup>Container Numbers.</sup> </div></td>
    <td colspan="2" ><div align="center" class="normalfntMid"><sup>7224</sup></div></td>
    <td >&nbsp;</td>
    <td ><div align="center" class="normalfntMid"><sup>7002</sup></div></td>
    <td>&nbsp;</td>
    <td colspan="2"><div align="center" class="normalfntMid"><sup>7002</sup></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" class="border-left-fntsize12"><div align="center" class="normalfntMid">7282</div></td>
    <td >&nbsp;</td>
    <td colspan="3" class="border-left-fntsize12"><div align="center" class="normalfntMid">(Kg.) 6292 </div></td>
    <td colspan="3" class="border-left-right-fntsize12"><div align="center" class="normalfntMid">6324</div></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="9">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" rowspan="2" class="border-left-fntsize12"><div align="center"><?php echo $GrossWt ; ?></div></td>
    <td colspan="3" rowspan="2" class="border-left-right-fntsize12"><div align="center"><?php echo $CBM ; ?></div></td>
  </tr>
  <tr>
    <td rowspan="16" class="border-left-fntsize12" valign="">&nbsp;</td>
    <td colspan="13" rowspan="16" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="3" class="normalfnt">
    
    
    
          <tr>
        <td colspan="6" ><?php echo $MarksAndNos?></td>
        </tr>
      <tr>
        <td width="25%" class="border-All-fntsize9" style="text-align:center;font-weight:600">PO#</td>
        <td width="15%"  class="border-top-bottom-right-fntsize9" style="text-align:center;font-weight:600">STYLE</td>
        <td width="25%"  class="border-top-bottom-right-fntsize9" style="text-align:center;font-weight:600">DESC</td>
        <td width="15%" class="border-top-bottom-right-fntsize9" style="text-align:center;font-weight:600">CTNS</td>
        <td width="15%" class="border-top-bottom-right-fntsize9" style="text-align:center;font-weight:600">ISD/DO</td>
        <td width="15%" class="border-top-bottom-fntsize9" style="text-align:center;font-weight:600">QTY/PCS</td>
      </tr>
       <?php 
	  	$str_desc="select
					strDescOfGoods,
					strBuyerPONo,
					dblQuantity,
					dblUnitPrice,
					strStyleID,
					dblAmount,
					intNoOfCTns,
					strISDno
					from
					invoicedetail					
					where 
					strInvoiceNo='$invoiceNo'";
					//die($str_desc);
		$result_desc=$db->RunQuery($str_desc);
		while($row_desc=mysql_fetch_array($result_desc)){$tot+=$row_desc["dblAmount"];$totqty+=$row_desc["dblQuantity"];
	  ?>       
       <tr>
        <td  style="text-align:center;"><?php echo $row_desc["strBuyerPONo"];?></td>
        <td  style="text-align:center;"><?php echo $row_desc["strStyleID"];?></td>
        <td  style="text-align:center;"><?php echo $row_desc["strDescOfGoods"];?></td>
        <td  style="text-align:center"><?php echo number_format($row_desc["intNoOfCTns"],0);$totctns+=$row_desc["intNoOfCTns"];?></td>
        <td  style="text-align:center"><?php echo $row_desc["strISDno"];?></td>
        <td  style="text-align:center"><?php echo $row_desc["dblQuantity"];$totpcs+=$row_desc["dblQuantity"];?></td>
      </tr>
       <?php }?>
       <tr>
         <td  style="text-align:center;">&nbsp;</td>
         <td  style="text-align:center;">&nbsp;</td>
         <td  style="text-align:center;">&nbsp;</td>
         <td  style="text-align:center;border-bottom-style:double;border-top-style:solid;border-top-width:1px;" ><?php echo $totctns;?></td>
         <td  style="text-align:center">&nbsp;</td>
         <td  style="text-align:center;border-bottom-style:double;border-top-style:solid;border-top-width:1px;"><?php echo $totpcs;?></td>
       </tr>
      </table></td>
    <td height="19" colspan="3" class="border-left-fntsize12">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize12"><div class="normalfnt"><span >&nbsp;19.(b) Net Wt.</span></div></td>
    <td colspan="3" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td height="19" colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize12"><div align="center" class="normalfntMid">(Kg.) 6160 </div></td>
    <td colspan="3" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" rowspan="2" class="border-left-fntsize12"><div align="center"><?php echo $NetWt ; ?></div></td>
    <td colspan="3" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" rowspan="2" class="border-top-left-fntsize12"><div align="left" class="normalfnt">
      <div align="left" class="normalfnt">
        <div align="center">19. (c) Short Shipped </div>
      </div>
    </div></td>
    <td colspan="3" class="border-top-left-fntsize12"><div align="center" class="normalfnt">19(d)Gross Wt.</div></td>
    <td colspan="3" class="border-Left-Top-right-fntsize12"><div align="center" class="normalfnt">&nbsp;20. (b) Cube m </div></td>
  </tr>
  
  <tr>
    <td colspan="3" class="border-left-fntsize12"><div class="normalfnt"><span >(Kg.)</span></div></td>
    <td colspan="3" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="9">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="9">&nbsp;</td>
    <td colspan="3" class="border-top-left-fntsize12"><div align="left" class="normalfnt">
      <div align="center">19. (e)  Shipped </div>
    </div></td>
    <td colspan="3" class="border-top-left-fntsize12"><div align="left" class="normalfnt">&nbsp;19. (f)</div></td>
    <td colspan="3" class="border-Left-Top-right-fntsize12"><div align="left" class="normalfnt">&nbsp;20. (c) </div></td></tr>
  <tr>
    <td class="border-top-left-fntsize12">&nbsp;</td>
    <td class="border-top-left-fntsize12">&nbsp;</td>
    <td class="border-top-left-fntsize12">&nbsp;</td>
    <td class="border-top-left-fntsize12">&nbsp;</td>
    <td class="border-top-left-fntsize12">&nbsp;</td>
    <td class="border-top-left-fntsize12">&nbsp;</td>
    <td class="border-top-left-fntsize12">&nbsp;</td>
    <td class="border-top-left-fntsize12">&nbsp;</td>
    <td class="border-top-left-fntsize12">&nbsp;</td>
    <td class="border-top-left-fntsize12">&nbsp;</td>
    <td class="border-top-left-fntsize12">&nbsp;</td>
    <td class="border-top-left-fntsize12">&nbsp;</td>
    <td class="border-top-left-fntsize12">&nbsp;</td>
    <td class="border-top-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td class="border-left-fntsize12">&nbsp;</td>
    <td class="border-left-fntsize12">&nbsp;</td>
    <td class="border-left-fntsize12">&nbsp;</td>
    <td class="border-left-fntsize12">&nbsp;</td>
    <td class="border-left-fntsize12">&nbsp;</td>
    <td class="border-left-fntsize12">&nbsp;</td>
    <td class="border-left-fntsize12">&nbsp;</td>
    <td class="border-left-fntsize12">&nbsp;</td>
    <td class="border-left-fntsize12">&nbsp;</td>
    <td class="border-left-fntsize12">&nbsp;</td>
    <td class="border-left-fntsize12">&nbsp;</td>
    <td class="border-left-fntsize12">&nbsp;</td>
    <td class="border-left-fntsize12">&nbsp;</td>
    <td class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="9" class="border-top-left-fntsize12"><div align="left" class="normalfnt">&nbsp;21. For SLPA Use </div></td>
    <td colspan="5" class="border-top-left-fntsize12"><div align="left" class="normalfnt">&nbsp;23. Shipping Agent </div></td>
    <td colspan="9" class="border-Left-Top-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="9"  class="border-left-fntsize12">&nbsp;</td>
    <td colspan="5"  class="border-left-fntsize12" >&nbsp;</td>
    <td colspan="9" rowspan="2" class="border-left-right-fntsize12" valign="top"><table width="330">
      <tr><td width="4"></td>
      <td width="314"><div class="normalfnt">Received on board .......................... number of packages/containers/trallers in apparent good order and condition. </div></td></tr></table></td>
  </tr>
  <tr>
    <td colspan="9" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="5" class="border-left-fntsize12">&nbsp;</td>
    </tr>
  <tr>
    <td height="50" colspan="9" rowspan="2" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="5" rowspan="2" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="9" class="border-left-right-fntsize12"><div  class="normalfnt">&nbsp;&nbsp;28. SLPA Supervising Officer </div></td>
  </tr>
  <tr>
    <td height="50" colspan="9" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="border-left-fntsize12"><div align="center" class="normalfntMid">Date</div></td>
    <td colspan="3" >&nbsp;</td>
    <td colspan="3" class="normalfntMid">Signature</td>
    <td class="border-left-fntsize12"><div  class="normalfntMid">Date</div></td>
    <td colspan="2" >&nbsp;</td>
    <td colspan="2" ><div  class="normalfntMid">Signature</div></td>
    <td colspan="3" class="border-left-fntsize12"><div  class="normalfnt">&nbsp;&nbsp;&nbsp;Date</div></td>
    <td colspan="3" >&nbsp;</td>
    <td colspan="3" class="border-right-fntsize12"><div  class="normalfntMid">Signature</div></td>
    </tr>
  <tr>
    <td colspan="3" rowspan="2" class="border-top-left-fntsize12"><div  class="normalfnt">&nbsp;22</div></td>
    <td colspan="3" rowspan="2" class="border-top-left-fntsize12"><div  class="normalfnt">&nbsp;&nbsp;&nbsp;Astimated &nbsp;&nbsp;Amount(Rs) </div></td>
    <td colspan="3" rowspan="2" class="border-top-left-fntsize12"><div  class="normalfnt">&nbsp;&nbsp;&nbsp;Fnal Amount(Rs) </div></td>
    <td colspan="5" class="border-top-left-fntsize12"><div align="left" class="normalfnt">&nbsp;24. For Custom Use </div></td>
    <td colspan="9" class="border-left-right-fntsize12"><div  class="normalfnt">&nbsp;&nbsp;&nbsp;29. Chief Officer </div></td>
  </tr>
  <tr>
    <td height="19" colspan="5" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="9" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" rowspan="2" height="50" class="border-top-left-fntsize12"><div  class="normalfnt">&nbsp;a. Whartage</div></td>
    <td colspan="3" rowspan="2" class="border-top-left-fntsize12">&nbsp;</td>
    <td colspan="3" rowspan="2" class="border-top-left-fntsize12">&nbsp;</td>
    <td colspan="5" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="9" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize12"><div  class="normalfnt">&nbsp;&nbsp;&nbsp;Date</div></td>
    <td colspan="3" >&nbsp;</td>
    <td colspan="3" class="border-right-fntsize12"><div  class="normalfntMid">Signature</div></td>
    </tr>
  <tr>
    <td colspan="3" rowspan="2" height="50" class="border-top-left-fntsize12" valign="top"><div  class="normalfnt" >&nbsp;b. Less F.C.L &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rebate </div></td>
    <td colspan="3" rowspan="2" class="border-top-left-fntsize12">&nbsp;</td>
    <td colspan="3" rowspan="2" class="border-top-left-fntsize12">&nbsp;</td>
    <td colspan="5" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="9" rowspan="2" class="border-Left-Top-right-fntsize12"><div align="center"><strong>SN SHOULD NOT BE CLAUSED </strong></div></td>
  </tr>
  <tr>
    <td class="border-left-fntsize12"><div  class="normalfntMid">Date</div></td>
    <td colspan="2" >&nbsp;</td>
    <td colspan="2" ><div  class="normalfntMid">Signature</div></td>
    </tr>
  <tr>
    <td colspan="3" rowspan="2" height="50" class="border-top-left-fntsize12" valign="top"><div  class="normalfnt">&nbsp;c. Whartage  &nbsp;&nbsp;&nbsp;&nbsp;payable </div></td>
    <td colspan="3" rowspan="2" class="border-top-left-fntsize12">&nbsp;</td>
    <td colspan="3" rowspan="2" class="border-top-left-fntsize12">&nbsp;</td>
    <td colspan="5" class="border-top-left-fntsize12"><div class="normalfnt">25.(a)Status of Container8130/1 </div></td>
    <td colspan="9" rowspan="2" class="border-left-right-fntsize12" valign="top"><table height="38" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="10" height="38">&nbsp;</td>
        <td width="318" valign="top" class="normalfnt">Place receive for shipment the goods described above subject to your published regulations &amp; condition (including those as a liability) </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="19" class="border-All" >&nbsp;</td>
    <td ><div class="normalfnt">&nbsp;FCL</div></td>
    <td class="border-All">&nbsp;</td>
    <td ><div class="normalfnt">&nbsp;LCL</div></td>
    <td >&nbsp;</td>
    </tr>
  <tr>
    <td colspan="3" rowspan="2" height="50" class="border-top-left-fntsize12" ><div  class="normalfnt">&nbsp;d. Harbour Dues </div></td>
    <td colspan="3" class="border-top-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-top-left-fntsize12">&nbsp;</td>
    <td colspan="5" rowspan="2" class="border-top-left-fntsize12"><div class="normalfnt">&nbsp;25. (b) Freight Payable at 4286/7 </div></td>
    <td colspan="9" class="border-left-right-fntsize12" valign="top"><div  class="normalfnt">&nbsp;30. Name of Company prepairing this note </div></td>
  </tr>
  <tr>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="9" class="border-left-right-fntsize12"><span>&nbsp;&nbsp;<?php echo $exportername ; ?></span> </td>
  </tr>
  <tr>
    <td colspan="3" rowspan="2" height="50" class="border-top-left-fntsize12"><div  class="normalfnt_size9">&nbsp;e. Pallessting &nbsp;Pre-warehousing &nbsp;&nbsp;&nbsp;Charges </div></td>
    <td colspan="3" rowspan="2" class="border-top-left-fntsize12">&nbsp;</td>
    <td colspan="3" rowspan="2" class="border-top-left-fntsize12">&nbsp;</td>
    <td colspan="5" rowspan="2" class="border-left-fntsize12"><div class="normalfnt">&nbsp;26. Number of original Bs/L 1086/1 </div></td>
    <td colspan="9" class="border-left-right-fntsize12"><div  class="normalfnt">&nbsp;31. Name of Declarent3140/1 </div></td>
  </tr>
  <tr>
    <td height="19" colspan="9" class="border-left-right-fntsize12"><dd><?php echo $Declarent ; ?></td>
  </tr>
  <tr>
    <td colspan="3" height="50" rowspan="2" class="border-top-left-fntsize12"><div  class="normalfnt">&nbsp;f. Fork-Lift &nbsp;&nbsp;&nbsp;&nbsp;Charges </div></td>
    <td colspan="3" class="border-top-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-top-left-fntsize12">&nbsp;</td>
    <td colspan="5" class="border-top-left-fntsize12"><div  class="normalfntMid">27. Please debit our C/A No. </div></td>
    <td colspan="9" class="border-left-right-fntsize12"><div  class="normalfnt">&nbsp;32. Telephone No </div></td>
  </tr>
  <tr>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="5" class="border-left-fntsize12"><div  class="normalfntMid_size10">With Charges payable </div></td>
    <td colspan="9" class="border-left-right-fntsize12" style="text-align:center">011-4791888 / 0773043858</td>
  </tr>
  <tr>
    <td colspan="3" rowspan="2" height="50" class="border-top-left-fntsize12"><div  class="normalfnt">&nbsp;g. Total </div></td>
    <td colspan="3" class="border-top-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-top-left-fntsize12">&nbsp;</td>
    <td colspan="5" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="9" class="border-left-right-fntsize12"><div  class="normalfnt">&nbsp;33. Signature of Declarant &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date.<?php echo date("d/m/Y");?> </div></td>
  </tr>
  <tr>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="5" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="9" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="23" style="font-size:9px" class="border-top-fntsize12"><?php echo $invoiceno;?></td>
    </tr>
  <tr>
    <td width="37" ></td>
    <td width="37" ></td>
    <td width="37" ></td>
    <td width="37" ></td>
    <td width="37" ></td>
    <td width="37" ></td>
    <td width="37" ></td>
    <td width="37" ></td>
    <td width="37" ></td>
    <td width="37" ></td>
    <td width="37" ></td>
    <td width="37" ></td>
    <td width="37" ></td>
    <td width="37" ></td>
    <td width="37" ></td>
    <td width="37" ></td>
    <td width="37" ></td>
    <td width="37" ></td>
    <td width="37" ></td>
    <td width="37" ></td>
    <td width="37" ></td>
    <td width="37" ></td>
    <td width="37" ></td>
  </tr>
</table>
</td></tr></table>
</body>
</html>
