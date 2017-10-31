<?php
	session_start();
	include("../../Connector.php");
	$backwardseperator = "../../";
	include $backwardseperator."authentication.inc";	
	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Calendar</title>
<link href="../../javascript/calendar/theme.css" type="text/css" rel="stylesheet" />
<link href="../../css/erpstyle.css" type="text/css" rel="stylesheet" />
<script language="javascript" src="../../javascript/script.js" type="text/javascript"></script>
<script language="javascript" src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script language="javascript" src="../../javascript/calendar/calendar-en.js" type="text/javascript" ></script>


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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php include $backwardseperator.'Header.php'; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form name="frmHoliday" id="frmHoliday"><table width="500" border="0" cellspacing="0" cellpadding="2" align="center" class="bcgl1">
      <tr>
        <td><table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr>
            <td colspan="4" class="mainHeading" height="25">Holiday Calendar</td>
            </tr>
          <tr>
            <td width="52">&nbsp;</td>
            <td width="110">&nbsp;</td>
            <td width="145">&nbsp;</td>
            <td width="193">&nbsp;</td>
          </tr>
          <tr>
            <td class="normalfnt">Date </td>
            <td><input type="text" name="txtDate" id="txtDate" style="width:80px;" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" /><input type="text" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
            <td><input type="radio" name="rb" id="rbM" value="m">
              <span class="normalfnt">Mercantile Holiday</span></td>
            <td><input type="radio" name="rb" id="rbPoay" value="p">
              <span class="normalfnt">Poyaday</span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4"></td>
            </tr>
           

          <tr>
            <td colspan="4"><table width="500" border="0" cellspacing="0" cellpadding="2" align="center" >
              <tr>
                <td width="150">&nbsp;</td>
                <td width="150" align="right"><img src="../../images/new.png" width="96" height="24" onClick="clearPage();"></td>
                <td width="150"><img src="../../images/save.png" width="84" height="24" onClick="saveHolidayDetails();"></td>
                <td width="150">&nbsp;</td>
              </tr>
            </table></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="4" height="10"></td>
      </tr>
      <tr>
      <td colspan="4" align="center"><div style="overflow:scroll; height:250px; width:480px;">
      <table width="480" border="0" cellspacing="1" cellpadding="0" align="center" class="main_border_line" id="tblHolCalendar">
        <tr>
        <td class="grid_header">Del</td>
          <td width="188" class="grid_header" height="20">Date</td>
          <td width="292" class="grid_header">Holiday Type</td>
        </tr>
         <?php 
			$tdate = date('Y');
			$dfrom = $tdate.'-'.'01-01';
			$dto = $tdate.'-'.'12-31';
			//$arrDate = explode('-'
			$sql = "select * from calendar where dtmdate between '$dfrom' and '$dto' order by dtmdate ";
			$result = $db->RunQuery($sql); 
			
			while($row = mysql_fetch_array($result))
			{
				$holType = $row["strStatus"];
				
				switch($holType)
				{
					case 'p':
						{
							$type = 'Poyaday';
							break;
						}
					case 'm':
						{
							$type = 'Mercantile Holiday';
							break;
						}
				}
			?>
        <tr class="grid_raw">
         <td><img src="../../images/del.png" onClick="deleteHoliday(this);"></td>
          <td style="text-align:left"><?php echo $row["dtmdate"]; ?></td>
          <td class="normalfnt"><?php echo $type; ?></td>
        </tr>
          <?php 
		  }
		  ?>
      </table></div></td>
      </tr>
    </table>
      
      </form>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<script language="javascript" type="text/javascript">
function saveHolidayDetails()
{
	var holDate = trim(document.getElementById("txtDate").value);
	var val='';
	if(holDate == '')
	{
		alert('Select a Date');
		document.getElementById("txtDate").focus();
		return;
	}
	
	for(x=0;x<document.frmHoliday.rb.length;x++)
	{
		if(document.frmHoliday.rb[x].checked)
		{
			val = document.frmHoliday.rb[x].value;
			}
	}
	var url = 'holidayCalendardb.php?id=saveHoliday';
		url += '&holDate='+holDate;
		url += '&val='+val
		
		var xml_http_obj	=$.ajax({url:url,async:false});
		
		if(xml_http_obj.responseText == 1)
		{
			alert('Saved successfully');
			loadHolidayDetails();
		}
			
}

function loadHolidayDetails()
{
	clearGrid();
	var url = 'holidayCalendardb.php?id=loadHolidayDetails';
	var xml_http_obj	=$.ajax({url:url,async:false});
	
	var xml_date			=xml_http_obj.responseXML.getElementsByTagName('dtmDate');
	
	
	for(var loop=0; loop<xml_date.length; loop++)
	{
		var dtmDate		= xml_http_obj.responseXML.getElementsByTagName('dtmDate')[loop].childNodes[0].nodeValue;
		var type 		= xml_http_obj.responseXML.getElementsByTagName('holType')[loop].childNodes[0].nodeValue;
		
		createHolidayGrid(dtmDate,type);
	}
	
	
}

function clearGrid()
{
	$("#tblHolCalendar tr:gt(0)").remove();
	$("#frmHoliday")[0].reset();
}

function createHolidayGrid(dtmDate,type)
{
	var tbl = $('#tblHolCalendar tbody');
	var lastRow 		= $('#tblHolCalendar tbody tr').length;
	var row 			= tbl[0].insertRow(lastRow);
	row.className = "grid_raw";
	
	var rowCell 	  	= row.insertCell(0);
	//rowCell.className 	= "grid_raw";
	rowCell.innerHTML 	= "<img src=\"../../images/del.png\" width=\"15\" height=\"15\" onclick=\"deleteHoliday(this);\" />";
	
	var rowCell 	  	= row.insertCell(1);
	//rowCell.className 	= "grid_raw";
	rowCell.innerHTML 	= dtmDate;
	
	var rowCell 	  	= row.insertCell(2);
	//rowCell.className 	= "grid_raw";
	rowCell.innerHTML 	= type;
	
	row.setAttribute('style','text-align:left');
}

function deleteHoliday(obj)
{
var tblMain = obj.parentNode.parentNode.parentNode;
	var rowNo = obj.parentNode.parentNode.rowIndex;
	var holDate = obj.parentNode.parentNode.cells[1].innerHTML;
	
	var url = 'holidayCalendardb.php?id=deleteHoliday';
		url += '&holDate='+trim(holDate);
	var xml_http_obj	=$.ajax({url:url,async:false});
	if(xml_http_obj.responseText == 1)
		{
			tblMain.deleteRow(rowNo);
		}	
	
	
}

function clearPage()
{
	$("#frmHoliday")[0].reset();
}
</script>
</body>
</html>
