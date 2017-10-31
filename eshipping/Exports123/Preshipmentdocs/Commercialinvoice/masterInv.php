<?php
$backwardseperator = "../../../";
session_start();
include("../../../Connector.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="360" height="125" border="0" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE">
  <tr class="bcgcolor-highlighted">
    <td height="25" colspan="3"  class="normaltxtmidb2L">&nbsp; Commercial Invoice Printer</td>
    <td width="20" align="left" class="bcgcolor-highlighted"><div align="right"><img src="../../../images/cross.png" alt="1" width="17" height="17"  class="mouseover" onclick="closeWindow()"/></div></td>
  </tr>
  <tr>
    <td height="5" colspan="4"></td>
  </tr>
  <tr>
    <td width="5%" height="25">&nbsp;</td>
    <td  width="27%" class="normalfnth2Bm" style="text-align:left">Invoice </td>
    <td colspan="2" nowrap="nowrap"><select name="cboMasterInv"  class="txtbox" id="cboMasterInv" style="width:220px" >
      <option value=''></option>
      <option value=""></option>
      <?php 
                   $sqlInvoice="SELECT strInvoiceNo FROM commercial_invoice_header order by strInvoiceNo";
                   $resultInvoice=$db->RunQuery($sqlInvoice);
						 while($row=mysql_fetch_array( $resultInvoice)) { ?>
      <option value="<?php echo $row['strInvoiceNo'];?>"><?php echo $row['strInvoiceNo'];?></option>
      <?php }?>
    </select></td>
  </tr>
  
  <tr>
    <td width="5%" height="30">&nbsp;</td>
    <td class="normalfnth2Bm" style="text-align:left" nowrap="nowrap">Buyer</td>
    <td colspan="2"><select name="cdoMasterInvBuyer"  class="txtbox" id="cdoMasterInvBuyer" style="width:220px" >
      <option value=''></option>
      <option value="LN">Lands End</option>
    </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="normalfnth2Bm" style="text-align:left" nowrap="nowrap" height="25">&nbsp;</td>
    <td width="63%">&nbsp;</td>
    <td><img src="../../../images/go.png" width="30" height="22" alt="go" onclick="print_MasterInv()" class="mouseover" title="Print"/></td>
  </tr>
</table>
</body>
</html>
