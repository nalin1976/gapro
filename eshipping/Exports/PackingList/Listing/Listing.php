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
            <td height="30" bgcolor="#588DE7" class="TitleN2white">Cusdec Listing </td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td colspan="2" class="normalfnt">&nbsp;</td>
                  <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                  <td width="5%" class="normalfnt">&nbsp;</td>
                  <td width="17%" class="normalfnt">Packing Type </td>
                  <td width="23%"><select name="cboBankName"  onchange="getBankDetails();" class="txtbox" id="cboBankName"style="width:150px">
				 
	
                  </select> </td>
                  <td width="12%" class="normalfnt">Style No </td>
                  <td width="43%"><select name="select"  onchange="getBankDetails();" class="txtbox" id="select"style="width:150px">
                  </select></td>
                </tr>
                <tr>
                  <td colspan="2" class="normalfnt">&nbsp;</td>
                  <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="5" class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td colspan="3" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="89%" bgcolor="#9BBFDD" class="normalfnth2">&nbsp;</td>
                              <td width="11%" bgcolor="#9BBFDD" class="normalfnt">&nbsp;</td>
                            </tr>
                            <tr>
                              <td colspan="2" class="normalfnt"><div id="divcons" style="overflow:scroll; height:130px; width:750px;">
                                  <table width="800" cellpadding="0" cellspacing="0" id="tblMainGrn">
                                    <tr>
                                      <td width="5%" height="25" bgcolor="#498CC2" class="normaltxtmidb2">&nbsp;</td>
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
                    <tr>
                      <td width="5%" class="normalfnt">&nbsp;</td>
                      <td width="23%" class="normalfnt">&nbsp;</td>
                      <td width="72%">&nbsp;</td>
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
