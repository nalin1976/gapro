<?php
	session_start();
	include("../../Connector.php");
	$backwardseperator = "../../";
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web -CDN</title>

<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
	
}

-->
</style>

<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>
<link type="text/css" href="../../css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../../AATestRB/InterJob/java.js" type="text/javascript"></script>
<script src="../../NewFabricInspectionJS.js"></script>
<script src="manualinvoice.js"></script>
<script src="Commercialinvoice.js" type="text/javascript"></script>
<script src="cdn.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>

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
<link type="text/css" href="../../css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="../../js/jquery-ui-1.7.2.custom.min.js"></script>
		<script type="text/javascript">
			$(function(){

				// Accordion
				$("#accordion").accordion({ header: "h3" });
	
				// Tabs
				$('#tabs').tabs();
	

				// Dialog			
				$('#dialog').dialog({
					autoOpen: false,
					width: 600,
					buttons: {
						"Ok": function() { 
							$(this).dialog("close"); 
						}, 
						"Cancel": function() { 
							$(this).dialog("close"); 
						} 
					}
				});
				
				// Dialog Link
				$('#dialog_link').click(function(){
					$('#dialog').dialog('open');
					return false;
				});

				// Datepicker
				$('#datepicker').datepicker({
					inline: true
				});
				
				// Slider
				$('#slider').slider({
					range: true,
					values: [17, 67]
				});
				
				// Progressbar
				$("#progressbar").progressbar({
					value: 20 
				});
				
				//hover states on the static widgets
				$('#dialog_link, ul#icons li').hover(
					function() { $(this).addClass('ui-state-hover'); }, 
					function() { $(this).removeClass('ui-state-hover'); }
				);
				
			});
		</script>
	
</head>

<body><!-- setDefaultDate-->
<form name="frmFabricIns" id="frmFabricIns" >
  <table width="950" border="0" align="center" bgcolor="#FFFFFF">
<tr>
    <td><?php include '../../Header.php'; 
 ?></td>
</tr>
  <tr>
    <td height="12" colspan="2" bgcolor="#316895" class="TitleN2white">Cargo Dispatch Note </td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
	<tr class="bcgl1txt1NB">
	  <td>
      <div  id="tabs" >
			<ul>
				<li><a href="#tabs-1" >Cargo Dispatch Note</a></li>
				<li><a href="#tabs-2" onclick="saveCDN();getMarksNDesc();">Description Of Goods</a></li>
				<li><a href="#tabs-3" onclick="load_po_desc();">PO Wise Description</a></li>
			</ul>
			<div id="tabs-1"><table width="100%" border="0">
      <tr>
        <td width="62%"><table width="100%" border="0">
          <tr>
            <td height="30" bgcolor="#588DE7" class="TitleN2white">Cargo Dispatch Note </td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%" class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td class="normalfnt"><table width="100%" border="0" cellpadding="1" cellspacing="1" class="bcgl1"><tr><td><table width="100%" border="0" cellpadding="1" cellspacing="1" class="bcgl1">
                        <tr>
                          <td width="14%" height="3"></td>
                          <td width="19%"></td>
                          <td width="15%"></td>
                          <td width="19%"></td>
                          <td width="15%"></td>
                          <td width="18%"></td>
                        </tr>
                        <tr>
                          <td>&nbsp;&nbsp;Select Invoice</td>
                          <td ><select name="cboInvoice"  class="txtbox" id="cboInvoice"style="width:150px" onchange="viewCDN();">
                              <option value=''></option>
                              <?php
                   			$str="select strInvoiceNo from shippingnote order by strInvoiceNo";
                  			$exec=$db->RunQuery($str);
									while($row=mysql_fetch_array($exec)) 
						 			{?>
                              <option value="<?php echo $row['strInvoiceNo'];?>"><?php echo $row['strInvoiceNo'];?></option>
                              <?php }?>
                            </select>                          </td>
                          <td>Date </td>
                          <td><input name="txtDate" style="width:100px; text-align:center" type="text" maxlength="100" class="txtbox" id="txtDate" size="10" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" /></td>
                          <td>Shipper(Company)</td>
                          <td><select name="txtShipper"  class="txtbox" id="txtShipper"style="width:150px" >
                              <option value=''></option>
                            </select>                          </td>
                        </tr>
                        <tr>
                          <td>&nbsp;&nbsp;Consignee</td>
                          <td><select name="txtConsignee"  class="txtbox" id="txtConsignee"style="width:150px" >
                              <option value=''></option>
                            </select>                          </td>
                          <td><!--<input name="txtShipper" type="text" class="txtbox" id="txtShipper" size="18" />-->
                            Vessel</td>
                          <td><input name="txtVessel" type="text" class="txtbox" id="txtVessel" size="25" maxlength="100"/></td>
                          <td>Ex-Vessel</td>
                          <td><!--<input name="txtConsignee" type="text" class="txtbox" id="txtConsignee" size="18" />-->
                              <input name="txtExVessel" type="text" maxlength="100" class="txtbox" id="txtExVessel" size="25" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;&nbsp;Voyage</td>
                          <td><input name="txtVoyage" type="text" maxlength="100" class="txtbox" id="txtVoyage" size="25" /></td>
                          <td>Voyage Date</td>
                          <td><input name="txtVoyegeDate" style="width:100px; text-align:center" type="text" maxlength="100" class="txtbox" id="txtVoyegeDate" size="10" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" /></td>
                          <td>Port Of Discharge</td>
                          <td><input name="txtDischarge" type="text" maxlength="100" class="txtbox" id="txtDischarge" size="25" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;&nbsp;Lorry No </td>
                          <td><input name="txtLorry" type="text" maxlength="100" class="txtbox" id="txtLorry" size="25" /></td>
                          <td>BL No </td>
                          <td><input name="txtBL" type="text" maxlength="100" class="txtbox" id="txtBL" size="25" /></td>
                          <td>Tare Wt. Kg </td>
                          <td><input name="txtTareWt" type="text" maxlength="100" class="txtbox" id="txtTareWt" size="25" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
                        </tr>
                        <tr>
                          <td>&nbsp;&nbsp;Customer Entry </td>
                          <td><input name="txtCustomerEntry" type="text" maxlength="100" class="txtbox" id="txtCustomerEntry" size="25" /></td>
                          <td>Seal No </td>
                          <td><input name="txtSeal" type="text" maxlength="100" class="txtbox" id="txtSeal" size="25" /></td>
                          <td>Declarent Name</td>
                          <td><select id="txtDeclarent" class="txtbox" style="width:150px"   name="txtDeclarent" tabindex="4">
                              <option value=""></option>
                              <?php 
					$strWharf="	select
								intWharfClerkID,
								strName
								from 
								wharfclerks";
				$resultsWharf=$db->RunQuery($strWharf);
					while($rowWharf=mysql_fetch_array($resultsWharf)){?>
                              <option value="<?php echo $rowWharf['intWharfClerkID'];?>"><?php echo $rowWharf['strName'];?></option>
                              <?php }?>
                          </select></td>
                        </tr>
                        <tr>
                          <td>&nbsp;&nbsp;Name Of Driver </td>
                          <td><input name="txtDriver" type="text" maxlength="100" class="txtbox" id="txtDriver" size="25" /></td>
                          <td>Name Of Cleaner </td>
                          <td><input name="txtCleaner" type="text" maxlength="100" class="txtbox" id="txtCleaner" size="25" /></td>
                          <td>Signatory</td>
                          <td><select id="txtSignatroy" class="txtbox" style="width:150px"   name="txtSignatroy" tabindex="4">
                              <option value=""></option>
                              <?php 
					$strWharf="	select
								intWharfClerkID,
								strName
								from 
								wharfclerks";
				$resultsWharf=$db->RunQuery($strWharf);
					while($rowWharf=mysql_fetch_array($resultsWharf)){?>
                              <option value="<?php echo $rowWharf['intWharfClerkID'];?>"><?php echo $rowWharf['strName'];?></option>
                              <?php }?>
                          </select></td>
                        </tr>
                        <tr>
                          <td>&nbsp;&nbsp;Gross Wt. </td>
                          <td><input name="txtGross" type="text" maxlength="100" class="txtbox" id="txtGross" size="25" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
                          <td>Others</td>
                          <td><input name="txtOthers" type="text" maxlength="100" class="txtbox" id="txtOthers" size="25" /></td>
                          <td>Net Wt.</td>
                          <td><input name="txtNet" type="text" maxlength="100" class="txtbox" id="txtNet" size="25" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
                        </tr>
                        <tr>
                          <td>&nbsp;&nbsp;CBM</td>
                          <td><input name="txtCBM" type="text" maxlength="100" class="txtbox" id="txtCBM" size="25"  /></td>
                          <td>Temperature</td>
                          <td><input name="txtTemperature" type="text" maxlength="100" class="txtbox" id="txtTemperature" size="25" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
                          <td>CNT OPR Code</td>
                          <td><input name="txtCNT" type="text" maxlength="100" class="txtbox" id="txtCNT" size="25" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;&nbsp;VSL OPR Code </td>
                          <td><input name="txtVSLOPR" type="text" maxlength="100" class="txtbox" id="txtVSLOPR" size="25" /></td>
                          <td>Place Of Delivery</td>
                          <td><select name="txtDelivery"  class="txtbox" id="txtDelivery" style="width:150px" >
                              <option value=''></option>
                              <option value='CY'>CY</option>
                              <option value='CFS'>CFS</option>
                              <option value='DOOR'>DOOR</option>
                          </select></td>
                          <td>Place Of Receipt </td>
                          <td><select name="txtPlaceofReceipt"  class="txtbox" id="txtPlaceofReceipt"style="width:150px" >
                              <option value=''></option>
                              <option value='CY'>CY</option>
                              <option value='PORT'>PORT</option>
                              <option value='CFS'>CFS</option>
                              <option value='DOOR'>DOOR</option>
                          </select></td>
                        </tr>
                        <tr>
                          <td colspan="6" height="2"></td>
                        </tr>
                      </table></td>
                          </tr>
                      </table></td>
                      </tr>
                    <tr class="bcgcolor-highlighted">
                      <td class="normalfnt2bldBLACK">Type Of Container</td>
                    </tr><tr><td>

                          <table width="100%" border="0" cellspacing="1" cellpadding="1">
                          <tr>
                            <td width="3%">&nbsp;</td>
                            <td width="11%">Height</td>
                            <td width="19%"><input name="txtHeight" type="text" maxlength="100" class="txtbox" id="txtHeight" size="18" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
                            <td width="15%">Lenght</td>
                            <td width="19%"><input name="txtLength" type="text" maxlength="100" class="txtbox" id="txtLength" size="18" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
                            <td width="15%">Type</td>
                            <td width="18%"><select name="txtType"  class="txtbox" id="txtType"style="width:150px" >
                              <option value=''></option>
                              <option value='01X20 GP'>01X20 GP</option>
                              <option value='01X40 HC'>01X40 HC</option>
                              <option value='01X40 GP'>01X40 GP</option>
                              </select></td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td>Remarks</td>
                            <td colspan="3" rowspan="4" valign="top"><label for="textarea"></label>
                              <textarea name="txtRemarks" cols="40" rows="3" id="txtRemarks"></textarea></td>
                            <td colspan="2" rowspan="4" align="center">&nbsp;</td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            </tr>
                        </table>                        </td>
                      </tr>
                  </table></td>
                  </tr>
              </table>            </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr bgcolor="#d6e7f5">
                <td width="100%"><table width="100%" border="0" cellspacing="0">
                    <tr bgcolor="#d6e7f5">
                      <td width="21%">&nbsp;</td>
                      <td width="19"><img src="../../images/new.png" alt="New" width="100" height="24" name="New"onclick="ClearForm();" /></td>
                      <td width="21"><img src="../../images/save.png" alt="Save" width="84" height="24" name="Save" onclick="saveCDN();" class="mouseover;"/></td>
                      <td width="21"><img src="../../images/print.png" alt="Delete" width="100" height="24" name="Delete"onclick="printReport();" class="mouseover;"/></td>
                      <td width="18%"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0"/></a></td>
                      <td width="21%">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        </tr>
    </table>
			</div>
			<div id="tabs-2" style="height:600"><table height="563" width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="91%" height="21" bgcolor="#9BBFDD" class="head1">Description Of Goods </td>
        <td width="9%" bgcolor="#9BBFDD" class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td height="540" colspan="2" class="normalfnt">
		<div id="divcons" style="overflow:hidden; height:540px; width:100%px;">
		<table width="100%" border="0">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="100%" border="0">
          <tr>
            <td height="30" bgcolor="#588DE7" class="TitleN2white">Cargo Dispatch Note </td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%" class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td class="normalfnt"><table width="100%" border="0" cellpadding="1" cellspacing="1" class="bcgl1">
                        <tr>
                          <td width="1%">&nbsp;</td>
                          <td colspan="2" class="normalfnBLD1"><div align="center">Marks No Of Packages </div></td>
                          <td width="11%">&nbsp;</td>
                          <td colspan="2" class="normalfnBLD1"><div align="center">Item Description </div></td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td colspan="2" rowspan="12"><label for="textarea"></label>
                            <div align="center">
                              <textarea name="txtMarksnnosarea" style="width:180px;" rows="20" id="txtMarksnnosarea"></textarea>
                            </div></td>
                          <td>&nbsp;</td>
                          <td colspan="2" rowspan="12"><div align="center">
                            <textarea name="txtDescarea" style="width:180px;" rows="20" id="txtDescarea"></textarea>
                          </div></td>
                          </tr>
                        <tr>
                          <td height="17">&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td width="9%">&nbsp;</td>
                          <td width="35%">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td width="10%">&nbsp;</td>
                          <td width="34%">&nbsp;</td>
                        </tr>
                      </table></td>
                      </tr>
                    <tr class="bcgl1">
                      <td class="normalfnt">&nbsp;</td>
                      </tr>
                  </table></td>
                  </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr bgcolor="#d6e7f5">
                <td width="100%"><table width="100%" border="0" cellspacing="0">
                    <tr bgcolor="#d6e7f5">
                      <td width="117">&nbsp;</td>
                      <td width="59">&nbsp;</td>
                      <td width="110"><img src="../../images/save.png" alt="Save" width="84" height="24" name="Save" onclick="saveMarksDesc();"/></td>
                      <td width="17">&nbsp;</td>
                      <td width="137"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0"/></a></td>
                      <td width="117">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="19%">&nbsp;</td>
      </tr>
    </table>
		</div>		</td>
        </tr>
    </table></div>
	<div id="tabs-3" s><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      
      <tr>
        <td width="91%" height="21" bgcolor="#9BBFDD" class="head1">PO Wise Description </td>
        <td width="9%" bgcolor="#9BBFDD" class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="normalfnt">
		
		<div style="overflow: scroll; height: 250px; width: 900px;" id="selectitem"><table width="880" cellspacing="1" cellpadding="0" class="bcgl1 normalfnt" id="tblDescription_po">
          <tr>
          	<td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">&nbsp;</td>
            <td width="15%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">PO # </td>
			<td width="10%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">ISD </td>
			<td width="15%" bgcolor="#498CC2" class="normaltxtmidb2">DESCRIPTION</td>
            <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">CTNS</td>
			<td width="10%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">PCS</td>			
            <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">NET Wt. </td>
			<td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">GROSS Wt. </td>
			<td width="10%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">CBM</td>			                
            </tr></table></div>				</td>
        </tr>
		<tr>
        <td height="21" colspan="2" bgcolor="#D6E7F5" class="head1"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="10%">&nbsp;</td>
            <td width="10%">&nbsp;</td>
            <td width="10%">&nbsp;</td>
            <td width="10%">&nbsp;</td>
            <td width="10%"><img src="../../images/save.png" alt="Save" name="Save" width="84" height="24" id="Save" onclick="save_po_wise_cdn();"/></td>
            <td width="10%"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
            <td width="10%">&nbsp;</td>
            <td width="10%">&nbsp;</td>
            <td width="10%">&nbsp;</td>
            <td width="10%">&nbsp;</td>
          </tr>
        </table></td>
        </tr>
    </table>
	</div>	
      </div>
		</td>
		</tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
      <tr>
        <td height="19" bgcolor="#D6E7F5">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>