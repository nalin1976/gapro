<?php
$backwardseperator = "../../";
session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Commodity Codes</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>

<script src="../commoditityCodes/button.js"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

</head>

<body>

<?php

include "../../Connector.php";

?>

<form id="frmBanks" name="form1" method="POST" action="">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="19%" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="62%"><table width="100%" border="0">
          <tr>
            <td height="30" bgcolor="#588DE7" class="TitleN2white">Canada Custom Invoice </td>
          </tr>
          <tr bgcolor="#D8E3FA">
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="28%" class="normalfnt">&nbsp;</td>
                  <td width="72%">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2" class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Vender</td>
                      <td rowspan="3"><label for="textarea" ></label>
                        <textarea name="textarea" rows="5" id="textarea" style="height:50"></textarea></td>
                      <td>Shipment Date </td>
                      <td><input name="txtBankCode2" type="text" class="txtbox" id="txtBankCode2" size="20" onclick="checkvalue();"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                      <td>Origin</td>
                      <td><input name="txtBankCode3" type="text" class="txtbox" id="txtBankCode3" size="20" onclick="checkvalue();"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                      <td>Currency</td>
                      <td><input name="txtBankCode4" type="text" class="txtbox" id="txtBankCode4" size="20" onclick="checkvalue();"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Consignee</td>
                      <td width="29%" rowspan="4"><textarea name="textarea2" rows="5" id="textarea2" style="height:50"></textarea></td>
                      <td>Terms Of Payment </td>
                      <td><input name="txtBankCode5" type="text" class="txtbox" id="txtBankCode5" size="20" onclick="checkvalue();"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                      <td>Transpertation</td>
                      <td><input name="txtBankCode6" type="text" class="txtbox" id="txtBankCode6" size="20" onclick="checkvalue();"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                      <td>CCRA Ruling </td>
                      <td><input name="txtBankCode7" type="text" class="txtbox" id="txtBankCode7" size="20" onclick="checkvalue();"/></td>
                    </tr>
                    <tr>
                      <td width="5%" class="normalfnt">&nbsp;</td>
                      <td width="20%" class="normalfnt">&nbsp;</td>
                      <td width="19%">Transshippment</td>
                      <td width="27%"><input name="txtBankCode8" type="text" class="txtbox" id="txtBankCode8" size="20" onclick="checkvalue();"/></td>
                    </tr>
                    <tr>
                      <td colspan="5" class="normalfnt"><table width="100%" border="0" cellpadding="0" cellspacing="0">

                            <tr>
                              <td colspan="2" class="normalfnt"><div id="divcons" style="overflow:scroll; height:130px; width:550px;">
                                  <table width="500" cellpadding="0" cellspacing="0" id="tblMainGrn">
                                    <tr>
                                      <td width="3%" height="25" bgcolor="#498CC2" class="normaltxtmidb2">No Of Packages </td>
                                      <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">Marks &amp; No </td>
                                      <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">Quentity</td>
                                      <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">Unit Price </td>
                                      <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Total</td>
                                      <!--          </tr>
              <td  height="80" class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
			  <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td colspan="3"    class="normaltxtmidb2"><img src="../../images/loading5.gif" width="100" height="100" border="0"  /></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
           </tr>-->
                                    </tr>
                                    </table>
                              </div></td>
                            </tr>
                                              </table></td>
                      </tr>
                    <tr>
                      <td colspan="5" class="normalfnt">&nbsp;
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="7%">&nbsp;</td>
                            <td width="12%">Inv Tot </td>
                            <td width="15%"><input name="txtBankCode62" type="text" class="txtbox" id="txtBankCode62" size="10" onclick="checkvalue();"/></td>
                            <td width="14%">Net Weight </td>
                            <td width="16%"><input name="txtBankCode622" type="text" class="txtbox" id="txtBankCode622" size="10" onclick="checkvalue();"/>
                              Kg</td>
                            <td width="3%">&nbsp;</td>
                            <td width="11%">Gross Wgt </td>
                            <td width="7%"><input name="txtBankCode623" type="text" class="txtbox" id="txtBankCode623" size="10" onclick="checkvalue();"/></td>
                            <td width="7%">Kg</td>
                            <td width="8%">&nbsp;</td>
                          </tr>
                        </table>                        <span id="txtHint" style="color:#FF0000"></span></td>
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
                      <td width="19"><img src="../../images/new.png" alt="New" width="100" height="24" name="New"onclick="ClearForm();"/></td>
                      <td width="21"><img src="../../images/save.png" alt="Save" width="84" height="24" name="Save" onclick="butCommand(this.name)"/></td>
                      <td width="21"><img src="../../images/delete.png" alt="Delete" width="100" height="24" name="Delete"onclick="ConfirmDelete(this.name);"/></td>
                      <td width="18%"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0"/></a></td>
                      <td width="21%">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="19%" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>

  
  
  
  
</table>

</form>
</body>
</html>
