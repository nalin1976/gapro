<?php
	include("../../Connector.php");	
?>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="cusdec.js" type="text/javascript"></script>
<script src="cusdecdescription.js" type="text/javascript"></script>
<table width="600" class="bcgl1">
<tr>
<td><table width="100%" height="207" border="0" cellpadding="0" cellspacing="0">
  <tr>
	<td width="1%" bgcolor="#0E4874">&nbsp;</td>
	<td colspan="3" bgcolor="#0E4874" class="PopoupTitleclass"><table width="100%" border="0">
		<tr class="cursercross" onmousedown="grab(document.getElementById('frmMaterialTransfer'));" >
		  <td width="84%" align="center">Select Item </td>
		  <td width="13%">&nbsp;</td>
		  <td width="3%"><img src="../../images/cross.png" onClick="closeWindowDialog();" alt="Close" name="Close" width="17" height="17" id="Close" class="mouseover" /></td>
		</tr>
	  </table></td>
  </tr>
  <tr>
	<td height="24">&nbsp;</td>
	<td width="23%" class="normalfnt">Item Like </td>
	<td width="54%" align="left"><input type="text" id="txtPopUpItemlike" style="width:318px" class="txtbox" onkeyup="FilterItemDescription();"></td>
	<td width="22%" rowspan="2" align="center" valign="middle"><img src="../../images/filter_nbg.png" alt="filter" width="85" height="26" onclick="FilterItemDescription();" /></td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td class="normalfnt">Commodity Code Like </td>
    <td><input name="text" type="text" class="txtbox" id="txtPopUpHslike" style="width:318px" onkeyup="FilterItemDescription();"/></td>
    </tr>
	 <tr>
	<td colspan="4" height="30" bgcolor="#D6E7F5"><table width="100%">
 <tr>
	<td width="70%"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
	  <tr>
		<td><div id="divItemPopUp" style="overflow:scroll;height:290px;" ><table width="100%" border="0" id="tblItemPopUp" cellpadding="0" cellspacing="1" class="bcgl1">
	<tr>
	<td width="65%" height="22" bgcolor="#3E81B7" class="normaltxtmidb2">Item Description </td>
	<td width="21%" bgcolor="#3E81B7" class="normaltxtmidb2">Commodity Code</td>
	<td width="14%" bgcolor="#3E81B7" class="normaltxtmidb2">Unit</td>
	</tr>
<?php
$sql="select * from item Order By strDescription";
$result=$db->RunQuery($sql);
$i=0;
while($row=mysql_fetch_array($result))
{
$i++;
if($i % 2 == 0)
	$class	= "bcgcolor-tblrowWhite";
else
	$class	= "bcgcolor-tblrow";
?>
	<tr ondblclick="AddToDescription(this);" class="<?php echo $class;?>" onmouseover="this.style.background ='#D6E7F5';" onmouseout="this.style.background='';">
		<td class="normalfnt" id="<?php echo $row["strItemCode"]?>"><?php echo $row["strDescription"];?></td>
		<td class="normalfnt"><?php echo $row["strCommodityCode"];?></td>
		<td class="normalfnt"><?php echo $row["strUnit"];?></td>
	</tr>

<?php
}
?>

		</table></div></td>
	  </tr>
	  <tr>
		<td><table width="100%" border="0">
		</table></td>
	  </tr>
	</table></td>
  </tr>
	</table></td>
 </tr>
</table></td>
</tr>
</table>