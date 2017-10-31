<?php
	session_start();
	include("../Connector.php");
	$backwardseperator = "../";	
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

<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="../AATestRB/InterJob/java.js" type="text/javascript"></script>
<script src="NewFabricInspectionJS.js"></script>
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
<link type="text/css" href="../css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="../js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="../js/jquery-ui-1.7.2.custom.min.js"></script>
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
    <td><?php include '../Header.php'; 
 ?></td>
</tr>
  <tr>
    <td height="12" colspan="2" bgcolor="#316895" class="TitleN2white">Fabric Inspection </td>
  </tr>

  <tr>
    <td><table width="100%" border="0">
	
	<tr>
  	<td>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
		
		<tr>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" >
			<tr>
				<td width="0%">&nbsp;</td>
			    <td width="14%" class="normalfnt">Invoice No </td>
			    <td width="19%"><select name="cboInvoice" class="txtbox" id="cboInvoice" style="width:133px" onchange="LoadItem();">
                  <option  value="0" selected="selected">Select One</option>
                  <?php	
				 	$SQL = "SELECT DISTINCT grnheader.strInvoiceNo,purchaseorderheader.strSupplierID FROM grnheader INNER JOIN purchaseorderheader ON grnheader.intPoNo = purchaseorderheader.intPONo INNER JOIN grndetails ON grnheader.intGrnNo = grndetails.intgrnno INNER JOIN matitemlist ON matitemlist.intItemSerial=grndetails.intMatDetailID WHERE matitemlist.intMainCatID=1  ORDER BY grnheader.strInvoiceNo;";
					$result = $db->RunQuery($SQL);						
					while($row = mysql_fetch_array($result))
					{						
						echo "<option  value=\"". $row["strSupplierID"] ."\">" .$row["strInvoiceNo"]. "</option>" ;
					}	
				?>
                </select></td>
			    <td width="25%"><img src="../images/search.png" onclick="SearchDetails();" class="mouseover"   /></td>
			    <td colspan="2" class="normalfnt">Supplier</td>
			    <td width="32%"><input name="txtSupplier" type="text" class="txtbox" id="txtSupplier" size="50"  onfocus="this.blur();"/></td>
			    <td width="0%">&nbsp;</td>
			</tr>
			<tr>
				<td height="25">&nbsp;</td>
			    <td class="normalfnt">Item Description</td>
			    <td colspan="2"><label for="Submit"></label>			      <span style="width:320px">
			      <select name="cboDescription" class="txtbox" id="cboDescription" style="width:320px" onchange="LoadItemAndColour();" >
                    <option value="0" selected="selected">Select One</option>
                  </select>
			    </span></td>
			    <td colspan="2" class="normalfnt">Style No </td>
			    <td rowspan="2"><textarea name="txtStyleID" cols="47" class="txtbox" id="txtStyleID" onfocus="this.blur();"  ></textarea></td>
			    <td>&nbsp;</td>
			</tr>
						<tr>
				<td>&nbsp;</td>
			    <td class="normalfnt">Color</td>
			    <td colspan="2"><select name="cboColor" class="txtbox" id="cboColor" style="width:133px" onchange="SearchDetails();LoadFabricDetails();"  >
                      <option value="0" selected="selected">Select One</option>
                    </select></td>
			    <td width="5%">&nbsp;</td>
			    <td width="5%">&nbsp;</td>
			    <td>&nbsp;</td>
			</tr>
			</table>		</td>
		</tr>
		</table>	</td>
    </tr>
		
		
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
	<tr class="bcgl1txt1NB">
	  <td>
      <div  id="tabs" >
			<ul>
				<li><a href="#tabs-1">Genaral</a></li>
				<li><a href="#tabs-2">Inspection</a></li>
				<li><a href="#tabs-3">Lots</a></li>
			</ul>
			<div id="tabs-1">
			  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="89%" bgcolor="#9BBFDD" class="head1">Genaral</td>
        <td width="11%" bgcolor="#9BBFDD" class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td height="280" colspan="2" class="normalfnt">
		<div id="divcons" style="overflow:scroll; height:280px; width:100%px;">
		<table width="108%" height="459" class="bcgl1" id="tblGen">
		    <tr>
		      <td height="22"  width="18">&nbsp;</td>
		      <td class="normalfnt" width="50">&nbsp;</td>
		      <td colspan="2">&nbsp;</td>
		      <td width="1">&nbsp;</td>
		      <td colspan="3">Defect Approved </td>
		      <td width="48">Yes</td>
		      <td width="64"><input name="optDefectApprovaed" type="radio" id="optDefectApprovaedYes" value="radiobutton" /></td>
		      <td width="50">No</td>
		      <td width="99"><input name="optDefectApprovaed" type="radio" id="optDefectApprovaedNo" value="radiobutton" checked="checked" /></td>
		    </tr>
		    <tr>
		  <td height="22">&nbsp;</td>
		  <td class="normalfnt">Received Date		    </td>
		  <td colspan="2"><input onfocus="this.blur();" name="dtmRecievedDate" type="text" class="txtbox" id="dtmRecievedDate" size="20"  
		  value="<?php echo date('Y-m-d'); ?>"/></td>
		  <td>&nbsp;</td>
		  <td colspan="3">Defetive Panel Replace </td>
		    <td colspan="4"><input name="txtDefectivePannelRep" type="text" class="txtbox" id="txtDefectivePannelRep" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="35" maxlength="10" /></td>
		    </tr>
		<tr>
		<td width="18" height="22">&nbsp;		</td>
		<td width="216" class="normalfnt">Received Qty		  </td>
		<td width="143"><input name="txtReceivedQty" type="text" class="txtbox" id="txtReceivedQty" onfocus="this.blur();" size="20" maxlength="15" /></td>
		<td width="83"><select name="cmbUnits" class="txtbox" id="cmbUnits"  style="width:60px" >
          <option  value="0" selected="selected"></option>
          <?php	
					$SQL = "SELECT strUnit,strTitle	FROM units ORDER BY strTitle;";
					$result = $db->RunQuery($SQL);						
					while($row = mysql_fetch_array($result))
					{						
						echo "<option value=\"". $row["strUnit"] ."\">" .$row["strTitle"]. "</option>" ;
					}	
				?>
        </select></td>
		<td width="1">&nbsp;</td>
		<td colspan="3">Inroll Shortages </td>
		<td colspan="4"><input name="txtInrollShortages" type="text" class="txtbox" id="txtInrollShortages" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="35" maxlength="10" /></td>
		</tr>
		<tr>
		  <td height="26">&nbsp;</td>
		  <td>App. SWAT Imformed Date </td>
		  <td colspan="2"><input name="dtmAppSWATImformedDate" type="text" class="txtbox" id="dtmAppSWATImformedDate" size="20" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input name="reset32" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');" value="" /></td>
		  <td>&nbsp;</td>
		  <td colspan="3">Total Yards we needed </td>
		  <td colspan="4"><input name="txtTotalQty" type="text" class="txtbox" id="txtTotalQty" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="35" maxlength="10" /></td>
		</tr>
		<tr>
		  <td height="26">&nbsp;</td>
		  <td width="216">App. SWAT Received Date</td>
		  <td colspan="2"><input name="dtmAppSWATReceivedDate" type="text" class="txtbox" id="dtmAppSWATReceivedDate" size="20" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input name="reset322" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');" value="" />		    </td>
		  <td>&nbsp;</td>
		  <td colspan="3">Claim Report Up-Date</td>
		  <td>Yes</td>
		  <td><input name="optClaimReportUpDate" id="optClaimReportUpDateYES" type="radio" value="radiobutton" /></td>
		  <td>No</td>
		  <td><input name="optClaimReportUpDate" id="optClaimReportUpDateNO" type="radio" value="radiobutton" checked="checked" /></td>
		</tr>
		<tr>
		  <td height="22">&nbsp;</td>
		  <td>Srinkage Legth		    </td>
		  <td colspan="2"><textarea name="txtSinkAgeLegth" cols="35" rows="4" class="txtbox" id="txtSinkAgeLegth" ></textarea></td>
		  <td>&nbsp;</td>
		  <td colspan="3">Mailed Date </td>
		  <td colspan="4"><input name="dtmMailedDate" type="text" class="txtbox" id="dtmMailedDate" size="20" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input name="reset32" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');" value="" /></td>
		</tr>
		<tr>
		  <td height="22">&nbsp;</td>
		  <td>Srinkage Width		    </td>
		  <td colspan="2"><textarea name="txtSinkAgeWidth" cols="35" rows="4" class="txtbox" id="txtSinkAgeWidth" ></textarea></td>
		  <td>&nbsp;</td>
		  <td colspan="3">Shade Band Send Date </td>
		  <td colspan="4"><input name="dtmShadeBandSendDate" type="text" class="txtbox" id="dtmShadeBandSendDate" size="20" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input name="reset32" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');" value="" /></td>
		</tr>
		<tr>
		  <td height="22">&nbsp;</td>
		  <td>Order Width		    </td>
		  <td colspan="2"><textarea name="txtOrderWidth" cols="35" rows="4" class="txtbox" id="txtOrderWidth" ></textarea></td>
		  <td>&nbsp;</td>
		  <td colspan="3">Gatepass No </td>
		  <td colspan="4"><input name="txtGatepassNo3" type="text" class="txtbox" id="txtGatepassNo3" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="35" maxlength="10"></td>
		</tr>
		<tr>
		  <td height="22">&nbsp;</td>
		  <td>Cuttable Width </td>
		  <td colspan="2" rowspan="2"><textarea name="txtCuttableWidth" cols="35" rows="4" class="txtbox" id="txtCuttableWidth" ></textarea></td>
		  <td>&nbsp;</td>
		  <td colspan="3">Shade Band Approval </td>
		  <td>Yes</td>
		  <td><input name="optShadeBandApprovale" id="optShadeBandApprovaleYES" type="radio" value="radiobutton" /></td>
		  <td>No</td>
		  <td><input name="optShadeBandApprovale" id="optShadeBandApprovaleNO" type="radio" value="radiobutton" checked="checked" /></td>
		</tr>
		<tr>
		  <td height="22">&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan="3">CLR. Matching Labdip 
		    <label></label></td>
		  <td colspan="4"><input name="txtCLRMatchingLabdip" type="text" class="txtbox" id="txtCLRMatchingLabdip" size="35" maxlength="10" /></td>
		  </tr>
		<tr>
		  <td height="22">&nbsp;</td>
		  <td>Less Width Sample Send Date </td>
		  <td colspan="2"><input name="dtmLessWidthSampleSendDate" type="text" class="txtbox" id="dtmLessWidthSampleSendDate" size="20" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/>
		      <input name="reset322" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');" value="" /></td>
		  <td>&nbsp;</td>
		  <td colspan="3">Send Date </td>
		  <td colspan="4"><input name="dtmCLRMatchingLabdipSentDate" type="text" class="txtbox" id="dtmCLRMatchingLabdipSentDate" size="20" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input name="reset322" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');" value="" /></td>
		  </tr>
		<tr>
		  <td height="22">&nbsp;</td>
		  <td>Gatepass No </td>
		  <td colspan="2"><input name="txtGatepassNo1" type="text" class="txtbox"  id="txtGatepassNo1" onkeypress="return isNumberKey(event);"  size="35" maxlength="10" /></td>
		  <td>&nbsp;</td>
		  <td colspan="3">Gatepass No </td>
		  <td colspan="4"><input name="txtGatepassNo4" type="text" class="txtbox"  id="txtGatepassNo4" onkeypress="return isNumberKey(event);"  size="35" maxlength="10" /></td>
		  </tr>
		<tr>
		  <td height="23">&nbsp;</td>
		  <td>Inspected Quantity </td>
		  <td colspan="2"><input name="txtInspectedQty" type="text" class="txtbox"  id="txtInspectedQty" onkeypress="return CheckforValidDecimal(this.value, 4,event);"  size="35" /></td>
		  <td>&nbsp;</td>
		  <td colspan="3">Colour Approval </td>
		  <td>Yes</td>
		  <td><input name="optColourApproval" id="optColourApprovalYES" type="radio" value="radiobutton" /></td>
		  <td>No</td>
		  <td><input name="optColourApproval" id="optColourApprovalNO" type="radio" value="radiobutton" checked="checked" /></td>
		</tr>
		<tr>
		  <td height="24">&nbsp;</td>
		  <td>Inspected % </td>
		  <td colspan="2"><input name="txtInspectedRate" type="text" class="txtbox" id="txtInspectedRate" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="35" maxlength="10" /></td>
		  <td>&nbsp;</td>
		  <td colspan="3">Roll Wish Entry % </td>
		  <td colspan="4"><input name="txtSkewingBowingRate" type="text" class="txtbox"  id="txtSkewingBowingRate" onkeypress="return isNumberKey(event);"  size="35" maxlength="10" /></td>
		  </tr>
		<tr>
		  <td height="22">&nbsp;</td>
		  <td>Defected % </td>
		  <td colspan="2"><input name="txtDefectiveRate" type="text" class="txtbox" id="txtDefectiveRate" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="35" maxlength="10" /></td>
		  <td>&nbsp;</td>
		  <td colspan="3">Send Date </td>
		  <td colspan="4"><input name="dtmSkewingBowingDate" type="text" class="txtbox" id="dtmSkewingBowingDate" size="20" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input name="reset322" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');" value="" />		    </td>
		  </tr>
		<tr>
          <td height="21">&nbsp;</td>
		  <td>Gatepass No </td>
		  <td colspan="2"><input name="txtGatepassNo2" type="text" class="txtbox" id="txtGatepassNo2" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="35" maxlength="10"></td>
		  <td>&nbsp;</td>
		  <td colspan="3">Gatepass No </td>
		  <td colspan="4"><input name="txtGatepassNo5" type="text" class="txtbox" id="txtGatepassNo5" onkeypress="return isNumberKey(event);"  size="35" maxlength="10" /></td>
		  </tr>
		<tr>
		  <td height="21">&nbsp;</td>
		  <td>Defect Sent Date </td>
		  <td colspan="2"><input name="dtmDefectSentDate" type="text" class="txtbox" id="dtmDefectSentDate" size="20" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/>
		      <input name="reset322" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');" value="" /></td>
		  <td>&nbsp;</td>
		  <td width="1">&nbsp;</td>
		  <td width="1">&nbsp;</td>
		  <td width="164">&nbsp;</td>
		  <td colspan="4">&nbsp;</td>
		</tr>
		</table>
		</div>		</td>
        </tr>
    </table></div>
			<div id="tabs-2"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="89%" bgcolor="#9BBFDD" class="head1">Inspection</td>
        <td width="11%" bgcolor="#9BBFDD" class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td height="280" colspan="2" class="normalfnt">
		<div id="divcons" style="overflow:hidden; height:280px; width:100%px;">
		<table width="100%" height="310" class="bcgl1">
		  <tr>
            <td width="20">&nbsp;</td>
		    <td width="200">&nbsp;</td>
		    <td colspan="4" >&nbsp;</td>
		    <td >&nbsp;</td>
		    <td colspan="2" >&nbsp;</td>
		    <td >&nbsp;</td>
		    </tr>
		<tr>
		<td width="20" >&nbsp;</td>
		<td width="200" >Bowing /Skew Approval </td>
		<td>Yes</td>
		<td><input name="optBowingskeyApproval" id="optBowingskeyApprovalYes" type="radio" value="radiobutton" /></td>
		<td>No</td>
		<td><input name="optBowingskeyApproval" id="optBowingskeyApprovalNo" type="radio" value="radiobutton" checked="checked" /></td>
		<td width="24" >&nbsp;</td>
		<td colspan="2" ><div align="center"><span class="style3">Replacement Records / Details </span></div></td>
		<td width="25" >&nbsp;</td>
		</tr>
		<tr>
          <td >&nbsp;</td>
		  <td >Bowing %</td>
		  <td colspan="4" ><input name="txtClrShading2" type="text" class="txtbox" id="txtClrShading2" size="30" maxlength="10" /></td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  </tr>
		<tr>
          <td >&nbsp;</td>
		  <td >Send Date </td>
		  <td colspan="4" ><input name="txtClrShading3" type="text" class="txtbox" id="txtClrShading3" size="30" maxlength="10" /></td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  </tr>
		<tr>
          <td >&nbsp;</td>
		  <td >GatepassNo</td>
		  <td colspan="4" ><input name="txtClrShading4" type="text" class="txtbox" id="txtClrShading4" size="30" maxlength="10" /></td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  </tr>
		<tr>
          <td >&nbsp;</td>
		  <td >CLR. Shading </td>
		  <td colspan="4" ><input name="txtClrShading" type="text" class="txtbox" id="txtClrShading" size="30" maxlength="10" /></td>
		  <td >&nbsp;</td>
		  <td width="201" >Invoice No </td>
		  <td width="184" ><input name="txtInvoiceNo2" type="text" class="txtbox" id="txtInvoiceNo2" onkeypress="return isNumberKey(event);" size="30" maxlength="150" /></td>
		  <td >&nbsp;</td>
		  </tr>
		<tr>
          <td >&nbsp;</td>
		  <td >Send Date </td>
		  <td colspan="4" ><input name="dtmClrShadingDate" type="text" class="txtbox" id="dtmClrShadingDate" size="20" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');" value="" /></td>
		  <td >&nbsp;</td>
		  <td >Supplier</td>
		  <td ><input name="txtSupplier2" type="text" class="txtbox" id="txtSupplier2" onkeypress="return isNumberKey(event);" size="30" maxlength="150" /></td>
		  <td >&nbsp;</td>
		  </tr>
		<tr>
          <td >&nbsp;</td>
		  <td >Gatepass No  </td>
		  <td colspan="4" ><input name="txtGatepassNo6" type="text" class="txtbox" id="txtGatepassNo6" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="30" maxlength="10"/></td>
		  <td >&nbsp;</td>
		  <td >Style No </td>
		  <td ><input name="txtStyleNo2" type="text" class="txtbox" id="txtStyleNo2" size="30" maxlength="150"  /></td>
		  <td >&nbsp;</td>
		  </tr>
		<tr>
          <td >&nbsp;</td>
		  <td >Shading Approval </td>
		  <td>Yes</td>
		  <td><input name="optShadingApproval" id="optShadingApprovalYes" type="radio" value="radiobutton" /></td>
		  <td>No</td>
		  <td><input name="optShadingApproval" id="optShadingApprovalNo" type="radio" value="radiobutton" checked="checked" /></td>
		  <td >&nbsp;</td>
		  <td >PO &amp; PI </td>
		  <td ><input name="txtPOPI2" type="text" class="txtbox" id="txtPOPI2" size="30" maxlength="150"/></td>
		  <td >&nbsp;</td>
		  </tr>
		<tr>
          <td >&nbsp;</td>
		  <td >Fabric Way </td>
		  <td>Yes</td>
		  <td><input name="optFabricWay" id="optFabricWayYes" type="radio" value="radiobutton" /></td>
		  <td>No</td>
		  <td><input name="optFabricWay" id="optFabricWayNo" type="radio" value="radiobutton" checked="checked" /></td>
		  <td >&nbsp;</td>
		  <td >Buyer</td>
		  <td ><input name="txtBuyer2" type="text" class="txtbox" id="txtBuyer2" size="30" maxlength="50" /></td>
		  <td >&nbsp;</td>
		  </tr>
		<tr>
          <td height="22" >&nbsp;</td>
		  <td >Grarde</td>
		  <td colspan="4" ><label>
		    <select name="cboGrade" style="width:100px" id="cboGrade" class="txtbox">
		      <option value="0" selected="selected"></option>
		      <option value="1">A</option>
		      <option value="2">B</option>
		      <option value="3">C</option>
		      <option value="4">D</option>
                                </select>
		  </label></td>
		  <td >&nbsp;</td>
		  <td >Colour</td>
		  <td ><input name="txtColour2" type="text" class="txtbox" id="txtColour2" size="30" /></td>
		  <td >&nbsp;</td>
		  </tr>
		<tr>
          <td >&nbsp;</td>
		  <td >Status</td>
		  <td colspan="4" ><select name="cboStatus" style="width:100px" id="cboStatus" class="txtbox">
		    <option value="0" selected="selected"></option>
		    <option value="1">OK</option>
		    <option value="2">HOLD</option>
		    <option value="3">REJECTED</option>
		    </select>		  </td>
		  <td >&nbsp;</td>
		  <td >Received Quantity </td>
		  <td ><input name="txtRecQty2" type="text" class="txtbox" id="txtRecQty2" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="10"/></td>
		  <td >&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="10" >&nbsp;</td>
		  </tr>
		</table>
		</div>		</td>
        </tr>
    </table></div>
		<div id="tabs-3"  height:280px ><table width="100%" height="280" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="95%" height="17" bgcolor="#9BBFDD" class="normalfnth2"><div align="left" class="head1">Lots</div></td>
        <td width="5%" bgcolor="#9BBFDD" class="normalfnth2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><div id="divLotInterface" style=" overflow:scroll; width:100%; height:260px" > 		  
		  
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
        <td width="12%"><img src="../images/new.png" alt="new" name="butNew" width="96" height="24" class="mouseover"  id="butNew" onclick="NewFabricInspection(); LotInterface(); "/></td>
        <td width="12%"><img src="../images/cancel.jpg" width="104" height="24" onclick ="DeleteInspection();" /></td>
        <td width="12%"><img src="../images/save.png" alt="save" name="butSave" width="84" height="24" class="mouseover" id="butSave" onclick="SaveFabricInspection();" /></td>
        <td width="14%"><img src="../images/report.png" alt="butReportList" name="butReportList" width="108" height="24" class="mouseover" id="butReport" onclick="FabricInspectionReport();"/></td>
        <td width="14%"><a href="../main.php"><img src="../images/close.png" width="97" height="24" border="0" class="mouseover"  /></a></td>
        <td width="12%">&nbsp;</td>
        <td width="12%"><label></label></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>