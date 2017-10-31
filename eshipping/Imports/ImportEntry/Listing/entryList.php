<?php
$backwardseperator = "../../../";
session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Import Listing</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>

<?php

include "../../../Connector.php";

?>

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
            <td height="30" bgcolor="#588DE7" class="TitleN2white">Import Listing </td>
          </tr>
          <tr bgcolor="#FEFDEB">
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%" bgcolor="#FFFFFF" class="normalfnt"><table width="500" cellpadding="0" cellspacing="0" id="tblMainGrn">
                    <tr>
                      <td width="3%" height="25" bgcolor="#498CC2" class="normaltxtmidb2">Delivery No </td>
                      <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">Invoice No  </td>
                      <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">Entry No </td>
                      <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">Cleared Date </td>
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
                    <tr>
                      <td height="15" bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      </tr>
                    <tr>
                      <td height="15" bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      </tr>
                    <tr>
                      <td height="15" bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      </tr>
                    <tr>
                      <td height="15" bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      </tr>
                    <tr>
                      <td height="15" bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      </tr>
                    <tr>
                      <td height="15" bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      </tr>
                    <tr>
                      <td height="15" bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      </tr>
                    <tr>
                      <td height="15" bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      </tr>
                    <tr>
                      <td height="15" bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      </tr>
                    <tr>
                      <td height="15" bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      </tr>
                    <tr>
                      <td height="15" bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      </tr>
                    <tr>
                      <td height="15" bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      </tr>
                    <tr>
                      <td height="15" bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      </tr>
                    <tr>
                      <td height="15" bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      </tr>
                    <tr>
                      <td height="15" bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      </tr>
                    <tr>
                      <td height="15" bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      </tr>
                    <tr>
                      <td height="15" bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      </tr>
                    <tr>
                      <td height="15" bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      <td bgcolor="#FFFFFF" class="normaltxtmidb2">&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr bgcolor="#d6e7f5">
                <td width="100%"><table width="100%" border="0" cellspacing="0">
                    <tr bgcolor="#d6e7f5">
                      <td width="21%">&nbsp;</td>
                      <td width="19">&nbsp;</td>
                      <td width="21">&nbsp;</td>
                      <td width="21">&nbsp;</td>
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
