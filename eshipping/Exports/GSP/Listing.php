<?php
$backwardseperator = "../../";
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

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

</head>

<body>



<form id="frmBanks" name="form1" method="POST" action="">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="100%" border="0">
          <tr>
            <td height="19" bgcolor="#588DE7" class="TitleN2white">Listing</td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%" class="normalfnt"><table width="100%" height="186" border="0" class="bcgl1">
                    <tr>
                      <td width="100%" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><table width="100%" height="223" border="0" cellpadding="0" cellspacing="0">
						                              <tr>
							                            <td colspan="2" bgcolor="#FFFFFF" class="normalfnt">&nbsp;</td>
							                            <td width="11%" bgcolor="#9BBFDD" class="normalfnt">&nbsp;</td>
                            </tr>
                            <tr>
							  <td width="11%" bgcolor="#9BBFDD" class="normalfnt">&nbsp;</td>
                              <td width="89%" bgcolor="#9BBFDD" class="normalfnth2">&nbsp;</td>
                              <td width="11%" bgcolor="#9BBFDD" class="normalfnt">&nbsp;</td>
                            </tr>
                            <tr>
                              <td colspan="2" class="normalfnt"><div id="divcons" style="overflow:scroll; height:230px; width:750px;">
                                  <table width="700" cellpadding="0" cellspacing="0" id="tblMainGrn">
                                    <tr>
                                      <td width="7%" height="26" bgcolor="#498CC2" class="normaltxtmidb2">Item No </td>
									  <td width="11%" height="26" bgcolor="#498CC2" class="normaltxtmidb2">Country Shift </td>
									  <td width="9%" height="26" bgcolor="#498CC2" class="normaltxtmidb2">HS Code </td>
									  <td width="19%" bgcolor="#498CC2" class="normaltxtmidb2"><blockquote>
									    <p>Gross Weight </p>
									    </blockquote></td>
									  <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Net Weight </td>
									  <td width="14%" height="26" bgcolor="#498CC2" class="normaltxtmidb2">Fabric Weight </td>
									  <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Qty</td>
									  <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Unit</td>
									  <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Invoice</td>
									  <td width="10%" height="26" bgcolor="#498CC2" class="normaltxtmidb2">LMPO</td>
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
                      </table></td>
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
                      <td width="156">&nbsp;</td>
                      <td width="50">&nbsp;</td>
                      <td width="108"><img src="../../images/new.png" alt="New" width="100" height="24" name="New"onclick="ClearForm();"/></td>
                      <td width="100"><img src="../../images/save.png" alt="Save" width="84" height="24" name="Save" onclick="butCommand(this.name)"/></td>
                      <td width="104"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0"/></a></td>
                      <td width="226">&nbsp;</td>
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
