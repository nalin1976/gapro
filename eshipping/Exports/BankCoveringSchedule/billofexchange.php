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

<script src="../Certificate of origin/button.js"></script>
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
            <td height="24" bgcolor="#588DE7" class="TitleN2white"><p>Bill Of Exchange </p>
              </td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%" class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td class="normalfnt"><table width="100%" border="0" cellpadding="1" cellspacing="1" class="bcgl1">
                        <tr>
                          <td width="1%">&nbsp;</td>
                          <td width="22%">Invoice No </td>
                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="33%"><input name="txtPhone54522" type="text" class="txtbox" id="txtPhone54522" size="15" /></td>
                              <td width="22%"><img src="../../images/search.png" alt="Delete" name="Delete" width="80" height="24" id="Delete"onclick="ConfirmDelete(this.name);"/></td>
                              <td width="9%">date</td>
                              <td width="36%"><input name="txtPhone5452" type="text" class="txtbox" id="txtPhone5452" size="15" /></td>
                            </tr>
                          </table></td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td width="22%">For</td>
                          <td><input name="txtPhone54523" type="text" class="txtbox" id="txtPhone54523" size="55" /></td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>For( In Letters ) </td>
                          <td><input name="txtPhone545232" type="text" class="txtbox" id="txtPhone545232" size="55" /></td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Bank</td>
                          <td><input name="txtPhone545233" type="text" class="txtbox" id="txtPhone545233" size="55" /></td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Drawn Under </td>
                          <td><input name="txtPhone5452332" type="text" class="txtbox" id="txtPhone5452332" size="55" /></td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><label for="label">LC No </label></td>
                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="33%"><input name="txtPhone545222" type="text" class="txtbox" id="txtPhone545222" size="15" /></td>
                              <td width="13%">&nbsp;</td>
                              <td width="18%">LC Date </td>
                              <td width="36%"><input name="txtPhone54524" type="text" class="txtbox" id="txtPhone54524" size="15" /></td>
                            </tr>
                          </table></td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Drawn To </td>
                          <td><input name="txtPhone54523322" type="text" class="txtbox" id="txtPhone54523322" size="55" /></td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Amount</td>
                          <td><input name="txtPhone54523323" type="text" class="txtbox" id="txtPhone54523323" size="55" /></td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Contact Name </td>
                          <td><input name="txtPhone54523324" type="text" class="txtbox" id="txtPhone54523324" size="55" /></td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Contact No </td>
                          <td><input name="txtPhone54523325" type="text" class="txtbox" id="txtPhone54523325" size="55" /></td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
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
