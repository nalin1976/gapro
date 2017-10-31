<?php
session_start();
include "../Connector.php"; 
$backwardseperator = "../";
$companyId			= $_SESSION["FactoryID"];

$chkDate			= $_GET["chkDate"];
$txtDateFrom		= trim($_GET["txtFromDate"]);
$txtDateTo			= trim($_GET["txtToDate"]);
$txtOrderNo		 	= trim($_GET["txtOrderNo"]);
$txtAllocationNo 	= trim($_GET["txtAllocationNo"]);
$cboSubCategory  	= $_GET["cboSubCategory"];
$cboItem 		 	= $_GET["cboItem"];
$cboLOCompany	 	= $_GET["cboLOCompany"];
$txtItem		 	= trim($_GET["txtItem"]);
$reportFormat		= $_GET["ReportFormat"];

if($reportFormat=="E")
{
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment;filename="ExportAnalysis.xls"');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Item Wise Left Over Allocation List</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../js/jquery-ui-1.8.9.custom.css"/>

<style type="text/css">
<!--
#tblSample td, th { padding: 0.5em; }
.classy0 { background-color: #234567; color: #89abcd; }
.classy1 { background-color: #89abcd; color: #234567; }
.style3 {color: #000000}
-->
</style>

</head>
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>


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

function clearDate(obj)
{
	if(!obj.checked)
	{
		document.getElementById('txtFromDate').value="";
		document.getElementById('txtToDate').value="";
		document.getElementById("txtFromDate").disabled =true;
		document.getElementById("txtToDate").disabled =true;
	}
	else
	{
		document.getElementById("txtFromDate").disabled =false;
		document.getElementById("txtToDate").disabled =false;
		document.getElementById('txtFromDate').value="<?php echo date('Y-m-d');?>";
		document.getElementById('txtToDate').value="<?php echo date('Y-m-d');?>";
	}
}
function SearchDetails()
{
	document.frmItemWiseLeftOverList.submit();
}
function loadData(evt)
{
	
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	 if(charCode == 13)
	 {
		 document.frmItemWiseLeftOverList.submit();
	 }
}

</script>

<body>
<form id="frmItemWiseLeftOverList" name="frmItemWiseLeftOverList" method="post" action="itemWiseLeftOverList.php">
<table width="950" border="0" align="center" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td><table width="1100" border="0" cellpadding="1" cellspacing="1" id="tblGRNDetails" bgcolor="#333333">
        <thead>
            <tr bgcolor="#CCCCCC" class="normalfntMid">
              <th width="75" height="25" nowrap="nowrap" >&nbsp;LeftOver No&nbsp;</th>
              <th width="68" nowrap="nowrap" >&nbsp;Order No&nbsp;</th>
              <th width="66" nowrap="nowrap" >&nbsp;strBuyerPoNo&nbsp;</th>
              <th width="53" nowrap="nowrap" >&nbsp;Item Description&nbsp;</th>
              <th width="67" nowrap="nowrap" >&nbsp;Color&nbsp;</th>
              <th width="108" nowrap="nowrap" >&nbsp;Size&nbsp;</th>
              <th width="49" nowrap="nowrap" >&nbsp;strUnit&nbsp;</th>
              <th width="36" nowrap="nowrap" >&nbsp;Allowcation Qty&nbsp;</th>
              <th width="41" nowrap="nowrap" >&nbsp;Saved By&nbsp;</th>
              <th width="70" nowrap="nowrap" >&nbsp;Saved Date&nbsp;</th>
              <th width="74" nowrap="nowrap"  >&nbsp;Company Code&nbsp;</th>
              <th width="77" nowrap="nowrap" >&nbsp;GRN No&nbsp;</th>
              </tr>
            </thead>
  <?php
$sql="select concat(IWLH.intSerialYear,'/',IWLH.intSerialNo) as leftoverNo,IWLD.intStyleId,IWLD.strBuyerPoNo,MIL.strItemDescription,
IWLD.strColor,IWLD.strSize,IWLD.strUnit,IWLD.dblQty ,UA.Name,IWLH.dtmDate,C.strComCode,concat(IWLD.intGRNYear,'/',IWLD.intGRNNo) as GRNNo,O.strOrderNo,IWLD.intMatDetailId,IWLD.strGRNType,IWLD.intGRNYear,IWLD.intGRNNo
from itemwiseleftover_header IWLH
inner join itemwiseleftover_detail IWLD ON IWLH.intSerialNo=IWLD.intSerialNo and IWLH.intSerialYear=IWLD.intSerialYear
inner join matitemlist MIL ON MIL.intItemSerial=IWLD.intMatDetailId
inner join useraccounts UA ON UA.intUserID=IWLH.intUserId
inner join companies C ON C.intCompanyID=IWLH.intCompanyId
inner join orders O ON O.intStyleId=IWLD.intStyleId
where IWLH.intStatus<>'a' ";

if($txtOrderNo!="")
	$sql .= "and O.strOrderNo='$txtOrderNo' ";
	
if($txtAllocationNo!="")
	$sql .= "and IWLH.intSerialNo='$txtAllocationNo' ";
	
if($cboItem!="")
	$sql .= "and IWLD.intMatDetailId='$cboItem' ";

if($cboLOCompany!="")
	$sql .= "and IWLH.intCompanyId='$cboLOCompany' ";
	
if($chkDate=='on')
	$sql .= "and date(IWLH.dtmDate)>='$txtDateFrom' and date(IWLH.dtmDate)<='$txtDateTo' ";

if($txtItem!="")
	$sql .= " and MIL.strItemDescription like '%$txtItem%' ";
if($cboSubCategory!="")
	$sql .= " and MIL.intSubCatID = $cboSubCategory ";
	
$sql .= " order by IWLH.intSerialYear,IWLH.intSerialNo ";
//echo $sql;
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	
?>
            <tr bgcolor="#FFFFFF">
              <td height="15" nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["leftoverNo"]  ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strOrderNo"]?>&nbsp;</td>	
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strBuyerPoNo"]?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strItemDescription"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strColor"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strSize"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strUnit"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt" style="text-align:right">&nbsp;<?php echo $row["dblQty"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["Name"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["dtmDate"] ?>&nbsp;</td>
              <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strComCode"] ?>&nbsp;</td>
              <?php
		if($row["strGRNType"]=="B")
		{
		?>
              <td nowrap="nowrap" class="normalfnt"><a href="../BulkGRN/Details/grnReport.php?grnYear=<?php echo $row["intGRNYear"]?>&amp;grnno=<?php echo $row["intGRNNo"]?>" target="_blank" id="Bulkgrnreport" rel="1">&nbsp;<u><?php echo $row["GRNNo"]?></u>&nbsp;</a></td>	
              <?php
		}
		else
		{
		?>
              <td nowrap="nowrap" class="normalfnt"><a href="../GRN/Details/grnReport.php?grnYear=<?php echo $row["intGRNYear"]?>&amp;grnno=<?php echo $row["intGRNNo"]?>" target="_blank" id="grnreport" rel="1">&nbsp;<u><?php echo $row["GRNNo"]?></u>&nbsp;</a></td>
              <?php
		}
		?>
              </tr>
  <?php 
}
?>
            </table>
          </td>
        </tr>
      </table>
    
</table>
</form>
<script type="text/javascript" src="frmItemWiseLeftOver.js"></script>
</body>
</html>
