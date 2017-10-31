<?php
	session_start();
	

	include("../../Connector.php");
	$backwardseperator = "../../";
	$companyID=$_SESSION["FactoryID"];
	$listForwarderId=$_GET['forwarderId'];
	$listInvoiceNo=$_GET['invoiceNo'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web - Forwarder Invoice</title>


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
<script src="ForwaderInvoice.js" type="text/javascript"></script>


<link type="text/css" href="../../css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.7.2.custom.min.js"></script>

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

<style type="text/css">


<!--
body {
	background-color: #CCCCCC;
	
}


<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->

.tableGrid{
	border:1px solid #cccccc;
}

.tableGrid thead{
	background-color:#7cabc4;
	text-align:center;
	color:#ffffff;
	padding:10px 5px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:11px;
}

.tableGrid tbody{
	background-color:#e3e9ec;
	text-align:left;
	color:#333333;
	padding:4px;
}
</style>
</head>
<?php
$xml = simplexml_load_file('../../config.xml');
$Declarant = $xml->companySettings->Declarant; 
$Destination = $xml->companySettings->Country; 
?>
<?php
$country="";
$sqlcountry="SELECT strCountryCode,strCountry FROM country ORDER BY strCountry";
$result_country=$db->RunQuery($sqlcountry);
		$country .= "<option value=\"".""."\">".""."</option>";		
	while($row_country=mysql_fetch_array($result_country))
	{
		$country .= "<option value=\"".$row_country["strCountryCode"]."\">".$row_country["strCountry"]."</option>";
	} 
?>

<body <?php if($listForwarderId!=''){ ?>onload="loadListData(<?php echo $listForwarderId ; ?>,'<?php echo $listInvoiceNo ; ?>')" <?php } ?> >
<table width="950" border="0" align="center" bgcolor="#FFFFFF" cellspacing="0">
	<tr>
    	<td><?php include '../../Header.php'; ?></td>
	</tr>
  	<tr>
    	<td>
<form name="frmFabricIns" id="frmFabricIns" >
<table width="850" height="150" border="0" align="center" bgcolor="#FFFFFF" cellspacing="0">
	<tr>
    	<td></td>
	</tr>
  	<tr>
    	<td bgcolor="#316895" class="TitleN2white" style="text-align:center">&nbsp;Forwarder Invoice </td>
    </tr>
  	<tr>
    	<td>
			<table align="center" width="822" style="margin-top:15px;"  class="normalfnt">
				
				<tr>
					<td width="116" class="normalfnt">Search Forwarder</td>
				  <td colspan="3">
				  <select id="cboSearchForwader" name="cboSearchForwader" style="width:403px" class="normalfnt" onchange="loadSavedInvoices();">
				  <option value="0"></option>
				  <?php
				  	$sql="SELECT DISTINCT
							forwaders.strName,
							forwader_invoice_header.intForwaderId
							FROM
							forwader_invoice_header
							INNER JOIN forwaders ON forwader_invoice_header.intForwaderId = forwaders.intForwaderID
							;";
					$result=$db->RunQuery($sql);
						while($row=mysql_fetch_array($result))
						{
				  ?>
				  <option value="<?php echo $row['intForwaderId']; ?>"><?php echo $row['strName']; ?></option>
				  <?php
				 		 }
				  ?>
				  </select></td>
					<td width="96" class="normalfnt">Search Invoice</td>
				  <td width="170">
				  <select style="width:168px" id="cboSearchInv" name="cboSearchInv" class="normalfnt" onchange="loadSavedData();" disabled="disabled">
				  <option value="0"></option>
				  </select>				  </td>
				</tr>
				
				<tr>
					<td width="116" class="normalfnt">Forwarder</td>
				  <td colspan="3">
				  <select id="cboForwader" name="cboForwader" style="width:403px" class="normalfnt" onchange="loadGrid();">
				  <option value="0"></option>
				  	<?php
						$sql="SELECT intForwaderID,strName FROM forwaders ORDER BY strName ;"; 
						$result=$db->RunQuery($sql);
						while($row=mysql_fetch_array($result))
						{
					?>
					<option value="<?php echo $row['intForwaderID']; ?>"><?php echo $row['strName']; ?></option>
					<?php
						}
					?>
				  </select></td>
					<td width="96" class="normalfnt">Carrier</td>
				  <td width="170">
				  <select style="width:168px" id="cboCarrier" name="cboCarrier" class="normalfnt" onchange="loadGrid();">
				  <option value=""></option>
				  <?php
				  	$sql="SELECT DISTINCT strCarrier from commercial_invoice_header
ORDER BY strCarrier";
					$result=$db->RunQuery($sql);
					while($row=mysql_fetch_array($result))
					{ 
				  ?>
				  <option value="<?php echo $row['strCarrier']; ?>"><?php echo $row['strCarrier']; ?></option>
				  <?php
				  	}
				  ?>
				  </select>				  </td>
				</tr>
				<tr>
					<td width="116" class="normalfnt">Forw. Invoice No</td>
				  <td colspan="3"><input type="text" class="txtbox" style="width:150px" id="txtForInvNo" name="txtForInvNo" /></td>
					<td width="96" class="normalfnt">Amount</td>
				  <td width="170"><input type="text" class="txtbox" style="width:168px; text-align:right" id="txtAmount" name="txtAmount" onkeypress="return CheckforValidDecimal(this.value,2,event);" /></td>
				</tr>
				<tr>
					<td width="116" class="normalfnt">Date</td>
			      <td width="170"><input name="txtDate" tabindex="2" type="text" class="txtbox" id="txtDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
				  
					<td width="72" class="normalfnt">Cheque No </td>
			      <td width="170"><input type="text" class="txtbox" style="width:150px;" id="txtChequeNo" name="txtChequeNo" disabled="disabled" /></td>
					<td width="96" class="normalfnt">Paid Amount </td>
					<td width="170"><input type="text" class="txtbox" style="width:168px; text-align:right; " id="txtPaidAmt" name="txtPaidAmt" disabled="disabled" onkeypress="return CheckforValidDecimal(this.value,2,event);" value="0" /></td>
				</tr>
				<tr>
				  <td class="normalfnt">For.Inv. Submit </td>
				  <td><input type="checkbox" id="chk_forInvSubmit" name="chk_forInvSubmit" /></td>
				  <td class="normalfnt">Submit Date </td>
				  <td><input name="txtSubInvDate" tabindex="2" type="text" class="txtbox" id="txtSubInvDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
				  <td class="normalfnt">&nbsp;</td>
				  <td>&nbsp;</td>
			    </tr>
		  </table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
			<div align="center">
				<div align="center" style="width:600px; height:200px; overflow:scroll; margin-top:25px; margin-bottom:25px;">
					<table align="center" width="580" class="tableGrid" id="tbl_forwaderInvDetails">
						<thead>	
							<tr>
								<td>Select</td>						
								<td>CUSDEC No</td>
								<td>BPO No</td>
								<td>Invoice No</td>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
		</td>
	</tr>
	<tr>
    	<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
         
          <tr>
            <td width="6%" bgcolor="#D6E7F5">&nbsp;</td>
            <td width="6%" bgcolor="#D6E7F5">&nbsp;</td>
            <td width="9%" bgcolor="#D6E7F5">&nbsp;</td>
            <td width="6%" bgcolor="#D6E7F5">&nbsp;</td>
            <td width="8%" bgcolor="#D6E7F5">&nbsp;</td>
            <td width="12%" bgcolor="#D6E7F5"><img src="../../images/new.png" alt="new" name="butNew" width="" height="24" class="mouseover"  id="butNew" onclick="clearForm();"/></td>
            <td width="9%" bgcolor="#D6E7F5"><img src="../../images/save.png" alt="new" name="butIouSave" width="84" height="24" class="mouseover"  id="butIouSave" onclick="validateData();"/></td>
            <td width="10%" bgcolor="#D6E7F5"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
            <td width="34%" bgcolor="#D6E7F5">&nbsp;</td>
          </tr>
        </table>
		</td>
	</tr>
</table>
</form>
</td>
</tr>
</table>