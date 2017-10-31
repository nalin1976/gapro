<?php
session_start();
$backwardseperator = "../../";
include "../../Connector.php";
include "${backwardseperator}authentication.inc";

$companyID 		= $_SESSION["FactoryID"];
$cboToFactory 	= $_POST["cboToFactory"];

if(!isset($_POST["cboToFactory"]) && $_POST["cboToFactory"]=="")
{
	$dateFrom 	= date('Y-m-d');
	$dateTo  	= date('Y-m-d');
	$chkDate	= 'on';
}
else
{
	$chkDate		= $_POST["chkDate"];
	$dateFrom		= $_POST["txtFromDate"];
	$dateTo			= $_POST["txtToDate"];
}
$cboStyle 		= $_POST["cboStyle"];
$cboOrderNo		= $_POST["cboOrderNo"];

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Defect Transfer Listing</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css"/>
<script src="../../javascript/calendar/calendar.js" language="javascript" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" language="javascript" type="text/javascript"></script>
<script src="../../javascript/script.js" language="javascript" type="text/javascript"></script>

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
<script language="javascript" type="text/javascript">

function viewDefectData()
{
	$("#frmDefectTransferList").submit();
}
function clearDate(obj)
{
	if(!obj.checked)
	{
		document.getElementById('txtFromDate').value="";
		document.getElementById('txtToDate').value="";
		document.getElementById("txtFromDate").disabled =true;
		document.getElementById("txtToDate").disabled =true;
	}
	else
	{
		document.getElementById("txtFromDate").disabled =false;
		document.getElementById("txtToDate").disabled =false;
		document.getElementById('txtFromDate').value="<?php echo date('Y-m-d');?>";
		document.getElementById('txtToDate').value="<?php echo date('Y-m-d');?>";
	}
}
function loadStyle(obj)
{
	$("#cboStyle").val(obj.value);
}
function loadPONo(obj)
{
	$("#cboOrderNo").val(obj.value);
}


</script>
</head>
<body>
<form name="frmDefectTransferList" method="post" action="defectTransferList.php" id="frmDefectTransferList">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td><?php include $backwardseperator.'Header.php'?></td>
</tr>
<tr>
  <td><table width="800" border="0" cellspacing="2" cellpadding="0" align="center">
    <tr>
      <td><table width="100%" border="0" cellpadding="0" cellspacing="1" class="tableBorder">
        <tr>
          <td colspan="4" class="mainHeading" height="26">Defect Transfer Listing</td>
        </tr>
        <tr>
          <td class="normalfnt"><table width="100%" border="0" cellspacing="1" cellpadding="1" class="bcgl1">
            <tr>
              <td colspan="2" class="normalfnt">Sewing Factory</td>
              <td width="44%" class="normalfnt"><select name="cboToFactory" id="cboToFactory" style="width:325px;">
                <option value="">Select One</option>
                <?php 
					  	$sql = "SELECT DISTINCT companies.intCompanyID,companies.strName 
								FROM companies 
								inner join was_stocktransactions_defect wsd on wsd.intFromFactory=companies.intCompanyID
								where wsd.intCompanyID ='$companyID' and wsd.strType='Defect'
								order by companies.strName";
							//echo $sql;
						$result = $db->RunQuery($sql);
						while($row = mysql_fetch_array($result))
						{
							if($cboToFactory==$row["intCompanyID"])
								echo "<option value=\"".$row['intCompanyID']."\" selected=\"selected\">" . $row["strName"] . "</option>";
							else
								echo "<option value=\"".$row['intCompanyID']."\">" . $row["strName"] . "</option>";
						}
							
					  ?>
              </select></td>
              <td width="9%" class="normalfnt">PO No</td>
              <td width="21%" class="normalfnt"><select name="cboOrderNo" id="cboOrderNo" style="width:150px;" onChange="loadStyle(this);">
                <option value="">Select One</option>
                <?php 
					  	$sql = " SELECT DISTINCT
									O.strOrderNo,
									O.intStyleId,
									O.strStyle
									FROM
									was_stocktransactions_defect AS wsd
									INNER JOIN orders O ON O.intStyleId = wsd.intStyleId
									WHERE
									wsd.intCompanyId='$companyID' and wsd.strType='Defect'
									order by O.strOrderNo";
							
						$result = $db->RunQuery($sql);
						while($row = mysql_fetch_array($result))
						{
							if($cboOrderNo==$row["intStyleId"])
								echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . trim($row["strOrderNo"]) ."</option>" ;
							else		
								echo "<option value=\"" . $row["intStyleId"] ."\">" . $row["strOrderNo"] . "</option>";
						}
							
					  ?>
              </select></td>
              <td width="12%" class="normalfnt">&nbsp;</td>
            </tr>
            <tr>
              <td width="3%" class="normalfnt"><input name="chkDate" id="chkDate" type="checkbox" <?php echo ($chkDate=='on' ? "checked=\"checked\"":"")?> onClick="clearDate(this)"></td>
              <td width="11%" class="normalfnt">&nbsp;<span>Date From</span></td>
              <td class="normalfnt"><input name="txtFromDate" type="text" tabindex="9" class="txtbox" id="txtFromDate" style="width:100px"  onmousedown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onFocus="return showCalendar(this.id, '%Y-%m-%d');" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?Php echo($dateFrom=='' ? "":$dateFrom);?>" <?php echo ($chkDate=="on" ? "":"disabled=\"disabled\"")?>/><input name="reset1" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onClick="return showCalendar(this.id, '%Y-%m-%d');" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="txtToDate" type="text" tabindex="9" class="txtbox" id="txtToDate" style="width:100px"  onmousedown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onFocus="return showCalendar(this.id, '%Y-%m-%d');" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?Php echo($dateTo=='' ? "":$dateTo);?>" <?php echo ($chkDate=="on" ? "":"disabled=\"disabled\"")?>/><input name="reset12" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" /></td>
              <td class="normalfnt">Style No</td>
              <td class="normalfnt"><select name="cboStyle" id="cboStyle" style="width:150px;" tabindex="2" onChange="loadPONo(this);">
                <option value="" selected="selected">Select One</option>
                <?php 

			$SQL = "SELECT DISTINCT
									O.strOrderNo,
									O.intStyleId,
									O.strStyle
									FROM
									was_stocktransactions_defect AS wsd
									INNER JOIN orders O ON O.intStyleId = wsd.intStyleId
									WHERE
									wsd.intCompanyId='$companyID' and wsd.strType='Defect'
									order by O.strStyle";	
			$result = $db->RunQuery($SQL);		
			while($row = mysql_fetch_array($result))
			{
			
							if($cboStyle==$row["intStyleId"])
								echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . trim($row["strStyle"]) ."</option>" ;
							else		
								echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>" ;
			}
		?>
              </select></td>
              <td class="normalfnt" style="text-align:right"><img src="../../images/search.png" alt="search" onClick="viewDefectData()"/></td>
            </tr>
          </table></td>
        </tr>
        <tr>
        <td>
         <table width="800" border="0" cellpadding="1" cellspacing="0">
         <tr><td>
         <div id="divDefectTrans" style="overflow:scroll; width:800px;height:300px">
		  <table width="100%" border="0" cellpadding="0" cellspacing="1" id="tblDefectTrans" bgcolor="#CCCCFF">
            <tr class="mainHeading4">
                        <td width="139"  height="20"> Defect Trnasfer No</td>
                        <td width="124" >PO No</td>
                        <td width="125" >Style No</td>
                        <td width="138" >Color</td>
                        <td width="107" >Date</td>
                        <td width="107" >Qty</td>
                        <td style="display:none" width="102" >Report</td>
            </tr>
            <?php
			$sql = "select O.strOrderNo,O.strStyle,concat(wsd.intDocumentYear,'/',wsd.intDocumentNo) as defectNo,
					wsd.strColor,wsd.dblQty, date(wsd.dtmDate) as dtmDate,wsd.intFromFactory,wsd.intStyleId,wsd.strColor
					from was_stocktransactions_defect wsd
					inner join orders O on O.intStyleId=wsd.intStyleId
					where wsd.strType='Defect' ";
			if($dateFrom!="")
				$sql.="AND date(wsd.dtmDate)>='$dateFrom' ";
			if($dateTo!="")
				$sql.="AND date(wsd.dtmDate)<='$dateTo' ";
			if($cboToFactory!="")
				$sql.="AND wsd.intFromFactory='$cboToFactory' ";
			if($cboOrderNo!="")
				$sql.="AND wsd.intStyleId='$cboOrderNo' ";
			$sql.="order by defectNo";

			$result=$db->RunQuery($sql);
			while($row=mysql_fetch_array($result))
			{
			?>
                <tr class="bcgcolor-tblrowWhite">
                  <td  height="20" class="normalfnt">&nbsp;<?php echo $row['defectNo']; ?>&nbsp;</td>
                  <td class="normalfnt" >&nbsp;<?php echo $row['strOrderNo']; ?>&nbsp;</td>
                  <td class="normalfnt" >&nbsp;<?php echo $row['strStyle']; ?>&nbsp;</td>
                  <td class="normalfnt" >&nbsp;<?php echo $row['strColor']; ?>&nbsp;</td>
                  <td class="normalfnt" >&nbsp;<?php echo $row['dtmDate']; ?>&nbsp;</td>
                  <td class="normalfntRite" >&nbsp;<?php echo $row['dblQty']; ?>&nbsp;</td>
                  <td style="display:none" class="normalfntMid" >&nbsp;<img src="../../images/report.png" height="18">&nbsp;</td>
                </tr>
           <?php
			}
		   ?>
                      
                    </table>  
                  </div>
                  </td>
                  </tr>
                  </table>
        </td>
        </tr>
      </table></td>
    </tr>
  </table></td>
  </tr>
 </table>
</form>