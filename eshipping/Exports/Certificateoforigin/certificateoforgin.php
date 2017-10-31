<?php
	session_start();
	include("../../Connector.php");
	$backwardseperator = "../../";
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web - Certificate Of Origin</title>

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

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="manualinvoice.js"></script>
<script src="Commercialinvoice.js" type="text/javascript"></script>
<script src="certificateoforgin.js"></script>
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
    <td height="12" colspan="2" bgcolor="#316895" class="TitleN2white">Certificate Of Origin</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
	<tr class="bcgl1txt1NB">
	  <td>
      <div  id="tabs" >
			<ul>
				<li><a href="#tabs-1" onclick="clearall();">Invoice</a></li>
				<li><a href="#tabs-2" onclick="getInvoiceDetail();">Description Of Goods</a></li>
				<li style="visibility:hidden"><a href="#tabs-3" onclick="checkInvoiceNo();">Details</a></li>
			</ul>
			<div id="tabs-1"><table width="100%" border="0">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="100%" border="0">
          <tr>
            <td height="10" bgcolor="#588DE7" class="TitleN2white">Certificate Of Origin 
              </td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%" class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td class="normalfnt"><table width="100%" border="0" cellpadding="1" cellspacing="1" class="bcgl1">
                        <tr>
                          <td width="2%">&nbsp;</td>
                          <td width="19%">&nbsp;</td>
                          <td width="22%">&nbsp;</td>
                          <td width="1%">&nbsp;</td>
                          <td width="30%">&nbsp;</td>
                          <td width="26%">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td width="19%" height="30">Select Invoice </td>
                          <td colspan="4"><select name="cboInvoice"  class="txtbox" id="cboInvoice"style="width:140px" onchange="getData();">				<option value=""></option>
                            <?php $sql="select strInvoiceNo from invoiceheader order by strInvoiceNo" ;
							$results=$db->RunQuery($sql);
							while($r=mysql_fetch_array($results)){
							?>
                            <option value="<?php echo $r['strInvoiceNo'];?>"><?php echo $r['strInvoiceNo'];?></option>
							<?php } ?>
                          </select></td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Shipper(Company)</td>
                          <td><input name="txtCompany" type="text" class="txtbox" id="txtCompany" size="18" disabled="disabled"; /></td>
                          <td>&nbsp;</td>
                          <td>Port Of Discharge </td>
                          <td><input name="txtPortofDischarge" type="text" class="txtbox" id="txtPortofDischarge" size="18" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Consignee</td>
                          <td><input name="txtConsgnee" type="text" class="txtbox" id="txtConsgnee" size="18"  disabled="disabled"/></td>
                          <td>&nbsp;</td>
                          <td>Export Year </td>
                          <td><input name="txtYear" type="text" class="txtbox" id="txtYear" size="18" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Vessel</td>
                          <td><input name="txtVessel" type="text" class="txtbox" id="txtVessel" size="18" /></td>
                          <td>&nbsp;</td>
                          <td>Supplimentary Det. </td>
                          <td><input name="txtSupplimentry" type="text" class="txtbox" id="txtSupplimentry" size="18" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Final Destination </td>
                          <td><input name="txtDestination" type="text" class="txtbox" id="txtDestination" size="18" /></td>
                          <td>&nbsp;</td>
                          <td>No Of Cartons </td>
                          <td><input name="txtCartoons" type="text" class="txtbox" id="txtCartoons" size="18" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Cage 2 </td>
                          <td><input name="txtCage2" type="text" class="txtbox" id="txtCage2" size="18" /></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td height="25">Marks No Of Pkgs </td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td colspan="4" rowspan="4"><label for="label"></label>
                            <textarea name="texMarksnNos" cols="50" rows="4" id="texMarksnNos"></textarea></td>
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
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                      </table></td>
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
                      <td width="21%">&nbsp;</td>
                      <td width="19"><img src="../../images/new.png" alt="New" width="100" height="24" name="New"onclick="Clearformm();" class="mouseover"/></td>
                      <td width="21"><img src="../../images/save.png" alt="Save" width="84" height="24" name="Save" onclick="savedb()" class="mouseover"/></td>
                      <td width="21"><img src="../../images/print.png" alt="Delete" class="mouseover" name="Delete" width="100" height="24"  id="Delete"onclick="printReport();"/></td>
                      <td width="18%"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0"/></a></td>
                      <td width="21%">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="19%">&nbsp;</td>
      </tr>
    </table>
			 </div>
			<div id="tabs-2" style="height:600"><table height="563" width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="91%" height="21" bgcolor="#9BBFDD" class="head1">Description Of Goods </td>
        <td width="9%" bgcolor="#9BBFDD" class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td height="280" colspan="2" class="normalfnt">
		<div id="divcons" style="overflow:hidden; height:540px; width:100%px;">
		<table width="100%" height="323" class="bcgl1">
		  <tr>
		    <td width="107" height="15">Invoice No </td>
		    <td width="187"><input name="txtInvoiceDetail" type="text" class="txtbox" id="txtInvoiceDetail"  size="25" maxlength="10" disabled="disabled" /></td>
		    <td width="147" >&nbsp;</td>
		    <td width="147" >&nbsp;</td>
		    <td width="147" >&nbsp;</td>
		    <td width="148" >&nbsp;</td>
			</tr>
		<tr>
		<td height="80" colspan="6" ><div style="overflow: scroll; height: 250px; width: 900px;" id="selectitem"><table width="1200" cellspacing="1" cellpadding="0" class="bcgl1" id="tblDescription">
          <tbody id="tblDescriptionOfGood">
          <tr>
          	<td width="30" bgcolor="#498CC2" class="normaltxtmidb2">&nbsp;</td>
            <td width="30" bgcolor="#498CC2" class="normaltxtmidb2">Id</td>
            <td width="40" height="33" bgcolor="#498CC2" class="normaltxtmidb2">Style No</td>
            <td width="230" bgcolor="#498CC2" class="normaltxtmidb2">Description</td>
            <td width="70" bgcolor="#498CC2" class="normaltxtmidb2">Unit Price </td>
            <td width="30" bgcolor="#498CC2" class="normaltxtmidb2">Unit</td>
            <td width="70" bgcolor="#498CC2" class="normaltxtmidb2">CM</td>
            <td width="70" bgcolor="#498CC2" class="normaltxtmidb2">Qty</td>
             <td width="30" bgcolor="#498CC2" class="normaltxtmidb2">Unit </td>
            <td width="100" bgcolor="#498CC2" class="normaltxtmidb2">Value</td>
            <td width="70" bgcolor="#498CC2" class="normaltxtmidb2">Gr Mass </td>
            <td width="70" bgcolor="#498CC2" class="normaltxtmidb2">Nt Mass </td>
            <td width="110" bgcolor="#498CC2" class="normaltxtmidb2">Hs Code </td>
           	<td width="40" bgcolor="#498CC2" class="normaltxtmidb2">No Of CTNS</td>
			<td width="70" bgcolor="#498CC2" class="normaltxtmidb2">Umo_Qty1</td>
           	<td width="70" bgcolor="#498CC2" class="normaltxtmidb2">Umo_Qty2</td>
			<td width="70" bgcolor="#498CC2" class="normaltxtmidb2">Umo_Qty3</td>
            </tr></tbody></table></div> </td>
		<td width="148" >&nbsp;</td>
		</tr>
		<tr>
		  <td colspan="6" ><table width="103%" border="0" cellspacing="0" cellpadding="0">
            <tr bgcolor="#D6E7F5">
              <td width="29%" height="29" >&nbsp;</td>
              <td width="11%" ><img src="../../images/new.png" alt="new" name="butNew" width="96" height="24" class="mouseover"  id="butNew" onclick=" newDettail();setGenDesc();"/></td>
              <td width="13%" ><img src="../../images/cancel.jpg" width="104" height="24" onclick ="getInvoiceDetail() ;" /></td>
              <td width="11%" ><img src="../../images/save.png" alt="save" name="butSave" width="84" height="24" class="mouseover" id="butSave" onclick="saveData();" /></td>
              <td width="12%" ><a href="../../main.php"><img src="../../images/close.png" width="97" height="24" border="0" class="mouseover" /></a></td>
              <td width="24%" >&nbsp;</td>
            </tr>
          </table></td>
          </tr>
		<tr>
		  <td colspan="6" ><table width="100%" border="0" cellspacing="0" cellpadding="1">
            <tr>
              <td width="9">&nbsp;</td>
              <td width="97" height="30">Style No </td>
              <td width="255"><input name="txtStyle" type="text" size="15" tabindex="1" class="txtbox" id="txtStyle"style="width:210ssspx">              </td>
              <td colspan="2"><div align="center">Description Of Goods </div></td><td colspan="2">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="27">&nbsp;</td>
              <td>Qty</td>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="37%"><input name="txtQty"  class="txtbox" id="txtQty" tabindex="2" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="50" /></td>
                  <td width="19%"><div align="left"> &nbsp; Unit</div></td>
                  <td width="44%"><select name="txtQtyUnit" type="text" tabindex="3" id="txtQtyUnit" class="txtbox" style="width:100px" >
						<option value=""></option>	                  
                  <?php 
							$sqlunit="SELECT 	strUnit FROM 	units ";
							$resultunit=$db->RunQuery($sqlunit);							
							while($rowunit=mysql_fetch_array($resultunit)) 
							{
							echo "<option value=".$rowunit['strUnit'].">".$rowunit['strUnit']."</option>";
															
							}  
						         
                  ?>
						</select>                  </td>
                </tr>
              </table></td>
              <td rowspan="4" align="center">&nbsp;</td>
              <td rowspan="4" align="center"><div align="left">
                <textarea name="txtareaDisc"  tabindex="12"id="txtareaDisc" style="width:160px; height:100px; "></textarea>
              </div></td>
              <td aligsn="center"><div align="center">Umo &amp; Qty1</div></td>
              <td aligsn="center"><div align="center">
                <input name="txtUmoQty1"  class="txtbox" id="txtUmoQty1" tabindex="16" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="10" />
              </div></td>
              <td width="108"><select name="cboUmoQty1" type="text" tabindex="17" id="cboUmoQty1" class="txtbox" style="width:100px" >
                <option value=""></option>
                <?php 
							$sqlunit="SELECT 	strUnit FROM 	units ";
							$resultunit=$db->RunQuery($sqlunit);							
							while($rowunit=mysql_fetch_array($resultunit)) 
							{
							echo "<option value=".$rowunit['strUnit'].">".$rowunit['strUnit']."</option>";
															
							}  
						         
                  ?>
              </select></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td height="29">Unit Price </td>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="37%"><input name="txtUnitPrice" type="text" class="txtbox" id="txtUnitPrice" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="30"tabindex="3" /></td>
                  <td width="19%"><div align="left">&nbsp; Unit </div></td>
                  <td width="44%"><select name="txtUnit" type="text" tabindex="4" id="txtUnit" class="txtbox" style="width:100px" >
                    <option value=""></option>
                    <?php 
							$sqlunit="SELECT 	strUnit FROM 	units ";
							$resultunit=$db->RunQuery($sqlunit);							
							while($rowunit=mysql_fetch_array($resultunit)) 
							{
							echo "<option value=".$rowunit['strUnit'].">".$rowunit['strUnit']."</option>";
															
							}  
						         
                  ?>
                  </select></td>                 
                </tr>
              </table></td>
              <td align="center">Umo &amp; Qty2</td>
              <td align="center"><input name="txtUmoQty2"  class="txtbox" id="txtUmoQty2" tabindex="18" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="10" /></td>
              <td><select name="cboUmoQty2" type="text" tabindex="19" id="cboUmoQty2" class="txtbox" style="width:100px" >
                <option value=""></option>
                <?php 
							$sqlunit="SELECT 	strUnit FROM 	units ";
							$resultunit=$db->RunQuery($sqlunit);							
							while($rowunit=mysql_fetch_array($resultunit)) 
							{
							echo "<option value=".$rowunit['strUnit'].">".$rowunit['strUnit']."</option>";
															
							}  
						         
                  ?>
              </select></td>
            </tr>
            <tr>
              <td height="27">&nbsp;</td>
              <td>CM(P/T/Q)</td>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="37%"><input name="txtCM" tabindex="6" type="text" class="txtbox" id="txtCM" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="30" /></td>
                  <td width="19%">
                      <div align="left">&nbsp; Value</div></td><td width="44%"><input name="txtValue" tabindex="7" class="txtbox" id="txtValue" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onfocus="getItemVal();" size="15" maxlength="30" /></td>
                </tr>
              </table></td>
              <td align="center">Umo &amp; Qty3</td>
              <td align="center"><input name="txtUmoQty3"  class="txtbox" id="txtUmoQty3" tabindex="20" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="10" /></td>
              <td><select name="cboUmoQty3" type="text" tabindex="21" id="cboUmoQty3" class="txtbox" style="width:100px" >
                <option value=""></option>
                <?php 
							$sqlunit="SELECT 	strUnit FROM 	units ";
							$resultunit=$db->RunQuery($sqlunit);							
							while($rowunit=mysql_fetch_array($resultunit)) 
							{
							echo "<option value=".$rowunit['strUnit'].">".$rowunit['strUnit']."</option>";
															
							}  
						         
                  ?>
              </select></td>
            </tr>
            <tr>
              <td height="28">&nbsp;</td>
              <td >Procedure Code </td>
              <td><input name="txtProcedureCode" type="text" class="txtbox" id="txtProcedureCode" style='text-align:right' tabindex="8" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="8" value="0000.000" /></td>
              <td align="center">Buyer Po No </td>
              <td colspan="2" align="center"><div align="left">
                <input name="txtBuyerPO" type="text" tabindex="13" class="txtbox" id="txtBuyerPO" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="33" maxlength="10" />
              </div></td>
              </tr>
            <tr>
              <td>&nbsp;</td>
              <td height="27">HS Code </td>
              <td>
              			<select  id="txtHS" tabindex="9" class="txtbox" name="txtHS" style="width:200px" >
                     <option value=""></option>
                     <?php 
							$sqlcategory="SELECT strCommodityCode FROM  excommoditycodes GROUP BY strCommodityCode";
							$resultcategory=$db->RunQuery($sqlcategory);							
							while($rowcategory=mysql_fetch_array($resultcategory)) 
							{
							echo "<option value=".$rowcategory['strCommodityCode'].">".$rowcategory['strCommodityCode']."</option>";
															
							}  
						         
                  	?>                          
                      </select></td>
              <td width="3">&nbsp;</td>
              <td width="190">&nbsp;</td>
              <td colspan="2">&nbsp;</td>
              <td>&nbsp;</td>     
            </tr>
            <tr>
              <td width="9" height="27">&nbsp;</td>
              <td >Category No </td>
              <td ><input name="cboCategory" type="text" class="txtbox" tabindex="10" id="cboCategory" size="35" maxlength="50" /></td>
              <td>&nbsp;</td>
              <td>Gross Mass </td>
              <td colspan="2"><input name="txtGross" type="text" class="txtbox" tabindex="14" id="txtGross" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="30" maxlength="10" /></td>
              <td>&nbsp;</td>     
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>No Of Ctns </td>
              <td><input name="txtCtns" type="text" class="txtbox" tabindex="11" id="txtCtns" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="20" /></td>
				  <td>&nbsp;</td>           
             
              <td>Net Mass </td>
              <td colspan="2"><input name="txtNet" type="text" tabindex="15" class="txtbox" id="txtNet" onkeypress="return CheckforValidDecimal(this.value, 4,event);"size="30" maxlength="10" /></td>
               <td><div align="right"><img src="../../images/addsmall.png" alt="add" width="95" height="24" class="mouseover"  onclick="addToGrid();"/></div></td>     
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td width="120">&nbsp;</td>
              <td width="92">&nbsp;</td>
              <td>&nbsp;</td>
              <td width="9">&nbsp;</td>
            </tr>
          </table></td>
          </tr>
		</table>
		</div>		</td>
        </tr>
    </table></div>
		<div id="tabs-3"  height:280px ><table width="100%" height="443" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="95%" height="17" bgcolor="#9BBFDD" class="normalfnth2"><div align="left" class="head1">Lots</div></td>
        <td width="5%" bgcolor="#9BBFDD" class="normalfnth2">&nbsp;</td>
      </tr>
      <tr>
        <td height="394" colspan="2"><div id="divLotInterface" style=" overflow:scroll; width:100%; height:400px" >
          <table width="100%" height="358" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <blockquote>&nbsp;</blockquote>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
            </tr>
            <tr>
              <td width="0%" class="normalfnt">&nbsp;</td>
              <td width="15%" class="normalfnt">10.Marks And Nos </td>
              <td width="23%" class="normalfnt">11.Description</td>
              <td width="27%" class="normalfnt">12.Quentity</td>
              <td width="22%" class="normalfnt">13.Unit Price </td>
              <blockquote>&nbsp;</blockquote>
              <td width="13%" class="normalfnt">14.Amount</td>
              <td width="0%" class="normalfnt">&nbsp;</td>
            </tr>
            <tr>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt"><p>
                  <label for="label"></label>
                  <textarea name="textarea4" rows="8" id="label"></textarea>
              </p></td>
              <td class="normalfnt"><textarea name="textarea5" cols="30" rows="8" id="textarea4"></textarea></td>
              <td class="normalfnt"><textarea name="textarea6" rows="8" id="textarea5"></textarea></td>
              <td class="normalfnt"><textarea name="textarea7" cols="20" rows="8" id="textarea6"></textarea></td>
              <td class="normalfnt"><textarea name="textarea8" cols="20" rows="8" id="textarea7"></textarea></td>
              <td class="normalfnt">&nbsp;</td>
            </tr>
            <tr>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
            </tr>		
            <tr>
              <td height="23" class="normalfnt">&nbsp;</td>
              <td class="normalfnt">N.F.E Clause </td>
              <td colspan="2" class="normalfnt"><input name="txtClrShading223323233626322" type="text" class="txtbox" id="txtClrShading223323233626322" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="40" maxlength="10" /></td>
              <td class="normalfnt"><input name="txtClrShading223323233627" type="text" class="txtbox" id="txtClrShading223323233627" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="10" /></td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
            </tr>
            <tr>
              <td class="normalfnt">&nbsp;</td>              
              <td class="normalfnt">F.O.B Clause </td>
              <td class="normalfnt"><input name="txtClrShading2233232336263222" type="text" class="txtbox" id="txtClrShading2233232336263222" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="40" maxlength="10" /></td>
              <td class="normalfnt">&nbsp;</td>
			  <td class="normalfnt"><input name="txtClrShading2233232336272" type="text" class="txtbox" id="txtClrShading2233232336272" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="10" /></td>
			  <td class="normalfnt">&nbsp;</td>
			  <td class="normalfnt">&nbsp;</td>
            </tr>
            <tr>
              <td class="normalfnt">&nbsp;</td>
              <td colspan="3" class="normalfnt"><textarea name="textarea9" cols="80" rows="4" id="label2"></textarea></td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
            </tr>
            <tr>
              <td class="normalfnt">&nbsp;</td>
              <td colspan="3" class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
            </tr>
            <tr>
              <td class="normalfnt">&nbsp;</td>
              <td colspan="3" class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
            </tr>
            <tr>
              <td class="normalfnt">&nbsp;</td>
              <td colspan="3" rowspan="4" class="normalfnt"><label for="label2"></label></td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
            </tr>
            <tr>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
            </tr>
            <tr>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
            </tr>
            <tr>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
            </tr>
          </table>          
        </div>
          </p></td>
      </tr>
	  
	  <tr>
	  <td>
	  <table width="900" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
      <tr>
        <td width="100" height="29">&nbsp;</td>
        <td width="100">&nbsp;</td>
        <td width="100"><img src="../../images/new.png" alt="new" name="butNew" width="96" height="24" class="mouseover"  id="butNew" onclick="pageReload(); "/></td>
        <td width="100"><img src="../../images/cancel.jpg" width="104" height="24" onclick ="DeleteInspection();" /></td>
        <td width="100"><img src="../../images/save.png" alt="save" name="butSave" width="84" height="24" class="mouseover" id="butSave" onclick="saveData();" /></td>
        <td width="100"><img src="../../images/report.png" alt="butReportList" name="butReportList" width="108" height="24" class="mouseover" id="butReport" /></td>
        <td width="100"><a href="../../../main.php"><img src="../../images/close.png" width="97" height="24" border="0" class="mouseover"  /></a></td>
        <td width="100">&nbsp;</td>
		<td width="100">&nbsp;</td>
		
      </tr>
    </table>
	  </td>
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