<?php
include "../Connector.php";
$backwardseperator = "../";
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>shipment Term</title>

<link href="../css/erpstyle.css"  rel="stylesheet" type="text/css" />
<script src="emailconfig.js"></script>
<script src="../javascript/script.js"></script>
</head>

<body>

<form id="frmEmailPopUp" name="frmEmailPopUp" method="post" action="">
<table width="400" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="100%" colspan="2"><table width="100%" align="center" border="0" class="tableBorder">
          <tr>
            <td width="93%" class="mainHeading">Email Config </td>
            <td width="2" class="mainHeading"><div align="center"><img src="../images/cross.png" alt="close"   class="mainImage"  onclick="closeWindow();"/></div></td>
          </tr>
          <tr>
            <td colspan="2" >
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="3%" class="normalfnt">&nbsp; </td>
                  <td width="10%" class="normalfnt">User</td>
                  <td width="87%" class="normalfnt"><input type="text" id="txtPopUpSeaarch"  maxlength="20" onkeypress="SearchPopUpnames(event);" style="width:200px"/></td>
                </tr>
              </table>            </td>
          </tr>
          <tr>
            <td height="34" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableFooter" >
              <tr>
                <td width="100%"><div id="" style="width:100%;height:350px;overflow:auto">
				<table id="tblPopUp"  width="100%" cellpadding="0" cellspacing="1"  border="0" class="bcgl1" bgcolor="#CCCCFF">
                  <tr>
                    <td height="20" width="54" bgcolor="#498CC2" class="normaltxtmidb2"><input type="checkbox" id="chkPopSelectAll" onclick="SelectAll(this);" /></td>
                    <td width="456" bgcolor="#498CC2" class="normaltxtmidb2">User Names</td>
                    </tr>
<?php
$sql="select intUserID,UserName from useraccounts where status=1 order by UserName";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
?>
                  <tr class="bcgcolor-tblrowWhite">
                    <td align="center" valign="middle" class="normalfntMid"><input type="checkbox" id="chkPopSelect" /></td>
                    <td class="normalfnt" id="<?php echo $row["intUserID"];?>">&nbsp;<?php echo $row["UserName"];?></td>
                    </tr>
<?php
}
?>
                </table>
                </div></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><img src="../images/addsmall.png" alt="add" width="95" height="24" onclick="AddToMainTable();"/></td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
