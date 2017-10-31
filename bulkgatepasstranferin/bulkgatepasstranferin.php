<?php
	session_start();
	include "../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
	$backwardseperator = "../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Bulk Gatepass Transfer IN</title>
<script src="../javascript/script.js" type="text/javascript"></script>
<script type="text/javascript" src="bulkgatepasstranferin.js"></script>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />

<script src="java.js" type="text/javascript"></script>
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>
</head>
<body>
<form id="frmGPTranferIn" name="frmGPTranferIn">
  <tr>
    <td><?php include '../Header.php'; ?></td>
  </tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="bcgl1">
  <tr>
    <td height="25" class="mainHeading">Bulk Gate Pass TransferIn</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="bcgl1">
      <tr>
        <td width="1">&nbsp;</td>
        <td width="83" class="normalfnt">Gate Pass No</td>
        <td width="175"><span class="normalfnt">
          <select name="cboGatePassNo" class="txtbox" id="cboGatePassNo" style="width:175px" onchange="LoadGatePassDetails();">
            <?php
		$SQL= "SELECT DISTINCT CONCAT(BGP.intGatePassYear,'/',BGP.intGatePassNo) AS GatePassNo 
		FROM bulk_gatepassheader AS BGP 
		Inner Join bulk_gatepassdetails AS BGPD ON BGPD.intGatePassNo = BGP.intGatePassNo AND BGP.intGatePassYear = BGPD.intGatePassYear 
		Inner Join mainstores AS MS ON BGP.intDestination = MS.strMainID 
		WHERE BGP.intStatus =1 AND 
		BGPD.dblBalQty >0 AND 
		MS.intCompanyId ='$companyId'
		union 
		SELECT DISTINCT CONCAT(BGPH.intGatePassYear,'/',BGPH.intGatePassNo) AS GatePassNo 
		FROM bulk_gatepassheader AS BGPH 
		Inner Join bulk_gatepassdetails AS BGPD ON BGPD.intGatePassNo = BGPH.intGatePassNo AND BGPH.intGatePassYear = BGPD.intGatePassYear 
		WHERE BGPH.intStatus =1 AND 
		BGPD.dblBalQty >0 AND 
		BGPH.intCompanyId ='$companyId'
		order by GatePassNo desc";
		$result =$db->RunQuery($SQL);
		
			echo "<option value =\"".""."\">"."Select One"."</option>";
		while ($row=mysql_fetch_array($result))
		{
			echo "<option value=\"". $row["GatePassNo"] ."\">" . $row["GatePassNo"] ."</option>" ;
		}
	  
	  ?>
          </select>
        </span></td>
        <td width="41"><div align="center"><span class="normalfnt">Date</span></div></td>
        <td width="151"><input  type="text" name="cboGatePassNo2" class="txtbox" id="cboGatePassNo2" style="width:98px" readonly="" value="<?php echo date ("d/m/Y") ?>" /></td>
        <td width="18"><span class="normalfnt">
          <?PHP
$sqlsetting="select strValue from settings where strKey='CommonStockActivate'";
$result_setting=$db->RunQuery($sqlsetting);
while($row_setting=mysql_fetch_array($result_setting))
{
	$commonBinID	= $row_setting["strValue"];	
}	
?>
        </span></td>
        <td width="47">&nbsp;</td>		
        <td width="94"><span class="normalfnt">Main Stores</span></td>
        <td width="285" class="normalfnt"><select name="cboMainStore" class="txtbox" id="cboMainStore" style="width:285px" onchange="LoadSubStores(this.value);">
          <?php
		$SQL ="select strMainID,strName from mainstores where intStatus=1 AND intCompanyId=$companyId";
		$result = $db->RunQuery($SQL);
					
					echo "<option value=\"". "" ."\">" . "Select One" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"". $row["strMainID"] ."\">" . $row["strName"] ."</option>" ;
					}	
	?>
        </select></td>
        <td width="13"></select></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="normalfnt">TransferIn No</td>
        <td colspan="3"><input  type="text" name="cboGPTransInNo" class="txtbox" id="cboGPTransInNo" style="width:100px" readonly="" />
          <img src="../images/view.png" alt="view" align="absbottom" onclick="SearchPopUp();" /></td>
        <td>&nbsp;</td>
        <td width="47">&nbsp;</td>
        <td width="94"><span class="normalfnt">Sub Stores</span></td>
        <td><span class="normalfnt">
          <select name="cbosubstores" class="txtbox" id="cboSubStores" style="width:285px">
            <?php
		$SQL = "Select strSubID,strSubStoresName from substores where intStatus=1";
		$result = $db->RunQuery($SQL1);
					
					
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"". $row["strSubID"] ."\">" . $row["strSubStoresName"] ."</option>" ;
					}	
	?>
          </select>
        </span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><span class="normalfnt">Remarks</span></td>
        <td class="normalfnt"><input name="txtRemarks" type="text" class="txtbox" id="txtRemarks" style="width:282px;" maxlength="100" /></td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
      <tr>
        <td class="mainHeading2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
<?PHP
$sqlsetting="select strValue from settings where strKey='CommonStockActivate'";
$result_setting=$db->RunQuery($sqlsetting);
while($row_setting=mysql_fetch_array($result_setting))
{
	$commonBinID	= $row_setting["strValue"];	
}
?>
          <tr>
            <td width="32%" title="<?php //echo $commonBinID ;?>" id="titCommonBinID">&nbsp;</td>
            <td width="56%" >&nbsp;</td>
            <td width="12%" ><img src="../images/add_bin.png" width="109" height="18" onclick="autoBin();" /></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><div id="divTransInMain" style="overflow:scroll; height:310px; width:950px;">
          <table id="tblTransInMain" width="932" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
            <tr class="mainHeading4">
              <td width="4%" height="25">Del</td>
              <td width="28%">Item Description</td>
              <td width="7%">Color</td>
              <td width="8%">Size</td>
              <td width="8%">Unit</td>
              <td width="11%">GatePass Qty</td>
              <td width="11%">Trans In Qty</td>
              <td width="4%"></td>
              <td width="10%">GRN
                No</td>
              <td width="9%">GRN
                Year</td>
            </tr>
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
 
  <tr >
    <td height="30"><table width="100%" border="0" class="bcgl1">
      <tr>
        <td width="18%" class="normalfntMid">
        <img src="../images/new.png" alt="new" width="96" height="24" onclick="ClearForm();" />
        <img src="../images/save-confirm.png" alt="save" width="174" height="24" id="cmdSave" onclick="SaveValidation();"/>
        <img src="../images/report.png" alt="Report" width="108" height="24" onclick="showReport();"  />
        <a href="../main.php"><img src="../images/close.png" alt="close" width="97" height="24" border="0" /></a>
        </td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<div style="left:550px; top:380px; z-index:10; position:absolute; width: 240px; visibility:hidden; " id="gotoReport" ><table width="270" height="65" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
            <td width="82" height="27">State </td>
            <td width="186"><select name="select3" class="txtbox" id="cboReportState" style="width:100px" onchange="LoadPopUpTransIn();">              
              <option value="1">Confirm</option>
              <option value="10">Cancel</option>
            </select></td>
            <td width="186">Year</td>
            <td width="186"><select name="select4" class="txtbox" id="cboReportYear" style="width:55px" onchange="LoadPopUpTransIn();">
             
			   <?php
	
	$SQL = "SELECT DISTINCT intTINYear FROM gategasstransferinheader ORDER BY intTINYear DESC;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["intTINYear"] ."\">" . $row["intTINYear"] ."</option>" ;
	}
	
	?>
            </select></td>
          </tr>
          <tr>
            <td><div align="center">TransIn</div></td>
            <td><select name="select" class="txtbox" id="cboRptTransIn" style="width:100px" onchange="showReport();">
			<option value="Select One" selected="selected">Select One</option>
            </select>            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
		
		
</div>
<!--Start - Search popup-->
<div style="left:418px; top:142px; z-index:10; position:absolute; width: 261px; visibility:hidden; height: 61px;" id="NoSearch" >
  <table width="260" height="59" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
  		<tr>
        	<td colspan="6" bgcolor="#550000" align="right"><img src="../images/cross.png" onClick="SearchPopUp();" alt="Close" name="Close" width="17" height="17" id="Close"/></td>
        </tr>
          <tr>
		  	<td width="4" height="22" class="normalfnt"></td>
            <td width="44" height="22" class="normalfnt">State </td>
            <td width="108"><select name="select3" class="txtbox" id="cboState" style="width:100px" onchange="LoadPopUpNo();">              
              <option value="1">Saved & Confirmed</option>              
			  <!--<option value="10">Cancelled</option>-->
            </select></td>
            <td width="37" class="normalfnt">Year</td>
            <td width="55"><select name="select4" class="txtbox" id="cboYear" style="width:55px" onchange="LoadPopUpNo();">
             
			   <?php
	
	$SQL = "SELECT DISTINCT intTransferInYear FROM bulk_gatepasstransferinheader ORDER BY intTransferInYear DESC;";
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["intTransferInYear"] ."\">" . $row["intTransferInYear"] ."</option>" ;
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
