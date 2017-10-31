<?php
	session_start();
	include "../Connector.php";
	$backwardseperator = "../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Without PO Payments Voucher</title>

<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="calendar.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />

<style type="text/css">
<!--
body 
{
	background-color: #CCCCCC;
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

<script language="javascript" type="text/javascript" src="withoutPOVoucher.js"></script>
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>



</head>

<body onload="setDefaultDate();">

<form name="frmwithoutPOPayment" id="frmwithoutPOPayment">
<table width="964" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
       <td height="6" colspan="2"><?php include '../Header.php'; ?></td>
    </tr>
	 <tr>
       <td width="968" height="24" bgcolor="#498CC2" class="normaltxtmidb2" >Payment - Without PO Payment Voucher</td>
       
	 </tr>
    <tr>
    <td><table width="88%" height="149" border="0" class="bcgl1">
      <tr>
        <td width="58%" valign="top"><table width="92%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="10" bgcolor="#F8DDB6" class="normalfnt">&nbsp;</td>
            <td width="87" height="27" bgcolor="#F8DDB6" class="normalfnt">Voucher  No</td>
            <td width="150" height="27" bgcolor="#F8DDB6" class="normalfnt"><input name="txtPayNo" type="text" class="txtbox" id="txtPayNo" size="20" style="text-align:center" maxlength="20" disabled="disabled"/></td>
            <td width="60" bgcolor="#F8DDB6" class="normalfnt">Date</td>
            <td width="194" bgcolor="#F8DDB6" class="normalfnt"><input name="txtDate" type="text" class="txtbox" id="txtDate" size="20" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');"></td>
            <td width="71" bgcolor="#F8DDB6" class="normalfnt">User</td>
            <td width="373" bgcolor="#F8DDB6" class="normalfnt"><input name="txtUserID" type="text" disabled="disabled"  class="txtbox" id="txtUserID"  value="<?php 
						
						$SQL = "select Name from useraccounts where intUserID  =" . $_SESSION["UserID"] ;
						$result = $db->RunQuery($SQL);
					
						while($row = mysql_fetch_array($result))
						{
							echo $row["Name"];
						}
					?>" size="24" /></td>
          </tr>
<!--          <tr>
            <td width="13" class="normalfnt">&nbsp;</td>
            <td width="84" height="23" class="normalfnt">&nbsp;</td>
            <td colspan="3" class="normalfnt">&nbsp;</td>
          </tr>-->
          <tr>
            
            <td colspan="7" ><div id="divAmt" style="width:945px" >
			  <table width="943" border="0" cellpadding="0" cellspacing="0" >
                <tr>
                  <td >&nbsp;</td>
                  <td class="normalfnt">Payee</td>
                  <td height="22" ><span class="normalfnt">
                    <select name="cboPayee" class="txtbox" id="cboPayee" style="width:345px" onchange="GetSupplierInvoiceSchedules();">
                      <?php
					$strSQL="SELECT intPayeeID,strTitle FROM payee WHERE intStatus=1 ORDER BY strTitle";
					$result = $db->RunQuery($strSQL);
		
					echo "<option value=\"". "0" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"". $row["intPayeeID"] ."\">" . $row["strTitle"] ."</option>" ;
					}
				
				
				
				?>
                    </select>
                  </span></td>
                  <td height="22" ><span class="normalfnt">Cheque/Draft No</span></td>
                  <td height="22" ><span class="normalfnt">
                    <input name="txtChequeNo" type="text" class="txtbox" id="txtChequeNo" size="24" onfocus="setSelect(this)" />
                  </span></td>
                  <td height="22" >&nbsp;</td>
                  <td height="22" >&nbsp;</td>
                </tr>
                <tr>
                  <td >&nbsp;</td>
                  <td class="normalfnt">Description</td>
                  <td height="22" ><input name="txtDescription" class="txtbox" type="text" id="txtDescription" size="55" onfocus="setSelect(this)" /></td>
                  <td height="22" ><span class="normalfnt">Account</span></td>
                  <td height="22" ><span class="normalfnt">
                    <input name="txtAccount" type="text" class="txtbox" id="txtAccount" size="24" onfocus="setSelect(this)"/>
                  </span></td>
                  <td height="22" >&nbsp;</td>
                  <td height="22" >&nbsp;</td>
                </tr>
                <tr>
                  <td >&nbsp;</td>
                  <td class="normalfnt">Batch No</td>
                  <td ><select name="cbobatch" class="txtbox" id="cbobatch" style="width:207px">
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
                  <td height="22" class="normalfnt">Tax Code </td>
                  <td><span class="normalfnt">
                    <input name="txtTaxCode" type="text" class="txtbox" id="txtTaxCode" onfocus="setSelect(this)" value="-" size="24" />
                  </span></td>
                  <td>&nbsp;</td>
                  <td width="108">&nbsp;</td>
                </tr>
                <tr>
                  <td width="13" >&nbsp;</td>
                  <td width="82" ><span class="normalfnt">Schedule No</span></td>
                  <td width="359" ><select name="cboScheduleNo" class="txtbox" id="cboScheduleNo" style="width:207px" onchange="getInvoiceDetails()">
                    </select></td>
                  <td width="104" height="22" class="normalfnt" >Currency From</td>
                  <td width="170"><select name="cboCurrencyFrom" class="txtbox" id="cboCurrencyFrom" style="width:100px" onchange="rateShow(1)">
                    <?php
					$strSQL="SELECT strCurrency,dblRateq FROM currencytypes ORDER BY strCurrency";
					$result = $db->RunQuery($strSQL);
		
					echo "<option value=\"". "0" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"". $row["dblRateq"] ."\">" . $row["strCurrency"] ."</option>" ;
					}
				?>
                  </select></td>
                  <td width="83"><span class="normalfnt">Currency To</span></td>
                  <td><select name="cboCurrencyTo" class="txtbox" id="cboCurrencyTo" style="width:100px" onchange="rateShow(2)">
                    <?php
					$strSQL="SELECT strCurrency,dblRateq FROM currencytypes ORDER BY strCurrency";
					$result = $db->RunQuery($strSQL);
		
					echo "<option value=\"". "0" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"". $row["dblRateq"] ."\">" . $row["strCurrency"] ."</option>" ;
					}
				?>
                  </select></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td class="normalfnt">Total Amount</td>
                  <td><span class="normalfnt">
                    <input name="txtTotalAmt" type="text" disabled="disabled" class="txtbox" id="txtTotalAmt" style="text-align:left" value="0.00" size="32" />
                  </span></td>
                  <td height="22"><span class="normalfnt">Rate</span></td>
                  <td><span class="normalfnt">
                    <input name="txtRateFrom" type="text" disabled="disabled" class="txtbox" id="txtRateFrom" value="0.00" size="14" />
                  </span></td>
                  <td><span class="normalfnt">Rate</span></td>
                  <td><span class="normalfnt">
                    <input name="txtRateTo" type="text"  disabled="disabled" class="txtbox" id="txtRateTo" value="0.00" size="14"/>
                  </span></td>
                </tr>
                <!--<tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td height="22">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>-->
              </table>
			  
            </div>                                                </tr>
          


          </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"colspan="4" class="normalfnt"><div class="bcgl1" id="divInvs" style="overflow:scroll; width:952px;height:150px" >
              <table width="950" cellpadding="0" cellspacing="0"  id="tblGLAccs">
                <tr>
                  <td width="10" height="20" bgcolor="#498CC2" class="normaltxtmidb2">*</td>
                  <td width="97" height="20" bgcolor="#498CC2" class="normaltxtmidb2">Invoice No</td>
                  <td width="79" bgcolor="#498CC2" class="normaltxtmidb2">Date</td>
				  <td width="263" bgcolor="#498CC2" class="normaltxtmidb2">Description</td>
                  <td width="100" bgcolor="#498CC2" class="normaltxtmidb2">Amount</td>
                  <td width="102" bgcolor="#498CC2" class="normaltxtmidb2">Tax</td>
                  <td width="101" bgcolor="#498CC2" class="normaltxtmidb2">Discount</td>
                  <td width="129" bgcolor="#498CC2" class="normaltxtmidb2">Total Amount </td>
                  <td width="67" bgcolor="#498CC2" class="normaltxtmidb2">Currency</td>
                </tr>
				 <!--<tr>
                  <td width="10" >&nbsp;</td>
				  <td width="97" height="17">222 </td>
                  <td width="79" >dddd</td>
                  <td width="263" >333</td>
                  <td width="100" style="text-align:right" >21</td>
                  <td width="102" style="text-align:right">34555</td>
                  <td width="101" style="text-align:right">2009-05-30</td>
                  <td width="129"  style="text-align:right">rs</td>
                  <td width="67"  style="text-align:center">SLR</td>
				 </tr>-->
          </table>
			
			</div></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>        </tr>
      <tr>
		</td>
		  
    </table><td width="1"></td>
  </tr>
  
  
  <tr>
    <td bgcolor="#D6E7F5"><table width="100%" border="0">
      <tr>
        <td width="30%">&nbsp;</td>
        <td width="12%"><img src="../images/new.png" alt="new" width="96" height="24" onclick="ClearAll()"/></td>
        <td width="11%"><img src="../images/save.png" alt="Save" width="84" height="24" class="mouseover" onclick="SaveNewVoucher();" /></td>
        <td width="11%"><a href="withoutPOVoucherFinder.php"><img src="../images/search.png" width="86" height="24" border="0" /></a></td>
        <td width="13%"><a href="../main.php"><img src="../images/close.png" alt="close" width="97" height="24" border="0" /></a></td>
        <td width="23%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
