<?php
session_start();
$backwardseperator = "../../";
include "../../Connector.php";

$conpc			= $_GET["conpc"];		
$wastage		= $_GET["wastage"];				
$unitPrice		= $_GET["unitPrice"];
$finance		= $_GET["finance"];
$rowIndex		= $_GET["rowIndex"];

?>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<body>
<html>
<table width="450" border="0" bgcolor="#FFFFFF">
            <tr>
            <td height="16" colspan="3" >
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr class="mainHeading">
                  <td width="96%" height="25" >Search Order No </td>
                  <td width="4%" ><img src="../../images/cross.png" alt="close" width="17" height="17" onClick="CloseSearchPopup('popupLayer1');" class="mouseover"/></td>
                </tr>
              </table></td>
            </tr>
			<tr>
				<td width="27%" class="normalfnt">Order No </td>
			    <td width="68%" class="normalfnt"><input type="text" id="txtPopupOrderNo" onkeypress="SetOrderNo(event);" /></td>
			    <td width="5%" class="normalfnt">&nbsp;</td>
			</tr>
            <tr>
              <td height="21" colspan="3" class="normalfnt"><span class="compulsoryRed">Select 'Order No' and press enter.</span></td>
            </tr>
          </table>
</html>
</body>