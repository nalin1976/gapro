<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Bulk Purchase Ratio</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form>
<table width="500" border="0" align="center" bgcolor="#FFFFFF">  
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td ><table width="100%" border="0" align="center">
          <tr class="mainHeading">
            <td width="93%" height="25" >Bulk Purchase Ratio</td>
            <td width="7%"><img src="../../images/cross.png" alt="Cress" width="17" height="17" onclick="closePopupBox(2);" /></td>
          </tr>
          <tr>
            <td height="135" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
               <!-- <tr>
                 <td colspan="3"><table width="100%" border="0">
						  <tr>
							<td width=6>&nbsp;</td>
							<td width=66 class="normalfnt">Buyer</td>
							<td width=157><select name="cboBuyer" class="txtbox" id="cboBuyer" style="width:140px" onChange="ChangeBuyer();">
							</select>        </td>
							<td width=88 class="normalfnt">Division</td>
							<td width=153><select name="cboDivision" class="txtbox" id="cboDivision" style="width:140px" onChange="ChangeDivision();">
							  </select></td>
						 </tr>
						</table></td>
                </tr>-->
                <tr class="mainHeading4">
                  <td height="20" >Colors</td>
                  <td height="20" >&nbsp;</td>
                  <td height="20" >Selected Colors</td>
                </tr>

                <tr>
                  <td width="46%" height="141" valign="top"><select name="cbocolors" size="10" class="txtbox" id="cbocolors" style="width:225px" ondblclick="MoveColorRight();" onkeypress="keyMoveColorRight(event);">
                     
                  </select></td>
                  <td width="8%"><table width="100%" border="0">
                      <tr>
                        <td><div align="center"></div></td>
                      </tr>
                      <tr>
                        <td><div align="center"><img src="../../images/bw.png" alt="&gt;" width="18" height="19" onclick="MoveColorRight();"/></div></td>
                      </tr>
                      <tr>
                        <td><div align="center"><img src="../../images/fw.png" width="18" height="19" onclick="MoveColorLeft();" /></div></td>
                      </tr>
                      <tr>
                        <td><div align="center"><img src="../../images/ff.png" alt="&gt;&gt;" width="18" height="19"  onclick="MoveAllColorsLeft();"/></div></td>
                      </tr>
                      <tr>
                        <td><div align="center"><img src="../../images/fb.png" width="18" height="19" onclick="MoveAllColorsRight();" /></div></td>
                      </tr>
                  </table></td>
                  <td width="46%" valign="top"><select name="cboselectedcolors" size="10" class="txtbox" id="cboselectedcolors" style="width:225px">
                      
                  </select></td>
                </tr>
                <tr>
                  <td height="8" colspan="3" class="specialFnt1"><table width="100%" border="0" class="bcgl2Lbl">
                    <tr>
                      <td width="118" class="mainHeading4">Add New Color</td>
                      <td width="80" class="normalfnt">Color Name</td>
                      <td width="147"><input name="txtColor" style="text-transform:uppercase" type="text" class="txtbox" id="txtColor" size="20" maxlength="30"/></td>
                      <td width="129" align="left"><img src="../../images/addmark.png"  onclick="AddNewColor();" /></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="11" colspan="3" class="normaltxtmidb2L">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="136" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr class="mainHeading4">
                <td height="20" >Sizes</td>
                <td height="20" >&nbsp;</td>
                <td height="20" >Selected Sizes</td>
              </tr>
              <tr>
                <td width="46%" height="141" valign="top"><select name="cbosizes" size="10" class="txtbox" id="cbosizes" style="width:225px" ondblclick="MoveSizeRight();" onkeypress="keyMoveSizeRight(event);">
                                   </select></td>
                <td width="8%"><table width="100%" border="0">
                    <tr>
                      <td><div align="center"></div></td>
                    </tr>
                    <tr>
                      <td><div align="center"><img src="../../images/bw.png" alt="&gt;" width="18" height="19"  onclick="MoveSizeRight();"/></div></td>
                    </tr>
                    <tr>
                      <td><div align="center"><img src="../../images/fw.png" width="18" height="19" onclick="MoveSizeLeft();" /></div></td>
                    </tr>
                    <tr>
                      <td><div align="center"><img src="../../images/ff.png" alt="&gt;&gt;" width="18" height="19" onclick="MoveAllSizesLeft();" /></div></td>
                    </tr>
                    <tr>
                      <td><div align="center"><img src="../../images/fb.png" width="18" height="19"  onclick="MoveAllSizesRight();"/></div></td>
                    </tr>
                </table></td>
                <td width="46%" valign="top"><select name="cboselectedsizes" size="10" class="txtbox" id="cboselectedsizes" style="width:225px">
                    
                </select></td>
              </tr>
              <tr>
                <td height="8" colspan="3" class="specialFnt1"><table width="100%" border="0" class="bcgl2Lbl">
                    <tr>
                      <td width="118" class="mainHeading4">Add New Size</td>
                      <td width="80" class="normalfnt">Size Name</td>
                      <td width="147"><input name="txtSize" style="text-transform:uppercase" type="text" class="txtbox" id="txtSize" size="20"  maxlength="30"/></td>
                      <td width="129" align="left"><img src="../../images/addmark.png" width="47" height="24"  onclick="AddNewSize();"/></td>
                    </tr>
                </table></td>
              </tr>
              
            </table></td>
          </tr>
          <tr>
            <td colspan="2"><table width="100%" border="0">
                <tr>
                  <td align="center">
				  <img src="../../images/save.png" alt="save" width="84" height="24" onclick="addItemToMainTable();" />
				  <img src="../../images/close.png" alt="Close" width="97" height="24" onclick="closePopupBox(2);" /></td>
                  </tr>
            </table></td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
