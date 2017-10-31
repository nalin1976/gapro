<?php
session_start();
include "authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Preorder Approve</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style></head>
<script src="javascript/reviseorder.js" type="text/javascript"></script>
<script src="javascript/script.js" type="text/javascript"></script>
<body>

<form id="form1" name="form1" method="post" action="">
  <table width="950" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td><?php include 'Header.php'; ?></td>
    </tr>
    <tr>
      <td><table width="100%" border="0">
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td width="4%"><div align="center"><img src="images/butt_1.png" width="15" height="15" /></div></td>
          <td width="96%" class="head1">Revise Order </td>
        </tr>
        <tr>
          <td colspan="2"><table width="100%" border="0">
            <tr>
              <td width="3%">&nbsp;</td>
              <td width="13%" class="normalfnt">Factory</td>
              <td width="17%"><select name="cboFactory" onchange="GetPendingPreOders();" style="width:170px" id="cboFactory">
                          <option value="Select One" selected="selected">Select One</option>
                          <?php
	include "Connector.php"; 
	$SQL = "SELECT intCompanyID,strName FROM companies c where intStatus='1';";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
	}
	
	?>
    </select>
              </td>
              <td width="13%" class="normalfnt"> Style ID</td>
              <td width="18%"><input name="txtstyle" type="text" class="txtbox" id="txtstyle" /></td>
              <td width="36%"><img src="images/view.png" onclick="GetTargetPreOders();" alt="view" width="91" height="19" /></td>
            </tr>
          </table></td>
          </tr>
        <tr>
          <td colspan="2"><table id="tblPreOders" width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
            <tr>
              <td width="30%" height="29" bgcolor="#498CC2" class="normaltxtmidb2">Style No</td>
              <td width="20%" bgcolor="#498CC2" class="normaltxtmidb2">Approved Date</td>
              <td width="16%" bgcolor="#498CC2" class="normaltxtmidb2">Done by</td>
			  <td width="16%" bgcolor="#498CC2" class="normaltxtmidb2">Approved by</td>
              <td width="18%" bgcolor="#498CC2" class="normaltxtmidb2">View</td>
            </tr>
            
          </table></td>
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
