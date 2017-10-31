<?php
session_start();
$backwardseperator = "../../";

include $backwardseperator."authentication.inc";
$txtDfrom	= date("Y-m-01");
$txtDto		= date("Y-m-d");

include "../../Connector.php";

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>GaPro | First Sale Reports</title>
<link href="../../css/erpstyle.css" rel="stylesheet"/>
<link href="../../js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js" language="javascript" ></script>
<link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/calendar/calendar.js" language="javascript" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" language="javascript" type="text/javascript"></script>
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
    <td><?php include '../../Header.php';?></td>
  </tr>
  <tr>
    <td height="5"></td>
  </tr>
  <tr>
    <td><table width="800" border="0" cellspacing="0" cellpadding="2" align="center" class="tableBorder">
  <tr>
    <td><table width="800" border="0" cellspacing="0" cellpadding="2" align="center" >
      <tr>
        <td height="25" class="mainHeading">First Sale Report</td>
        </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="2" class="tableBorder">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
            <tr>
            	<td colspan="10"><fieldset class="roundedCorners" >
                            <legend class="legendHeader">&nbsp;Approved Date&nbsp;</legend> 
                                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                <tr>
                                  <td width="33" class="normalfntMid"><input name="checkDate" id="checkDate" type="checkbox" checked="checked" onClick="setDateChecked(this);" disabled /></td>
                                  <td width="105" class="normalfnt">Date From </td>
                                  <td width="131"><input type="text" name="txtDfrom " id="txtDfrom" style="width:90px;" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  value="<?php echo ($txtDfrom=="" ? "":$txtDfrom);?>" /><input name="text3" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                  <td width="76" class="normalfnt">To</td>
                                  <td width="194"><input type="text" name="txtDto" id="txtDto" style="width:90px;" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);" onClick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDto=="" ? "":$txtDto);?>" /><input name="text22" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                </tr>
                              </table>
                            </fieldset></td>
            </tr>
            <tr><td colspan="6" height="10"></td></tr>
              <tr class="normalfnt">
                <td width="5%">&nbsp;</td>
                <td width="12%" height="20">Order No</td>
                <td width="33%"><input type="text" name="txtOrderNo" id="txtOrderNo" style="width:160px;"></td>
                <td width="18%">Tax Invoice Status</td>
                <td width="24%"><select name="cboTaxStatus" id="cboTaxStatus" style="width:122px;" class="txtbox">
                  <option value="" selected="selected">All</option>
                  <option value="0">Pending</option>
                  <option value="1">Approved</option>
                </select></td>
                <td width="8%">&nbsp;</td>
              </tr>
              <tr class="normalfnt">
                <td>&nbsp;</td>
                <td>Buyer </td>
                <td><select name="cboAppBuyer" id="cboAppBuyer" style="width:162px;" class="txtbox">
                             <option value="" >Select One</option>
                    <?php
	$SQL = " select intBuyerID, strName from buyers where intStatus=1 order by strName ";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
	}
?>
                            </select>                </td>
                <td>Order Contract</td>
                <td><select name="cboOC" id="cboOC" style="width:122px;">
                  <option value="" selected="selected">All</option>
                  <option value="0">Pending</option>
                  <option value="1">First Approved</option>
                  <option value="2">Second Approved</option>
                </select></td>
                <td>&nbsp;</td>
              </tr>
           <tr><td colspan="6" height="10"></td></tr>  
            
            </table></td>
          </tr>
        </table></td>
        </tr>
      
      <tr>
        <td height="10"></td>
        </tr>
         <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="2" class="tableBorder">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center"><img src="../../images/new.png" width="96" height="24" onClick="ClearForm();"><img src="../../images/report.png" width="108" height="24" onClick="viewReport();"><img src="../../images/download.png" onClick="viewExcelReport();"><a href="../../main.php"><img src="../../images/close.png" width="97" height="24" border="0"></a></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<script language="javascript" type="text/javascript">
$(document).ready(function() 
{
	var url					='db.php?id=load_ord_str';
		var pub_xml_http_obj	=$.ajax({url:url,async:false});
		var pub_po_arr			=pub_xml_http_obj.responseText.split("|");
		
		$( "#txtOrderNo" ).autocomplete({
			source: pub_po_arr
		});
		
		
	
});

function viewReport()
{
	var txtDfrom  	= document.getElementById("txtDfrom").value;
	var txtDto    	= document.getElementById("txtDto").value;
	var orderNo     = URLEncode(document.getElementById("txtOrderNo").value);
	var buyer 		=  document.getElementById("cboAppBuyer").value;
	var taxStatus   = document.getElementById("cboTaxStatus").value;
	var ocStatus    = document.getElementById("cboOC").value;
	
	var url	 = "firstSaleReport.php?";
		url	+= "ReportType=N";
	 	url += "&txtDfrom="+txtDfrom+"&txtDto="+txtDto;
		url += "&orderNo="+orderNo;
		url += "&buyer="+buyer;
		url += "&taxStatus="+taxStatus;
		url += "&ocStatus="+ocStatus;
		
	window.open(url,'firstSaleReport.php');	
}

function viewExcelReport()
{
	var txtDfrom  	= document.getElementById("txtDfrom").value;
	var txtDto    	= document.getElementById("txtDto").value;
	var orderNo     = URLEncode(document.getElementById("txtOrderNo").value);
	var buyer 		=  document.getElementById("cboAppBuyer").value;
	var taxStatus   = document.getElementById("cboTaxStatus").value;
	var ocStatus    = document.getElementById("cboOC").value;
	
	var url	 = "firstSaleReport.php?";
		url	+= "ReportType=E";
	 	url += "&txtDfrom="+txtDfrom+"&txtDto="+txtDto;
		url += "&orderNo="+orderNo;
		url += "&buyer="+buyer;
		url += "&taxStatus="+taxStatus;
		url += "&ocStatus="+ocStatus;
		
	window.open(url,'firstSaleReport.php');	
}
function ClearForm(){	
	setTimeout("location.reload(true);",0);
	//$("#frmBalance")[0].reset();
}

</script>
</body>
</html>
