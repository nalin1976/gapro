<?php 
 include "../../Connector.php"; 
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="850" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
	<tr>
		<td><table width="100%" border="0">
	<tr>
		<td>
		<table width="100%" border="0" class="tableBorder">
	<tr class="mainHeading">
		<td width="95%" height="25" >Add Material</td>
	    <td width="5%" align="center" valign="middle"><img src="../../images/cross.png" alt="cross" width="17" height="17" onClick="CloseGenPOPopUp('popupLayer1');"></td>
	</tr>
	<tr >
		<td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
		<tr>
			<td width="21%" >&nbsp;</td>
			<td width="23%" class="normalfnt">PR No</td>
			<td width="35%" class="normalfnt"><input name="txtPRNo" type="text"  id="txtPRNo" style="width:255px" onKeyPress="enableEnterSubmitLoadDetails(event)" /></td>
			<td width="21%">&nbsp;</td>
		</tr>
		<tr>
			<td width="21%" >&nbsp;</td>
			<td width="23%" class="normalfnt">Main Category</td>
			<td width="35%" class="normalfnt"><select name="cboMainCategory" class="txtbox" id="cboMainCategory" style="width:257px" onChange="loadSubCategory();"></select></td>
			<td width="21%">&nbsp;</td>
		</tr>
		<tr>
			<td >&nbsp;</td>
			<td class="normalfnt">Sub Category</td>
			<td class="normalfnt"><select name="cboSubCategory" class="txtbox" id="cboSubCategory" style="width:257px" ></select></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td >&nbsp;</td>
			<td class="normalfnt">Mat Detail Like</td>
			<td class="normalfnt"><input name="txtDetailsLike" type="text"  class="txtbox" id="txtDetailsLike" style="width:255px"  /></td>
			<td>&nbsp;</td>
		</tr>
        <tr>
        	<td>&nbsp;</td>
            <td class="normalfnt">Cost Center <span class="compulsoryRed">*</span></td>
            <td class="normalfnt"><select name="cboCostCenter" id="cboCostCenter" style="width:257px;">
            <?php 
			$sql = " select intCostCenterId,strDescription from costcenters where intStatus=1 order by strDescription ";
			$result =  $db->RunQuery($sql);
			echo  "<option value="."null".">".""."</option>";
				 while($rw = mysql_fetch_array($result))
				 {
					 echo "<option value=\"". $rw["intCostCenterId"] ."\">" . $rw["strDescription"] ."</option>";
				 }
			?>
            </select>
            </td>
            <td><img src="../../images/search.png" alt="new" name="butNew" class="mouseover"  id="butNew" onClick="loadMaterial();"/></td>
        </tr>
		</table></td>
	</tr>
	<tr>
		<td height="10" colspan="2" class="mainHeading2">Select Items</td>
	</tr>
	<tr>
	<td colspan="2">
		<div id="divcons" style="overflow:scroll; height:300px; width:850px;">
		<table width="100%" cellpadding="2" cellspacing="1" id="tblMaterial" bgcolor="#CCCCFF" >
			<tr class="mainHeading4">
				<td width="3%" height="25"><input type="checkbox" name="checkAll" id="checkAll" onClick="CheckAll(this)"/></td>	
				<td width="39%" >Detail</td>
				<td width="9%" >Unit</td>
				<td width="9%" > Qty</td>
				<td width="9%" >Unit Price </td>
				<td width="9%" >GL Code</td>
				<td width="22%" >GL Description</td>
			</tr>
		</table>
		</div>	</td>
	</tr>
	<tr>
	<td height="32" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr >
		<td width="28%" align="center">
		<img src="../../images/ok.png" alt="ok" width="86" height="24" onClick="addItemToMainTable();" />
		<img src="../../images/close.png" width="97" height="24" onClick="CloseGenPOPopUp('popupLayer1');"/></td>
	</tr>
	</table></td>
	</tr>
	</table>
	</td>
	</tr>
	</table></td>
	</tr>
	<tr>				
</tr>
</table>
</body>
</html>
