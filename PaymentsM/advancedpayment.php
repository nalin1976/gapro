<?php
	session_start();
	include "../Connector.php";
	$backwardseperator = "../";
	$report_companyId=$_SESSION['FactoryID'];

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro:Advance Payments</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../js/jquery-ui-1.8.9.custom.css"/>
<link rel="stylesheet" href="mootools/SexyAlertBox/sexyalertbox.css" type="text/css" media="all" />
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="../javascript/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.7.2.custom.min.js"></script>
<script language="javascript" type="text/javascript" src="advancepayment.js"></script>
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



<body onload="initializeTheInterface()">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="tdHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom_center">
	<div class="main_top"ad>
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
          <td width="13" height="24" class="normalfnt">&nbsp;</td>
          <td width="90" class="normalfnt">Supplier</td>
          <td  colspan="2"><select name="cboSuppliers" class="txtbox" id="cboSuppliers" onchange="" style="width:348px">
          <?php
		       
		       $type = $_POST["rdoType"];
			   if($type == ''){
				$type = 'S';   
			   }
		       if($type=='S')
			   {
						$checkedS	= "checked=\"checked\"";
					
					     
				$strSQL="SELECT distinct
							suppliers.strSupplierID,
							suppliers.strTitle as strSupName
							FROM
							purchaseorderheader
							Inner Join suppliers ON purchaseorderheader.strSupplierID = suppliers.strSupplierID
							WHERE suppliers.intStatus=1
							ORDER BY
							suppliers.strTitle ASC";
				
				}
				
				else if($type=='B')
				{
						$checkedB	= "checked=\"checked\"";
						$strSQL="SELECT distinct
								suppliers.strSupplierID,
								suppliers.strTitle as strSupName
								FROM
								bulkpurchaseorderheader
								Inner Join suppliers ON bulkpurchaseorderheader
								.strSupplierID = suppliers.strSupplierID
								WHERE suppliers.intStatus=1
								ORDER BY
								suppliers.strTitle ASC";
				}
				else if($type=='G')
				{
							$checkedG	= "checked=\"checked\"";
							$strSQL="SELECT distinct
							suppliers.strSupplierID,
							suppliers.strTitle as strSupName
							FROM
							generalpurchaseorderheader 
							Inner Join suppliers ON generalpurchaseorderheader.intSupplierID = suppliers.strSupplierID
							WHERE suppliers.intStatus=1
							ORDER BY
							suppliers.strTitle ASC";

				}
				$result = $db->RunQuery($strSQL);
				echo "<option value=\"". "0" ."\">" . "" ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strSupName"] ."</option>" ;
				}
			
			?>
		  
		  </select></td>
          <td width="481" rowspan="3" ><div id="ss" style="height:100px"><table width="479" height="40" border="0" cellpadding="0" cellspacing="0" class="normalfnt2BITAB">
              <tr>
                <td height="21" colspan="5" align="center" class="normalfntBtab">Payment Types </td>
                </tr>
              <tr class="containers">
                <td width="133" >&nbsp;</td>
				<?php 
					 $type = $_POST["rdoType"];
					if($type=='G')
						$checkedG	= "checked=\"checked\"";
					else if($type=='W')
						$checkedW	= "checked=\"checked\"";
					else if($type=='B')
						$checkedB	= "checked=\"checked\"";
					else
						$checkedS	= "checked=\"checked\"";
				?>
                <td width="98" class="normalfnth2B" >
                  <input name="rdoType" type="radio" <?php echo $checkedS; ?> value="S" id="rdoStyle" onclick="pageRefresh();" />
                  <span class="normalfntSMB">Style                </span></td>
                <td width="16" class="normalfnth2B" >&nbsp;</td>
                <td width="98" class="normalfnth2B" >
				<input name="rdoType" type="radio" <?php echo $checkedG; ?> value="G" id="rdoGeneral" onclick="pageRefresh();" />
                  <span class="normalfntSMB">General </span></td>
				<td width="132" >&nbsp;</td>
              </tr>
              <tr class="containers">
                <td >&nbsp;</td>
                <td class="normalfnth2B" >
				<input name="rdoType" type="radio" <?php echo $checkedB; ?> value="B" id="rdoBulk" onclick="pageRefresh();"/>
                  <span class="normalfntSMB">Bulk  </span></td>
                <td class="normalfnth2B" >&nbsp;</td>
                <td class="normalfnth2B" >
				<input name="rdoType" type="radio" disabled="disabled" <?php echo $checkedW; ?> value="W" id="rdoWash"  onclick="pageRefresh();"/>
                 <!-- <span class="normalfntSMB">Wash </span></td>-->
                <td >&nbsp;</td>
              </tr>
		            
                    </table>
          </div></td>
          </tr><tr>
		   <td width="13" height="24">&nbsp;</td>
        <td width="90"><span class="normalfnt">Currency</span></td>
        <td width="90"><select name="cboCurrencyTo" class="txtbox" id="cboCurrencyTo" style="width:150px" onchange="loadcurrency();findSupPOs();loadBatchAccCurr();">
          <?php
			$strSQL="SELECT strCurrency,intCurID FROM currencytypes WHERE intStatus=1";
			$result = $db->RunQuery($strSQL);
			
			echo "<option value=\"". "0" ."\">" . "" ."</option>" ;
			while($row = mysql_fetch_array($result))
			{
				echo "<option value=\"". $row["intCurID"] ."\">" . $row["strCurrency"] ."</option>" ;
			}
		?>
        </select></td>
        <td align="Left"><span class="normalfnt">Rate &nbsp;</span>		
		<input name="txtcurrency" style="text-align:center " width="90px" type="text"  value="0" class="txtbox" id="txtcurrency" /></td></tr>
        <tr>
          <td height="29" class="normalfnt">&nbsp;</td>
          <td height="27" class="normalfnt">Description</td>
          <td colspan="2"><textarea name="txtDescription" cols="52" rows="2" class="txtbox" id="txtDescription"></textarea></td>
          </tr>
        <tr>
          <td class="normalfnt" width="90" height="24">&nbsp;</td>
          <td class="normalfnt">Batch No</td>
          <td width="175"><select name="cboBatchNo" class="txtbox" id="cboBatchNo" style="width:150px" >
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
          <td width="191">
            <!--<input name="button" type="submit" class="tablezREDMid" id="cmdShowGLs" value="Show all GLS" onclick="showGLAccounts(true)"  />-->
            <img src="../images/showallgls.png" alt="Show All GLS" id="cmdShowGLs"  onclick="showGlPoup(<?php echo $report_companyId; ?>)"></td>
        </tr>
      </table>
    </div>      </td>
  </tr>
  
  <tr>
    <td width="471" height="118"><div id="divconsOfSelGLs" style="overflow: -moz-scrollbars-vertical; height:120px; width:442px;" class="bcgl1">
<table width="425" cellpadding="0" cellspacing="0" id="tblGLAccs" name=id="tblGLAccs">
<tr>
<td width="114" height="22" bgcolor="#498CC2" class="grid_header">GL Acc</td>
<td width="187" bgcolor="#498CC2" class="grid_header">Description</td>
<td width="234" bgcolor="#498CC2" class="grid_header">Amount</td>
</tr>

</table>
</div></td>
   <td width="481"><div id="divTaxType" style="overflow: -moz-scrollbars-vertical; height:120px; width:478px; " class="bcgl1">
<table width="464" height="25" border="0" cellpadding="0" cellspacing="0" class="normaltxtmidb2" id="tblTax">
<tr>
<td bgcolor="#498CC2" height="22" width="61" class="grid_header">*</td>
<td bgcolor="#498CC2" width="161"  class="grid_header">Tax</td>
<td bgcolor="#498CC2" width="111"  class="grid_header">Rate</td>
<td bgcolor="#498CC2" width="131"  class="grid_header">Value</td>
</tr>
</table>
</div></td>
  </tr>
  <tr>
    <td colspan="2"><table width="951" height="75" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
         <td width="11" height="24">&nbsp;</td>
        <td><span class="normalfnt" height="24">Draft No</span></td>
        <td><input name="txtDraftNo" style="text-align:LEFT" type="text"  value="0" class="txtbox" id="txtDraftNo" onclick="clearTextAll(this);"/></td>
        <td width="144"><span class="normalfnt">Freight Charges</span></td>
        <td width="180" class="normalfnt"><input name="txtFrightChargers"  style="text-align:right"   value="0.00" type="text" class="txtbox" id="txtFrightChargers" onchange="setPOValue()" onclick="clearTextAll(this);" onkeypress="return CheckforValidDecimal(this.value,1,event);" /></td>
         <td class="normalfnt">PO Amount</td>
        <td><span class="normalfnt">
          <input name="txtPOAmount"  style="text-align:right"  disabled="disabled" id="txtPOAmount" type="text" class="txtbox"  size="20" value="0.00"/>
        </span></td>
      </tr>
      <tr>
	   <td width="11" height="24">&nbsp;</td>
        <td><span class="normalfnt" height="24">Discount</span></td>
        <td><input name="txtDiscount" type="text"  style="text-align:right"  value="0.00" class="txtbox" id="txtDiscount" onchange="setPOValue()" onclick="clearTextAll(this);" onkeypress="return CheckforValidDecimal(this.value, 1,event);"/></td>
        <td><span class="normalfnt">Courier Charges</span></td>
        <td><input name="txtCourierChargers"  style="text-align:right"  type="text" class="txtbox" id="txtCourierChargers" value="0.00" onchange="setPOValue()" onclick="clearTextAll(this);"  onkeypress="return CheckforValidDecimal(this.value, 1,event);" /></td>
         <td><span class="normalfnt">Total Amount</span></td>
        <td><input name="txtPOTotalAmount"  style="text-align:right"   disabled="disabled" type="text" class="txtbox" id="txtPOTotalAmount" size="20" value="0.00" /></td>
        <td width="23">&nbsp;</td>
      </tr>
      <tr>
	    <td width="11" height="24">&nbsp;</td>
        <td><span class="normalfnt">Bank Charges</span></td>
        <td><input name="txtBankChargers"  style="text-align:right" value="0.00"  type="text" class="txtbox" id="txtBankChargers" onchange="setPOValue()" onclick="clearTextAll(this);" onkeypress="return CheckforValidDecimal(this.value, 1,event);"/></td>
        <td width="135"><span class="normalfnt">Tax Amount </span></td>
        <td width="140"><span class="normalfnt">
          <input name="txtTaxAmount"  style="text-align:right"  disabled="disabled" id="txtTaxAmount" type="text" class="txtbox"  size="20" />
        </span></td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>

  <tr>
    <td colspan="2"><div id="divPOs" style="overflow:none; height:130px; width:950px;" class="bcgl1">
<table width="950"  cellpadding="0" cellspacing="0" id="tblPOList">
<tr>
<td width="22" bgcolor="#498CC2" class="grid_header">*</td>
<td width="70" height="25" bgcolor="#498CC2" class="grid_header">PO NO</td>
<!--//<td width="14%" bgcolor="#498CC2" class="normaltxtmidb2">PO</td>-->
<td width="154" bgcolor="#498CC2" class="grid_header">Currency</td>
<td width="140" bgcolor="#498CC2" class="grid_header">PO Amount</td>
<td width="140" bgcolor="#498CC2" class="grid_header">PO Paid Amount</td>
<td width="98" bgcolor="#498CC2" class="grid_header">PO Balance</td>
<td width="98" bgcolor="#498CC2" class="grid_header">Pay Amount</td>
<td width="98" bgcolor="#498CC2" class="grid_header">According To Currency</td>
<td width="128" bgcolor="#498CC2" class="grid_header">Pay Term</td>
</tr>
</table>
</div></td>
  </tr>
  <tr>
<td colspan="2" bgcolor="">
<br />
<table width="100%" border="0">
<tr>
<td align="center"><img src="../images/new.png" alt="new" class="mouseover" onclick="clearAll()" />
<!--<img src="../images/cal.png" alt="close" class="mouseover"  onclick="setPOValue()" />-->
<img src="../images/save.png"  alt="Save" class="mouseover" id="savebutton" onclick="checkValues();"  />
<img src="../images/report.png" alt="report" class="mouseover"   onclick="ReportPrint()"  />
<a target="_blank"><img  src="../images/search.png" alt="report" class="mouseover"  onclick="AdvancePaymentReport()"  /></a>
<a href="../main.php"><img src="../images/close.png" alt="close"  border="0" class="mouseover" onclick="advclose()" /></a></td>
</tr>
</table></td>
  </tr>
  
</table>
</form>
</div>
</div>
</body>
<script src="../js/jquery.fixedheader.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="advancepayment.js"></script>
</html>
