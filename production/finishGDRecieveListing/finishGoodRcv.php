<?php
session_start();
$backwardseperator = "../../";
include "${backwardseperator}authentication.inc";
$factoryID=$_POST['cboFactory'];
$styleNo=$_POST['cboPo'];
$styleN=$_POST['cboStyle'];
$gpNO=$_POST['cobGPNo'];
$dateFrom=$_POST['txtDateFrom'];
$dateTo=$_POST['txtDateTo'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Wash Receive Listing</title>
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>
<script src="finishGoodRcv.js" type="text/javascript"></script>
<script type="text/javascript">
function submitFrom(){
	document.getElementById('frmInputListing').submit();	
} 

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

<body>
<?php
	include "../../Connector.php";	
?>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td><?php include $backwardseperator."Header.php";?></td>
	</tr>
</table>

	<form name="frmInputListing" id="frmInputListing" method="post">
    	<table border="0"  align="center" class="main_border_line">
        	<tr>
                <td class="mainHeading">Wash Receive Listing</td>
            </tr>
        	<tr>
            	<td>
                    <table border="0" class="main_border_line" cellpadding="0" cellspacing="2">
                        
                        <tr style="display:none;">
                            <td style="width:50;" >&nbsp;</td>
                            <td style="width:100px;" class="normalfnt">Factory</td>
                            <td  colspan="4" style="width:600px;" >
                            <select name="cboFactory" id="cboFactory" class="txtbox" style="width:500px"  tabindex="1">
                                <?php
                                $SQL = "SELECT DISTINCT c.intCompanyID,c.strName,c.strCity 
                                            FROM companies c
                                                INNER JOIN productionfinishedgoodsreceiveheader p ON p.strTComCode=c.intCompanyID
                                                    ;";//WHERE c.intManufacturing=1
                                $result = $db->RunQuery($SQL);
                                
                                echo "<option value = \"\">" . "Select One" . "</option>";
                                while($row = mysql_fetch_array($result))
                                {
									if($factoryID==$row["intCompanyID"])
                                   	 	echo "<option value=\"" . $row["intCompanyID"] ."\" selected=\"selected\">" . $row["strName"] ." - ". $row["strCity"] . "</option>";
									else
										echo "<option value=\"" . $row["intCompanyID"] ."\">" . $row["strName"] ." - ". $row["strCity"] . "</option>";
                                }
                                ?>
                            </select>
                            </td>
                            
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td class="normalfnt" style="width:100px;">Order No</td>
                          <td style="width:200px;"><select  name="cboPo" id="cboPo" style="width:200px;" onchange="selectStyle(this);"> <!--LoadGrid('cboPo')-->
                            <?php
                                    $SQL = "SELECT DISTINCT
											productionfinishedgoodsreceiveheader.intStyleNo, 
											orders.strOrderNo
											FROM
											productionfinishedgoodsreceiveheader  LEFT JOIN orders ON productionfinishedgoodsreceiveheader.intStyleNo = orders.intStyleId
											WHERE
							productionfinishedgoodsreceiveheader.strTComCode='".$_SESSION['FactoryID']."'
											group by productionfinishedgoodsreceiveheader.intStyleNo 
											order by orders.strOrderNo ASC";
                                    $result = $db->RunQuery($SQL);
                                    
                                    echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
                                    while($row = mysql_fetch_array($result))
                                    {
										if($styleNo==$row['intStyleNo'])
                                       	 	echo "<option value=\"" . $row["intStyleNo"] ."\" selected=\"selected\">" . $row["strOrderNo"] . "</option>";
										else
											echo "<option value=\"" . $row["intStyleNo"] ."\">" . $row["strOrderNo"] . "</option>";
                                    }
                                ?>
                          </select></td>
                          <td class="normalfnt" style="width:100px;">Style name</td>
                          <td style="width:200px;"><select name="cboStyle" id="cboStyle" class="txtbox" style="width:196px" onchange="selectPo(this);">
                            <?php
                                    $SQL = "SELECT DISTINCT
											orders.strStyle
											FROM
										    productionfinishedgoodsreceiveheader  LEFT JOIN orders ON productionfinishedgoodsreceiveheader.intStyleNo = orders.intStyleId
										    WHERE
										    productionfinishedgoodsreceiveheader.strTComCode='".$_SESSION['FactoryID']."'
										    group by productionfinishedgoodsreceiveheader.intStyleNo 
										    order by orders.strStyle ASC";
                                    $result = $db->RunQuery($SQL);
                                    
                                    echo "<option value = \"\">" . "Select One" . "</option>";
                                    while($row = mysql_fetch_array($result))
                                    {
										if($styleN==$row['strStyle'])
										echo "<option value=\"" . $row["strStyle"] ."\" selected=\"selected\">" . $row["strStyle"] . "</option>";
                                        else
										echo "<option value=\"" . $row["strStyle"] ."\">" . $row["strStyle"] . "</option>";
                                    }
                                ?>
                          </select></td>
                          <td style="width:100px;" >&nbsp;</td>
                          
                        </tr>
                        <td>&nbsp;</td>
                          <td class="normalfnt" style="width:100px;">GatePass No</td>
                          <td colspan="3" style="width:500px;"><select  style="width:500px;" name="cobGPNo" id="cboGPNo">
                          <?php 
                            $SQL="SELECT distinct concat(productionfinishedgoodsreceiveheader.intGPYear,'/',					productionfinishedgoodsreceiveheader.dblGatePassNo) as GP,
							CONCAT(productionfinishedgoodsreceiveheader.intGPTYear,'/',productionfinishedgoodsreceiveheader.dblGatePassNo,' -> ',orders.strOrderNo,'/',orders.strStyle) AS GPNo

							FROM productionfinishedgoodsreceiveheader
							INNER JOIN orders ON orders.intStyleId = productionfinishedgoodsreceiveheader.intStyleNo
							WHERE
							productionfinishedgoodsreceiveheader.strTComCode='".$_SESSION['FactoryID']."'
							ORDER BY dblGatePassNo DESC;";
									$result = $db->RunQuery($SQL);
									echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
									while($row = mysql_fetch_array($result))
									{
										if($gpNO==$row["GP"])
											echo "<option value=\"" .$row["GP"]."\" selected=\"selected\">" . $row["GPNo"]. "</option>";	
										else
											echo "<option value=\"" .$row["GP"]."\">" . $row["GPNo"]. "</option>";	
									}
							?>
                          </select></td>
                          <!--<td class="normalfnt" style="width:100px;">&nbsp;</td>
                          <td>&nbsp;</td>-->
                          <td style="width:100px;">&nbsp;</td>
                        <tr>
                          <td>&nbsp;</td>
                          <td class="normalfnt" style="width:100px;">Date From</td>
                          <td><input name="txtDateFrom" type="text" tabindex="9" class="txtbox" id="txtDateFrom" style="width:100px"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%Y/%m/%d');" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');" value="<?php echo $dateFrom;?>"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');" value="" /></td>
                          <td class="normalfnt" style="width:100px;">Date To</td>
                          <td style="width:100px;"><input name="txtDateTo" type="text" tabindex="9" class="txtbox" id="txtDateTo" style="width:100px"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%Y/%m/%d');" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');" value="<?php echo $dateTo;?>"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');" value="" /></td>
                          <td style="width:100px;"><img src="../../images/search.png" onclick="submitFrom()"/></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td class="normalfnt">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td style="width:100px;" class="normalfnt"></td>
                            <td style="width:200px;"></td>
                            <td style="width:100px;"></td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                    </table>
                    
          <br/>
                    
                    <div id="divcons" style="overflow:scroll; height:300px; width:725px;"><table width="705" border="0" class="main_border_line" id="tableGatePass">
                        <!--<tr>
                            <td height="20" colspan="7" class="sub_containers">Wash Receive</td>
                        </tr>-->
                        <tr>
                            <td width="150" class="grid_header">Transf No</td>
                            <td width="150" class="grid_header">Date</td>
                            <td width="100" class="grid_header">Total Qty</td>
                            <td width="100" class="grid_header">View</td>
                            <td width="100" class="grid_header">Report</td>
                        </tr>
                        <?php 
						$sql = "SELECT 
								concat(productionfinishedgoodsreceiveheader.intGPTYear,'/',productionfinishedgoodsreceiveheader.dblTransInNo) AS GP, 
								 productionfinishedgoodsreceiveheader.intGPTYear,
								 productionfinishedgoodsreceiveheader.dblTransInNo,
								 productionfinishedgoodsreceiveheader.dtmTransInDate, 
								 productionfinishedgoodsreceiveheader.dblTotQty 
								 FROM productionfinishedgoodsreceiveheader 
								 WHERE
								 productionfinishedgoodsreceiveheader.strTComCode = '".$_SESSION['FactoryID']."'";
								   if($factoryID!="")
								  $sql .=" AND productionfinishedgoodsreceiveheader.strTComCode = '$factoryID'";
								   if($styleNo!="")
								  $sql .=" AND productionfinishedgoodsreceiveheader.intStyleNo = '$styleNo'";
								   if($dateFrom!="")
								  $sql .=" AND date(productionfinishedgoodsreceiveheader.dtmTransInDate) >= '$dateFrom'";
								   if($dateTo!="")
								  $sql .=" AND date(productionfinishedgoodsreceiveheader.dtmTransInDate) <= '$dateTo'";
								   if($gpNO!=""){
									$sql.=" AND concat(productionfinishedgoodsreceiveheader.intGPYear,'/',productionfinishedgoodsreceiveheader.dblGatePassNo) =  '$gpNO'";
									}
								   $sql .="  ORDER BY productionfinishedgoodsreceiveheader.dblTransInNo DESC";
								  // echo $sql;
								  $res=$db->RunQuery($sql);
								  $i=0;
								  $cls='';
								  while($row=mysql_fetch_array($res)){
									  ($i%2==0)?$cls="grid_raw":$cls="grid_raw2";
						?>
                        <tr>
                            <td width="79" class="<?php echo $cls;?>"><a target="_blank" class="non-html pdf" href="../finishGoodsReceive/finishGoodsReceive.php?SerialNumber=<?php echo $row['dblTransInNo'];?>&intYear=<?php echo $row['intGPTYear'];?>&id=1" style="text-align:left;">&nbsp;<?php echo $row['GP'];?></a></td>
                            <td width="99" class="<?php echo $cls;?>" ><?php echo substr($row['dtmTransInDate'],0,10);?></td>
                            <td width="83" class="<?php echo $cls;?>" style="text-align:right"><?php echo $row['dblTotQty'];?>&nbsp;</td>
                            <td width="69" class="<?php echo $cls;?>"><img src="../../images/view2.png" height="18" border="0" onclick="loadData(<?php echo $row['dblTransInNo'];?>,<?php echo $row['intGPTYear'];?>)"/></td>
                            <td width="104" class="<?php echo $cls;?>">
                            <img src="../../images/report.png" height="18" border="0" onclick='loadReport(<?php echo $row['dblTransInNo'];?>,<?php echo $row['intGPTYear'];?>)'/>
                            </td>
                        </tr>
                        <?php $i++;}?>
                    </table></div>
              </td>
        	</tr>
            <tr><td align="center"><img src="../../images/new.png"  onclick="clearForm();" /><a href="../../main.php"><img border="0" class="normalfntMid" alt="close" src="../../images/close.png"></a></td></tr>
        </table>
		<br/>
	</form>
<!--	</div>
	<div class="gap"></div>
</div>-->
</body>
</html>