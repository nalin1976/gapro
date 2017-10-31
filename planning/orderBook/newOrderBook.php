<?php
 session_start();
 include "../../Connector.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Learning Curves</title>

<link href="file:///C|/Program Files/Inetpub/wwwroot/eplan/css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../css/planning.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="orderBook-js.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<script type="text/javascript" src="../../javascript/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<link href="../../css/rb.css" rel="stylesheet" type="text/css" />

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

</head>

<table width="407" height="243" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr class="cursercross" onmousedown="grab(document.getElementById('newOrderBookPop'),event);">
            <td width="419" height="41" bgcolor="#498CC2" class="mainHeading">New Order Book</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="88%">
          <table width="100%" border="0">

            <tr>
              <td height="239"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="">
			  <tr>
                  <td height="12">&nbsp;</td>
				   <td height="12">&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt" >&nbsp;</td>
                  <td class="normalfnt" >&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td width="8%" height="23">&nbsp;</td>
				   <td width="7%" height="23">&nbsp;</td>
                  <td width="7%" class="normalfnt">&nbsp;</td>
                  <td width="25%" class="normalfnt">Style Id </td>
                  <td width="38%"><input tabindex="2" name="txtStyleId" type="text" id="txtStyleId" style="width:160px" maxlength="10" onkeyup="changeDescription(this);"/></td>
                  <td width="15%">&nbsp;</td>
                </tr>
                <tr>
                  <td height="25">&nbsp;</td>
				   <td height="25">&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt" >Description</td>
                  <td class="normalfnt" ><input tabindex="2" name="txtDescription" type="text" id="txtDescription" style="width:160px" maxlength="10" disabled="disabled"/></td>
                  <td>&nbsp;</td>
                </tr>
           <tr>
                  <td height="12">&nbsp;</td>
				   <td height="12">&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt" >Quantity</td>
                  <td class="normalfnt"><input name="txtQuantity" type="text" id="txtQuantity" style="width:102px" maxlength="10" /></td>
                  <td>&nbsp;</td>
                </tr>
           <tr>
             <td height="28">&nbsp;</td>
			  <td height="28">&nbsp;</td>
             <td class="normalfnt">&nbsp;</td>
             <td class="normalfnt" >CutDate</td>
             <td class="normalfnt" ><input name="txtCutDate" type="text"  class="txtbox" id="txtCutDate" size="15" onclick="return showCalendar(this.id, '%Y-%m-%d');" readonly="true"/><input name="reset1" type="reset"  class="txtbox" style="visibility:hidden; z-index:1005"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
             <td>&nbsp;</td>
           </tr>
		    <tr>
                  <td height="12">&nbsp;</td>
				   <td height="12">&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt" >ExFacDate</td>
                  <td class="normalfnt" ><input name="txtExFacDate" type="text"  class="txtbox" id="txtExFacDate" size="15" onclick="return showCalendar(this.id, '%Y-%m-%d');" readonly="true"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                  <td>&nbsp;</td>
                </tr>
				 <tr>
                  <td height="26">&nbsp;</td>
				   <td height="26">&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt" >SMV</td>
                  <td class="normalfnt" ><input tabindex="2" name="txtSMV" type="text" id="txtSMV" style="width:102px" maxlength="10" onkeypress="return isNumberKey(event);" /></td>
                  <td>&nbsp;</td>
                </tr>
				 <tr>
                  <td height="12">&nbsp;</td>
				   <td height="12">&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt" >Cutting SMV</td>
                  <td class="normalfnt" ><input tabindex="2" name="txtCuttingSMV" type="text" id="txtCuttingSMV" style="width:102px" maxlength="10" onkeypress="return isNumberKey(event);" /></td>
                  <td>&nbsp;</td>
                </tr> 
				 <tr>
                  <td height="24">&nbsp;</td>
				   <td height="24">&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt" >Sewing SMV</td>
                  <td class="normalfnt" ><input tabindex="2" name="txtSewingSMV" type="text" id="txtSewingSMV" style="width:102px" maxlength="10" onkeypress="return isNumberKey(event);" /></td>
                  <td>&nbsp;</td>
                </tr>  
				 <tr>
                  <td height="25">&nbsp;</td>
				   <td height="25">&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt" >PackingSMV</td>
                  <td class="normalfnt" ><input tabindex="2" name="txtPackingSMV" type="text" id="txtPackingSMV" style="width:102px" maxlength="10" onkeypress="return isNumberKey(event);" /></td>
                  <td>&nbsp;</td>
                </tr>  
				 <tr>
                  <td height="12">&nbsp;</td>
				   <td height="12">&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt" >&nbsp;</td>
                  <td class="normalfnt" >&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>                                
              </table></td>
            </tr>
			<td height="52"><table width="100%" height="50" border="0" cellpadding="0" cellspacing="0">
                <tr>
				
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
			  
                <td width="70%" bgcolor=""><table width="119%" border="0" class="tableFooter">
                    <tr>
                     <td width="60" height="12"><div align="center"></div></td>
                  <td width="97"><div align="center"><span class="normalfntp2"><img src="../../images/new.png" class="mouseover" alt="report" width="96" height="24" onclick="clearFields();"/></span></div></td>
                  <td width="85"><div align="center"><span class="normalfntp2"><img src="../../images/save.png" class="mouseover" alt="report" width="84" height="24" onclick="validateData()" /></span></div></td>
                  <td width="108"><div align="center"><span class="normalfntp2"><img src="../../images/close.png" class="mouseover" alt="close" width="97" height="24" border="0" onclick="closePopupBox(1002);" /></span></div></td>
				  <td width="19">&nbsp;</td>
                      
                    </tr>
                </table></td>
              </tr>
            </table></td>
                </tr>
              </table></td>
            </tr>
          </table>
       </td>
        
      </tr>
    </table></td>
  </tr>
  <tr>
    
  </tr>
</table>
</body>
</html>
