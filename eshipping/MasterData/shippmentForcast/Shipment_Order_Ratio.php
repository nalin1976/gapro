<div id="addFm" class="popupFrom" style="margin-left:200px" >
  <tr>
    <td>
      <tr>
        <td width="900"><table width="100" border="0" cellspacing="0" id="pop1">
          <tr>
            <td width="900" height="30" bgcolor="#498CC2" class="TitleN2white"><div align="right">Shipment Order Ratio </div></td>
            <td width="35%" bgcolor="#498CC2" class="TitleN2white">&nbsp;</td>
            </tr>
          <tr bgcolor="#D8E3FA">
            <td height="96" colspan="2">
              <table width="66%" border="0" cellpadding="0" cellspacing="0" >
                
                <tr>
                  <td colspan="2" class="normalfnt" style="text-align:center">
                    
                    <tr>
                      <td colspan="4" class="normalfnt"><table width="566" border="0" class="bcgl1">
                        
                        <tr>
                          <td width="134" class="normalfnt">SC Number </td>
                          <td width="208"><select name="cboSCNO" class="txtbox" onchange="LoadGridUsingSe();"   style="width:200px" id="cboSCNO">
                            <?php
	
							$SQL = "SELECT
							shipmentforecast_detail.strSC_No
							FROM
							shipmentforecast_detail
							GROUP BY
							shipmentforecast_detail.strSC_No
							ORDER BY
							shipmentforecast_detail.strSC_No DESC";
	
	$result = $db->RunQuery($SQL);
	
	echo "<option value=\"".""."\">" .""."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strSC_No"] ."\">" . $row["strSC_No"] ."</option>" ;
	}
	
	?>
                            </select></td>
                          <td width="230" style="visibility:hidden"><input name="txtstyle" type="text" maxlength="100" class="txtbox" id="txtstyle" size="60" style="width:225px"/></td>
                          </tr>
                        <tr>
                          <td class="normalfnt">PO NUMBER</td>
                          <td width="208"><select name="cboPONO" class="txtbox"   style="width:200px" id="cboPONO">
                            <?php
								
							$SQL = "SELECT
							shipmentforecast_detail.strPoNo
							FROM
							shipmentforecast_detail
							GROUP BY
							shipmentforecast_detail.strSC_No
							ORDER BY
							shipmentforecast_detail.strSC_No DESC";
							
										
	
	$result = $db->RunQuery($SQL);
	
	echo "<option value=\"".""."\">" .""."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strPoNo"] ."\">" . $row["strPoNo"] ."</option>" ;
	}
	
	?>
                            </select></td>
                          <td>&nbsp;</td>
                        </tr>
                      </table></td>
                </tr>
                    <tr>
                      <td colspan="4" class="normalfnt"><table width="566" border="0" cellpadding="0" cellspacing="0">
                        
                        <tr>
                          <td colspan="2" class="normalfnt"><table width="564"><tr><td width="502">
                          <div style="overflow-y: scroll; overflow-x: scroll; height: 100px; width: 564px;" id="selectitem1">
                          <table width="100%" bgcolor="FFFFFF" cellpadding="0" cellspacing="1" class="bcgl1 normalfnt" id="tblOrderRatio">
          <tr>
          	<td width="13%" height="20" bgcolor="#498CC2" class="normaltxtmidb2">Color</td>
            <td width="13%" bgcolor="#498CC2" class="normaltxtmidb2">Size</td>
            <td width="13%" bgcolor="#498CC2" class="normaltxtmidb2">M</td>
            <td width="13%" bgcolor="#498CC2" class="normaltxtmidb2">L</td>
            <td width="13%" bgcolor="#498CC2" class="normaltxtmidb2">XL</td>
            <td width="13%" bgcolor="#498CC2" class="normaltxtmidb2">XXL</td>
		  </tr>	
          <!--<tr class="bcgcolor-tblrowWhite">
          <td style="text-align:center"><input type="text" style="width:158px; text-align:center;" onblur="checkExist(this);"/></td>
          <td style="text-align:center"><input type="text" style="width:75px; text-align:center;" onblur="checkExist(this);"/></td>
          <td style="text-align:center"><input type="text" style="width:75px; text-align:center;" onblur="checkExist(this);"/></td>
          	<td style="text-align:center"><input type="text" style="width:75px; text-align:center;" onblur="checkExist(this);"/></td>
          	<td style="text-align:center"><input type="text" style="width:75px; text-align:center;" onblur="checkExist(this);"/></td>
            <td style="text-align:center"><input type="text" style="width:75px; text-align:center;" onkeypress="addR(this,event); return CheckforValidDecimal(this.value,4,event)"/></td>
          </tr>-->
          	
           </table>
           </div> 
                            
                            </td>
                                                              
                          </tr></table></td>
                          </tr>
                      </table></td>
                </tr>
            </table></td>
          </tr>
                </table>            </td>
  </tr>
          <tr>
            <td height="34" colspan="2"><table width="572" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="900" bgcolor="#d6e7f5"><table width="566" border="0">
                  <tr>
                    
                    <td width="7">&nbsp;</td>
                    <td width="103">&nbsp;</td>
                    <td width="97"><img src="../../images/new.png" width="84" height="24" name="New" onclick="showColorSizeSelector();" class="mouseover" id="check" alt="new"/></td>
                    <td width="96"><img src="../../images/save.png" alt="Save" width="84" height="24" name="Save"  class="mouseover" onclick="savedata()" /></td>
                    <td width="108"><img src="../../images/close.png" alt="Close"  class="mouseover" name="Close" width="84" height="24" border="0" onclick="closeFm('addFm');" /></td>
                  <td width="130">&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
  </tr>
</table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
 </table>
 </div>