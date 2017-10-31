<?php
session_start();
include "../Connector.php"; 
$backwardseperator = "../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ePlan Web - Paid Invoice Finder</title>
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
.style1 {color: #B7D3FC}
-->
</style>


</head>
<script src="InvoiceFinder.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>


<body onload="setDefaultDateofFinder()">

<form id="form1" name="form1" method="post" action="">
  <table width="950" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td colspan="4"><?php include '../Header.php'; ?></td>
    </tr>
    <tr>
      <td height="139" colspan="4"><table width="100%" border="0" id="tblMain">
        <tr>
          <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
          <td width="365"><div id="divType" align="center">
            <table width="359" id="tblType" height="20" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="48">&nbsp;</td>
                <td width="76"><img src="../images/color1.png" width="29" height="15" /></td>
                <td width="235"><span class="head1">UnPaid Invoice List </span></td>
              </tr>
            </table>
          </div></td>
          <td width="100">&nbsp;</td>
          <td width="12" class="normalfnth2">&nbsp;</td>
          <td width="456"><table width="436" border="0" cellpadding="0" cellspacing="0" class="tablezRED" id="tblType">
            <tr>
              <td width="126"><span class="normalfnth2">Unpaid Invoices</span></td>
              <td width="98"><span class="normalfnth2">
                <input name="chkType" type="radio" class="style1" onclick="setInterface('Unpaid')" value="chkUnPaid" id="chkUnPaid" checked="CHECKED"/>
              </span></td>
              <td width="119"><span class="normalfnth2">Paid Invoices </span></td>
              <td width="91"><input name="chkType" type="radio" class="style1" value="chkPaid" id="chkPaid" onclick="setInterface('Paid')"/></td>
            </tr>
          </table></td>
          <td width="1">&nbsp;</td>
          </tr>
        <tr>
          <td colspan="5"><table width="100%" border="0">
            <tr>
              <td width="1%" height="32" rowspan="2">&nbsp;</td>
              <td width="12%" class="normalfnt">Payee</td>
              <td width="29%"><select name="cboPayees" class="txtbox" id="cboPayees" style="width:270px" >
                  <option value="0"></option>
                  <?php
	$SQL = "SELECT intPayeeID,strTitle FROM payee WHERE intStatus=1 ORDER BY strTitle";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["intPayeeID"] ."\">" . $row["strTitle"] ."</option>" ;
	}
	
	?>
                </select>              </td>
              <td width="1%">&nbsp;</td>
              <td class="normalfnt">Date From</td>
              <td width="17%" class="normalfnt"><input name="txtDateFrom" type="text" class="txtbox" id="txtDateFrom" size="20" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');"></td>
              <td width="6%"><span class="normalfnt">Date To</span></td>
              <td colspan="3" class="normalfnt"><input name="txtDateTo" type="text" class="txtbox" id="txtDateTo" size="20" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');"></td>
              <td width="9%" class="normalfnt">&nbsp;</td>
            </tr>
            <tr>
              <td width="12%" height="28" class="normalfnt">Invoice No like </td>
              <td  class="normalfnt"><input name="textInvNoLike" class="txtbox" type="text"  id="textInvNoLike" size="43" onfocus="setSelect(this)" /></td>
              <td  class="normalfnt">&nbsp;</td>
              <td width="8%">&nbsp;</td>
              <td width="17%" class="normalfnt">&nbsp;</td>
              <td width="6%">&nbsp;</td>
              <td width="3%">&nbsp;</td>
              <td width="1%">&nbsp;</td>
              <td width="13%"><span class="normalfnt"><img src="../images/search.png" alt="go" width="80" height="24" class="mouseover" onclick="fillAvailableInvoicData();" /></span></td>
			  <td width="9%" class="normalfnt"><a href="withoutPOInvoice.php"><img src="../images/close.png" width="80" height="22" border="0" /></a></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="5">
		  <div id="divPayVoucherData" style="overflow:scroll; height:200px" class="bcgl1">
		  <table id="tblPVData" width="922" border="0" cellpadding="0" cellspacing="0" >
            <tr>
			  <td width="3%" height="23" bgcolor="#498CC2" class="normaltxtmidb2">*</td>
              <td width="9%" height="23" bgcolor="#498CC2" class="normaltxtmidb2">Invoice No</td>
              <td width="29%" bgcolor="#498CC2" class="normaltxtmidb2">Payee</td>
              <td width="29%" bgcolor="#498CC2" class="normaltxtmidb2">Description</td>
              <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">Date</td>
              <td width="11%" bgcolor="#498CC2" class="normaltxtmidb2">Amount</td>
              <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">View Invoice </td>
             </tr>
			<!--<tr>
              <td height="20" class="normalfnt">Payment No dfdf </td>
              <td height="20" class="normalfnt">Payment No dfdf </td>
              <td height="20" class="normalfnt" style="text-align:right">Payment No dfdf </td>
              <td height="20" class="normalfnt"><div align="center"><img src="../images/butt_1.png" width="15" height="15" /></div></td>
            </tr>-->
          </table>
		  </div>		  </td>
        </tr>
	
		
      </table></td>
    </tr>
    
  </table>
</form>
</body>
</html>
