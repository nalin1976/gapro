<?php
	session_start();
		include "../Connector.php";
	$backwardseperator = "../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Payment Voucher</title>

<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="calendar.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />

<style type="text/css">
<!--
body {
	background-color: #FFF;
	
}
-->
</style>

<style type="text/css">
<!--
#tblSample td, th { padding: 0.5em; }
.classy0 { background-color: #234567; color: #89abcd; }
.classy1 { background-color: #89abcd; color: #234567; }
-->
</style>


<script language="javascript" type="text/javascript" src="paymentVoucher.js"></script>
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>



</head>
<body >
<form name="frmPayment" id="frmPayment" action="paymentVoucher.php" method="post">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include '../Header.php'; ?></td>
	</tr> 
</table>
<div class="main_bottom_center">
	<div class="main_top"><div class="main_text">Payment Voucher</div></div>
<div class="main_body">
<table width="70%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><table width="90%" border="0">
      <tr>
        <td valign="top" >
          <table width="946" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>
              <fieldset style="-moz-border-radius: 5px;">
              <table width="100%" border="0" class="">
          		<tr>
		            <td width="7%" bgcolor="#FFFFFF" class="normalfnt">Supplier</td>
		            <td width="28%" bgcolor="#FFFFFF" class="normalfnt"><select name="cboSupliers" class="txtbox" id="cboSupliers" style="width:250px" onchange="getScheduals(),getDets();" >
              <?php
					$strSQL="SELECT strSupplierID,strTitle AS strSupName FROM suppliers WHERE intStatus=1 ORDER BY strTitle";
					$result = $db->RunQuery($strSQL);
		
					echo "<option value=\"". "" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strSupName"] ."</option>" ;
					}

				?>
            </select></td>
            <td bgcolor="#FFFFFF" class="normalfnt">Date</td>
            <td bgcolor="#FFFFFF" class="normalfnt"><input name="txtDate" type="text" class="txtbox" id="txtDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo date("Y-m-d");?>"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
			<td width="14%" class="normalfnt">Payment Type</td>
            <td width="18%"   bgcolor="#FFFFFF" class="normalfnt">
            <!--<table width="200" height="40" border="0" cellpadding="0" cellspacing="0" class="containers">
              <tr>
                <td height="21" colspan="5" align="center" class="normalfntBtab">Payment Types </td>
              </tr>
              <tr>
                <td width="61" >&nbsp;</td>
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
                <td width="104" class="containers" ><input name="rdoType" type="radio" <?php echo $checkedS; ?> value="S" id="rdoStyle" onclick="pageRefresh();" />
                    <span class="containers">Style </span></td>
                <td width="62" class="containers" >&nbsp;</td>
                <td width="75" class="containers" ><input name="rdoType" type="radio" <?php echo $checkedG; ?> value="G" id="rdoGeneral" onclick="pageRefresh();" />
                    <span class="containers">General </span></td>
                <td width="45" >&nbsp;</td>
              </tr>
              <tr>
                <td >&nbsp;</td>
                <td class="containers" ><input name="rdoType" type="radio" <?php echo $checkedB; ?> value="B" id="rdoBulk" onclick="pageRefresh();"/>
                    <span class="containers">Bulk </span></td>
                <td class="containers" >&nbsp;</td>
                <td class="containers" ><input name="rdoType" type="radio" <?php echo $checkedW; ?> value="W" id="rdoWash"  onclick="pageRefresh();"/>
                    <span class="containers">Wash </span></td>
                <td >&nbsp;</td>
              </tr>
            </table>-->
			<?php 
			  $type = $_POST["cboPaymentType"];
			  $checked	= "selected=\"selected\""; 
		  ?>
		  <select name="cboPaymentType" id="cboPaymentType" onchange="pageRefresh();" style="width:75px;">
		  	<option value="S" <?php if($type=="S"){ echo $checked;} ?>>Style</option>
			<option value="G" <?php if($type=="G"){ echo $checked;} ?>>General</option>
			<option value="B" <?php if($type=="B"){ echo $checked;} ?>>Bulk</option>
			<option value="W" <?php if($type=="W"){ echo $checked;} ?>>Wash</option>
		  </select>	
			</td>
            </tr>
          <tr>
            <td bgcolor="#FFFFFF" class="normalfnt">Batch No</td>
            <td bgcolor="#FFFFFF" class="normalfnt"><select name="cboBatchNo" class="txtbox" id="cboBatchNo" style="width:250px" onchange="getBank()">
              <?php
					$strSQL="SELECT intBatch,strDescription FROM batch WHERE intBatchType='2' ORDER BY strDescription";
					$result = $db->RunQuery($strSQL);
		
					echo "<option value=\"". "0" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"". $row["intBatch"] ."\">" . $row["strDescription"] ."</option>" ;
					}
				?>
            </select></td>
            <td width="4%" bgcolor="#FFFFFF" class="normalfnt">Bank</td>
            <td width="29%" bgcolor="#FFFFFF" class="normalfnt"><!--<input name="txtBank" type="text" class="txtbox" id="txtBank" size="20" />-->
            

			<select name="txtBank" class="txtbox" id="txtBank" style="width:200px" >
              <?php
					$strSQL="SELECT intBranchId, strName FROM branch where intStatus=1 order by strName;";
					$result = $db->RunQuery($strSQL);
		
					echo "<option value=\"". "0" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"". $row["intBranchId"] ."\">" . $row["strName"] ."</option>" ;
					}
				?>
            </select>
              <input name="txtBankCode" type="text" class="txtbox" id="txtBankCode" size="1" style="visibility:hidden" /></td>
			  <td  bgcolor="#FFFFFF" class="normalfnt">Exchange Rate</td>
			  <td  bgcolor="#FFFFFF" class="normalfnt"><input type="text" style="text-align:right;width:75px;" readonly="readonly" id="txtExtRange" /></td>
            </tr>
          <tr>
            <td bgcolor="#FFFFFF" class="normalfnt">Description</td>
            <td bgcolor="#FFFFFF" class="normalfnt"><input name="txtDescription" type="text" class="txtbox" id="txtDescription" value="" style="width:248px" /></td>
            <td bgcolor="#FFFFFF" class="normalfnt">&nbsp;</td>
            <td bgcolor="#FFFFFF" class="normalfnt"><input type="hidden" id="hdnVId" /></td>
			<td bgcolor="#FFFFFF" class="normalfnt">Entry No</td>
            <td bgcolor="#FFFFFF" class="normalfnt"><input type="text" value="" name="txtEntryNo" id="txtEntryNo"  style="text-align: right; width: 75px;"/></td>
            </tr>
        </table>
        </fieldset>
        </td>
              </tr>
          </table>
          </td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>
    
    <table width="100%" border="0" class="">
      <tr>
        <td width="11%" bgcolor="#D5F1A9" class="containers">AccPac ID</td>
        <td width="22%" bgcolor="#D5F1A9" class="containers"><span class="containers">
          <input name="txtAccPacID" type="text" class="txtbox" id="txtAccPacID" size="15" onfocus="setSelect(this)"/>
        </span></td>
        <td width="13%" bgcolor="#D5F1A9" class="containers"><span class="containers">Cheque/Draft No</span></td>
        <td width="14%" bgcolor="#D5F1A9" class="containers"><span class="containers">
          <input name="txtChequeNo" type="text" class="txtbox" id="txtChequeNo" size="20" onfocus="setSelect(this)"/>
        </span></td>
        <td width="6%" bgcolor="#D5F1A9" class="containers">Account</td>
        <td width="12%" bgcolor="#D5F1A9" class="containers"><span class="containers">
          <input name="txtAmount" type="text" class="txtbox" id="txtAmount" value="CLER" size="12"  style="text-align:center" onfocus="setSelect(this)" />
        </span></td>
        <td width="9%" bgcolor="#D5F1A9" class="containers">Tax Code</td>
        <td width="13%" bgcolor="#D5F1A9" class="containers"><span class="containers">
          <input name="txtTaxCode" type="text" class="txtbox" id="txtTaxCode" value="-" size="18" onfocus="setSelect(this)" />
        </span></td>
      </tr>
      <tr>
        <td bgcolor="#D5F1A9" class="containers">Schedule No </td>
        <td bgcolor="#D5F1A9" class="containers"><select name="cboSchedual" class="txtbox" id="cboSchedual" style="width:200px" onchange="loadInvoiceSchedual()">
        </select></td>
        <td bgcolor="#D5F1A9" class="containers"><span class="containers">Source Code</span></td>
        <td bgcolor="#D5F1A9" class="containers"><span class="containers">
          <select name="cbosearch6" class="txtbox" id="cbosearch6" style="width:80px">
            <option value="0"></option>
            <option value="2">OB</option>
            <option value="2">PY</option>
            <option value="2">RC</option>
            <option value="2">RV</option>
            <option value="2">SO</option>
            <option value="2">TR</option>
            <option value="2">VD</option>
          </select>
        </span></td>
        <td bgcolor="#D5F1A9" class="containers">Currency</td>
        <td bgcolor="#D5F1A9" class="containers"><span class="containers">
          <select name="cboCurrency" class="txtbox" id="cboCurrency" style="width:105px">
            <?php
						$strSQL="select c.intCurID,c.strCurrency 
								from currencytypes  c
								inner join exchangerate exr on exr.currencyID=c.intCurID
								where c.intStatus =  '1' AND  exr.intStatus =  '1' order by strCurrency;";
						$result = $db->RunQuery($strSQL);
			
						echo "<option value=\"". "0" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"". $row["intCurID"] ."\">" . $row["strCurrency"] ."</option>" ;
						}
					?>
          </select>
        </span></td>
        <td bgcolor="#D5F1A9" class="containers">Total Amount</td>
        <td bgcolor="#D5F1A9" class="containers"><span class="containers">
          <input name="txtTotalAmont" type="text" class="txtbox" id="txtTotalAmont" size="18" style="text-align:center" disabled="disabled" />
        </span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" height="213" border="0" cellpadding="0" cellspacing="0">
<!--      <tr>
        <td height="17" bgcolor="#9BBFDD" class="normalfnth2"><div align="center">BULK PO's</div></td>
        </tr>
-->      
<tr>
        <td><div id="divInvsList" style="overflow:scroll; height:210px; width:950px;">
          <table width="930" cellpadding="0" cellspacing="0" id="tblInvoice">
		  	<thead>
            <tr>
              <td width="5%" height="20" bgcolor="#498CC2" class="grid_header"><input type="checkbox" onclick="chkUnchk(this);"/></td>
			  <td width="14%" bgcolor="#498CC2" class="grid_header">Schedule No</td>
              <td width="14%" bgcolor="#498CC2" class="grid_header">Invoice No</td>
              <td width="16%" bgcolor="#498CC2" class="grid_header">Total Amount</td>
              <td width="16%" bgcolor="#498CC2" class="grid_header">Paid Amount</td>
              <td width="17%" bgcolor="#498CC2" class="grid_header">Balance</td>
              <td width="18%" bgcolor="#498CC2" class="grid_header">Pay Amount</td>
              <td width="15%" bgcolor="#498CC2" class="grid_header">Advance</td>
             <td width="15%" bgcolor="#498CC2" class="grid_header">Currency</td>
            </tr>
			</thead>
			<tbody>
			</tbody>
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor=""><table width="100%" border="0">
      <tr>
        <td width="21%">&nbsp;</td>
        <td width="11%"><img src="../images/new.png" class="mouseover" onclick="clearPayementVoucherIF()" /></td>
        <td width="9%"><img src="../images/save.png" alt="Save" class="mouseover" id="imgSave"  onclick="paymentVoucherSave()" /></td>
        <td width="12%"><img src="../images/report.png" class="mouseover"  onclick="voucherReport()" /></td>
        <td width="9%"><img src="../images/search.png" class="mouseover"  onclick="paymentVoucherReport()" /></td>
        <td width="11%"><a href="../main.php"><img src="../images/close.png" alt="close"  border="0" class="mouseover" /></a></td>
        <td width="27%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</div>
</div>
</form>
</body>
</html>
