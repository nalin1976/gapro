<?php
$backwardseperator = "../../../";
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shipping Data</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css"/>

<script src="../../../javascript/script.js"></script>
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
<?php
include('../../../Connector.php');
?>
<form id="frmShippingdata" name="frmShippingdata" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include "{$backwardseperator}Header.php";?></td>
  </tr>
  <tr>
    <td><table width="950" border="0" align="center">
      <tr>
        <td width="1%">&nbsp;</td>
        <td width="86%"><table width="100%" border="0" class="tableBorder">
          <tr>
            <td height="35" align="center" bgcolor="#660000" class="mainHeading">Shipping Data</td>
          </tr>
          <tr>
            <td height="96"><table width="120%" border="0">
              <tr>
                <td colspan="3" class="normalfnt">&nbsp;</td>
                <td colspan="4">&nbsp;</td>
              </tr>
              <tr>
                <td width="0%" rowspan="13" class="normalfnt">&nbsp;</td>
                <td width="7%" height="11" class="normalfnt">Order No</td>
                <td width="23%"><select name="cboSearch" class="txtbox" id="cboSearch" onchange="loadDetails(this);" style="width:160px">
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
                <td width="11%" class="normalfnt"> Buyer </td>
                <td colspan="3" ><input name="txtBuyers" type="text" class="txtbox" id="txtBuyers" style="width:30px" maxlength="30"/>
                    <input name="txtBuyer" type="text" class="txtbox" id="txtBuyer" style="width:449px" maxlength="30"/></td>
              </tr>
              <tr>
                <td class="normalfnt">Style ID<span class="compulsoryRed"></span></td>
                <td width="23%"><select name="cboStyle" class="txtbox" id="cboStyle" onchange="" style="width:160px">
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
                <td class="normalfnt" nowrap="nowrap"> Buyer Po No</td>
                <td width="20%"  ><input name="txtBuyerPoNo" type="text" class="txtbox" id="txtBuyerPoNo" style ="width:220px" maxlength="30"/></td>
                <td width="8%"class="normalfnt" nowrap="nowrap"> Shipment Term</td>
                <td width="31%" ><select name="cboShipmentTerm" class="txtbox" id="cboShipmentTerm" style="width:170px">
                    <?php
	$SQL="SELECT strShipmentTermId,strShipmentTerm FROM shipmentterms  order by strShipmentTermId ASC";		
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
                <td class="normalfnt" nowrap="nowrap">Pcs Per Pack</td>
                <td><input name="txtPcsPerpack" type="text" class="txtbox" id="txtPcsPerpack" style="width:158px" maxlength="4"/></td>
                <td class="normalfnt" nowrap="nowrap"> Payment Term</td>
                <td  colspan="3"><select name="cboPaymentTerm" class="txtbox" id="cboPaymentTerm" style="width:490px">
                    <?php
	$SQL="select strPayTermId,strDescription from popaymentterms where intStatus not in(13,14) order by strDescription";		
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strPayTermId"] ."\">" . $row["strDescription"] ."</option>" ;
	}		  
			  
				  ?>
                </select></td>
              </tr>
              <tr>
                <td class="normalfnt">Material</td>
                <td><input name="txtMaterial" type="text" class="txtbox" id="txtMaterial" style="width:158px" maxlength="30"/></td>
                <td class="normalfnt">Garment Type </td>
                <td><input name="txtGarmentType " type="text" class="txtbox" id="txtGarmentType" style="width:220px"maxlength="30"/></td>
                <td class="normalfnt">Quota Cat </td>
                <td><input name="txtQuataCat" type="text" class="txtbox" id="txtQuataCat" style="width:170px" maxlength="30"/></td>
              </tr>
              <tr>
                <td class="normalfnt">Dimension</td>
                <td><input name="textDimension" type="text"  class="textbox" id="textDimension" style="width:158px" maxlength="10" /></td>
                <td class="normalfnt" nowrap="nowrap">Fabric Content</td>
                <td colspan="3"><input name="textFabricContent" type="text"  class="textbox" id="textFabricContent"style="width:489px" maxlength="100" /></td>
              </tr>
              <tr>
                <td class="normalfnt">Wash Code</td>
                <td><input name="textWashCode" type="text"  class="textbox" id="textWashCode" style="width:158px" maxlength="30" /></td>
                <td class="normalfnt">Description</td>
                <td colspan="3"><input name="textDescription" type="text"  class="textbox" id="textDescription" style="width:489px" maxlength="10" /></td>
              </tr>
              <tr>
                <td class="normalfnt">Qty</td>
                <td><input name="textQty" type="text"  class="textbox" id="textQty" style="width:158px" maxlength="50" /></td>
                <td class="normalfnt">CTN .Size</td>
                <td rowspan="4" colspan="3"><table width="428" border="0" bgcolor="#F9E3CC" cellpadding="0" cellspacing="1">
                    <tr bgcolor="#FFFFFF">
                      <td width="25%"  class="normalfnt">Length</td>
                      <td width="25%" class="normalfnt">Width</td>
                      <td width="26%" class="normalfnt">Height</td>
                      <td width="24%">&nbsp;</td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr >
                    <tr bgcolor="#FFFFFF">
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr >
                    <tr bgcolor="#FFFFFF">
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td class="normalfnt">Vessal</td>
                <td colspan="5"><input name="textVessal" type="text"  class="textbox" id="textVessal" style="width:158px" maxlength="50" /></td>
                <td width="0%" class="normalfnt">&nbsp;</td>
                <td width="0%" >&nbsp;</td>
                <td width="0%" >&nbsp;</td>
              </tr>
              <tr>
                <td class="normalfnt">Vessal Date</td>
                <td colspan="5"><input name="textVessalData" type="text"  class="textbox" id="textVessalData" style="width:158px" maxlength="50" /></td>
              </tr>
              <tr>
                <td class="normalfnt">Mode</td>
                <td colspan="5"><select name="cboMode" class="txtbox" id="cboMode" onchange="" style="width:160px">
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
              </tr>
              <tr>
                <td class="normalfnt">Gender</td>
                <td class="normalfnt"><select name="cboGender" class="txtbox" id="cboGender" onchange="" style="width:160px">
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
                    <img src="../../../images/aad.png" onclick="loadGenderPopUp()" /></td>				 
                <td class="normalfnt">CTN.Type</td>
                <td class="normalfnt"><input name="textCtnType" type="text"  class="textbox" id="textCtnType" style="width:220px" maxlength="50" /></td>
                <td colspan="2" class="normalfnt"><table>
                    <tr>
                      <td><input type="radio" id="orderData_rdctntype" name="orderData_rdctntype" /></td>
                      <td>Bottom</td>
                      <td><input type="radio"id="orderData_rdctntype" name="orderData_rdctntype" /></td>
                      <td>Top</td>
                    </tr>
                </table></td>
              </tr>	
			   <tr>
                <td class="normalfnt"nowrap="nowrap" >Fabric Ref No</td>
                <td><input name="textFabricRefNo" type="text"  class="textbox" id="textFabricRefNo" style="width:158px" maxlength="30" /></td>
                <td class="normalfnt">Mill</td>
                <td colspan="3"><select name="cboMill" class="txtbox" id="cboMill" onchange="" style="width:489px">
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
                <td colspan="2"  class="normalfnt">Po & Quantities</td>
                <td  colspan="4" class="normalfnt">Destination</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="2" ><table width="269" border="1" id="tblPoQty">
                    <thead>
                      <tr>
                        <td width="19">&nbsp;</td>
                        <td width="91" class="normalfnt">Actival Po</td>
                        <td width="68" class="normalfnt">Qty</td>
                        <td width="63" class="normalfnt">Destination</td>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table></td>
                <td colspan="4"><table>
                    <tr>
                      <td class="normalfnt">Destination</td>
                      <td class="normalfnt">Adderss 1</td>
                      <td class="normalfnt">Adderss 2</td>
                      <td class="normalfnt">Telephone</td>
                      <td class="normalfnt">Fax</td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0"class="bcgl1">
              <tr>
                <td align="center" width="100%"><table  border="0" class="tableFooter">
                    <tr>
                      <td ><img src="../../../images/new.png" alt="New" name="New"
					  width="96" height="24" onclick="ClearForm();" class="mouseover"/></td>
                      <td ><img src="../../../images/save.png" alt="Save" name="Save" width="84" height="24" onclick="SaveShipingData();" class="mouseover"/></td>
                      <td ><img src="../../../images/delete.png" alt="Delete" name="Delete"
					  width="100" height="24" onclick="ConfirmDelete(this.name)" class="mouseover"/></td>
                      <td class="normalfnt"><img src="../../../images/report.png" alt="Report" width="108" height="24" border="0" class="mouseover" onclick="ViewShippingdataReport();"  /></td>        
                       <td ><a href="../../../main.php"><img src="../../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td> 					  	  
                     </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
       <td width="13%">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  </tr>
  <td>&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
