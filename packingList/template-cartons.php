
<?php
	$styleId 	= 	$_GET["styleId"];
	//if( $styleId='')
		//$$styleId=	'202748';
	$type		=	$_GET["type"];
	
	include "../Connector.php";	
?>

<table  width="1200" border="0" cellpadding="0" cellspacing="1" bordercolor="#162350" bgcolor="#CCCCFF" id="tblMainGrid">
  <tr>
    <td height="33"  bgcolor="#498CC2" class="normaltxtmidb2">Del</td>
	<td width="14%" bgcolor="#498CC2" class="normaltxtmidb2">Buyer PO</td>
    <td width="4%" bgcolor="#498CC2" class="normaltxtmidb2">SH</td>
    <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Length</td>
    <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Sticker</td>
    <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Container</td>
    <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">From</td>
    <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">To </td>
    <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">CTNs</td>
    <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2">Color</td>
		<?php
	$SQL = "SELECT distinct
styleratio.strSize
FROM styleratio
WHERE
styleratio.intStyleId =  '$styleId'
			";
	//echo $SQL;
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$size = $row["strSize"];

	?>
    <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2"><?php echo $size; ?></td>
	<?php
	}
	?>
    <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">PSC/CTN</td>
    <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Total</td>
    <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Gross WGT</td>
    <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Net WGT</td>
    <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Net-Net WGT</td>
    <!--          </tr>
              <td  height="80" class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
			  <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td colspan="3"    class="normaltxtmidb2"><img src="../../images/loading5.gif" width="100" height="100" border="0"  /></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
           </tr>-->
  </tr>
 <tr>
    <td width="1%" height="18" bgcolor="#FFFFFF" class="normaltxtmidb2"><img src="../images/del.png" name="butDelete" id="butDelete"/></td>
    <td bgcolor="#FFFFFF" class="normaltxtmidb2"><select name="cboBuyerPoNo" class="txtbox" id="cboBuyerPoNo" style="width:100px" >
      				  	<option value="" ></option>
					<?php
					$SQL = "SELECT
							style_buyerponos.strBuyerPONO
							FROM style_buyerponos
							WHERE
							style_buyerponos.intStyleId =  '$styleId'
							";
					$result = $db->RunQuery($SQL);
					while($row = mysql_fetch_array($result))
					{
					echo "<option value=\"". $row["strBuyerPONO"] ."\">" . $row["strBuyerPONO"] ."</option>" ;
					}
					?>
    </select></td>
    <td bgcolor="#FFFFFF" class="normaltxtmidb2"><select name="cboSh" class="txtbox" id="cboSh" style="width:50px" >
	<option></option>
	<option>MIX</option>
    </select></td>
    <td bgcolor="#FFFFFF" class="normaltxtmidb2"><select name="cboLength" class="txtbox" id="cboLength" style="width:60px" >
	<option></option>
		<?php
	$SQL = "SELECT
			packinglistlength.strLength,
			packinglistlength.intId
			FROM packinglistlength
			";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["intId"] ."\">" . $row["strLength"] ."</option>" ;
	}
	?>
    </select></td>
    <td bgcolor="#FFFFFF" class="normaltxtmidb2">
      <input name="txtSticker" type="text" class="txtbox" id="txtSticker" size="20">    </td>
    <td bgcolor="#FFFFFF" class="normaltxtmidb2"><input name="txtContainer" type="text" class="txtbox" id="txtContainer" size="15"></td>
    <td bgcolor="#FFFFFF" class="normaltxtmidb2"><input onblur="calculateCartons(this);calculateSizeTotal(this);" onkeypress="return CheckforValidDecimal(this, 4,event);" name="txtFrom" type="text" class="txtbox" id="txtFrom" size="10"></td>
    <td bgcolor="#FFFFFF" class="normaltxtmidb2"><input onblur="calculateCartons(this);calculateSizeTotal(this);" onkeypress="return CheckforValidDecimal(this, 4,event);" name="txtTo" type="text" class="txtbox" id="txtTo" size="10"></td>
    <td bgcolor="#FFFFFF" class="normaltxtmidb2"><input onfocus="this.blur();" name="txtCtns" type="text" class="txtbox" id="txtCtns" size="10"></td>
    <td bgcolor="#FFFFFF" class="normaltxtmidb2"><select name="cboColor" class="txtbox" id="cboColor" style="width:70px" >
		<option></option>
		<?php
	$SQL = "SELECT distinct
styleratio.strColor
FROM styleratio
WHERE
styleratio.intStyleId =  '$styleId'
			";
	echo $SQL;
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["strColor"] ."\">" . $row["strColor"] ."</option>" ;
	}
	?>
    </select></td>
	
	<?php
	$SQL = "SELECT distinct
styleratio.strSize
FROM styleratio
WHERE
styleratio.intStyleId =  '$styleId'
			";
	//echo $SQL;
	$result = $db->RunQuery($SQL);
	$sizeCount = (int)mysql_num_rows($result)+16;
	while($row = mysql_fetch_array($result))
	{
		

	?>
    <td bgcolor="#FFFFFF" class="normaltxtmidb2"><input onblur="calculateSizeTotal(this);" onkeypress="return CheckforValidDecimal(this, 4,event);" name="txtSize" type="text" class="txtbox" id="txtSize" size="10"></td>
	
	<?php
	}
	?>
    <td bgcolor="#FFFFFF" class="normaltxtmidb2"><input onfocus="this.blur();" name="txtPscCtn" type="text" class="txtbox" id="txtPscCtn" size="10"></td>
    <td bgcolor="#FFFFFF" class="normaltxtmidb2"><input onfocus="this.blur();" name="txtTotal" type="text" class="txtbox" id="txtTotal" size="10"></td>
    <td bgcolor="#FFFFFF" class="normaltxtmidb2"><input onblur="loopCalculate();" onkeypress="return CheckforValidDecimal(this, 4,event);" name="txtGrossWgt" type="text" class="txtbox" id="txtGrossWgt" size="15"></td>
    <td bgcolor="#FFFFFF" class="normaltxtmidb2"><input onblur="loopCalculate();"  onkeypress="return CheckforValidDecimal(this, 4,event);" name="txtNetWgt" type="text" class="txtbox" id="txtNetWgt" size="15"></td>
    <td bgcolor="#FFFFFF" class="normaltxtmidb2"><input onkeypress="return CheckforValidDecimal(this, 4,event);" name="txtNetNetWgt" type="text" class="txtbox" id="txtNetNetWgt" size="15"></td>
  </tr>
  <tr>
    <td height="18" colspan="3" bgcolor="#FFFFFF" ><img src="../images/addnew2.png" alt="add new" name="butAddColor" width="112" height="18" class="mouseover" id="butAddColor" onclick="addNewRow()" /></td>
  </tr>
</table>

