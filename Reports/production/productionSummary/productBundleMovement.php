<?php 
$backwardseperator = '../../../';
include "../../../Connector.php";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Production Bundle Movement</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<link href="../../../javascript/calendar/theme.css" rel="stylesheet" type="text/css"/>
<script language="javascript" src="../../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script language="javascript" src="../../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script language="javascript" src="../../../javascript/script.js" type="text/javascript"></script>
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
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td><?php include '../../../Header.php'; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="600" border="0" cellspacing="0" cellpadding="2"  align="center" class="tableBorder">
      <tr>
        <td ><table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td height="25" class="mainHeading">PRODUCTION BUNDLE MOVEMENT</td>
  </tr>
</table> </td>
        </tr>
      <tr>
        <td><table width="600" border="0" cellspacing="0" cellpadding="2">
          <tr class="normalfnt">
            <td width="108">Date From </td>
            <td width="205"><input type="text" name="txtDfrom " id="txtDfrom" style="width:120px;" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  value="<?php echo ($txtDfrom=="" ? "":$txtDfrom);?>" /><input name="text3" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
            <td width="87">Date To </td>
            <td width="184"><input type="text" name="txtDto" id="txtDto" style="width:120px;" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);" onClick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDto=="" ? "":$txtDto);?>" /><input name="text22" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
          </tr>
          <tr class="normalfnt">
            <td>Order No</td>
            <td><select name="cboOrderNo" id="cboOrderNo" style="width:122px;" onChange="loadCutNoDetails();">
             <option value="" selected="selected">Select One</option>
                  <?php
	
	$SQL = "select distinct SP.intStyleId,O.strOrderNo
			from specification SP
			INNER JOIN orders O ON O.intStyleId=SP.intStyleId
			order by O.strOrderNo ;";
	$result = $db->RunQuery($SQL);

	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	?>
            </select>            </td>
            <td>Style No</td>
            <td><select name="cboStyleNo" id="cboStyleNo" style="width:122px;">
            <option value="" selected="selected">Select One</option>
<?php
	$sql="select distinct strStyle 
		  from orders O 
		  INNER JOIN specification SP ON O.intStyleId=SP.intStyleId
		  Order By O.strStyle;";
	$result=$db->RunQuery($sql);			
	while($row=mysql_fetch_array($result))
	{
		echo "<option value=\"".trim($row["strStyle"],' ')."\">".$row["strStyle"]."</option>";
	}
?>
            </select>            </td>
          </tr>
          <tr class="normalfnt">
            <td>Cut No</td>
            <td><select name="cboCutNo" id="cboCutNo" style="width:122px;" onChange="loadBundleNo();">
            <option value=""></option>
            </select>            </td>
            <td>Line No</td>
            <td><select name="cboLineNo" id="cboLineNo" style="width:122px;">
            <option value="" selected="selected">Select One</option>
            <?php 
			$sql_t = "select intTeamNo,strTeam from plan_teams ";
			$result_t=$db->RunQuery($sql_t);			
	while($rowT=mysql_fetch_array($result_t))
	{
		echo "<option value=\"".trim($rowT["intTeamNo"],' ')."\">".$rowT["strTeam"]."</option>";
	}
			?>
            </select>            </td>
          </tr>
          <tr class="normalfnt">
            <td height="20">Bundle No</td>
            <td><select name="cboBundleNo" id="cboBundleNo" style="width:122px;">
            </select>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="2" class="tableBorder">
          <tr>
            <td align="center"><img src="../../../images/report.png" width="108" height="24" onClick="viewReport();"><a href="../../../main.php"><img src="../../../images/close.png" width="97" height="24" border="0"></a></td>
          </tr>
        </table></td>
        </tr>

    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<script language="javascript" type="text/javascript">
function loadCutNoDetails()
{
	var styleId = document.getElementById('cboOrderNo').value;
	var url = "productionDetailxml.php?RequestType=loadOrderNowiseCutDetails&styleId="+styleId;
	htmlobj = $.ajax({url:url,async:false});
	document.getElementById('cboCutNo').innerHTML = htmlobj.responseText;
}
function loadBundleNo()
{
	var cutNo = document.getElementById('cboCutNo').value;
	var url = "productionDetailxml.php?RequestType=loadCutwiseBundleDetails";
	url += "&cutNo="+cutNo;
	htmlobj = $.ajax({url:url,async:false});
	document.getElementById('cboBundleNo').innerHTML = htmlobj.responseText;
}
function viewReport()
{
	var styleId = document.getElementById('cboOrderNo').value; 
	var dateFrom = document.getElementById('txtDfrom').value;
	var dateTo =  document.getElementById('txtDto').value;
	var cutNo =  document.getElementById('cboCutNo').value;
	var lineNo =  document.getElementById('cboLineNo').value;
	var styleNo = document.getElementById('cboStyleNo').value;
	var bundleNo =  document.getElementById('cboBundleNo').value;
	
	var url = "bundleMovementRpt.php?styleId="+styleId;
	url += "&dateFrom="+dateFrom;
	url += "&dateTo="+dateTo;
	url += "&cutNo="+cutNo;
	url += "&lineNo="+lineNo;
	url += "&bundleNo="+bundleNo;
	url += "&styleNo="+URLEncode(styleNo);
	if(dateFrom =='')
	{
		alert("Please select 'Date From' ");
		document.getElementById('txtDfrom').focus()
		return false;
	}
	if(dateTo =='')
	{
		alert("Please select 'Date To' ");
		document.getElementById('txtDfrom').focus()
		return false;
	}
	window.open(url,'bundleMovementRpt.php?');
}
</script>