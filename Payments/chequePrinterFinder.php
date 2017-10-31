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
<title>GaPro - Payments Finder</title>
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


<body onload="setDefaultDateofFinder()">
<table width="100%">
	<tr>
		<td id="tdHeader"><?php include $backwardseperator ."Header.php";?></td>
	</tr>
</table>
<div class="main_bottom_center">
	<div class="main_top">
		<div class="main_text">Cheque Payment Finder<span class="vol"></span></div>
	</div>
	<div class="main_body">
<form id="form1" name="form1" method="post" action="">
  <table width="950" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td height="139" colspan="4"><table width="100%" border="0">
        <tr>
          <td colspan="3"><table width="100%" border="0">
            <tr>
              <td width="1%" height="32">&nbsp;</td>
              <td width="6%" class="normalfnt">Supplier</td>
              <td width="29%"><select name="cboSuppliers" class="txtbox" id="cboSuppliers" style="width:270px" >
                <option value="0"></option>
    <?php
	$SQL = "SELECT strSupplierID,strTitle FROM suppliers WHERE intStatus=1 ORDER BY strTitle;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
	}
	
	?>
                  </select>	</td>
              <td width="8%" class="normalfnt"> Date From </td>
              <td width="14%"><input name="txtDateFrom" type="text" class="txtbox" id="txtDateFrom" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');"></td>
			  
              <td width="7%" class="normalfnt">Date To </td>
              <td width="35%"><table width="100%" border="0">
                <tr>
                  <td width="46%"><input name="txtDateTo" type="text" class="txtbox" id="txtDateTo" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');"></td>
				  
                  <td width="28%"><span class="normalfnt"><img src="../images/search.png" alt="go" width="80" height="24" class="mouseover" onclick="findChequeDetails();" /></span></td>
                  <td width="27%"><a href="paymentVoucher.php"><img src="../images/close.png" width="80" height="24" border="0" /></a></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
          </tr>
        <tr>
          <td colspan="3">
		  <div class="bcgl1" id="divChequeData" style="overflow:scroll; width:945px;height:200px">
		  <table id="tblChequeData" width="922"  border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="11%" height="25" bgcolor="#498CC2" class="grid_header">Cheque Ref. No</td>
              <td width="12%" bgcolor="#498CC2" class="grid_header">Date</td>
              <td width="10%" bgcolor="#498CC2" class="grid_header">Amount</td>
              <td width="13%" bgcolor="#498CC2" class="grid_header">Cheque Type</td>
              <td width="40%" bgcolor="#498CC2" class="grid_header">Bank</td>
              <td width="7%" bgcolor="#498CC2" class="grid_header">Format</td>
              <td width="5%" bgcolor="#498CC2" class="grid_header">View</td>
             </tr>
			<!--<tr>
              <td height="20" class="normalfnt">123</td>
              <td height="20" class="normalfnt" >2009</td>
              <td height="20" class="normalfnt" style="text-align:right">2000.00f </td>
              <td height="20" class="normalfnt" style="text-align:center">CROSS</td>
			  <td height="20" class="normalfnt" >BOC</td>
              <td height="20" class="normalfnt"><div align="center"><img src="../images/butt_1.png" width="15" height="15" /></div></td>
            </tr>-->
          </table>
		  </div>		  </td>
        </tr>
	
		
      </table></td>
    </tr>
        <tr>
			<td width="3">&nbsp;</td>
			<td width="10" height="16" class="txtbox"><input type="text" class="txtbox" name="textfield" size="1" height="12" disabled="disabled" style="background-color:#DFFFBF"/></td>
			<td width="932"  class="normalfnt">Printed Cheques</td>
			
    </tr>
  </table>
</form>
</div>
</div>
</body>
</html>
