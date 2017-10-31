<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />

<link type="text/css" href="../../css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
<link href="../../js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="mainPagePanelViewers/sewingProduction/sewingProductionJS.js"></script>

<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js"></script>
<script src="Efficiencyscreen.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.7.2.custom.min.js"></script>

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

<link href="../panelCSS.css" rel="stylesheet" type="text/css" />
  <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
    <tr>
      <td align="center" class="normalfnt">
      <table width="950" height="550" border="0" cellpadding="5" cellspacing="0">
        <tr>
          <td valign="top"><table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="1">
            <tr>
              <td width="29%" valign="top">
               <fieldset  class="fieldsetPnl"><legend class="lengendfntPnl">Search</legend>
              <table width="100%" height="200" border="0" align="center" cellpadding="0" cellspacing="1">
                <tr>
                  <td height="3"></td>
                  <td></td>
                </tr>
                <tr>
                  <td width="32%" height="23">&nbsp;Factory</td>
                  <td width="68%"><select name="cmbSrchFacPD" class="txtbox" id="cmbSrchFacPD" style="width:150px"></select></td>
                  </tr>
                <tr>
                  <td height="23">&nbsp;Line No</td>
                  <td><select name="cmbSrchLinePD" class="txtbox" id="cmbSrchLinePD" style="width:150px"></select></td>
                  </tr>
                <tr>
                  <td height="23">&nbsp;Date</td>
                  <td><input  name="txtSrchDatePD" type="text" class="txtbox" id="txtSrchDatePD" style="width:76px;"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo date("Y-m-d");?>"/><input type="text" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
       
                  
                  </tr>
                <tr>
                  <td height="32">&nbsp;</td>
                  <td valign="middle"><img src="images/btSearch.png" width="78" height="23" onclick="searchDataPD();"/></td>
                  </tr>
                <tr>
                  <td colspan="2">
                  <fieldset  class="fieldsetPnl" style="background-color:#ffffd4;">
                  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="10" height="1"></td>
                      <td width="68"></td>
                      <td width="60"></td>
                      <td width="72"></td>
                      <td width="55"></td>
                    </tr>
                    <tr>
                      <td height="16" colspan="5"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFCC99">
                        <tr>
                          <td height="5"></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                        <tr>
                          <td width="25" height="16"></td>
                          <td width="15" bgcolor="#67909a" class="border-All"></td>
                          <td width="100">&nbsp;-&nbsp;Target</td>
                          <td width="15" bgcolor="#bd5559" class="border-All"></td>
                          <td >&nbsp;-&nbsp;Actual</td>
                        </tr>
                        <tr>
                          <td height="5"></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                      </table></td>
                      </tr>
                    <tr>
                      <td height="7" colspan="5"></td>
                      </tr>
                    <tr>
                      <td height="20"></td>
                      <td>Target qty</td>
                      <td id="lbTotTarQty">: 0</td>
                      <td>Actual qty</td>
                      <td id="lbTotActQty">: 0</td>
                    </tr>
                    <tr>
                      <td height="20"></td>
                      <td>Variance</td>
                      <td id="lbVariance">: 0</td>
                      <td>Others qty</td>
                      <td id="lbOtherQty">: 0</td>
                    </tr>
                    <tr>
                      <td height="1"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </table>
                  </fieldset>
                  </td>
                  </tr>
                </table>
               </fieldset></td>
              <td width="71%" valign="top">
              <fieldset  class="fieldsetPnl">
              <legend class="lengendfntPnl">Graphic view</legend>
              <table width="100%" height="200" border="0" align="center" cellpadding="0" cellspacing="1">
                <tr>
                  <td>
                  <div id="graphicDivPD" style="width:650px;height:198px;overflow:scroll;overflow-x:hidden;overflow-y:hidden;">
                 	
                  </div>
                  
                  </td>
                  </tr>
                </table></fieldset>
              </td>
              </tr>
            <tr>
              <td colspan="2" valign="top">
              <fieldset  class="fieldsetPnl"><legend class="lengendfntPnl">Details View</legend>
              <table width="930" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td>
                  <div id="mainGridHeadDivPD" style="width:913px;height:61px;overflow:scroll;overflow-x:hidden;overflow-y:hidden;">
                    <table  style="width:913px;" border="0" cellpadding="0" cellspacing="1" id="table1PD" bgcolor="#FFFFFF">
                      <tr class="gridHdrTxtPnlMn">
                          
                          <td colspan="4" height="30" bgcolor="#66CC00">Target</td>
                          <td style="background-color:#FFF;"></td>
                          <td colspan="5" bgcolor="#FF6600">Actual</td>
                      </tr>
                      <tr bgcolor="#fbbf6f" class="gridHdrTxtPnl" >
                                              
                        <td width="80" height="30">Start Time</td>
                        <td width="80">End Time</td>
          				<td width="215">Order no</td>
                        <td width="80">Qty</td>
                        
                        <td style="background-color:#FFF;"> </td>
                        
                       
                        <td width="80">Achieve Time</td>
                        <td width="285">Order no</td>
                        <td width="80">Qty</td>
                      </tr>
                    </table>
                  </div>
                  </td>
                  </tr>
                <tr>
                  <td><div id="mainGridDataDivPD" style="overflow:scroll; height:250px; width:930px;" onmousedown="scrollGridHead('mainGridHeadDivPD','mainGridDataDivPD');"></div></td>
                  </tr>
              </table></fieldset></td>
              </tr>
          </table></td>
          </tr>
      </table></td>
    </tr>
  </table>
