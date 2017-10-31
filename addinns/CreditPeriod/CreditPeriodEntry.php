<?php
 session_start();
 $backwardseperator = "../../";
 include "../../Connector.php";
 #chk updates
 
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Payments:Credit period</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="CreditPeriodJS.js"></script>
<script src="/gapro/javascript/script.js" type="text/javascript"></script>
</head>
<body>

<form name="frmCreditPeriod" id="frmCreditPeriod" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="td_coHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Credit Period<span class="vol">(Ver 0.3)</span><span id="creditperiod_popup_close_button"><!--<img onclick="" align="right" src="../../images/cross.png" />--></span></div>
	</div>
	<div class="main_body">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">

  <tr>
    <td><table width="500" border="0" align="center" class="tableBorder">
      <tr>
        <td >
          <table width="100%" border="0" >
            <tr>
              <td height="17"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="9%"  height="25">&nbsp;</td>
                    <td width="19%" class="normalfnt">Description&nbsp;<span class="compulsoryRed">*</span></td>
                    <td width="37" id="title_Description" title=""><input name="txtDescription" type="text" class="txtbox" id="txtDescription" size="31" maxlength="50" tabindex="1"/></td>
                    <td width="35%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="24">&nbsp;</td>
                    <td class="normalfnt">No of dates&nbsp;<span class="compulsoryRed">*</span></td>
                    <td align="left" width="37" ><input name="txtNoOfDates" type="text" class="txtbox" id="txtNoOfDates" size="10" maxlength="3" style="text-align:right" onkeypress="return CheckforValidDecimal(this.value, 0,event);" tabindex="1"/></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td >&nbsp;</td>
                    <td class="normalfnt">Active</td>
                    <td align="left" width="37"><input type="checkbox" name="chkActive" id="chkActive" checked="checked"/></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="24" colspan="4" class="tableBorder"><table  width="10" border="0" cellspacing="0" cellpadding="0" align="center">
                      <tr>
                        <td >&nbsp;</td>
                        <td ><img src="../../images/new.png" alt="New" name="New" onClick="ClearCPForm();" class="mouseover" tabindex="5"/></td>
                        <td ><img src="../../images/save.png" onclick="NewCreditPeriod();" alt="save" width="84" height="24" tabindex="3"/></td>
                        <td  id="tdDelete"><a href="../../main.php"><img src="../../images/close.png" alt="close" width="97" height="24" border="0" tabindex="4"/></a></td>
                        <td >&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td height="161"><table width="100%" height="159" border="0" cellpadding="0" cellspacing="0">
                  <tr class="bcgl1">
                    <td width="100%" height="138"><table width="93%" border="0" class="bcgl1">
                        <tr>
                          <td colspan="3"><div id="divcons" style="overflow:scroll; height:150px; width:500px;">
                              <table width="100%" id="tblCreditPeriod" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
                                <tr class="mainHeading2">
                                  <td width="39" bgcolor="" class="normaltxtmidb2">Del</td>
                                  <td width="44" bgcolor="" class="normaltxtmidb2">Edit</td>
                                  <td width="249" bgcolor="" class="normaltxtmidb2">Credit Period</td>
                                  <td width="116" height="20" bgcolor="" class="normaltxtmidb2"><div align="center">No of Dates</div></td>
                                  </tr>
		  						  <?php
								  	$SQL = "SELECT intSerialNO,strDescription,dblNoOfDays,intStatus FROM creditperiods  order by strDescription ASC";	
									$result = $db->RunQuery($SQL);	
									while($row = mysql_fetch_array($result))
									{
								  ?>	
                                <tr class="bcgcolor-tblrowWhite">
                                  <td class="normalfnt"><div align="center"><img src="../../images/del.png" onclick="DeleteCreditPeriod(this)" alt="Delete" width="15" height="15"  class="mouseover" id="<?php echo $row["intSerialNO"];  ?>" /></div></td>
                                  <td class="normalfnt"><div align="center"><img src="../../images/edit.png"  onclick="showData(this)" alt="Edit" width="15" height="15" class="mouseover" id="<?php echo $row["intSerialNO"];  ?>" /></div></td>
                                  <td class="normalfnt" id="<?php echo $row["intStatus"]; ?>"><?php echo $row["strDescription"]; ?></td>
                                  <td class="normalfnt" style="text-align:right"><?php echo $row["dblNoOfDays"];  ?>                                </td>
                                  </tr>    
								  <?php
								  }
								  ?>                            
                              </table>
                          </div></td>
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
</table>
</form>
</body>
</html>
