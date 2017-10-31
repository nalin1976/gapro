<?php
session_start();
$backwardseperator = "../../../";
include_once("${backwardseperator}authentication.inc");
include_once("${backwardseperator}Connector.php");
include_once("../class/class.washing_qc.php");
$factory=$_SESSION['FactoryID'];
$wqcObj=new classWashingQC();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="../../../javascript/jquery.js"></script>
<script src="../../../javascript/script.js" type="text/javascript"></script>
<script src="qc_finish.js" type="text/javascript"></script>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<title>Gapro | Washing QC Line Recoders Entry</title>
</head>
<body>
<table width="100%">
<tr>
	<td><?php include("${backwardseperator}Header.php");?></td>
</tr>
</table>
<form name="frmWetQc" id="frmWetQc">
<table width="51%" align="center" class="main_border_line" border="0">
	<tr>
    	<td class="mainHeading" colspan="8">QC Check Finsh Entry</td>
    </tr>
    <tr>
    	<td width="17%" class="normalfnt">Order No</td>
        <td width="35%">
       	 <select style="width:220px;" onchange="getColor(this);" id="cboOrderNo" name="cboOrderNo">
         	<option value="" >Select One</option>
            <?php 
			$sql="SELECT DISTINCT orders.intStyleId,orders.strOrderNo FROM was_stocktransactions INNER JOIN orders ON orders.intStyleId = was_stocktransactions.intStyleId
WHERE was_stocktransactions.intCompanyId='$factory' order by orders.strOrderNo;";
	
		$res=$db->RunQuery($sql);
			//$res=$wqcObj->getPoNo($factory);
			while($row=mysql_fetch_assoc($res)){
				echo "<option value=\"".$row['intStyleId']."\">".$row['strOrderNo']."</option>";
				
			}?>
            
         </select>
        </td>
        <td width="11%" class="normalfnt">Color</td>
        <td width="37%"><input type="text" style="width:220px;" readonly="readonly" id="txtColor" name="txtColor" /></td>
        
    </tr>
    <tr>
    	<td class="normalfnt">Sewing Factory</td><td colspan="3">
        	<select style="width:450px;" id="cboSewingFactory" disabled="disabled">
            	<option value="">Select One</option>
                <?php
                $sql="SELECT DISTINCT companies.intCompanyID,companies.strName FROM companies ORDER BY companies.strName ASC";
				$res=$db->RunQuery($sql);
				while($row=mysql_fetch_assoc($res)){
					echo "<option value=".$row['intCompanyID'].">".$row['strName']."</option>";
				}
				?>
            </select>
        </td>
    </tr>
    <tr>
    	<td class="normalfnt">Line Recoder</td><td>
        <select id="cboLineRecoder" name="cboLineRecoder" style="width:220px;" onchange="getEpfNoDet(this);">
        	<option value="">Select One</option>
          <?php
          $resL=$wqcObj->getLineRecoder($_SESSION['FactoryID']);
		  while($rowL=mysql_fetch_assoc($resL)){
			 echo "<option value=\"".$rowL['intOperatorId']."\">".$rowL['strName']."</option>";
		  }
		  ?>
        </select></td>
        <td class="normalfnt">EPF No</td><td><input type="text" id="txtEpfNo" readonly="readonly"/></td>
        
    </tr>
    <tr>
    	<td class="normalfnt">Shift</td><td width="35%">
        <select style="width:100px;" id="cboShift" name="cboShift">
        	<option value="">Select One</option>
            <?php
            $sql="select intShiftId,strShiftName from was_shift where intStatus='1';";
			$res=$db->RunQuery($sql);
			while($rowS=mysql_fetch_assoc($res)){
				echo "<option value=\"".$rowS['intShiftId']."\">".$rowS['strShiftName']."</option>;";
			}
			?>
        </select>
        </td>
        <td width="11%" class="normalfnt">Date</td>
        <td width="37%"><input type="text" style="width:100px;" value="<?php echo date("Y-m-d");?>"/></td>
    </tr>
    <tr>
    	<td class="normalfnt" colspan="4">
        	<table  width="100%">
            	<tr>
                    <td width="18%">&nbsp;</td>
                    <td width="24%">Checked Qty</td>
                    <td width="24%">Damaged Qty</td>
                    <td width="34%">Check Finish Qty</td>
                </tr>
                <tr>
                    <td width="18%">&nbsp;</td>
                    <td width="24%">
                    <input type="text" value="" id="CheckedQty" name="CheckedQty" maxlength="10" onkeypress="return isValidZipCode(this.value,event);" style="text-align:right;" onkeyup="setBalance(this);" />
                    </td>
                    <td width="24%">
                    <input type="text" value="" id="DamagedQty" name="DamagedQty" maxlength="10"  onkeypress="return isValidZipCode(this.value,event);" style="text-align:right;" onkeyup="setBalance(this);" />
                    </td>
                    <td width="34%">
                    <input type="text" value="" id="CheckFinishQty" name="CheckFinishQty" maxlength="10" readonly="readonly"/></td>
                </tr>
                <tr>
                    <td width="18%">&nbsp;</td>
                    <td width="24%">&nbsp;</td>
                    <td width="24%">&nbsp;</td>
                    <td width="34%">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>

        	<td colspan="4" align="center" >
            	<div align="center" class="main_border_line">
                	<img src="../../../images/new.png" onclick="clearFrom();" />
                    <img src="../../../images/save.png" onclick="saveCheckFinish();" />
                    <img src="../../../images/report.png" />
                   <a href="../../../main.php"><img src="../../../images/close.png" border='0'/></a>
                </div>
            </td>
    </tr>
</table>
</form>
</body>
</html>