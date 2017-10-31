<?php
session_start();
$backwardseperator = "../../";	
include "${backwardseperator}authentication.inc";
include("{$backwardseperator}Connector.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Lab Testing Gatepass</title>
<link href="../../js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../css/tableGrib.css" rel="stylesheet" type="text/css" />
    
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<script type="text/javascript" src="labTestingGP.js"></script>
</head>

<body>
<table width="100%">
    <tr>
        <td>
        	<?php include("{$backwardseperator}Header.php");?>
        </td>
    </tr>
    <tr>
        <td width="50%">
        <form id="frm">
        	<table width="50%" align="center" class="tableBorder">
            	<tr>
                	<td class="mainHeading" colspan="6"> Lab Testing Gatepass</td>
                </tr>
                <tr>
                	<td width="5%">&nbsp; </td>
                    <td width="16%">&nbsp; </td>
                    <td width="30%">&nbsp; </td>
                    <td width="16%" class="normalfnt">Gatepass No </td>
                    <td width="30%"><input type="text" name="txtGPNo" id="txtGPNo" style="width:147px;text-align:right;"/> </td>
                    <td  width="5%">&nbsp; </td>
                </tr>
                <tr>
                	<td>&nbsp; </td>
                	<td class="normalfnt">PO No<span class="compulsoryRed">*</span></td>
                    <td>
                    	<select name="cboPO" id="cboPO" style="width:150px;" onchange="loadStyle(this)">
                        	<option value="">Select One</option>
                            <?php 
							  $sql="SELECT DISTINCT
									o.strStyle,
									o.strOrderNo,
									o.intStyleId
									FROM
									was_stocktransactions AS w
									INNER JOIN orders AS o ON w.intStyleId = o.intStyleId
									INNER JOIN was_mrn ON was_mrn.intStyleId = o.intStyleId
									WHERE
									w.intCompanyId ='".$_SESSION['FactoryID']."'";
									
							$res=$db->RunQuery($sql);
							while($row=mysql_fetch_assoc($res)){
								echo "<option value=\"".$row['intStyleId']."\">".$row['strOrderNo']."</option>";
							}
							?>
                    	</select>
                    </td>
                    <td class="normalfnt">Style No</td>
                    <td>
                    	<select name="cboStyle" id="cboStyle" style="width:150px;" onchange="loadPO(this)">
                        	<option value="">Select One</option>
                            <?php 
							$sql="SELECT DISTINCT
									o.strStyle,
									o.strOrderNo,
									o.intStyleId
									FROM
									was_stocktransactions AS w
									INNER JOIN orders AS o ON w.intStyleId = o.intStyleId
									INNER JOIN was_mrn ON was_mrn.intStyleId = o.intStyleId
									WHERE
									w.intCompanyId ='".$_SESSION['FactoryID']."'";
									
							$res=$db->RunQuery($sql);
							while($row=mysql_fetch_assoc($res)){
								echo "<option value=\"".$row['strStyle']."\">".$row['strStyle']."</option>";
							}
							?>
                    	</select>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                	<td width="5%">&nbsp; </td>
                    <td width="16%" class="normalfnt">Color</td>
                    <td width="30%">
                    <select name="cboColor" id="cboColor" style="width:150px;">
                        	<option value="">Select One</option>
                    </select>
                    </td>
                    <td width="16%" class="normalfnt">Vehicle No</td>
                    <td width="30%"><input type="text" name="txtVNo" id="txtVNo" style="width:147px;"/> </td>
                    <td  width="5%">&nbsp; </td>
                </tr>
                <tr>
                	<td width="5%">&nbsp; </td>
                    <td width="16%" class="normalfnt">Order Qty</td>
                    <td width="30%"><input type="text" name="txtOrderQty" id="txtOrderQty" style="width:147px;"/></td>
                    <td width="16%" class="normalfnt">Request No<span class="compulsoryRed">*</span></td>
                    <td width="30%">
                    	<select name="cboRNo" id="cboRNo" style="width:150px;" onchange="getMRNQty(this);" >
                        <option value="">Select One</option>
                        </select>
                    </td>
                    <td  width="5%">&nbsp; </td>
                </tr>
                <tr>
                	<td width="5%">&nbsp; </td>
                    <td width="16%" class="normalfnt">From Factory</td>
                    <td colspan="3">
                    <select name="cboFFac" id="cboFFac" style="width:450px;" disabled="disabled">
                        	<option value="">Select One</option>
                            <?php
                            $sql="SELECT strName,intCompanyID from companies where intCompanyID='".$_SESSION['FactoryID']."';";
							$res=$db->RunQuery($sql);
							while($row=mysql_fetch_array($res)){
								echo "<option value=\"".$row['intCompanyID']."\" selected=\"selected\">".$row['strName']."</option>";
							}
							?>
                    </select>
                    </td>
                    <td  width="5%">&nbsp; </td>
                </tr>
                <tr>
                	<td width="5%">&nbsp; </td>
                    <td width="16%" class="normalfnt">Sewing Factory</td>
                    <td colspan="3">
                    <select name="cboSFac" id="cboSFac" style="width:450px;" disabled="disabled">
                        	<option value="">Select One</option>
                            <?php
                            $sql="SELECT strName,intCompanyID from companies;";
							$res=$db->RunQuery($sql);
							while($row=mysql_fetch_array($res)){
								echo "<option value=\"".$row['intCompanyID']."\">".$row['strName']."</option>";
							}
							?>
                    </select>
                    </td>
                    <td  width="5%">&nbsp; </td>
                </tr>
                <tr>
                	<td width="5%">&nbsp; </td>
                    <td width="16%" class="normalfnt">To Factory<span class="compulsoryRed">*</span></td>
                    <td colspan="3">
                    <select name="cboTFac" id="cboTFac" style="width:450px;">
                        	<option value="">Select One</option>
                            <?php 
		$sql="SELECT DISTINCT was_outside_companies.intCompanyID,was_outside_companies.strName FROM was_outside_companies WHERE was_outside_companies.intStatus = 1 ORDER BY was_outside_companies.strName ASC;";
		$res=$db->RunQuery($sql);
		while($row=mysql_fetch_array($res)){
				echo "<option value=\"".$row["intCompanyID"]."\">".$row["strName"]."</option>";
		}?>
                    </select>
                    </td>
                    <td  width="5%">&nbsp; </td>
                </tr>
                 <tr>
                	<td width="5%">&nbsp; </td>
                    <td width="16%" class="normalfnt">Available Qty</td>
                    <td width="30%">
                    <input type="text" name="cboAvQty" id="cboAvQty" style="width:147px;text-align:right;" />
                    </td>
                    <td width="16%" class="normalfnt">Send Qty<span class="compulsoryRed">*</span> </td>
                    <td width="30%"><input type="text" name="txtSendQty" id="txtSendQty" style="width:147px;text-align:right;"  onkeypress="return isValidZipCode(this.value,event);" maxlength="8" onkeyup="setBalance(this);"/> </td>
                    <td  width="5%">&nbsp; </td>
                </tr>
                <tr>
                	<td width="5%">&nbsp; </td>
                    <td width="16%" class="normalfnt">Remarks</td>
                    <td colspan="3">
                    <textarea rows="1" cols="20" style="width: 445px;" id="txtRemarks" name="txtRemarks">  </textarea>
                    </td>
                    <td  width="5%">&nbsp; </td>
                </tr>
                <tr>
                	<td width="5%">&nbsp; </td>
                    <td width="16%" class="normalfnt">&nbsp;</td>
                    <td colspan="3">&nbsp;</td>
                    <td  width="5%">&nbsp; </td>
                </tr>
                <tr>
                    <td colspan="6" align="center">
                    	<table class="tableBorder" width="80%">
                            <tr>
                                <td align="center">
                                    <img src="../../images/new.png" onclick="clearForm();"/>
                                    <img src="../../images/save.png" onclick="saveDet();" id="save"/>
                                    <img src="../../images/report.png" style="display:none;" id="rpt" onclick="loadReport();"/>
                                   <a href="../../main.php"><img border="0" tabindex="13" title="Click to go to main page" alt="close" id="butClose" src="../../images/close.png"></a>
                                </td>
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