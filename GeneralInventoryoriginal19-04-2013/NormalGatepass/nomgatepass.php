<?php
	session_start();
	include "../../Connector.php";	
	$backwardseperator = "../../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Normal Gatepass</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>

<script type="text/javascript" src="nomgatepass.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>


<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>
<link href="../GeneralIssue/css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../GeneralIssue/javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>

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
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script type="text/javascript">
var factoryID = <?php

 echo $_SESSION["FactoryID"]; 
 ?>;
 //alert(factoryID);
var UserID = <?php
 session_start();
 echo $_SESSION["UserID"]; 
 ?>;
var EscPercentage = 0.25;
 
var serverDate = new Date();
serverDate.setYear(parseInt(<?php
echo date("Y"); 
?>));
serverDate.setMonth(parseInt(<?php
echo date("m"); 
?>));
serverDate.setDate(parseInt(<?php
echo date("d")+1; 
?>));
</script>

<script src="../javascript/script.js" type="text/javascript"></script>
<script src="../GeneralIssue/java.js" type="text/javascript"></script>

</head>

<body onload="loadDetails(
<?php 	
	$no = $_GET["No"];
	$noArray	= explode('/',$no);
	if($no!=""){
		echo $noArray[0] ; echo "," ; echo $noArray[1];		 
		}
	else
		echo "0,0";
?> );">

<form name="frmIssues" id="frmIssues">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
   <tr>
    <td height="26" bgcolor="#316895" class="TitleN2white">Normal Gatepass</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="100%"><table  width="100%" border="0" cellpadding="0" cellspacing="0" >
          <tr>
            <td class="normalfnt" height="25" >Gatepass No</td>
            <td class="normalfnt"><input name="txtreturnNo" type="text" class="txtbox" id="txtreturnNo" style="width:150px;" readonly="readonly" /></td>
            <td class="normalfnt">Date</td>
            <td class="normalfnt"><input name="txtdate" type="text" READONLY class="txtbox" id="txtdate" style="width:150px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date ("d/m/Y") ?>"/><input name="reset" type="reset" class="txtbox" style="visibility:hidden;" onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
            <td class="normalfnt">Gatepass To </td>
            <td class="normalfnt"><!--<select name="cboreturnedby" class="txtbox" id="cboreturnedby" style="width:180px">
            </select>-->
			  <input name="cboreturnedby" type="text" class="txtbox" id="cboreturnedby" style="width:150px;" maxlength="60" /></td>
          </tr>
          <tr>
        <!--    <td width="9%" height="24" class="normalfnt">Mat. Req No</td>
            <td width="10%" class="normalfnt"><select name="cbosuporigin" class="txtbox" id="cbosuporigin" style="width:80px">
            </select>            </td>-->
            <td width="10%" height="25" class="normalfnt">Attention</td>
            <td width="23%" class="normalfnt"><input name="txtattention" type="text" class="txtbox" id="txtattention" style="width:150px;" maxlength="60" /></td>
            <td width="10%" class="normalfnt">Through</td>
            <td width="24%" class="normalfnt"><!--<select name="cbopodatefrm" class="txtbox" id="cbopodatefrm" style="width:80px">
            </select>       -->
              <input name="txtthrough" type="text" class="txtbox" id="txtthrough" style="width:150px;" maxlength="60" /></td>
            <td width="10%" class="normalfnt">Instructed By </td>
            <td width="23%" class="normalfnt"><!--<input name="txtinstructed" type="text" class="txtbox" id="txtinstructed" size="30" />-->
			<input name="cboinstruct" type="text" class="txtbox" id="cboinstruct" style="width:150px;" maxlength="60" />
              <!--<select name="cboinstruct" class="txtbox" id="cboinstruct" style="width:180px">

              </select>--></td>          
			<!--<td width="9%" class="normalfnt"> Issue No Like </td>
			<td width="11%" class="normalfnt"><input type="text" id="txtisslike" name="txtisslike" size="13" class="txtbox" /></td>--><td width="9%" class="normalfnt">&nbsp;</td>
          </tr>
          <tr>
        <!--    <td width="9%" height="24" class="normalfnt">Mat. Req No</td>
            <td width="10%" class="normalfnt"><select name="cbosuporigin" class="txtbox" id="cbosuporigin" style="width:80px">
            </select>            </td>-->
            <td  height="25" class="normalfnt">Remarks</td>
            <td  colspan="3" class="normalfnt"><input name="txtRemarks" type="text" class="txtbox" id="txtRemarks" style="width:463px;" maxlength="60" /></td>
            <td class="normalfnt">Style No</td>
            <td class="normalfnt"><!--<select name="cbopodatefrm" class="txtbox" id="cbopodatefrm" style="width:80px">
            </select>       -->
              <input name="txtStyleNo" type="text" class="txtbox" id="txtStyleNo" style="width:150px;" maxlength="60" /></td>
  </tr>
           <tr>
            <td class="normalfnt">Special Instruction</td>
            <td class="normalfnt" colspan="5"><textarea name="txtInstructions" class="txtbox" id="txtInstructions" style="width:782px;"></textarea></td>
       </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="89%" bgcolor="#9BBFDD" class="normalfnth2"><div align="center">Normal Gatepass Details</div></td>
        <td width="11%" bgcolor="#9BBFDD" class="normalfnt"><img src="../../images/add-new.png" alt="add new" width="109" height="18" onclick="AdddetailsTomainPage();"/></td>
      </tr>
      <tr>
        <td colspan="2" class="normalfnt"><div id="divcons" style="overflow:scroll; height:250px; width:950px;">
          <table id="tblIssueList" width="900" bgcolor="#CCCCFF"  cellpadding="0" cellspacing="1" >
            <tr >
              <td width="2%" height="24" bgcolor="#498CC2" class="normaltxtmidb2">Del</td>              
			  <td width="30%" bgcolor="#498CC2" class="normaltxtmidb2">Description</td>			  
              <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Quantity</td>
              <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Unit</td>
					<td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Returnable</td>
			  </tr>
       <!--     <tr>
              <td><div align="center"><img src="../images/edit.png" alt="edit" width="15" height="15" /></div></td>
              <td><div align="center"><img src="../images/del.png" alt="del" width="15" height="15" /></div></td>
              <td class="normalfnt">Pocketing</td>
			  <td class="normalfnt">Pocketing-100%</td>
			  <td class="normalfntMid">Orange</td>
              <td class="normalfntMid">L</td>			      
              <td> <input type="text" size="10" class="txtbox" name="txtIssueQty" id="txtIssueQty" onfocus="GetQty(this);"/></td>			 
              <td class="normalfntMid"><img src="../images/aad.png" alt="add" width="15" height="15" onclick="ShowBinItems(this);"/></td>
              <td class="normalfntRite">100</td>
              <td class="normalfntRite">1000</td>
			  <td class="normalfntMid">2009/100005</td>
              <td class="normalfntMid">100005</td>
              <td class="normalfntMid">POC</td>
              </tr>-->
           <!-- <tr>
              <td><div align="center"><img src="../images/edit.png" alt="edit" width="15" height="15" /></div></td>
              <td><div align="center"><img src="../images/del.png" alt="del" width="15" height="15" /></div></td>
              <td class="normalfnt">Zipper</td>
              <td class="normalfnt">Zipper</td>
			  <td class="normalfntMid">0</td>
              <td class="normalfntMid">145.24</td>			  
              <td class="normalfntRite">442</td>
              <td class="normalfntMid">0</td>
              <td class="normalfntRite">.2542</td>
              <td class="normalfntRite">0.254</td>
			  <td class="normalfntMid">ACCE</td>
              <td class="normalfntMid">0</td>
              <td class="normalfntMid">ZIPPR</td>
              </tr>
            <tr>
              <td><div align="center"><img src="../images/edit.png" alt="edit" width="15" height="15" /></div></td>
              <td><div align="center"><img src="../images/del.png" alt="del" width="15" height="15" /></div></td>
              <td class="normalfnt">Lable - Co Lable</td>
              <td class="normalfnt">Lable - Co Lable</td>
			  <td class="normalfntMid">0</td>
              <td class="normalfntMid">789.21</td>			                
              <td class="normalfntRite">4247</td>
              <td class="normalfntMid">0</td>
              <td class="normalfntRite">.2241</td>
              <td class="normalfntRite">0.175</td>
			  <td class="normalfntMid">ACCE</td>
              <td class="normalfntMid">0</td>
              <td class="normalfntMid">LABLE</td>
              </tr>-->
          </table>
        </div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
      <tr>
        <td width="20%" id="unitbox" style="visibility:hidden;width:140px;" height="29"><select name="cboOrderUnit" class="txtbox"  id="cboOrderUnit">
						
                            <?php
	
	$SQL = "select strUnit, strTitle from units Order By strTitle;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strUnit"] ."\">" . $row["strTitle"] ."</option>" ;
	}
	
	?>                                                </select></td>
   		<td width="13%"><a href="nomgatepass.php"><img src="../../images/new.png" alt="new" width="96" height="24"  border="0" /></a></td> 
        <td width="11%"><img src="../../images/save.png" alt="save" width="84" height="24" id="Save" onclick="getIssueNo();" /></td>
        <td width="13%"><img src="../../images/report.png" width="108" height="24" onclick="showReport();" /></td>
        <td width="13%"><img src="../../images/print.png" alt="print" width="115" height="24" onclick="printReport();" /></td>
        <td width="10%"><a href="../../main.php"><img src="../../images/close.png" width="97" height="24" border="0" /></a></td>
        <td width="20%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<div style="left:550px; top:285px; z-index:10; position:absolute; width:240px; visibility:hidden; " id="gotoReport" ><table width="270" height="65" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
            <td width="82" height="27">State </td>
            <td width="186"><select name="select3" class="txtbox" id="cboState" style="width:100px" onchange="LoadPopUpIssueNo();">              
              <option value="1">Confirm</option>             
            </select></td>
            <td width="186">Year</td>
            <td width="186"><select name="select4" class="txtbox" id="cboYear" style="width:55px" onchange="LoadPopUpIssueNo();">
             
			<?php
			//	$SQL = "SELECT DISTINCT intIssueYear FROM issues ORDER BY intIssueYear DESC;";	
				$SQL = " SELECT DISTINCT intRetYear FROM gensupreturnheader ORDER BY intRetYear DESC;";	
				$result = $db->RunQuery($SQL);		
				while($row = mysql_fetch_array($result))
				{
				//echo "<option value=\"". $row["intIssueYear"] ."\">" . $row["intIssueYear"] ."</option>" ;
				echo "<option value=\"". $row["intRetYear"] ."\">" . $row["intRetYear"] ."</option>" ;
				}
			?>
            </select></td>
          </tr>
          <tr>
            <td><div align="center">Return No</div></td>
            <td><select name="select" class="txtbox" id="cboRptIssueNo" style="width:100px" onchange="showReport();">
			<option value="Select One" selected="selected">Select One</option>
            </select>            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
		
		
</div>
</body>

</html>
