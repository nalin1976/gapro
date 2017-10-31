<?php
	session_start();
	

	include("../../Connector.php");
	$backwardseperator = "../../";
	$companyID=$_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>eShipping Web - Import IOU List</title>
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
<script src="cusdec.js" type="text/javascript"></script>
<script src="cusdecdescription.js" type="text/javascript"></script>
<script src="iou.js" type="text/javascript"></script>
<script src="search.js" type="text/javascript"></script>
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
<link type="text/css" href="../../css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="../../js/jquery-ui-1.7.2.custom.min.js"></script>
		<script type="text/javascript">
			$(function(){

				// Accordion
				$("#accordion").accordion({ header: "h3" });
	
				// Tabs
				$('#tabs').tabs();
	

				// Dialog			
				$('#dialog').dialog({
					autoOpen: false,
					width: 600,
					buttons: {
						"Ok": function() { 
							$(this).dialog("close"); 
						}, 
						"Cancel": function() { 
							$(this).dialog("close"); 
						} 
					}
				});
				
				// Dialog Link
				$('#dialog_link').click(function(){
					$('#dialog').dialog('open');
					return false;
				});

				// Datepicker
				$('#datepicker').datepicker({
					inline: true
				});
				
				// Slider
				$('#slider').slider({
					range: true,
					values: [17, 67]
				});
				
				// Progressbar
				$("#progressbar").progressbar({
					value: 20 
				});
				
				//hover states on the static widgets
				$('#dialog_link, ul#icons li').hover(
					function() { $(this).addClass('ui-state-hover'); }, 
					function() { $(this).removeClass('ui-state-hover'); }
				);
				
			});
		</script>


</head>

<body>
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
<tr>
    <td><?php include '../../Header.php';  ?></td>
</tr>
<tr>
    <td height="9" align="center" ></td>
</tr>
<tr>
	<td>
	<table border="0" cellspacing=""="0"  width="100%"><tr><td>
	<table border="0" cellspacing="0" bgcolor="#ffffff"  width="100%" class="normalfnt">
	  <tr>
	    <td height="23">&nbsp;</td>
	    <td colspan="4" bgcolor="#498cc2"  ><div class="TitleN2white">Import IOU List View</div></td>
	    <td>&nbsp;</td>
	    </tr>
	  <tr>
	    <td width="23%">&nbsp;</td>
	    <td width="12%">&nbsp;</td>
	    <td width="15%">&nbsp;</td>
	    <td width="12%">&nbsp;</td>
	    <td width="15%">&nbsp;</td>
	    <td width="23%">&nbsp;</td>
	    </tr>
	  
	  <tr>
	    <td>&nbsp;</td>
	    <td colspan="4" class="bcgl1">
		<table border="0" cellspacing="0" class="normalfnt" bgcolor="#ffffff" width="100%">
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;&nbsp;Category</td>
			  <td colspan="2"><select name="select" class="txtbox" id="select" style="width:200px">
                <option value="0">--Select Category--</option>
                <option value="1">IOU</option>
                <option value="2">Canceled IOU</option>
                <option value="3">Settled IOU</option>
                <option value="4">Settled and Canceled IOU</option>
                <option value="5">IOU Invoice</option>
              </select></td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;&nbsp;From Date </td>
			  <td><input name="txtVoyageDate" type="text" class="txtbox" id="txtVoyageDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
			  <td>&nbsp;&nbsp;To Date</td>
			  <td><input name="txtVoyageDate2" type="text" class="txtbox" id="txtVoyageDate2" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
			  </tr>
			
			
			<tr>
			  <td width="18%">&nbsp;</td>
			  <td width="32%">&nbsp;</td>
			  <td width="18%">&nbsp;</td>
			  <td width="32%">&nbsp;</td>
			</tr></table>		</td>
	    <td>&nbsp;</td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td colspan="4" class="bcgl1"><table border="0" cellspacing="0" class="normalfnt" bgcolor="#ffffff" width="100%">
          <tr>
            <td height="22" colspan="6" class="bcgcolor">&nbsp;Select Required Columns</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="center"><input type="checkbox" class="txtbox" value="c1"  checked="checked"/></div></td>
            <td>IOU Number </td>
            <td><div align="center"><input type="checkbox" class="txtbox" value="c1" /></div></td>
            <td>Invoice Total </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="center"><input type="checkbox" class="txtbox" value="c1" /></div></td>
            <td>IOU Invoice No </td>
            <td><div align="center"><input type="checkbox" class="txtbox" value="c1" /></div></td>
            <td>Wharf Clerk </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="center"><input type="checkbox" class="txtbox" value="c1" /></div></td>
            <td>Date</td>
            <td><div align="center"><input type="checkbox" class="txtbox" value="c1" /></div></td>
            <td>User</td>
            <td>&nbsp;</td>
          </tr>
         
          <tr>
            <td width="10%">&nbsp;</td>
            <td width="10%"><div align="center"><input type="checkbox" class="txtbox" value="c1" /></div></td>
            <td width="30%">Customer</td>
            <td width="10%">&nbsp;</td>
            <td width="30%">&nbsp;</td>
            <td width="10%">&nbsp;</td>
          </tr>
		   <tr>
            <td height="37">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><img src="../../images/go.png" alt="g" width="30" height="22" class="mouseover" /></td>
          </tr>
	      </table></td>
	    <td>&nbsp;</td>
	    </tr>
	  <tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr></table>
	
	</td></tr></table>
	</td>
</tr>
</table>

</body>
</html>
