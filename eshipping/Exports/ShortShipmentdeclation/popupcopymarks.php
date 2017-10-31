<?php
$backwardseperator = "../../";
session_start();
include("../../Connector.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../..//javascript/calendar/theme.css" />
</head>

<body>
<table width="320" height="150" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr class="bcgcolor-highlighted">
    <td height="24" colspan="4"  class="normaltxtmidb2L">&nbsp; MARKS &amp; Nos of PKGS </td>
    <td class="bcgcolor-highlighted" align="left"><img src="../../images/cross.png" alt="1" width="17" height="17"  class="mouseover" onclick="closeWindow()"/></td>
  </tr>
  <tr>
    <td height="35" colspan="2"><div align="center" class="normalfnth2Bm">Invoice Number </div></td>
    <td colspan="2"><div align="right">
      <select name="cboinvoicecopy"  class="txtbox" id="cboinvoicecopy" style="width:150px" onchange="getMarksAndNos();">
        <option value=''></option>                          
                      <?php
                   			$str="SELECT strInvoiceNo FROM invoiceheader";
                  			$exec=$db->RunQuery( $str);
									while($row=mysql_fetch_array( $exec)) 
						 			echo "<option value=".$row['strInvoiceNo'].">".$row['strInvoiceNo']."</option>";                 
                  			 ?>					
      </select>
    </div></td>
    <td width="20">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><textarea name="txtMarkCopy" style=" height:100px; width:150; heigh:100px;"id="txtMarkCopy"></textarea></td>
    <td ><div align="center"><img src="../../images/do_copy.png" alt="1" class="mouseover" width="32" height="31" onclick="setMarksAndNos()" /></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="38">
    <div align="right"></div></td>
    <td width="110">&nbsp;</td>
    <td width="76">&nbsp;</td>
    <td width="76">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
