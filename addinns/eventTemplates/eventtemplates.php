<?php

session_start();
$backwardseperator = "../../";
include "${backwardseperator}authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Event templates</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="eventtemplates.js" type="text/javascript"></script>
<script src="../../javascript/script.js"></script>
</head>

<body>
<?php
	include "../../Connector.php";	
?>

<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include "../../Header.php";?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="28%">&nbsp;</td>
        <td width="51%"><form name="frmEventTemplate" id="frmEventTemplate">
          <table width="91%" border="0">
            <tr>
              <td height="16" bgcolor="#498CC2" class="mainHeading">Event templates</td>
            </tr>
            <tr>
              <td height="17"><table width="100%" border="0">
                <tr>
                  <td width="1%">&nbsp;</td>
                  <td width="14%" class="normalfnt">Customer</td>
                  <td colspan="5"><select name="cbocustomer" id="cbocustomer" class="txtbox" style="width:250px" onchange="LoadLeadTime();">
                      <?php
						$SQL = "SELECT	intBuyerID,strName FROM buyers ORDER BY strName";
						$result = $db->RunQuery($SQL);
						
						echo "<option value = \"". "" . "\">" . "" . "</option>";
						while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"" . $row["intBuyerID"] ."\">" . $row["strName"] . "</option>";
						}
					?>
                    </select>                  </td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td width="14%" class="normalfnt">Lead Time </td>
                  <td width="16%"><!-- <input name="txtleadtime" type="text" class="txtbox" id="txtleadtime" /></td> -->
                      <select name="cboleadtime" id="cboleadtime" class="txtbox" style="width:75px" onchange="LoadEventsforLeadTime();">
                      </select>                  </td>
                  <td width="6%"><img  src="../../images/add.png" width="16" height="16"  class="mouseover" onclick="DrawNewLeadTimeTextBox();" /></td>
                  <td width="15%"><div  id="divnewleadtime"  name="divnewleadtime">		</div></td>
                  <td width="15%"><div  id="divnewleadtimeok"  name="divnewleadtimeok">		</div></td>
                  <td width="15%">&nbsp;</td>
                  <td width="10%" align="left">&nbsp;</td>
                  <td width="8%"></td>
                  <!--<select name="cboleadtime" id="cboleadtime" class="txtbox" style="width:150px"> </select>-->
                </tr>
              </table></td>
            </tr>
            <tr>
              <td height="165"><table width="98%" height="165" border="0" cellpadding="0" cellspacing="0">
                  <tr class="bcgl1">
                    <td width="100%"><table width="93%" border="0" class="bcgl1">
                        <tr>
                          <td colspan="3"><div id="divcons" style="overflow:scroll; height:300px; width:500px;">
							<!-- Populating Table Grid with Events [start]-->
                              <table width="100%" cellpadding="0" cellspacing="0" id="tblevents" >
                                <tr>
                                  <td width="27" bgcolor="#498CC2" class="mainHeading2">Edit</td>
                                  <td width="48" height="18" bgcolor="#498CC2" class="mainHeading2">Select</td>
                                  <td width="271" bgcolor="#498CC2" class="mainHeading2">Event Name</td>
                                  <td width="112" bgcolor="#498CC2" class="mainHeading2">Offset</td>
                                </tr>
                              </table>
                          </div></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr class="bcgl1">
                    <td bgcolor=""><table width="100%" border="0" class="tableFooter">
                        <tr>
                          <td width="23%"  class="normalfnt"><input type="checkbox" id="chkCheckAll" onClick="checkAll(this);" >&nbsp;Check All</td>
                          
                          <td width="17%" class="normalfntRite" ><img src="../../images/save.png" alt="Save"  class="mouseover" onclick="SaveEventTemplates();"/></td>
                          <td width="20%" class="normalfntp2"><img src="../../images/report.png" alt="report" align="middle" class="mouseover" onclick="loadReport();"/></td>
                          <td width="19%" class="normalfntLeft"><a href="../../main.php"><img src="../../images/close.png" alt="close"   border="0" align="middle" class="mouseover" /><a></td>
                          <td width="18%">&nbsp;</td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
            </tr>
          </table>
<div style="left:551px; top:439px; z-index:10; position:absolute; width: 122px; visibility:hidden; height: 20px;" id="divlistORDetails">
  <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
  <tr>
    <td width="43"><div align="center">List</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioListORdetails" id="radioListORdetails" value="list" onclick="loadReport();"/></div></td>
	<td width="57"><div align="center">Details</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioListORdetails" id="radioListORdetails" value="details" onclick="loadReport();"/></div></td>
  </tr>
  </table>	  
  </div>
        </form></td>
        <td width="21%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
