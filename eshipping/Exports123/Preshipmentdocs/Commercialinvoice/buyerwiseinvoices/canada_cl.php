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
$invoiceNo=$_GET['InvoiceNo'];
include("invoice_queries.php");	
//$orientation="jsPrintSetup.kLandscapeOrientation";
$orientation="jsPrintSetup.kPortraitOrientation";
include("printer.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Compliance Letter</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body class="body_bound">
<table width="800" border="0" cellspacing="0" cellpadding="0" style="font-family:'Times New Roman';font-size:14px;font-weight:bold">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" style="font-family:'Times New Roman';font-weight:bold;font-size:40px;text-align:center" bgcolor="#CCCCCC">Orit Trading Lanka (Pvt) Ltd.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" style="font-family:'Times New Roman';font-size:16px;font-weight:bold;text-align:center" bgcolor="#999999"> 07-02, East Tower, Echelon Square, World Trade Centre,Colombo 1. Tel 94-1-346370 Fax 94-1-346376</td>
  </tr>
  <tr>
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
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" style="font-family:'Times New Roman';font-size:16px;font-weight:bold;text-align:center">COMPLIANCE LETTER</td>
  </tr>
  <tr>
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
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">THIS IS TO CONFIRM THAT THE GARMENTS CONTAINED IN THIS SHIPMENT</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">HAVE BEEN INSPECTED AND COMPLY WITH THE CANADIAN REQUIREMENT OF </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">COUNTRY OF ORIGIN ON LABELS AND FABRIC CONTENT LABELS.</td>
  </tr>
  <tr>
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
  </tr>
  </tr>
  <?php $str_desc="select
					strBuyerPONo
					from
					commercial_invoice_detail					
					where 
					strInvoiceNo='$invoiceNo'
					order by strBuyerPONo
					";
					//die($str_desc);
					$no=1;
		$result_desc=$db->RunQuery($str_desc);
		$bool_rec_fst=1;
		while($row_desc=mysql_fetch_array($result_desc) or $no<=2)
		
		{$no++;
			
			if($bool_rec_fst==1){$bool_rec_fst=0;?>
  <tr>
    <td>&nbsp;</td>
    <td>01</td>
    <td>EXPORT  CONTRACT NO &amp; DATE </td>
    <td>:<?php echo $row_desc["strBuyerPONo"];?></td>
  </tr>
  <?php }
 	 else
  		{
	?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;<?php echo $row_desc["strBuyerPONo"];?></td>
  </tr>
   <?php
		  }
		  }?>
  <tr>
  
  <tr>
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
  </tr>
  <?php $str_desc="select distinct
					strSpecDesc
					from
					commercial_invoice_detail					
					where 
					strInvoiceNo='$invoiceNo'
					order by strBuyerPONo
					";
					//die($str_desc);
					$no=1;
		$result_desc=$db->RunQuery($str_desc);
		$bool_rec_fst=1;
		while($row_desc=mysql_fetch_array($result_desc) or $no<=2)
		
		{$no++;
			
			if($bool_rec_fst==1){$bool_rec_fst=0;?>
  <tr>
    <td>&nbsp;</td>
    <td>02</td>
    <td>DESCRIPTION</td>
    <td>:<?php echo $row_desc["strSpecDesc"];?></td>
  </tr>
  <?php }
 	 else
  		{
	?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;<?php echo $row_desc["strSpecDesc"];?></td>
  </tr>
   <?php
		  }
		  }?>
  <tr>
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
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>03</td>
    <td>TOTAL QUANTITY  PCS</td>
    <td>:<?php echo $r_summary->summary_sum($invoiceNo,'dblQuantity')." ".$r_summary->summary_string($invoiceNo,'strUnitID');?></td>
  </tr>
  <tr>
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
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>04</td>
    <td>INVOICE NO &amp; DATE </td>
    <td>:<?php echo $dataholder['strInvoiceNo'];?> OF <?php echo $dateInvoice ;?></td>
  </tr>
  <tr>
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
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php $str_desc="select
					strStyleID					
					from
					commercial_invoice_detail					
					where 
					strInvoiceNo='$invoiceNo'
					order by strBuyerPONo
					";
					//die($str_desc);
		$no=1;
		$result_desc=$db->RunQuery($str_desc);
		$bool_rec_fst=1;
		while($row_desc=mysql_fetch_array($result_desc) or $no<=2)
		
		{$no++;
			
			if($bool_rec_fst==1){$bool_rec_fst=0;?>
  <tr>
    <td>&nbsp;</td>
    <td>05</td>
    <td>STYLE NO/FABRIC </td>
    <td>:<?php echo $row_desc["strStyleID"];?></td>
  </tr>
   <?php }
 	 else
  		{
	?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;<?php echo $row_desc["strStyleID"];?></td>
  </tr>
  <?php }}?>
  <tr>
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
  </tr>
   <?php $str_desc="select
					strFabric
					from
					commercial_invoice_detail					
					where 
					strInvoiceNo='$invoiceNo'";
					//die($str_desc);
					$no=1;
		$result_desc=$db->RunQuery($str_desc);
		$bool_rec_fst=1;
		while($row_desc=mysql_fetch_array($result_desc) or $no<=2)
		
		{$no++;?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php echo $row_desc["strFabric"];?></td>
  </tr><?php }?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>06</td>
    <td>P.S NUMBER </td>
    <td>:<?php echo $com_inv_dataholder['strPSno'];?></td>
  </tr>
  <tr>
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
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>07</td>
    <td>AMOUNT IN US$</td>
    <td>:<?php $tot_term_amt=$r_summary->summary_sum($invoiceNo,'dblAmount')+($r_summary->summary_sum($invoiceNo,'dblQuantity'))*$tot_ch; echo number_format($tot_term_amt,2);?> </td>
  </tr>
  <tr>
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
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>08</td>
    <td><?php echo ($com_inv_dataholder['strHAWB']!=""?"HAWB":"B/L");?> NO &amp; DATE</td>
    <td>:<?php echo($com_inv_dataholder['strHAWB']!=""?$com_inv_dataholder['strHAWB']:$com_inv_dataholder['strBL']);?> OF <?php echo $dateInvoice ;?></td>
  </tr>
  <tr>
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
  </tr>
  <tr>
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
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" style="font-family:'Times New Roman';font-size:18px;font-weight:bold;text-align:center">ORIT TRADING LANKA (PVT) LTD</td>
  </tr>
  <tr>
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
  </tr>
  <tr>
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
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" style="font-family:'Times New Roman';font-size:16px;font-weight:bold;text-align:center">Commercial Manager</td>
  </tr>
  <tr>
    <td  width="8%">&nbsp;</td>
    <td  width="7%">&nbsp;</td>
    <td  width="35%">&nbsp;</td>
    <td  width="50%">&nbsp;</td>
  </tr>
</table>
</body>
</html>