<?php
session_start();
$backwardseperator = "../../";
include "../../Connector.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Supplier Invoice</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />

<script src="../../javascript/jquery.js"></script>
<!-- * Alert * -->
<!--<script src="../mootools/SexyAlertBox/mootools.js" type="text/javascript"></script>
<link rel="stylesheet" href="../mootools/SexyAlertBox/sexyalertbox.css" type="text/css" media="all" />
<script src="../mootools/SexyAlertBox/sexyalertbox.packed.js" type="text/javascript"></script>-->
<script src="supplierInvoice.js" type="text/javascript"></script>

	<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
	<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
	<script src="../../javascript/script.js" type="text/javascript"></script>

<script src="../../javascript/jquery-ui.js"></script>

<style type="text/css">
<!--
.style1 {
	color: #0000FF;
	font-weight: bold;
}

.main_bottom_center2 {
	width:auto; height:auto;
	position : absolute; 
	top : 150px; left:74px;
	background-color:#FFFFFF;
	border:1px solid;
	-moz-border-radius-bottomright:5px;
	-moz-border-radius-bottomleft:5px;
	border-bottom-color:#550000;
	border-top-color:#550000;
	border-left-color:#550000;
	background-color:#FFFFFF;
	border-right-color:#550000;
	padding-right:6px;
	padding-top:6px;
	padding-bottom:15px;
	-moz-border-radius-bottomright:5px;
	-moz-border-radius-bottomleft:5px;
	border-bottom:10px solid #550000;
}
-->
</style>

	<script type="text/javascript">
	var oldLink = null;
	// code to change the active stylesheet
	function setActiveStyleSheet(link, title) {
	  var i, a, main;
	  for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
		if(a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title")) {
		  a.disabled = true;
		  if(a.getAttribute("title") == title) a.disabled = false;
		}
	  }
	  if (oldLink) oldLink.style.fontWeight = 'normal';
	  oldLink = link;
	  link.style.fontWeight = 'bold';
	  return false;
	}
	
	// This function gets called when the end-user clicks on some date.
	function selected(cal, date) {
	  cal.sel.value = date; // just update the date in the input field.
	  if (cal.dateClicked && (cal.sel.id == "sel1" || cal.sel.id == "sel3"))
		// if we add this call we close the calendar on single-click.
		// just to exemplify both cases, we are using this only for the 1st
		// and the 3rd field, while 2nd and 4th will still require double-click.
		cal.callCloseHandler();
	}
	
	// And this gets called when the end-user clicks on the _selected_ date,
	// or clicks on the "Close" button.  It just hides the calendar without
	// destroying it.
	function closeHandler(cal) {
	  cal.hide();                        // hide the calendar
	//  cal.destroy();
	  _dynarch_popupCalendar = null;
	}
	
	// This function shows the calendar under the element having the given id.
	// It takes care of catching "mousedown" signals on document and hiding the
	// calendar if the click was outside.
	function showCalendar(id, format, showsTime, showsOtherMonths) {
	  var el = document.getElementById(id);
	  if (_dynarch_popupCalendar != null) {
		// we already have some calendar created
		_dynarch_popupCalendar.hide();                 // so we hide it first.
	  } else {
		// first-time call, create the calendar.
		var cal = new Calendar(1, null, selected, closeHandler);
		// uncomment the following line to hide the week numbers
		// cal.weekNumbers = false;
		if (typeof showsTime == "string") {
		  cal.showsTime = true;
		  cal.time24 = (showsTime == "24");
		}
		if (showsOtherMonths) {
		  cal.showsOtherMonths = true;
		}
		_dynarch_popupCalendar = cal;                  // remember it in the global var
		cal.setRange(1900, 2070);        // min/max year allowed.
		cal.create();
	  }
	  _dynarch_popupCalendar.setDateFormat(format);    // set the specified date format
	  _dynarch_popupCalendar.parseDate(el.value);      // try to parse the text in field
	  _dynarch_popupCalendar.sel = el;                 // inform it what input field we use
	
	  // the reference element that we pass to showAtElement is the button that
	  // triggers the calendar.  In this example we align the calendar bottom-right
	  // to the button.
	  _dynarch_popupCalendar.showAtElement(el.nextSibling, "Br");        // show the calendar
	
	  return false;
	}
	
	var MINUTE = 60 * 1000;
	var HOUR = 60 * MINUTE;
	var DAY = 24 * HOUR;
	var WEEK = 7 * DAY;
	
	// If this handler returns true then the "date" given as
	// parameter will be disabled.  In this example we enable
	// only days within a range of 10 days from the current
	// date.
	// You can use the functions date.getFullYear() -- returns the year
	// as 4 digit number, date.getMonth() -- returns the month as 0..11,
	// and date.getDate() -- returns the date of the month as 1..31, to
	// make heavy calculations here.  However, beware that this function
	// should be very fast, as it is called for each day in a month when
	// the calendar is (re)constructed.
	function isDisabled(date) {
	  var today = new Date();
	  return (Math.abs(date.getTime() - today.getTime()) / DAY) > 10;
	}
	
	function flatSelected(cal, date) {
	  var el = document.getElementById("preview");
	  el.innerHTML = date;
	}
	
	function showFlatCalendar() {
	  var parent = document.getElementById("display");
	
	  // construct a calendar giving only the "selected" handler.
	  var cal = new Calendar(0, null, flatSelected);
	
	  // hide week numbers
	  cal.weekNumbers = false;
	
	  // We want some dates to be disabled; see function isDisabled above
	  cal.setDisabledHandler(isDisabled);
	  cal.setDateFormat("%A, %B %e");
	
	  // this call must be the last as it might use data initialized above; if
	  // we specify a parent, as opposite to the "showCalendar" function above,
	  // then we create a flat calendar -- not popup.  Hidden, though, but...
	  cal.create(parent);
	
	  // ... we can show it here.
	  cal.show();
	}
	</script>
</head>

<body>


<form name="frmsupinv" id="frmsupinv">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF" >
	<tr>
		<td height="6" colspan="2"><?php include '../../Header.php'; ?></td>
	</tr> 
</table>
<div class="main_bottom_center2">
	<div class="main_top"><div class="main_text">Supplier Invoice</div></div>
<div class="main_body">
<table width="810" border="0" align="center" bgcolor="#FFFFFF">
 
<tr>
   <td>
<table width="100%" border="0" >
   <tr>
	<td width="65%" height="132" valign="top">	
	<table width="100%" height="113" border="0" cellpadding="0" cellspacing="0" class="button_row">
    <tr>
	<td width="1%">&nbsp;</td>
	<td width="7%" height="23" class="normalfnt">Supplier</td>
	<td colspan="4">
	<select name="cboSupplier" class="txtbox" id="cboSupplier" style="width:180px" onchange="LoadDetails();">
	<?php 
	$strSQL="SELECT strSupplierID,strTitle AS strName FROM suppliers WHERE intStatus=1 ORDER BY strTitle";
	$result = $db->RunQuery($strSQL);
	echo "<option value=\"0\"></option>" ;
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strName"] ."</option>" ;
	}
										
	?>
	</select>
    </td>
    <td width="1%">&nbsp;</td>
    <td width="11%" class="normalfnt">Batch No</td>
    <td width="23%"><select name="cboBatchNo" class="txtbox" id="cboBatchNo" style="width:180px" onchange="">
<?php 
$strSQL="SELECT batch.intBatch FROM batch ORDER BY batch.intBatch ASC";
$result = $db->RunQuery($strSQL);
echo "<option value=\"0\"></option>" ;
while($row = mysql_fetch_array($result))
{
	echo "<option value=\"". $row["intBatch"] ."\">" . $row["intBatch"] ."</option>" ;
}
?>
</select>
    </td>
	<td width="3%">&nbsp;</td>
	<td width="1%" class="normalfnt">&nbsp;</td>
	<td width="28%" colspan="4">
    
    <table width="100%" border="1" style="border:thin ;" id="tblTaxData">
  <thead>
    <td class="grid_header">&nbsp;</td>
    <td class="grid_header">Tax Type</td>
    <td class="grid_header">Rate</td>
  </thead>
  <tbody>
 <?php 
$SQL = "SELECT * FROM taxtypes WHERE intStatus=1 order by strTaxType ASC";	
//echo $SQL;	
$result = $db->RunQuery($SQL);
$i=1;
while($row = mysql_fetch_array($result))
{  //echo $i;
    $dblRate = $row['dblRate'];
	echo "<tr>";
	echo "<td><input type=\"checkbox\" id=\"".$row['dblRate']."\" onclick=\"addColumn(this);\" ></td>";
	echo "<td class=\"normalfnt\" id=\"Type\">".$row['strTaxType']."</td>";
	echo "<td class=\"normalfnt\" id=\"".$row['dblRate']."\">".$row['dblRate']."</td>";
	echo "</tr>";
	$i++;
}
 
 
 ?>  
  
  </tbody>
</table>
    
    </td>
    
 
	</tr>
      <tr>
   <td>&nbsp;</td>
   <td height="27" class="normalfnt">Type</td>
   <td colspan="4">
   <select name="cboType" class="txtbox" id="cboType" style="width:180px">
<?php 
$strSQL="SELECT strTypeID,strDescription FROM paymenttype ORDER BY intID";
$result = $db->RunQuery($strSQL);
echo "<option value=\"0\"></option>" ;
while($row = mysql_fetch_array($result))
{
	echo "<option value=\"". $row["strTypeID"] ."\">" . $row["strDescription"] ."</option>" ;
}
?> 
   </select>
   </td>
   <td>&nbsp;</td>
  <td class="normalfnt">Currency</td>
   <td>
   <select name="cboCurrency" class="txtbox" id="cboCurrency" style="width:180px" onchange="">
<?php 
$strSQL="SELECT currencytypes.intCurID, currencytypes.strCurrency FROM currencytypes WHERE currencytypes.intStatus = 1 ORDER BY
currencytypes.strCurrency ASC";
$result = $db->RunQuery($strSQL);
echo "<option value=\"0\"></option>" ;
while($row = mysql_fetch_array($result))
{
  echo "<option value=\"". $row["intCurID"] ."\">" . $row["strCurrency"] ."</option>" ;
}
?>
</select>
  </td>
<td>&nbsp;</td>
<td class="normalfnt">&nbsp;</td>
<td>&nbsp;</td>
 </tr>
 
      <tr>
        <td>&nbsp;</td>
        <td height="34" class="normalfnt">Account</td>
        <td colspan="4"><select name="cboAccount" class="txtbox" id="cboAccount" style="width:180px" onchange="">
          <?php 
$strSQL="SELECT companies.intCompanyID,companies.strName FROM companies WHERE companies.intStatus = 1 ORDER BY companies.strName ASC";
$result = $db->RunQuery($strSQL);
echo "<option value=\"0\"></option>" ;
while($row = mysql_fetch_array($result))
{
	echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
}
?>
        </select></td>
        <td>&nbsp;</td>
        <td class="normalfnt">Credit Period</td>
        <td><input type="text" name="txtCreditPeriod" id="txtCreditPeriod" style=" width:180px;" /></td>
        <td>&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
  
      </tr>
      <tr>
<td>&nbsp;</td>
<td height="23" class="normalfnt">Date</td>
<td colspan="4">
<input type="text" name="txtDate" id="txtDate" onclick="return showCalendar(this.id, '%Y-%m-%d');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" />

</td>
<td>&nbsp;</td>
<td class="normalfnt">AccPacc ID</td>
<td><input type="text" name="txtAccPaccID" id="txtAccPaccID" style=" width:180px; " />
</td>
	<td>&nbsp;</td>
	<td class="normalfnt">&nbsp;</td>

	</tr>
          						
</table>						</td>
  </tr>
</table>
		</td>
  </tr>
  <tr>
    <td>
      <table width="100%" border="0" >
        <tr>
          <td width="65%" height="130" valign="top">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="button_row">
      
              <tr>
                <td height="100" colspan="2" class="normalfnt">
                
                  <div id="divcons" style="overflow:scroll; height:230px; width:800px;">
                    <table width="1738" cellpadding="0" border="1" cellspacing="0" id="tblGridInvoice">
                      <thead id="tblhdr">
                      <tr>
                        <td width="40" height="22" class="grid_header">*</td>
                        <td width="102" class="grid_header">Invoice No</td>
                        <td width="302" class="grid_header">Description</td>
                        <td width="115" class="grid_header">Amount</td>
                        <td width="115" class="grid_header">Commission</td>
                        <td width="115" class="grid_header">Tax</td>
                        <td width="115" class="grid_header">Tax Amount</td>
                        <td width="115" class="grid_header">Tot. Amt</td>
                        <td width="115" class="grid_header">Entry No</td>
                        <td width="115" class="grid_header">Line No</td>
                        <td width="115" class="grid_header">Freight</td>
                        <td width="115" class="grid_header">Insurance</td>
                        <td width="115" class="grid_header">Other</td>
                        </tr>
                        </thead>
                    
                        <tbody>
                        
                        </tbody>
                      </table>
                    </div>
                  </td>
                </tr>
              </table>
          </td>
          </tr>
      </table></td>
  </tr>
  <tr>
    <td height="49" class="color_for_td">&nbsp;</td>
  </tr>
	<tr>
		<td class="button_row">
			<table width="100%" border="0">
				<tr>
					<td width="29%">&nbsp;</td>
					<td width="11%"><img src="../../images/new.png" alt="new" class="mouseover" onclick="ClearForm();"/></td>
					<td width="10%"><img id="btnsave" src="../../images/save.png" alt="Save" class="mouseover" onclick="getGridCommissionValues()" /></td>
					<td width="12%"><img src="../../images/report.png" alt="report" onclick="calculateTax()"/></td>
					<td width="15%"><a href="../../Header.php"><img src="../../images/close.png" alt="close" border="0" /></a></td>
					<td width="23%" >&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</div></div>
</form>

<div class="gap"></div>

</body>
</html>
