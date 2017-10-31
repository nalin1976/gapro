<?php
 session_start();
 $backwardseperator = "../../";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>General Stock Balance</title>

<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="stockbalance.js" type="text/javascript"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/calendar/calendar.js" language="javascript" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" language="javascript" type="text/javascript"></script>

<script type="text/javascript">

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

function flatSelected(cal, date) {
  var el = document.getElementById("preview");
  el.innerHTML = date;
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


	
function viewReport()
{
var cboMainCat 		= document.getElementById('cboMainCat').value;
var cboSubCat  		= document.getElementById('cboSubCat').value;
var cboMatItem 		= document.getElementById('cboMatItem').value;
var txtmaterial 	= document.getElementById('txtmaterial').value;
var costCenter		= document.getElementById("cboCostCenter").value;
var GLCode			= document.getElementById("cboGLCode").value;
if(document.getElementById('bal').checked == true)
	var bal = 0;
else
	var bal = 1;

var x = document.getElementById('cc').value;

if(document.getElementById('detail').checked == true)
{
	var reportName = "detailReport.php";
	var url = reportName+'?id=report&cboMainCat='+cboMainCat+'&cboSubCat='+cboSubCat+'&cboMatItem='+cboMatItem+'&cboCompany='+x+'&bal='+bal+'&cboItemCode='+GLCode;
}
else
{
	var reportName = "genStockbalReport.php";
	var url = reportName+'?id=report&cboMainCat='+cboMainCat+'&cboSubCat='+cboSubCat+'&cboMatItem='+cboMatItem+'&cboCompany='+x+'&bal='+bal+'&txtmaterial='+txtmaterial+'&CostCenter='+costCenter+'&GLCode='+GLCode;
}


window.open(url,reportName);
}

function ViewExcelReport(){
	
	var mainCatCode 	= document.getElementById('cboMainCat').value;
	var subCatCode 		= document.getElementById('cboSubCat').value;
	var factoryCode 	= document.getElementById('cc').value;
	var genItemCode 	= document.getElementById('cboGLCode').value;
	var dtDate 			= document.getElementById('txtDfrom').value;
	var itemDesc 		= document.getElementById('txtmaterial').value;
	
	if((factoryCode=='') && (subCatCode=='') && (genItemCode=='') && (mainCatCode=='') && (itemDesc=='')) {alert("Select atleast one of the options from the list"); return;}
	
	var url = "genstockexcel.php?factoryCode="+factoryCode+"&mainCode="+mainCatCode+"&subCode="+subCatCode+"&gitemcode="+genItemCode+"&itemdesc="+itemDesc;
	
	if(factoryCode != '')
		url += "factoryCode="+factoryCode;
			
	if(mainCatCode != ''){
		url += "&mainCode="+mainCatCode;
	}	
	
	if(dtDate != '')
		url += "&dtdate="+dtDate;
		
	
	
	if(document.getElementById('detail').checked==true){alert("Detail list report cannot be generate for selected report"); return;}
	
	window.open(url);
	
}

</script>
</head>

<body>

<?php

include "../../Connector.php";

?>


  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="100%" border="0" class="bcgl1">
          <tr>
            <td height="35" class="mainHeading">General Stock Balance</td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="92%" class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td width="5%" class="normalfnt">&nbsp;</td>
                      <td width="23%" class="normalfnt">Main Category </td>
                      <td width="60%"><select name="cboMainCat" class="txtbox" id="cboMainCat" style="width:285px" onchange="LoadSubCategory(this)">
                        <?php
						$intMainCat = $_POST["cboMainCat"];
							
						$SQL = 	"SELECT genmatmaincategory.intID, genmatmaincategory.strDescription FROM genmatmaincategory ";
						$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
						echo "<option  value=\"". $row["intID"] ."\">" . trim($row["strDescription"]) ."</option>" ;								
						}
						
						?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Sub Category </td>
                      <td><select name="cboSubCat" class="txtbox" id="cboSubCat" style="width:285px" onchange="LoadMaterial()">
                        <?php
						/*
						$intSubCatNo = $_POST["cboSubCat"];
							
						$SQL = 	"SELECT MSC.intSubCatNo, MSC.StrCatName FROM genmatsubcategory  MSC
								WHERE MSC.intCatNo <>'' ";
								
						if($intMainCat!='')
							$SQL .= " AND MSC.intCatNo =  '$intMainCat'";
							
						$SQL .= " order by MSC.StrCatName ";
						
						$result = $db->RunQuery($SQL);*/
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;/*
						while($row = mysql_fetch_array($result))
						{
							echo "<option  value=\"". $row["intSubCatNo"] ."\">" . trim($row["StrCatName"]) ."</option>" ;								
						}
						*/
						?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Material Like</td>
                      <td><input type="text" name="txtmaterial" id="txtmaterial" style="width:284px;" onkeypress="EnterSubmitLoadItem(event);" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Material</td>
                      <td><select name="cboMatItem" class="txtbox" id="cboMatItem" style="width:285px">
                    <?php
					/*
					$intMatItem = $_POST["cboMatItem"];
						
					$SQL = 	"SELECT genmatitemlist.intItemSerial, genmatitemlist.strItemDescription 
							FROM genmatitemlist ";		
					
					$SQL .= " Order By strItemDescription";
					$result = $db->RunQuery($SQL);*/
					echo "<option value=\"". "" ."\">" . "" ."</option>" ;
					/*
					while($row = mysql_fetch_array($result))
					{
					echo "<option value=\"". $row["intItemSerial"] ."\">" . trim($row["strItemDescription"]) ."</option>" ;								
					}
						*/
					?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Factory</td>
                      <td><select  name="cc" class="txtbox" id="cc" style="width:285px" onchange="LoadCostCenter(this)">
                    <?php
					
					$SQL = 	"SELECT intCompanyID,strName FROM companies";		

					$result = $db->RunQuery($SQL);
					echo "<option value=\"". "" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
					echo "<option value=\"". $row["intCompanyID"] ."\">" . trim($row["strName"]) ."</option>" ;								
					}
						
					?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Cost Center </td>
                      <td><select  name="cboCostCenter" class="txtbox" id="cboCostCenter" style="width:285px" onchange="LoadGLCode(this)">
                        <?php
					
					/*$SQL = 	"SELECT intCompanyID,strName FROM companies";		

					$result = $db->RunQuery($SQL);
					echo "<option value=\"". "" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
					echo "<option value=\"". $row["intCompanyID"] ."\">" . trim($row["strName"]) ."</option>" ;								
					}*/
						
					?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Navision Code</td> <!-- Change to Navition Code -->
                      <td><!--select  name="cboGLCode" class="txtbox" id="cboGLCode" style="width:285px">
                        <?php
					
						$SQL = 	"select intGLAccID,strDescription from glaccounts where intStatus=1 
								 order by strDescription";		
	
						$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
						echo "<option value=\"". $row["intGLAccID"] ."\">" . trim($row["strDescription"]) ."</option>" ;								
						}
							
						?>
                      </select>-->
                      <select  name="cboGLCode" class="txtbox" id="cboGLCode" style="width:285px">
                        <?php
					
						$SQL = 	" SELECT genmatitemlist.intItemSerial, CONCAT(genmatitemlist.strItemCode,'  -  ', genmatitemlist.strItemDescription ) AS 		GSTK FROM   genmatitemlist  WHERE intStatus = 1";		   
	
						$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
						echo "<option value=\"". $row["intItemSerial"] ."\">" . trim($row["GSTK"]) ."</option>" ;								
						}
							
						?>
                      </select>
                      
                      </td>
                    </tr>
					<tr>
                    	<td class="normalfnt">&nbsp;</td>
                      	<td class="normalfnt">Date</td>
                        <td width="19%"><input type="text" name="txtDfrom " id="txtDfrom" style="width:90px;" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  onKeyDown="" /><input type="text" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
                    </tr>
					<tr><td colspan="3"><table width="100%">
					
					                    <tr height="20">
                      <td class="normalfnt" width="5%">&nbsp;</td>
                      <td class="normalfnt" width="23%">&nbsp;</td>
                      <td class="normalfntRite">With 0 Balance&nbsp;<input type="radio" id="bal" name="bal"/></td>
                      <td class="normalfntRite">Without 0 Balance&nbsp;<input type="radio" checked="checked" name="bal"/></td>
                      <td class="normalfnt" width="20%">&nbsp;</td>
                    </tr>
					                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfntRite">Detail Report&nbsp;&nbsp;&nbsp;<input type="radio" id="detail" name="detail" /></td>
                      <td class="normalfntRite">Summery Report&nbsp;&nbsp;<input type="radio" checked="checked"  id="detail" name="detail" /></td>
                      <td class="normalfnt" >&nbsp;</td>
                    </tr>
					
					</table></td></tr>
					
					
					
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
                      <td width="11%">&nbsp;</td>                     
                      <td width="77%" ><img src="../../images/new.png" alt="new" onclick="ClearForm();"/><img src="../../images/report.png" alt="Report" name="Delete"  border="0" class="mouseover" onclick="viewReport();"/><img src="../../images/exceldw.gif" onclick="ViewExcelReport()" /><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0"/></a></td>
                      <td width="12%">&nbsp;</td>
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
}
</script>

</body>
</html>
