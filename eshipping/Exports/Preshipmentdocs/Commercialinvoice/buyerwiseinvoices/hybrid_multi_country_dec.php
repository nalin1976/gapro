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
<title>MULTIPLE COUNTRY DECLARATION</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<?php 
$orientation="jsPrintSetup.kLandscapeOrientation";
//$orientation="jsPrintSetup.kPortraitOrientation";
include("printer.php");?>
</head>

<body class="body_bound">
<table width="100%" border="0" cellspacing="0" cellpadding="2" style="font-family:Book Antiqua;font-size:14px;">
  <tr>
    <td  colspan="5" style="font-family:Book Antiqua;font-size:16px;text-align:center"><strong>MULTIPLE COUNTRY DECLARATION</strong></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" style="text-align:justify">I      Udaya Perera (name)      declare that the articles described and covered by the invoice or entry to which declaration related were exported from the identified below on the dates listed  and were subjected to assemblies, Manufacturing or processing operation in and/or incorporate materials originating  in identified below on the dates listed  and were subjected to assemblies, Manufacturing or processing operation in and/or incorporate materials originating  in is correct and true to the best of my information knowledge and belief.</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="28%"><dd><strong>A&nbsp;&nbsp;&nbsp;&nbsp;HONG KONG</strong></td>
        <td width="24%"><strong>B&nbsp;&nbsp;&nbsp;&nbsp;SRI LANKA</strong></td>
        <td width="23%"><strong>C&nbsp;&nbsp;&nbsp;&nbsp;PAKISTAN</strong></td>
        <td width="25%"> <strong>D&nbsp;&nbsp;&nbsp;&nbsp;INDIA</strong></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td width="15%" rowspan="3" class="border-Left-Top-right-fntsize10" style="text-align:center"><strong>Marks of Identification  Number</strong></td>
        <td width="25%" rowspan="3" class="border-top-right-fntsize10" style="text-align:center"><strong>Description of Articles and Quantity</strong></td>
        <td width="20%" rowspan="3" class="border-top-right-fntsize10" style="text-align:center"><strong>Description of Manufacturing and or processing operation</strong></td>
        <td colspan="5" class="border-top-right-fntsize10" style="text-align:center"><strong>M  A T E R I A L S</strong></td>
      </tr>
      <tr>
        <td colspan="5" class="border-right-fntsize10" style="text-align:center"> <strong>Date &amp; Country Manufacturing and Processing</strong></td>
      </tr>
      <tr>
        <td width="5%" class="border-top-right-fntsize10" style="text-align:center"><strong>Country</strong></td>
        <td width="5%" class="border-top-right-fntsize10" style="text-align:center"><strong>Date of </strong><strong>Export</strong></td>
        <td width="15%" class="border-top-right-fntsize10" style="text-align:center"><strong>Description </strong><strong>of Materials</strong></td>
        <td width="5%" class="border-top-right-fntsize10" style="text-align:center"><strong>Country</strong><strong> on Export</strong></td>
        <td width="5%" class="border-top-right-fntsize10" style="text-align:center"><strong>Date of </strong><strong>Export</strong></td>
      </tr>
      <tr>
        <td class="border-Left-Top-right-fntsize10">&nbsp;</td>
        <td rowspan="17" class="border-top-right-fntsize10" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt" style="font-size:10px;">
          <tr>
            <td colspan="2" style="text-align:center">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" style="text-align:center"><?php echo $r_summary->summary_sum($invoiceNo,'intNoOfCTns');?> CTNS</td>
          </tr>
          <tr>
            <td colspan="2" style="text-align:center"><?php echo $r_summary->summary_sum($invoiceNo,'dblQuantity')." ".$r_summary->summary_string($invoiceNo,'strUnitID');?></td>
          </tr>
          <tr>
            <td colspan="2" style="text-align:center">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">HTS #:<?php echo $r_summary->summary_string($invoiceNo,'strHSCode');?></td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"><strong>FABRIC</strong></td>
          </tr>
          <tr>
            <td colspan="2"><?php  echo $r_summary->summary_string($invoiceNo,'strFabric');?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><strong>PO #:</strong></td>
            <td><strong>STYLE#:</strong></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
		while($row_desc=mysql_fetch_array($result_desc)){?>
          <tr>
            <td><?php echo $row_desc["strBuyerPONo"];?></td>
            <td><?php echo $row_desc["strStyleID"];?></td>
          </tr><?php }?>
          <tr>
            <td width="50%">&nbsp;</td>
            <td  width="50%">&nbsp;</td>
          </tr>
        </table></td>
        <td class="border-top-right-fntsize10">&nbsp;</td>
        <td class="border-top-right-fntsize10">&nbsp;</td>
        <td rowspan="17" class="border-top-right-fntsize10"><?php echo $dateInvoice;?></td>
        <td class="border-top-right-fntsize10">&nbsp;</td>
        <td class="border-top-right-fntsize10">&nbsp;</td>
        <td class="border-top-right-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize10">AS PER INVOICE</td>
        <td class="border-right-fntsize10"> MARK FABRIC FOR CUTTING</td>
        <td class="border-right-fntsize10" style="text-align:center">B</td>
        <td class="border-right-fntsize10">FABRIC</td>
        <td class="border-right-fntsize10" style="text-align:center">D</td>
        <td class="border-right-fntsize10">18.12.10</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">FABRIC</td>
        <td class="border-right-fntsize10" style="text-align:center">C</td>
        <td class="border-right-fntsize10">18.12.10</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">CUTTING</td>
        <td class="border-right-fntsize10" style="text-align:center">B</td>
        <td class="border-right-fntsize10">ADHESIVE TAPE</td>
        <td class="border-right-fntsize10" style="text-align:center">B</td>
        <td class="border-right-fntsize10">18.12.10</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">CARTON</td>
        <td class="border-right-fntsize10" style="text-align:center">B</td>
        <td class="border-right-fntsize10">18.12.10</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">SEWING</td>
        <td class="border-right-fntsize10" style="text-align:center">B</td>
        <td class="border-right-fntsize10">HANG TAG</td>
        <td class="border-right-fntsize10" style="text-align:center">A</td>
        <td class="border-right-fntsize10">18.12.10</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">MAIN LABEL</td>
        <td class="border-right-fntsize10" style="text-align:center">A </td>
        <td class="border-right-fntsize10">18.12.10</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">PACKING</td>
        <td class="border-right-fntsize10" style="text-align:center">B</td>
        <td class="border-right-fntsize10">CARE LABEL</td>
        <td class="border-right-fntsize10" style="text-align:center">A</td>
        <td class="border-right-fntsize10">18.12.10</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">POLY LINER</td>
        <td class="border-right-fntsize10" style="text-align:center">B</td>
        <td class="border-right-fntsize10">18.12.10</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">FINISHING</td>
        <td class="border-right-fntsize10" style="text-align:center">B</td>
        <td class="border-right-fntsize10">ZIPPER</td>
        <td class="border-right-fntsize10" style="text-align:center">B</td>
        <td class="border-right-fntsize10">18.12.10</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">THREAD</td>
        <td class="border-right-fntsize10" style="text-align:center">B</td>
        <td class="border-right-fntsize10">18.12.10</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">QUALITY CONTROL </td>
        <td class="border-right-fntsize10" style="text-align:center">B</td>
        <td class="border-right-fntsize10">STICKER</td>
        <td class="border-right-fntsize10" style="text-align:center">A</td>
        <td class="border-right-fntsize10">18.12.10</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">INSPECTION</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="8" class="border-top-fntsize10">&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name</td>
        <td>Udaya Perera&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Title : </td>
        <td>Commercial Manager</td>
        <td colspan="2">Name of Firm :</td>
        <td colspan="3" style="font-size:12px;"><strong><?php echo $Company;?></strong></td>
        </tr>
      <tr>
        <td style="text-align:right">.................. </td>
        <td>.......................... </td>
        <td>.......................... </td>
        <td colspan="2">Address:</td>
        <td colspan="3" style="font-size:10px;"><?php echo $Address;?></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3" style="font-size:10px;"><?php echo $City;?></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        </tr>
      <tr>
        <td style="text-align:center">&nbsp;</td>
        <td ><?php echo $dateInvoice;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature :</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td style="text-align:right">.................. </td>
        <td>..........................&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;</td>
        <td>.......................... </td>
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
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="8">Country or countries when used in this declaration includes territories and U.S. insular possessions.</td>
      </tr>
      <tr>
        <td colspan="8">The country will be indentified in the above declaration by the alphabetical designation appearing next to the named country.</td>
      </tr>
    </table></td>
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
		  <?php
		  	}
			else
			{
			?>
		    <?php
			}
			$count++;
			$id++;
	}
	$dzs=$totQuentity/12;
	?>	  
</table>
</body>
</html>