<?php
	session_start();
	include "../../Connector.php";
	$backwardseperator = "../../";
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro:Advance Payments</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../js/jquery-ui-1.8.9.custom.css"/>
<link rel="stylesheet" href="mootools/SexyAlertBox/sexyalertbox.css" type="text/css" media="all" />
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../../javascript/jquery.js" type="text/javascript"></script>
</head>

<!--onload="initializeTheInterface()"-->
<body onload="grid_fix_header_poList();">

<table width="100%" border="0" align="center" >
  <tr>
    <td id="tdHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom_center">
	<div class="main_top">
		<div class="main_text">Advance Payments<span class="vol"></span><span id="advancePayments_popup_close_button"></span></div>
	</div>
	<div class="main_body">
<form id="frmAdvance" name="frmAdvance" method="post" action="advancedpayment.php" >
<table align="center" width="952" height="500" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">

<tr>
<td width="471" height="118"><div  style=" height:110px; width:425px;" class="bcgl1">
<table width="420" cellpadding="0" cellspacing="0" >
<tr>
<td></td>
 <td width="81" height="43" class="normalfnt">&nbsp;Supplier</td>
          <td width="323"  colspan="2"><select name="cboSuppliers" class="txtbox" id="cboSuppliers" onchange="findSupPOs();loadBatchesAccordingToSupCurrency();" style="width:310px">
          <?php
				//$strSQL="SELECT strSupplierID,strTitle AS strSupName FROM suppliers WHERE intStatus=1 ORDER BY strTitle";
				
				$strSQL="SELECT distinct
							suppliers.strSupplierID,
							suppliers.strTitle as strSupName
							FROM
							purchaseorderheader
							Inner Join suppliers ON purchaseorderheader.strSupplierID = suppliers.strSupplierID
							WHERE suppliers.intStatus=1 and purchaseorderheader.strPayTerm = '1'
							ORDER BY
							suppliers.strTitle ASC";
				$result = $db->RunQuery($strSQL);
	
				echo "<option value=\"". "0" ."\">" . "" ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strSupName"] ."</option>" ;
				}
			
			?>
		  
		  </select></td>
</tr>

<tr>
<td width="14"></td>
<td height="58" class="normalfnt">&nbsp;Description</td>
<td>
<textarea name="txtDescription" cols="55" rows="2" class="txtbox" id="txtDescription" style="width:310px;"></textarea>
</td>
</tr>
</table>
</div></td>

<td width="481"><div id="divTaxType" style="height:110px; width:480px; " class="bcgl1">
<table width="480" height="103" border="0" cellpadding="0" cellspacing="0" class="normaltxtmidb2" id="">
<tr>
<td width="26"></td>
<td width="114" height="23" class="normalfnt">&nbsp;Batch No</td>
<td width="133" align="left"><select name="cboBatchNo" class="txtbox" id="cboBatchNo" style="width:100px" onchange="loadExchangeRate(this)"><!--,setPOValue(),findSupPOs();-->
            <?php 
				$strSQL="SELECT intBatch,strDescription FROM batch  where intBatchType='2' ORDER BY strDescription";
				$result = $db->RunQuery($strSQL);
	
				echo "<option value=\"". "0" ."\">" . "" ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"". $row["intBatch"] ."\">" . $row["strDescription"] ."</option>" ;
				}
			
			
			
			?>
          </select></td>
		  
		  <td width="115" class="normalfnt"></td>
		  <td width="92" align="left"> <!--<input name="txtTaxAmount"  style="text-align:right;width:70px"  disabled="disabled" id="txtTaxAmount" type="text" class="txtbox"  size="20" />--></td>
</tr>	

<tr>
<td></td>
<td width="114" height="20" class="normalfnt">&nbsp;Payment Type</td>
<td width="133" align="left">		  <select name="cboPaymentType" id="cboPaymentType" onchange="pageRefresh();" style="width:100px;">
		  	<option value="S" <?php if($type=="S"){ echo $checked;} ?>>Style</option>
			<option value="G" <?php if($type=="G"){ echo $checked;} ?>>General</option>
			<option value="B" <?php if($type=="B"){ echo $checked;} ?>>Bulk</option>
			<option value="W" <?php if($type=="W"){ echo $checked;} ?>>Wash</option>
		  </select>	</td>
		  
		  <td width="115" class="normalfnt" align="left" >&nbsp;Po Amount </td>
		  <td width="92" align="left"> <input name="txtPOAmount"  style="text-align:right;width:70px"  id="txtPOAmount" type="text" class="txtbox"
		    size="20"    onkeyup="changePOamt(this.value)"/></td>
</tr>	

<tr>
<td></td>
<td height="21" class="normalfnt">&nbsp;Exchange Rate</td>
<td align="left"><input type="text" name="txtExRate" id="txtExRate" style="text-align:right; width:98px;"  onkeypress="return CheckforValidDecimal(this.value, 3,event);" /></td>
		  <td width="115" class="normalfnt" align="left">&nbsp;Amount + NBT</td>
		  <td width="92" align="left"><input name="txtcommission" type="text" class="txtbox" id="txtcommission" onkeypress="return CheckforValidDecimal(this.value,1,event);" onchange="CalculateTotalInvoiceAmount();" style="text-align: right;width:70px" disabled="disabled"/> </td>
</tr>

<tr>
<td></td>
<td class="normalfnt">&nbsp;Currency</td>
<td align="left"><select name="cboCurrencyTo" class="txtbox" id="cboCurrencyTo" style="width:100px" disabled="true">
            <?php
			$strSQL="SELECT strCurrency,dblRateq,intCurID  FROM currencytypes WHERE intStatus=1";
			$result = $db->RunQuery($strSQL);
			
			echo "<option value=\"". "0" ."\">" . "" ."</option>" ;
			while($row = mysql_fetch_array($result))
			{
				echo "<option value=\"". $row["intCurID"] ."\">" . $row["strCurrency"] ."</option>" ;
			}
		?>
          </select></td>
		  <td width="115" class="normalfnt">&nbsp;Tax Amount</td>
		  <td width="92" align="left"> <input name="txtTaxAmount"  style="text-align:right;width:70px"  disabled="disabled" id="txtTaxAmount" type="text" class="txtbox"  size="20" /></td>
</tr>

<tr>
<td></td>
<td class="normalfnt">&nbsp;Draft No</td>
<td align="left"><input name="txtDraftNo" style="text-align:right;width:98px;" type="text"  value="0" class="txtbox" id="txtDraftNo" onkeypress="return CheckforValidDecimal(this.value,0,event);" maxlength="20" /></td>
<td class="normalfnt">&nbsp;Total Amount</td>
<td align="left"><input name="txtPOTotalAmount"  style="text-align:right;width:70px;"   disabled="disabled" type="text" class="txtbox" id="txtPOTotalAmount" size="10" /></td>
</tr>



</table>
</div></td>
</tr>

<tr>
<td>&nbsp;</td>
</tr>

  <tr><td colspan="2" style="border:1px solid #FAD163;">
<table width="952">
  <tr>
<td width="90" class="normalfnt">&nbsp;Bank Charges</td>
<td width="131" align="left"><input name="txtBankCharge" style="text-align:right;width:70px;" type="text"  class="txtbox" id="txtBankCharge" onkeypress="return CheckforValidDecimal(this.value,0,event);" maxlength="20"  onkeyup="setPOValue();"/></td>
<td width="119" class="normalfnt">&nbsp;Handling Charges</td>
<td width="139" align="left"><input name="txtHandleCharge"  style="text-align:right;width:70px;"  type="text" class="txtbox" id="txtHandleCharge" size="10" onkeyup="setPOValue();"/></td>
<td width="112" class="normalfnt">&nbsp;Freight Charges</td>
<td width="126" align="left"><input name="txtFreightCharge" style="text-align:right;width:98px;" type="text" class="txtbox" id="txtFreightCharge" onkeypress="return CheckforValidDecimal(this.value,0,event);" maxlength="20" onkeyup="setPOValue();"/></td>
<td width="112" class="normalfnt">&nbsp;Other Charges</td>
<td width="87" align="left"><input name="txtOtherCharge"  style="text-align:right;width:70px;"   type="text" class="txtbox" id="txtOtherCharge" size="10" onkeyup="setPOValue();"/></td>
</tr></table>
 </td></tr>
 
 <tr>
<td>&nbsp;</td>
</tr>
 
 
<tr>
<td height="21" align="center" style="vertical-align:bottom" class="mainHeading2">GL Account Details &nbsp;&nbsp;<img src="../../images/showallgls.png" alt="Show All GLS" id="cmdShowGLs"  onclick="ShowAllGLAccounts()" style="vertical-align:middle">&nbsp;&nbsp;<input type="text" style="width:100px;text-align:right;" id="txtGLTotal" name="txtGLTotal" onkeypress="return CheckforValidDecimal(this.value, 3,event)" readonly="readonly" /></td>
<td class="mainHeading2" align="center" valign="bottom" style="width:100px;">Tax Details</td>
</tr>
 <tr style="width:1px;"><td></td></tr>
  <tr>
    <td width="471" height="118"><div id="divconsOfSelGLs" style="overflow: -moz-scrollbars-vertical; height:120px; width:425px;" class="bcgl1">
<table width="420" cellpadding="0" cellspacing="0" id="tblGLAccs" name="tblGLAccs">
	<thead>
		<tr class="mainHeading4">
		<td width="20" height="22"><input type="checkbox" onclick="chkUnchkAll(this,'tblGLAccs');"/></td>
		<td width="82" height="22">GL Acc</td>
		<td width="222" >Description</td>
		<td width="94">Amount</td>
		</tr>
	</thead>
	<tbody></tbody>
</table>
</div></td>
    <td width="481"><div id="divTaxType" style="overflow: -moz-scrollbars-vertical; height:120px; width:480px; " class="bcgl1">
<table width="480" height="25" border="0" cellpadding="0" cellspacing="0" class="normaltxtmidb2" id="tblTax">
	<thead>
		<tr class="mainHeading4">
			<td height="20" width="20" ><input type="checkbox" onclick="chkUnchkAll(this,'tblTax');" /></td>
			<td width="130"  >Tax</td>
			<td width="86"  >Rate</td>
			<td  width="167">Value</td>
			<td width="77">Tax GL</td>
		</tr>
	</thead>
	<tbody >
<?php 
	$strSQL="SELECT
			taxtypes.strTaxTypeID,
			taxtypes.strTaxType,
			taxtypes.dblRate,
			gla.GLAccAllowNo,
			concat(gl.strAccID,'',c.strCode) as taxCode
			FROM taxtypes
			LEFT join glallowcation gla on gla.GLAccAllowNo=taxtypes.intGLId
			LEFT join glaccounts gl on gl.intGLAccID=gla.GLAccNo
			LEFT join costcenters c on c.intCostCenterId = gla.FactoryCode
			WHERE taxtypes.intStatus = '1'";
	$result=$db->RunQuery($strSQL);
	$cls="";
	$rc=0;
	while($row=mysql_fetch_array($result)){ 
		$GLAccAllowNo = ($row["GLAccAllowNo"]==""?"0":$row["GLAccAllowNo"]);
		$taxCode	  = ($row["taxCode"]==""?"-":$row["taxCode"]);
	if($rc%2==0){$cls="grid_raw";}else{$cls="grid_raw2";}?>
		<tr>
		<td class="<?php echo $cls;?>" id="<?php echo $row['strTaxTypeID']; ?>"><input type="checkbox" onclick="setTaxValue(this),setLineNumber();" /></td>
		<td class="<?php echo $cls;?>" style="text-align:left;"><?php echo $row['strTaxType']; ?></td>
		<td class="<?php echo $cls;?>" style="text-align:right;"><?php echo $row['dblRate']; ?></td>
		<td class="<?php echo $cls;?>"><input type="text" style="text-align:right;width:50px;" onkeypress="return isNumberKey(event,this.value);" onkeyup="setTaxValueChange();" maxlength="20"/></td>
		<td  class="<?php echo $cls;?>" id="<?php echo $GLAccAllowNo; ?>"><?php echo $taxCode; ?></td>
		</tr>
<?php $rc++; }?>
	</tbody>
</table>
</div></td>
  </tr>



  <tr>
    <td colspan="2"><div id="divPOs" class="bcgl1">
	<table width="957">
	<tr>
	<td class="mainHeading2" align="center" valign="bottom">Purchase Order Details</td>
	</tr>
	</table>
<table width="934"  cellpadding="0" cellspacing="0" id="tblPOList">
	<thead>
		<tr class="mainHeading4">
		<td width="23"><input type="checkbox" onclick="chkUnchkAll(this,'tblPOList');" /></td>
		<td width="72" height="25" >PO NO</td>
		<td width="100">Currency</td>
		<td width="144">PO Amount</td>
		<td width="144">PO Paid Amount</td>
		<td width="147">PO Balance</td>
		<td width="144">Pay Amount</td>
		<td width="75">Pay Term</td>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
</div></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="">
<table width="100%" border="0">
<tr>
<td width="24%">&nbsp;</td>
<td width="11%"><img src="../../images/new.png" alt="new" class="mouseover" onclick="clearAll()" /></td>
<!--<td width="11%"><img src="../images/cal.png" alt="close" class="mouseover"  onclick="setPOValue()" /></td>-->
<td width="10%"><img src="../../images/save.png"  alt="Save" class="mouseover"  onclick="formValidation()" id="imgSave"  /></td>

<td width="11%"><a target="_blank"><img  src="../../images/report.png" alt="report" class="mouseover"  onclick="AdvancePaymentReport()"  /></a></td>
<td width="11%" ><a href="../../main.php"><img src="../../images/close.png" alt="close"  border="0" class="mouseover" onclick="advclose()" /></a></td>
<td width="25%">&nbsp;</td>
</tr>
</table>	</td>
  </tr>
  
</table>
</form>
</div>
</div>

</body>
<script src="../../js/jquery.fixedheader.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="advancepayment.js"></script>
</html>
