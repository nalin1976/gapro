<?php
$backwardseperator = "../";
include '../Connector.php' ;
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shipping Data</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="../javascript/autofill.js" type="text/javascript"></script>
<script src="shipping.js"></script>
<script  language="javascript" type="text/javascript">

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

<form id="frmShippingdata" name="frmShippingdata" method="post" action="">
  <tr>
    <td><?php include "{$backwardseperator}Header.php";?></td>
  </tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF" >

  <tr>
    <td><table width="100%" border="0" align="center">
      <tr>
        <td width="86%"><table width="100%" border="0" class="tableBorder">
          <tr>
            <td height="25" align="center" bgcolor="#660000" class="mainHeading">Shipping Data</td>
          </tr>
          <tr>
            <td height="50" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="1%">&nbsp;</td>
                <td width="10%" class="normalfnt">Style No </td>
                <td width="21%"><select name="cboStyle" class="txtbox" id="cboStyle" onchange="LoadOrderNo(this.value);" style="width:160px">
                    <?php
	$SQL="SELECT distinct  strStyle FROM orders where intStatus not in(13,14) order by strStyle;";		
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
	}		  
			  
				  ?>
                </select></td>
                <td width="1%">&nbsp;</td>
                <td width="12%" class="normalfnt">Order No </td>
                <td width="18%"><select name="cboSearch" class="txtbox" id="cboSearch" onchange="SetSCNo(this);loadDetails(this);" style="width:160px">
                    <?php
	$SQL="SELECT  intStyleId,strOrderNo FROM orders where intStatus not in(13,14) order by strOrderNo";		
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}		  
			  
				  ?>
                </select></td>
                <td width="1%">&nbsp;</td>
                <td width="11%" class="normalfnt">SC No </td>
                <td width="25%"><select name="cboSCNo" class="txtbox" id="cboSCNo" onchange="SetOrderNo(this);loadDetails(this);" style="width:160px">
                    <?php
	$SQL="SELECT  S.intStyleId,S.intSRNO FROM orders O inner join specification S on S.intStyleId=O.intStyleId where O.intStatus not in(13,14) order by s.intSRNO desc";		
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}		  
			  
				  ?>
                </select></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="96"><table width="100%" border="0" class="tableBorder">
              
              <tr>
                <td width="1%" rowspan="10" class="normalfnt">&nbsp;</td>
                <td width="10%" height="11" class="normalfnt">Pcs Per Pack</td>
                <td width="22%"><input name="txtPcsPerpack" type="text" class="txtbox" id="txtPcsPerpack" style="width:158px;text-align:right" maxlength="4" onkeypress="return IsNumberWithoutDecimals(this.value,event);"/></td>
                <td width="12%" class="normalfnt">Buyer PO No</td>
                <td width="18%" ><input name="txtBuyerPoNo" type="text" class="txtbox" id="txtBuyerPoNo" style ="width:158px" maxlength="30"/></td>
                <td width="11%" >&nbsp;</td>
                <td width="26%" >&nbsp;</td>
              </tr>
              <tr>
                <td class="normalfnt">Material</td>
                <td width="22%"><input name="txtMaterial" type="text" class="txtbox" id="txtMaterial" style="width:158px" maxlength="30"/></td>
                <td class="normalfnt" nowrap="nowrap">Buyer</td>
                <td colspan="3"  ><input name="txtBuyers" type="text" class="txtbox" id="txtBuyers" style="width:30px" maxlength="30"/>
                  <input name="txtBuyer" type="text" class="txtbox" id="txtBuyer" style="width:404px" maxlength="30"/></td>
                </tr>
              <tr>
                <td class="normalfnt" nowrap="nowrap">Dimension</td>
                <td><input name="textDimension" type="text"  class="textbox" id="textDimension" style="width:158px" maxlength="10" /></td>
                <td class="normalfnt" nowrap="nowrap"> Payment Term</td>
                <td><select name="cboPaymentTerm" class="txtbox" id="cboPaymentTerm" style="width:158px">
                    <?php
	$SQL="select strPayTermId,strDescription from popaymentterms where intStatus  = 1 order by strDescription";		
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strPayTermId"] ."\">" . $row["strDescription"] ."</option>" ;
	}		  
			  
				  ?>
                </select></td>
                <td><span class="normalfnt">Shipment Term</span></td>
                <td><select name="cboShipmentTerm" class="txtbox" id="cboShipmentTerm" style="width:158px">
                  <?php
	$SQL="SELECT strShipmentTermId,strShipmentTerm FROM shipmentterms where intStatus=1  order by strShipmentTermId ASC";		
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		
	while($row = mysql_fetch_array($result))
	{								   
		echo "<option value=\"". $row["strShipmentTermId"] ."\">" . $row["strShipmentTerm"] ."</option>" ;
	}		  
			  
				  ?>
                </select></td>
              </tr>
              <tr>
                <td class="normalfnt">Wash Code</td>
                <td><input name="textWashCode" type="text"  class="textbox" id="textWashCode" style="width:158px" maxlength="30" /></td>
                <td class="normalfnt">Garment Type </td>
                <td><input name="txtGarmentType " type="text" class="txtbox" id="txtGarmentType" style="width:158px"maxlength="30"/></td>
                <td class="normalfnt">Quota Cat </td>
                <td><input name="txtQuataCat" type="text" class="txtbox" id="txtQuataCat" style="width:158px" maxlength="30"/></td>
              </tr>
              <tr>
                <td class="normalfnt">Qty</td>
                <td><input name="textQty" type="text"  class="textbox" id="textQty" style="width:158px;text-align:right" maxlength="10" onkeypress="return IsNumberWithoutDecimals(this.value,event);"/></td>
                <td class="normalfnt" nowrap="nowrap">Fabric Content</td>
                <td colspan="3"><input name="textFabricContent" type="text"  class="textbox" id="textFabricContent"style="width:440px" maxlength="100" /></td>
                </tr>
              <tr>
                <td class="normalfnt">Vessal</td>
                <td><input name="textVessal" type="text"  class="textbox" id="textVessal" style="width:158px" maxlength="50" /></td>
                <td class="normalfnt">Description</td>
                <td colspan="3"><input name="textDescription" type="text"  class="textbox" id="textDescription" style="width:440px" maxlength="10" /></td>
                </tr>
              <tr>
                <td class="normalfnt">Vessal Date</td>
                <td><input name="textVessalData" type="text"  class="txtbox" id="textVessalData" style="width:158px" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" /><input type="txtbox" value=""  class="txtbox" style="visibility:hidden;width:5px"   onclick="return showCalendar(this.id, '%d/%m/%Y');"></td>
                <td class="normalfnt">Mill</td>
                <td colspan="3"><select name="cboMill" class="txtbox" id="cboMill" onchange="" style="width:158px">
                  <?php
	$SQL="SELECT strSupplierID, strTitle FROM suppliers where intApproved=1  order by strTitle;";		
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
	}		  
			  
				  ?>
                </select></td>
                </tr>
              <tr>
                <td class="normalfnt">Mode</td>
                <td><select name="cboMode" class="txtbox" id="cboMode" onchange="" style="width:160px">
                  <?php
	$SQL="SELECT intShipmentModeId, strDescription FROM shipmentmode WHERE intStatus not in(13,14) order by strDescription ASC";		
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intShipmentModeId"] ."\">" . $row["strDescription"] ."</option>" ;
	}		  
			  
				  ?>
                </select></td>
                <td><span class="normalfnt">Carton Type</span></td>
                <td><span class="normalfnt">
                  <input name="textCtnType" type="text"  class="textbox" id="textCtnType" style="width:158px" maxlength="50" />
                </span></td>
                <td colspan="2"><table>
                  <tr>
                    <td><input type="radio" id="orderData_rdctntype" name="orderData_rdctntype" /></td>
                    <td class="normalfnt">Bottom</td>
                    <td><input type="radio"id="orderData_rdctntype" name="orderData_rdctntype" /></td>
                    <td class="normalfnt">Top</td>
                  </tr>
                </table></td>
                </tr>
              <tr>
                <td class="normalfnt">Gender</td>
                <td><span class="normalfnt">
                  <select name="cboGender" class="txtbox" id="cboGender" onchange="" style="width:160px">
                    <?php
	$SQL="SELECT  intGenderId,strGenderCode FROM gender ORDER BY strDescription";		
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intGenderId"] ."\">" . $row["strGenderCode"] ."</option>" ;
	}		  
			  
				  ?>
                  </select>
                </span></td>
                <td class="normalfnt">Destination</td>
                <td><span class="normalfnt"><img src="../images/add.png" alt="add" onclick="LoadDestination();"/></span></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="normalfnt">Fabric Ref No</td>
                <td><input name="textFabricRefNo" type="text"  class="textbox" id="textFabricRefNo" style="width:158px" maxlength="30" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>  
              </tr>
              	

			  
            </table></td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0"class="tableFooter">
              <tr>                
                      <td align="center"><img src="../images/new.png" alt="New" name="New" width="96" height="24" onclick="ClearForm();" class="mouseover" style="display:inline"/>
                      <img src="../images/save.png" alt="Save" name="Save" width="84" height="24" onclick="SaveShipingData();" class="mouseover" style="display:inline"/>
                      <img src="../images/delete.png" alt="Delete" name="Delete" width="100" height="24" onclick="ConfirmDelete()" class="mouseover" style="display:none" id="butDelete"/>
                    	<img src="../images/report.png" alt="Report" width="108" height="24" border="0" class="mouseover" onclick="ViewShippingdataReport();" style="display:inline"/>
                       <a href="../main.php"><img src="../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close" style="display:inline"/></a></td> 					  	  
              </tr>
            </table></td>
          </tr>
        </table></td>
       </tr>
      
    </table></td>
  </tr>
  </tr>
</table>
</form>
</body>
</html>
