<?php
 session_start();
 $backwardseperator = "../../";
	include "../../authentication.inc";
	include "../../Connector.php";	
	$companyId=$_SESSION["FactoryID"];

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>GaPro | L/C Request Data</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../../javascript/script.js" type="text/javascript"></script>
<script language="javascript" src="lcRequestData.js" type="text/javascript"></script>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="950" border="0" cellspacing="0" cellpadding="2" align="center" class="tableFooter">
  <tr>
    <td><table width="950" border="0" cellspacing="0" cellpadding="2" >
      <tr>
        <td colspan="5" class="mainHeading" height="25">L/C Request Data</td>
        </tr>
      <tr>
        <td width="122">&nbsp;</td>
        <td width="212">&nbsp;</td>
        <td width="96">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
      </tr>
      
      <tr class="normalfnt">
        <td height="20">PO No </td>
        <td><input type="text" name="txtOrderNo" id="txtOrderNo" style="width:180px;"></td>
        <td>Supplier </td>
        <td width="380"><input type="text" name="txtSupplierNo" id="txtSupplierNo" style="width:300px;"></td>
        <td width="124"><img src="../../images/view2.png" width="62" height="21" onClick="viewLCRequestData('M');"></td>
      </tr>
       <tr class="normalfnt">
        <td width="122">PI No </td>
        <td width="212"><input type="text" name="txtPIno" id="txtPIno" style="width:180px;"></td>
        <td width="96">Factory</td>
        <td colspan="2"><input type="text" name="txtFactory" id="txtFactory" style="width:300px;"></td>
       </tr>
       <tr class="normalfnt">
        <td width="122">Orit Ref No</td>
        <td width="212"><input type="text" name="txtOritRefNo" id="txtOritRefNo" style="width:180px;"></td>
        <td width="96">Ship Mode</td>
        <td colspan="2"><input type="text" name="txtShipMode" id="txtShipMode" style="width:300px;"></td>
      </tr>
      <tr class="normalfnt">
        <td height="20"><input type="checkbox" name="chkAllLC" id="chkAllLC">
          All LC Details</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
      </tr>
       <tr>
        <td colspan="5"><div id="divMain" style="overflow:scroll; height:300px; width:950px;">
        <table width="1200" border="0" cellspacing="1" bgcolor="#CCCCFF" cellpadding="2" id="tblMain">
         <thead>
          <tr  class="mainHeading4">
          <th>&nbsp;</th>
            <th>Supplier</th>
            <th >Factory</th>
            <th>PO #</th>
            <th>PI #</th>
            <th>Orit Ref #</th>
            <th>Supplier PI #</th>
            <th>DN#/EN#/Release #</th>
            <th>Ship Mode</th>
            <th>Item Code</th>
            <th>Color</th>
            <th>Size</th>
            <th>Qty(Pcs)</th>
            <th>Amount(USD)</th>
            <th>G.W.(KGS)</th>
            <th>Meas.(CM)</th>
            <th>Payment(Y/N)</th>
            <th>Handle By</th>
            <th>Ready Date</th>
            <th>PI Confirm Date</th>
            <th>Handover Date</th>
            <th>Remarks</th>
         	</tr>
          </thead>
         <!-- <tr>
          	 <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            
          </tr>-->
        </table></div></td>
        </tr>
    </table></td>
  </tr>
   <tr >
        <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="2" class="tableFooter">
          <tr>
            <td align="center"><a href="lcRequestData.php"><img src="../../images/new.png" width="96" height="24" border="0"></a><img src="../../images/save.png" width="84" height="24" onClick="updateLCData();"><img src="../../images/report.png" width="108" height="24" onClick="viewReport('M');"></td>
          </tr>
        </table></td>
        
      </tr>
</table>
</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
