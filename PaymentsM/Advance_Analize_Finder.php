<?php
	session_start();
	
	include "../Connector.php";
$backwardseperator = "../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro:Advance Payments Finder</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="calendar.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<style type="text/css">
<!--
body {
	background-color: #FFF;
}
-->
</style>

<style type="text/css">
<!--
#tblSample td, th { padding: 0.5em; }
.classy0 { background-color: #234567; color: #89abcd; }
.classy1 { background-color: #89abcd; color: #234567; }
-->
</style>
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="../javascript/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.fixedheader.js"></script>

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
<script src="advancePayment/advancePaymentList.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>


<body onload="setDefaultDateofFinder()">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="tdHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom_center">
	<div class="main_top">
		<div class="main_text">Advance Payment Finder<span class="vol"></span><span id="advancePayments_popup_close_button"></span></div>
	</div>
	<div class="main_body">
<form id="form1" name="form1" method="post" action="">
  <table width="950" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td colspan="8"><table bordercolor="#162350" width="100%" border="0">
        <tr>
          <td width="2%">&nbsp;</td>
          <td width="111"><table cellspacing="0" cellpadding="0">
				  <tr>
                    <td width="96" class="normalfnt">Payment Type</td>
				    </tr>
				  </table>				</td>
				<td width="157"  > <?php 
			  $type = $_POST["cboPaymentType"];
			  $checked	= "selected=\"selected\""; 
		  ?>
		  <select name="cboPaymentType" id="cboPaymentType" onchange="pageRefreshListing();">
		  	<option value="S" id="style" <?php if($type=="S"){ echo $checked;} ?>>Style</option>
			<option value="G" id="Genaral"<?php if($type=="G"){ echo $checked;} ?>>General</option>
			<option value="B" id="Bulk"<?php if($type=="B"){ echo $checked;} ?>>Bulk</option>
			<!--<option value="W" <?php if($type=="W"){ echo $checked;} ?>>Wash</option>-->
		  </select></td>
          
       
				
<td width="7%" class="normalfnt">Supplier</td>
		  <td width="27%"><select name="cboSuppliers" class="txtbox" id="cboSuppliers" style="width:200px" >
            <option value="0"></option>
            <?php
		       
			   $type = $_POST["cboPaymentType"];
			   if($type == ''){
				$type = 'S';   
			   }
		       if($type =='S')
			   {
						$checkedS	= "checked=\"checked\"";
					
					     
				$strSQL="SELECT distinct
							suppliers.strSupplierID,
							suppliers.strTitle as strSupName
							FROM
							purchaseorderheader
							Inner Join suppliers ON purchaseorderheader.strSupplierID = suppliers.strSupplierID
							WHERE suppliers.intStatus=1
							ORDER BY
							suppliers.strTitle ASC";
				
				}
				
				else if($type =='B')
				{
						$checkedB	= "checked=\"checked\"";
						$strSQL="SELECT distinct
								suppliers.strSupplierID,
								suppliers.strTitle as strSupName
								FROM
								bulkpurchaseorderheader
								Inner Join suppliers ON bulkpurchaseorderheader
								.strSupplierID = suppliers.strSupplierID
								WHERE suppliers.intStatus=1
								ORDER BY
								suppliers.strTitle ASC";
				}
				else if($type =='G')
				{
							$checkedG	= "checked=\"checked\"";
							$strSQL="SELECT distinct
							suppliers.strSupplierID,
							suppliers.strTitle as strSupName
							FROM
							generalpurchaseorderheader 
							Inner Join suppliers ON generalpurchaseorderheader.intSupplierID = suppliers.strSupplierID
							WHERE suppliers.intStatus=1
							ORDER BY
							suppliers.strTitle ASC";

				}
				$result = $db->RunQuery($strSQL);
				//echo "<option value=\"". "0" ."\">" . "" ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strSupName"] ."</option>" ;
				}
			
			?>
          </select></td>
		  <td width="28" class="normalfnt"><input type="checkbox" onclick="edDate(this);" name="chk" id="chk" /></td>
				<td width="69" class="normalfnt">Date From </td>
				<td width="103" class="normalfnt"><input name="txtDateFrom" type="text" class="txtbox" id="txtDateFrom" size="10" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');" disabled="disabled"/><input name="reseta" type="text"  class="txtbox" style="visibility:hidden; width:2px;" onclick="return showCalendar(this.id, '%Y/%m/%d');" value="" /></td>
				<td width="60" class="normalfnt">Date To </td>
				<td width="100" class="normalfnt"><input name="txtDateTo" type="text" class="txtbox" id="txtDateTo" size="10" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');" disabled="disabled"/><input name="reset2" type="text"  class="txtbox" style="visibility:hidden; width:2px;"   onclick="return showCalendar(this.id, '%Y/%m/%d');" value="" /></td>
        </tr>
        <tr>
          <td colspan="10"><table width="100%" border="0">
            <tr>
			<td width="15">&nbsp;</td>
             <td id="" width="62"><span class="normalfnt">Currency</span></td>
             <td  width="216"><select name="cboCurrencyTo" class="txtbox" id="cboCurrencyTo" style="width:150px" onchange="loadcurrency()">
               <?php
			$strSQL="SELECT strCurrency,intCurID FROM currencytypes WHERE intStatus=1";
			$result = $db->RunQuery($strSQL);
			
			echo "<option value=\"". "0" ."\">" . "" ."</option>" ;
			while($row = mysql_fetch_array($result))
			{
				echo "<option value=\"". $row["intCurID"] ."\">" . $row["strCurrency"] ."</option>" ;
			}
		?>
             </select></td>
             <td>		
		<input name="txtcurrency" style="text-align:center " width="90px" type="hidden" value="0" class="txtbox" id="txtcurrency" /></td>
             <td width="24">&nbsp;</td>
              <td width="396"><table width="100%" border="0">
                <tr>
                  
				  
                  <td width="39%">&nbsp;</td>
                  <td width="34%">&nbsp;</td>
                  <td width="27%" align="right"><span class="normalfnt"><img src="../images/search.png" alt="go" width="97" height="26"  class="mouseover" onclick="showAnalizeData();" /></span></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
          </tr>
        <tr>
          <td colspan="10">
		  <div class="bcgl1" id="divAdvData"  style="width:945px;height:345px ; background:#FFFFFF">
		    <table id="tblAdvData" width="945" border="0" cellpadding="0" cellspacing="1" bordercolor="#162350" bgcolor="#CCCCFF" >
              <tr>
             
                <td width="22%" height="25" bgcolor="" class="grid_header">Supplier</td>
                <td width="8%" bgcolor="" class="grid_header" >PO No</td>
                <td width="10%" bgcolor="" class="grid_header">Payment No </td>
                <td width="9%" bgcolor="" class="grid_header">Date </td>
                <td width="7%" bgcolor="" class="grid_header">Currency</td>
                <td width="11%" bgcolor="" class="grid_header">Advance Amount</td>
                <td width="8%" bgcolor="" class="grid_header">GRN Value</td>
                <td width="13%" bgcolor="" class="grid_header">To be Received Value</td>
                <td width="12%" bgcolor="" class="grid_header">Advance Settled</td>
              </tr>
            </table>
		  </div>		  </td>
        </tr>
      </table></td>
    </tr>
	<tr></tr>
	<tr>
		<td colspan="17">
		  <div class="bcgl1" id="divAdvData">
		    <table id="footTotal" width="950" border="0" cellpadding="0" cellspacing="1" bordercolor="#162350">
              <tr>
			  <td width="56%" height="25" bgcolor="" class="grid_header">Total</td>
                <td width="12%" bgcolor="" class="grid_header">&nbsp;</td>
                <td width="8%" bgcolor="" class="grid_header">&nbsp;</td>
                <td width="11%" bgcolor="" class="grid_header">&nbsp;</td>
                <td width="13%" bgcolor="" class="grid_header">&nbsp;</td>
			  </tr></table></div>				</td>	
	</tr>
		<tr>&nbsp;</tr>
		<tr>
		<td width="116" class="normalfnt">&nbsp;</td>
	    <td width="73" class="normalfnt">&nbsp;</td>
	    <td width="91" class="normalfnt">&nbsp;</td>
	    <td width="135" class="normalfnt"><span class="normalfnt" style="text-align:center; visibility:hidden"><img src="../images/report.png" alt="go"  class="mouseover" onclick="" /></span></td>
	    <td width="176" class="normalfnt"><a href="../main.php"><img src="../images/close.png"  border="0" /></a></td>
	    <td width="116" class="normalfnt">&nbsp;</td>
		<td width="116" class="normalfnt">&nbsp;</td>
		<td width="101" class="normalfnt">&nbsp;</td>
		</tr>
  </table>
</form>
</div>
</div>
</body>
</html>
