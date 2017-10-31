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

<script type="text/javascript" src="charts/jquery.min.js"></script>
<script type="text/javascript" src="charts/highcharts.js"></script>
<script type="text/javascript" src="charts/highslide-full.min.js"></script>
<script type="text/javascript" src="charts/highslide.config.js" charset="utf-8"></script>

<script src="curves-js.js" type="text/javascript"></script>
<script src="../plan/plan-js.js" type="text/javascript"></script>

</head>  

<body >

<table width="600" height="260" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr class="cursercross"  onmousedown="grab(document.getElementById('frmCurve'),event);">
    <td height="25" bgcolor="#498CC2" class="mainHeading">Learning Curves </td>
  </tr>
  <tr>
    <td><table width="88%" border="0">
      <tr>
        <td width="90%">
          <table width="88%" border="0">

            <tr>
              <td height="17"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="">
                <tr>
                  <td width="6%" height="23">&nbsp;</td>
                  <td width="23%" class="normalfnt"><label></label></td>
                  <td width="12%"><label></label>                    <span class="normalfnt">Curve Id </span></td>
                  <td width="25%"><select name="cboCurve" class="txtbox" id="cboCurve" onchange="loadCurveDetails()" style="width:150px">
                    <?php
							$sql="select  * from plan_learningcurveheader where intCompanyId = '$intCompanyId';";
							$result = $db->RunQuery($sql);
							echo "<option value=\"". "" ."\">" . "" ."</option>";
							while($row = mysql_fetch_array($result))
							{
							echo "<option  value=\"". $row["id"] ."\">" . $row["strCurveName"] ."</option>" ;
							}
					?>
                  </select></td>
                  <td width="34%">&nbsp;</td>
                </tr>
				<tr><td>&nbsp;</td></tr>
                <tr>
                  <td colspan="5"><table width="609" height="80" border="1" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><div id="container" style="width:600px; height: 200px; margin: 0 auto"></div></td>
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
			<td height="165"><table width="100%" height="165" border="0" cellpadding="0" cellspacing="0">
                <tr class="bcgl1">
				 <td colspan="3"><div  align="center" id="divNewCurve" >
				  <table style="visibility:hidden"   align="center" width="400" height="20" cellpadding="0" cellspacing="0" class="normalfnt" id="tblCurveId">
				  <tr><td>Curve Id</td><td><input type="text"  name="newCurveId"  id="newCurveId" onKeyPress="return enterNewCurveId(event);" /></td></tr>
				  </table>
				</td>
            <tr>
			

                  <td width="100%"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td colspan="3"><div align="center" id="divCurve" style="overflow:scroll; height:130px; width:600px;">
                       
                          <table align="center" width="400" height="20" cellpadding="0" cellspacing="0" class="normalfnt" id="tblCurve" border="0">
						  <tr>
						  	<td height="10" colspan="4" class="backcolorGreen" align="center"><b>Curve List</b></td>
						  </tr>
                            <tr>
                              <td width="60"  class="grid_raw">Del</td>
                              <td width="171"  class="grid_raw">Day No </td>  
                              <td width="167"  class="grid_raw">Efficiency</td>
                            </tr>
                            <tr>
                              <td align="center" valign="middle" class="normalfntMid"><div align="center"><img  src="../../images/del.png" /></div></td>
                              <td class="normalfntMid" align="center"></td>
							  <td class="normalfntMid" align="center"><input name="textfield" type="text" size="10" /></td>
                            </tr>
                          </table>
                        
                      </div></td>
                    </tr>
                  </table></td>
                </tr>
                <tr class="bcgl1">
                  <td bgcolor="#FFFFFF"><table width="100%" border="0">
                    <tr>
                      <td width="18%" class="normalfntp2">&nbsp;</td>
                      <td width="16%" class="normalfntp2"><img src="../../images/new.png" alt="report" width="96" height="24" onclick="newRow();" /></td>
                      <td width="14%" class="normalfntp2"><img src="../../images/save.png" alt="report" width="84" height="24" onclick="saveCurve();" /></td>
                      <td width="17%" class="normalfntp2"><img src="../../images/delete.png" alt="report" width="100" height="24" onclick="deleteCurveId()" /></td>
                      <td width="18%" class="normalfntp2"><img src="../../images/close.png" alt="close" width="97" height="24" border="0" onclick="closeWindow();" /></td>
                      <td width="17%">&nbsp;</td>
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
