<?php
	session_start();
	include "../../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
	$backwardseperator = "../../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | General - Gatepass Transfer IN</title>

<script type="text/javascript" src="gentranferin.js"></script>
<script type="text/javascript" src="gentranferinlist.js"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="java.js" type="text/javascript"></script>
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>
</head>

<body onload="loadGrnFrom(
<?php 	
$id = $_GET["id"];
if($id!=0)
{
	echo $_GET["GRNNo"] ; echo "," ; echo $_GET["intYear"] ; echo "," ; echo $_GET["category"];
}
else
	echo "0,0,99";
?> );">
<form id="frmGPTranferIn" name="frmGPTranferIn">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">
  <tr>
    <td height="25" class="mainHeading">General - Gate Pass TransferIn</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="2" cellpadding="0" class="bcgl1">
      <tr>
        <td><table width="100%" border="0" >
          <tr>
            <td width="1">&nbsp;</td>
            <td width="82" class="normalfnt">Gate Pass No</td>
            <td width="146">
              <select name="cboGatePassNo" class="txtbox" id="cboGatePassNo" style="width:175px" onchange="LoadGatePassDetails();">
                <?php	
		$SQL= "SELECT DISTINCT CONCAT(GP.intYear,'/',GP.strGatepassID) AS GatePassNo FROM gengatepassheader AS GP 
Inner Join gengatepassdetail AS GPD ON GPD.strGatepassID = GP.strGatepassID AND GP.intYear = GPD.intYear 
WHERE GP.intStatus =1 AND 
GPD.dblBalQty >0 AND 
GP.intToStores ='$companyId'";

		

		$result =$db->RunQuery($SQL);
		
			echo "<option value =\"".""."\">"."Select One"."</option>";
		while ($row=mysql_fetch_array($result))
		{
			echo "<option value=\"". "" ."\">".$row["GatePassNo"]."</option>";
		}
	  
	  ?>
              </select>
            </td>
            <td width="59"><div align="center"></div></td>
            <td width="159">&nbsp;</td>
            <td width="17">&nbsp;</td>
            <td width="46">&nbsp;</td>
            <td width="93"><span class="normalfnt">TransferIn No</span></td>
            <td width="283" class="normalfnt" id="Gatepassno_cell"><input  type="text" name="cboGPTransInNo" class="txtbox" id="cboGPTransInNo" style="width:120px" readonly="" /></td>
            <td width="18"></select></td>
          </tr>
		  <tr>
		  	<td>&nbsp;</td>
			<td><span class="normalfnt">Remarks</span></td>
			<td><input  type="text" name="txtRemarks" class="txtbox" id="txtRemarks" style="width:230px" /></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td></td>
			<td></td>
			<td class="normalfnt">Date</td>
			<td><input  type="text" name="cboGatePassNo2" class="txtbox" id="cboGatePassNo2" style="width:98px" readonly="" value="<?php echo date ("d/m/Y") ?>" /></td>
			<td></td>
	


		  </tr>


        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td class="mainHeading2"><table width="100%" border="0" cellpadding="0" cellspacing="0">

          <tr>
            <td width="32%" title="" id="titCommonBinID">&nbsp;</td>
            <td width="56%" >&nbsp;</td>
            <td width="12%" >&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><div id="divTransInMain" style="overflow:scroll; height:310px; width:950px;">
          <table id="tblTransInMain" width="932" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
            <tr class="mainHeading4">
              <td width="2%" height="25">Del</td>
              <td width="21%">Item Description</td>
              <td width="5%">Unit</td>
              <td width="6%">GatePass Qty</td>
              <td width="6%">Trans In Qty</td>
              <td width="6%">GRN<br/>No</td>
              <td width="5%">GRN<br/>Year</td>
              <td width="8%">Cost Center </td>
              <td width="8%">GL Code</td>
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
        <img src="../../images/new.png" alt="new" width="96" height="24" onclick="ClearFormGP();" />
        <img src="../../images/save-confirm.png" alt="save" width="174" height="24" id="cmdSave" onclick="SaveValidation();"/>
        <img src="../../images/report.png" alt="Report" width="108" height="24" onclick="showReport();"  />
		 <img src="../../images/cancel.jpg" id="butCancel" alt="Cancel" width="104" height="24" onclick ="Cancel();"/>
        <a href="../../main.php"><img src="../../images/close.png" alt="close" width="97" height="24" border="0" /></a>
        </td>
      </tr>
    </table></td>
  </tr>
</table>
</form>

</body>
</html>
