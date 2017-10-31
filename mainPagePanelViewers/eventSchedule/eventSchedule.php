<script language="javascript" type="text/javascript" src="mainPagePanelViewers/eventSchedule/eventScheduleJS.js"></script>
<link href="../panelCSS.css" rel="stylesheet" type="text/css" />
  <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
    <tr>
      <td align="center" class="normalfnt">
      <table width="950" height="550" border="0" cellpadding="5" cellspacing="0">
        <tr>
          <td valign="top"><table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="1">
            <tr>
              <td width="29%" valign="top">
               <fieldset  class="fieldsetPnl"><legend class="lengendfntPnl">Search</legend>
              <table width="100%" height="200" border="0" align="center" cellpadding="0" cellspacing="1">
                <tr>
                  <td height="5"></td>
                  <td></td>
                </tr>
                <tr>
                  <td width="35%" height="30">Order No</td>
                  <td width="65%"><select name="cmbSrchOrderEV" class="txtbox" id="cmbSrchOrderEV" style="width:150px" onchange="loadDeilveryDateEV();">
                  </select></td>
                  </tr>
                <tr>
                  <td height="30">Delivery Date</td>
                  <td><select name="cmbSrchDeliDateEV" class="txtbox" id="cmbSrchDeliDateEV" style="width:100px">
                    <option value="">Select one</option>
                  </select></td>
                  </tr>
                <tr>
                  <td height="40">&nbsp;</td>
                  <td><img src="images/btSearch.png" width="78" height="23" onclick="searchDataEV();"/></td>
                  </tr>
                
                <tr>
                  <td colspan="2" align="center"><fieldset  class="fieldsetPnl" style="background-color:#ffffd4;"><table width="240" border="0" align="center" cellpadding="0" cellspacing="2">
                    <tr>
                      <td height="7" colspan="8" ></td>
                      </tr>
                    <tr>
                      <td width="15" height="15" bgcolor="#fde797" class="border-All">&nbsp;</td>
                      <td width="7">&nbsp;</td>
                      <td width="15" bgcolor="#b3905b" class="border-All">&nbsp;</td>
                      <td width="80" > -Pending</td>
                      <td width="15" bgcolor="#71fb67" class="border-All">&nbsp;</td>
                      <td width="5" >&nbsp;</td>
                      <td width="15" bgcolor="#67909a" class="border-All">&nbsp;</td>
                      <td   > -Completed</td>
                      </tr>
                    <tr>
                      <td height="5" colspan="8"></td>
                      </tr>
                    <tr>
                      <td height="15" bgcolor="#ff8a88" class="border-All">&nbsp;</td>
                      <td>&nbsp;</td>
                      <td bgcolor="#bd5559" class="border-All">&nbsp;</td>
                      <td>-Delay</td>
                      <td bgcolor="#fb62f6" class="border-All">&nbsp;</td>
                      <td>&nbsp;</td>
                      <td bgcolor="#9a6778" class="border-All">&nbsp;</td>
                      <td>-Skiped</td>
                    </tr>
                    <tr>
                      <td height="5" colspan="8" ></td>
                      </tr>
                  </table></fieldset>
                  
                  </td>
                  </tr>
                </table>
               </fieldset></td>
              <td width="71%" valign="top">
              <fieldset  class="fieldsetPnl">
              <legend class="lengendfntPnl">Graphic view</legend>
              <table width="100%" height="200" border="0" align="center" cellpadding="0" cellspacing="1">
                <tr>
                  <td  align="center">
                  <div id="graphicDivBarEV" style="width:320px;height:198px;overflow:scroll;overflow-x:hidden;overflow-y:hidden;">
                 	
                  </div>                  
                  </td>
                  <td width="1" bgcolor="#FAD163"> </td>
                  <td align="center">
                  <div id="graphicDivPieEV" style="width:320px;height:198px;overflow:scroll;overflow-x:hidden;overflow-y:hidden;">
                 	
                  </div>                 
                  </td>
                  </tr>
                </table></fieldset>
              </td>
              </tr>
            <tr>
              <td colspan="2" valign="top">
              <fieldset  class="fieldsetPnl"><legend class="lengendfntPnl">Details View</legend>
              <table width="930" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td>
                  <div id="mainGridHeadDivEV" style="width:913px;height:31px;overflow:scroll;overflow-x:hidden;overflow-y:hidden;">
                    <table  style="width:913px;" border="0" cellpadding="0" cellspacing="1" id="table1EV" bgcolor="#FFFFFF">                     
                      <tr bgcolor="#fbbf6f" class="gridHdrTxtPnl" >
                        <td width="28"></td>                      
                        <td height="30">Event</td>
                        <td width="100">Estimated Date</td>
          				<td width="100">Change Date</td>
                        <td width="100">Completed Date</td>
                        <td width="200">Responsible</td>
                      </tr>
                    </table>
                  </div>
                  </td>
                  </tr>
                <tr>
                  <td><div id="mainGridDataDivEV" style="overflow:scroll; height:280px; width:930px;" onmousedown="scrollGridHead('mainGridHeadDivEV','mainGridDataDivEV');"></div></td>
                  </tr>
              </table></fieldset></td>
              </tr>
          </table></td>
          </tr>
      </table></td>
    </tr>
  </table>
