<div id="addFm1" class="popupFrom" style="margin-left:300px" >
  <tr>
    <td>
      <tr>
        <td width="900">
      <table width="500" border="0">  
<tr class="cursercross" onmousedown="grab(document.getElementById('frmSelector'),event);">  
<td width="486" height="24" bgcolor="#498CC2" class="TitleN2white">Select Colors and Sizes</td>  
</tr>  
<tr>  
<td><table width="100%" border="0">  
<tr style="display:none">  
<td width="3%">&nbsp;</td>  
<td width="18%" class="normalfnt" >Buyer</td>  
<td width="32%"><select name="cboBuyer" class="txtbox" id="cboBuyer" style="width:140px" onChange="ChangeBuyer();">  
</select>        </td>  
<td width="14%" class="normalfnt">Division</td>  
<td width="33%"><select name="cboDivision" class="txtbox" id="cboDivision" style="width:140px" onChange="ChangeDivision();">  
</select></td>  
</tr>  
</table></td>  
</tr>  
<tr>  
<td height="367"><table width="100%" border="0" cellpadding="0" cellspacing="0">  
<tr>  
<td height="20" colspan="3" bgcolor="#80AED5" class="normaltxtmidb2L">Colors</td>  
</tr>  
<tr>  
<td width="46%" bgcolor="#D6E7F5" class="normalfntMid">Colors</td>  
<td width="8%" bgcolor="#D6E7F5">&nbsp;</td>  
<td width="46%" bgcolor="#D6E7F5" class="normalfntMid">Selected Colors</td>  
</tr>  
<tr>  
<td height="141" valign="top"><select onkeypress="keyMoveColorRight(event);" name="cbocolors" size="10" class="txtbox" id="cbocolors" style="width:225px" ondblclick="MoveColorRight();">  
</select></td>  
<td><table width="100%" border="0">  
<tr>  
<td><div align="center"><img src="../../images/bw.png" alt="&gt;" width="18" height="19" class="mouseover" onClick="MoveColorRight();" /></div></td>  
</tr>  
<tr>  
<td><div align="center"><img src="../../images/fw.png" alt="&lt;" width="18" height="19" class="mouseover" onClick="MoveColorLeft();" /></div></td>  
</tr>  
<tr>  
<td><div align="center"></div></td>  
</tr>  
<tr>  
<td><div align="center"><img src="../../images/ff.png" alt="&gt;&gt;" width="18" height="19" class="mouseover" onClick="MoveAllColorsLeft();" /></div></td>  
</tr>  
<tr>  
<td><div align="center"><img src="../../images/fb.png" alt="&lt;&lt;" width="18" height="19" class="mouseover" id="imgMoveRight" onClick="MoveAllColorsRight();" /></div></td>  
</tr>  
</table></td>  
<td valign="top"><select name="cboselectedcolors" size="8" class="txtbox" id="cboselectedcolors" style="width:225px;" ondblclick="MoveColorLeft();">  
</select>  
<table width="228"><tr><td width="47" class="normalfntMid">New:</td><td width="108"><input  class="txtbox" type="text" onkeypress="return string_constrain(event);" size="18" maxlength="30" id="txtnewcolor" style="text-transform:uppercase" onkeyup="grabColorEnterKey(event);">
</td><td width="57"><img src="../../images/addmark.png" class="mouseover" onClick="AddNewColor();" width="74%" height="20%"></td></tr></table> 					
</td>  
</tr>  
<tr>  
<td height="21" colspan="3" bgcolor="#80AED5" class="normaltxtmidb2L">Sizes</td>  
</tr>  
<tr>  
<td bgcolor="#D6E7F5" class="normalfntMid">Sizes</td>  
<td bgcolor="#D6E7F5">&nbsp;</td>  
<td bgcolor="#D6E7F5" class="normalfntMid">Selected Sizes</td>  
</tr>  
<tr>  
<td valign="top"><select onkeypress="keyMoveSizeRight(event);" name="cbosizes" size="10" class="txtbox" id="cbosizes" style="width:225px" ondblclick="MoveSizeRight();">  
</select></td>  
<td><table width="100%" border="0">  
<tr>  
<td><div align="center"><img onkeypress="keyMoveSizeRight(event)"  src="../../images/bw.png" alt="&gt;" width="18" height="19" class="mouseover" onClick="MoveSizeRight();" /></div></td>  
</tr>  
<tr>  
<td><div align="center"><img src="../../images/fw.png" alt="&lt;" width="18" height="19" class="mouseover" onClick="MoveSizeLeft();" /></div></td>  
</tr>   
<tr>  
<td><div align="center"></div></td>  
</tr>  
<tr>  
<td><div align="center"><img src="../../images/ff.png" alt="&gt;&gt;" width="18" height="19" class="mouseover" onClick="MoveAllSizesLeft();" /></div></td>  
</tr>  
<tr>  
<td><div align="center"><img src="../../images/fb.png" alt="&lt;&lt;" width="18" height="19" class="mouseover" id="imgDownMoveRight" onClick="MoveAllSizesRight();" /></div></td>  
</tr>  
</table></td>  
<td valign="top"><select name="cboselectedsizes" size="8" class="txtbox" id="cboselectedsizes" style="width:225px" ondblclick="MoveSizeLeft();">  
</select> 
<table width="222"><tr><td width="41" class="normalfntMid">New:</td><td width="111"><input  class="txtbox" type="text" size="18"  onkeypress="return string_constrain(event);" onkeyup="grabSizeEnterKey(event);" maxlength="30" id="txtnewSize" style="text-transform:uppercase"></td>
<td width="54"><img src="../../images/addmark.png" class="mouseover" onClick="AddNewSize();"  width="80%" height="20%"></td></tr></table> 					
</td>  
</tr>  
</table></td>  
</tr>  
<tr>  
<td bgcolor="#D6E7F5"><table width="100%" border="0">  
<tr>  
<td width="25%">&nbsp;</td>  
<td width="29%"><img src="../../images/ok.png" alt="OK" width="86" height="24" class="mouseover" onClick="AddSelection();" /></td>  
<td width="21%"><img src="../../images/close.png" alt="Close" width="97" height="24" class="mouseover" onClick="closeFm('addFm1');" /></td>  
<td width="25%">&nbsp;</td>  
</tr>  
</table></td>  
</tr>  
</table>; 
</div>
