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
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Wash MRN Issue List</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css"/>
<script src="../../javascript/calendar/calendar.js" language="javascript" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" language="javascript" type="text/javascript"></script>
<script src="../../javascript/script.js" language="javascript" type="text/javascript"></script>
<script src="issueList.js" language="javascript" type="text/javascript"></script>

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
<!--      <tr><td>&nbsp;</td></tr>-->
        <tr>
          <td><table width="800" border="0" cellspacing="0" cellpadding="3" align="center" class="tableFooter">
            <tr>
              <td width="800"><table width="800" border="0" cellspacing="0" cellpadding="0" class="normalfnt" align="center">
                <tr>
                  <td colspan="4" class="mainHeading" height="26">Washing MRN Issue Listing</td>
                  </tr>
                <tr>
                  <td height="20" colspan="4"><table width="650" border="0" cellspacing="0" cellpadding="2" class="" align="center">

                    <tr class="normalfnt">
                      <td width="136">PO No</td>
                      <td width="210"><select name="cboOrderNo" id="cboOrderNo" style="width:122px;" onChange="getStyle(this)">
                        <option value=""></option>
                          <?php 
					  	$sql = "SELECT DISTINCT
								orders.strOrderNo,
								orders.intStyleId,
								orders.strStyle
								FROM
								was_issue
								INNER JOIN orders ON was_issue.intStyleId = orders.intStyleId
								WHERE
								was_issue.intCompanyID='".$_SESSION['FactoryID']."'
								ORDER BY
								orders.strOrderNo ASC;";
							
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
                      <td width="163"><select name="cboStyleNo" id="cboStyleNo" style="width:122px;" onChange="getStylewiseOrderNo(this);">
                        <option value=""></option>
                        <?php 
					  	$sql = "SELECT DISTINCT
								orders.strOrderNo,
								orders.intStyleId,
								orders.strStyle
								FROM
								was_issue
								INNER JOIN orders ON was_issue.intStyleId = orders.intStyleId
								WHERE
								was_issue.intCompanyID='".$_SESSION['FactoryID']."' 
								ORDER BY orders.strOrderNo ASC;";
							
						$result = $db->RunQuery($sql);
						while($row = mysql_fetch_array($result))
						{
							if($styleNo==$row["strStyle"])
								echo "<option selected=\"selected\" value=\"".$row["intStyleId"]."\" >" . $row["strStyle"] . "</option>";
							else
								echo "<option \">" . $row["strStyle"] . "</option>";
						}
							
					  ?>
                      </select></td>
                    </tr>
                    <tr class="normalfnt">
                      <td>Store</td>
                      <td><select name="wasMrn_cboStore" id="wasMrn_cboStore" style="width:152px;" tabindex="1">
                                        	<option value="">Select One</option>
            <?php 
			$SQL = "SELECT strMainID,strName FROM mainstores WHERE intStatus = '1' order by strName";	
			$result = $db->RunQuery($SQL);		
			while($row = mysql_fetch_array($result))
			{
				
							if($store==$row["strMainID"])
								echo "<option selected=\"selected\" value=\"". $row["strMainID"] ."\">" . trim($row["strName"]) ."</option>" ;
							else		
								echo "<option value=\"". $row["strMainID"] ."\">" . $row["strName"] ."</option>" ;
			}
		?>
                                        </select></td>
                      <td>Department</td>
                      <td><select name="wasMrn_cboDepartment" id="wasMrn_cboDepartment" style="width:152px;" tabindex="2">
                                        <option value="" selected="selected">Select One</option>
                  <?php 

			$SQL = "SELECT intDepID,strDepartment FROM department where intStatus='1'  order by strDepartment";	
			$result = $db->RunQuery($SQL);		
			while($row = mysql_fetch_array($result))
			{
			
							if($dep==$row["intDepID"])
								echo "<option selected=\"selected\" value=\"". $row["intDepID"] ."\">" . trim($row["strDepartment"]) ."</option>" ;
							else		
								echo "<option value=\"". $row["intDepID"] ."\">" . $row["strDepartment"] ."</option>" ;
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
                   
                          <td>Issue # From</td>
                          <td><select name="cbomMrnNofrom" id="cbomMrnNofrom" style="width:120px;">
                            <option value=""></option>
                            <?php 
					  	$SQL = "SELECT
								concat(was_issue.intIssueYear,'/',was_issue.intIssueNo) as INO
								FROM
								was_issue
								WHERE
								was_issue.intCompanyId='".$_SESSION['FactoryID']."' order by INO;";
						$result = $db->RunQuery($SQL);
						while($row = mysql_fetch_array($result))
						{
							if($issueNofrm == $row["INO"])
								echo "<option selected=\"selected\" value=\"" . $row["INO"] ."\">" . $row["INO"] . "</option>";
							else
								echo "<option value=\"" . $row["INO"] ."\">" . $row["INO"] . "</option>";
						}
					  ?>
                          </select></td>
                          <td>Issue # To </td>
                          <td><select name="cboMrnNoTo" id="cboMrnNoTo" style="width:120px;">
                            <option value=""></option>
                            <?php 
					  	$SQL = " SELECT
								concat(was_issue.intIssueYear,'/',was_issue.intIssueNo) as INO
								FROM
								was_issue
								WHERE
								was_issue.intCompanyId='".$_SESSION['FactoryID']."' order by INO;";
						$result = $db->RunQuery($SQL);
						while($row = mysql_fetch_array($result))
						{
							if($issueNoto == $row["INO"])
								echo "<option selected=\"selected\" value=\"" . $row["INO"] ."\">" . $row["INO"] . "</option>";
							else
								echo "<option value=\"" . $row["INO"] ."\">" . $row["INO"] . "</option>";
						}
					  ?>
                          </select></td>
              
                      </tr>
                    
                    <tr class="normalfnt">
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td><img src="../../images/search.png" width="80" height="24" onClick="viewIssuedWashData();"></td>
                    </tr>
                  </table></td>
                  </tr>
                <tr>
                  <td width="346">&nbsp;</td>
                  <td width="231">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td width="20">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="4">
                  <table width="800" border="0" cellpadding="2" cellspacing="0" class="bcgl1">
                    <tr><td>
                  <div id="divwash" style="overflow:scroll; width:800px; height:300px;">
                    <table width="800" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="98" class="grid_header" height="20">Issue No</td>
                        <td width="95" class="grid_header">PO No</td>
                        <td width="103" class="grid_header">Style No</td>
                        <td width="139" class="grid_header">Color</td>
                        <td width="101" class="grid_header">Date</td>
                        <td width="70" class="grid_header">Qty</td>
                        <td width="79" class="grid_header">View</td>
                        <td width="115" class="grid_header">Report</td>
                      </tr>
                      <?php 
					  
					  
					  	$sqlIssue = " SELECT
										was_issue.intStyleId,
										orders.strOrderNo,
										orders.intStyleId,
										orders.strStyle,
										was_issue.strColor,
										was_issue.dtmDate,
										was_issue.intIssueNo,
										was_issue.intIssueYear,
										mainstores.strMainID,
										mainstores.strName,
										concat(was_issue.intMrnYear,'/',was_issue.dblMrnNo) as MRN,
										department.strDepartment,
										department.intDepID,
										concat(was_issue.intIssueYear,'/',was_issue.intIssueNo) as INO,
										was_issue.dblQty
										FROM
										was_issue
										INNER JOIN orders ON was_issue.intStyleId = orders.intStyleId
										INNER JOIN mainstores ON was_issue.intStore = mainstores.strMainID
										INNER JOIN department ON department.intDepID = was_issue.intDepartment
										WHERE
										was_issue.intCompanyId='".$_SESSION['FactoryID']."' ";
						
						
						if($styleNo != '')
							$sqlIssue .= "  and orders.strStyle like '%$styleNo%' ";
							
						if($styleID != '')
							$sqlIssue .= " and  was_issue.intStyleId= '$styleID' ";
							
						if($issueNofrm != '')
							$sqlIssue .= " and concat(was_issue.intIssueYear,'/',was_issue.intIssueNo)  >= '$issueNofrm' ";
							
						if($issueNoto != '')
							$sqlIssue .= " and  concat(was_issue.intIssueYear,'/',was_issue.intIssueNo) <= '$issueNoto' ";
						
						if($dfrom != '')
							$sqlIssue .= " and  date(was_issue.dtmDate) >= '$dfrom' ";
							
						if($dto != '')
							$sqlIssue .= " and  date(was_issue.dtmDate) <= '$dto' ";
							
						if($dep != '')
							$sqlIssue .= " and  was_issue.intDepartment = '$dep' ";
							
						if($store != '')
							$sqlIssue .= " and  was_issue.intStore = '$store' ";
						
							
						$sqlIssue .= " order by was_issue.intIssueNo; ";	
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
                        <td height="20" class="<?php echo $cls ;?>"><?php echo $row['INO'];?></td>
                        <td class="<?php echo $cls ;?>" style="text-align:left;"><?php echo $row['strOrderNo'];?></td>
                        <td class="<?php echo $cls ;?>" style="text-align:left;"><?php echo $row['strStyle'];?></td>
                        <td class="<?php echo $cls ;?>" style="text-align:left;"><?php echo $row['strColor'];?></td>
                        <td class="<?php echo $cls ;?>" style="text-align:left;"><?php echo substr($row['dtmDate'],0,10);?></td>
                        <td class="<?php echo $cls ;?>" style="text-align:right;"><?php echo $row['dblQty'];?></td>
                        <td class="<?php echo $cls ;?>"><img src="../../images/view2.png" height="18"  onClick="loadDetToEdit('<?php echo $row['INO'];?>')" ></td><!--onClick="loadToEdit('<?php echo $row["INO"];?>''<?php echo $row['MRN'];?>',)"-->
                        <td class="<?php echo $cls ;?>"><img src="../../images/report.png" height="18"  onClick="loadReport('<?php echo $row["INO"];?>')" ></td>
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
                  <td width="209">&nbsp;</td>
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
