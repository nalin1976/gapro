<?php
	session_start();
	include("../../Connector.php");
	$backwardseperator = "../../";	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IOU Invoice </title>

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
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../../AATestRB/InterJob/java.js" type="text/javascript"></script>
<script src="../NewFabricInspectionJS.js"></script>
<script src="iouInvoice.js"></script>
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
<body>
<!--<body onload="setDefaultDate()">-->
<form name="frmFabricIns" id="frmFabricIns" >
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
<tr>
    <td><?php include '../../Header.php'; 
 ?></td>
</tr>
  <tr>
    <td height="12" colspan="2" bgcolor="#316895" class="TitleN2white">IOU Invoice </td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
	<tr class="bcgl1txt1NB">
	  <td>
      <div  id="tabs" >
			<ul>
				<li><a href="#tabs-1">Details Entry </a></li>
				<li><a href="#tabs-2">Un-Paid Invoices </a></li>
				<li><a href="#tabs-3">Paid Invoices </a></li>
			    <li><a href="#tabs-4">Payment</a></li>
			</ul>
			<div id="tabs-1">
			  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="89%" bgcolor="#9BBFDD" class="head1">Details Entry </td>
        <td width="11%" bgcolor="#9BBFDD" class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td height="280" colspan="2" class="normalfnt">
		<div id="divcons" style="overflow:scroll; height:450px; width:100%px;">
		<table width="108%" height="262" id="tblGen">
		    <tr class="bcgl1">
		      <td height="23"><table width="100%" cellspacing="0" class="bcgl1">
                <tr>
                  <td width="16%" height="23"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="18%"><input name="radiobutton" type="radio" value="radiobutton" id="radiobutton" />
                        <label for="radiobutton"></label></td>
                      <td width="33%">Imp</td>
                      <td width="21%"><input name="radiobutton" type="radio" value="radiobutton" id="radio" /></td>
                      <td width="28%">Exp</td>
                    </tr>
                  </table></td>
                  <td width="8%">IOU No </td>
                  <td width="11%"><select name="cboiouno" style="width:100px" id="cboiouno" class="txtbox" onchange="setbydelivery(this);" >
                     <?php
				$SQL = " SELECT 	intIOUNo FROM tbliouheader WHERE intSettled=1  ";
		
				$result = $db->RunQuery($SQL);
		
				echo "<option value=\"". "" ."\">" . "" ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"". $row["intIOUNo"] ."\">" . $row["intIOUNo"] ."</option>" ;
				}
							?>
                  </select></td>
                  <td width="3%">&nbsp;</td>
                  <td width="7%">Invoice No </td>
                  <td width="11%"><Input name="txtinvoiceNO" style="width:100px" id="txtinvoiceNO" class="txtbox" value="<?php $SQL = ' SELECT intInvoiceno 	FROM syscontrol';
                    		$result = $db->RunQuery($SQL);
								$row=mysql_fetch_array($result);echo $row['intInvoiceno']?>" disabled="disabled" >
                    
		
				
                  </select></td>
                  <td width="2%">&nbsp;</td>
                  <td width="8%">Delivery No </td>
                  <td width="12%"><select name="cboDelivery" style="width:100px" id="cboDelivery" class="txtbox" onchange="setbydelivery(this);">
                     <?php
				$SQL = " SELECT 	intIOUNo,intDeliveryNo FROM tbliouheader WHERE intSettled=1 ";
		
				$result = $db->RunQuery($SQL);
		
				echo "<option value=\"". "" ."\">" . "" ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"". $row["intIOUNo"] ."\">" . $row["intDeliveryNo"] ."</option>" ;
				}
			?>
                  </select></td>
                  <td width="8%">B/L No </td>
                  <td width="14%"><input name="txtBL" readonly="readonly" class="txtbox" id="txtBL" style="width:100px" ></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>SE No </td>
                  <td><input name="txtSEno" type="text" class="txtbox" id="txtSEno" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="10" /></td>
                  <td>&nbsp;</td>
                  <td>Entry No </td>
                  <td><input name="txtClrShading2224" type="text" class="txtbox" id="txtClrShading2224" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="10" /></td>
                  <td>&nbsp;</td>
                  <td>Inv Date </td>
                  <td><input name="txtCurrentDate" style="width:100px" id="txtCurrentDate" class="txtbox" value="<?php echo date('Y/m/d');?>">
                    </td>
                  <td>Due Date </td>
                 <td> <input name="txtduedate" type="text" class="txtbox" id="txtVoyageDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('Y/m/d');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"></td>
                 <!-- <td><select name="select23" style="width:100px" id="select23" class="txtbox">
                    <option value="0" selected="selected"></option>
                    <option value="1">A</option>
                    <option value="2">B</option>
                    <option value="3">C</option>
                    <option value="4">D</option>
                  </select></td>-->
                </tr>
              </table></td>
		      </tr>
		    <tr>
              <td height="35"><table width="100%" class="bcgl1">
                  <tr>
                    <td colspan="7" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="normalfnt">Consignee</td>
                        <td class="normalfnt" width="37%" class="normalfnt"><input name="txtConsignee" readonly="readonly" class="txtbox" id="txtConsignee" style="width:289px" ></td>
                        <td class="normalfnt">Exporter</td>
                         <td width="32%" class="normalfnt"><input name="txtExporter" readonly="readonly" class="txtbox" id="txtExporter" style="width:285px" ></td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Forwader</td>
                        <td class="normalfnt"><input name="txtForwader" readonly="readonly" class="txtbox" id="txtForwader" style="width:289px"></td>
                        <td class="normalfnt">Wharf Clerk </td>
                        <td class="normalfnt"><input name="txtClerk" class="txtbox" readonly="readonly" id="txtClerk" style="width:285px" ></td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Vessel / Flight </td>
                        <td class="normalfnt"><table width="85%" cellspacing="0">
                            <tr>
                              <td width="31%"><input name="txtVessel" type="text" class="txtbox" id="txtVessel" readonly="readonly" size="15" /></td>
                              <td width="28%" align="center">No Of PKGS </td>
                              <td width="41%"><input name="txtPKGS"  type="text" class="txtbox" id="txtPKGS" readonly="readonly" size="14" /></td>
                            </tr>
                        </table></td>
                        <td class="normalfnt">Merchandiser</td>
                        <td class="normalfnt"><table width="100%" readonly="readonly" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="41%"><input name="txtMerchandiser" type="text" readonly="readonly" class="txtbox" id="txtMerchandiser" size="46" /></td>
                            </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Reason For Dupplicate </td>
                        <td class="normalfnt"><input name="txtReason" readonly="readonly" type="text" class="txtbox" id="txtReason" size="46" /></td>
                        <td class="normalfnt">&nbsp;</td>
                        <td class="normalfnt">&nbsp;</td>
                      </tr>
                      
                    </table></td>
                    </tr>
                  
              </table></td>
		      </tr>
		    <tr>
             <td height="35"><table width="100%" class="bcgl1"  cellspacing="1">
                  <tr>
                    <td class="normalfnt"><table width="900" cellpadding="0"  id="tbliou">
                      <tr>
                        <td width="2%" bgcolor="#498CC2" class="normaltxtmidb2">&nbsp;</td>
                        <td width="3%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">Id</td>
                        <td width="18%" bgcolor="#498CC2" class="normaltxtmidb2">Expenses</td>
                        <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2">Estimate</td>
                        <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Actual</td>
                        <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Ex/Short</td>
                        <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Invoice</td>
                        </tr>
                      <!--<tr>
                        <td    class="normalfnt">&nbsp;</td>
                        <td    class="normalfnt">1</td>
                        <td    class="normalfnt"> 10 </td>
                        <td    class="normalfnt">10</td>
                        <td    class="normalfnt">110</td>
                        <td    class="normalfnt">10</td>
                        <td    class="normalfnt">10</td>
                        </tr>-->
                      <tr>
                        <td    class="normalfnt">&nbsp;</td>
                        <td    class="normalfnt">&nbsp;</td>
                        <td    class="normalfnt">&nbsp;</td>
                        <td    class="normalfnt">&nbsp;</td>
                        <td    class="normalfnt">&nbsp;</td>
                        <td    class="normalfnt">&nbsp;</td>
                        <td    class="normalfnt">&nbsp;</td>
                      </tr>
                    </table></td>
                    </tr>
              </table></td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      </tr>
		</table>
		</div>		</td>
        </tr>
    </table></div>
			<div id="tabs-2"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="89%" bgcolor="#9BBFDD" class="head1">Un-Paid Invoices </td>
        <td width="11%" bgcolor="#9BBFDD" class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td height="280" colspan="2" class="normalfnt">
		<div id="divcons" style="overflow:hidden; height:280px; width:100%px;">
		<table width="100%" height="293" class="bcgl1">
		  <tr>
            <td height="15">&nbsp;</td>
		    <td>&nbsp;</td>
		    <td width="196" >&nbsp;</td>
		    <td >&nbsp;</td>
		    <td width="163" >&nbsp;</td>
		    <td width="225" >&nbsp;</td>
		    <td >&nbsp;</td>
		    </tr>
		  <tr>
            <td height="15">&nbsp;</td>
		    <td>Customer</td>
		    <td ><select name="select6" class="txtbox" id="select6" style="width:285px" onchange="ShowItems()">
              <?php
				$SQL = 	"SELECT  DISTINCT ".
                      	"P.intPONo  AS dd, P.intPONo, S.strTitle, P.intYear, concat(P.intYear , '/' , P.intPONo , ' -- ' , S.strTitle) AS ListF, ".
                      	"concat(P.intYear  ,'/', P.intPONo) AS NPONO, P.strPINO, P.intDelToCompID ".
						"FROM         purchaseorderdetails PO INNER JOIN ".
                      	"purchaseorderheader P ON PO.intPONo = P.intPONo AND PO.intYear = P.intYear INNER JOIN ".
                      	"suppliers S ON P.strSupplierID = S.strSupplierID ".
						"WHERE     (P.intStatus = 10) AND (P.intDelToCompID = ".$_SESSION["intUserComp"].") ";
				
				if($pub_active!=1)
					$SQL .=" AND (PO.dblPending > 0) ";
				
				$SQL .= " order by P.intYear, P.intPONo";
				
				$result = $db->RunQuery($SQL);
				echo "<option value=\"". "" ."\">" . "" ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"". $row["NPONO"] ."\">" . trim($row["ListF"]) ."</option>" ;
				}
			?>
            </select></td>
		    <td >Invoice No </td>
		    <td ><select name="select7" class="txtbox" id="select7" style="width:285px" onchange="ShowItems()">
              <?php
				$SQL = 	"SELECT  DISTINCT ".
                      	"P.intPONo  AS dd, P.intPONo, S.strTitle, P.intYear, concat(P.intYear , '/' , P.intPONo , ' -- ' , S.strTitle) AS ListF, ".
                      	"concat(P.intYear  ,'/', P.intPONo) AS NPONO, P.strPINO, P.intDelToCompID ".
						"FROM         purchaseorderdetails PO INNER JOIN ".
                      	"purchaseorderheader P ON PO.intPONo = P.intPONo AND PO.intYear = P.intYear INNER JOIN ".
                      	"suppliers S ON P.strSupplierID = S.strSupplierID ".
						"WHERE     (P.intStatus = 10) AND (P.intDelToCompID = ".$_SESSION["intUserComp"].") ";
				
				if($pub_active!=1)
					$SQL .=" AND (PO.dblPending > 0) ";
				
				$SQL .= " order by P.intYear, P.intPONo";
				
				$result = $db->RunQuery($SQL);
				echo "<option value=\"". "" ."\">" . "" ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"". $row["NPONO"] ."\">" . trim($row["ListF"]) ."</option>" ;
				}
			?>
            </select></td>
		    <td ><img src="../../images/search.png" alt="search" name="butSave" width="80" height="24" class="mouseover" id="butSave" onclick="SaveFabricInspection();" /></td>
		    <td >&nbsp;</td>
		    </tr>
		  <tr>
            <td width="61" height="15">&nbsp;</td>
		    <td width="113">&nbsp;</td>
		    <td >&nbsp;</td>
		    <td width="122" >&nbsp;</td>
		    <td >&nbsp;</td>
		    <td >&nbsp;</td>
			<td >&nbsp;</td>
		  </tr>
		<tr>
		<td height="45" colspan="6" ><table width="900" cellpadding="0" cellspacing="0" id="tblMainGrn">
          <tr>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">&nbsp;</td>
            <td width="12%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">Customer </td>
            <td width="21%" bgcolor="#498CC2" class="normaltxtmidb2">IOU No </td>
            <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">Invoice No </td>
            <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Amount</td>
            <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Invoiced</td>
            <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Due Date </td>
            <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Rec.Amt</td>
            <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Balance </td>
            <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">Cheque No </td>
            </tr>
			<tr>
              <td    class="normalfnt">&nbsp;</td>
              <td    class="normalfnt">1</td>
              <td    class="normalfnt"> Description </td>
              <td    class="normalfnt">Unit</td>
              <td    class="normalfnt">500</td>
              <td    class="normalfnt">1200</td>
              <td    class="normalfnt">250</td>
              <td    class="normalfnt">22</td>
			  <td    class="normalfnt">22</td>
              <td    class="normalfnt">254</td>
           </tr>

		  </table></td>
		<td width="28" >&nbsp;</td>
		</tr>
		<tr>
		  <td colspan="6" >&nbsp;</td>
          <td >&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="6" >&nbsp;</td>
          <td >&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="6" >&nbsp;</td>
          <td >&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="6" >&nbsp;</td>
          <td >&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="6" >&nbsp;</td>
          <td >&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="6" >&nbsp;</td>
          <td height="22" >&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="6" >&nbsp;</td>
          <td >&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="6" >&nbsp;</td>
          <td >&nbsp;</td>
		  </tr>
		</table>
		</div>		</td>
        </tr>
    </table></div>
		<div id="tabs-3"  height:280px ><table width="100%" height="280" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="95%" height="17" bgcolor="#9BBFDD" class="normalfnth2"><div align="left" class="head1">Paid Invoices </div></td>
        <td width="5%" bgcolor="#9BBFDD" class="normalfnth2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><div id="divLotInterface" style=" overflow:scroll; width:100%; height:260px" >
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="5%" class="normalfnt">&nbsp;</td>
              <td width="12%" class="normalfnt">&nbsp;</td>
              <td width="13%" class="normalfnt">&nbsp;</td>
              <td width="10%" class="normalfnt">&nbsp;</td>
              <td width="11%" class="normalfnt">&nbsp;</td>
              <blockquote>&nbsp;</blockquote>
              <td width="9%" class="normalfnt">&nbsp;</td>
              <td width="11%" class="normalfnt">&nbsp;</td>
              <td width="9%" class="normalfnt">&nbsp;</td>
              <td width="14%" class="normalfnt">&nbsp;</td>
              <td width="6%" class="normalfnt">&nbsp;</td>
            </tr>
            <tr>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">&nbsp;</td>
            </tr>
          </table>	 		  
		  <blockquote>&nbsp;</blockquote>
        </div>
		  
		  </p></td>
      </tr>
    </table>
			
		
		</div>
		<div id="tabs-4"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="89%" bgcolor="#9BBFDD" class="head1">Payment</td>
        <td width="11%" bgcolor="#9BBFDD" class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td height="280" colspan="2" class="normalfnt">
		<div id="divcons" style="overflow:hidden; height:280px; width:100%px;">
		<table width="100%" height="293" class="bcgl1">
		  <tr>
            <td height="15" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="ui-state-focus">
              <tr>
                <td width="6%">&nbsp;</td>
                <td width="15%">Payment Date </td>
                <td width="24%"><input name="txtClrShading223323243222" type="text" class="txtbox" id="txtClrShading223323243222" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="30" maxlength="10" /></td>
                <td width="3%">&nbsp;</td>
                <td width="15%">Amount Paid </td>
                <td width="28%"><input name="txtClrShading223323243225" type="text" class="txtbox" id="txtClrShading223323243225" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="30" maxlength="10" /></td>
                <td width="9%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>Amount</td>
                <td><input name="txtClrShading223323243223" type="text" class="txtbox" id="txtClrShading223323243223" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="30" maxlength="10" /></td>
                <td>&nbsp;</td>
                <td>Balance Amount </td>
                <td><input name="txtClrShading223323243226" type="text" class="txtbox" id="txtClrShading223323243226" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="30" maxlength="10" /></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>Cheque No </td>
                <td><input name="txtClrShading223323243224" type="text" class="txtbox" id="txtClrShading223323243224" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="30" maxlength="10" /></td>
                <td>&nbsp;</td>
                <td>IOU No </td>
                <td><select name="select19" style="width:150px" id="select19" class="txtbox">
                  <option value="0" selected="selected"></option>
                </select></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>Delivery No </td>
                <td><input name="txtClrShading22332324322" type="text" class="txtbox" id="txtClrShading22332324322" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="30" maxlength="10" /></td>
                <td>&nbsp;</td>
                <td>B/L No </td>
                <td><input name="txtClrShading223323243227" type="text" class="txtbox" id="txtClrShading223323243227" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="30" maxlength="10" /></td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
		    </tr>
		<tr>
		<td width="66" height="45" ><table width="526" cellpadding="0" cellspacing="0" id="tblMainGrn">
          <tr>
            <td width="2%" bgcolor="#498CC2" class="normaltxtmidb2">&nbsp;</td>
            <td width="3%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">Inv No </td>
            <td width="18%" bgcolor="#498CC2" class="normaltxtmidb2">Pay.amt</td>
            <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2">Cheque No </td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Date</td>
            </tr>
			<tr>
              <td    class="normalfnt">&nbsp;</td>
              <td    class="normalfnt">1</td>
              <td    class="normalfnt"> Description </td>
              <td    class="normalfnt">Unit</td>
              <td    class="normalfnt">500</td>
              </tr>

		  </table></td>
		<td width="33" >&nbsp;</td>
		</tr>
		<tr>
		  <td >&nbsp;</td>
          <td >&nbsp;</td>
		  </tr>
		<tr>
		  <td >&nbsp;</td>
          <td >&nbsp;</td>
		  </tr>
		<tr>
		  <td >&nbsp;</td>
          <td >&nbsp;</td>
		  </tr>
		<tr>
		  <td >&nbsp;</td>
          <td >&nbsp;</td>
		  </tr>
		<tr>
		  <td >&nbsp;</td>
          <td >&nbsp;</td>
		  </tr>
		<tr>
		  <td >&nbsp;</td>
          <td height="22" >&nbsp;</td>
		  </tr>
		<tr>
		  <td >&nbsp;</td>
          <td >&nbsp;</td>
		  </tr>
		<tr>
		  <td >&nbsp;</td>
          <td >&nbsp;</td>
		  </tr>
		</table>
		</div>		</td>
        </tr>
    </table></div></div>
		</td>
		</tr>
    </table>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
      <tr>
      	<td width="6%">&nbsp;</td>
        <td width="12%" height="29">&nbsp;</td>
        <td width="12%"><img src="../../images/new.png" alt="new" name="butNew" width="84" height="24" class="mouseover"  id="butNew" onclick="frmReload();"/></td>
        <td width="12%"><img src="../../images/cancel.jpg" width="84" height="24" onclick="frmReload();" /></td>
        <td width="12%"><img src="../../images/save.png" alt="save" name="butSave" width="84" height="24" class="mouseover" id="butSave" onclick="updateiou('save');" /></td>
        <td width="12%"><img src="../../images/report.png" alt="butReportList" name="butReportList" width="84" height="24" class="mouseover" id="butReport" onclick="printthis();"/></td>
        <td width="12%"><a href="../../main.php"><img src="../../images/close.png" width="84" height="24" border="0" class="mouseover"  /></a></td>
        
        <td width="12%"><label></label></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<div style="  width: 200px; visibility:hidden; height:70 2px;" id="confirmReport" >
<table border=0><tr><td height="55" align="center"><h3>Saving......</h3>
</body>
</html>