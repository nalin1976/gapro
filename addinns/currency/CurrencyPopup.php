<?php
 session_start();
 include "../../Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<table width="600" height="198" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr class="cursercross" onmousedown="grab(document.getElementById('frmNewOrderBook'),event);">
		<td height="25" bgcolor="#498CC2" class="TitleN2white" align="center">Add New Styles</td>
	</tr>
	<!--<tr>
		<td align="center">
			<table width="100%">
				<tr>
					<td class="normalfntMid">Style Id </td>
					<td><input type="text" id="txtStyleID" width="100" /></td>
					<td class="normalfntMid">Description</td><td><input type="text" id="txtDsc" width="100"/></td>
					<td class="normalfntMid">Quantity</td><td><input type="text" id="txtQty" width="50" /></td>
				</tr>
				<tr>
					<td class="normalfntMid">Cut Date</td><td><input type="text" id="txtCD" width="70" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');"></td>
					<td class="normalfntMid">Ex-Factory</td><td><input type="text" id="txtEF" width="70" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td class="normalfntMid">Status</td><td><input type="text" id="txtSt" width="100"/></td>
					<td class="normalfntMid">Type</td><td><input type="text" id="txtType" width="100"/></td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td height="20" >
			<table align="center" >
				<tr>
					<td><span class="normalfntp2"><img src="../../images/new.png" class="mouseover" alt="report" width="96" height="24" onclick="cleatrFields();" /></span></td>
					<td><span class="normalfntp2"><img src="../../images/save.png" class="mouseover" alt="report" width="84" height="24" onclick="saveData()" /></span></td>
					<td><span class="normalfntp2"><img src="../../images/delete.png" class="mouseover" alt="report" width="100" height="24" onclick="#" /></span></td>
					<td><span class="normalfntp2"><img src="../../images/close.png" class="mouseover" alt="close" width="97" height="24" border="0" onclick="closeWindow2('')" /></td>
				</tr>
			</table>
		</td>
	</tr>-->
</table>
<p class="grid-1">&nbsp;</p>
</body>
</html>
 