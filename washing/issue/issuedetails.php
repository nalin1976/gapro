<?php
	session_start();
	include("../../Connector.php");
	$backwardseperator = "../../";	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Washing - Production Issue</title>
<link href="../../js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../css/tableGrib.css" rel="stylesheet" type="text/css" />
    
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<script type="text/javascript" src="issue.js"></script>
<script src="../issueList/issueList.js" language="javascript" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
	// TABS
	$('#tabs').tabs();
});
function loadCompayPos(){
	loadStyles();
}
</script>

</head>

<body onload="loadDet('<?php echo $_GET['iNo'];?>');">
<table width="100%" align="center">
	<tr>
    	<td><?php include "{$backwardseperator}Header.php"; ?></td>
	</tr>
</table>
<table width="700" align="center" class="tableBorder">
<tr>
	<td class="mainHeading">Washing MRN Issue</td>
</tr>
<tr>
    <td><form id="frmProductionIssue" name="frmProductionIssue" method="post">
                <table width="100%" id="tblWas_otherCom" align="center">
                	<tr>
                    	<td>
                        	<table width="100%" rules="none" cellspacing="0">
                            	<tr>
                                	<td width="2" >&nbsp;</td>
                                	<td width="108" class="normalfnt" >&nbsp;</td>
                                    <td width="215" >&nbsp;</td>
                                    <td width="117" class="normalfnt" >Issue No</td>
                                    <td width="178" ><input type="text" name="txtIssueNo" id="txtIssueNo" readonly="readonly" maxlength="10" style="width:100px;" value="" ></td>
                                    <td width="50" >&nbsp;</td>
                                </tr>
                            	<tr>
                                	<td width="2" >&nbsp;</td>
                                	<td width="108" class="normalfnt" >MRN No<span class="compulsoryRed">*</span></td>
                                    <td width="215" ><span class="normalfnt"><select name="cboMrn" id="cboMrn" style="width:102px;" onchange="LoadMRNDetails(this);" tabindex="1">
                                        <option value="">Select One</option>                         
                                        <?php 
			$SQL = "select concat(intMrnYear,'/',dblMrnNo)as mrnNo from was_mrn where dblBalQty >0 order by mrnNo";	
			$result = $db->RunQuery($SQL);		
			while($row = mysql_fetch_array($result))
			{
				echo "<option value=\"". $row["mrnNo"] ."\">" . $row["mrnNo"] ."</option>" ;
			}
		?>
                                      </select>
                                    </span></td>
                                    <td width="117" class="normalfnt" >Date</td>
                                    <td width="178" ><input type="text" name="wasMrn_txtMrnDate" id="wasMrn_txtMrnDate" readonly="readonly" maxlength="10" style="width:100px;" value="<?php echo date('d/m/Y');?>" tabindex="2"/></td>
                                    <td width="50" >&nbsp;</td>
                                </tr>
                            	<tr>
                                	<td >&nbsp;</td>
                                	<td class="normalfnt" >Store</td>
                                    <td class="normalfnt">
                                    	<select name="cboStore" id="cboStore" style="width:150px;" tabindex="3">
                                        	<option value="">Select One</option>
                                        option value="0" selected="selected">Select One</option>
                <?php 
			$SQL = "SELECT strMainID,strName FROM mainstores WHERE intStatus = '1' order by strName";	
			$result = $db->RunQuery($SQL);		
			while($row = mysql_fetch_array($result))
			{
				echo "<option value=\"". $row["strMainID"] ."\">" . $row["strName"] ."</option>" ;
			}
		?>
                                        </select>                                    </td>
                                    <td class="normalfnt">Department</td>
                                    <td class="normalfnt"><span class="normalfnt" style="width:200px;">
                                      <select name="cboDepartment" id="cboDepartment" style="width:150px;" tabindex="4">
                                        <option value="" selected="selected">Select One</option>
                  <?php 

			$SQL = "SELECT intDepID,strDepartment FROM department where intStatus='1'  order by strDepartment";	
			$result = $db->RunQuery($SQL);		
			while($row = mysql_fetch_array($result))
			{
			echo "<option value=\"". $row["intDepID"] ."\">" . $row["strDepartment"] ."</option>" ;
			}
		?>
                                      </select>
                                    </span></td>
                                    <td >&nbsp;</td>
                                </tr>
                                
                                <tr>
                                	<td >&nbsp;</td>
                                	<td class="normalfnt" >PO No</td>
                                    <td class="normalfnt"><select name="cboOrderNo" id="cboOrderNo" style="width:150px;" onchange="loadColor(this);" tabindex="5">
                                    <option value="">Select One</option>
                                    <?php
                                    /*$sql="  SELECT
											orders.strOrderNo,
											orders.intStyleId
											FROM
											was_mrn
											INNER JOIN orders ON was_mrn.intStyleId = orders.intStyleId
											ORDER BY
											orders.strOrderNo ASC;";
											$result = $db->RunQuery($sql);		
											while($row = mysql_fetch_array($result))
											{
											echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
											}*/
									?>
                                        </select></td>
                                    <td class="normalfnt" >Style No</td>
                                    <td class="normalfnt"><select name="cboStyleNo" id="cboStyleNo" style="width:150px;" onchange="loadColor(this.value);" tabindex="6">    
                                    <option value="">Select One</option>
                                    <?php
                                    /*$sql="  SELECT
											orders.strStyle
											FROM
											was_mrn
											INNER JOIN orders ON was_mrn.intStyleId = orders.intStyleId
											ORDER BY
											orders.strOrderNo ASC;";
											$result = $db->RunQuery($sql);		
											while($row = mysql_fetch_array($result))
											{
											echo "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
											}*/
									?>  
                                    </select>                              </td>
                                    <td style="width:50px;">&nbsp;</td>
                                </tr>
                                <tr>
                                	<td >&nbsp;</td>
                                	<td class="normalfnt" >Color</td>
                                    <td class="normalfnt" ><select name="cboColor" id="cboColor" style="width:150px;height:18px;" onchange="loadColor(this);" tabindex="7">
                                        	<option></option>
                                      </select></td>
                                    <td class="normalfnt" >&nbsp;</td>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td >&nbsp;</td>
                                </tr>
                                <tr>
                                	<td >&nbsp;</td>
                                	<td class="normalfnt">MRN Qty </td>
                                    <td class="normalfnt"><span class="normalfnt">
                                    <input type="text" style="text-align:right;width:100px;" id="txtMRNQty" name="txtMRNQty" onkeypress="return CheckforValidDecimal(this.value,0,event);"  tabindex="9"/>
                                  </span></td>
                                    <td class="normalfnt">Order Qty</td>
                                    <td><span class="normalfnt">
                                      <input type="text" style="text-align:right;width:100px;" id="txtOrderQty" name="txtOrderQty" readonly="readonly" tabindex="10"/>
                                    </span></td>
                                    <td >&nbsp;</td>
                                </tr>
                                <tr>
                                	<td >&nbsp;</td>
                                	<td class="normalfnt" >Issue Qty <span class="compulsoryRed">*</span></td>
                                    <td class="normalfnt" ><input type="text" style="text-align:right;width:100px;" id="txtIssueQty" name="txtIssueQty" tabindex="8" onkeyup="setBalance(this);" onkeypress="return isValidZipCode(this.value,event);" maxlength="8"/></td>
                                    <td class="normalfnt"  style="display:none;">Available Qty</td>
                                    <td ><span class="normalfnt">
                                    <input type="text" style="text-align:right;width:100px;display:none;" id="txtAvailableQty" name="txtAvailableQty" readonly="readonly" tabindex="11"/>
                                    </span></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                	<td style="width:50px;">&nbsp;                                    </td>
                                	<td class="normalfnt" style="width:100px;">Sewing Factory</td>
                                    <td colspan="3" class="normalfnt" style="width:500px;">
                                    	<select name="wasIssue_txtSFactoryS" id="wasIssue_txtSFactoryS" style="width:480px;">
                                        	<option>Select One</option>
                                        <?php 
											$sqlFactory="SELECT DISTINCT companies.intCompanyID,companies.strName FROM companies order by companies.strName;";
											$resFactory=$db->RunQuery($sqlFactory);
											
                  							while($rowF=mysql_fetch_array($resFactory))
                 							 {
														 	echo "<option value=\"".$rowF['intCompanyID']."\">".$rowF['strName']."</option>";
											 } 
										?>
                                        </select>                                    </td>
                                    <td style="width:50px;">&nbsp;                                    </td>
                                </tr>
                                <tr>
                                	<td >&nbsp;</td>
                                    <td class="normalfnt">Remarks</td>
                                    <td colspan="3" >
                                      <textarea name="wasMrn_txtRemarks" id="wasMrn_txtRemarks" style="width:478px;" cols="20" rows="1" class="txtbox" tabindex="12" onkeypress="return imposeMaxLength(this,event, 150);">
                                      </textarea></td>
                                    <td >&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                	<tr>	
						<td>
                            <table width="100%" border="0" class="tableFooter" align="center">
                                                    <tr>
                                                        <td width="37%" align="center">
<img src="../../images/new.png" id="butNew" onclick="ClearForm();" tabindex="16" title="Click to clear the page"/>
<img src="../../images/save.png" name="Save" width="80" id="Save" title="Click to save details" onclick="SaveIssue();" tabindex="13"/>
<img src="../../images/report.png" id="butSave" alt="report" tabindex="14" title="Click to view report" onclick="showReports();" style="display:none;"/>
<a href="../../main.php"><img src="../../images/close.png" id="butClose" alt="close" border="0" title="Click to go to main page" tabindex="15"/></a>							</td>
                                                    </tr>
                          </table>
						</td>
                    </tr>
                </table>
                  </form>
	
</td>
	</tr>
</table>
</body>
</html>