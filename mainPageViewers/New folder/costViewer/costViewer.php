<script language="javascript" type="text/javascript" src="mainPageViewers/costViewer/costViewerJS.js"></script>
<div class="viewerMainDiv" id="costViewerMainDiv">
 <table width="430"  border="0" cellpadding="0" cellspacing="0" class="normalfnt">
  	 <tr id="moredetailTR11">
    	<td></td>
    </tr>
    <tr id="detailTR11" style="display:none;">
      <td>
      <div class="viewerSubDiv" style="width:600px;">
      
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="23">
            
            
            
            <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
              	<td width="2%">&nbsp;</td>
                <td width="94%" height="22" align="center"><b>Material Reorder Level</b></td>
                <td width="4%" valign="bottom"><img src="images/btCloseSmall.png"  width="18" height="18" class="mouseover" onclick="closeDetail1();"/></td>
                 <?php /*?> <td ><input name="deliverydateDD" type="text" class="txtbox" id="date"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" style="width:100px;" tabindex="11"/><input type="reset" value=""  class="txtbox" style="visibility:hidden; width:10px;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"></td><?php */?>
                </tr>
              <tr>
                
                
                <td colspan="3" align="center"><fieldset class="viewerSub3Div" style="width:565px;">
                  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td height="5" colspan="5"></td>
                      </tr>
                    <tr>
                      <td width="15%" height="30">Cost Center </td>
                      <td width="43%"><select name="cboCostCenter" class="txtbox" id="cboCostCenter" style="width:200px" onchange="loaddetalisDiv1()">
                        <option value="">Select One</option>
                        <?php

	
						$SQL = "SELECT intCostCenterID,strDescription FROM costcenters;";	
						$result = $db->RunQuery($SQL);		
						while($row = mysql_fetch_array($result))
						{
							
								echo "<option value=\"". $row["intCostCenterID"] ."\">" . $row["strDescription"] ."</option>" ;
							
						
						}
	
					?>
                        </select></td>
                      <td width="8%">Date </td>
                      <td width="19%"><?php  echo date("Y-m-d");?></td>
                      <td width="15%"><img src="images/report_2.png" width="80" height="24" /  onclick="showReport();"></td>
                      </tr>
                    </table>
                </fieldset></td>
                </tr>
              <tr>
                <td height="5"></td>  
              </tr>
            </table>
            
            
            </td>
            </tr>
          <tr>
            <td align="center">
             <div class="viewerSub2Div" style="width:580px;">
              <table width="580" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td>
                  <div id="headerDiv1" style="overflow:scroll;width:575px; height:30px; overflow-x:hidden;overflow-y:hidden;">
                  <table width="558" cellpadding="0" cellspacing="1" align="left">
                    <tr class="gridHdrTxtST" bgcolor="#fbbf6f" style='font-size:10px'>
                      <td width="80%" height="30" align="center">Item Description</td>
                      <td width="10%" align="center">ROL</td>
                      <td width="10%" align="center">Stock</td>
                    </tr>
                  </table>
                  </div>
                  </td>
                  </tr>
                <tr>
                  <td>
                  <div id="detalisDiv1" style="overflow:scroll;width:575px; height:250px;" onmousedown="scrollGridHead('headerDiv1','detalisDiv1');">
                 	
                  </div>
                  
                  </td>
                  </tr>
              </table>
              </div>
              
              </td>
          </tr>
          <tr>
            <td height="10"></td>
          </tr>
          
        </table>
      </div>
      </td>
    </tr>
    <tr>
     <td height="5"></td>
    </tr>
    <tr>
      <td align="right">
      <div class="viewerSubDiv" style="width:345px;"  >
      
        <table width="100%" height="27" border="0" cellpadding="0" cellspacing="0" >
          <tr>
            <td width="41" align="center"><img src="images/matratio.png" width="23" height="20" class="mouseover" /></td>
            <td width="276" class="normalfnt" style="text-align:center;">Material Reorder Level</td>
            <td width="28" id="btUpAndDown1"><img src="images/btUpArrow.png" width="23" height="23" class="mouseover" onclick="displayDetail1();"/></td>
          </tr>
        </table>
      </div>
      </td>
    </tr>
  </table>
</div>





