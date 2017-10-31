
<?php
 session_start();
 include "../../Connector.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EventSchedule</title>

<link href="file:///C|/Program Files/Inetpub/wwwroot/eplan/css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../css/planning.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>

<script type="text/javascript" src="../../javascript/script.js"></script>
<link href="../../css/rb.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/calendar_functions.js" type="text/javascript"></script>
<script type="text/javascript" src="popupMenu.js"></script>
<script type="text/javascript" src="plan-js.js"></script>
</head>

<body >

<table width="450" height="226" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr class="cursercross"  onmousedown="grab(document.getElementById('eventSchedulePopUp'),event);">
            <td width="419" height="41" bgcolor="#498CC2" class="mainHeading">Event Schedule <img align="right" onclick="closeWindow();" id="butClose" src="../../images/cross.png"/></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="88%">
          <table width="100%" border="0">

            <tr>
              <td height="110"><table width="100%">
                <tr>
				<td>
					<table width="430">
                  <td width="11%" height="23">&nbsp;</td>
				   <td width="12%" height="12">&nbsp;</td>
                
                  <td width="4%">&nbsp;</td>
				   <td width="20%" class="normalfnt">BPO No</td>
				   <td width="53%" class="normalfnt"><select id="cboBpoNo" name="cboBpoNo"  style="width: 120px;"  class="txtbox" onchange="loadEventSchDetToPopUp();" ></select></td>
				   </table>
				   </td>
                </tr>
				
				<tr>
				<td height="100"><div style="overflow:scroll; width:430; height:100;">
            			<table width="430" height="100px" bgcolor="#FFFFFF" id="tblschedulePopUp" >
						  <tr height="10px" >
			 				 <td width="20%"   class="grid_raw" align="left">Event</td>
              				  <td width="20%"  class="grid_raw" align="left">Estimated Date</td>
							 <td width="7%"  class="grid_raw" align="left">Delay</td>
              			  </tr>
						   <tr>
			 				 <td>&nbsp;</td>
              				  <td>&nbsp;</td>
							 <td>&nbsp;</td>
              			  </tr>
   
                        </table>
						</div>
				</td>
				</tr>
				
                             
              </table></td>
            </tr>
			<td height="50"><table width="100%" height="50" border="0" cellpadding="0" cellspacing="0">
                <tr>
				
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
			  
                <td width="70%" bgcolor=""><table width="119%" border="0" class="tableFooter">
                    <tr>
                      <td width="235">&nbsp;</td>
                      
                      
                      <td width="136"><img src="../../images/ok.png" class="mouseover" alt="Save" name="Save" onclick="closeWindow();"/></td>
                     
					  <td width="219">&nbsp;</td>
                      
                    </tr>
                </table></td>
              </tr>
            </table></td>
                </tr>
              </table></td>
            </tr>
          </table>
       </td>
        
      </tr>
    </table></td>
  </tr>
  <tr>
    
  </tr>
</table>
</body>
</html>
