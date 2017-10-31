<?php
session_start();
include "authentication.inc";
$backwardseperator ='';
//$canIncreaseItemUnitprice=true;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro : : Pre-Order Costing Sheet </title>
<style type="text/css">
input.prompt {border:1 solid transparent; background-color:#99ccff;width:70;font-family:arial;font-size:12; color:black;}
td.titlebar { background-color:#A7D502; color:#0000D2; font-weight:bold;font-family:arial; font-size:12;}
table.promptbox {border:1 solid #ccccff; background-color:#F0F8D3; color:black;padding-left:2;padding-right:2;padding-bottom:2;font-family:arial; font-size:12;}
input.promptbox {border:1 solid #0000FF; background-color:white;width:100%;font-family:arial;font-size:12; color:black; }
</style>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script type="text/javascript" src="javascript/buyerPO.js"></script>
<script type="text/javascript" src="javascript/partDetails.js"></script>
<script type="text/javascript" src="javascript/subPartDetails.js"></script>
<script type="text/javascript" src="createiteminorders/createiteminorders.js"></script>
<script type="text/javascript" src="javascript/autofill.js"></script>

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

<script type="text/javascript">

var factoryID = <?php

 echo $_SESSION["CompanyID"]; 
 ?>;
 
var UserID = <?php
 echo $_SESSION["UserID"]; 
 ?>;
 
 var EditStyleNo = <?php

 echo "'" . $_GET["StyleNo"] . "'"; 
//echo  "'46687-24318'";
 ?>;

var EscPercentage = '<?php

$xml = simplexml_load_file('config.xml');
$esc = $xml->companySettings->ESCPercentage;
echo $esc;

// Not related to ESC
$SMVEnabled = $xml->PreOrder->SMVEnabled;

$LabourCostEnabled = $xml->PreOrder->LabourCostEnabled;

$EnableAdvancedBuyePO = $xml->BuyerPO->EnableAdvanceMode;


?>';

 var uselabourcost = <?php

 echo  $LabourCostEnabled ; 

 ?>;
 
var EnableSendToApprovalComments = <?php
$EnableSendToApprovalComments = $xml->PreOrder->EnableSendToApprovalComments;
 echo  $EnableSendToApprovalComments ; 

 ?>;

//get maximum percentage of finance and wastage

var maxFinance = '<?php 
$maxFinancePc = $xml->PreOrder->MaxFinancePercentage;
echo $maxFinancePc;
?>';

var maxWastage = '<?php 
$maxWasatePC = $xml->PreOrder->MaxWastagePercentage;
echo $maxWasatePC;
?>'
 
var serverDate = new Date();
serverDate.setYear(parseInt(<?php
echo date("Y"); 
?>));
serverDate.setMonth(parseInt(<?php
echo date("m")-1; 
?>,10));
serverDate.setDate(parseInt(<?php
echo date("d")+1; 
?>,10));

var pub_minimumProfitMargin = '<?php 
$pub_minimumProfitMargin = $xml->companySettings->MinimumProfitMargin;
echo $pub_minimumProfitMargin;
?>'
</script>

  <script type="text/javascript">
 var freezeRow=1; //change to row to freeze at
  var freezeCol=3; //change to column to freeze at
  var myRow=freezeRow;
  var myCol=freezeCol;
  var speed=100; //timeout speed

  var myTable;
  var noRows;
  var myCells,ID;
  

  
function setUp(){
	if(!myTable){myTable=document.getElementById("tblConsumption");}
 	myCells = myTable.rows[0].cells.length;
	noRows=myTable.rows.length;

	for( var x = 0; x < myTable.rows[0].cells.length; x++ ) {
		colWdth=myTable.rows[0].cells[x].offsetWidth;
		myTable.rows[0].cells[x].setAttribute("width",colWdth-4);

	}
}


function right(up){
	if(up){window.clearTimeout(ID);return;}
	if(!myTable){setUp();}

	if(myCol<(myCells)){
		for( var x = 0; x < noRows; x++ ) {
			myTable.rows[x].cells[myCol].style.display="";
		}
		if(myCol >freezeCol){myCol--;}
		ID = window.setTimeout('right()',speed);
	}
}

function left(up){
	if(up){window.clearTimeout(ID);return;}
	if(!myTable){setUp();}

	if(myCol<(myCells-1)){
		for( var x = 0; x < noRows; x++ ) {
			myTable.rows[x].cells[myCol].style.display="none";
		}
		myCol++
		ID = window.setTimeout('left()',speed);

	}
}

function down(up){
	if(up){window.clearTimeout(ID);return;}
	if(!myTable){setUp();}

	if(myRow<(noRows-1)){
			myTable.rows[myRow].style.display="none";
			myRow++	;

			ID = window.setTimeout('down()',speed);
	}
}

function upp(up){
	if(up){window.clearTimeout(ID);return;}
	if(!myTable){setUp();}
	if(myRow<=noRows){
		myTable.rows[myRow].style.display="";
		if(myRow >freezeRow){myRow--;}
		ID = window.setTimeout('upp()',speed);
	}
}


</script>

<style type="text/css" media="all">
.td1 {background:#EEEEEE;color:#000;border:1px solid #000;}
.th{background:blue;color:white;border:1px solid #000;}
A:link {COLOR: #0000EE;}
A:hover {COLOR: #0000EE;}
A:visited {COLOR: #0000EE;}
A:hover {COLOR: #0000EE;}

.div_freezepanes_wrapper{
position:relative;width:90%;height:400px;
overflow:hidden;background:#fff;border-style: ridge;
}

.div_verticalscroll{
position: relative;
#left:900px;
#top:-220px;
right:0px;
width:18px;
height:220px;
background:#EAEAEA;
border:1px solid #C0C0C0;
}

.buttonUp{
width:20px;position: absolute;top:2px;
}

.buttonDn{
width:20px;position: absolute;bottom:22px;
}

.div_horizontalscroll{
#position: absolute;
#bottom:100px;
width:950px;
height:18px;
background:#EAEAEA;
border:1px solid #C0C0C0;
}

.buttonRight{
width:20px;position: relative;left:0px;padding-top:2px;
}

.buttonLeft{
width:20px;position: relative;left:450px;padding-top:2px;
}
</style>

<script src="javascript/script.js" type="text/javascript"></script>
<script src="javascript/preorder.js" type="text/javascript"></script>
<script type="text/javascript" src="javascript/autofill.js"></script>
<style type="text/css">
<!--
.style1 {color: #FF0000}
#lyrLoading {
	position:absolute;
	left:486px;
	top:534px;
	width:75px;
	height:21px;
	z-index:1;
	background-color: #FFFFFF;
	overflow: hidden;
}
-->
</style>
</head>

<body onload="LoadSavedPreOrderInformation();">
<?php
	
	include "Connector.php";
	$styleNo = $_GET["StyleNo"];
	$styleName = $_GET["StyleName"];
	?>

<form id="frm_main" name="frm_main" method="post" action="">
<tr>
	<td height="6" ><?php include $backwardseperator.'Header.php'; ?></td>
</tr>
  <table width="90%" align="center" cellpadding="1" cellspacing="1" class="bcgl1" id="tblMain">
    <tr>
      <td height="75" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><table width="100%" height="44" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="92%" height="7"><span class="normalfnt">Merchandising/Preorder Costing/</span> <span class="normalfnth2">Edit Preorder</span></td>
                <td width="8%" rowspan="2">
				
				<?php
				 if (file_exists("styles/" . $_GET["StyleNo"] . ".jpg"))	
				 {
				?>				
				<a href="#"><img src="styles/<?php echo $_GET["StyleNo"]; ?>.jpg" name="imgStyle" width="56" height="63" border="0" id="imgStyle" onclick="ShowStyleLoader();" /></a>
				<?php
				}
				else
				{
				?>
				<a href="#"><img src="images/noimg.png" name="imgStyle" width="56" height="63" border="0" id="imgStyle" onclick="ShowStyleLoader();" /></a>
				<?php
				}				
				?>				</td>
              </tr>
              <tr>
                <td height="18"><table width="100%" border="0">
                    <tr>
                      <td width="15"><span class="head1"><img src="images/butt_1.png" width="15" height="15" /></span></td>
                      <td width="92"><span class="normalfnt"> Style No</span></td>
                      <td width="214"><select name="cboStyles" class="txtbox" style="width:210px" id="cboStyles" onchange="GetStyleNoWiseScNo(this);getOrderNo();">
                        <option value="Select One" selected="selected">Select One</option>
                        <?php
	
	/*$SQL = "select intStyleId,strStyle from orders where intUserID = " . $_SESSION["UserID"] . " AND intStatus  in (0,12,2) order by strStyle";
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($_GET["StyleNo"]==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>" ;
	}*/
	//get style wise orderno to order combo
	
	$SQL = "select distinct strStyle from orders where intUserID = " . $_SESSION["UserID"] . " AND intStatus  in (0,12,2) order by strStyle";
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($_GET["StyleName"]==  $row["strStyle"])
		{
			echo "<option selected=\"selected\" value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
	}
	?>
                      </select></td>
                      <td width="35"><img src="images/go.png" alt="go" width="30" height="22" class="mouseover" onclick="reloadPreOrderStyle();" style="visibility:hidden"/></td>
                      <td width="64"><div align="center" class="normalfnt">
                        <div align="center">SC</div>
                      </div></td>
                      <td width="109"><select name="cboSR" class="txtbox" style="width:100px" id="cboSR" onchange="GetOrderNoBySC(this.value);">
                        <option value="Select One" selected="selected">Select One</option>
                        <?php
	
		$SQL = "select specification.intSRNO,orders.intStyleId from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus in (0,12,2) and intUserID = " . $_SESSION["UserID"] . " ";
	
	if($_GET["StyleName"] != "Select One" && $_GET["StyleName"] != "")
		$SQL .= " and orders.strStyle='".$_GET["StyleName"]."'";
	
		$SQL .= " order by specification.intSRNO desc";
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($_GET["StyleNo"] ==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	?>
                      </select></td>
                      <td width="53"><span class="normalfnt"><img src="images/go.png" alt="go" width="30" height="22" class="mouseover" onclick="reloadPreOrderSR(this.id);" /></span></td>
                      <td width="168" class="normalfnt">Order No</td>
                      <td width="149"><select name="cboOrderNo" id="cboOrderNo" style="width:120px;" onchange="GetScByOrderNo(this.value);">
                       <option value="Select One" selected="selected">Select One</option>
                        <?php
	
	$SQL = "select intStyleId,strOrderNo from orders where intUserID = " . $_SESSION["UserID"] . " AND intStatus  in (0,12,2) ";
	
	if($_GET["StyleName"] != "Select One" && $_GET["StyleName"] != "")
		$SQL .= " and orders.strStyle='".$_GET["StyleName"]."'";
		
		$SQL .= " order by strOrderNo";
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($_GET["StyleNo"]==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	?>
                      </select>
                      </td>
                      <td width="319"><img src="images/go.png" width="30" height="22" onclick="reloadPreOrderOrderNo();" /></td>
                    </tr>
                  </table></td>
                </tr>
            </table>              </td>
          </tr>
		  <?php
		  if ($_GET["StyleNo"] =="")
		  die("");
		  
		  ?>
          <tr>
            <td height="286"><table width="100%" class="bcgl1">
                <tr>
                  <td width="73%" height="253"><table width="100%">
                      <tr>
                        <td width="104" class="normalfnt">Factory<span class="compulsoryRed"> *</span></td>
                        <td colspan="2"><select name="cboFactory" class="txtbox" onchange="ChangeFactory();" style="width:210px" id="cboFactory">
                          <option value="Select One" selected="selected">Select One</option>
                          <?php
	
	$SQL = "SELECT intCompanyID,strName,strCity FROM companies c where intStatus=1 and intManufacturing=1 order by strName ;";
	
	$result = $db->RunQuery($SQL);
	
	$compID = $_SESSION["CompanyID"];
	
	while($row = mysql_fetch_array($result))
	{
		if ($_SESSION["CompanyID"] ==  $row["intCompanyID"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ." - "." ". $row["strCity"].""."</option>" ;
		}
		else
			echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ." - "." ". $row["strCity"].""."</option>" ;
	}
	
	?>
                        </select></td>
                        <td width="107" class="normalfnt">Merchandiser <span class="compulsoryRed">*</span></td>
                        <td width="221" class="normalfnt"><select name="cboMerchandiser" class="txtbox" style="width:170px"  id="cboMerchandiser">
                          <option value="Select One" >Select One</option>
                          <?php
	
	$SQL = "select 	intUserID from orders  where intStyleId = '" . $_GET["StyleNo"] ."';";
	
	$result = $db->RunQuery($SQL);
	
	$createdUser = "";
	
	while($row = mysql_fetch_array($result))
	{
		$createdUser =  $row["intUserID"];
	}

	$SQL = "SELECT useraccounts.Name, useraccounts.intUserID FROM useraccounts INNER JOIN userpermission ON useraccounts.intUserID = userpermission.intUserID INNER JOIN role ON userpermission.RoleID = role.RoleID WHERE role.RoleName = 'Merchandising' order by useraccounts.Name"; 

	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		if ($createdUser ==  $row["intUserID"])
			echo "<option selected=\"selected\" value=\"". $row["intUserID"] ."\">" . $row["Name"] ."</option>" ;
		else
			echo "<option value=\"". $row["intUserID"] ."\">" . $row["Name"]  ."</option>" ;
	}
	
	?>
                        </select></td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Sewing Factory <span class="compulsoryRed">*</span></td>
                        <td colspan="2"><select name="cboManuFactory" class="txtbox"  style="width:210px" id="cboManuFactory">
                          <option value=""  selected="selected">Select One</option>
                          <?php
	
	$SQL = "SELECT intCompanyID,strName,strCity FROM companies c where intStatus=1 and intManufacturing=1 order by strName;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ." - "." ". $row["strCity"].""."</option>" ;
	}
	
	?>
                        </select></td>
                         <td class="normalfnt">Order No <span class="compulsoryRed">*</span></td>
                        <td class="normalfnt"><input name="txtOrderNo" type="text" class="txtbox" id="txtOrderNo" style="width:168px;" maxlength="30" disabled="disabled"/>&nbsp;<select name="cboOrderType" id="cboOrderType" style="width:80px;">
                        <?php 
					   $sql = " select intTypeId,strTypeName from orders_ordertype where intStatus=1  ";
					  $result = $db->RunQuery($sql); 
					  while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"". $row["intTypeId"] ."\">" . trim($row["strTypeName"]) ."</option>"; 
						} 
					   ?>
                        </select></td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Style No<span class="compulsoryRed"> *</span></td>
                        <td colspan="2"><input name="txtStyleNo" type="text" disabled="disabled" class="txtbox" id="txtStyleNo" style="width:40px" maxlength="27" onkeyup="AutoCompleteStyleNos(event);" />
                        <input name="txtRepeatNo" disabled="disabled" type="text" style="width:162px;" class="txtbox" id="txtRepeatNo"  maxlength="3" /></td>
                        <td class="normalfnt">Qty <span class="compulsoryRed">*</span></td>
                        <td class="normalfnt"><!-- onkeyup="ChangeOrderQuantity();"-->
                          <input name="txtQTY" type="text" class="txtbox" id="txtQTY"  onblur="DisplayEfficiencyLevel();checkForValues(this);ChangeOrderQuantity();"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();"  onkeypress="return isValidZipCode(this.value,event);" value="1" style="width:68px; text-align:right" maxlength="9" />
                          <span class="normalfnt">&nbsp;&nbsp;&nbsp; Ex:Qty&nbsp;%</span>
                          <input name="txtEXQTY" type="text" class="txtbox" id="txtEXQTY" onblur="checkForValues(this);ChangeOrderQuantity();"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();"  onkeypress="return isValidZipCode(this.value,event);" value="0" style="width:20px; text-align:right" maxlength="3"/>
                        <img src="images/calculator1.png" title="Calculate consumtion data" width="16" height="16" onclick="ChangeOrderQuantity();" style="visibility:hidden" />                        </td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Style Name<span class="compulsoryRed"> *</span></td>
                        <td colspan="2"><input name="txtStyleName" type="text" class="txtbox" id="txtStyleName" style="width:208px" maxlength="100"  /></td>
                        <td class="normalfnt">SMV <span class="compulsoryRed">*</span></td>
                        <td><span class="normalfnt">
                          <input name="txtSMV" type="text" <?php if ($SMVEnabled == "false") { ?> disabled="disabled" <?php } ?> class="txtbox" id="txtSMV" onblur="DisplayEfficiencyLevel();checkForValues(this);" onmousedown="DisableRightClickEvent();"  onmouseout="EnableRightClickEvent();" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="0" style="width:68px; text-align:right" maxlength="7" onkeyup="CalculateCMRate();CalculateESC();" />
                        </span></td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Buyer <span class="compulsoryRed">*</span></td>
                        <td colspan="2"><select name="cboCustomer" class="txtbox" onchange="getGetDivisions();GetBuyingOffices();" style="width:210px" id="cboCustomer">
                          <option value="Select One" selected="selected">Select One</option>
                          <?php
	
	$SQL = "SELECT intBuyerID,strName FROM buyers where intStatus=1 order by strName;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
	}
	
	?>
                        </select></td>
                         <td class="normalfnt">Season</td>
                        <td><select name="dboSeason" class="txtbox" style="width:170px"  id="dboSeason">
                          <?php
	
	$SQL = "SELECT intSeasonId, strSeason FROM seasons where intStatus=1 order by strSeason;";
	
	$result = $db->RunQuery($SQL);
		echo "<option value=\"". "Null" ."\">" . "Select One" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intSeasonId"] ."\">" . $row["strSeason"] ."</option>" ;
	}
	
	?>
                        </select></td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Buying Office</td>
                        <td colspan="2"><select name="cboBuyingOffice" class="txtbox" style="width:210px"  id="cboBuyingOffice">
                          <?php
						  	$sql = "select buyerbuyingoffices.intBuyingOfficeId,buyerbuyingoffices.strName from orders inner join buyerbuyingoffices on orders.intBuyerID = buyerbuyingoffices.intBuyerID where orders.intStyleId = '$styleNo';";
						  	$result = $db->RunQuery($sql);
						?>
							<option value="Null">Select One</option>
						<?php	 
							while($row = mysql_fetch_array($result))
							{
						  ?>
                          <option value="<?php echo $row["intBuyingOfficeId"]; ?>"><?php echo $row["strName"]; ?></option>
                          <?php
						  	}
						  ?>
                        </select></td>
                        <td><span class="normalfnt">Schedule Method</span></td>
                        <td><select name="cboScheduleMethod" class="txtbox" id="cboScheduleMethod" style="width:170px">
                          <option value="SE">Style Wise</option>
                          <option value="SB">Style &amp; BPO Wise</option>
                          <option value="SBD">Style, BPO &amp; Delivery Wise</option>
                          <option value="SD">Style &amp; Delivery</option>
                        </select></td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Division<span class="compulsoryRed">*</span></td>
                        <td colspan="2"><select name="dboDivision" class="txtbox" style="width:210px"  id="dboDivision">
                          <?php
						  	$sql = "select buyerdivisions.intDivisionId,buyerdivisions.strDivision from orders inner join buyerdivisions on orders.intBuyerID = buyerdivisions.intBuyerID where orders.intStyleId = '$styleNo';";
						  	$result = $db->RunQuery($sql);
							?>
							<option value="Null">Select One</option>
							<?php
							while($row = mysql_fetch_array($result))
							{
						  ?>
                          <option value="<?php echo $row["intDivisionId"]; ?>"><?php echo $row["strDivision"]; ?></option>
                          <?php
						  	}
						  ?>
                        </select></td>
                         <td><span class="normalfnt">Order Unit </span></td>
                        <td><select name="cboOrderUnit" class="txtbox" style="width:170px"  id="cboOrderUnit">
                          <?php
	
	$SQL = "select strUnit, intUnitID from units where intStatus=1 order by strUnit;";
	
	$result = $db->RunQuery($SQL);
	$val = 'PCS';
	while($row = mysql_fetch_array($result))
	{
		if($val == strtoupper($row["strUnit"]))
			echo "<option  selected=\"selected\" value=\"". $row["intUnitID"] ."\">" . $row["strUnit"] ."</option>" ;
		else	
			echo "<option value=\"". $row["intUnitID"] ."\">" . $row["strUnit"] ."</option>" ;
	}
	
	?>
                        </select></td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Ref. No.</td>
                        <td colspan="2"><input name="txtRefNo" type="text" class="txtbox" id="txtRefNo" style="width:208px" maxlength="30"  /></td>
                         <td  class="normalfnt">Cost Per Min</td>
                        <td ><input name="txtCostPerMinute" type="text" disabled="disabled" class="txtbox" id="txtCostPerMinute" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="<?php
	
	/*$SQL = "SELECT reaFactroyCostPerMin FROM companies where intCompanyID=" . $_SESSION["CompanyID"]  . ";";
	
	$result = $db->RunQuery($SQL);

	while($row = mysql_fetch_array($result))
	{
		echo $row["reaFactroyCostPerMin"]  ;
	}*/
	
	?>" style="width:68px; text-align:right" /></td>
                      </tr>
                      <tr>
                        <td height="20"  class="normalfnt" >Eff. Level</td>
                        <td valign="bottom" width="62" ><input name="txtEffLevel" onblur="checkForValues(this);"  type="text" class="txtbox" id="txtEffLevel" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="0" size="4" onkeyup="changeEffLevel();" maxlength="4" style="text-align:right" readonly="readonly" /></td>
                        <td valign="bottom" width="183" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="76">&nbsp;</td>
                            <td width="163">&nbsp;</td>
                          </tr>
                        </table></td>
                        <td  class="normalfnt">Total Fabric ConPc</td>
                        <td >
                          <input name="txtTotFabConPc" type="text" disabled="disabled" class="txtbox" id="txtTotFabConPc" value="<?php	
	$SQL = "select coalesce(sum(OD.reaConPc),0)as totConPc from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where intStyleId='$styleNo' and MIL.intMainCatID=1;";	
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		echo $row["totConPc"];
	}	
	?>" style="width:68px; text-align:right" />                        </td>
                      </tr>
                      <tr>
                        <td height="23" class="normalfnt" ><span class="normalfnt" >Product Category</span></td>
                        <td colspan="2" valign="bottom" ><select name="cboProductCategory" class="txtbox" style="width:210px"  id="cboProductCategory">
<?php	
	$SQL = "select  intCatId,strCatName from productcategory where intStatus = 1 order by strCatName;";	
	$result = $db->RunQuery($SQL);
		echo "<option value=\"". $row["intCatId"] ."\">" . $row["strCatName"] ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intCatId"] ."\">" . $row["strCatName"] ."</option>" ;
	}	
?>
                        </select></td>
                        <td  class="normalfnt">ESC</td>
                        <td ><input name="txtESC" type="text" disabled="disabled" class="txtbox" id="txtESC" onblur="checkForValues(this);" value="0"  style="text-align:right; width:68px;" maxlength="9" />                                        </td>
                      </tr>
                      <tr>
                        <td height="23" class="normalfnt" style="visibility:hidden" >Labour Cost </td>
                        <td valign="bottom" style="visibility:hidden" ><input name="txtLabourCost" type="text" <?php if ($LabourCostEnabled == "false") { ?> disabled="disabled" <?php } ?> class="txtbox" id="txtLabourCost" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onblur="checkForValues(this);" value="0" size="2" style="text-align:right" /></td>
                        <td valign="bottom" ><span class="normalfnt" style="visibility:hidden">No of Lines<span class="normalfnt" style="visibility:hidden">
                          <input name="txtNoLines" onblur="checkForValues(this);" type="text" class="txtbox"  id="txtNoLines"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();"  onkeypress="return isNumberKey(event);" value="1" size="15" />
                        </span></span></td>
                        <td height="23" class="normalfnt">Sub Contract Qty </td>
                        <td>
                          <input name="txtSubContactQty" type="text" style="text-align:right;" class="txtbox" id="txtSubContactQty" size="10" maxlength="30" onblur="checkForValues(this);" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();"  onkeypress="return isNumberKey(event);" />
                          <a href="#"><img src="images/view2.png" alt="save" width="62" height="21" border="0" onclick="ShowSubContractWindow();" />
                        </a></td>
                      </tr>
                      
                  </table></td>
                  <td width="27%" rowspan="2" valign="top"><table width="100%" height="249" class="bcgl1">
                    <!--DWLayoutTable-->
                      <tr>
                        <td height="25" colspan="3" bgcolor="#FDEAA8" class="normalfnth2" align="center"><label> Costing</label></td>
                      </tr>
                      <tr>
                        <td width="196" height="22" class="normalfnt">Finance %</td>
              <td colspan="2"><input name="txtFinancePercentage" type="text" class="txtbox" onblur="checkForValues(this);" id="txtFinancePercentage" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="0" size="2"  onkeyup="CalculateFigures();" maxlength="4" style="text-align:right" />
                            <input name="txtFinanceAmount" type="text" onblur="checkForValues(this);" disabled="disabled" class="txtbox" id="txtFinanceAmount" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="0"  style="text-align:right; width:54px" maxlength="9" /></td>
                      </tr>
                      <tr>
                        <td height="22" class="normalfnt">Material Cost</td>
                        <td colspan="2">
                          <input name="txtMaterialCost" type="text" disabled="disabled" class="txtbox" id="txtMaterialCost" onblur="checkForValues(this);" value="0" size="12" style="text-align:right" maxlength="9" />                        </td>
                      </tr>
                      <tr>
                        <td height="22" class="normalfnt">SMV Rate</td>
                        <td colspan="2">
                          <input name="txtSMVRate" type="text" class="txtbox" id="txtSMVRate" onblur="set4deci(this);" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return CheckforValidDecimal(this.value, 4,event);"  onkeyup="CalculateCMValueKeyPress();CalculateESC();calculateProfit();" value="0" size="12" style="text-align:right" maxlength="9" />                        </td>
                      </tr>
                      <tr>
                        <td height="22" class="normalfnt">CM Value</td>
                        <td colspan="2">
						<!--comment Remove this function CalculateESCWithCMBox(); in txtCMValue-->
                          <input name="txtCMValue" type="text" class="txtbox" id="txtCMValue" onblur="checkForValues(this);set4deci(this);" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onkeyup="CalculateCMRate();calculateProfit();" value="0" size="12" style="text-align:right" maxlength="9"/>                        </td>
                      </tr>
                      <tr>
                        <td height="24" class="normalfnt">Target FOB <span class="compulsoryRed">*</span></td>
                        <td width="162" valign="top">
<!--                          <input name="txtTargetFOB" type="text" class="txtbox" id="txtTargetFOB" onblur="checkForValues(this);" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onkeyup="ChangeFOB();" value="0" style="width:100px;" />-->
                          <input name="txtTargetFOB" type="text" class="txtbox" id="txtTargetFOB" onblur="set4deci(this);" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="0"  size="8" onkeyup="CalculateESC();calculateProfit();" style="text-align:right;" maxlength="9" />
                        <input name="chkFixed" type="checkbox" id="chkFixed" value="checkbox" checked="checked" /></td>
                      <td width="32" align="left" valign="middle" style="visibility:hidden"><strong class="error1">F</strong></td>
                      </tr>
                      <tr>
                        <td height="22" class="normalfnt">Profit</td>
                        <td colspan="2"><input type="text" name="txtProfit" id="txtProfit" size="12" disabled="disabled" style="text-align:right" maxlength="9"/></td>
                      </tr>
                      <tr>
                        <td height="22" class="normalfnt">UP Charge</td>
                        <td colspan="2">
                          <input name="txtUPCharge" type="text" class="txtbox" id="txtUPCharge" onblur="checkForValues(this);" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="0" size="12" onkeyup="CalculateCMRate();" style="text-align:right" maxlength="9" />                        </td>
                      </tr>
                      <tr>
                        <td height="22" class="normalfnt">Reason</td>
                        <td colspan="2" rowspan="2"><textarea name="txtUPChargeReason" type="text" class="txtbox" id="txtUPChargeReason"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" value="" onkeypress="return imposeMaxLength(this,event, 50);"  rows="2" cols="9"></textarea></td>
                      </tr>
                      <tr >
                        <td height="22" class="normalfnt" style="visibility:hidden">Margin
                        <input name="txtMargin" type="text" class="txtbox" id="txtMargin" onblur="checkForValues(this);" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="0" size="12" style="text-align:right" /></td>
                      </tr>
                      
                  </table></td>
                </tr>
                <!--<tr bgcolor="#d6e7f5" style="visibility:hidden">
                  <td><table width="98%" align="center">
                      <tr>
                        <td width="78" class="normalfnt">&nbsp;</td>
                        <td width="117">&nbsp;</td>
                        <td width="101" class="normalfnt">&nbsp;</td>
                        <td width="105">&nbsp;</td>
                        <td width="83" class="normalfnt" style="visibility:hidden">No of Lines</td>
                        <td width="117" style="visibility:hidden">&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>-->
            </table></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td height="80" valign="top"><table width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td width="90%" height="20" bgcolor="#FFD5AA"><div align="center" class="normalfnth2">Consumption</div></td>
            <td width="10%" bgcolor="#FFD5AA"><a href="#"><img src="images/add-new.png" width="109" height="18" border="0"  onclick="ShowItems();" /></a></td>
          </tr>
          <tr>
            <td colspan="2">
				<table width="100%">
				<tr>
				<td style="height:220px">           
           <!-- <div id="divcons" style="width:950px;">-->
                <table width="100%" id="tblConsumption" bgcolor="#CCCCFF"  cellpadding="0" cellspacing="1">
                <thead>
                  <tr bgcolor="#804000">
                    <th width="40px" height="27" class="normaltxtmidb2">Edit</th>
                    <th width="40px" class="normaltxtmidb2">Del</th>
                    <th width="255px" class="normaltxtmidb2">Description</th>
                    <th width="80px" class="normaltxtmidb2">Con. Pc</th>
                    <th width="80px" class="normaltxtmidb2">Unit</th>
                    <th width="17px" class="normaltxtmidb2">Unit Price</th>
                    <th width="13px" class="normaltxtmidb2">Waste</th>
                    <th width="60px" class="normaltxtmidb2"> Req. Qty</th>
                    <th width="60px" class="normaltxtmidb2">Total Qty </th>
                    <th width="60px" class="normaltxtmidb2">Tot Value </th>
                    <th width="60px" class="normaltxtmidb2">Cost PC</th>
                    <th width="68px" class="normaltxtmidb2">Origin</th>
                    <th width="40px" class="normaltxtmidb2">Freight</th>
					<th width="80px" class="normaltxtmidb2">Purch. Qty</th>
                    <th width="80px" class="normaltxtmidb2">Purch. Price </th>
                    <th width="40px" class="normaltxtmidb2">Mill</th>
                    <th width="40px" class="normaltxtmidb2">Main Fabric </th>
                    <!--<td width="80px" class="normaltxtmidb2">Transport Cost</td>
					<td width="80px" class="normaltxtmidb2">Clearing Cost</td>
					<td width="80px" class="normaltxtmidb2">Interest</td>
					<td width="80px" class="normaltxtmidb2">Export Cost</td>
					<td width="80px" class="normaltxtmidb2">Category</td>-->
                  </tr>
                  </thead>
                  <tbody></tbody>
                </table>
                <!--</div>-->
            </td>
          </tr>
      </table>
      
      </td>		
      <td>
	     
      </td>		
				</tr>				
				</table> 
  <!--   
<div style="cursor: pointer;" class="div_horizontalscroll" onmouseover="this.style.cursor='pointer'">
	<div style="float: left; width: 50%; height: 100%;" onmousedown="right();" onmouseup="right(1);"><img class="buttonRight" src="images/uF033.png"></div>
	<div style="float: right; width: 50%; height: 100%;" onmousedown="left();" onmouseup="left(1);"><img class="buttonLeft" src="images/uF034.png"></div>
</div>  -->    
      </td>
    </tr>
    <tr>
      <td height="21" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td height="99" valign="top"><table id="tblDelivery"  width="100%" cellpadding="0" cellspacing="1">
       <!-- <tr>
          <td height="20" colspan="6" bgcolor="#FFD5AA"><div align="center" class="normalfnth2">Delivery Schedule</div></td>
          <td height="20"  bgcolor="#FFD5AA"><div align="right"><a href="#"><img src="images/add-new.png" width="109" height="18" border="0" onclick="ShowAddDeliverySchedule();" /></a></div></td>
        </tr>-->
        <tr>
        <td colspan="11"><table width="100%" border="0">
          <tr>
            <td width="90%" bgcolor="#FFD5AA"><div align="center" class="normalfnth2">Delivery Schedule</div></td>
            <td width="10%" bgcolor="#FFD5AA"><div align="right"><a href="#"><img src="images/add-new.png" width="109" height="18" border="0" onclick="ShowAddDeliverySchedule();" /></a></div></td>
          </tr>
        </table></td>
        </tr>
        <tr>
          <td width="5%" height="24" bgcolor="#804000" class="normaltxtmidb2">Edit</td>
          <td width="4%" bgcolor="#804000" class="normaltxtmidb2">Del</td>
          <td width="11%" bgcolor="#804000" class="normaltxtmidb2">Delivery Date</td>
          <td width="5%" bgcolor="#804000" class="normaltxtmidb2">Qty.</td>
          <td width="7%" bgcolor="#804000" class="normaltxtmidb2">With Ex. Qty</td>
          <td width="13%" bgcolor="#804000" class="normaltxtmidb2">Shipping Mode</td>
          <td width="15%" bgcolor="#804000" class="normaltxtmidb2">Remarks</td>
         <td width="7%" bgcolor="#804000" class="normaltxtmidb2">BPO </td>
          <td width="12%" bgcolor="#804000" class="normaltxtmidb2">Estimated Date</td>
           <td width="13%" bgcolor="#804000" class="normaltxtmidb2">Hand Over Date</td>
            <td width="8%" bgcolor="#804000" class="normaltxtmidb2">Ref. No.</td>
        </tr>
       
      </table></td>
    </tr>
    <tr>
      <td bgcolor="#FFD5AA"><table width="100%" align="center">
          <tr>
            <td width="28%"><p align="right"><img src="images/partDetails.png" alt="Style Buyer PO" width="115" height="24" class="mouseover" onclick="ShowPartDetailsWindow();"/></p></td>
            <?php 
            /*if ($EnableAdvancedBuyePO == "true")
            {
            
            echo "<td width=\"19%\"><div align=\"center\"><img src=\"images/sbpo.png\" alt=\"Style Buyer PO\" width=\"171\" height=\"24\" class=\"mouseover\" onclick=\"showBPODeliveryForm();\" style=\"visibility:hidden\"/></div></td>";
             
            }
            else
            {
            
            echo "<td width=\"16%\"><div align=\"center\"><img src=\"images/sbpo.png\" alt=\"Style Buyer PO\" width=\"171\" height=\"24\" class=\"mouseover\" onclick=\"showStyleBuyerPOForm();\" style=\"visibility:hidden\"/></div></td>"; 
            
            }*/
            ?>
            
            <td width="12%"><div align="center"><a href="#"><img src="images/save.png" alt="save" width="84" height="24" border="0" onclick="UpdatePreOrder();" /></a></div></td>
            <td width="13%"><a href="#"><img src="images/send2app.png" alt="send to Approval" width="171" height="24" border="0" onclick="validateApprovalPossibility();"  /></a></td>
            <td width="9%"><a href="#"><img src="images/report.png" width="108" height="24" border="0" onclick="ShowPreOrderReport();" /></a></td>
            <td width="7%"><a href="main.php"><img src="images/close.png" width="97" height="24" border="0" /></a></td>
            <td width="10%">&nbsp;</td>
			<td width="21%">&nbsp;</td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
<div style="left:550px; top:450px; z-index:10; position:absolute; width:240px; visibility:hidden" id="loadUnitPopup">
	<table width="240" cellpadding="0" cellspacing="0" class="bcgl1" bgcolor="#FFFFFF">
	<tr><td colspan="3" align="right" bgcolor="#550000" class="mainHeading">
    <table width="240" cellpadding="0" cellspacing="0">
    <tr><td width="200">Unit conversion</td>
    <td width="20"><input  id="currRowId" type="hidden"  /></td>
   <td width="20" align="right"><img src="images/cross.png" onClick="closeUnitPopup();" alt="Close" name="Close" width="17" height="17" id="Close"/></td></tr>
    </table>
			</td>
		</tr>
		<tr>
		  <td height="20" class="normalfnt" >ConPc To Convert </td>
		  <td><input type="text" id="txtUCConpc" name="txtUCConpc" style="width: 80px; text-align: right;" onkeypress="return CheckforValidDecimal(this.value,<?php echo $xml->SystemSettings->ConsumptionDecimalLength;?>,event);"/></td>
		  <td>&nbsp;</td>
	  </tr>
		<tr>
		  <td height="20" class="normalfnt">Source Unit </td>
		  <td><select name="cboSourceUnit" id="cboSourceUnit" style="width:120px;" >
          </select></td>
		  <td>&nbsp;</td>
	  </tr>
		<tr>
		  <td width="108" height="20" class="normalfnt">Target Unit</td>
		<td width="120"><select name="cboUnitsC" id="cboUnitsC" style="width:120px;" >
    </select></td>
    <td width="20">&nbsp;</td>
		</tr>
		<tr>
		  <td height="20" colspan="3" align="center" ><input name="s" type="button" class="normalfnt" value="Convert" onclick="checkUnitConvertion();"/></td>
	  </tr>
	</table>
</div>
<div id="lyrLoading"><img src="images/loadingimg.gif" alt="loading" width="68" height="15" /></div>
<script type="text/javascript">
ScrollToElement(200,300);
var buyerPOQty = <?php

$SQL = "select COALESCE(sum(dblQty),0) as bpoQty from style_buyerponos where intStyleId = '$styleNo'";
$result = $db->RunQuery($SQL);

while($row = mysql_fetch_array($result))
{
	echo $row["bpoQty"];
}
?>;

var reportName = '<?php

$xml = simplexml_load_file('config.xml');
$reportname = $xml->PreOrder->ReportName;
echo $reportname;
?>';

var delSchedulerequired = <?php
$delschedule = $xml->PreOrder->DeliveryScheduleRequiredForApproval;
echo $delschedule;
?>;

var buyerPOrequired = <?php
echo $xml->PreOrder->BuyerPORequiredForApproval;
?>;

var consumptionDecimalLength = <?php
echo $xml->SystemSettings->ConsumptionDecimalLength;
?>;
var canIncreaseItemUnitprice='<?php echo $PP_canIncreaseItemUnitprice; ?>';
var editDelScheduleAfterFirstRevision = '<?php echo $PP_editDelScheduleAfterFirstRevision  ?>';
var editDelScheduleAfterRevision = '<?php echo $PP_editDelScheduleAfterRevision;  ?>';
</script>
<?php
include "dbConfigLoader.php";
?>
<script src="js/jquery.fixedheader.js" type="text/javascript"></script>
</html>
