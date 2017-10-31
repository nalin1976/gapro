<?php
	session_start();
	include("../../Connector.php");
	$backwardseperator = "../../";
	$invoiceNo = $_GET['InvoiceNo'];
	$id = $_GET['id'];
	//echo $invoiceNo;
	//echo $id;
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web -CDN</title>

<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
	
}

-->
</style>

<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>
<link type="text/css" href="../../css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.7.2.custom.min.js"></script>
        
        
<script type="text/javascript" src="../../js/jquery-1.4.4.min.js"></script>
<link href="../../css/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery-ui-1.8.9.custom.min.js"></script>

	
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="cdn.js" type="text/javascript"></script>
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
        
        <link type="text/css" href="../../css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="../../js/jquery-ui-1.7.2.custom.min.js"></script>
        
        
		<script type="text/javascript" src="../../js/jquery-1.4.4.min.js"></script>
		<link href="../../css/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="../../js/jquery-ui-1.8.9.custom.min.js"></script>
		<script src="jquery.fixedheader.js" type="text/javascript"></script>
		<script src="pl_plugin_search.js" type="text/javascript"></script>
		
        
		<script type="text/javascript">
			$(function(){

				// Accordion
				$("#accordion").accordion({ header: "h3" });
	
				// Tabs
				$('#tabs').tabs();
	

				// Dialog			
				$('#dialog').dialog({
					autoOpen: false,
					width: 600,
					buttons: {
						"Ok": function() { 
							$(this).dialog("close"); 
						}, 
						"Cancel": function() { 
							$(this).dialog("close"); 
						} 
					}
				});
				
				// Dialog Link
				$('#dialog_link').click(function(){
					$('#dialog').dialog('open');
					return false;
				});

				// Datepicker
				$('#datepicker').datepicker({
					inline: true
				});
				
				// Slider
				$('#slider').slider({
					range: true,
					values: [17, 67]
				});
				
				// Progressbar
				$("#progressbar").progressbar({
					value: 20 
				});
				
				//hover states on the static widgets
				$('#dialog_link, ul#icons li').hover(
					function() { $(this).addClass('ui-state-hover'); }, 
					function() { $(this).removeClass('ui-state-hover'); }
				);
				
			});
		</script>
	
</head>

<body <?php if($id==1){?> onload="load_Hdetail();" <?php }?> ><!-- "loadHeaderData(this.value);" setDefaultDate-->

  <table width="950" border="0" align="center" bgcolor="#FFFFFF">
<tr>
    <td><?php include '../../Header.php'; 
 ?></td>
</tr>
  <tr>
    <td height="12" colspan="2" bgcolor="#316895" class="TitleN2white"> </td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
	<tr class="bcgl1txt1NB">
	  <td>
      <div  id="tabs" >
			<ul>
				<li><a href="#tabs-1" >CDN</a></li>
				<li><a onclick="loadCDNno()" href="#tabs-2" id="hrtab">Description of Articles</a></li>
			</ul>
			<div id="tabs-1">
            <form name="frmCargoDispatch" id="frmCargoDispatch" >
            <table width="100%" border="0">
      <tr>
        <td width="62%"><table width="100%" border="0">
          <tr>
            <td height="30" bgcolor="#588DE7" class="TitleN2white">Cargo Dispatch Note </td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%" class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td class="normalfnt"><table width="100%" border="0" cellpadding="1" cellspacing="1" class="bcgl1"><tr><td><table width="100%" border="0" cellpadding="1" cellspacing="1">
                        <tr>
                          <td width="14%" height="3"></td>
                          <td width="19%"></td>
                          <td width="15%"></td>
                          <td width="19%"></td>
                          <td width="15%"></td>
                          <td width="18%"></td>
                        </tr>
                        
                        <tr>
                          <td colspan="6">
                          	<fieldset class="roundedCorners" >
                            <legend class="legendHeader">&nbsp;Search&nbsp;</legend>
                            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                  <tr>
                    <td width="2" class="normalfntMid">&nbsp;</td>
                    <td width="107" class="normalfnt">CDN Invoice No</td>
                    <td width="166"><input name="txtCDNInvNo" type="text" maxlength="100" class="txtbox" id="txtCDNInvNo" size="25" style="width:130px" onkeyup="changeCDNInvCombo(this,event);"  onclick="abc_InvNo();"/></td>
                    <td width="97" class="normalfnt">Buyer PO No</td>
                    <td width="167"><input name="txtCDNBuyerPO" type="text" maxlength="100" class="txtbox" id="txtCDNBuyerPO" size="25" style="width:130px" onkeyup="changeCDNPoCombo(this,event);" onclick="abc_BuyerPO();"/></td>
                  <td width="116" class="normalfnt" >Pre Invoice No</td>
                    <td width="177" ><input name="txtpendingCDNInvNo" type="text" maxlength="100" class="txtbox" id="txtpendingCDNInvNo" size="25" style="width:130px" onkeyup="changependingCDNvCombo(this,event);" onclick="abc_pre();"/></td>
                    <!--<td width="46"><input type="checkbox" id="ctn_srch" class="txtbox" onclick="cdn_cersh" /></td>-->
                  </tr>
                </table></fieldset>
                          
                          </td>
                          </tr>
                        <tr>
                          <td>&nbsp;&nbsp;CDN Invoice No</td>
                          <td nowrap="nowrap"><select name="cboCDNNo"  class="txtbox" id="cboCDNNo" style="width:150px" onchange="loadHeaderData(this.value);">
                              <option value=''></option>
                              <?php
							  
                   			$str="select intCDNNo,strInvoiceNo from cdn_header order by strInvoiceNo DESC";
                  			$exec=$db->RunQuery($str);
		
									while($row=mysql_fetch_array($exec)) 
						 			{
										if($row['strInvoiceNo'] == $invoiceNo)
										{
										?>
                              <option value="<?php echo $row['strInvoiceNo'];?>" selected="selected"><?php echo $row['strInvoiceNo'];?></option>
                              <?php }
							  			else
											  {
												  ?>
                                                  	
                                                   <option value="<?php echo $row['intCDNNo'];?>"><?php echo $row['strInvoiceNo'];?></option>

                <?php
								       }
									          } ?>
                                              
                            </select>                          </td>
                          <td>Invoice #&nbsp;<span class="compulsory">*</span></td>
                          <td><select name="cboInvoiceNo" class="txtbox" id="cboInvoiceNo" style="width:150px" onchange="loadInvoiceData(this.value);">
                            <option value=''></option>
                          </select></td>

         
  
                          <td>Date</td>
                          <td><input name="txtDate" style="width:100px; text-align:center" type="text" maxlength="100" class="txtbox" id="txtDate" size="10" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" />                   </td>
                        </tr>
                        <tr>
                          <td height="22">&nbsp;&nbsp;Consignee</td>
                          <td><select name="cboConsignee"  class="txtbox" id="cboConsignee" style="width:150px" >
                              <option value=''></option>
                               <?php 
						   $sqlBuyer="SELECT strBuyerID,strName,strBuyerCode FROM buyers ORDER BY strBuyerID  ";
						   $resultBuyer=$db->RunQuery($sqlBuyer);
						 while($row=mysql_fetch_array( $resultBuyer)) 
						 echo "<option value=".$row['strBuyerID'].">".$row['strName']." ---> ".$row['strBuyerCode']."</option>";                 
                   ?>
                            </select>  
                           </td>
                          <td><!--<input name="txtShipper" type="text" class="txtbox" id="txtShipper" size="18" />-->
                            Shipper (Company)</td>
                          <td><select name="cboShipper"  class="txtbox" id="cboShipper"style="width:150px" >
                            <option value=''></option>
                            <?php 
						   $sqlBuyer="select strCustomerID,strName from customers order by strName;";
						   $resultBuyer=$db->RunQuery($sqlBuyer);
						 while($row=mysql_fetch_array( $resultBuyer)) 
						 echo "<option value=".$row['strCustomerID'].">".$row['strName']."</option>";                 
                   ?>
                          </select></td>
                          <td>Voyage &amp; Date</td>
                          <td><!--<input name="txtConsignee" type="text" class="txtbox" id="txtConsignee" size="18" />-->
                            <input name="txtVoyageNo" type="text" class="txtbox" id="txtVoyageNo" size="25" maxlength="100" style="width:50px"/>
                            <input name="txtVoyegeDate" style="width:70px; text-align:center" type="text" maxlength="100" class="txtbox" id="txtVoyegeDate" size="10" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;&nbsp;Vessel/ Flight</td>
                          <td><input name="txtVessel" type="text" maxlength="100" class="txtbox" id="txtVessel" style="width:147px" /></td>
                          <td>EX-Vessel</td>
                          <td><input name="txtExVessel" type="text" maxlength="100" class="txtbox" id="txtExVessel" size="25" style="width:147px" /></td>
                          <td>Seal No</td>
                          <td><input name="" type="text" maxlength="100" class="txtbox" id="txtSealNo" style="width:147px" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;&nbsp;Port Of Discharge </td>
                          <td><select name="cboPortOfDischarge"  class="txtbox" id="cboPortOfDischarge" style="width:150px" >
                            <option value=''></option>
                             <?php 
                   $sqlCity="SELECT strCityCode,strCity,strPortOfLoading FROM city where strCity!='' and strPortOfLoading!='' order by strCity ";
                   $resultCity=$db->RunQuery($sqlCity);
						 while($row=mysql_fetch_array( $resultCity)) 
						 echo "<option value=".$row['strCityCode'].">".$row['strCity']." ---> ".$row['strPortOfLoading']."</option>";                 
                   ?>
                          </select></td>
                          <td>BL No</td>
                          <td><input name="txtBLNo" type="text" maxlength="100" class="txtbox" id="txtBLNo" size="25" style="width:147px"/></td>
                          <td>Name Of Cleaner</td>
                          <td><input name="txtCleaner" type="text" maxlength="100" class="txtbox" id="txtCleaner" size="25" style="width:147px"/></td>
                        </tr>
                        <tr>
                          <td>&nbsp;&nbsp;Tare Wt. Kg</td>
                          <td><input name="txtTaraWt" type="text" maxlength="100" class="txtbox" id="txtTaraWt" style="width:147px" onkeypress="return CheckforValidDecimal(this.value, 4,event);" /></td>
                          <td>Customes Entry</td>
                          <td><input name="txtCustomesEntry" type="text" maxlength="100" class="txtbox" id="txtCustomesEntry" size="25" style="width:147px" /></td>
                          <td>CNT OPR Code</td>
                          <td><input name="txtCNTCode" type="text" maxlength="100" class="txtbox" id="txtCNTCode" size="25" style="width:147px"/></td>
                        </tr>
                        <tr>
                          <td>&nbsp;&nbsp;Declarent Name </td>
                          <td><select name="cboDeclarentName"  class="txtbox" id="cboDeclarentName" style="width:150px" >
                            <option value=''></option>
                            <?php 
                   $sqlCity="select intWharfClerkID,strName from wharfclerks order by strName;";
                   $resultCity=$db->RunQuery($sqlCity);
						 while($row=mysql_fetch_array( $resultCity)) 
						 echo "<option value=".$row['intWharfClerkID'].">".$row['strName']."</option>";                 
                   ?>
                          </select></td>
                          <td>Name Of Driver </td>
                          <td><input name="txtDriver" type="text" maxlength="100" class="txtbox" id="txtDriver" size="25" style="width:147px"/></td>
                          <td>Container Type</td>
                          <td><select name="cboCotainerType"  class="txtbox" id="cboCotainerType"style="width:150px" >
                            <option value=''></option>
                             <?php 
						   $sqlBuyer="SELECT intContainerId,strContainerName FROM container ORDER BY strContainerName;";
						   $resultBuyer=$db->RunQuery($sqlBuyer);
						 while($row=mysql_fetch_array( $resultBuyer)) 
						 echo "<option value=".$row['intContainerId'].">".$row['strContainerName']."</option>";                 
                   ?>
                          </select></td>
                        </tr>
                        <tr>
                          <td>&nbsp;&nbsp;Signatory </td>
                          <td><select name="cboSignator"  class="txtbox" id="cboSignator" style="width:150px" >
                            <option value=''></option>
                           <?php 
                   $sqlCity="select intWharfClerkID,strName from wharfclerks order by strName;";
                   $resultCity=$db->RunQuery($sqlCity);
						 while($row=mysql_fetch_array( $resultCity)) 
						 echo "<option value=".$row['intWharfClerkID'].">".$row['strName']."</option>";                 
                   ?>
                          </select></td>
                          <td>Temperature</td>
                          <td><input name="txtTemoerature" type="text" maxlength="100" class="txtbox" id="txtTemoerature" size="25" style="width:147px" onkeypress="return CheckforValidDecimal(this.value, 4,event);" /></td>
                          <td>LCL/ FCL</td>
                          <td><select name="cboCotainerType2"  class="txtbox" id="cboCotainerType2"style="width:150px" >
                            <option value='LCL'>LCL</option>
                            <option value='FCL'>FCL</option>
                           
                          </select></td>
                        </tr>
                        <tr>
                          <td>&nbsp;&nbsp;VSL OPR Code</td>
                          <td><input name="txtVSLCode" type="text" maxlength="100" class="txtbox" id="txtVSLCode" style="width:147px" /></td>
                          <td>Container H x L</td>
                          <td><input name="txtContainerH" type="text" maxlength="100" class="txtbox" id="txtContainerH" size="25" onkeypress="return CheckforValidDecimal(this.value, 4,event);" style="width:70px"/>&nbsp;&nbsp;<input name="txtContainerL
" type="text" maxlength="100" class="txtbox" id="txtContainerL" size="25" onkeypress="return CheckforValidDecimal(this.value, 4,event);" style="width:67px"/></td>
                          <td>Container No </td>
                          <td><input type="text" class="txtbox" id="txtContainerNo" name="txtContainerNo" style="width:147px" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;&nbsp;CTN &nbsp;&nbsp;Measurements</td>
                          <td><input type="checkbox" id="ctn_measure" class="txtbox" /></td>
                          <td>CDN Doc No</td>
                          <td><input name="txtCDNDocNo" type="text" maxlength="100" class="txtbox" id="txtCDNDocNo" size="25" onkeypress="return CheckforValidDecimal(this.value, 4,event);" style="width:70px"/></td>
                          <td>SLPA No</td>
                          <td><input name="txtSLPANo" type="text" maxlength="100" class="txtbox" id="txtSLPANo" size="25" style="width:147px"/></td>
                        </tr>
                        <tr>
                        <td height="2">&nbsp;&nbsp;Status</td>
                          <td><input name="txtStatus" type="text" maxlength="100" class="txtbox" id="txtStatus" style="width:147px" disabled="disabled"/></td>
                          <td>Export date </td>
                          <td><input name="exportDate" style="width:100px; text-align:center" type="text" maxlength="100" class="txtbox" id="exportDate" size="10" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" /> </td>
                          <td colspan="2" height="2"></td>
                        </tr>
                        <tr>
                          <td colspan="6" height="2"></td>
                        </tr>
                      </table></td>
                          </tr>
                          <tr>
                          	<td>
                            <table width="100%" border="0" cellpadding="1" cellspacing="1">
                        <tr>
                          <td width="14%" height="3"></td>
                          <td width="19%"></td>
                          <td width="15%"></td>
                          <td width="19%"></td>
                          <td width="15%"></td>
                          <td width="18%"></td>
                        </tr>
                        <tr>
                          <td colspan="6" align="left">
                          
                          <div style="overflow-y: scroll; overflow-x: hidden; height: 100px; width: 390px;" id="selectitem1">
                          <table width="100%" bgcolor="FFFFFF" cellpadding="0" cellspacing="1" class="bcgl1 normalfnt" id="tblDescription_po1">
          <tr>
          	<td width="13%" height="20" bgcolor="#498CC2" class="normaltxtmidb2"></td>
            <td width="13%" bgcolor="#498CC2" class="normaltxtmidb2">Lorry No</td>
            <td width="12%"  bgcolor="#498CC2" class="normaltxtmidb2">CTNS</td>
		  </tr>	
          <tr class="bcgcolor-tblrowWhite">
          	<td style="text-align:center"><img style="cursor:pointer" maxlength="15" alt="del" onclick="delRow(this);" 
            src="../../images/del.png"/></td>
          	<td style="text-align:center"><input type="text" style="width:158px; text-align:center;" onblur="checkExist(this);"/></td>
            <td style="text-align:center"><input type="text" style="width:158px; text-align:center;" onkeypress="addR(this,event); return CheckforValidDecimal(this.value,4,event)"/></td>
          </tr>
          	
           </table>
           </div>
                          
                          </td>
                          <td colspan="6" align="left">
                          
                          <div style="overflow-y: scroll; overflow-x: hidden; height: 100px; width: 390px;" id="selectitem2">
                          <table width="100%" bgcolor="FFFFFF" cellpadding="0" cellspacing="1" class="bcgl1 normalfnt" id="tblDescriptionCTN">
          <tr>
          	<td width="13%" height="20" bgcolor="#498CC2" class="normaltxtmidb2"></td>
            <td width="13%" bgcolor="#498CC2" class="normaltxtmidb2">CTN</td>
            <td width="12%"  bgcolor="#498CC2" class="normaltxtmidb2">QTY</td>
		  </tr>	
          <tr class="bcgcolor-tblrowWhite">
          	<td style="text-align:center"><img style="cursor:pointer" maxlength="15" alt="del" onclick="delRow(this);" 
            src="../../images/del.png"/></td>
          	<td style="text-align:center"><select id="cboCTN" name="cboCTN" class="txtbox" style="width:170px">
            <option value=""></option>
            <?php
				$sqlCT="SELECT DISTINCT
						cartoon.strCartoon,
						cartoon.intCartoonId
						FROM cartoon";
						
				 $resCT=$db->RunQuery($sqlCT);
				 while($rowCT = mysql_fetch_array($resCT))
				 {
			?>
            <option value="<?php echo $rowCT['strCartoon']; ?>"><?php echo $rowCT['strCartoon']; ?></option>
            <?php
				 }
				?>
            </select></td>
            <td style="text-align:center"><input type="text" style="width:158px; text-align:center;" onkeypress="addRo(this,event); return CheckforValidDecimal(this.value,4,event)"/></td>
          </tr>
          	
           </table>
           </div>
                          
                          </td>

                          </tr>
                      
                        <tr>
                          <td colspan="6" height="2"></td>
                        </tr>
                      </table>
                            </td>
                          </tr>
                      </table></td>
                      </tr>
                    
                  </table></td>
                  </tr>
              </table>            </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr bgcolor="#d6e7f5">
                <td width="100%"><table width="100%" border="0" cellspacing="0">
                    <tr bgcolor="#d6e7f5">
                      <td align="center"><img src="../../images/new.png" alt="New" name="New" onclick="clearPage();"  class="mouseover" />
                      <img src="../../images/save.png" alt="Save" name="Save" id="butSave" onclick="saveData();" class="mouseover"/>
                      <img src="../../images/print.png" alt="Delete" name="Delete"onclick="printReport();" class="mouseover"/>
                      <img src="../../images/cancel.jpg" alt="Cancel" name="Cancel" border="0" onclick="cancelPages()" id="cancelPage" class="mouseover"/>
                      </a><img src="../../images/conform.png" alt="Conform" name="Conform" border="0" onclick="pageConfom()" id="conformPage" class="mouseover"/>
                      <img src="../../images/revise.png" alt="revise" name="revise" width="93" height="26" border="0" class="mouseover" id="revise" onclick="revisestatus()"/>
                      <img src="../../images/do_copy.png" onclick="popAddCtn();" />
                      <img src="../../images/go.png" alt="go"  name="butgo" width="37" height="26" class="mouseover"  id="butgo" onclick="gotoCdn();" />
                      </td>
                      </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        </tr>
    </table>
    </form>
			</div>
			
	<div id="tabs-2" s><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      
      <tr>
        <td width="88%" height="21" bgcolor="#9BBFDD" class="head1">PO Wise Description </td>
        <td width="12%" bgcolor="#9BBFDD" class="normalfnt"><img src="../../images/addnew2.png" alt="Add" name="Add" id="butAdd" onclick="AddDataFromPopUp();" class="mouseover" style="visibility:hidden"/></td>
      </tr>
      <tr>
        <td colspan="2" class="normalfnt">
		<div id="divcons" style="overflow:hidden;  width:100%;">
		<table width="100%"  >
		  <tr>
		    <td width="58" height="15"><!--CDN No--> </td>
		    <td width="174"><input name="txtInvoiceDetail" type="text" class="txtbox" id="txtInvoiceDetail"  size="25" maxlength="10" disabled="disabled" style="visibility:hidden"/></td>
		    <td width="66" ><!--Invoices--></td>
		    <td width="151" >
            <select name="cboInvoiceNoOther" class="txtbox" id="cboInvoiceNoOther" style="width:150px; visibility:hidden" onchange="">
                            <option value=''></option>
                          	</select>
            </td>
		    <td width="349" style="text-align:left; visibility:hidden"><img src="../../images/add.png" style="cursor:pointer" onclick="loadInvDetailsGridOtherRow();"/></td>
		    <td width="114" ><img src="../../images/addsmall.png" title="Add PL" style="cursor:pointer;" onclick="viewPOPUPDetail();"/></td>
			</tr>
		<tr>
		<td height="80" colspan="6" ><div style="overflow: scroll; height: 250px; width: 900px;" id="selectitem"><table width="1200" cellspacing="1" cellpadding="0" class="bcgl1" id="tblDescription">
          <tbody id="tblDescriptionOfGood">
          <tr>
          	<td width="2%" bgcolor="#498CC2" class="normaltxtmidb2" height="25"><img src="../../images/del.png" style="cursor:pointer" alt="del" onclick="deleteAll();"/></td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Invoice</td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Style </td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">PO </td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">PL </td>
            <td width="13%" bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">Description</td>
            <td width="13%" bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">Fabrication</td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Color</td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Price </td>
            <td width="2%" bgcolor="#498CC2" class="normaltxtmidb2">Unit</td>
            
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Qty</td>
             <td width="2%" bgcolor="#498CC2" class="normaltxtmidb2">Unit </td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Value</td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Gross </td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Net </td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">HS</td>
           	<td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">CTNS</td>
			<td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">UOM_Qty1</td>
           	<td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">UOM_Qty2</td>
			<td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">UOM_Qty3</td>
			<td width="4%" bgcolor="#498CC2" class="normaltxtmidb2">ISD#</td>
            <td width="3%" bgcolor="#498CC2" class="normaltxtmidb2">CBM</td>
            </tr></tbody></table></div> </td>
		
		</tr>
		<tr>
		  <td colspan="6" ><table width="103%" border="0" cellspacing="0" cellpadding="0">
            <tr bgcolor="#D6E7F5">
              <td width="1%" height="29" >&nbsp;</td>
              <td width="40%" >&nbsp;</td>
              
              <td width="18%" ><img src="../../images/save.png" style="visibility:hidden" alt="save" name="butSave" width="84" height="24" class="mouseover" id="butSave" onclick="InsertDetail();" /></td>
             
              <td width="30%" >&nbsp;</td>
            </tr>
          </table></td>
          </tr>
		<tr>
		  <td colspan="6" ><table width="100%" border="0" cellspacing="0" cellpadding="3" class="normalfnt">
          
           <tr>
		      <td width="13%" height="25">Total Price</td>
		      <td width="21%"><input name="txtTotalPrice" maxlength="20" type="text"  class="txtbox" id="txtTotalPrice" style="width:158px" disabled="disabled" value="0" /></td>
		      <td width="13%">Total Qty</td>
		      <td width="21%"><input name="txtTotalQty" type="text"  class="txtbox" id="txtTotalQty" style="width:158px" disabled="disabled" value="0" maxlength="20" /></td>
		      <td width="10%">Total Amount </td>
		      <td width="22%"><input name="txtTotalAmount" type="text" class="txtbox" id="txtTotalAmount" style="width:158px" maxlength="20" disabled="disabled" value="0"  /></td>
		      </tr>
          
          
          
          
          
		    <tr>
		      <td width="13%" height="25">Style No </td>
		      <td width="21%"><input name="txtStyle" maxlength="20" type="text" tabindex="1" class="txtbox" id="txtStyle" style="width:158px" /></td>
		      <td width="13%">Buyer Po No </td>
		      <td width="21%"><input name="txtBuyerPO" type="text" tabindex="2" class="txtbox" id="txtBuyerPO" style="width:158px" maxlength="20" /></td>
		      <td width="10%">ISD No / DO </td>
		      <td width="22%"><input name="txtISDNo" type="text" class="txtbox" tabindex="3" id="txtISDNo" style="width:158px" maxlength="20"  /></td>
		      </tr>
		    <tr>
		      <td height="25">HS Code</td>
		      <td><select  id="txtHS" tabindex="4" class="txtbox" name="txtHS" style="width:158px" >
		        <option value=""></option>
		        <?php 
							$sqlcategory="SELECT strCommodityCode, strDescription, strFabric FROM  excommoditycodes GROUP BY strCommodityCode";
							$resultcategory=$db->RunQuery($sqlcategory);							
							while($rowcategory=mysql_fetch_array($resultcategory)) 
							{
							echo "<option value=".$rowcategory['strCommodityCode'].">".$rowcategory['strCommodityCode']."->".$rowcategory['strDescription']."->".$rowcategory['strFabric']."</option>";
															
							}  
						         
                  	?>
		        </select></td>
		      <td>Description</td>
		      <td><input name="txtareaDisc" type="text" tabindex="5" class="txtbox" id="txtareaDisc" style="width:158px" maxlength="200" /></td>
		      <td> Fabrication</td>
		      <td><input name="txtFabric" type="text" tabindex="6" class="txtbox" id="txtFabric"  style="width:158px" maxlength="200" /></td>
		      </tr>
              <tr>
              	<td>Packing List</td>
                <td><select disabled="disabled" name="txtPLno" type="text" id="txtPLno" class="txtbox" style="width:100px" tabindex="15" onchange="getMass()">
                  <option value=""></option>
                  <?php 
							$strpl="select concat(strPLNo,'/',strStyle,'/',strProductCode,'/',strISDno ,' ',strDO)as plno, strPLNo from shipmentplheader order by strPLNo desc";
							$resultpl=$db->RunQuery($strpl);							
							while($rowpl=mysql_fetch_array($resultpl)) 
							{
								echo "<option value=".$rowpl['strPLNo'].">".$rowpl['plno']."</option>";															
							}  
						         
                  ?>
                </select></td>
                
                
                <td>CBM</td>
                <td><input name="txtCBM" tabindex="7" type="text" class="txtbox" id="txtCBM" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="30" /></td>
                <td><input name="txtPL" tabindex="23" type="text" class="txtbox" id="txtPL" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="30" value="" style="visibility:hidden"/></td>
                <td><input name="txtColor" tabindex="23" type="text" class="txtbox" id="txtColor" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="30" value="" style="visibility:hidden"/><input name="txtInv" tabindex="23" type="text" class="txtbox" id="txtInv" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="30" value="" style="visibility:hidden"/></td>
              </tr>
		    <tr>
		      <td height="25">Qty</td>
		      <td nowrap="nowrap"><input name="txtQty"  class="txtbox" id="txtQty" tabindex="8" onkeypress="return CheckforValidDecimal(this.value, 4,event);" style="width:100px;" maxlength="15" onblur="getItemVal();"/>
		        <select name="txtUnit" type="text" tabindex="9" id="txtUnit" class="txtbox" style="width:50px" >
		          <option value=""></option>
		          <?php 
							$sqlunit="SELECT 	strUnit FROM 	units ";
							$resultunit=$db->RunQuery($sqlunit);							
							while($rowunit=mysql_fetch_array($resultunit)) 
							{
							echo "<option value=".$rowunit['strUnit'].">".$rowunit['strUnit']."</option>";
															
							}  
						         
                  ?>
		          </select></td>
		      <td>Price </td>
		      <td nowrap="nowrap"><input name="txtUnitPrice" type="text" class="txtbox" id="txtUnitPrice" onkeypress="return CheckforValidDecimal(this.value, 4,event);" style="width:100px;" maxlength="15"tabindex="10" onblur="getItemVal()"/>
		        <select name="txtQtyUnit" type="text" tabindex="11" id="txtQtyUnit" class="txtbox" style="width:50px" >
		          <option value=""></option>
		          <?php 
							$sqlunit="SELECT 	strUnit FROM 	units ";
							$resultunit=$db->RunQuery($sqlunit);							
							while($rowunit=mysql_fetch_array($resultunit)) 
							{
							echo "<option value=".$rowunit['strUnit'].">".$rowunit['strUnit']."</option>";
															
							}  
						         
                  ?>
		          </select></td>
		      <td>Value</td>
		      <td><input name="txtValue" tabindex="12" class="txtbox" id="txtValue" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onfocus="getItemVal();" style="width:100px;" maxlength="12" /></td>
		      </tr>
		    <tr>
		      <td height="25">Gross Mass</td>
		      <td><input name="txtGross" type="text" class="txtbox" tabindex="13" id="txtGross" onkeypress="return CheckforValidDecimal(this.value, 4,event);" style="width:100px;" maxlength="15" /></td>
		      <td>Net Mass </td>
		      <td><input name="txtNet" type="text" tabindex="14" class="txtbox" id="txtNet" onkeypress="return CheckforValidDecimal(this.value, 4,event);" style="width:100px;"maxlength="15" /></td>
		      <td>No of CTNs</td>
		      <td><input name="txtCtns" type="text" class="txtbox" tabindex="15" id="txtCtns" onkeypress="return CheckforValidDecimal(this.value, 4,event);" style="width:100px;" maxlength="15" /></td>
		      </tr>		    
		    <tr>
		      <td height="25">UOM &amp; Qty 1</td>
		      <td><input name="txtUmoQty1"  class="txtbox" id="txtUmoQty1" tabindex="16" onkeypress="return CheckforValidDecimal(this.value, 4,event);" style="width:100px;" maxlength="10" onfocus="calUOM()" />
		        <select name="cboUmoQty1" type="text" tabindex="17" id="cboUmoQty1" class="txtbox" style="width:50px" >
		          <option value=""></option>
		          <?php 
							$sqlunit="SELECT 	strUnit FROM 	units ";
							$resultunit=$db->RunQuery($sqlunit);							
							while($rowunit=mysql_fetch_array($resultunit)) 
							{
							echo "<option value=".$rowunit['strUnit'].">".$rowunit['strUnit']."</option>";
															
							}  
						         
                  ?>
		          </select></td>
		      <td>UOM &amp; Qty 2</td>
		      <td><input name="txtUmoQty2"  class="txtbox" id="txtUmoQty2" tabindex="18" onkeypress="return CheckforValidDecimal(this.value, 4,event);" style="width:100px;" maxlength="10" />
		        <select name="cboUmoQty2" type="text" tabindex="19" id="cboUmoQty2" class="txtbox" style="width:50px" >
		          <option value=""></option>
		          <?php 
							$sqlunit="SELECT 	strUnit FROM 	units ";
							$resultunit=$db->RunQuery($sqlunit);							
							while($rowunit=mysql_fetch_array($resultunit)) 
							{
							echo "<option value=".$rowunit['strUnit'].">".$rowunit['strUnit']."</option>";
															
							}  
						         
                  ?>
		          </select></td>
		      <td>UOM &amp; Qty3</td>
		      <td><input name="txtUmoQty3"  class="txtbox" id="txtUmoQty3" tabindex="20" onkeypress="return CheckforValidDecimal(this.value, 4,event);" style="width:100px;" maxlength="10" onfocus="calUOM()"/>
		        <select name="cboUmoQty3" type="text" tabindex="21" id="cboUmoQty3" class="txtbox" style="width:50px" >
		          <option value=""></option>
		          <?php 
							$sqlunit="SELECT 	strUnit FROM 	units ";
							$resultunit=$db->RunQuery($sqlunit);							
							while($rowunit=mysql_fetch_array($resultunit)) 
							{
							echo "<option value=".$rowunit['strUnit'].">".$rowunit['strUnit']."</option>";
															
							}  
						         
                  ?>
		          </select></td>
		      </tr>
              <tr>
                <td height="25">Category No </td>
                <td><select  id="cboCategory" tabindex="22" class="txtbox" name="cboCategory" style="width:160px" >
                  <option value=""></option>
                  <?php
              				$sqlunit1 = "SELECT strCatNo FROM quotacat";
							$resultunit1=$db->RunQuery($sqlunit1);							
							while($rowunit1=mysql_fetch_array($resultunit1)) 
							{
								echo "<option value=".$rowunit1['strCatNo'].">".$rowunit1['strCatNo']."</option>";
															
							}
				  ?>  
                </select></td>
                <td>Procedure Code</td>
                <td><input name="txtProcedureCode" type="text" class="txtbox" id="txtProcedureCode" style='text-align:right;width:158px' tabindex="22" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="8" value="3054.950" /></td>
                <td><input name="txtCM" tabindex="23" type="text" class="txtbox" id="txtCM" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="30" value="0" style="visibility:hidden"/></td>
                <td><img src="../../images/addsmall.png" alt="add" width="95" height="24" class="mouseover"  onclick="addToGrid()" /><img src="../../images/new.png" alt="new" name="butNew" style="visibility:hidden" width="96" height="24" class="mouseover"  id="butNew2" onclick=" newDettail();setGenDesc();"/></td>
              </tr>
		   		    </table></td>
          </tr>
		</table>
		</div>
		</td>
        </tr>
		<tr>
        <td height="21" colspan="2" bgcolor="#D6E7F5" class="head1"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="10%">&nbsp;</td>
            <td width="10%">&nbsp;</td>
            <td width="10%">&nbsp;</td>
            <td width="10%"><img src="../../images/save.png" alt="Save" name="Save" width="84" height="24" id="Save" onclick="InsertDetail();" class="mouseover"/></td>
            <td width="10%"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
            <td width="10%"><img src="../../images/print.png" alt="Delete" name="Delete"onclick="printReport();" class="mouseover"/></td>
            <td width="10%"><img src="../../images/addmark.png" alt="addDetails" name="addDetails" onclick="addDetailsToGrid();" class="mouseover"/></td>
            <td width="10%">&nbsp;</td>
            <td width="10%">&nbsp;</td>
            <td width="10%">&nbsp;</td>
          </tr>
        </table></td>
        </tr>
    </table>
	</div>	
      </div>
		</td>
		</tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
      <tr>
        <td height="19" bgcolor="#D6E7F5">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>

</body>
</html>