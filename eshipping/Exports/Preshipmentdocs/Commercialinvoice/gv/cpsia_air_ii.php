<?php 
session_start();
include "../../../../Connector.php";
$invoiceNo=$_GET['InvoiceNo'];	
$HAWB=$_GET['HAWB'];	
$style=$_GET['style'];	
$po=$_GET['po'];	


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CPSIA</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="850" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5%">&nbsp;</td>
    <td width="95%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="6" style="font-size:14px;text-align:center;font-weight:bold">CPSIA Conformity Certificate for Imported Product  MBL/HBL/HAWB#: </td>
    <td><?php echo $HAWB;?></td>
  </tr>
  <tr>
    <td colspan="7" class="border-Left-Top-right-fntsize10" style="font-size:12px;text-align:center"><strong>Identification of Product</strong></td>
  </tr>
  <tr>
    <td class="border-top-bottom-left-fntsize10" height="25">&nbsp;</td>
    <td class="border-top-bottom-fntsize10">1) P.O. or Contract # </td>
    <td class="border-top-bottom-fntsize10">Material-Style# or Style Name </td>
    <td class="border-top-bottom-fntsize10">&nbsp;</td>
    <td class="border-top-bottom-fntsize10">&nbsp;</td>
    <td class="border-top-bottom-fntsize10">P.O. or Contract # </td>
    <td class="border-top-bottom-right-fntsize10">Material-Style# or Style Name</td>
  </tr>
  <tr>
    <td class="border-bottom-left-fntsize10"><?php echo "(1)";?></td>
    <td class="border-bottom-fntsize10"><?php echo $po;?></td>
    <td class="border-bottom-fntsize10"><?php echo $style;?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-bottom-fntsize10">&nbsp;</td>
    <td class="border-bottom-right-fntsize10">&nbsp;</td>
  </tr>
  <?php 
  
		$no=1;
		while($no<=13)		
		{$no++;?>
  <tr>
    <td class="border-bottom-left-fntsize10"><?php echo "(".($no-1).")";?></td>
    <td class="border-bottom-fntsize10">&nbsp;</td>
    <td class="border-bottom-fntsize10">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-bottom-fntsize10">&nbsp;</td>
    <td class="border-bottom-right-fntsize10">&nbsp;</td>
  </tr>
  <?php }?>
  <tr>
    <td class="border-left-fntsize10">(13)</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="border-All-fntsize10">2) The products were tested for and are compliant with the following rules, bans, standards and regulations. (Check ONLY applicable tests performed.) </td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10" height="20">&nbsp;____ Standard for Flammability of Clothing Textiles (15USC 1191-1204; 16 CFR 1610) </td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10">&nbsp;__X___ Exempt from Testing under the Standard for Flammability of Clothing Textiles (15USC  1191-1204: 16 CFR 1610)</td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10"  height="20">&nbsp;_____ ASTM Standard for Drawstrings in Children's Garments (ASTM F1816) </td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10"  height="20">&nbsp;_____ Small Parts Standard (16 CFR 1501 &amp; 1500.50-53) </td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10"  height="20">&nbsp;___ Lead in Surface Coating Standard (16 CFR 1303)</td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10"  height="20">&nbsp;___  Total Lead Content Standard (CPSIA Sec. 101) </td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10"  height="20">&nbsp;_____ Federal Hazardous Substances Act (15 USC 1261-1278; 16CFR 1500-1512) </td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10"  height="20">&nbsp;_____Other (please specify):</td>
  </tr>
   <tr>
    <td colspan="7" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"  class="border-All-fntsize10">3) Name, Address, Telephone Number of  Importer </td>
    <td colspan="4" class="border-top-bottom-right-fntsize10">4) Contact Information of U.S. Record Holder </td>
  </tr>
  <tr>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;</td>
    <td colspan="4" class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;</td>
    <td colspan="4" class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;</td>
    <td colspan="4" class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;</td>
    <td colspan="4" class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;</td>
    <td colspan="4" class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;</td>
    <td colspan="4" class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;</td>
    <td colspan="4" class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="border-All-fntsize10">5) Date (month &amp; year) and Place (city &amp; state, country or administrative region)  of Manufacture and Vendor Identification #: </td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="border-All-fntsize10">6) Date(s) and Place (city &amp; state, country or administrative region) of Testing:</td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>  
  <tr>
    <td colspan="7" class="border-All-fntsize10">7) Name, Address and Telephone Number of Testing Facility:</td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="border-top-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td width="5%">&nbsp;</td>
    <td width="17%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
    <td width="5%">&nbsp;</td>
    <td width="5%">&nbsp;</td>
    <td width="18%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>