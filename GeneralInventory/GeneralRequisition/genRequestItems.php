<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Material Requisition</title>
<link href="../GeneralRequsition/css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<script src="../GeneralRequsition/javascript/script.js" type="text/javascript"></script>
<script src="../GeneralRequsition/javascript/MRNScript.js" type="text/javascript"></script>

</head>

<body onload="loadStyleID();">
<form name="frmbom" id="frmbom">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td colspan="2" class="normalfnt"><table width="105%" border="0" class="tablezRED">
          <tr>
            <td width="11%">Qty Reqd</td>
            <td width="24%"><input name="txtReqQty" type="text" class="txtbox" id="txtReqQty" size="18" /></td>
            <td width="11%">&nbsp;</td>
            <td width="22%">&nbsp;</td>
            <td width="32%" rowspan="2" valign="bottom"><div align="right"><img src="../../images/search.png" alt="Search" width="80" height="24" onclick="MatToMRN();" /></div></td>
          </tr>
          <tr>
            <td>Materials</td>
            <td><select name="cbomat" class="txtbox" id="cbomat" style="width:120px" onchange="LoadSubCat();">
                        </select></td>
            <td>Category</td>
            <td><select name="cbomaterials" class="txtbox" id="cbomaterials" style="width:110px">
                        </select></td>
            </tr>
        </table></td>
        <td width="40%" valign="top" class="normalfnt"><table width="100%" border="0">
          <tr>
            <td width="6%" class="color7">&nbsp;</td>
            <td width="26%">&nbsp;</td>
            
            <td width="14%">&nbsp;</td>
            
            <td width="20%">&nbsp;</td>
           
            <td width="18%">&nbsp;</td>
          </tr>
        </table></td>
        </tr>
      
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="89%" bgcolor="#9BBFDD" class="normalfnth2">&nbsp;</td>
        <td width="11%" bgcolor="#9BBFDD" class="normalfnt"><img src="../../images/add-new.png" alt="add new" width="109" height="18" /></td>
      </tr>
      <tr>
        <td colspan="2" class="normalfnt"><div id="divcons" style="overflow:scroll; height:130px; width:950px;">
          <table width="1100px" cellpadding="0" cellspacing="0" id="mrnMatGrid">
            <tr>
              <td width="1%" bgcolor="#498CC2" class="normaltxtmidb2">*</td>
			  <td width="17%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">Item</td>
              <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Total Qty</td>
              <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Req Qty</td>
              <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2">Bal To MRN Qty</td>
              <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">MRN Raised</td>
              <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2">Issued Qty</td>
			  <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2">Stock Balance </td>
              </tr>                     
          </table>
        </div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
      <tr>
        <td width="39%" height="29">&nbsp;</td>
        <td width="12%"><img src="../../images/ok.png" alt="OK" width="86" height="24" onclick="addtoMainGrid();closeLayer();" /></td>
        <td width="10%"><a href="../GeneralRequsition/main.php"><img src="../../images/close.png" width="97" height="24" border="0" onclick="closeLayer();"/></a></td>
        <td width="39%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
