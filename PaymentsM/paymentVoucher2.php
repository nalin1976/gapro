<?php
	session_start();
		include "../Connector.php";
	$backwardseperator = "../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="calendar.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<style>
.main_bottom_center1 {
	width:auto;
	height:auto;
	position : absolute;
	top : 150px;
	left:50px;
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
<script language="javascript" type="text/javascript" src="paymentVoucher2.js"></script>
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
                  <td colspan="3"><select name="cboSupliers" class="txtbox" id="cboSupliers" style="width:240px" onchange="getScheduals(),getDets()" >
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
                  <td class="normalfnt">Batch No</td>
                  <td width="16%"><select name="cboBatchNo" class="txtbox" id="cboBatchNo" style="width:70px" onchange="getBank()">
                      <?php
					$strSQL="SELECT intBatch,strDescription FROM batch WHERE intBatchType=1 ORDER BY strDescription";
					$result = $db->RunQuery($strSQL);
		
					echo "<option value=\"". "0" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"". $row["intBatch"] ."\">" . $row["strDescription"] ."</option>" ;
					}
				?>
                    </select></td>
                  <td width="20%" class="normalfnt">Schedule No </td>
                  <td width="32%"><select name="cboSchedual" class="txtbox" id="cboSchedual" style="width:70px" onchange="loadInvoiceSchedual()">
                    </select></td>
                </tr>
                <tr>
                  <td class="normalfnt">Description</td>
                  <td colspan="3"><input name="txtDescription" type="text" class="txtbox" id="txtDescription" value="" style="width:240px" /></td>
                </tr>
              </table></td>
            <td width="40%"><table align="left"  width="100%">
                <tr>
                  <td width="18%" class="normalfnt">Acp ID</td>
                  <td width="27%"><input name="txtAccPacID" type="text" class="txtbox" id="txtAccPacID" size="10" onfocus="setSelect(this)"/></td>
                  <td width="18%"  class="normalfnt" >Date</td>
                  <td width="40%"  class="normalfnt"><input name="txtDate" type="text" class="txtbox" id="txtDate" size="10" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo date("Y-m-d");?>"/>
                    <input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                </tr>
                <tr>
                  <td class="normalfnt">Bank</td>
                  <td colspan="3"><select name="txtBank" class="txtbox" id="txtBank" style="width:250px" >
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
                  <td  class="normalfnt">Check No</td>
                  <td><input name="txtChequeNo" type="text" class="txtbox" id="txtChequeNo" size="10" onfocus="setSelect(this)"/></td>
                  <td  class="normalfnt">Currency</td>
                  <td><select name="cboCurrency" class="txtbox" id="cboCurrency" style="width:82px">
                      <?php
			$strSQL="SELECT currencytypes.strCurrency AS CurrencyCode, currencytypes.strTitle AS CurrencyDesc, exchangerate.rate AS Rate
			FROM currencytypes 
			JOIN exchangerate
	       ON exchangerate.currencyID=currencytypes.intCurID
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
              </table></td>
            <td width="20%"><table width="100%">
                <tr>
                  <td class="normalfnt">Payment Type</td>
                  <td class="normalfnt"><?php 
			  $type = $_POST["cboPaymentType"];
			  $checked	= "selected=\"selected\""; 
		  ?>
                    <select name="cboPaymentType" id="cboPaymentType" onchange="pageRefresh();" style="width:75px;">
                      <option value="S" <?php if($type=="S"){ echo $checked;} ?>>Style</option>
                      <option value="G" <?php if($type=="G"){ echo $checked;} ?>>General</option>
                      <option value="B" <?php if($type=="B"){ echo $checked;} ?>>Bulk</option>
                      <option value="W" <?php if($type=="W"){ echo $checked;} ?>>Wash</option>
                    </select></td>
                </tr>
              </table></td>
          </tr>
        </table>
        <br />
        <table width="100%" border="0" class="bcgl1">
          <tr>
            <td class="normalfnt">Source Code</span></td>
            <td><select name="cbosearch6" class="txtbox" id="cbosearch6" style="width:80px">
                <option value="0"></option>
                <option value="2">OB</option>
                <option value="2">PY</option>
                <option value="2">RC</option>
                <option value="2">RV</option>
                <option value="2">SO</option>
                <option value="2">TR</option>
                <option value="2">VD</option>
              </select></td>
            <td class="normalfnt">Account</td>
            <td><input name="txtAmount" type="text" class="txtbox" id="txtAmount" value="CLER" size="12"  style="text-align:center" onfocus="setSelect(this)" /></td>
            <td  class="normalfnt">Tax Code</td>
            <td ><input name="txtTaxCode" type="text" class="txtbox" id="txtTaxCode" value="-" size="18" onfocus="setSelect(this)" /></td>
            <td class="normalfnt">Total Amount</td>
            <td><input name="txtTotalAmont" type="text" class="txtbox" id="txtTotalAmont" size="18" style="text-align:center" disabled="disabled" />
          </tr>
        </table>
      </table>
      <br />
      <div id="divInvsList" style="overflow:scroll; height:210px; width:950px;">
        <table width="100%" cellpadding="0" cellspacing="0" id="tblInvoice">
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
    </div>
  </div>
</form>
</body>
</html>
