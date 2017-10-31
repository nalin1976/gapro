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
$Com_TinNo=$xmldoc->companySettings->TinNo;
$invoiceNo=$_GET['InvoiceNo'];
include("invoice_queries.php");	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CERTIFICATE OF ORIGIN</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<?php 
//$orientation="jsPrintSetup.kLandscapeOrientation";
$orientation="jsPrintSetup.kPortraitOrientation";
include("printer.php");?>
</head>

<body class="body_bound">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td style="text-align:center;font-family:'Times New Roman';font-weight:bold;font-size:16px">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="text-align:center;font-family:'Times New Roman';font-weight:bold;font-size:14px">CERTIFICATE OF ORIGIN</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="3" class="normalfnt">
      <tr>
        <td height="">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="">The undersigned : </td>
        <td colspan="4"><strong><?php echo $Company;?> / <?php echo $dataholder['CustomerName'];?></strong></td>
        </tr>
      <tr>
        <td height="">&nbsp;</td>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td height="">Factory Address :</td>
        <td colspan="4"><strong><?php echo $Company;?></strong></td>
      </tr>
      <tr>
        <td height="">&nbsp;</td>
        <td colspan="4"><strong><?php echo $Address;?></strong></td>
      </tr>
      <tr>
        <td height="">&nbsp;</td>
        <td colspan="4"><strong><?php echo $City;?></strong></td>
      </tr>
      <tr>
        <td height="">&nbsp;</td>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td height="">Factory City:</td>
        <td colspan="4"><strong>COLOMBO</strong></td>
      </tr>
      <tr>
        <td height="">&nbsp;</td>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td height="">Factory Country:</td>
        <td colspan="4"><strong>SRI LANKA</strong></td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td colspan="4">&nbsp;</td>
        </tr>
      <tr>
        <td height="" colspan="5">Verifies that the goods being declared here in were made at the above factory in the country <br />of origin stated below and is able and willing to provide backup </td>
      </tr>
      <tr>
        <td height="" colspan="5">&nbsp;</td>
      </tr>
      <tr>
        <td height="">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="" colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="25" class="border-Left-Top-right-fntsize12" style="text-align:center"><strong>HYBRID PROMOTIONS LLC P.O.No.,</strong></td>
            <td colspan="2" class="border-top-right-fntsize12"  style="text-align:center"><strong>Description </strong></td>
            <td class="border-top-right-fntsize12"  style="text-align:center"><strong>Country</strong></td>
          </tr>
          <tr>
            <td class="border-Left-Top-right-fntsize12" style="text-align:center">&nbsp;</td>
            <td colspan="2" class="border-top-right-fntsize10" style="text-align:center">&nbsp;</td>
            <td class="border-top-right-fntsize10">&nbsp;</td>
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
					strISDno,
					dblGrossMass,
					dblNetMass,
					dblNetNet,
					strHSCode
					from
					commercial_invoice_detail					
					where 
					strInvoiceNo='$invoiceNo'";
					//die($str_desc);
		$result_desc=$db->RunQuery($str_desc);
		$bool_rec_fst=1;
		while($row_desc=mysql_fetch_array($result_desc)){
		$tot+=$row_desc["dblAmount"]+$tot_ch*$row_desc["dblQuantity"];
		$totqty+=$row_desc["dblQuantity"];
		$totctns+=$row_desc["intNoOfCTns"];
		$price_dtl=$row_desc["dblUnitPrice"]+$tot_ch;
		$amt_dtl=$row_desc["dblAmount"]+$tot_ch*$row_desc["dblQuantity"];
		$hts_code=$row_desc["strHSCode"];
	  ?>
          <tr>
            <td class="border-left-right-fntsize10" style="text-align:center"><?php echo $row_desc["strBuyerPONo"];?></td>
            <td colspan="2" class="border-right-fntsize10"><?php echo $row_desc["strDescOfGoods"];?></td>
            <td class="border-right-fntsize10" style="text-align:center">SRI LANKA</td>
          </tr>
          <tr>
            <td class="border-left-right-fntsize10">&nbsp;</td>
            <td>&nbsp;</td>
            <td class="border-right-fntsize10">&nbsp;</td>
            <td class="border-right-fntsize10">&nbsp;</td>
          </tr>
          <?php }?>
          <tr>
            <td class="border-top">&nbsp;</td>
            <td class="border-top">&nbsp;</td>
            <td class="border-top">&nbsp;</td>
            <td class="border-top">&nbsp;</td>
          </tr>
          <tr>
            <td width="30%">&nbsp;</td>
            <td width="15%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
            <td width="35%">&nbsp;</td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td height="">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="">Furthermore I Certify that :</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="">&nbsp;</td>
        <td colspan="4">•&nbsp;&nbsp;&nbsp;I have signature authorization for this company.</td>
        </tr>
      <tr>
        <td height="">&nbsp;</td>
        <td colspan="4">•&nbsp;&nbsp;&nbsp;I have production and manufacturing knowledge of the product declared on this document.</td>
        </tr>
      <tr>
        <td height="">&nbsp;</td>
        <td colspan="4">•&nbsp;&nbsp;&nbsp;I understand that I am liable for any false statements or material omissions made on or in connection<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;with this document.</td>
        </tr>
      <tr>
        <td height="">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="" colspan="5">&nbsp;</td>
      </tr>
      <tr>
        <td height="" colspan="5">I certify  that the information  provided above is true and correct.</td>
      </tr>
      <tr>
        <td height="" colspan="5">&nbsp;</td>
      </tr>
      <tr>
        <td height="" colspan="5">&nbsp;</td>
        </tr>
      <tr>
        <td height="">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="">&nbsp;</td>
        <td colspan="4" class="border-bottom-fntsize10">&nbsp;</td>
        </tr>
      <tr>
        <td height="">&nbsp;</td>
        <td colspan="2">Signature of producer / manufacture</td>
        <td>&nbsp;</td>
        <td>Date</td>
      </tr>
      <tr>
        <td height="">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="">&nbsp;</td>
        <td colspan="2" class="border-bottom-fntsize10"><strong>UDAYA PERERA</strong></td>
        <td colspan="2" class="border-bottom-fntsize10"><strong>COMMERCIAL MANAGER</strong></td>
        </tr>
      <tr>
        <td height="">&nbsp;</td>
        <td colspan="2">Print Name and title</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="21%" height="">&nbsp;</td>
        <td width="24%">&nbsp;</td>
        <td width="10%">&nbsp;</td>
        <td width="9%">&nbsp;</td>
        <td width="36%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="5%">&nbsp;</td>
    <td width="95%">&nbsp;</td>
  </tr>
</table>
</body>
</html>