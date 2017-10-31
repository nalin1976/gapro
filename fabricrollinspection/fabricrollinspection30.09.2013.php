<?php
	session_start();
	include "../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
	$backwardseperator = "../";	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro : : Fabric Roll Inspection </title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script type="text/javascript" src="fabricrollinspection.js"></script>
<script type="text/javascript" src="../javascript/script.js"></script>

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
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />


<style type="text/css">
<!--
.style1 {color: #FF0000}
#lyrLoading {
	position:absolute;
	left:595px;
	top:443px;
	width:75px;
	height:21px;
	z-index:1;
	background-color: #FFFFFF;
	overflow: hidden;
}
-->
</style>
</head>

<body>

<form id="frmmain" name="frmmain" method="post" action="">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    
    <tr>
      <td><?php include '../Header.php'; ?></td>
    </tr>
    <tr>
      <td><table width="900" align="center" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF" class="tableBorder">
        <tr>
          <td  valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    
                    <tr>
                      <td height="7" class="mainHeading">Fabric Roll Inspection </td>
                      </tr>
                     <?php
					$sql_stores="select strMainID,strName from mainstores where intCompanyId='$companyId';";
					$result_stores=$db->RunQuery($sql_stores);
					$row_stores = mysql_fetch_array($result_stores);
					$storesName = $row_stores["strName"];
					$storesID	= $row_stores["strMainID"];
					?>
                    <tr>
                      <td><span class="normalfnt">
                        <input name="fabric_serial" type="hidden" id="fabric_serial" />
                        <input name="fabric_serial_year" type="hidden" id="fabric_serial_year" />
                        <input name="stores" type="hidden" id="stores" value="<?php echo $storesID;?>" />
                      </span></td>
                      </tr>
                </table></td>
              </tr>
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="3" class="normalfnt bcgl1">
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>Inspection No</td>
                    <td><select name="txtInspectionSerial" class="txtbox" id="txtInspectionSerial" style="width:200px"   tabindex="1">
                      <option  value=""></option>
                      <?php
						  $str_invoice="select intFRollSerialNO,intFRollSerialYear 
from fabricrollheader order by  intFRollSerialYear, intFRollSerialNO";
						  $result_invoice=$db->RunQuery($str_invoice);
						  while($row_invoice=mysql_fetch_array($result_invoice))
							  {?>
                      <option  value="<?php echo $row_invoice['intFRollSerialYear']."/".$row_invoice['intFRollSerialNO'];?>"><?php echo $row_invoice['intFRollSerialYear']."->".$row_invoice['intFRollSerialNO'];?></option>
                      <?php }
						  ?>
                    </select></td>
                    <td>Invoice No <span class="compulsoryRed">*</span></td>
                    <td><select name="cboInvoice" class="txtbox" id="cboInvoice" style="width:200px" onchange="get_matitem_list()"  tabindex="1">
                      <option  value=""></option>
                      <?php
						  $str_invoice="select distinct strInvoiceNo from bulkgrnheader order by strInvoiceNo";
						  $result_invoice=$db->RunQuery($str_invoice);
						  while($row_invoice=mysql_fetch_array($result_invoice))
							  {?>
                      <option  value="<?php echo $row_invoice['strInvoiceNo'];?>"><?php echo $row_invoice['strInvoiceNo'];?></option>
                      <?php }
						  ?>
                    </select></td>
                    <td>Supplier</td>
                    <td><select name="cboSupplier" class="txtbox" style="width:200px" id="cboSupplier" >
        </select></td>
                  </tr>
                  <tr>
                    <td>Style</td>
                    <td><select name="cboStyleId" class="txtbox" style="width:200px" id="cboStyleId" tabindex="3" onchange="SeachStyle(this);" >
                      <?php	 	
		$style_result =$db->RunQuery($str_style);
		
			echo "<option value =\"".""."\"></option>";
		while ($row_style=mysql_fetch_array($style_result))
		{		
			echo "<option value=\"".$row_style["intStyleId"]."\">".$row_style["strStyle"]."</option>";
		}
?>
                    </select></td>
                    <td>SC</td>
                    <td><select name="cboScNo"  class="txtbox" style="width:200px" id="cboScNo"  onchange="SeachStyle(this);">
                      <?php                  
		$result =$db->RunQuery($SQL);
		
			echo "<option value =\"".""."\"></option>";
		while ($row=mysql_fetch_array($result))
		{		
			echo "<option value=\"".$row["intStyleId"]."\">".$row["intSRNO"]."</option>";
		}
?>
                    </select></td>
                    <td>Date <span class="compulsoryRed">*</span></td>
                    <td><input name="txtDate" type="text" tabindex="5" class="txtbox" id="txtDate" style="width:128px"  value="<?php echo date('d/m/Y');?>" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%d/%m/%Y');" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;" onkeypress="return showCalendar(this.id, '%d/%m/%Y');"   onclick="return showCalendar(this.id, '%d/%m/%Y');"  value="" /></td>
                  </tr>
                  <tr>
                    <td>Item <span class="compulsoryRed">*</span></td>
                    <td><select name="cboItem" class="txtbox" id="cboItem" style="width:200px" onchange="get_color_list()" tabindex="2">
                      <option  value="" ></option>
                    </select></td>
                    <td>Color <span class="compulsoryRed">*</span></td>
                    <td><select name="cboColor" class="txtbox" id="cboColor" style="width:200px" onchange="refreshgrid();" tabindex="4">
                      <option  value="" selected="selected"></option>
                    </select></td>
                    <td>Stores</td>
                    <td><input name="txtStores" disabled="disabled" type="text" tabindex="5" class="txtbox" id="txtStores" style="width:128px" value="<?php echo $storesName;?>" /></td>
                  </tr>
                  <tr>
                    <td>PO Width </td>
                    <td><input name="txtPOwidth" tabindex="6" type="text" style="width:198px;" class="txtbox" id="txtPOwidth" maxlength="30" /></td>
                    <td>Invoice Width </td>
                    <td><input name="txtInvoicewidth" tabindex="6" type="text" style="width:198px;" class="txtbox" id="txtInvoicewidth" maxlength="30" /></td>
                    <td>Wash Type </td>
                    <td><input name="txtWashType" tabindex="6" type="text" style="width:198px;" class="txtbox" id="txtWashType" maxlength="30" /></td>
                  </tr>
                  <tr>
                    <td>Remarks</td>
                    <td colspan="3" rowspan="2"><textarea name="txtRemarks" style="width:198px"  rows="2" class="txtbox" id="txtRemarks" onkeypress="return imposeMaxLength(this,event, 200);" tabindex="14" ></textarea></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="11%"></td>
                    <td width="24%"></td>
                    <td width="11%"></td>
                    <td width="24%"></td>
                    <td width="10%"></td>
                    <td width="20%"></td>
                  </tr>
                </table></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td  valign="top"><table width="100" cellpadding="0" cellspacing="0">
              <tr>
                <td width="841"   class="mainHeading2">Details</td>
                <td width="109"  class="mainHeading2"><a href="#"></a></td>
              </tr>
              <tr>
                <td colspan="2"><div id="divcons" style="overflow:scroll; height:220px; width:900px;">
                    <table width="850" id="tbl_roll_details" bgcolor="#996f03"  cellpadding="0" cellspacing="1" class="normalfnt" >
                      <tr   class="mainHeading4">
					  	<td height="25" width="10%" >Del</td>
						<td height="25" width="10%" >Roll #</td>
                        <td height="25" width="10%" >Yards</td>
						<td height="25" width="10%" >Fabric Width</td>
						<td height="25" width="10%" >Shrink Length</td>
						<td height="25" width="10%" >Shrink Width</td>
						<td height="25" width="10%" >Shade</td>
						<td height="25" width="10%" >Ptrn No</td>
						<td height="25" width="10%" >Skewness</td>
						<td height="25" width="10%" >Elongation</td>
                      </tr>
                    </table>
                </div></td>
              </tr>
          </table></td>
        </tr>
        
        <tr>
          <td  ><table width="100%" class="bcgl1">
              <tr>
                <td width="25%" align="right"><img src="../images/new.png" alt="new" width="96" height="24" onclick="ClearForm();" class="mouseover"/></td>
				<td width="13%"><img src="../images/cal.png" alt="cal" width="114" height="24" onclick="sortgrid()"/></td>
                <td width="24%"><div align="center"><img src="../images/save-confirm.png" id="cmdSave" alt="save_confirm" width="174" height="24" onclick="SaveValidation();" class="mouseover"/></div></td>
                <td width="15%"><img src="../images/report.png" alt="report" width="108" height="24" border="0" class="mouseover" onclick="shrinkageReport();"/></td>
                
                <td width="23%"><a href="../main.php"><img src="../images/close.png" alt="close" width="97" height="24" border="0" class="mouseover"/></a></td>
              </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>

<!--Start - Search popup-->
<!--End - Search popup-->
<!--Start - Unit Conversion-->
<!--End - Unit Conversion-->
</html>