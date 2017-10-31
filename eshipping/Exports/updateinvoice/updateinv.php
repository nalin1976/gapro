<?php
$backwardseperator = "../../";
session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web|Export report </title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>



<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>


<script src="updateinv.js"></script>
<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />

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

<?php

include "../../Connector.php";

?>

<form id="title" name="title" method="POST" action="">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="19%" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="60%"><table  border="0" cellspacing="0" width="647" height="293">
          <tr>
            <td width="96%" height="26" bgcolor="#498CC2" class="TitleN2white">Document Submission</td>
            <td width="4%" bgcolor="#498CC2" class="TitleN2white"><img src="../../images/cross.png" alt="1" width="17" height="17"  class="mouseover" onclick="closeWindow()"/></td>
          </tr>
          <tr bgcolor="#D8E3FA">
            <td height="96" colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0"  >
              <tr>
                <td colspan="2" class="normalfnt"><table width="100%" border="0" bgcolor="#FFFFFF" >
                  <tr>
                    <td width="1%" class="normalfnt">&nbsp;</td>
                    <td width="11%">Carrier</td>
                    <td width="26%"><label>
                      <select name="cboDestination"  tabindex="13" class="txtbox" id="cboDestination"style="width:160px">
                        <option value=""></option>
                        <?php 
                   $sqlCity="select distinct strCarrier  from commercial_invoice_header order by strCarrier";
                   $resultCity=$db->RunQuery($sqlCity);
						 while($row=mysql_fetch_array( $resultCity)) 
						                 {
                   ?>
                   <option value="<?php echo $row['strCarrier'];?>" ><?php echo $row['strCarrier'];?></option>
                   
                   <?php 
				   
						 }?>
                      </select>
                    </label></td>
                    <td width="5%">Date</td>
                    <td width="4%"><input type="checkbox" id="chDateSelect" name="chDateSelect" onchange="showDate()" checked="checked" /></td>
                    <td width="18%"><input name="txtInvoiceDate" tabindex="2" type="text" class="txtbox" id="txtInvoiceDate2" size="10" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('Y-m-d');?>" onclick="return showCalendar(this.id, '%Y-%m-%d');" /><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                    <td width="3%">To</td>
                    <td width="19%"><input name="txtInvoiceDate2" tabindex="2" type="text" class="txtbox" id="txtInvoiceDate3" size="10" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('Y-m-d');?>" onclick="return showCalendar(this.id, '%Y-%m-%d');" /><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                    <td width="13%"><img src="../../images/search.png"  name="btnSearch"  id="btnSearch" class="mouseover"/></td>
                  </tr>
                  <tr>
                   <tr>
                    <td class="normalfnt" height="25">&nbsp;</td>
                    <td>Document</td>
                    <td><input name="txtDocument" tabindex="2" type="text" class="txtbox" id="txtDocument" size="10" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');" /><input name="reset4" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>Payments</td>
                    <td>&nbsp;</td>
                    <td><input name="txtPayments" tabindex="2" type="text" class="txtbox" id="txtPayments" size="10" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');" /><input name="reset3" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                    <td>&nbsp;</td>
                  </tr>
                    <td colspan="9" class="normalfnt"><table width="642" border="0" class="bcgl1">
                      <tr>
                        <td width="634" height="21" bgcolor="#D6E7F5" class="normalfntMid">&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td colspan="9" class="normalfnt"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td height="162" colspan="2" class="normalfnt"><table width="642" height="163">
                          <tr>
                            <td width="634" height="149"><div id="divcons" style="overflow:scroll; height:300px; width:634px;">
                              <table width="637" cellpadding="0" cellspacing="1" id="tblCommodityCode">
                                <tr>
                                  <td width="3%" height="25" bgcolor="#498CC2" class="normaltxtmidb2"><input type="checkbox" id="checkBoxAll" name="checkBoxAll" onclick="checkAll(this)" /></td>
                                  <td width="17%" bgcolor="#498CC2" class="normaltxtmidb2">Invoice no</td>
                                  <td width="20%" bgcolor="#498CC2" class="normaltxtmidb2">ISD</td>
                                  <td width="20%" bgcolor="#498CC2" class="normaltxtmidb2">Date</td>
                                  <td width="20%" bgcolor="#498CC2" class="normaltxtmidb2">Vessel</td>
                                  <td width="20%" bgcolor="#498CC2" class="normaltxtmidb2">Voyage </td>
                                </tr>
                              </table>
                            </div></td>
                          </tr>
                        </table></td>
                      </tr>
                    </table></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="34" colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0" >
              <tr>
                <td width="100%" bgcolor="#d6e7f5"><table width="100%" border="0" >
                  <tr>
                    <td width="207">&nbsp;</td>
                    <td width="91"><img src="../../images/save.png" alt="Ok" name="Ok" width="84" height="24"  class="mouseover" id="Ok" onclick="sendData();" /></td>
                    <td width="93" align="right"><img src="../../images/cancel.jpg" alt="Close" name="Close" width="84" height="24" border="0"  class="mouseover" id="Close"lass="mouseover" onclick="closeWindow()"/></td>
                    <td width="207">&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="21%" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="20" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
 
</table>
 <div style="z-index:10; position:absolute; width: 150px; visibility:hidden; left: 645px; top: 358px;" id="reportPopUp">
      <table width="100%" cellpadding="0" cellspacing="0" class="tablezRED" >
      <tr>
        
        <td width="20"><div><select name="cboReport" id="cboReport" style="width:150px" onchange="getReport();">
											<option value="" selected="selected">select one</option>
											<option value="1">East Coast</option>
											<option value="2">Web Tool</option>
                                            <option value="3">Inspection Certificate</option>
                                            <option value="4">Q2 Levis Reports</option>
											</select></div></td>
        
      </tr>
      </table>	  
  </div> 
</form>



</body>
</html>