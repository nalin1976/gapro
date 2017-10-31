<?php 
session_start();
include "../../../../Connector.php";
include 'common_report.php';
$xmldoc=simplexml_load_file('../../../../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;
include("invoice_queries.php");	
//$orientation="jsPrintSetup.kLandscapeOrientation";
$orientation="jsPrintSetup.kPortraitOrientation";
include("printer.php");

$invoiceNo=$_GET['InvoiceNo'];
$type=($_GET['type']==""? "FOB":$_GET['type']);
   
   $sqlinvoiceheader="SELECT
						IH.strInvoiceNo,
						date(dtmInvoiceDate) AS dtmInvoiceDate,
						IH.bytType,
						customers.strName AS CustomerName,
						CONCAT(customers.strAddress1,' ',customers.strAddress2 ) AS CustomerAddress,
						customers.strAddress1,
						customers.strAddress2,
						customers.strCountry AS CustomerCountry,
						buyers.strBuyerID,
						buyers.strName AS BuyerAName,
						buyers.strAddress1 AS buyerAddress1,
						buyers.strAddress2 AS buyerAddress2,
						buyers.strCountry AS BuyerCountry,
						buyers.strBuyerCode AS strBuyerCode,
						soldto.strName AS soldtoAName,
						soldto.strAddress1 AS soldtoAddress1,
						soldto.strAddress2 AS soldtoAddress2,
						soldto.strCountry AS soldtoCountry,
						(SELECT cty.strCity FROM city cty where cty.strCityCode=IH.strFinalDest) AS strFinalDest,
						IH.strNotifyID1,
						IH.strNotifyID2,
						IH.strLCNo AS LCNO,
						IH.dtmLCDate AS LCDate,
						IH.strLCBankID,
						IH.dtmLCDate,
						IH.strPortOfLoading,
						city.strCity AS city,
						IH.strCarrier,
						IH.strVoyegeNo,
						IH.dtmSailingDate,
						IH.strCurrency,
						IH.dblExchange,
						IH.intNoOfCartons,
						IH.intMode,
						IH.strCartonMeasurement,
						sum(IH.strCBM) AS strCBM,
						IH.strMarksAndNos,
						IH.strGenDesc,
						IH.bytStatus,
						IH.intFINVStatus,
						IH.intCusdec,
						IH.strTransportMode,
						IH.strIncoterms,
						IH.strPay_trms,
						IH.strVesselName,
						IH.dtmVesselDate,
						invoicedetail.dblGOHstatus,
						invoicedetail.strBuyerPONo,
						invoicedetail.dblNetMass,
						invoicedetail.dblGrossMass,
						invoicedetail.strBuyerPONo,
						invoicedetail.strCatNo,
						IH.strPortOfDischarge,
						sn.strPlaceOfDelivery
						FROM
						invoiceheader AS IH
						LEFT JOIN customers ON IH.strCompanyID = customers.strCustomerID
						LEFT JOIN buyers ON IH.strBuyerID = buyers.strBuyerID
						LEFT JOIN buyers AS soldto ON IH.strSoldTo = soldto.strBuyerID
						LEFT JOIN city ON IH.strFinalDest = city.strCityCode
						LEFT JOIN shippingnote sn ON sn.strInvoiceNo = IH.strInvoiceNo
						INNER JOIN invoicedetail ON IH.strInvoiceNo = invoicedetail.strInvoiceNo
						WHERE IH.strInvoiceNo='$invoiceNo'";
	
	$idresult=$db->RunQuery($sqlinvoiceheader);
	//echo $sqlinvoiceheader;
	$dataholder=mysql_fetch_array($idresult);
	
	$dateVariable = $dataholder['dtmInvoiceDate'];
	$dateInvoice = substr($dateVariable, 0, 10); 
	//die ("$sqlinvoiceheader"); 
	$dateLC = $dataholder['LCDate'];
	$LCDate = substr($dateLC, 0, 10); 	
		

?>
        

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>| M&amp;S | VENDOR DECLARATION |</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">

.fnt4{
		font-family:Arial;
		font-size:4px;
		text-align:center;
		line-height:6px;
}
.fnt6{
		font-family:Arial;
		font-size:6px;
		text-align:center;
		line-height:8px;
}
.fnt7{
		font-family:Arial;
		font-size:7px;
		text-align:center;
		line-height:9px;
}
.fnt8{
		font-family:Arial;
		font-size:8px;
		text-align:center;
		line-height:10px;
}
.fnt9{
		font-family:Arial;
		font-size:9px;
		text-align:center;
		line-height:11px;
}
.fnt12{
		font-family:Arial;
		font-size:12px;
		text-align:center;
		line-height:14px;
}
.fnt12-bold{
		font-family:Arial;
		font-size:12px;
		text-align:center;
		font-weight:600;
		line-height:14px;
}

.fnt12-bold-head{
		font-family:Arial;
		font-size:13px;
		text-align:center;
		font-weight:900;
		line-height:14px;
}

.fnt14-bold{
		font-family:Arial;
		font-size:16px;
		text-align:center;
		font-weight:700;
		line-height:16px;
}
.fnt16-bold{
		font-family:Arial;
		font-size:18px;
		text-align:center;
		font-weight:700;
		line-height:18px;
}
.fnt30-bold{
		font-family:Arial;
		font-size:34px;
		text-align:center;
		font-weight:700;
}

</style>
 

</head>

<body class="body_bound">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="28" colspan="10" align="center" style="font-size:24px"><u><strong>VENDOR DECLARATION</strong></u></td>
  </tr>
  <tr>
    <td height="28" colspan="10" align="center" style="font-size:24px"></td>
  </tr>
  <tr>
    <td width="11%">&nbsp;</td>
    <td width="7%" class="border-All"><div align="center"><strong><?php if($dataholder['dblGOHstatus'==0]){echo "CTN";} else {echo "GOH";} ?></strong></div></td>
    <td width="13%">&nbsp;</td>
    <td width="10%" align="center">&nbsp;</td>
    <td colspan="4"><strong>Att:</strong></td>
    <td width="11%">&nbsp;</td>
       <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td><td>&nbsp;</td>
    <td>&nbsp;</td><td>&nbsp;</td>
    <td width="4%">&nbsp;</td><td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="14%">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
    <td class="border-top-left">Vessel &amp; Voyage:</td>
   <td colspan="4" class="border-top-left"><?php echo $dataholder['strVesselName']?> &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $dataholder['strVoyegeNo']?></td>
    <td class="border-All">Invoice No:</td><td class="border-top-bottom-right"><?php echo $dataholder['strInvoiceNo'];?></td>
  </tr>
  <tr>
    <td colspan="2" class="border-top-left" style="font-weight:bold">Vendor Name:</td>
    <td colspan="2" class="border-top-left" style="font-weight:bold">Country of Origin:</td>
    <td class="border-top-left">&nbsp;</td>
     <td colspan="2" class="border-top-left" style="font-weight:bold">Cargo Ready Date</td> 
    <td class="border-top-left" style="font-weight:bold">Cargo Delivery Date</td>
    <td class="border-left-right" style="font-weight:bold">Port of Discharge</td>
     <td class="border-right" style="font-weight:bold">Final Destination</td>
    <td width="0%">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="2" class="border-left">HELA CLOTHING (PVT) LTD</td>
    <td colspan="2" class="border-left">SRI LANKA</td>
    <td class="border-left">&nbsp;</td>
     <td colspan="2" class="border-left"><?php echo $dataholder['dtmVesselDate']?></td> 
    <td class="border-left"><?php echo $dataholder['dtmVesselDate']?></td>
    <td class="border-left-right"><?php echo $dataholder['strPortOfDischarge']?></td>
     <td class="border-right"><?php echo $dataholder['strFinalDest']?></td>
    <td width="0%">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="2" class="border-top-left" style="font-weight:bold">Shipper Name:</td> 
    <td colspan="6" class="border-top-left" style="font-weight:bold" >Discription (part I)</td> 
    <td colspan="2" class="border-Left-Top-right" style="font-weight:bold"><div align="center">Container Details for Factory Loads</div></td>
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
    <td colspan="2" class="border-left">HELA CLOTHING (PVT) LTD</td>      
    <td colspan="6" class="border-left" style="font-weight:bold"><?php echo $row_desc["strDescOfGoods"];?></td>      
    <td class="border-Left-Top-right">Container No</td>
    <td class="border-top-right">Seal No</td>   
  </tr>
 	<?php }?>
   <tr>
    <td colspan="2" class="border-left" >NO.309/11 NEGOMBO ROAD</td> 
    <td colspan="6" class="border-left">&nbsp;</td> 
    <td class="border-Left-Top-right">&nbsp;</td>
    <td class="border-top-right">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="2" class="border-left">WELISARA, SRI LANKA</td> 
    <td colspan="6" class="border-left">&nbsp;</td> 
    <td  class="border-Left-Top-right">&nbsp;</td>
    <td  class="border-top-right">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="2" class="border-left">&nbsp;</td> 
    <td colspan="6" class="border-left">&nbsp;</td> 
    <td class="border-Left-Top-right">&nbsp;</td>
    <td class="border-top-right">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="2"  class="border-top-left" style="font-weight:bold">Consignee</td> 
    <td colspan="5" class="border-top-left" style="font-weight:bold">Description(part II)</td> 
    <td rowspan="5" class="border-top-left">&nbsp;</td>
    <td colspan="2" rowspan="4" class="border-Left-Top-right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
     <td colspan="2" class="border-left">MARKS &amp; SPENCER SCM LTD</td> 
    <td class="border-left">L/C No.</td> <td colspan="4"><?php echo $dataholder["LCNO"];?></td>
    <td>&nbsp;</td>
  </tr>
      <tr>
   <td colspan="2" class="border-left">LOWRY HOUSE, CENTRAL PARK</td> 
    <td class="border-left">T/R No.</td> <td colspan="4">&nbsp;</td>
  </tr>
   <tr>
   <td colspan="2" class="border-left">OHIO AVENUE, SALFORD QUAYS</td> 
    <td class="border-left">Cat No.</td> <td colspan="4"><?php echo $dataholder["strCatNo"];?></td>
  </tr>
   <tr>
   <td colspan="2" class="border-left">MANCHESTER, M50 2GT, UK.</td> 
    <td class="border-left">HTS No.</td> <td colspan="4">&nbsp;</td>
    <td colspan="2" class="border-Left-Top-right"><div align="center"><strong>Vendor Stamps &amp; Signature</strong></div></td>
  </tr>
  
  
   <tr>
    <td colspan="2" class="border-top-left" style="font-weight:bold">Notify Party</td> 
    <td colspan="8" class="border-Left-Top-right"><div align="center">&lt;&lt;&lt;&lt;&lt;&lt; &lt;&lt;&lt;&lt;&lt; &lt;&lt;&lt;&lt;&lt; Documents to be produce &gt;&gt;&gt;&gt;&gt; &gt;&gt;&gt;&gt;&gt; &gt;&gt;&gt;&gt;&gt;</div></td> 
  </tr>
   <tr>
    <td colspan="2" class="border-left">&nbsp;</td> 
    <td colspan="5" class="border-Left-Top-right">Approval letter</td> 
    <td class="border-top" style="font-weight:bold"><div align="center">Yes</div></td>
    <td  class="border-Left-Top-right">&nbsp;</td>
    <td  class="border-top-right">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="2" class="border-left">SAME AS CONSIGNEE</td> 
    <td colspan="5" class="border-Left-Top-right">Commercial Invoice</td> 
    <td  class="border-top" style="font-weight:bold"><div align="center">Yes</div></td>
    <td  class="border-Left-Top-right">&nbsp;</td>
    <td  class="border-top-right">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="2" class="border-left">&nbsp;</td> 
    <td colspan="5" class="border-Left-Top-right">Packing List</td> 
    <td  class="border-top" style="font-weight:bold"><div align="center">Yes</div></td>
    <td  class="border-Left-Top-right">&nbsp;</td>
    <td  class="border-top-right">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="2" class="border-bottom-left">&nbsp;</td> 
    <td colspan="5" class="border-All">&nbsp;</td> 
    <td class="border-top-bottom">&nbsp;</td>
    <td class="border-All">&nbsp;</td>
    <td class="border-top-bottom-right">&nbsp;</td>
  </tr>
  
</table>
<table>

</table>

<p>&nbsp;</p>
<?php $invNum=$dataholder['strInvoiceNo'];
			 $qty="SELECT
commercial_invoice_detail.strInvoiceNo,
commercial_invoice_detail.dblCBM,
commercial_invoice_detail.dblGrossMass,
sum(commercial_invoice_detail.dblQuantity) as quantity,
commercial_invoice_detail.dblAmount
FROM
commercial_invoice_detail
WHERE
commercial_invoice_detail.strInvoiceNo = '$invNum'
";
		$result_qty=$db->RunQuery($qty);
	 //echo $qty;
	$qty11=mysql_fetch_array($result_qty);
?>
<?php 
$invNum2=$dataholder['strInvoiceNo'];
$sqlvc="SELECT
shipmentforecast_detail.strSeason,
shipmentforecast_detail.strDeptNo,
shipmentforecast_detail.strStyleNo,
shipmentforecast_detail.strPoNo
FROM
shipmentforecast_detail
INNER JOIN invoicedetail ON invoicedetail.strStyleID = shipmentforecast_detail.strStyleNo AND invoicedetail.strBuyerPONo = shipmentforecast_detail.strPoNo
WHERE
invoicedetail.strInvoiceNo = '$invNum2'";

	$result_vc=$db->RunQuery($sqlvc);
	 //echo $qty;
	$resvc=mysql_fetch_array($result_vc);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="10%" rowspan="2" class="border-All"><div align="center"><strong>Marks &amp; Nos</strong></div></td>
    <td width="7%" rowspan="2" class="border-top-bottom-right"><div align="center"><strong>P.O.No</strong></div></td>
    <td width="28%" rowspan="2" class="border-top-bottom-right"><div align="center"><strong>Stoke #</strong></div></td>
    <td width="5%" rowspan="2" class="border-top-bottom-right"><div align="center"><strong>Dept #</strong></div></td>
    <td width="5%" rowspan="2" class="border-top-bottom-right"><div align="center"><strong>Supp#</strong></div></td>
    <td width="5%" rowspan="2" class="border-top-bottom-right"><div align="center"><strong>Season</strong></div></td>
    <td colspan="4" class="border-top-bottom-right"><div align="center"><strong>Bookings</strong></div></td>
    <td colspan="4" class="border-top-bottom-right"><div align="center"><strong>Actuals</strong></div></td>
  </tr>
  <tr>
    <td width="5%" class="border-bottom-right"><div align="center"><strong>Ctns</strong></div></td>
    <td width="5%" class="border-bottom-right" ><div align="center"><strong>SETS</strong></div></td>
    <td width="5%" class="border-bottom-right"><div align="center"><strong>CBM</strong></div></td>
    <td width="5%" class="border-bottom-right"><div align="center"><strong>Gr.Wgt</strong></div></td>
    <td width="5%"><div align="center" class="border-bottom-right" style="text-align:center"><strong>Ctns</strong></div></td>
    <td width="5%"><div align="center" class="border-bottom-right" style="text-align:center"><strong>PCS</strong></div></td>
    <td width="5%"><div align="center" class="border-bottom-right" style="text-align:center"><strong>CBM</strong></div></td>
    <td width="5%"><div align="center" class="border-bottom-right" style="text-align:center"><strong>Gr.Wgt</strong></div></td>
  </tr>
  <tr>
    <td class="border-Left-bottom-right"><?php echo $dataholder['strMarksAndNos'];?></td>
    <td class="border-bottom-right"><?php echo $dataholder['strBuyerPONo'];?></td>
    <td class="border-bottom-right" style="text-align:center"><?php echo $resvc['strStyleNo'];?></td>
    <td class="border-bottom-right" style="text-align:center"><?php echo $resvc['strDeptNo'];?></td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right" style="text-align:center"><?php echo $resvc['strSeason'];?></td>
    <td class="border-bottom-right" style="text-align:center"><?php if($dataholder['dblGOHstatus']=='0') {echo "CTN";} else{echo "GOH";}?></td>
    <td class="border-bottom-right" style="text-align:center"><?php echo number_format($dataholder['intNoOfCartons'],0);$totctns+=$dataholder["intNoOfCartons"];?></td>
    <td class="border-bottom-right" style="text-align:center"><?php echo round($dataholder['strCBM']); $totcmb+=$dataholder['strCBM'];?></td>
    <td class="border-bottom-right" style="text-align:center"><?php echo $dataholder['dblGrossMass']; $totgw+=$dataholder['dblGrossMass'];?></td>
    <td class="border-bottom-right" style="text-align:center"><?php if($dataholder['dblGOHstatus']=='0') {echo "CTN";} else{echo "GOH";}?></td>
    <td class="border-bottom-right" style="text-align:center"><?php echo $qty11['quantity']; $totpcs+=$qty11['quantity'];?></td>
    <td class="border-bottom-right" style="text-align:center"><?php echo $qty11['dblCBM']; $totcbm+=$qty11['dblCBM'];?></td>
    <td class="border-bottom-right" style="text-align:center"><?php echo $qty11['dblGrossMass']; $totgrw+=$qty11['dblGrossMass'];?></td>
  </tr>
   <tr>
    <td class="border-Left-bottom-right"><?php echo "BOOKING NO :"?></td>
    <td class="border-bottom-right">
	
	<?php 
	
	$booKinNo="SELECT
commercial_invoice_header.strBookingNo
FROM
commercial_invoice_header
INNER JOIN commercial_invoice_detail ON commercial_invoice_header.strInvoiceNo = commercial_invoice_detail.strInvoiceNo
WHERE
commercial_invoice_header.strInvoiceNo = '$invoiceNo'";

$bkresult=$db->RunQuery($booKinNo);
	//echo $sqlinvoiceheader;
	$bookinNo=mysql_fetch_array($bkresult);
?> <?php echo $bookinNo['strBookingNo'];?></td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp; </td>
    <td class="border-bottom-right">&nbsp;</td>
  </tr>
   <tr>
    <td class="border-Left-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp; </td>
    <td class="border-bottom-right">&nbsp;</td>
  </tr>
   <tr>
    <td class="border-Left-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp;</td>
    <td class="border-bottom-right">&nbsp; </td>
    <td class="border-bottom-right">&nbsp;</td>
  </tr>
 
  <tr>
    <td colspan="6" class="border-Left-bottom-right"><div align="center">Total &gt;&gt;&gt;&gt;&gt; &gt;&gt;&gt;&gt;&gt;</div></td>
    <td  class="border-bottom-right">&nbsp;</td>
    <td  class="border-bottom-right" style="text-align:center"><?php echo $totctns;?></td>
    <td  class="border-bottom-right" style="text-align:center"><?php echo $totcmb; ?></td>
    <td  class="border-bottom-right" style="text-align:center"><?php echo $totgw; ?></td>
    <td  class="border-bottom-right">&nbsp;</td>
    <td  class="border-bottom-right" style="text-align:center"><?php echo $totpcs;?></td>
    <td  class="border-bottom-right" style="text-align:center"><?php echo $totcbm; ?></td>
    <td  class="border-bottom-right" style="text-align:center"><?php echo $totgrw; ?></td>
  </tr>
</table>
</body>
<script type="text/javascript">
/*var htpl=$.ajax({url:'../packinglist_formats/pl_levis_euro.php?plno=1',async:false})
$('#pl').html(htpl.responseText);
*/
var i=0;
<?php 

if($limitNo==0){
$str_counter="select			
			strISDno
			from 
			commercial_invoice_detail
			where strInvoiceNo='$invoiceNo'
			group by strISDno order by strISDno				 
				";
$result_counter=$db->RunQuery($str_counter);

while($row_counter=mysql_fetch_array($result_counter))
{if($i>0){?>
	//window.open("ISD.php?InvoiceNo=<?php echo $invoiceNo?> &limitNo=<?php echo $i?>","<?php echo $i.'x'?>");

<?php
}
$i++;
}
}
?>
</script>
</html>