<?php
session_start();
$backwardseperator = "../../../";
include "$backwardseperator".''."Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search Export AOD</title>
<style type="text/css"> 
body {
	background-color: #CCCCCC;
	
}
</style>
<link type="text/css" href="../../../css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
<script type="text/javascript" src="../../../js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="../../../js/jquery-ui-1.7.2.custom.min.js"></script>
        
        
		<script type="text/javascript" src="../../../js/jquery-1.4.4.min.js"></script>
		<link href="../../../css/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="../../../js/jquery-ui-1.8.9.custom.min.js"></script>
		<script src="jquery.fixedheader.js" type="text/javascript"></script>


<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="search.js"></script>

<link rel="stylesheet" type="text/css" href="../../../javascript/calendar/theme.css" />
<script src="../../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../../javascript/calendar/calendar-en.js" type="text/javascript"></script>


<script type="text/javascript" src="../../../javascript/script.js"></script>

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
.dataTable { font-family:Verdana, Arial, Helvetica, sans-serif; border-collapse: collapse; border:1px solid #999999; width: 750px; font-size:12px;}
.dataTable td, .dataTable th { padding: 0px 0px;  margin:0px;border:1px solid #D7CEFF;}

.dataTable thead a {text-decoration:none; color:#444444; }
.dataTable thead a:hover { text-decoration: underline;}

/* Firefox has missing border bug! https://bugzilla.mozilla.org/show_bug.cgi?id=410621 */
/* Firefox 2 */
html</**/body .dataTable, x:-moz-any-link {margin:1px;}
/* Firefox 3 */
html</**/body .dataTable, x:-moz-any-link, x:default {margin:1px}
</style>
</head>

<body>
<table  width="950" border="0" cellspacing="0" cellpadding="2" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include "".$backwardseperator."Header.php"; ?></td>
  </tr>
  <tr>
    <td bgcolor="#316895"  height="25" class="TitleN2white" >Export AOD Search</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="3" class="normalfnt">
     
      <tr>
	    <td width="4%">&nbsp;</td>
        <td width="10%" height="25">PL No</td>
        <td width="17%"><select name="cboPLNo" class="txtbox" id="cboPLNo" style="width:135px" tabindex="3" onchange="deleteRows();">
          <option value=""></option>
		  <?php
		  	$sql="SELECT DISTINCT strPLNo FROM exportdispatchdetail ORDER BY strPLNo ASC ;";
			$result = $db->RunQuery($sql);
			while($row = mysql_fetch_array($result))
			{
		  ?>
		   <option value="<?php echo $row['strPLNo']; ?>"><?php echo $row['strPLNo']; ?></option>
		   <?php
		   }
		   ?>
        </select></td>
        <td width="7%">PO No</td>
        <td width="23%"><input name="txtPONo"  type="" class="txtbox" id="txtPONo" tabindex="1" style="width:150px" /></td>
        <td width="13%">Buyer</td>
        <td width="26%"><select name="cboBuyer" class="txtbox" id="cboBuyer" style="width:130px" tabindex="3" onchange="deleteRows();">
          <option value=""></option>
		  <?php
			$sql="SELECT DISTINCT buyers.strBuyerID,buyers.strName,buyers.strBuyerCode
					FROM buyers 
					INNER JOIN exportdispatchheader ON exportdispatchheader.strBuyerCode=buyers.strBuyerID
					ORDER BY strBuyerID";
			$result=$db->RunQuery($sql);
			while($row=mysql_fetch_array( $result)) 
			{ 
				echo "<option value=".$row['strBuyerID'].">".$row['strName']." ---> ".$row['strBuyerCode']."</option>";
		?>
			
		 <?php
			 }
		?>
        </select></td>
      </tr>
       <tr>
	     <td>&nbsp;</td>
       	 <td width="10%">Date    From</td>
		 <?php
		 	$sql="SELECT dtmDate from exportdispatchheader 
				 ORDER BY dtmDate ASC LIMIT 1; ";
				 
			$result=$db->RunQuery($sql);
			$row=mysql_fetch_array($result);
			
			$dateDispatch=$row['dtmDate'];
			if($dateDispatch!='')
			{
				$dateDispatchArray 	= explode('-',$dateDispatch);
				$FormatDateDispatch = $dateDispatchArray[2]."/".$dateDispatchArray[1]."/".$dateDispatchArray[0];
			}
			else
				$FormatDateDispatch='';
		  ?>
       	 <td width="17%"><input tabindex="2" id="txtFromDate" name="txtFromDate" type="text" class="txtbox" size="20" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo $FormatDateDispatch; ?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
		 <td width="7%">To</td>
		 <td width="23%"><input tabindex="2" id="txtToDate" name="txtToDate" type="text" class="txtbox" size="20" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
         <td><img src="../../../images/search.png" width="80" height="24" id="btnSearch" class="mouseover" onclick="validateData();"/></td>
         <td>&nbsp;</td>
       </tr>
    </table></td>
  </tr>
  <tr>
    <td height="300" valign="top" class="normalfnt">
<!--	<div id="divcons"  style="overflow-x:hidden; overflow-y:scroll;  height:400px; width:100%;">
	<table style="width:100%;"  cellpadding="2" cellspacing="1" bgcolor="#EFDEFE"  id="tblDispatchDetails">
      <thead>
        <tr class="mainHeading4 normaltxtmidb2 " >
          <th height="25"  width="10%" bgcolor="#498CC2">Dispatch No</th>
           <th height="25"  width="8%" bgcolor="#498CC2">Date</th>
          <th height="25"  width="12%" bgcolor="#498CC2">Buyer</th>
           <th height="25"  width="6%" bgcolor="#498CC2">Report</th>
          <th height="25"  width="6%" bgcolor="#498CC2">View</th>
        </tr>
      </thead><tbody></tbody>
    </table>
	</div>-->
	<div id="divcons"  style="overflow-x:hidden; overflow-y:scroll;  height:400px; width:100%;">
          <table width="954" cellpadding="0" cellspacing="1" bgcolor="#9BBFDD" id="tblDispatchDetails">
          
            <tr>
			  <td width="4%" bgcolor="#498CC2" class="normaltxtmidb2">Dispatch No</td>
              <td width="8%" height="25" bgcolor="#498CC2" class="normaltxtmidb2">Date</td>
              <td width="16%" bgcolor="#498CC2" class="normaltxtmidb2">Buyer</td>
			  <td width="4%" bgcolor="#498CC2" class="normaltxtmidb2">Report</td>
              <td width="4%" bgcolor="#498CC2" class="normaltxtmidb2">View</td>
			</tr>
	</table>
	</div>
	</td>
  </tr>
</table>
</body>
</html>