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
<table width="431" border="0" bgcolor="#FFFFFF">
            <tr>
            <td height="16" >
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr class="mainHeading">
                  <td width="96%" height="25" >View Report </td>
                  <td width="4%" ><img src="../../images/cross.png" alt="close" width="17" height="17" onClick="CloseSearchPopup('popupLayer1');" class="mouseover"/></td>
                </tr>
              </table></td>
            </tr>
			<tr>
				<td width="27%" class="normalfnt"> <table width="425" border="0" cellpadding="1" cellspacing="0">
  	<tr>
  		<td><table width="100%" class="bcgl1" cellspacing="1" cellpadding="0">
			<tr style="border:solid #666666 2px;">
				<td width="213" class="normalfnt" >&nbsp;
				  <input name="radiobutton" id="rdoReport2" type="radio" value="radiobutton" onclick="ViewReport_List(this.id);" />
		      Without Pocketing Category</td>
			  <td width="205" class="normalfnt"><input name="radiobutton" id="rdoReport1" type="radio" value="radiobutton" onclick="ViewReport_List(this.id);" /> 
			  With Pocketing Category </td>
			</tr>	
		</table></td>
	</tr>
	<tr>
		<td>
		<table width="100%" class="bcgl1" cellspacing="1" cellpadding="0">	
			<tr class="bcgl1">
				<td width="213" class="normalfnt">&nbsp;
				  <input name="radiobutton1" id="radio2" type="radio" value="radiobutton" checked="checked" onclick="ChangeReportCategory(1);"/>
		      With 2 Decimal </td>
				<td width="205" ><span class="normalfnt">
				      <input name="radiobutton1" id="radio4" type="radio" value="radiobutton" onclick="ChangeReportCategory(2);"//>
	          With 4 Decimal </span></td>
			</tr>	
		</table></td>
	</tr>
  </table>	</td>
		    </tr>
          </table>
</html>
</body>