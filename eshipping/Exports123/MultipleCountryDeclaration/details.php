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

<script src="button.js"></script>
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
            <td height="30" bgcolor="#588DE7" class="TitleN2white">Multiple Country Declaration</td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%" class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td colspan="3" class="normalfnt"><table width="100%" border="0" cellpadding="1" cellspacing="1" class="bcgl1">
                        <tr>
                          <td width="1%">&nbsp;</td>
                          <td width="19%">Select Invoice </td>
                          <td width="32%"><select name="select"  class="txtbox" id="select"style="width:120px">
                          </select></td>
                          <td width="1%">&nbsp;</td>
                          <td width="27%">Report Name </td>
                          <td width="20%"><input name="txtPhone54526" type="text" class="txtbox" id="txtPhone54526" size="18" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td colspan="2" rowspan="6"><div id="divcons" style="overflow:scroll; height:150px; width:250px;">
                              <table width="800" cellpadding="0" cellspacing="0" id="tblMainGrn">
                                <tr>
                                  <td width="40%" height="25" bgcolor="#498CC2" class="normaltxtmidb2">Country</td>
                                  <td width="60%" height="25" bgcolor="#498CC2" class="normaltxtmidb2">Code</td>
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
                          <td>&nbsp;</td>
                          <td rowspan="6"><label for="label"></label>
                            <textarea name="textarea3" cols="20" rows="8" id="label"></textarea></td>
                          <td rowspan="6"><textarea name="textarea4" cols="20" rows="8" id="textarea3"></textarea></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr class="bcgl1">
                      <td colspan="3" class="normalfnt">&nbsp;
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Manufacture / Operations</td>
                            <td>Materials</td>
                            <td width="4%">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>Date
                              <input name="txtPhone545262" type="text" class="txtbox" id="txtPhone545262" size="18" /></td>
                            <td>Date
                              <input name="txtPhone5452622" type="text" class="txtbox" id="txtPhone5452622" size="18" /></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td><div id="div" style="overflow:scroll; height:150px; width:300px;">
                              <table width="800" cellpadding="0" cellspacing="0" id="tblMainGrn">
                                <tr>
                                  <td width="40%" height="25" bgcolor="#498CC2" class="normaltxtmidb2">Operation </td>
                                  <td width="60%" bgcolor="#498CC2" class="normaltxtmidb2">Code</td>
                                  <td width="60%" height="25" bgcolor="#498CC2" class="normaltxtmidb2">Country</td>
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
                            <td><div id="div2" style="overflow:scroll; height:150px; width:300px;">
                              <table width="800" cellpadding="0" cellspacing="0" id="tblMainGrn">
                                <tr>
                                  <td width="40%" height="25" bgcolor="#498CC2" class="normaltxtmidb2">Operation</td>
                                  <td width="60%" bgcolor="#498CC2" class="normaltxtmidb2">Code</td>
                                  <td width="60%" height="25" bgcolor="#498CC2" class="normaltxtmidb2">Country</td>
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
                            <td>&nbsp;</td>
                          </tr>
                        </table>
                        <span id="txtHint" style="color:#FF0000"></span></td>
                      </tr>
                    <tr class="bcgl1">
                      <td width="42%" class="normalfnt"><div align="right">
                        <input name="txtPhone5452623" type="text" class="txtbox" id="txtPhone5452623" size="18" />
                      </div></td>
                      <td width="13%" class="normalfnt">Units</td>
                      <td width="45%" class="normalfnt"><input name="txtPhone5452624" type="text" class="txtbox" id="txtPhone5452624" size="18" /></td>
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
