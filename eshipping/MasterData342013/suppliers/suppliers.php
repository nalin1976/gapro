<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web | Suppliers</title>
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
<script src="button.js" type="text/javascript"></script>
<script src="Search.js" type="text/javascript"></script>
<script src="suppliers.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>

</head>

<body >
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
            <td height="30" bgcolor="#588DE7" class="TitleN2white">Suppliers</td>
          </tr>
          <tr bgcolor="#D8E3FA">
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="93%" class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                      <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Search</td>
                      <td colspan="3"><select name="cboCustomer" class="txtbox"  onchange="getSuppliersDetails();" style="width:370px" id="cboCustomer">
                        <?php
	
	$SQL = "SELECT strSupplierID, strName FROM suppliers ORDER BY strName;";
	
	$result = $db->RunQuery($SQL);
	
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{	$row["strName"]=str_replace("''","'",$row["strName"]);
		echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strName"] ."</option>" ;
	}
	
	?>
                      </select></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="normalfnt">&nbsp;</td>
                      <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Supplier Name <span id="txtHint" style="color:#FF0000">*</span></td>
                      <td colspan="3" ><input name="txtNmae" type="text" class="txtbox" id="txtName"  size="50" /></td>
                  </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Address <span id="txtHint" style="color:#FF0000">*</span></td>
                      <td colspan="3"><input name="txtAddress1" type="text" class="txtbox" id="txtAddress1"  size="50" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                      <td colspan="3"><input name="txtAddress2" type="text" class="txtbox" id="txtAddress2"  size="50" /></td>
                      </tr>
                    
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Country <span id="txtHint" style="color:#FF0000">*</span></td>
                      <td width="19%"><select name="txtCountry" class="txtbox"   style="width:130px" id="txtCountry" >
                        <?php
	
	$SQL = "SELECT 	strCountryCode, 	strCountry FROM country ";
	
	$result = $db->RunQuery($SQL);
	
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strCountryCode"] ."\">" . $row["strCountry"] ."</option>" ;
	}
	
	?>
                      </select>
                      <td width="15%">City <span id="cityqq" style="color:#FF0000">*</span></td>
                      <td width="38%"><input name="cboCity" type="text" class="txtbox" id="cboCity" size="17" /></td>
                    </tr>
                    
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Telephone</td>
                      <td><input name="txtTelephone" type="text" class="txtbox" id="txtTelephone" size="16" /></td>
                      <td>Fax</td>
                      <td><input name="txtFax" type="text" class="txtbox" id="txtFax" size="17" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Email</td>
                      <td><input name="txtEmail" type="text" class="txtbox" id="txtEmail" size="16" /></td>
                      <td>TIN</td>
                      <td><input name="txtTIN" type="text" class="txtbox" id="txtTIN" size="17" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Remarks</td>
                      <td><span id="txtHint" style="color:#FF0000">
                        <input name="txtRemarks" type="text" class="txtbox" id="txtRemarks" size="16" />
                      </span></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
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
                      <td width="19%"><img src="../../images/new.png" alt="New" name="New" class="mouseover" onclick="ClearForm();"/></td>
					  <td><img src="../../images/save.png" alt="Save" name="save" width="84" height="24" class="mouseover" onclick="saveData();"/></td>
                      <td width="15%"><img src="../../images/delete.png" alt="Delete" name="Delete" width="100" height="24" class="mouseover" onclick="deleteData();"/></td>
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
