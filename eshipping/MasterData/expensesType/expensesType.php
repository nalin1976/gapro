<?php
$backwardseperator = "../../";
session_start();
$id=$_GET['ID'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web | Expenses Type</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>

<script src="../expencesType/button.js"></script>
<script src="expense.js"></script>
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
        <td width="28%">&nbsp;</td>
        <td width="43%"><table width="97%" border="0">
          <tr>
            <td height="24" bgcolor="#588DE7" class="TitleN2white" >Expenses Type </td>
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
                   <!-- <tr>
                      <td width="5%" class="normalfnt">&nbsp;</td>
                      <td width="23%" class="normalfnt">Expenses Code </td>
                      <td><input name="txtExCode" type="text" class="txtbox" id="txtExCode" size="30" /></td>
                    </tr>
                    <tr>-->
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Description</td>
                      <td><input name="txtExDesc" type="text" class="txtbox" id="txtExDesc" size="40"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Expenses Type </td>
                      <td><input name="txtExType" type="text" class="txtbox" id="txtExType" size="20" /></td>
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
                      <td width="74">&nbsp;</td>
                      <td width="85"><img src="../../images/save.png" alt="Save" width="84" height="24" name="Save" onclick="saveData($id);"/></td>
                      <td width="103"><img src="../../images/delete.png" alt="Delete" width="100" height="24" name="Delete"onclick="deleteData();"/></td>
                      <td width="156"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0"/></a></td>
                      <td width="1">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="29%">&nbsp;</td>
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
