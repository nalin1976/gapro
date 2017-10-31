<?php
	include("../../Connector.php");	
	$deliveryNo		= $_GET["deliveryNo"];
	$matdetailID	= $_GET["matdetailID"];
	$recType		= $_GET["recType"];
	$itenDec		= $_GET["itenDec"];
	$unitPrice		= $_GET["unitPrice"];
?>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="cusdec.js" type="text/javascript"></script>
<script src="cusdecdescription.js" type="text/javascript"></script>
<table width="550">
<tr>
<td><table width="100%" height="207" border="0" cellpadding="0" cellspacing="0">
  <tr>
	<td width="1%" bgcolor="#588DE7">&nbsp;</td>
	<td colspan="4" bgcolor="#588DE7" class="PopoupTitleclass"><table width="100%" border="0">
		<tr class="cursercross" onmousedown="grab(document.getElementById('frmTaxPopUp'));" >
		  <td width="96%" align="center">Preview Tax Calculation</td>
		  <td width="4%"><img src="../../images/cross.png" onClick="closeWindowDialog();" alt="Close" name="Close" width="17" height="17" id="Close" class="mouseover" /></td>
		</tr>
	  </table></td>
  </tr>
  <tr>
	<td height="24">&nbsp;</td>
	<td width="19%" class="normalfnt">Item Description </td>
	<td width="1%" align="left" class="normalfnt">:</td>
	<td colspan="2" align="left" class="normalfnt"><?php echo $itenDec;?></td>
	<td width="1%" align="left">&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td class="normalfnt">UnitPrce</td>
	<td class="normalfnt">:</td>
    <td width="65%" class="normalfnt"> <?php echo $unitPrice;?></td>
    <td width="13%" class="normalfnt mouseover" onclick="AddNewTaxRow();" ><div align="center"><img src="../../images/plus_16.png" alt="add" /> addTax </div></td>
    <td>&nbsp;</td>
  </tr>
	 <tr>
	<td colspan="5" height="30" bgcolor="#D6E7F5"><table width="100%">
 <tr>
	<td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
	  <tr>
		<td><div id="divTaxPopUp" style="overflow:scroll;height:220px;" >
		  <table width="550" border="0" id="tblTaxPopUp" cellpadding="0" cellspacing="1" class="bcgl1">
            <tr>
              <td width="4%" bgcolor="#3E81B7" class="normaltxtmidb2">Del</td>
              <td width="6%" bgcolor="#3E81B7" class="normaltxtmidb2">Save</td>
              <td width="10%" bgcolor="#3E81B7" class="normaltxtmidb2">Position</td>
              <td width="24%" bgcolor="#3E81B7" class="normaltxtmidb2">Tax Code </td>
              <td width="19%" height="22" bgcolor="#3E81B7" class="normaltxtmidb2">Tax Base </td>
              <td width="11%" bgcolor="#3E81B7" class="normaltxtmidb2">Tax Rate </td>
              <td width="19%" bgcolor="#3E81B7" class="normaltxtmidb2">Amount</td>
              <td width="4%" bgcolor="#3E81B7" class="normaltxtmidb2">MP</td>
            </tr>
            <?php
$sql="select * from cusdectax 
where intDeliveryNo='$deliveryNo'
and intItemCode ='$matdetailID'
Order By intPosition";
$result=$db->RunQuery($sql);
$i=0;
while($row=mysql_fetch_array($result))
{
$i++;
if($i % 2 == 0)
	$class	= "bcgcolor-tblrowWhite";
else
	$class	= "bcgcolor-tblrow";
	
	$position		= $row["intPosition"];
	$taxCode		= $row["strTaxCode"];
	$taxBase		= $row["dblTaxBase"];
	$taxRate		= $row["dblRate"];
	$taxAmount		= $row["dblAmount"];
	$mp				= $row["intMP"];
?>
            <tr onclick="rowclickColorChange(this,'tblTaxPopUp');" class="<?php echo $class;?>">
              <td class="normalfntMid"><img src="../../images/del.png" alt="del" width="15" height="15" onclick="RemoveTaxPopUpItem(this);"/></td>
              <td class="normalfntMid"><img src="../../images/disk.png" alt="del" width="15" height="15" onclick="SaveTaxPoPupDetails(this);"/></td>
              <td class="normalfntMid"><?php echo $position;?></td>
              <td class="normalfnt"><?php echo $taxCode;?></td>
              <td class="normalfnt" ><input type="text" name="txtPopupTaxAmount2" id="txtPopupTaxAmount2" class="txtbox" size="17" style="text-align:right" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="<?php echo round($taxBase,0);?>"/></td>
              <td class="normalfntMid" onclick="changePopUpTaxToStyleTextBox(this);"><?php echo $taxRate;?></td>
              <td class="normalfnt"><input type="text" name="txtPopupTaxAmount" id="txtPopupTaxAmount" class="txtbox" size="17" style="text-align:right" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="<?php echo round($taxAmount,0);?>"/></td>
<?php
if($mp==1){
?>
              <td class="normalfnt"><input type="checkbox" name="txtMP" id="txtMP" class="txtbox" size="2" style="text-align:center" checked="checked" onclick="SaveMp(this);"/></td>
<?php
}
else{
?>
				<td class="normalfnt"><input type="checkbox" name="txtMP" id="txtMP" class="txtbox" size="2" style="text-align:center" onclick="SaveMp(this);"/></td>
<?php
}
?>
            </tr>
            <?php
}
?>
          </table>
		</div></td>
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