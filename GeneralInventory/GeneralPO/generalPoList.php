<?php
session_start();
$backwardseperator = "../../";
include "../../Connector.php";

require_once '../../classes/location.php';

$class_location = new Location();

$class_location->SetConnection($db);

$rsLocationList = $class_location->GetLocationList();

if(!isset($_POST["txtPoNo"]) && $_POST["txtPoNo"]=="")
	{
		$fromDate 	= date('Y-m-d');
		$toDate   	= date('Y-m-d');
		//$chkDate 	= 'on';
		$status		= 0 ;
	}
	else
	{
		$status		= $_POST["cboStatus"];
		$fromDate	= $_POST["txtFromDate"];
		$toDate		= $_POST["txtToDate"];
		$chkDate	= $_POST["chkDate"];	
	}
	
	$PONo		= $_POST["txtPoNo"];
	$polist		= $_POST["cbopolist"];
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | General Purchase Order List</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="generalPoList-java.js" type="text/javascript"></script>
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
<style type="text/css">
    table.fixHeader {
        border: thin #CCCCCC;
        border-width: 2px 2px 2px 2px;
        width: 850px;
    }
    tbody.ctbody {
        height: 500px;
        /*overflow-y: auto;*/
        /*overflow-x: hidden;*/
		overflow:hidden;
    }

</style>

<script type="text/javascript">
function dateDisable(objChk)
{
	if(!objChk.checked)
	{
		document.getElementById("txtFromDate").disabled = true;
		document.getElementById("txtFromDate").value = "";
		document.getElementById("txtToDate").disabled = true;
		document.getElementById("txtToDate").value = "";
	}
	else
	{
		document.getElementById("txtFromDate").disabled = false;
		document.getElementById("txtToDate").disabled = false;
		document.getElementById("txtFromDate").value = "<?php echo date("Y-m-d")?>";
		document.getElementById("txtToDate").value = "<?php echo date("Y-m-d")?>";
	}
}


</script>
<body onload="pageload()" >
 
<form name="frmGenPOList" id="frmGenPOList" method="post" action="generalPoList.php">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">
  <tr>
    <td class="mainHeading" height="25">General Purchase Order List</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="tableBorder" cellpadding="1" cellspacing="0">
      <tr>
        <td width="2%" height="27">&nbsp;</td>
        <td width="6%" class="normalfnt">Suplier</td>
        <td width="41%"><select name="cbopolist" class="txtbox" id="cbopolist" style="width:255px">
		 <option value="" selected="selected" >Select One</option>
                          <?php
	
							$SQL = "SELECT strTitle,strSupplierID,strSupplierCode FROM suppliers s where intStatus='1' order by strTitle;";	
							$result = $db->RunQuery($SQL);		
							while($row = mysql_fetch_array($result))
							{
								if($polist==$row['strSupplierID'])
								{
									echo "<option selected=\"selected\" value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
								}
								else
								{
									echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] . " - " . $row["strSupplierCode"] ."</option>" ;
								}
							}
							
							
							
							?>
								 
            </select></td>
        <td width="3%"><span class="normalfnt">
          <input type="checkbox" name="chkDate" id="chkDate" onclick="dateDisable(this);" <?php echo ($chkDate=='on' ? "checked=\"checked\"":"")?>/>
        </span></td>
        <td width="7%" class="normalfnt">From</td>
        <td width="10%"><input name="txtFromDate" type="text" class="txtbox" id="txtFromDate" style="width:70px" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($fromDate=="" ? "":$fromDate);?>" <?php echo ($chkDate=="on" ? "":'disabled=\"disabled\"')?>/><input type="reset" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
        <td width="2%" class="normalfnt">To</td>
        <td width="15%"><input name="txtToDate" type="text" class="txtbox" id="txtToDate" style="width:70px" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($toDate=="" ? "":$toDate);?>" <?php echo ($chkDate=="on" ? "":'disabled=\"disabled\"')?>/><input type="reset" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
        <td width="4%" class="normalfnt"> </td>
        <td width="10%"><img src="../../images/search.png" alt="search" width="80" height="24" class="mouseover" id="imgSearch"/></td>
      </tr>
      <tr>
        <td height="27">&nbsp;</td>
        <td class="normalfnt">Status</td>
        <td><select name="cboStatus" class="txtbox" id="cboStatus" style="width:150px" >
          <option <?php echo($status==0?'selected="selected"':"") ?> value="0">Pending for Process</option>
          <option <?php echo($status==2?'selected="selected"':"") ?> value="2">Confirmed</option>
          <option <?php echo($status==1?'selected="selected"':"") ?> value="1">Processed</option>
          <option <?php echo($status==10?'selected="selected"':"") ?> value="10">Canceled</option>
        </select></td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">PO No Like</td>
        <td><input class="txtbox" style="width: 70px;" name="txtPoNo" id="txtPoNo" value="<?php echo ($PONo!="" ? $PONo:'');?>"></td>
        <td class="normalfnt">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="27">&nbsp;</td>
        <td class="normalfnt">Delivery</td>
        <td><select name="cboDeliveryLocation" class="txtbox" id="cboDeliveryLocation" style="width:250px" >
           <option value="0">All delivery location</option>     
           <?php 
            while($rowLocation =  mysql_fetch_array($rsLocationList)){
            ?>
           <option value="<?php echo $rowLocation["intCompanyID"]; ?>"><?php echo $rowLocation["strName"]; ?></option>
           <?php
              
            }
           ?>     
          
        </select></td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>   
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><div id="divcons2" style="overflow:scroll; height:370px; width:950px;">
          <table width="100%" border="0" cellpadding="0" cellspacing="1" id="tblPoList" name="tblPoList" bgcolor="#CCCCFF">
          <thead>
            <tr class="mainHeading4">
              <th width="6%"><input type="checkbox" id="chkAll" name="chkAll" /></th>	
              <th width="11%" height="25" >PO No</th>
              <th width="41%" >Supplier</th>
              <th width="4%" >Currency</th>
              <th width="8%" >PO Value</th>
              <th width="8%" >Date</th>              
              <th width="15%" >User</th>
              <th width="7%" >Report</th>
              </tr>
            </thead>  
             <tbody>             
             </tbody>
            
            </table>
          </div></td>
      </tr>
    </table></td>
    
  </tr>
<tr>
	<td><?php include "../../permissionProvider.php"; ?>
    	<table width="100%" border="0">
        	<tr><td width="20%">&nbsp;</td>
            	<td width="56%"><input type="hidden" id="confirmGPO" name="confirmGPO" value="<?php echo $confirmGeneralPO; ?>" /><input type="hidden" id="approveGPO" name="approveGPO" value="<?php echo $approveGeneralPo; ?>" /></td>
            	<td width="21%"><img id="imgConfirm" src="../../images/conform.png" class="mouseover" alt="view" style="display:none" /><img id="imgApprove" src="../../images/approve.png" class="mouseover" alt="view" style="display:none" /></td><td width="3%">&nbsp;</td></tr>
        </table>
    </td>
</tr>
</table>
</form>
</body>
</html>