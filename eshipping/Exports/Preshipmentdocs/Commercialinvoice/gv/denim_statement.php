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
<title>DENIM STATEMENT</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table cellspacing="0" cellpadding="0" class="normalfnt_size12" style="line-height:20px;font-size:14px">
 
  <tr>
    <td height="20" colspan="6" class="head2BLCK">ORIT TRADING LANKA (PVT) LTD</td>
  </tr>
  <tr>
    <td colspan="6" class="normalfnt2bldBLACKmid">07-02, EAST TOWER,    WORLD TRADE CENTRE,ECHELON SQUARE, COLOMBO 01,Sri Lanka </td>
  </tr>
  <tr>
    <td colspan="6" class="normalfnt2bldBLACKmid">Tel:2346370-5    Fax:2346376</td>
  </tr>
  <tr>
    <td width="53"></td>
    <td width="196"></td>
    <td width="72"></td>
    <td width="224"></td>
    <td width="125"></td>
    <td width="50"></td>
  </tr>
  <tr>
    <td colspan="6" >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" class="head2BLCK" style="font-size:18px;text-decoration:underline">DENIM STATEMENT</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="2">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="2" class="normalfnt_size20" style="font-size:14px" height="25">TO:  US CUSTOMS</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr  class="normalfnt_size20" style="font-size:14px">
    <td></td>
    <td height="25">PAYMENT#</td>
    <td></td>
    <td>T/T</td>
    <td></td>
    <td></td>
  </tr>
  <tr  class="normalfnt_size20" style="font-size:14px">
    <td></td>
    <td height="25">MID NO#</td>
    <td></td>
    <td>LKORIAPPMAR</td>
    <td></td>
    <td></td>
  </tr>
  <tr  class="normalfnt_size20" style="font-size:14px">
    <td></td>
    <td height="25">INVOICE#</td>
    <td></td>
    <td><?php echo $invoiceNo;?></td>
    <td></td>
    <td></td>
  </tr>
  <tr  class="normalfnt_size20" style="font-size:14px">
    <td></td>
    <td height="25">BL NO:</td>
    <td></td>
    <td><?php echo $data_header['strBL'];?></td>
    <td></td>
    <td></td>
  </tr>
  <tr  class="normalfnt_size20" style="font-size:14px">
    <td></td>
    <td colspan="2" height="25" >CONTAINER NO</td>
    <td><?php echo $data_header['strContainer'];?></td>
    <td></td>
    <td></td>
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
		while($row_desc=mysql_fetch_array($result_desc) or $no<=5)
		
		{$no++;
			
			if($bool_rec_fst==1){$bool_rec_fst=0;?>
        
          <tr  class="normalfnt_size20" style="font-size:14px">
            <td></td>
            <td colspan="2" height="25">PO/MATERIAL#</td>
            <td><?php echo $row_desc["strBuyerPONo"];?></td>
            <td colspan="2"><?php echo $row_desc["strStyleID"];?></td>
          </tr><?php }
		  
		  else{?>
          
          <tr  class="normalfnt_size20" style="font-size:14px">
            <td></td>
            <td colspan="2" height="25"></td>
            <td><?php echo $row_desc["strBuyerPONo"];?></td>
            <td colspan="2"><?php echo $row_desc["strStyleID"];?></td>
          </tr>
          
          <?php
		  }
		  }?>
   <tr  class="normalfnt_size20" style="font-size:14px">
    <td></td>
    <td colspan="2" height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td colspan="5">The denim garments and/or    accessories that accompany this invoice </td>
  </tr>
  <tr>
    <td></td>
    <td colspan="3">were not made by process    in which:</td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="3">&nbsp;</td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="5" rowspan="12">1) the denim garments    and/or accessories were disposed in a chamber in dry contacttogethere with franules    or a coarse, permeable material (including without limitation pumice    stones)which have been    impregnated with a bleaching agent (including without limitation    hypochloritebleach and/or potassium    permanganate),</td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td colspan="5" rowspan="5">2) the denim garment    and/or accessories were bleached in a dry state by dry-tumbline thethe denim garments and/or    accessories and the granules together for a period of timesufficient randomly datde    the denim garment and/or accessories; or</td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="4">&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="5" rowspan="2">3) The faded denim    garment and/or accessories are separated from the granules.</td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td> </td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td>Date:</td>
    <td><?php echo $s_date;?></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td>Name:</td>
    <td colspan="2">UDAYA PERERA</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td>Signature:</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td>Title:</td>
    <td colspan="2">COMMERCIAL MANAGER</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table>
</body>
</html>