<?php
	session_start();
	include "../../Connector.php";
	$backwardseperator = "../../";
	
	$Category			= ($_POST["cboCategory"]=="" ? 0:$_POST["cboCategory"]);
	$TransferNoFrom		= $_POST["TransferNoFrom"];
	$TransferNoTo		= $_POST["TransferNoTo"];
	$FromStyleID		= $_POST["cboFromSC"];
	$ToStyleID		 	= $_POST["cboToSc"];

	$ReturnUserID		= $_POST["cboUser"];
	$CompanyID			= $_POST["cboCompany"];
	
	$GrnNoFrom			= $_POST["GrnNoFrom"];
	$GrnNoTo			= $_POST["GrnNoTo"];
	$DateFrom			= $_POST["DateFrom"];	
	 $DateFromArray		= explode('/',$DateFrom);
  	  $formatedfromDate = $DateFromArray[2]."-".$DateFromArray[1]."-".$DateFromArray[0];
  	$DateTo				= $_POST["DateTo"];
     $DateToArray		= explode('/',$DateTo);
      $formatedToDate   = $DateToArray[2]."-".$DateToArray[1]."-".$DateToArray[0];
	$chkDate			= $_POST["chkDate"];
	
	$BuyerPoNo		 	= $_POST["cboBuyerPoNo"];
	$Description        = $_POST["cboDescription"];
	
	$txtMatItem			= $_POST["txtMatItem"];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Inter Job Transaction List & Report</title>
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

<form name="frmInterJobTransferListReport" id="frmInterJobTransferListReport" action="interjobtransactionlistreport.php" method="post">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td height="26" bgcolor="#316895" class="TitleN2white"><table width="100%" border="0">
      <tr>
        <td width="24%"><div align="center">Inter Job Transaction Listing & Report
          <select name="cboCategory" class="txtbox" id="cboCategory" style="width:130px">
            <option <?php if($_POST["cboCategory"]==20) { ?> selected="selected" <?php } ?> value="20">All Details</option>
			<option <?php if($_POST["cboCategory"]==0) { ?> selected="selected" <?php } ?>  value="0">Saved Details</option>            
            <option <?php if($_POST["cboCategory"]==1) { ?> selected="selected" <?php } ?>  value="1">Approved Details</option>
            <option <?php if($_POST["cboCategory"]==2) { ?> selected="selected" <?php } ?>  value="2">Authorised Details</option>
			<option <?php if($_POST["cboCategory"]==3) { ?> selected="selected" <?php } ?>  value="3">Confirmed Details</option>
			<option <?php if($_POST["cboCategory"]==10) { ?> selected="selected" <?php } ?>  value="10">Canceled Details</option>

          </select>
        </div></td>
        </tr>
    </table></td>
  </tr>
  <tr><td><table width="950" border="0" cellspacing="0" cellpadding="2" class="bcgl1">
    <tr>
      <td><table width="948" border="0" cellspacing="0" cellpadding="0" class="normalfnt" align="center">
        <tr>
          <td width="101" height="20">Transfer No From</span></td>
          <td width="135"><select name="TransferNoFrom" class="txtbox" id="TransferNoFrom" style="width:130px">
            <?php
		$SQL ="SELECT DISTINCT CONCAT(intTransferYear , '/' , intTransferId) AS TransferNo FROM itemtransfer ORDER BY intTransferId,intTransferYear;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["TransferNoFrom"]==$row["TransferNo"])
					echo "<option selected=\"selected\"value=\"". $row["TransferNo"] ."\">" . $row["TransferNo"] ."</option>" ;
				else
				echo "<option value=\"".$row["TransferNo"]."\">".$row["TransferNo"]."</option>";
			}
	
 	?>
          </select></td>
          <td width="39">To</td>
          <td width="141"><select name="TransferNoTo" class="txtbox" id="TransferNoTo" style="width:129px">
            <?php
 
		$SQL ="SELECT DISTINCT CONCAT(intTransferYear , '/' , intTransferId) AS TransferNo FROM itemtransfer ORDER BY intTransferId,intTransferYear;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["TransferNoTo"]==$row["TransferNo"])
					echo "<option selected=\"selected\"value=\"". $row["TransferNo"] ."\">" . $row["TransferNo"] ."</option>" ;
				else
				echo "<option value=\"".$row["TransferNo"]."\">".$row["TransferNo"]."</option>";
			}
	
 	?>
          </select></td>
          <td width="26"><input <?php if($_POST["chkDate"]== "on") { ?> checked="checked" <?php } ?> type="checkbox" name="chkDate" id="chkDate"  onclick="DateDisable(this);"/></td>
          <td width="79">Date From</td>
          <td width="156"><input name="DateFrom" type="text" class="txtbox" id="DateFrom" style="width:118px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($DateFrom=="" ? date ("d/m/Y"):$DateFrom) ?>" <?php if($_POST["chkDate"]!= "on") { ?> disabled="disabled" <?php }?>/><input name="reset" id="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value=""/></td>
          <td width="39">To</td>
          <td width="144"><input name="DateTo" type="text" class="txtbox" id="DateTo" style="width:118px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($DateTo=="" ? date ("d/m/Y"):$DateTo) ?>" <?php if($_POST["chkDate"]!= "on") { ?> disabled="disabled" <?php }?>/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
          <td width="88" rowspan="4"><img src="../../images/search.png"  alt="search" width="80" height="24" onclick="SubmitForm();" /></td>
        </tr>
        <tr>
          <td height="21">Order No From</td>
          <td><select name="cboFromStyle" class="txtbox" id="cboFromStyle" style="width:130px" onchange="SeachFromSC();">
            <?php
 
		$SQL ="select Distinct intStyleIdFrom,strOrderNo
			 from itemTransfer IT inner join orders o on
			o.intStyleId = IT.intStyleIdFrom
			Order BY strOrderNo;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["cboFromStyle"]==$row["intStyleIdFrom"])
					echo "<option selected=\"selected\"value=\"". $row["intStyleIdFrom"] ."\">" . $row["strOrderNo"] ."</option>" ;
				else
					echo "<option value=\"".$row["intStyleIdFrom"]."\">".$row["strOrderNo"]."</option>";
			}
	
 	?>
          </select></td>
          <td>SC </td>
          <td><select name="cboFromSC" class="txtbox" id="cboFromSC" style="width:130px" onchange="SeachFromStyle();">
            <?php
 
		$sql ="select Distinct intStyleIdFrom,
(select intSRNO from specification SP where SP.intStyleId=IT.intStyleIdFrom) AS FromSC
 from itemTransfer IT Order BY FromSC DESC;";
		
			$result =$db->RunQuery($sql);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["cboFromSC"]==$row["intStyleIdFrom"])
					echo "<option selected=\"selected\"value=\"".$row["intStyleIdFrom"]."\">".$row["FromSC"]."</option>";
				else
					echo "<option value=\"".$row["intStyleIdFrom"]."\">".$row["FromSC"]."</option>";
			}
	
 	?>
          </select></td>
          <td>&nbsp;</td>
          <td>Order No To</td>
          <td><select name="cboToStyle" class="txtbox" id="cboToStyle" style="width:120px" onchange="SeachToSC();">
            <?php
 
		$SQL ="select Distinct intStyleIdTo,strOrderNo
			 from itemTransfer IT inner join orders o on
			o.intStyleId = IT.intStyleIdTo
			Order BY strOrderNo;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["cboToStyle"]==$row["intStyleIdTo"])
					echo "<option selected=\"selected\"value=\"". $row["intStyleIdTo"] ."\">" . $row["strOrderNo"] ."</option>" ;
				else
					echo "<option value=\"".$row["intStyleIdTo"]."\">".$row["strOrderNo"]."</option>";
			}
	
 	?>
          </select></td>
          <td>SC</td>
          <td><select name="cboToSc" class="txtbox" id="cboToSc" style="width:120px" onchange="SeachToStyle();">
            <?php
 
		$sqlGrnTo ="select Distinct intStyleIdTo,
(select intSRNO from specification SP where SP.intStyleId=IT.intStyleIdTo) AS ToSc
 from itemTransfer IT Order BY ToSc DESC;";
		
			$result_GrnTo =$db->RunQuery($sqlGrnTo);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row_grnto=mysql_fetch_array($result_GrnTo))
			{
				if($_POST["cboToSc"]==$row_grnto["intStyleIdTo"])
					echo "<option selected=\"selected\"value=\"".$row_grnto["intStyleIdTo"]."\">".$row_grnto["ToSc"]."</option>";
				else
					echo "<option value=\"".$row_grnto["intStyleIdTo"]."\">".$row_grnto["ToSc"]."</option>";
			}
	
 	?>
          </select></td>
          </tr>
        <tr>
          <td height="20">Meterial</td>
          <td colspan="3"><select name="cboDescription" class="txtbox" id="cboDescription" style="width:304px">
            <?php
 
		$SQL ="select distinct intMatdetailID,
(select strItemDescription from matitemlist MIL where ITD.intMatDetailId=MIL.intItemSerial) AS Description
from itemtransferdetails ITD
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
          <td>BuyerPoNo</td>
          <td><select name="cboBuyerPoNo" class="txtbox" id="cboBuyerPoNo" style="width:120px">
            <?php
 
		$SQL ="select distinct strBuyerPoNo from itemtransferdetails;";
		
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
          <td>User</td>
          <td><select name="cboUser" class="txtbox" id="cboUser" style="width:120px">
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
          <td height="20">Material Like</td>
          <td colspan="3"><input type="text" name="txtMatItem" id="txtMatItem" style="width:302px;" value="<?php echo $txtMatItem; ?>" /></td>
          <td>&nbsp;</td>
          <td>Company</td>
          <td colspan="3"><select name="cboCompany" class="txtbox" id="cboCompany" style="width:315px">
            <?php
 
		$SQL ="select Distinct intFactoryCode,(select strName from companies CO where IT.intFactoryCode=CO.intCompanyID)AS strName from itemtransfer IT Order By IT.intFactoryCode;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["cboCompany"]==$row["intFactoryCode"])
					echo "<option selected=\"selected\"value=\"".$row["intFactoryCode"]."\">".$row["strName"]."</option>";
				else
					echo "<option value=\"".$row["intFactoryCode"]."\">".$row["strName"]."</option>";
			}
	
 	?>
          </select></td>
          </tr>
      </table></td>
    </tr>
  </table></td></tr>
 
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
              <td width="8%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">RETURN NO</td>
              <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">RETURN DATE</td>
			  <td width="12%" bgcolor="#498CC2" class="normaltxtmidb2">FROM STYLE</td>
			  <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">FROM SC</td>
			  <td width="12%" bgcolor="#498CC2" class="normaltxtmidb2">TO STYLE</td>
			  <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">TO SC</td>              
			  <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">USER ID</td>			  
			  <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">STATUS</td>
			   <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2">VIEW</td>
            </tr>
<?PHP
$TransferNoFromArray	= explode('/',$TransferNoFrom);
$TransferNoToArray	= explode('/',$TransferNoTo);
$GrnNoFromArray		= explode('/',$GrnNoFrom);
$GrnNoToArray		= explode('/',$GrnNoTo);
$booCheck	= true;

$sqlDetails="select distinct concat(ITH.intTransferYear,'/',ITH.intTransferId)AS TransferNo,
			date(dtmTransferDate) as dtmDate,
			(select strOrderNo from orders o where o.intStyleId = ITH.intStyleIdFrom) as intStyleIdFrom,
			(select intSRNO from specification SP where ITH.intStyleIdFrom=SP.intStyleId)AS FromSc,
			(select strOrderNo from orders o where o.intStyleId = ITH.intStyleIdTo) as intStyleIdTo,
			(select intSRNO from specification SP where ITH.intStyleIdTo=SP.intStyleId)AS ToSc,
			(select UA.Name from useraccounts UA where ITH.intUserId=UA.intUserID)AS ReturnUser,
			ITH.intStatus
			from itemtransfer ITH
			inner join itemtransferdetails ITD on ITH.intTransferId=ITD.intTransferId AND ITH.intTransferYear=ITD.intTransferYear
			inner join matitemlist MIL on MIL.intItemSerial = ITD.intMatDetailId
			where ITH.intTransferId<>0";

if($Category!="20")
{ 			
	$sqlDetails .=" AND ITH.intStatus=$Category"; 
	$booCheck	= false;
	}
	
if($TransferNoFrom!="")
{
	$sqlDetails .=" AND ITH.intTransferId>=$TransferNoFromArray[1] AND ITH.intTransferYear>=$TransferNoFromArray[0]";
	$booCheck	= false;
	}
	
if($TransferNoTo!="")
{
	$sqlDetails .=" AND ITH.intTransferId<=$TransferNoToArray[1] AND ITH.intTransferYear<=$TransferNoToArray[0]";
	$booCheck	= false;
	}
	
if($FromStyleID!="")
{
	$sqlDetails .=" AND ITH.intStyleIdFrom='$FromStyleID'";
	$booCheck	= false;
	}

if($ToStyleID!="")
{
	$sqlDetails .=" AND ITH.intStyleIdTo='$ToStyleID'";
	$booCheck	= false;
	}
	
if($BuyerPoNo!="")
{
	$sqlDetails .=" AND ITD.strBuyerPoNo='$BuyerPoNo'";
	$booCheck	= false;
	}

if($Description!="")
{
	$sqlDetails .=" AND ITD.intMatDetailId='$Description'";
	$booCheck	= false;
	}
if($txtMatItem!="")
{
	$sqlDetails .=" AND MIL.strItemDescription like '%$txtMatItem%'";
	$booCheck	= false;
	}	
if($CompanyID!="")
{
	$sqlDetails .=" AND ITH.intFactoryCode=$CompanyID";	
	$booCheck	= false;
	}	

if($ReturnUserID!="")
{
	$sqlDetails .=" AND ITH.intUserId=$ReturnUserID";
	$booCheck	= false;
	}

if($DateFrom!="")
{
	$sqlDetails .=" AND date(ITH.dtmTransferDate)>='$formatedfromDate'";
	$booCheck	= false;
	}

if($DateTo!="")
{
	$sqlDetails .=" AND date(ITH.dtmTransferDate)<='$formatedToDate'";
	$booCheck	= false;
	}
//echo $sqlDetails;
$result_details = $db->RunQuery($sqlDetails);
	while($row_details=mysql_fetch_array($result_details))
	{
		$Status			= $row_details["intStatus"];
		$TransferNoArray	= explode('/',$row_details["TransferNo"]);
		$strUrl="../../InterJobTransfer/interJobMaterialTransferNote.php?InterJobNo=".$TransferNoArray[1]."&InterJobYear=".$TransferNoArray[0];
?>

            <tr class="bcgcolor-tblrow">
			  
              <td class="normalfntMid"><?php echo $row_details["TransferNo"];?></td>
              <td class="normalfntMid"><?php echo $row_details["dtmDate"];?></td>
			  <td class="normalfnt"><?php echo $row_details["intStyleIdFrom"];?></td>
			  <td class="normalfntMid"><?php echo $row_details["FromSc"];?></td>
			  <td class="normalfntMid"><?php echo $row_details["intStyleIdTo"];?></td>			  
              <td class="normalfntMid"><?php echo $row_details["ToSc"];?></td>
			  <td class="normalfntMid"><?php echo $row_details["ReturnUser"];?></td>
			  <td class="normalfntMid"><?php 
			  	if($Status==0)echo 	"Saved";
			   	if($Status==1)echo 	"Approved";
			    if($Status==2)echo 	"Authorised";
				if($Status==3)echo 	"Confirmed";
				if($Status==10)echo "Canceled";
			  ?></td>
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
	document.getElementById('frmInterJobTransferListReport').submit();	
}
function RefreshPage()
{
	setTimeout("location.reload(true);",0);
}
function SeachFromStyle(){	
	//var ScNo =document.getElementById("cboFromSC").options[document.getElementById("cboFromSC").selectedIndex].text;
	var ScNo =document.getElementById("cboFromSC").value;
	document.getElementById("cboFromStyle").value =ScNo;
	LoadMerchandiser();
}

function SeachFromSC(){	
	var StyleFromID =document.getElementById('cboFromStyle').value;
	document.getElementById('cboFromSC').value =StyleFromID;
	LoadMerchandiser();
}

function SeachToStyle(){
	var ScNo =document.getElementById("cboToSc").value;
	document.getElementById("cboToStyle").value =ScNo;	
}

function SeachToSC(){
	var StyleToID =document.getElementById('cboToStyle').value;
	document.getElementById('cboToSc').value =StyleToID;	
}

</script>

</form>

</body>
</html>
