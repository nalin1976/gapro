<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web - Import IOU Cancellation</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" /><link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="canceliou.js" type="text/javascript"></script>
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
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style></head>

<body >

<?php
	include "../../Connector.php";	
	
				
?>
<form name="frmbom" id="frmbom" >
<table width="950" border="0" align="center" bgcolor="#FEFDEB">
<tr>
    <td><?php include '../../Header.php'; ?></td>
</tr>
  
  
  
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="24" bgcolor="#9BBFDD" class="bcgcolor-row"><div align="center" class="TitleN2white"> IOU Cancellation </div></td>
        </tr>
		<tr>
        <td bgcolor="#ffffff" class="bcgl1Txt2" > <table width="935" cellpadding="0" cellspacing="1" bgcolor="#9BBFDD" id="tbliou">
           <!-- <tr>
              <td width="15%" height="24" bgcolor="#498CC2" class="normaltxtmidb2">IOU No </td>
              <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Date</td>
			  <td width="25%" bgcolor="#498CC2" class="normaltxtmidb2">Consignee </td>
              <td width="25%" bgcolor="#498CC2" class="normaltxtmidb2">Wharf Clerk</td>
              <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">&nbsp;</td>
			  <td width="20%" bgcolor="#498CC2" class="normaltxtmidb2">Reason</td>
        </tr>--></table>
		
      <tr>
        <td class="normalfnt"><div id="divcons"  style="overflow:scroll; height:430px; width:950px;">
          <table width="935" cellpadding="0" cellspacing="1" bgcolor="#9BBFDD" id="tbliou">
            <tr>
              <td width="10%" height="24" bgcolor="#498CC2" class="normaltxtmidb2">IOU No </td>
              <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Date</td>
			  <td width="25%" bgcolor="#498CC2" class="normaltxtmidb2">Consignee </td>
              <td width="25%" bgcolor="#498CC2" class="normaltxtmidb2">Wharf Clerk</td>
              <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">&nbsp;</td>
			  <td width="25%" bgcolor="#498CC2" class="normaltxtmidb2">Reason</td>
        </tr>
			  <?php 
			$str="select 	ih.intIOUNo, 	
				(select strName from customers where strCustomerID=  ih.strCustomerID) as Customer, 
				(select strName from wharfclerks where intWharfClerkID=  ih.intWharfClerk) as wharfclerk	 
				,strstatus,reason,userid
				from 
				tbliouheader ih left join tblioucancellation ic on ic.iouno=ih.intIOUNo ";
				$result = $db->RunQuery($str);
				$i=0;
			 while($row = mysql_fetch_array($result))
			  { if ($i%2==0)
			    $class="bcgcolor-tblrow";
				else
				$class="bcgcolor-tblrowWhite";
			  ?>
			   <tr class="<?php echo $class;?>">
              <td height="24" ><?php echo $row["intIOUNo"];?> </td>
              <td ><?php echo date("d/m/y");?></td>
			  <td ><?php echo $row["Customer"];?> </td>
              <td ><?php echo $row["wharfclerk"];?></td>
			  <?php if($row["strstatus"]==""){?>
              <td  align="center"><img src="../../images/eclose.png" alt="cancel"  class="mouseover" onclick="confirmCancel(this);" /></td><?php } else{?><td align="center"><div style='color:#CC0000'>Canceled</div></td><?php }?>
			  <td ><?php echo $row["reason"];?></td></tr>
			  <?php $i++;}?>
          </table>
        </div></td>
        </tr>
        
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
      <tr>
        
        <td width="12%" align="center" onclick="updateiou('settle');" >&nbsp;</td>
        <td width="11%">&nbsp;</td>    	
        <td width="11%">&nbsp;</td>
        <td width="11%">&nbsp;</td>
        <td width="11%"><img src="../../images/cancel.jpg" alt="Cancel" name="butCancel" width="84" height="24" class="mouseover" id="butCancel" onclick="frmReload();"/></td>
        <td width="11%"><img src="../../images/report.png" name="butReport" width="84" height="24" class="mouseover" id="butReport"  onclick="printthis();"/></td>
        <td width="11%"><a href="../../main.php"><img src="../../images/close.png" width="84" height="24" border="0" class="mouseover" /></a></td>
        <td width="11%">&nbsp;</td>    
      </tr>
    </table></td>
  </tr>
</table>
</form>

</body>
</html>


