<script language="javascript" type="text/javascript" src="mainPagePanelViewers/sewingProduction/sewingProductionJS.js"></script>
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
                  <td width="32%" height="30">Factory</td>
                  <td width="68%"><select name="cmbSrchFacPD" class="txtbox" id="cmbSrchFacPD" style="width:150px"></select></td>
                  </tr>
                <tr>
                  <td height="30">Line No</td>
                  <td><select name="cmbSrchLinePD" class="txtbox" id="cmbSrchLinePD" style="width:150px"></select></td>
                  </tr>
                <tr>
                  <td height="30">Date</td>
                  <td><input  name="txtSrchDatePD" type="text" class="txtbox" id="txtSrchDatePD" style="width:80px;"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo date("Y-m-d");?>"/><input type="text" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
                  </tr>
                <tr>
                  <td height="40" onclick="abc();">&nbsp;</td>
                  <td valign="middle"><img src="images/btSearch.png" width="78" height="23" onclick="searchDataPD();"/></td>
                  </tr>
                <tr>
                  <td colspan="2">
                  <fieldset  class="fieldsetPnl" style="background-color:#ffffd4;">
                  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td height="10"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td width="25" height="16"></td>
                      <td width="15" bgcolor="#67909a" class="border-All"></td>
                      <td width="100">&nbsp;-&nbsp;Target</td>
                      <td width="15" bgcolor="#bd5559" class="border-All"></td>
                      <td >&nbsp;-&nbsp;Actual</td>
                    </tr>
                    <tr>
                      <td height="7"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </table>
                  </fieldset>
                  </td>
                  </tr>
                </table>
               </fieldset></td>
              <td width="71%" valign="top">
              <fieldset  class="fieldsetPnl">
              <legend class="lengendfntPnl">Graphic view</legend>
              <table width="100%" height="200" border="0" align="center" cellpadding="0" cellspacing="1">
                <tr>
                  <td>
                  <div id="graphicDivPD" style="width:650px;height:198px;overflow:scroll;overflow-x:hidden;overflow-y:hidden;">
                 	
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
                  <div id="mainGridHeadDivPD" style="width:913px;height:61px;overflow:scroll;overflow-x:hidden;overflow-y:hidden;">
                    <table  style="width:913px;" border="0" cellpadding="0" cellspacing="1" id="table1PD" bgcolor="#FFFFFF">
                      <tr class="gridHdrTxtPnlMn">
                          
                          <td colspan="4" height="30" bgcolor="#66CC00">Target</td>
                          <td style="background-color:#FFF;"></td>
                          <td colspan="5" bgcolor="#FF6600">Actual</td>
                      </tr>
                      <tr bgcolor="#fbbf6f" class="gridHdrTxtPnl" >
                                              
                        <td width="80" height="30">Start Time</td>
                        <td width="80">End Time</td>
          				<td width="215">Order no</td>
                        <td width="80">Qty</td>
                        
                        <td style="background-color:#FFF;"> </td>
                        
                       
                        <td width="80">Achieve Time</td>
                        <td width="285">Order no</td>
                        <td width="80">Qty</td>
                      </tr>
                    </table>
                  </div>
                  </td>
                  </tr>
                <tr>
                  <td><div id="mainGridDataDivPD" style="overflow:scroll; height:250px; width:930px;" onmousedown="scrollGridHead('mainGridHeadDivPD','mainGridDataDivPD');"></div></td>
                  </tr>
              </table></fieldset></td>
              </tr>
          </table></td>
          </tr>
      </table></td>
    </tr>
  </table>
