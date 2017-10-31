<?php
session_start();
$backwardseperator = "../../";
include "$backwardseperator".''."Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Export Registry</title>
<style type="text/css"> 
body {
	background-color: #CCCCCC;
	
}

.inv-state-ok{
	text-align:center;
	font-weight:100;
	font-family:Verdana;
	font-size:12;
	color:#690;	
}

.inv-state-cancel{
	text-align:center;
	font-weight:100;
	font-family:Verdana;
	font-size:12;
	color:#FACC2E;	
}

.inv-state-not-ok{
	text-align:center;
	font-weight:100;
	text-decoration:blink;
	font-family:Verdana;
	font-size:12;
	color:#F00;	
}
.dataTable tr:hover{
	background-color:#D9FFD9;
}
</style>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery-1.4.4.min.js"></script>
<link href="../../css/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery-ui-1.8.9.custom.min.js"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="exportregistry.js" type="text/javascript"></script>
<script src="../../shipmentpackinglist/jquery.fixedheader.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
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
<style type="text/css">
.dataTable { font-family:Verdana, Arial, Helvetica, sans-serif; border-collapse: collapse; border:1px solid #999999; width: 750px; font-size:12px;}
.dataTable td, .dataTable th { padding: 0px 0px;  margin:0px;border:1px solid #D7CEFF;}

.dataTable thead a {text-decoration:none; color:#444444; }
.dataTable thead a:hover { text-decoration: underline;}

/* Firefox has missing border bug! https://bugzilla.mozilla.org/show_bug.cgi?id=410621 */
/* Firefox 2 */
html</**/body .dataTable, x:-moz-any-link {margin:1px;}
/* Firefox 3 */
html</**/body .dataTable, x:-moz-any-link, x:default {margin:1px}
</style>
</head>

<body>
<table  width="950" border="0" cellspacing="0" cellpadding="2" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include "".$backwardseperator."Header.php"; ?></td>
  </tr>
  <tr>
    <td bgcolor="#316895"  height="25" class="TitleN2white" >Export Registry</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="3" class="normalfnt">
     
      <tr>
        <td width="3%" height="40">Registry</td>
        <td width="7%"><select name="cboInvoiceType"  class="txtbox" tabindex="7" id="cboInvoiceType" style="width:160px">
          <option value="F" >Final</option>
            <option value="P" >Proforma</option>
        </select></td>
        <td width="4%" height="40">Location</td>
        <td width="23%"><select name="cboLocation" style="width:150px" id="cboLocation" class="txtbox" onchange="loadLocation();">
							<option value="0"></option>
							<?php
								$sql="SELECT
										customers.strCustomerID,
										customers.strMLocation
										FROM
										customers;";
										
								$result=$db->RunQuery($sql);
								while($row=mysql_fetch_array($result))
								{ 
							?>
								<option value="<?php echo $row['strCustomerID']; ?>"><?php echo $row['strMLocation']; ?></option>
								<?php
								}
								?>
						</select></td>
        <td width="10%" valign="middle">Date <input type="checkbox" id="cbxSetDate" name="cbxSetDate" /></td>
        <td width="44%">From
          <input name="txtDateFrom" tabindex="16" type="text" class="txtbox" id="txtDateFrom" style="width:70px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"   onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset3" type="reset"  class="txtbox" style="visibility:hidden;width:2px;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" />
          To 
          <input name="txtDateTo" tabindex="16" type="text" class="txtbox" id="txtDateTo" style="width:70px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset4" type="reset"  class="txtbox" style="visibility:hidden;width:2px;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
        
        <td width="3%"><img src="../../images/search.png" width="71" height="24" id="btnSearch" class="mouseover"/></td>
        <td width="3%"><img src="../../images/report.png" width="71" height="24" title="Report" onclick="reportDetail()"/></td>
        <td width="3%"><img src="../../images/save_small.jpg" width="27" height="24" align="middle" class="mouseover" onclick="saveDetail()" title="Save "/></td>
		
      </tr>
      
    </table></td>
  </tr>
  <tr>
                          <td colspan="6">
                          	<fieldset class="roundedCorners" >
                            <legend class="legendHeader">&nbsp;Search&nbsp;</legend>
                            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                  <tr>
                    <td width="6" class="normalfntMid">&nbsp;</td>
                    <td width="76" class="normalfnt">Invoice No</td>
                    <td width="158"><input name="txtCDNInvNo" type="text" maxlength="100" class="txtbox" id="txtCDNInvNo" size="25" style="width:130px" onkeyup="changeCDNInvCombo(this,event);" onload="abc();"/></td>
                    <td width="287" class="normalfnt">PO No</td>
                    <td width="132"><input name="txtCDNBuyerPO" type="text" maxlength="100" class="txtbox" id="txtCDNBuyerPO" size="25" style="width:130px" onkeyup="changeCDNPoCombo(this,event);" onload="abc();"/></td>
                  
                  <td width="1130" class="normalfnt">Style No</td>
                   <td width="163"><input name="txtStyleNo" type="text" maxlength="100" class="txtbox" id="txtStyleNo" size="25" style="width:130px" onkeyup="changeStyleNoCombo(this,event);" onload="abc();"/></td>
                  
                   <td width="67" class="normalfnt">Buyer</td>
                   <td width="850"><input name="txtbuyer" type="text" maxlength="100" class="txtbox" id="txtbuyer" size="25" style="width:130px" onkeyup="changetxtbuyerCombo(this,event);" onload="abc();"/></td>
                  
                  <td width="63" class="normalfnt">Lot No</td>
                   <td width="855"><input name="txtlotNo" type="text" maxlength="100" class="txtbox" id="txtlotNo" size="25" style="width:130px" onkeyup="loadLotNo(this,event);" onload="abc();"/></td> 
                 
                  </tr>
                </table></fieldset>
                          
                          </td>
                          </tr>
  <tr>
    <td height="500" valign="top"><table style="width:1200px;"  cellpadding="3" cellspacing="1" bgcolor="#EFDEFE"  id="tblER" class="dataTable">
      <thead>
        <tr class="mainHeading4 normaltxtmidb2 " >
          <th height="31"  bgcolor="#498CC2">Invoice #</th>
           <th height="31" bgcolor="#498CC2">Value</th>
           <th height="31" bgcolor="#498CC2">Status</th>
          <th height="31"  bgcolor="#498CC2">Buyer</th>
           <th height="31" bgcolor="#498CC2">Mode</th>
          <th height="31"  bgcolor="#498CC2" >Vessel / Flight</th>
          <th height="31" bgcolor="#498CC2">CBM</th>
          <th height="31"  bgcolor="#498CC2">ETD</th>
          <th height="31"  bgcolor="#498CC2">ETA</th>
          <th height="31"  bgcolor="#498CC2">ENTRY NO</th>
          <th height="31"  bgcolor="#498CC2">EXPORT NO</th>
          <th height="31"  bgcolor="#498CC2">FILE NO</th>
          <th height="31"  bgcolor="#498CC2">LOT NO</th>
          <th height="31"  bgcolor="#498CC2">PO No</th>
		  <th height="31"  bgcolor="#498CC2">Material No </th>
		  <th height="31"  bgcolor="#498CC2">ISD No  </th>
		  <th height="31"  bgcolor="#498CC2">Type Of Garment </th>
		  <th height="31"  bgcolor="#498CC2">No Of CTN </th>
		  <th height="31"  bgcolor="#498CC2">Qty (PCS) </th>
          <th height="31"  bgcolor="#498CC2">Fabric</th>
		  <th height="31"  bgcolor="#498CC2">BL / AWB # </th>
		  <th height="31"  bgcolor="#498CC2">Cont. No  </th>
		  <th height="31"  bgcolor="#498CC2">Cont Size </th>
		  <th height="31"  bgcolor="#498CC2">Freight Payment </th>
		  <th height="31"  bgcolor="#498CC2">Payment Term </th>
		  <th height="31"  bgcolor="#498CC2">Destination (Country)</th>
		  <th height="31"  bgcolor="#498CC2">Destination (Port)</th>
		  <th height="31"  bgcolor="#498CC2">Agent</th>
		  <th height="31"  bgcolor="#498CC2">EX FTY </th>
		  <th height="31"  bgcolor="#498CC2">Date Of Export </th>
          <th height="31"  bgcolor="#498CC2">Doc Due</th>
          <th height="31"  bgcolor="#498CC2">Doc Sub </th>
          <th height="31"  bgcolor="#498CC2">Pay Due</th>
          <th height="31"  bgcolor="#498CC2">Pay Sub</th>
          <th height="31"  bgcolor="#498CC2">Month </th>
          <th height="31"  bgcolor="#498CC2">View</th>
        </tr>
      </thead>
      <tbody>
       <tr style="background-color:#498CC2;border-spacing:0px;" >
          <th style="visibility:hidden;" ><input type="text" style="width: 150px;height:2px; visibility:hidden" class="txtbox" /></th>
          <th  ><input type="text" style="width: 80px;height:2px; visibility:hidden" class="txtbox" /></th>
          <th  ><input type="text" style="width: 80px;height:2px; visibility:hidden" class="txtbox" /></th>
          <th style="background-color:#498CC2"  ><input type="text" style="width: 300px;height:2px; visibility:hidden" class="txtbox" /></th>
          <th style="background-color:#498CC2" ><input type="text" style="width: 80px;height:2px; visibility:hidden" class="txtbox" /></th>
          <th  style="background-color:#498CC2" ><input type="text" style="width: 100px;height:2px; visibility:hidden" class="txtbox" /></th>
          <th  style="background-color:#498CC2" ><input type="text" style="width: 80px;height:2px; visibility:hidden" class="txtbox" /></th>
          <th style="background-color:#498CC2" ><input type="text" style="width: 80px;height:2px; visibility:hidden" class="txtbox" /></th>
          <th style="background-color:#498CC2" ><input type="text" style="width: 80px;height:2px; visibility:hidden" class="txtbox" /></th>
          <th style="background-color:#498CC2" ><input type="text" style="width: 80px;height:2px; visibility:hidden" class="txtbox" /></th>
          <th style="background-color:#498CC2" ><input type="text" style="width: 80px;height:2px; visibility:hidden" class="txtbox" /></th>
          <th style="background-color:#498CC2" ><input type="text" style="width: 80px;height:2px; visibility:hidden" class="txtbox" /></th>
          <th  style="background-color:#498CC2" ><input type="text" style="width: 80px;height:2px; visibility:hidden" class="txtbox" /></th>
          <th style="background-color:#498CC2" ><input type="text" style="width: 100px;height:2px; visibility:hidden" class="txtbox" /></th>
		   <th style="background-color:#498CC2" ><input type="text" style="width: 100px;height:2px; visibility:hidden" class="txtbox" /></th>
		   <th style="background-color:#498CC2" ><input type="text" style="width: 100px;height:2px; visibility:hidden" class="txtbox" /></th>
		   <th style="background-color:#498CC2" ><input type="text" style="width: 100px;height:2px; visibility:hidden" class="txtbox" /></th>
           <th style="background-color:#498CC2" ><input type="text" style="width: 100px;height:2px; visibility:hidden" class="txtbox" /></th>
		    <th style="background-color:#498CC2" ><input type="text" style="width: 100px;height:2px; visibility:hidden" class="txtbox" /></th>
			<th style="background-color:#498CC2" ><input type="text" style="width: 100px;height:2px; visibility:hidden" class="txtbox" /></th>
			<th style="background-color:#498CC2" ><input type="text" style="width: 100px;height:2px; visibility:hidden" class="txtbox" /></th>
			<th style="background-color:#498CC2" ><input type="text" style="width: 100px;height:2px; visibility:hidden" class="txtbox" /></th>
			<th style="background-color:#498CC2" ><input type="text" style="width: 100px;height:2px; visibility:hidden" class="txtbox" /></th>
			<th style="background-color:#498CC2" ><input type="text" style="width: 100px;height:2px; visibility:hidden" class="txtbox" /></th>
			<th style="background-color:#498CC2" ><input type="text" style="width: 100px;height:2px; visibility:hidden" class="txtbox" /></th>
			<th style="background-color:#498CC2" ><input type="text" style="width: 100px;height:2px; visibility:hidden" class="txtbox" /></th>
			<th style="background-color:#498CC2" ><input type="text" style="width: 100px;height:2px; visibility:hidden" class="txtbox" /></th>
			<th style="background-color:#498CC2" ><input type="text" style="width: 100px;height:2px; visibility:hidden" class="txtbox" /></th>
			<th style="background-color:#498CC2" ><input type="text" style="width: 100px;height:2px; visibility:hidden" class="txtbox" /></th>
			<th style="background-color:#498CC2" ><input type="text" style="width: 100px;height:2px; visibility:hidden" class="txtbox" /></th>
            <th style="background-color:#498CC2" ><input type="text" style="width: 100px;height:2px; visibility:hidden" class="txtbox" /></th>
            <th style="background-color:#498CC2" ><input type="text" style="width: 100px;height:2px; visibility:hidden" class="txtbox" /></th>
            <th style="background-color:#498CC2" ><input type="text" style="width: 100px;height:2px; visibility:hidden" class="txtbox" /></th>
            <th style="background-color:#498CC2" ><input type="text" style="width: 100px;height:2px; visibility:hidden" class="txtbox" /></th>
           <th style="background-color:#498CC2" ><input type="text" style="width: 100px;height:2px; visibility:hidden" class="txtbox" /></th>
			<th style="background-color:#498CC2" ><input type="text" style="width: 100px;height:2px; visibility:hidden" class="txtbox" /></th>
          </tr>
      </tbody>
    </table></td>
  </tr>
  <tr>
  		<td height="10"></td>
  </tr>
</table>
</body>
</html>