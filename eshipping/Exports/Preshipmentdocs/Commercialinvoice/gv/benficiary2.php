<?php 
session_start();
include "../../../../Connector.php";
$invoiceNo=$_GET['InvoiceNo'];	
$str_header		="select 
date(dtmInvoiceDate) as dtmSailingDate,
strContainer,
sum(dblQuantity) as qty,
sum(dblAmount) as amt, 
strVoyegeNo,
strCarrier,
strSealNo,
strBL
from 
commercial_invoice_header
left join finalinvoice on commercial_invoice_header.strInvoiceNo=finalinvoice.strInvoiceNo
left join commercial_invoice_detail on commercial_invoice_header.strInvoiceNo=commercial_invoice_detail.strInvoiceNo
where  finalinvoice.strInvoiceNo='$invoiceNo' group by finalinvoice.strInvoiceNo";
$result_header	=$db->RunQuery($str_header);
$data_header	=mysql_fetch_array($result_header);
$sail_date_array=explode("-",$data_header[dtmSailingDate]);	
$s_date=$sail_date_array[2]."/".$sail_date_array[1]."/".$sail_date_array[0];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BENEFICIARY STATEMENT</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="800" border="0" cellspacing="0" cellpadding="0" class="normalfnt_size12" style="line-height:20px;font-size:12px">
  <tr>
    <td>&nbsp;</td>
    <td colspan="4" style="text-align:center"><span class="head2BLCK">ORIT TRADING LANKA (PVT) LTD</span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4" class="normalfnt2bldBLACKmid">07-02, EAST TOWER,    WORLD TRADE CENTRE,ECHELON SQUARE, COLOMBO 01,Sri Lanka </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4" class="normalfnt2bldBLACKmid">Tel:2346370-5    Fax:2346376</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4" class="head2BLCK" style="font-size:18px;text-decoration:underline">BENEFICIARY'S STATEMENT</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Date</td>
    <td colspan="2"><?php echo $s_date;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>MID CODE</td>
    <td colspan="2">LKORIAPPMAR</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>PAYMENT</td>
    <td colspan="2">T/T</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td >&nbsp;</td>
    <td>INVOICE NO</td>
    <td colspan="2"><?php echo $invoiceNo;?></td>
    <td>&nbsp;</td>
  </tr>
  <?php $str_desc="select
					strDescOfGoods,
					strBuyerPONo,
					strStyleID,
					dblQuantity,
					dblUnitPrice,
					dblAmount,
					intNoOfCTns,
					strFabric,
					strISDno
					from
					commercial_invoice_detail					
					where 
					strInvoiceNo='$invoiceNo'";
					//die($str_desc);
					$no=1;
		$result_desc=$db->RunQuery($str_desc);
		$bool_rec_fst=1;
		while($row_desc=mysql_fetch_array($result_desc) or $no<=2)
		
		{$no++;
			
			if($bool_rec_fst==1){$bool_rec_fst=0;?>
  <tr>
    <td>&nbsp;</td>
    <td>ORDER NO</td>
    <td colspan="2"><?php echo $row_desc["strBuyerPONo"];?></td>
    <td>&nbsp;</td>
  </tr>
  <?php }
              
              else{?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2"><?php echo $row_desc["strBuyerPONo"];?></td>
    <td>&nbsp;</td>
  </tr>
   <?php
		  }
		  }?>
  <?php $result_desc=$db->RunQuery($str_desc);
		$bool_rec_fst=1;
		$no=0;
		while($row_desc=mysql_fetch_array($result_desc) or $no<=2)
		
		{$no++;
			
			if($bool_rec_fst==1){$bool_rec_fst=0;?>
  <tr>
    <td>&nbsp;</td>
    <td>MATERIAL NO</td>
    <td colspan="2"><?php echo $row_desc["strStyleID"];?></td>
    <td>&nbsp;</td>
  </tr>
   <?php }         
     else{?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2"><?php echo $row_desc["strStyleID"];?></td>
    <td>&nbsp;</td>
  </tr>
  <?php
		  }
		  }
	?>
  <tr>
    <td>&nbsp;</td>
    <td>QUANTITY</td>
    <td><?php echo number_format($data_header['qty'],2);?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>U.S. DOLLAR AMOUNT</td>
    <td colspan="2"><?php echo  "$".number_format($data_header['amt'],2);?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
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
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">WE HEREBY CERTIFY THAT :</td>
    <td>&nbsp;</td>
  </tr>
  
  
  <tr>
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
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4">A. ONE FULL SET OF LEGIBLE PHOTOCOPIED DOCUMENTS HAVE BEEN DHL/FEDEX WITHIN 10 DAYS OF ARRIVAL TO NORTON MCNAUGHTON 463 7TH AVENUE - 9TH FLOOR NEW YORK, NY 10018 ATTN: TRAFFIC DEPT.<br />
      B. FOR OCEAN SHIPMENTS : ONE SET OF ORIGINAL SHIPPING DOCUMENTS INCLUDING 1/3 ORIGINAL MARINE/OCEAN BILL OF LADING AND VISAED COMMERCIAL INVOICE WITH CATEGORY NUMBER HAVE BEEN SENT BY DHL/FED-EX TO BARTHCO INTERNATIONAL 5900 CORE AVE. SUITE 400 NORTH CHARLESTON, SC. 29406 WITHIN 10 DAYS OF SHIPMENT ARRIVAL,<br />
      C. FOR AIR SHIPMENTS : ONE SET OF ORIGINAL SHIPPING DOCUMENTS INCLUDING ORIGINAL AIR WAYBILL CONSIGNED TO NORTON MCNAUGHTON OF SQUIRE, INC. VISAED INVOICE, COMMERCIAL INVOICE, COUNTRY DECLARATION, INSPECTION CERTIFICATE AND QUOTA STATEMENT HAVE ACCOMPANIED THE SHIPMENT. D. FULL SET OF COPIES OF SHIPPING DOCUMENTS INCLUDING DETAILED PACKING LIST PER CONTAINER WERE FAXED/E-MAILED TO NORTON PRODUCTION/TRAFFIC LIST PER CONTAINER WERE FAXED/E-MAILED TO NORTON PRODUCTION/TRAFFIC</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">ORIT TRADING LANKA (PVT) LTD</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
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
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>COMMERCIAL MANAGER</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="6%">&nbsp;</td>
    <td width="30%">&nbsp;</td>
    <td width="21%">&nbsp;</td>
    <td width="18%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
  </tr>
</table>
</body>
</html>
