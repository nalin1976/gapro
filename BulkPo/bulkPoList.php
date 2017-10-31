<?php
include "../Connector.php";
$backwardseperator = "../";
session_start();

	$dateFrom		= $_POST["txtDateFrom"];
	$dateFromArray 	= explode('/',$dateFrom);
	$dateTo			= $_POST["txtDateTo"];
	$dateToArray 	= explode('/',$dateTo);
	$chkDate		= $_POST["chkDate"];
	$cboMode		= $_POST["cboMode"];
	if(!isset($_POST["cboMode"])&&$_POST["cboMode"]=="")
	{
		$dateFrom	= date("d/m/Y");
		$dateTo		= date("d/m/Y");
		$chkDate 	= "on";
		$cboMode 	= 0;
	}	
	$dateFromArray 	= explode('/',$dateFrom);
	$dateToArray 	= explode('/',$dateTo);
	$cbopolist		= $_POST["cbopolist"];
	$txtPoNo		= $_POST["txtPoNo"];
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Bulk Purchase Order</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="bulkPo-java.js" type="text/javascript"></script>
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
<body >
<form name="frmBulkPOListing" id="frmBulkPOListing" action="bulkPoList.php" method="post">
  <tr>
    <td><?php include '../Header.php'; ?></td>
  </tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
      <tr>
        <td width="61%" height="25" class="mainHeading">Bulk PO List</td>      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="tableBorder" align="center">      
      <tr>
        <td width="1%" >&nbsp;</td>
        <td width="5%" class="normalfnt">Suplier</td>
        <td width="28%"><select name="cbopolist" class="txtbox" id="cbopolist" style="width:255px" >
		 <option value="" selected="selected" >Select One</option>
<?php
$SQL = "SELECT strTitle,strSupplierID FROM suppliers s where intStatus='1' order by strTitle;";	
$result = $db->RunQuery($SQL);		
while($row = mysql_fetch_array($result))
{
	echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
}
?>								 
                </select></td>
        <td width="3%"><span class="normalfnt">
          <input type="checkbox" name="chkDate" id="chkDate" <?php echo($chkDate=="on" ? "checked=\"checked\"":"");?>/>
        </span></td>
        <td width="5%" class="normalfnt">From</td>
        <td width="14%"><input name="txtDateFrom" type="text" class="txtbox" id="txtDateFrom" size="12" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($dateFrom=="" ? "":$dateFrom);?>"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%d/%m/%Y');" ></td>
        <td width="3%" class="normalfnt">To</td>
        <td width="13%"><input name="txtDateTo" type="text" class="txtbox" id="txtDateTo" size="12" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($dateTo=="" ? "":$dateTo);?>"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%d/%m/%Y');"></td>
        <td width="8%" class="normalfnt">PO No Like </td>
        <td width="11%"><input type="text" id="txtPoNo" name="txtPoNo" size="14" class="txtbox" value="<?php echo $txtPoNo;?>" /></td>
        <td width="9%"><img src="../images/search.png" alt="search" width="80" height="24" onclick="loadBulkPo();"/></td>
      </tr>
      <tr>
        <td >&nbsp;</td>
        <td class="normalfnt">Mode</td>
        <td><select name="cboMode" class="txtbox" id="cboMode" style="width:255px" >
          <option value="0" <?php echo ($cboMode=='0'? "selected=selected":"");?>>Pending for Process</option>
          <option value="1" <?php echo ($cboMode=='1'? "selected=selected":"");?>>Processed</option>
          <option value="10"<?php echo ($cboMode=='10'? "selected=selected":"");?>>Cancelled</option>
        </select></td>
        <td>&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="950" border="0" cellpadding="0" cellspacing="0" align="center">
      <tr>
        <td height="17" class="mainHeading2"><div align="center">BULK PO's</div></td>
        </tr>
      <tr>
        <td align="center"><div id="divcons2" style="overflow:scroll; height:450px; width:950px;">
          <table width="100%" cellpadding="2" cellspacing="1" id="tblPoList" bgcolor="#CCCCFF"> 
            <tr class="mainHeading4">
              <td width="10%" height="25" >PO No</td>
              <td width="80%" >Suplier Name </td>
              <td width="10%" >View</td>
            </tr>
<?php
$SQL =  "SELECT BPH.intBulkPoNo,BPH.intYear,S.strTitle FROM bulkpurchaseorderheader BPH Inner Join suppliers S ON S.strSupplierID = BPH.strSupplierID WHERE BPH.intStatus = '$cboMode' ";

if($chkDate=="on")
	$SQL .= " AND BPH.dtDate>='".$dateFromArray[2].'-'.$dateFromArray[1].'-'.$dateFromArray[0]."' ";
if($chkDate=="on")
	$SQL .= " AND BPH.dtDate<='".$dateToArray[2].'-'.$dateToArray[1].'-'.$dateToArray[0]."'";
if($txtPoNo!="")
	$SQL .= " AND BPH.intBulkPoNo LIKE '%$txtPoNo%' ";
if($cbopolist!="")
	$SQL .= " AND BPH.strSupplierID = '$cbopolist' ";
$result = $db->RunQuery($SQL);
while($row = mysql_fetch_array($result))
{
?>
		<tr class="bcgcolor-tblrowWhite">
		  <td height="15" class="normalfnt"><a href="../BulkPo/bulkPo.php?id=1&BulkPoNo=<?php echo $row["intBulkPoNo"];?>&intYear=<?php echo $row["intYear"];?>" class="non-html pdf" target="_blank"><?php echo $row["intYear"].'/'.$row["intBulkPoNo"]?></a></td>
		  <td class="normalfnt"><?php echo $row["strTitle"]?></td>
		  <td ><a href="../BulkPo/bulkPurchaeOrderReport.php?id=1&bulkPoNo=<?php echo $row["intBulkPoNo"];?>&intYear=<?php echo $row["intYear"];?>" class="non-html pdf" target="_blank"><img border="0" src="../images/view.png" alt="view" /></a></td>
		</tr>
<?php
}
?>
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>