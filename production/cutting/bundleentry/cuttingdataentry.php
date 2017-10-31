<?php
	session_start();
	include "../../../Connector.php";
	$userid=$_SESSION["UserID"];
	$backwardseperator = "../../../";	
	$str_usercompany="select intCompanyID from useraccounts where intUserID='$userid'";
	$results_usercompany=$db->RunQuery($str_usercompany);
	$row_usercompany=mysql_fetch_array($results_usercompany);
	$companyid=$row_usercompany["intCompanyID"];
	
	$str_setting_qty="SELECT 	strKey,strValue, strDescription	FROM settings where strKey='ProductionCutExcessPercentage'";
	$result_setting_qty=$db->RunQuery($str_setting_qty);
	$data_setting_qty=mysql_fetch_array($result_setting_qty);
	$setting_qty=$data_setting_qty['strValue'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bundle Entry for Cut Panel</title>

<link rel="stylesheet" type="text/css" href="../../../javascript/calendar/theme.css" />
<script src="../../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../../javascript/script.js" type="text/javascript"></script>
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

<link type="text/css" href="../../css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="../../js/jquery-ui-1.7.2.custom.min.js"></script>
        <script src="cuttingdataentry.js?n=1" type="text/javascript"></script>
		

<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0"  cellspacing="0" cellpadding="0">
  <tr>
    <td><?php include '../../../Header.php'; ?></td>
  </tr>
  <tr>
    <td align="center"><table width="850" class="tableBorder" border="0" cellspacing="3" cellpadding="0" align="center">
      <!--<tr>
    <td>
      <div align="left">
        
        </div></td></tr>-->
      <tr>
        <td class="mainHeading" >Production Bundle Entry</td>
      </tr>
      
      <tr>
        <td><table width="100%" border="0" cellspacing="2" cellpadding="0" class="normalfnt bcgl1" >
            
            <tr>
              <td  height="25" nowrap="nowrap">&nbsp; Factory <span style="color:#FF0000">*</span></td>
              <td><select name="cboFromFactory"  class="txtbox" style="width:180px" id="cboFromFactory"  tabindex="1" >
                <option value=""></option>
                <?php 
			$strtofactory="select intCompanyID,strComCode,strName from companies where intStatus=1 order by strName";
		
			$factresults=$db->RunQuery($strtofactory);
			
			while($factrow=mysql_fetch_array($factresults))
			{
		?>
                <option value="<?php echo $factrow['intCompanyID'];?>"><?php echo $factrow['strName'];?></option>
                <?php } ?>
              </select></td>
              <td>&nbsp;&nbsp;To Factory</dd>
                <span style="color:#FF0000">*</span></td>
              <td><select name="cboToFactory" class="txtbox" style="width:180px" id="cboToFactory"  tabindex="2">
                <option value=""></option>
                <?php 
			$strtofactory="select intCompanyID,strComCode,strName from companies where intStatus=1 and intManufacturing=1 order by strName";
		
			$factresults=$db->RunQuery($strtofactory);
			
			while($factrow=mysql_fetch_array($factresults))
			{
		?>
                <option value="<?php echo $factrow['intCompanyID'];?>"><?php echo $factrow['strName'];?></option>
                <?php } ?>
              </select></td>
              <td>&nbsp;&nbsp;Shift</td>
              <td><select name="txtShift" class="txtbox" style="width:102px" id="txtShift"  tabindex="3">
                <option value="Day">Day</option>
                <option value="Night">Night</option>
              </select></td>
            </tr>
            <tr>
              <td height="25">&nbsp;&nbsp;Type <span style="color:#FF0000">*</span></td>
              <td><select name="cbo_cut_type"  class="txtbox" style="width:180px" id="cbo_cut_type" onchange="get_filtered()" tabindex="4" >
                <option value=""></option>
                <?php 
			$str_cut_type=" SELECT glob_type,GPT.glob_type_id
							FROM glob_page GP
							INNER JOIN glob_page_type GPT ON GPT.glob_page_id=GP.glob_page_id
							INNER JOIN glob_type GT ON GT.glob_type_id=GPT.glob_type_id
							WHERE  GP.glob_page='cuttingdataentry.php'
							ORDER BY glob_type
							";
		
			$result_cut_type=$db->RunQuery($str_cut_type);
			
			while($row_cut_type=mysql_fetch_array($result_cut_type))
			{
		?>
                <option value="<?php echo $row_cut_type['glob_type_id'];?>"><?php echo $row_cut_type['glob_type'];?></option>
                <?php } ?>
              </select></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td width="12%" height="25">&nbsp;&nbsp;Buyer</td>
              <td width="20%"><select name="cboBuyer" class="txtbox" style="width:180px" id="cboBuyer" onchange="filterStyle();" tabindex="5">
                  <option value=""></option>
                  <?php 
			$buyerstr="select 	intBuyerID,buyerCode,strName from buyers where intStatus=1 order by strName";
		
			$buyerresults=$db->RunQuery($buyerstr);
			
			while($buyerrow=mysql_fetch_array($buyerresults))
			{
		?>
                  <option value="<?php echo $buyerrow['intBuyerID'];?>"><?php echo $buyerrow['strName'];?></option>
                  <?php } ?>
              </select></td>
              <td width="12%">&nbsp;&nbsp;PO/ Style No</td>
              <td width="20%"><select name="cmbStyle" class="txtbox" style="width:180px" id="cmbStyle" tabindex="6"  onchange="LoadColor();">
                  
                  <option value=""></option>
                  <?php 
			$strpo="select  scch.intStyleId,strOrderNo,strStyle from style_cut_compo_header scch inner join orders on orders.intStyleId=scch.intStyleId  where orders.intStatus=11 order by strOrderNo";
		
			$poresults=$db->RunQuery($strpo);
			
			while($porow=mysql_fetch_array($poresults))
			{?>
                <option value="<?php echo $porow['intStyleId'];?>"><?php echo $porow['strOrderNo']."/ ".$porow['strStyle'];?></option>
             <?php } ?>
              </select></td>
              <td width="12%">&nbsp;&nbsp;Color</td>
              <td width="20%"><select name="cmbColor" class="txtbox" style="width:180px" id="cmbColor"  tabindex="7" onchange="loadLayers()">
                  
               <option value=""></option>     
              </select></td>
            </tr>
            
            <tr>
              <td height="25">&nbsp;&nbsp;Order Qty </td>
              <td><input name="txtOrderQty" type="text" class="txtbox" disabled="disabled"  id="txtOrderQty" style="width:100px;text-align:right" maxlength="30" />&nbsp;Pcs<input type="hidden" id="exPercentage" name="exPercentage"/><input type="hidden" id="exSettingPercentage" name="exSettingPercentage" value="<?php echo $setting_qty;?>"/> </td>
              <td>&nbsp;&nbsp;Accumulated </td>
              <td ><input name="txtAccumulated" disabled="disabled" type="text" class="txtbox"  id="txtAccumulated" style="width:100px;text-align:right" maxlength="30" />
              &nbsp;Pcs<input type="hidden" id="initAccumilateQty" name="initAccumilateQty" /></td>
              <td>&nbsp;&nbsp;Total  Qty </td>
              <td><input name="txtTotalCut" disabled="disabled" type="text" class="txtbox" id="txtTotalCut" style="width:100px;text-align:right" maxlength="30" />&nbsp;Pcs</td>
            </tr>
            <tr>
              <td height="25">&nbsp;&nbsp;Pattern Nos</dd></td>
              <td><input name="txtPatternNo" type="text" class="txtbox" tabindex="8" id="txtPatternNo" style="width:180px" maxlength="30" /></td>
              <td>&nbsp;&nbsp;Cut Number <span style="color:#FF0000">*</span></td>
              <td id="cut_no_cell"><input name="txtCutNo" type="text" class="txtbox" id="txtCutNo" style="width:180px"  maxlength="40" tabindex="9"/></td>
              <td>&nbsp;&nbsp;Date</td>
              <td><input name="txtCutDate" type="text" tabindex="10" class="txtbox" id="txtCutDate" style="width:100px"  value="<?php echo date('d/m/Y');?>" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%d/%m/%Y');" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;" onkeypress="return showCalendar(this.id, '%d/%m/%Y');"   onclick="return showCalendar(this.id, '%d/%m/%Y');"  value="" /></td>
            </tr>
            <tr>
              <td height="25">&nbsp; Ply Height</td>
              <td><input name="txtPlyHeight" type="text" class="txtbox" id="txtPlyHeight" style="width:40px;text-align:right" maxlength="3" tabindex="11" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/>                
                 &nbsp;Marker Length&nbsp; 
                 <input name="txtMarkerLength" type="text" class="txtbox" id="txtMarkerLength" style="width:40px; text-align:right;" maxlength="6" tabindex="12" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
              <td>&nbsp;&nbsp;Invoice No</td>
              <td><input name="txtInvoiceNo" type="text" class="txtbox" id="txtInvoiceNo" style="width:180px" maxlength="30" tabindex="13"  /></td>
              <td>&nbsp;&nbsp;Spreader</td>
              <td><select name="cmbSpreader" class="txtbox" style="width:102px" id="cmbSpreader"  tabindex="14" >
                <option value="manual">Manual</option>
                <option value="automatic">Automatic</option>
              </select></td>
            </tr>
        </table></td>
      </tr>
      <!--<tr bgcolor="#CA521A" >
        <td height="3" class="mbari9"></td>
      </tr>-->
      <!--<tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="bcgl1 normalfnt">
            <tr>
              <td height="30" width="12%">&nbsp;</td>
              <td width="5%"><div align="right"></div></td>
              <td width="11%"><div align="center"></div></td>
              <td width="5%">
                  <div align="right"></div></td>
              <td width="27%"><div align="center"></div></td>
              <td width="16%"><div align="center"></div></td>
              <td width="12%"><div align="center"></div></td>
              <td width="12%"><div align="center"></div></td>
            </tr>
        </table></td>
      </tr>-->
     <!-- <tr>
        <td height="22" class="mbari9"></td>
      </tr>-->
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="2" class="normalfnt bcgl1">
            
            <tr>
              <td width="11%" height="30" >&nbsp;&nbsp;Size</td>
              <td width="10%"><div align="center">
                  <select name="cboSize" class="txtbox" style="width:80px" id="cboSize" tabindex="15" onchange="load_SW_Qtys();" >
                    <option value=""></option>
                  </select>
              </div></td>
              <td width="13%">&nbsp;No of Garments</td>
              <td width="11%">
                  <input name="txtGarments" type="text" class="txtbox" tabindex="16" style="text-align:right; width:80px; " id="txtGarments"  maxlength="3" onkeypress="return CheckforValidDecimal(this.value, 4,event);" />
              </td>
              <td width="5%"><div align="left">
                  <input type="image" src="../../../images/aad.png" alt="a" width="19" height="19" class="mouseover" onclick="addSiztoGrid()" tabindex="16"/>
              </div></td>
              <td width="10%">&nbsp;</td>
              <td width="10%">&nbsp;</td>
              <td width="10%">&nbsp;</td>
              
              <?php $str_serial="select 	intCutBundleSerial,dblBundleNo, intNumberRange from syscontrol ";
				  $result_serial=$db->RunQuery($str_serial);
				  $row_serail=mysql_fetch_array($result_serial);?>
              <td width="10%"><input name="hidden" type="hidden" id="bundleSerial" value="<?php echo $row_serail['intCutBundleSerial'];?>" />
                  <input name="numberrange" type="hidden" id="numberrange" value="<?php echo $row_serail['intNumberRange'];?>" />
                  <input name="bundleno" type="hidden" id="bundleno" value="<?php echo $row_serail['dblBundleNo'];?>" /></td>
              <td width="10%">&nbsp;</td>
            </tr>
			<tr>
              <td height="30" >&nbsp; Ordered Pcs</td>
              <td><input name="txtSWQty" disabled="disabled" type="text" class="txtbox" tabindex="15" style="text-align:right; width:80px; " id="txtSWQty"  maxlength="3" onkeypress="return CheckforValidDecimal(this.value, 4,event);" /></td>
              <td>&nbsp;Cut Qty/Pcs</td>
              <td><input name="txtSWCutQty" disabled="disabled" type="text" class="txtbox" tabindex="15" style="text-align:right; width:80px; " id="txtSWCutQty"  maxlength="3" onkeypress="return CheckforValidDecimal(this.value, 4,event);" /></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="5" ><div id="divcons"  style="overflow:scroll; height:300px; width:90%;">
                <table width="100%"  cellpadding="0" cellspacing="1" bgcolor="#996f03" id="tblSizes">
                  <tr class="mainHeading4">
                  		<td width="10%"  >&nbsp;</td>
                        <td width="45%" height="25" >Size</td>
                        <td width="45%" >Letter</td>
                  </tr>
                  </table>
              </div></td>
              <td colspan="5"><div id="divcons"  style="overflow:scroll; height:300px; width:90%;">
                <table width="100%"  cellpadding="0" cellspacing="1" bgcolor="#996f03" id="tblLayer">
                  <tr class="mainHeading4">
                    <td width="30%" height="25"  >Lay No</td>
                        <td width="35%" >Pcs</td>
                        <td width="35%" >Shades</td>
                      </tr>
                  </table>
              </div></td>
              </tr>
            <tr>
              <td >&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" class="bcgl1" cellspacing="0" cellpadding="0">
            <tr >
              <td width="23%" height="30">
                <div align="right">
                  <input type="image" tabindex="17" src="../../../images/new.png" alt="n" onclick="new_cut();"/>
                    </div></td><td width="13%" ><div align="center">
                  <input name="image" type="image" class="mouseover" onclick="view_for_edit()" tabindex="18" src="../../../images/view.png" alt="s" />
              </div></td>
              <td width="11%"><div align="center">
                  <input type="image" tabindex="19" src="../../../images/save.png" alt="p"  class="mouseover" onclick="saveHeader();"/>
              </div></td>
              <td width="15%"><div align="center">
                  <input type="image" tabindex="20" src="../../../images/report.png " alt="c"  class="mouseover" onclick="print_form();"/>
              </div></td>
              <td width="14%"><div align="center">
                  <input type="image" tabindex="21"src="../../../images/delete.png" onclick="delete_cut();"/>
              </div></td>
              <td width="24%">
                <a href="../../../main.php">
                  <input type="image" tabindex="22" src="../../../images/close.png" alt="c"  class="mouseover"  />
                  </a>
                </td></tr>
        </table></td>
      </tr>
      <!--<tr>
        <td height="5"></td>
      </tr>-->
      <!--<tr>
        <td class="bcgl1"><div id="divcons"  style="overflow:scroll; height:150px; width:100%;" >
            <table width="100%"  cellpadding="0" cellspacing="1" bgcolor="#996f03"  id="tblLayer">
              <tr class="mainHeading4">
                <td width="10%"  >Pattern No</td>
                <td width="10%"  >Style</td>
                <td width="10%"  >Size</td>
                <td width="10%"  >Cut No</td>
                <td width="10%"  >Bundle No</td>
                <td width="10%"  >Shade</td>
                <td width="10%"  >Number Range</td>
                <td width="10%"  >Component</td>
                <td width="10%"  >Pcs</td>
                <td width="10%"  >Serial #</td>
              </tr>
            </table>
        </div></td>
      </tr>-->
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<script type="text/javascript">
document.getElementById("cboFromFactory").value=<?php echo $companyid;?>;
</script>
</body>
</html>
