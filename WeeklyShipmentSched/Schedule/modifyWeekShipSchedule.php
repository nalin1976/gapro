<?php 
	$backwardseperator = "../../";
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Modify Weekly Shipment Forcast</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="weeklyShipSchedule-java.js" type="text/javascript"></script>
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
</script>
</head>

<body>
<form name="frmWeeklyShipSched" id="frmWeeklyShipSched">
<?php
include "../../Connector.php";

?>

<table width="100%" align="center">
  <tr>
    <td id="td_coHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom_center">
	<div class="main_top">
		<div class="main_text">Modify Weekly Shipment Forecast<span class="vol"></span></div>
	</div>
	<div class="main_body">
		<form method="post" action="">
		<table width="950" border="0" class="main_border_line">
			<tr>
				<td></td>
			</tr>
			<tr>
				<td width="10">&nbsp;</td>
				<td width="47" class="normalfnt">Style</td>
				<td width="160">
<select name="cboStyleNo" class="txtbox" id="cboStyleNo" style="width:100px"> 

		<?php
		$SQL =  "SELECT intStyleId,strStyle from orders ORDER BY strStyle";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["intStyleId"]."\">".$row["strStyle"]."</option>";
			}
	
 	    ?>
 </select>
			  </td>
				<td width="74" class="normalfnt">Order No</td>
				<td width="156"><select name="cboOrderNo" class="txtbox" id="cboOrderNo" style="width:100px"> 

		<?php
		$SQL =  "SELECT intStyleId,strOrderNo from orders ORDER BY strStyle";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
			}
	
 	    ?>
 </select>
			  </td>
				<td width="73" class="normalfnt">Buyer</td>
				<td width="150">
<select name="cboBuyer" class="txtbox" id="cboBuyer" style="width:100px"> 

		<?php
		$SQL = "SELECT intBuyerID,strName FROM buyers ORDER BY strName";	
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["intBuyerID"]."\">".$row["strName"]."</option>";
			}
	
 	    ?>
 </select>
			  </td>
				<td width="89" class="normalfnt">Schedule No</td>
				<td width="153"><select name="cboWeeklySchedNo" class="txtbox" id="cboWeeklySchedNo" style="width:150px" onchange="">
                    <option value=""></option>
                    <?php
				
				$sql = "Select distinct intScheduleNo FROM weeklyshipmentschedule ORDER BY intScheduleNo";
				$result = $db->RunQuery($sql);
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"". $row["intScheduleNo"] ."\">" . $row["intScheduleNo"] ."</option>" ;
				}
				
				?>
                </select>
			  </td>
			  <td align="right"><img src="../../images/search.png" name="search" width="108" height="24" class="mouseover" id="search"  onclick="loadWeeklyScheduleModify();" title="Search for deliveries"/></td>
			</tr>
		</table>
		<br />
		<div id="main">
			<div id="slide1">
				<table width="100%" border="0">
					<tr>
						<td width="6%"></td>
					</tr>
					<tr>
						<td>&nbsp;</td>					  
				      <td width="25%" class="normalfntRite"><div align="left">Date</div></td>
      <td width="69%" class="normalfnt"><input name="DateForMonth" type="text" class="txtbox" id="DateForMonth" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($scheFrom=="" ? date ("d/m/Y"):$scheFrom) ?>" style="width:80px;"/><input name="reset" id="reset" type="reset"  class="txtbox" style="visibility:hidden;width:1px;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" /></td>
					</tr>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td></td>
					</tr>
				</table>
				<table width="100%" border="0" class="pic_border">
					<tr>
						<td height="20%">&nbsp;</td>
					</tr>
					<tr>
						<td align="center"><img src="../../images/stylecolor.png" onclick="loadWeekModify(this.id);" id="loadWeek1"/></td>
					</tr>
					<tr>
						<td class="pic_txt" id="txtweek1">WEEK 01</td>
					</tr>
					<tr>
						<td align="center"><img src="../../images/stylecolor.png" onclick="loadWeekModify(this.id);" id="loadWeek2"/></td>
					</tr>
					<tr>
						<td class="pic_txt" id="txtweek2">WEEK 02</td>
					</tr>
					<tr>
						<td align="center"><img src="../../images/stylecolor.png" onclick="loadWeekModify(this.id);" id="loadWeek3"/></td>
					</tr>
					<tr>
						<td class="pic_txt" id="txtweek3">WEEK 03</td>
					</tr>
					<tr>
						<td align="center"><img src="../../images/stylecolor.png" onclick="loadWeekModify(this.id);" id="loadWeek4"/></td>
					</tr>
					<tr>
						<td class="pic_txt" id="txtweek4">WEEK 04</td>
					</tr>
					<tr>
						<td align="center"><img src="../../images/stylecolor.png" onclick="loadWeekModify(this.id);" id="loadWeek5"/></td>
					</tr>
					<tr>
						<td class="pic_txt" id="txtweek5">WEEK 05</td>
					</tr>
					<tr>
						<td align="center"><img src=""/></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="100%" border="0">
					<tr>
						<td colspan="2"></td>
					</tr>
					<tr>
						<td class="grid_header"><a href="#">Orders - Set</a></td>
						<td class="grid_header"><a href="#">Orders - Not Set</a></td>
					</tr>
					<tr>
						<td colspan="2" class="grid_header"><a href="#">Order All</a></td>
					</tr>
				</table>
			</div>
		  <div id="slide2">
		    <div style="overflow:scroll; width:755px; height:375px;">
              <table width="3000" border="0" id="tblWeeklyModify"  cellpadding="0" cellspacing="1" id="tblWeeklyModify"   style="background-color:#fff3cf; padding:1px 0px 4px 8px;text-align:center;font-size: 13px;font-family: Verdana;	color: #751609; border-color:996F03" cellpadding="0" cellspacing="1" bordercolor="#162350" bgcolor="#CCCCFF">
                <tr>
                  <td height="17" colspan="38" class="sub_containers"></td>
                </tr>
                <tr>
				  <td  class="grid_header">Delete</td>
                  <td  class="grid_header">SR 98</td>
                  <td  class="grid_header">CTM - COL</td>
				  <td  class="grid_header">ETD Date</td>
                  <td  class="grid_header">Week</td>
                  <td  class="grid_header">No</td>
                  <td  class="grid_header">Del Date</td>
                  <td  class="grid_header">Style</td>
                  <td  class="grid_header">Order Qty</td>
                  <td  class="grid_header">Del Qty</td>
                  <td  class="grid_header">Order No</td>
                  <td  class="grid_header">Mon Qty(Sea)</td>
				  <td  class="grid_header">Mon Qty(Air)</td>
                  <td  class="grid_header">Bal Qty</td>
                  <td  class="grid_header">Ship Now(Sea)</td>
                  <td  class="grid_header">Ship Now(Air)</td>
                  <td  class="grid_header">Remark</td>
                  <td  class="grid_header">Wash Code</td>
                  <td  class="grid_header">L</td>
                  <td  class="grid_header">W</td>
                  <td  class="grid_header">H</td>
                  <td  class="grid_header">PCS / Pack</td>
                  <td  class="grid_header">Dimension</td>
                  <td  class="grid_header">Mode</td>
                  <td  class="grid_header">Vessal</td>
                  <td  class="grid_header">Vessal Date</td>
  
                </tr>
              </table>
	        </div>
		  </div>
		</div>
		<br/>
		<table width="950">
			<tr>
				<td></td>
			</tr>
		</table>
		<br/>	
		<table width="950" border="0" class="main_border_line">
			<tr>
				<td width="226">&nbsp;</td>
				<td width="96"><img src="../../images/new.png"/></td>
				<td width="87"><img src="../../images/save.png" onclick="deleteBeforeUpdate();"/></td>
				<td width="108"><img src="../../images/report.png"/></td>
				<td width="104"><img src="../../images/delete.png"/></td>
				<td width="303"><img src="../../images/close.png"/></td>
			</tr>
		</table>
	</div>
	<div class="gap"></div>
</div>
</form>
</body>
</html>
