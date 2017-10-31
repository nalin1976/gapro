<?php
 session_start();
 $backwardseperator = "../../../";
 $chkDate = $_POST["chkDate"];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Stock Balance - Style Items</title>

<script src="../../../javascript/script.js" language="javascript" type="text/javascript"></script>
<script src="stockbalance.js" type="text/javascript"></script>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../../javascript/calendar/theme.css" rel="stylesheet" type="text/css" />
<script src="../../../javascript/calendar/calendar.js" language="javascript" type="text/javascript"></script>
<script src="../../../javascript/calendar/calendar-en.js" language="javascript" type="text/javascript"></script>
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
function viewReport()
{
	//var url = 	document.getElementById("tagA").name;
	var x = '';
	if(document.getElementById("rdoAll").checked)
		x = 'all';
	else if(document.getElementById("rdoRunning").checked)
		x = 'running';
	else if(document.getElementById("rdoLeftOvers").checked)
		x = 'leftOvers';
	else if(document.getElementById("rbBulk").checked)
		x = 'bulk';	
	
	
	var reportType = document.getElementById("cboReportType").value;
	if(reportType == 'rdoSumRpt')
	{
		var dfrom =document.getElementById('txtDfrom').value;
		var dTo = document.getElementById('txtDto').value ;
		var checkDate 	= document.getElementById("chkDate").checked;
		if(checkDate)
		{
			if(dfrom == '')
			{
				alert("Please select 'Date From' ");
				document.getElementById('txtDfrom').focus();
				return false;
			}
			if(dTo == '')
			{
				alert("Please select 'Date To' ");
				document.getElementById('txtDto').focus();
				return false;
			}
		}
		url = 'styleSummeryReport.php?';
		url	+=	'x='+x;
		
		url	+=	'&with0='+document.getElementById("rdoWith").checked;
		url += '&dfrom='+URLEncode(dfrom);
		url += '&dTo='+URLEncode(dTo);
		url += '&checkDate='+checkDate;
	}
	
	if(reportType == 'rdoStyleWise')
		url = 'stylewisereport.php?';
	if(reportType == 'rdoMatWise')
		url = 'itemStockBalReport.php?';
	if(reportType == 'rbSubcat')
	{
		url = 'subcategoryRpt.php?';
		var dfrom =document.getElementById('txtDfrom').value;
		var dTo = document.getElementById('txtDto').value ;
		var checkDate 	= document.getElementById("chkDate").checked;
		url += '&dfrom='+URLEncode(dfrom);
		url += '&dTo='+URLEncode(dTo);
		url += '&checkDate='+checkDate;
	}
		
	if(reportType == 'rbBulk')
	{
		url = 'bulkMerchandiserReport.php?';
		url += '&Merchandiser='+document.getElementById("cboMerchandiser").value;
	}				
	url	+=	'&x='+x;	
	if(document.getElementById("cboMainStores").value!='')
		url	+=	'&mainStores='+document.getElementById("cboMainStores").value;
		
	if(document.getElementById("cboMainCat").value!='')
		url	+=	'&mainId='+document.getElementById("cboMainCat").value;
	
	if(document.getElementById("cboSubCat").value!='')
		url	+=	'&subId='+document.getElementById("cboSubCat").value;
	
	if(document.getElementById("cboMatItem").value!='')
		url	+=	'&maiItem='+document.getElementById("cboMatItem").value;
	
	if(document.getElementById("cboColor").value!='')
		url	+=	'&color='+URLEncode(document.getElementById("cboColor").value);
	
	if(document.getElementById("cboSize").value!='')
		url	+=	'&size='+URLEncode(document.getElementById("cboSize").value);
		
	if(document.getElementById("cboStyle").value!='')
		url	+=	'&style='+document.getElementById("cboStyle").value;
		
	if(document.getElementById("txtMatItem").value!='')
		url	+=	'&txtmatItem='+URLEncode(document.getElementById("txtMatItem").value);
	
	if(document.getElementById("cboStyleNo").value!='')
		url	+=	'&StyleNo='+URLEncode(document.getElementById("cboStyleNo").value);	
	if(document.getElementById("cboOrderType").value!='')
		url	+=	'&OrderType='+URLEncode(document.getElementById("cboOrderType").value);		
	url	+=	'&with0='+document.getElementById("rdoWith").checked;
	var withLeftVal='';
	if(document.getElementById("rbwithLeftval").checked)
		withLeftVal = true;
	else
		withLeftVal = false;	
	url += '&withLeftVal='+withLeftVal;
	
window.open(url);
	//document.getElementById("tagA").href = url;
}
	
function GetStyleId(obj)
{
	document.getElementById('cboStyle').value = obj.value;
	LoadColor(obj.value);
	LoadSize(obj.value);
}

function GetScNo(obj)
{
	document.getElementById('cboSc').value = obj.value;
	LoadColor(obj.value);
	LoadSize(obj.value);
}

/*function ShowExcelReport()
{
	//var url = 	document.getElementById("tagA").name;
	var x = '';
	if(document.getElementById("rdoAll").checked)
		x = 'all';
	else if(document.getElementById("rdoRunning").checked)
		x = 'running';
	else if(document.getElementById("rdoLeftOvers").checked)
		x = 'leftOvers';
	else if(document.getElementById("rbBulk").checked)
		x = 'bulk';	
	
	
	var reportType = document.getElementById("cboReportType").value;
	if(reportType == 'rdoSumRpt')
	{
		var dfrom =document.getElementById('txtDfrom').value;
		var dTo = document.getElementById('txtDto').value ;
		var checkDate 	= document.getElementById("chkDate").checked;
		if(checkDate)
		{
			if(dfrom == '')
			{
				alert("Please select 'Date From' ");
				document.getElementById('txtDfrom').focus();
				return false;
			}
			if(dTo == '')
			{
				alert("Please select 'Date To' ");
				document.getElementById('txtDto').focus();
				return false;
			}
		}
		url = 'stylesummeryxclrpt.php?';
		url	+=	'x='+x;
		
		url	+=	'&with0='+document.getElementById("rdoWith").checked;
		url += '&dfrom='+URLEncode(dfrom);
		url += '&dTo='+URLEncode(dTo);
		url += '&checkDate='+checkDate;
	}
	
	if(reportType == 'rdoStyleWise')
		url = 'stylewisexclrpt.php?';
	if(reportType == 'rdoMatWise')
		url = 'xlsitemwise.php?';
	if(reportType == 'rbSubcat')
		url = 'xlsSubCategory.php?';			
	url	+=	'&x='+x;	
	if(document.getElementById("cboMainStores").value!='')
		url	+=	'&mainStores='+document.getElementById("cboMainStores").value;
		
	if(document.getElementById("cboMainCat").value!='')
		url	+=	'&mainId='+document.getElementById("cboMainCat").value;
	
	if(document.getElementById("cboSubCat").value!='')
		url	+=	'&subId='+document.getElementById("cboSubCat").value;
	
	if(document.getElementById("cboMatItem").value!='')
		url	+=	'&maiItem='+document.getElementById("cboMatItem").value;
	
	if(document.getElementById("cboColor").value!='')
		url	+=	'&color='+URLEncode(document.getElementById("cboColor").value);
	
	if(document.getElementById("cboSize").value!='')
		url	+=	'&size='+URLEncode(document.getElementById("cboSize").value);
		
	if(document.getElementById("cboStyle").value!='')
		url	+=	'&style='+document.getElementById("cboStyle").value;
		
	if(document.getElementById("txtMatItem").value!='')
		url	+=	'&txtmatItem='+URLEncode(document.getElementById("txtMatItem").value);
	
	if(document.getElementById("cboStyleNo").value!='')
		url	+=	'&StyleNo='+URLEncode(document.getElementById("cboStyleNo").value);	
	if(document.getElementById("cboOrderType").value!='')
		url	+=	'&OrderType='+URLEncode(document.getElementById("cboOrderType").value);		
	url	+=	'&with0='+document.getElementById("rdoWith").checked;
	var withLeftVal='';
	if(document.getElementById("rbwithLeftval").checked)
		withLeftVal = true;
	else
		withLeftVal = false;	
	url += '&withLeftVal='+withLeftVal;
window.open(url);
}
*/	
function ShowExcelReport(){
	
	var url = '';//	document.getElementById("tagA").name;
	var x = '';
	if(document.getElementById("rdoAll").checked)
		x = 'all';
	else if(document.getElementById("rdoRunning").checked)
		x = 'running';
	else if(document.getElementById("rdoLeftOvers").checked)
		x = 'leftOvers';
	else if(document.getElementById("rbBulk").checked)
		x = 'bulk';	
	
	var reportType = document.getElementById("cboReportType").value;
	if(reportType == 'rdoSumRpt')
	{
		var dfrom =document.getElementById('txtDfrom').value;
		var dTo = document.getElementById('txtDto').value ;
		var checkDate 	= document.getElementById("chkDate").checked;
		if(checkDate)
		{
			if(dfrom == '')
			{
				alert("Please select 'Date From' ");
				document.getElementById('txtDfrom').focus();
				return false;
			}
			if(dTo == '')
			{
				alert("Please select 'Date To' ");
				document.getElementById('txtDto').focus();
				return false;
			}
		}
		url = 'stylesummeryxclrpt.php?';
		url	+=	'x='+x;
		
		url	+=	'&with0='+document.getElementById("rdoWith").checked;
		url += '&dfrom='+URLEncode(dfrom);
		url += '&dTo='+URLEncode(dTo);
		url += '&checkDate='+checkDate;
	}
	
	//if(reportType == 'rdoStyleWise')
	//	url = 'stylewisexclrpt.php?';
	if(reportType == 'rdoMatWise')
		url = 'toexcel.php?';
	//if(reportType == 'rbSubcat')
	//	url = 'xlsSubCategory.php?';			
	url	+=	'&x='+x;	
	if(document.getElementById("cboMainStores").value!='')
		url	+=	'&mainStores='+document.getElementById("cboMainStores").value;
		
	if(document.getElementById("cboMainCat").value!='')
		url	+=	'&mainId='+document.getElementById("cboMainCat").value;
	
	if(document.getElementById("cboSubCat").value!='')
		url	+=	'&subId='+document.getElementById("cboSubCat").value;
	
	if(document.getElementById("cboMatItem").value!='')
		url	+=	'&maiItem='+document.getElementById("cboMatItem").value;
	
	if(document.getElementById("cboColor").value!='')
		url	+=	'&color='+URLEncode(document.getElementById("cboColor").value);
	
	if(document.getElementById("cboSize").value!='')
		url	+=	'&size='+URLEncode(document.getElementById("cboSize").value);
		
	if(document.getElementById("cboStyle").value!='')
		url	+=	'&style='+document.getElementById("cboStyle").value;
		
	if(document.getElementById("txtMatItem").value!='')
		url	+=	'&txtmatItem='+URLEncode(document.getElementById("txtMatItem").value);
	
	if(document.getElementById("cboStyleNo").value!='')
		url	+=	'&StyleNo='+URLEncode(document.getElementById("cboStyleNo").value);	
	if(document.getElementById("cboOrderType").value!='')
		url	+=	'&OrderType='+URLEncode(document.getElementById("cboOrderType").value);		
	url	+=	'&with0='+document.getElementById("rdoWith").checked;
	var withLeftVal='';
	if(document.getElementById("rbwithLeftval").checked)
		withLeftVal = true;
	else
		withLeftVal = false;	
	url += '&withLeftVal='+withLeftVal;
//alert(url);	
window.open(url);
	
	
}

</script>
</head>

<body>
<!--<form id="frmBalance" name="frmBalance" >-->
<?php
include "../../../Connector.php";
?>
  <tr>
    <td><?php include '../../../Header.php'; ?></td>
  </tr>

<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="100%" border="0" class="bcgl1">
          <tr>
            <td height="25" class="mainHeading">Stock Balance </td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td colspan="2" class="normalfnt">&nbsp;</td>
                  <td width="72%">&nbsp;</td>
                </tr>
                <tr>
                 <!-- <td width="20%" class="normalfnt">&nbsp;</td>-->
                  <td colspan="3"  align="center"><table width="90%" border="0" cellpadding="0" cellspacing="0" class="normalfnt">
                    <tr>
                      <td width="8%">
					  <?php 
					  	$y		= $_POST["A"];
					  ?>
					  <input <?php
					  	if($y=='all' || $y=='')
							echo 'checked="checked"';
							
					   ?> name="A" type="radio" value="all" id="rdoAll" onchange="GetStyleAndSc(0)"/></td>
                      <td width="16%">All</td>
                      <td width="7%"><input <?php
					  	if($y=='running')
							echo 'checked="checked"';
							
					   ?>name="A" type="radio" value="running" id="rdoRunning" onchange="GetStyleAndSc(11)"/></td>
                      <td width="23%">Running</td>
                      <td width="6%"><input <?php
					  	if($y=='leftOvers')
							echo 'checked="checked"';
							
					   ?> name="A" type="radio" value="leftOvers" id="rdoLeftOvers" onchange="GetStyleAndSc(13)"/></td>
                      <td width="25%">Left Overs </td>
                      <td width="6%"><input type="radio" name="A" id="rbBulk" value="Bulk" onchange="getReportType('bulk');" /></td>
                      <td width="9%">Bulk</td>
                    </tr>
                  </table></td>
                  </tr>
                <tr>
                  <td colspan="2" class="normalfnt">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="3" class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td width="7%" class="normalfnt">&nbsp;</td>
                      <td width="24%" class="normalfnt">Main Category </td>
                      <td width="69%"><select name="cboMainCat" class="txtbox" id="cboMainCat" style="width:285px" onchange="LoadSubCategory(this)">
                        <?php
						$intMainCat = $_POST["cboMainCat"];
							
						$SQL = 	"SELECT matmaincategory.intID, matmaincategory.strDescription FROM matmaincategory ";
						$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
							if($intMainCat==$row["intID"])
								echo "<option selected=\"selected\" value=\"". $row["intID"] ."\">" . trim($row["strDescription"]) ."</option>" ;								
							else
								echo "<option value=\"". $row["intID"] ."\">" . trim($row["strDescription"]) ."</option>" ;
						}
						
						?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Sub Category </td>
                      <td><select name="cboSubCat" class="txtbox" id="cboSubCat" style="width:285px" onchange="LoadMaterial()">
                        <?php
						$intSubCatNo = $_POST["cboSubCat"];
							
						$SQL = 	"SELECT MSC.intSubCatNo, MSC.StrCatName FROM matsubcategory  MSC
								WHERE MSC.intCatNo <>'' ";
								
						if($intMainCat!='')
							$SQL .= " AND MSC.intCatNo =  '$intMainCat'";
							
						$SQL .= " order by MSC.StrCatName ";
						
						$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
						if($intSubCatNo==$row["intSubCatNo"])
							echo "<option selected=\"selected\" value=\"". $row["intSubCatNo"] ."\">" . trim($row["StrCatName"]) ."</option>" ;								
						else
							echo "<option value=\"". $row["intSubCatNo"] ."\">" . trim($row["StrCatName"]) ."</option>" ;
						}
						
						?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Material Like</td>
                      <td><input type="text" name="txtMatItem" id="txtMatItem" style="width:284px;" onKeyPress="EnterSubmitLoadItem(event);" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Material</td>
                      <td><select name="cboMatItem" class="txtbox" id="cboMatItem" style="width:285px">
                    <?php
					$intMatItem = $_POST["cboMatItem"];
						
					$SQL = 	"SELECT MIL.intItemSerial, MIL.strItemDescription 
							FROM matitemlist MIL WHERE MIL.intMainCatID =  '$intMainCat' AND MIL.intSubCatID =  '$intSubCatNo ";		
					
					$SQL .= " Order By strItemDescription";
					$result = $db->RunQuery($SQL);
					echo "<option value=\"". "" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
					if($intMatItem==$row["intItemSerial"])
						echo "<option selected=\"selected\" value=\"". $row["intItemSerial"] ."\">" . trim($row["strItemDescription"]) ."</option>" ;								
					else
						echo "<option value=\"". $row["intItemSerial"] ."\">" . trim($row["strItemDescription"]) ."</option>" ;
					}
						
					?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Color</td>
                      <td><select name="cboColor" class="txtbox" id="cboColor" style="width:285px" >
                    <?php
					$strColor = $_POST["cboColor"];
						
					$SQL = 	"SELECT distinct strColor FROM colors order by strColor";
					$result = $db->RunQuery($SQL);
					echo "<option value=\"". "" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
					if($strColor==$row["strColor"])
						echo "<option selected=\"selected\" value=\"". $row["strColor"] ."\">" . trim($row["strColor"]) ."</option>" ;								
					else
						echo "<option value=\"". $row["strColor"] ."\">" . trim($row["strColor"]) ."</option>" ;
					}
						
					?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Size</td>
                      <td><select name="cboSize" class="txtbox" id="cboSize" style="width:285px" >
						<?php
						$strSize = $_POST["cboSize"];
							
						$SQL = 	"SELECT distinct strSize FROM sizes order by strSize";
						$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
						if($strSize==$row["strSize"])
							echo "<option selected=\"selected\" value=\"". $row["strSize"] ."\">" . trim($row["strSize"]) ."</option>" ;								
						else
							echo "<option value=\"". $row["strSize"] ."\">" . trim($row["strSize"]) ."</option>" ;
						}
							
						?>
						  </select></td>
                      </tr>
                      <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Style No</td>
                      <td><select name="cboStyleNo" class="txtbox" id="cboStyleNo" style="width:285px" onchange="loadStylewiseOrderNo();" >
						<?php
						//works only for style wise report
						$StyleNo = $_POST["cboStyleNo"];
							
						$SQL = 	"select distinct O.strStyle from orders O
inner join specification S on O.intStyleId=S.intStyleId Order By strStyle";

						$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
						if($StyleNo==$row["strStyle"])
							echo "<option selected=\"selected\" value=\"". $row["strStyle"] ."\">" . trim($row["strStyle"]) ."</option>" ;								
						else
							echo "<option value=\"". $row["strStyle"] ."\">" . trim($row["strStyle"]) ."</option>" ;
						}
							
						?>
						  </select></td>
                      </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Order No </td>
                      <td><select name="cboStyle" class="txtbox" id="cboStyle" style="width:180px" onchange="GetScNo(this)" >
                        <?php
						$strStyleId = $_POST["cboStyle"];
							
						$SQL = 	"select O.intStyleId,O.strOrderNo from orders O
inner join specification S on O.intStyleId=S.intStyleId Order By strOrderNo";

						$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
						if($strStyleId==$row["intStyleId"])
							echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . trim($row["strOrderNo"]) ."</option>" ;								
						else
							echo "<option value=\"". $row["intStyleId"] ."\">" . trim($row["strOrderNo"]) ."</option>" ;
						}
							
						?>
                      </select>
                        <select name="cboSc" class="txtbox" id="cboSc" style="width:100px" onchange="GetStyleId(this)" >
                          <?php
						$ScNo = $_POST["cboSc"];
							
						$SQL = 	"select O.intStyleId,intSRNO from orders O
inner join specification S on O.intStyleId=S.intStyleId Order By intSRNO DESC";
						$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
						if($ScNo==$row["intStyleId"])
							echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . trim($row["intSRNO"]) ."</option>" ;								
						else
							echo "<option value=\"". $row["intStyleId"] ."\">" . trim($row["intSRNO"]) ."</option>" ;
						}
							
						?>
                        </select></td>
                      </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Stores</td>
                      <td><select name="cboMainStores" class="txtbox" id="cboMainStores" style="width:285px">
						<?php
						$intMainStores = $_POST["cboMainStores"];
							
						$SQL = 	"SELECT mainstores.strMainID, mainstores.strName FROM mainstores";
						$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
						if($intMainStores==$row["strMainID"])
							echo "<option selected=\"selected\" value=\"". $row["strMainID"] ."\">" . trim($row["strName"]) ."</option>" ;								
						else
							echo "<option value=\"". $row["strMainID"] ."\">" . trim($row["strName"]) ."</option>" ;
						}
							
						?>
						  </select></td>
                    </tr>
                    <tr>
                    	<td class="normalfntRite"><input type="checkbox" name="chkDate" id="chkDate" <?php if($chkDate == 'on') {?> checked="checked" <?php }?> onclick="DateDisable(this)"/></td>
                        <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="26%">Date From</td>
                            <td width="19%"><input type="text" name="txtDfrom " id="txtDfrom" style="width:90px;" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  onKeyDown="" disabled="disabled" /><input type="text" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
                            <td width="18%">Date To</td>
                            <td width="37%"><input type="text" name="txtDto" id="txtDto" style="width:90px;" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  disabled="disabled" /><input type="text" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
                          </tr>
                         
                        </table></td>
                        </tr>
                        <tr>
                        <td>&nbsp;</td>
                        <td>Report Type</td>
                        <td><select name="cboReportType" id="cboReportType" style="width:285px;">
                       <?php 
					   $sqlReport_bulk = "select strValue from settings where strKey='BulkReportId' ";
					   $resultReport_bulk = $db->RunQuery($sqlReport_bulk);
					   $rowB = mysql_fetch_array($resultReport_bulk);
					   $bulkReportId =  $rowB["strValue"];
					   
					   $sql = "select strReportCode,strReportType from reporttype where intReportId not in ($bulkReportId) ";
					  $result = $db->RunQuery($sql); 
					  while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"". $row["strReportCode"] ."\">" . trim($row["strReportType"]) ."</option>"; 
						}
					   ?>
                        </select>
                        </td>
                        </tr>
                          <tr>
                        <td>&nbsp;</td>
                        <td>Order Type</td>
                        <td><select name="cboOrderType" id="cboOrderType" style="width:285px;">
                        <?php 
						 $sql = " select intTypeId,strTypeName from orders_ordertype where intStatus=1  ";
					  $result = $db->RunQuery($sql); 
					  while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"". $row["intTypeId"] ."\">" . trim($row["strTypeName"]) ."</option>"; 
						}
						?>
                        </select>
                        </td>
                        </tr> 
                        <tr><td colspan="3"> <div style="display:none" id="viewMerchand">
                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="7%" class="normalfnt"></td>
    <td width="24%">Merchandiser</td>
    <td width="69%"><select name="cboMerchandiser" id="cboMerchandiser" style="width:285px;">
                          <option value=""></option>
            <?php 
			$SQL = "SELECT useraccounts.Name, useraccounts.intUserID FROM useraccounts INNER JOIN userpermission ON useraccounts.intUserID = userpermission.intUserID INNER JOIN role ON userpermission.RoleID = role.RoleID WHERE role.RoleName = 'Merchandising' order by useraccounts.Name"; 

	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intUserID"] ."\">" . $row["Name"]  ."</option>" ;
	}
			?>
                         </select></td>
  </tr>
</table></div>

                        </td></tr> 
                      
                          
                    <tr>
                      <td colspan="2" class="normalfnt">&nbsp;</td>
                      <td>&nbsp;<span id="txtHint" style="color:#FF0000"></span></td>
                    </tr>
                    <tr>
                      <td colspan="3" class="normalfnt"><table width="100%" border="0" cellspacing="1" cellpadding="0">
                        <tr>
                         <td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="1">
                           <tr>
                             <td width="8%">&nbsp;</td>
                             <td width="4%"><input name="rdoB" type="radio" id="rdoWith" value="with" <?php 
						  	if($x=='with')
								echo 'checked="checked"';
						   ?> /></td>
                             <td width="23%">With <strong>0</strong> Balance</td>
                             <td width="3%">&nbsp;</td>
                             <td width="8%">&nbsp;</td>
                             <td width="5%"><input <?php 
						  	if($x!='with')
								echo 'checked="checked"';
						   ?> name="rdoB" type="radio" value="without" id="rdoWithout" /></td>
                             <td width="49%">Without <strong>0</strong> Balance </td>
                           </tr>
                           <tr>
                            <td>&nbsp;</td>
                            <td><input type="radio" name="radio" id="rbwithLeftval" value="rbwithLeftval" /></td>
                            <td>With Leftover Value</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td><input type="radio" name="radio" id="rbwithoutLeftval" value="rbwithoutLeftval" checked="checked" /></td>
                            <td>Without Leftover Value</td>
                           </tr>
                         </table></td>
                          </tr>
                      </table></td>
                      </tr>
                    <tr>
                      <td colspan="2" class="normalfnt">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </table></td>
                  </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor="#FFE1E1"><table width="100%" border="0">
                    <tr>
                      <td width="25%" align="center">                     
                      <img src="../../../images/new.png" alt="new" onclick="ClearForm();"/>
                    <!--  <a id="tagA" name="report.php" target="_blank">-->
             <img src="../../../images/report.png" alt="Report" name="Delete"  border="0" class="mouseover" onclick="viewReport();"/>
           <!--  </a>-->
             <img src="../../../images/download.png"  border="0" onclick="ShowExcelReport();" />
                      
                      <a href="../../../main.php"><img src="../../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0"/></a>
                      </td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="19%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<script type="text/javascript">
function ClearForm(){	
	setTimeout("location.reload(true);",0);
	//$("#frmBalance")[0].reset();
}
function DateDisable(obj)
{
	if(obj.checked){
		document.getElementById('txtDfrom').disabled=false;
		document.getElementById('txtDto').disabled=false;
	}
	else{
		document.getElementById('txtDfrom').disabled=true;
		document.getElementById('txtDto').disabled=true;
		document.getElementById('txtDfrom').value='';
		document.getElementById('txtDto').value='';
	}
}
</script>
<!--</form>-->
</body>
</html>
