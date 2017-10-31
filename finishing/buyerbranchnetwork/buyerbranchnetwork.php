<?php
$backwardseperator = "../../";
include '../../Connector.php' ;
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Buyer Branch Network</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="buyerbranchnetwork.js"></script>

</head>
<body>

<form id="branchNetwork" name="branchNetwork" >
  <table width ="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="700" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder" cellspacing="0">
    
    <tr>
      <td height="25"class="mainHeading"> Buyer Branch Network </td>
	</tr>
	<tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="10">
          <tr>
            <td><table width="90%" border="0" align="center"  cellspacing="0" cellpadding="2">
  <tr>
    <td><table width="100%" border="0" align="center" class="bcgl1">
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Search</td>
        <td colspan="3"><select name="cboSearch" style="width:380px" id="cboSearch" tabindex="1" onchange="setData(this.value);">
             <?php
		$SQL =" select intBuyerBranchId,strBranchName from finishing_buyer_branch_network order by strBranchName  ";	
		
		$result = $db->RunQuery($SQL);
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intBuyerBranchId"] ."\">" . $row["strBranchName"] ."</option>" ;
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
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Branch Name&nbsp;<span class="compulsoryRed">*</span></td>
        <td colspan="3"><input name="txtBranchName" type="text" class="txtbox" id="txtBranchName"  style="width:380px" maxlength="20" tabindex="2"/>        </td>
      </tr>
      <tr>
        <td width="2" class="normalfnt">&nbsp;</td>
        <td width="163" class="normalfnt">Mother Company&nbsp;<span class="compulsoryRed">*</span></td>
        <td colspan="3"><select name="cboBuyer"  style="width:380px" id="cboBuyer" tabindex="3">
          <?php
		$SQL =" SELECT intBuyerID,strName FROM buyers where intStatus<>10 order by strName;";	
		
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
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Country&nbsp;<span class="compulsoryRed">*</span></td>
        <td colspan="3"><select name="cboCountry"  style="width:380px" id="cboCountry" tabindex="4">
		
		<?php
		$SQL =" SELECT intConID, strCountry FROM country where intStatus<>10 order by strCountry;";	
		
		$result = $db->RunQuery($SQL);
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intConID"] ."\">" . $row["strCountry"] ."</option>" ;
	}		  
		 ?>
          
        </select></td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Correspondence Address 1 </td>
        <td colspan="3"><input name="txtAddress1" type="text" class="txtbox" id="txtAddress1" style="width:380px" maxlength="50" tabindex="5"/></td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Correspondence Address 2 </td>
        <td colspan="3"><input name="txtAddress2" type="text" class="txtbox" id="txtAddress2" style="width:380px" maxlength="50" tabindex="6"/></td>
      </tr>

      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Correspondence Address 3 </td>
        <td colspan="3"><input name="txtAddress3" type="text" class="txtbox" id="txtAddress3" style="width:380px" maxlength="50" tabindex="7"/></td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Tel</td>
        <td width="129" ><input name="txtTelNo" type="text" class="txtbox" id="txtTelNo" style="width:127px" maxlength="50" tabindex="8" onkeypress=""/></td>
        <td width="73" class="normalfnt">Fax</td>
        <td width="213"><input name="txtFaxNo" type="text" class="txtbox" id="txtFaxNo" style="width:127px" maxlength="30" tabindex="9"/></td>
      </tr>

      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">e-Mail</td>
        <td colspan="3"><input name="txtEmail" type="text" class="txtbox" id="txtEmail" style="width:380px" maxlength="50" tabindex="10"/></td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Contact Person </td>
        <td colspan="3"><input name="txtCotactPerson" type="text" class="txtbox" id="txtCotactPerson" style="width:380px" maxlength="50" tabindex="11"/></td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Remarks</td>
        <td colspan="3"><input name="txtRemarks" type="text" class="txtbox" id="txtRemarks" style="width:380px" maxlength="50" tabindex="12"/></td>
      </tr>
      <tr>
        <td colspan="5" class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" class="normalfnt">&nbsp;</td>
        </tr>

    </table></td>
  </tr>
  <tr>
  <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="bcgl1">
  <tr>
    <td align="center"><img src="../../images/new.png" alt="New" name="New" class="mouseover" id="New" style="display:inline" onclick="ClearForm();" tabindex="14"/> <img src="../../images/save.png" alt="Save" name="Save" class="mouseover" id="Save" style="display:inline" onclick="SaveBuyerBranchData();" tabindex="13"/> <img src="../../images/delete.png" alt="Delete" border="0"name="Delete" class="mouseover" id="Delete" onclick="deleteData();" style="display:inline" tabindex="15"/> <a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" border="0" id="Close" style="display:inline" tabindex="16"/></a></td>
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
