<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web|Export report </title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="cdn.js" type="text/javascript"></script>

</head>
<body>
<?php

include "../../Connector.php";

?>

<form id="cdnPopUp" name="cdnPopUp" >
  <table  border="0" cellspacing="0" width="750" >
    <tr>
      <td width="96%" height="26" bgcolor="#498CC2" class="TitleN2white">&nbsp;</td>
      <td width="4%" bgcolor="#498CC2" class="TitleN2white"><img src="../../images/cross.png" alt="1" width="17" height="17"  class="mouseover" onclick="closeWindow()"/></td>
    </tr>
    <tr bgcolor="#D8E3FA">
      <td height="96" colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0"  >
          <tr>
            <td colspan="2" class="normalfnt"><table width="100%" border="0" bgcolor="#FFFFFF" >
                <tr>
                  <td width="1%" class="normalfnt">&nbsp;</td>
                  <td width="11%">Invoice #</td>
                  <td><label>
                    <select name="popcboInvoiceNo"  tabindex="13" class="txtbox" id="popcboInvoiceNo" style="width:180px">
                      <option value=""></option>
                      <?php 
                   $sqlCity = "select distinct strInvoiceNo from invoicedetail order by strInvoiceNo;";
                   $resultCity = $db->RunQuery($sqlCity);
						 while($row=mysql_fetch_array( $resultCity)) 
						 echo "<option value=".$row['strInvoiceNo'].">".$row['strInvoiceNo']."</option>";                 
                   ?>
                      </select>
                  </label></td>
                  <td width="4%">&nbsp;</td>
                  <td width="18%">&nbsp;</td>
                  <td width="3%">&nbsp;</td>
                  <td width="21%">&nbsp;</td>
                  <td width="11%"><img src="../../images/search.png"  name="btnSearch"  id="btnSearch" class="mouseover" onclick="searchDetailData();"/></td>
                </tr>
                <tr bgcolor="#9BBFDD">
                  <td colspan="8" class="normalfnt">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="8" class="normalfnt"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td height="162" colspan="2" class="normalfnt">
                           
                              <div id="divcons" style="overflow:scroll; height:250px; width:750px;" class="bcgl1">
                                  <table width="850" cellpadding="0" cellspacing="1" id="tblInvoiceDetails" bgcolor="#D8E3FA">
                                    <tr>
                                      <td width="3%" height="25" bgcolor="#498CC2" class="normaltxtmidb2"><input type="checkbox" id="checkBoxAll" name="checkBoxAll" onclick="checkAll(this)" /></td>
                                      <td width="16%" bgcolor="#498CC2" class="normaltxtmidb2" >Pre-Invoice No</td>
                                      <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2" >PO</td>
                                      <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2" >Style#</td>
                                      <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2" >PL#</td>
                                      <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2" >CTNS </td>
                                      <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2" >QTY</td>
                                      <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2" >Price</td>
                                      <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2" >Net</td>
                                      <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2" >Gross</td>
                                      <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2" >CBM</td>
                                    </tr>
                                  </table>
                              </div>
                       </td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
            <td colspan="8" width="100%" bgcolor="#d6e7f5"><table width="100%" border="0">
                <tr>
                  <td align="center"><img src="../../images/ok.png" alt="Ok" name="Ok" class="mouseover" id="Ok" onclick="sendData();" /><img src="../../images/close.png" alt="Close" name="Close" class="mouseover" id="Close"lass="mouseover" onclick="closeWindow()"/></td>
                </tr>
            </table></td>
          </tr>
      </table></td>
    </tr>
      </table></td>
    </tr>
  </table>
</form>

<script src="../../freeze/jquery.fixedheader.js" type="text/javascript"></script>

</body>
</html>
