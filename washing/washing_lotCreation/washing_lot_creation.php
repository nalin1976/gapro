<?php
	session_start();
	include("../../Connector.php");
	include("class.washingplan.php");
	$backwardseperator = "../../";	
	$planClass = new washingplan();
	$factory	= $_SESSION['FactoryID'];

	 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Washing - Lot Creation</title>
<link href="../../js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../css/tableGrib.css" rel="stylesheet" type="text/css" />

    <style>
/* TimeEntry styles */
.timeEntry_control {
	vertical-align: middle;
	margin-left: 3px;
}
* html .timeEntry_control { /* IE only */
	margin-top: -4px;
}

</style>
<style type="text/css">
.menu_separator{
	border-bottom:#999 solid 1px;	
}
.menu_hoverz:hover{
	background-color:#DEE4F8;
	cursor: pointer;
}
.menu_css{
	border:#999 solid 1px;	
}

#tt {
 position:absolute;
 display:block;
 background:url(images/tt_left.gif) top left no-repeat;
 }
 #tttop {
 display:block;
 height:5px;
 margin-left:5px;
 background:url(images/tt_top.gif) top right no-repeat;
 overflow:hidden;
 }
 #ttcont {
 display:block;
 padding:2px 12px 3px 7px;
 margin-left:5px;
 background:#666;
 color:#fff;
 font-family: Verdana;
 font-size:11px;
 }
#ttbot {
display:block;
height:5px;
margin-left:5px;
background:url(images/tt_bottom.gif) top right no-repeat;
overflow:hidden;
}

</style>
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<script type="text/javascript" src="washingPlan.js"></script>
<script type="text/javascript" src="lot_strip_generate.js"></script>
<script type="text/javascript" src="washingPlan_db.js"></script>
<script type="text/javascript" src="washingPlan_xml.js"></script>


<script src="jquery-1.js"></script>
<script type="text/javascript">

////////////////////////////////////
function checkInHours(value){
 if(value>12){
   alert("Please use 12 hour time format only");
   document.getElementById('machineLoading_TimeInHours').value="";
  
  }
 }

function checkInMinutes(value){

 if(value>60){
  alert("Please enter valid minutes");
  document.getElementById('machineLoading_TimeInMinutes').value="";
  }
  
  if(value == 60){
  var TimeInHours = document.getElementById('machineLoading_TimeInHours').value;

   if(TimeInHours == 12){
   document.getElementById('machineLoading_TimeInHours').value = "1";
   }else{
     TimeInHours = (TimeInHours*1 + 1*1);
  document.getElementById('machineLoading_TimeInHours').value = TimeInHours;
  }
  document.getElementById('machineLoading_TimeInMinutes').value="00";
  }
}

function checkOutHours(value){
if(value>12){
  alert("Please use 12 hour time format only");
  document.getElementById('machineLoading_TimeOutHours').value="";
  
 }
}

function checkOutMinutes(value){
 if(value>60){
  alert("Please enter valid minutes");
  document.getElementById('machineLoading_TimeOutMinutes').value="";
  }
  if(value == 60){
  var TimeInHours = document.getElementById('machineLoading_TimeOutHours').value;

   if(TimeInHours == 12){
   document.getElementById('machineLoading_TimeOutHours').value = "1";
   /*
   var ampm = document.getElementById('machineLoading_TimeOutAMPM').options[0].text;
   if(ampm=="AM"){
   document.getElementById('machineLoading_TimeOutAMPM').options[0].text = "PM";
   document.getElementById('machineLoading_TimeOutAMPM').options[1].text = "AM";
   }else{
    document.getElementById('machineLoading_TimeOutAMPM').options[0].text = "AM";
	document.getElementById('machineLoading_TimeOutAMPM').options[1].text = "PM";
   }*/
   }else{
     TimeInHours = (TimeInHours*1 + 1*1);
  document.getElementById('machineLoading_TimeOutHours').value = TimeInHours;
  }
  document.getElementById('machineLoading_TimeOutMinutes').value="00";
  }
}
$(function () {
	$('#machineLoading_txtTimeIn').timeEntry({spinnerImage: 'spinnerDefault.png'});
	$('#machineLoading_txtTimeOut').timeEntry({spinnerImage: 'spinnerDefault.png'});
});

function viewReport()
{
	var planId = document.getElementById('txtPlanNo').value;
	if(planId=="")
	{
		alert("No record to view report.");
		return;
	}
	else
	{
		var url ="rptLotCreation.php?planId="+planId;
		window.open(url,"rptLotCreation");
	}
}
</script>

</head>

<body onload="setTimeLine();">
<form id="frmlotCreation" name="frmlotCreation">
<table width="1860" align="center">
	<tr>
    	<td><?php include "{$backwardseperator}Header.php"; ?></td>
	</tr>
</table>
<script type="text/javascript" src="../javascript/jquery.timeentry.js"></script>
<script type="text/javascript" src="../javascript/jquery.mousewheel.js"></script>
<table  align="center" class="tableBorder" width="1860">
<tr>
	<td class="mainHeading">Lot Creation</td>
</tr>
<tr>
                <td>
                              <table  rules="none" cellspacing="0" width="100%" >
                              <thead>
                            	<tr>
                                	<td width="182">&nbsp;	
                                    </td>
                                	<td class="normalfnt" width="115"  >Search</td>
                                    <td width="331">
                                    <select id="cboSearch" style="width:150px;" onchange="loadPlans(this)">
                                    	<option value="">Select One</option>
                                    <?php 
									$sql="select concat(intPlanYear,'/',intPlanNo) as PLANID from was_planheader order by PLANID DESC;";
									$res=$db->RunQuery($sql);
									while($row=mysql_fetch_assoc($res)){
										echo "<option value=\"".$row['PLANID']."\">".$row['PLANID']."</option>";	
									}
									?> 
                                    </select>
									
									
									</td>
                                    <td class="normalfnt" width="127">&nbsp;</td>
                                    <td width="256" class="normalfntMid">Plan Number</td>
                                    <td class="normalfnt" width="172"><input type="text" id="txtPlanNo" name="txtPlanNo"/></td>
                                    <td width="93" class="normalfnt">&nbsp;</td>
                                </tr>
                            	
                                <tr class="mainHeading4">
                                	<td colspan="2" rowspan="2" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2" >
                                	  <tr bgcolor="#FFFFFF">
                                	    <td><table width="100%" border="0" cellspacing="0" cellpadding="2" class="bcgl1">
                                	      <tr bgcolor="#FFFFFF">
                                	        <td class="nor">&nbsp;PO List</td>
                              	        </tr>
                                	      <tr>
                                	        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="36%">&nbsp;
                                        <select name="cboSearchPo" id="cboSearchPo" class="txtbox" style="width:90px" onchange="searchBy(this);">
                                          <option value="" selected="selected">All</option>
                                          <option value="0">Not Planed</option>
                                          <option value="1">Planed</option>
                                          <option value="2">Color</option>
                                      </select></td>
                                      <td width="51%" id="cellSearch"><div id="divPONOSearch"><input type="text" name="txtSearchPONo" id="txtSearchPONo" class="txtbox" width="100px" onkeypress="searchPOList(event);" /></div><div id="divColorSearch" style="display:none"><input type="text" name="txtSearchColor" id="txtSearchColor" class="txtbox" width="100px" onkeypress="searchPOList(event);" /></div></td>
                                      <td width="13%"><img src="../../images/search_1.png" alt="" name="btnSearch" width="15" height="15" id="btnSearch" onclick="searchPO();"/></td>
                                    </tr>
                                  </table></td>
                              	        </tr>
                              	      </table></td>
                              	    </tr>
                              	  </table></td>
                                	<td  class="normalfnt">Pool </td>
                                    <td class="normalfnt"></td>
                                    <td  class="normalfnt"><select id="machineLoading_txtTimeIn" name="machineLoading_txtTimeIn" onchange="setTimeLine(this);" style="display:none">
                                   		<option value="">Select One</option>
                                        <?php
                                        $sql="select distinct intShiftId,strShiftName from was_shift where intStatus=1 order by intShiftId;";
										$res=$db->RunQuery($sql);
										while($row=mysql_fetch_assoc($res)){
											echo "<option value=\"".$row['intShiftId']."\">".$row['strShiftName']."</option>";
										}
										?> 
                                    </select> 
                                    <!--<input type="text" id="machineLoading_txtTimeIn" style="width:100px;" onchange="setTimeLine(this);" />--></td>
                                    <td class="normalfnt">Date&nbsp;
                                      <input type="text" name="wasOther_txtDateS" id="wasOther_txtDateS" readonly="readonly" maxlength="10" style="width:100px;" value="<?php echo date('Y-m-d');?>"/></td>
                                    <td class="normalfnt">&nbsp;                                    </td>
                                </tr>
                                <tr class="mainHeading4">
                                  <td height="16" colspan="4"  class="normalfnt"><table width="705" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="85" style="color:#EDABE8">Pending</td>
                                        <td width="12" bgcolor="#EDABE8">&nbsp;</td>
                                        <td width="55">&nbsp;</td>
                                        <td width="85" style="color:#3F6">Planed</td>
                                        <td width="12" bgcolor="#3F6">&nbsp;</td>
                                        <td width="55">&nbsp;</td>
                                        <td width="85" style="color:#99F">Allocated</td>
                                        <td width="12" bgcolor="#99F">&nbsp;</td>
                                        <td width="55">&nbsp;</td>
                                        <td width="85" style="color:#D77E9F">Merged</td>
                                        <td width="12" bgcolor="#D77E9F">&nbsp;</td>
                                        <td width="55">&nbsp;</td>
                                        <td width="85" style="color:#648E4B">RC Printed</td>
                                        <td width="12" bgcolor="#648E4B">&nbsp;</td>
                                        
                                    </tr>
                                  </table></td>
                                  <td class="normalfnt">&nbsp;</td>
                                </tr>
                                </thead>
                              <!--onmouseover="mOver();"-->
                                <tbody id="tblBody" class="board" >
                                <tr>
									<?php 
									$lastmonth = Date('Y-m-d',mktime(0, 0, 0, date("m")+1, date("d"),   date("Y")));
									$sqlPo="SELECT DISTINCT
											o.strOrderNo,
											o.intQty,
											ds.dtDateofDelivery,
											SP.intStyleId,
											o.reaExPercentage,
											SR.strColor,
											(select sum(dblPlanedQty) from was_planlotpool 
											where was_planlotpool.intStyleId=o.intStyleId 
											group by was_planlotpool.intStyleId) as planedQty
											FROM
											specification SP
											INNER JOIN orders AS o ON SP.intStyleId = o.intStyleId
											INNER JOIN styleratio AS SR ON SR.intStyleId=SP.intStyleId
											INNER JOIN deliveryschedule AS ds ON ds.intStyleId = o.intStyleId
											WHERE SP.intStyleId IN (select intStyleId from was_actualcostheader)
											order by planedQty;";
										
									$resPo=$db->RunQuery($sqlPo);
									?>
                                   <!--onmouseover=\"mOver();\"-->
                                   
                                	<td rowspan="15" align="left" valign="top"  style="border: 1px solid #CCC;">
                                    <div style="overflow:scroll; height:330px;background:#FFC;width:180px;" class="0 droptarget" id="lot_crt_poList" align="left" >
                                    <?php
                                    while($rowPo=mysql_fetch_array($resPo))
									{
										$tot=round(($rowPo['intQty']+($rowPo['intQty']*($rowPo['reaExPercentage']/100) )),0);
										if($tot==$rowPo['planedQty'])
										{
											continue;
										}
										$notecard = "<a alter=\"".$rowPo['intStyleId']."\" id=\"item".$rowPo['intStyleId']."\" draggable=\"true\" href=\"#\">";
										$notecard .= "<div draggable=\"true\" alter=\"".$rowPo['intQty']."~".$rowPo['reaExPercentage']."\" ";
										if($rowPo['planedQty']=="")
										{
										$notecard .= "style=\"background:#EDABE8; border: 1px solid #639; width: 160px; height: 25px; float: none; cursor: arm; z-index: -1; position: static;text-align:left;font-size:10px;\"";
										}
										else
										{
										$notecard .= "style=\"background:#3F6; border: 1px solid #639; width: 160px; height: 25px; float: none; cursor: arm; z-index: -1; position: static;text-align:left;font-size:10px;\"";
										}
										$notecard .= "class=\"drag\" id=\"".$rowPo['intStyleId']."\">";
										$notecard .= "<label id=\"lblPO\">PO :-</label>";
										$notecard .= "<label id=\"lblPONo\">" . $rowPo['strOrderNo'] ."</label><br />";
										$notecard .= "<label style=\"display:none;\" id=\"lblOQty\">Order Qty:-</label>";
										$notecard .= "<label style=\"display:none;\" id=\"lblPoQty\">" . $rowPo['intQty'] ."</label><br />";
										$notecard .= "<label style=\"display:none;\" id=\"lblTot\">Total Qty:-</label>";
										$notecard .= "<label style=\"display:none;\" id=\"lblTotQty\">".$tot."</label><br />";
										
										$notecard .= "<label style=\"display:none;\" id=\"lblPlaned\">Planed Qty:-</label>";
										$notecard .= "<label style=\"display:none;\" id=\"lblPlanedQty\">0</label><br />";
										$notecard .= "<label style=\"display:none;\" id=\"lblBalance\">Balance Qty:-</label>";
										if($rowPo['planedQty']=="")
										{
										$notecard .= "<label style=\"display:none;\" id=\"lblBalanceQty\">" . $tot . "</label>";			
										}
										else
										{
										$notecard .= "<label style=\"display:none;\" id=\"lblBalanceQty\">" . ($tot-$rowPo['planedQty']) . "</label>";
										}
										$notecard .= "</div>";
										/*$notecard .= "<label>Test</label>";*/
										$notecard .= "</a>";
										
										echo $notecard;
									 }
									  ?>
                                    </div>
                                    </td>
                                    <td colspan="5" rowspan="2" valign="top">
                                    	<table width="100%" border="0" >
                                        <tbody>
                                        	<tr>
                                        		<td width="110" class="normalfnt">&nbsp;</td>
                                                <td colspan="2" rowspan="4" valign="top" class="0 droptarget" id="lot_StripPool" style="border: 1px solid #CCC; background:#FFC;">&nbsp;</td>
                                            </tr>
                                            <tr>
                                        		<td class="normalfnt">&nbsp;</td>
                                            </tr>
                                            <tr>
                                        		<td class="normalfnt">&nbsp;</td>
                                            </tr>
                                            <tr>
                                        		<td class="normalfnt">&nbsp;</td>
                                            </tr>
                                            <tr>
                                        		<td class="normalfnt">&nbsp;</td>
                                                <td colspan="2" class="normalfnt" style="background:#99F">Time Line</td>
                                            </tr>
                                            <tr>
                                        		<td class="normalfnt" style="background:#99F;" height="22">Machine No</td>
                                                <td colspan="2" id="timeLineArea">
                                                <table style="border:solid #CCC 0px;width:1440px;" cellspacing="0">
                                                <tr style="height:20px;">
                                                <?php
												for($i=1;$i<25;$i++)
												{
												?>
												 <td style="border:solid #CCC 1px;width:60px;font-size:10px;background:#66F;color:#FF0;"><?php echo $i; ?></td>	
                                                 <?php
												}
												?>
                                                </tr>
                                                </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                            <tbody id="tblmid">
                                             <?php 
								$machineDets = array();
								$sql="	SELECT
										was_machine.strMachineName,
										was_machine.intCapacity,
										was_machinetype.dblOHCostMin,
										was_machine.intMachineId,
										was_machine.intMachineType
										FROM
										was_machine
										INNER JOIN was_machinetype ON was_machinetype.intMachineId = was_machine.intMachineType
										WHERE
										was_machinetype.intStatus = '1'
										ORDER BY
										was_machine.strMachineName ASC;";
								$res=$db->RunQuery($sql);
								$c=0;
								while($row=mysql_fetch_array($res)){
									$machineDets[$c][0] = $row['intMachineId'];
									$machineDets[$c][1] = $row['strMachineName'];
									$machineDets[$c][2] = $row['intCapacity'];
									$machineDets[$c][3] = $row['dblOHCostMin'];
									$machineDets[$c][4] = $row['intMachineType'];
									
									$c++;
								}

								for ($i=0; $i < count($machineDets); $i++){ ?> 
								<tr id='<?php echo $machineDets[$i][4];?>/<?php echo $machineDets[$i][2];?>' height="22" >
                                                <td class="normalfnt" colspan="1" style="background:#CCF;border-right:solid 1px #999" width="110" id="<?php echo $machineDets[$i][0]."m";?>"><?php echo $machineDets[$i][1];?></td>
                                                <td colspan="5" class="0 droptarget" style="background:#CCF" id="<?php echo $machineDets[$i][0]."mac"; ?>"  alter="lot_crt_machineList" abbr="<?php echo $machineDets[$i][3] ;?>"></td>
                                            </tr>
								
								<?php }?>
                        <tr id="" height="22" >
                        <td class="normalfnt" colspan="1" style="background:#CCF;border-right:solid 1px #999" width="110" id="">Merge Lot</td>
                        <td width="378" class="0 droptarget" id="mac" abbr="0" style="background:#CCF" alter="merge_lotList" ></td>
                        <td class="0 droptarget" style="background:#CCF" width="507" id="merge_lot"  alter="merge_lotListing" ></td>
                        </tr>
								
                                </tbody>
                                        </table>
                                    </td>
                                	<td height="110" align="center" style="border-bottom:solid #CCC 1px;" id="lot_crt_recycle" class="0 droptarget">
                                    	
                                        	<img src="2.png" width="75" height="75" />
                                        
                                        
                                  </td>
                                  </tr>
                                <tr>
                                  <td class="normalfnt">&nbsp;</td>
                                </tr>
                               
                                </tbody>
                            </table>
                        </td>

  </tr>
</table>

<table align="center" width="1860">
	<tr>
    	<td align="center"> 
            <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <img src="../../images/new.png" onclick="clearAll();"  />
                    <img src="../../images/save.png" id="btnSave" name="btnSave" onclick="savePlan();"/>
                    <img src="../../images/report.png" id="btnSave" name="btnReport" onclick="viewReport();"/>
                    <img src="../../images/close.png" />
                </td>   
            </tr>
            </table>
       </td>   
    </tr>
</table>
<div style=" padding: 1px; display: none; position: absolute; background-color: rgb(238, 238, 238); top: 667px; left: 330px;" id="grid_menu" class="menu_css">

			<table width="120" id='menu-hide' class="normalfnt" cellpadding="1">
            	
                <tr>
                    <td id="Merge_Lot" class=" menu_hoverz" height="15"><img src="../../images/merge.png" width="16px" height="16px"> &nbsp; Merge Lots</td>
                </tr>  
            </table>
		
</div>
</form>
</body>
</html>