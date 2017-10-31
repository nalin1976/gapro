<?php
	session_start();
	$backwardseperator = "../../";
	include "../../Connector.php";		
	include "{$backwardseperator}authentication.inc";
	$companyId=$_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro :: Washing - Actual Cost</title>
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
-->
#tblDet tr{
	/*background:#9CF;*/
	border:solid #006 1px;}
</style>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="actualcost.js?n=1"></script>
<script type="text/javascript" src="actualcostOutSide.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<script type="text/javascript" src="../javascript/tablednd.js"></script>


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

<body>
<form id="frmmain" name="frmmain" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include($backwardseperator.'Header.php'); ?></td>
	</tr> 
</table>
<!--<div class="main_bottom_center">
	<div class="main_top"><div class="main_text">Actual Cost</div></div>
<div class="main_body">-->

  <table width="800" align="center" cellpadding="1" cellspacing="1" border="0" class="tableBorder">
  	<tr>
  		<td class="mainHeading">Wash Cost</td>
  	</tr>
    <tr>
      <td width="800" height="75" valign="top">
      	<table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td>
            <table border="0" width="100%" align="center">
                <tr>
                  <td>
                  <fieldset class="fieldsetStyle" style="width:800px;-moz-border-radius: 5px;">
                  	<table align="center" cellpadding="1" cellspacing="0" class="normalfnt" width="100%" border="0">
                  	  <tr>
                        <td width="120"  class="normalfnt">Style No</td>
                        <td width="152"  ><select name="cboStyleId" class="txtbox" style="width:150px" id="cboStyleId" tabindex="1" onchange="LoadStyleWiseOrderNo(this.value);">
                          <?php
$sql="SELECT  DISTINCT O.strStyle
FROM   orders O INNER JOIN  was_washpriceheader WPH ON O.intStyleId = WPH.intStyleId 
WHERE   (O.intStyleId NOT IN 
(SELECT     BCH.intStyleId From was_actualcostheader BCH
WHERE (intStatus = 1)))";
$result=$db->RunQuery($sql); 
	echo "<option value="."".">Select One</option>";
while($row=mysql_fetch_array($result))
{ 
	echo "<option value=".$row["strStyle"].">".$row["strStyle"]."</option>";
} 
?>
                        </select></td>
                        <td width="21"  class="normalfnt">&nbsp;</td>
                        <td width="46"  >&nbsp;</td>
                        <td colspan="2" class="normalfnt">Serial No.: </td>
                        <td colspan="4" class="normalfnt">
                          <input type="text" readonly="readonly" name="txtSampleNo" id="txtSampleNo" class="txtbox" style="text-align:right;width:100px" /></td>
                        <td width="124" align="center"><img src="../../images/search.png" onclick="loadPrevious();" style="cursor:pointer;"/></td>
                      </tr>
                      <tr>
                        <td width="120"  class="normalfnt"><span class="normalfnt" style="width:120px;">PO No </span> <span class="compulsoryRed"> *</span></td>
                        <td width="152"  ><select name="cboOrderNo" class="txtbox" style="width:150px" id="cboOrderNo" onchange="LoadMainFabAndMill(this.value);LoadWashPriceDetails(this);LoadOrderDetails(this.value);"  tabindex="2">
                          <?php
$sql="SELECT  DISTINCT O.intStyleId,O.strOrderNo
FROM   orders O INNER JOIN  was_washpriceheader WPH ON O.intStyleId = WPH.intStyleId 
WHERE   (O.intStyleId NOT IN 
(SELECT     BCH.intStyleId From was_actualcostheader BCH
WHERE (intStatus = 1)))";
$result=$db->RunQuery($sql); 
	echo "<option value="."".">Select One</option>";
while($row=mysql_fetch_array($result))
{ 
	echo "<option value=".$row["intStyleId"].">".$row["strOrderNo"]."</option>";
} 
?>
                        </select></td>
                        <td width="21"  class="normalfnt">&nbsp;</td>
                        <td width="46"  >&nbsp;</td>
                        <td colspan="2" class="normalfnt">Revision No </td>
                        <td colspan="4" class="normalfnt"><input type="text" id="txtRevNumber" name="txtRevNumber" style="text-align:right;width:100px"  readonly="readonly"/></td>
                        <td width="124" align="center">&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="120" class="normalfnt" style="width:120px;">Company Name<span class="compulsoryRed">*</span></td>
                        <td colspan="10"><select name="cboCustomer" class="txtbox" style="width:485px;" id="cboCustomer" tabindex="3" onchange="LoadBranch(this.value);" >
                          <?php
						$sql="select strName,intCompanyID from companies where intStatus=1  order by strName";
						$result=$db->RunQuery($sql);
							echo "<option value="."".">"."Select One"."</option>\n";
						while($row=mysql_fetch_array($result))
						{
							echo "<option value=".$row["intCompanyID"].">".$row["strName"]."</option>\n";
						}
						?>
                        </select></td>
                        
                       
                      </tr>
                      <tr>
                        <td width="120" class="normalfnt" style="width:120px;"><span class="normalfnt" style="width:120px;">Fabric Name<span class="compulsoryRed"> *</span></span></td>
                        <td><select name="cboMainFabric" class="txtbox" style="width:150px" id="cboMainFabric" onchange="LoadDescription();" tabindex="4">
                          <option value="">Select One</option>
                        </select></td>
                        <td class="normalfnt">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td width="100"  class="normalfnt" style="width:100px;">Order Qty </td>
                        <td width="52" class="normalfnt">&nbsp;</td>
                        <td width="72" class="normalfnt"><input name="txtOrderQty" type="text" class="txtbox" id="txtOrderQty" style="text-align:right;width:70px" onkeypress="return CheckforValidDecimal(this.value, 4,event);" tabindex="16" /></td>
                        <td width="50"  class="normalfnt" style="width:50px;" >&nbsp; Ex<span class="normalfnt" style="width:50px;">
                          <input name="txtExPercent" type="text" class="txtbox" id="txtExPercent" style="text-align:right;width:20px" onkeypress="return CheckforValidDecimal(this.value, 4,event);" tabindex="16" />
                        </span></td>
                        <td width="25" class="normalfnt"><span class="normalfnt" style="width:50px;">
                          %</span></td>
                        <td width="16" class="normalfnt">=</td>
                        <td class="normalfnt"><input name="txtTotalQty" type="text" class="txtbox" id="txtTotalQty" style="text-align:right;width:80px" onkeypress="return CheckforValidDecimal(this.value, 4,event);" tabindex="16" /></td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Color <span class="compulsoryRed">*</span></td>
                        <td colspan="3">
						<!--<select name="cboOrderNo" class="txtbox" style="width:150px" id="cboOrderNo" onchange="SeachSC();LoadBuyerPoNo();LoadWashPriceDetails(this);"  tabindex="3">-->
						<select name="cboColor" class="txtbox" style="width:150px" id="cboColor" tabindex="5">
						  <option value="">Select One</option>
						  </select></td>
                        <td colspan="2" class="normalfnt">Mill</td>
                        <td colspan="4" >
                          <select name="cboMill" class="txtbox" style="width:150px;" id="cboMill" tabindex="10">
                          <option value="">Select One</option>
                       	  </select>                       
                        </td>
                        <td width="124">&nbsp;</td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Branch<span class="compulsoryRed"> *</span></td>
                        <td width="152"><select name="cboBranch" class="txtbox" style="width:150px" id="cboBranch" tabindex="6">
                          <option value="">Select One</option>
                        </select></td>
                        <td width="21" class="normalfnt">&nbsp;</td>
                        <td width="46">&nbsp;</td>
                        <td colspan="2" class="normalfnt">Style Description</td>
                        <td colspan="4" class="normalfnt" align="right"><input name="txtDescription" type="text" class="txtbox" id="txtDescription" style="width:150px" onkeypress="return CheckforValidDecimal(this.value, 4,event);" tabindex="11" /></td>
                        <td class="normalfnt">&nbsp;</td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Wash Type<span class="compulsoryRed"> *</span></td>
                        <td colspan="3"><select name="cboWashType" class="txtbox" style="width:150px" id="cboWashType" tabindex="7">
                        <option value="">Select One</option>
                        </select></td>
                        <td colspan="2" class="normalfnt">Division</td>
                        <td colspan="4" class="normalfnt">
                        <select name="cboDivision" class="txtbox" style="width:150px" id="cboDivision" tabindex="12">
                        	<option value="">Select One</option>
                        </select>                        
                        </td>
                        <td class="normalfnt">&nbsp;</td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Machine Type<span class="compulsoryRed"> *</span></td>
                        <td colspan="3"><select name="cboMachineType" class="txtbox" style="width:150px" id="cboMachineType" tabindex="8" onchange="selectMaxCapacity(this);">
                          <option value="">Select One</option>
                          <?php
							$sql="select intMachineId,strMachineType from  was_machinetype;";
							$result=$db->RunQuery($sql);
							while($row=mysql_fetch_array($result))
							{
								echo "<option value=".$row["intMachineId"].">".$row["strMachineType"]."</option>\n";
							}
						?>
                        </select></td>
                        <td colspan="2" class="normalfnt">Garment Type <span class="compulsoryRed">*</span> </td>
                        <td colspan="4" class="normalfnt">
						<select name="cboGarmentType" class="txtbox" style="width:150px" id="cboGarmentType" tabindex="13">
                        	<option value="">Select One</option>
                        </select>						</td>
                        <td class="normalfnt">&nbsp;</td>
                      </tr>
                      <tr>
                        <td class="normalfnt">No Of Pcs <span class="compulsoryRed">*</span></td>
                        <td colspan="3"><input name="txtNoOfPcs" type="text" class="txtbox" id="txtNoOfPcs" style="text-align:right;width:100px" onkeypress="return isValidZipCode(this.value,event);" tabindex="9" onkeyup="checkDecimals(this);" maxlength="10"/></td>
                        <td colspan="2" class="normalfnt">Weight <span class="compulsoryRed">*</span></td>
                        <td colspan="4" class="normalfnt" align="right"><input name="txtWeight" type="text" class="txtbox" id="txtWeight" style="text-align:right;width:100px" onkeypress="return CheckforValidDecimal(this.value, 2,event);" tabindex="14" onkeyup="checkfirstDecimal(this);" onchange="checkLastDecimal(this);" maxlength="10"/>
                          Kg</td>
                        <td class="normalfnt">&nbsp;</td>
                      </tr>
                      <tr>
                        <td class="normalfnt"><span class="normalfnt" style="width:10px;">
                          <input type="radio" name="rdoCategory" id="rdoInHouse2" checked="checked" value="0" onclick="loadActCostTypeData(this);" />
                        </span> <span class="normalfnt" style="width:100px;">In House</span></td>
                        <td valign="middle"><option value=""><span class="normalfnt" style="width:10px;">
                          <input type="radio" name="rdoCategory" id="rdoOutSide2" value="1" onclick="loadActCostTypeData(this);" />
                        </span><span class="normalfnt" style="width:100px;">Out Side </span></option></td>
                        <td valign="middle">&nbsp;</td>
                        <td valign="middle">&nbsp;</td>
                        <td colspan="2" class="normalfnt">Total Handling Time<span class="compulsoryRed"> *</span></td>
                        <td colspan="4" class="normalfnt"><input name="txtTotHTime" type="text" class="txtbox" id="txtTotHTime" style="text-align:right;width:100px" onkeypress="return CheckforValidDecimal(this.value,1,event);" tabindex="15" onkeyup="checkfirstDecimal(this);" onchange="checkLastDecimal(this);" maxlength="10"/>
Min</td>
                        <td class="normalfnt"><img src="../../images/additem2.png" onclick="LoadProcess();" /></td>
                      </tr>
                      <tr>
                        <td class="normalfnt">&nbsp;</td>
                        <td valign="middle">&nbsp;</td>
                        <td valign="middle">&nbsp;</td>
                        <td valign="middle">&nbsp;</td>
                        <td colspan="2" class="normalfnt">&nbsp;</td>
                        <td colspan="4" class="normalfnt">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                      </tr>
                  	</table>
                  </fieldset>                  </td>                  
                </tr>            
            </table>            </td>
          </tr>
      	</table>	  </td>
    </tr>
    <tr>
      <td valign="top" align="">
      	<table cellpadding="0" cellspacing="0" border="0" id="">
          <tr>
            <td height="17" class="containers"><div align="center"><b>Details</b></div></td>
          </tr>
          <tr>
            <td colspan="2" width="100%">
            <fieldset class="fieldsetStyle" style="width:800px;-moz-border-radius: 5px;">
            <div id="divcons" style="overflow:scroll; height:280px">
              <table width="100%" id="tblMain" class="normaltxtmidb2"  cellpadding="0" cellspacing="1" border="0">
                  <thead>
                    <tr bgcolor="" height="20">
                      <td style="width:10px;" class="grid_header">&nbsp;</td>
                      <td style="width:10px;" class="grid_header"> No </td>
                      <td style="width:150px;" class="grid_header">Process Description</td>
                      <td style="width:70px;"class="grid_header">Liquor(L)</td>
                      <td style="width:70px;" class="grid_header">Temperature(C)</td>
                      <td style="width:60px;"class="grid_header">Time(mins)</td>
                      <td style="width:80px;" class="grid_header">Chemical</td>
                      <td style="width:20px;"class="grid_header">Serial</td>
                      <td style="width:50px;"class="grid_header">PH Value</td>
                    </tr>
                  </thead>
                  <tbody id="tblDet" >
                  </tbody>        
              </table>
            </div>
            </fieldset>            </td>
          </tr> 
		  <script type="text/javascript" src="../javascript/tabledndDemo.js"></script>
      	</table>      </td>
    </tr>
    

    <tr>
      <td  height="10" bgcolor="">
          <table width="98%">
              <tr>
                <td width="2%">&nbsp;</td>
                <td align="center" >
                <img src="../../images/new.png" alt="new" width="96" height="24" onclick="ClearForm();" class="mouseover"/>
                <img src="../../images/save.png" id="saveIMG" alt="save_confirm" onclick="SaveValidation();" class="mouseover" style="display:inline;" />
                <img src="../../images/conform.png" alt="confirm" onclick="confrimActualCost();" id="confirmIMG"  style="display:none;"/>
                <img src="../../images/copyPO.png" alt="copy" width="108" height="24" onclick="loadCopyActCost();" />
                <img src="../../images/report.png" width="108" height="24" border="0" onclick="ViewReportPopUp();" class="mouseover"/>
                <img src="../../images/porevise.png" id="reviseIMG" onclick="loadRevision();"  style="display:none;"/>
                <a href="../../main.php"><img src="../../images/close.png" width="97" height="24" border="0" class="mouseover"/></a>
                </td>
                <td width="1%">&nbsp;</td>
              </tr>
          </table>      </td>
    </tr>
  </table>

<!--Reports-->
<div style="left:350px; top:530px; z-index:10; position:absolute; width: 300px; visibility:hidden; height: 20px;" id="reportsPopUp">
  <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
      <tr>
        <td width="43"><div align="center">Wash Formula</div></td>
        <td width="20"><div align="center"><input type="radio" name="radioReports" id="radioReports" value="CostSheet" onclick="washReport(0);"/></div></td>
        <td width="57"><div align="center">Cost Sheet</div></td>
        <td width="20"><div align="center"><input type="radio" name="radioReports" id="radioReports" value="WashFormula" onclick="washReport(0);"/></div></td>
      </tr>
  </table>	  
</div>
<!--////-->
<!--Copy Processes-->
    <div style="left:480px; top:580px; z-index:10; position:absolute; width: 250px; visibility:hidden; height: 20px;" id="copyActCost">
          <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
              <tr>
                <td width="43"><div align="center">Copy Process</div></td>
                <td width="20">
                    <div align="center">
                    <select name="cboCopyActCost" id="cboCopyActCost" onchange="copyActCostDetails(this.id);">
                        <option value="">select item</option>
                    <?php 
                    $sql_loadSNo="SELECT intSerialNo,intCat,concat(intSerialNo,'~',intCat) as val FROM was_actualcostheader;";
                    $resSNo=$db->RunQuery($sql_loadSNo);
                    while($rowS=mysql_fetch_array($resSNo))
                    {
                    ?>
                    
                        <option value="<?php echo $rowS['val'];?>" title="<?php echo $rowS['intCat'];?>"><?php echo $rowS['intSerialNo'];?></option>
                    <?php 	}?>
                    </select>
                    </div>
                    <!--<input type="hidden" id="<?php echo $rowS['intSerialNo'];?>" name="<?php echo $rowS['intSerialNo'];?>" value="<?php echo $rowS['intCat'];?>"/>-->
                </td>
              </tr>
          </table>	  
      </div>
<!--/////-->
<!--Revision -->
 	<div style="left:600px; top:580px; z-index:10; position:absolute; width: 250px; visibility:hidden; height: 20px;" id="revReason">
      <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
            <td width="43"><div align="center">Reason</div></td>
            <td width="20">
                <div align="center">
                    <input type="text" id="txtReason" name="txtReason" maxlength="100" />
                </div>
            </td>
            <td width="20">
                <div align="center">
                    <img src="../../images/porevise.png" onclick="reviseData();"/>
                </div>
            </td>
          </tr>
      </table>	  
  </div>
<!--////--> 
   <!--</div>
 </div>-->
</form> 
</body>
</html>