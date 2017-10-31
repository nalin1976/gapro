<?php
	session_start();
	include "../Connector.php";
	$backwardseperator = "../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Without PO Payments Schedule</title>

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

<script language="javascript" type="text/javascript" src="withoutPOSchedule.js"></script>
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>



</head>

<body onload="setDefaultDate();">

<form name="frmwithoutPOPayment" id="frmwithoutPOPayment">
<table width="961" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
       <td width="970" height="6" colspan="2"><?php include '../Header.php'; ?></td>
    </tr>
	 <tr>
       <td height="26" colspan="2"  bgcolor="#498CC2" class="normaltxtmidb2" >Payment - Without PO Payment Schedule</td>
     </tr>
	   <tr>
    <td>
   
  <tr>
    <td><table width="98%" border="0" class="bcgl1">
      <tr>
        <td width="58%" valign="top"><table width="79%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="12" bgcolor="#F8DDB6" class="normalfnt">&nbsp;</td>
            <td width="194" height="27" bgcolor="#F8DDB6" class="normalfnt">Schedule No</td>
            <td width="234" height="27" bgcolor="#F8DDB6" class="normalfnt"><input name="txtScheduleNo" type="text" class="txtbox" id="txtScheduleNo" size="24" style="text-align:center" maxlength="20" disabled="disabled"/></td>
            <td width="153" bgcolor="#F8DDB6" class="normalfnt">Date</td>
            <td width="317" bgcolor="#F8DDB6" class="normalfnt"><input name="txtDate" type="text" class="txtbox" id="txtDate" size="24" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');"></td>
            </tr>
          
          <tr>
            
            <td colspan="5" ><div id="divAmt" style="width:800">
              <table width="899" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="13" >&nbsp;</td>
                  <td width="191" height="30" ><span class="normalfnt">Payee</span></td>
                  <td width="651" ><span class="normalfnt">
                    <select name="cboPayee" class="txtbox" id="cboPayee" style="width:345px" onchange="GetSupplierWPOInvoiceDetails();">
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
                  <td width="49" height="22" >&nbsp;</td>
                 
                </tr>
                <!--                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td height="22">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>-->
                <tr>
                  <td height="22" colspan="4"><table width="947" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
                      <tr>
                        <td width="10" height="24">&nbsp;</td>
                        <td width="193"><span class="normalfnt">Amount</span></td>
                        <td width="233"><span class="normalfnt">
                          <input name="txAmount" type="text" class="txtbox" id="txAmount" style="text-align:right" value="0.00" size="24" maxlength="20" />
                        </span></td>
                        <td width="153" height="24"><span class="normalfnt">Discount</span></td>
                        <td width="313"><span class="normalfnt">
                          <input name="txtDiscountAmt" type="text" class="txtbox" id="txtDiscountAmt" style="text-align:right" value="0.00" size="24" maxlength="20" />
                        </span></td>
                      </tr>
                      <tr>
                        <td height="24">&nbsp;</td>
                        <td height="24"><span class="normalfnt">Tax</span></td>
                        <td><span class="normalfnt">
                          <input name="txtTaxAmt" type="text" class="txtbox" id="txtTaxAmt" style="text-align:right" value="0.00" size="24" maxlength="20" />
                        </span></td>
                        <td><span class="normalfnt">Total Amount </span></td>
                        <td><span class="normalfnt">
                          <input name="txtTotalAmt" type="text" class="txtbox" id="txtTotalAmt" style="text-align:right" value="0.00" size="24" maxlength="20" />
                        </span></td>
                      </tr>
                  </table></td>
                </tr>
              </table>
            </div>                                                </tr>
          


          </table>
</td>
        
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="4" valign="top" class="normalfnt"><div class="bcgl1" id="divInvs"  style="overflow:scroll; height:150px">
              <table width="955" cellpadding="0" cellspacing="0" id="tblInvoices">
                <tr>
                  <td width="1" height="23" bgcolor="#498CC2" class="normaltxtmidb2"></td>
                  <td width="26" bgcolor="#498CC2" class="normaltxtmidb2">*</td>
                  <td width="87" bgcolor="#498CC2" class="normaltxtmidb2">Invoice No </td>
                  <td width="184" bgcolor="#498CC2" class="normaltxtmidb2">Description</td>
                  <td width="104" bgcolor="#498CC2" class="normaltxtmidb2">Date</td>
				  <td width="131" bgcolor="#498CC2" class="normaltxtmidb2">Amount</td>
                  <td width="131" bgcolor="#498CC2" class="normaltxtmidb2">Tax</td>
                  <td width="131" bgcolor="#498CC2" class="normaltxtmidb2">Discount</td>
                  <td width="125" bgcolor="#498CC2" class="normaltxtmidb2">Total Amount </td>
                  
                </tr>
<!--				 <tr>
                  <td width="1" height="18" ></td>
                  <td width="26" ><input name="chkSelect" type="checkbox" id="chkSelect" value="chkSelect" /></td>
                  <td width="87" >222 </td>
                  <td width="184" >dddd</td>
                  <td width="131" style="text-align:right" >333</td>
                  <td width="131" >21</td>
                  <td width="125" >34555</td>
                  <td width="104" colspan="2" >2009-05-30</td>
                </tr>-->
          </table>
			
			</div></td>
    </tr>
          

  </tr>
  
  
  
  <tr>
    <td bgcolor="#D6E7F5"><table width="100%" border="0">
      <tr>
        <td width="27%">&nbsp;</td>
        <td width="11%"><img src="../images/new.png" alt="new" width="96" height="24" onclick="clearAll()"/></td>
        <td width="11%"><img src="../images/cal.png" alt="new" width="96" height="24" onclick="valueCalculate()"/></td>
        <td width="10%"><img src="../images/save.png" alt="Save" width="84" height="24" class="mouseover" onclick="SaveInvoiceSchedule();" /></td>
        <td width="13%"><a href="../main.php"><img src="../images/close.png" alt="close" width="97" height="24" border="0" /></a></td>
        <td width="28%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
