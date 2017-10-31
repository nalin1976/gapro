<?php
	session_start();
	include "../../Connector.php";
	$backwardseperator = "../../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sample Register</title>
<link  href="../../css/erpstyle.css"  rel="stylesheet" type="text/css" />
<link  href="../../css/tableGrib.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="SampleRegisterFunction.js"></script>
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/tablegrid.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>

<!--calendar-->
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script type="text/javascript" src="../../javascript/calendar/calendar.js" ></script>
<script type="text/javascript" src="../../javascript/calendar/calendar-en.js" ></script>
<script type="text/javascript" src="../../javascript/calendar/functions.js" ></script>
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

<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include '../../Header.php'; ?></td>
	</tr> 
</table>
<div>
	<div align="center">
		<div class="trans_layoutL">
		<div class="trans_text">Sample Register<span class="volu"></span></div>
			<table align="center" width="88%" border="0">
				<tr>
					<td width="3%" class="normalfnt"></td>
					<td width="9%" class="normalfnt">Style No</td>
		  	  	  	<td width="24%" class="normalfnt">
						<select style="width: 152px;" class="txtbox" name="styleNoList" id="styleNoList" tabindex="1" onchange="getOrderNo()">
							
	<?php
	
	$SQL = "SELECT * FROM orders INNER JOIN sampleschedule ON orders.intStyleId=sampleschedule.intStyleId;";
	
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strStyle"] ."\">" .$row["strStyle"]."</option>" ;
	}
	

	
	?>
							
						</select>
			  	  </td>
				  <td width="3%" class="normalfnt">&nbsp;</td>
		  	  	  	<td width="9%" class="normalfnt">&nbsp;</td>
				  <td width="11%" class="normalfnt">Order No</td>
		  	  	  	<td width="41%" class="normalfnt">
						<select style="width: 152px;" class="txtbox" name="OrderDetails" id="OrderDetails" onchange="loadDataGrid();">
	<?php
	
	$SQL = "SELECT * FROM orders INNER JOIN sampleschedule ON orders.intStyleId=sampleschedule.intStyleId;";
	
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intStyleId"] ."\">" .$row["strOrderNo"]."</option>" ;
	}
    
	?>		  		
        				</select>
			  	  </td>
				</tr>
		  </table>
			<br />
            <table width="75%" border="0" class="bcgl1" style="margin-bottom:1px">
				<tr>
				<td align="center">		
			<div style="overflow-x:hidden; overflow-y:scroll; height:250px; width:798px;">
            
				<table style="width:780px" border="0" cellspacing="1" id="dataGrid" bgcolor="#CCCCFF">
					<thead>
						<tr class="mainHeading2">
							<td colspan="9" class="normaltxtmidb2">Sample Register</td>			
						</tr>	
						<tr class="mainHeading2">
							<td width="43" class="mainHeading4">No</td>
							<td width="120" class="mainHeading4">Sample Name
                            <input type="text" style="visibility:hidden; height:0px" width="15" >
                            </td>
							<td width="71" class="mainHeading4">Due Date</td>	
							<td width="50" class="mainHeading4">OP</td>		
							<td width="71" class="mainHeading4">Issued Date</td>
							<td width="71" class="mainHeading4">Issued To</td>
							<td width="71" class="mainHeading4">Re.Sub 01</td>
							<td width="71" class="mainHeading4">Re.Sub 02</td>	
							<td width="71" class="mainHeading4">App</td>
						</tr>		
					</thead>	
					<!--<tbody  >
						<tr>
							<td width="43">&nbsp;</td>
							<td width="93">&nbsp;</td>
							<td width="63">&nbsp;</td>	
							<td width="113">&nbsp;</td>	
							<td width="109">&nbsp;</td>
							<td width="71">&nbsp;</td>
							<td width="84">&nbsp;</td>	
							<td width="90">&nbsp;</td>	
							<td width="68">&nbsp;</td>	
					  </tr>
					</tbody>-->
					</table>
                   

			</div>
             </td>
                    </tr>
                    </table>
			<br />
			<!--<table align="center" width="100%" border="0">
				<tr>
					<td width="2%" class="normalfnt"></td>
			  	  	<td width="4%" class="normalfnt"><input type="checkbox" id="originalSample" /></td>
					<td width="13%" class="normalfnt">Original Sample</td>
					<td colspan="2" class="normalfnt"></td>
				</tr>
				<tr>
					<td width="2%" class="normalfnt"></td>
			  	  	<td width="4%" class="normalfnt"><input type="checkbox" id="fabric" /></td>
					<td width="13%" class="normalfnt">fabric</td>
					<td width="8%" class="normalfnt">Date</td>
					<td width="73%" class="normalfnt">
						<input name="txtDatefrom" type="text" class="txtbox" id="txtDatefrom" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo $datefrom=="" ? date("Y-m-d"):$datefrom; ?>" /><input type="reset" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');">
			  	  </td>
				</tr>
				<tr>
					<td width="2%" class="normalfnt"></td>
			  	  	<td width="4%" class="normalfnt"><input type="checkbox" id="accessories" /></td>
					<td width="13%" class="normalfnt">Accessories</td>
					<td width="8%" class="normalfnt">Date</td>
					<td width="73%" class="normalfnt">
						<input name="txtDatefrom" type="text" class="txtbox" id="txtDatefrom" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo $datefrom=="" ? date("Y-m-d"):$datefrom; ?>"  /><input type="reset" value=""  class="txtbox" style="visibility:hidden;width:1px" onclick="return showCalendar(this.id, '%Y-%m-%d');">
			  	  </td>
				</tr>
		  	</table>-->
			<br />
			<table align="center" width="367" border="0">
      			<tr>
					<td width="15%">&nbsp;</td>
					<td width="26%"><img src="../../images/new.png" width="90" id="butNew" onclick=  "clearForm();"/></td>
					<td width="23%"><img src="../../images/save.png" width="80" id="butSave" onclick="validateGridData();"/></td>
					<td width="26%"><a href="../../main.php"><img src="../../images/close.png" alt="close" width="90" border="0" /></a></td>
					<td width="10%">&nbsp;</td>
      			</tr>
		  </table>
		</div>
	</div>
</div>

</body>
</html>
