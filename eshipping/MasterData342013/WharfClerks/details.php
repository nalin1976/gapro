<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web | Employees</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
	font-size: 14px;
	font-family: Tahoma;
}
-->
</style>
<!--<script src="button.js"></script>
<script src="Search.js"></script>-->
<script src="wharfclerk.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>


</head>

<body>
<?php
	include "../../Connector.php";	
?>
	
<form id="frmBuyers" name="frmBuyers" method="post" action="">
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
            <td height="30" bgcolor="#588DE7" class="TitleN2white">Employees</td>
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
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Employee Id</td>
                      <td colspan="3"><select name="cboClerk" class="txtbox"  onchange="getClerkDetail();" style="width:320px" id="cboClerk">
                        <?php
					$SQL = "SELECT 	intWharfClerkID, 
						strName FROM wharfclerks ORDER BY strName;";
					
					$result = $db->RunQuery($SQL);
					
					echo "<option value=\"". "" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"". $row["intWharfClerkID"] ."\">" . $row["strName"] ."</option>" ;
					}
				?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                      <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="4%" class="normalfnt">&nbsp;</td>
                      <td width="22%" class="normalfnt"> Name<span id="txtHint" style="color:#FF0000">*</span></td>
                      <td colspan="3"><input name="txtName" type="text" autocompletetype="Disabled" autocomplete="off" class="txtbox" id="txtName"  size="50" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Address</td>
                      <td colspan="3"><input name="txtAddress1" type="text" class="txtbox" id="txtAddress1"  size="50" /></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="normalfnt">&nbsp;</td>
                      <td colspan="3"><input name="txtAddress2" type="text" class="txtbox" id="txtAddress2"  size="50" /></td>
                    </tr>
                    <!-- <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Street</td>
                      <td colspan="3"><input name="txtStreet" type="text" class="txtbox" id="txtStreet" size="50" /></td>
                    </tr>
                    <tr>-->
  <td class="normalfnt">&nbsp;</td>
      <td class="normalfnt">Country</td>
    <td width="18%"><input name="txtCountry" type="text" class="txtbox" id="txtCountry" size="16" /></td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">Phone</td>
    <td><input name="txtPhone" type="text" class="txtbox" id="txtPhone" size="16" /></td>
    <td width="16%" style="text-align:center">Fax</td>
    <td width="40%"><input name="txtFax" type="text" class="txtbox" id="txtFax" size="15" /></td>
    <!--<td>Do Charges </td>
                      <td><input name="txtCharges" type="text" class="txtbox" id="txtCharges" size="15" /></td>-->
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">e-Mail</td>
    <td colspan="3"><input name="txtEmail" type="text" class="txtbox" id="txtEmail" size="50" /></td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">Remarks</td>
    <td colspan="3"><input name="txtRemarks" type="text" class="txtbox" id="txtRemarks" size="50" /></td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">TIN</td>
    <td colspan="3"><input name="txtTIN" type="text" class="txtbox" id="txtTIN" size="50" /></td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">ID Number </td>
    <td colspan="3"><span id="txtHint" style="color:#FF0000">
      <input name="txtFax2" type="text" class="txtbox" id="txtIdnumber" size="15" />
    </span></td>
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
                      <td width="22%">&nbsp;</td>
                      <td width="19%"><img src="../../images/new.png" alt="New" name="New" onclick="ClearForm();"/></td>
					  <td><img src="../../images/save.png" alt="Save" name="save" width="84" height="24" onclick="saveData()"/></td>
                      <td width="15%"><img src="../../images/delete.png" alt="Delete" name="Delete" width="100" height="24" onclick="deleteData();"/></td>
                      <td width="18%"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                      <td width="26%">&nbsp;</td>
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
