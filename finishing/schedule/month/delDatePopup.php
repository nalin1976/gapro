<?php
	session_start();
	$backwardseperator = "../../../";
	include "../../../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
	include "../../../authentication.inc";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<table width="700" border="0" cellspacing="0" cellpadding="1" bgcolor="#FFFFFF">
  <tr>
    <td colspan="5" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="97%" class="mainHeading">Delivery Dates</td>
        <td width="3%"  align="right" bgcolor="#550000"><img src="../../../images/cross.png" width="17" height="17" onClick="CloseOSPopUp('popupLayer1');" align="right"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5" height="5"></td>
  </tr>
  <tr>
    <td colspan="5"><table width="690" border="0" cellspacing="0" cellpadding="1" class="bcgl1" align="center">
      <tr>
        <td width="129" class="normalfnt">Date From</td>
        <td width="156"><input  name="txtPopupDfrom" type="text" class="txtbox" id="txtPopupDfrom" style="width:120px;" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" /><input type="text" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
        <td width="93" class="normalfnt">Date To</td>
        <td width="229"><input type="text" name="txtPopupDTo" id="txtPopupDTo" style="width:120px;"onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" /><input type="text" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
        <td width="93"><img src="../../../images/view2.png" onClick="loadDeliverySchedules();"></td>
      </tr>
      <tr>
        <td><span class="normalfnt">Hand Over Date</span></td>
        <td><input type="text" name="txtPopupHOdate" id="txtPopupHOdate" style="width:120px;"onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" /><input type="text" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5" height="5"></td>
   
  </tr>
  
 
  <tr>
    <td colspan="5"><div id="delPopup" style="width:700px; height:200px; overflow:scroll;">
    <table width="700" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF" id="popupDelSchedule">
  <tr class="mainHeading4">
    <td width="37" height="22"><input type="checkbox" name="chkDelAll" id="chkDelAll" onClick="CheckAll(this,'popupDelSchedule');"></td>
    
    <td width="121">Delivery Date</td>
    <td width="107">Delivery Qty</td>
    <td width="103">Order Qty</td>
    <td width="152">Style No</td>
    <td width="173">Order No</td>
  </tr>
</table>

    </div></td>
  </tr>
  <tr><td height="10"></td></tr>
  <tr>
    <td colspan="5" align="center"><img src="../../../images/addsmall.png" width="95" height="24" onClick="addItemToItemGrid();"></td>
  </tr>
  <tr>
  	<td colspan="5" height="10"></td>
  </tr>
  <tr>
  	<td colspan="5"><div id="delPopupItem" style="width:700px; height:200px; overflow:scroll;">
    <table width="700" border="0" cellspacing="1" cellpadding="0" id="tblPopItems" bgcolor="#CCCCFF">
      <tr class="mainHeading4">
        <td width="23" height="22"><input type="checkbox" name="chkAllDel" id="chkAllDel" onClick="CheckAll(this,'tblPopItems');"></td>
        <td width="23">Del</td>
        <td width="110">Hand OverDate</td>
        <td width="99">Delivery Date</td>
        <td width="84">Delivery Qty</td>
        <td width="73">Order Qty</td>
        <td width="134">Style No</td>
        <td width="145">Order No</td>
      </tr>
    </table></div></td>
  </tr>
  <tr>
  	<td height="10"></td>
  </tr>
  <tr>
  	<td colspan="5" align="center"><img src="../../../images/additem2.png" width="77" height="24" onClick="addItemToMainGrid();"><img src="../../../images/close.png" width="97" height="24" onClick="CloseOSPopUp('popupLayer1');"></td>
  </tr>
</table>
</body>
</html>
