<?php
	session_start();
	

	include("../../Connector.php");
	$backwardseperator = "../../";
	$companyID=$_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web - Forwarder Payment</title>

<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
	
}

-->
</style>

<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<link type="text/css" href="../../css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="../jquery.fixedheader.js"></script>

<script type="text/javascript" src="payment.js"></script>

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
.tableGrid{
	border:1px solid #cccccc;
}

.tableGrid thead{
	background-color:#7cabc4;
	text-align:center;
	color:#ffffff;
	padding:10px 5px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:11px;
}

.tableGrid tbody{
	background-color:#e3e9ec;
	text-align:left;
	color:#333333;
	padding:4px;
}
</style>
</head>


<body>
<form name="frmFabricIns" id="frmFabricIns" >
<table width="700" border="0" align="center" bgcolor="#FFFFFF" cellspacing="0">
	<tr>
    	<td><?php include '../../Header.php'; ?></td>
	</tr>
  	<tr>
    	<td bgcolor="#316895" class="TitleN2white" style="text-align:center">&nbsp;Forwarder Payment</td>
    </tr>
  	<tr>
    	<td>
			<table align="center" width="488" style="margin-top:15px;">
				<tr>
					<td width="109" class="normalfnt">Forwader</td>
					<td colspan="3">
						<select name="cboForwader" style="width:350px" id="cboForwader" class="txtbox" onchange="clearGrid();">
							<option value="0"></option>
							<?php
								$sql="SELECT intForwaderID,strName FROM forwaders ORDER BY strName ;"; 
								$result=$db->RunQuery($sql);
								while($row=mysql_fetch_array($result))
								{
							?>
							<option value="<?php echo $row['intForwaderID']; ?>"><?php echo $row['strName']; ?></option>
							<?php
							}
							?>
						</select>		  	  	  </td>
				</tr>
				<tr>
					<td class="normalfnt">Cheque No </td>
		  	      <td width="155"><input type="text" size="20" class="txtbox" name="txtChequeNo" id="txtChequeNo" /></td>
					<td width="65" class="normalfnt">Amount</td>
	  	  	  	  <td width="139"><input type="text" size="20" class="txtbox" disabled="disabled" name="txtFullAmount" id="txtFullAmount" value="0" style="text-align:right"/></td>
				</tr>
				<tr>
				  <td class="normalfnt">Search Date </td>
				  <td><input type="checkbox" id="chk_dateRange" name="chk_dateRange" onclick="enableDateRange(this);"/></td>
				  <td class="normalfnt">No Svat</td>
				  <td><input type="checkbox" id="chk_svat" name="chk_svat" checked="checked" onclick="changeAmount(this);"/></td>
			  </tr>
				<tr>
					<td class="normalfnt">Date From</td>
			  	  <td width="155"><input name="txtDateFrom" tabindex="2" type="text" class="txtbox" id="txtDateFrom" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');" disabled="disabled"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
					<td width="65" class="normalfnt">Date To</td>
	  	  	  	  <td width="139"><input name="txtDateTo" tabindex="2" type="text" class="txtbox" id="txtDateTo" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');" disabled="disabled"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
				</tr>
				
				<tr>
					<td class="normalfnt">&nbsp;</td>
			  	  <td width="155"><img src="../../images/search.png" align="left" onclick="validateDataToLoadGrid();" class="mouseover"/></td>
					<td width="65" class="normalfnt">&nbsp;</td>
	  	  	  	  <td width="139">&nbsp;</td>
				</tr>
				
	 	  </table>
		  	<div align="center">
				<div align="center" style="width:550px; height:200px; overflow:scroll; margin-top:25px; margin-bottom:25px;">
					<table align="center" width="530" cellpadding="0" cellspacing="1" id="tblPaymentDetails" border="0" bgcolor="#CCCCFF">
						<thead>
							<tr bgcolor="#498CC2" class="normaltxtmidb2">
								<th width="43">Select</th>
								<th width="98">For. Invoice No</th>						
								<th width="82">Date</th>
								<th width="79">Amount</th>
								<th width="86">Net Amount</th>
                                <th width="86">SVat</th>
                                <th width="86">Paying Amount</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
		</td>
	</tr>
	<tr>
    	<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
         
          <tr>
            <td width="6%" bgcolor="#D6E7F5">&nbsp;</td>
            <td width="6%" bgcolor="#D6E7F5">&nbsp;</td>
            <td width="9%" bgcolor="#D6E7F5">&nbsp;</td>
            <td width="6%" bgcolor="#D6E7F5">&nbsp;</td>
            <td width="8%" bgcolor="#D6E7F5">&nbsp;</td>
            <td width="12%" bgcolor="#D6E7F5"><img src="../../images/new.png" alt="new" name="" width="115" height="24" class="mouseover"  id="" onclick="clearForm();"/></td>
            <td width="9%" bgcolor="#D6E7F5"><img src="../../images/save.png" alt="new" name="butIouSave" width="84" height="24" class="mouseover"  id="butIouSave" onclick="validateData();"/></td>
            <td width="10%" bgcolor="#D6E7F5"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
            <td width="34%" bgcolor="#D6E7F5">&nbsp;</td>
          </tr>
        </table>
		</td>
	</tr>
</table>