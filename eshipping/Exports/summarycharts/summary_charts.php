<?php
$backwardseperator = "../../";
session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web | Shipment Summaries</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>


<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>
<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>

<script src="exportrelease.js"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />

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


<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><table width="442" border="0" cellspacing="0" >
      <tr>
        <td width="65%" height="30" bgcolor="#498CC2" class="TitleN2white">Shipment Summaries</td>
      </tr>
      <tr >
        <td colspan="2"><form id="frm_er" ><table width="100%" border="0" cellspacing="0" cellpadding="2" class="bcgl1">
          <tr>
            <td class="normalfntRite"></td>
            <td></td>
          </tr>
          
          <tr>
            <td width="30%" align="center" valign="middle" ><table width="100%" border="0" cellspacing="0" cellpadding="3">
              <tr>
                <td width="50%" class="normalfntRite"><input type="checkbox" checked="checked" id="chb_period" onchange="set_period()"/></td>
                <td width="50%" class="normalfntRite">Period : </td>
              </tr>
            </table></td>
            <td width="70%" class="normalfnt"><input name="txtDateFrom" tabindex="10" type="text" class="txtbox" id="txtDateFrom"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%d/%m/%Y');" style="width:100px;"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;width:2px;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /> 
              To 
                <input name="txtDateTo" tabindex="10" type="text" class="txtbox" id="txtDateTo"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%d/%m/%Y');" style="width:100px;"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;width:2px;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
          </tr>
          <tr>
            <td   class="normalfntRite">Country  :</td>
            <td class="normalfnt"><select name="cboCountryList" class="txtbox" id="cboCountryList" style="width:240px" tabindex="4" onchange="getCountryDetails();">
              <?php
	
	$SQL = "SELECT country.strCountryCode, country.strCountry FROM country WHERE (((country.intStatus)=1));";	
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strCountryCode"] ."\">" . $row["strCountry"] ."</option>" ;
	}
	
	?>
            </select></td>
          </tr>
          <tr>
            <td   class="normalfntRite">Destination :</td>
            <td class="normalfnt"><select name="cboDestination"  tabindex="13" class="txtbox" id="cboDestination"style="width:240px">
              <option value=""></option>
              <?php 
                   $sqlCity="SELECT strPortOfLoading,strCityCode, strCity FROM city  order by strCity";
                   $resultCity=$db->RunQuery($sqlCity);
						 while($row=mysql_fetch_array( $resultCity)) 
						 echo "<option value=".$row['strCityCode'].">".$row['strCity']." --> ".$row['strPortOfLoading']."</option>";                 
                   ?>
            </select></td>
          </tr>
          <tr>
            <td   class="normalfntRite">Buyer :</td>
            <td class="normalfnt"><select name="cboConsignee"  class="txtbox" tabindex="6" id="cboConsignee"style="width:240px">
              <option value=""></option>
              <?php 
                   $sqlBuyer="SELECT strBuyerID,strName,strBuyerCode	FROM buyers where intDel=0 ORDER BY strBuyerCode  ";
                   $resultBuyer=$db->RunQuery($sqlBuyer);
						 while($row=mysql_fetch_array( $resultBuyer)) 
						 echo "<option value=".$row['strBuyerID'].">".$row['strBuyerCode']." ---> ".$row['strName']."</option>";                 
                   ?>
            </select></td>
          </tr>
          <tr>
            <td   class="normalfntRite">Exhibit 1 :</td>
            <td class="normalfnt"><select name="cboExhi1" class="txtbox" id="cboExhi1" style="width:240px" tabindex="4" onchange="getCountryDetails();">
             <option value="qty/month" >Quantity Over Month</option>
             <option value="cbm/month" >CBM Over Month</option>
             <option value="amount/month" >Amount Over Month</option>
			 <option value="qty/dest" >Quantity Over Destination</option>
             <option value="cbm/dest" >CBM Over Destination</option>
             <option value="amount/dest" >Amount Over Destination</option>
             <option value="qty/buyer" >Quantity Over Buyer</option>
             <option value="cbm/buyer" >CBM Over Buyer</option>
             <option value="amount/buyer" >Amount Over Buyer</option>
            </select></td>
          </tr>
          <tr>
            <td   class="normalfntRite">Exhibit 2 :</td>
            <td class="normalfnt"><select name="cboExhi2" class="txtbox" id="cboExhi2" style="width:240px" tabindex="4" onchange="getCountryDetails();">
              <option value="qty/month" >Quantity Over Month</option>
             <option value="cbm/month" >CBM Over Month</option>
             <option value="amount/month" >Amount Over Month</option>
			 <option value="qty/dest" >Quantity Over Destination</option>
             <option value="cbm/dest" >CBM Over Destination</option>
             <option value="amount/dest" >Amount Over Destination</option>
             <option value="qty/buyer" >Quantity Over Buyer</option>
             <option value="cbm/buyer" >CBM Over Buyer</option>
             <option value="amount/buyer" >Amount Over Buyer</option>
            </select></td>
          </tr>
          <tr>
            <td   class="normalfntRite">Exhibit 3 :</td>
            <td class="normalfnt"><select name="cboExhi3" class="txtbox" id="cboExhi3" style="width:240px" tabindex="4" onchange="getCountryDetails();">
              <option value="qty/month" >Quantity Over Month</option>
             <option value="cbm/month" >CBM Over Month</option>
             <option value="amount/month" >Amount Over Month</option>
			 <option value="qty/dest" >Quantity Over Destination</option>
             <option value="cbm/dest" >CBM Over Destination</option>
             <option value="amount/dest" >Amount Over Destination</option>
             <option value="qty/buyer" >Quantity Over Buyer</option>
             <option value="cbm/buyer" >CBM Over Buyer</option>
             <option value="amount/buyer" >Amount Over Buyer</option>
            </select></td>
          </tr>
          <tr>
            <td   class="normalfntRite">Exhibit 4 :</td>
            <td class="normalfnt"><select name="cboExhi4" class="txtbox" id="cboExhi4" style="width:240px" tabindex="4" onchange="getCountryDetails();">
              <option value="qty/month" >Quantity Over Month</option>
             <option value="cbm/month" >CBM Over Month</option>
             <option value="amount/month" >Amount Over Month</option>
			 <option value="qty/dest" >Quantity Over Destination</option>
             <option value="cbm/dest" >CBM Over Destination</option>
             <option value="amount/dest" >Amount Over Destination</option>
             <option value="qty/buyer" >Quantity Over Buyer</option>
             <option value="cbm/buyer" >CBM Over Buyer</option>
             <option value="amount/buyer" >Amount Over Buyer</option>
            </select></td>
          </tr>
          <tr>
            <td class="normalfntRite"></td>
            <td></td>
          </tr>
        </table></form></td>
      </tr>
      <tr>
        <td height="34" colspan="2" bgcolor="#D6E7F5"><table width="100%" border="0">
          <tr>
            <td width="193" >&nbsp;</td>
            <td width="108"><img src="../../images/report.png" id="btnNew" class="mouseover" name="btnReport" tabindex="29" onclick="show_report()"/></td>
            <td width="183" id="Report_cell">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="20" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
 
</table>
</body>
<script type="text/javascript">
	function show_report()
	{
		var frmDate=$('#txtDateFrom').val();
		var toDate=$('#txtDateTo').val();
		var country=$('#cboCountryList').val();
		var destination=$('#cboDestination').val();
		var buyer=$('#cboConsignee').val();
		var Exhi1=$('#cboExhi1').val();
		var Exhi2=$('#cboExhi2').val();
		var Exhi3=$('#cboExhi3').val();
		var Exhi4=$('#cboExhi4').val();
		window.open("fusionchart/test.php?frmDate="+frmDate+'&toDate='+toDate+'&country='+country
		+'&destination='+destination+'&buyer='+buyer+'&Exhi1='+Exhi1+'&Exhi2='+Exhi2+'&Exhi3='+Exhi3+'&Exhi4='+Exhi4,"chart")
	}	
</script>
</html>