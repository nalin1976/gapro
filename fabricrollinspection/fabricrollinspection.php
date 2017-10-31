<?php
	session_start();
	include "../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
	//echo $companyId;
	$backwardseperator = "../";	
	$styleNo = $_POST["cboStyleId"];
	//echo $styleNo;
	$scNo = $_POST["cboScNo"];
	//echo $scNo;
	$widthUOM = $_POST["cboWidthUOM"];
	$itemDescription = $_POST["cboDescription"];
	$poNo 	= $_POST["cboPoNo"];
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gapro : Fabric Roll Inspection </title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script type="text/javascript" src="fabricrollinspection.js"></script>
<script type="text/javascript" src="../javascript/script.js"></script>
<script type="text/javascript" src="../javascript/jquery.js"></script>

<script type="text/javascript" src="../js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.9.custom.min.js"></script>

<link href="../js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />


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
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />


<style type="text/css">
<!--
.style1 {color: #FF0000}
#lyrLoading {
	position:absolute;
	left:595px;
	top:443px;
	width:75px;
	height:21px;
	z-index:1;
	background-color: #FFFFFF;
	overflow: hidden;
}
-->
</style>
</head>

<body onload="LoadPoNo();">

<form id="frmmain" name="frmmain" method="post" action="">
  <table width="950" align="center" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF">
    <tr>
      <td height="75" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><table width="100%" height="44" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td height="6" colspan="3"><?php include $backwardseperator ."Header.php"; ?></td>
                </tr>
              <tr>
                <td width="8%" height="7"><span class="head1">Stores : </span></td>
<?php
	$sql_stores="select strMainID,strName from mainstores where intCompanyId='$companyId';";
	$result_stores=$db->RunQuery($sql_stores);
	$row_stores = mysql_fetch_array($result_stores);
	$storesName = $row_stores["strName"];
	$storesID	= $row_stores["strMainID"];
?>
                <td id="storesID" width="84%" class="normalfnt2" title="<?php echo $storesID;?>"><?php echo $storesName;?></td>
                <td width="8%" rowspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td height="18" colspan="2"><table width="100%" border="0">
                    <tr>                     
                      <td width="15%" class="normalfnt">Roll No </td>
                      <td width="15%"><span class="normalfnt">
                        <input name="txtFabricRollSerialNO" type="text" class="txtbox" id="txtFabricRollSerialNO" size="20" />
                      </span></td>
<!--                      <td width="13%"><img src="../images/view.png" alt="view" width="91" height="19" onclick="SearchPopUp();"/></td>-->
					  <td width ="13%"><img src="../images/view.png" onclick="LoadRollPlanPopUp(this);"/></td>	
                      <td width="9%">&nbsp;</td>
                      <td width="13%">&nbsp;</td>
                      <td width="13%" class="normalfnt">&nbsp;</td>
                      <td width="21%">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
            </table>              </td>
          </tr>

          <tr>
            <td><table width="100%" class="bcgl1">
                <tr>
                  <td width="68%"><table width="100%">
                      <tr>
                        <td width="100" class="normalfnt">Year</td>
                        <td><select name="cboYear" class="txtbox" style="width:80px" id="cboYear" onchange="LoadPoNo();">
                          <?php
$sqlyear="select Distinct intYear from purchaseorderheader order by intYear ASC;";
$result_year = $db->RunQuery($sqlyear);
	
	while($row_year = mysql_fetch_array($result_year))
	{
		echo "<option selected=\"selected\" value=\"". $row_year["intYear"] ."\">" . $row_year["intYear"] ."</option>" ;
	}
?>
                        </select></td>
                        <td class="normalfnt" width=""></td>
                        <td>&nbsp;</td>
                        <td width="116" class="normalfnt">&nbsp;</td>
                        <td width="69" class="normalfnt">&nbsp;</td>
                        <td width="251" class="normalfnt">&nbsp;</td>
                      </tr>
                      <tr>
                        <td class="normalfnt"><span class="normalfnt" style="text-align:left;"> PoNo</span></td>
                        <td colspan="3"><label for="ponoLike"></label>
                        <input type="text" name="txtponoLike" id="txtponoLike" onkeypress="autocomplete_item();"/><span><img src="../images/go.png" class="mouseover" onclick="DisplaySelectedItem(); LoadSupplier(); LoadStyle();LoadSc();LoadBuyerPoNo(); LoadDescription(); LoadColor();LoadScToPo();" />
                        <select name="cboPoNo" class="txtbox" style="width:100px" id="cboPoNo" onchange="LoadSupplier(); LoadStyle(); LoadSc();LoadBuyerPoNo(); LoadDescription(); LoadColor(); LoadScToPo();"   >
                        </select>
                        </span></td>
                        <td class="normalfnt">Supplier Batch No</td>
                        <td><span class="normalfnt">
                          <input name="txtSupBatchNo" type="text" class="txtbox" id="txtSupBatchNo" size="9" 
                          onkeyup="nextCompanyBatchNoTextBox(event); validateSpecialCharacters(this.id); AutoType();" onclick="SelectPoNo();"/>
                        </span></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Supplier</td>
                        <td colspan="3"><select name="cboSupplier" class="txtbox" style="width:314px" id="cboSupplier" >
                        </select></td>
                        <td class="normalfnt">Company Batch No</td>
                       
                        <td><input name="txtCompBatchNo" type="text" class="txtbox" id="txtCompBatchNo" size="9" 
                        onkeyup="validateSpecialCharacters(this.id);"  /></td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Style No </td>
                        <td width="170">
                        	<select name="cboStyleId" class="txtbox" style="width:170px" id="cboStyleId" onchange="LoadColor();LoadSc();LoadBuyerPoNo(); LoadDescription();">
                            	<option value="0" selected="selected">Select One</option>
                        	</select>
                        </td>
                        <td width="36" class="normalfnt" align="right">Sc No </td>
                        <td width="170">
                        	<select name="cboScNo" class="txtbox" style="width:100px" id="cboScNo" onchange="LoadStyleToSc();LoadBuyerPoToSc(); LoadDescriptionToSc(); LoadColorToSc();">
                        		<option value="" selected="selected">Select One</option>
                        	</select>
                        </td>
                        <td colspan="3" rowspan="5" class="normalfnt"><table id="tblSub" width="438" border="0" class="bcgl1" bgcolor="#fbf8b3">
                          <tr bgcolor="#fbf8b3">
                            <td width="112">Roll No </td>
                            <td width="10">:</td>
                            <td colspan="4"><input name="txtRollNo" type="text" class="txtbox" id="txtRollNo" size="9" maxlength="10" onkeyup="nextSuppWidthTextBox(event); validateSpecialCharacters(this.id);" /></td>
                            </tr>
                          <tr>
                            <td bgcolor="#fbf8b3">&nbsp;</td>
                            <td bgcolor="#fbf8b3">&nbsp;</td>
                            <td bgcolor="#fbf8b3" width="80">Supplier</td>
                            <td bgcolor="#fbf8b3" width="63">Company</td>
                            <td bgcolor="#fbf8b3" width="103">UOM</td>
                            <td width="47" rowspan="4" align="center" valign="bottom"><input name="add" type="button" value="Add" id="add" onclick="AddDetailsToMainGrid();Clear();" onfocus="nextSuppBatchNoTextBox(event);"/></td>
                          </tr>
                          <tr>
                            <td class="normalfnt" bgcolor="#fbf8b3">R/Width</td>
                            <td>:</td>
                            <td><input name="txtSuppWith" type="text" class="txtbox" id="txtSuppWith" size="9" style="text-align:right" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onkeyup="nextCompWidthTextBox(event); AutoTypeWidth(); "  /></td>
                            <td><input name="txtCompWidth" type="text" class="txtbox" id="txtCompWidth" size="9" style="text-align:right" onkeypress="return CheckforValidDecimal(this.value, 4,event);"  onkeyup="nextWidthUOM(event);"/></td>
                            <td>
                            <select name="cboWidthUOM" class="txtbox" style="width:90px" id="cboWidthUOM" onkeyup="nextSuppLengthTextBox(event);">
                             <option value="YRD" selected="selected">YARD</option>
                              <?php
	
	$SQL = "SELECT strUnit, strTitle FROM units Where intStatus=1 order by strTitle;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		
		echo "<option value=\"". $row["strUnit"] ."\">" . $row["strTitle"] ."</option>" ;
	}
	
	?>
                            </select>
                            </td>
                           </tr>
                          <tr>
                            <td class="normalfnt">R/Length</td>
                            <td>:</td>
                            <td><input name="txtSuppLength" type="text" class="txtbox" id="txtSuppLength" size="9" style="text-align:right" onkeypress="return CheckforValidDecimal(this.value, 4,event);"  onkeyup="nextCompLengthTextBox(event); AutoTypeLength();"/></td>
                            <td><input name="txtCompLength" type="text" class="txtbox" id="txtCompLength" size="9" style="text-align:right" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onkeyup="nextLengthUOM(event);" /></td>
                            <td><select name="cboLengthUOM" class="txtbox" style="width:90px" id="cboLengthUOM" onkeyup="nextSuppWeigthTextBox(event);">
                            	<option value="YRD" selected="selected">YARD</option>
                                                            <?php
	
	$SQL = "SELECT strUnit, strTitle FROM units Where intStatus=1 order by strTitle;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strUnit"] ."\">" . $row["strTitle"] ."</option>" ;
	}
	
	?>
                            </select></td>
                            </tr>
                          <tr>
                            <td class="normalfnt">R/Weight</td>
                            <td>:</td>
                            <td><input name="txtSuppWeight" type="text" class="txtbox" id="txtSuppWeight" size="9" style="text-align:right" onkeypress="return CheckforValidDecimal(this.value, 4,event);"  onkeyup="nextCompWeigthTextBox(event); AutoTypeWeigth();" /></td>
                            <td><input name="txtCompWeight" type="text" class="txtbox" id="txtCompWeight" size="9" style="text-align:right" onkeypress="return CheckforValidDecimal(this.value, 4,event);"  onkeyup="nextWeigthUOM(event);"/></td>
                            <td>
                            <select name="cboWeightUOM" class="txtbox" style="width:90px;" id="cboWeightUOM" onkeyup="nextSpecComments(event);">
                            	<option value="KGS" selected="selected">KILOGRAM</option>
                                                            <?php
	
	$SQL = "SELECT strUnit, strTitle FROM units Where intStatus=1 order by strTitle;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strUnit"] ."\">" . $row["strTitle"] ."</option>" ;
	}
	
	?>
                            </select></td>
                            </tr>
                          <tr bgcolor="#d6e7f5">
                            <td class="normalfnt" bgcolor="#fbf8b3">Special Comments </td>
                            <td bgcolor="#fbf8b3">:</td>
                            <td colspan="4" bgcolor="#fbf8b3">
                            	<input name="txtSpecialComment" type="text" class="txtbox" id="txtSpecialComment" size="50" maxlength="50"  onkeyup="ToAddButton(event);"/>
                            </td>
                            </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Buyer PoNo </td>
                        <td colspan="3">
                        	<select name="cboBuyerPoNo" class="txtbox" style="width:170px" id="cboBuyerPoNo" onchange="LoadDescription();" >
                            	<option value="0" selected="selected">Select One</option>
                            </select>
                        </td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Item Description </td>
                        <td colspan="3">
                        	<select name="cboDescription" class="txtbox" style="width:314px" id="cboDescription" onchange="LoadColor();" >
                            	<option value="0" selected="selected">Select One</option>
                        	</select>
                        </td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Color</td>
                        <td colspan="3">
                        	<select name="cboColor" class="txtbox" style="width:170px" id="cboColor" />
                        		<option value="0" selected="selected">Select One</option>
                        	</select>
                        </td>
                      </tr>
                      <tr>
                        <td valign="middle" class="normalfnt">Remarks</td>
                        <td colspan="3" valign="middle">
                          <input name="txtRemarks" type="text" class="txtbox" id="txtRemarks" size="50" maxlength="100" />                        </td>
                      </tr>
                      
                  </table></td>                  
                </tr>            
            </table></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td height="72" valign="top"><table width="100" cellpadding="0" cellspacing="0">
          <tr>
            <td width="949" height="20" bgcolor="#fbf8b3"><div align="center" class="normaltxtmidb2" style=" color:#800000;">Details</div></td>
            <td width="1" bgcolor="#9BBFDD"><a href="#"></a></td>
          </tr>
          <tr>
            <td colspan="2"><div id="divcons" style="overflow:scroll; height:220px; width:950px;">
              <table width="1300" id="tblMain" bgcolor="#CCCCFF"  cellpadding="0" cellspacing="1">
                <tr bgcolor="#498CC2" height="20">
                  <td width="3%" bgcolor="#fbf8b3" class="normaltxtmidb6">Del</td>
                  <td width="6%" bgcolor="#fbf8b3" class="normaltxtmidb6">Roll No </td>
                  <td width="6%" bgcolor="#fbf8b3" class="normaltxtmidb6">S/Width</td>
                  <td width="8%" bgcolor="#fbf8b3" class="normaltxtmidb6">C/width</td>
                  <td width="7%" bgcolor="#fbf8b3" class="normaltxtmidb6">W/UOM</td>
                  <td width="6%" bgcolor="#fbf8b3" class="normaltxtmidb6"> S/Length </td>
                  <td width="6%" bgcolor="#fbf8b3" class="normaltxtmidb6">C/length </td>
                  <td width="6%" bgcolor="#fbf8b3" class="normaltxtmidb6">L/UOM</td>
                  <td width="6%" bgcolor="#fbf8b3" class="normaltxtmidb6">S/Weight</td>
                  <td width="5%" bgcolor="#fbf8b3" class="normaltxtmidb6">C/Weight</td>
                  <td width="3%" bgcolor="#fbf8b3" class="normaltxtmidb6">W/UOM</td>
                  <td width="19%" bgcolor="#fbf8b3" class="normaltxtmidb6">Special Comments </td>
                </tr>
              </table>
            </div></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td height="1" >&nbsp;</td>
    </tr>

    <tr>
      <td  height="10" bgcolor="" class="bcgl1"><table width="100%">
          <tr>
            <td width="29%"><p align="right"><img src="../images/new.png" alt="new" width="96" height="24" onclick="ClearForm();" class="mouseover"/></p></td>
            <td width="21%"><div align="center" id="imgDiv"><img src="../images/save-confirm.png" id="cmdSave" alt="save_confirm" width="174" height="24" onclick="SaveValidation();" class="mouseover"/></div></td>
            <td width="12%"><a href="#"><img src="../images/report.png" width="108" height="24" border="0" onclick="ViewReport();" class="mouseover"/></a></td>
            <td width="12%"><img src="../images/cancel.jpg" id="cmdCancel" width="104" height="24" alt="cancel" onclick="Cancel();"/></td>
            <td width="26%"><a href="../main.php"><img src="../images/close.png" width="97" height="24" border="0" class="mouseover"/></a></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>

<!--Start - Search popup-->
<!--<div style="left:665px; top:541px; z-index:10; position:absolute; width: 261px; visibility:hidden; height: 61px;" id="NoSearch" >
  <table width="260" height="59" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
		  	<td width="4" height="22" class="normalfnt"></td>
            <td width="44" height="22" class="normalfnt">State </td>
            <td width="108"><select name="select3" class="txtbox" id="cboState" style="width:100px" onchange="LoadPopUpNo();">              
              <option value="1">Saved & Confirmed</option>		  
            </select></td>
            <td width="37" class="normalfnt">Year</td>
            <td width="55"><select name="cboPopupYear" class="txtbox" id="cboPopupYear" style="width:55px" onchange="LoadPopUpNo();">
             
			   <?php
	
	/*$SQL = "SELECT DISTINCT intFRollSerialYear FROM fabricrollheader ORDER BY intFRollSerialYear DESC;";	
	$result = $db->RunQuery($SQL);	
		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["intFRollSerialYear"] ."\">" . $row["intFRollSerialYear"] ."</option>" ;
	}
	*/
	?>
            </select></td>
            <td width="10">&nbsp;</td>
          </tr>
          <tr>
		  <td width="4" height="27" class="normalfnt"></td>
            <td><div align="center" class="normalfnt">Job No</div></td>
            <td><select name="select" class="txtbox" id="cboNo" style="width:100px" onchange="ViewReport();">
			<option value="Select One" selected="selected">Select One</option>
            </select>            </td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
        
  </table>
		

</div>-->
<!--End - Search popup-->
<!--Start - Unit Conversion-->
<div style="left:367px; top:113px; z-index:15; position:absolute; width: 241px; visibility:hidden; height: 300px; border:120px; border-color:#000000;" id="divRollPlanPopUp">
<table width="360" height="188" border="0" cellpadding="0" cellspacing="0" class="normalfnt" >

<tr>
<td colspan="20">
    <tr bgcolor="#ccff33" class="normalfntMid" height="15"><td  colspan="7" bgcolor="#99CCFF" ><strong>Fabric Roll Plan Search</strong></td>
      <td align="right" bgcolor="#99CCFF" ><img src="../images/cross.png" class="mouseover" onclick="closePOP();" /></td>
    </tr>
 
    <tr class="normalfnt">
    	<td align="left" width="75">&nbsp;&nbsp;Mode</td>
        <td>
        	<select name="cboMode" class="txtbox" id="cboMode" style="width:90px" onchange="LoadSupplierToMode('<?php echo $companyId; ?>'); LoadSuppBatchNo('<?php echo $companyId; ?>'); LoadRollNoToMode('<?php echo $companyId; ?>');">
              <option value="0">Select One</option>	
			  <option  value="1">Saved</option>
			  <option   value="10">Cancelled</option>  
            </select>
        </td>
       
    </tr>
    		
		<tr class="normalfnt">		
	    <td width="75" align="left">&nbsp;&nbsp;Supplier  </td>

	    <td colspan="5">
        	<select name="cboPopUpSupplier" class="txtbox"  style="width:220px"  id="cboPopUpSupplier" onchange="LoadSuppBatchNo('<?php echo $companyId; ?>'); LoadRollNoToMode('<?php echo $companyId; ?>');" >
        			
            <option value="0">Select One</option>                                                                                                       
        </select>	      &nbsp;</td>
	     <td colspan="4">&nbsp;</td>
    </tr>
    
	<tr class="normalfnt" >
	 	
	    <td  align="left" width="75">&nbsp; Supp Batch </td>
	    <td width="105" >
       	  <select name="cboPopUpSupplierBatchNo" class="txtbox" style="width:90px"  id="cboPopUpSupplierBatchNo" onchange="LoadRollNoToMode('<?php echo $companyId; ?>');">
            
			<?php 
				/*$sql	="";
				$sql ="select distinct strSupplierBatchNo from fabricrollheader where intStatus=1 AND intCompanyID='$companyId' Order By   		 		  		   			   intFRollSerialYear,intFRollSerialNO DESC;";
				$result=$db->RunQuery($sql);
				
				echo   "<option value=\"".""."\">".""."</option>\n";
				while($row=mysql_fetch_array($result))
				{
					echo   "<option value=\"".$row["strSupplierBatchNo"]."\">".$row["strSupplierBatchNo"]."</option>\n";
				}*/
			?>
            </select>
      </td>
         
	 <td width="46" >&nbsp;Roll NO </td>	
	 <td width="9">&nbsp;</td>
      
     <td width="3" ></td>
     <td width="100"><select name="cboPopUpRollNo" class="txtbox"  style="width:100px"  id="cboPopUpRollNo" onchange="LoadDetailToMainPage()">
       <?php 
				/*$sql	="";//where intStatus=1
				$sql ="select distinct concat(intFRollSerialYear,'/',intFRollSerialNO)As rollNo from fabricrollheader intCompanyID='$companyId' 	 						Order By intFRollSerialYear,intFRollSerialNO DESC;";
				$result=$db->RunQuery($sql);
				
				echo   "<option value=\"".""."\">".""."</option>\n";
				
				while($row=mysql_fetch_array($result))
				{
					echo   "<option value=\"".$row["rollNo"]."\">".$row["rollNo"]."</option>\n";
				}*/
			?>
     </select></td>
	</tr>
    	
	<tr class="normalfnt">     
	 <td  colspan="7" align="center" width="94"><img src="../images/search.png" onclick ="LoadDetailToMainPage()" class="mouseover"> </td>
	</tr>   
	     
</table>
</div>
<!--End - Unit Conversion-->
</html>