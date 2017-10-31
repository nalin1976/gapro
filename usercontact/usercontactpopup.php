<?php
	include("../Connector.php");	
?>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="usercontact.js" type="text/javascript"></script>
<table width="600" class="bcgl1">
<tr>
<td><table width="100%" height="207" border="0" cellpadding="0" cellspacing="0">
  <tr>
	<td width="1%" bgcolor="#0E4874">&nbsp;</td>
	<td colspan="3" bgcolor="#0E4874" class="PopoupTitleclass"><table width="100%" border="0">
		<tr class="cursercross" onmousedown="grab(document.getElementById('frmMaterialTransfer'));" >
		  <td width="84%" align="center">Select Item </td>
		  <td width="13%">&nbsp;</td>
		  <td width="3%"><img src="../images/cross.png" onClick="closeWindow();" alt="Close" name="Close" width="17" height="17" id="Close" class="mouseover" /></td>
		</tr>
	  </table></td>
  </tr>
  <tr>
	<td height="24">&nbsp;</td>
	<td width="23%" class="normalfnt">User Name</td>
	<td width="54%" align="left"><input name="txtUser" type="text" class="txtbox" id="txtUser" style="width:318px"/></td>
	<td width="22%" rowspan="2" align="center" valign="middle"></td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td class="normalfnt">Company</td>
    <td><select name="cboCompany" class="txtbox" id="cboCom" style="width:318px">
	<?PHP
		$SQL="SELECT intCompanyID,strName FROM companies ";
		
			$result = $db->RunQuery($SQL);
		
					echo "<option value=\"".""."\">" ."Select Company"."</option>";
			while ($row = mysql_fetch_array($result))
				{
					echo "<option value=\"".$row["intCompanyID"]."\">". $row["strName"] ."</option>";
				}
    ?>
	</select></td>
    </tr>
	   <tr>
	<td>&nbsp;</td>
    <td class="normalfnt">Department</td>
    <td><input name="txtDepartment" type="text" class="txtbox" id="txtDepartment" style="width:318px"/></td>
    </tr>
      <tr>
	<td>&nbsp;</td>
    <td class="normalfnt">Factory Extension</td>
    <td><input name="text" type="text" class="txtbox" id="txtFacExten" style="width:318px" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
    </tr>
      <tr>
	<td>&nbsp;</td>
    <td class="normalfnt">User Extension</td>
    <td><input name="text" type="text" class="txtbox" id="txtUserExten" style="width:318px" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
    </tr>
 <tr>
	<td>&nbsp;</td>
    <td class="normalfnt">Remarks</td>
    <td><input name="text" type="text" class="txtbox" id="txtRemarks" style="width:318px"/></td>
    </tr>
    
<tr>
	<td colspan="4"><table border="0" width="100%">
	<tr>
		<td width="100%"><img src="../images/save.png" onClick="SaveDetails();" alt="Save" name="Save" id="Save" class="mouseover" /></td>
		
	</tr>
	</table></td>
</tr>
	</table></td>
	 </tr>
 
 
</table></td>
</tr>
</table>