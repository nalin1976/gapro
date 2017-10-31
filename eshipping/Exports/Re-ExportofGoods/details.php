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
            <td height="24" bgcolor="#588DE7" class="TitleN2white"><p>Proposed Shipment Declaration  </p>
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
                          <td width="22%"><select name="select"  class="txtbox" id="select"style="width:120px">
                          </select></td>
                          <td width="1%">&nbsp;</td>
                          <td width="17%">Destination</td>
                          <td width="37%"><select name="select3"  class="txtbox" id="select3"style="width:120px">
                          </select></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td width="22%">Exporter</td>
                          <td><select name="select2"  class="txtbox" id="select2"style="width:120px">
                          </select></td>
                          <td>&nbsp;</td>
                          <td>Mode Of Shipment </td>
                          <td><select name="select4"  class="txtbox" id="select4"style="width:120px">
                          </select></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Proposed Data Of Shipment  </td>
                          <td><input name="txtPhone54522" type="text" class="txtbox" id="txtPhone54522" size="18" /></td>
                          <td>&nbsp;</td>
                          <td>Min No  </td>
                          <td><input name="txtPhone54527" type="text" class="txtbox" id="txtPhone54527" size="18" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Import Cusdec No </td>
                          <td><input name="txtPhone545222" type="text" class="txtbox" id="txtPhone545222" size="18" /></td>
                          <td>&nbsp;</td>
                          <td>Date</td>
                          <td><input name="txtPhone545228" type="text" class="txtbox" id="txtPhone545228" size="18" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Import Cusdec No </td>
                          <td><input name="txtPhone545223" type="text" class="txtbox" id="txtPhone545223" size="18" /></td>
                          <td>&nbsp;</td>
                          <td>Date</td>
                          <td><input name="txtPhone545227" type="text" class="txtbox" id="txtPhone545227" size="18" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><label for="label">Import Cusdec No </label></td>
                          <td><input name="txtPhone5452232" type="text" class="txtbox" id="txtPhone5452232" size="18" /></td>
                          <td>&nbsp;</td>
                          <td>Date</td>
                          <td><input name="txtPhone5452272" type="text" class="txtbox" id="txtPhone5452272" size="18" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Name Of Authorized </td>
                          <td colspan="4"><input name="txtPhone5452273" type="text" class="txtbox" id="txtPhone5452273" size="55" /></td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Designation</td>
                          <td colspan="4"><input name="txtPhone54522732" type="text" class="txtbox" id="txtPhone54522732" size="55" /></td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>B D/T NO </td>
                          <td><input name="txtPhone5452275" type="text" class="txtbox" id="txtPhone5452275" size="18" /></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
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
