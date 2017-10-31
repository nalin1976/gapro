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
$proforma=$_GET['proforma'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<title>COMMERCIAL INVOICE</title>
</head>

<body>
<table width="850" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="25" class="border-All-fntsize12"><strong>Invoice</strong></td>
        <td>&nbsp;</td>
        <td class="border-All"><?php echo $dataholder['strInvoiceNo'];?></td>
        <td>&nbsp;</td>
        <td colspan="2" class="border-All"><?php echo $dateInvoice ;?></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="border-Left-Top-right-fntsize12"><strong>To:</strong></td>
        <td colspan="2" class="border-top-right-fntsize12"><strong>Sender:</strong></td>
        <td colspan="2" class="border-top-right-fntsize12"><strong>Bank name and address:</strong></td>
      </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12"><?php echo $dataholder['BuyerAName'];?></td>
        <td colspan="2" class="border-right-fntsize12"><?php echo $Company;?></td>
        <td colspan="2" class="border-right-fntsize12"><?php echo $dataholder['bankname'];?></td>
      </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12"><?php echo $dataholder['buyerAddress1'];?></td>
        <td colspan="2" class="border-right-fntsize12"><?php echo $Address;?></td>
        <td colspan="2" class="border-right-fntsize12"><?php echo $dataholder['bankaddress1'];?></td>
      </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12"><?php echo $dataholder['buyerAddress2'];?></td>
        <td colspan="2" class="border-right-fntsize12"><?php echo $City;?></td>
        <td colspan="2" class="border-right-fntsize12"><?php echo $dataholder['bankaddress2'];?></td>
      </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12"><?php echo $dataholder['BuyerCountry'];?></td>
        <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12"><?php echo ($dataholder['buyerphone']!=""?"Tel : ".$dataholder['buyerphone']:"");?> <?php echo ($dataholder['BuyerFax']!=""?"Fax : ".$dataholder['BuyerFax']:"");?></td>
        <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12">Tel # <?php echo $phone;?> </td>
        <td colspan="2" rowspan="2" class="border-right-fntsize12" valign="top"><?php echo $dataholder['bankref'];?></td>
      </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12">Fax # <?php echo $Fax;?></td>
        </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="6" class="border-top">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" height="25" class="border-Left-Top-right-fntsize12">Country of origin: SRI LANKA</td>
        <td colspan="3" class="border-top-right-fntsize12">Country of shipment: </td>
      </tr>
      <tr>
        <td height="25" colspan="3" class="border-left-right-fntsize12">SALES OF MERCHANDISE </td>
        <td colspan="3" class="border-right-fntsize12">SRI LANKA</td>
      </tr>
      <tr>
        <td colspan="3"  class="border-Left-Top-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-top-right-fntsize12">&nbsp;</td>
        <td class="border-top-right-fntsize12">L/ C No.:<?php echo $dataholder['LCNO']; ?></td>
        </tr>
      <tr>
        <td colspan="3" class="border-left-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" class="border-left-right-fntsize12"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="10%" height="25">&nbsp;</td>
            <td width="9%"><table width="25" border="0" cellspacing="0" cellpadding="0">
              <tr>
                 <td width="25" height="25" class="border-All">&nbsp;</td>
              </tr>
            </table></td>
            <td width="76%"> &nbsp;&nbsp;Telegraphic Transfer (T/T)</td>
            <td width="5%" >&nbsp;</td>
          </tr>
        </table></td>
        <td colspan="2" class="border-right-fntsize12"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="10%" height="25">&nbsp;</td>
            <td width="9%"><table width="25" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="25" height="25" class="border-All"><?php echo ($dataholder['LCNO']==""?'&nbsp;':"X"); ?></td>
              </tr>
            </table></td>
            <td width="76%">&nbsp;&nbsp;Letter of Credit (L/C)</td>
            <td width="5%" >&nbsp;</td>
          </tr>
        </table></td>
        <td class="border-top-right-fntsize12">Date: <?php echo $dataholder['dtmLCDate']; ?></td>
      </tr>
      <tr>
        <td colspan="3" class="border-left-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="6" class="border-top">&nbsp;</td>
        </tr>
       <tr>
         <td height="36" colspan="6"  class="border-Left-Top-right-fntsize12"><strong>C&amp;A Purchase Order No. </strong>(16digits including 3 digits shipment ID): <?php echo $r_summary->summary_string($invoiceNo,'strBuyerPONo')?></td>
       </tr>
      <tr>
        <td colspan="3"  class="border-Left-Top-right-fntsize12">Merchandise description: </td>
        <td colspan="3" class="border-top-right-fntsize12">Composition of goods:</td>
      </tr>
      <tr>
        <td colspan="3" class="border-left-right-fntsize12">&nbsp;</td>
        <td colspan="3" class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td height="60" colspan="3" class="border-left-right-fntsize12" valign="top"><?php  echo $r_summary->summary_string($invoiceNo,'strFabric');?></td>
        <td colspan="3" class="border-right-fntsize12" valign="top"><?php  echo $r_summary->summary_string($invoiceNo,'strDescOfGoods');?></td>
      </tr>
      <tr>
        <td height="25" colspan="6"  class="border-Left-Top-right-fntsize12">Clothing structure</td>
      </tr>
      <tr>
         <td colspan="6"  class="border-left-right-fntsize12" height="40"><table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td width="11%">&nbsp;</td>
             <td width="5%"><table width="25" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td width="25" height="25" class="border-All">X</td>
               </tr>
             </table></td>
             <td width="17%"> woven </td>
             <td width="5%"><table width="25" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td width="25" height="25" class="border-All">&nbsp;</td>
               </tr>
             </table></td>
             <td width="19%">knitted</td>
             <td width="4%"><table width="25" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td width="25" height="25" class="border-All">&nbsp;</td>
               </tr>
             </table></td>
             <td width="14%">leather</td>
             <td width="4%"><table width="25" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td width="25" height="25" class="border-All">&nbsp;</td>
               </tr>
             </table></td>
             <td width="10%">other</td>
             <td width="11%">&nbsp;</td>
           </tr>
         </table></td>
       </tr>
      <tr>
        <td height="25" colspan="3"  class="border-Left-Top-right-fntsize12">Transport method:</td>
        <td colspan="3" class="border-top-right-fntsize12">Delivery condition: </td>
      </tr>
      <tr>
        <td colspan="3" class="border-left-right-fntsize12" height="35"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="11%">&nbsp;</td>
            <td width="5%"><table width="25" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="25" height="25" class="border-All"><?php echo ($dataholder['strTransportMode']=="Sea"?'X':"&nbsp;"); ?></td>
              </tr>
            </table></td>
            <td width="17%"> sea </td>
            <td width="5%"><table width="25" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="25" height="25" class="border-All"><?php echo ($dataholder['strTransportMode']=="Air"?'X':"&nbsp;"); ?></td>
              </tr>
            </table></td>
            <td width="19%">air</td>
            <td width="4%"><table width="25" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="25" height="25" class="border-All">&nbsp;</td>
              </tr>
            </table></td>
            <td width="14%">air/sea</td>
            </tr>
        </table></td>
        <td colspan="3" class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" colspan="6"  class="border-Left-Top-right-fntsize12">Packing method:</td>
      </tr>
      <tr>
         <td colspan="6"  class="border-left-right-fntsize12" height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td width="11%">&nbsp;</td>
             <td width="5%"><table width="25" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td width="25" height="25" class="border-All">&nbsp;</td>
               </tr>
             </table></td>
             <td width="17%"> sea </td>
             <td width="5%"><table width="25" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td width="25" height="25" class="border-All">X</td>
               </tr>
             </table></td>
             <td>packed: if packed, total number of cartons is:<?php echo number_format($r_summary->summary_sum($invoiceNo,'intNoOfCTns'),2);?> CTNS</td>
             </tr>
         </table></td>
       </tr>
      <tr>
        <td colspan="3"  class="border-Left-Top-right-fntsize12" height="30">Packing list (delivery note) number: <?php echo $r_summary->summary_string($invoiceNo,'strBuyerPONo')?></td>
        <td colspan="2" class="border-top-right-fntsize12">Gross weight:</td>
        <td class="border-top-right-fntsize12">Net weight:</td>
      </tr>
      <tr>
        <td colspan="3" class="border-left-right-fntsize12" height="30">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12" style="text-align:center"><?php echo $r_summary->summary_sum($invoiceNo,'dblGrossMass')?> KGS</td>
        <td class="border-right-fntsize12" style="text-align:center"><?php echo $r_summary->summary_sum($invoiceNo,'dblNetMass')?> KGS</td>
      </tr>
      <tr>
        <td colspan="6" class="border-top">&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">Supplier's stamp and original signature (plus remarks):</td>
        <td>&nbsp;</td>
        <td colspan="2" class="border-Left-Top-right-fntsize12" height="30"><strong>Total quantity </strong></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" class="border-All-fntsize12" height="30" style="text-align:center"><?php echo $r_summary->summary_sum($invoiceNo,'dblQuantity')?> PCS</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-Left-Top-right-fntsize12" height="30"><strong>Amount</strong></td>
        <td class="border-top-right-fntsize12"><strong>Currency</strong></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right">Unit Price &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td class="border-Left-Top-right-fntsize12" height="30" style="text-align:center"><?php echo $r_summary->summary_string($invoiceNo,'dblUnitPrice')?></td>
        <td class="border-top-right-fntsize12" style="text-align:center">US$</td>
      </tr>
      <tr>
        <td height="30">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" align="right">Total amount invoiced &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td class="border-Left-Top-right-fntsize12" style="text-align:center"><?php echo number_format($r_summary->summary_sum($invoiceNo,'dblAmount'),2);?></td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" class="border-top">&nbsp;</td>
        </tr>
      <tr>
        <td width="10%">&nbsp;</td>
        <td width="15%">&nbsp;</td>
        <td width="30%">&nbsp;</td>
        <td width="15%">&nbsp;</td>
        <td width="10%">&nbsp;</td>
        <td width="20%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>