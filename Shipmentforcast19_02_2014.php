<?php
 session_start();
 include "authentication.inc";
 
$factory = $_POST["cboFactory"];
$buyer = $_POST["cboCustomer"];
$styleID = $_POST["cboStyles"];
$srNo = $_POST["cboSR"];

if ($factory != "Select One")
{
	$styleID = "Select One";
	$srNo = "Select One";
}

if ($_POST["txtStyle"] != "")
	$styleId = $_POST["txtStyle"];

$xml = simplexml_load_file('config.xml');

$EnableAdvancedBuyePO = $xml->BuyerPO->EnableAdvanceMode;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Style Buyer PO</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />

<script src="js/jquery-ui-1.7.2.custom.min.js" type="text/javascript"></script>
<link href="js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-ui-1.8.9.custom.min.js" type="text/javascript"></script>

<script src="javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="javascript/calendar/calendar-en.js" type="text/javascript"></script>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}

-->
</style>



<script type="text/javascript" src="javascript/aprovedPreoder.js"></script>
<script type="text/javascript" src="javascript/script.js"></script>
<script type="text/javascript" src="javascript/bom.js"></script>

<script type="text/javascript">

var index = 0;
var styles =new Array();
var message = "Following Style Numbers has been updated as completed.\n\n";

function resetCompanyBuyer()
{
	document.getElementById("cboFactory").value = "Select One";
	document.getElementById("cboCustomer").value = "Select One";
}

function submitForm()
{
	document.frmcomplete.submit();
}



</script>
<script type="text/javascript" src="Shipmentforcast.js"></script>
<script type="text/javascript" src="Shipmentforcastpopup.js"></script>
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
<link rel="stylesheet" type="text/css" media="all" href="js/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	function getdate(textboxID){
		new JsDatePick({
			useMode:2,
			target:textboxID,
			dateFormat:"%d-%m-%Y"
		});
	}
</script>
</head>

<body>
<form id="frmcomplete" name="frmcomplete" method="post" action="styleBuyerPO.php">
  <table width="950" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td><?php include $backseperator .'Header.php'; ?></td>
    </tr>
    <tr>
      <td><table width="100%" border="0">
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td width="4%"><div align="center"><img src="images/butt_1.png" width="15" height="15" /></div></td>
          <td width="96%" class="head1">Shipment Forcast</td>
        </tr>
        <tr>
          <td colspan="2"><table width="100%" border="0">
            <!--DWLayoutTable-->
            <tr>
              <td width="50%" height="21"><table width="931" border="0">
                <tr>
                  <td width="72" bgcolor="#99CCFF" class="txtbox">Buyer</td>
                  <td width="72" class="txtbox"><select name="cboBuyer" class="txtbox" id="cboBuyer" style="width:170px">
                    <option value="Select One" selected="selected">Select One</option>
                    <option value="M AND S" >M AND S</option>
                    <option value="NEXT" >NEXT</option>
                    <option value="TESCO" >TESCO</option>
                    <option value="DECATHLON" >DECATHLON</option>
                    <option value="ASDA" >ASDA</option>
                    <option value="FASHION LAB" >FASHION LAB</option>
                    <option value="LEVIS" >LEVIS</option>
                    <option value="SAINSBURY" >SAINSBURY</option>
                    <option value="FEILDING" >FEILDING</option>
                    <option value="ORIGINAL MARINES" >ORIGINAL MARINES</option>
                    <option value="NIKE" >NIKE</option>
                    <option value="BLUES" >BLUES</option>
					<?php
					
$xml = simplexml_load_file('config.xml');
$reportname = $xml->PreOrder->ReportName;

	include "Connector.php"; 
	$SQL = "";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
		if ($factory == $row["intCompanyID"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
		}
		else
		{
			echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
		}
	}
	
	?>
    
                  </select></td>
                  <td width="72" bgcolor="#99CCFF" class="txtbox">PO No</td>
                  <td width="72" class="txtbox"><select name="cboPoNo" class="txtbox" style="width:180px" id="cboPoNo">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "SELECT
			shipmentforecast_detail.strPoNo
			FROM
			shipmentforecast_detail
			GROUP BY
			shipmentforecast_detail.strPoNo
			ORDER BY
			shipmentforecast_detail.strPoNo ASC";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		
			echo "<option value=\"". $row["strPoNo"] ."\">" . $row["strPoNo"] ."</option>" ;
		
	}
	
	?>
                  </select></td>
                  <td width="72" bgcolor="#99FF66" class="txtbox">From</td>
                  <td width="155" class="txtbox" nowrap="nowrap"><input name="txtdatefrom" type="text" class="txtbox" id="txtdatefrom" style="width:100px; text-align:center;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" /></td>
                  <td width="70" bgcolor="#99FF66" class="txtbox">To</td>
                  <td width="150" class="txtbox" nowrap="nowrap"><input name="txtdateto" type="text" class="txtbox" id="txtdateto" style="width:100px; text-align:center;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" /></td>
                  </tr>
                <tr>
                  <td height="26">&nbsp;</td>
                  <td><img src="images/search.png" alt="Search" width="80" height="24" class="mouseover" onclick="SearchBuyers();" /></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>
                  <?php if($allowApproval){ ?>
                  	<img src="images/approve.png" title="Add PL" style="cursor:pointer;" onclick="approvaldetails();"/>
                  <?php } ?>
                  </td>
                  <td>&nbsp;</td>
                  <td><div align="right"><img src="images/add-new.png" alt="Search" width="130" height="19" class="mouseover" onclick="buyerselect(<?php if($allowShipmentSchedule){ echo "1"; }else{ echo "0"; } ?>);" /></div></td>
                  </tr>
<style>
div.getdata
{
border-right:1px solid;
border-bottom:2px solid;
padding:5px 5px;
background:#F5F5DC;
border-color:#FFF;
}

div.setdata
{
border-right:1px solid;
border-bottom:2px solid;
padding:5px 5px;
background:#12BDF5;
border-color:#12BDF5;
}

div.getsetdata
{
border-right:1px solid;
border-bottom:2px solid;
height:15px;
padding:5px 5px;
background:#999933;
border-color:#999933;
}

div.getsetgetdata
{
border-right:1px solid;
border-bottom:2px solid;
height:25px;
width:10px;
background:#999933;
border-color:#999933;
}

</style>
<link href="../style.css" rel="stylesheet" type="text/css" />
  <link href="noti_pop/jquery.notice.css" type="text/css" media="screen" rel="stylesheet" />
  <script src="noti_pop/jquery.notice.js" type="text/javascript"></script>

<style>
.success {
	background-color:
 #090;
}
.error {
	background-color:#900;
}
ul li {
	padding:3px;
}
ul li:hover {
	cursor:pointer;
	background-color:#000;
	color:#FFF;
}
</style>
<style type="text/css">
body{
	 margin:0;
	 padding:0;
	 min-width:960px;
	 color:#bbbbbb; 
}

a { 
	text-decoration:none; 
	color:#00c6ff;
}

h1 {
	font: 4em normal Arial, Helvetica, sans-serif;
	padding: 20px;	margin: 0;
	text-align:center;
}

h1 small{
	font: 0.2em normal  Arial, Helvetica, sans-serif;
	text-transform:uppercase; letter-spacing: 0.2em; line-height: 5em;
	display: block;
}

h2 {
    color:#bbb;
    font-size:3em;
	text-align:center;
	text-shadow:0 1px 3px #161616;
}

.container {width: 960px; margin: 0 auto; overflow: hidden;}

#content {	float: left; width: 100%;}

.post { margin: 0 auto; padding-bottom: 50px; float: left; width: 960px; }

.btn-sign {
	width:460px;
	margin-bottom:20px;
	margin:0 auto;
	padding:20px;
	border-radius:5px;
	background: -moz-linear-gradient(center top, #00c6ff, #018eb6);
    background: -webkit-gradient(linear, left top, left bottom, from(#00c6ff), to(#018eb6));
	background:  -o-linear-gradient(top, #00c6ff, #018eb6);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorStr='#00c6ff', EndColorStr='#018eb6');
	text-align:center;
	font-size:36px;
	color:#fff;
	text-transform:uppercase;
}

.btn-sign a { color:#fff; text-shadow:0 1px 2px #161616; }

#mask {
	display: none;
	background: #000; 
	position: fixed; left: 0; top: 0; 
	z-index: 10;
	width: 100%; height: 100%;
	opacity: 0.8;
	z-index: 999;
}

.login-popup{
	display:none;
	background: #333;
	padding: 10px; 	
	border: 2px solid #ddd;
	float: left;
	font-size: 1.2em;
	position: fixed;
	top: 50%; left: 50%;
	z-index: 99999;
	box-shadow: 0px 0px 20px #999;
	-moz-box-shadow: 0px 0px 20px #999; /* Firefox */
    -webkit-box-shadow: 0px 0px 20px #999; /* Safari, Chrome */
	border-radius:3px 3px 3px 3px;
    -moz-border-radius: 3px; /* Firefox */
    -webkit-border-radius: 3px; /* Safari, Chrome */
}

img.btn_close {
	float: right; 
	margin: -28px -28px 0 0;
}

fieldset { 
	border:none; 
}

form.signin .textbox label { 
	display:block; 
	padding-bottom:7px; 
}

form.signin .textbox span { 
	display:block;
}

form.signin p, form.signin span { 
	color:#999; 
	font-size:11px; 
	line-height:18px;
} 

form.signin .textbox input { 
	background:#666666; 
	border-bottom:1px solid #333;
	border-left:1px solid #000;
	border-right:1px solid #333;
	border-top:1px solid #000;
	color:#fff; 
	border-radius: 3px 3px 3px 3px;
	-moz-border-radius: 3px;
    -webkit-border-radius: 3px;
	font:13px Arial, Helvetica, sans-serif;
	padding:6px 6px 4px;
	width:200px;
}

form.signin input:-moz-placeholder { color:#bbb; text-shadow:0 0 2px #000; }
form.signin input::-webkit-input-placeholder { color:#bbb; text-shadow:0 0 2px #000;  }



</style>
<script>


function buyerselect(Allow){
	if(Allow == "1"){
	var buyer = document.getElementById('cboBuyer').value;
	if(buyer == "Select One" ){
		jQuery.noticeAdd({
				text: 'Please select the buyer',
				stay: false
			});
		}
	if(buyer == "M AND S"){
		MANDSadd("1","1");
		}
	if(buyer == "NEXT"){
		Nextadd("1","1");
		}
	if(buyer == "TESCO"){
		Tescoadd("1","1");
		}
	if(buyer == "DECATHLON"){
		Decathlonadd("1","1");
		}
	if(buyer == "ASDA"){
		Asdaadd("1","1");
		}
	if(buyer == "FASHION LAB"){
		FasionLabadd("1","1");
		}
	if(buyer == "LEVIS"){
		Levisadd("1","1");
		}
	if(buyer == "SAINSBURY"){
		Sainsburyadd("1","1");
		}
	if(buyer == "FEILDING"){
		Feildingadd("1","1");
		}
	if(buyer == "ORIGINAL MARINES"){
		OriginaMarinesadd("1","1");
		}
	if(buyer == "NIKE"){
		Nikeadd("1","1");
		}
	if(buyer == "BLUES"){
		Bluesadd("1","1");
		}
	}else{
		jQuery.noticeAdd({
				text: 'You Dont Have User Permissions',
				stay: false
			});
		}
	}
	
function closeWindow()
{
		  $('#mask , .login-popup').fadeOut(300 , function() {
		$('#mask').remove();  
	}); 
	return false;
}

function editItems(){
	<?php if($allowShipmentSchedule){ ?>
	var x = 1; 
	buyeredit(this.cells[20].childNodes[0].innerHTML, x);
	<?php }else{ ?>
	var x = 0;
	buyeredit(this.cells[20].childNodes[0].innerHTML, x);
	<?php } ?>
}

</script>
              </table></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td colspan="2"><div id="divData" style="width:930px; height:400px; overflow: scroll; border-width:3px; border-style:solid;border-color:#99CCFF;">
            <table width="1061" bgcolor="#CCCCFF" border="0" cellpadding="0" cellspacing="1" class="bcgl1" id="tblPreOders" >
              <tbody id="tblDescription">
              <tr>
                <td width="2%" height="19" bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">&nbsp;&nbsp;&nbsp; SC No &nbsp;&nbsp;&nbsp;</td>
                <td width="2%" height="19" bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Buyer &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td width="4%" bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Style No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">&nbsp;&nbsp;&nbsp; Buyer PO No &nbsp;&nbsp;&nbsp;</td>
                <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">&nbsp;&nbsp;&nbsp; Description &nbsp;&nbsp;&nbsp;</td>
                <td width="4%" bgcolor="#999933" class="normaltxtmidb2" nowrap="nowrap">&nbsp;&nbsp;&nbsp; Possibility &nbsp;&nbsp;&nbsp;</td>
                <td width="4%" bgcolor="#999933" class="normaltxtmidb2" nowrap="nowrap">&nbsp;&nbsp;&nbsp; Possible Qty &nbsp;&nbsp;&nbsp;</td>
                <td width="4%" bgcolor="#999933" class="normaltxtmidb2" nowrap="nowrap">&nbsp;&nbsp;&nbsp; Possible Date &nbsp;&nbsp;&nbsp;</td>
                <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">&nbsp;&nbsp;&nbsp; Fabric Composition &nbsp;&nbsp;&nbsp;</td>
                <td width="4%" bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">&nbsp;&nbsp;&nbsp; Color &nbsp;&nbsp;&nbsp;</td>
                <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">&nbsp;&nbsp;&nbsp; Season &nbsp;&nbsp;&nbsp;</td>
                <td width="4%" bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">&nbsp;&nbsp;&nbsp; Price &nbsp;&nbsp;&nbsp;</td>
                <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Factory &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td width="4%" bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">&nbsp;&nbsp;&nbsp; CTNS &nbsp;&nbsp;&nbsp;</td>
                <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">&nbsp;&nbsp;&nbsp; QTY &nbsp;&nbsp;&nbsp;</td>
                <td width="3%" bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">&nbsp;&nbsp;&nbsp; Net WT &nbsp;&nbsp;&nbsp;</td>
                <td width="3%" bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">&nbsp;&nbsp;&nbsp; GRS WT &nbsp;&nbsp;&nbsp;</td>
                <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">&nbsp;&nbsp;&nbsp; GSP Status &nbsp;&nbsp;&nbsp;</td>
                <td width="4%" bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">&nbsp;&nbsp;&nbsp; Retec No &nbsp;&nbsp;&nbsp;</td>
                <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">&nbsp;&nbsp;&nbsp; Unit &nbsp;&nbsp;&nbsp;</td>
                <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">&nbsp;&nbsp;&nbsp; Shipment ID &nbsp;&nbsp;&nbsp;</td>
                <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Status &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; User Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
              </tr>
              </tbody>
            </table>
          </div></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><div align="right">
        <div class="buttons">
			<a href="#" id="show" class="button left"><img src="images/ButtonSendEmail.jpg" width="166" height="27"></a>
			<div id="myResults"></div>
            
		</div></div></td>
    </tr>
  </table>
  
</form>

	<link rel="stylesheet" href="css/avgrund.css">
    <script src="js/jquery.avgrund.js"></script>
	<script>
	$(function() {
		$('#show').avgrund({
			height: 300,
			width: 1000,
			holderClass: 'custom',
			showClose: true,
			showCloseText: 'close',
			onBlurContainer: '.container',
			template: '<div id="divData" style="width:635px; height:295px; overflow: hidden; border-width:3px; border-style:solid;border-color:#99CCFF;">'+
			'<br></br>'+
			'<table align="Center">' +
			'<tr>' +
			'<td width="72" class="normalfnt">Buyer</td>' +
			'<td><select name="cboBuyerSelect" class="txtbox" id="cboBuyerSelect" style="width:170px">'+
                    '<option value="Select One" selected="selected">Select One</option>'+
                    '<option value="M AND S" >M AND S</option>'+
                    '<option value="NEXT" >NEXT</option>'+
                    '<option value="TESCO" >TESCO</option>'+
                    '<option value="DECATHLON" >DECATHLON</option>'+
                    '<option value="ASDA" >ASDA</option>'+
                    '<option value="FASHION LAB" >FASHION LAB</option>'+
                    '<option value="LEVIS" >LEVIS</option>'+
                    '<option value="SAINSBURY" >SAINSBURY</option>'+
                    '<option value="FEILDING" >FEILDING</option>'+
                    '<option value="ORIGINAL MARINES" >ORIGINAL MARINES</option>'+
                    '<option value="NIKE" >NIKE</option>'+
                    '<option value="BLUES" >BLUES</option>'+
					'</select></td>' +
			'<td></td>' +
			'<td></td>' +
			'</tr>' +
			'<tr>'+
			'<td width="72" class="normalfnt">Date From</td>' +
			'<td width="72" class="normalfnt"><input id="txtmailfrom" type="text" style="width:170px" onclick="getdate(this.id)"/></td>' +
			'<td width="72" class="normalfnt">To</td>' +
			'<td width="72" class="normalfnt"><input id="txtmailto" type="text" style="width:170px" onclick="getdate(this.id)"/></td>' +
			'</tr>'+
			'<tr>'+
			'<td width="72" class="normalfnt" nowrap="nowrap">Factory Manager</td>' +
			'<td width="72" class="normalfnt"><select name="cboFactoryManager" class="txtbox" id="cboFactoryManager" style="width:170px">'+
			'<option value="Select One" selected="selected">Select One</option>'+
			'<option value="test@helaclothing.com">Kolitha</option>'+
			<?php $sql="SELECT
			emailaccounts.intUserName,
			emailaccounts.intEmailAddress
			FROM
			emailaccounts
			ORDER BY
			emailaccounts.intEmailID ASC";
			$result = $db->RunQuery($sql);
	
			while($row = mysql_fetch_array($result))
			{?>
		
			'<option value="<?php echo $row["intEmailAddress"]; ?>" > <?php echo $row["intUserName"] ?> </option>'+
		
			<?php 
			}
			?>
			'</select>'+
			'</td>' +
			'<td width="72" class="normalfnt"></td>' +
			'<td width="72" class="normalfnt"></td>' +
			'</tr>'+
			'<tr>'+
			'<td width="72" class="normalfnt"></td>' +
			'<td width="72" class="normalfnt"><img src="images/send.jpg" width="50" height="30" onclick="emailsend();" ></td>' +
			'<td width="72" class="normalfnt"></td>' +
			'<td width="72" class="normalfnt"></td>' +
			'</tr>'+
			'</table>' +
			'</div>'
		});
	});
	</script>
    
</body>
</html>
