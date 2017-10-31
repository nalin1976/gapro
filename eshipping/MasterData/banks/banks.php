<?php
$backwardseperator = "../../";
session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web | Banks</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>

<script src="banks.js"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js" type="text/javascript"></script>
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
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="100%" border="0">
          <tr>
            <td height="30" bgcolor="#588DE7" class="TitleN2white">Banks</td>
          </tr>
          <tr bgcolor="#D8E3FA">
            <td height="96" bgcolor="#D8E3FA">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="128%" colspan="3" class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Bank Name</td>
                      <td colspan="3"><select name="cboBankName"  onchange="LoadBankData();" class="txtbox" id="cboBankName"style="width:320px">
                        <?php
	
	$SQL = "SELECT strBankCode, strName,strAddress1, strAddress2, strCountry, strPhone, strFax, strEMail, strContactPerson, strRemarks, strRefNo
FROM bank;";
	
	$result = $db->RunQuery($SQL);
	
	echo "<option value=\"".""."\">" .""."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strBankCode"] ."\">" . $row["strName"] ."</option>" ;
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
                      <td width="5%" class="normalfnt">&nbsp;</td>
                      <td width="23%" class="normalfnt">Bank Code <span id="txtHint" style="color:#FF0000">*</span></td>
                      <td colspan="3"><input name="txtBankCode" type="text" class="txtbox" id="txtBankCode" size="50" maxlength="10" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
                      </tr>
					  
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Bank Name <span id="txtHint" style="color:#FF0000">*</span></td>
                      <td colspan="3"><input name="txtName" type="text" class="txtbox" id="txtName" size="50" maxlength="75"/></td>
                      </tr>
					  <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Swift Code <span id="txtHint" style="color:#FF0000">*</span></td>
                      <td colspan="3"><input name="txtSwift" type="text" class="txtbox" id="txtSwift" size="50" maxlength="20"/></td>
                      </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Address</td>
                      <td colspan="3"><input name="txtAddress1" type="text" maxlength="50" class="txtbox" id="txtAddress1" size="50" /></td>
                      </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                      <td colspan="3"><input name="txtAddress2" type="text" class="txtbox" id="txtAddress2" size="50" maxlength="50"/></td>
                      </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Country</td>
                      <td colspan="3"><input name="txtCountry" type="text" class="txtbox" id="txtCountry" size="50" maxlength="50"/></td>
                      </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Phone</td>
                      <td width="23%"><input name="txtPhone" type="text" class="txtbox" id="txtPhone" size="16" /></td>
                      <td width="13%">Fax</td>
                      <td width="36%"><input name="txtFax" type="text" class="txtbox" id="txtFax" size="15" maxlength="50"/></td>
                      </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">e-Mail</td>
                      <td colspan="3"><input name="txtEMail" type="text" class="txtbox" id="txtEMail" size="50" /></td>
                      </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Account No</td>
                      <td colspan="3"><input name="txtRefNo" type="text" class="txtbox" id="txtRefNo" size="50" /></td>
                      </tr>
                    <tr>
					 <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Account Name</td>
                      <td colspan="3"><input name="txtAccName" type="text" class="txtbox" id="txtAccName" size="50" /></td>
                      </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Contact Person</td>
                      <td colspan="3"><input name="txtContactPerson" type="text" class="txtbox" id="txtContactPerson" size="50" /></td>
                      </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Remarks</td>
                      <td colspan="3"><input name="txtRemarks" type="text" class="txtbox" id="txtRemarks" size="50" /></td>
                      </tr>
                    <tr>
                      <td colspan="2" class="normalfnt">&nbsp;</td>
                      <td colspan="3">&nbsp;<span id="txtHint" style="color:#FF0000"></span></td>
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
                      <td width="19"><img src="../../images/new.png"  alt="New" width="100" height="24" name="New" class="mouseover" onclick="Clear()"/></a></td>
                      <td width="21"><img src="../../images/save.png"  alt="Save" width="84" class="mouseover noborderforlink"  height="24" name="Save" onclick="saveData()"/></td>
                      <td width="21"><img src="../../images/delete.png" class="mouseover" alt="Delete" width="100" height="24"   name="Delete" onclick="deletedata()"/></td>
                      <td width="18%"><a href="../../main.php"><img src="../../images/close.png" alt="Close" class="noborderforlink" name="Close" width="97" height="24" border="0"/></a></td>
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
