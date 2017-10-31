<?php
	session_start();
	include "../../Connector.php";	
	$companyId = $_SESSION["FactoryID"];
	$backwardseperator = "../../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Chemical Allocation</title>
<script type="text/javascript" src="chemicalAllocation.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>
</head>

<body >
<form id="frmChemicalAllocation" name="frmChemicalAllocation">
<tr>
<td><?php include '../../Header.php'; ?></td>
</tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">
  <tr>
    <td height="26" class="mainHeading">Chemical Allocation</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="0">      	
		<tr>
			<td><table width="100%" border="0" cellspacing="1" cellpadding="5" class="tableBorder">
              <tr>
                <td width="1%" ><div id="comboUnit" style="width:90px;display:none"><select name="cboUnit" class="txtbox" id="cboUnit" style="width:90px" onchange="setUnit(this)" >
                  <?PHP		
$sql="select strUnit from units where intStatus=1 order by strUnit";	 
$result =$db->RunQuery($sql);
	echo "<option value =\"".""."\"></option>";
while ($row=mysql_fetch_array($result))
{		
	echo "<option value=\"".$row["strUnit"]."\">".$row["strUnit"]."</option>";
}
?>
                </select></div></td>
                <td width="8%" class="normalfnt" >Serial No</td>
                <td width="48%" ><input  type="text" name="txtSerialNo" class="txtbox" id="txtSerialNo" style="width:148px" disabled="disabled"/></td>
                <!--<td width="11%"><span class="normalfnt">Cost Center</span></td>
                <td width="32%" ><select name="cboCostCenter" class="txtbox" id="cboCostCenter" style="width:285px" tabindex="4">
                  <?PHP		
$sql="select intCostCenterId,strDescription from costcenters where intStatus=1 and intFactoryId='$companyId' order by strDescription";	 
$result =$db->RunQuery($sql);
	echo "<option value =\"".""."\">"."Select One"."</option>";
while ($row=mysql_fetch_array($result))
{		
	echo "<option value=\"".$row["intCostCenterId"]."\">".$row["strDescription"]."</option>";
}
?>
                  </select></td>-->
              </tr>
            </table></td>
		</tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="mainHeading2">
          <tr>
            <td width="32%" height="23" id="titCommonBinID" title="<?php //echo $commonBinID ;?>">&nbsp;</td>
            <td width="57%" title="<?php echo $Status ;?>" id="titStatus">&nbsp;</td>
            <td width="11%" ><img src="../../images/add-new.png" width="109" id="butNew" height="18" onclick="OpenItemPopUp();" tabindex="8" /></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><div id="divMain" style="overflow:scroll; height:300px; width:950px;">
          <table id="tblMain" width="1100" border="0" cellpadding="2" cellspacing="1" bgcolor="#CCCCFF">
            <tr class="mainHeading4">
              <td width="3%" height="25" >Del</td>
              <td width="20%" >Item Description</td>
              <td width="9%" >Unit</td>
              <td width="9%" >Unitprice</td>
              <td width="8%" >Stock Qty</td>
              <td width="8%">Add Chemicals</td>
              <!--<td width="6%">GL Code</td>
              <td width="16%">GL Description</td>-->
            </tr>
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr >
    <td height="30"><table width="100%" border="0" class="tableBorder">
      <tr>	
        <td width="15%" class="normalfntMid">
        <img src="../../images/new.png" alt="new" border="0" id="butNew" style="display:inline" onclick="ClearForm();" />
        <img src="../../images/save-confirm.png" alt="Save" id="butSave" onclick="SaveChemAllocation();" />
		<img src="../../images/report.png" alt="Report" border="0" id="butReport" style="display:inline" onclick="ViewReport();"/>
        <a href="../../main.php"><img src="../../images/close.png" alt="close" border="0" id="butClose" style="display:inline" /></a>
		</td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
 <script type="text/javascript" src="../../js/jquery.fixedheader.js"></script>