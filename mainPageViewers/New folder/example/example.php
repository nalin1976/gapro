<?php ///////////////////////////// Coding by Lahiru Ranagana 2013-04-04 /////////////////////////
session_start();
include "../../Connector.php";
$userid=$_SESSION["UserID"];
?>
<script language="javascript" type="text/javascript" src="mainPageViewers/example/exampleJS.js"></script>
<link rel="stylesheet" type="text/css" href="javascript/calendar/theme.css" />
<script src="javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="javascript/calendar/calendar-en.js" type="text/javascript"></script>


<div class="viewerMainDiv" id="Example">
  <table width="500"  border="0" cellpadding="0" cellspacing="0" class="normalfnt">
  	 <tr id="moreDetailTRExample" style="display:none;">
    	<td>
    	 <div class="viewerSubDiv" style="width:600px;">
      
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="23">
            <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="43%">&nbsp;</td>
                <td width="53%"><b>Search Events</b></td>
                <td width="4%"><img src="images/btCloseSmall.png"  width="18" height="18" class="mouseover" onclick="closeMoreDetailTopExample();" title="Close form"/></td>
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
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
              <td height="25">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              </tr> 
               
              <tr>
              <td height="25">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              </tr> 
               
               
              <tr>
                <td height="30"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
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
  
    <tr id="detailTRExample" style="display:none;">
      <td>
      <div class="viewerSubDiv" style="width:600px;">
      
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="23"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="43%">&nbsp;</td>
                <td width="53%"><img src="images/btUpArrowBox.png" width="70" height="13"  class="mouseover" onclick="displayMoreInfoTopExample();" title="Click for view serching facilities"/></td>
                <td width="4%"><img src="images/btCloseSmall.png"  width="18" height="18" class="mouseover" onclick="closeDetailExample();" title="Close form"/></td>
              </tr>
          </table></td>
            </tr>          
          <tr>
            <td align="center">
            <div class="viewerSub2Div" style="width:580px;">
            <table width="580" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="left">
                <div id="headerDivExample" style="overflow:scroll;width:563px; height:30px; overflow-x:hidden;overflow-y:hidden;">
                 
                </div></td>
              </tr>
              <tr>
                <td align="center">
           	<div id="detalisDivExample" style="overflow:scroll;width:580px; height:220px;" onmousedown="scrollGridHead('headerDivExample','detalisDivExample');">Loading..</div>
           		</td>
              </tr>
            </table>
            </div>
            </td>
          </tr>
          <tr>
            <td height="30">&nbsp;</td>
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
      <div class="viewerSubDiv" style="width:330px;">
      
        <table width="100%" height="27" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="40" align="center"><img src="images/iconEventViwer.png" width="23" height="20" class="mouseover" /></td>
            <td width="175" class="normalfnt" style="text-align:left;">Example</td>
            <td width="86"></td>
            <td width="29" id="btUpAndDownExample"><img src="images/btUpArrow.png" width="23" height="23" class="mouseover" onclick="displayDetailExample();loadGridDataExample();" title="View your event details"/></td>
          </tr>
        </table>
      </div>
      </td>
    </tr>
  </table>
</div>