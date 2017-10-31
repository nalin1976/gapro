<?php
	session_start();
	include("../../Connector.php");
	$backwardseperator = "../../";	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Washing - Receive</title>
<link href="../../js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../css/tableGrib.css" rel="stylesheet" type="text/css" />
    
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<script type="text/javascript" src="rvcdToOtherFac.js"></script>
<script type="text/javascript">

function loadCompayPos(){
	loadStyles();
}
</script>

</head>
<!-- onload="loadCompayPos();"-->
<body>
<table width="100%" align="center">
	<tr>
    	<td><?php include "{$backwardseperator}Header.php"; ?></td>
	</tr>
</table>
<table style="width:750px;" align="center" class="tableBorder">
<tr>
	<td class="mainHeading">Gatepass TransferIn</td>
</tr>
<tr>
    <td>
              <form id="frmWasOtherFacory_send" name="frmWasOtherFacory_send" method="post">
                <table id="tblWas_otherCom" align="center">
                	<tr>
                    	<td>
                        	<table style="width:700px;" rules="none" cellspacing="0">
                            	<tr>
                                	<td style="width:50px;">&nbsp;                                    </td>
                                	<td class="normalfnt" style="width:100px;">
                                    	Serial No</td>
                                    <td style="width:200px;" class="normalfnt">
                                    	<input type="text" name="wasOther_txtSerialNoR" id="wasOther_txtSerialNoR" readonly="readonly" style="width:100px;" />                                    </td>
                                    <td class="normalfnt" style="width:100px;">
                                    	Date                                    </td>
                                    <td style="width:200px;">
                                    	<input type="text" name="wasOther_txtDateS" id="wasOther_txtDateS" readonly="readonly" maxlength="10" style="width:100px;" value="<?php echo date('d/m/Y');?>"/>                                    </td>
                                    <td style="width:50px;">&nbsp;                                    </td>
                                </tr>
                            	<tr>
                                	<td style="width:50px;">&nbsp;                                    </td>
                                	<td class="normalfnt" style="width:100px;">
                                    	GatePass No                                    </td>
                                    <td style="width:500px;" class="normalfnt" colspan="3" >
                                    	<select name="wasOther_cboGPNoR" id="wasOther_cboGPNoR" style="width:408px;" onchange="loadTofactory(this)">
                                        <option value="">Select One</option>
<?php 
/*$sqlGP="SELECT was_issuedtootherfactory.dblGPNo,was_issuedtootherfactory.intYear,concat(was_issuedtootherfactory.intYear,'/',was_issuedtootherfactory.dblGPNo,'->',orders.strOrderNo,'/',orders.strStyle) as GP 
FROM was_issuedtootherfactory 
Inner Join orders ON was_issuedtootherfactory.intStyleId = orders.intStyleId dblGPNo
WHERE was_issuedtootherfactory.intToFactory ='".$_SESSION['FactoryID']."';";*/

$sqlGP="SELECT WIOF.dblGPNo,WIOF.intYear,concat(WIOF.dblGPNo,'/',WIOF.intYear,' -> ',orders.strOrderNo,' / ',orders.strStyle) as GP ,
WIOF.dblQty,
COALESCE((select sum(dblQty) from was_rcvdfromfactory WRF where WIOF.intStyleId=WRF.intStyleId and WIOF.strColor=WRF.strColor and WRF.dblGPNo=WIOF.dblGPNo and WRF.intGPYear=WIOF.intYear
group by intStyleId,strColor),0) as tiQty
FROM was_issuedtootherfactory WIOF
Inner Join orders ON WIOF.intStyleId = orders.intStyleId 
WHERE WIOF.intToFactory ='".$_SESSION['FactoryID']."' or WIOF.intCompanyId='".$_SESSION['FactoryID']."'
group by WIOF.dblGPNo,WIOF.intStyleId,WIOF.strColor
having WIOF.dblQty>tiQty";
$resGP=$db->RunQuery($sqlGP);

while($rowGP=mysql_fetch_array($resGP))
{
echo "<option value=\"".$rowGP['intYear']."/".$rowGP['dblGPNo']."\">".$rowGP['GP']."</option>";
}
?>
                                        </select>                                    </td>
                                    
                                   
                                    <td style="width:50px;">&nbsp;                                    </td>
                                </tr>
                            	<tr>
                                	<td style="width:50px;">&nbsp;                                    </td>
                                	<td class="normalfnt" style="width:100px;">From Factory</td>
                                    <td colspan="3" class="normalfnt" style="width:500px;">
                                    	<select name="wasOther_txtFromFactoryS" id="wasOther_txtFromFactoryS" style="width:408px;" onchange="loadCompayPos();" disabled="disabled">
                                        	<option value="">Select One</option>
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
                                	<td style="width:50px;">&nbsp;                                    </td>
                                	<td class="normalfnt" style="width:100px;">To Factory</td>
                                    <td colspan="3" class="normalfnt" style="width:500px;">
                                    	<select name="wasOther_txtToFactoryS" id="wasOther_txtToFactoryS" style="width:408px;" onchange="loadCompayPos();" disabled="disabled">
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
                                        </select>                                    </td>
                                    <td style="width:50px;">&nbsp;                                    </td>
                                </tr>
                                <tr>
                                	<td style="width:50px;">&nbsp;                                    </td>
                                	<td class="normalfnt" style="width:100px;">Sewing Factory</td>
                                    <td colspan="3" class="normalfnt" style="width:500px;">
                                    	<select name="wasOther_txtSFactoryS" id="wasOther_txtSFactoryS" style="width:408px;" disabled="disabled">
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
                                	<td style="width:50px;">&nbsp;                                    </td>
                                	<td class="normalfnt" style="width:100px;">
                                    	PO No                                    </td>
                                    <td class="normalfnt" style="width:200px;">
                                    	<select name="wasOther_cboPOS" id="wasOther_cboPOS" style="width:102px;" onchange="loadColor(this);">
                                        	<option></option>
                                        </select>                                    </td>
                                    <td class="normalfnt" style="width:100px;">
                                    	Style No                                    </td>
                                    <td style="width:200px;" class="normalfnt">
                                    	<select name="wasOther_txtStyleS" id="wasOther_cboStyleS" style="width:100px;" onchange="loadPO(this.value);">
                                        	<option></option>
                                        </select>                                    </td>
                                    <td style="width:50px;">&nbsp;                                    </td>
                                </tr>
                                <tr>
                                	<td style="width:50px;">&nbsp;                                    </td>
                                	<td class="normalfnt" style="width:100px;">
                                    	Color</td>
                                    <td class="normalfnt" style="width:200px;">
                       	  <select name="wasOther_cboColorS" id="wasOther_cboColorS" style="width:102px;" onchange="loadQty(this);">
                                        	<option></option>
                                        </select>                                    </td>
                                    <td class="normalfnt" style="width:100px;">&nbsp;</td>
                                    <td style="width:200px;" class="normalfnt">&nbsp;</td>
                                    <td style="width:50px;">&nbsp;                                    </td>
                                </tr>
                                <tr>
                                	<td style="width:50px;">&nbsp;                                    </td>
                                	<td class="normalfnt" style="width:100px;">
                                    	Order Qty                                    </td>
                                    <td class="normalfnt" style="width:200px;">
                                   		<input type="text" style="text-align:right;width:100px;" id="wasOther_txtOderQty" name="wasOther_txtOderQty" readonly="readonly" />                                    </td>
                                    <td class="normalfnt" style="width:100px;">
                                    	GatePass Qty                                    </td>
                                    <td style="width:200px;">
                                    	<input type="text" style="text-align:right;width:100px;" id="wasOther_txtRecvQty" name="wasOther_txtRecvQty" readonly="readonly"/>                                    </td>
                                    <td style="width:50px;">&nbsp;                                    </td>
                                </tr>
                                <tr>
                                	<td style="width:50px;">&nbsp;                                    </td>
                                	<td class="normalfnt" style="width:100px;"><span class="normalfnt" style="width:100px;"><span class="normalfnt" style="width:100px;">Receiving</span> Qty</span></td>
                                    <td class="normalfnt" style="width:200px;"><input type="text" id="wasOther_txtSQty" name="wasOther_txtSQty" style="text-align:right;width:100px;" onkeypress="return CheckforValidDecimal(this.value,0,event);" onkeyup="checkBalance(this);" /></td>
                                    <td class="normalfnt" style="width:100px;"><span class="normalfnt" style="width:100px;">Available Qty</span></td>
                                    <td style="width:200px;"><span class="normalfnt" style="width:200px;"><span class="normalfnt" style="width:200px;">
                               	<input type="text" style="text-align:right;width:100px;" id="wasOther_txtAVLQty" name="wasOther_txtAVLQty" readonly="readonly"/>
                                    	</span></span> </td>
                                    <td style="width:50px;">&nbsp;                                    </td>
                                </tr>
                                <tr>
                                	<td style="width:50px;">&nbsp;                                    </td>
                                	<td class="normalfnt" style="width:100px;"><span class="normalfnt" style="width:100px;"><span class="normalfnt" style="width:100px;">Reason</span></span></td>
                                    <td class="normalfnt" style="width:200px;"><select name="wasOther_cboReason" id="wasOther_cboReason" style="width:204px;" disabled="disabled">
                                    	<option value="">Select One</option>
                                        <?php
                                        $sql="select intSerialNo,strProcessName from was_washformula where intStatus='1' -- and intProcType='2';";
										$res=$db->RunQuery($sql);
										while($row=mysql_fetch_array($res)){
											echo "<option value=\"".$row['intSerialNo']."\">".$row['strProcessName']."</option>";
										}
										?>
                                    </select></td>
                                    <td class="normalfnt" style="width:100px;">&nbsp;</td>
                                    <td style="width:200px;">&nbsp;</td>
                                    <td style="width:50px;">&nbsp;                                    </td>
                                </tr>
                                <tr>
                                	<td style="width:50px;">&nbsp;</td>
                                    <td style="width:50px;" class="normalfnt">Remarks</td>
                                    <td colspan="3" style="width:500px;" class="normalfnt">
                                      <textarea name="wasOther_txtRemarks" id="wasOther_txtRemarks" style="width:408px;" cols="20" rows="1">
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
                                                        <img src="../../images/new.png" id="butNew" onclick="ClearForm();" tabindex="10" title="Click to clear the page"/>
                                                        <img src="../../images/save.png" name="Save" width="80" id="Save" title="Click to save details" onclick="Save_receive();" tabindex="7"/>
                                                        <img src="../../images/report.png" id="butReport" alt="report" tabindex="8" title="Click to view report" onclick="showRpt();" style="display:none;"/>
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