<?php

session_start();
$backwardseperator = "../../";
include "${backwardseperator}authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Event templates</title>
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="cutPCView.js" type="text/javascript"></script>
<script type="text/javascript">

	
//----------------------hem-------------------------------------------------------------------
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
<?php
	include "../../Connector.php";	
?>

<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include "../../Header.php";?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="28%">&nbsp;</td>
        <td width="51%"><form name="frmEventTemplate" id="frmEventTemplate">
          <table width="100%" border="0">
            <tr>
              <td height="16" bgcolor="#498CC2" class="mainHeading">Cut PC's Transfer In Note View </td>
            </tr>
            <tr>
              <td height="17"><table width="100%" border="0">
			  <tr>
			  <td width="20%"></td>
			  <td width="30%"></td>
			  <td width="25%"></td>
			  <td width="25%"></td>
			  </tr>
                <tr>
                  <td class="normalfnt">PO No </td>
                  <td colspan="3"><select name="cboPONo"  id="cboPONo" class="txtbox" style="width:505px" onchange="loadStyle();">
                      <?php
$year = date("Y");
					  
	/* $SQL = "SELECT productionbundleheader.intStyleId, productionbundleheader.strCutNo, orders.strStyle,orders.strOrderNo, productionbundledetails.strSize, productionbundledetails.dblPcs, productionbundledetails.intCutBundleSerial, productionbundledetails.dblBundleNo FROM productiongpdetail
		LEFT JOIN productionbundleheader ON productiongpdetail.intCutBundleSerial = productionbundleheader.intCutBundleSerial
		LEFT JOIN orders ON productionbundleheader.intStyleId = orders.intStyleId
		LEFT JOIN productionbundledetails ON productiongpdetail.intCutBundleSerial = productionbundledetails.intCutBundleSerial and  productiongpdetail.dblBundleNo = productionbundledetails.dblBundleNo
        where productiongpdetail.intYear = '".$year."'";*/
		
	 $SQL = "SELECT * FROM orders ORDER BY strStyle ASC";
		
						$result = $db->RunQuery($SQL);
						
						echo "<option value = \"". "" . "\">" . "" . "</option>";
						while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"" . $row["intStyleId"] ."\">" . $row["strOrderNo"] . "</option>";
						}
					?>
                    </select> </td>
                </tr>
                <tr>
                  <td class="normalfnt">Style</td>
                  <td colspan="3"><select name="cboStyle" id="cboStyle" class="txtbox" style="width:505px" >
                    </select> </td>
                </tr>
			
			<tr><td colspan="4"><table width="100%">	
			  <td width="20%"></td>
			  <td width="30%"></td>
			  <td width="26%"></td>
			  <td width="24%"></td>
			  <tr>
			  <td class="normalfnt">Transfer In Note No</td>
			  <td colspan="3"><select name="cboTrnfInNote"  id="cboTrnfInNote" class="txtbox" style="width:505px" onchange="getGridDetails()">
                      <?php
$year = date("Y"); 
					  
	/* $SQL = "SELECT productionbundleheader.intStyleId, productionbundleheader.strCutNo, orders.strStyle,orders.strOrderNo, productionbundledetails.strSize, productiongpdetail.intGPnumber,productionbundledetails.dblPcs, productionbundledetails.intCutBundleSerial, productionbundledetails.dblBundleNo FROM productiongpdetail
		INNER JOIN productionbundleheader ON productiongpdetail.intCutBundleSerial = productionbundleheader.intCutBundleSerial
		INNER JOIN orders ON productionbundleheader.intStyleId = orders.intStyleId
		INNER JOIN productionbundledetails ON productiongpdetail.intCutBundleSerial = productionbundledetails.intCutBundleSerial and  productiongpdetail.dblBundleNo = productionbundledetails.dblBundleNo
        where productiongpdetail.intYear = '".$year."'";*/
		
	 $SQL = "SELECT * FROM productiongptinheader ORDER BY dblCutGPTransferIN ASC";
						$result = $db->RunQuery($SQL);
						
						echo "<option value = \"". "" . "\">" . "" . "</option>";
						while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"" . $row["dblCutGPTransferIN"] ."\">" . $row["dblCutGPTransferIN"] . "</option>";
						}
					?>
                    </select><input type="hidden" name="txtYear" id="txtYear" value="<?php echo $year ?>" /></td>
			  </tr>
			  </table></td><tr>
			  
			  
              </table></td>
            </tr>
            <tr>
              <td height="165"><table width="98%" height="165" border="0" cellpadding="0" cellspacing="0">
                  <tr class="bcgl1">
                    <td width="100%"><table width="100%" border="0" class="bcgl1">
                        <tr>
                          <td colspan="3"><div id="divcons" style="overflow:scroll; height:300px; width:700px;">
							<!-- Populating Table Grid with Events [start]-->
                              <table width="100%" cellpadding="0" cellspacing="1" id="tblevents" >
                                <tr>
                                  <td width="10%" bgcolor="#498CC2" class="mainHeading2">Note No</td>
                                  <td width="10%" height="18" bgcolor="#498CC2" class="mainHeading2">Date</td>
                                  <td width="40%" bgcolor="#498CC2" class="mainHeading2">Source Factory </td>
                                  <td width="10%" bgcolor="#498CC2" class="mainHeading2">PO No </td>
                                  <td width="10%" height="18" bgcolor="#498CC2" class="mainHeading2">Style No </td>
                                  <td width="10%" bgcolor="#498CC2" class="mainHeading2">Gate Pass </td>
                                  <td width="10%" bgcolor="#498CC2" class="mainHeading2">status</td>
                                </tr>
                              </table>
                          </div></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr class="bcgl1">
                    <td bgcolor=""><table width="100%" border="0" class="tableFooter">
                        <tr>
                          <td width="23%"  class="normalfnt">&nbsp;</td>
                          
                          <td width="17%" class="normalfntRite" >&nbsp;</td>
                          <td width="20%" class="normalfntp2"><span class="normalfntLeft"><img src="../../images/close.png" alt="close"   border="0" align="middle" class="mouseover" /></span></td>
                          <td width="19%" class="normalfntLeft"><a href="../../main.php"></a></td>
                          <td width="18%">&nbsp;</td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
            </tr>
          </table>
        </form></td>
        <td width="21%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
