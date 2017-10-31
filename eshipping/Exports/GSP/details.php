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
            <td height="24" bgcolor="#588DE7" class="TitleN2white"><p>Header</p>
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
                          <td width="22%">Serial No </td>
                          <td width="22%"><select name="select"  class="txtbox" id="select"style="width:120px">
                          </select></td>
                          <td width="1%">&nbsp;</td>
                          <td width="17%">&nbsp;</td>
                          <td width="37%">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td width="22%">Exporters Name and address </td>
                          <td rowspan="2"><label for="textarea"></label>
                            <textarea name="textarea" rows="5" id="textarea"></textarea></td>
                          <td>&nbsp;</td>
                          <td>Official Use </td>
                          <td rowspan="4"><textarea name="textarea3" rows="10" id="textarea3"></textarea></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Consignee's Name and Address  </td>
                          <td rowspan="2"><textarea name="textarea2" rows="5" id="textarea2"></textarea></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><label for="label"> To </label></td>
                          <td><select name="select5"  class="txtbox" id="select5"style="width:120px">
                          </select></td>
                          <td>&nbsp;</td>
                          <td>Produced Country </td>
                          <td><select name="select2"  class="txtbox" id="select2"style="width:120px">
                          </select></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Mode</td>
                          <td><select name="select6"  class="txtbox" id="select6"style="width:120px">
                          </select></td>
                          <td>&nbsp;</td>
                          <td>Exported Country </td>
                          <td><select name="select3"  class="txtbox" id="select3"style="width:120px">
                          </select></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>From</td>
                          <td><select name="select7"  class="txtbox" id="select7"style="width:120px">
                          </select></td>
                          <td>&nbsp;</td>
                          <td>Issued In </td>
                          <td><select name="select4"  class="txtbox" id="select4"style="width:120px">
                          </select></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
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
