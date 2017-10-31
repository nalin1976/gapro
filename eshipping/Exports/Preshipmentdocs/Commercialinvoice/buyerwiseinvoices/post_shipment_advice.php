<?php 
session_start();
include "../../../../Connector.php";
$invoiceNo=$_GET['InvoiceNo'];

				$str_commercial_inv="select
									strCarrier, 
									strVoyegeNo, 
									date_format(dtmSailingDate,'%d-%b-%y')as  dtmSailingDate,
									date_format(dtmETA,'%d-%b-%y')as  dtmETA,
									strBL, 
									dblFreight, 
									dblInsurance, 
									dblDestCharge,
									strHAWB,
									city.strCity AS city,
									city.strPortOfLoading AS port
									from commercial_invoice_header cih
									left join finalinvoice on finalinvoice.strInvoiceNo=cih.strInvoiceNo
									LEFT JOIN city ON cih.strFinalDest =city.strCityCode
									where 
									cih.strInvoiceNo='$invoiceNo'";
				$result_com_inv=$db->RunQuery($str_commercial_inv);				
				$com_inv_dataholder=mysql_fetch_array($result_com_inv);	
				$freight_ch=($com_inv_dataholder['dblFreight']==""?0:$com_inv_dataholder['dblFreight']);
				$insurance_ch=($com_inv_dataholder['dblInsurance']==""?0:$com_inv_dataholder['dblInsurance']);
				$dest_ch=($com_inv_dataholder['dblDestCharge']==""?0:$com_inv_dataholder['dblDestCharge']);
				$tot_ch=$freight_ch+$insurance_ch+$dest_ch;
				$amt_dtl=$row_desc["dblAmount"]+$tot_ch*$row_desc["dblQuantity"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>POST SHIPMENT ADVICE</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<?php 
$orientation="jsPrintSetup.kLandscapeOrientation";
//$orientation="jsPrintSetup.kPortraitOrientation";
include("printer.php");?>
</head>

<body class="body_bound">
<table cellspacing="0" cellpadding="0" class="normalfnt_size12">
  <col width="141" />
  <col width="146" />
  <col width="107" />
  <col width="76" span="2" />
  <col width="111" />
  <col width="122" />
  <col width="83" />
  <col width="88" />
  <col width="102" />
  <tr height="21">
    <td height="21" width="141"></td>
    <td colspan="8" style="font-size:18px;text-align:center;font-weight:500"><u>POST    SHIPMENT ADVICE</u></td>
    <td width="102"></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td width="253"></td>
    <td></td>
    <td width="76"></td>
    <td width="76"></td>
    <td width="111"></td>
    <td width="122"></td>
    <td width="83"></td>
    <td width="88"></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="21">
    <td height="21">SHIPPER</td>
    <td colspan="5">ORIT TRADING    LANKA(PVT)LTD</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="21">
    <td height="21">VESSEL</td>
    <td colspan="5"><span style="text-align:left"><?php echo  $com_inv_dataholder["strCarrier"];?></span></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="21">
    <td height="21">BL/AWB # </td>
    <td colspan="3"><?php echo ($com_inv_dataholder['strHAWB']==""?$com_inv_dataholder['strBL']:$com_inv_dataholder['strHAWB']);?></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="21">
    <td height="21" nowrap="nowrap">ETD COLOMBO</td>
    <td colspan="4"><?php echo $com_inv_dataholder["dtmSailingDate"];?></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="21">
    <td height="21">ETA <?php echo $com_inv_dataholder["city"];?></td>
    <td colspan="4"><?php echo $com_inv_dataholder["dtmETA"];?></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17" style="font-weight:600;text-align:center">INVOICE #</td>
    <td style="font-weight:600;text-align:center">DESCRIPTION</td>
    <td style="font-weight:600;text-align:center">QTY</td>
    <td style="font-weight:600;text-align:center">CARTONS</td>
    <td style="font-weight:600;text-align:center">P.O.#</td>
    <td style="font-weight:600;text-align:center">LOT #</td>
    <td style="font-weight:600;text-align:center">BL/ AWB </td>
    <td style="font-weight:600;text-align:center">GROSS WT</td>
    <td style="font-weight:600;text-align:center">NET WT</td>
    <td style="font-weight:600;text-align:center">AMOUNT US$</td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td style="font-weight:600;text-align:center">KGS</td>
    <td style="font-weight:600;text-align:center">KGS</td>
    <td></td>
  </tr>
  <tr height="31">
    <td height="31"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
   <?php 
	  	$str_desc="select
					strDescOfGoods,
					strBuyerPONo,
					strStyleID,
					dblQuantity,
					dblUnitPrice,
					dblAmount,
					intNoOfCTns,
					dblGrossMass,
					dblNetMass,
					strBuyerPONo,
					strStyleID,
					strISDno
					from
					commercial_invoice_detail					
					where 
					strInvoiceNo='$invoiceNo'
					order by strBuyerPONo
					";
					//die($str_desc);
		$result_desc=$db->RunQuery($str_desc);
		$bool_rec_fst=1;
		while($row_desc=mysql_fetch_array($result_desc)){
		$tot+=$row_desc["dblAmount"]+$tot_ch*$row_desc["dblQuantity"];
		$price_dtl=$row_desc["dblUnitPrice"]+$tot_ch;
		$amt_dtl=$row_desc["dblAmount"]+$tot_ch*$row_desc["dblQuantity"];
		$hts_code=$row_desc["strHSCode"];
		
	  ?>
     
  <tr height="20">
    <td height="20" style="text-align:center" nowrap="nowrap"><?php echo $invoiceNo;?></td>
    <td style="text-align:center"><?php echo $row_desc["strDescOfGoods"];?></td>
    <td style="text-align:center"><?php echo $row_desc["dblQuantity"];$totqty+=$row_desc["dblQuantity"];?></td>
    <td style="text-align:center"><?php echo $row_desc["intNoOfCTns"];$totctn+=$row_desc["intNoOfCTns"];?></td>
    <td style="text-align:center"><?php echo $row_desc["strBuyerPONo"];?></td>
    <td style="text-align:center"><?php echo $row_desc["strStyleID"];?></td>
    <td style="text-align:center" nowrap="nowrap"><?php echo ($bool_rec_fst==1?($com_inv_dataholder['strHAWB']==""?$com_inv_dataholder['strBL']:$com_inv_dataholder['strHAWB']):"");?></td>
    <td style="text-align:center"><?php echo $row_desc["dblGrossMass"];$totGross+=$row_desc["dblGrossMass"];?></td>
    <td style="text-align:center"><?php echo $row_desc["dblNetMass"];$totNet+=$row_desc["dblNetMass"]?></td>
    <td style="text-align:center"><?php echo number_format($amt_dtl,2);$totAmt+=$amt_dtl;?></td>
  </tr><?php $bool_rec_fst=0;}?>
  <tr height="20">
    <td height="20"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  
  <tr height="20">
    <td height="20"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="20">
    <td height="20"></td>
    <td></td>
    <td class="border-bottom-fntsize12">&nbsp;</td>
    <td class="border-bottom-fntsize12">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td class="border-bottom-fntsize12">&nbsp;</td>
    <td class="border-bottom-fntsize12">&nbsp;</td>
    <td class="border-bottom-fntsize12">&nbsp;</td>
  </tr>
  <tr height="35">
    <td height="35" >&nbsp;&nbsp;GRAND TOTAL</td>
    <td></td>
    <td style="border-bottom-style:double;text-align:center"><?php echo $totqty;?></td>
    <td style="border-bottom-style:double;text-align:center;" ><?php echo $totctn;?></td>
    <td></td>
    <td></td>
    <td></td>
    <td style="border-bottom-style:double;text-align:center" ><?php echo $totGross;?></td>
    <td style="border-bottom-style:double;text-align:center" ><?php echo $totNet;?></td>
    <td style="border-bottom-style:double;text-align:center" ><?php echo number_format($totAmt,2);?></td>
  </tr>
</table>
</body>
</html>
