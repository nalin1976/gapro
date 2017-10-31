<?php
$backwardseperator = "../../../";
session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Banks</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>

<script src="../button.js"></script>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />

</head>

<body>


<form id="frmBanks" name="form1" method="POST" action="">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="100%" border="0">
          <tr>
            <td height="30" bgcolor="#588DE7" class="TitleN2white">Header</td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%" class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td class="normalfnt"><table width="100%" border="0" cellpadding="1" cellspacing="1" class="bcgl1">
                        <tr>
                          <td width="4%">&nbsp;</td>
                          <td width="21%">&nbsp;</td>
                          <td width="24%">&nbsp;</td>
                          <td width="3%">&nbsp;</td>
                          <td width="2%">&nbsp;</td>
                          <td width="14%">&nbsp;</td>
                          <td width="32%">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td width="21%">Invoice Id </td>
                          <td><select name="select"  class="txtbox" id="select"style="width:100px">
                          </select></td>
                          <td>&nbsp;</td>
                          <td colspan="2">Report Title </td>
                          <td><input name="txtPhone522" type="text" class="txtbox" id="txtPhone522" size="23" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Invoice Date </td>
                          <td><input name="txtPhone5452" type="text" class="txtbox" id="txtPhone5452" size="15" /></td>
                          <td>&nbsp;</td>
                          <td colspan="2">Shipper</td>
                          <td><select name="select2"  class="txtbox" id="select2"style="width:100px">
                          </select></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>No Of CTNs/CBM </td>
                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="39%"><input name="txtPhone5453" type="text" class="txtbox" id="txtPhone5453" size="8" /></td>
                                <td width="61%"><input name="txtPhone54532" type="text" class="txtbox" id="txtPhone54532" size="5" /></td>
                              </tr>
                          </table></td>
                          <td>&nbsp;</td>
                          <td colspan="2">Consignee</td>
                          <td><select name="select3"  class="txtbox" id="select3"style="width:100px">
                          </select></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>CTN Measurement </td>
                          <td><input name="txtPhone54522" type="text" class="txtbox" id="txtPhone54522" size="15" /></td>
                          <td>&nbsp;</td>
                          <td colspan="2">Notify Party </td>
                          <td><select name="select10"  class="txtbox" id="select10"style="width:100px">
                          </select></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>CTN Dimension </td>
                          <td><input name="txtPhone54523" type="text" class="txtbox" id="txtPhone54523" size="15" /></td>
                          <td>&nbsp;</td>
                          <td colspan="2">LC No </td>
                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="31%"><input name="txtPhone54533" type="text" class="txtbox" id="txtPhone54533" size="8" /></td>
                                <td width="27%">LC Date </td>
                                <td width="42%"><input name="txtPhone54534" type="text" class="txtbox" id="txtPhone54534" size="5" /></td>
                              </tr>
                          </table></td>
                        </tr>
                      </table></td>
                      </tr>
                    <tr class="bcgl1">
                      <td class="normalfnt">&nbsp;
                        <table width="100%" border="0" cellpadding="1" cellspacing="1" class="bcgl1">
                          <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="19%" class="normalfnt">Port Of Loading </td>
                            <td width="27%" class="normalfnt"><input name="txtPhone542" type="text" class="txtbox" id="txtPhone542" size="23" /></td>
                            <td width="4%" class="normalfnt">&nbsp;</td>
                            <td width="22%" class="normalfnt">Marks and Nos </td>
                            <td width="23%" class="normalfnt">Description Of Goods </td>
                            <td width="1%" class="normalfnt">&nbsp;</td>
                            <td width="2%" class="normalfnt">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td class="normalfnt">Final Destination </td>
                            <td class="normalfnt"><input name="txtPhone543" type="text" class="txtbox" id="txtPhone543" size="23" /></td>
                            <td class="normalfnt">&nbsp;</td>
                            <td rowspan="6" class="normalfnt"><label for="textarea"></label>
                              <textarea name="textarea" cols="20" rows="7" id="textarea"></textarea></td>
                            <td rowspan="6" class="normalfnt"><textarea name="textarea2" cols="20" rows="7" id="textarea2"></textarea></td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td class="normalfnt">Carrier</td>
                            <td class="normalfnt"><input name="txtPhone54" type="text" class="txtbox" id="txtPhone54" size="23" /></td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td class="normalfnt">Saling Date </td>
                            <td class="normalfnt"><input name="txtPhone55" type="text" class="txtbox" id="txtPhone55" size="23" /></td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td class="normalfnt">Quantity / Unit </td>
                            <td class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="45%"><input name="txtPhone54535" type="text" class="txtbox" id="txtPhone54535" size="8" /></td>
                                <td width="55%"><input name="txtPhone54536" type="text" class="txtbox" id="txtPhone54536" size="8" /></td>
                              </tr>
                            </table>                              <label for="textarea"></label></td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td class="normalfnt">Gross Mass </td>
                            <td class="normalfnt"><input name="txtPhone545" type="text" class="txtbox" id="txtPhone545" size="23" /></td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td class="normalfnt">Net Mass </td>
                            <td class="normalfnt"><input name="txtPhone546" type="text" class="txtbox" id="txtPhone546" size="23" /></td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td class="normalfnt">Net Net Mass </td>
                            <td class="normalfnt"><input name="txtPhone547" type="text" class="txtbox" id="txtPhone547" size="23" /></td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt">&nbsp;</td>
                          </tr>
                        </table>                        
                        <span id="txtHint" style="color:#FF0000"></span></td>
                      </tr>
                  </table></td>
                  </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr bgcolor="#d6e7f5">
                <td width="100%"><table width="100%" border="0" cellspacing="0">
                    <tr bgcolor="#d6e7f5">
                      <td width="21%">&nbsp;</td>
                      <td width="19"><img src="../../../images/new.png" alt="New" width="100" height="24" name="New"onclick="ClearForm();"/></td>
                      <td width="21"><img src="../../../images/save.png" alt="Save" width="84" height="24" name="Save" onclick="butCommand(this.name)"/></td>
                      <td width="21"><img src="../../../images/delete.png" alt="Delete" width="100" height="24" name="Delete"onclick="ConfirmDelete(this.name);"/></td>
                      <td width="18%"><a href="../../../main.php"><img src="../../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0"/></a></td>
                      <td width="21%">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="19%">&nbsp;</td>
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
