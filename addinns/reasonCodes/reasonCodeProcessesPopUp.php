<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Branch</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="reasonCodesPopUp.js"></script>
</head>

<body>

<?php
include "../../Connector.php";

?>
<table width="100%"  border="0" align="center" bgcolor="#FFFFFF">
    <tr>
    	<td>
        	<table  width="100%" border="0">
            	<tr>
                	<td width="19%">&nbsp;</td>
                	<td  width="62%">
                    	<table width="100%" border="0" class="tableBorder">
                        	<tr>
                            	<td height="35" ><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                  <tr>
                                    <td width="96%" class="mainHeading" height="25">Reason Codes</td>
                                    <td width="4%" class="mainHeading"><img src="../../images/cross.png" width="17" height="17" onClick="CloseOSPopUp('popupLayer1');" align="right"></td>
                                  </tr>
                                </table></td>
                            </tr>
                            <tr>
                            	<td>
                                	<table border="0" align="center">
                                    	<tr>
                                        	<td width="44" class="normalfnt">Process</td><td width="157"><input type="text" id="reasonCodes_txtProcess" name="reasonCodes_txtProcess"/></td>
                                        </tr>
                                        <tr>
                                        	<td colspan="2" align="center"><input type="hidden" name="processId" id="processId" />
                                       	    <img src="../../images/addsmall.png"  onclick="addProcess();"/></td>
                                        </tr>
                                    </table>                                </td>
                            </tr>
                         </table>
                  </td>
                    <td width="19%">&nbsp;</td>
                </tr>
            </table>
         </td>
     </tr>
</table>
</body>
</html>