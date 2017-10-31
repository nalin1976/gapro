<?php
session_start();
include "../Connector.php"; 
$backwardseperator = "../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Without PO Voucher Finder</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="calendar.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<style type="text/css">
<!--
body {
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


</head>
<script src="withoutPOVoucherFinder.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>


<body onload="setDefaultDateofFinder()">

<form id="form1" name="form1" method="post" action="">
  <table width="905" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td colspan="4"><?php include '../Header.php'; ?></td>
    </tr>
    <tr>
      <td height="139" colspan="4"><div id="dd" style="width:855px"><table width="96%" border="0">
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td width="93"><div align="center"><img src="../images/color1.png" width="29" height="15" /></div></td>
          <td width="468"><span class="head1">Without PO Vouchers</span></td>
          <td width="378" class="head1">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="0%" height="32" rowspan="3">&nbsp;</td>
              <td width="10%" class="normalfnt">Payee</td>
              <td width="87%" class="normalfnt"><select name="cboPayees" class="txtbox" id="cboPayees" style="width:400px" >
                  <option value="0"></option>
                  <?php
					$SQL = "SELECT intPayeeID,strTitle FROM payee WHERE intStatus=1 ORDER BY strTitle";	
					$result = $db->RunQuery($SQL);		
					while($row = mysql_fetch_array($result))
					{
					echo "<option value=\"". $row["intPayeeID"] ."\">" . $row["strTitle"] ."</option>" ;
					}
					
					?>
              </select></td>
              <td width="4%">&nbsp;</td>
              <td width="0%">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" class="normalfnt"><table width="897" height="22" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="95">Date From </td>
                    <td width="215"><input name="txtDateFrom" type="text" class="txtbox" id="txtDateFrom" size="18" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');"></td>
                    <td width="59">Date To </td>
                    <td width="184"><input name="txtDateTo" type="text" class="txtbox" id="txtDateTo" size="18" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');"></td>
                    <td width="132">&nbsp;</td>
                    <td width="116"><img src="../images/search.png" alt="go" width="90" height="24" class="mouseover" onclick="fillAvailablePaymentData();" /></td>
                    <td width="96"><a href="withoutPOVoucher.php"><img src="../images/close.png" width="96" height="22" border="0" /></a></td>
                  </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="3">
		  <div class="bcgl1" id="divPayVoucherData" style="overflow:scroll; width:890px;height:200px">
		  <table id="tblPVData" width="900" border="0" cellpadding="0" cellspacing="0">
            <tr>
			  <td width="1%" height="25" bgcolor="#498CC2" class="normaltxtmidb2">*</td>
              <td width="9%" height="25" bgcolor="#498CC2" class="normaltxtmidb2">Voucher No</td>
              <td width="26%" bgcolor="#498CC2" class="normaltxtmidb2">Payee</td>
              <td width="26%" bgcolor="#498CC2" class="normaltxtmidb2">Description</td>
              <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Date</td>
              <td width="12%" bgcolor="#498CC2" class="normaltxtmidb2">Amount</td>
              <!--<td width="18%" bgcolor="#498CC2" class="normaltxtmidb2">Total Amount </td>-->
              <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Voucher</td>
              <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Schedule</td>
              </tr>
<!--			<tr>
              <td height="20" class="normalfnt"></td>
              <td height="20" class="normalfnt">111</td>
              <td height="20" class="normalfnt">saman</td>
			  <td height="20" class="normalfnt">test</td>
			  <td height="20" class="normalfnt">2009/06/04</td>
			  <td height="20" class="normalfnt" style="text-align:right">2000</td>
			  
              <td height="20" class="normalfnt"><div align="center"><img src="../images/butt_1.png" width="15" height="15" /></div></td>
            </tr>-->
          </table>
		  </div>		  </td>
        </tr>
	
		
      </table></div></td>
    </tr>
    
  </table>
</form>
</body>
</html>
