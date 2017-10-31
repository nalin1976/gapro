<?php
session_start();
$backwardseperator = "../../";
include "${backwardseperator}authentication.inc";
include "../../Connector.php";  
$iNo=$_GET['iNo'];
$iYear=$_GET['iYear'];
if(empty($iNo))
	$iNo=0;
if(empty($iYear))
	$iYear=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<title>Gapro:Washing-Issued Wash Production</title>

<link href="../../js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../css/tableGrib.css" rel="stylesheet" type="text/css" />
<link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<script type="text/javascript" src="../../javascript/calendar/calendar.js"></script>
<script type="text/javascript" src="../../javascript/calendar/calendar-en.js"></script>
<script type="text/javascript" src="../../js/jquery.fixedheader.js"></script>
	
<script type="text/javascript">
$(function(){
	// TABS
	$('#tabs').tabs();
});
</script>
<script src="issuedWash.js" type="text/javascript"></script>
<script src="issuedWash_0utSide.js" type="text/javascript"></script>
<script type="text/javascript">
function dateInDisable(obj)
{
	if(obj.checked){
		document.getElementById('machineLoading_dateIn').disabled=false;
		<?php
		
		?>
	}
	else{
		document.getElementById('machineLoading_dateIn').disabled=true;
	}
}

function dateOutDisable(obj)
{
	if(obj.checked){
		document.getElementById('machineLoading_dateOut').disabled=false;
	}
	else{
		document.getElementById('machineLoading_dateOut').disabled=true;
	}
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
<script type="text/javascript">
var tdate = "<?php echo date('Y-m-d');?>"
function today(){
var tDay= new Date();
//document.getElementById('issuedWash_txtDate').value =(tDay.getFullYear())+"-"+(tDay.getMonth()+1)+"-"+tDay.getDate();
}
function loadCompayPos(){
	loadStyles()
	}
</script>
</head>

<body onload="today(),loadCompayPos(),loadDataToEdit(<?php echo $iNo;?>,<?php echo $iYear;?>);">

<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include($backwardseperator.'Header.php'); ?></td>
	</tr> 
</table>

<table  border="0" align="center" class="bcgl1" bgcolor="#FFFFFF">
  <tr>
  	<td style="width:750px;" class="mainHeading">Issued To Wash Production</td>
  </tr>
  <tr>
    <td>
		<div  id="tabs" style="background-color:#FFFFFF">
		<ul>
			<li><a href="#tabs-1" class="normalfnt">In House</a></li>
			<li><a href="#tabs-2" class="normalfnt">Out Side</a></li>
		</ul>
        <!--// Tab 1 Add and Edit Data// -->
		<div id="tabs-1">
		<form id="frmIssuedWash" name="frmIssuedWash" method="post" action="">
	  	<table  border="0" align="center" cellpadding="0" cellspacing="0" style="width:600px;" ><!--class="main_border_line"-->
            <tr>
              <td style="width:600px;" valign="top">
              <table style="width:600px;">	
                <tr>
                  <td style="width:25px;">&nbsp;</td>
                  <td class="normalfnt" style="width:125px;">Issued No</td>
                  <td colspan="0" style="width:150px;"><input type="text" name="issuedWash_txtSerialNo" id="issuedWash_txtSerialNo" style="width:100px" readonly="readonly"/></td>
                    <td class="normalfnt" style="width:100px;">Date <span class="compulsoryRed">*</span></td>
                    <td colspan="0" style="width:150px;"><input name="issuedWash_txtDate" readonly="readonly" type="text" class="txtbox" id="issuedWash_txtDate"   style="width:100px" value="<?php echo date('Y-m-d'); ?>"/><!-- onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"   onclick="return showCalendar(this.id, '%Y-%m-%d');" <input name="reset" id="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value=""/>--></td>
                </tr>	
                
                
                <tr>
                  <td>&nbsp;</td>
                  <td class="normalfnt" style="width:100px;">PO No <span class="compulsoryRed">*</span></td>
                  <td colspan="0" class="normalfnt"><select name="issuedWash_cboPoNo" id="issuedWash_cboPoNo" style="width:150px;height:20px;" onchange="loadCompany(this);">
                    <!--,loadDetails(this)-->
                    <option value="">Select One</option>
                    <?php
					$sql="SELECT DISTINCT o.intStyleId,o.strOrderNo,o.strStyle
							FROM was_stocktransactions AS s
							INNER JOIN orders AS o ON s.intStyleId = o.intStyleId
							WHERE
							s.intCompanyId='".$_SESSION['FactoryID']."' order by o.strOrderNo";
                    $res=$db->RunQuery($sql);
					while($row=mysql_fetch_array($res)){
						echo "<option value=\"".$row['intStyleId']."\">".$row['strOrderNo']."</option>";
					}
					?>
                    </select></td>
                    <td class="normalfnt" style="width:100px;">Style No</td>
                    <td colspan="0" class="normalfnt"><select name="issuedWash_cboStyle" class="txtbox" id="issuedWash_cboStyle" style="width:102px;height:20px;" onchange="loadPO(this.value)" tabindex="2">
                      <option value="">Select One</option>
                      <?php
					$sql="SELECT DISTINCT o.intStyleId,o.strOrderNo,o.strStyle
							FROM was_stocktransactions AS s
							INNER JOIN orders AS o ON s.intStyleId = o.intStyleId
							WHERE
							s.intCompanyId='".$_SESSION['FactoryID']."' order by o.strStyle";
                    $res=$db->RunQuery($sql);
					while($row=mysql_fetch_array($res)){
						echo "<option value=\"".$row['intStyleId']."\">".$row['strStyle']."</option>";
					}
					?>
                      </select></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td class="normalfnt" style="width:100px;">Factory <span class="compulsoryRed">*</span></td>
                  <td colspan="3" style="width:450px;" class="normalfnt"><select name="issuedWash_cboFactory" id="issuedWash_cboFactory" style="width:383px;height:20px;" onchange=" loadColor(document.getElementById('issuedWash_cboPoNo'));" tabindex="3" >
                    <option value="">Select One</option>
                    <?php  /*//WHERE companies.intCompanyID =  '".$_SESSION['FactoryID']."'
                  $sql_loadFactory="SELECT companies.intCompanyID,companies.strName FROM companies where intManufacturing=1  order by companies.strName ;";
                  $resF=$db->RunQuery($sql_loadFactory);
                  while($rowF=mysql_fetch_array($resF))
                  {
                  ?>
                    <option value="<?php echo $rowF['intCompanyID'];  ?>"><?php echo $rowF['strName'];  ?></option>
                    <?php  }
           $sqlChk="select count(*) as C from  was_stocktransactions where intDocumentNo='".$iNo."' and intDocumentYear='".$iYear."' and strType='IWash';";
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
                                }*/ ?>
                    </select></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td class="normalfnt" style="width:100px;">Color <span class="compulsoryRed">*</span></td>
                  <td colspan="0"><select name="issuedWash_cboColor" id="issuedWash_cboColor" style="width:150px;height:20px;font-size:12px;color:#20407B;" onchange="loadQty('issuedWash_cboPoNo');" tabindex="4">
                    <option value="">Select One</option>
                    </select></td>
                  <td class="normalfnt" style="width:100px;">&nbsp;</td>
                  <td colspan="0">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td class="normalfnt" style="width:100px;">Order Qty</td>
                  <td colspan="0"><input type="text" name="issuedWash_txtOderQty" id="issuedWash_txtOderQty" style="width:100px;text-align:right;" onkeypress="return CheckforValidDecimal(this.value,0,event);" readonly="readonly" tabindex="5"/></td>
                  <td class="normalfnt" style="width:100px;">RCVD.  Qty </td>
                  <td colspan="0"><input type="text" name="issuedWash_txtRecvQty" id="issuedWash_txtRecvQty" style="width:100px;text-align:right;" onkeypress="return CheckforValidDecimal(this.value,0,event);" readonly="readonly" tabindex="6"/></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td class="normalfnt" style="width:100px;">Acc.Issue  Qty</td>
                  <td colspan="0"><input type="hidden" name="issuedWash_txtAVLQty" id="issuedWash_txtAVLQty" style="width:100px;text-align:right;" onkeypress="return CheckforValidDecimal(this.value,0,event);" readonly="readonly"/><input type="text" name="issuedWash_txtIssuedQty" id="issuedWash_txtIssuedQty" style="width:100px;text-align:right;" onkeypress="return CheckforValidDecimal(this.value,0,event);" readonly="readonly" tabindex="7"/></td>
                  <td class="normalfnt" style="width:100px;">Issue Qty<span class="compulsoryRed">*</span> </td>
                  <td colspan="0"><input type="text"  maxlength="8" name="issuedWash_txtIssueQty" id="issuedWash_txtIssueQty" style="width:100px;text-align:right;" onkeypress="return isValidZipCode(this.value,event);"  onkeyup="setBalance(this);"  <?php if($chk==1){ echo "disabled='disabled'";}else {}?>" tabindex="8" />
                   </td>
                   <!--"-->
                   <!--<td width="97" class="normalfnt">Balance Qty </td>
                   <td width="104" class="normalfnt">--><input type="hidden" name="issuedWash_txtBalQty" id="issuedWash_txtBalQty" style="width:100px;text-align:right;" onkeypress="return CheckforValidDecimal(this.value,0,event);" readonly="readonly"/><!--</td>-->
                </tr>
              </table>
              </td>
            </tr>
            <!--<tr>
                  <td colspan="2" class="containers">&nbsp;</td>
            </tr>
            <tr>
              <td height="30" colspan="2">
              <div id="div"  style="overflow:scroll; width:830px; height:280px;">
                <table width="800" id="tblIssueWashGrid" bgcolor="#F3E8FF"  cellpadding="0" cellspacing="1" border="0">
                    <thead>
                    <tr bgcolor="#498CC2" class="grid_header">
                         <td width="10" class="grid_header">&nbsp;</td>
                         <td width="100" height="25" class="grid_header">Color</td>
                         <td width="80" height="25" class="grid_header">Size</td>
                         <td width="80" class="grid_header">Recieved Qty</td>
                         <td width="80" class="grid_header">Available Qty</td>
                         <td width="50" class="grid_header">Issue Qty</td>
                         <td width="50" class="grid_header">Balance Qty</td>
                    </tr>
                  </thead>
                  
                  <tbody>
                  </tbody>
                </table>
              </div>
              </td>  
            </tr>-->
            <tr>
            <td colspan="6">
                <table align="center" border="0">
                        <tr>
                            <td>
                                <img src="../../images/new.png" alt="new"  width="84" height="24" border="0" onclick="ClearForm('new');" id="new" tabindex="11"/>
                                <img src="../../images/save.png" id="imgSave" alt="save" width="84" height="24" border="0" onclick="saveIssuedWash();" style="display:<?php if($chk==1){ echo "none";}else {echo "inline";}?>" tabindex="9"/>
                            <img id="imgConfirm" src="../../images/conform.png" onclick="showReport();" style="display:none;"  />
                            <a href="../../main.php"><img src="../../images/close.png" alt="close" width="84" height="24" border="0"/ tabindex="10"></a> </td>
                        </tr>
                  </table>
                </td>
              </tr>
	    </table>
	  </form>
	  	</div>
        <!-- // End Tab-1 -->
        <!-- // Start Tab-2 -->
        <div id="tabs-2">
        
            <form id="frmIssuedWash_os" name="frmIssuedWash_os" method="post" action="">
            <table  border="0" align="center" cellpadding="0" cellspacing="0"  style="width:600px;">
            <tr>
              <td valign="top" style="width:600px;">
              <table  style="width:600px;" border="0" class="" align="center">		  	
                <tr>
                  <td style="width:50px;">&nbsp;</td>
                  <td style="width:100px;" class="normalfnt">PO No <span class="compulsoryRed">*</span></td>
                  <td style="width:150px;" colspan="0">
                  <select name="issuedWash_os_pono" id="issuedWash_os_pono" style="width:150px;height:20px;font-size:12px;color:#20407B;" onchange="loadOutSideDet(this);">
                  <option value="">Select One</option>
                  <?php 
                  $sql_po="select intId,intPONo from was_outsidepo order by intPONo;";
                  $resPo=$db->RunQuery($sql_po);
                  while($rowF=mysql_fetch_array($resPo))
                  {
                  ?>
                    <option value="<?php echo $rowF['intId'];  ?>"><?php echo $rowF['intPONo'];  ?></option>
           <?php  }?>
         </select></td>
                  <td style="width:100px;" class="normalfnt">Style Name</td>
                  <td style="width:150px;" colspan="0">
                  <select name="issuedWash_os_style" id="issuedWash_os_style" style="width:150px;height:20px;font-size:12px;color:#20407B;" >
                  </select></td>
    <!--			  <td width="30" class="normalfnt"><img src="../../images/aad.png" onclick="loadExistingData();" style="cursor:pointer;visibility:hidden;"/></td>-->
                </tr>
                <tr>
                  <td style="width:50px;">&nbsp;</td>
                  <td class="normalfnt" style="width:100px;"> Color <span class="compulsoryRed">*</span></td>
                  <td colspan="0"><select name="issuedWash_os_color" class="txtbox" id="issuedWash_os_color" style="width:150px;height:20px;font-size:12px;color:#20407B;" onchange="loadPO(this.value)">
                    </select></td>
                    <td class="normalfnt" style="width:100px;">Mill <span class="compulsoryRed">*</span></td>
                    <td colspan="0" style="width:150px;">
                    <select id="issuedWash_os_mill" name="issuedWash_os_mill" style="width:150px;height:20px;font-size:12px;color:#20407B;">
                    </select></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td class="normalfnt" style="width:100px;">Division <span class="compulsoryRed">*</span></td>
                  <td colspan="0"><select name="issuedWash_os_division" id="issuedWash_os_division" style="width:150px;height:20px;font-size:12px;color:#20407B;" onchange="loadDetails(this);">
                  </select></td>
                  <td class="normalfnt" style="width:100px;">Factory</td>
                  <td colspan="0">
                  <select style="width:150px;height:20px;font-size:12px;color:#20407B;" name="issuedWash_os_factory" id="issuedWash_os_factory">
                  </select></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td class="normalfnt" style="width:100px;">Gatepass No <span class="compulsoryRed">*</span></td>
                  <td colspan="0"><input type="text" name="issuedWash_os_gpno" id="issuedWash_os_gpno" style="width:150px;text-align:right;" onkeypress="return CheckforValidDecimal(this.value,0,event);"/></td>
                  <td class="normalfnt" style="width:100px;">Fabric ID</td>
                  <td colspan="0">
                  <select name="issuedWash_os_fbId" id="issuedWash_os_fbId" style="width:150px;height:20px;font-size:12px;color:#20407B;"></select></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td class="normalfnt" style="width:100px;">Cut No <span class="compulsoryRed">*</span></td>
                  <td colspan="0"><input type="text" name="issuedWash_os_cutno" id="issuedWash_os_cutno" style="width:150px;text-align:right;" onkeypress="return CheckforValidDecimal(this.value,0,event);" /></td>
                  <td class="normalfnt" style="width:100px;">Size</td>
                  <td colspan="0">
                  <input type="text" name="issuedWash_os_size" id="issuedWash_os_size" style="width:150px" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td class="normalfnt" style="width:100px;">Purpose<span class="compulsoryRed">*</span></td>
                  <td colspan="0"><input type="text" name="issuedWash_os_purpose" id="issuedWash_os_purpose" style="width:150px" /></td>
                  <td class="normalfnt" style="width:100px;">Qty</td>
                  <td colspan="0"><input type="text" name="issuedWash_os_qty" id="issuedWash_os_qty" style="width:150px;text-align:right;" onkeypress="return CheckforValidDecimal(this.value,0,event);" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td class="normalfnt" style="width:100px;">Term <span class="compulsoryRed">*</span></td>
                  <td colspan="0"><input type="text" name="issuedWash_os_term" id="issuedWash_os_term" style="width:150px" /></td>
                  <td class="normalfnt" style="visibility:hidden;" >Serial</td>
                  <td colspan="0"><input type="hidden" name="issuedWash_os_serial" id="issuedWash_os_serial" style="width:150px" /></td>
                </tr>
              </table>
              </td>
            </tr>
            <!--<tr>
                  <td colspan="2" class="containers">&nbsp;</td>
            </tr>
            <tr>
              <td height="30" colspan="2">
              <div id="div"  style="overflow:scroll; width:800px; height:280px;">
                <table width="800" id="tblIssueWashGrid" bgcolor="#F3E8FF"  cellpadding="0" cellspacing="1" border="0">
                    <thead>
                    <tr bgcolor="#498CC2" class="grid_header">
                         <td width="10" class="grid_header">&nbsp;</td>
                         <td width="100" height="25" class="grid_header">Color</td>
                         <td width="80" height="25" class="grid_header">Size</td>
                         <td width="80" class="grid_header">Recieved Qty</td>
                         <td width="80" class="grid_header">Available Qty</td>
                         <td width="50" class="grid_header">Issue Qty</td>
                         <td width="50" class="grid_header">Balance Qty</td>
                    </tr>
                  </thead>
                  
                  <tbody>
                  </tbody>
                </table>
              </div>
              </td>  
            </tr>-->
                <tr>
                    <td colspan="6">
                        <table align="center" border="0">
                                <tr>
                                    <td>
                                        <img src="../../images/new.png" alt="new"  width="84" height="24" border="0" onclick="ClearFormOS('new');" id="new" />
                                        <img src="../../images/save.png" alt="save" width="84" height="24" border="0" onclick="validateForm();" id="save"/>
                                    <!--	<img src="../../images/print.png" alt="print" width="84" height="24" border="0" onclick="();" />--><img src="../../images/report.png" onclick="" id="rpt" />
                                    <a href="../../main.php"><img src="../../images/close.png" alt="close" width="84" height="24" border="0"/></a> </td>
                                </tr>
                            </table>
                    </td>
                </tr>
            </table>
            </form>
        
        </div>
		<!-- // Start Tab-1 -->
	  </div>
		
  	</td>
  </tr>
</table> 
</body>
</html>

        
        