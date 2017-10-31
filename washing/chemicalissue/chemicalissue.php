<?php
	session_start();
	include("../../Connector.php");
	$backwardseperator = "../../";	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Chemical Issue</title>
<link href="../../js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../css/tableGrib.css" rel="stylesheet" type="text/css" />
<link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css" />
    
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<script type="text/javascript" src="../../javascript/calendar/calendar.js"></script>
<script type="text/javascript" src="../../javascript/calendar/calendar-en.js"></script>
<script type="text/javascript" src="chemicalissue.js"></script>
<script type="text/javascript" src="../../js/jquery.fixedheader.js"></script>
	
<script type="text/javascript">
$(function(){
	// TABS
	$('#tabs').tabs();
});
</script>
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
<table width="100%" align="center">
	<tr>
    	<td><?php include '../../Header.php'; ?></td>
	</tr>
</table>
<table width="950" align="center" class="tableBorder">
<tr>
	<td class="mainHeading">Chemical Issue</td>
</tr>
<tr>
    <td>
		<div  id="tabs" style="background-color:#FFFFFF">
		<ul>
			<li><a href="#tabs-1" class="normalfnt">Chemical Issue Details </a></li>
			<li><a href="#tabs-2" class="normalfnt"  onclick="LoadList();">Chemical Issue List </a></li>
		</ul>
				<div id="tabs-1">
              <form id="frmChemRequisitionMain" action="" name="frmChemRequisitionMain" method="post">
					<table width="100%" border="0">
						
						<tr >
							<td width="11%" class="normalfnt" >MRN No </td>
					  	    <td width="19%" class="normalfnt" id="orderId" title=""><select name="txtMRNNo" class="txtbox" style="width:152px;" id="txtMRNNo" onchange="LoadDetails(this);" tabindex="1" />
						                                <?php 
							$sql="select distinct concat(MH.intMRNYear,'/',MH.intMRNNo)as MrnNo from was_matrequisitionheader MH inner join was_matrequisitiondetails MD on MD.intMRNYear=MH.intMRNYear and MD.intMRNNo=MH.intMRNNo where MH.intStatus=0 and MD.dblMrnBalQty>0 order by MH.intMRNYear,MH.intMRNNo DESC";
							$result =$db->RunQuery($sql); 
							echo "<option value=\"". "" ."\">" . "" ."</option>" ;
							while($row=mysql_fetch_array($result))
							{
								echo "<option value=\"". $row["MrnNo"] ."\">" . $row["MrnNo"] ."</option>" ;
							}
						?>
						 </select>						</td>
							<td width="18%" class="normalfnt">Issue No </td>
					        <td width="19%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" id="txtIssueNo" disabled="disabled" tabindex="2" /></td>
						  <td width="12%" class="normalfnt">Cost No  </td>
						  <td width="21%" class="normalfnt"><select style="width: 152px;" class="txtbox" id="cboCostNo" name="cboCostNo" tabindex="5" disabled="disabled">
                          </select>
					      <input type="text"  class="txtbox" style="visibility:hidden;width:2px"   onclick="return showCalendar(this.id, '%d/%m/%Y');"  /></td>
						</tr>
						<tr>
							<td width="11%" class="normalfnt">PO No </td>
						  	<td width="19%" class="normalfnt">
								<select style="width: 152px;" class="txtbox" id="cboOrderNo" name="cboOrderNo" tabindex="4"  disabled="disabled">
						  </select>						  </td>
							<td class="normalfnt">Style No </td>
						    <td class="normalfnt"><select style="width: 152px;" class="txtbox" id="cboStyleNo" name="cboStyleNo" tabindex="5" disabled="disabled">
                            </select></td>
						    <td class="normalfnt">Machine Type</td>
						    <td class="normalfnt"><select name="cboMachineType" class="txtbox" id="cboMachineType" style="width: 152px;" tabindex="6"disabled="disabled"  >
                              <?php 
							$sql = "select intMachineId,strMachineType from was_machinetype where intStatus";
							$result =$db->RunQuery($sql); 
							echo "<option value=\"". "" ."\">" . "" ."</option>" ;
							while($row=mysql_fetch_array($result))
							{
								echo "<option value=\"". $row["intMachineId"] ."\">" . $row["strMachineType"] ."</option>" ;
							}
						?>
                            </select></td>
						</tr>
						<tr>
							<td width="11%" class="normalfnt">PO Qty </td>
					  	  <td width="19%" class="normalfnt"><input name="txtOrderQty" type="text" class="txtbox" id="txtOrderQty" style="width:150px;text-align:right" disabled="disabled" tabindex="7" /></td>
							<td class="normalfnt">Requested Qty </td>
						    <td class="normalfnt"><input type="text" class="txtbox" style="width:150px;text-align:right" id="txtBuyerFob" tabindex="8" disabled="disabled" /></td>
						    <td class="normalfnt">&nbsp;</td>
						    <td class="normalfnt">&nbsp;</td>
						</tr>
					</table>
<br />		
			<!--<div style="overflow:scroll; height:360px; width:698px;">-->
<table style="width:100%"  border="0" cellspacing="1" bgcolor="#C58B8B" class="bcgcolor" >						
								<tr class="mainHeading4">
								  <th width="836" >Item Description </th>
              </tr>	
				</table>
				<div style="overflow:scroll; height:360px; width:100%;" class="tableBorder">
						<table style="width:100%"  border="0" cellspacing="1" id="tblItemList" cellpadding="0" bgcolor="#CCCCFF" >                   
							<thead>
								<tr  class="mainHeading4">
                                  <th width="2%" height="20"><input type="checkbox" name="chkAll" id="chkAll"  /></th>		
								  <th width="34%">Item Description</th>
									<th width="9%">Unit</th>
									<th width="8%">Issue Qty </th>
									<th width="8%">MRN Qty </th>
								    <th width="7%">Issued Qty </th>
								    <th width="7%">Bal To Issue Qty </th>
								    <th width="7%">Stock Balance </th>
							    </tr>		
							</thead>	
							<tbody>
							</tbody>
						</table>
				  </div>

					<table width="100%" border="0" class="tableFooter" align="center">
						<tr>
							<td width="37%" align="center">
							<img src="../../images/new.png" onclick="ClearForm();" />
							<img src="../../images/save.png" width="80" onclick="Save();" />
							<img src="../../images/report.png" alt="report" />
							<img src="../../images/close.png" alt="close" />
							</td>
						</tr>
					</table>
                  </form>
				</div>
				<div id="tabs-2">
					<div style="overflow:scroll; height:350px; width:100%;">
					<table style="width:100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF" id="tblList" >
						<thead>	
							<tr class="mainHeading4">
								<th width="159" height="25">Issue No </th>
								<th width="148">MRN No </th>
								<th width="262">Date</th>	
								<th width="368">Issued By </th>	
							</tr>		
						</thead>
					</table>
					</div>
					<br />
					<table width="100%" border="0">
						<tr>
							<td width="34%">&nbsp;</td>
							<td width="12%"><img src="../../images/new.png" id="butNew" name="butNew" width="90" /></td>
							<td width="11%"><img src="../../images/save.png" id="butSave" name="butSave" width="80" /></td>
							<td width="12%"><a href="../../main.php"><img src="../../images/close.png" id="butClose" name="butClose" alt="close" width="90" border="0" /></a></td>
							<td width="31%">&nbsp;</td>
						</tr>
					</table>

				</div>
			</div>	
</td>
	</tr>
</table>
</body>
</html>