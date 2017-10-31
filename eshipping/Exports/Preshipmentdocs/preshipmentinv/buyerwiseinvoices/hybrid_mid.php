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
<title>MID VERIFICATION STATEMENT</title>
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
    <td style="text-align:center;font-family:'Times New Roman';font-weight:bold;font-size:14px">MID VERIFICATION STATEMENT</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="3" class="normalfnt">
      <tr>
        <td height="">To:</td>
        <td colspan="2"><?php echo $forwaderName;?></td>
        <td>Date:</td>
        <td><?php echo $dateInvoice ;?></td>
      </tr>
      <tr>
        <td height="">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="">Attn:</td>
        <td colspan="2">&nbsp;</td>
        <td>From:</td>
        <td><?php echo $Company;?></td>
      </tr>
      <tr>
        <td height="">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="">Re.File#</td>
        <td colspan="2">&nbsp;</td>
        <td>HBL/MBL#</td>
        <td><?php echo ($com_inv_dataholder['strBL']==""?$com_inv_dataholder['strHAWB']:$com_inv_dataholder['strBL']);?></td>
      </tr>
      <tr>
        <td height="">&nbsp;</td>
        <td colspan="2">(Pls Leave blank for fowarder's Use Only)</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="" colspan="5">&nbsp;</td>
      </tr>
      <tr>
        <td height="" colspan="5">&nbsp;</td>
      </tr>
      <tr>
        <td height="" colspan="5">To address U.S Customs requirement to disclose the origin-conferring manufacturer of merchandise</td>
      </tr>
      <tr>
        <td height="" colspan="5">coming outside the United States (in prusuance of TBT 05-029 and 05-031). We declare the following:</td>
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
            <td height="25" class="border-Left-Top-right-fntsize12" style="text-align:center"><strong>Invoice</strong></td>
            <td colspan="2" class="border-top-right-fntsize12"  style="text-align:center"><strong>Description </strong></td>
            <td class="border-top-right-fntsize12"  style="text-align:center"><strong>Origin-conferring Manufacturer's Name &amp; Address:</strong></td>
          </tr>
          <tr>
            <td class="border-Left-Top-right-fntsize12" style="text-align:center">&nbsp;</td>
            <td colspan="2" class="border-top-right-fntsize10" style="text-align:center">&nbsp;</td>
            <td class="border-top-right-fntsize10"><?php echo $Company;?></td>
          </tr>
          <tr>
            <td class="border-left-right-fntsize10" style="text-align:center"><?php echo $invoiceNo;?></td>
            <td>&nbsp;</td>
            <td class="border-right-fntsize10">&nbsp;</td>
            <td class="border-right-fntsize10"><?php echo $Address;?></td>
          </tr>
          <tr>
            <td class="border-left-right-fntsize10">&nbsp;</td>
            <td>&nbsp;</td>
            <td class="border-right-fntsize10">&nbsp;</td>
            <td class="border-right-fntsize10"><?php echo $City;?></td>
          </tr>
          <tr>
            <td class="border-left-right-fntsize10">&nbsp;</td>
            <td>&nbsp;</td>
            <td class="border-right-fntsize10">&nbsp;</td>
            <td class="border-right-fntsize10">&nbsp;</td>
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
            <td class="border-left-right-fntsize10" style="text-align:center">&nbsp;</td>
            <td><?php echo $row_desc["strDescOfGoods"];?></td>
            <td class="border-right-fntsize10">&nbsp;</td>
            <td class="border-right-fntsize10">&nbsp;</td>
          </tr>
          <?php }?>
          <tr>
            <td class="border-left-right-fntsize10">&nbsp;</td>
            <td>&nbsp;</td>
            <td class="border-right-fntsize10">&nbsp;</td>
            <td class="border-right-fntsize10">&nbsp;</td>
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
            <td class="border-left-right-fntsize10" style="text-align:center">&nbsp;</td>
            <td><?php echo $row_desc["strStyleID"];?></td>
            <td class="border-right-fntsize10"><?php echo $row_desc["dblQuantity"];?></td>
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
            <td width="20%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
            <td width="40%">&nbsp;</td>
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
        <td height="">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="" colspan="5">(Note Address must be complete and contain street number.</td>
      </tr>
      <tr>
        <td height="" colspan="5"> Actual city names must be given, provinces are not accepted.)</td>
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
        <td height="">Print Name: </td>
        <td>UDAYA PERERA</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="">Title &amp; Date</td>
        <td>COMMERCIAL MANAGER</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="20%" height="">&nbsp;</td>
        <td width="25%">&nbsp;</td>
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