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
<title>GaPro | Style Items - Return To Stores</title>


<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>
<!--start -for calander-->
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="javascript/calendar/theme.css" />
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="../javascript/styleNoOrderNoLoading.js" type="text/javascript"></script>

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

<script src="../javascript/script.js" type="text/javascript"></script>
<script src="java.js" type="text/javascript"></script>
<!--End -for calander-->
</head>

<body >
<form>
  <tr>
    <td><?php include '../Header.php'; ?></td>
  </tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="bcgl1">
  <tr>
    <td height="26" class="mainHeading">Style Items - Return To Stores </td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td valign="top"><table width="100%" border="0" class="bcgl1">
            <tr>
			<td width="9%" height="25" class="normalfnt">Style No </td>
            <td width="19%" class="normalfnt"><select name="cboStyles" class="txtbox" id="cboStyles" style="width:170px" onchange="getStylewiseOrderNoNew('ReturnToStoresGetStylewiseOrderNo',this.value,'cboStyleID');getScNo('ReturnToStoresgetStyleWiseSCNum','cboSCNO');">
<?php
		$SQL="SELECT DISTINCT ".
				"orders.strStyle  ".
				"FROM ".
				"issuesdetails AS ID ".
				"Inner Join orders ON ID.intStyleId = orders.intStyleId  ".
				"Inner Join issues ON ID.intIssueNo = issues.intIssueNo AND ID.intIssueYear = issues.intIssueYear ".
				"WHERE ".
				"ID.dblBalanceQty > 0 AND ".
				"issues.intCompanyID ='$companyId' order by orders.strStyle";	
	 
			 echo "<option value =\"".""."\">"."Select One"."</option>";
		 $result =$db->RunQuery($SQL);		 
		 while($row =mysql_fetch_array($result))
		 {
			if($_POST["strStyle"] == $row["strStyle"])
				echo "<option selected=\"selected\" value=\"".$row["strStyle"]."\">".$row["strStyle"]."</option>";
			else
				echo "<option value=\"".$row["strStyle"]."\">".$row["strStyle"]."</option>";
		 }			 
?>
            </select></td>
			
              <td width="3%" class="normalfnt">&nbsp;</td>
              <td width="25%" class="normalfnt">&nbsp;</td>
              <td width="11%" class="normalfnt">Buyer PO No</td>
              <td width="33%"><select name="cboBuyerPoNo" class="txtbox" id="cboBuyerPoNo" style="width:170px" onchange="ValidatePopUpItems();" >
              </select></td>
            </tr>
            <tr>
              <td height="22" class="normalfnt">Order No</td>
              <td><select name="cboStyleID" class="txtbox" id="cboStyleID" style="width:170px" onchange="getSC('cboSCNO','cboStyleID');getStyleNoFromSC('cboSCNO','cboStyleID');LoadBuyerPoNo();" >
<?PHP		
		$str_style="SELECT DISTINCT ".
				"ID.intStyleId, ".
				"orders.strOrderNo  ".
				"FROM ".
				"issuesdetails AS ID ".
				"Inner Join orders ON ID.intStyleId = orders.intStyleId  ".
				"Inner Join issues ON ID.intIssueNo = issues.intIssueNo AND ID.intIssueYear = issues.intIssueYear ".
				"WHERE ".
				"ID.dblBalanceQty > 0 AND ".
				"issues.intCompanyID ='$companyId' order by orders.strOrderNo"; 
		$style_result =$db->RunQuery($str_style);
		
			echo "<option value =\"".""."\">"."Select One"."</option>";
		while ($row_style=mysql_fetch_array($style_result))
		{		
			echo "<option value=\"".$row_style["intStyleId"]."\">".$row_style["strOrderNo"]."</option>";
		}
?>
              </select></td>
              <td><span class="normalfnt">SC</span></td>
              <td><span class="normalfnt">
                <select name="cboSCNO" class="txtbox" id="cboSCNO" style="width:100px" onchange="getStyleNoFromSC('cboSCNO','cboStyleID');LoadBuyerPoNo();" >
                  <?PHP		
$SQL="SELECT DISTINCT ".
"ID.intStyleId, ".
"specification.intSRNO ".
"FROM ".
"issuesdetails AS ID ".
"Inner Join specification ON ID.intStyleId = specification.intStyleId ".
"Inner Join issues ON ID.intIssueNo = issues.intIssueNo AND ID.intIssueYear = issues.intIssueYear ".
"WHERE ".
"ID.dblBalanceQty > 0 AND ".
"issues.intCompanyID ='$companyId' ".
"Order by specification.intSRNO DESC";
$result =$db->RunQuery($SQL);
	echo "<option value =\"".""."\">"."Select One"."</option>";
while ($row=mysql_fetch_array($result))
{		
	echo "<option value=\"".$row["intStyleId"]."\">".$row["intSRNO"]."</option>";
}
?>
                </select>
              </span></td>
              <td class="normalfnt">Return By</td>
              <td colspan="3"><select name="cboReturnBy" class="txtbox" id="cboReturnBy" style="width:285px">
                <?php
	
	$sqlreturn="select intDepID,strDepartment from department where intStatus=1";
	$result_sqlreturn=$db->RunQuery($sqlreturn);
		
		echo "<option value=\"".""."\">"."Select Department"."</option>";
		
	while($rowsqlreturn=mysql_fetch_array($result_sqlreturn))
	{
		echo "<option value =\"".$rowsqlreturn["intDepID"]."\">".$rowsqlreturn["strDepartment"]."</option>";
	}
			  
?>
              </select></td>
            </tr>
            <tr>
              <td height="22" class="normalfnt">Return NO </td>
              <td><input  type="text" name="txtReturnNo" class="txtbox" id="txtReturnNo" style="width:80px" readonly="" /><img src="../images/view.png" alt="view" width="91" height="19" align="absbottom" onclick="SearchPopUp();" /></td>
				 <td><span class="normalfnt">Date</span></td>
				 <td><input  type="text" name="cboGatePassNo2" class="txtbox" id="cboGatePassNo2" style="width:98px" readonly="" value="<?php echo date ("d/m/Y") ?>" /></td>
				 <?PHP
$sqlsetting="select strValue from settings where strKey='CommonStockActivate'";
$result_setting=$db->RunQuery($sqlsetting);
while($row_setting=mysql_fetch_array($result_setting))
{
	$commonBinID	= $row_setting["strValue"];	
}

?>

 <td width="11%" class="normalfnt">Main Stores</td>
              <td width="33%" colspan="3"><select name="cboMainStores" class="txtbox" id="cboMainStores" style="width:285px" onchange="LoadSubStores();">
                <?php
	
	$sqlstores="select strMainID,strName from mainstores where intStatus=1 AND intCompanyId=$companyId";
	$result_stores=$db->RunQuery($sqlstores);
		
		echo "<option value=\"".""."\">"."Select Main Store"."</option>";
		
	while($rowstores=mysql_fetch_array($result_stores))
	{
		echo "<option value =\"".$rowstores["strMainID"]."\">".$rowstores["strName"]."</option>";
	}
?>
              </select></td>
            </tr>
            <tr>
              <td class="normalfnt">Remarks</td>
              <td colspan="3"><input name="txtRemarks" type="text" class="txtbox" id="txtRemarks" style="width:307px" maxlength="50"/></td>

             <td  class="normalfnt">Sub Stores </td>
<td ><select name="cboSubStores" class="txtbox" id="cboSubStores" style="width:285px">
</select></td>
            </tr>
            

        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="mainHeading2">
          <tr>
            <td width="32%" title="<?php echo $commonBinID ;?>" id="commonBinID">&nbsp;</td>
            <td width="57%" ></td>
            <td width="11%" ><img src="../images/add-new.png" id="cmdAddNew" width="109" height="18" onclick="ValidatePopUpItems();" /></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><div id="divMain" style="overflow:scroll; height:300px; width:950px;">
          <table id="tblMain"width="932" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
            <tr class="mainHeading4">
              <td width="-1%" height="25" >Del</td>
			  <td width="10%">Issue No</td>
              <td width="19%">Description</td>
              <td width="13%">Style No</td>
              <td width="7%">BuyerPoNo</td>
              <td width="9%">Color</td>
              <td width="7%">Size</td>
              <td width="6%">Unit</td>
              <td width="8%">Qty</td>
              <td width="8%">Issue Qty</td>
              <td width="10%">Bin</td>
              <td width="4%" >GRN No</td>
              <td width="4%" >GRN Type</td>
              </tr>
<!--            <tr>
              <td class="normalfnt"><img src="../images/del.png" alt="del" width="15" height="15"/></td>
             <td class="normalfnt">NA</td>
			  <td class="normalfntMidSML">Tags Hand Bag- Ref# - TIWLH</td>
              <td class="normalfntMidSML">0</td>
              <td class="normalfntMidSML">0.2544</td>
              <td class="normalfntMidSML">NA</td>
              <td class="normalfntMidSML">NA</td>
              <td class="normalfntMidSML">PCS</td>
              <td class="normalfntRite">0.20</td>
              <td class="normalfntMidSML"><input type="text" name="txtIssueQty" id="txtIssueQty" class="txtbox" size="8" style="text-align:right" onkeypress="return isNumberKey(event);" value="0" /></td>              
              <td class="normalfntMidSML"><img src="../images/location.png" alt="add" width="80" height="15" /></td>
              </tr>-->
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr >
    <td height="30"><table width="100%" border="0" align="center">
      <tr><td colspan="8" align="center" valign="middle"><a href="returntostores.php"><img src="../images/new.png" alt="new" border="0" id="cmdNew" width="96" height="24" /></a>
      <img src="../images/save.png" alt="Save" name="cmdSave" id="cmdSave" onclick="SaveValidation(0);" />
      <img src="../images/conform.png" alt="confirm" id="cmdConfirm" width="115" height="24" style="display:none" onclick="Confirm();"/>
      <img src="../images/cancel.jpg" alt="cancel" id="cmdCancel" name="cmdCancel" width="104" height="24" style="display:none" onclick="Cancel();" />
      <img src="../images/report.png" alt="Report" border="0" width="108" height="24" onclick="ViewReport();" />
      <a href="../main.php"><img src="../images/close.png" alt="close" width="97" height="24" border="0" /></a>
      </td></tr>	
     
    </table></td>
  </tr>
</table>
</form>
<!--Start - Search popup-->
<div style="left:418px; top:142px; z-index:10; position:absolute; width: 261px; visibility:hidden; height: 61px;" id="NoSearch" >
  <table width="260" height="71" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
            
            <td  colspan="6" class="mainHeading"><img src="../images/cross.png" alt="rep" align="right" onclick="closeFindReturnNo();" /></td>
          </tr>
          <tr>
		  	<td width="4" height="22" class="normalfnt"></td>
            <td width="44" height="22" class="normalfnt">State </td>
            <td width="108"><select name="select3" class="txtbox" id="cboState" style="width:100px" onchange="LoadPopUpNo();">              
              <option value="0">Saved</option>
			  <option value="1">Confirmed</option>              
			  <option value="10">Cancelled</option>
            </select></td>
            <td width="37" class="normalfnt">Year</td>
            <td width="55"><select name="select4" class="txtbox" id="cboYear" style="width:55px" onchange="LoadPopUpNo();">
             
			   <?php
	
	$SQL = "SELECT DISTINCT intReturnYear FROM returntostoresheader ORDER BY intReturnYear DESC;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["intReturnYear"] ."\">" . $row["intReturnYear"] ."</option>" ;
	}
	
	?>
            </select></td>
            <td width="10">&nbsp;</td>
          </tr>
          <tr>
		  <td width="4" height="27" class="normalfnt"></td>
            <td><div align="center" class="normalfnt">Job No</div></td>
            <td><select name="select" class="txtbox" id="cboNo" style="width:100px" onchange="loadPopUpReturnToStores();">
			<option value="Select One" selected="selected">Select One</option>
            </select>            </td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
  </table>
		

</div>
<!--End - Search popup-->
<script type="text/javascript" language="javascript">
var confirmReturn = <?php 
if($PP_AllowConfirmReturnToStores)
	echo "true";
else
	echo "false";

?>
</script>
<script type="text/javascript" src="returntostores.js"></script>
</body>
</html>