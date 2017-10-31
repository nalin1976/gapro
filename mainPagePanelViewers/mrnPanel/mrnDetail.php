
<script language="javascript" type="text/javascript" src="mainPagePanelViewers/mrnPanel/mrnDetail.js"></script>
<script type="text/javascript" src="../../issue/issue.js"></script>
<script type="text/javascript" src="../../issue/issue.js"></script>
<script type="text/javascript">

</script>
<link href="../panelCSS.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../css/erpstyle.css"/>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
    <tr>
      <td align="center" class="normalfnt">
      <table width="950" height="550" border="0" cellpadding="5" cellspacing="0">
        <tr>
          <td valign="top"><table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="1">
            <tr>
              <td width="100%" valign="top">
             
              
            <fieldset  class="fieldsetPnl" style="display:none" >
              <legend class="lengendfntPnl">Graphical View</legend>
              <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="1">
                <tr>
                  <td >
                  <div id="graphicDivPD" style="width:650px;height:30px;overflow:scroll;overflow-x:hidden;overflow-y:hidden;">
                 	<table>
                    	<tr class="mouseover">
                                              
                        
                          <td width="70" >MRN No 
						</td>
 <td width="150" ><select id="cboMrnno" class="txtbox" style="width:150px" name="cboMrnno" onchange="loadMrnDetailsToGrid();"></select></td>  
 
 <td  height="23" width="21" >&nbsp;</td>
                         <td  width="15" >&nbsp;</td>
                        
                       
                        <td height="23" width="12" >&nbsp;</td>
                         <td width="13">&nbsp;</td>
                            
                       
                     
                       
                        <td  height="23" width="10">&nbsp;</td>
                         <td width="289" ><img id="btCompleteEvent" class="mouseover" height="23" width="79" title="Tick events & click this for completing your events" 	                             onclick="completeEvent();" name="btCompleteEvent" src="images/btComplete.png" /></td>
                        </tr>
                    </table>
                  </div></td>
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
                  <div id="mainGridHeadDivPD" style="width:913px;height:30px;overflow:scroll;overflow-x:hidden;overflow-y:hidden;">
                    <table width="928" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF" id="table1PD" style="width:913px;">
                   
                      <tr class="gridHdrTxtPnlMn">
                          
                         
                          <td style="background-color:#FFF;"></td>
                          
                      </tr>
                      <tr bgcolor="#fbbf6f" class="gridHdrTxtPnl" style="width:100%;" >
       
                        <td width="15%">MRN No</td>
                        <td width="20%" height="30">MRN Date</td>
                        <td width="20%">Department</td>
                        <td width="15%">User</td>
                        <td width="15%">Stores</td>
                        <td width="15%">Issue Note</td>
                       
                      </tr>
                    </table>
                  </div>
                  </td>
                  </tr>
                <tr>
                
                  <td><div id="mainGridDataDivPD" style="overflow:scroll; height:450px; width:930px;" onmousedown="scrollGridHead('mainGridHeadDivPD','mainGridDataDivPD');">
              <table  style="width:913px;" border="0" cellpadding="0" cellspacing="1" id="MRNtbl" bgcolor="#FFFFFF">
                      <thead>
                      <tr class="gridHdrTxtPnlMn">
                          
                         
                          <td style="background-color:#FFF;"></td>
                          
                      </tr>
                      <tbody>
                       <tr class="gridHdrTxtPnlMn">
                          
                         
                          <td style="background-color:#FFF;"></td>
                          
                      </tr>
                      </tbody>
                      </thead>
                    </table>
                  
                  </div></td>
                  
                  </tr>
              </table></fieldset></td>
              </tr>
          </table></td>
          </tr>
      </table></td>
    </tr>
  </table>