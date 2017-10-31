<?php
	session_start();
	include("../../Connector.php");
	$backwardseperator = "../../";	
	$mrn='';
	$mrn=$_GET['mrn'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Washing - MRN</title>
<link href="../../js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../css/tableGrib.css" rel="stylesheet" type="text/css" />
    
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<script type="text/javascript" src="mrn.js"></script>
<script type="text/javascript" src="../mrnList/mrnList.js"></script>
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

<body onload="loadMrnDets('<?php echo $mrn;?>');">
<table width="100%" align="center">
	<tr>
    	<td><?php include "{$backwardseperator}Header.php"; ?></td>
	</tr>
</table>
<table style="width:750px;" align="center" class="tableBorder">
<tr>
	<td class="mainHeading">Sample MRN</td>
</tr>
<tr>
    <td>
              <form id="frmWasOtherFacory_send" action="" name="frmWasOtherFacory_send" method="post">
                <table id="tblWas_otherCom" align="center">
                	<tr>
                    	<td>
                        	<table style="width:700px;" rules="none" cellspacing="0">
                            	<tr>
                                	<td style="width:50px;">&nbsp;                                    </td>
                                	<td class="normalfnt" style="width:100px;">
                                    	MRN No                                    </td>
                                    <td style="width:200px;">
                                    	<input type="text" name="wasMrn_txtMrnNo" id="wasMrn_txtMrnNo" readonly="readonly" maxlength="15" style="width:100px;text-align:right;"/>                                    </td>
                                    <td class="normalfnt" style="width:100px;">
                                    	Date                                    </td>
                                    <td style="width:200px;">
                                    	<input type="text" name="wasMrn_txtMrnDate" id="wasMrn_txtMrnDate" readonly="readonly" maxlength="10" style="width:100px;" value="<?php echo date('d/m/Y');?>"/>                                    </td>
                                    <td style="width:50px;">&nbsp;                                    </td>
                                </tr>
                            	<tr>
                                	<td style="width:50px;">&nbsp;                                    </td>
                                	<td class="normalfnt" style="width:100px;">Store<span class="compulsoryRed">*</span></td>
                                    <td class="normalfnt">
                                    	<select name="wasMrn_cboStore" id="wasMrn_cboStore" style="width:150px;" tabindex="1">
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
                                    <td class="normalfnt">Department<span class="compulsoryRed">*</span></td>
                                    <td class="normalfnt"><span class="normalfnt" style="width:200px;">
                                      <select name="wasMrn_cboDepartment" id="wasMrn_cboDepartment" style="width:150px;" tabindex="2">
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
                                    <td style="width:50px;">&nbsp;                                    </td>
                                </tr>
                                <tr>
                                	<td style="width:50px;">&nbsp;                                    </td>
                                	<td class="normalfnt" style="width:100px;">
                                    	PO No<span class="compulsoryRed">*</span>                                   </td>
                                    <td style="width:200px;" class="normalfnt">
                                    	<select name="wasMrn_cboPOS" id="wasMrn_cboPOS" style="width:150px;" onchange="loadColor(this);" tabindex="3">
                                        	<option></option>
											<?php 
											$sql_loadStyle="SELECT DISTINCT
															o.strOrderNo,
															o.intStyleId,
															o.intStatus
															FROM
															orders AS o
															WHERE o.intStatus='11'
															order by o.strOrderNo ASC;";
					//echo $sql_loadStyle;
	$resS=$db->RunQuery($sql_loadStyle);
										while($row=mysql_fetch_array($resS)){
											echo "<option value=\"".$row['intStyleId']."\">" .$row['strOrderNo'] . "</option>";
											
										}
										?>
                                        </select>                                    </td>
                                    <td class="normalfnt" style="width:100px;">
                                    	Style No                                    </td>
                                    <td style="width:200px;" class="normalfnt">
                                    	<select name="wasMrn_cboStyles" id="wasMrn_cboStyles" style="width:150px;" onchange="loadPos(this);" tabindex="4">
                                        	<option></option>
											<?php 
											$sql_loadStyle="SELECT DISTINCT
															o.strOrderNo,
															o.intStyleId,
															o.strStyle
															FROM
															orders AS o
															WHERE o.intStatus='11'
															order by o.strOrderNo ASC;";
					//echo $sql_loadStyle;
										$resS=$db->RunQuery($sql_loadStyle);
										while($row=mysql_fetch_array($resS)){
											echo "<option value=\"".$row['strStyle']."\">" .$row['strStyle'] . "</option>";
											
										}
										?>
                                        </select>                                    </td>
                                    <td style="width:50px;">&nbsp;                                    </td>
                                </tr>
                                <tr>
                                	<td style="width:50px;">&nbsp;                                    </td>
                                	<td class="normalfnt" style="width:100px;">
                                    	Color<span class="compulsoryRed">*</span></td>
                                    <td class="normalfnt" style="width:200px;">
                       	  <select name="wasMrn_cboColor" id="wasMrn_cboColor" style="width:150px;height:18px;" onchange="loadColor(this);" tabindex="5">
                                        	<option></option>
                                      </select>                                    </td>
                                    <td class="normalfnt" style="width:100px;">&nbsp;</td>
                                    <td style="width:200px;" class="normalfnt">&nbsp;</td>
                                    <td style="width:50px;">&nbsp;                                    </td>
                                </tr>
                                <tr>
                                	<td style="width:50px;">&nbsp;                                    </td>
                                	<td class="normalfnt" style="width:100px;"><span class="normalfnt" style="width:100px;"><span class="normalfnt" style="width:100px;">Order Qty</span></span></td>
                                    <td class="normalfnt" style="width:200px;"><span class="normalfnt" style="width:200px;">
                                      <input type="text" style="text-align:right;width:100px;" id="wasMrn_txtOderQty" name="wasMrn_txtOderQty" readonly="readonly" tabindex="6"/>
                                    </span></td>
                                    <td class="normalfnt" style="width:100px;"><span class="normalfnt" style="width:100px;"><span class="normalfnt" style="width:100px;"><span class="normalfnt" style="width:100px;"><span class="normalfnt" style="width:100px;"><span class="normalfnt" style="width:100px;">MRN Qty<span class="compulsoryRed">*</span></span></span></span></span></span></td>
                                    <td style="width:200px;"><span class="normalfnt" style="width:200px;"><span class="normalfnt" style="width:200px;"><span class="normalfnt" style="width:200px;"><span class="normalfnt" style="width:200px;">
                                      <input type="text" style="text-align:right;width:100px;" id="wasMrn_txtMrnQty" name="wasMrn_txtMrnQty" onkeypress="return isValidZipCode(this.value,event); "  onkeyup="setBalance(this);" tabindex="8" maxlength="8" />
                                    </span></span></span></span></td>
                                    <td style="width:50px;">&nbsp;                                    </td>
                                </tr>
                                <tr style="display:none;">
                                	<td style="width:50px;">&nbsp;                                    </td>
                                	<td class="normalfnt" style="width:100px;">&nbsp;</td>
                                    <td class="normalfnt" style="width:200px;">&nbsp;</td>
                                    <td class="normalfnt" style="width:100px;"><span class="normalfnt" style="width:100px;"><span class="normalfnt" style="width:100px;">Available Qty</span></span></td>
                                    <td style="width:200px;"><span class="normalfnt" style="width:200px;">
                                      <input type="text" style="text-align:right;width:100px;" id="wasOther_txtAVLQty" name="wasOther_txtAVLQty" readonly="readonly" tabindex="7"/>
                                    </span></td>
                                    <td style="width:50px;">&nbsp;                                    </td>
                                </tr>
                                <tr>
                                	<td style="width:50px;">&nbsp;</td>
                                    <td style="width:50px;" class="normalfnt" valign="baseline">Remarks</td>
                                    <td colspan="3" style="width:500px;" class="normalfnt">
                                      <textarea name="wasMrn_txtRemarks" id="wasMrn_txtRemarks" style="width:450px;" cols="20" rows="1" tabindex="9" onkeypress="return imposeMaxLength(this,event, 150);">
                                      </textarea>                                    </td>
                                    <td style="width:50px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                	<tr>	
						<td>
                            <table width="100%" border="0" class="tableFooter" align="center">
                                                    <tr>
                                                        <td width="37%" align="center">
                                                        <img src="../../images/new.png" id="butNew" onclick="clearFormN();" tabindex="10" title="Click to clear the page"/>
                                                        <img src="../../images/save.png" name="Save" width="80" id="Save" title="Click to save details" onclick="Save_Mrn();" tabindex="12"/>
                                                        <img src="../../images/report.png" id="butRpt" alt="report" title="Click to view report" onclick="showReports();" tabindex="11" style="display:none;"/>
                                                        <a href="../../main.php"><img src="../../images/close.png" id="butClose" alt="close"  border="0" title="Click to go to main page" tabindex="13"/></a>							</td>
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