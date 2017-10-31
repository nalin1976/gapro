<?php
session_start();
$backwardseperator = "../../";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body 
{
	background-color: #CCCCCC;
}
</style>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>

<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>
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

function dateDisable(obj)
{
	if(obj.checked){
		document.getElementById('fromDate').disabled=false;
		document.getElementById('toDate').disabled=false;
	}
	else{
		document.getElementById('fromDate').disabled=true;
		document.getElementById('toDate').disabled=true;
	}
}

function closeWindow1()
{

	try
	{
		var box = document.getElementById('popupbox');
		box.parentNode.removeChild(box);
	}
	catch(err)
	{        
	}	
}
</script>
</head>

<body onload="">
<?php 

include "../../Connector.php";
 $orderNo  = $_GET["orderNo"];
?>
<form name="frmShipNow" id="frmShipNow">
<table width="450" border="0" align="center" bgcolor="#FFFFFF">

		
		  <tr >
    <td><table width="50%" border="0" cellpadding="0" cellspacing="0">
      <tr class="cursercross" onmousedown="grab(document.getElementById('frmShipNow'),event);">
        <td width="61%" height="31" bgcolor="#FBF8B3" class="mainHeading"><div align="center"></div></td>      </tr>

  <tr>
    <td><table width="50%" border="0"  bgcolor="#FFFFFF" style="text-align:center;font-size: 13px;font-family: Verdana;	color: #751609; border-color:996F03" ">
      <tr>
    <!--<td width="13%" ><div align="center">Schedule No</div></td>
        <td width="19%" ><select name="cboModifyMonShipSched" class="txtbox" id="cboModifyMonShipSched" style="width:150px" onchange="loadModifyMonShipSchedData();">
                    <option value="Select One">Select One</option>
                    <?php
				
				$sql = "Select distinct intScheduleNo FROM monthlyshipmentschedule ORDER BY intScheduleNo";
				$result = $db->RunQuery($sql);
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"". $row["intScheduleNo"] ."\">" . $row["intScheduleNo"] ."</option>" ;
				}
				
				?>
                </select></td>-->
			
              <!--<td width="7%" ><div align="center">Actual PO</div></td>
          <td width="37%"  colspan="0" align="left"><select name="frmMachineLoadingList_cboMachineType" class="txtbox" id="frmMachineLoadingList_cboMachineType" style="width:100px" onchange="loadMachine(this.value);"> 

	 <option value="" ></option>
 </select></td><td width="13%"><div align="right"><b>Schedule No:&nbsp;</div></td>-->
        <td width="68%">
               <div align="right">

                </div></td></table></td>
  </tr>

  
    <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="0"><div id="divcons2" style="overflow:scroll; height:285px; width:550px;" class="tableBorder">
                   <table width="530" cellpadding="0" cellspacing="1" id="tblDest"   style="background-color:#FAD163; padding:1px 0px 4px 8px;text-align:center;font-size: 13px;font-family: Verdana;	color: #751609; border-color:996F03" >
            <tr>			
			  <td >Delete</td>	
			  <td >Destination</td>	  
			  <td >To Ship (Sea)</td>
			  <td >To Ship (Air)</td>
			  <td >Ctn Qty</td>
              </tr>
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><div align="right">
      <table width="100%" border="0">
        <tr>
            <td width="10%"><div align="center"><img src="../../images/save.png" alt="close" width="97" height="24" align="right" onclick="deleteBeforeSave();"/></div></td>            <td width="10%"><div align="center"><img src="../../images/close.png" alt="close" width="97" height="24" align="left" onclick="closeWindow();"/></div></td>
          </tr>
      </table>
    </div></td>
  </tr>
</table>
</form>
</body>
</html>
