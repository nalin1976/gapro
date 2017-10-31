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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BENEFICIARY'S CERTIFICATE</title>
<?php 
//$orientation="jsPrintSetup.kLandscapeOrientation";
$orientation="jsPrintSetup.kPortraitOrientation";
include("printer.php");?>
</head>

<body class="body_bound">
<table width="850" border="0" cellspacing="0" cellpadding="2" style="font-family:Book Antiqua;font-size:14px;" align="center">
  <tr>
    <td colspan="5" style="font-family:'Trebuchet MS';font-size:28px; text-align:center" nowrap="nowrap">HELA CLOTHING (PVT) LTD</td>
  </tr>
  <tr>
    <td colspan="5" style="font-family:'Trebuchet MS';font-size:17px; text-align:center" nowrap="nowrap">309/11, NEGOMBO ROAD</td>
  </tr>
  <tr>
    <td colspan="5" style="font-family:'Trebuchet MS';font-size:17px; text-align:center">WELISARA SRI LANKA.</td>
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
    <td colspan="5" style="font-family:Times-new-roman;font-size:22px; text-align:center"><strong>BENEFICIARY'S CERTIFICATE</strong></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td width="249">LETTER OF CREDIT NO</td>
    <td><span class="normalfnt_size12"><?php echo $dataholder["LCNO"];?>  </span></td>
    <td width="49">DATE</td>
    <td colspan="2"><?php echo $dataholder["dtmLCDate"];?></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>INVOICE NO</td>
    <td colspan="3"><?php echo $invoiceNo;?></td>
    <td width="241"></td>
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
		    <td>&nbsp;</td>
		    <td colspan="4">&nbsp;</td>
  </tr>
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
    <td width="149"><?php echo $totQuentity; ?> PCS</td>
    <td colspan="3"><?php echo round($dzs,2);?> DZS</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>U.S. DOLLAR AMOUNT</td>
    <td colspan="4"><?php echo number_format($tot,2); ?></td>
  </tr>
  <tr>
    <td colspan="5">------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
  </tr>
  <tr>
    <td colspan="5">WE HERE BY CERTIFY THAT:</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">WE WILL BEAR ANY COSTS(EG.DEMURRAGE COSTS) INCURRED DUE TO DISCREPANCIES IN DOCUMENTS</td>
  </tr>
  <tr>
    <td colspan="5">PRESENTED PROVIDING THAT THE FAULT IS THAT OF THE SUPPLIER.</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">WE WILL BEAR ANY REFURBISHMENT COSTS INCURRED BY THE APPLICANT (ASDA STORES LTD) DUE TO</td>
  </tr>
  <tr>
    <td colspan="5">THE GOODS BEING OF A SUBSTANDARED QUALITY PROVIDING SUBSTANTIATING EVEDENCE IS GIVEN</td>
  </tr>
  <tr>
    <td colspan="5">TO SUBSTAIN THE CLAIM AND THAT BOTH PARTIES AGREE.</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">ONE COPY OF FULL SETS OF DOCUMENTS (AS PER THE LIST BELOW) HAVE BEEN COURIERED TO SPEED</td>
  </tr>
  <tr>
    <td colspan="5">MARK TRANSPORT NO 49 WARD PLACE COLOMBO 07, SRI LANKA</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">WITHIN 5 DAYS OF THE SHIPPED ON BOARD DATE</td>
  </tr>
  <tr>
    <td colspan="5">1  ORIGINAL COMMERCIAL INVOICE</td>
  </tr>
  <tr>
    <td colspan="5">1  ORIGINAL PACKING LIST</td>
  </tr>
  <tr>
    <td colspan="5">1  COPY FORWARDER CARGO RECEIPT</td>
  </tr>
  <tr>
    <td colspan="5">1  ORIGINAL CERTIFICATE OF ORIGIN</td>
  </tr>
  <tr>
    <td colspan="5">1  ORIGINAL CONTAINER MANIFEST</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
</table>
</body>
</html>