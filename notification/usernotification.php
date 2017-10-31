<?php
session_start();
$backwardseperator = "../";	
include "../authentication.inc";
include "../Connector.php"; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Allocate User For Notification</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="javascript/script.js" type="text/javascript"></script>
</head>

<body>
<form id="frmNotification" name="frmNotification" method="post" action="">
  <table width="100%" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td><?php include '../Header.php'; ?></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" align="center">
        
        <tr>
          <td width="100%"><table width="100%" border="0">
            <tr>
              <td width="62%"><table width="100%" border="0" class="tableBorder">
                  <tr>
                    <td height="35" bgcolor="#498CC2" class="mainHeading">Notification</td>
                  </tr>
                  <tr>
                    <td height="61"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="2%">&nbsp;</td>
                        <td width="10%" class="normalfnt">User Name </td>
                        <td width="88%"><select name="cboPoNo1" id="cboPoNo1" class="txtbox"style="width:360px" onchange="loadCutNo(this.value);">
                          <?php
$SQL = "select intUserID,UserName from useraccounts order by UserName";
$result = $db->RunQuery($SQL);
	echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
while($row = mysql_fetch_array($result))
{
	echo "<option value=\"" . $row["intUserID"] ."\">" . $row["UserName"] . "</option>";
}
?>
                        </select></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="3"><table width="100%" border="0" cellspacing="1" cellpadding="0" class="tableBorder" bgcolor="#CCCCFF">
                          <tr class="mainHeading4">
                            <th width="3%" height="25">Del</th>
                            <th width="37%">First Notification </th>
                            <th width="20%">Second Notification </th>
                            <th width="20%">Third Notification </th>
                            <th width="20%">Forth Notification </th>
                          </tr>
                          <tr class="bcgcolor-tblrowWhite">
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
                  <tr>
                    <td ><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
                        <tr>
                          <td width="100%" height="25" class="normalfntMid">
						  <img src="../images/save.png" alt="OK" onclick="CopyOrder();" /> 
						  <a href="main.php"><img src="../images/close.png" id="butClose" alt="close" border="0" /></a>
						  </td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
              </tr>
          </table></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
</body>
</html>
