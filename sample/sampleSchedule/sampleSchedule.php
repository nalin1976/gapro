<?php

session_start();
include "../../Connector.php";	
$backwardseperator = "../../";
$companyId 			= $_SESSION["FactoryID"];
$datefrom			= $_POST["txtDatefrom"];
$dateTo				= $_POST["txtDateTo"];
$buyerid			= $_POST["cboBuyer"];
$styleid			= $_POST["cboStyleId"];
//$mkDate				= date("m")-1,'/',date("d"),'/',date("Y");
$fMonth				= date("m")-1;
$fDate				= date("d");
$fYear				= date("Y");
$mkDate				= $fMonth.'/'.$fDate.'/'.$fYear;

$txtCheck			= $_POST['txtCheck'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaProgsl | Sample Schedule</title>
<script type="text/javascript" src="gennormalgatepassjs.js"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="sampleScheduleJS.js" type="text/javascript"></script>

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

</head>
<body>
<form name="frmNGList" id="frmNGList" action="sampleSchedule.php" method="post">
  <tr>
    <td><?php include "${backwardseperator}Header.php"; ?></td>
  </tr>
<table width="1000" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">
  <tr>
    <td class="mainHeading">Sample Schedule</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="100%"><table width="99%" border="0" cellpadding="2" cellspacing="0" class="tableBorder">
          <tr>
            <td width="11%" height="24" nowrap="nowrap" class="normalfnt">Style No </td>
            <td width="9%" class="normalfnt">
            <?php	
                $sqlStyles = "SELECT
							  SS.intStyleId,
							  OD.strStyle
							  FROM
							  sampleschedule SS
							  Inner Join orders AS OD ON OD.intStyleId = SS.intStyleId ORDER BY OD.strStyle";
							  
							  $resultStyles = $db->RunQuery($sqlStyles);

			?>
                <select id="cboStyleId" name="cboStyleId" style="width:150px" onchange="submitForm();">
                	<option></option>
            <?php
                 while($rowStyles=mysql_fetch_array($resultStyles))
				{
					
					if($styleid==$rowStyles['intStyleId'])
					{
					 
			?>  
            		<option selected value="<?php echo $rowStyles['intStyleId']; ?>"><?php echo $rowStyles['strStyle']; ?></option>
                    
            <?php
					}
					else
					{
			?>
            		<option value="<?php echo $rowStyles['intStyleId']; ?>"><?php echo $rowStyles['strStyle']; ?></option>
            
            <?php
			
					}
				}
		    ?>
                </select>
                
            </td>
            <td width="5%"></td>
            <td width="10%" class="normalfnt" nowrap="nowrap">Customer</td>
            
			<td width="27%" class="normalfnt"><select id="cboBuyer" name="cboBuyer" style="width:150px" onchange="submitForm();">
			    <option> </option>
			    <?php
			  		$sqlBuyer = "SELECT
								 DISTINCT buyers.intBuyerID,
								 buyers.strName
								 FROM
								 orders
								 Inner Join buyers ON orders.intBuyerID = buyers.intBuyerID
								 WHERE
								 orders.intStatus=2  ORDER BY buyers.strName";
								 
					$resultBuyer = $db->RunQuery($sqlBuyer);
					
					while($rowBuyer=mysql_fetch_array($resultBuyer))
					{			 
						
						if($buyerid==$rowBuyer['intBuyerID'])
						{
			  ?>
			    <option selected="selected" value="<?php echo $rowBuyer['intBuyerID']; ?>"><?php echo $rowBuyer['strName']; ?></option>
			    <?php
						}
						else
						{
			  ?>
			    <option value="<?php echo $rowBuyer['intBuyerID']; ?>"><?php echo $rowBuyer['strName']; ?></option>
			    <?php
						}
					}
					
			  ?>
			    </select></td>
			           
			<td width="10%" class="normalfnt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td width="7%" nowrap="nowrap" class="normalfnt">
			<input type="checkbox" id="chkdate" onclick="checkOK();" name="chkdate" <?php if($txtCheck=="checked"){?> checked="checked"<?php } ?>>
			&nbsp;Date From</td>
            <td width="10%" class="normalfnt" nowrap="nowrap"><input name="txtDatefrom" type="text" class="txtbox" id="txtDatefrom" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo $datefrom=="" ? date("Y-m-d"):$datefrom; ?>" <?php if($txtCheck==''){ echo "disabled='disabled'";} ?> /><input type="reset" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');">	              </td>
            <td width="1%" nowrap="nowrap" class="normalfnt">Date to</td>
            <td width="10%" class="normalfnt" nowrap="nowrap"><input name="txtDateTo" type="text" class="txtbox" id="txtDateTo" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" <?php if($txtCheck==''){ echo "disabled='disabled'";} ?> onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo $dateTo=="" ? date("Y-m-d"):$dateTo;?>"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');">			</td>
            <td width="9%" class="normalfnt"><img src="../../images/search.png" alt="search" width="80" height="24" onclick="ReloadPage();" /></td>
            
          </tr>
          <tr>
            <td height="24" class="normalfnt">&nbsp;</td>
            <td colspan="4" class="normalfnt">&nbsp;</td>
            <td class="normalfnt">&nbsp;</td>
            <td class="normalfnt">&nbsp;</td>
            <td class="normalfnt">&nbsp;</td>
            <td class="normalfnt"><input type="text" value="<?php echo $txtCheck; ?>"id="txtCheck" style="visibility:hidden; width:10px" name="txtCheck" /></td>
            <td class="normalfnt">&nbsp;</td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="18" class="mainHeading2"><div align="center">Sample Schedule Details</div></td>
        </tr>
      <tr>
        <td class="normalfnt"><div id="divtblIssueDetails" style="overflow:scroll; height:400px; width:1000px;">
          <table id="tblIssueDetails" width="100%" cellpadding="0" cellspacing="1"  bgcolor="#CCCCFF">
            <tr class="mainHeading4">
              <td width="10%" height="25" >Date</td>
              <td width="15%" >Customer</td>
              <td width="12%" >Style</td>
              <td width="20%" >Description</td>
              <td width="10%" >Size</td>
              <td width="10%" >FIT/PHOTO</td>
              <td width="12%" >Fabric</td>
			  <td width="15%" >Fabric Due </td>
              <td width="15%" >Status</td>
              <td width="10%" height="25" >Due Date</td>
              </tr>
<?php
$fromArray 	= explode('/',$datefrom);
$toArray 	= explode('/',$dateTo);
	$sql ="SELECT
		   SS.intStyleId,
		   SS.strFabricDue,
		   LEFT(SS.dtmDueDate,10) AS DTMdue,
		   OD.dtmOrderDate,
		   OD.strStyle,
		   B.buyerCode,
		   OD.strDescription AS ODDescription,
		   OD.strSize,
		   ST.strDescription AS STDescription,
		   SST.strDescription AS SSTDescription
		   FROM
		   sampleschedule AS SS
		   Inner Join orders AS OD ON OD.intStyleId = SS.intStyleId
		   Inner Join buyers AS B ON B.intBuyerID = OD.intBuyerID
		   Inner Join sampletypes AS ST ON ST.intSampleId = OD.strSampleId
		   Inner Join samplestatus AS SST ON SS.intStatus = SST.intId
		   WHERE 
		   SST.intStatus=1 ";
	
	if($buyerid!="")
			$sql .="AND OD.intBuyerID=$buyerid "; 
			
	if($styleid!="")
			$sql .="AND OD.intStyleId=$styleid ";
	
	if($txtCheck=="checked")
	{
		if($datefrom!="")
				$sql .="AND OD.dtmOrderDate>='$datefrom' ";
		
		if($dateTo!="")
				$sql .="AND OD.dtmOrderDate<='$dateTo' ";
	}
	
	$sql .="Order by OD.dtmOrderDate";
	
$result=$db->RunQuery($sql);

while($row=mysql_fetch_array($result))
{
?>
<tr class="bcgcolor-tblrowWhite" onmouseover="this.style.background ='#D6E7F5';" onmouseout="this.style.background='';">
<td class="normalfntMid"><?php echo $row["dtmOrderDate"];?></td>
<td class="normalfntMid"><?php echo $row["buyerCode"];?></td>
<td class="normalfntMid"><?php echo $row["strStyle"]; ?></td>
<td class="normalfntMid"><?php echo $row["ODDescription"]; ?></td>
<td class="normalfntMid"><?php echo $row["strSize"]; ?></td>
<td class="normalfntMid"><?php echo $row["STDescription"]; ?></td>
<td class="normalfntMid"><?php echo $row["ODDescription"]; ?></td>
<td class="normalfntMid"><input id="<?php echo $row["intStyleId"]; ?>" type="text" value="<?php echo $row["strFabricDue"]; ?>" style="width:100px"/></td>
<td class="normalfntMid"><?php echo $row["SSTDescription"]; ?></td>
<td class="normalfntMid"><input name="txtDatefrom" type="text" class="txtbox" id="txtDatefrom1" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php if($row["DTMdue"]==""){ echo date("Y-m-d"); } else{ echo $row["DTMdue"]; }?>" /><input type="reset" value=""  class="txtbox" style="visibility:hidden; width:1px; height:1px" onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
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
    <td><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#FAD163">
      <tr>
        <td width="40%" ><div align="center">
        <img src="../../images/save.png" class="mouseover" title="New" style="vertical-align:middle;" alt="new" width="96" height="24" onclick="saveFabricDue();" />        
        <a href="../main.php"><img src="../../images/close.png" title="Go to home page" style="vertical-align:middle;" width="97" height="24" border="0" /></a></div></td>       
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
