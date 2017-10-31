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
<title>Learning Curves</title>

<link href="../css/planning.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../learningCurve/charts/jquery.min.js"></script>
<script type="text/javascript" src="../learningCurve/charts/highcharts.js"></script>
<script type="text/javascript" src="../learningCurve/charts/highslide-full.min.js"></script>
<script type="text/javascript" src="../learningCurve/charts/highslide.config.js" charset="utf-8"></script>


<script src="plan-js.js" type="text/javascript"></script>
<script type="text/javascript" src="popupMenu.js"></script>

</head>  

<body >

<table width="600" height="260" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr class="cursercross"  onmousedown="grab(document.getElementById('applyLearningCurvePopUp'),event);">
            <td height="35" bgcolor="#498CC2" class="mainHeading">Apply Learning Curve</td>
          </tr>
  <tr>
    <td><table width="88%" border="0">
      <tr>
        <td width="88%">
          <table width="88%" border="0">

            <tr>
              <td height="17"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="">
                <tr>
                  <td width="6%" height="23">&nbsp;</td>
                  <td width="23%" class="normalfnt"><label></label></td>
                  <td width="12%"><label></label>                    <span class="normalfnt">Curve Id </span></td>
                  <td width="25%"><select style="width: 152px;"  class="txtbox" name="cbo_curveDet" id="cbo_curveDet" tabindex="1" onchange="loadCurveDetailsInChart();"></select></td>
                  <td width="34%">&nbsp;</td>
                </tr>
				<tr><td>&nbsp;</td></tr>
                <tr>
                  <td colspan="5"><table width="609" height="80" border="1" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><div id="container1" style="width:600px; height: 200px; margin: 0 auto"></div></td>
                    </tr>
                  </table></td>
                  </tr>
                
                <tr>
                  <td height="12">&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                  <td >&nbsp;</td>
                  <td class="normalfnt" >&nbsp;</td>
                  <td>&nbsp;</td>
                </tr></div>
              </table></td>
            </tr>
			<td height="50"><table width="100%" height="50" border="0" cellpadding="0" cellspacing="0">
                <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor=""><table width="100%" border="0" class="tableFooter">
                    <tr>
                      <td width="116">&nbsp;</td>
                      
                      <td width="90"></td>
                      <td width="102"><img src="../../images/Select.png" class="mouseover" alt="select" name="select" width="100" height="24" onclick="showCurveId1();"  /></td>
                      <td width="97"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close" onclick="closeWindow();"/></a></td>
                      <td width="178">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
                </tr>
              </table></td>
            </tr>
          </table>
        </form></td>
        
      </tr>
    </table></td>
  </tr>
  <tr>
    
  </tr>
</table>
</body>
</html>
