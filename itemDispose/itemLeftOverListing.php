<?php

session_start();
$backwardseperator = "../";
$intCompanyId		= $_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Common Stock Non-Moving Items </title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="pending-java.js" type="text/javascript"></script>
<script src="itemDispos.js" type="text/javascript"></script>
<script type="text/javascript">
function LoadData()
{
/*	if(document.getElementById('txtDays').value.trim() == "")
	{
		alert("Enter Days.");
		return false;
	}*/
	document.getElementById('itemLeftoverListing').submit();
}
function itemLeftReport(){

	window.open("itemLeftOverReport.php?days="+document.getElementById('txtDays').value.trim());
}
</script>
<script type="text/javascript">
function pageSubmit()
{
	//document.getElementById("frmGrnList").submit();
}
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

<body  >
<?php
	include "../Connector.php";	
	$days=$_POST['txtDays'];
	$SQL = " SELECT intCompanyID FROM useraccounts  where intUserID=".$_SESSION["UserID"].";";
				$result = $db->RunQuery($SQL);
				while($row = mysql_fetch_array($result))
					$_SESSION["intUserComp"]=$row["intCompanyID"];
?>
<form name="itemLeftoverListing" id="itemLeftoverListing" action="itemLeftoverListing.php" method="post">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
<tr>
    <td><?php include '../Header.php'; ?></td>
</tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
		  	<td width="4%" height="24" class="normalfnt">&nbsp;</td>
			<td width="11%" height="24" class="normalfnt">&nbsp;</td>
			<td width="7%" height="24" class="normalfnt">&nbsp;</td>
            <td width="11%" class="normalfnt">&nbsp;</td>
            <td width="7%" class="normalfnt">&nbsp;</td>
            <td width="15%" class="normalfnt">&nbsp;</td>
            <td width="2%" class="normalfnt">&nbsp;</td>
            <td width="7%" class="normalfnt">Days</td>
            <td width="14%" class="normalfnt"><input type="text" id="txtDays" name="txtDays" value="<?php echo $days; ?>" /></td>
            <td width="6%" class="normalfnt">&nbsp;</td>
            <td width="15%" class="normalfnt"><img src="../images/search.png" alt="search"  class="mouseover" onclick="LoadData();"/></td>
            <td width="1%" class="normalfnt">&nbsp;</td>
          </tr>
		           
        </table></td>
        </tr>

    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#9BBFDD" class="normalfntBtab">Common Stock Non-Moving Items </td>
        </tr>
      <tr>
        <td class="normalfnt"><div id="divcons" style="overflow:scroll; height:450px; width:950px;">
          <table width="926" cellpadding="0" cellspacing="0" id="tblPendingGrn" border="0"  bgcolor="#ccccff" rules="rows">
		  <thead>
            <tr>
		      <td width="3%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">*</td>
              <td width="10%" height="33" bgcolor="#498CC2" class="normaltxtmidb2"> No</td>
			  <td width="18%" bgcolor="#498CC2" class="normaltxtmidb2">Item Description </td>
              <td width="12%" bgcolor="#498CC2" class="normaltxtmidb2">Main store</td>
              <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Color</td>
			  <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Size</td>
			  <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Unit</td>
			  <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Qty</td>
			  <td width="5%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">Days</td>
			  <td width="12%" bgcolor="#498CC2" class="normaltxtmidb2">Date</td>
             </tr>
			</thead>
			<tbody>
			<?php $sql="
			select * from(SELECT
			DATEDIFF(now(),stocktransactions.dtmDate) AS NDays,
			concat(stocktransactions.intDocumentYear,'/',stocktransactions.intDocumentNo) as N,
			matitemlist.strItemDescription,
			mainstores.strName,
			stocktransactions.strColor,
			stocktransactions.strSize,
			stocktransactions.strUnit,
			stocktransactions.dblQty,
			stocktransactions.dtmDate
			FROM
			stocktransactions
			Inner Join matitemlist ON matitemlist.intItemSerial = stocktransactions.intMatDetailId
			Inner Join mainstores ON mainstores.strMainID = stocktransactions.strMainStoresID
			WHERE
			stocktransactions.strType =  'LeftOver' ) as tbl";
			if($days!=""){
				$sql.=" where tbl.NDays >= '$days'";
			}
			//echo $sql;
			$res=$db->RunQuery($sql);
			while(@$row=mysql_fetch_array($res)){
			?>
			 <tr>
		      <td width="3%" height="33" bgcolor="#ffffff" class=""> </td>
              <td width="10%" height="33" bgcolor="#ffffff" class="normalfntLeft"> <?php echo $row['N'];?></td>
			  <td width="18%" bgcolor="#ffffff" class="normalfnt"><?php echo $row['strItemDescription'];?> </td>
              <td width="12%" bgcolor="#ffffff" class="normalfnt"><?php echo $row['strName'];?></td>
              <td width="10%" bgcolor="#ffffff" class="normalfnt"><?php echo $row['strColor'];?></td>
			  <td width="10%" bgcolor="#ffffff" class="normalfnt"><?php echo $row['strSize'];?></td>
			  <td width="10%" bgcolor="#ffffff" class="normalfntCenterTABNoBorder"><?php echo $row['strUnit'];?></td>
			  <td width="10%" bgcolor="#ffffff" class="normalfntRite"><?php echo  round($row['dblQty'],4);?></td>
			  <td width="5%"  bgcolor="#ffffff" class="normalfntRite"><?php echo $row['NDays'];?></td>
			  <td width="12%" bgcolor="#ffffff" class="normalfntCenterTABNoBorder"> <?php echo substr($row['dtmDate'],0,10);?> </td>
			  
             </tr>
			 <?php }?>
			</tbody>
          </table>
        </div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5" border="0">
      <tr><!--<a href="itemLeftOverReport.php?days=<?php #echo $days; ?>" target="_blank" >-->
		 <td height="29" align="right"><img src="../images/print.png" border="0" class="mouseover" onclick="itemLeftReport();"/><!--</a>-->&nbsp;</td>
		 <td height="29" align="left">&nbsp;<a href="../main.php"><img src="../images/close.png"  border="0" class="mouseover" /></a></td>
        </tr>
    </table></td>
  </tr>
  <tr>
  </tr>
</table>
</form>
</body>
</html>
