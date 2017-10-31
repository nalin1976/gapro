<?php ///////////////////////////// Coding by Lahiru Ranagana 2013-04-04 /////////////////////////
session_start();
include "../../Connector.php";
$userid=$_SESSION["UserID"];
?>
<script language="javascript" type="text/javascript" src="eventsViewerJS.js"></script>

<div class="viewerMainDiv" id="eventViewerMainDiv">
  <table width="500"  border="0" cellpadding="0" cellspacing="0" class="normalfnt">
  	 <tr id="moreDetailTR" style="display:none;">
    	<td>
    	 <div class="viewerSubDiv" style="width:600px;">
      
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="23">
            <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="43%">&nbsp;</td>
                <td width="53%"><b>Search Events</b></td>
                <td width="4%"><img src="../../images/btCloseSmall.png"  width="18" height="18" class="mouseover" onclick="closeMoreDetailTop();resetSrchFm();" title="Close form"/></td>
              </tr>
            </table></td>
            </tr>
          <tr>
            <td align="center">
            <div style="width:580px;" class="viewerSub3Div">
            <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="2%" height="5"></td>
                <td width="13%"></td>
                <td width="35%"></td>
                <td width="14%"></td>
                <td width="36%"></td>
              </tr>
              <tr>
                <td height="25">&nbsp;</td>
                <td>Buyer</td>
                <td id="tdOrderNo"><select name="searchBuyer" class="txtbox" id="searchBuyer" style="width:170px;">
                </select></td>
                <td id="tdOrderNo">Event Name</td>
                <td id="tdOrderNo">
                <select name="searchEvent" class="txtbox" id="searchEvent" style="width:170px" onchange="" >
                  
                </select></td>
              </tr>
              <tr>
              <td height="25">&nbsp;</td>
              <td>Order No</td>
              <td><select name="searchOrderNo" class="txtbox" id="searchOrderNo" style="width:170px" onchange="" >
              </select></td>
              <td>Style</td>
              <td><select name="searchStyle" class="txtbox" id="searchStyle" style="width:170px" onchange="" >
              </select></td>
              </tr> 
               
              <tr>
              <td height="25">&nbsp;</td>
              <td>Color</td>
              <td><select name="searchColor" class="txtbox" id="searchColor" style="width:170px" onchange="" >
              </select></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              </tr> 
               
               
              <tr>
                <td height="30"></td>
                <td colspan="4"><table width="570" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="73" height="25" bgcolor="#FFFF99" class="border-top-bottom border-left" style="border-color:#CCC;">&nbsp;Date From</td>
                    <td width="139" bgcolor="#FFFF99" style="border-color:#CCC;" class="border-top-bottom"><input name='searchDateFrom' type='text'  class='txtbox' id='searchDateFrom' style='width:72px;' onclick="return showCalendar(this.id, '%Y-%m-%d');" onMouseDown='DisableRightClickEvent();' onMouseOut='EnableRightClickEvent();' onKeyPress="return ControlableKeyAccess(event);" /><input type='text' value='' class='txtbox' style='visibility:hidden;width:1px' onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
                    <td width="65" bgcolor="#FFFF99" style="border-color:#CCC;" class="border-top-bottom">Date To</td>
                    <td width="85" bgcolor="#FFFF99" style="border-color:#CCC;" class="border-top-bottom border-right"><input name='searchDateTo' type='text'  class='txtbox' id='searchDateTo' style='width:72px;' onclick="return showCalendar(this.id, '%Y-%m-%d');" onMouseDown='DisableRightClickEvent();' onMouseOut='EnableRightClickEvent();' onKeyPress="return ControlableKeyAccess(event);" /><input type='text' value='' class='txtbox' style='visibility:hidden;width:1px' onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
                    <td width="167" align="right"><img src="../../images/search.png" alt=""  class="mouseover" onclick="loadEvents();" title="Search events"/></td>
                    <td width="41">&nbsp;</td>
                  </tr>
                </table></td>
                </tr>
              <tr>
                <td height="10"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
            </table>
            </div>
            </td>
          </tr>
           <tr>
             <td height="8"></td>
            </tr>
        </table>
        
      </div>
   		</td>
    </tr>
  	
    <tr>
     <td height="5"></td>
    </tr>
  
    <tr id="detailTR" style="display:none;">
      <td>
      <div class="viewerSubDiv" style="width:600px;">
      
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="23">
            <input type="hidden" name="hdToday" id="hdToday" value="<?php echo date("Y-m-d");?>"/>
            <input type="hidden" name="hdGridOrderBy" id="hdGridOrderBy" value=""/>
            <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="43%"><?php //echo"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";  echo date("Y-m-d"); echo"&nbsp;&nbsp;&nbsp;"; echo date("h:i:A");?></td>
                <td width="53%"><img src="../../images/btUpArrowBox.png" width="70" height="13"  class="mouseover" onclick="displayMoreInfoTop();resetSrchFm();" title="Click for view serching facilities"/></td>
                <td width="4%"><img src="../../images/btCloseSmall.png"  width="18" height="18" class="mouseover" onclick="closeDetail();" title="Close form"/></td>
              </tr>
            </table></td>
            </tr>          
          <tr>
            <td align="center">
            <div class="viewerSub2Div" style="width:580px;">
            <table width="580" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="left">
                <div id="headerDiv" style="overflow:scroll;width:563px; height:30px; overflow-x:hidden;overflow-y:hidden;">
                  <table style="width:563px;" border='0' cellpadding='0' cellspacing='1' align="left" id="evtScheduleHeadr">
                    <tr bgcolor='#fbbf6f' class='gridHdrTxtST mouseover' style='font-size:10px'>
                      <td height='30' align='center' title="Click for ordering details by order no">
                      
                    	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        	<tr><td onclick="loadDataOrderBy('OrderNo');" align="center">Order No
                      		<img src="images/icOrderBy.png"   border="0"/></td>
                      		<td width="30" id="tdExpandOrderDetails"><img src="images/btLeftArrow.png" border="0" width="23" height="23" onclick="showMoreOrderDetails();"/></td></tr>
                        </table> 
                      
                      </td>
                      <td width='150' align='center' class="moreColumStyleNo">
                      	  <table width="100%" border="0">
                          <tr><td width="15"></td><td align="center">Style No</td>
                          <td align="right" width="15">
                          <img src="images/btCloseSmallRound.png" border="0" width="15" height="15" onclick="hideColums('moreColumStyleNo',150);"/></td>
                          </tr></table>
                      </td>                   
                      <td width='150' align='center' class="moreColumBuyer">
                          <table width="100%" border="0">
                          <tr><td width="15"></td><td align="center">Buyer</td>
                          <td align="right" width="15">
                          <img src="images/btCloseSmallRound.png" border="0" width="15" height="15" onclick="hideColums('moreColumBuyer',150);"/></td>
                          </tr></table>
                      </td>
                      <td width='150' align='center' class="moreColumDevision">
                      	  <table width="100%" border="0">
                          <tr><td width="15"></td><td align="center">Division</td>
                          <td align="right" width="15">
                          <img src="images/btCloseSmallRound.png" border="0" width="15" height="15" onclick="hideColums('moreColumDevision',150);"/></td>
                          </tr></table>
                      </td>
                      <td width='150' align='center' class="moreColumOritOrderNo">
                          <table width="100%" border="0">
                          <tr><td width="15"></td><td align="center">Orit Order No</td>
                          <td align="right" width="15">
                          <img src="images/btCloseSmallRound.png" border="0" width="15" height="15" onclick="hideColums('moreColumOritOrderNo',150);"/></td>
                          </tr></table>
                      </td>
                      
                      <td width='150' align='center' onclick="loadDataOrderBy('Event');" title="Click for ordering details by Event">Event
                      <img src="images/icOrderBy.png"   border="0"/></td>
                      <td width='80' align='center' onclick="loadDataOrderBy('EstimateDt');" title="Click for ordering details by Estimate Date">Estimate
                      <img src="images/icOrderBy.png"   border="0"/></td>
                      <td width='80' align='center' onclick="loadDataOrderBy('CompleteDt');" title="Click for ordering details by Complete Date">Complete
                      <img src="images/icOrderBy.png"   border="0"/></td>
                      <td width='25'></td>
                    </tr>
                  </table>
                </div></td>
              </tr>
              <tr>
                <td align="center">
           	<div id="detalisDiv" style="overflow:scroll;width:580px; height:220px;" onmousedown="scrollGridHead('headerDiv','detalisDiv');">Loading..</div>
           		</td>
              </tr>
            </table>
            </div>
            </td>
          </tr>
          <tr>
            <td height="30">
            <table width="500" height="12" border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
              <td width="110"><img src="../../images/btSkip.png" name="btSkipEvent" width="79" height="23" class="mouseover" id="btSkipEvent" onclick="skipEvent();" title="Tick events &amp; click this for skip your events"/></td>
                <td width="23" height="23" bgcolor="#FF8080" style="border-color:#CCC; text-align:center;" class="border-top-bottom border-left"><input type="radio" name="radioBt1" id="rdDelayed" value="D" onclick="loadEvents();hideMoreOrderDetails()" checked="checked"/> </td>
                <td width="70" bgcolor="#FFFF99" style="border-color:#CCC;" class="border-top-bottom">&nbsp;Delayed</td>
                <td width="23" bgcolor="#FFCC00" style="border-color:#CCC;text-align:center;" class="border-top-bottom"><input type="radio" name="radioBt1" id="rdPending" value="P" onclick="loadEvents();hideMoreOrderDetails()"/></td>
                <td width="70" bgcolor="#FFFF99" style="border-color:#CCC;" class="border-top-bottom">&nbsp;Future</td>
                <td width="23" bgcolor="#53FF53"  style="border-color:#CCC;text-align:center;" class="border-top-bottom"><input type="radio" name="radioBt1" id="rdCompleted" value="C" onclick="loadEvents();hideMoreOrderDetails()"/></td>
                <td width="70" bgcolor="#FFFF99" style="border-color:#CCC;" class="border-top-bottom border-right">&nbsp;Completed</td>
                <td   align="right"><img src="../../images/btComplete.png" name="btCompleteEvent" width="79" height="23" class="mouseover" id="btCompleteEvent" onclick="completeEvent();" title="Tick events & click this for completing your events"/></td>
                

              </tr>
              
            </table>
            </td>
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
      <div class="viewerSubDiv" style="width:330px;" id="viewerSubDiv">
      
        <table width="100%" height="27" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="40" align="center"><img src="../../images/iconEventViwer.png" width="23" height="20" class="mouseover" /></td>
            <td width="175" class="normalfnt" style="text-align:left;">Events Schedule Information</td>
            <td width="86" id="tdNoOfDelayedEvent" style="color:#F30;"></td>
            <td width="29" id="btUpAndDown"><img src="../../images/btUpArrow.png" width="23" height="23" class="mouseover" onclick="displayDetail();" title="View your event details"/></td>
          </tr>
        </table>
      </div>
      </td>
    </tr>
  </table>
</div>