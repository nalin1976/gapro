<?php
session_start();
$backwardseperator = "../";
include "$backwardseperator".''."Connector.php";
$plno=$_GET["plno"];
$orderno = $_GET["orderno"];
$orderId = $_GET["orderId"];

$orderSql="SELECT * FROM shipmentplheader WHERE strPLNo='$plno'";
$resultOrder=$db->RunQuery($orderSql);
$rowOrder=mysql_fetch_array($resultOrder);

$rowOrderNo=$rowOrder['strStyle'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />

<title>Shipment Packing List</title>
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
.bcglm {
	border: 1px solid #CC9900;
}
</style>

<link type="text/css" href="../css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
<style type="text/css">
.dataTable { font-family:Verdana, Arial, Helvetica, sans-serif; border-collapse: collapse; border:1px solid #999999; width: 750px; font-size:12px;}
.dataTable td, .dataTable th {border: 1px solid #FFF; padding: 0px 0px;  margin:0px;}

.dataTable thead a {text-decoration:none; color:#444444; }
.dataTable thead a:hover { text-decoration: underline;}

/* Firefox has missing border bug! https://bugzilla.mozilla.org/show_bug.cgi?id=410621 */
/* Firefox 2 */
html</**/body .dataTable, x:-moz-any-link {margin:1px;}
/* Firefox 3 */
html</**/body .dataTable, x:-moz-any-link, x:default {margin:1px}
</style>
<script type="text/javascript" src="../js/jquery-1.3.2.min.js"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="jquery.fixedheader.js" type="text/javascript"></script>
<style type="text/css">
#menu-hide tr:hover{background-color:#c5c5c5} 
.bcgl2 {
	border-bottom: 1px solid #DADADA;
}
.normalfnt_num {
	font-family: Verdana;
	font-size: 11px;
	color: #498CC2;
	margin: 0px;
	font-weight: normal;
	text-align:center;
	padding:2px;
}
</style>
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
<script type="text/javascript" src="ship.js"></script>
  

<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
	
}
.buttonDn {width:20px;position: absolute;bottom:22px;
}
.buttonUp {width:20px;position: absolute;top:2px;
}
.div_verticalscroll {position: relative;
#left:900px;
#top:-220px;
right:0px;
width:18px;
height:220px;
background:#EAEAEA;
border:1px solid #C0C0C0;
}

-->
</style>
</head>
<body>
<table width="960" border="0" cellspacing="2" cellpadding="0" bgcolor="#FFFFFF" align="center">
  <tr>
    <td align="center"><?php include "".$backwardseperator."Header.php"; ?></td>
  </tr>
  <tr>
    <td bgcolor="#316895"  height="25" class="TitleN2white" >Shipment Packing List</td>
  </tr>
  <tr>
    <td class="bcgl1txt1NB">
    
      <form id="pl_header" >
        <table border="0" cellspacing="0" cellpadding="3" class="normalfnt bcgl1" width="100%">
          <tr>
            <td height="5" colspan="8"></td>
          </tr>
          <tr>
            <td height="25" title="PL Number is an auto generated number.">PL No</td>
            <td id='plno_cell' title="PL Number is an auto generated number."><input name="txtPLNo"  type="text" class="txtbox" id="txtPLNo" tabindex="1" style="width:146px" disabled="disabled" /></td>
            <td>Date</td>
            <td><input style="text-align:center" name="txtSailingDate" tabindex="2"  type="text" class="txtbox" id="txtSailingDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="calender" type="text"  class="txtbox" style="visibility:hidden;width:5px;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
            <td>Order No <span style="color:#F00">*</span></td>
            <td><select name="cmbStyle" class="txtbox" id="cmbStyle" style="width:150px" tabindex="3">
              <option value=""></option>
              <?php 
			$buyerstr="select distinct strStyle from style_ratio_plugin order by strStyle";
		
			$buyerresults=$db->RunQuery($buyerstr);
			
			while($buyerrow=mysql_fetch_array($buyerresults))
			{
				if($orderno==$buyerrow['strStyle'])
				{
		?>
        		<option selected value="<?php echo $buyerrow['strStyle'];?>"><?php echo $buyerrow['strStyle'];?></option>
                
                <?php
				}
				else
				{
				?>
              <option value="<?php echo $buyerrow['strStyle'];?>"><?php echo $buyerrow['strStyle'];?></option>
              <?php } } ?>
            </select></td>
            <td>Style <span style="color:#F00">*</span></td>
            <td><input name="txtProductCode" type="text" class="txtbox" id="txtProductCode" style="width:146px" maxlength="50" tabindex="4"/></td>
          </tr>
          <tr>
            <td height="25" nowrap="nowrap">Material #</td>
            <td><input name="txtMaterialNo" type="text" class="txtbox" id="txtMaterialNo" style="width:146px"  maxlength="50" tabindex="5"/></td>
            <td>Cons. Type </td>
            <td><input name="txtFabric" type="text" class="txtbox" id="txtFabric" style="width:146px" maxlength="50" tabindex="6"/></td>
            <td>Fabric</td>
            <td><input name="txtLable" type="text" class="txtbox" id="txtLable" style="width:146px"  maxlength="50" tabindex="7"/></td>
            <td>ISD No</td>
            <td><input name="txtISD" type="text" class="txtbox" id="txtISD" style="width:146px" maxlength="50" tabindex="9"/></td>
          </tr>
          <tr>
            <td height="25">Item #</td>
            <td><input name="txtItemNo" type="text" class="txtbox" id="txtItemNo" style="width:146px" maxlength="50" tabindex="17"/></td>
            <td nowrap="nowrap">PrePacK Code</td>
            <td><input name="txtPrePackCode" type="text" class="txtbox" id="txtPrePackCode" style="width:146px" maxlength="50" tabindex="10"/></td>
            <td>Season</td>
            <td><input name="txtSeason" type="text" class="txtbox" id="txtSeason" style="width:146px" maxlength="50" tabindex="11"/></td>
            <td>Division</td>
            <td><input name="txtDivision" type="text" class="txtbox" id="txtDivision" style="width:146px" maxlength="50" tabindex="12"/></td>
          </tr>
          <tr>
            <td height="25" nowrap="nowrap">DO #</td>
            <td nowrap="nowrap"><input name="txtCTNS" type="text" class="txtbox" id="txtCTNS" style="width:146px;display:none"  maxlength="50" tabindex="13" title="Separate using 'X'." />
            <input name="txtDO" type="text" class="txtbox" id="txtDO" style="width:146px"  maxlength="50" tabindex="21"/></td>
            <td>Wash Code</td>
            <td><input name="txtWashCode" type="text" class="txtbox" id="txtWashCode" style="width:146px" maxlength="50" tabindex="14" /></td>
            <td>Article</td>
            <td><input name="txtArticle" type="text" class="txtbox" id="txtArticle" style="width:146px;" maxlength="50" tabindex="15"/></td>
            <td>DC </td>
            <td><input name="txtDC" type="text" maxlength="30"class="txtbox" id="txtDC"style="width:146px" tabindex="20"/></td>
          </tr>
          <tr>
            <td height="25" nowrap="nowrap">Container #</td>
            <td><input name="txtContainer" type="text"  class="txtbox" id="txtContainer" style="width:146px"  maxlength="50" tabindex="25" /></td>
            <td>Item</td>
            <td><input name="txtItem" type="text" class="txtbox" id="txtItem" style="width:146px" maxlength="50" tabindex="18"/></td>
            <td nowrap="nowrap">Manu. Ord. # </td>
            <td><input name="txtManufactOrderNo" type="text" class="txtbox" id="txtManufactOrderNo" style="width:146px;"  maxlength="50" tabindex="19"/></td>
            <td nowrap="nowrap">Manu. Style</td>
            <td><input name="txtManufactStyle" type="text" class="txtbox" id="txtManufactStyle" style="width:146px" maxlength="50" tabindex="20"/></td>
          </tr>
          <tr>
            <td height="25">Destination</td>
            <td><select name="cboDestination" class="txtbox" id="cboDestination"style="width:150px;" tabindex="27">
              <option value=""></option>
              <?php 
                   $sqlCity="SELECT strPortOfLoading,strCityCode, strCity FROM city  order by strCity";
                   $resultCity=$db->RunQuery($sqlCity);
						 while($row=mysql_fetch_array( $resultCity)) 
						 echo "<option value=".$row['strCityCode'].">".$row['strCity']." --> ".$row['strPortOfLoading']."</option>";                 
                   ?>
            </select></td>
            <td>Sorting Type</td>
            <td><input name="txtSortingType" type="text" class="txtbox" id="txtSortingType" style="width:146px" maxlength="50" tabindex="22"/></td>
            <td>Manufacturer </td>
            <td><select name="cboFactory"  class="txtbox" style="width:150px" id="cboFactory"  tabindex="23" >
              <option value=""></option>
              <?php 
			$strtofactory="select strCustomerID,strName from customers  order by strName";
		
			$factresults=$db->RunQuery($strtofactory);
			
			while($factrow=mysql_fetch_array($factresults))
			{
		?>
              <option value="<?php echo $factrow['strCustomerID'];?>"><?php echo $factrow['strName'];?></option>
              <?php } ?>
            </select></td>
            <td>WT Unit </td>
            <td><select name="txtUnit" type="text" id="txtUnit" class="txtbox" style="width:150px" tabindex="24">
              <option value=""></option>
              <option value="lbs">lbs</option>
              <option value="KG">KG</option>                       
           	  </select></td>
          </tr>
          <tr>
            <td width="8%" height="25" nowrap="nowrap">Transport Mode</td>
            <td width="18%"><select name="cboTransMode" class="txtbox" id="cboTransMode"style="width:150px" tabindex="26">
              <option value=""></option>
              <?php 
					$str_lship_mode="select strDescription from shipmentmode  ";
					$result_lship_mode=$db->RunQuery($str_lship_mode);
					while($row_lship_mode=mysql_fetch_array( $result_lship_mode)) 
				   {?>
              <option value="<?php  echo $row_lship_mode['strDescription'];?>">
                <?php  echo $row_lship_mode['strDescription'];?>
                </option>
              <?php }   ?>
            </select></td>
            <td width="9%" nowrap="nowrap">Marks & Nos</td>
            <td width="16%" rowspan="3"> <textarea name="txtMarksNos" cols="20" rows="3" id="txtMarksNos"></textarea></td>
            <td width="9%" class="normalfnt">Ship To</td>
            <td width="16%"><select name="cboShipTo"  class="txtbox" style="width:150px" id="cboShipTo"  tabindex="23" >
              <option value=""></option>
              <?php 
			$strShipTo="SELECT strBuyerID, strName FROM buyers order by strName";
		
			$shipToresults=$db->RunQuery($strShipTo);
			
			while($shiprow=mysql_fetch_array($shipToresults))
			{
		?>
              <option value="<?php echo $shiprow['strBuyerID'];?>"><?php echo $shiprow['strName'];?></option>
              <?php } ?>
            </select></td>
            <td width="8%">&nbsp;</td>
            <td width="16%">&nbsp;</td>
          </tr>
          <tr>
            <td height="25">&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
		
      </form>
     
    
    </td>
  </tr>
  <tr>
  		<td height="300" valign="top" class="bcgl1"><table style="width:100%;"  cellpadding="0" cellspacing="0" bgcolor="#ffffff"  id="tblPL" class="dataTable">
  		  
          <?php
          $str="SELECT 
		SPSI.strPLNo,
		SPSI.strSize,
		SPSI.intColumnNo,
		FGW.dblWeight AS dblNet
		FROM shipmentplsizeindex SPSI
		INNER JOIN 
		shipmentplheader SPH ON SPH.strPLNo=SPSI.strPLNo
		INNER JOIN 
		finishing_garment_weight FGW ON FGW.strOrderId=SPH.strStyle AND FGW.strSize=SPSI.strSize
		WHERE SPSI.strPLNo='$plno' order by SPSI.intColumnNo";
	$result=$db->RunQuery($str);
	$noOfColumns=mysql_num_rows($result);
	//$rowSize=mysql_fetch_array($result);
	$cell_width		=round(90/($noOfRows+13),0);
	
		?>
        <thead>
        <tr class="normaltxtmidb2" bgcolor="#498CC2">
        	<th height="20" width="<?php echo $cell_width; ?>%">#</th>
        	<th height="20" width="<?php echo $cell_width; ?>%">CTN_F.</th>
            <th height="20" width="<?php echo $cell_width; ?>%">CTN_To</th>
            <th height="20" width="<?php echo $cell_width; ?>%">CTN WT</th>
            <th height="20" width="<?php echo $cell_width; ?>%">TAG#</th>
            <th height="20" width="<?php echo $cell_width; ?>%">PrePack#</th>
            <th height="20" width="<?php echo $cell_width; ?>%">Pack#</th>
            <th height="20" width="<?php echo $cell_width; ?>%">Color</th>
            <th height="20" width="<?php echo $cell_width; ?>%">Length</th>
            <?php
            while($rowSize=mysql_fetch_array($result))
			{
			?>
            	<th height="20" width="<?php echo $cell_width; ?>%" bgcolor="#020061"><?php echo $rowSize['strSize']; ?></th> 
        	<?php
			}
            ?>
             <th height="20" width="<?php echo $cell_width; ?>%">#PCS</th>
             <th height="20" width="<?php echo $cell_width; ?>%">#CTNS</th>
             <th height="20" width="<?php echo $cell_width; ?>%">QTY</th>
             <th height="20" width="<?php echo $cell_width; ?>%">DOZ</th>
             <th height="20" width="<?php echo $cell_width; ?>%">GROSS</th>	
			 <th height="20" width="<?php echo $cell_width; ?>%">NET</th>
             <th height="20" width="<?php echo $cell_width; ?>%">Net Net</th>
             <th height="20" width="<?php echo $cell_width; ?>%">Tot Grs.</th>
             <th height="20" width="<?php echo $cell_width; ?>">Tot Net</th>
             <th height="20" width="<?php echo $cell_width; ?>%">Tot N.N.</th> 
        </tr>
        </thead>
        <tbody>
        	<?php $str="select 	*			 
					from 
					shipmentpldetail 
					where strPLNo='$plno'";
	$result=$db->RunQuery($str);
	$lastRow=0;
	while($row=mysql_fetch_array($result))
	{
		
	?>
    	<tr class="trclass">
        	<td class="normalfnt_num"><?php echo $lastRow+1; ?></td>
            <td class="normalfnt_num"><input type="text" onkeypress="return CheckforValidDecimal(this.value, 0,event);" onblur="cal_amounts(this)" class="txtbox keymove" style="width:50px;text-align:right;" maxlength="15" value="<?php echo $row['dblPLNoFrom']; ?>"  /></td>
            <td class="normalfnt_num"><input type="text" onkeypress="return CheckforValidDecimal(this.value, 0,event);" onblur="cal_amounts(this)" class="txtbox keymove" style="width:50px;text-align:right;" maxlength="15" value="<?php echo $row['dblPlNoTo']; ?>"  /></td>
            <?php
            	$str_ctn="SELECT 	
                    intCartoonId, 
                    intLength, 
                    intWidth, 
                    intHeight, 
                    strCartoon, 
                    dblWeight, 
                    strDescription, 
                    dtmSaveDate, 
                    intUserId		 
                    FROM 
                    cartoon   ";
                $result_ctn=$db->RunQuery($str_ctn);
				//$row_ctn=mysql_fetch_array($result_ctn);
				//echo $row['strCTN'];
            ?>
            <td><select class="txtbox keymove" style="width:110px">
            	<?php
					while($row_ctn=mysql_fetch_array($result_ctn))
					{
						if($row_ctn['intCartoonId']==$row['strCTN'])
						{
				?>
                		<option selected="selected" value="<?php echo $row_ctn['intCartoonId']; ?>"><?php echo $row_ctn['strCartoon']; ?></option>
                 <?php
						}
						else
						{
				 ?>
                 		<option value="<?php echo $row_ctn['intCartoonId']; ?>"><?php echo $row_ctn['strCartoon']; ?></option>
                <?php
						}
					}
				?>
            </select>
			</td>
            
            <td class="normalfnt_num"><input type="text" class="txtbox keymove" style="width:110px;text-align:center;" maxlength="30" onkeypress='setTagNo(this,event);' value="<?php echo $row['strTagNo']; ?>"  />
            </td>
            
            <td class="normalfnt_num"><input type="text" class="txtbox keymove" style="width:100px;text-align:center;"maxlength="30" value="<?php echo $row['strPrePack']; ?>" />
            </td>
            
            <td><select class="txtbox keymove" style="width:110px">
                	<?php
					if($row['srtPack']=='3Bulk')
					{
					?>
                    	<option selected="selected" value="3Bulk">Bulk</option>
                    <?php
					}
					else
					{
					?>
                    	<option value="3Bulk">Bulk</option> 
                        
                    <?php
					}
					if($row['srtPack']=='2Ratio')
					{
					?>
                    	<option selected="selected" value="2Ratio">Ratio</option>
                    <?php
					}
					else
					{
					?>
                    	<option value="2Ratio">Ratio</option>
                        
                     <?php
					}
					if($row['srtPack']=='1Pre Pack')
					{
					?>
                    	<option selected="selected" value="1Pre Pack">Pre Pack</option>
                    <?php
					}
					else
					{
					?>
                    	<option value="1Pre Pack">Pre Pack</option>
                    <?php
					}
					?>
                        
                </select></td>
             <?php
            	$sqlColor="select distinct strColor from orderspecdetails od
							inner join orderspec oh on oh.intOrderId=od.intOrderId
	 						where oh.strOrder_No='$rowOrderNo'";
	 			$resultColor=$db->RunQuery($sqlColor);					
	 		?>
            <td><select class="txtbox keymove" style="width:110px">
           		<?php
					while($rowColor=mysql_fetch_array($resultColor))
					{
						if($rowColor['strColor']==$row['strColor'])
						{
				?>
                		<option selected="selected" value="<?php echo $rowColor['strColor']; ?>"><?php echo $rowColor['strColor']; ?></option>
                 <?php
						}
						else
						{
				 ?>
                 		<option value="<?php echo $rowColor['strColor']; ?>"><?php echo $rowColor['strColor']; ?></option>
                <?php
						}
					}
				?>
           </select></td>
            <td><input type="text" class="txtbox keymove" style="width:110px;text-align:center;" maxlength="30" value="<?php echo $row['strLength']; ?>" /></td>
            <?php
				$rowNo=$lastRow+1;
				$columnNo=0;
				
				while($columnNo<$noOfColumns)
				{
					$sqlPcs="select 	strPLNo, 
						intRowNo, 
						intColumnNo, 
						dblPcs					 
						from 
						shipmentplsubdetail 
						where strPLNo='$plno' AND intRowNo=$rowNo AND intColumnNo=$columnNo";
					$resultPcs=$db->RunQuery($sqlPcs);
					$rowPcs=mysql_fetch_array($resultPcs);	
			?>
            <td><input type="text" onkeypress="return CheckforValidDecimal(this.value, 0,event);" onblur="cal_amounts(this);" class="txtbox keymove" style="width:50px;text-align:right;background-color:#C2E2B8" maxlength="8" value="<?php echo $rowPcs['dblPcs']; ?>" /></td>
            <?php
			$columnNo++;
				}
			?>
            
			<td><input class="txtbox keymove" type="text" maxlength="15" style="width: 50px; text-align: right;" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="<?php echo $row['dblNoofPCZ']; ?>" />
            </td>
            
            <td><input class="txtbox keymove" type="text" maxlength="15" style="width: 50px; text-align: right;" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="<?php echo $row['dblNoofCTNS']; ?>" /></td>
            
            <td><input class="txtbox keymove" type="text" maxlength="15" style="width: 50px; text-align: right;" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="<?php echo $row['dblQtyPcs']; ?>" /></td>
            
            <td><input class="txtbox keymove" type="text" maxlength="15" style="width: 50px; text-align: right;" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="<?php echo $row['dblQtyDoz']; ?>" /></td>
            
            <td><input class="txtbox keymove" type="text" maxlength="15" style="width: 50px; text-align: right; background-color: rgb(243, 237, 216);" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onblur="cal_amounts(this)" value="<?php echo $row['dblGorss']; ?>" /></td>
             <td><input class="txtbox keymove" type="text" maxlength="15" style="width: 50px; text-align: right; background-color: rgb(243, 237, 216);" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onblur="cal_amounts(this)" value="<?php echo $row['dblNet']; ?>" /></td>
               <td><input class="txtbox keymove" type="text" maxlength="15" style="width: 50px; text-align: right; background-color: rgb(243, 237, 216);" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onblur="cal_amounts(this)" value="<?php echo $row['dblNetNet']; ?>" /></td>
            
            <td><input class="txtbox keymove" type="text" maxlength="15" style="width: 50px; text-align: right;" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="<?php echo $row['dblTotGross']; ?>" /></td>
            
             <td><input class="txtbox keymove" type="text" maxlength="15" style="width: 50px; text-align: right;" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="<?php echo $row['dblTotNet']; ?>" /></td>
            
             <td><input class="txtbox keymove" type="text" maxlength="15" style="width: 50px; text-align: right;" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="<?php echo $row['dblTotNetNet']; ?>"></td>	
        </tr>
    <?php
		$lastRow++;
	}
	?>
    		
       </tbody>
	    </table></td>
  </tr>
  <tr>
  	<td><table width="100%" border="0" class="tableBorder" cellspacing="0" cellpadding="0" >
      
      <tr bgcolor="#D6E7F5">
        <td width="14%" height="30">&nbsp;</td>
        <td width="10%" height="30"><div align="center"> <img tabindex="29" src="../images/new.png"  id='btnNew'/> </div></td>
        <td width="11%" ><div align="center"> <img class="mouseover" tabindex="30" src="../images/view.png"  id="btnView" /> </div></td>
        <td width="10%" class="td_confirm"><div align="center"> <img tabindex="31" src="../images/save.png"   class="mouseover" id='btnSave'/> </div></td>
        <td width="12%" ><div align="center"> <img tabindex="32" src="../images/report.png "   class="mouseover"  id="btnPrint"/> </div></td>
        <td width="12%" id="td_confirm" class="td_confirm"><div align="center"> <img tabindex="32" src="../images/conform.png"   class="mouseover"  id="btnConfirm"/> </div></td>
        <td width="9%" valign="middle"><a href="stylerato/stylerato_plugin/stylerato_plugin.php"><img src="../images/back.png"  class="noborderforlink"/></a></td>
        <td width="18%"><a href="<?php echo $backwardseperator?>main.php"><img src="../images/close.png"  class="mouseover noborderforlink"  /></a></td>
        <td width="4%" align="center"><img src="../images/do_copy.png" width="32" height="31" alt="c" class="mouseover" title="Save As New Packing List" id="btn_save_as"/></td>
      </tr>
    </table></td>
  </tr>
 
</table>
<div style=" padding: 2px; display: none; position: absolute; background-color: rgb(238, 238, 238); top: 667px; left: 330px;" id="grid_menu" class="bcgl1">

			<table width="150" id='menu-hide' class="normalfnt" cellpadding="3">
            	<tr>
                    <td id="auto_cal_weight" class="bcgl2" height="20">Auto Calculate Weights</td>
                </tr>
                <tr>
                    <td id="auto_cal_ctns" class="bcgl2" height="20">Set Carton Numbers</td>
                </tr>
                <tr>
            		<td id="insert_above" class="bcgl2" height="20">Insert Row Above</td>
                </tr>
                <tr>
                    <td id="insert_bellow" class="bcgl2" height="20">Insert Row Below</td>
                </tr>
                <tr>
                    <td id="del_rows" class="bcgl2" height="20"><img src="../images/del.png" align="absmiddle"/> Delete Row</td>
                </tr>
            </table>
		
</div>
<script type="text/javascript">get_pl_header_data(<?php echo $plno ?>);load_saved_pl_details(<?php echo $plno ?>);</script>

</body>
</html>