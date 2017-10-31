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
<title>GaPro | Washing - Defect Gatepass</title>
<link href="../../js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../css/tableGrib.css" rel="stylesheet" type="text/css" />
    
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<script type="text/javascript" src="defectGatepass.js"></script>
<script type="text/javascript">

</script>

</head>
<body>
<table width="100%" align="center">
	<tr>
    	<td><?php include "{$backwardseperator}Header.php"; ?></td>
	</tr>
</table>
<table style="width:750px;" align="center" class="tableBorder">
<tr>
	<td class="mainHeading">Defect Gatepass</td>
</tr>
<tr>
    <td>
              <form id="frmWasDefectGatepass" action="" name="frmWasDefectGatepass" method="post">
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
                                    	<input type="text" name="txtGatePassNo" id="txtGatePassNo" readonly="readonly" maxlength="15" style="width:100px;text-align:right;"/>
                                    </td>
                                    <td class="normalfnt" style="width:100px;">
                                    	Date
                                    </td>
                                    <td style="width:200px;">
                                    	<input type="text" name="txtDate" id="txtDate" readonly="readonly" maxlength="10" style="width:100px;" value="<?php echo date('Y-m-d');?>"/>
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
                                    	<select name="cboPONo" id="cboPONo" style="width:102px;" onchange="loadColor(this);">
                                        	<option value="">Select One</option>
                                            <?php
					$sql="SELECT DISTINCT orders.intStyleId,orders.strOrderNo,orders.strStyle,sum(wsd.dblQty) as qty 
FROM was_stocktransactions_defect AS wsd 
INNER JOIN orders ON wsd.intStyleId = orders.intStyleId and wsd.intCompanyId='".$_SESSION['FactoryID']."' 
group by wsd.intStyleId having qty>0 order by orders.strOrderNo;";
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
                                    	<select name="cboStyleNo" id="cboStyleNo" style="width:102px;" onchange="loadPO(this);">
                                        	<option value="">Select One</option>
                      <?php
					$sql="SELECT DISTINCT orders.intStyleId,orders.strOrderNo,orders.strStyle,sum(wsd.dblQty) as qty  
FROM was_stocktransactions_defect AS wsd 
INNER JOIN orders ON wsd.intStyleId = orders.intStyleId and wsd.intCompanyId='".$_SESSION['FactoryID']."' group by wsd.intStyleId having qty>0 ";
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
                       	  <select name="cboColor" id="cboColor" style="width:102px;" >
                                        	<option></option>
                                      </select>
                                    </td>
                                    <td class="normalfnt" style="width:100px;">Vehicle No </td>
                                    <td style="width:200px;" class="normalfnt"><input type="text" name="txtVehicleNo" id="txtVehicleNo" maxlength="10" style="width:100px;" /></td>
                                    <td style="width:50px;">&nbsp;
                                    	
                                    </td>
                                </tr>
                                <tr>
                                	<td style="width:50px;">&nbsp;
                                    	
                                    </td>
                                	<td class="normalfnt" style="width:100px;">From Factory</td>
                                    <td colspan="3" class="normalfnt" style="width:500px;">
                                    	<select name="cboFromFactory" id="cboFromFactory" style="width:404px;" onchange="loadCompayPos();" disabled="disabled">
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
                                    	<select name="cboSewingFactory" id="cboSewingFactory" style="width:404px;"   disabled="disabled" onchange="LoadQtyWhenChangeSewFactory(this);">
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
                                   		<input type="text" style="text-align:right;width:100px;" id="txtOrderQty" name="txtOrderQty" readonly="readonly" />
                                    </td>
                                    <td class="normalfnt" style="width:100px;">
                                    	GatePass Qty
                                    </td>
                                    <td style="width:200px;">
                                    	<input type="text" style="text-align:right;width:100px;" id="txtGatepassQty" name="txtGatepassQty" readonly="readonly"/>
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
                                   		<input type="text" style="text-align:right;width:100px;" id="txtAvailableQty" name="txtAvailableQty" readonly="readonly"/>
                                    </td>
                                    <td class="normalfnt" style="width:100px;">
                                    	Send Qty<span class="compulsoryRed">*</span>
                                    </td>
                                    <td style="width:200px;">
                                    	<input type="text" id="txtSendQty" name="txtSendQty" style="text-align:right;width:100px;" onkeypress="return CheckforValidDecimal(this.value,0,event);" onkeyup="checkBalance(this);" readonly="readonly" />
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
                                   		<input name="txtToFactory" id="txtToFactory" type="text" class="txtbox" style="width:402px" maxlength="150" />
                                    </td>
                                    <td style="width:50px;">&nbsp;</td>
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
                                        <textarea name="txtRemarks" id="txtRemarks" style="width:400px;" cols="20" rows="1">
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