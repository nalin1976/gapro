<?php
	session_start();
	include("../../Connector.php");
	$backwardseperator = "../../";	
	$factory=$_SESSION['FactoryID'];
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
<script type="text/javascript" src="mrnReturn.js"></script>
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

<body>
<table width="100%" align="center">
	<tr>
    	<td><?php include "{$backwardseperator}Header.php"; ?></td>
	</tr>
</table>
<table width="700" align="center" class="tableBorder">
<tr>
	<td class="mainHeading">Washing Sample Issue Return</td>
</tr>
<tr>
    <td><form id="frmProductionIssueReturn" name="frmProductionIssueReturn" method="post">
                <table width="100%" id="tblWas_otherCom" align="center">
                	<tr>
                    	<td>
                        	<table width="100%" rules="none" cellspacing="0">
                            	<tr>
                                <tr>
                                	<td width="2" >&nbsp;</td>
                                	<td width="108" class="normalfnt" >&nbsp;</td>
                                    <td width="215" >&nbsp;</td>
                                    <td width="117" class="normalfnt" >Return Serial</td>
                                    <td width="178" ><input type="text" name="txtRtnSerial" id="txtRtnSerial" readonly="readonly" maxlength="10" style="width:100px;" value="" tabindex="2"/></td>
                                    <td width="50" >&nbsp;</td>
                                </tr>
                                	<td width="2" >&nbsp;</td>
                                	<td width="108" class="normalfnt" >Issue No<span class="compulsoryRed">*</span></td>
                                    <td width="215" ><span class="normalfnt"><select name="cboIssue" id="cboIssue" style="width:102px;" onchange="LoadIssueDetails(this);" tabindex="1">
                                        <option value="">Select One</option>                         
                                        <?php 
			$SQL = "select DISTINCT concat(wi.intIssueYear,'/',wi.intIssueNo) as INO from was_issue wi where wi.intCompanyId='$factory' order by wi.intIssueNo ASC";	
			//echo $SQL;
			$result = $db->RunQuery($SQL);		
			while($row = mysql_fetch_array($result))
			{
				echo "<option value=\"". $row["INO"] ."\">" . $row["INO"] ."</option>" ;
			}
		?>
                                      </select>
                                    </span></td>
                                    <td width="117" class="normalfnt" >Date</td>
                                    <td width="178" ><input type="text" name="wasRtn_txtMrnDate" id="wasRtn_txtMrnDate" readonly="readonly" maxlength="10" style="width:100px;" value="<?php echo date('d/m/Y');?>" tabindex="2"/></td>
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
                                        </select></td>
                                    <td class="normalfnt" >Style No</td>
                                    <td class="normalfnt"><select name="cboStyleNo" id="cboStyleNo" style="width:150px;" onchange="loadColor(this.value);" tabindex="6"></select>                                    </td>
                                    <td style="width:50px;">&nbsp;</td>
                                </tr>
                                <tr>
                                	<td >&nbsp;</td>
                                	<td class="normalfnt" >Color</td>
                                    <td class="normalfnt" ><select name="cboColor" id="cboColor" style="width:150px;" onchange="loadColor(this);" tabindex="7">
                                        	<option></option>
                                      </select></td>
                                    <td class="normalfnt" >Order Qty</td>
                                    <td class="normalfnt"><input type="text" style="text-align:right;width:100px;" id="txtOrderQty" name="txtOrderQty" readonly="readonly" tabindex="8"/></td>
                                    <td >&nbsp;</td>
                                </tr>
                                <tr>
                                	<td >&nbsp;</td>
                                	<td class="normalfnt">Return Qty <span class="compulsoryRed">*</span></td>
                                    <td class="normalfnt"><span class="normalfnt">
                                      <input type="text" style="text-align:right;width:100px;" id="txtRtnQty" name="txtRtnQty" onkeyup="setBalance(this);" onkeypress="return isValidZipCode(this.value,event);" tabindex="9" maxlength="8"/>
                                    </span><input type="hidden" id="txtAvlQty" name="txtAvlQty"/></td>
                                    <td class="normalfnt"><span class="normalfnt">Issue Qty </span></td>
                                    <td><span class="normalfnt">
                                      <input type="text" style="text-align:right;width:100px;" id="txtIssueQty" name="txtIssueQty" onkeypress="return CheckforValidDecimal(this.value,0,event);"  tabindex="10" readonly="readonly"/>
                                    </span></td>
                                    <td >&nbsp;</td>
                                </tr>
                                <!--<tr>
                                	<td >&nbsp;</td>
                                	<td class="normalfnt" >&nbsp;</td>
                                    <td class="normalfnt" >&nbsp;</td>
                                    <td class="normalfnt" >&nbsp;</td>
                                    <td >&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>-->
                                <tr>
                                	<td style="width:50px;">&nbsp;                                    </td>
                                	<td class="normalfnt" style="width:100px;">Sewing Factory</td>
                                    <td colspan="3" class="normalfnt" style="width:500px;">
                                    	<select name="wasIssue_txtSFactoryS" id="wasIssue_txtSFactoryS" style="width:480px;" tabindex="11">
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
<img src="../../images/new.png" id="butNew" onclick="clearFrom();" tabindex="16" title="Click to clear the page"/>
<img src="../../images/save.png" name="Save" width="80" id="Save" title="Click to save details" onclick="saveData();" tabindex="13"/>
<img src="../../images/report.png" id="butSave" alt="report" tabindex="14" title="Click to view report" onclick="showReports();"/>
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