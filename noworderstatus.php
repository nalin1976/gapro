<?php
include "Connector.php";
$StyleIDList = array();
$StyleList = array();
$rowCount=0;
$noFrom=0;
$noTo=15;

$pubCompanyID	= $_POST["cboCompanyID"];
$pubCustomer	= $_POST["cboCustomer"];
$pubStyleID		= $_POST["txtstyleid"];
$pubNoFrom		= $_POST["txtNoFrom"];
$pubNoTo		= $_POST["txtNoTo"];
$date			= $_POST["chkDate"];
$chkDate		= ($date=="on" ? 1:0);
$date			= $_POST["txtDate"];
		$dateArray 	= explode('/',$date);
		$FormatDate 	= $dateArray[2]."-".$dateArray[1]."-".$dateArray[0];
$loopingIndex = 0;
		//echo $FormatDate;
$SQL_styleID="SELECT DISTINCT O.intStyleId 
	FROM orders O	
	INNER JOIN buyers B ON O.intBuyerID = B.intBuyerID 
	inner join deliveryschedule on deliveryschedule.intStyleId=O.intStyleId 
	WHERE O.intStatus <>13";
if($pubStyleID!="")
	$SQL_styleID .=" AND O.intStyleId like '$pubStyleID%'";
if($pubCompanyID!="")
	$SQL_styleID .=" AND O.intCompanyID ='$pubCompanyID'";
if($pubCustomer!="")
	$SQL_styleID .=" AND B.intBuyerID='$pubCustomer'";	
if($date!="")
	$SQL_styleID .="AND dtDateofDelivery = '$FormatDate'";
						
	$SQL_styleID .=" order by O.intStyleId 
					limit $pubNoFrom,$pubNoTo";

			if ($_POST["cboCompanyID"] != null || $_POST["cboCompanyID"] != "")
			{
			//echo $SQL_styleID;			
			$result_styleID = $db->RunQuery($SQL_styleID);
			
			while($row_styleID=mysql_fetch_array($result_styleID))
			{
				$StyleIDList[$loopingIndex] = $row_styleID["intStyleId"];
				$StyleList[$loopingIndex] = "'" . $row_styleID["intStyleId"] . "'";
				$loopingIndex ++;			
			}
			}
		 
?>
<head>
<title>ORDER STATUS</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
.style1 {color: #FF0000}
.style3 {color: #FFFFFF}
.style4 {color: #FFFF00}
.style5 {color: #000000}
-->
</style>
<link rel="stylesheet" type="text/css" href="javascript/calendar/theme.css" />
<script src="javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script type="text/javascript" src="javascript/orderstatus.js"></script>
<script src="javascript/script.js" type="text/javascript"></script>
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
<script type="text/javascript">
var factoryID = <?php

 echo $_SESSION["CompanyID"]; 
 ?>;
var UserID = <?php
 session_start();
 echo $_SESSION["UserID"]; 
 ?>;
var EscPercentage = 0.25;
 
var serverDate = new Date();
serverDate.setYear(parseInt(<?php
echo date("Y"); 
?>));
serverDate.setMonth(parseInt(<?php
echo date("m"); 
?>));
serverDate.setDate(parseInt(<?php
echo date("d")+1; 
?>));


</script>
<script type="text/javascript">
var noOfRowsFrom=0;
var noOfRowsTo=15;
var noOfStyleRecords;
var currentLeft = 0;

function doWork(e,obj)
{

	var top = obj.scrollTop;
	var left = obj.scrollLeft;
   if (left > 0 && currentLeft != left && top <= 20)
   {
   		document.getElementById('divHeader').style.visibility = 'hidden'; 
		
		currentLeft = left;
	}
	
	if (top > 20)
	{
		document.getElementById('divHeader').scrollLeft = obj.scrollLeft;
		document.getElementById('divHeader').style.visibility = 'visible'; 
		currentLeft = left;
	}
	else
	{
		document.getElementById('divHeader').style.visibility = 'hidden'; 
	}
	
}

function getStyleDeials(possition)
{
var companyid=document.getElementById("cboCompanyID").value;
var buyerid=document.getElementById("cboCustomer").value;
var styleid=document.getElementById("txtstyleid").value;
var check=document.getElementById("chksearch").value;

var row=document.getElementById("tblCaption").getElementsByTagName("TR")
var cell=row[0].getElementsByTagName("TD")
var noOfRocs=cell[1].innerHTML;
var noOfStyleRecords=document.getElementById("txtTotNos").value;

if(possition==1)
	{
		noOfRowsFrom=0
	 	noOfRowsTo=15	//default 15
	}
	else if(possition==2)
	{	if(noOfRowsFrom>0)
		{
			noOfRowsFrom=noOfRowsFrom-15
			//noOfRowsTo=noOfRowsTo-15
			noOfRowsTo=noOfRowsTo
		}
		else
		{
			noOfRowsFrom=0
			noOfRowsTo=15	//default 15
		}
	}
	else if(possition==3)
	{
		if(noOfStyleRecords>noOfRowsFrom){
			noOfRowsFrom=noOfRowsFrom+15
			//noOfRowsTo=noOfRowsTo+15
			noOfRowsTo=noOfRowsTo
		}
		else
			noOfRowsFrom=noOfStyleRecords;
			
	}
	else if(possition==4)
	{
		var temp=noOfStyleRecords/15
		
		var tempRecSets=(temp-parseInt(temp))

			noOfRowsFrom=parseInt(temp)*15
	 		noOfRowsTo	=Number(tempRecSets*15).toFixed(0);
		
	}


	//cell[3].innerHTML=noOfRowsFrom;
	//cell[5].innerHTML=noOfRowsTo;
	//document.getElementById("txtNoFrom").value=noOfRowsFrom
	//document.getElementById("txtNoTo").value=noOfRowsTo
	document.getElementById("txtNoFrom").value=noOfRowsFrom;
	document.getElementById("txtNoTo").value=noOfRowsTo;
}

function SubmitForm()
{
	var companyID=document.getElementById("cboCompanyID").value;
	var cusID=document.getElementById("cboCustomer").value;
	var styleLike=document.getElementById("txtstyleid").value;

	if(companyID==""){alert("Please select the company....");return;}
	document.frmStatus.submit();
}
</script>


</head>

<body>
	  <?php
		  $dynamiwidth = 0;
		  $printstyleList = implode(",", $StyleList); 
	   	  $SQL_widthQuery="SELECT DISTINCT matsubcategory.StrCatName,matsubcategory.intSubCatNo FROM matsubcategory INNER JOIN matitemlist ON matsubcategory.intSubCatNo = matitemlist.intSubCatID INNER JOIN orderdetails ON matitemlist.intItemSerial = orderdetails.intMatDetailID INNER JOIN orders ON orderdetails.intStyleId = orders.intStyleId INNER JOIN companies ON companies.intCompanyID = orders.intCompanyID WHERE orders.intStyleId in (" . $printstyleList . ") AND companies.intCompanyID = ".$_POST["cboCompanyID"]." ;";  //
		
		//echo $SQL_widthQuery;			
			if ($_POST["cboCompanyID"] != null || $_POST["cboCompanyID"] != "")
			{
				$result_set = $db->RunQuery($SQL_widthQuery);
				$num_rows = mysql_num_rows($result_set);
				$dynamiwidth +=  ($num_rows * 300);
				
			}
			
	 	$dynamiwidth += 7100;
	  ?>

<form name="frmStatus" id="frmStatus" method="post" action="noworderstatus.php">
  <table width="934" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td width="5997"><?php include 'Header.php'; ?></td>
    </tr>
    <tr>
      <td><table width="100%" border="0">
          <tr>
            <td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
                <tr>
                  <td height="24" class="normalfnt">Company</td>
                  <td width="23%" class="normalfnt"><select name="cboCompanyID" class="txtbox" id="cboCompanyID" style="width:200px" onChange="GetNoOfStyles();">
                      <?php
	
	$SQL = "SELECT intCompanyID,strName FROM companies  where intStatus='1' order by strName;";
	
	$result = $db->RunQuery($SQL);
	
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		if ($_POST["cboCompanyID"] ==  $row["intCompanyID"])
			echo "<option selected=\"selected\" value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
		else
			echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
	}
	
	?>
                    </select>
                  <span class="normalfntMidTAB"></span>                  </td>
                  <td width="2%" class="normalfnt"><input type="checkbox" name="chksearch" id="chksearch" /></td>
                  <td width="14%" class="normalfnt">Search by Customer</td>
                  <td width="17%" class="normalfnt"><select name="cboCustomer" class="txtbox" id="cboCustomer" style="width:150px" onChange="GetNoOfStyles();">
                      <?php
	
	$SQL_customer = "SELECT buyers.intBuyerID,buyers.strName from buyers WHERE buyers.intStatus='1' order by strName;";
	
	$result_customer = $db->RunQuery($SQL_customer);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result_customer))
	{
		if ($_POST["cboCustomer"] ==  $row["intBuyerID"])
			echo "<option selected=\"selected\" value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
		else
			echo "<option value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  <td width="10%" class="normalfnt">Style ID Like</td>
                  <td width="19%" class="normalfnt"><input name="txtstyleid" type="text" class="txtbox" id="txtstyleid" value="<?php echo $_POST["txtstyleid"];?>" onKeyUp="GetNoOfStyles();"/></td>
                  <td width="9%" class="normalfnt"><img src="images/search.png" alt="search" name="search" id="search" width="80" height="24" onClick="SubmitForm();"/></td>
                </tr>
            </table></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td>
	<div id="divmainto" style="width:955px">
	  <table width="934" height="401" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <!--<td width="3%"  height="20"  bgcolor="#9BBFDD" class="normalfnth2"><input type="checkbox" name="chkdate" id="chkdate" /></td>
            <td width="17%"  bgcolor="#9BBFDD" class="normalfnth2"></td>-->
            <td width="80%" colspan="3" bgcolor="#9BBFDD" class="normalfnth2"><div align="center" ><table width="954" border="0" cellpadding="0" cellspacing="0" class="tablezRED" id="tblCaption">
          <tr>
			<td width="93">
			  Delivery Date		  			  </td>
            <td width="30"><input <?php if($_POST["chkDate"]== "on") { ?> checked="checked" <?php } ?> type="checkbox" name="chkDate" id="chkDate" onClick="DisableCalander(this);GetNoOfStyles();"/></td>
            <td width="142"><input name="txtDate" type="text" class="txtbox" id="txtDate" size="15" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="GetNoOfStyles();return showCalendar(this.id, '%d/%m/%Y');" disabled="disabled" value="<?php echo ($date=="" ? date ("d/m/Y"):$date) ?>"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"></td>
            <td width="83">No of Styles :</td>
            <td width="52"><input name="txtTotNos" type="text" class="txtbox" readonly="" id="txtTotNos"  size="5" height="10" value="<?php echo ($_POST["txtTotNos"]=="" ? 0:$_POST["txtTotNos"])?>"></td>
			<td width="157" class="normalfnt"><select name="cboStyleID1" class="txtbox" id="cboStyleID1" style="width:150px" onChange="GetStyleIDTotxtBox(this);"></select></td>
			<td width="48"></td>
            <td width="50"> From :</td>
            <td width="75">
              <input name="txtNoFrom" type="text" class="txtbox" id="txtNoFrom" value="<?php echo ($_POST["txtNoFrom"]=="" ? 0:$_POST["txtNoFrom"])?> " size="10" height="10">              </td>
            <td width="49">To :</td>
            <td width="75"><input name="txtNoTo" type="text" class="txtbox" id="txtNoTo"  value="
			<?php echo ($_POST["txtNoTo"]=="" ? 15:$_POST["txtNoTo"]);?>
			" size="10" height="10"></td>
            <td width="22" onClick="getStyleDeials(1)"><img src="images/fb.png" width="18" height="19" /></td>
            <td width="28" onClick="getStyleDeials(2)"><img src="images/fw.png" width="18" height="19" /></td>
            <td width="23" onClick="getStyleDeials(3)"><img src="images/bw.png" width="18" height="19" /></td>
            <td width="25" onClick="getStyleDeials(4)"><img src="images/ff.png" width="18" height="19" /></td>
          </tr>
        </table>
			</div></td>
          </tr>
          <tr>
            <td height="380" colspan="3" class="normalfnt"><div id="divcons" onscroll="doWork(event,this);" style="overflow:scroll; height:410px; width:955px;">
                <div id="divHeader" style="position:fixed;width:934px;overflow:hidden;">
                  <table style="visibility:hidden" width="<?php echo $dynamiwidth; ?>" cellpadding="0" cellspacing="0">
                                      <tr class="normaltxtmidb2">
                    <td width="116" height="20" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">Customer</td>
                    <td width="116" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">Style 
                    ID</td>
                    <td width="137" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">Description</td>
                    <td width="140" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">Buyer 
                    PO</td>
                    <td width="100" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">FOB</td>
                    <td width="102" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">SMV</td>
                    <td width="28" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">Est. 
                    YY</td>
                    <td width="19" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">CM</td>
                    <td width="41" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">Order 
                    Date</td>
                    <td width="104" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">Color</td>
                    <td width="27" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">Size</td>
                    <td width="95" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">Qty</td>
                    <td width="31" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">GMT 
                    ETD</td>
                    <td width="32" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">Rev. 
                    ETD</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">PLND 
                    Cut Date</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">Act 
                    Cut Date</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">PLND 
                    Input Date</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">Act 
                    Input Date</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">PLND 
                    Finish Date</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">Act 
                    Shipment Date</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">Shipment 
                    QTY</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">+/-</td>
                    <td colspan="3" bgcolor="#498CC2" class="normaltxtmidb2">SAMPLES STATUS </td>
                    <td colspan="5" bgcolor="#498CC2" class="normaltxtmidb2">SIZE</td>
                   <td colspan="5" bgcolor="#498CC2" class="normaltxtmidb2">Gold Seal </td>
                    <td colspan="5" bgcolor="#498CC2" class="normaltxtmidb2">TESTING</td>
                    <td height="20" colspan="22" bgcolor="#498CC2" class="normaltxtmidb2L">FABRIC  STATUS</td>
                    <td height="20" bgcolor="#498CC2" class="normaltxtmidb2L"><span class="normaltxtmidb2 style1"><?php //echo $row["StrCatName"];?></span></td>
                    <td height="20" colspan="2" bgcolor="#498CC2" class="normaltxtmidb2L">&nbsp;</td>
                  </tr>
                  
                  <tr class="normaltxtmidb2">
                   <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">PITN 
                    ORG SMP TGT</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">PTTD 
                    RCVD</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">ORG 
                    SMPL RCVD</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">QTY</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">SIZE</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">TGT</td>
                    <td width="100" height="20" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2 style3">SENT</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">APVD</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">QTY</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">SIZE</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">TGT</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2"><span class="normaltxtmidb2 style3">SENT</span></td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">APVD</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">QTY</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">SIZE</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">TGT</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2"><span class="normaltxtmidb2 style3">SENT</span></td>
                    <td rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">APVD</td>
                    <td width="47" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">aaSUPPLIER</td>
                    <td width="47" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">PO</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">PI #</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">PAY MODE</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">PAY TGT DATE</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">PAY ACT DATE</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">FABRIC</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">COLOR / PRINT / CONTRAST</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">YDG BKD</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">YDG SHPD</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">+/-</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2 style4">PLND ETD</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">ACT ETD</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">ACT ETA</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">IH DATE</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">COPY DOCS</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2">ORI DOCS</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">SMPL YDG RCVD Date</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">Lab Dip Aprvd</td>
                    <td colspan="2" bgcolor="#498CC2" class="normaltxtmidb2">Fab Test </td>
                    <td width="73" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">APVD BULK SWT RCVD</td>
                    <td width="34" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">FAB INS P/F</td>
					  
                                            <?php 
					  $SQL_subcat="SELECT DISTINCT matsubcategory.StrCatName,matsubcategory.intSubCatNo FROM matsubcategory INNER JOIN matitemlist ON matsubcategory.intSubCatNo = matitemlist.intSubCatID INNER JOIN orderdetails ON matitemlist.intItemSerial = orderdetails.intMatDetailID INNER JOIN orders ON orderdetails.intStyleId = orders.intStyleId INNER JOIN companies ON companies.intCompanyID = orders.intCompanyID WHERE orders.intStyleId in (" . $printstyleList . ") AND companies.intCompanyID = ".$_POST["cboCompanyID"]." and matsubcategory.intStatus=1 and matsubcategory.intCatno=2 or matsubcategory.intCatno=3 and matsubcategory.StrCatName<>'';";
//echo  $SQL_subcat;
								if ($_POST["cboCompanyID"] != null || $_POST["cboCompanyID"] != "")
			{
								$result_subcat = $db->RunQuery($SQL_subcat);
								while($row=mysql_fetch_array($result_subcat))
								{  
					?>
                   <td width="150" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2"><?php //echo $row["StrCatName"];?> BKD</td>
                    <td width="150" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2"><?php //echo $row["StrCatName"];?> <br /> IH</td>
                    <?php
					}
					}
					?>
				    </tr>
                    <tr class="normaltxtmidb2">
                      <td width="400" height="17" bgcolor="#498CC2" class="normaltxtmidb2">Customer</td>
                      <td width="200" bgcolor="#498CC2" class="normaltxtmidb2">Style 
                      ID</td>
                      <td width="300" bgcolor="#498CC2" class="normaltxtmidb2">Description</td>
                      <td width="200" bgcolor="#498CC2" class="normaltxtmidb2">Buyer 
                      PO</td>
                      <td width="100" bgcolor="#498CC2" class="normaltxtmidb2">FOB</td>
                      <td width="100" bgcolor="#498CC2" class="normaltxtmidb2">SMV</td>
                      <td width="100" bgcolor="#498CC2" class="normaltxtmidb2">Est. 
                      YY</td>
                      <td width="150" bgcolor="#498CC2" class="normaltxtmidb2">CM</td>
                      <td width="200" bgcolor="#498CC2" class="normaltxtmidb2">Order 
                      Date</td>
                      <td width="100" bgcolor="#498CC2" class="normaltxtmidb2">Color</td>
                      <td width="100" bgcolor="#498CC2" class="normaltxtmidb2">Size</td>
                      <td width="100" bgcolor="#498CC2" class="normaltxtmidb2">Qty</td>
                      <td width="100" bgcolor="#498CC2" class="normaltxtmidb2">GMT 
                      ETD</td>
                      <td width="100" bgcolor="#498CC2" class="normaltxtmidb2">Rev. 
                      ETD</td>
                    </tr>
                  </table>
                </div>
              <table width="934" height="115" cellpadding="0" cellspacing="0" class="color2" id="docu">
                  <tr class="normaltxtmidb2">
                    <td height="20" colspan="14" bgcolor="#999999" width="1100" class="tablezRedBorder style5">ORDER PLACEMENT</td>
                    <td colspan="8" bgcolor="#C7BBE8" class="tablezRedBorder style5">PRODUCTION</td>
                    <td colspan="18" bgcolor="#F9D9D5" class="tablezRedBorder style5">SAMPLING</td>
                    <td colspan="7" bgcolor="#DFFFDF" class="tablezRedBorder style5">FABRIC</td>
                    <td height="20" id="idtrim" bgcolor="#FFECD9" class="tablezRedBorder style5">TRIMS</td>
					 <?php 
		/*														
						$arrSubCats = array();
						$arrindex = 0;
					  	$SQL_subcat="SELECT DISTINCT matsubcategory.StrCatName,matsubcategory.intSubCatNo FROM matsubcategory INNER JOIN matitemlist ON matsubcategory.intSubCatNo = matitemlist.intSubCatID INNER JOIN orderdetails ON matitemlist.intItemSerial = orderdetails.intMatDetailID INNER JOIN orders ON orderdetails.intStyleId = orders.intStyleId INNER JOIN companies ON companies.intCompanyID = orders.intCompanyID WHERE orders.intStyleId in (" . $printstyleList . ") AND companies.intCompanyID = ".$_POST["cboCompanyID"].";";
					
						if ($_POST["cboCompanyID"] != null || $_POST["cboCompanyID"] != "")
						{
								$result_subcat = $db->RunQuery($SQL_subcat);
								while($row=mysql_fetch_array($result_subcat))
								{  
								
								$arrSubCats[$arrindex] = $row["intSubCatNo"];
								$arrindex  ++;
								
								}
						}*/
					?>
                  </tr>
                  <tr class="normaltxtmidb2">
                    <td width="130" height="20" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">Customer</td>
                    <td width="130" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">Style 
                    ID</td>
                    <td width="150" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">Description</td>
                    <td width="140" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">Buyer 
                    PO</td>
                    <td width="100" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">FOB</td>
                    <td width="102" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">SMV</td>
                    <td width="28" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">Est. 
                    YY</td>
                    <td width="19" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">CM</td>
                    <td width="41" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">Order 
                    Date</td>
                    <td width="104" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">Color</td>
                    <td width="27" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">Size</td>
                    <td width="95" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">Qty</td>
                    <td width="31" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">GMT 
                    ETD</td>
                    <td width="32" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">Rev. 
                    ETD</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">PLND 
                    Cut Date</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">Act 
                    Cut Date</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">PLND 
                    Input Date</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">Act 
                    Input Date</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">PLND 
                    Finish Date</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">Act 
                    Shipment Date</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">Shipment 
                    QTY</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">+/-</td>
                    <td colspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">SAMPLES STATUS </td>
                    <td colspan="5" bgcolor="#498CC2" class="tablezWhiteBorder">SIZE</td>
                   <td colspan="5" bgcolor="#498CC2" class="tablezWhiteBorder">Gold Seal </td>
                    <td colspan="5" bgcolor="#498CC2" class="tablezWhiteBorder">TESTING</td>
                    <td height="20" colspan="7" bgcolor="#498CC2" class="tablezWhiteBorder">FABRIC  STATUS</td>
					
					<?php
						$arrSubCats = array();
						$arrindex = 0;
						
						$SQL_subcat="SELECT DISTINCT matsubcategory.StrCatName,matsubcategory.intSubCatNo FROM matsubcategory INNER JOIN matitemlist ON matsubcategory.intSubCatNo = matitemlist.intSubCatID INNER JOIN orderdetails ON matitemlist.intItemSerial = orderdetails.intMatDetailID INNER JOIN orders ON orderdetails.intStyleId = orders.intStyleId INNER JOIN companies ON companies.intCompanyID = orders.intCompanyID WHERE orders.intStyleId in (" . $printstyleList . ") AND companies.intCompanyID = ".$_POST["cboCompanyID"]." and matsubcategory.intStatus=1 and matsubcategory.StrCatName<>'' order by matsubcategory.intCatno;";
							
							//echo $SQL_subcat;
												
						if ($_POST["cboCompanyID"] != null || $_POST["cboCompanyID"] != "")
						{
							$result_subcat = $db->RunQuery($SQL_subcat);
							while($row=mysql_fetch_array($result_subcat))
							{  
								$arrSubCats[$arrindex] = $row["intSubCatNo"];
								$arrindex  ++;
						?>
					
                    <td height="20" colspan="2" bgcolor="#498CC2" class="tablezWhiteBorder"><div align="center"><span class="normaltxtmidb2"><?php echo $row["StrCatName"];?></span><span class="normaltxtmidb2"></span></div></td>
						<?php
							}
						}
						?>
                  </tr>
                  
                  <tr class="normaltxtmidb2">
                   <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">PITN 
                    ORG SMP TGT</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">PTTD 
                    RCVD</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">ORG 
                    SMPL RCVD</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">QTY</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">SIZE</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">TGT</td>
                    <td width="100" height="20" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder style3">SENT</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">APVD</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">QTY</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">SIZE</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">TGT</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder"><span class="normaltxtmidb2 style3">SENT</span></td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">APVD</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">QTY</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">SIZE</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">TGT</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder"><span class="normaltxtmidb2 style3">SENT</span></td>
                    <td rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">APVD</td>
                    <!--<td width="47" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">SUPPLIERte</td>-->
                    <!--<td width="47" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">PO</td>-->
                    <!--<td width="94" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">PI #</td>-->
                    <!--<td width="94" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">PAY MODE</td>-->
                    <!--<td width="94" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">PAY TGT DATE</td>-->
                    <!--<td width="94" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">PAY ACT DATE</td>-->
                    <!--<td width="94" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">FABRIC</td>-->
                    <!--<td width="94" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">COLOR / PRINT / CONTRAST</td>-->
                    <!--<td width="94" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">YDG BKD</td>-->
                    <!--<td width="94" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">YDG SHPD</td>-->
                   <!-- <td width="94" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">+/-</td>-->
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder style4">PLND ETD</td>
                    <!--<td width="94" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">ACT ETD</td>-->
                    <!--<td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">ACT ETA</td>-->
                    <!--<td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">IH DATE</td>-->
                    <!--<td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">COPY DOCS</td>-->
                   <!-- <td width="94" rowspan="2" bgcolor="#498CC2">ORI DOCS</td>-->
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">SMPL YDG RCVD Date</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">Lab Dip Aprvd</td>
                    <td colspan="2" bgcolor="#498CC2" class="normaltxtmidb2">Fab Test </td>
                    <td width="73" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">APVD BULK SWT RCVD</td>
                    <td width="34" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">FAB INS P/F</td>
					
										  
                                            <?php 
					  $SQL_subcat="SELECT DISTINCT matsubcategory.StrCatName,matsubcategory.intSubCatNo FROM matsubcategory INNER JOIN matitemlist ON matsubcategory.intSubCatNo = matitemlist.intSubCatID INNER JOIN orderdetails ON matitemlist.intItemSerial = orderdetails.intMatDetailID INNER JOIN orders ON orderdetails.intStyleId = orders.intStyleId INNER JOIN companies ON companies.intCompanyID = orders.intCompanyID WHERE orders.intStyleId in (" . $printstyleList . ") AND companies.intCompanyID = ".$_POST["cboCompanyID"]." and matsubcategory.intStatus=1 and matsubcategory.StrCatName<>'' order by matsubcategory.intCatno;";
					
								if ($_POST["cboCompanyID"] != null || $_POST["cboCompanyID"] != "")
			{
								$result_subcat = $db->RunQuery($SQL_subcat);
								while($row=mysql_fetch_array($result_subcat))
								{  
					?>
                   <td width="150" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">Ord. Qty </td>
                    <td width="150" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder"> Rec. Qty </td>
                    <?php
					}
					}
					?>
					
                    <!--<td width="94" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2"><span class="normaltxtmidb2L"><?php //echo $row["StrCatName"];?></span></td>-->
                  </tr>
                  
                  
                  
                  <tr class="normaltxtmidb2">
                    <td width="94" bgcolor="#498CC2" class="tablezWhiteBorder">QTY</td>
                    <td width="94" bgcolor="#498CC2" class="tablezWhiteBorder">SIZE</td>
                  </tr>
<?php
				  
$companyid=$_POST["cboCompanyID"];
$buyerid=$_POST["cboCustomer"];
$styleid=$_POST["txtstyleid"];
$check=$_POST["chksearch"];
$noFrom=$_POST["txtNoFrom"];
$noTo=$_POST["txtNoTo"];
				
$SQL_search= "";

$SQL_search="SELECT SR.strBuyerPONO, 
	SR.strColor, 
	sum(SR.dblQty) as dblQty, 
	O.intStyleId, 
	O.strDescription, 
	O.reaSMV,
	O.reaSMVRate, 
	O.dtmDate, 
	O.reaFOB, 
	DS.dtDateofDelivery, 
	B.strName, 
	O.intCompanyID, 
	B.intBuyerID
	FROM  styleratio SR
	RIGHT  OUTER JOIN orders O ON SR.intStyleId = O.intStyleId 
	INNER JOIN deliveryschedule DS ON O.intStyleId = DS.intStyleId 
	INNER JOIN buyers B ON O.intBuyerID = B.intBuyerID
	WHERE O.intStyleId  in (" . $printstyleList . ")
	group by SR.strBuyerPONO, SR.strColor, O.intStyleId, O.strDescription, 
	O.reaSMV,O.reaSMVRate, O.dtmDate, O.reaFOB, DS.dtDateofDelivery, 
	O.intCompanyID, B.intBuyerID order by O.intStyleId";

						//echo $SQL_search;
						

							$result_search = $db->RunQuery($SQL_search);
							
							while($row_search=mysql_fetch_array($result_search))
						 	{
						   	$CM=$row_search["reaSMV"]*$row_search["reaSMVRate"];
						  	
								
?>
                 
      
                  <tr bgcolor="#FFFFFF">
                    <td width="130" height="20"class="normalfntTAB"><input name="txtData17" type="text" id="txtData17" disabled="disabled" style="background:#FFFFFF" class="txtbox_withoutBorder" size="25" value="<?php echo $row_search["strName"];?>" /></td>
                    <td width="130" class="normalfntTAB"><input name="txtData17" type="text" id="txtData17" disabled="disabled" style="background:#FFFFFF" class="txtbox_withoutBorder" size="25" value="<?php echo $row_search["intStyleId"];?>" /></td>
                    <td width="137" class="normalfntMidTAB"><input name="txtData17" type="text" id="txtData17" disabled="disabled" style="background:#FFFFFF" class="txtbox_withoutBorder" size="30" value="<?php echo $row_search["strDescription"];?>" /></td>
                    <td width="140"  class="normalfntMidTAB"><input name="txtData17" type="text" id="txtData17" disabled="disabled" style="background:#FFFFFF" class="txtbox_withoutBorder" size="17" value="<?php echo $row_search["strBuyerPONO"];?>" /></td>
                    <td width="100" class="normalfntMidTAB"><input name="txtData17" type="text" id="txtData17" disabled="disabled" style="background:#FFFFFF" class="txtbox_withoutBorder" size="10" value="<?php echo $row_search["reaFOB"];?>" /></td>
                    <td width="102" class="normalfntMidTAB"><input name="txtData17" type="text" id="txtData17" disabled="disabled" style="background:#FFFFFF" class="txtbox_withoutBorder" size="10" value="<?php echo $row_search["reaSMV"];?>" /></td>
                    <td width="28" class="normalfntMidTAB"><img src="images/add.png" width="16" height="16" onClick="getEstyypopup(this)"></td>
                    <td width="19" class="normalfntMidTAB"><input name="txtData17" type="text" id="txtData17" disabled="disabled" style="background:#FFFFFF" class="txtbox_withoutBorder" size="10" value="<?php echo $CM;?>" /></td>
                    <td width="41" class="normalfntMidTAB"><input name="txtData17" type="text" id="txtData17" disabled="disabled" style="background:#FFFFFF" class="txtbox_withoutBorder" size="10" value="<?php $neworderdate = substr($row_search["dtmDate"],-19,10);
			echo $neworderdate;?>" /></td>
                    <td width="104" class="normalfntMidTAB"><input name="txtData17" type="text" id="txtData17" disabled="disabled" style="background:#FFFFFF" class="txtbox_withoutBorder" size="15" value="<?php echo $row_search["strColor"];?>" /></td>
                    <td width="27" class="normalfntMidTAB"><img src="images/add.png" width="16" height="16" onClick="getSizeRatios(this)" /></td>
                    <td width="95" class="normalfntMidTAB"><input name="txtData17" type="text" id="txtData17" disabled="disabled" style="background:#FFFFFF" class="txtbox_withoutBorder" size="15" value="<?php echo round($row_search["dblQty"]);?>" /></td>
                    <td width="31" class="normalfntMidTAB"><input name="txtData17" type="text" id="txtData17" disabled="disabled" style="background:#FFFFFF" class="txtbox_withoutBorder" size="10" value="<?php $newdate = substr($row_search["dtDateofDelivery"],-19,10);
					echo $newdate;?>" /></td>
                    <td  class="normalfntMidTAB"><input name="txtData17" type="text" id="txtData17" disabled="disabled" style="background:#FFFFFF" class="txtbox_withoutBorder" size="10" value="<?php echo $newdate;?>" /></td>
                    <td  width="100" class="normalfntMidTAB"><input name="txtData17" type="text" id="txtData17" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData5" type="text" id="txtData5" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData4" type="text" id="txtData4" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData3" type="text" id="txtData3" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData6" type="text" id="txtData6" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData7" type="text" id="txtData7" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData8" type="text" id="txtData8" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData9" type="text" id="txtData9" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData10" type="text" id="txtData10" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData11" type="text" id="txtData11" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData2" type="text" id="txtData2" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15"  /></td>
                    <td class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
<?php
$arrindex = 0;
/*$result_subcat = $db->RunQuery($SQL_subcat);
while($row=mysql_fetch_array($result_subcat))*/
	for($arrindex=0; $arrindex < count($arrSubCats);$arrindex++)
	{
		 $catID = $arrSubCats[$arrindex];
		 
		$spec = false;
		$bgColor = "#CCCCCC";	 
		$sqlspec="select distinct intSubCatID from specificationdetails SD 
		inner join matitemlist MIL ON SD.strMatDetailID=MIL.intItemSerial
		where intStyleId='".$row_search["intStyleId"]."'
		AND intSubCatID=$catID";
		$result_spec = $db->RunQuery($sqlspec);
			while($row_spec=mysql_fetch_array($result_spec))
			{
				
				$firpoqty="";
				$secpoqty="";
				$firgrnqty="";
				$secgrnqty="";
				$spec=true;
			}

 
?>
	<td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData15" type="text" id="txtData15" class="txtbox" size="15" autocompletetype="Disabled" autocomplete="off" value="<?php
if($spec){						 
$SQL_po="SELECT SUM(purchaseorderdetails.dblQty)AS pototal FROM purchaseorderdetails  inner join matitemlist on matitemlist.intItemSerial = purchaseorderdetails.intMatDetailID  WHERE purchaseorderdetails.intStyleId = '".$row_search["intStyleId"]."' AND matitemlist.intSubCatID = $catID ;"; // $catID

						$result1 = $db->RunQuery($SQL_po);
							$bgColor = "#FFFFCC";
							while($row_po=mysql_fetch_array($result1))
							{
								$poqty = explode(".",$row_po["pototal"],2);
								$firpoqty = ($poqty[0]!=0) ? $poqty[0] : "00";
								$secpoqty = ($poqty[1]!=0) ? ".".substr($poqty[1],0,2) : ".00";
							
								echo $firpoqty.$secpoqty;					   
							 
							}				

	}				
					?>"   style="background:<?php echo $bgColor; ?>" />                    </td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB">
                                        <input name="txtData16" type="text" id="txtData16" class="txtbox" size="15" autocompletetype="Disabled" autocomplete="off" value="<?php 
if($spec){
$SQL_grn="SELECT SUM(grndetails.dblQty)AS grntotal FROM grndetails inner join matitemlist on matitemlist.intItemSerial = grndetails.intMatDetailID WHERE grndetails.intStyleId = '".$row_search["intStyleId"]."' AND matitemlist.intSubCatID = $catID;";
//echo $SQL_grn;
				
						   

				    $result_grn = $db->RunQuery($SQL_grn);
					$bgColor = "#CBEFD0";
					while($row_grn=mysql_fetch_array($result_grn))
					{
					  
					    $grnqty = explode(".",$row_grn["grntotal"],2);
					    $firgrnqty = ($grnqty[0]!=0) ? $grnqty[0] : "00";
						$secgrnqty = ($grnqty[1]!=0) ? ".".substr($grnqty[1],0,2) : ".00";						
						
						echo $firgrnqty.$secgrnqty;
					}
}
					//$arrindex += 1;
					//$arrSubCats[$arrindex]++;
					?>" style="background:<?php echo $bgColor; ?>" /></td>
                    <?php
						
						}
					?>
                  </tr>
                  <?phP
						}
					
				  ?>
                </table>
              </div></td>
          </tr>
      </table>
	</div></td>
    </tr>
    <tr>
      <td><table width="96%" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
          <tr>
            <td width="58%" height="20"><table width="100%" border="0">
          <tr>
            <td width="5%" ><input type="text" name="textfield" size="3" class="osc1TXT" disabled="disabled"></td>
            <td width="23%" class="normalfnt">Order Placement</td>
            <td width="4%" ><input type="text" name="textfield" size="3" class="osc2TXT" disabled="disabled"></td>
            <td width="23%" class="normalfnt">Fabric Purchase</td>
            <td width="5%" ><input type="text" name="textfield" size="3" class="osc3TXT" disabled="disabled"></td>
            <td width="13%" class="normalfnt">Sample</td>
            <td width="6%" ><input type="text" name="textfield" size="3" class="osc4TXT" disabled="disabled"></td>
            <td width="21%" class="normalfnt">Trim Purchasing</td>
            </tr>
        </table>			</td>
            <td width="3%">&nbsp;</td>
            <td width="7%"><img src="images/ok.png" width="112" height="24" /></td>
            <td width="7%"><img src="images/report.png" width="108" height="24" onClick="ShowPreOrderReport();" /></td>
            <td width="21%"><a href="main.php"><img src="images/close.png" width="97" height="24" border="0" /></a></td>
            <td  width="4%">&nbsp;</td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
<script type="text/javascript">
 document.getElementById("idtrim").colSpan="<?php echo count($arrSubCats)*2;?>";
 
 function GetStyleIDTotxtBox(obj)
 {
	document.getElementById('txtstyleid').value = obj.value;
 }
</script>
 </body>
</html>
