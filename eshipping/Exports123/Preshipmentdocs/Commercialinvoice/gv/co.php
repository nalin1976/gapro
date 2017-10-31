<?php 
session_start();
include "../../../../Connector.php";
$invoiceNo=$_GET['InvoiceNo'];	
$str_header		="select 
date(dtmInvoiceDate) as dtmSailingDate,
buyers.strName AS BuyerAName, 
buyers.strAddress1 AS buyerAddress1 ,
buyers.strAddress2 AS buyerAddress2,
strContainer,
strVoyegeNo,
strCarrier,
sum(dblQuantity) as qty,
sum(dblAmount) as amt, 
strSealNo,
strBL
from 
commercial_invoice_header
left join finalinvoice on commercial_invoice_header.strInvoiceNo=finalinvoice.strInvoiceNo
LEFT JOIN buyers ON commercial_invoice_header.strBuyerID =buyers.strBuyerID 
left join commercial_invoice_detail on commercial_invoice_header.strInvoiceNo=commercial_invoice_detail.strInvoiceNo
where  finalinvoice.strInvoiceNo='$invoiceNo' group by finalinvoice.strInvoiceNo";
//die($str_header);
$result_header	=$db->RunQuery($str_header);
$data_header	=mysql_fetch_array($result_header);
$sail_date_array=explode("-",$data_header[dtmSailingDate]);	
$s_date=$sail_date_array[2]."/".$sail_date_array[1]."/".$sail_date_array[0];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CERTIFICATE OF ORIGIN</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="800" border="0" cellspacing="0" cellpadding="0" class="normalfnt_size12" style="line-height:25px;font-size:12px;font-weight:600">
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4" style="text-align:center">&nbsp;</td>
  </tr>
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
    <td colspan="4" class="head2BLCK" style="font-size:15px;text-decoration:underline">CERTIFICATE OF ORIGIN</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><?php echo $s_date;?></td>
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
    <td><table cellspacing="0" cellpadding="0">
      <tr>
        <td width="152">BUYER:</td>
      </tr>
    </table></td>
    <td colspan="3"><?php echo $data_header['BuyerAName'];?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3"><?php echo $data_header['buyerAddress1'];?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3"><?php echo $data_header['buyerAddress2'];?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>PAYMENT</td>
    <td colspan="2">T/T</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>INVOICE#</td>
    <td colspan="2"><?php echo $invoiceNo;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>MID NO#</td>
    <td colspan="2">LKORIAPPMAR</td>
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
    <td>QTY</td>
    <td colspan="2"><?php echo number_format($data_header['qty'],2);?>PCS.</td>
    <td><?php echo number_format($data_header['qty']/12,2);?>DZN.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4" class="border-top">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4">WE    HEREBY CERTIFY THAT THE ABOVE MENTIONED CONSIGNMENT IS OF SRI LANKA ORIGIN.</td>
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
    <td colspan="4">ORIT TRADING LANKA (PVT) LTD</td>
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
    <td width="7%">&nbsp;</td>
    <td width="33%">&nbsp;</td>
    <td width="12%">&nbsp;</td>
    <td width="24%">&nbsp;</td>
    <td width="24%">&nbsp;</td>
  </tr>
</table>
</body>
</html>
