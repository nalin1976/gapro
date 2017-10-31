<?php
$backwardseperator = "../../";
include '../../Connector.php' ;
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cutting Value</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<script src="cuttingvalue.js"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>


</head>
<body>

<form id="cuttingValueForm" name="cuttingValueForm" >
  <table width ="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
  <td height="2"></td>
  </tr>
  <tr>
    <td><table width="450" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder" cellspacing="2">
    
    <tr>
      <td height="25"class="mainHeading"> Cutting Value </td>
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
        <td class="normalfnt">Factory</td>
        <td><select name="cboFactory" style="width:250px" id="cboFactory" tabindex="1" onchange="getDetails(this.value);">
             <?php
		$SQL ="select intCompanyID,strName from companies order by strName;";	
		
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
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Cutting</td>
        <td class="normalfnt"><input name="txtCutting" type="text" class="txtbox" id="txtCutting" onkeypress="return CheckforValidDecimal(this.value, 2,event);"  style="width:100px" maxlength="3" tabindex="2"/>&nbsp;&nbsp;%</td>
      </tr>
      <tr>
        <td width="4" class="normalfnt">&nbsp;</td>
        <td width="112" class="normalfnt">Sewing<span class="compulsoryRed"></span></td>
        <td class="normalfnt"><input name="txtSewing" type="text" class="txtbox" id="txtSewing" onkeypress="return CheckforValidDecimal(this.value, 2,event);"  style="width:100px" maxlength="3" tabindex="3"/>&nbsp;&nbsp;%</td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Finishing<span class="compulsoryRed"></span></td>
        <td class="normalfnt"><input name="txtFinishing" type="text" class="txtbox" id="txtFinishing" onkeypress="return CheckforValidDecimal(this.value, 2,event);"  style="width:100px" maxlength="3" tabindex="3"/>&nbsp;&nbsp;%</td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Packing<span class="compulsoryRed"></span> </td>
        <td class="normalfnt"><input name="txtPacking" type="text" class="txtbox" id="txtPacking" onkeypress="return CheckforValidDecimal(this.value, 2,event);"  style="width:100px" maxlength="3" tabindex="3"/>&nbsp;&nbsp;%</td>
      </tr>
      <tr>
        <td colspan="3" class="normalfnt">&nbsp;</td>
        </tr>

    </table></td>
  </tr>
  <tr>
  <td><table width="100%" border="0" cellspacing="2" cellpadding="2" class="bcgl1">
  <tr>
    <td align="center"><img src="../../images/new.png" alt="New" name="New" class="mouseover" id="butNew" style="display:inline" onclick="ClearForm();" tabindex="7"/><img src="../../images/save.png" alt="Save" name="Save" class="mouseover" id="butSave" style="display:inline" onclick="SaveCuttingValue();" tabindex="6"/><img src="../../images/delete.png" alt="Delete" border="0"name="Delete" class="mouseover" id="butDelete" onclick="deleteData();" style="display:inline" tabindex="8"/><a href="../../main.php" id="td_coDelete"><img src="../../images/close.png" alt="Close" name="Close" border="0" id="Close" style="display:inline" tabindex="9"/></a></td>
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
