<?php
	session_start();
	$backwardseperator = "../../";
include "${backwardseperator}authentication.inc";

 include "../../Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Time Table Header</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="eventschdl.js">
</script>

</head>

<body>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include "../../Header.php";?></td>
  </tr>
  <tr>
    <td>
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td width="951"></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="15%">&nbsp;</td>
        <td width="55%"><table width="75%" border="0" class="tableBorder">
          <tr>
            <td height="35" bgcolor="#498CC2" class="mainHeading">Event Schedule</td>
          </tr>
          <tr>
            <td height="165"><form id="frmcategories" name="form1" method="post" action="">
              <table width="100%" height="165" border="0" cellpadding="0" cellspacing="0">
                <tr class="bcgl1">
                  <td width="100%"><table width="93%" border="0" class="bcgl1">
                    <tr>
                      <td colspan="3"><div id="divcons" style="overflow:scroll; height:130px; width:500px;">
          <table width="485" id="tblEvents" cellpadding="0" cellspacing="0">

			  <?php
			  
			 

			$SQL = "select strDescription from events ;";
			
			$result = $db->RunQuery($SQL);
			
			while($row = mysql_fetch_array($result))
			{
			  
			  ?>
			   <tr>
              <td class="normalfnt"><?php echo $row["strDescription"]; ?></td>
              </tr>
			  <?php
			  }
			  ?>
          </table>
        </div></td>
                      </tr>
                    
                  </table></td>
                </tr>
                <tr class="bcgl1">
                  <td>&nbsp;</td>
                </tr>
                <tr class="bcgl1">
                  <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="backcolorGreen">
				<!-- <div style="filter:progid:DXImageTransform.Microsoft.Gradient(
   GradientType=1,StartColorStr='white', EndColorStr='#498CC2');
   width: 100%" height="18" class="normaltxtmidb2L style1" >New Event                   
					</div> -->
					<tr>
                      <td height="18" colspan="4" bgcolor="#99CC00" class="mainHeading4"><strong>New Event</strong></td>
                      </tr>
                    <tr>
                      <td width="3%" height="27" class="backcolorWhite">&nbsp;</td>
                      <td width="22%" class="backcolorWhite">Event name</td>
                      <td colspan="2" class="backcolorWhite"><input name="txtevent" type="text" class="txtbox" id="txtevent" size="60" maxlength="45" /></td>
                      </tr>
                    <tr>
                      <td colspan="2" bgcolor="#D6E7F5" class="backcolorWhite">&nbsp;</td>
                      <td width="14%" bgcolor="#D6E7F5" class="backcolorWhite">&nbsp;</td>
                      <td width="61%" bgcolor="#D6E7F5" class="backcolorWhite"><div align="right"><img src="../../images/addsmall.png" alt="Add" width="95" height="24" class="mouseover" onclick="AddEvents();" /></div></td>
                    </tr>
                  </table></td>
                </tr>
                <tr class="bcgl1">
                  <td>&nbsp;</td>
                </tr>
                <tr class="bcgl1">
                  <td bgcolor=""><table width="100%" border="0" class="tableFooter">
                    <tr>
                      <td width="27%">&nbsp;</td>
                      <td width="26%" class="normalfntp2">&nbsp;</td>
                      <td width="27%" class="normalfntp2">&nbsp;</td>
					  <td width="12%" class="normalfnt"><img src="../../images/report.png" alt="Report" width="108" height="24" border="0" class="mouseover" onclick="loadReport();"  /></td>
                      <td width="20%"><div align="right"><span class="normalfntp2"><a href="../../main.php"><img src="../../images/close.png" alt="close" width="97" height="24" border="0" class="mouseover" /></a></span></div></td>
                    </tr>
                  </table></td>
                </tr>
              </table>
                        </form>            </td>
          </tr>
        </table></td>
        <td width="30%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</td>
</tr>
</table>
</body>
</html>
