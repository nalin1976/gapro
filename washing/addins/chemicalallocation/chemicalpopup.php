<?php
session_start();
$backwardseperator = "../../../";
include "../../../Connector.php";
$prossId	= $_GET["ProssId"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Chemical Allocation</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<script src="chemicalallocation.js"></script>
<script src="../../../javascript/script.js"></script>
</head>
<body>
<!--<form id="frmChemicalAllocation" name="frmChemicalAllocation" >-->
<table width="528" border="0" align="center" bgcolor="#FFFFFF">
<tr>
	<td><table width="100%" border="0" align="center">
		<tr>
			<td width="62%"><table width="100%" border="0" class="tableBorder">
				<tr class="mainHeading">
					<td width="96%" height="25" >Chemical</td>
					<td width="4%" ><img src="../../../images/cross.png" alt="Close" width="17" height="17" onclick="ClosePopUp();" /></td>
				</tr>
				<tr>
					<td height="96" colspan="2">
					<table width="100%" border="0">
					<tr>
						<td width="34%" colspan="1" class="mainHeading4" >Chemical Name</td>
                        <td width="33%" colspan="1" class="mainHeading4" ><input type="text" id="txtChmSearch" name="txtChmSearch"  width="200;" onkeypress="SearchChemical(this,event);"/></td>
                        <td width="33%" colspan="1" class="mainHeading4" >&nbsp;</td>
					</tr>
					<tr>
						<td colspan="3" class="normalfntMid" >
						<div style="overflow:scroll;height:276px;">
						<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF" id="tblPopUp">				
						<tr class="mainHeading4" height="25">
							<th width="4%"><input type="checkbox" name="chkAll" id="chkAll" onclick="CheckAll(this);"/></th>
							<th width="66%">Chemical Description </th>
							<th width="15%">Unit</th>
							<th width="15%">Unit Price</th>
						</tr>
<?php
$sql="select GMIL.intItemSerial,GMIL.strItemDescription,GMIL.strUnit,GMIL.dblLastPrice from genmatitemlist GMIL where GMIL.intMainCatID=1 and  GMIL.intItemSerial not in(select intChemicalId from was_chemical where intProcessId=$prossId) order by GMIL.strItemDescription";
//echo $sql;
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
?>
						<tr class="bcgcolor-tblrowWhite" >
							<td width="4%"><input type="checkbox" name="chkSelect" id="chkSelect" /></td>
							<td width="66%" class="normalfnt" id="<?php echo $row["intItemSerial"]?>"><?php echo $row["strItemDescription"]?></td>
							<td width="15%" class="normalfnt" id="<?php echo $row["strUnit"]?>"><?php echo $row["strUnit"]?></td>
							<td width="15%" class="normalfnt" ><input type="text" name="txtUP" id="txtUP" style="width:70px;text-align:right" value="<?php echo round($row["dblLastPrice"],4);?>" onkeypress="return CheckforValidDecimal(this.value, 3,event);" onkeyup="checkfirstDecimal(this);" onchange="checkLastDecimal(this);"/></td>
						</tr>  
<?php
}
?>   
					</table>
					</div>
					</td>
					</tr>                
				</table></td>
				</tr>
				<tr>
				<td height="34" colspan="2">
				<table width="100%" border="0"class="tableBorder">
				<tr>
					<td width="25%" align="center">
						<img src="../../../images/addsmall.png" alt="Save" name="butSave" class="mouseover" id="butSave" tabindex="6" onclick="AddToMainGrid();"/>
						<img src="../../../images/close.png" alt="Save" name="butClose" class="mouseover" id="butSave" tabindex="6" onclick="ClosePopUp();" />
					</td>
				</tr>
				</table></td>
				</tr>
			</table></td>
		</tr>
	</table></td>
</tr>
</table>
<!--</form>-->
</body>
</html>