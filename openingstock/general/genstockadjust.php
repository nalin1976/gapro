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
<title>GaPro | Style Items - General Stock Adjust</title>
<script type="text/javascript" src="genstockadjust.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>
</head>

<body >
<form id="frmGeneralStockAdjestment" name="frmGeneralStockAdjestment">
<tr>
<td><?php include '../../Header.php'; ?></td>
</tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">
  <tr>
    <td height="26" class="mainHeading">General Stock Adjustment </td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="0">      	
		<tr>
			<td><table width="100%" border="0" cellspacing="1" cellpadding="5" class="tableBorder">
              <tr>
                <td width="9%"><span class="normalfnt">&nbsp;Serial No</span></td>
                <td width="17%"><input  type="text" name="txtSerialNo" class="txtbox" id="txtSerialNo" style="width:148px" disabled="disabled"/></td>
                <td width="4%">&nbsp;</td>
                <td width="17%"><img src="../../images/view.png" alt="view" align="absbottom" onclick="SearchPopUp();" style="visibility:hidden" /></td>
                <td width="10%">&nbsp;</td>
                <td width="11%"><span class="normalfnt">Cost Center</span></td>
                <td width="32%"><select name="cboCostCenter" class="txtbox" id="cboCostCenter" style="width:285px" tabindex="4">
                  <?PHP		
$sql="select intCostCenterId,strDescription from costcenters where intStatus=1 and intFactoryId='$companyId' order by strDescription";	 
$result =$db->RunQuery($sql);
	echo "<option value =\"".""."\">"."Select One"."</option>";
while ($row=mysql_fetch_array($result))
{		
	echo "<option value=\"".$row["intCostCenterId"]."\">".$row["strDescription"]."</option>";
}
?>
                  </select></td>
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
            <td width="32%" title="<?php //echo $commonBinID ;?>" id="titCommonBinID">&nbsp;</td>
            <td width="57%" title="<?php echo $Status ;?>" id="titStatus">&nbsp;</td>
            <td width="11%" ><img src="../../images/add-new.png" width="109" id="butNew" height="18" onclick="OpenItemPopUp();" tabindex="8" /></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><div id="divMain" style="overflow:scroll; height:300px; width:950px;">
          <table id="tblMain" width="1020" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
            <tr class="mainHeading4">
              <td width="3%" height="25" >Del</td>
              <td width="13%" >Main Category</td>
              <td width="12%" >Sub Category</td>
			  <td width="24%" >Item Description</td>
              <td width="9%" >Unit</td>
              <td width="9%" >Unitprice</td>
              <td width="8%" >Stock Qty</td>
              <td width="9%" >Adjust Qty</td>
			   <td width="5%" >- / +</td>
               <td width="8%">Location</td>
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
        <img src="../../images/save-confirm.png" alt="Save" id="butSave" style="display:inline" onclick="SaveOpenStock();" />
		<img src="../../images/report.png" alt="Report" border="0" id="butReport" style="display:inline" onclick="ViewReport();"/>
        <a href="../../main.php"><img src="../../images/close.png" alt="close" border="0" id="butClose" style="display:inline" /></a>
		</td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<!--Start - Search popup-->
<div style="left:418px; top:142px; z-index:10; position:absolute; width: 261px; visibility:hidden; height: 61px;" id="NoSearch" >
  <table width="260" height="71" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
            <td height="22" class="mainHeading" colspan="6"><span class="mainHeading"><img src="../../images/cross.png" alt="rep" align="right" onclick="closeFindReturn();" /></span></td>
            
          </tr>
          <tr>
		  	<td width="4" height="22" class="normalfnt"></td>
            <td width="44" height="22" class="normalfnt">State </td>
            <td width="108"><select name="select3" class="txtbox" id="cboState" style="width:100px" onchange="LoadPopUpNo();">              
              <option value="1">Saved & Confirmed</option>              
			  <option value="10">Cancelled</option>
            </select></td>
            <td width="37" class="normalfnt">Year</td>
            <td width="55"><select name="select4" class="txtbox" id="cboYear" style="width:55px" onchange="LoadPopUpNo();">
             
			   <?php
	
	$SQL = "SELECT DISTINCT intReturnToSupYear FROM returntosupplierheader ORDER BY intReturnToSupYear DESC;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intReturnToSupYear"] ."\">" . $row["intReturnToSupYear"] ."</option>" ;
	}
	
	?>
            </select></td>
            <td width="10">&nbsp;</td>
          </tr>
          <tr>
		  <td width="4" height="27" class="normalfnt"></td>
            <td><div align="center" class="normalfnt">Job No</div></td>
            <td><select name="select" class="txtbox" id="cboNo" style="width:100px" onchange="loadPopUpReturnToStores();">
			<option value="Select One" selected="selected">Select One</option>
            </select>            </td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
  </table>
		

</div>
<!--End - Search popup-->
</body>
</html>
 <script type="text/javascript" src="../../js/jquery.fixedheader.js"></script>