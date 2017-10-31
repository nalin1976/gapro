<?php
$backwardseperator = "../../../";
session_start();
// fuel chit genatrate only for confirm jobs. firt time save a fuel chit get the print of original copy after that can get duplicate copies
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Fuel Chit Details</title>
<link rel="stylesheet" type="text/css" href="../../../css/erpstyle.css"/>
<link rel="stylesheet" type="text/css" href="../../../css/tableGrib.css"/>

<script type="text/javascript" src="../../../javascript/jquery.js"></script>
<script type="text/javascript" src="../../../js/jquery-1.2.6.min.js"></script>
<script type="text/javascript" src="../../../js/tablegrid.js"></script>
<script type="text/javascript" src="../../../javascript/script.js" ></script>
<script type="text/javascript" src="fuelChit-js.js"></script>

<!--calender-->
<link rel="stylesheet" type="text/css" href="../../../javascript/calendar/theme.css" />
<script type="text/javascript" src="../../../javascript/calendar/calendar.js" ></script>
<script type="text/javascript" src="../../../javascript/calendar/calendar-en.js" ></script>


<!--time picker  --> 

<!--date picker    -->    
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

    cal.callCloseHandler();
}

function closeHandler(cal) {
  cal.hide();                        // hide the calendar
//  cal.destroy();
  _dynarch_popupCalendar = null;
}

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

  _dynarch_popupCalendar.showAtElement(el.nextSibling, "Br");        // show the calendar

  return false;
}

var MINUTE = 60 * 1000;
var HOUR = 60 * MINUTE;
var DAY = 24 * HOUR;
var WEEK = 7 * DAY;

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

  var cal = new Calendar(0, null, flatSelected);

  cal.weekNumbers = false;

  cal.setDisabledHandler(isDisabled);
  cal.setDateFormat("%A, %B %e");

  cal.create(parent);

  cal.show();
  

}

</script>

<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../../css/tableGrib.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript"  src="../../../js/tablegrid.js"></script>
</head>

<body>

<?php
include "../../../Connector.php";
?>

<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="td_coHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
        <link rel="Stylesheet" media="screen" href="../../../js/Time Picker/ui.css">
        <script type="text/javascript" src="../../../js/Time Picker/jquery.js"></script>
        <script type="text/javascript" src="../../../js/Time Picker/ui_003.js"></script>
        <script type="text/javascript" src="../../../js/Time Picker/jquery_003.js"></script>
        <script type="text/javascript" src="../../../js/Time Picker/jquery_002.js"></script>
        <script type="text/javascript" src="../../../js/Time Picker/ui.js"></script>
        <script type="text/javascript" src="../../../js/Time Picker/ui_002.js"></script>
  
<script type="text/javascript">
          /*  $(function(){
             $('#txtTimeFrom').timepickr({handle: '#trigger-test'});			
			 $('#txtTimeTo').timepickr({handle: '#trigger-test'});
            }); -- dissabled to remove the time picker list down 02/05/2011 */
</script>   
<div>
	<div align="center">
		<div class="trans_layoutD">
		<div class="trans_text">Fuel Chit<span class="volu"></span></div>
        <form name="invoiceForm" id="invoiceForm" method="post" action="">
          <table width="650" align="center" cellspacing="1">
            <tr>
            
           </tr>
          
           
            <tr>
              <td class="normalfnt" width="1">&nbsp;</td>
              <td class="normalfnt" width="80">Job No</td>
              <td><select name="cboJobNo" id="cboJobNo" class="txtbox"  style="width:132px;" onchange="loadTargetKM();">
              <option></option>
              <?php
			  	$sql = "SELECT trip.intJobNo FROM trip ORDER BY trip.intJobNo DESC";
				//WHERE trip.intOutAmtStatus='1'
				$results = $db->RunQuery($sql);
				while($row = mysql_fetch_array($results))
				{
					echo "<option value=\"".$row["intJobNo"]."\">".$row["intJobNo"]."</option>";
			  	}
			  ?>
              
              </select>       </td>
              <td class="normalfnt" width="90">Date</td>
              <td ><input name="txtDate" type="text"  style="width: 130px;" class="txtbox" id="txtDate"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo $date; ?>"  /><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;height:1px !important;"   onclick="return showCalendar(this.id, '%Y-%m-%d');"  /></td>
            </tr>
            <tr>
              <td class="normalfnt" width="1">&nbsp;</td>
              <td class="normalfnt" width="80">Target Km</td>
              <td ><input type="text" id="targetKM" name="targetKM " style="width:130px; "/></td>
              
              <td class="normalfnt" width="90">Actual Km</td>
              <td class="normalfnt" width="132"><input type="text"  disabled="disabled" id="actualKM" name="actualKM" style="width:130px; background-color:#EFEFEF;" class=""/></td>
            </tr>
			<tr>
              <td class="normalfnt" width="1">&nbsp;</td>
              <td class="normalfnt" width="80">Fuel Lt per Km</td>
              <td class="normalfnt" width="132"><input id="fuelLTperKm" name="fuelLTperKm" disabled="disabled" type="text" style="width:130px; background-color:#EFEFEF;"/></td>
           
             
              <td class="normalfnt" width="80">Fuel Lt</td>
              <td class="normalfnt" width="132"><input id="fuelLT" name="fuelLT" disabled="disabled" type="text" style="width:130px; background-color:#EFEFEF;"/></td>
            </tr>
            <tr>
              <td class="normalfnt" width="1">&nbsp;</td>
              <td class="normalfnt" width="80">Start Meter</td>
              <td class="normalfnt" width="132"><input id="startMeter" name="startMeter" type="text" style="width:130px;" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
           
             
              <td class="normalfnt" width="80">End Meter</td>
              <td class="normalfnt" width="132"><input id="endMeter" name="endMeter" type="text" style="width:130px;" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onkeyup="calculateActualKm();"/></td>
            </tr>
            <tr>
              <td class="normalfnt" width="1">&nbsp;</td>
              <td class="normalfnt" width="80">Aditional Lt</td>
              <td class="normalfnt" width="132"><input id="addAmount" name="addAmount" type="text" style="width:130px;"/></td>
              
              <td class="normalfnt" width="80">Reason</td>
              <td class="normalfnt" width="132"><input id="txtReason" name="txtReason" type="text" style="width:130px;" /></td>
			</tr>
            <tr>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">Vehical No</td>
              <td class="normalfnt"><input id="txtVehicalNo" name="txtVehicalNo" type="text" style="width:130px;" disabled="disabled"/></td>
              <td class="normalfnt">Actual Lt</td>
              <td class="normalfnt" width="132"><input id="actualLt" name="actualLt" type="text" style="width:130px;" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
            </tr>
			
            <tr>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">Pump Date</td>
              <td class="normalfnt"><input name="txtPompDate" type="text"  style="width: 130px;" class="txtbox" id="txtPompDate"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo $date; ?>"  /><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;height:1px !important;"   onclick="return showCalendar(this.id, '%Y-%m-%d');"  /></td>
              <td class="normalfnt">Previous Meter </td>
              <td class="normalfnt"><input id="txtPrevoius" name="txtPrevoius" type="text" style="width:130px;" disabled="disabled"/></td>
            </tr>
          </table>
		  
		  <br />
		<table width="600">
			<tr align="center">
            <td width="11%">&nbsp;</td>
				<td width="16%"><img src="../../../images/Tnew.jpg" alt="new" class="mouseover" id="butNew" onClick="ClearForm();"/></td>
				<td width="16%"><img src="../../../images/Tsave.jpg" class="mouseover" id="butSave" onClick="saveFuelChit();"></td>
				<td width="16%"><img src="../../../images/Tcancel.jpg" name="butDelete" class="mouseover" id="butDelete" onClick="deleteInvoice();"></td>
                <td width="16%"><img src="../../../images/Tprint.jpg" class="mouseover" id="butReport" onClick="printFuelChit();"></td>
				<td width="16%"><a href="../../../main.php"><img src="../../../images/Tclose.jpg" id="butClose" border="0"></a></td>
				<td width="9%">&nbsp;</td>
			</tr>
		</table>
        </form>
		</div>
	</div>
</div>

</body>
</html>


