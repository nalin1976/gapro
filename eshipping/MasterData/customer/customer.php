<?php
	$backwardseperator = "../../";
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web | Manufacturers</title>
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

<script src="../../javascript/script.js"></script>
<script src="customer.js" type="text/javascript"></script>

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
            <td height="30" bgcolor="#588DE7" class="TitleN2white">Manufacturers</td>
          </tr>
          <tr bgcolor="#D8E3FA">
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                      <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Manufacturer </td>
                      <td colspan="3"><select name="cboCompany" class="txtbox"  onchange="getCompanyDetails();" style="width:366px;" id="cboCompany">
                          <?php
	
	$SQL = "SELECT strCustomerID, strName ,strMLocation FROM customers WHERE intDelStatus='1' ORDER BY strName"; 
	
	$result = $db->RunQuery($SQL);
	
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strCustomerID"] ."\">".$row["strName"]." - ". $row["strMLocation"] ."</option>" ;
		
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
                      <td  class="normalfnt">&nbsp;</td>
                      <td class="normalfnt"> Name</td>
                      <td colspan="3"><input name="txtCompanyName" type="text" class="txtbox" id="txtCompanyName"  style="width:363px;" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Location <span id="txtHint" style="color:#FF0000">*</span></td>
                      <td colspan="3"><input name="txtMLocation" type="text" class="txtbox" id="txtMLocation"  style="width:363px;" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Address <span id="txtHint" style="color:#FF0000">*</span></td>
                      <td colspan="3"><input name="txtAddress1" type="text" class="txtbox" id="txtAddress1" style="width:363px;" /></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="normalfnt">&nbsp;</td>
                      <td colspan="3"><input name="txtAddress2" type="text" class="txtbox" id="txtAddress2" style="width:363px;" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Country <span id="txtHint" style="color:#FF0000">*</span></td>
                      <td colspan="3"><input name="txtCountry" type="text" class="txtbox" id="txtCountry" style="width:363px;" /></td>
                    </tr>
                    <tr>
                      <td width="1%" class="normalfnt">&nbsp;</td>
                      <td width="22%" class="normalfnt">Telephone</td>
                      <td width="24%" ><input name="txtPhone" type="text" class="txtbox" id="txtPhone" style="width:130px;" /></td>
                      <td width="15%" class="normalfnt">Fax </td>
                      <td width="38%" ><input name="txtFax" type="text" class="txtbox" id="txtFax" style="width:130px;" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Email</td>
                      <td><input name="txtEmail" type="text" class="txtbox" id="txtEmail" style="width:130px;"  /></td>
                      <td class="normalfnt">Vender Code</td>
                      <td><input name="txtVender" type="text" class="txtbox" id="txtVender" style="width:130px;" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">TIN No <span id="txtHint" style="color:#FF0000">*</span> </td>
                      <td><input name="txtTin" type="text" class="txtbox" id="txtTin" style="width:130px;"  /></td>
                      <td class="normalfnt">Mid Code </td>
                      <td><input name="txtMid" type="text" class="txtbox" id="txtMid" style="width:130px;"  /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Sequence No </td>
                      <td ><input name="txtSequence" type="text" class="txtbox" id="txtSequence" style="width:130px;"  maxlength="50"/></td>
                      <td  class="normalfnt">Licence</td>
                      <td ><input name="txtLicence" type="text" class="txtbox" id="txtLicence" style="width:130px;"  /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Location # </td>
                      <td><input name="txtLocation" type="text" class="txtbox" id="txtLocation" style="width:130px;"  /></td>
                      <td class="normalfnt">PPC Code</td>
                      <td><input name="txtPpc" type="text" class="txtbox" id="txtPpc" style="width:130px;"></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">TBQ No </td>
                      <td><input name="txtTbq" type="text" class="txtbox" id="txtTbq" style="width:130px;"  /></td>
                      <td class="normalfnt">Ref No </td>
                      <td><input name="txtRefno" type="text" class="txtbox" id="txtRefno" style="width:130px;"></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Registration No </td>
                      <td><input name="txtRegistration" type="text" class="txtbox" id="txtRegistration" style="width:130px;"  /></td>
                      <td class="normalfnt">Authorize</td>
                      <td><input name="txtAuthorize" type="text" class="txtbox" id="txtAuthorize" style="width:130px;" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Remarks </td>
                      <td colspan="3"><input name="txtRemarks" type="text" class="txtbox" id="txtRemarks" style="width:363px;"  /></td>
                      </tr>
                    
                    <tr>
                      <td colspan="2" class="normalfnt">Factory Code</td>
                      <td colspan="3"><span id="txtHint" style="color:#FF0000">
                        <input name="txtFacCode" type="text" class="txtbox" id="txtFacCode" style="width:130px;"  />
                      </span></td>
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
                      <td width="20%">&nbsp;</td>
                      <td width="17%"><img src="../../images/new.png" alt="New" name="New" class="mouseover" onclick="ClearForm();"/></td>
					  <td width="16%"><img src="../../images/save.png" alt="Save" name="save" width="84" class="mouseover" height="24" onClick="saveData();"/></td>
                      <td width="19%"><img src="../../images/delete.png" alt="Delete" name="Delete" class="mouseover" width="100" height="24" onClick="deleteData();"/></td>
                      <td width="28%"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
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
