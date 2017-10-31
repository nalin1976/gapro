<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Buyers</title>
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
<script src="../Fabric transfer/button.js" type="text/javascript"></script>
<script src="../Fabric transfer/Search.js" type="text/javascript"></script>

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
        <td width="17%">&nbsp;</td>
        <td width="69%"><table width="100%" border="0">
          <tr>
            <td height="30" bgcolor="#588DE7" class="TitleN2white">Fabric Transfer </td>
          </tr>
          <tr bgcolor="#D8E3FA">
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td colspan="2" class="normalfnt">&nbsp;</td>
                  <td width="72%">&nbsp;</td>
                </tr>
                <tr>
                  <td width="5%" class="normalfnt">&nbsp;</td>
                  <td width="23%" class="normalfnt">Serial No </td>
                  <td><select name="cboCustomer" class="txtbox"  onchange="getCustomerDetails();" style="width:320px" id="cboCustomer">
							<?php
	
	$SQL = "SELECT intBuyerID, strName FROM buyers where intStatus=1;";
	
	$result = $db->RunQuery($SQL);
	
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
	}
	
	?>
                  </select></td>
                </tr>
                <tr>
                  <td colspan="3" class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td width="5%" class="normalfnt">&nbsp;</td>
                      <td width="23%" class="normalfnt">Address of the transfer </td>
                      <td colspan="3"><input name="txtName" type="text" AutoCompleteType="Disabled" autocomplete="off" class="txtbox" id="txtName"  size="50" onclick="checkvalue();"/></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="normalfnt">&nbsp;</td>
                      <td colspan="3"><input name="txtAddress2" type="text" class="txtbox" id="txtAddress2"  size="50" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Tin</td>
                      <td colspan="3"><input name="txtStreet" type="text" class="txtbox" id="txtStreet" size="50" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Location Of the Transfer </td>
                      <td colspan="3"><input name="txtStreet2" type="text" class="txtbox" id="txtStreet2" size="50" /></td>
                      </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Tin</td>
                      <td width="23%"><input name="txtCountry" type="text" class="txtbox" id="txtCountry" size="16" /></td>
                      <td width="11%">TQB NO </td>
                      <td width="38%"><input name="txtZipCode" type="text" class="txtbox" id="txtZipCode" size="15" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Description Of Item </td>
                      <td colspan="3"><input name="txtEmail2" type="text" class="txtbox" id="txtEmail2" size="50" /></td>
                      </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Country Of Destination </td>
                      <td><input name="txtCountry" type="text" class="txtbox" id="txtCountry" size="16" /></td>
                      <td>Cat No </td>
                      <td><input name="txtZipCode" type="text" class="txtbox" id="txtZipCode" size="15" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Date Of export </td>
                      <td><input name="txtCountry" type="text" class="txtbox" id="txtCountry" size="16" /></td>
                      <td>Order No </td>
                      <td><input name="txtZipCode" type="text" class="txtbox" id="txtZipCode" size="15" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Balance Of Accesseries /Fabric </td>
                      <td colspan="3"><input name="txtRemarks" type="text" class="txtbox" id="txtRemarks" size="50" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">VAT Invoice No </td>
                      <td><input name="txtCountry" type="text" class="txtbox" id="txtCountry" size="16" /></td>
                      <td>Date </td>
                      <td><input name="txtZipCode" type="text" class="txtbox" id="txtZipCode" size="15" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Total Value </td>
                      <td><input name="txtCountry" type="text" class="txtbox" id="txtCountry" size="16" /></td>
                      <td>Quantity</td>
                      <td><input name="txtZipCode" type="text" class="txtbox" id="txtZipCode" size="15" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Reason for Transfer / Sale </td>
                      <td colspan="3"><input name="txtRemarks2" type="text" class="txtbox" id="txtRemarks2" size="50" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Transferor Name </td>
                      <td><input name="txtCountry" type="text" class="txtbox" id="txtCountry" size="16" /></td>
                      <td>Transferee Name </td>
                      <td><input name="txtZipCode" type="text" class="txtbox" id="txtZipCode" size="15" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Company</td>
                      <td colspan="3"><input name="txtRemarks22" type="text" class="txtbox" id="txtRemarks22" size="50" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                      <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2" class="normalfnt">&nbsp;</td>
                      <td colspan="3">&nbsp;</td>
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
					  <td>&nbsp;</td>
                      <td width="15%"><img src="../../images/save.png" alt="Save" name="save" width="84" height="24" onClick="butCommand(this.name)"/></td>
                      <td width="18%"><img src="../../images/delete.png" alt="Delete" name="Delete" width="100" height="24" onClick="ConformDelete(this.name)"/></td>
                      <td width="26%"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="14%">&nbsp;</td>
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
