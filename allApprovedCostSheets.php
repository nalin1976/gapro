<?php
 session_start();
include "authentication.inc";
 
$factory 		= $_POST["cboFactory"];
$buyer 			= $_POST["cboCustomer"];
$styleID 		= $_POST["cboStyles"];
$orderid		= $_POST["cboOrderNo"];
$like_order		= $_POST["cboOrderNo"];
$srNo 			= $_POST["cboSR"];
$fromDate 		= $_POST["txtFrmDate"];
$styleNo		= $_POST["txtStyleNo"];
$orderNo		= $_POST["txtOrderNo"];
if($fromDate!=""){
	$date_frm_date_array=explode("/",$fromDate);
	$fromDate=$date_frm_date_array[2]."-".$date_frm_date_array[1]."-".$date_frm_date_array[0];
}

$toDate = $_POST["txtToDate"];
if($toDate!=""){
	$date_to_date_array=explode("/",$toDate);	
	$toDate=$date_to_date_array[2]."-".$date_to_date_array[1]."-".$date_to_date_array[0];
}
if ($factory != "")
{
	$styleID = "";
	$srNo = "";
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro Web - All Approved Cost Sheets</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="javascript/calendar/theme.css" />
<script src="javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script type="text/javascript" src="javascript/aprovedPreoder.js"></script>
<script type="text/javascript" src="javascript/script.js"></script>
<script type="text/javascript" src="javascript/bom.js"></script>
<script type="text/javascript">

var index = 0;
var styles =new Array();
var message = "Following Style Numbers has been updated as completed.\n\n";

function resetCompanyBuyer()
{
	document.getElementById("cboFactory").value = "";
	document.getElementById("cboCustomer").value = "";
}

function dateArrange()
{
	
	if(document.getElementById("frmDateCheck").checked==false){
	document.getElementById("txtToDate").value="";
	document.getElementById("txtToDate").disabled=true;
	document.getElementById("txtFrmDate").value="";
	document.getElementById("txtFrmDate").disabled=true;
	}
	else{
	document.getElementById("txtToDate").disabled=false;
	document.getElementById("txtFrmDate").disabled=false;
	
	}
}

function submitForm()
{
	document.frmcomplete.submit();
}

function pickDate(obj)
{
	alert(obj);
}

function GetScNo(obj)
{
	document.getElementById('cboSR').value = obj.value;
}

function GetOrderNo(obj)
{
	document.getElementById('cboOrderNo').value = obj.value;
}
function GetStyleWiseOrderNo(obj)
{	
	var status = "11,13";
	var booUser	= false;
	var url = "Reports/orderreport/orderreportxml.php?RequestType=GetStyleWiseOrderNoInReports&styleNo=" +obj+ '&status='+status+ '&booUser=' +booUser;
	htmlobj=$.ajax({url:url,async:false});	
	document.getElementById('cboOrderNo').innerHTML  = htmlobj.responseText;
}
function GetStyleWiseOrderNo(obj)
{	
	var status = "11,13";
	var booUser	= false;
	var url = "Reports/orderreport/orderreportxml.php?RequestType=GetStyleWiseOrderNoInReports&styleNo=" +obj+ '&status='+status+ '&booUser=' +booUser;
	htmlobj=$.ajax({url:url,async:false});	
	document.getElementById('cboOrderNo').innerHTML  = htmlobj.responseText;
}
function GetScWiceStyleNo()
{	
	var obj = document.getElementById('cboSR').value;
	var status = "11,13";
	var booUser	= false;
	var url = "Reports/orderreport/orderreportxml.php?RequestType=GetScWiceStylenoinReports&styleNo=" +obj+ '&status='+status+ '&booUser=' +booUser;
	htmlobj=$.ajax({url:url,async:false});	
        
	document.getElementById('cboStyles').innerHTML  = htmlobj.responseText;
}
</script>
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
</head>

<body>
<form id="frmcomplete" name="frmcomplete" method="post" action="allApprovedCostSheets.php">
    <tr>
      <td><?php include 'Header.php'; ?></td>
    </tr>
  <table width="950" border="0" align="center" class="tableBorder" cellpadding="0" cellspacing="0">

    <tr>
      <td><table width="100%" border="0" cellpadding="0" cellspacing="1">
        <tr>
          <td width="100%" class="mainHeading" height="25">All Approved Cost Sheets</td>
        </tr>
        <tr>
          <td><table width="100%" border="0" class="normalfnt" cellpadding="0" cellspacing="0">
            <!--DWLayoutTable-->
            <tr>
              <td ><table width="100%" border="0" class="tableBorder" cellpadding="0" cellspacing="1">
                
                <tr>
                  <td width="86" >Factory</td>
                  <td width="165"  ><select name="cboFactory" class="txtbox" id="cboFactory" style="width:150px" tabindex="1">
                    <option value="" selected="selected">Select One</option>
                    <?php
					
$xml = simplexml_load_file('config.xml');
$reportname = $xml->PreOrder->ReportName;

	include "Connector.php"; 
	$SQL = "SELECT intCompanyID,strName FROM companies c where intStatus='1';";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
		if ($factory == $row["intCompanyID"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
		}
		else
		{
			echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
		}
	}
	
	?>
                  </select></td>
                  <td width="100"  >SC No</td>
                  <td width="194" ><select name="cboSR" class="txtbox" style="width:150px" tabindex="4" id="cboSR" onchange="GetScWiceStyleNo();resetCompanyBuyer();">
                    <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select O.intStyleId,S.intSRNO from specification S inner join orders O on S.intStyleId = O.intStyleId AND O.intStatus in ( 11, 13) ";
	
	/*if($styleID!="")
		$SQL .= "and O.strStyle='$styleID' ";*/
		
	$SQL .= "order by S.intSRNO desc;";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		if ($srNo==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  <td width="118" >Style No </td>
                  <td width="182"  ><select name="cboStyles" class="txtbox" style="width:150px" id="cboStyles" onchange="resetCompanyBuyer();" tabindex="3">
                    <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select distinct O.strStyle, O.intStyleId from orders O where O.intStatus in ( 11, 13) order by O.strStyle;";
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($styleID==  $row["strStyle"])
		{
			echo "<option selected=\"selected\" value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>" ;
	}
	
	?>
                  </select></td>
                <!--  <td width="64" >Order No </td>
                  <td width="150"  ><select name="cboOrderNo" class="txtbox" tabindex="7" style="width:150px" id="cboOrderNo" onchange="resetCompanyBuyer();GetScNo(this);">
                    <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select O.strOrderNo,O.intStyleId from orders O where O.intStatus in ( 11, 13) ";
	
	if($styleID!="")
		$SQL .= " and O.strStyle='$styleID' ";
		
	$SQL .= "order by O.strOrderNo ";
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($orderid==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId "] ."\">" . $row["strOrderNo"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	?>
                  </select></td>-->
                  
                  </tr>
                  <tr>
                  <td >Buyer</td>
                  <td ><select name="cboCustomer" class="txtbox" style="width:150px" id="cboCustomer" tabindex="2">
                    <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "SELECT intBuyerID, strName FROM buyers order by strName;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		if ($buyer == $row["intBuyerID"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
		}
		else
		{
			echo "<option value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
		}
	}
	
	?>
                  </select></td>
                  <td  >Style Like </td>
                  <td><input name="txtStyleNo" tabindex="8" type="text" class="txtbox" id="txtStyleNo" value="<?php echo $_POST["txtStyleNo"]; ?>" style="width:148px" maxlength="30"/></td>
                  <td  >Order Like</td>
                  <td><input name="txtOrderNo" type="text" class="txtbox" id="txtOrderNo" value="<?php echo $_POST["txtOrderNo"]; ?>" /></td>
                  <td width="11" >&nbsp;</td>
                  <td width="83"><div align="right">
                    <input name="image" type="image" class="mouseover" tabindex="9" onclick="submitForm();" src="images/search.png"  width="80" height="24" />
                  </div></td>
                  </tr>
                  <tr>
                    <td ><input type="checkbox" id="frmDateCheck"   name="frmDateCheck" class="txtbox" tabindex="5" onchange="dateArrange();" />&nbsp;&nbsp; From</td>
                    <td ><input name="txtFrmDate" value="<?php echo $_POST['txtFrmDate'];?>" type="text" class="txtbox" id="txtFrmDate" style="width:148px"  onmousedown="DisableRightClickEvent();" tabindex="5" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%d/%m/%Y');" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;width:1px" onkeypress="return showCalendar(this.id, '%d/%m/%Y');"   onclick="return showCalendar(this.id, '%d/%m/%Y');"  value="" /></td>
                    <td  >To</td>
                    <td><input name="txtToDate" value="<?php echo $_POST['txtToDate'];?>" type="text"  class="txtbox" id="txtToDate" style="width:148px" tabindex="6"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%d/%m/%Y');" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;width:1px" onkeypress="return showCalendar(this.id, '%d/%m/%Y');"   onclick="return showCalendar(this.id, '%d/%m/%Y');"  value="" /></td>
                    <td  >&nbsp;</td>
                    <td>&nbsp;</td>
                    <td >&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
				   
              </table></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td><div id="divData" style="width:950px; height:400px; overflow: scroll; " >
            <table width="100%" bgcolor="#ECD9FF" border="0" cellpadding="1" cellspacing="1" id="tblPreOders" >
              <tr class="mainHeading4">
                <th width="8%" >SC No </th>
                <th width="14%" height="25"  >Style No</th>
                <th width="21%">Description</th>
                <th width="15%">Order Qty</th>
                <th width="10%">Company</th>
                <th width="14%">Buyer</th>
                <th width="9%" >Approved By </th>
                <th width="8%" >Costing By</th>
                <th width="9%" >Approved Date</th>
                <th width="9%" >Merchandiser</th>
                <th width="7%" >View</th>
              </tr>
              <?php
			$sql = "SELECT orders.strOrderNo,orders.intStyleId,orders.strStyle,strDescription,specification.intSRNO, companies.strComCode, buyers.strName,intQty,dtmAppDate,DATE_FORMAT(dtmAppDate, '%Y %b %d') AS dtmAppDate1,intSRNO, 
(SELECT useraccounts.Name FROM useraccounts WHERE useraccounts.intUserID = orders.intUserID) AS costingby,
(SELECT useraccounts.Name FROM useraccounts WHERE useraccounts.intUserID = orders.intApprovedBy) AS approvedBy,
(SELECT useraccounts.Name FROM useraccounts WHERE useraccounts.intUserID = orders.intCoordinator) AS merchandiser, orders.intQty
FROM orders INNER JOIN companies ON orders.intCompanyID = companies.intCompanyID 
INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID INNER JOIN specification ON orders.intStyleId = specification.intStyleId   WHERE orders.intStatus in ( 11, 13)  " ;
			
			
			if ($factory != "")
			{
				$sql.= " and orders.intCompanyID = $factory";
			}
			if ($buyer != "")
			{
				$sql.= " and orders.intBuyerID = $buyer";
			}
			if ($orderid != "")
			{				
				$sql.= " and orders.intStyleId = '$orderid'";
			}
			if ($styleID != "")
			{
				//$sql.= " and orders.strStyle ='$styleID'";
                                $sql.= " and orders.intStyleId ='$styleID'";
			}
			if ($styleNo != "" )
			{
				$sql.= " and orders.strStyle like '%$styleNo%'";
			}
			if ($orderNo != "" )
			{
				$sql.= " and orders.strOrderNo like '%$orderNo%'";
			}
			if ($fromDate != "")
			{
				$sql.= " and date(orders.dtmAppDate) >= '$fromDate' ";
			}
			if ($toDate != "")
			{
				$sql.= " and date(orders.dtmAppDate) <= '$toDate' ";
			}
			
			$sql.= " order by intSRNO desc";
                        //echo $sql;
			$result = $db->RunQuery($sql);	
			$pos = 0;
			while($row = mysql_fetch_array($result))
			{
			?>
              <tr class="bcgcolor-tblrowWhite">
              <td class="normalfnt"><?php echo  $row["intSRNO"]; ?></td>
                <td height="21" class="normalfnt"><?php echo $row["strStyle"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strDescription"]; ?></td>
                <td class="normalfntR"><?php echo  number_format($row["intQty"],0); ?></td>
                <td class="normalfnt"><?php echo  $row["strComCode"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strName"]; ?></td>
                <td class="normalfnt"><?php echo  $row["approvedBy"]; ?></td>
                <td class="normalfnt"><?php echo  $row["costingby"]; ?></td>
                <td class="normalfnt"><?php echo  $row["dtmAppDate1"]; ?></td>
                <td class="normalfnt"><?php echo  $row["merchandiser"]; ?></td>
                <?php if($viewallapprovedcostsheets) 
						{
				?>
                <td class="normalfnt"><a href="<?php echo $reportname; ?>?styleID=<?php echo  urlencode($row["intStyleId"]); ?>" target="_blank"><img src="images/view2.png" border="0" class="noborderforlink" /></a></td>
                <?php 
						}
						else
						{
				?>
                <td class="normalfnt"></td>
                <?php 
						} 
				?>
              </tr>
              <?php
			  $pos ++;
			}
			?>
            </table>
          </div></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><div align="right"></div></td>
    </tr>
  </table>
</form>
</body>
</html>
