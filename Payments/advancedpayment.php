<?php
	session_start();
	include "../Connector.php";
	$backwardseperator = "../";
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro:Advance Payments</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body 
{
	background-color: #FFF;
}
.style1 {color: #0000FF}
-->
</style>
</head>

<script language="javascript" type="text/javascript" src="advancepayment.js"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="../javascript/jquery.js" type="text/javascript"></script>
<!--onload="initializeTheInterface()"-->
<body >

<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
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
<table align="center" width="952" height="509" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td height="154" colspan="2"><?php #include "../Header.php"; ?>
      <div id="divdata" style="height:125px; width:950px;left:inherit " class="bcgl1">
      <table width="950" height="110" border="0" cellpadding="0" cellspacing="0" >
        <tr>
          <td width="8" height="24" class="normalfnt">&nbsp;</td>
          <td width="77" class="normalfnt">Supplier</td>
          <td  colspan="2"><select name="cboSuppliers" class="txtbox" id="cboSuppliers" onchange="findSupPOs()" style="width:341px">
          <?php
				//$strSQL="SELECT strSupplierID,strTitle AS strSupName FROM suppliers WHERE intStatus=1 ORDER BY strTitle";
				
				$strSQL="SELECT distinct
							suppliers.strSupplierID,
							suppliers.strTitle as strSupName
							FROM
							purchaseorderheader
							Inner Join suppliers ON purchaseorderheader.strSupplierID = suppliers.strSupplierID
							WHERE suppliers.intStatus=1
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
		  <td width="104" class="normalfnt">Batch No</td>
		  <td width="138" class="normalfnt"><select name="cboBatchNo" class="txtbox" id="cboBatchNo" style="width:100px" onchange="loadExchangeRate(this),getPos();"><!--,setPOValue(),findSupPOs();-->
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
		  <td width="96" class="normalfnt">Payment Type</td>
          <td width="161" >
		  <?php 
			  $type = $_POST["cboPaymentType"];
			  $checked	= "selected=\"selected\""; 
		  ?>
		  <select name="cboPaymentType" id="cboPaymentType" onchange="pageRefresh();" style="width:100px;">
		  	<option value="S" <?php if($type=="S"){ echo $checked;} ?>>Style</option>
			<option value="G" <?php if($type=="G"){ echo $checked;} ?>>General</option>
			<option value="B" <?php if($type=="B"){ echo $checked;} ?>>Bulk</option>
			<option value="W" <?php if($type=="W"){ echo $checked;} ?>>Wash</option>
		  </select>		  </td>
          </tr>
        <tr>
          <td height="29" class="normalfnt">&nbsp;</td>
          <td height="29" class="normalfnt">Description</td>
          <td colspan="2"><textarea name="txtDescription" cols="55" rows="2" class="txtbox" id="txtDescription"></textarea></td>
		  <td height="29" class="normalfnt">Exchange Rate</td>
		  <td height="29" class="normalfnt"><input type="text" name="txtExRate" id="txtExRate" style="width:100px; text-align:right;"onkeypress="return CheckforValidDecimal(this.value, 3,event);" /></td>
		  <td height="29" class="normalfnt">Currency</td>
		  <td height="29" class="normalfnt"><select name="cboCurrencyTo" class="txtbox" id="cboCurrencyTo" style="width:100px" disabled="true">
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
        </tr>
        <tr>
          <td  class="normalfnt">&nbsp;</td>
          <td class="normalfnt">&nbsp;</td>
          <td width="168"><input type="hidden" id="txtPaymentNo" /></td>
          <td width="198">
           
            <img src="../images/showallgls.png" alt="Show All GLS" id="cmdShowGLs"  onclick="showGlPoup()"></td>
			<td height="29" class="normalfnt">Entry Number </td>
			<td height="29" class="normalfnt"><input type="text" name="txtExRate2" id="txtExRate2" style="width:100px; text-align:right;" readonly="readonly" /></td>
        </tr>
      </table>
    </div>      </td>
  </tr>
  
  <tr>
    <td width="471" height="118"><div id="divconsOfSelGLs" style="overflow: -moz-scrollbars-vertical; height:120px; width:425px;" class="bcgl1">
<table width="420" cellpadding="0" cellspacing="0" id="tblGLAccs" name=id="tblGLAccs">
	<thead>
		<tr>
		<td width="20" height="22" bgcolor="#498CC2" class="grid_header"><input type="checkbox" onclick="chkUnchkAll(this,'tblGLAccs');"/></td>
		<td width="114" height="22" bgcolor="#498CC2" class="grid_header">GL Acc</td>
		<td width="187" bgcolor="#498CC2" class="grid_header">Description</td>
		<td width="234" bgcolor="#498CC2" class="grid_header">Amount</td>
		</tr>
	</thead>
	<tbody></tbody>
</table>
</div></td>
    <td width="481"><div id="divTaxType" style="overflow: -moz-scrollbars-horizonral; height:120px; width:480px; " class="bcgl1">
<table width="480" height="25" border="0" cellpadding="0" cellspacing="0" class="normaltxtmidb2" id="tblTax">
	<thead>
		<tr>
			<td bgcolor="#498CC2" height="20" width="15" class="grid_header"><input type="checkbox" onclick="chkUnchkAll(this,'tblTax');" /></td>
			<td bgcolor="#498CC2" width="100"  class="grid_header">Tax</td>
			<td bgcolor="#498CC2" width="50"  class="grid_header">Rate</td>
			<td bgcolor="#498CC2" width="40"  class="grid_header">Value</td>
		</tr>
	</thead>
	<tbody style="overflow:-moz-scrollbars-vertical; height:100px;">
<?php 
	$strSQL="SELECT strTaxTypeID,strTaxType,dblRate FROM taxtypes where intStatus='1' order by strTaxType";
	$result=$db->RunQuery($strSQL);
	$cls="";
	$rc=0;
	while($row=mysql_fetch_array($result)){ if($rc%2==0){$cls="grid_raw";}else{$cls="grid_raw2";}?>
		<tr>
		<td class="<?php echo $cls;?>" id="<?php echo $row['strTaxTypeID']; ?>"><input type="checkbox" onclick="setTaxValue(this),setLineNumber();" /></td>
		<td class="<?php echo $cls;?>" style="text-align:left;"><?php echo $row['strTaxType']; ?></td>
		<td class="<?php echo $cls;?>" style="text-align:right;"><?php echo $row['dblRate']; ?></td>
		<td class="<?php echo $cls;?>"><input type="text" style="text-align:right;width:50px;" onkeypress="return isNumberKey(event,this.value);" onkeyup="setTaxValueChange();" maxlength="20"/></td>
		</tr>
<?php $rc++; }?>
	</tbody>
</table>
</div></td>
  </tr>
  <tr>
    <td colspan="2"><table width="952" height="75" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="11" height="24">&nbsp;</td>
        <td width="104"><span class="normalfnt">Line No</span></td>
        <td width="211"><input type="text" name="txtlineno" id="txtlineno" value='0' style="width:50px;text-align:right;" readonly="readonly"/></td>
        <td width="144"><span class="normalfnt">Freight Charges</span></td>
        <td width="180" class="normalfnt"><input name="txtFrightChargers"  style="text-align:right"   value="0.0000" type="text" class="txtbox" id="txtFrightChargers" onchange="setPOValue()" onkeypress="return CheckforValidDecimal(this.value,3,event);" maxlength="20"/></td>
        <td width="135"><span class="normalfnt">Tax Amount </span></td>
        <td width="140"><span class="normalfnt">
          <input name="txtTaxAmount"  style="text-align:right"  disabled="disabled" id="txtTaxAmount" type="text" class="txtbox"  size="20" />
        </span></td>
      </tr>
      <tr>
	    <td width="11" height="24">&nbsp;</td>
        <td><span class="normalfnt" height="24">Draft No</span></td>
        <td><input name="txtDraftNo" style="text-align:right;width:140px;" type="text"  value="0" class="txtbox" id="txtDraftNo" onkeypress="return CheckforValidDecimal(this.value,0,event);" maxlength="20" /></td>
        <td><span class="normalfnt">Courier Charges</span></td>
        <td><input name="txtCourierChargers"  style="text-align:right" value="0.0000" type="text" class="txtbox" id="txtCourierChargers" onchange="setPOValue()" onkeypress="return CheckforValidDecimal(this.value, 3,event);" maxlength="20" /></td>
        <td class="normalfnt">PO Amount</td>
        <td><span class="normalfnt">
          <input name="txtPOAmount"  style="text-align:right"  disabled="disabled" id="txtPOAmount" type="text" class="txtbox"  size="20" />
        </span></td>
        <td width="23">&nbsp;</td>
      </tr>
      <tr>
	    <td width="11" height="24">&nbsp;</td>
        <td><span class="normalfnt" height="24">Discount</span></td>
        <td><input name="txtDiscount" type="text"  style="text-align:right;width:140px;"  value="0.0000" class="txtbox" id="txtDiscount" onchange="setPOValue()" onkeypress="return CheckforValidDecimal(this.value, 3,event);" maxlength="20"/></td>
        <td><span class="normalfnt">Other Charges</span></td>
        <td><input name="txtBankChargers"  style="text-align:right" value="0.0000"  type="text" class="txtbox" id="txtBankChargers" onchange="setPOValue()" onkeypress="return CheckforValidDecimal(this.value, 3,event);" maxlength="20"/></td>
        <td><span class="normalfnt">Total Amount</span></td>
        <td><input name="txtPOTotalAmount"  style="text-align:right"   disabled="disabled" type="text" class="txtbox" id="txtPOTotalAmount" size="20" /></td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
  	<td colspan="2">
		<table width="100%">
			<tr>
				<td width="33%" class="normalfnt">
					<table  width="100%">
						<tr>
							<td class="containers" colspan="4" style="text-align:center;">Freight Charges</td>
						</tr>
					</table>
					<div class="bcgl1" style="overflow:scroll;height:100px;">
						<table id="tblFreight">
							<thead>
								<tr>
									<td width="20" class="grid_header">*</td>
									<td width="100" class="grid_header">GL Acc Id</td>
									<td width="100" class="grid_header">Description</td>
									<td width="80" class="grid_header">Amount</td>
								</tr>
							</thead>
							<tbody>
							<?php $sqlF="SELECT glaccounts.strAccID,glaccounts.strDescription,companies.intCompanyID,companies.strAccountNo,glaccounts.intGLAccID 
										FROM glallowcation
										Inner Join glaccounts ON glallowcation.GLAccNo = glaccounts.intGLAccID
										Inner Join companies ON glallowcation.FactoryCode = companies.intCompanyID
										where glaccounts.intGLType=2 and glaccounts.intStatus='1' order by glaccounts.strDescription;";
								  $resF=$db->RunQuery($sqlF);
								  $cls="";
								  $c=0;
								  ($c%2==0)?$cls='grid_raw':$cls='grid_raw2';
								  while($rowF=mysql_fetch_array($resF)){?>
								  <tr>
								  	<td width="20" class="<?php echo $cls; ?>"><input type="checkbox" onclick="setCharges(this,document.getElementById('txtFrightChargers'),document.getElementById('tblFreight')),setLineNumber()" /></td>
									<td width="100" class="<?php echo $cls; ?>" id="<?php echo $rowF['intGLAccID'];?>" style="text-align:left;"><?php echo $rowF['strAccID']."".$rowF['strAccountNo'];?></td>
									<td width="100" class="<?php echo $cls; ?>" style="text-align:left;"><?php echo $rowF['strDescription'];?></td>
									<td width="80" class="<?php echo $cls; ?>"><input type="text" style="width:50px;text-align:right;" onkeypress="return CheckforValidDecimal(this.value, 3,event);" onkeyup="clckGLBox(this),setCharges(this,document.getElementById('txtFrightChargers'),document.getElementById('tblFreight'));" value="0" maxlength="20"/></td>
								 </tr>
							<?php $c++;}?>
							</tbody>
						</table>
					</div>
				
				</td>
				<td  width="33%" class="normalfnt">
						<table  width="100%">
							<tr>
								<td class="containers" colspan="4" style="text-align:center;">Courier Charges</td>
							</tr>
						</table>
					<div class="bcgl1" style="overflow:scroll;;height:100px;">
						<table id="tblCourier">
							<thead>
								<tr>
									<td width="20" class="grid_header">*</td>
									<td width="100" class="grid_header">GL Acc Id</td>
									<td width="100" class="grid_header">Description</td>
									<td width="80" class="grid_header">Amount</td>
								</tr>
							</thead>
							<tbody>
							<?php $sqlF="SELECT glaccounts.strAccID,glaccounts.strDescription,companies.intCompanyID,companies.strAccountNo,glaccounts.intGLAccID  
										FROM glallowcation
										Inner Join glaccounts ON glallowcation.GLAccNo = glaccounts.intGLAccID
										Inner Join companies ON glallowcation.FactoryCode = companies.intCompanyID
										where glaccounts.intGLType=4 and glaccounts.intStatus='1' order by glaccounts.strDescription;";
								  $resF=$db->RunQuery($sqlF);
								  $cls="";
								  $c=0;
								  ($c%2==0)?$cls='grid_raw':$cls='grid_raw2';
								  while($rowF=mysql_fetch_array($resF)){?>
								  <tr>
								  	<td width="20" class="<?php echo $cls; ?>"><input type="checkbox" onclick="setCharges(this,document.getElementById('txtCourierChargers'),document.getElementById('tblCourier')),setLineNumber();" /></td>
									<td width="100" class="<?php echo $cls; ?>" id="<?php echo $rowF['intGLAccID'];?>" style="text-align:left;"><?php echo $rowF['strAccID']."".$rowF['strAccountNo'];?></td>
									<td width="100" class="<?php echo $cls; ?>" style="text-align:left;"><?php echo $rowF['strDescription'];?></td>
									<td width="80" class="<?php echo $cls; ?>"><input type="text" style="width:50px;text-align:right;" onkeypress="return CheckforValidDecimal(this.value, 3,event);" onkeyup="clckGLBox(this),setCharges(this,document.getElementById('txtCourierChargers'),document.getElementById('tblCourier'));" value="0" maxlength="20"/></td>
								 </tr>
							<?php $c++;}?>
							</tbody>
						</table>
					</div>
				</td>
				<td  width="33%" class="normalfnt">
					<table  width="100%">
						<tr>
							<td class="containers" colspan="4" style="text-align:center;">Other Charges</td>
						</tr>
					</table>
					<div class="bcgl1" style="overflow:scroll;height:100px;">
						<table id="tblOther">
							<thead>
								
								<tr>
									<td width="20" class="grid_header">*</td>
									<td width="100" class="grid_header">GL Acc Id</td>
									<td width="100" class="grid_header">Description</td>
									<td width="80" class="grid_header">Amount</td>
								</tr>
							</thead>
							<tbody>
							<?php $sqlF="SELECT glaccounts.strAccID,glaccounts.strDescription,companies.intCompanyID,companies.strAccountNo,glaccounts.intGLAccID  
										FROM glallowcation
										Inner Join glaccounts ON glallowcation.GLAccNo = glaccounts.intGLAccID
										Inner Join companies ON glallowcation.FactoryCode = companies.intCompanyID where glaccounts.intGLType=5 and glaccounts.intStatus='1' order by glaccounts.strDescription;";
								  $resF=$db->RunQuery($sqlF);
								  $cls="";
								  $c=0;
								  ($c%2==0)?$cls='grid_raw':$cls='grid_raw2';
								  while($rowF=mysql_fetch_array($resF)){?>
								  <tr>
								  	<td width="20" class="<?php echo $cls; ?>"><input type="checkbox" onclick="setCharges(this,document.getElementById('txtBankChargers'),document.getElementById('tblOther')),setLineNumber();" /></td>
									<td width="100" class="<?php echo $cls; ?>" id="<?php echo $rowF['intGLAccID'];?>" style="text-align:left;"><?php echo $rowF['strAccID']."".$rowF['strAccountNo'];?></td>
									<td width="100" class="<?php echo $cls; ?>" style="text-align:left;"><?php echo $rowF['strDescription'];?></td>
									<td width="80" class="<?php echo $cls; ?>"><input type="text" style="width:50px;text-align:right;" onkeypress="return isNumberKey(event,this.value);" onkeyup="clckGLBox(this),setCharges(this,document.getElementById('txtBankChargers'),document.getElementById('tblOther'));" value="0" maxlength="20"/></td>
								 </tr>
							<?php $c++;}?>
							</tbody>
						</table>
					</div>
				
				
				</td>
			</tr>
		</table>
	</td>
  </tr>

  <tr>
    <td colspan="2"><div id="divPOs" style="overflow:scroll; height:130px; width:950px;" class="bcgl1">
<table width="933"  cellpadding="0" cellspacing="0" id="tblPOList">
	<thead>
		<tr>
		<td width="23" bgcolor="#498CC2" class="grid_header"><input type="checkbox" onclick="chkUnchkAll(this,'tblPOList');" /></td>
		<td width="72" height="25" bgcolor="#498CC2" class="grid_header">PO NO</td>
		<td width="158" bgcolor="#498CC2" class="grid_header">Currency</td>
		<td width="144" bgcolor="#498CC2" class="grid_header">PO Amount</td>
		<td width="144" bgcolor="#498CC2" class="grid_header">PO Paid Amount</td>
		<td width="147" bgcolor="#498CC2" class="grid_header">PO Balance</td>
		<td width="144" bgcolor="#498CC2" class="grid_header">Pay Amount</td>
		<td width="99" bgcolor="#498CC2" class="grid_header">Pay Term</td>
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
<td width="26%">&nbsp;</td>
<td width="11%"><img src="../images/new.png" alt="new" class="mouseover" onclick="clearAll()" /></td>
<!--<td width="11%"><img src="../images/cal.png" alt="close" class="mouseover"  onclick="setPOValue()" /></td>-->
<td width="11%"><img src="../images/save.png"  alt="Save" class="mouseover"  onclick="checkValues()" id="imgSave"  /></td>
<td width="11%"><img src="../images/report.png" alt="report" class="mouseover"  onclick="ReportPrint()"  /></td>
<td width="11%"><a target="_blank"><img  src="../images/search.png" alt="report" class="mouseover"  onclick="AdvancePaymentReport()"  /></a></td>
<td width="11%" ><a href="../main.php"><img src="../images/close.png" alt="close"  border="0" class="mouseover" onclick="advclose()" /></a></td>
<td width="26%">&nbsp;</td>
</tr>
</table>	</td>
  </tr>
  
</table>
</form>
</div>
</div>

</body>
</html>
