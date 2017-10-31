<?php
	session_start();
	include "../../Connector.php";
	$backwardseperator = "../../";
	$ReturnUserID		= $_POST["cboUser"];
	$CompanyID			= $_POST["cboCompany"];
	$ReturnNoFrom		= $_POST["ReturnNoFrom"];
	$ReturnNoTo			= $_POST["ReturnNoTo"];
	$GrnNoFrom			= $_POST["GrnNoFrom"];
	$GrnNoTo			= $_POST["GrnNoTo"];
	$DateFrom			= $_POST["DateFrom"];	
	 $DateFromArray		= explode('/',$DateFrom);
  	  $formatedfromDate = $DateFromArray[2]."-".$DateFromArray[1]."-".$DateFromArray[0];
  	$DateTo				= $_POST["DateTo"];
     $DateToArray		= explode('/',$DateTo);
      $formatedToDate   = $DateToArray[2]."-".$DateToArray[1]."-".$DateToArray[0];
	$chkDate			= $_POST["chkDate"];
	$StyleID		 	= $_POST["cboScNo"];
	$BuyerPoNo		 	= $_POST["cboBuyerPoNo"];
	$Description        = $_POST["cboDescription"];
	$Category			= ($_POST["cbocategory"]=="" ? 1:$_POST["cbocategory"]);
	$Supplier			= $_POST["cboSupplier"];
	$txtMatItem			= $_POST["txtMatItem"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Style Items :: Return To Supplier List & Report</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>
<!--<script type="text/javascript" src="../StyleItemGatePass/Details/gatePassDetails.js"></script>-->
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>

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
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
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

<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../../java.js" type="text/javascript"></script>
</head>
<body>

<form name="frmReturnToSupplierListReport" id="frmReturnToSupplierListReport" action="returntosupplierlistreport.php" method="post">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td height="26" bgcolor="#316895" class="TitleN2white"><table width="100%" border="0">
      <tr>
        <td width="24%"><div align="center">Style Items - Return To Supplier Listing & Report
          <select name="cbocategory" class="txtbox" id="cbocategory" style="width:130px">
            <option value="2">All Details</option>            
            <option value="1">Confirmed Details</option>
            <option value="10">Cancel Details</option>

          </select>
        </div></td>
        </tr>
    </table></td>
  </tr>
  <tr><td><table width="950" border="0" cellspacing="0" cellpadding="2" class="bcgl1">
    <tr>
      <td><table width="948" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
        <tr>
          <td width="100" height="20">Return No From</td>
          <td width="146"><select name="ReturnNoFrom" class="txtbox" id="ReturnNoFrom" style="width:130px">
            <?php
		$SQL ="SELECT DISTINCT CONCAT(intReturnToSupYear , '/' , intReturnToSupNo) AS ReturnNo FROM returntosupplierheader ORDER BY intReturnToSupNo,intReturnToSupYear;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["ReturnNoFrom"]==$row["ReturnNo"])
					echo "<option selected=\"selected\"value=\"". $row["ReturnNo"] ."\">" . $row["ReturnNo"] ."</option>" ;
				else
				echo "<option value=\"".$row["ReturnNo"]."\">".$row["ReturnNo"]."</option>";
			}
	
 	?>
          </select></td>
          <td width="36">To</td>
          <td width="143"><select name="ReturnNoTo" class="txtbox" id="ReturnNoTo" style="width:130px">
            <?php
 
		$SQL ="SELECT DISTINCT CONCAT(intReturnToSupYear , '/' , intReturnToSupNo) AS ReturnNo FROM returntosupplierheader ORDER BY intReturnToSupNo,intReturnToSupYear;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["ReturnNoTo"]==$row["ReturnNo"])
					echo "<option selected=\"selected\"value=\"". $row["ReturnNo"] ."\">" . $row["ReturnNo"] ."</option>" ;
				else
				echo "<option value=\"".$row["ReturnNo"]."\">".$row["ReturnNo"]."</option>";
			}
	
 	?>
          </select></td>
          <td width="29"><input  type="checkbox" name="chkDate" id="chkDate"  onclick="DateDisable(this);" <?php if($chkDate == 'on'){?> checked="checked" <?php }?>/></td>
          <td width="75">Date From</td>
          <td width="135"><input name="DateFrom" type="text" class="txtbox" id="DateFrom" style="width:108px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($DateFrom=="" ? date ("d/m/Y"):$DateFrom) ?>" <?php if($chkDate != 'on'){?> disabled="disabled" <?php }?>/><input name="reset" id="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value=""/></td>
          <td width="53">To</td>
          <td width="147"><input name="DateTo" type="text" class="txtbox" id="DateTo" style="width:107px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($DateTo=="" ? date ("d/m/Y"):$DateTo) ?>" <?php if($chkDate != 'on'){?> disabled="disabled" <?php }?>/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
          <td width="84" rowspan="5"><img src="../../images/search.png"  alt="search" width="80" height="24" onclick="SubmitForm();" /></td>
        </tr>
        <tr>
          <td height="20">GRN No From </td>
          <td><select name="GrnNoFrom" class="txtbox" id="GrnNoFrom" style="width:130px">
            <?php
 
		$SQL ="SELECT DISTINCT CONCAT(intGrnYear , '/' , intGrnNo) AS GrnNo FROM returntosupplierdetails ORDER BY intGrnYear,intGrnNo;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["GrnNoFrom"]==$row["GrnNo"])
					echo "<option selected=\"selected\"value=\"". $row["GrnNo"] ."\">" . $row["GrnNo"] ."</option>" ;
				else
					echo "<option value=\"".$row["GrnNo"]."\">".$row["GrnNo"]."</option>";
			}
	
 	?>
          </select></td>
          <td>To</td>
          <td><select name="GrnNoTo" class="txtbox" id="GrnNoTo" style="width:130px">
            <?php
 
		$sqlGrnTo ="SELECT DISTINCT CONCAT(intGrnYear , '/' , intGrnNo) AS GrnNoTo FROM returntosupplierdetails ORDER BY intGrnYear,intGrnNo;";
		
			$result_GrnTo =$db->RunQuery($sqlGrnTo);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row_grnto=mysql_fetch_array($result_GrnTo))
			{
				if($_POST["GrnNoTo"]==$row_grnto["GrnNoTo"])
					echo "<option selected=\"selected\"value=\"".$row_grnto["GrnNoTo"]."\">".$row_grnto["GrnNoTo"]."</option>";
				else
					echo "<option value=\"".$row_grnto["GrnNoTo"]."\">".$row_grnto["GrnNoTo"]."</option>";
			}
	
 	?>
          </select></td>
          <td>&nbsp;</td>
          <td>Supplier</td>
          <td colspan="3"><select name="cboSupplier" class="txtbox" id="cboSupplier" style="width:298px">
            <?php
 
		$SQL ="select distinct intRetSupplierID,  
(select strTitle from suppliers S where RSH.intRetSupplierID=S.strSupplierID)AS Supplier 
from returntosupplierheader RSH;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["cboSupplier"]==$row["intRetSupplierID"])
					echo "<option selected=\"selected\"value=\"".$row["intRetSupplierID"]."\">".$row["Supplier"]."</option>";
				else
					echo "<option value=\"".$row["intRetSupplierID"]."\">".$row["Supplier"]."</option>";
			}
	
 	?>
          </select></td>
          </tr>
        <tr>
          <td height="20">Order No</td>
          <td><select name="cboStyleID" class="txtbox" id="cboStyleID" style="width:130px" onchange="LoadScNo();">
            <?php
 
		$SQL ="select distinct RSD.intStyleId,o.strOrderNo 
				from returntosupplierdetails RSD
				inner join orders o on RSD.intStyleId=o.intStyleId
				order by o.strOrderNo;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["cboStyleID"]==$row["intStyleId"])
					echo "<option selected=\"selected\"value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
				else
					echo "<option value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
			}
	
 	?>
          </select></td>
          <td>SC</td>
          <td><select name="cboScNo" class="txtbox" id="cboScNo" style="width:130px" onchange="LoadStyleID();">
            <?php
 
		$SQL ="select distinct intSRNO,RSD.intStyleId from returntosupplierdetails RSD
inner join specification SP on RSD.intStyleId=SP.intStyleId;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["cboScNo"]==$row["intStyleId"])
					echo "<option selected=\"selected\"value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
				else
					echo "<option value=\"".$row["intStyleId"]."\">".$row["intSRNO"]."</option>";
			}
	
 	?>
          </select></td>
          <td>&nbsp;</td>
          <td>BuyerPoNo</td>
          <td><select name="cboBuyerPoNo" class="txtbox" id="cboBuyerPoNo" style="width:108px">
            <?php
 
		$SQL ="select distinct strBuyerPoNo from returntosupplierdetails;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["cboBuyerPoNo"]==$row["strBuyerPoNo"])
					echo "<option selected=\"selected\"value=\"". $row["strBuyerPoNo"] ."\">" . $row["strBuyerPoNo"] ."</option>" ;
				else
					echo "<option value=\"".$row["strBuyerPoNo"]."\">".$row["strBuyerPoNo"]."</option>";
			}
	
 	?>
          </select></td>
          <td>By User </td>
          <td><select name="cboUser" class="txtbox" id="cboUser" style="width:110px">
            <?php
 
		$SQL ="select distinct intRetUserId,
				(select UA.Name FROM useraccounts UA where UA.intUserID=RSH.intRetUserId) AS UserName
				from returntosupplierheader RSH 
				Order By RSH.intRetUserId;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($ReturnUserID==$row["intRetUserId"])
					echo "<option selected=\"selected\"value=\"".$row["intRetUserId"]."\">".$row["UserName"]."</option>";
				else
					echo "<option value=\"".$row["intRetUserId"]."\">".$row["UserName"]."</option>";
			}
	
 	?>
          </select></td>
          </tr>
        <tr>
          <td height="20">Meterial</td>
          <td colspan="3"><select name="cboDescription" class="txtbox" id="cboDescription" style="width:312px">
            <?php
 
		$SQL ="select distinct intMatdetailID,
(select strItemDescription from matitemlist MIL where RSH.intMatdetailID=MIL.intItemSerial) AS Description
from returntosupplierdetails RSH
;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["cboDescription"]==$row["intMatdetailID"])
					echo "<option selected=\"selected\"value=\"".$row["intMatdetailID"]."\">".$row["Description"]."</option>";
				else
					echo "<option value=\"".$row["intMatdetailID"]."\">".$row["Description"]."</option>";
			}
	
 	?>
          </select></td>
          <td>&nbsp;</td>
          <td>Company</td>
          <td colspan="3"><select name="cboCompany" class="txtbox" id="cboCompany" style="width:298px">
            <?php
 
		$SQL ="select Distinct intCompanyID,(select strName from companies CO where RSH.intCompanyID=CO.intCompanyID)AS strName from returntosupplierheader RSH Order By RSH.intCompanyID;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["CompanyID"]==$row["intCompanyID"])
					echo "<option selected=\"selected\"value=\"".$row["intCompanyID"]."\">".$row["strName"]."</option>";
				else
					echo "<option value=\"".$row["intCompanyID"]."\">".$row["strName"]."</option>";
			}
	
 	?>
          </select></td>
          </tr>
        <tr>
          <td height="20">Meterial Like</td>
          <td colspan="3"><input type="text" name="txtMatItem" id="txtMatItem" style="width:310px;" value="<?php echo $txtMatItem; ?>"/></td>
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
  <!--<tr>
    <td>&nbsp;</td>
  </tr>-->
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
          
        </table></td>
      </tr>
      <tr>
        <td><div id="divGatePassDetails" style="overflow:scroll; height:320px; width:950px;">
          <table id="tblGatePassDetails" width="100%" cellpadding="0" bgcolor="#CCCCFF" cellspacing="1">
            <tr>			  
              <td width="6%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">RETURN NO</td>
              <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2">RETURN DATE</td>
              <td width="20%" bgcolor="#498CC2" class="normaltxtmidb2">SUPPLIER</td>
			  <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">USER ID</td>
			  <td width="18%" bgcolor="#498CC2" class="normaltxtmidb2">COMPANY</td>
			   <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2">VIEW</td>
            </tr>
<?PHP
$ReturnNoFromArray	= explode('/',$ReturnNoFrom);
$ReturnNoToArray	= explode('/',$ReturnNoTo);
$GrnNoFromArray		= explode('/',$GrnNoFrom);
$GrnNoToArray		= explode('/',$GrnNoTo);
$booCheck	= true;
$sqlDetails="select distinct concat(RSH.intReturnToSupYear,'/',RSH.intReturnToSupNo)AS ReturnNo,
			date(dtmRetDate) as dtmDate,
			(select strTitle from suppliers S where RSH.intRetSupplierID=S.strSupplierID)AS Supplier,
			(select UA.Name from useraccounts UA where RSH.intRetUserId=UA.intUserID)AS ReturnUser,
			(select strName from companies CO where RSH.intCompanyID=CO.intCompanyID)AS Company
			from returntosupplierheader RSH
			inner join returntosupplierdetails RSD on RSH.intReturnToSupNo=RSD.intReturnToSupNo AND RSH.intReturnToSupYear=RSD.intReturnToSupYear
			inner join matitemlist MIL on MIL.intItemSerial = RSD.intMatdetailID
			where RSH.intReturnToSupNo<>0";

if($Category!="2")
{			
	$sqlDetails .=" AND RSH.intStatus=$Category"; 
	$booCheck	= false;
	}
	
if($ReturnNoFrom!="")
{
	$sqlDetails .=" AND RSH.intReturnToSupNo>=$ReturnNoFromArray[1] AND RSH.intReturnToSupYear>=$ReturnNoFromArray[0]";
	$booCheck	= false;
	}

if($ReturnNoTo!="")
{
	$sqlDetails .=" AND RSH.intReturnToSupNo<=$ReturnNoToArray[1] AND RSH.intReturnToSupYear<=$ReturnNoToArray[0]";
	$booCheck	= false;
	}

if($GrnNoFrom!="")
{
	$sqlDetails .=" AND RSD.intGrnNo>=$GrnNoFromArray[1] AND RSD.intGrnYear>=$GrnNoFromArray[0]";
	$booCheck	= false;
	}

if($GrnNoTo!="")
{
	$sqlDetails .=" AND RSD.intGrnNo<=$GrnNoToArray[1] AND RSD.intGrnYear<=$GrnNoToArray[0]";
	$booCheck	= false;
	}
	
if($StyleID!="")
{
	$sqlDetails .=" AND RSD.intStyleId='$StyleID'";
	$booCheck	= false;
	}

if($BuyerPoNo!="")
{
	$sqlDetails .=" AND RSD.strBuyerPoNo='$BuyerPoNo'";
	$booCheck	= false;
	}

if($Description!="")
{
	$sqlDetails .=" AND RSD.intMatdetailID='$Description'";
	$booCheck	= false;
	}
if($txtMatItem!="")
{
	$sqlDetails .=" AND MIL.strItemDescription like '%$txtMatItem%'";
	$booCheck	= false;
	}

	
if($CompanyID!="")
{
	$sqlDetails .=" AND RSH.intCompanyID=$CompanyID";	
	$booCheck	= false;
	}	

if($ReturnUserID!="")
{
	$sqlDetails .=" AND RSH.intRetUserId=$ReturnUserID";
	$booCheck	= false;
	}

if($Supplier!="")
{
	$sqlDetails .=" AND RSH.intRetSupplierID='$Supplier'";
	$booCheck	= false;
	}
if($DateFrom!="")
{
	$sqlDetails .=" AND date(RSH.dtmRetDate)>='$formatedfromDate'";
	$booCheck	= false;
	}

if($DateTo!="")
{
	$sqlDetails .=" AND date(RSH.dtmRetDate)<='$formatedToDate'";
	$booCheck	= false;
	}
	
//echo $sqlDetails;
$result_details = $db->RunQuery($sqlDetails);
	while($row_details=mysql_fetch_array($result_details))
	{
		$ReturnArray	= explode('/',$row_details["ReturnNo"]);
		$strUrl="../../returntosupplier/returntosupplierreport.php?ReturnNo=".$ReturnArray[1]."&ReturnYear=".$ReturnArray[0];
?>

            <tr class="bcgcolor-tblrow">
			  
              <td class="normalfntMid"><?php echo $row_details["ReturnNo"];?></td>
              <td class="normalfntMid"><?php echo $row_details["dtmDate"];?></td>
              <td class="normalfntMid"><?php echo $row_details["Supplier"];?></td>
			  <td class="normalfntMid"><?php echo $row_details["ReturnUser"];?></td>
			  <td class="normalfntMid"><?php echo $row_details["Company"];?></td>
			  <td class="normalfntMid"><a href="<?php echo $strUrl;?>" class="non-html pdf" target="_blank"><img border="0" src="../../images/view.png" alt="view" /></a></td>
            </tr>
<?php
}
?>
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr bgcolor="#D6E7F5">
    <td height="30"><table width="100%" border="0">
      <tr>
        <td width="37%" class="normalfnt">&nbsp;</td>       
        <td width="14%" class="normalfnt"><img src="../../images/refreshico.png" alt="Report" width="108" height="24" onclick="RefreshPage();" /></td>
        <td width="18%" class="normalfnt"><a href="../../main.php"><img src="../../images/close.png" alt="close" width="97" height="24" border="0" /></a></td>
        <td width="31%" class="normalfnt">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<script type="text/javascript">

function DateDisable(obj)
{
	if(obj.checked){
		document.getElementById('DateFrom').disabled=false;
		document.getElementById('DateTo').disabled=false;
	}
	else{
		document.getElementById('DateFrom').disabled=true;
		document.getElementById('DateTo').disabled=true;
	}
}

function SubmitForm()
{
	document.getElementById('frmReturnToSupplierListReport').submit();	
}
function RefreshPage()
{
	setTimeout("location.reload(true);",0);
}
function LoadStyleID(){
	var ScNo =document.getElementById("cboScNo").value;
	document.getElementById("cboStyleID").value =ScNo;	
}
function LoadScNo(){
	var StyleID =document.getElementById("cboStyleID").value;
	document.getElementById("cboScNo").value =StyleID;	
}

</script>

</form>
</body>
</html>
