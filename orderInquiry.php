<?php
 session_start();
 include "authentication.inc";
 $backwardseperator='';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Order Inquiry</title>

<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="javascript/jquery.js" type="text/javascript"></script>
<script src="javascript/jquery-ui.js"></script>
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
<link rel="stylesheet" type="text/css" href="javascript/calendar/theme.css" />
<script type="text/javascript">
var factoryID = <?php

 echo $_SESSION["CompanyID"]; 
 ?>;
var UserID = <?php
 echo $_SESSION["UserID"]; 
 ?>;
var EscPercentage = 0.25;
 
var serverDate = new Date();
serverDate.setYear(parseInt(<?php
echo date("Y"); 
?>));
serverDate.setMonth(parseInt(<?php
echo date("m"); 
?>,10)-1);
serverDate.setDate(parseInt(<?php
echo date("d")+1; 
?>,10));

var buyerPOQty = 0;


</script>
<script src="javascript/script.js" type="text/javascript"></script>
<script src="javascript/preorder.js" type="text/javascript"></script>
<script src="javascript/orderInquiry.js" type="text/javascript"></script>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>

<body >
<?php
	
	include "Connector.php";

	$xml = simplexml_load_file('config.xml');
	$SMVEnabled = $xml->PreOrder->SMVEnabled;

	?>
<tr>
	<td height="6" colspan="2"><?php  include $backwardseperator.'Header.php'; ?></td>
</tr>
<form id="frm_main" name="frm_main" method="post" action="">
  <table width="950" align="center" cellpadding="1" cellspacing="1" class="bcgl1" id="body">
    <tr>
      <td height="75" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><table width="100%" height="44" border="0" cellpadding="0" cellspacing="0">

              <tr>
                <td width="92%" height="7"><span class="normalfnt">Merchandising/Order Inquiry</span></td>
                <td width="8%" rowspan="2"><a href="#"></a></td>
              </tr>
              <tr>
                <td height="18"><span class="head1"><img src="images/butt_1.png" width="15" height="15" /> Order Inquiry</span></td>
                </tr>
            </table>              </td>
          </tr>
          <tr>
            <td><table width="950">
                <tr>
                  <td><table width="950">
                      <tr>
                        <td width="29" class="normalfnt">&nbsp;</td>
                        <td width="70" class="normalfnt">Buyer</td>
                        <td width="237"><select name="cboBuyerFind" class="txtbox" id="cboBuyerFind" style="width:175px" onchange="LoadStyleCustomer();loadBuyerwiseOrderNo();">
                          <option value="" selected="selected">Select One</option>
                          <?php
	
	$SQL = "SELECT intBuyerID, strName FROM buyers where intStatus=1 order by strName;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
	}
	
	?>
            </select>                        </td>
                        <td width="70" class="normalfnt">Style No</td>
                        <td width="167"><!--<select name="cboStyleNoFind" class="txtbox" id="cboStyleNoFind" style="width:150px" onchange="setValuetoStyleBox();changeOrderNo();">-->
                        <select name="cboStyleNoFind" class="txtbox" id="cboStyleNoFind" style="width:150px" onchange="changeOrderNo();">
			<option value="" selected="selected">Select One</option>
                          <?php
	
	$SQL = "SELECT distinct strStyle FROM orders where intStatus='2' order by strStyle;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
	}
	
	?>
            </select>                        </td>
                        <td width="96" class="normalfnt">Order No</td>
                             
                        <td width="249"><!--<select name="cboOrderNo" class="txtbox" id="cboOrderNo" style="width:150px" onchange="changeStyleNo();setValuetoStyleBox();">-->
                        <select name="cboOrderNo" class="txtbox" id="cboOrderNo" style="width:150px" onchange="setValuetoStyleBox();">
			<option value="" selected="selected">Select One</option>
                          <?php
	
	$SQL = "SELECT  intStyleId,strOrderNo FROM orders where intStatus='2' order by strOrderNo";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	?>
            </select>          </td>
                      </tr>
                      <tr height="5">
                        <td class="normalfnt"></td>
                        <td ></td>
                        <td></td>
                        <td class="normalfnt"></td>
                        <td colspan="3"></td>
                      </tr>                      
                  </table> 
				  
<div style="left:420px; top:145px; z-index:10; position:absolute; width: 228px; visibility:hidden;" id="FindStyle">
<table width="250" height="58" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
            <td width="82"><div align="center">Buyer</div></td>
            <td width="242"><select name="select2" class="txtbox" id="cboBuyerFind" style="width:180px" onchange="LoadStyleCustomer();">
                          <option value="" selected="selected">Select One</option>
                          <?php
	
	$SQL = "SELECT intBuyerID, strName FROM buyers where intStatus=1 order by strName;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
	}
	
	?>
            </select></td>
          </tr>
          <tr>
            <td><div align="center">Style No </div></td>
            <td><select name="select" class="txtbox" id="cboStyleNoFind" style="width:100px" onchange="setValuetoStyleBox();">
			<option value="Select One" selected="selected">Select One</option>
            </select>            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>  </div>
				  
				  </td>
                </tr>
               
               <!-- <tr bgcolor="#FFFFFF" style="visibility:hidden" id="trNoOfLines">
                  <td><table width="100%" align="center">
                      <tr>
                        <td width="137" height="5" ></td>
                        <td width="318"></td>
                        <td width="153" ></td>
                        <td width="109"></td>
                        <td width="89" style="visibility:hidden">&nbsp;</td>
                        <td width="102" style="visibility:hidden" height="5">&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>-->
            </table></td>
          </tr>
          <tr>
            <td><table width="950" class="bcgl1">
                <tr>
                  <td><table width="950">
                      <tr>
                        <td width="29" class="normalfnt">&nbsp;</td>
                        <td width="106" class="normalfnt">&nbsp;</td>
                        <td width="194" class="normalfnt">&nbsp;</td>
                        <td width="93" class="normalfnt">&nbsp;</td>
                        <td width="128" class="normalfnt">&nbsp;</td>
                        <td width="372" class="normalfnt">&nbsp;</td>
                      </tr>
                      <tr>
                        <td class="normalfnt">&nbsp;</td>
                        <td class="normalfnt">Style No <span class="compulsoryRed">*</span></td>
                        <td colspan="2"><input name="txtStyleNo" type="text" class="txtbox" id="txtStyleNo" style="width:203px" maxlength="26"/> <input name="txtRepeatNo" type="text" class="txtbox" id="txtRepeatNo" style="width:38px" maxlength="3" /></td>
                        <td class="normalfnt">Order No. <span class="compulsoryRed">*</span>  </td>
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="99"><input name="txtPoNo" type="text" class="txtbox" id="txtPoNo" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();"  maxlength="35" value="<?php
	
	$SQL = "SELECT reaFactroyCostPerMin FROM companies where intCompanyID=" . $_SESSION["CompanyID"]  . ";";
	
	$result = $db->RunQuery($SQL);

	while($row = mysql_fetch_array($result))
	{
	//hem(6/9/2010)	echo $row["reaFactroyCostPerMin"]  ;
	}
	
	?>"  style="text-align:right; width:95px;" /></td>
                            <td width="85" class="normalfnt">Order Date <span class="compulsoryRed">*</span> </td>
                            <td width="113" class="normalfnt"><input name="adviceDate" type="text" class="txtbox" id="adviceDate" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" style="width:86px" value="<?php echo date("d/m/Y")?>"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;width:15px"   onclick="return showCalendar(this.id, '%d/%m/%Y');" /></td>
                            <td width="75"><select name="cboOrderType" id="cboOrderType" style="width:75px;">
                        <?php 
					   $sql = " select intTypeId,strTypeName from orders_ordertype where intStatus=1  ";
					  $result = $db->RunQuery($sql); 
					  while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"". $row["intTypeId"] ."\">" . trim($row["strTypeName"]) ."</option>"; 
						} 
					   ?>
                        </select></td>
                            </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td class="normalfnt">&nbsp;</td>
                        <td class="normalfnt">Style Name <span class="compulsoryRed">*</span></td>
                        <td colspan="2"><input name="txtStyleName" type="text" class="txtbox" id="txtStyleName" style="width:248px" maxlength="100" /></td>
                        <td class="normalfnt">Original Order Qty <span class="compulsoryRed">*</span> </td>
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="106"><input name="txtQTY" type="text" class="txtbox" id="txtQTY"   onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();"  onkeypress="return isValidZipCode(this.value,event);" value="" style="text-align:right;width:95px"  maxlength="9" /></td>
                              <td width="77" class="normalfnt">Color</td>
                              <td width="189"><select name="cboColor" id="cboColor" style="width:87px;">
                              <?php 
							$sqlColor = "select distinct strColor from colors where intStatus=1 ";
							
							$resColor =$db->RunQuery($sqlColor); 
							echo "<option value=\"". "" ."\">" . "Select One" ."</option>" ;
							while($row=mysql_fetch_array($resColor))
							{
								echo "<option value=\"". $row["strColor"] ."\">" . $row["strColor"] ."</option>" ;
							}
						?>
                              </select>
                              </td>
                            </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td class="normalfnt">&nbsp;</td>
                        <td class="normalfnt">Buyer  <span class="compulsoryRed">*</span></td>
                        <td colspan="2"><select name="cboCustomer" class="txtbox" onchange="getGetDivisions();GetBuyingOffices();" style="width:250px" id="cboCustomer">
                          <option value="" selected="selected">Select One</option>
                          <?php
	
	$SQL = "SELECT intBuyerID, strName FROM buyers where intStatus=1 order by strName;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
	}
	
	?>
                        </select>
                        <img src="images/add.png" alt="ok" width="16" height="16" align="top" onclick="OpenBuyerPopUp();"/></td>
                        <td class="normalfnt">Season</td>
                        <td><select name="dboSeason" class="txtbox" style="width:275px"  id="dboSeason">
                         
                          <?php
	
	$SQL = "SELECT intSeasonId, strSeason FROM seasons  where intStatus=1 order by strSeason;";
	
	$result = $db->RunQuery($SQL);
		echo "<option value=\"". "Null" ."\">" . "Select One" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intSeasonId"] ."\">" . $row["strSeason"] ."</option>" ;
	}
	
	?>
                        </select>
                        <img src="images/add.png" alt="ok" width="16" height="16" align="top" onclick="OpenSeasonPopUp();"/></td>
                      </tr>
                      <tr height="5">
                        <td class="normalfnt"></td>
                        <td ></td>
                        <td colspan="2"></td>
                        <td class="normalfnt"></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td class="normalfnt">&nbsp;</td>
                        <td class="normalfnt">Buying Office</td>
                        <td colspan="2"><select name="cboBuyingOffice" class="txtbox" style="width:250px"  id="cboBuyingOffice">
                        </select></td>
                        <td class="normalfnt">Color Code </td>
                        <td><input name="txtColorCode" type="text" class="txtbox" id="txtColorCode" style="width:272px" maxlength="30" /></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td class="normalfnt">Division<span class="compulsoryRed">*</span></td>
                        <td colspan="2"><select name="dboDivision" class="txtbox" style="width:250px"  id="dboDivision">
                        </select></td>
                        <td class="normalfnt">Dimension</td>
                        <td><input name="txtDimention" type="text" class="txtbox" id="txtDimention" style="width:272px" maxlength="30"   onkeypress="return checkForTextNumber(this.value,event);" /><input type="hidden" name="txtUser" id="txtUser" value="<?php echo $_SESSION["UserID"] ?>" /></td>
                      </tr>
                      <tr>
                        <td class="normalfnt">&nbsp;</td>
                        <td class="normalfnt">Ref. No.</td>
                        <td colspan="2"><input name="txtRefNo" type="text" class="txtbox" style="width:248px" id="txtRefNo" maxlength="30" /></td>
                        <td class="normalfnt">Mill</td>
                        <td><select name="cboMill" class="txtbox" style="width:275px"  id="cboMill" onchange="GetFabricRefNo(this.value);">
                          <option value="Null" selected="selected">Select One</option>
                          <?php
	
	$SQL = "SELECT strSupplierID, strTitle FROM suppliers where intApproved=1  order by strTitle;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
	}
	
	?>
                        </select></td>
                      </tr>
<tr>
                        <td class="normalfnt">&nbsp;</td>
                        <td class="normalfnt">Fabric Ref No. </td>
                        <td colspan="2"><input name="txtFabRefNo" type="text" class="txtbox" style="width:248px" id="txtFabRefNo" maxlength="30" /></td>
                        <td class="normalfnt">Fabrication</td>
                        <td><input name="txtFabrication" type="text" class="txtbox" style="width:272px" id="txtFabrication" maxlength="100" /></td>
                      </tr>                      
                  </table> 
				  
<div style="left:420px; top:145px; z-index:10; position:absolute; width: 228px; visibility:hidden;" id="FindStyle">
<table width="250" height="58" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
            <td width="82"><div align="center">Buyer</div></td>
            <td width="242"><select name="cboBuyerFind" class="txtbox" id="cboBuyerFind" style="width:180px" onchange="LoadStyleCustomer();">
                          <option value="" selected="selected">Select One</option>
                          <?php
	
	$SQL = "SELECT intBuyerID, strName FROM buyers where intStatus=1 order by strName;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
	}
	
	?>
            </select></td>
          </tr>
          <tr>
            <td><div align="center">Style No </div></td>
            <td><select name="cboStyleNoFind" class="txtbox" id="cboStyleNoFind" style="width:100px" onchange="setValuetoStyleBox();">
			<option value="Select One" selected="selected">Select One</option>
            </select>            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>  </div>
				  
				  </td>
                </tr>
               
               <!-- <tr bgcolor="#FFFFFF" style="visibility:hidden" id="trNoOfLines">
                  <td><table width="100%" align="center">
                      <tr>
                        <td width="137" height="5" ></td>
                        <td width="318"></td>
                        <td width="153" ></td>
                        <td width="109"></td>
                        <td width="89" style="visibility:hidden">&nbsp;</td>
                        <td width="102" style="visibility:hidden" height="5">&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>-->
            </table></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td bgcolor="#FFD5AA"><table width="100%" align="right">
          <tr>
            <td width="284">&nbsp;</td>
            <td width="96"><img src="images/new.png" alt="new" width="96" height="24" onclick="ClearInquiryForm();"/></td>
            <td width="95"><a href="#"><img src="images/save.png" alt="save" width="95" height="24" border="0" onclick="SaveNewOrderInquiry();" /></a></td>
            <td width="360"><a href="main.php"><img src="images/close.png" alt="" width="97" height="24" border="0" /></a></td>
          </tr>
      </table></td>
    </tr>
    
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>
