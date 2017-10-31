<?php 
$delveryID = $_GET["delveryID"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<table width="500" border="0" cellspacing="0" cellpadding="2" bgcolor="#FFFFFF">
  <tr >
    <td colspan="4" height="25"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="mainHeading">
    <td width="95%" height="25" >Edit Delivery Schedule</td>
    <td width="5%"><img src="../images/cross.png" width="17" height="17" onClick="CloseOSPopUp('popupLayer1')"></td>
  </tr>
</table></td>
  </tr>
  <tr>
    <td width="90">&nbsp;</td>
    <td width="147">&nbsp;</td>
    <td width="101">&nbsp;</td>
    <td width="146">&nbsp;</td>
  </tr>
  <tr class="normalfnt">
    <td>Qty. </td>
    <td><input type="text" name="quantity" id="quantity" onBlur="checkForValues(this);"  onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();"  onKeyPress="return isNumberKey(event);"  value="" maxlength="9" style="width:75px; text-align:right" onKeyUp="calExQtyForDeliverySchedule(this.value);"></td>
    <td>Qty + Ex.Qty</td>
    <td><input name="excqty" type="text"  onblur="checkForValues(this);"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();"  onkeypress="return isNumberKey(event);" id="excqty" value= "" maxlength="9" style="width:101px; text-align:right" disabled="disabled"></td>
  </tr>
  <tr class="normalfnt">
    <td>Delivery Date</td>
    <td><input type="text" name="deliverydate " id="deliverydate" style="width:75px;" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"  onKeyDown="" /><input type="text" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%d/%m/%Y');"></td>
    <td>Shipping Mode</td>
    <td><select name="cboShippingMode" class="txtbox" id="cboShippingMode" style="width:101px"></select></td>
  </tr>
  <tr class="normalfnt">
    <td>Remarks</td>
    <td colspan="3"><input name="remarks" type="text" maxlength="50" class="txtbox" id="remarks" style="width:357px" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" ><table width="100%" border="0" cellspacing="0" cellpadding="2" class="bcgl1">
  <tr>
    <td align="center" valign="middle"><img src="../images/save.png" class="mouseover" width="84" height="24" onClick="UpdateSchedule(<?php echo $delveryID ?>);" />
		<img src="../images/close.png" class="mouseover" width="97" height="24" onClick="CloseOSPopUp('popupLayer1');" /></td>
  </tr>
</table>
</td>
  </tr>
</table>
</body>
</html>
