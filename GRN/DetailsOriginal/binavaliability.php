<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="frmBinAvailability">
<table width="500" border="0">
  <tr>
    <td width="486" height="24" bgcolor="#498CC2" class="TitleN2white"><table width="100%" border="0">
      <tr>
        <td width="94%">Bin Avaliability</td>
        <td width="6%">&nbsp;</td>
      </tr>
    </table>      </td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="11%"><span class="normalfnt">Category</span></td>
        <td width="23%" class="normalfnt"><input name="txtCategory" type="text" class="txtbox" id="txtCategory" size="18"  /></td>
        <td width="5%" class="normalfnt">Qty</td>
        <td width="16%"><input name="txtBinQty" type="text" class="txtbox" style="text-align:right" id="txtBinQty" size="12"  /></td>
        <td width="24%" class="normalfnt">Allocated Qty </td>
        <td width="21%" class="normalfnt"><input name="txtQty2" type="text" class="normalfnt2BITAB" style="text-align:right" id="txtQty2" size="12" value="500"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="tablezRED">
      <tr>
        <td width="10%">&nbsp;</td>
        <td width="26%">Location</td>
        <td width="34%"><span class="normalfnt">
          <select name="cboLocation" class="txtbox" id="cboLocation" style="width:140px">
          </select>
        </span></td>
        <td width="30%"><img src="../../images/search.png" alt="Search" width="80" height="24" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="164"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="100%" height="7"><div id="divcons" style="overflow:scroll; height:130px; width:500px;">
          <table width="480px" cellpadding="0" cellspacing="0">
            <tr>
              <td width="7%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">Del</td>
              <td width="21%" bgcolor="#498CC2" class="normaltxtmidb2">Bin ID</td>
              <td width="21%" bgcolor="#498CC2" class="normaltxtmidb2">Bin Capacity Qty </td>
              <td width="19%" bgcolor="#498CC2" class="normaltxtmidb2">Bin Available Qty </td>
              <td width="20%" bgcolor="#498CC2" class="normaltxtmidb2R">Req Qty </td>
              <td width="12%" bgcolor="#498CC2" class="normaltxtmidb2">Add</td>
            </tr>
            <tr class="backcolorGreen">
              <td><div align="center"><img src="../../images/posted.png" alt="del" width="15" height="15" /></div></td>
              <td class="normalfntMid">FABR</td>
              <td class="normalfntMid">Pocketing</td>
              <td class="normalfntRite">1212</td>
              <td class="normalfntRite">1212</td>
              <td><div align="center">
                  <input type="checkbox" name="cboadd" id="cboadd" />
              </div></td>
            </tr>
            <tr>
              <td><div align="center"><img src="../../images/del.png" alt="del" width="15" height="15" /></div></td>
              <td class="normalfntMid">ACCE</td>
              <td class="normalfntMid">Zipper</td>
              <td class="normalfntRite">2323</td>
              <td class="normalfntRite">2323</td>
              <td><div align="center">
                  <input type="checkbox" name="cboadd2" id="cboadd2" />
              </div></td>
            </tr>
            <tr>
              <td><div align="center"><img src="../../images/del.png" alt="del" width="15" height="15" /></div></td>
              <td class="normalfntMid">ACCE</td>
              <td class="normalfntMid">Lable - Co Lable</td>
              <td class="normalfntRite">2332</td>
              <td class="normalfntRite">2332</td>
              <td><div align="center">
                  <input type="checkbox" name="cboadd3" id="cboadd3" />
              </div></td>
            </tr>
          </table>
        </div></td>
        </tr>
      <tr>
        <td height="8" bgcolor="#80AED5" class="normaltxtmidb2L">Already Allocated Bins</td>
      </tr>
      <tr>
        <td height="11"><div id="divcons2" style="overflow:scroll; height:130px; width:500px;">
          <table width="480px" cellpadding="0" cellspacing="0">
            <tr>
              <td width="4%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">Del</td>
              <td width="12%" bgcolor="#498CC2" class="normaltxtmidb2">Bin ID</td>
              <td width="18%" bgcolor="#498CC2" class="normaltxtmidb2">Bin ID </td>
              <td width="19%" bgcolor="#498CC2" class="normaltxtmidb2">Bin Capacity Qty </td>
              <td width="16%" bgcolor="#498CC2" class="normaltxtmidb2">Bin Available Qty </td>
              <td width="18%" bgcolor="#498CC2" class="normaltxtmidb2R"> Qty</td>
              <td width="13%" bgcolor="#498CC2" class="normaltxtmidb2">&nbsp;</td>
            </tr>
            <tr>
              <td><div align="center"><img src="../../images/del.png" alt="del" width="15" height="15" /></div></td>
              <td class="normalfnt">FABR</td>
              <td class="normalfnt">Pocketing</td>
              <td class="normalfnt">Pocketing</td>
              <td class="normalfnt">Pocketing</td>
              <td class="normalfntRite">221</td>
              <td class="normalfntRite">1</td>
            </tr>
            <tr>
              <td><div align="center"><img src="../../images/del.png" alt="del" width="15" height="15" /></div></td>
              <td class="normalfnt">ACCE</td>
              <td class="normalfnt">Zipper</td>
              <td class="normalfnt">Zipper</td>
              <td class="normalfnt">Zipper</td>
              <td class="normalfntRite">443</td>
              <td class="normalfntRite">1</td>
            </tr>
            <tr>
              <td><div align="center"><img src="../../images/del.png" alt="del" width="15" height="15" /></div></td>
              <td class="normalfnt">ACCE</td>
              <td class="normalfnt">Lable - Co Lable</td>
              <td class="normalfnt">Lable - Co Lable</td>
              <td class="normalfnt">Lable - Co Lable</td>
              <td class="normalfntRite">43432</td>
              <td class="normalfntRite">0.4</td>
            </tr>
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#D6E7F5"><table width="100%" border="0">
      <tr>
        <td>&nbsp;</td>
        <td width="29%"><img src="../../images/ok.png" alt="ok" width="86" height="24" /></td>
        <td width="21%"><img src="../../images/close.png" alt="Close" width="97" height="24" /></td>
        <td width="25%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
