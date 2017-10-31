<?php
	session_start();
		include "../Connector.php";
	$backwardseperator = "../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Payment Voucher</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="calendar.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<link rel="stylesheet" type="text/css" href="../js/jquery-ui-1.8.9.custom.css"/>
<link rel="stylesheet" href="mootools/SexyAlertBox/sexyalertbox.css" type="text/css" media="all" />
<style>
.main_bottom_center1 {
	width:auto;
	height:auto;
	position : absolute;
	top : 150px;
	left:135px;
	background-color:#FFFFFF;
	border:1px solid;
	-moz-border-radius-bottomright:5px;
	-moz-border-radius-bottomleft:5px;
	border-bottom-color:#550000;
	border-top-color:#550000;
	border-left-color:#550000;
	background-color:#FFFFFF;
	border-right-color:#550000;
	padding-right:15px;
	padding-top:20px;
	padding-bottom:15px;
	-moz-border-radius-bottomright:5px;
	-moz-border-radius-bottomleft:5px;
	border-bottom:10px solid #550000;
}
</style>

<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
</head>
<body>
<form name="frmPayment" id="frmPayment" action="paymentVoucher.php" method="post">
  <table width="100%" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td height="6" colspan="2"><?php include '../Header.php'; ?></td>
    </tr>
  </table>
  <div class="main_bottom_center1">
    <div class="main_top">
      <div class="main_text">Payment Voucher</div>
    </div>
    <div class="main_body">
      <table width="100%">
        <table width="100%"  class="bcgl1" border="0">
          <tr>
            <td width="40%"><table width="100%" align="left">
                <tr>
                  <td width="18%" class="normalfnt">Supplier</td>
                  <td colspan="3"><select name="cboSupliers" class="txtbox" id="cboSupliers" style="width:241px" onchange="getScheduals();getDets();" >
                      <?php
					$strSQL="SELECT strSupplierID,strTitle AS strSupName FROM suppliers WHERE intStatus=1 ORDER BY strTitle";
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
                  <td width="24%" class="normalfnt">Schedule No </td>
                  <td width="23%"><select name="cboSchedual" class="txtbox" id="cboSchedual" style="width:70px" onchange="getDets()">
                    </select></td>
                  <td class="normalfnt" >Batch No</td>
                  <td width="34%"><select name="cboBatchNo" class="txtbox" id="cboBatchNo" style="width:70px" onchange="getBank()">
                      <?php
					$strSQL="SELECT intBatch,strDescription FROM batch WHERE intBatchType=2 AND intCompID=".$_SESSION["FactoryID"]." ORDER BY strDescription";
					$result = $db->RunQuery($strSQL);
		
					echo "<option value=\"". "0" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"". $row["intBatch"] ."\">" . $row["strDescription"] ."</option>" ;
					}
				?>
                    </select></td>
                </tr>
                <tr>
                  <td class="normalfnt">Description</td>
                  <td colspan="3"><input name="txtDescription" type="text" class="txtbox" id="txtDescription" value="Being Payment of" style="width:240px" /></td>
                </tr>
              </table></td>
            <td width="40%"><table align="left"  width="100%">
                <tr>
                  <td width="25%" class="normalfnt">Vendor ID</td>
                  <td width="12%"><input name="txtAccPacID" type="text" class="txtbox" id="txtAccPacID" size="10" onfocus="setSelect(this)"/></td>
                  <td width="13%"  class="normalfnt" >Date</td>
                  <td width="40%"  class="normalfnt"><input name="txtDate" type="text" class="txtbox" id="txtDate" size="11" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo date("Y-m-d");?>"/>
                    <input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                </tr>
                <tr>
                  <td class="normalfnt">Bank</td>
                  <td colspan="3"><select name="txtBank" class="txtbox" id="txtBank" style="width:214px" >
                      <?php
					$strSQL="SELECT bank.strBankCode,bank.strBankName FROM bank ORDER BY bank.intBankId ASC";
					$result = $db->RunQuery($strSQL);
		
					echo "<option value=\"". "0" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"". $row["strBankCode"] ."\">" . $row["strBankName"] ."</option>" ;
					}
				?>
                    </select>
                    <input name="txtBankCode" type="text" class="txtbox" id="txtBankCode" size="1" style="visibility:hidden" /></td>
                </tr>
                <tr>
                  <td  class="normalfnt">Cheque No</td>
                  <td colspan="3"><input name="txtChequeNo" type="text" class="txtbox" id="txtChequeNo" size="33" onfocus="setSelect(this)"/></td>
                </tr>
              </table></td>
            <td width="20%"><table width="100%">
                <tr>
                  <td class="normalfnt">Payment Type</td>
                  <td class="normalfnt"><?php 
			  $type = $_POST["cboPaymentType"];
			  $checked	= "selected=\"selected\""; 
		  ?>
                    <select name="cboPaymentType" id="cboPaymentType" onchange="pageRefresh();" style="width:81px;">
                      <option value="S" <?php if($type=="S"){ echo $checked;} ?>>Style</option>
                      <option value="G" <?php if($type=="G"){ echo $checked;} ?>>General</option>
                      <option value="B" <?php if($type=="B"){ echo $checked;} ?>>Bulk</option>
                      <option value="W" <?php if($type=="W"){ echo $checked;} ?>>Wash</option>
                    </select></td>
                </tr>
                <tr>
                  <td  class="normalfnt">Currency</td>
                  <td><select name="cboCurrency" class="txtbox" id="cboCurrency" style="width:82px" onchange="loadBatch();">
                      <?php
			$strSQL="SELECT currencytypes.strCurrency AS CurrencyCode, currencytypes.strTitle AS CurrencyDesc, exchangerate.rate AS Rate
			         FROM currencytypes INNER JOIN exchangerate ON exchangerate.currencyID=currencytypes.intCurID
			         WHERE currencytypes.intStatus =  '1' AND  exchangerate.intStatus =  '1'";
						$result = $db->RunQuery($strSQL);
			
						echo "<option value=\"". "0" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"". $row["Rate"] ."\">" . $row["CurrencyCode"] ."</option>" ;
						}
					?>
                    </select></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
          </tr>
        </table>
        <br />
        <table width="100%" border="0" class="bcgl1">
          <tr>
            <td class="normalfnt" style="width:85px">Source Code</span></td>
            <td style="width:95px"><select name="cbosearch6" class="txtbox" id="cbosearch6" style="width:80px">
                <option value="0"></option>
                <option value="2">OB</option>
                <option value="2">PY</option>
                <option value="2">RC</option>
                <option value="2">RV</option>
                <option value="2">SO</option>
                <option value="2">TR</option>
                <option value="2">VD</option>
              </select></td>
            <td class="normalfnt" style="width:54px">Account</td>
            <td style="width:134px"><input name="txtAmount" type="text" class="txtbox" id="txtAmount" value="CLER" size="12"  style="text-align:center" onfocus="setSelect(this)" /></td>
            <td  class="normalfnt" style="width:87px">Tax Code</td>
            <td ><input name="txtTaxCode" type="text" class="txtbox" id="txtTaxCode" value="-" size="33" onfocus="setSelect(this)" /></td>
            <td width="10%">&nbsp;<img src="../images/search.png" class="mouseover"  onclick="paymentVoucherReport()" /></td>
          </tr>
        </table>
      </table>
      <br />
      <div id="divInvsList" style="overflow:none; height:210px; width:950px;" class="bcgl1">
        <table width="100%" cellpadding="0" cellspacing="0" id="tblInvoice" >
          <tr class="mainHeading4">
            <td width="5%" height="20">#</td>
            <td width="14%">Invoice No</td>
            <td width="16%">Total Amount</td>
            <td width="16%">Paid Amount</td>
            <td width="17%">Balance</td>
            <td width="18%">Pay Amount</td>
            <td width="15%">Advance</td>
          </tr>
        </table>
      </div>
      <br />
      <table width="100%" class="bcgl1">
        <tr>
          <td width="20%">&nbsp;</td>
          <td width="11%"><img src="../images/new.png" class="mouseover" onclick="clearPayementVoucherIF()" /></td>
          <td width="12%"><img src="../images/cal.png" class="mouseover"  onclick="calculetTheTotalAmount()" /></td>
          <td width="10%"><img src="../images/save.png" alt="Save" class="mouseover"  onclick="paymentVoucherSave()" /></td>
          <td class="normalfntMid">Total Amount</td>
          <td><input name="txtTotalAmont" type="text" class="txtbox" id="txtTotalAmont" size="18" style="text-align:center" disabled="disabled" />
          <td width="13%"><a href="../main.php"><img src="../images/close.png" alt="close"  border="0" class="mouseover" /></a></td>
        </tr>
      </table>
    </div>
  </div>
</form>
</body>
<script src="../js/jquery.fixedheader.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="paymentVoucher.js"></script>
</html>
