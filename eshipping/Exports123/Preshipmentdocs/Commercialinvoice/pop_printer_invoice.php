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
<table width="400" height="125" border="0" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE">
  <tr class="bcgcolor-highlighted">
    <td height="25" colspan="3"  class="normaltxtmidb2L">&nbsp; Commercial Invoice Printer</td>
    <td width="20" align="left" class="bcgcolor-highlighted"><div align="right"><img src="../../../images/cross.png" alt="1" width="17" height="17"  class="mouseover" onclick="closeWindow()"/></div></td>
  </tr>
  <tr>
    <td height="5" colspan="4"></td>
  </tr>
  <tr>
    <td width="5%" height="25">&nbsp;</td>
    <td  width="27%" class="normalfnth2Bm" style="text-align:left">Document Type </td>
    <td colspan="2" nowrap="nowrap">
	<select name="cboDocType"  class="txtbox" id="cboDocType" style="width:220px" onchange="feildHide()">
      <option value=""></option>
	  <option value="optco">CO</option>
      <option value="optgspco">gspCO</option>
      <option value="optaptaco">aptaCO</option>
	  <option value="optisftaco">isftaCO</option>
    </select></td>
  </tr>
  
   <tr>
    <td width="5%" height="30">&nbsp;</td>
    <td class="normalfnth2Bm" style="text-align:left" nowrap="nowrap">GSP Date</td>
    <td colspan="2" nowrap="nowrap"><input name="txtGSPDate" tabindex="2" type="text" class="txtbox" id="txtGSPDate" style="width:140px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('Y-m-d');?>" onclick="return showCalendar(this.id, '%Y-%m-%d');" disabled="disabled"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
  </tr>
  <tr>
    <td width="5%" height="30">&nbsp;</td>
    <td class="normalfnth2Bm" style="text-align:left" nowrap="nowrap">Reference No</td>
    <td colspan="2"><input type="text" name="txtRefeNo" id="txtRefeNo" style="width:158px" tabindex="18" class="txtbox" /></td>
  </tr>
  <tr>
    <td width="5%" height="30">&nbsp;</td>
    <td class="normalfnth2Bm" style="text-align:left" nowrap="nowrap">Exchange Rate</td>
    <td colspan="2"><input type="text" name="txtExchangeRateForCo" id="txtExchangeRateForCo" style="width:158px" tabindex="18" class="txtbox" disabled="disabled"/></td>
  </tr>
  <tr>
    <td width="5%" height="30">&nbsp;</td>
    <td class="normalfnth2Bm" style="text-align:left" nowrap="nowrap">Unit Price</td>
    <td colspan="2"><input type="text" name="txtUnitPriceForCo" id="txtUnitPriceForCo" style="width:158px" tabindex="18" class="txtbox" disabled="disabled"/></td>
  </tr>
  <tr>
    <td width="5%" height="30">&nbsp;</td>
    <td class="normalfnth2Bm" style="text-align:left" nowrap="nowrap">Net Wt</td>
    <td colspan="2"><input type="text" name="txtNetWtCo" id="txtNetWtCo" style="width:158px" tabindex="18" class="txtbox" disabled="disabled"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="normalfnth2Bm" style="text-align:left" nowrap="nowrap" height="25">&nbsp;</td>
    <td width="63%">&nbsp;</td>
    <td><img src="../../../images/go.png" width="30" height="22" alt="go" onclick="print_co()" class="mouseover" title="Print"/></td>
  </tr>
</table>
</body>
</html>
