<?php
$backwardseperator = "../../";
session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Transport Charges</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>

<script src="button.js"></script>
<script src="charges.js"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

</head>

<body>

<?php

include "../../Connector.php";

?>

<form id="frmBanks" name="form1" method="POST" action="">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="25%">&nbsp;</td>
        <td width="54%"><table width="100%" border="0">
          
          <tr bgcolor="#D8E3FA">
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td colspan="2" class="normalfnt">&nbsp;</td>
                  <td width="72%">&nbsp;</td>
                </tr>
                <!--<tr>
                  <td width="5%" class="normalfnt">&nbsp;</td>
                  <td width="23%" class="normalfnt">Country</td>
                  <td><select name="cboCountry"  onchange="getBankDetails();" class="txtbox" id="cboCountry"style="width:180px">
				  
	
	
                  </select></td>
                </tr>
                
                --><tr>
                  <td colspan="2" class="normalfnt">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="3" class="normalfnt"><table width="102%" border="0" class="bcgl1">
                    <tr>
                      <td width="5%" class="normalfnt">&nbsp;</td>
                      <td width="23%" class="normalfnt">Serial No </td>
                      <td><input name="txtSerial" type="text" class="txtbox" id="txtSerial" size="30" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">CMB Floor </td>
                      <td><input name="txtCMBFloor" type="text" class="txtbox" id="txtCMBFloor" size="30"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">CMB Ceiling </td>
                      <td><input name="txtCMBCeiling" type="text" class="txtbox" id="txtCMBCeiling" size="30" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Amount</td>
                      <td><input name="txtAmount" type="text" class="txtbox" id="txtAmount" size="30" /></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="normalfnt">&nbsp;</td>
                      <td width="72%">&nbsp;<span id="txtHint" style="color:#FF0000"></span></td>
                    </tr>
                  </table></td>
                  </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor="#d6e7f5"><table width="100%" border="0">
                    <tr>
                      <td width="21%">&nbsp;</td>
                      <td width="19"><img src="../../images/new.png" alt="New" width="100" height="24" class='mouseover' name="New"onclick="ClearForm();"/></td>
                      <td width="21"><img src="../../images/save.png" alt="Save" width="84" height="24" class='mouseover' name="Save" onclick="saveData();"/></td>
                      <td width="21"><img src="../../images/delete.png" alt="Delete" width="100" height="24" class='mouseover' name="Delete"onclick="deleteData();"/></td>
                      <td width="18%"><a href="../../main.php"><img src="../../images/close.png" alt="Close"  class='mouseover' name="Close" width="97" height="24" border="0"/></a></td>
                      <td width="21%">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="21%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>

  
  
  
  
</table>

</form>
</body>
</html>
