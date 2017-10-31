<?php
	session_start();
	include("../../../Connector.php");
	$backwardseperator = "../../../";
	include $backwardseperator."authentication.inc";
	include "../../../eshipLoginDB.php";
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro : : Pre-Shipment Invoice</title>
<link href="../../../js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
	<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
	<link href="../../../css/tableGrib.css" rel="stylesheet" type="text/css" />
    <link href="../../../javascript/calendar/theme.css" rel="stylesheet" type="text/css" />
    
	<!--<link href="../../css/JqueryTabs.css" rel="stylesheet" type="text/css" />-->
   <style type="text/css">
<!--
.bcgcolor-Red {
	background-color: #FF0000;
}

-->
</style> 
	<script type="text/javascript" src="../../../js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="../../../javascript/script.js"></script>
   <script type="text/javascript" src="../../../javascript/calendar/calendar.js"></script>
   <script type="text/javascript" src="../../../javascript/calendar/calendar-en.js"></script>
	<!--<script type="text/javascript" src="../../js/jquery-ui-1.7.2.custom.min.js"></script>-->
   <!-- <script type="text/javascript" src="../../js/jquery-ui-1.8.9.custom.min.js"></script>
	<script type="text/javascript" src="../../js/tablegrid.js"></script>-->
	<script type="text/javascript" src="commercialinvoice.js"></script>

	<script type="text/javascript">
		$(function(){
			// TABS
			$('#tabs').tabs();
		});
	</script>
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

<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td><?php include '../../../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="920" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <th class="mainHeading" height="20">Pre-Shipment Invoice</th>
      </tr>
      <tr>
        <td>
        <div  id="tabs" style="background-color:#FFFFFF">
        <ul>
            <li><a href="#tabs-1" class="normalfnt">Shipment Data</a></li>
            <li><a href="#tabs-2" class="normalfnt" onclick="checkInvoiceNo();" >Description of Article</a></li>
        </ul>
        <div id="tabs-1" >
		<form name="frmShipmentData" id="frmShipmentData">
		<table width="100%" border="0" cellspacing="0" cellpadding="2" >
  <tr>
    <td class="mainHeading2">Shipment Data</td>
  </tr>
  <tr>
    <td class="tableBorder" ><table width="100%" border="0" cellspacing="0" cellpadding="3" class="normalfnt">
      <tr>
        <td colspan="6"></td>
      </tr>
      <tr>
        <td>Invoice No</td>
        <td><select name="cboInvoiceNo" class="txtbox" onchange="loadData(this.value);" id="cboInvoiceNo"  style="width:180px;">
		 <option value=""></option>
		  <?php
				$sql = "select intInvoiceNo,strInvoice from shipping_pre_inv_header order by strInvoice";
				$result = $db->RunQuery($sql);
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=".$row["intInvoiceNo"].">".$row['strInvoice']."</option>\n";
				}
			?>
        </select></td>
        <td>Date<span style="color:#F00">*</span></td>
        <td><input name="txtInvoiceDate" tabindex="16" type="text" class="txtbox" id="txtInvoiceDate" style="width:70px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset1" type="text"  class="txtbox" style="visibility:hidden;width:1px;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
        <td>SDP<span style="color:#F00">*</span></td>
        <td><select name="cboSDP" id="cboSDP" onchange="loadComInvData(this.value);" style="width:180px;">
          <option value=""></option>
          <?php
				$sql = "select intSDPID,strSDP_Title from shipping_sdp order by strSDP_Title";
				$result = $db->RunQuery($sql);
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=".$row["intSDPID"].">".$row['strSDP_Title']."</option>\n";
				}
			?>
        </select></td>
      </tr>
      <tr>
        <td>Consignee<span style="color:#F00">*</span></td>
        <td><select name="cboConsignee" class="txtbox" onchange="" id="cboConsignee"  style="width:180px;">
		<option value=""></option>
			<?php
				$sql_destination = "select intBuyerBranchId,strBranchName from finishing_buyer_branch_network order by strBranchName ";

				$result = $db->RunQuery($sql_destination);
				while($row = mysql_fetch_array($result))
				{
					 echo "<option value=".$row['intBuyerBranchId'].">".$row['strBranchName']."</option>";
				}
			?>
        </select></td>
        <td>Exporter<span style="color:#F00">*</span></td>
        <td><select name="cboExporter" class="txtbox" onchange="" id="cboExporter"  style="width:180px;">
		<option value=""></option>
			<?php
				$sql_destination = "select intCompanyID,strName from companies where intManufacturing!=1 order by strName; ";

				$result = $db->RunQuery($sql_destination);
				while($row = mysql_fetch_array($result))
				{
					 echo "<option value=".$row['intCompanyID'].">".$row['strName']."</option>";
				}
			?>
        </select></td>
        <td>Manufacturer<span style="color:#F00">*</span></td>
        <td><select name="cboManufacturer" class="txtbox" onchange="" id="cboManufacturer"  style="width:180px;">
		<option value=""></option>
              <?php
				$sql_destination = "select intCompanyID,strName from companies where intManufacturing=1 order by strName; ";

				$result = $db->RunQuery($sql_destination);
				while($row = mysql_fetch_array($result))
				{
					 echo "<option value=".$row['intCompanyID'].">".$row['strName']."</option>";
				}
			?>
        </select></td>
      </tr>
      <tr>
        <td nowrap="nowrap">Port of Loading<span style="color:#F00">*</span></td>
        <td><select name="cboPortOfLoading" class="txtbox" id="cboPortOfLoading"  style="width:180px;">
          <option value=""></option>
          <?php
				$sql_destination = "select intCityID,strCityName,strPort from finishing_final_destination 
									order by strCityName ";

				$result = $db->RunQuery($sql_destination);
				while($row = mysql_fetch_array($result))
				{
					 echo "<option value=".$row['intCityID'].">".$row['strCityName']." --> ".$row['strPort']."</option>";
				}
			?>
        </select></td>
        <td>Mode<span style="color:#F00">*</span></td>
        <td><select name="cboTransportMode" class="txtbox" id="cboTransportMode"  style="width:180px;">
          <option value=""></option>
          <?php
				 $sql="SELECT * FROM shipmentmode where intStatus='1' order by intShipmentModeId";
				 $result = $db->RunQuery($sql);
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=".$row["intShipmentModeId"].">".$row["strDescription"]."</option>\n";
				}
				?>
        </select></td>
        <td>Destination<span style="color:#F00">*</span></td>
        <td><select name="cboDestination" class="txtbox" id="cboDestination"  style="width:180px;">
          <option value=""></option>
          <?php
				$sql_destination = "select intCityID,strCityName,strPort from finishing_final_destination 
									order by strCityName ";

				$result = $db->RunQuery($sql_destination);
				while($row = mysql_fetch_array($result))
				{
					 echo "<option value=".$row['intCityID'].">".$row['strCityName']." --> ".$row['strPort']."</option>";
				}
			?>
        </select></td>
      </tr>
      <tr>
        <td>Incoterm<span style="color:#F00">*</span></td>
        <td><select name="cboIncoterm" class="txtbox" id="cboIncoterm"  style="width:180px;">
          <option value=""></option>
          <?php
			 $sql_shipmentterm = "select strShipmentTermId,strShipmentTerm from shipmentterms where intStatus = 1
			 					  order by strShipmentTerm ";
			 $result = $db->RunQuery($sql_shipmentterm);
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=".$row["strShipmentTermId"].">".$row["strShipmentTerm"]."</option>\n";
				}
			?>
        </select></td>
        <td>Pay Term<span style="color:#F00">*</span></td>
        <td><select name="cboPaymentTerm" class="txtbox" id="cboPaymentTerm"  style="width:180px;">
          <option value=""></option>
          <?php
				$sql_payTerm = "select strPayTermId,strDescription from popaymentterms where intStatus = 1 order by strDescription ;";
				$result = $db->RunQuery($sql_payTerm);
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=".$row["strPayTermId"].">".$row["strDescription"]."</option>\n";
				}
			?>
        </select></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Bank<span style="color:#F00">*</span></td>
        <td><select name="cboBank" class="txtbox" id="cboBank"  style="width:180px;">
          <option value=""></option>
          <?php
				$sql_bank = "select intBranchId,strName from branch where intStatus = 1 order by strName";
				$result = $db->RunQuery($sql_bank);
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=".$row["intBranchId"].">".$row["strName"]."</option>\n";
				}
			?>
        </select></td>
        <td>Declaration</td>
        <td>EX
          <select name="cboDeclaration" type="text" id="cboDeclaration" class="txtbox" style="width:50px" tabindex="13">
            <option value="3">3</option>
            <option value="1">1</option>
          </select></td>
        <td nowrap="nowrap">Office of Entry</td>
        <td><select name="cboOfficeEntry"  class="txtbox" id="cboOfficeEntry" style="width:180px">
          <option value=""></option>
          <option value="CBIF1">CBIF1</option>
          <option value="CBEX1">CBEX1</option>
          <option value="KTEX1">KTEX1</option>
          <option value="CBBE1">CBBE1</option>
          <option value="CBBE2">CBBE2</option>
        </select></td>
      </tr>
      <tr>
        <td>Carrier<span style="color:#F00">*</span></td>
        <td><input name="txtCarrier" tabindex="4" type="text" class="txtbox" id="txtCarrier"  style="width:180px" maxlength="50" /></td>
        <td>Voyage No</td>
        <td><input name="txtVoyage" tabindex="4" type="text" class="txtbox" id="txtVoyage"  style="width:180px" maxlength="50" /></td>
        <td>ETD &amp; ETA<span style="color:#F00">*</span></td>
        <td nowrap="nowrap"><input name="txtETD" tabindex="16" type="text" class="txtbox" id="txtETD" style="width:78px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset4" type="text"  class="txtbox" style="visibility:hidden;width:1px;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" />
          <input name="txtETA" tabindex="16" type="text" class="txtbox" id="txtETA" style="width:78px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset5" type="text"  class="txtbox" style="visibility:hidden;width:1px;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
      </tr>
      <tr>
        <td>Currency<span style="color:#F00">*</span></td>
        <td><select name="cboCurrency" class="txtbox" onchange="" id="cboCurrency"  style="width:180px;">
		<option value=""></option>
              <?php
				$sql_destination = "select intCurID,strCurrency from currencytypes where intStatus=1 order by strCurrency; ";

				$result = $db->RunQuery($sql_destination);
				while($row = mysql_fetch_array($result))
				{
					 echo "<option value=".$row['intCurID'].">".$row['strCurrency']."</option>";
				}
			?>
        </select></td>
        <td>Local Currency<span style="color:#F00">*</span></td>
        <td><select name="cboLocalCurrency" class="txtbox" onchange="" id="cboLocalCurrency"  style="width:180px;">
		<option value=""></option>
              <?php
				$sql_destination = "select intCurID,strCurrency from currencytypes where intStatus=1 order by strCurrency; ";

				$result = $db->RunQuery($sql_destination);
				while($row = mysql_fetch_array($result))
				{
					 echo "<option value=".$row['intCurID'].">".$row['strCurrency']."</option>";
				}
			?>
        </select></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Insurance</td>
        <td><input name="txtInsurance" tabindex="4" type="text" class="txtbox" id="txtInsurance"  style="width:180px" maxlength="50" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
        <td>Freight</td>
        <td><input name="txtFreight" tabindex="4" type="text" class="txtbox" id="txtFreight"  style="width:180px" maxlength="50"  onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="" /></td>
        <td>Other</td>
        <td><input name="txtOther" tabindex="4" type="text" class="txtbox" id="txtOther"  style="width:180px" maxlength="50" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
      </tr>
      <tr>
        <td>Wharf clerk</td>
        <td ><select name="cboWharfClerk" class="txtbox" onchange="" id="cboWharfClerk"  style="width:180px;">
		<option value=""></option>
              <?php
				$sql_destination = "select intUserID,Name from useraccounts where status=1 order by Name; ";

				$result = $db->RunQuery($sql_destination);
				while($row = mysql_fetch_array($result))
				{
					 echo "<option value=".$row['intUserID'].">".$row['Name']."</option>";
				}
			?>
        </select></td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="4"></td>
  </tr>
  <tr>
  <td class="tableBorder"><table width="100%" cellpadding="2" cellspacing="0" >
    <tr>
      <td align="center"><img src="../../../images/new.png" width="96" height="24" onclick="clearFormData();rptButtonDis();" /><img src="../../../images/save.png" width="84" height="24" id="butSave" name="Save" onclick="saveData(<?php echo $preInvoiceNo; ?>);" /><img src="../../../images/delete.png" id="butDelete" onclick="deleteData();" /><img src="../../../images/report.png" name="butReport" class="mouseover" id="butReport" onclick="expCusReport();" style="display:none"/><a href="../../../main.php"><img src="../../../images/close.png" width="97" height="24" border="0" /></a></td>
    </tr>
  </table></td>
  </tr>
  </table>
</form>
</div>

        <div id="tabs-2">
		<form name="frmDescripOfArticle" id="frmDescripOfArticle">
		  <table width="100%" border="0" cellspacing="0" cellpadding="2">
		    <tr>
		      <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableBorder" >
		        <tr>
		          <td width="16%" class="mainHeading2" style="text-align:center">&nbsp;</td>
		          <td width="8%" class="mainHeading2" style="text-align:center">&nbsp;</td>
		          <td width="9%" class="mainHeading2" style="text-align:center">&nbsp;</td>
		          <td width="33%" class="mainHeading2" style="text-align:center"> Description of Article</td>
		          <td width="33%" class="mainHeading2" style="text-align:right"><img src="../../../images/add-new.png" align="right" onclick="loadPOpup();" /></td>
		          </tr>
		        <tr>
		          <td colspan="6"><table width="100%" border="0" cellspacing="0" cellpadding="0" >
		            <tr>
		              <td width="90%"><div style="overflow: scroll; height: 250px; width:854px;" id="selectitem">
		                <table width="1100" border="0" cellspacing="1" cellpadding="2" bgcolor="#F6A828"  id="tblDescription" >
		                  <tr class="mainHeading4">
		                    <th width="13" >Del</th>
		                    <th width="48"  height="20" >PO No</th>
		                    <th width="46" >Style</th>
		                    <th width="74" >HS Code</th>
		                    <th width="31" >Qty</th>
		                    <th width="46" >Price</th>
		                    <th width="134" >Net Net Weight</th>
		                    <th width="98" >Net Weight</th>
		                    <th width="119" >Gross Weight</th>
		                    <th width="37" >CBM</th>
		                    <th width="76" >Package</th>
		                    <th width="50" >PL No</th>
		                    <th width="16" >&nbsp;</th>
		                    </tr>
		                  </table>
		                </div></td>
		              </tr>
		            </table></td>
		          </tr>
		        <tr>
		          <td colspan="6" height="3"></td>
		          </tr>
		        </table></td>
		      </tr>
		    <tr>
		      <td><table width="100%" cellpadding="2" cellspacing="2" class="tableBorder">
		        <tr>
		          <td align="center"><img src="../../../images/new.png" width="96" height="24" onclick="ClearTable('tblDescription');rptButtonDis();" /><img src="../../../images/save.png" width="84" height="24" id="butSave2" name="Save" onclick="saveDetailData();" /><img src="../../../images/delete.png" id="butDelete2" onclick="deleteDetailData();" /><img src="../../../images/report.png" name="butReport" class="mouseover" id="butReportDetail" onclick="expCusReport();" style="display:none"/><a href="../../../main.php"><img src="../../../images/close.png" width="97" height="24" border="0" /></a></td>
		          </tr>
		        </table></td>
		      </tr>
		    </table>
		</form>
        </div>  
        </div>
        </td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>