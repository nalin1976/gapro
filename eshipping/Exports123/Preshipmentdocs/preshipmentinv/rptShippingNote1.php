<?php 
	session_start();
	include "../../Connector.php";
	$invoiceno=$_GET["invoiceno"];
  $str="select sn.strShippingNoteNo, sn.strInvoiceNo, ih.strBuyerID as consigneeid, ih.strCompanyID as exporterid, ih.strNotifyID1 as NotifyID, ih.strPortOfLoading, ih.strCompanyID, ih.strCarrier, ih.strVoyegeNo, 
date(ih.dtmSailingDate) as dtmSailingDate, sn.strWarehouseNo,  sn.strCustomEntryNo, sn.strShippingLineName, 
 sn.dtmShNoteDate, sn.strExporterRegNo, sn.strSLPANo, sn.strPortOfDischarge, sn.strBLNo, sn.strVslOprCode, sn.strCtnOprCode, sn.strNameOfDeclarent, 
 sn.strUserId, soldto.strName as soldtoName, soldto.strAddress1 as soldtoADD1, soldto.strAddress2 as 
soldtoADD2, soldto.strCountry as soldtoCountry from shippingnote sn inner join invoiceheader ih on ih.strInvoiceNo=sn.strInvoiceNo 
left join buyers soldto on soldto.strBuyerID=ih.strSoldTo where sn.strInvoiceNo='$invoiceno' ";
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
											$PlcOfAcceptence=$row["strPortOfLoading"];
											$PlaceOfDelivery=$row["strPlaceOfDelivery"];
											$SLPANo=$row["strSLPANo"];
											$VoyageNo=$row["strVoyegeNo"]." ".$SailingDate;
											$WarehouseNo=$row["strWarehouseNo"];
											$Carrier=$row["strCarrier"];
											$PortOfDischarge=$row["strPortOfDischarge"];
											$VslOprCode=$row["strVslOprCode"];
											$CtnOprCode=$row["strCtnOprCode"];
											$MarksNo=$row["strMarksNo"];
											$DescriptionOfGoods=$row["strDescriptionOfGoods"];
											$GrossWt=$row["dblGrossWt"];
											$NetWt=$row["dblNetWt"];
											$CBM=$row["dblCBM"];
											$PortOfLoading=$row["strPortOfLoading"];
											$Declarent=$row["strNameOfDeclarent"];
											

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>eShipping Web - Export Shipping Note :: Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" /><style type="text/css">
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
td{
	line-height:90%;
}
-->
</style>

</head>

<body>
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td >
<table width="68%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr height="3">
    <td colspan="23" ></td>
  </tr>
  
  <tr>
    <td height="12" colspan="23"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="36%" height="12" class="normalfnt_size10"><?php echo "INVOICE NO :" .$invoiceno; ?></td>
        <td width="64%" colspan="=2"><div align="right" class="cusdec-normalfnt2bldBLACK">SHIPPING NOTE /BOAT NOTE -EXP 3a &nbsp;&nbsp;</div></td>
        </tr>
      </table></td>
  </tr>
  <?php
  		$sqlExporter=  "select 	strCustomerID, 
								intSequenceNo,
								strMLocation, 
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
    <td height="12" colspan="11" class="border-top-left-fntsize12" >&nbsp;&nbsp;1.Shipper (Name and Address)</td>
    <td colspan="6" class="border-top-left-fntsize12">&nbsp;&nbsp;9. Customer Entry No </td>
    <td colspan="6" class="border-Left-Top-right-fntsize12"><div align="center">10. SN (BL) No. </div></td>
  </tr>
  <tr>
    <td height="12" colspan="11" class="border-left-fntsize12 normalfnth2B">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $exportername; ?></td>
    <td colspan="6" rowspan="2"  class="border-left-fntsize12 normalfnth2B"><div align="center" class="normalfnth2B">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $CustomEntryNo ; ?></div></td>
    <td colspan="6" rowspan="2"  class="border-left-right-fntsize12 normalfnth2B"><div align="center"><strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $BLNo ; ?></strong></div></td>
  </tr>
    <tr>
    <td height="12" colspan="11" class="border-left-fntsize12 normalfnth2B">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $exporteraddress1; ?></td>
    </tr>
  <tr>
    <td colspan="11" height="12" class="border-left-fntsize12 normalfnth2B">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $exporteraddress2; ?></td>
    <td colspan="6" rowspan="2"  class="border-top-left-fntsize12">&nbsp;&nbsp;11. Exporter Registration No. </td>
    <td colspan="6" rowspan="2"  class="border-Left-Top-right-fntsize12"><div align="center">12. SLPA No. </div></td>
  </tr>
  <tr>
    <td colspan="11" height="12" class="border-left-fntsize12 normalfnth2B">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $exportercountry; ?></td>
  </tr>
  <tr>
    <td colspan="11" height="12" class="border-left-fntsize12">&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td rowspan="2"  class="border-left-fntsize12">&nbsp;</td>
    <td rowspan="2"  class="border-left-fntsize12">&nbsp;</td>
    <td rowspan="2"  class="border-left-fntsize12">&nbsp;</td>
    <td rowspan="2"  class="border-left-fntsize12">&nbsp;</td>
    <td rowspan="2"  class="border-left-fntsize12">&nbsp;</td>
    <td rowspan="2"  class="border-left-fntsize12">&nbsp;</td>
    <td colspan="6" rowspan="2"  class="border-left-right-fntsize12 normalfnth2B"><div align="center">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $SLPANo; ?></div></td>
  </tr>
  <tr>
    <td colspan="11" height="12" class="border-left-fntsize12">&nbsp;</td>
  </tr>
  
  <tr>
    <td height="12" colspan="11" class="border-top-left-fntsize12">&nbsp;&nbsp;2. Consignee (Name and Address) 3132/3 </td>
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
				//$rowConsignee["strBuyerID"];
  ?>
  <tr>
    <td colspan="11" height="" class="border-left-fntsize12 normalfnth2B">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ConsigneeName ; ?></td>
    <td colspan="12" height="0" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="11" height="" class="border-left-fntsize12 normalfnth2B">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ConsigneeAddress1 ; ?></td>
    <td colspan="12" class="border-left-right-fntsize12 normalfnth2B">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ShippingLineName ; ?></td>
  </tr>
  <tr>
    <td colspan="11" height="" class="border-left-fntsize12 normalfnth2B">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ConsigneeAddress2 ; ?></td>
    <td colspan="12" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="11" height="" class="border-left-fntsize12 normalfnth2B">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ConsigneeCountry ; ?></td>
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
    <td colspan="11" class="border-top-left-fntsize12">&nbsp;&nbsp;3. Notify Address 3180/1 </td>
    <td colspan="12" class="border-Left-Top-right-fntsize12">&nbsp;&nbsp;14. (a) Place of Acceptance 3348/9 </td>
  </tr>
  <tr>
 <?php 
$SQLNO =   "SELECT
            buyers.strName,
            buyers.strAddress1,
            buyers.strAddress2,
            buyers.strCountry
            FROM
            buyers
            Inner Join invoiceheader ON buyers.strBuyerID = invoiceheader.strNotifyID1
            WHERE
            invoiceheader.strInvoiceNo =  '$invoiceno'";
			
	$r1=$db->RunQuery($SQLNO);
	$r1=mysql_fetch_array($r1);			
?>
    <td colspan="11" class="border-left-fntsize12 normalfnth2B">&nbsp;&nbsp;&nbsp;&nbsp;<?php if($row["consigneeid"]==$row["NotifyID"]){ echo "Same As Consignee"; } else { echo $r1["strName"]; }  ?></td>
    <td colspan="12" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td class="border-left-fntsize12 normalfnth2B normalfnth2B" colspan="11">&nbsp;&nbsp;&nbsp;&nbsp;<?php if($row["consigneeid"]!=$row["NotifyID"]){ echo $r1["strAddress1"]; } ?></td>
        <td colspan="12" class="border-left-right-fntsize12 normalfnth2B">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $PlcOfAcceptence ; ?></td>
  </tr>
  <tr>
    <td colspan="11" class="border-left-fntsize12 normalfnth2B">&nbsp;&nbsp;&nbsp;&nbsp;<?php if($row["consigneeid"]!=$row["NotifyID"]){ echo $r1["strAddress2"];  } ?></td>
    <td colspan="12" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="11" class="border-left-fntsize12 normalfnth2B">&nbsp;&nbsp;&nbsp;&nbsp;<?php if($row["consigneeid"]!=$row["NotifyID"]){ echo $r1["strCountry"];  } ?></td>
    <td colspan="12"class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="border-top-left-fntsize12">&nbsp;&nbsp;4. Voyage No./Date 8228 </td>
    <td colspan="6" class="border-top-left-fntsize12">&nbsp;&nbsp;5. Warehouse No. 3156 </td>
    <td colspan="12" class="border-Left-Top-right-fntsize12">&nbsp;&nbsp;14. (b) Place of Delivery 3246/7 </td>
  </tr>
  <tr>
    <td height="12" colspan="5" class="border-left-fntsize12" nowrap="nowrap">&nbsp;&nbsp;<strong><?php echo $VoyageNo." " ; ?></strong></td>
    <td colspan="6" class="border-left-fntsize12">&nbsp;&nbsp;<strong><?php echo $WarehouseNo ; ?></strong></td>
    <td colspan="12" rowspan="2" class="border-left-right-fntsize12">
<?php    
    $SQLNEW =  "SELECT
				city.strCity,
				city.strPortOfLoading
				FROM
				invoiceheader
				Inner Join city ON invoiceheader.strFinalDest = city.strCityCode
				WHERE
				invoiceheader.strInvoiceNo =  '$invoiceno'";
	$resultNEW=$db->RunQuery($SQLNEW);
	$rowNEW=mysql_fetch_array($resultNEW);				
	
?>
      <div align="left" class="normalfnth2B">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rowNEW["strCity"]; ?></div></td>
  </tr>
  
  <tr>
    <td colspan="5" class="border-top-left-fntsize12">&nbsp;&nbsp;6.Vessel 8122/3 </td>
    <td colspan="6" class="border-top-left-fntsize12">&nbsp;&nbsp;47. Port of Loading 3231/1 </td>
    </tr>
  <tr>
    <td height="26" colspan="5" class="border-left-fntsize12">&nbsp;&nbsp;<strong><?php echo $Carrier ; ?></strong></td>
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
  <?php    
    $SQLNEW1 =  "SELECT
				city.strCity
				FROM
				invoiceheader
				Inner Join city ON invoiceheader.strPortOfLoading = city.strPortOfLoading
				WHERE
				invoiceheader.strInvoiceNo =  '$invoiceno'";
	$resultNEW1=$db->RunQuery($SQLNEW1);
	$rowNEW1=mysql_fetch_array($resultNEW1);				
	
?>
    <td height="29" colspan="5" class="border-left-fntsize12">&nbsp;&nbsp;<strong><?php echo $rowNEW["strPortOfLoading"]; ?></strong></td>
    <td colspan="3" class="border-left-fntsize12" ><div align="center"><strong><?php echo $VslOprCode ; ?></strong></div></td>
    <td colspan="3" class="border-left-fntsize12"><div align="center"><strong><?php echo $CtnOprCode ; ?></strong></div></td>
  </tr>
  
  <tr>
    <td height="12" colspan="5" class="border-top-left-fntsize12"><div class="normalfnt">&nbsp;&nbsp;15. Marks &amp; Nos. 7102 </div></td>
    <td colspan="4" class="border-top-fntsize12" ><div class="normalfnt">&nbsp;16.Number &amp; Kind of Packages</div> </td>
    <td colspan="5" class="border-top-fntsize12"><div class="normalfnt">&nbsp;&nbsp;&nbsp;17.Decription of Packages</div> </td>
    <td colspan="3" class="border-top-left-fntsize12">
      <div align="left"  class="normalfnt">18.CCCN No </div></td>
    <td colspan="3" class="border-top-left-fntsize12"><div class="normalfnt">&nbsp;19.(a)Gross Wt.</div> </td>
    <td colspan="3" class="border-Left-Top-right-fntsize12"><div class="normalfnt">&nbsp;&nbsp;20. (a) Cube m</div> </td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize12" ><div  class="normalfntMid">Container Numbers. </div></td>
    <td colspan="2" ><div align="center" class="normalfntMid">7224</div></td>
    <td >&nbsp;</td>
    <td ><div align="center" class="normalfntMid">7002</div></td>
    <td>&nbsp;</td>
    <td colspan="2"><div align="center" class="normalfntMid">7002</div></td>
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
    <td colspan="3" rowspan="2" class="border-left-fntsize12"><div align="center">
	<?php 
	$sql_CB1  = "SELECT
				Sum(invoicedetail.dblGrossMass) AS sumGross,
				Sum(invoicedetail.dblNetMass) AS sumNet
				FROM
				invoicedetail
				WHERE
				invoicedetail.strInvoiceNo = '$invoiceno'";
				
	$result_CB1 = $db->RunQuery($sql_CB1);
	$row_CB1    = mysql_fetch_array($result_CB1);
	?>
	<?php echo $row_CB1["sumGross"]; ?></div></td>
    <td colspan="3" rowspan="2" class="border-left-right-fntsize12"><div align="center">
	<?php 
	$sql_CB = "SELECT
				shippingnote.dblCBM
				FROM
				shippingnote
				WHERE
				shippingnote.strInvoiceNo =  '$invoiceno'";
	$result_CB = $db->RunQuery($sql_CB);
	$row_CB    = mysql_fetch_array($result_CB);
	
	echo $row_CB["dblCBM"]; ?></div></td>
  </tr>
  <tr>
    <td colspan="14" rowspan="16" valign="" class="border-left-fntsize12"><table width="96%" border="0" cellspacing="0" cellpadding="3" class="normalfnt">
      
      <?php 
	     $str_desc="select
	  				strMarksAndNos,
					strDescOfGoods,
					strBuyerPONo,
					SUM(dblQuantity) AS sumQTY,
					invoicedetail.strStyleID,
					invoicedetail.strBuyerPONo,
					dblUnitPrice,
					strStyleID,
					dblAmount,
					SUM(intNoOfCTns) AS sumCTNS,
					strISDno,
					strFabrication
					from
					invoicedetail
					inner join invoiceheader on invoicedetail.strInvoiceNo = invoiceheader.strInvoiceNo				
					where 
					invoicedetail.strInvoiceNo='$invoiceno'
					group by invoicedetail.strInvoiceNo and replace(invoicedetail.strDescOfGoods,'  ',' ')";
				    //die($str_desc);
					
		  $result_desc = $db->RunQuery($str_desc);
		
			
	  ?>       
      <tr>
        <td width="39%" height="200"  style="text-align:left;"><span style="text-align:right">
          <textarea name="textarea" readonly='readonly'  style='border:0px; height:175px; width:180px;overflow:hidden; ' class="normalfnt">
	  <?php
          while($row_desc = mysql_fetch_array($result_desc))
		  {		  
		  	echo $row_desc['strMarksAndNos'];
          
		  }
	  ?>
      
    	   </textarea>
          </span></td>
        <td width="61%"  style="text-align:left; vertical-align:text-top">
          <br />
          
          <?php
		
		  $result_desc = $db->RunQuery($str_desc);
          while($row_desc = mysql_fetch_array($result_desc))
		  {
		  
		  	if($row_desc['sumCTNS']!="")
			{
				
				echo $row_desc['sumCTNS']; ?>&nbsp;&nbsp;Cartons Containing<br /><br /><?php
                echo $row_desc['sumQTY']; ?>&nbsp;&nbsp;Pcs of&nbsp;<?php echo $row_desc['strDescOfGoods']; ?><br /><br /><?php
                echo $row_desc['strFabrication']; ?><br /><br />
          <?php
			}
		  }
	  ?>
          <?php
	  	$str_desc1="select DISTINCT
	  				strStyleID,
					strBuyerPONo
					from
					invoicedetail		
					where 
					invoicedetail.strInvoiceNo='$invoiceno'";
				    //die($str_desc);
					
		  $result_desc1 = $db->RunQuery($str_desc1);
	  ?>
          CONTRACT NO :<br /><br />
          STYLE NO :&nbsp;
          <?php
	  	$i=1;
	  	while($row_desc1 = mysql_fetch_array($result_desc1))
		{
			echo $row_desc1["strStyleID"];if($i<mysql_num_rows($result_desc1)){echo " / ";} 
			$i++;
		}
	  ?><br /><br />
          ORDER NO :&nbsp;
          <?php
	  	$j=1;
		$result_desc2 = $db->RunQuery($str_desc1);
	  	while($row_desc2 = mysql_fetch_array($result_desc2))
		{
			echo $row_desc2["strBuyerPONo"];if($j<mysql_num_rows($result_desc2)){echo " / ";} 
			$j++;
		}
	  ?>
          <br /><br /></td>
        </tr>
      
      
      
    </table></td>
    <td height="10" colspan="3" class="border-left-fntsize12">&nbsp;</td>
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
    <td height="12" colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize12"><div align="center" class="normalfntMid">(Kg.) 6160 </div></td>
    <td colspan="3" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" rowspan="2" class="border-left-fntsize12"><div align="center">
	
	<?php 
	$result_CB1 = $db->RunQuery($sql_CB1);
	$row_CB1    = mysql_fetch_array($result_CB1);
	
	echo $row_CB1["sumNet"]; ?></div></td>
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
    <td colspan="5" class="border-left-fntsize12"><span style="text-align:left; vertical-align:text-top">Container Type :&nbsp;
        <?php
			$sql_Container =   "SELECT
								container.strContainerName
								FROM
								shippingnote
								Inner Join container ON shippingnote.strContainerType = container.intContainerId
								WHERE
								shippingnote.strInvoiceNo =  '$invoiceno'";
		 $result_Container = $db->RunQuery($sql_Container);
		 $row_Container = mysql_fetch_array($result_Container);
		
		?>
    </span></td>
    <td colspan="9" class="normalfnt_size12">&nbsp;<strong>
      <?php  echo $row_Container["strContainerName"]; ?>
    </strong></td>
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
    <td height="10" colspan="9" rowspan="2" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="5" rowspan="2" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="9" class="border-left-right-fntsize12"><div  class="normalfnt">&nbsp;&nbsp;28. SLPA Supervising Officer </div></td>
  </tr>
  <tr>
    <td height="12" colspan="9" class="border-left-right-fntsize12">&nbsp;</td>
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
    <td height="10" colspan="5" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="9" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" rowspan="2" height="30" class="border-top-left-fntsize12"><div  class="normalfnt">&nbsp;a. Whartage</div></td>
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
    <td colspan="3" rowspan="2" height="30" class="border-top-left-fntsize12" valign="top"><div  class="normalfnt" >&nbsp;b. Less F.C.L &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rebate </div></td>
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
    <td colspan="3" rowspan="2" height="25" class="border-top-left-fntsize12" valign="top"><div  class="normalfnt">&nbsp;c. Whartage  &nbsp;&nbsp;&nbsp;&nbsp;payable </div></td>
    <td colspan="3" rowspan="2" class="border-top-left-fntsize12">&nbsp;</td>
    <td colspan="3" rowspan="2" class="border-top-left-fntsize12">&nbsp;</td>
    <td colspan="5" class="border-top-left-fntsize12"><div class="normalfnt">25.(a)Status of Container8130/1 </div></td>
    <td colspan="9" rowspan="2" class="border-left-right-fntsize12" valign="top"><table height="33" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="10" height="25">&nbsp;</td>
        <td width="318" valign="top" class="normalfnt">Place receive for shipment the goods described above subject to your published regulations &amp; condition (including those as a liability) </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="15" class="border-All" >&nbsp;</td>
    <td ><div class="normalfnt">&nbsp;FCL</div></td>
    <td class="border-All">&nbsp;</td>
    <td ><div class="normalfnt">&nbsp;LCL</div></td>
    <td >&nbsp;</td>
    </tr>
  <tr>
    <td colspan="3" rowspan="2" height="25" class="border-top-left-fntsize12" ><div  class="normalfnt">&nbsp;d. Harbour Dues </div></td>
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
    <td colspan="3" rowspan="2" height="25" class="border-top-left-fntsize12"><div  class="normalfnt_size9">&nbsp;e. Pallessting &nbsp;Pre-warehousing &nbsp;&nbsp;&nbsp;Charges </div></td>
    <td colspan="3" rowspan="2" class="border-top-left-fntsize12">&nbsp;</td>
    <td colspan="3" rowspan="2" class="border-top-left-fntsize12">&nbsp;</td>
    <td colspan="5" rowspan="2" class="border-left-fntsize12"><div class="normalfnt">&nbsp;26. Number of original Bs/L 1086/1 </div></td>
    <td colspan="9" class="border-left-right-fntsize12"><div  class="normalfnt">&nbsp;31. Name of Declarent3140/1 </div></td>
  </tr>
  <tr>
    <td height="14" colspan="9" class="border-left-right-fntsize12"><dd>
	<?php 
$SQLNO1 =  "SELECT
			wharfclerks.strName,
			wharfclerks.strPhone,
			wharfclerks.strIdNo
			FROM
			wharfclerks
			INNER JOIN shippingnote ON shippingnote.strNameOfDeclarent = wharfclerks.intWharfClerkID
			WHERE shippingnote.strInvoiceNo='$invoiceno'";
			
	$r11=$db->RunQuery($SQLNO1);
	$r12=mysql_fetch_array($r11);			
?>
	<?php echo $r12["strName"]; ?>&nbsp;&nbsp;&nbsp;ID NO :&nbsp;<?php echo $r12["strIdNo"];?></td>
  </tr>
  <tr>
    <td colspan="3" height="25" rowspan="2" class="border-top-left-fntsize12"><div  class="normalfnt">&nbsp;f. Fork-Lift &nbsp;&nbsp;&nbsp;&nbsp;Charges </div></td>
    <td colspan="3" class="border-top-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-top-left-fntsize12">&nbsp;</td>
    <td colspan="5" class="border-top-left-fntsize12"><div  class="normalfntMid">27. Please debit our C/A No. </div></td>
    <td colspan="9" class="border-left-right-fntsize12"><div  class="normalfnt">&nbsp;32. Telephone No :&nbsp;<?php echo $r12["strPhone"]; ?></div></td>
  </tr>
  <tr>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="5" class="border-left-fntsize12"><div  class="normalfntMid_size10">With Charges payable </div></td>
    <td colspan="9" class="border-left-right-fntsize12"></td>
  </tr>
  <tr>
    <td colspan="3" rowspan="2" height="25" class="border-top-left-fntsize12"><div  class="normalfnt">&nbsp;g. Total </div></td>
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
    <td colspan="23" style="font-size:9px;text-align:right" class="border-top-fntsize12">
    <table width="100%" border="0" cellspacing="0" cellpadding="3" class="normalfnt">
    <tr>
    <td width="80%">&nbsp;* Need to appear only on the first THREE Copies submitted to shipping Company.
    <br />&nbsp;<b>DARK CAGES FOR OFFICE USE ONLY.</b></td>
    <td width="20%">
    
    
    	Factory : <strong><?php echo $rowExporter["strMLocation"]; ?></strong></td></tr> </table>   
       </td>
    </tr>
  <tr>
    <td width="22" ></td>
    <td width="28" ></td>
    <td width="25" ></td>
    <td width="27" ></td>
    <td width="28" ></td>
    <td width="27" ></td>
    <td width="22" ></td>
    <td width="25" ></td>
    <td width="28" ></td>
    <td width="29" ></td>
    <td width="25" ></td>
    <td width="35" ></td>
    <td width="42" ></td>
    <td width="13" ></td>
    <td width="77" ></td>
    <td width="45" ></td>
    <td width="4" ></td>
    <td width="38" ></td>
    <td width="29" ></td>
    <td width="42" ></td>
    <td width="35" ></td>
    <td width="26" ></td>
    <td width="5" ></td>
  </tr>
</table>
</td></tr></table>
</body>
</html>
