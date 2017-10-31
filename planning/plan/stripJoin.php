<?php
 session_start();
 include "../../Connector.php";
 $intCompanyId		=$_SESSION["FactoryID"];
 //echo $intCompanyId;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Joining Stripes</title>

<link href="../css/planning.css" rel="stylesheet" type="text/css" />

<script src="plan-js.js" type="text/javascript"></script>
<script type="text/javascript" src="popupMenu.js"></script>

</head>  

<body >

<table width="407" height="243" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr class="cursercross"  onmousedown="grab(document.getElementById('stripJoinPopUp'),event);">
            <td width="419" height="41" bgcolor="#498CC2" class="mainHeading">Join Stripes</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="88%">
          <table width="100%" border="0">

            <tr>
              <td height="15"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="">
                <tr>
                  <td width="8%" height="23">&nbsp;</td>
				   <td width="7%" height="12">&nbsp;</td>
                  <td width="7%" class="normalfnt">&nbsp;</td>
                  <td width="25%" class="normalfnt">Strip Id </td>
                  <td width="38%"><select style="width: 152px;"  class="txtbox" name="cbo_StripDet" id="cbo_StripDet" tabindex="1" onchange="loadQtyToTextBox();"></select></td>
                  <td width="15%">&nbsp;</td>
                </tr>
                <tr>
                  <td height="12">&nbsp;</td>
				   <td height="12">&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt" >Quantity</td>
                  <td class="normalfnt" ><input type="text" name="txt_stripQty" id="txt_stripQty" size="10" disabled="disabled" align="right" /></td>
                  <td>&nbsp;</td>
                </tr>
           <tr>
                  <td height="12">&nbsp;</td>
				   <td height="12">&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt" >&nbsp;</td>
                  <td class="normalfnt" >&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
           <tr>
             <td height="12">&nbsp;</td>
			  <td height="12">&nbsp;</td>
             <td class="normalfnt">&nbsp;</td>
             <td class="normalfnt" >&nbsp;</td>
             <td class="normalfnt" >&nbsp;</td>
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
                      <td width="85">&nbsp;</td>
                      
                      
                      <td width="100"><img src="../../images/addsmall.png" class="mouseover" alt="select" name="select" width="100" height="24" onclick="joinStripes();"  /></td>
                      <td width="127"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close" onclick="closeWindow();"/></td>
					  <td width="61">&nbsp;</td>
                      
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
