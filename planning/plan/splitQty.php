<?php
 session_start();
 include "../../Connector.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Learning Curves</title>

<link href="file:///C|/Program Files/Inetpub/wwwroot/eplan/css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../css/planning.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>

<script type="text/javascript" src="../../javascript/script.js"></script>
<link href="../../css/rb.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/calendar_functions.js" type="text/javascript"></script>
<script type="text/javascript" src="popupMenu.js"></script>
<script type="text/javascript" src="plan-js.js"></script>
</head>

<body >

<table width="407" height="226" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr class="cursercross"  onmousedown="grab(document.getElementById('splitQtyPopUp'),event);">
            <td width="419" height="41" bgcolor="#498CC2" class="mainHeading">Split Quantity<img align="right" onclick="closeWindow();" id="butClose" src="../../images/cross.png"/></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="88%">
          <table width="100%" border="0">

            <tr>
              <td height="110"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="">
                <tr>
                  <td width="8%" height="23">&nbsp;</td>
				   <td width="7%" height="12">&nbsp;</td>
                  <td width="4%" class="normalfnt">&nbsp;</td>
                  <td width="35%" class="normalfnt">Quantity</td>
                  <td width="32%" class="normalfnt"><input type="text" name="txtQty" id="txtQty" disabled="disabled" style="text-align:right; background-color:#CCCCCC;" size="10" /></td>
                  <td width="14%">&nbsp;</td>
                </tr>
                <tr>
                  <td height="25">&nbsp;</td>
				   <td height="25">&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt" >Actual Qty</td>
                  <td class="normalfnt" ><input type="text" name="txtProducedQty" id="txtProducedQty" style="text-align:right; background-color:#CCCCCC;" disabled="disabled" size="10" /></td>
                  <td>&nbsp;</td>
                </tr>
           <tr>
                  <td height="25">&nbsp;</td>
				   <td height="25">&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt" >Remaining Qty</td>
                  <td class="normalfnt" ><input type="text" name="txtRestQty" id="txtRestQty" disabled="disabled" style="text-align:right; background-color:#CCCCCC"  size="10" /></td>
                  <td>&nbsp;</td>
                </tr>
           <tr>
             <td height="12">&nbsp;</td>
			  <td height="12">&nbsp;</td>
             <td class="normalfnt">&nbsp;</td>
             <td class="normalfnt" >SplitQty</td>
             <td class="normalfnt" ><input type="text" id="txtSplitQty" name="txtSplitQty" style="text-align:right" onkeyup="pressEnter(event);" size="10"  onkeypress="return isNumberKey(event);" /></td>
             <td>&nbsp;</td>
           </tr>                               
              </table></td>
            </tr>
			<td height="50"><table width="100%" height="50" border="0" cellpadding="0" cellspacing="0">
                <tr>
				
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
			  
                <td width="70%" bgcolor=""><table width="119%" border="0" class="tableFooter">
                    <tr>
                      <td width="126">&nbsp;</td>
                      
                      
                      <td width="138"><img src="../../images/ok.png" class="mouseover" alt="Save" name="Save" onclick="validateQty();" /></td>
                     
					  <td width="113">&nbsp;</td>
                      
                    </tr>
                </table></td>
              </tr>
            </table></td>
                </tr>
              </table></td>
            </tr>
          </table>
       </td>
        
      </tr>
    </table></td>
  </tr>
  <tr>
    
  </tr>
</table>
</body>
</html>
