<?php
session_start();
$backwardseperator = "../../";
include "${backwardseperator}authentication.inc";
	  $comID = $_POST["cboissuewashFac"];
	  $styleNo = $_POST["cboStyleNo"];
	  $styleID = $_POST["cboOrderNo"];
	  $issueNofrm = $_POST["cbomMrnNofrom"];
	  $issueNoto = $_POST["cboMrnNoTo"];
	  $dfrom = $_POST["txtDfrom"];
	  $dto = $_POST["txtDto"];
	  $intyear = $_POST["cboYear"];
	  //$intStatus=$_POST['cboStatus'];
	  $dep=$_POST['wasMrn_cboDepartment'];
	  $store=$_POST['wasMrn_cboStore'];
	  $CompanyID = $_POST['cboOFactory'];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Gapro | Lab Testing Gatepass Testing</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css"/>
<script src="../../javascript/calendar/calendar.js" language="javascript" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" language="javascript" type="text/javascript"></script>
<script src="../../javascript/script.js" language="javascript" type="text/javascript"></script>
<script src="labtestinggplist.js" language="javascript" type="text/javascript"></script>

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
      <!--<tr><td>&nbsp;</td></tr>-->
        <tr>
          <td><table width="800" border="0" cellspacing="0" cellpadding="3" align="center" class="tableFooter">
            <tr>
              <td width="800"><table width="800" border="0" cellspacing="0" cellpadding="0" class="normalfnt" align="center">
                <tr>
                  <td colspan="4" class="mainHeading" height="26">Lab Testing  Listing</td>
                  </tr>
                <tr>
                  <td height="20" colspan="4"><table width="650" border="0" cellspacing="0" cellpadding="2" class="" align="center">

                    <tr class="normalfnt">
                      <td width="136">PO No</td>
                      <td width="210"><select name="cboOrderNo" id="cboOrderNo" style="width:152px;height:18px;" onChange="getStyle(this);">
                        <option></option>
                          <?php 
					  	$sql = "SELECT DISTINCT
								o.strOrderNo,
								o.strStyle,
								o.intStyleId
								FROM
								was_labtestinggp AS l
								INNER JOIN orders AS o ON l.intStyleNo = o.intStyleId
								WHERE
								l.intFromFac =".$_SESSION['FactoryID']."
								ORDER BY
								o.strOrderNo ASC;";
							
						$result = $db->RunQuery($sql);
						while($row = mysql_fetch_array($result))
						{
							if($styleID==$row["intStyleId"])
								echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . trim($row["strOrderNo"]) ."</option>" ;
							else		
								echo "<option value=\"" . $row["intStyleId"] ."\">" . $row["strOrderNo"] . "</option>";
						}
							
					  ?>
                        </select></td>
                      <td width="79">Style No</td>
                      <td width="163"><select name="cboStyleNo" id="cboStyleNo" style="width:152px;height:18px;" onChange="getStylewiseOrderNo(this);">
                        <option></option>
                        <?php 
					  	$sql = "SELECT DISTINCT
								o.strStyle
								from was_mrn m
								inner join orders o on o.intStyleId=m.intStyleId
								WHERE
								m.intCompanyId = '".$_SESSION['FactoryID']."'
								order by o.strStyle";
									
							
						$result = $db->RunQuery($sql);
						while($row = mysql_fetch_array($result))
						{
							if($styleNo==$row["strStyle"])
								echo "<option selected=\"selected\" \" value=\"".$row["strStyle"]."\">" . $row["strStyle"] . "</option>";
							else
								echo "<option value=\"".$row["strStyle"]."\">" . $row["strStyle"] . "</option>";
						}
							
					  ?>
                      </select></td>
                    </tr>
                    <tr class="normalfnt">
                      <td>Date From</td>
                      <td><input type="text" name="txtDfrom" id="txtDfrom" style="width:120px;height:18px;" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo $dfrom; ?>" /><input type="reset" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
                      <td>Date To</td>
                      <td><input type="text" name="txtDto" id="txtDto" style="width:121px;height:18px;" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo $dto; ?>" /><input type="reset" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
                    </tr>
                    <tr class="normalfnt">
                      <td>GP # From</td>
                      <td><select name="cbomMrnNofrom" id="cbomMrnNofrom" style="width:121px;height:18px;">
                        <option value=""></option>
                        <?php 
					  	$SQL = "SELECT DISTINCT concat(l.intLabGPYear,'/',l.dblLabGPNo) as GP FROM was_labtestinggp AS l WHERE l.intFromFac='".$_SESSION['FactoryID']."';";
						$result = $db->RunQuery($SQL);
						while($row = mysql_fetch_array($result))
						{
							if($issueNofrm == $row["GP"])
								echo "<option selected=\"selected\" value=\"" . $row["GP"] ."\">" . $row["GP"] . "</option>";
							else
								echo "<option value=\"" . $row["GP"] ."\">" . $row["GP"] . "</option>";
						}
					  ?>
                      </select></td>
                      <td>GP # To</td>
                      <td><select name="cboMrnNoTo" id="cboMrnNoTo" style="width:122px;height:18px;">
                        <option value=""></option>
                        <?php 
					  	$SQL = "SELECT DISTINCT concat(l.intLabGPYear,'/',l.dblLabGPNo) as GP FROM was_labtestinggp AS l WHERE l.intFromFac='".$_SESSION['FactoryID']."';";
						$result = $db->RunQuery($SQL);
						while($row = mysql_fetch_array($result))
						{
							if($issueNoto == $row["GP"])
								echo "<option selected=\"selected\" value=\"" . $row["GP"] ."\">" . $row["GP"] . "</option>";
							else
								echo "<option value=\"" . $row["GP"] ."\">" . $row["GP"] . "</option>";
						}
					  ?>
                      </select></td>
                    </tr>
                                      
                    <tr class="normalfnt">
                      <td>To Factory</td>
                      <td colspan="2">
                      <select id="cboOFactory" name="cboOFactory" style="width:300px;">
                      <option value="">Select One</option>
                      <?php 
					  $sql="SELECT was_outside_companies.intCompanyID,was_outside_companies.strName
							from was_outside_companies
							WHERE
							was_outside_companies.intStatus = 1
							ORDER BY
							was_outside_companies.strName ASC;";
							$result = $db->RunQuery($sql);
						while($row = mysql_fetch_array($result))
						{
							if($CompanyID==$row["intCompanyID"])
								echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . trim($row["strName"]) ."</option>" ;
							else		
								echo "<option value=\"" . $row["intCompanyID"] ."\">" . $row["strName"] . "</option>";
						}
					  ?>
                      </select>
                      </td>
                      <td align="right"><img src="../../images/search.png" width="80" height="24" onClick="viewIssuedWashData();"></td>
                    </tr>
                  </table></td>
                  </tr>
                <tr>
                  <td width="336">&nbsp;</td>
                  <td width="280">&nbsp;</td>
                  <td width="56">&nbsp;</td>
                  <td width="134">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="4">
                  <table width="800" border="0" cellpadding="2" cellspacing="0" class="bcgl1">
                    <tr><td>
                  <div id="divwash" style="overflow:scroll; width:800px; height:300px;">
                    <table width="778" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="98" class="grid_header" height="20">GP No</td>
                        <td width="95" class="grid_header">PO No</td>
                        <td width="103" class="grid_header">Style No</td>
                        <td width="138" class="grid_header">Color</td>
                        <td width="101" class="grid_header">Date</td>
                        <td width="70" class="grid_header">Qty</td>
                        <td width="80" class="grid_header" style="display:none;">View</td>
                        <td width="93" class="grid_header">Report</td>
                      </tr>
                      <?php 
					  
					  
					  	$sqlIssue = " SELECT
										concat(was_labtestinggp.intRequestYear,'/',was_labtestinggp.dblLabGPNo) as GP,
										orders.strOrderNo,
										orders.strStyle,
										was_labtestinggp.strColor,
										was_labtestinggp.dtmDate,
										was_labtestinggp.dblQty
										FROM
										was_labtestinggp
										INNER JOIN orders ON was_labtestinggp.intStyleNo = orders.intStyleId
										WHERE
										 
										was_labtestinggp.intFromFac='".$_SESSION['FactoryID']."'
										";
						
						
						if($CompanyID != '')
							$sqlIssue .= "  and was_labtestinggp.intToFac='$CompanyID' ";
							
						if($styleID != '')
							$sqlIssue .= " and  was_labtestinggp.intStyleNo = '$styleID' ";
							
						if($issueNofrm != '')
							$sqlIssue .= " and  concat(was_labtestinggp.intRequestYear,'/',was_labtestinggp.dblLabGPNo) >= '$issueNofrm' ";
							
						if($issueNoto != '')
							$sqlIssue .= " and  concat(was_labtestinggp.intRequestYear,'/',was_labtestinggp.dblLabGPNo) <= '$issueNoto' ";
						
						if($dfrom != '')
							$sqlIssue .= " and  date(was_labtestinggp.dtmDate) >= '$dfrom' ";
							
						if($dto != '')
							$sqlIssue .= " and  date(was_labtestinggp.dtmDate) <= '$dto' ";
							
			
							
						$sqlIssue .= "ORDER BY was_labtestinggp.intLabGPYear,was_labtestinggp.dblLabGPNo ASC; ";	
						//echo $sqlIssue;
						$result = $db->RunQuery($sqlIssue);
						$i=0;
						while($row = mysql_fetch_array($result))
						{
							if($i%2 == 0)
								$cls = 'grid_raw2';
							else
								$cls = 'grid_raw';
													
					  ?><!--style="visibility:<?php if($chk==1){ echo "hidden";}else {echo "visible";}?>"-->
                      <tr>
                        <td height="20" class="<?php echo $cls ;?>"><?php echo $row['GP'];?></td>
                        <td class="<?php echo $cls ;?>" style="text-align:left;"><?php echo $row['strOrderNo'];?></td>
                        <td class="<?php echo $cls ;?>" style="text-align:left;"><?php echo $row['strStyle'];?></td>
                        <td class="<?php echo $cls ;?>" style="text-align:left;"><?php echo $row['strColor'];?></td>
                        <td class="<?php echo $cls ;?>" style="text-align:left;"><?php echo substr($row['dtmDate'],0,10);?></td>
                        <td class="<?php echo $cls ;?>" style="text-align:right;"><?php echo $row['dblQty'];?></td>
                        <td class="<?php echo $cls ;?>" style="display:none;"><img src="../../images/view2.png" height="18" onClick="loadToEdit('<?php echo $row["MRN"];?>')" ></td>
                        <td class="<?php echo $cls ;?>"><img src="../../images/report.png" height="18"  onClick="loadReport('<?php echo $row["GP"];?>')" ></td>
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
                  <td><img onClick="clearForm();" src="../../images/new.png">
                  <img src="../../images/report.png" onClick="showReport();" style="display:none;" />
                  <a href="../../main.php"><img border="0" src="../../images/close.png" alt="close" class="normalfntMid"></a></td>
                  <td width="56">&nbsp;</td>
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
