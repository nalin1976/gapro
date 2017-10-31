<?php 
session_start();
include "../../../../Connector.php";
$invoiceNo=$_GET['InvoiceNo'];	
$str_header		="select 
date(dtmInvoiceDate) as dtmSailingDate,
strContainer,
strVoyegeNo,
strCarrier,
strSealNo,
strBL
from 
commercial_invoice_header
left join finalinvoice on commercial_invoice_header.strInvoiceNo=finalinvoice.strInvoiceNo
where  finalinvoice.strInvoiceNo='$invoiceNo'";
$result_header	=$db->RunQuery($str_header);
$data_header	=mysql_fetch_array($result_header);
$sail_date_array=explode("-",$data_header[dtmSailingDate]);	
$s_date=$sail_date_array[2]."/".$sail_date_array[1]."/".$sail_date_array[0];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NON DENIM</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="800" border="0" cellspacing="0" cellpadding="0" class="normalfnt_size12" style="line-height:25px;font-size:16px;font-weight:600">
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
    <td colspan="4" class="head2BLCK" style="font-size:18px;text-decoration:underline">BENEFICIARY CERTIFICATE</td>
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
    <td>TO:  US CUSTOMS</td>
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
    <td>INVOICE#</td>
    <td colspan="2"><?php echo $invoiceNo;?></td>
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
    <td>BL #</td>
    <td colspan="2"><?php echo $data_header['strBL'];?></td>
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
    <td>CONTAINER NO</td>
    <td colspan="2"><?php echo $data_header['strContainer'];?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr> <?php $str_desc="select
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
    <td>PO / MATERIAL #</td>
    <td colspan="2"><?php echo $row_desc["strBuyerPONo"];?></td>
    <td><?php echo $row_desc["strStyleID"];?></td>
  </tr>
   <?php }
              
              else{?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2"><?php echo $row_desc["strBuyerPONo"];?></td>
    <td><?php echo $row_desc["strStyleID"];?></td>
  </tr>
  <?php
		  }
		  }?>
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
    <td colspan="4">WE HEREBY CERTIFY THAT  THE ABOVE GARMENTS ARE NOT  DENIM.</td>
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
    <td width="8%">&nbsp;</td>
    <td width="31%">&nbsp;</td>
    <td width="6%">&nbsp;</td>
    <td width="22%">&nbsp;</td>
    <td width="33%">&nbsp;</td>
  </tr>
</table>
</body>
</html>
