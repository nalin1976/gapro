<?php
$backwardseperator = "../../";
include '../../Connector.php' ;
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cost Center</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<script src="costcenter.js"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>


</head>
<body>

<form id="costCenterForm" name="costCenterForm" >
  <table width ="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="500" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder" cellspacing="0">
    
    <tr>
      <td height="25"class="mainHeading"> Cost Center </td>
	</tr>
	<tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="10">
          <tr>
            <td><table width="93%" border="0" align="center"  cellspacing="0" cellpadding="2">
  <tr>
    <td><table width="100%" border="0" align="center" class="bcgl1">
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td width="324">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Search</td>
        <td><select name="cboSearch" style="width:300px" id="cboSearch" tabindex="1" onchange="setCostData(this.value);">
             <?php
		$SQL ="select intCostCenterId,strDescription from costcenters order by strDescription;";	
		
		$result = $db->RunQuery($SQL);
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intCostCenterId"] ."\">" . $row["strDescription"] ."</option>" ;
	}		  
		 ?>
        </select></td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Account Code&nbsp;<span class="compulsoryRed">*</span></td>
        <td><input name="txtCode" type="text" class="txtbox" id="txtCode"  style="width:298px" maxlength="10" tabindex="2"/>        </td>
      </tr>
      <tr>
        <td width="4" class="normalfnt">&nbsp;</td>
        <td width="112" class="normalfnt">Description &nbsp;<span class="compulsoryRed">*</span></td>
        <td><input name="txtDescription" type="text" class="txtbox" id="txtDescription"  style="width:298px" maxlength="50" tabindex="3"/></td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Plant&nbsp;<span class="compulsoryRed">*</span></td>
        <td><select name="cboPlant"  style="width:300px" id="cboPlant" tabindex="4">
		<option value=""> </option>
		<option value="1">Sewing</option>
		<option value="2">Cutting</option>
		<option value="3">Washing</option>
		<option value="4">Dry</option>
		<option value="5">Finishing</option>
		<option value="6">Sample Sewing</option>
		<option value="7">Washing Development</option>
		
        </select></td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Factory&nbsp;<span class="compulsoryRed">*</span> </td>
        <td><select name="cboFactory"  style="width:300px" id="cboFactory" tabindex="5">
          <?php
		$SQL ="select intCompanyID,strName from companies where intStatus=1 order by strName;";	
		
		$result = $db->RunQuery($SQL);
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
	}		  
		 ?>
        </select></td>
      </tr>
      <tr>
        <td colspan="3" class="normalfnt">&nbsp;</td>
        </tr>

    </table></td>
  </tr>
  <tr>
  <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="bcgl1">
  <tr>
    <td align="center"><img src="../../images/new.png" alt="New" name="New" class="mouseover" id="butNew" style="display:inline" onclick="ClearForm();" tabindex="7"/> <img src="../../images/save.png" alt="Save" name="Save" class="mouseover" id="butSave" style="display:inline" onclick="SaveCostCenterData();" tabindex="6"/> <img src="../../images/delete.png" alt="Delete" border="0"name="Delete" class="mouseover" id="butDelete" onclick="deleteData();" style="display:inline" tabindex="8"/> <a href="../../main.php" id="td_coDelete"><img src="../../images/close.png" alt="Close" name="Close" border="0" id="Close" style="display:inline" tabindex="9"/></a></td>
  </tr>
</table>
</td>
  </tr>
</table>
</td>
          </tr>
        </table></td>
  </tr>
 </table>
 </td>
 </tr>
 </table>  
 </form>
</body>
</html>
