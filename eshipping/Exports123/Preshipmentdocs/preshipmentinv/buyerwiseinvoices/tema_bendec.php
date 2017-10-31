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
//$invoiceNo='10210/OTL/09/10';
include("invoice_queries.php");	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TEMA BEN DEC</title>
<?php 
//$orientation="jsPrintSetup.kLandscapeOrientation";
$orientation="jsPrintSetup.kPortraitOrientation";
include("printer.php");?>
</head>

<body class="body_bound">
<table width="850" border="0" cellspacing="0" cellpadding="2" style="font-family:Book Antiqua;font-size:14px;">
  <tr>
    <td colspan="5" style="font-family:forte;font-size:52px;"> <?php echo $Company; ?></td>
  </tr>
  <tr>
    <td colspan="5" style="font-family:forte;font-size:13px;" nowrap="nowrap"><?php echo $Address; ?><?php echo $City; ?>. Tel:<?php echo $phone;  ?> Fax: <?php echo $Fax; ?></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"><?php echo $dateInvoice;?></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" style="font-family:Book Antiqua;font-size:16px;"><strong><u>BENEFICIARY'S DECLARATION</u></strong></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td width="214">LETTER OF CREDIT NO</td>
    <td><span class="normalfnt_size12"><?php echo $dataholder["LCNO"];?> </span></td>
    <td width="52">DATE</td>
    <td colspan="2" ><?php echo $dataholder["dtmLCDate"];?></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>INVOICE NO</td>
    <td colspan="3"><?php echo $invoiceNo;?></td>
    <td width="248"></td>
  </tr>
  <?php
  	$id=0;
	$totQuentity=0;
	$tot=0;
  	$sql = "select strInvoiceNo,strBuyerPONo,dblQuantity,dblAmount
			from commercial_invoice_detail
			where strInvoiceNo='$invoiceNo';";
			
	$result=$db->RunQuery($sql);
	while(($row=mysql_fetch_array($result))||($count<5))
	{
		$totQuentity+=$row["dblQuantity"];
		$tot+=$row["dblAmount"]+$tot_ch*$row_desc["dblQuantity"];
		
			if($id==0)
			{
  ?>
		  <tr>
			<td>P.O.NO</td>
			<td colspan="4"><?php echo $row["strBuyerPONo"]; ?></td>
		  </tr>	
		  <?php
		  	}
			else
			{
			?>
			 <tr>
				<td></td>
				<td colspan="4"><?php echo $row["strBuyerPONo"]; ?></td>
		  	</tr>		
			<?php
			}
			$count++;
			$id++;
	}
	$dzs=$totQuentity/12;
	?>	  
  <tr>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>QUANTITY</td>
    <td width="181"><?php echo $totQuentity; ?> PCS</td>
    <td colspan="3"><?php echo round($dzs,2);?> DZS</td>
  </tr>
  <tr>
    <td>U.S. DOLLAR AMOUNT</td>
    <td colspan="4"><?php echo number_format($tot,2); ?></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">WE HEREBY CERTIFY FOLLOWING DOCUMENTS HAVE BEEN SENT DIRECTLY TO THE FORWARDER </td>
  </tr>
  <tr>
    <td colspan="5">FOR ACCOMPANYING CARGO</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">
      <table width="75%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="28%" height="20">&nbsp;</td>
          <td width="4%">A.</td>
          <td width="68%">02 ORIGINAL INVOICES</td>
        </tr>
        <tr>
          <td height="20">&nbsp;</td>
          <td>B.</td>
          <td>1 ORIGINAL CERTIFICATE OF ORIGIN FORM &quot;A&quot;</td>
        </tr>
        <tr>
          <td height="20">&nbsp;</td>
          <td>C.</td>
          <td>2 ORIGINAL PACKING LIST AND WEIGHT LIST</td>
        </tr>
        <tr>
          <td height="20">&nbsp;</td>
          <td>D.</td>
          <td>1 COPY TEMA AQL REPORT</td>
        </tr>
      </table>    </td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" style="font-family:Book Antiqua;font-size:20px;"><strong>ORIT TRADING LANKA (PVT) LTD</strong></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"><strong>Commercial Manager</strong></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
</table>
</body>
</html>