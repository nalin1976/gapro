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
<title>Guidance for Packing Declarations</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />

</head>

<body>
<table width="850" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td   style="text-align:center;font-size:25px;">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td   style="text-align:center;font-size:25px;">As Required by AUSTRALIAN QUARANTINE INSPECTION SERVICE<br /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="text-align:center;font-size:25px;">(AQIS) for Oceanfreight Imports to Australia</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="text-align:center;font-size:20px;">Guidance for Packing Declarations</td>
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
    <td>&nbsp;</td>
    <td><table width="850" border="0" cellspacing="0" cellpadding="4">
      <tr>
  
    <td style="text-align:center;font-family:'Times New Roman';font-weight:bold;font-size:24px" height="35" bgcolor="#CCCCCC" class="border-Left-Top-right-fntsize12">ORIT TRADING LANKA (PVT) LTD</td>
  </tr>
  <tr>
    <td style="text-align:center;font-family:'Times New Roman';font-weight:bold;font-size:12px" height="20" bgcolor="#999999" class="border-left-right-fntsize12"><?php echo $Address;?></span>,<?php echo $City;?>. Tel: <?php echo $phone;?> Fax: <?php echo $Fax;?></td>
  </tr>
      <tr>
        <td height="32" class="border-Left-Top-right-fntsize12" style="text-align:center;font-size:14px;"><table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td width="28%">&nbsp;</td>
            <td width="8%">FCL</td>
            <td width="10%"><table width="25" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="25" height="25" class="border-All">&nbsp;<?php echo ($com_inv_dataholder['dblConTypeId']=="FCL"?'X':'');?> </td>
                </tr>
              </table></td>
            <td width="9%">or LCL</td>
            <td width="6%"><table width="25" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="25" height="25" class="border-All">&nbsp;<?php echo ($com_inv_dataholder['dblConTypeId']!="FCL"?'X':'');?></td>
                </tr>
              </table></td>
            <td width="39%">Packing declaration</td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12"><table width="100%" border="0" cellspacing="0" cellpadding="3">
               <tr>
            <td width="26%" >&nbsp;</td>
            <td width="7%" class="border-bottom-fntsize12">(Boxes</td>
            <td width="7%" class="border-bottom-fntsize12"><table width="25" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="25" height="25" class="border-All">&nbsp;</td>
                </tr>
              </table></td>
            <td width="38%" class="border-bottom-fntsize12">to be marked with an X in the appropriate place)</td>
            <td width="22%">&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12" style="font-size:14px;">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12" style="font-size:14px;">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          
          <tr>
            <td width="16%" height="25"><span style="font-size:14px;" >Vessel Name:</span></td>
            <td width="30%" class="border-bottom"><?php echo $dataholder['strCarrier'];?></td>
            <td width="16%"><span style="font-size:14px;">Voyage Number:</span></td>
            <td colspan="2" class="border-bottom"><?php echo $dataholder['strVoyegeNo'];?></td>
            </tr>
          <tr>
            <td height="25" colspan="2"><span  style="font-size:14px;">Consignment identifier(s) or numerical link(s):</span></td>
            <td colspan="3" class="border-bottom"><?php echo $r_summary->summary_string($invoiceNo,'strBuyerPONo');?></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12" height="30" style="font-size:16px;"><strong>PROHIBITED PACKAGING MATERIAL STATEMENT</strong></td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12">(Prohibited packaging materials include straw, bamboo, peat, hay, chaff, etc.)</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12" height="25">Q1 Have prohibited packaging materials or bamboo products been used as packaging or dunnage in the</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12">consignment covered by this document?</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="28%">A1</td>
            <td width="8%">YES</td>
            <td width="10%"><table width="25" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="25" height="25" class="border-All">&nbsp;</td>
              </tr>
            </table></td>
            <td width="9%">NO</td>
            <td width="6%"><table width="25" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="25" height="25" class="border-All">X</td>
              </tr>
            </table></td>
            <td width="39%">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12" height="30" style="font-size:16px;"><strong>TIMBER PACKAGING/DUNNAGE STATEMENT</strong></td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12">(Timber packaging/dunnage includes: crates, cases, pallets, skids, and any other timber used as a shipping
          aid.)</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12">Q2a Has Timber packaging/dunnage been used in consignments covered by this document?</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="28%">A2a</td>
            <td width="8%">YES</td>
            <td width="10%"><table width="25" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="25" height="25" class="border-All">&nbsp;</td>
              </tr>
            </table></td>
            <td width="9%">NO</td>
            <td width="6%"><table width="25" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="25" height="25" class="border-All">X</td>
              </tr>
            </table></td>
            <td width="39%">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12" height="30" style="font-size:16px;"><strong>ISPM 15 STATEMENT</strong></td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12">Q2b All timber packaging/dunnage used in the consignment has been treated and marked in compliance
          with ISPM 15?</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="28%">A2b</td>
            <td width="8%">YES</td>
            <td width="10%"><table width="25" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="25" height="25" class="border-All">&nbsp;</td>
              </tr>
            </table></td>
            <td width="9%">NO</td>
            <td width="6%"><table width="25" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="25" height="25" class="border-All">X</td>
              </tr>
            </table></td>
            <td width="39%">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12" height="30" style="font-size:16px;"><strong>BARK STATEMENT</strong></td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12">(This is also applicable to ISPM 15 compliant packaging/dunnage. Bark is the external natural layer covering
          trees and branches.)</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12">Q3 Is all timber packaging/dunnage used in this consignment free from bark?</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="28%">A3</td>
            <td width="8%">YES</td>
            <td width="10%"><table width="25" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="25" height="25" class="border-All">X</td>
                </tr>
              </table></td>
            <td width="9%">NO</td>
            <td width="6%"><table width="25" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="25" height="25" class="border-All">&nbsp;</td>
                </tr>
              </table></td>
            <td width="39%">&nbsp;</td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12" height="20" style="font-size:14px;">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12" height="40" style="font-size:16px;"><strong>CLEANLINESS DECLARATION (for FCL consignments only)</strong></td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12">The container(s) covered by this document has/have been cleaned and is/are free from material of animal
          and/or plant origin and soil.</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12"><table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td><strong>Signature:</strong></td>
            <td class="border-bottom-fntsize10">&nbsp;</td>
            <td>&nbsp;</td>
            <td><strong>Date of Issue:</strong></td>
            <td class="border-bottom-fntsize10" align="center" style="text-align:center"><?php echo $dateInvoice ;?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="14%">&nbsp;</td>
            <td width="22%">(Company Representative)</td>
            <td width="8%">&nbsp;</td>
            <td width="18%">&nbsp;</td>
            <td width="26%">&nbsp;</td>
            <td width="12%">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-top">&nbsp;</td>
      </tr>
  </table></td>
  </tr>
  <tr>
    <td width="5%">&nbsp;</td>
    <td width="95%"><br /></td>
  </tr>
</table>
</body>
</html>