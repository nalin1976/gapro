<?php
session_start();
$backwardseperator = "../../";
include "../../Connector.php";
$cboMode	=	$_POST['cboMode'];
$costID		=	$_POST['frmMachineLoadingList_cboCostId'];
$machineType	=	$_POST['frmMachineLoadingList_cboMachineType'];
$machine	=	$_POST['machineLoadingList_cboMachine'];
$fromDate	=	$_POST['fromDate'];
$toDate		=	$_POST['toDate'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Machine Loading List</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/jquery.js" type="text/jscript"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="machineLoading.js" type="text/javascript"></script>
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

function dateDisable(obj)
{
	if(obj.checked){
		document.getElementById('fromDate').disabled=false;
		document.getElementById('toDate').disabled=false;
	}
	else{
		document.getElementById('fromDate').disabled=true;
		document.getElementById('toDate').disabled=true;
	}
}

function closeWindow1()
{
alert("A");
	try
	{
		var box = document.getElementById('popupbox');
		box.parentNode.removeChild(box);
	}
	catch(err)
	{        
	}	
}
</script>
</head>

<body>
<form name="frmMachineLoadingList" id="frmMachineLoadingList" action="machineLoadingList.php" method="post">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6"><?php include($backwardseperator.'Header.php'); ?></td>
	</tr> 
</table>

<!--<div class="main_bottom_center">
	<div class="main_top "><div class="main_text">Machine Loading List</div></div>
<div class="main_body">-->

<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="bcgl1">
  <tr>
  	<td class="mainHeading">Machine Loading List</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <td width="61%"  class="containers"><table width="23%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="1%">&nbsp;</td>
              <td width="5%" class="containers">Mode </td>
              <td width="94%"><select name="cboMode" class="txtbox" id="cboMode" style="width:150px">
                  <option value="1" <?php if($_POST["cboMode"]==1){?>selected="selected"<?php }?>>Pass</option>
                  <option value="0" <?php if($_POST["cboMode"]==0){?>selected="selected"<?php }?>>Fail</option>
				  <option value="5" <?php if($_POST["cboMode"]==5){?>selected="selected"<?php }?>>Rewash</option>
              </select></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="tablezRED">
      <tr>
        <td width="6%">Cost ID</td>
        <td width="11%"><select name="frmMachineLoadingList_cboCostId" class="txtbox" id="frmMachineLoadingList_cboCostId" style="width:100px" onchange="">
		 <option value="" selected="selected" ></option>
                    <?php 
				$SQL = "SELECT DISTINCT intCostId FROM was_machineloadingheader ORDER BY intCostId";	
				$result = $db->RunQuery($SQL);		

				while($row = mysql_fetch_array($result))
				{	
					if($_POST['frmMachineLoadingList_cboCostId']==$row["intCostId"]){
						echo "<option value=\"". $row["intCostId"] ."\" selected=\"selected\">" . $row["intCostId"] ."</option>" ;
					}
					else{
						echo "<option value=\"". $row["intCostId"] ."\" >" . $row["intCostId"] ."</option>" ;
					}
				}
				
				?>
								 
            </select></td>
			
          <td width="10%">Machine Type</td>
          <td width="11%" colspan="0"><select name="frmMachineLoadingList_cboMachineType" class="txtbox" id="frmMachineLoadingList_cboMachineType" style="width:100px;" onchange="loadMacinesList(this.value)"> 

		<?php

		$SQL="SELECT DISTINCT intMachineId,strMachineType FROM was_machinetype ORDER BY strMachineType";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{	
				if($_POST['frmMachineLoadingList_cboMachineType']==$row["intMachineId"]){ ?>
					<option value="<?php echo $row['intMachineId'];?>" selected="selected"><?php echo $row["strMachineType"];?></option>
					<?php }
				else{ ?>
					<option value="<?php echo $row["intMachineId"];?>"><?php echo $row["strMachineType"];?></option>
			<?php }
			}
	
 	 ?>
 </select></td>
 
  <td width="5%">Machine</td>
          <td width="12%" colspan="0"><select name="machineLoadingList_cboMachine" class="txtbox" id="machineLoadingList_cboMachine" style="width:100px"> 

		<?php

		$SQL="SELECT was_machine.intMachineId,was_machine.strMachineName FROM was_machine ORDER BY strMachineName";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST['machineLoadingList_cboMachine']==$row["intMachineId"]){
					echo "<option value=\"".$row["intMachineId"]."\" selected=\"selected\">".$row["strMachineName"]."</option>";
					}
				else{
					echo "<option value=\"".$row["intMachineId"]."\">".$row["strMachineName"]."</option>";
				}
			}

 	    ?>
 </select></td>
		 <td width="3%"  class="normalfnt"><input type="checkbox" id="edDate" name="edDate" onclick="rdDateP(this)"/></td>
		 <td width="4%"  class="normalfnt">From</td>
        <td width="13%"  class="normalfnt"><input name="fromDate" type="text" class="txtbox" id="fromDate" size="10" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo $fromDate;?>" /><input name="reset" id="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value=""/></td>
	
 <td width="3%"  class="normalfnt">To</td>	
 <td width="13%"  class="normalfnt"><input name="toDate" type="text" class="txtbox" id="toDate" size="10" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo $toDate;?>" /><input name="reset" id="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value=""/></td>
		
<td width="9%" ><img src="../../images/search.png" alt="search" width="80" height="24" class="mouseover" onclick="loadMachineLoadningGrid();"/></td>

      </tr>
    </table></td>
  </tr>

  
    <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="2"><div id="divcons2" style="overflow:scroll; height:240px; width:950px;">
          <table width="1600" cellpadding="0" cellspacing="1" bgcolor="" id="tblMachineLoadingList">
            <tr>
			  <td  class="grid_header">Edit</td>
              <td  class="grid_header">Po No</td>
              <td  class="grid_header">Cost ID</td>
			  <td  class="grid_header">Machine Type</td>
			  <td  class="grid_header">Machine Name</td>
			  <td  class="grid_header">Lot No</td>
			  <td  class="grid_header">Rewash No</td>
			  <td  class="grid_header">Time In</td>
  			  <td  class="grid_header">Time Out</td>
			  <td  bgcolor="#498CC2" class="grid_header">No of PC</td>
   			  <td  bgcolor="#498CC2" class="grid_header">Weight</td>
   			  <!--<td  bgcolor="#498CC2" class="grid_header">Operator Id</td>-->
			  <td  bgcolor="#498CC2" class="grid_header">Shift</td>
			  <td  bgcolor="#498CC2" class="grid_header">Root Card No</td>
   			  <td  bgcolor="#498CC2" class="grid_header">Operator Name</td>
   			  <td  bgcolor="#498CC2" class="grid_header">In Date</td>
   			  <td  bgcolor="#498CC2" class="grid_header">Out Date</td>
   			  <!--<td  bgcolor="#498CC2" class="grid_header">Status</td>-->
   			  <td bgcolor="#498CC2" class="grid_header">Color</td>
   			  <td bgcolor="#498CC2" class="grid_header">Wash Type</td>
             </tr>
			 <?php 
			 $SQL=  "SELECT orders.strStyle,orders.intStyleId,was_machineloadingheader.intCostId,was_machine.strMachineName,was_machinetype.strMachineType,was_machineloadingheader.intLotNo,was_machineloadingheader.intReWashNo,was_machineloadingheader.tmInTime,was_machineloadingheader.tmOutTime,was_operators.strName,was_shift.strShiftName,was_machineloadingheader.intRootCardNo,was_machineloadingheader.intRootCardYear,was_machineloadingheader.intStatus,
was_machineloadingheader.dblQty,was_machineloadingheader.dblWeight,was_machineloadingheader.strColor,
was_machineloadingheader.dtmInDate,was_machineloadingheader.dtmOutDate,was_washtype.strWasType,was_machineloadingheader.intMachineType,was_machineloadingheader.intMachineId,was_machineloadingheader.intOperatorId,was_machineloadingheader.intShiftId,was_machineloadingheader.intWashType,orders.strDescription,was_machineloadingheader.intCostId,was_machineloadingheader.intRewashNo,was_machineloadingheader.tmInTime,was_machineloadingheader.tmOutTime,was_machineloadingheader.intStatus,was_machineloadingheader.tmInTime,was_machineloadingheader.tmOutTime
FROM orders INNER JOIN was_machineloadingheader ON was_machineloadingheader.intStyleId=orders.intStyleId
            INNER JOIN was_machine ON was_machineloadingheader.intMachineId=was_machine.intMachineId
			INNER JOIN was_operators ON was_machineloadingheader.intOperatorId= was_operators.intOperatorId
			INNER JOIN was_shift ON was_machineloadingheader.intShiftId = was_shift.intShiftId
			INNER JOIN was_machinetype ON was_machineloadingheader.intMachineType=was_machinetype.intMachineId
			INNER JOIN was_washtype ON was_machineloadingheader.intWashType=was_washtype.intWasID
			WHERE was_machineloadingheader.intStatus='$cboMode'";
			
			if($costID !=""){
			$SQL .= "AND was_machineloadingheader.intCostId='$costID'";
			}
			if($machineType !=""){
			$SQL .= "AND was_machineloadingheader.intMachineType='$machineType'";
			}
			if($machine != ""){
			$SQL .= "AND was_machineloadingheader.intMachineId";
			}
			if($fromDate != ""){
			$SQL .= "AND was_machineloadingheader.dtmInDate>='$formatedfromDate'";
			}
			if($toDate != ""){
			$SQL .= "AND was_machineloadingheader.dtmInDate<='$formatedtoDate'";
			}	
			$result = $db->RunQuery($SQL);
	$cls="";
	$c=0;
	    while($row = @mysql_fetch_array($result))
		{		($c%2==0)?$cls="grid_raw":$cls="grid_raw2";
				$string= $row["intStyleId"]+"###"+$row["intRootCardNo"]+"###"+$row["intStatus"];
				$RootCrdNo = $row["intRootCardNo"];
				$RootCrdYear = $row["intRootCardYear"];
				
			?>
			 <tr>
			  <td  height="" bgcolor="" class="<?php echo $cls;?>"><?php if($cboMode!="0"){?>
              <img class="mouseover"  border="0" src="../../images/view.png" alt="view" id="<?php echo $row["intStyleId"];?>" onclick="loadMachineLoadingForm(this.id,<?php echo $RootCrdNo;?>,<?php echo $RootCrdYear;?>,<?php echo $row["intStatus"];?>);"/> <?php } ?>
              </td>
              <td class="<?php echo $cls;?>" style="text-align:left;"> <?php echo $row["strStyle"];?></td>
              <td  class="<?php echo $cls;?>" style="text-align:right;"><?php echo $row["intCostId"];?></td>
			  <td  class="<?php echo $cls;?>" style="text-align:left;"> <?php echo $row["strMachineType"];?></td>
			  <td  class="<?php echo $cls;?>" style="text-align:left;"><?php echo $row["strMachineName"];?></td>
			  <td  class="<?php echo $cls;?>" style="text-align:right;" > <?php echo  $row["intLotNo"];?> </td>
			  <td  class="<?php echo $cls;?>" style="text-align:right;"> <?php  echo $row["intRewashNo"];?></td>
			  <td  class="<?php echo $cls;?>" style="text-align:right;"> <?php echo $row["tmInTime"];?></td>
  			  <td class="<?php echo $cls;?>" style="text-align:right;"> <?php echo $row["tmOutTime"];?></td>
			  <td class="<?php echo $cls;?>" style="text-align:right;"> <?php echo $row["dblQty"];?> </td>
   			  <td class="<?php echo $cls;?>" style="text-align:right;"><?php echo  $row["dblWeight"];?></td>
   			  <!--<td class="<?php //echo $cls;?>" style="text-align:right;"> <?php //echo $row["intOperatorId"];?></td>-->
			  <td class="<?php echo $cls;?>" style="text-align:right;"><?php echo $row["strShiftName"];?></td>
			  <td class="<?php echo $cls;?>" style="text-align:right;"><?php echo $row["intRootCardNo"];?>  </td>
   			  <td class="<?php echo $cls;?>" style="text-align:left;"><?php echo $row["strName"];?></td>
			  <?php  $dateIn         = $row["dtmInDate"];
					 $dateInArray	 = explode('-',$dateIn);
					 $formateddateIn = $dateInArray[2]."/".$dateInArray[1]."/".$dateInArray[0]; ?>
   			  <td class="<?php echo $cls;?>" style="text-align:right;"><?php echo $formateddateIn;?></td>
			  <?php 
			  		 $dateOut        = $row["dtmOutDate"];
					 $dateOutArray	 = explode('-',$dateOut);
					 $formateddateOut= $dateOutArray[2]."/".$dateOutArray[1]."/".$dateOutArray[0];	
			  ?>
   			  <td class="<?php echo $cls;?>" style="text-align:right;"><?php echo $formateddateOut;?></td>
   			  <!--<td class="<?php //echo $cls;?>" style="text-align:right;"><?php //echo  $row["intStatus"];?></td>-->
   			  <td class="<?php echo $cls;?>" style="text-align:left;"><?php echo  $row["strColor"];?></td>
   			  <td class="<?php echo $cls;?>" style="text-align:left;"><?php echo  $row["strWasType"];?> </td>
			 </tr>
			<?php } ?>
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor=""><table width="100%" border="0">
      <tr>
        <td width="88%">&nbsp;</td>
        <td width="11%"><div align="center"><img src="../../images/close.png" alt="close" width="97" height="24" onclick="closeWindow();"/></div></td>
        <td width="1%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<!--  </div>
  </div>-->
</form>
</body>
</html>
