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
    <td colspan="2" style="font-family:'Trebuchet MS';font-size:28px; text-align:center" nowrap="nowrap">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" style="font-family:'Trebuchet MS';font-size:17px; text-align:center" nowrap="nowrap">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" style="font-family:'Trebuchet MS';font-size:17px;" nowrap="nowrap"><?php echo $dateInvoice;?></td>
  </tr>
  <tr>
    <td colspan="2" style="font-family:'Times-New-Roman';font-size:25px; text-align:center" nowrap="nowrap">REACH COMPLIANCE DECLARATION</td>
  </tr>
  
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="2" style="font-size:20px">I, undersigned J.P.D.S.K. Jayawickrama as legal representative of Hela Clothing (Pvt) Ltd.,</td>
  </tr>
  <tr>
    <td colspan="2" style="font-size:21px;">No. 309/11, Negombo Road, Welisara, Sri Lanka Declare that goods provided to Trader</td>
  </tr>
  <tr>
    <td colspan="2" style="font-size:22px;">SRL, Interporto Di Nola Lotto H, Blocco C, Localita, Boscofangone 80035 Nola (NA)</td>
  </tr>
  <tr>
    <td colspan="2" style="font-size:22px;">Italy under invoice number dated on have been manufactured with full compliance to </td>
  </tr>
  <tr>
    <td colspan="2" style="font-size:22px;">REACH relevant Regulation(S).</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
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
		    <td colspan="2">&nbsp;</td>
  </tr>
		  <tr>
			<td colspan="2">&nbsp;</td>
		  </tr>	
		  <?php
		  	}
			else
			{
			?>
			 <tr>
				<td colspan="2"></td>
			</tr>		
			<?php
			}
			$count++;
			$id++;
	}
	$dzs=$totQuentity/12;
	?>	  
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td style="font-size:22px;">Signed by - Kolitha Jayawickrama</td>
  </tr>
  <tr>
    <td colspan="0" style="font-size:18px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Commercial Manager)</td>
   
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><?php echo $dateInvoice;?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
</body>
</html>