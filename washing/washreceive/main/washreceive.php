<?php
	session_start();
	include('../../../Connector.php');	
	$backwardseperator = "../../../";
	include "../../../authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<title>GaPro :: Wash Receive</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../../javascript/calendar/theme.css" />

<script src="washreceive.js"></script>
<script src="../../javascript/tablednd.js" type="text/javascript"></script>
<script src="../../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../../javascript/script.js"></script>
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
<style>
    .moving {
        border:2px solid green;
    }

    .selected {
        background-color:#FFC !important;
    }
	
</style>
</head>

<body>
  <tr>
    <td width="100%"><?php include('../../../Header.php'); ?></td>
  </tr>
  <form id="frmWashRecieve" name="frmWashRecieve">
<table width="800" border="0" align="center" class="bcgl1">

  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="normalfnt">
	<tr>
      <td colspan="2" height="27"  class="mainHeading">Budgeted Cost</td>
    </tr>
	<tr>
      <td colspan="2" height="8" ></td>
    </tr>
	
      <tr>
        <td><table width="100%" border="0"  cellpadding="1" cellspacing="0">
            <tr>
              <td>
			  <fieldset class="fieldsetStyle" style="width:800px;">
                <!--<legend class="innertxt">&nbsp; </legend>-->
			    <table width="100%" border="0" align="center" cellpadding="1" cellspacing="0" class="normalfnt">
			      <tr>
			        <td width="7">&nbsp;</td>
			        <td width="120" style="width:120px;">Fabric Name<span class="compulsoryRed">*</span></td>
			        <td width="170"><?php $sql_Fabric="SELECT m.intItemSerial,m.strItemDescription FROM  matitemlist m INNER JOIN orderdetails AS OD ON OD.intMainFabricStatus=1 AND OD.intMatDetailID= m.intItemSerial;"; ?>
			          <select name="cboFabricName" id="cboFabricName" class="txtbox" style="width:150px;"  onchange="selectFabricDet(this.id);">
			            <option value="" selected="selected">Select Item</option>
			            <?php
                      $resF=$db->RunQuery($sql_Fabric);
					  while($rowF=mysql_fetch_array($resF)){?>
			            <option value="<?php echo $rowF['intItemSerial'];?>"><?php echo $rowF['strItemDescription'];?></option>
			            <?php }?>
			            </select></td>
			        <td width="61">&nbsp;</td>
			        <td width="120" style="width:120px;">Sample No </td>
			        <td width="204"><input type="text" readonly="readonly" name="txtSampleNo" id="txtSampleNo" class="txtbox" style="width:150px;" /></td>
			        <td width="104"><img src="../../../images/aad.png" onclick="loadPrevious();" style="cursor:pointer;"/></td>
			        </tr>
			      <tr>
			        <td height="25">&nbsp;</td>
			        <td>Customer Name<span class="compulsoryRed">*</span></td>
			        <td><select name="cboCustomerName" id="cboCustomerName" class="txtbox" style="width:150px;" onchange="selectStyleName(this.id);" >
			          <option value="" selected="selected">Select Item</option>
			          <?php 
						$sql_buyer="SELECT intBuyerID,strName FROM buyers WHERE intStatus = 1;";
						$res=$db->RunQuery($sql_buyer);
						while($row=mysql_fetch_array($res)){
					?>
			          <option value="<?php echo $row['intBuyerID'];?>"><?php echo $row['strName'];?></option>
			          <?php }?>
			          </select></td>
			        <td>&nbsp;</td>
			        <td> Date<span class="compulsoryRed">*</span></td>
			        <td><input class="txtbox" type="text" id="txtReceiveDate" name="txtReceiveDate" style="width:100px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y-%m-%d');"/></td>
			        <td></td>
			        </tr>
			      <tr>
			        <td height="25">&nbsp;</td>
			        <td>Style Name<span class="compulsoryRed">*</span></td>
			        <td><select name="cboStyleName" id="cboStyleName" class="txtbox" style="width:150px;" >
			          <option value="" selected="selected">Select Item</option>
			          <?php 
					   $sql_Styles="SELECT O.intStyleId,O.strStyle FROM orders O ;";
					   $resSty=$db->RunQuery($sql_Styles);
					   	while($rowSty=mysql_fetch_array($resSty))
						{
							echo "<option value=".$rowSty['intStyleId'].">".$rowSty['strStyle']."</option>";
						}
					   ?>
			          </select></td>
			        <td>&nbsp;</td>
			        <td>Mill</td>
			        <td><input type="text" style="width:150px;" name="txtMill" id="txtMill"/></td>
			        <td>&nbsp;</td>
			        </tr>
			      <tr>
			        <td height="25">&nbsp;</td>
			        <td>Division<span class="compulsoryRed">*</span></td>
			        <td><select name="cboDivision" id="cboDivision" class="txtbox" style="width:150px;" onchange="selectColor(this.id);" >
			          <option value="" selected="selected">Select Item</option>
			          <?php 
						$sql_SelectDiv="SELECT intDivisionId,strDivision FROM buyerdivisions";
						$res=$db->RunQuery($sql_SelectDiv);
						while($row=mysql_fetch_array($res))
						{
							echo "<option value=".$row['intDivisionId'].">".$row['strDivision']."</option>";
						}?>
			          </select></td>
			        <td>&nbsp;</td>
			        <td> Fabric Dsc </td>
			        <td colspan="2"><textarea style="width:200px; height:25px;" name="txtFabricDsc" class="txtbox" id="txtFabricDsc"></textarea></td>
			        </tr>
			      <tr>
			        <td height="25">&nbsp;</td>
			        <td>Color<span class="compulsoryRed">*</span></td>
			        <td><select name="cboColor" id="cboColor" class="txtbox" style="width:150px;" >
			          <option value="" selected="selected">Select Item</option>
			          <?php
                        $sql_colors="SELECT strColor,strDescription FROM colors;";
					  	$resColors=$db->RunQuery($sql_colors);
						while($rowWT=mysql_fetch_array($resColors)){?>
			          <option value="<?php echo $rowWT['strColor'];?>"><?php echo $rowWT['strDescription'];?></option>
			          <?php }?>
			          </select></td>
			        <td>&nbsp;</td>
			        <td>Fabric Content</td>
			        <td colspan="2"><textarea style="width:200px; height:25px;" class="txtbox" name="txtFabricContent" id="txtFabricContent"></textarea></td>
			        </tr>
			      <tr>
			        <td height="25">&nbsp;</td>
			        <td height="25">Wash Type<span class="compulsoryRed">*</span></td>
			        <td><select name="cboWashType" id="cboWashType" class="txtbox" style="width:150px;" >
			          <option value="" selected="selected">Select Item</option>
			          <?php 
					  	$sql_washType="SELECT intWasID,strWasType FROM was_washtype;";
					  	$resWashType=$db->RunQuery($sql_washType);
						while($rowWT=mysql_fetch_array($resWashType)){?>
			          <option value="<?php echo $rowWT['intWasID'];?>"><?php echo $rowWT['strWasType'];?></option>
			          <?php }?>
			          </select></td>
			        <td><img src="../../../images/aad.png" onclick="loadWashTypePopUp();" style="cursor:pointer;"/></td>
			        <td>Handling Time<span class="compulsoryRed">*</span></td>
			        <td><input type="text" style="width:150px;" id="txtTimeHandling" name="txtTimeHandling"  onkeypress="return CheckforValidDecimal(this.value,2,event); "/></td>
			        <td>&nbsp;</td>
			        </tr>
			      <tr>
			        <td height="25">&nbsp;</td>
			        <td height="25">Garment<span class="compulsoryRed">*</span></td>
			        <td><select name="cboGarment" id="cboGarment" class="txtbox" style="width:150px;" >
			          <option value="" selected="selected">Select Item</option>
			          <?php  
					$sql_garment="SELECT intGamtID,strGarmentName FROM was_garmenttype;";
					$resGarment=$db->RunQuery($sql_garment);
					while($rowG=mysql_fetch_array($resGarment)){?>
			          <option value="<?php echo $rowG['intGamtID']; ?>"><?php echo $rowG['strGarmentName']; ?></option>
			          <?php }?>
			          </select></td>
			        <td>&nbsp;</td>
			        <td>No of Pcs<span class="compulsoryRed">*</span></td>
			        <td><input type="text"  style="width:150px;" name="txtNoOfPcs" id="txtNoOfPcs" onkeypress="return isNumeric(this.value); "/></td>
			        <td>&nbsp;</td>
			        </tr>
			      <tr>
			        <td height="25">&nbsp;</td>
			        <td height="25">Machine Type<span class="compulsoryRed">*</span></td>
			        <td><select name="cboMachine" id="cboMachine" class="txtbox" style="width:150px;" >
			          <option value="" selected="selected">Select Item</option>
			          <?php  $sql_Machines="SELECT intMachineId,strMachineName FROM was_machine;";
								$resMachines=$db->RunQuery($sql_Machines);
								while($rowM=mysql_fetch_array($resMachines)){?>
			          <option value="<?php echo $rowM['intMachineId']; ?>"><?php echo $rowM['strMachineName']; ?></option>
			          <?php }?>
			          </select></td>
			        <td>&nbsp;</td>
			        <td>Weight<span class="compulsoryRed">*</span></td>
			        <td><input type="text"  style="width:150px;" name="txtWeight" id="txtWeight" onkeypress="return CheckforValidDecimal(this.value, 3,event);"/></td>
			        <td>&nbsp;</td>
			        </tr>
			      <tr>
			        <td height="25">&nbsp;</td>
			        <td colspan="3" height="25"><table>
			          <tr>
			            <td><input type="radio" value="1" name="radioType" id="radioType"/></td>
			            <td> In House </td>
			            <td><input type="radio" value="2" name="radioType" id="radioType"/></td>
			            <td> Out Side </td>
			            </tr>
			          </table></td>
			        <td>&nbsp;</td>
			        <td>&nbsp;</td>
                    <td align="right"><img src="../../../images/additem2.png" onclick="loadProcessPopUp();" style="cursor:pointer;"/></td>
			        </tr>
			      </table>
			  </fieldset></td>
             <!-- <td width="284">
			  <fieldset class="fieldsetStyle"  style="width:273px;">
                <legend class="innertxt">Locations</legend>
                <table width="267" border="0" cellpadding="0" cellspacing="0" class="normalfnt">
                  <tr>
                    <td width="11" >&nbsp;</td>
                    <td width="90">Main Stores</td>
                    <td width="166"><select name="mainStores" id="mainStores" class="txtbox" style="width:150px;" >
                        <option value="0" selected="selected">Select Item</option>
                    </select></td>
                  </tr>
                  <tr>
                    <td height="25">&nbsp;</td>
                    <td>Sub Stores</td>
                    <td><select name="subStores" id="subStores" class="txtbox" style="width:150px;" >
                        <option value="0" selected="selected">Select Item</option>
                    </select></td>
                  </tr>
                  <tr>
                    <td height="25">&nbsp;</td>
                    <td>Bin</td>
                    <td><select name="bin" id="bin" class="txtbox" style="width:150px;" >
                        <option value="0" selected="selected">Select Item</option>
                    </select></td>
                  </tr>
                  <tr>
                    <td height="25">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="25">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="25">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
			  </fieldset></td>-->
            </tr>
        </table></td>
      </tr>
      <tr>
        <td></td>
      </tr>
      <tr>
        <td height="5"></td>
      </tr>
      <tr>
        <td>		
          <div id="txtemp"  style="overflow:scroll; height:320px;">
          <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#F3E8FF" id="tblMain">
            <thead>
            <tr bgcolor="#498CC2" class="normaltxtmidb2">
                <td width="3%" height="30">&nbsp;</td>
                <td width="6%" >&nbsp;</td>
                <td width="22%" >Process Description</td>
                <td width="18%" >Temperature(C)</td>
                <td width="10%" >Liquor(L)</td>
                <td width="12%" >Time(mins)</td>
                <td width="12%" >Chemical</td>
                <td width="8%" >Serial</td>
            </tr>
            
            </thead>
            <tbody id="tblDet">

            </tbody>
           </table>
          </div></td>
      </tr>
      <script type="text/javascript" src="../../javascript/tabledndDemo.js"></script>
      <tr>
        <td><table border="0" cellpadding="0" cellspacing="0" align="center">
          <tr height="8">
		<td></td>
		</tr>
        <tr>
        	<td>
            	<table class="" align="center">
                	<tr>
                    	<td><img src="../../../images/new.png"  onclick="clearForm();"  /></td>
                        <td><img src="../../../images/save.png" height="26" id="saveIMG" onclick="saveData();" /></td>
                        <td><img src="../../../images/conform.png" onclick="confrimWashRecieve();" id="confirmIMG" /></td>
                        <td><img src="../../../images/copyPO.png" onclick="loadCopyBudget();"/></td>
                        <td><img src="../../../images/report.png"  onclick="loadReport();" /></td>
                        <td><img src="../../../images/porevise.png" id="reviseIMG" onclick="loadRevision();" style="visibility:visible;"/></td>
                        <td>
                        <img src="../../../images/close.png" id="closeIMG" /></td>
                    </tr>
                </table>
            </td>
      	</tr>
        </table></td>
      </tr>
      <tr>
        <td><!--<fieldset class="fieldsetStyle" style="width:930px;">
          <legend class="innertxt">Name Of from</legend>
          <table width="920" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="7" >&nbsp;</td>
              <td width="92" >Receive No</td>
              <td width="128"><input name="receiveNo" type="text" class="txtbox" id="receiveNo" size="15" /></td>
              <td width="67">Cut Qty </td>
              <td width="171"><input name="cutQty" type="text" class="txtbox" id="cutQty" size="15" /></td>
              <td width="69">PO Qty </td>
              <td width="145"><input name="poQty" type="text" class="txtbox" id="poQty" size="15" /></td>
              <td width="124">Total Received Qty </td>
              <td width="137"><input name="totalReceivedQty" type="text" class="txtbox" id="totalReceivedQty" size="15" /></td>
            </tr>
          </table>
        </fieldset>--></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="18" background="../images/bcgdbar.png" class="specialFnt1">&nbsp;</td>
  </tr>
</table>

<div style="left:350px; top:680px; z-index:10; position:absolute; width: 300px; visibility:hidden; height: 20px;" id="reportsPopUp">
  <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
  <tr>
    <td width="43"><div align="center">Wash Formula</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioReports" id="radioReports" value="CostSheet" onclick="washReport();"/></div></td>
	<td width="57"><div align="center">Cost Sheet</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioReports" id="radioReports" value="WashFormula" onclick="washReport();"/></div></td>
  </tr>
  </table>	  
  </div>
  
  <div style="left:200px; top:680px; z-index:10; position:absolute; width: 250px; visibility:hidden; height: 20px;" id="copyBudget">
  <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
  <tr>
    <td width="43"><div align="center">Copy Process</div></td>
	<td width="20">
    <div align="center">
    <select name="cboCopyBudget" id="cboCopyBudget" onchange="copyDetails(this.id);">
    	<option value="">select item</option>
    <?php 
	$sql_loadSNo="SELECT intSerialNo FROM was_budgetcostheader;";
	$resSNo=$db->RunQuery($sql_loadSNo);
	while($rowS=mysql_fetch_array($resSNo))
	{
	?>
    
        <option value="<?php echo $rowS['intSerialNo'];?>"><?php echo $rowS['intSerialNo'];?></option>
    <?php 	}?>
    </select>
    </div></td>
</td>
  </tr>
  </table>	  
  </div>
  
  <div style="left:600px; top:680px; z-index:10; position:absolute; width: 250px; visibility:hidden; height: 20px;" id="revReason">
  <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
  <tr>
    <td width="43"><div align="center">Reason</div></td>
	<td width="20">
    <div align="center">
  		<input type="text" id="txtReason" name="txtReason" maxlength="100" />
    </div></td>
    <td width="20">
    <div align="center">
  		<img src="../../../images/porevise.png" onclick="reviseData();"/>
    </div></td>
</td>
  </tr>
  </table>	  
  </div>
  </form>
</body>
</html>
