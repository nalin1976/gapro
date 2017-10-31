<?php
session_start();
$backwardseperator = "../../";
include "${backwardseperator}authentication.inc";
	  $comID = $_POST["cboissuewashFac"];
	  $styleNo = $_POST["cboStyleNo"];
	  $styleID = $_POST["cboOrderNo"];
	  $issueNofrm = $_POST["cboissueNofrom"];
	  $issueNoto = $_POST["cboIssueNoTo"];
	  $dfrom = $_POST["txtDfrom"];
	  $dto = $_POST["txtDto"];
	  $intyear = $_POST["cboYear"];
	  $intStatus=$_POST['cboStatus'];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Issued To Wash List</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css"/>
<script src="../../javascript/calendar/calendar.js" language="javascript" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" language="javascript" type="text/javascript"></script>
<script src="../../javascript/script.js" language="javascript" type="text/javascript"></script>
<script src="issuedWashlist.js" language="javascript" type="text/javascript"></script>
<script src="../issuedWash/issuedWash.js" type="text/javascript"></script>
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

function viewIssuedWashData()
{
	$("#frmissuedWashList").submit();
}

</script>
</head>

<body>
<form name="frmissuedWashList" method="post" action="" id="frmissuedWashList">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><?php include $backwardseperator.'Header.php'?></td>
    </tr>
    <?php
	include "../../Connector.php";	
?>
    <tr>
      <td><table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr><td>&nbsp;</td></tr>
        <tr>
          <td><table width="800" border="0" cellspacing="0" cellpadding="3" align="center" class="tableFooter">
            <tr>
              <td width="800"><table width="800" border="0" cellspacing="0" cellpadding="0" class="normalfnt" align="center">
                <tr>
                  <td colspan="4" class="mainHeading" height="26">Issued To Wash Listing</td>
                  </tr>
                <tr>
                  <td width="130">&nbsp;</td>
                  <td width="164">&nbsp;</td>
                  <td width="116">&nbsp;</td>
                  <td width="290">&nbsp;</td>
                </tr>



                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td height="20" colspan="4"><table width="550" border="0" cellspacing="0" cellpadding="2" class="bcgl1" align="center">
                  
                    <tr class="normalfnt">
                      <td width="136" height="20">Factory </td>
                      <td colspan="3"><select name="cboissuewashFac" id="cboissuewashFac" style="width:420px;">
                        <option></option>
                        <?php 
				  
				  	$sql = " select distinct wih.strFComCode, c.strName
							from was_issuedtowashheader wih inner join companies c on
							c.intCompanyID = wih.strFComCode 
							order by c.strName	";
							
					$result = $db->RunQuery($sql);
					while($row = mysql_fetch_array($result))
					{
						if($comID==$row["strFComCode"])
							echo "<option selected=\"selected\" value=\"". $row["strFComCode"] ."\">" . trim($row["strName"]) ."</option>" ;
						else		
							echo "<option value=\"" . $row["strFComCode"] ."\">" . $row["strName"] . "</option>";
					}
					
				  ?>
                      </select></td>
                      </tr>

                    <tr class="normalfnt">
                      <td>Style No</td>
                      <td width="210"><select name="cboStyleNo" id="cboStyleNo" style="width:122px;" onChange="getStylewiseOrderNo();">
                      <option></option>
                      <?php 
					  	$sql = " select distinct strStyle 
							from was_issuedtowashheader wih inner join orders o on
							wih.intStyleNo = o.intStyleId order by strStyle";
							
						$result = $db->RunQuery($sql);
						while($row = mysql_fetch_array($result))
						{
							if($styleNo==$row["strStyle"])
								echo "<option selected=\"selected\" \">" . $row["strStyle"] . "</option>";
							else
								echo "<option \">" . $row["strStyle"] . "</option>";
						}
							
					  ?>
                      </select></td>
                      <td width="79">PO No</td>
                      <td width="163"><select name="cboOrderNo" id="cboOrderNo" style="width:122px;">
                       <option></option>
                      <?php 
					  	$sql = " select distinct wih.intStyleNo, o.strOrderNo 
							from was_issuedtowashheader wih inner join orders o on
							wih.intStyleNo = o.intStyleId order by strStyle";
							
						$result = $db->RunQuery($sql);
						while($row = mysql_fetch_array($result))
						{
							if($styleID==$row["intStyleNo"])
							echo "<option selected=\"selected\" value=\"". $row["intStyleNo"] ."\">" . trim($row["strOrderNo"]) ."</option>" ;
						else		
							echo "<option value=\"" . $row["intStyleNo"] ."\">" . $row["strOrderNo"] . "</option>";
						}
							
					  ?>
                      </select></td>
                    </tr>
                    <tr class="normalfnt">
                      <td>Date From</td>
                      <td><input type="text" name="txtDfrom" id="txtDfrom" style="width:120px;" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo $dfrom; ?>" /><input type="reset" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
                      <td>Date To</td>
                      <td><input type="text" name="txtDto" id="txtDto" style="width:121px;" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo $dto; ?>" /><input type="reset" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
                    </tr>
                    <tr class="normalfnt">
                      <td colspan="4"><table width="600" border="0" cellspacing="0" cellpadding="2" class="normalfnt">
                        <tr>
                          <td width="47" height="20">Year</td>
                          <td width="91"><select name="cboYear" id="cboYear" style="width:80px;" onChange="loadIssueNo();">
                          <?php 
						   $issueYear = date("Y");
						  if($intyear == '')
						  	$intyear = $issueYear;
						 
						  for ($loop = date("Y") ; $loop >= 2008; $loop --)
							{
								if ($intyear ==  $loop)
									echo "<option selected=\"selected\" value=\"$loop\">$loop</option>";
								else
									echo "<option value=\"$loop\">$loop</option>";
							}
						  ?>
                          </select>                          </td>
                          <td width="96">Issue # From</td>
                          <td width="106"><select name="cboissueNofrom" id="cboissueNofrom" style="width:100px;">
                            <option></option>
                            <?php 
					  	$SQL = " select  dblIssueNo from was_issuedtowashheader where intIssueYear=$issueYear
								order by dblIssueNo ";
						$result = $db->RunQuery($SQL);
						while($row = mysql_fetch_array($result))
						{
							if($issueNofrm == $row["dblIssueNo"])
								echo "<option selected=\"selected\" value=\"" . $row["dblIssueNo"] ."\">" . $row["dblIssueNo"] . "</option>";
							else
								echo "<option value=\"" . $row["dblIssueNo"] ."\">" . $row["dblIssueNo"] . "</option>";
						}
					  ?>
                          </select></td>
                          <td width="76">Issue # To</td>
                          <td width="160"><select name="cboIssueNoTo" id="cboIssueNoTo" style="width:120px;">
                          <option></option>
                            <?php 
					  	$SQL = " select  dblIssueNo from was_issuedtowashheader where intIssueYear=$issueYear
								order by dblIssueNo desc";
						$result = $db->RunQuery($SQL);
						while($row = mysql_fetch_array($result))
						{
							if($issueNoto == $row["dblIssueNo"])
								echo "<option selected=\"selected\" value=\"" . $row["dblIssueNo"] ."\">" . $row["dblIssueNo"] . "</option>";
							else
								echo "<option value=\"" . $row["dblIssueNo"] ."\">" . $row["dblIssueNo"] . "</option>";
						}
					  ?>
                          </select></td>
                        </tr>
                      </table></td>
                      </tr>
                    <tr class="normalfnt">
                      <td>Status</td>
                      <td><select name="cboStatus" id="cboStatus" style="width:122px;">
                      <option value="0" <?php if($intStatus==0){ echo  "selected=\"selected\"";} ?>>Pending</option>
                      <option value="1" <?php if($intStatus==1){ echo  "selected=\"selected\"";} ?>>Confirmed</option>
                      </select></td>
                      <td>&nbsp;</td>
                      <td><img src="../../images/search.png" width="80" height="24" onClick="viewIssuedWashData();"></td>
                    </tr>
                  </table></td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="4">
                  <table width="800" border="0" cellpadding="2" cellspacing="0" class="bcgl1">
                    <tr><td>
                  <div id="divwash" style="overflow:scroll; width:800px; height:300px;">
                    <table width="800" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="91" class="grid_header" height="20">Issue No</td>
                        <td width="116" class="grid_header">PO No</td>
                        <td width="128" class="grid_header">Style No</td>
                        <td width="75" class="grid_header">Date</td>
                        <td width="224" class="grid_header">Factory</td>
                        <td width="68" class="grid_header">View</td>
                        <td width="98" class="grid_header">Report</td>
                      </tr>
                      <?php 
					  
					  
					  	$sqlIssue = " SELECT wih.dblIssueNo,wih.intIssueYear,date(wih.dtmIssueDate) as dtmIssueDate,
									o.strOrderNo,o.strStyle,c.strComCode,wih.intStyleNo,concat(c.strName,'/',c.strCity) as Fac,
									wih.intStatus
									FROM was_issuedtowashheader wih INNER JOIN orders o ON
									wih.intStyleNo = o.intStyleId 
									INNER JOIN companies c ON c.intCompanyID = wih.strFComCode
									where wih.intIssueYear = '$intyear' ";
						
						if($comID != '')		
							$sqlIssue .= " and  wih.strFComCode = '$comID' ";
						
						if($styleNo != '')
							$sqlIssue .= " and  o.strStyle like '%$styleNo%' ";
							
						if($styleID != '')
							$sqlIssue .= " and  wih.intStyleNo = '$styleID' ";
							
						if($issueNofrm != '')
							$sqlIssue .= " and  wih.dblIssueNo >= '$issueNofrm' ";
							
						if($issueNoto != '')
							$sqlIssue .= " and  wih.dblIssueNo <= '$issueNoto' ";
						
						if($dfrom != '')
							$sqlIssue .= " and  date(wih.dtmIssueDate) >= '$dfrom' ";
							
						if($dto != '')
							$sqlIssue .= " and  date(wih.dtmIssueDate) <= '$dto' ";
						
						if($intStatus != '')
							$sqlIssue .= " and  wih.intStatus = '$intStatus' ";
							
						$sqlIssue .= " order by wih.dblIssueNo ";	
							//echo $sqlIssue;
						$result = $db->RunQuery($sqlIssue);
						$i=0;
						while($row = mysql_fetch_array($result))
						{
							if($i%2 == 0)
								$cls = 'grid_raw2';
							else
								$cls = 'grid_raw';
						$sqlChk="select count(*) as C from  was_stocktransactions where intDocumentNo='".$row["dblIssueNo"]."' and intDocumentYear='".$row["intIssueYear"]."';";
						//echo $sqlChk;

						$res=$db->RunQuery($sqlChk);
						$chk=0;
						$rowc=mysql_fetch_array($res);
						$c=$rowc['C']; 
						if( $c > 0  ){
							$chk=1;
							}
						else {
							$chk=0;
							}
						
					  ?><!--style="visibility:<?php if($chk==1){ echo "hidden";}else {echo "visible";}?>"-->
                      <tr>
                        <td height="20" class="<?php echo $cls ;?>"><?php echo $row["intIssueYear"].'/'.$row["dblIssueNo"]; ?></td>
                        <td class="<?php echo $cls ;?>" style="text-align:left;"><?php echo $row["strOrderNo"]; ?></td>
                        <td class="<?php echo $cls ;?>" style="text-align:left;"><?php echo $row["strStyle"]; ?></td>
                        <td class="<?php echo $cls ;?>"><?php echo $row["dtmIssueDate"]; ?></td>
                        <td class="<?php echo $cls ;?>" style="text-align:left;"><?php echo $row["Fac"]; ?></td>
                        <td class="<?php echo $cls ;?>"><img src="../../images/view2.png" height="18" onClick="loadToEdit(<?php echo $row["intIssueYear"];?>,<?php echo $row["dblIssueNo"]; ?>,<?php echo $row['intStatus']; ?>)" ></td>
                        <td class="<?php echo $cls ;?>"><img src="../../images/report.png" height="18"  onClick="loadReport(<?php echo $row["intIssueYear"];?>,<?php echo $row["dblIssueNo"]; ?>)" ></td>
                      </tr>
                      <?php 
					  $i++;
					  }
					  ?>
                    </table>
                  </div></td></tr></table></td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
