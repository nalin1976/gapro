<?php
session_start();
include "../Connector.php"; 
$strPaymentType=$_GET["strPaymentType"];
$backwardseperator = "../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro- Payments Finder</title>
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


</head>
<script src="paymentVoucher.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>


<body onload="setDefaultDateOfChequePrinter()">
<table width="100%">
	<tr>
		<td id="tdHeader"><?php include $backwardseperator ."Header.php";?></td>
	</tr>
</table>
<div class="main_bottom_center">
	<div class="main_top">
		<div class="main_text">Cheque Printer<span class="vol"></span></div>
	</div>
	<div class="main_body">
<form id="form1" name="form1" method="post" action="">
  <table width="950" height="405" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td height="334" colspan="11"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#D6E7F5">
          <td colspan="6"><table width="953" height="28" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
              
              <tr>
                <td class="normalfnt" height="24">&nbsp;</td>
                <td class="normalfnt">Ref. No</td>
                <td ><input name="txtChequeRef" type="text" class="txtbox" id="txtChequeRef" style="text-align:center" value="" size="15" /></td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td>Date</td>
                <td width="162"><input name="txtDate" type="text" class="txtbox" id="txtDate" size="18" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');" value="" /></td>
                <td width="156"><input type="text" class="txtbox" name="textfield2" size="18" style="text-align:center" value="
				<?php
					$SQL = "select Name from useraccounts where intUserID  =" . $_SESSION["UserID"] ;
					$result = $db->RunQuery($SQL);
					
					while($row = mysql_fetch_array($result))
					{
						echo $row["Name"];
					}
				?>
				
				" /></td>
              </tr>
              <tr>
                <td width="10" class="normalfnt" height="24">&nbsp;</td>
                <td width="84" class="normalfnt">Type</td>
                <td width="217" ><select name="cboPaymentMode" id="cboPaymentMode" class="txtbox" style="width:150px" onchange="clearChequePrint();modeSet()">
                  <option value="1" selected="selected">PO PAYMENTS</option>
                  <option value="2">WPO PAYMENTS</option>
                  <option value="3">ADVANCE PAYMENTS</option>
                  </select></td>
                <td width="65" >&nbsp;</td>
                <td width="137" >&nbsp;</td>
                <td width="120">Company</td>
                <td colspan="2"><input type="text" class="txtbox" name="textfield3" size="45" style="text-align:center" value="
				<?php
					$SQL = "SELECT strName FROM companies WHERE companies.intCompanyID =" . $_SESSION["FactoryID"] ;
					$result = $db->RunQuery($SQL);
					
					while($row = mysql_fetch_array($result))
					{
						echo $row["strName"];
					}
				?>
				" /></td>
                </tr>
            </table></td>
          </tr>
        <tr>
          <td colspan="6"><table width="100%" border="0" id="tblMain">
            
            <tr>
              <td height="25">&nbsp;</td>
              <td class="normalfnt">Supplier</td>
              <td><select name="cboSuppliers" class="txtbox" id="cboSuppliers" style="width:270px" onchange="fillAvailablePaymentDataToPrint()" >
                <option value="0"></option>
                <?php
	$SQL = "SELECT strSupplierID,strTitle FROM suppliers WHERE intStatus=1 ORDER BY strTitle;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
	}
	
	?>
              </select></td>
              <td class="normalfnt">&nbsp;</td>
              <td width="6%" class="normalfnt">Payee</td>
              <td width="51%"><input name="txtPayee" type="text" class="txtbox" id="txtPayee" size="79" /></td>
              </tr>
            <tr>
              <td width="1%" height="25">&nbsp;</td>
              <td width="11%" class="normalfnt">Bank</td>
              <td width="30%"><select name="cboBanks" class="txtbox" id="cboBanks" style="width:270px" >
                <option value="0"></option>
                <?php
	$SQL = "SELECT strBankCode,strName FROM bank WHERE intStatus=1 order by strName";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["strBankCode"] ."\">" . $row["strName"] ."</option>" ;
	}
	
	?>
              </select></td>
              <td width="1%" class="normalfnt">&nbsp;</td>
              <td colspan="2" class="normalfnt"><table width="557" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="106"><span class="normalfnt">Cross Cheque</span></td>
                      <td width="28"><input name="optType" type="radio" id="optCross" value="radiobutton" checked="checked" /></td>
                      <td width="113"><span class="normalfnt">Account Payee</span></td>
                      <td width="32"><span class="normalfnt">
                        <input name="optType"  type="radio" value="radiobutton" id="optPayee"  />
                        </span></td>
                      <td width="94">Cheque Type </td>
                      <td width="184"><select name="chequeType" id="chequeType" class="txtbox" style="width:150px">
                                      
						<?php
							$SQL = "SELECT chqFormatID,strFromat FROM chequeformat ORDER BY strFromat";	
							$result = $db->RunQuery($SQL);		
							while($row = mysql_fetch_array($result))
							{
							echo "<option value=\"". $row["chqFormatID"] ."\">" . $row["strFromat"] ."</option>" ;
							}				
						?>
                      </select>                      </td>
                    </tr>
                                          </table></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td height="209" colspan="6">
		  <div class="bcgl1" id="divPayVoucherData" style="overflow:scroll; width:945px;height:200px">
		  <table id="tblPVData" width="928"  border="0" cellpadding="0" cellspacing="0">
            <tr>
			  <td width="2%" height="25" bgcolor="#498CC2" class="grid_header">*</td>
              <td width="11%" height="25" bgcolor="#498CC2" class="grid_header">Voucher No</td>
              <td width="9%" bgcolor="#498CC2" class="grid_header">Date</td>
              <td width="21%" bgcolor="#498CC2" class="grid_header" >Description</td>
              <td width="11%" bgcolor="#498CC2" class="grid_header">Amount </td>
              <td width="9%" bgcolor="#498CC2" class="grid_header">Tax</td>
              <td width="12%" bgcolor="#498CC2" class="grid_header">Total Amount </td>
              <td width="7%" bgcolor="#498CC2" class="grid_header">&nbsp;</td>
              <td width="9%" bgcolor="#498CC2" class="grid_header">Voucher</td>
              <td width="9%" bgcolor="#498CC2" class="grid_header">Schedule</td>
             </tr>
			<!--<tr>
              <td height="20" class="normalfnt">Payment No dfdf </td>
              <td height="20" class="normalfnt">Payment No dfdf </td>
              <td height="20" class="normalfnt" style="text-align:right">Payment No dfdf </td>
              <td height="20"   class="normalfnt"><div align="center"><img src="../images/butt_1.png" width="15" height="15" /></div></td>
            </tr>-->
		  </table>
		  </div>		  </td>
        </tr>
		
	
		
      </table>
	  <tr bgcolor="">
	  	<td width="14" height="30" >&nbsp;</td>
	    <td width="100" ><span class="normalfnt">Total Amount</span></td>
	    <td width="390"  ><input name="txtTotAmt" type="text" disabled="disabled" class="txtbox" id="txtTotAmt" style="text-align:right;background:#FFFF99" value="0.00"" size="21" /></td>
	    <td width="97" ><img src="../images/new.png" width="97" height="24" border="0" onclick="clearChequePrint()" /></td>
	    <td width="97" ><img src="../images/print.png" width="97" height="24" onclick="saveChequeDetails();" /></td>
	    <td width="97" ><a href="chequePrinterFinder.php"><img src="../images/search.png" width="97" height="24" border="0" /></a></td>
	    <td width="128" ><a href="../Header.php"><img src="../images/close.png" width="97" height="24" border="0" /></a></td>
	    <td width="36" >&nbsp;</td>
	  </tr>
  </table>
</form>
</div>
</div>
</body>
</html>
