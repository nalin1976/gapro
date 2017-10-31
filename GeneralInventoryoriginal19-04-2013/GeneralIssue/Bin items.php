<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Fabric Inspection</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="15%">&nbsp;</td>
        <td width="55%"><table width="75%" border="0">
          <tr>
            <td height="16" bgcolor="#498CC2" class="TitleN2white">Bin Items</td>
          </tr>
          <tr>
            <td height="17"><table width="100%" border="0">
              <tr>
                <td width="19%">&nbsp;</td>
                <td width="25%" class="normalfnt">Required Quantity</td>
                <td width="56%"><input type="text" name="txtReqQty" id="txtReqQty" readonly="true"/></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="165"><form id="frmcategories" name="form1" method="post" action="">
              <table width="100%" height="165" border="0" cellpadding="0" cellspacing="0">
                <tr class="bcgl1">
                  <td width="100%"><table width="93%" border="0" class="bcgl1">
                    <tr>
                      <td colspan="3"><div id="divBinItems" style="overflow:scroll; height:130px; width:500px;">
          <table id="tblBinItems" width="900" cellpadding="0" cellspacing="0" onclick="validateBinQty(this);">
            <tr>
              <td width="40" bgcolor="#498CC2" class="normaltxtmidb2">Bin ID</td>
              <td width="39" bgcolor="#498CC2" class="normaltxtmidb2">Avl Qty</td>
              <td width="41" bgcolor="#498CC2" class="normaltxtmidb2">Req Qty</td>
              <td width="30" height="33" bgcolor="#498CC2" class="normaltxtmidb2">Add</td>
              <td width="71" bgcolor="#498CC2" class="normaltxtmidb2">Main Stores</td>
              <td width="66" bgcolor="#498CC2" class="normaltxtmidb2">Sub Stores</td>
              <td width="55" bgcolor="#498CC2" class="normaltxtmidb2">Location</td>
              <td width="42" bgcolor="#498CC2" class="normaltxtmidb2">GRN</td>
              <td width="68" bgcolor="#498CC2" class="normaltxtmidb2">GRN Fac Us</td>
              <td width="46" bgcolor="#498CC2" class="normaltxtmidb2">Type</td>
              </tr>
            <tr>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfntRite">1</td>
              <td class="normalfntRite"><input type="text" size="8" class="txtbox" name="txtIssueQty" id="txtIssueQty" onfocus="GetQty(this);" onkeypress="return isNumberKey(event)"> </td>
              <td class="normalfntMid"><div align="center">
                <input type="checkbox" name="chkBin" id="chkBin" onclick="GetStockQty(this);" />
              </div></td>
              <td class="normalfntMid">10097/</td>
              <td class="normalfntMid">10097/</td>
              <td class="normalfntMid">10097/</td>
              <td class="normalfntMid">10097/</td>
              <td class="normalfntMid">10097/</td>
              <td class="normalfntMid">10097/</td>
            </tr>
           <tr>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfntRite">2</td>
              <td class="normalfntRite">2</td>
              <td class="normalfntMid"><div align="center">
                <input type="checkbox" name="chkdel2" id="chkdel2" />
              </div></td>
              <td class="normalfntMid">15697</td>
              <td class="normalfntMid">15697</td>
              <td class="normalfntMid">15697</td>
              <td class="normalfntMid">15697</td>
              <td class="normalfntMid">15697</td>
              <td class="normalfntMid">15697</td>
            </tr>
            <tr>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfntRite">3</td>
              <td class="normalfntRite">3</td>
              <td class="normalfntMid"><div align="center">
                <input type="checkbox" name="chkdel3" id="chkdel3" />
              </div></td>
              <td class="normalfntMid">564100</td>
              <td class="normalfntMid">564100</td>
              <td class="normalfntMid">564100</td>
              <td class="normalfntMid">564100</td>
              <td class="normalfntMid">564100</td>
              <td class="normalfntMid">564100</td>
            </tr>
          </table>
        </div></td>
                      </tr>
                    
                  </table></td>
                </tr>
                <tr class="bcgl1">
                  <td bgcolor="#D6E7F5"><table width="100%" border="0">
                    <tr>
                      <td width="11%">&nbsp;</td>
                      <td width="17%" class="normalfntp2"><img src="../images/save.png" alt="Save" width="84" height="24" /></td>
                      <td width="20%" class="normalfntp2"><img src="../images/new.png" alt="new" width="96" height="24" /></td>
                      <td width="22%" class="normalfntp2"><img src="../images/report.png" alt="report" width="108" height="24" /></td>
                      <td width="20%" class="normalfntp2"><img src="../images/close.png" alt="close" width="97" height="24"/></td>
                      <td width="10%">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
              </table>
                        </form>            </td>
          </tr>
        </table></td>
        <td width="30%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
