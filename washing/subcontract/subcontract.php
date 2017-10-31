<?php
	session_start();
	include("../../Connector.php");
	$backwardseperator = "../../";	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Washing - Sub Contract</title>
<link href="../../js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css/">
<link href="../../css/tableGrib.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script type="text/javascript" src="subcontractor.js"></script>
<script type="text/javascript">
$(function(){
	// TABS
	$('#tabs').tabs();
});
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
<table width="100%" align="center">
	<tr>
    	<td><?php include "{$backwardseperator}Header.php"; ?></td>
	</tr>
</table>
<table width="800" align="center" class="tableBorder">
<tr>
	<td class="mainHeading">Sub Contract </td>
</tr>
<tr>
    <td>
		<div  id="tabs" style="background-color:#FFFFFF">
		<ul>
			<li><a href="#tabs-1" class="normalfnt" onclick="setStyleAndPo(1);">Send </a></li>
			<li><a href="#tabs-2" class="normalfnt" onclick="setStyleAndPo(2);">Receive </a></li>
		</ul>
				<div id="tabs-1">
              <form id="frmWasSubContract_send" name="frmWasSubContract_send">
					<table width="100%" border="0">
                    <tr >
						  <td width="2%" class="normalfnt" >&nbsp;</td>
							<td width="22%" class="normalfnt" >&nbsp;</td>
					  	    <td width="21%" class="normalfnt">&nbsp;</td>
							<td width="3%" class="normalfnt">&nbsp;</td>
				          <td width="25%" class="normalfnt">AOD No  </td>
						  <td width="26%" class="normalfnt"><input type="text" style="width: 150px;" class="txtbox" id="txtAODNo" name="txtAODNo" tabindex="2" disabled="disabled"/></td>
						  <td width="1%" class="normalfnt">&nbsp;</td>
						</tr>
						 
						
                       
				    <tr>
						  <td width="2%" class="normalfnt">&nbsp;</td>
							<td width="22%" class="normalfnt">Style No </td>
						  	<td width="21%" class="normalfnt"><select name="cboStyleNo2" style="width:150px;height:20px;" id="cboStyleNo2" tabindex="1" onchange="LoadOrderNo(this,0);">
						  	  <?php 
	$sql="select distinct O.strStyle from was_stocktransactions WS inner join orders O on O.intStyleId=WS.intStyleId WHERE WS.intCompanyId = '".$_SESSION['FactoryID']."' group by WS.intStyleId having sum(WS.dblQty) > 0  order by O.strStyle";
	
	$result =$db->RunQuery($sql); 
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row=mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
	}
	?>
					  	    </select></td>
							<td class="normalfnt">&nbsp;</td>
						    <td class="normalfnt">Order No <span class="compulsoryRed">*</span></td>
						    <td class="normalfnt"><select style="width: 151px;height:20px;" class="txtbox" id="cboOrderNo" name="cboOrderNo" tabindex="3" onchange="LoadColor(this,0)">
						      <?php
$sql="select distinct O.intStyleId,O.strOrderNo from was_stocktransactions WS inner join orders O on O.intStyleId=WS.intStyleId where WS.intCompanyId='".$_SESSION['FactoryID']."' group by WS.intStyleId order by O.strOrderNo"; //group by WS.intStyleId having sum(WS.dblQty) > 0
$result =$db->RunQuery($sql); 
echo "<option value=\"". "" ."\">" . "" ."</option>" ;
while($row=mysql_fetch_array($result))
{
echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
}
?>
					        </select></td>
						    <td class="normalfnt">&nbsp;</td>
						</tr>
                        <tr>
                        	<td width="2%" class="normalfnt">&nbsp;</td>
							<td width="22%" class="normalfnt">Sewing Factory <span class="compulsoryRed">*</span></td>
                            <td  class="normalfnt" colspan="4">
                            <select name="cboSubOutFromFac" id="cboSubOutFromFac" style="width:525px;" onchange="GetQtyWhenChangeSewFactory(this);" disabled="disabled">
                            	<option value="">Select Factory</option>
                                <?php
                                $sql_loadFactory="SELECT companies.intCompanyID,companies.strName FROM companies where intmanufacturing=1 AND companies.intCompanyID <> '".$_SESSION["FactoryID"]."'  order by companies.strName ;";
                  $resF=$db->RunQuery($sql_loadFactory);
                  while($rowF=mysql_fetch_array($resF))
                  {
                  ?>
                    <option value="<?php echo $rowF['intCompanyID'];  ?>"><?php echo $rowF['strName'];  ?></option>
                    <?php }?>
                            </select>
                            </td>
                            <td class="normalfnt">&nbsp;</td>
                        </tr> 
                         <tr>
                        	<td width="2%" class="normalfnt">&nbsp;</td>
							<td width="22%" class="normalfnt">Sub Contractor <span class="compulsoryRed">*</span></td>
                            <td  class="normalfnt" colspan="4"><select name="cboSContractor" style="width:525px;" id="cboSContractor" tabindex="4">
                              <?php
$sql="select WOC.intCompanyID,WOC.strName from was_outside_companies WOC where WOC.intStatus=1 order by WOC.strName";
$result=$db->RunQuery($sql);
	echo "<option value="."".">".""."</option>\n";
while($row=mysql_fetch_array($result))
{
	echo "<option value=".$row["intCompanyID"].">".$row["strName"]."</option>\n";
}
?>
                            </select></td>
                            <td class="normalfnt">&nbsp;</td>
                        </tr>
						<tr>
						  <td width="2%" class="normalfnt">&nbsp;</td>
							<td width="22%" class="normalfnt">Color <span class="compulsoryRed">*</span></td>
					  	  <td width="21%" class="normalfnt"><select style="width: 150px;height:20px;" id="cboColor" name="cboColor" tabindex="5" onchange="LoadDetails(this);">
                            <?php 
/*$sql="select distinct O.intStyleId,O.strOrderNo from was_stocktransactions WS inner join orders O on O.intStyleId=WS.intStyleId group by WS.intStyleId having sum(WS.dblQty) > 0 order by O.strOrderNo";*/
//$result =$db->RunQuery($sql); 
//echo "<option value=\"". "" ."\">" . "" ."</option>" ;
/*while($row=mysql_fetch_array($result))
{
echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
}*/
?>
                          </select></td>
							<td class="normalfnt">&nbsp;</td>
						    <td class="normalfnt">Vehicle No.</td>
						    <td class="normalfnt"><input type="text" name="subSend_vehicleNo" id="subSend_vehicleNo" style="width:150px;text-align:left"/></td>
						    <td class="normalfnt">&nbsp;</td>
						</tr>
						<tr>
						  <td class="normalfnt">&nbsp;</td>
						  <td class="normalfnt">Order Qty</td>
						  <td class="normalfnt"><input type="text" readonly="readonly" name="subSend_orderQty" id="subSend_orderQty" style="width:148px;text-align:right"/></td>
						  <td class="normalfnt">&nbsp;</td>
						  <td class="normalfnt" style="display:inline;">Wash Received Qty</td>
						  <td class="normalfnt"><input type="text" readonly="readonly" name="subSend_washRcvd" id="subSend_washRcvd" style="width:150px;text-align:right"/></td>
					      <td class="normalfnt">&nbsp;</td>
					  </tr>
						<tr>
						  <td class="normalfnt">&nbsp;</td>
						  <td class="normalfnt">Total Available Qty </td>
						  <td class="normalfnt"><input name="txtTotReceiveQty" type="text" disabled="disabled" class="txtbox" id="txtTotReceiveQty" style="width:148px;text-align:right" /></td>
						  <td class="normalfnt">&nbsp;</td>
						  <td class="normalfnt">Total send To out Qty </td>
						  <td class="normalfnt"><input name="txtSeToOut" type="text" disabled="disabled" id="txtSeToOut" style="width:150px;text-align:right" /></td>
					      <td class="normalfnt">&nbsp;</td>
					  </tr>
						<tr>
						  <td class="normalfnt">&nbsp;</td>
						  <td class="normalfnt">Send Now Qty <span class="compulsoryRed">*</span></td>
						  <td class="normalfnt"><input name="txtS_sendNow" type="text"class="txtbox" id="txtS_sendNow" style="width:148px;text-align:right" tabindex="6" onkeypress="return IsNumberWithoutDecimals(this,event);" onkeyup="ValidateBalQty(this);" maxlength="10"/></td>
						  <td class="normalfnt">&nbsp;</td>
						  <td class="normalfnt">Total Received From Out Qty </td>
						  <td class="normalfnt"><input name="txtReFrOut" type="text" disabled="disabled" id="txtReFrOut" style="width:150px;text-align:right" /></td>
					      <td class="normalfnt">&nbsp;</td>
					  </tr>
						<tr>
						  <td class="normalfnt">&nbsp;</td>
						  <td class="normalfnt">Total Balance Qty </td>
						  <td class="normalfnt"><input name="txtS_BalQty" type="text" disabled="disabled" id="txtS_BalQty" style="width:148px;text-align:right" /></td>
						  <td class="normalfnt">&nbsp;</td>
						  <td class="normalfnt">&nbsp;</td>
						  <td class="normalfnt"  style="display:none">
                          <span>Normal</span>
                          &nbsp;<span><input type="radio" name="rdoSubPrc" checked="checked" id="chkSubPrcN" value="0"/></span>&nbsp;
                          <span>Rewash</span>
                          <span>&nbsp;<input type="radio" name="rdoSubPrc" value="1" id="chkSubPrcR"/></span></td>
					      <td class="normalfnt">&nbsp;</td>
					  </tr>
                      <tr>
                        	<td width="2%" class="normalfnt">&nbsp;</td>
							<td width="22%" class="normalfnt">Remarks</td>
                            <td  class="normalfnt" colspan="4"><textarea style="width: 524px;height:30px" class="txtbox" id="txtPurpose" name="txtPurpose" tabindex="6" onkeypress="setMaxLength(this)"></textarea></td>
                            <td class="normalfnt">&nbsp;</td>
                      </tr>
					</table>
<br />		
			<!--<div style="overflow:scroll; height:360px; width:698px;">
			<div style="overflow:scroll; height:360px; width:100%;" class="tableBorder"></div>-->

					<table width="100%" border="0" class="tableFooter" align="center">
						<tr>
							<td width="37%" align="center">
							<img src="../../images/new.png" id="butNew" onclick="ClearForm(0);" tabindex="10" title="Click to clear the page"/>
							<img src="../../images/save.png" name="Save" width="80" id="Save" title="Click to save details" onclick="Save_Send();" tabindex="7"/>
							<img src="../../images/report.png" id="butReport" alt="report" tabindex="8" title="Click to view report" onclick="loadGP();" style="display:none;"/>
							<a href="../../main.php"><img src="../../images/close.png" id="butClose" alt="close" tabindex="9" border="0" title="Click to go to main page"/></a>							</td>
						</tr>
					</table>
                  </form>
				</div>
				<div id="tabs-2">
				 <form id="frmWasSubContract_receive" action="" name="frmWasSubContract_receive" method="post">
					<table width="100%" border="0">
						<tr >
						  <td width="2%" class="normalfnt" >&nbsp;</td>
							<td width="22%" class="normalfnt" ></td><!--Sent AOD No-->
					  	    <td width="21%" class="normalfnt"><select  style="width:148px;display:none;" name="subSentAODSearch" id="subSentAODSearch"  onchange="GetSentAODDets(this,event);" > 
                            <option value="">Select AOD No.</option>
                            <?php 
							$sqlA="SELECT concat(was_subcontractout.intAODYear,'/',was_subcontractout.intAODNo) as AOD FROM was_subcontractout ORDER BY was_subcontractout.intAODNo ASC;";
							$res=$db->RunQuery($sqlA);
							while($row=mysql_fetch_array($res)){
								echo "<option value=\"".$row['AOD'] ."\">".$row['AOD']."</option>";
							}
							?>
                            </select></td>
							<td width="3%" class="normalfnt">&nbsp;</td>
				          <td width="25%" class="normalfnt">AOD No <span class="compulsoryRed">*</span></td>
						  <td width="26%" class="normalfnt"><input type="text" style="width: 148px;" class="txtbox" id="txtReAODNo" name="txtReAODNo" tabindex="2" />
					      <input type="hidden" style="width: 50px;"  id="txtRe_SerialNo"   /></td>
						  <td width="1%" class="normalfnt">&nbsp;</td>
						</tr>
                        
				    <tr >
						  <td width="2%" class="normalfnt" >&nbsp;</td>
							<td width="22%" class="normalfnt" >Style No </td>
					  	    <td width="21%" class="normalfnt"><select name="cboStyleNo" style="width:150px;height:20px;" id="cboStyleNo" tabindex="1" onchange="LoadOrderNo(this,1);">
	<?php 
	$sql="select distinct O.strStyle
from was_stocktransactions WS 
inner join orders O on O.intStyleId=WS.intStyleId 
where (COALESCE((select sum(dblQty) from was_stocktransactions WS where strType='SubOut' group by WS.intStyleId,WS.strColor),0) +
COALESCE((select sum(dblQty) from was_stocktransactions WS where strType='SubIn' group by WS.intStyleId,WS.strColor),0)) < 0 and WS.strType in('SubOut','SubIn') order by O.strStyle";

$sql="select distinct O.strStyle
from was_stocktransactions WS 
inner join orders O on O.intStyleId=WS.intStyleId 
where  WS.strType='SubOut' -- and WS.intCompanyId='".$_SESSION['FactoryID']."'
order by O.strStyle";

	$result =$db->RunQuery($sql); 
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row=mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
	}
	?>
						 </select>						</td>
							<td width="3%" class="normalfnt">&nbsp;</td>
				          <td width="25%" class="normalfnt">Order No <span class="compulsoryRed">*</span></td>
						  <td width="26%" class="normalfnt"><select style="width: 150px;height:20px;" class="txtbox" id="cboReOrderNo" name="cboReOrderNo" tabindex="3" onchange="LoadColor(this,1)">
						    <?php
$sql="select distinct O.intStyleId,O.strOrderNo
from was_stocktransactions WS 
inner join orders O on O.intStyleId=WS.intStyleId 
where (COALESCE((select sum(dblQty) from was_stocktransactions WS where strType='SubOut' group by WS.intStyleId,WS.strColor),0) +
COALESCE((select sum(dblQty) from was_stocktransactions WS where strType='SubIn' group by WS.intStyleId,WS.strColor),0)) < 0 and WS.strType in('SubOut','SubIn') order by O.strStyle";

$sql="select distinct O.intStyleId,O.strOrderNo
from was_stocktransactions WS 
inner join orders O on O.intStyleId=WS.intStyleId 
where  WS.strType='SubOut' -- and WS.intCompanyId='".$_SESSION['FactoryID']."'
order by O.strOrderNo";
$result =$db->RunQuery($sql); 
echo "<option value=\"". "" ."\">" . "" ."</option>" ;
while($row=mysql_fetch_array($result))
{
echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
}
?>
					      </select></td>
						  <td width="1%" class="normalfnt">&nbsp;</td>
						</tr>
						<tr>
						  <td width="2%" class="normalfnt">&nbsp;</td>
							<td width="22%" class="normalfnt">Sewing Factory</td>
						  	<td  class="normalfnt" colspan="4">
                            <select name="cboSubInSFromFac" id="cboSubInSFromFac" style="width:525px;" disabled="disabled" >
                            <option value=""></option>
                                <?php
                                $sql_loadFactory="SELECT companies.intCompanyID,companies.strName FROM companies where companies.intCompanyID <> '".$_SESSION["FactoryID"]."'  order by companies.strName ;";
                  $resF=$db->RunQuery($sql_loadFactory);
                  while($rowF=mysql_fetch_array($resF))
                  {
                  ?>
                    <option value="<?php echo $rowF['intCompanyID'];  ?>"><?php echo $rowF['strName'];  ?></option>
                    <?php }?>
                            </select></td>
						    <td class="normalfnt">&nbsp;</td>
						</tr>
						<tr>
						  <td width="2%" class="normalfnt">&nbsp;</td>
							<td width="22%" class="normalfnt">Color <span class="compulsoryRed">*</span></td>
					  	  <td width="21%" class="normalfnt"><select style="width: 150px;height:20px;" id="cboReColor" name="cboReColor" tabindex="5" onchange="LoadReDetails(this);">
                            <?php
/*$sql="select distinct O.intStyleId,O.strOrderNo from was_stocktransactions WS inner join orders O on O.intStyleId=WS.intStyleId group by WS.intStyleId having sum(WS.dblQty) > 0 order by O.strOrderNo";
$result =$db->RunQuery($sql); 
echo "<option value=\"". "" ."\">" . "" ."</option>" ;
while($row=mysql_fetch_array($result))
{
echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
}*/
?>
                          </select></td>

						</tr>
						<tr>
						  <td class="normalfnt">&nbsp;</td>
						  <td class="normalfnt">Sub Contractor <span class="compulsoryRed">*</span></td>
						  <td class="normalfnt" colspan="4"><select name="cboRe_SContractor" style="width:525px;" id="cboRe_SContractor" tabindex="4" onchange="getSubCompanyWiseQty(this);">
						    <?php
$sql="select WOC.intCompanyID,WOC.strName from was_outside_companies WOC where WOC.intStatus=1 order by WOC.strName";
$result=$db->RunQuery($sql);
	echo "<option value="."".">".""."</option>\n";
while($row=mysql_fetch_array($result))
{
	echo "<option value=".$row["intCompanyID"].">".$row["strName"]."</option>\n";
}
?>
					      </select></td>
						  <td class="normalfnt">&nbsp;</td>

					  </tr>
						<tr>
						  <td class="normalfnt">&nbsp;</td>
						  <td class="normalfnt">Balance To  Receive Qty </td>
						  <td class="normalfnt"><input name="txtRe_BalToReQty" type="text" disabled="disabled" class="txtbox" id="txtRe_BalToReQty" style="width:148px;text-align:right" /></td>
						  <td class="normalfnt">&nbsp;</td>
						  <td class="normalfnt">Total send To out Qty </td>
						  <td class="normalfnt"><input name="txtRe_ToOut" type="text" disabled="disabled" id="txtRe_ToOut" style="width:148px;text-align:right" /></td>
					      <td class="normalfnt">&nbsp;</td>
					  </tr>
						<tr>
						  <td class="normalfnt">&nbsp;</td>
						  <td class="normalfnt">Receive Now Qty <span class="compulsoryRed">*</span></td>
						  <td class="normalfnt"><input name="txtRe_ReNow" type="text"class="txtbox" id="txtRe_ReNow" style="width:148px;text-align:right" tabindex="6" onkeypress="return IsNumberWithoutDecimals(this,event);" onkeyup="ValidateReBalQty(this);" maxlength="10"/></td>
						  <td class="normalfnt">&nbsp;</td>
						  <td class="normalfnt">Total Received From Out Qty </td>
						  <td class="normalfnt"><input name="txtRe_ReFrOut" type="text" disabled="disabled" id="txtRe_ReFrOut" style="width:148px;text-align:right" /></td>
					      <td class="normalfnt">&nbsp;</td>
					  </tr>
						<tr>
						  <td class="normalfnt">&nbsp;</td>
						  <td class="normalfnt">Balance Now Qty </td>
						  <td class="normalfnt"><input name="txtRe_BalQty" type="text" disabled="disabled" id="txtRe_BalQty" style="width:148px;text-align:right" /></td>
						  <td class="normalfnt">&nbsp;</td>
						  <td class="normalfnt">&nbsp;</td>
						  <td class="normalfnt">&nbsp;</td>
					      <td class="normalfnt">&nbsp;</td>
					  </tr>
                      <tr>
						  <td class="normalfnt">&nbsp;</td>
						  <td class="normalfnt">Remarks</td>
						  <td class="normalfnt" colspan="4"><textarea type="text" style="width: 521px;height:30px;" class="txtbox" id="txtRe_Purpose" name="txtRe_Purpose" tabindex="6" onkeypress="setMaxLength(this)"></textarea></td>
						  <td class="normalfnt">&nbsp;</td>

					  </tr>
					</table>
<br />		
			<!--<div style="overflow:scroll; height:360px; width:698px;">
			<div style="overflow:scroll; height:360px; width:100%;" class="tableBorder"></div>-->

					<table width="100%" border="0" class="tableFooter" align="center">
						<tr>
							<td width="37%" align="center">
							<img src="../../images/new.png" id="butNew" onclick="ClearForm(1);" tabindex="10" title="Click to clear the page"/>
							<img src="../../images/save.png" id="butSaveR" width="80" onclick="Save_Receive();" tabindex="7" title="Click to save details"/>
							<img src="../../images/report.png" id="butSave" alt="report" tabindex="8" title="Click to view report" onclick="showRptPoUp();" style="display:none;"/>
							<a href="../../main.php"><img src="../../images/close.png" id="butClose" alt="close" tabindex="9" border="0" title="Click to go to main page"/></a>
							</td>
						</tr>
					</table>
                  </form>
		  </div>
	  </div>	
</td>
	</tr>
</table>
</body>
</html>