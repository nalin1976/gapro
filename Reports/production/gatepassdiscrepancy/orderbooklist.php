<?php
session_start();
include "../../../Connector.php";
$backwardseperator = "../../../";

$txtDfrom	= date("01/m/Y");
$txtDto	=date("d/m/Y");	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Production Reports </title>

<script src="../../../javascript/script.js" language="javascript" type="text/javascript"></script>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css" />
<script src="../../../javascript/calendar/calendar.js" language="javascript" type="text/javascript"></script>
<script src="../../../javascript/calendar/calendar-en.js" language="javascript" type="text/javascript"></script>
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

<script type="text/javascript">
function viewReport()
{
/*	var checkDate 	= document.getElementById("checkDate").checked;
	var txtDfrom  	= document.getElementById("txtDfrom").value;
	var txtDto    	= document.getElementById("txtDto").value;
*/	
	var styleNo		= document.getElementById('cboStyleNo').value;
	var orderNo		= document.getElementById('cboOrderNo').value;
	var buyer    	= document.getElementById("cboBuyer").value;
	var toFactory	= document.getElementById('cboToFactory').value;
	if(document.getElementById("cboReportCategory").value=='0')
		var reportName = "rptdiscrepancy.php";
	var url  = reportName+"?&Buyer="+buyer+"&ToFactory="+toFactory+"&StyleNo="+URLEncode(styleNo)+"&OrderNo="+orderNo;
	window.open(url,reportName);	
}
	
function setDateChecked(objChk)
{
	if(!objChk.checked)
		{
			document.getElementById("txtDfrom").disabled= true;
			document.getElementById("txtDto").disabled= true;
			
		}
		else
		{
			document.getElementById("txtDfrom").disabled=false;
			document.getElementById("txtDto").disabled= false;
		}
	
}
function ShowExcelReport()
{
	var checkDate = document.getElementById("checkDate").checked;
	var txtDfrom  = document.getElementById("txtDfrom").value;
	var txtDto    = document.getElementById("txtDto").value;
	var buyer    	= document.getElementById("cboBuyer").value;
	var url  ="xclrptOrderBook.php?txtDfrom="+txtDfrom+"&txtDto="+txtDto+"&checkDate="+checkDate+"&Buyer="+buyer;
	window.open(url);
	
}

function LoadOrderNo(obj)
{
	var styleNo	= obj.value;
	
	var url = "discrepancydb.php?RequestType=LoadOrderNo&StyleNo="+URLEncode(styleNo);
	var htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboOrderNo').innerHTML = htmlobj.responseText;
	
	var url = "discrepancydb.php?RequestType=LoadSCNo&StyleNo="+URLEncode(styleNo);
	var htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboScNo').innerHTML = htmlobj.responseText;
}

function SetOrderNo(obj)
{
	document.getElementById('cboOrderNo').value = obj.value;
}

function SetSCNo(obj)
{
	document.getElementById('cboScNo').value = obj.value;
}
</script>
</head>

<body>
<tr>
<td><?php include '../../../Header.php'; ?></td>
</tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="100%" border="0" class="bcgl1">
          <tr>
            <td height="25" class="mainHeading">Production Reports </td>
          </tr>
          <tr>
            <td height="75"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="92%" class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td class="normalfnt"><table width="100%" border="0" cellspacing="1" cellpadding="0">
                          <tr>
                            <td colspan="2">&nbsp;</td>
                            <td width="25%">&nbsp;</td>
                            <td width="11%">&nbsp;</td>
                            <td width="38%">&nbsp;</td>
                          </tr>
                          <tr style="display:none">
                            <td width="8%" align="center"><input name="checkDate" id="checkDate" type="checkbox" checked="checked" onclick="setDateChecked(this);"/></td>
                            <td width="18%" >Date From</td>
                            <td><input type="text" name="txtDfrom " id="txtDfrom" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"  value="<?php echo ($txtDfrom=="" ? "":$txtDfrom);?>" /><input name="text" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                            <td>Date To</td>
                            <td><input type="text" name="txtDto" id="txtDto" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($txtDto=="" ? "":$txtDto);?>"><input name="text2" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td>To Factory </td>
                            <td colspan="3"><select name="cboToFactory" class="txtbox" id="cboToFactory" style="width:302px">
                              <?php 	
	$SQL="select distinct C.intCompanyID,C.strName from productiongpheader PGH inner join companies C on C.intCompanyID=PGH.intTofactory
order by C.strName";	
	$result =$db->RunQuery($SQL);	
		echo "<option value =\"".""."\">"."Select One"."</option>";
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["intCompanyID"]."\">".$row["strName"]."</option>";
	}
?>
                            </select></td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td>Buyer</td>
                            <td colspan="3"><select name="cboBuyer" class="txtbox" id="cboBuyer" style="width:302px">
 <?php 	
	$SQL="select B.intBuyerID,B.strName from buyers B where B.intStatus=1 order by B.strName";	
	$result =$db->RunQuery($SQL);	
		echo "<option value =\"".""."\">"."All"."</option>";
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["intBuyerID"]."\">".$row["strName"]."</option>";
	}
?>
                            </select></td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td>Style No </td>
                            <td colspan="3"><select name="cboStyleNo" class="txtbox" id="cboStyleNo" style="width:302px" onchange="LoadOrderNo(this)">
                              <?php 	
	$SQL="select distinct O.strStyle from productiongpheader PGH inner join orders O on O.intStyleId=PGH.intStyleId
order by O.strStyle;";
	$result =$db->RunQuery($SQL);	
		echo "<option value =\"".""."\">"."All"."</option>";
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["strStyle"]."\">".$row["strStyle"]."</option>";
	}
?>
                            </select></td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td>Order No </td>
                            <td><select name="cboOrderNo" class="txtbox" id="cboOrderNo" style="width:130px" onchange="SetSCNo(this);">
                              <?php 	
	$SQL="select distinct O.intStyleId,O.strOrderNo from productiongpheader PGH inner join orders O on O.intStyleId=PGH.intStyleId
order by O.strOrderNo;";	
	$result =$db->RunQuery($SQL);	
		echo "<option value =\"".""."\">"."All"."</option>";
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
	}
?>
                            </select></td>
                            <td>SC No </td>
                            <td><select name="cboScNo" class="txtbox" id="cboScNo" style="width:100px" onchange="SetOrderNo(this);">
                              <?php 	
	$SQL="select distinct S.intStyleId,S.intSRNO from productiongpheader PGH inner join specification S on S.intStyleId=PGH.intStyleId
order by S.intSRNO DESC";	
	$result =$db->RunQuery($SQL);	
		echo "<option value =\"".""."\">"."All"."</option>";
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["intStyleId"]."\">".$row["intSRNO"]."</option>";
	}
?>
                            </select></td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td>Report Category </td>
                            <td colspan="3">
							<select name="cboReportCategory" class="txtbox" id="cboReportCategory" style="width:302px">
								<option value="0">GatePass Qty Discrepancies Report</option>								
                            </select></td>
                          </tr>
                      </table></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor="#FFE1E1"><table width="100%" border="0">
                    <tr>
                      <td width="25%" align="center">                     
                      <img src="../../../images/new.png" alt="new" onclick="ClearForm();"/>
                     	<img src="../../../images/report.png" alt="Report" name="Delete"  border="0" class="mouseover" onclick="viewReport();"/>
						<img src="../../../images/download.png"  border="0" onclick="ShowExcelReport();" style="display:none"/>
                      <a href="../../../main.php"><img src="../../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0"/></a>                      </td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="19%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<script type="text/javascript">
function ClearForm(){	
	setTimeout("location.reload(true);",0);
	//$("#frmBalance")[0].reset();
}
</script>
<!--</form>-->
</body>
</html>
