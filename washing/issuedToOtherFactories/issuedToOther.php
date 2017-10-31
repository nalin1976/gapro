<?php
	session_start();
	include("../../Connector.php");
	$backwardseperator = "../../";	
	$gp=$_GET['gp'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Washing - Issued To Other Factories</title>
<link href="../../js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../css/tableGrib.css" rel="stylesheet" type="text/css" />
    
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<script type="text/javascript" src="issuedToOtherFac.js"></script>
<script type="text/javascript">
function loadCompayPos(){
	loadStyles();
}/*onload="loadCompayPos() ";*/
</script>

</head>

<body onload="loadDets('<?php echo $gp;?>')">
<table width="100%" align="center">
	<tr>
    	<td><?php include "{$backwardseperator}Header.php"; ?></td>
	</tr>
</table>
<table style="width:750px;" align="center" class="tableBorder">
<tr>
	<td class="mainHeading">Gatepass</td>
</tr>
<tr>
    <td>
              <form id="frmWasOtherFacory_send" action="" name="frmWasOtherFacory_send" method="post">
                <table id="tblWas_otherCom" align="center">
                	<tr>
                    	<td>
                        	<table style="width:700px;" rules="none" cellspacing="0">
                            	<tr>
                                	<td style="width:50px;">&nbsp;
                                    	
                                    </td>
                                	<td class="normalfnt" style="width:100px;">
                                    	GatePass No
                                    </td>
                                    <td style="width:200px;">
                                    	<input type="text" name="wasOther_txtGPNoS" id="wasOther_txtGPNoS" readonly="readonly" maxlength="15" style="width:100px;text-align:right;"/>
                                    </td>
                                    <td class="normalfnt" style="width:100px;">
                                    	Date
                                    </td>
                                    <td style="width:200px;">
                                    	<input type="text" name="wasOther_txtDateS" id="wasOther_txtDateS" readonly="readonly" maxlength="10" style="width:100px;" value="<?php echo date('d/m/Y');?>"/>
                                    </td>
                                    <td style="width:50px;">&nbsp;
                                    	
                                    </td>
                                </tr>
                            	
                                <tr>
                                	<td style="width:50px;">&nbsp;
                                    	
                                    </td>
                                	<td class="normalfnt" style="width:100px;">
                                    	PO No<span class="compulsoryRed">*</span>
                                    </td>
                                    <td style="width:200px;" class="normalfnt">
                                    	<select name="wasOther_cboPOS" id="wasOther_cboPOS" style="width:102px;" onchange="loadColor(this);">
                                        	<option value="">Select One</option>
                                            <?php
					$sql="SELECT DISTINCT orders.intStyleId,orders.strOrderNo,orders.strStyle FROM was_stocktransactions AS s INNER JOIN orders ON s.intStyleId = orders.intStyleId and s.intCompanyId='".$_SESSION['FactoryID']."' order by strOrderNo;";
                    $res=$db->RunQuery($sql);
					while($row=mysql_fetch_array($res)){
						echo "<option value=\"".$row['intStyleId']."\">".$row['strOrderNo']."</option>";
					}
					?>
                                        </select>
                                    </td>
                                    <td class="normalfnt" style="width:100px;">
                                    	Style No
                                    </td>
                                    <td style="width:200px;" class="normalfnt">
                                    	<select name="wasOther_txtStyleS" id="wasOther_cboStyleS" style="width:102px;" onchange="loadPO(this.value);">
                                        	<option value="">Select One</option>
                      <?php
					$sql="SELECT DISTINCT orders.intStyleId,orders.strOrderNo,orders.strStyle FROM was_stocktransactions AS s INNER JOIN orders ON s.intStyleId = orders.intStyleId";
                    $res=$db->RunQuery($sql);
					while($row=mysql_fetch_array($res)){
						echo "<option value=\"".$row['intStyleId']."\">".$row['strStyle']."</option>";
					}
					?>
                                        </select>
                                    </td>
                                    <td style="width:50px;">&nbsp;
                                    	
                                    </td>
                                </tr>
                                <tr>
                                	<td style="width:50px;">&nbsp;
                                    	
                                    </td>
                                	<td class="normalfnt" style="width:100px;">
                                    	Color<span class="compulsoryRed">*</span>
									</td>
                                    <td class="normalfnt" style="width:200px;">
                       	  <select name="wasOther_cboColorS" id="wasOther_cboColorS" style="width:102px;" >
                                        	<option></option>
                                      </select>
                                    </td>
                                    <td class="normalfnt" style="width:100px;">Vehicle No </td>
                                    <td style="width:200px;" class="normalfnt"><input type="text" name="wasOther_txtvNo" id="wasOther_txtvNo" maxlength="10" style="width:100px;" /></td>
                                    <td style="width:50px;">&nbsp;
                                    	
                                    </td>
                                </tr>
                                <tr>
                                	<td style="width:50px;">&nbsp;
                                    	
                                    </td>
                                	<td class="normalfnt" style="width:100px;">From Factory</td>
                                    <td colspan="3" class="normalfnt" style="width:500px;">
                                    	<select name="wasOther_txtFromFactoryS" id="wasOther_txtFromFactoryS" style="width:404px;" onchange="loadCompayPos();" disabled="disabled">
                                        	<option>Select One</option>
                                        <?php 
											$sqlFactory="SELECT DISTINCT companies.intCompanyID,companies.strName FROM companies order by companies.strName;";
											$resFactory=$db->RunQuery($sqlFactory);
											
                  							while($rowF=mysql_fetch_array($resFactory))
                 							 {
												 if($_SESSION['FactoryID']==$rowF['intCompanyID'])
												 	echo "<option value=\"".$rowF['intCompanyID']."\" selected=\"selected\">".$rowF['strName']."</option>";
												 else
												 	echo "<option value=\"".$rowF['intCompanyID']."\">".$rowF['strName']."</option>";
											 } 
										?>
                                        </select>
                                    </td>
                                    <td style="width:50px;">&nbsp;
                                    	
                                    </td>
                                </tr>
                                <tr>
                                	<td style="width:50px;">&nbsp;
                                    	
                                    </td>
                                	<td class="normalfnt" style="width:100px;">Sewing Factory</td>
                                    <td colspan="3" class="normalfnt" style="width:500px;">
                                    	<select name="wasOther_txtSewingFactoryS" id="wasOther_txtSewingFactoryS" style="width:404px;"   disabled="disabled" onchange="LoadQtyWhenChangeSewFactory();">
                                        	<option>Select One</option>
                                        <?php 
											$sqlFactory="SELECT DISTINCT companies.intCompanyID,companies.strName FROM companies order by companies.strName;";
											$resFactory=$db->RunQuery($sqlFactory);
											
                  							while($rowF=mysql_fetch_array($resFactory))
                 							 {
				/*								 if($_SESSION['FactoryID']==$rowF['intCompanyID'])
												 	echo "<option value=\"".$rowF['intCompanyID']."\" selected=\"selected\">".$rowF['strName']."</option>";
												 else*/
												 	echo "<option value=\"".$rowF['intCompanyID']."\">".$rowF['strName']."</option>";
											 } 
										?>
                                        </select>
                                    </td>
                                    <td style="width:50px;">&nbsp;
                                    	
                                    </td>
                                </tr>
                                <tr>
                                	<td style="width:50px;">&nbsp;
                                    	
                                    </td>
                                	<td class="normalfnt" style="width:100px;">
                                    	Order Qty
                                    </td>
                                    <td class="normalfnt" style="width:200px;">
                                   		<input type="text" style="text-align:right;width:100px;" id="wasOther_txtOderQty" name="wasOther_txtOderQty" readonly="readonly" />
                                    </td>
                                    <td class="normalfnt" style="width:100px;">
                                    	GatePass Qty
                                    </td>
                                    <td style="width:200px;">
                                    	<input type="text" style="text-align:right;width:100px;" id="wasOther_txtRecvQty" name="wasOther_txtRecvQty" readonly="readonly"/>
                                    </td>
                                    <td style="width:50px;">&nbsp;
                                    	
                                    </td>
                                </tr>
                                <tr>
                                	<td style="width:50px;">&nbsp;
                                    	
                                    </td>
                                	<td class="normalfnt" style="width:100px;">
                                    	Available Qty
                                    </td>
                                    <td class="normalfnt" style="width:200px;">
                                   		<input type="text" style="text-align:right;width:100px;" id="wasOther_txtAVLQty" name="wasOther_txtAVLQty" readonly="readonly"/>
                                    </td>
                                    <td class="normalfnt" style="width:100px;">
                                    	Send Qty<span class="compulsoryRed">*</span>
                                    </td>
                                    <td style="width:200px;">
                                    	<input type="text" id="wasOther_txtSQty" name="wasOther_txtSQty" style="text-align:right;width:100px;" onkeypress="return CheckforValidDecimal(this.value,0,event);" onkeyup="checkBalance(this);" />
                                    </td>
                                    <td style="width:50px;">&nbsp;
                                    	
                                    </td>
                                </tr>
                                <tr>
                                	<td style="width:50px;">&nbsp;
                                    	
                                    </td>
                                	<td class="normalfnt" style="width:100px;">
                                    	To Factory<span class="compulsoryRed">*</span>
                                    </td>
                                    <td class="normalfnt" colspan="3" style="width:500px;">
                                   		<select name="wasOther_OutFactoryS" id="wasOther_OutFactoryS" style="width:404px;">
                                        	<option value="">Select One</option>
                                        <?php 
											$sqlOFactory="SELECT DISTINCT companies.intCompanyID,companies.strName FROM companies where intCompanyID <> '".$_SESSION['FactoryID']."'order by companies.strName;";
											$resOFactory=$db->RunQuery($sqlOFactory);
											
                  							while($rowOF=mysql_fetch_array($resOFactory))
                 							 {
												 if($_SESSION['FactoryID']==$rowOF['intCompanyID'])
												 	echo "<option value=\"".$rowOF['intCompanyID']."\" selected=\"selected\">".$rowOF['strName']."</option>";
												 else
												 	echo "<option value=\"".$rowOF['intCompanyID']."\">".$rowOF['strName']."</option>";
											 } 
										?>
                                        </select>
                                    </td>
                                    <td style="width:50px;">&nbsp;</td>
                                </tr>
                                <tr>
                                	<td style="width:50px;">&nbsp;</td>
                                    <td style="width:50px;" class="normalfnt">Reason</td>
                                    <td  class="normalfnt"><span class="normalfnt" style="width:500px;">
                                      <select name="wasOther_cboReason" id="wasOther_cboReason" style="width:190px;">
                                        <option value="0">Select One</option>
                                        <?php
                                        $sql="select intSerialNo,strProcessName from was_washformula where intStatus='1' -- and intProcType='2';";
										$res=$db->RunQuery($sql);
										while($row=mysql_fetch_array($res)){
											echo "<option value=\"".$row['intSerialNo']."\">".$row['strProcessName']."</option>";
										}
										?>
                                      </select>
                                  </span></td>
                                    <td  class="normalfnt">Damages</td>
                                    <td  class="normalfnt"><input type="checkbox" name="chkDamages" id="chkDamages" /></td>
                                    <td class="normalfnt">&nbsp;</td>
                                </tr>
                                <tr>
                                	<td style="width:50px;">&nbsp;</td>
                                    <td  style="width:100px;"><span class="normalfnt" style="width:50px;">Remarks</span></td>
                                    <td style="width:50px;" colspan="3">
                                    	<!--<table width="404">
                                        	<thead>
                                        	<tr>
                                            	<td width="30" class="grid_header">Cut No</td><td width="38" class="grid_header">Shade</td><td width="23" class="grid_header">Qty</td><td width="20" class="grid_header"><input type="checkbox" /></td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>-->
                                      <span class="normalfnt" style="width:500px;">
                                        <textarea name="wasOther_txtRemarks" id="wasOther_txtRemarks" style="width:400px;" cols="20" rows="1">
                                        </textarea>
                                    </span></td>
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
                                                        <img src="../../images/new.png" id="butNew" onclick="clearForm();" tabindex="10" title="Click to clear the page"/>
                                                        <img src="../../images/save.png" name="Save" width="80" id="Save" title="Click to save details" onclick="Save_Send();" tabindex="7"/>
                                                        <img src="../../images/report.png" id="butReport" alt="report" tabindex="8" title="Click to view report" onclick="showaReport();" style="display:none;"/>
                                                        <img src="../../images/cancel.jpg" id="butCancel" alt="report" tabindex="8" title="Click to Cancel" onclick="cancelDet();" style="display:none;"/>
                                                        <img src="../../images/conform.png" id="butConfirm" alt="report" tabindex="8" title="Click to Confirm" onclick="confirmDet();" style="display:none;"/>
                                                        <a href="../../main.php"><img src="../../images/close.png" id="butClose" alt="close" tabindex="9" border="0" title="Click to go to main page"/></a>							</td>
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