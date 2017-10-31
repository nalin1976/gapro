<?php
	session_start();
	include("../Connector.php");
	$backwardseperator = "../../";	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Fabric Inspection</title>

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
<script src="../../AATestRB/InterJob/java.js" type="text/javascript"></script>
<script src="../NewFabricInspectionJS.js"></script>
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

<body onload="setDefaultDate()">
<form name="frmFabricIns" id="frmFabricIns" >
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
<tr>
    <td><?php include '../../Header.php'; 
 ?></td>
</tr>
  <tr>
    <td height="12" colspan="2" bgcolor="#316895" class="TitleN2white">Visa Form </td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
	<tr class="bcgl1txt1NB">
	  <td>
      <div  id="tabs" >
			<ul>
				<li><a href="#tabs-1">VISA</a></li>
				<li><a href="#tabs-2">DETAILS</a></li>
				<li><a href="#tabs-3">DESCRIPTION</a></li>
			</ul>
			<div id="tabs-1">
			  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="89%" bgcolor="#9BBFDD" class="head1">Header Information </td>
        <td width="11%" bgcolor="#9BBFDD" class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td height="280" colspan="2" class="normalfnt">
		<div id="divcons" style="overflow:scroll; height:350px; width:100%px;">
		<table width="108%" height="229" id="tblGen">
		    <tr>
              <td height="35"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
                <tr>
                  <td width="9%">&nbsp;</td>
                  <td width="8%">&nbsp;</td>
                  <td width="17%">Select Invoice </td>
                  <td width="15%"><select name="cboBankName"  onchange="getBankDetails();" class="txtbox" id="cboBankName"style="width:120px">
                  </select></td>
                  <td width="8%">&nbsp;</td>
                  <td width="14%">&nbsp;</td>
                  <td width="12%">&nbsp;</td>
                  <td width="4%">&nbsp;</td>
                  <td width="13%">&nbsp;</td>
                </tr>
              </table></td>
		      </tr>
		    <tr>
		      <td height="65"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
                <tr>
                  <td width="17%">&nbsp;</td>
                  <td width="17%">Shipper(Company)</td>
                  <td width="44%"><input name="txtClrShading223323233" type="text" class="txtbox" id="txtClrShading223323233" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="25" maxlength="10" /></td>
                  <td width="22%">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Consignee</td>
                  <td><input name="txtClrShading2233232332" type="text" class="txtbox" id="txtClrShading2233232332" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="25" maxlength="10" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Buyer</td>
                  <td><select name="select3"  onchange="getBankDetails();" class="txtbox" id="select3"style="width:140px">
                  </select></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>References</td>
                  <td><input name="txtClrShading2233232333" type="text" class="txtbox" id="txtClrShading2233232333" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="25" maxlength="10" /></td>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
		      </tr>
		    <tr>
		      <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
                <tr>
                  <td width="12%">&nbsp;</td>
                  <td width="22%">Terms Of Sale </td>
                  <td width="18%"><input name="txtClrShading2233232335" type="text" class="txtbox" id="txtClrShading2233232335" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="25" maxlength="10" /></td>
                  <td width="38%">Marks And No Of Packages </td>
                  <td width="10%">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Payment And Discount </td>
                  <td><input name="txtClrShading22332323353" type="text" class="txtbox" id="txtClrShading22332323353" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="25" maxlength="10" /></td>
                  <td width="38%" rowspan="4"><label for="textarea"></label>
                    <label for="textarea"></label>
                    <textarea name="textarea" cols="55" rows="5" id="textarea"></textarea></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Aditional Info </td>
                  <td><input name="txtClrShading22332323354" type="text" class="txtbox" id="txtClrShading22332323354" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="25" maxlength="10" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Document NR. </td>
                  <td><input name="txtClrShading22332323352" type="text" class="txtbox" id="txtClrShading22332323352" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="25" maxlength="10" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      </tr>
		</table>
		</div>		</td>
        </tr>
    </table></div>
			<div id="tabs-2" style="height:600"><table height="563" width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="89%" height="21" bgcolor="#9BBFDD" class="head1">Details</td>
        <td width="11%" bgcolor="#9BBFDD" class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td height="280" colspan="2" class="normalfnt">
		<div id="divcons" style="overflow:hidden; height:540px; width:100%px;">
		<table width="100%" height="323" class="bcgl1">
		  <tr>
		    <td width="107" height="15">Invoice No </td>
		    <td width="187"><input name="txtClrShading2233232336" type="text" class="txtbox" id="txtClrShading2233232336" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="25" maxlength="10" /></td>
		    <td width="147" >&nbsp;</td>
		    <td width="147" >&nbsp;</td>
		    <td width="147" >&nbsp;</td>
		    <td width="148" >&nbsp;</td>
			<td width="148" >&nbsp;</td>
		    </tr>
		<tr>
		<td height="80" colspan="6" ><div id="divDescription" style="height:250px"><table width="900" cellpadding="0" cellspacing="0" id="tblMainGrn">
          <tr>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">&nbsp;</td>
            <td width="13%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">Position</td>
            <td width="14%" bgcolor="#498CC2" class="normaltxtmidb2">Style No </td>
            <td width="24%" bgcolor="#498CC2" class="normaltxtmidb2">Description</td>
            <td width="12%" bgcolor="#498CC2" class="normaltxtmidb2"><blockquote>
              <p>Qty</p>
            </blockquote></td>
            <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Unit</td>
            <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Qty</td>
            <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Unit Price </td>
            <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">Category No </td>
            </tr>
			<tr>
              <td    class="normalfnt">&nbsp;</td>
              <td    class="normalfnt">1</td>
              <td    class="normalfnt"> Description </td>
              <td    class="normalfnt">Unit</td>
              <td    class="normalfnt">500</td>
              <td    class="normalfnt">1200</td>
              <td    class="normalfnt">250</td>
              <td    class="normalfnt">22</td>
			  <td    class="normalfnt">22</td>
              </tr>

		  </table>
		</div></td>
		<td width="148" >&nbsp;</td>
		</tr>
		<tr>
		  <td colspan="6" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr bgcolor="#D6E7F5">
              <td width="23%" height="29" bgcolor="#CCCCCC">&nbsp;</td>
              <td width="11%" bgcolor="#CCCCCC">&nbsp;</td>
              <td width="13%" bgcolor="#CCCCCC">&nbsp;</td>
              <td width="11%" bgcolor="#CCCCCC">&nbsp;</td>
              <td width="13%" bgcolor="#CCCCCC">&nbsp;</td>
              <td width="29%" bgcolor="#CCCCCC">&nbsp;</td>
            </tr>
          </table></td>
          <td >&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="6" ><table width="100%" border="0" cellspacing="0" cellpadding="1">
            <tr>
              <td width="7%">&nbsp;</td>
              <td width="13%">Position</td>
              <td><input name="txtClrShading223323233624" type="text" class="txtbox" id="txtClrShading223323233624" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="40" maxlength="10" /></td>
              <td colspan="2">Description Of Goods</td>
              </tr>
            <tr>
              <td>&nbsp;</td>
              <td>Category No </td>
              <td width="30%"><input name="txtClrShading2233232336242" type="text" class="txtbox" id="txtClrShading2233232336242" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="40" maxlength="10" /></td>
              <td rowspan="4"><textarea name="textarea3" cols="70" rows="5" id="textarea3" style="width:200"></textarea></td>
              <td width="7%" colspan="-4">&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>PO No </td>
              <td><input name="txtClrShading2233232336243" type="text" class="txtbox" id="txtClrShading2233232336243" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="40" maxlength="10" /></td>
              <td colspan="-4">&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>Fabric Content </td>
              <td><input name="txtClrShading2233232336244" type="text" class="txtbox" id="txtClrShading2233232336244" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="40" maxlength="10" /></td>
              <td colspan="-4">&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td colspan="-4">&nbsp;</td>
            </tr>
          </table></td>
          <td >&nbsp;</td>
		  </tr>
		</table>
		</div>		</td>
        </tr>
    </table></div>
		<div id="tabs-3"  height:280px ><table width="100%" height="443" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="95%" height="17" bgcolor="#9BBFDD" class="normalfnth2"><div align="left" class="head1">Description</div></td>
        <td width="5%" bgcolor="#9BBFDD" class="normalfnth2">&nbsp;</td>
      </tr>
      <tr>
        <td height="394" colspan="2"><div id="divLotInterface" style=" overflow:scroll; width:100%; height:400px" >
          <table width="100%" height="287" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <blockquote>&nbsp;</blockquote>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
            </tr>
            <tr>
              <td width="5%" class="normalfnt">&nbsp;</td>
              <td width="12%" class="normalfnt">No Of Packages </td>
              <td width="13%" class="normalfnt">Detail Description </td>
              <td width="10%" class="normalfnt">Quantity</td>
              <td width="11%" class="normalfnt">Unit Price </td>
              <blockquote>&nbsp;</blockquote>
              <td width="9%" class="normalfnt">Amount</td>
              <td width="6%" class="normalfnt">&nbsp;</td>
            </tr>
            <tr>
              <td height="141" class="normalfnt">&nbsp;</td>
              <td class="normalfnt"><p>
                  <label for="label"></label>
                  <textarea name="textarea4" rows="8" id="label"></textarea>
              </p></td>
              <td class="normalfnt"><textarea name="textarea5" cols="30" rows="8" id="textarea4"></textarea></td>
              <td class="normalfnt"><textarea name="textarea6" rows="8" id="textarea5"></textarea></td>
              <td class="normalfnt"><textarea name="textarea7" cols="20" rows="8" id="textarea6"></textarea></td>
              <td class="normalfnt"><textarea name="textarea8" cols="20" rows="8" id="textarea7"></textarea></td>
              <td class="normalfnt">&nbsp;</td>
            </tr>
            <tr>
              <td class="normalfnt">&nbsp;</td>
              <td colspan="3" class="normalfnt"><label for="label2">Description</label></td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
            </tr>
            <tr>
              <td class="normalfnt">&nbsp;</td>
              <td colspan="3" rowspan="3" class="normalfnt"><textarea name="textarea9" cols="80" rows="4" id="label2"></textarea></td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
            </tr>
            <tr>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
            </tr>
            <tr>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
            </tr>
            <tr>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">Buyer Code</td>
              <td class="normalfnt"><input name="txtClrShading22332323362442" type="text" class="txtbox" id="txtClrShading22332323362442" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="40" maxlength="10" /></td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
            </tr>
          </table>
          <blockquote>&nbsp;</blockquote>
        </div>
          </p></td>
      </tr>
    </table>
			
		
		</div>
      </div>
		</td>
		</tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
      <tr>
        <td width="12%" height="29">&nbsp;</td>
        <td width="12%"><img src="../../images/new.png" alt="new" name="butNew" width="96" height="24" class="mouseover"  id="butNew" onclick="NewFabricInspection(); LotInterface(); "/></td>
        <td width="12%"><img src="../../images/cancel.jpg" width="104" height="24" onclick ="DeleteInspection();" /></td>
        <td width="12%"><img src="../../images/save.png" alt="save" name="butSave" width="84" height="24" class="mouseover" id="butSave" onclick="SaveFabricInspection();" /></td>
        <td width="14%"><img src="../../images/report.png" alt="butReportList" name="butReportList" width="108" height="24" class="mouseover" id="butReport" onclick="FabricInspectionReport();"/></td>
        <td width="14%"><a href="../../main.php"><img src="../../images/close.png" width="97" height="24" border="0" class="mouseover"  /></a></td>
        <td width="12%">&nbsp;</td>
        <td width="12%"><label></label></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>