<?php
	session_start();
	$backwardseperator = "../../";
	include('../../Connector.php');	
	include "../../authentication.inc";
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Budget Cost</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css/">
<link href="../../js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<link href="../../css/tableGrib.css" rel="stylesheet" type="text/css" />

<!--<script src="../../js/jquery-1.4.2.min.js" type="text/javascript"></script>-->
<script src="../../javascript/jquery.js"></script>
<script src="../javascript/tablednd.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="washreceive.js" type="text/javascript"></script>
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
        background-color:#FFC;
    }
	
</style>
</head>

<body>
<form id="frmWashRecieve" name="frmWashRecieve">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include($backwardseperator.'Header.php'); ?></td>
	</tr> 
</table>
<!--<div class="main_bottom_center">
	<div class="main_top"><div class="main_text">Budgeted Cost</div></div>
<div class="main_body">-->

<table width="850" border="0"  align="center" class="tableBorder" bgcolor="#FFFFFF">
  <tr>
  	<td class="mainHeading">Budgeted Cost</td>
  </tr>
  <tr>
    <td>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="normalfnt">
            <tr>
                <td>
                    <table width="100%" border="0"  cellpadding="1" cellspacing="0">
                        <tr>
                            <td>
                                <!--<fieldset class="fieldsetStyle" style="width:800px;-moz-border-radius: 5px;">-->
                                <table width="100%" border="0" align="center" cellpadding="1" cellspacing="0" class="normalfnt">
                                    <tr>
                                        <td width="6">&nbsp;</td>
                                        <td width="120" style="width:120px;">&nbsp;</td>
                                        <td width="209"></td>
                                        <td width="19">&nbsp;</td>
                                        <td width="120" style="width:120px;">Sample No </td>
                                      <td width="224"><input type="text" disabled="disabled"name="txtSampleNo" id="txtSampleNo" class="txtbox" style="width:100px;" /></td>
                                        <td width="106"><img src="../../images/search.png" onclick="loadPrevious();" style="cursor:pointer;"/></td>
                                    </tr>
                                    <tr>
                                        <td height="25">&nbsp;</td>
                                      <td height="25"><span style="width:120px;">Fabric Name<span class="compulsoryRed"> *</span></span></td>
                                        <td ><input type="text" name="cboFabricName" id="cboFabricName" class="txtbox" style="width:200px;" onkeyup="GetFabricSerial(this,event);" maxlength="25" /></td>
                                        <td>&nbsp;</td>
                                        <td height="25">Date</td>
                                        <td colspan="2"><input class="txtbox" type="text" id="txtReceiveDate" name="txtReceiveDate" style="width:100px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo date("Y-m-d")?>"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y-%m-%d');"/></td>
                                    </tr>
                                    <tr>
                                        <td height="25">&nbsp;</td>
                                        <td>Customer Name <span class="compulsoryRed">*</span></td>
                                        <td colspan="4"><select name="cboCustomerName" id="cboCustomerName" class="txtbox" style="width:565px;">
                                         <!-- <option value="" selected="selected">Select Item</option>-->
                                          <?php 
                                            $sql_buyer="select intCompanyID,strName from companies where intStatus=1 and intCompanyID='".$_SESSION['FactoryID']."' order by strName;";
                                            $res=$db->RunQuery($sql_buyer);
                                            while($row=mysql_fetch_array($res)){
                                        ?>
                                          <option value="<?php echo $row['intCompanyID'];?>"><?php echo $row['strName'];?></option>
                                          <?php }?>
                                          </select></td>
                                          <td></td>
                                    </tr>
                                    <tr>
                                        <td height="25">&nbsp;</td>
                                        <td>Style Name <span class="compulsoryRed">*</span></td>
                                        <td><input type="text" name="cboStyleName" id="cboStyleName" class="txtbox" style="width:200px;" maxlength="25"/></td>
                                        <td>&nbsp;</td>
                                        <td>Mill</td>
                                        <td><select style="width:201px;" name="txtMill" id="txtMill"/>
<?php 
$sql= "select strSupplierID,strTitle from suppliers where intStatus =1 order by strTitle";
$result=$db->RunQuery($sql);
	echo "<option value="."".">"."Select One"."</option>\n"; 
while($row=mysql_fetch_array($result))
{
	echo "<option value=".$row["strSupplierID"].">".$row["strTitle"]."</option>\n"; 
}
?>
										</select></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td height="25">&nbsp;</td>
                                        <td>Division</td>
                                        <td><input name="cboDivision" id="cboDivision" class="txtbox" style="width:200px;" maxlength="25"></td>
                                        <td>&nbsp;</td>
                                        <td> Fabric Description </td>
                                        <td colspan="2"><textarea style="width:200px; height:25px;" name="txtFabricDsc" class="txtbox" id="txtFabricDsc" onkeypress=" return imposeMaxLength(this,event, 30);"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td height="25">&nbsp;</td>
                                        <td>Color <span class="compulsoryRed">*</span></td>
                                        <td>
                                        <input type='text' class="txtbox" id="cboColor" name="cboColor" style="width:200px;" onkeyup="GetColors(this,event);" maxlength="25"/>
                                        <!--<select name="cboColor" id="cboColor" class="txtbox" style="width:200px;" >
                                          <option value="" selected="selected">Select Item</option>
<?php
$sql_colors="SELECT DISTINCT strColor FROM colors order by strColor;";//WHERE intStatus='1'
$resColors=$db->RunQuery($sql_colors);
while($rowWT=mysql_fetch_array($resColors)){?>
	<option value="<?php echo $rowWT['strColor'];?>"><?php echo $rowWT['strColor'];?></option>
<?php }?>
                                          </select>--></td>
                                        <td>&nbsp;</td>
                                        <td>Fabric Content</td>
                                        <td colspan="2"><textarea style="width:200px; height:25px;" class="txtbox" name="txtFabricContent" id="txtFabricContent" onkeypress="return imposeMaxLength(this,event, 30);"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td height="25">&nbsp;</td>
                                        <td height="25">Wash Type <span class="compulsoryRed">*</span></td>
                                        <td colspan="4">
                                        <textarea class="txtbox" name="cboWashType" id="cboWashType"  style="width:564px;height:30px;" onkeypress="return imposeMaxLength(this,event, 150);" ></textarea>
									</td>
                                        
                                        <td>&nbsp;</td>
                                    </tr>
                              <tr>
                                        <td height="25">&nbsp;</td>
                                        <td height="25">Garment<span class="compulsoryRed"> *</span></td>
                                        <td><select name="cboGarment" id="cboGarment" class="txtbox" style="width:200px;" >
                                          <option value="" selected="selected">Select Item</option>
                                          <?php  
                                        $sql_garment="SELECT DISTINCT productcategory.intCatId,productcategory.strCatName FROM productcategory WHERE productcategory.intStatus =  '1' ORDER BY strCatName;";
                                        $resGarment=$db->RunQuery($sql_garment);
                                        while($rowG=mysql_fetch_array($resGarment)){?>
                                          <option value="<?php echo $rowG['intCatId']; ?>"><?php echo $rowG['strCatName']; ?></option>
                                          <?php }?>
                                        </select></td>
                                        <td>&nbsp;</td>
                                        <td>Handling Time<span class="compulsoryRed"> *</span></td>
                                        <td><input type="text" style="width:100px;text-align: right;" id="txtTimeHandling" name="txtTimeHandling"  onkeypress="return CheckforValidDecimal(this.value,1,event); " maxlength="8" onkeyup="checkfirstDecimal(this);" onchange="checkLastDecimal(this);"/> 
                                        Min </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td height="25">&nbsp;</td>
                                        <td height="25">Machine Type <span class="compulsoryRed">*</span></td>
                                        <td><select name="cboMachine" id="cboMachine" class="txtbox" style="width:200px;" >
                                          <?php  
$sql_Machines="SELECT DISTINCT intMachineId,strMachineType FROM was_machinetype where intStatus=1 order by strMachineType;";
$resMachines=$db->RunQuery($sql_Machines);
	echo "<option value="."".">Select One</option>";
while($rowM=mysql_fetch_array($resMachines))
{
	echo "<option value=".$rowM['intMachineId'].">".$rowM['strMachineType']."</option>";
}
?>
                                        </select></td>
                                        <td>&nbsp;</td>
                                        <td>No of Pcs <span class="compulsoryRed">*</span></td>
                                        <td><input type="text"  style="width:100px;text-align: right;" name="txtNoOfPcs" id="txtNoOfPcs" onkeypress="return isValidZipCode(this.value,event); " maxlength="8" /></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td height="25">&nbsp;</td>
                                        <td height="25">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>Weight<span class="compulsoryRed"> *</span></td>
                                        <td><input type="text"  style="width:100px;text-align: right;" name="txtWeight" id="txtWeight" onkeypress="return CheckforValidDecimal(this.value, 2,event);" maxlength="8" onkeyup="checkfirstDecimal(this);" onchange="checkLastDecimal(this);"/> 
                                        Kg </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    
                                    <tr>
                                        <td height="25">&nbsp;</td>
                                        <td colspan="3" height="25">
                                        <!--<fieldset class="fieldsetStyle" style="width:200px;-moz-border-radius: 5px;">-->
                                        <table>
                                          <tr>
                                            <td><input type="radio" value="1" name="radioType" id="radioType" checked="checked" onchange="LoadCategoryDetails(0)" /></td>
                                            <td> In House </td>
                                            <td><input type="radio" value="2" name="radioType" id="radioType" onchange="LoadCategoryDetails(1)"/></td>
                                            <td> Out Side </td>
                                          </tr>
                                         </table>
                                        <!--</fieldset>-->
                                        </td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td align="right"><img src="../../images/additem2.png" onclick="loadProcessPopUp();" style="cursor:pointer;"/></td>
                                    </tr>
                                </table>
                                <!--</fieldset>-->
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td height="17" class="containers"><div align="center"><b>Details</b></div></td>
            </tr>
            <tr>
                <td>	
                <!--<fieldset class="fieldsetStyle" style="width:800px;-moz-border-radius: 5px;">-->
                <div id="txtemp"  style="height:320px;">
              <table width="820" border="0" cellpadding="0" cellspacing="1" bgcolor="#F3E8FF" id="tblMain">
                <thead>
                <tr bgcolor="#498CC2" class="normaltxtmidb2">
                    <td width="23" height="30" class="grid_header">Del</td>
                    <td width="38" class="grid_header" >No</td>
                    <td width="280" class="grid_header" >Process Description</td>
                    <td width="88" class="grid_header" >Liquor(L)</td>
                    <td width="91" class="grid_header" >Temp(C)</td>
                    <td width="91" class="grid_header" >Time(mins)</td>
                    <td width="126" class="grid_header" >Chemical</td>
                    <td width="54" class="grid_header" >Serial</td>
                </tr>                
                </thead>
                <tbody id="tblDet">
                
                </tbody>
               </table>
              </div>
               <!-- </fieldset>-->
                </td>
            </tr>
            <script type="text/javascript" src="../javascript/tabledndDemo.js"></script>
            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" align="center">
                  <tr height="8">
                    <td></td>
                  </tr>
                  <tr>
                    <td>
                        <table width="800"align="center" class="tableBorder">
                            <tr>
                            <?php
							if($PP_AllowConfirmBudgetCostsheet==true)
								$disStatus = "inline";
							else
								$disStatus = "none"; 
							?>
                                <td align="center"><img src="../../images/new.png"  onclick="clearForm();" style="display:inline"/>
                                <img src="../../images/save.png" id="saveIMG" onclick="saveData();" style="display:inline"/>
                                <img src="../../images/conform.png" onclick="confrimWashRecieve();" id="confirmIMG" style="display:<?php echo $disStatus; ?>"/>
                                <img src="../../images/copyPO.png" onclick="loadCopyBudget();" style="display:inline"/>
                                <img src="../../images/report.png"  onclick="loadReport();" style="display:inline"/>
                                <img src="../../images/porevise.png" id="reviseIMG" onclick="loadRevision();" style="display:none"/>
                                <a href="../../main.php"><img src="../../images/close.png" border="0" class="mouseover" id="closeIMG" style="display:inline"/></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                  </tr>
                </table>
                </td>
            </tr>
        </table>
    </td>
  </tr>
<!--  <tr>-->
<!--    <td height="18" background="../images/bcgdbar.png" class="specialFnt1">&nbsp;</td>-->
<!--  </tr>-->
</table>
  <div style="left:360px; top:640px; z-index:10; position:absolute; width: 300px; visibility:hidden; height: 20px;" id="reportsPopUp">
      <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
            <td width="43"><div align="center">Wash Formula</div></td>
            <td width="20"><div align="center"><input type="radio" name="radioReports" id="radioReports" value="WashFormula" onclick="washReport();"/></div></td>
            <td width="57"><div align="center">Cost Sheet</div></td>
            <td width="20"><div align="center"><input type="radio" name="radioReports" id="radioReports" value="CostSheet" onclick="washReport();"/></div></td>
          </tr>
      </table>	  
  </div>
  
  <div style="left:519px;top:666px;z-index:10;position:absolute;width:250px;visibility:hidden;height:30px;background-color:#999999" id="copyBudget">
      <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" >
          <tr>
            <td width="12" class="normalfnt">&nbsp;</td>
            <td width="104" class="normalfnt"><div>Copy Process</div></td>
            <td width="134">
			<select name="cboCopyBudget" id="cboCopyBudget" onchange="copyDetails(this.id);" style="width:120px">
			<option value="">select One</option>
                <?php 
                $sql_loadSNo="SELECT intSerialNo FROM was_budgetcostheader order by intSerialNo desc;";//where intStatus=1 
				//echo $sql_loadSNo;
                $resSNo=$db->RunQuery($sql_loadSNo);
                while($rowS=mysql_fetch_array($resSNo))
                {
                ?>                
                    <option value="<?php echo $rowS['intSerialNo'];?>"><?php echo $rowS['intSerialNo'];?></option>
                <?php 	
				}
				?>
              </select>            </td>
          </tr>
      </table>	  
  </div>
  
  <div style="left:600px; top:640px; z-index:10; position:absolute; width: 250px; visibility:hidden;height:30px;background-color:#999999" id="revReason">
      <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" >
      <tr>
        <td width="43"><div align="center">Reason</div></td>
        <td width="20"><div align="center"><input type="text" id="txtReason" name="txtReason" maxlength="100" /></div></td>
        <td width="20"><div align="center"><img src="../../images/go.png" onclick="reviseData();"/></div></td>
      </tr>
      </table>	  
  </div> 
<!--   </div>
 </div>-->
</form>

</body>
</html>
 <script type="text/javascript" src="../../js/jquery.fixedheader.js"></script>
<script type="text/javascript">
	var confirmBudgetedCost = "<?php echo $PP_AllowConfirmBudgetCostsheet?>";
</script>