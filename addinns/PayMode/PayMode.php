<?php
$backwardseperator = "../../";
 	session_start();
	include "../../Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../javascript/calendar/calendar.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />

<title>GaPro | Payment Mode</title>
<script type="text/javascript" language="javascript" src="PayModeJS.js"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>

</head>

<body >
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="tdHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Payment Mode<span class="vol">(Ver 0.3)</span><span id="paymentMode_popup_close_button"><!--<img onclick="" align="right" style="visibility:hidden;" src="../../images/cross.png" />--></span></div>
	</div>
	<div class="main_body">
	
<table width="100%" border="0" align="center" bgcolor="#FFFFFF" >
<!--  <tr>
    <td id="tdHeader"><?php #include "../../Header.php";?></td>
  </tr>-->
<tr>
<td><table width="550" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">
<!--  <tr>
    <td height="25" bgcolor="#498CC2" class="mainHeading"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="13%" valign="middle" class="normaltxtmidb2">&nbsp;</td>
          <td width="72%" class="mainHeading">Payment Mode </td>
          <td width="15%" class="seversion"> (Ver 0.3) </td>
        </tr>
      </table></td>
  </tr>-->
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td><form id="frmPayMode">
          <table width="100%" border="0" >
            <tr>
              <td height="165"><table width="100%" height="165" border="0" cellpadding="0" cellspacing="0">
                <tr class="bcgl1">
                  <td width="100%" valign="top"><table width="101%" border="0" class="bcgl1">
                    <tr>
                      <td valign="top"><table width="100%" border="0">
                        <tr>
                          <td width="32%" class="normalfnt">Description <span class="compulsoryRed">*</span></td>
                          <td width="68%" align="left"><input name="txtDescription"  type="text" class="txtbox" id="txtDescription" size="30" maxlength="100"  tabindex="1"/>
                                        <input name="hidden" type="hidden" id="hidden_paymodeid" />
                          </td>
                        </tr>
                        <tr>
                          <td class="normalfnt" >Remarks <span class="compulsoryRed">*</span></td>
                          <td align="left"><input name="txtRemarks" type="text" class="txtbox" id="txtRemarks" size="50" maxlength="100" tabindex="2"/></td>
                        </tr>
						<tr>
                          <td class="normalfnt" >Active </td>
                          <td align="left"><input type="checkbox" id="chkActINAct" checked="checked" tabindex="3"/></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td height="100" valign="top"><div id="divBatches" style="overflow:scroll; height:150px; width:650px;">
                        <table width="100%" height="44" cellpadding="0" cellspacing="1" id="tblPOPayMode" bgcolor="">
                          <tr class="mainHeading2" >
						  	<td width="10%" height="24"class="grid_header">Del</td>
                            <td width="10%" height="24"class="grid_header">Edit</td>
                            <td width="10%"  class="grid_header"><div align="left">&nbsp;ID</div></td>
                            <td width="30%"  class="grid_header"><div align="left">&nbsp;Description</div></td>
                            <td width="40%"  class="grid_header"><div align="left">&nbsp;Remarks</div></td>
                          </tr>
                          <?php	
							$SQL = "select strPayModeId,strDescription,ifnull(strRemarks,' ') as strRemarks,intStatus from popaymentmode order by strDescription ASC --  where intStatus=1 ;";
							$result = $db->RunQuery($SQL);
							$count=0;
							$cls="";
							while($row = mysql_fetch_array($result))
							{
							($count%2==0)?$cls="grid_raw":$cls="grid_raw2";
						?>
                          <tr bgcolor="#FFFFFF">
						  	<td class="<?php echo $cls;?>"><img src="../../images/del.png" onclick="DeletePaymentMode(this)" alt="Delete" width="15" height="15"  class="mouseover" /></td>
                            <td height="18" class="<?php echo $cls;?>" id="<?php echo  $row["intStatus"];?>"> <img src="../../images/edit.png" alt="edit" width="15" height="15" class="mouseover" onclick="ShowData(this)" /> </td>
                            <td class="<?php echo $cls;?>" id=" <?php echo $row["strPayModeId"];  ?>"><?php echo $row["strPayModeId"];  ?></td>
                            <td class="<?php echo $cls;?>"  id=" <?php echo $row["strDescription"];  ?>" style="text-align:left;"><?php echo ($row["strDescription"]==""? "  n/a":$row["strDescription"]); ?></td>
                            <td class="<?php echo $cls;?>" id=" <?php echo $row["strRemarks"];  ?>" style="text-align:left;"><?php echo ($row["strRemarks"]==""? " n/a":$row["strRemarks"]);  ?></td>
                          </tr>
                          <?php
							$count++;}
						?>
                        </table>
                      </div></td>
                    </tr>
                  </table></td>
                </tr> <tr >
                  <td height="5"></td></tr>
                <tr class="bcgl1">
                  <td bgcolor=""><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder" align="center">
                    <tr>
                  <td class="normalfntp2">
					  <div align="center">
                      <img src="../../images/new.png" alt="NEW" width="96" height="24" onclick="setNew();" tabindex="6" />
                      <img src="../../images/save.png" alt="SAVE" name="Save" width="84" height="24" id="Save" onclick="butCommand(this.name)"tabindex="4" />
                      <a href="../../main.php" id="td_coDelete" ><img src="../../images/close.png" alt="s" width="97" height="24" border="0" / tabindex="5"></a>
                      </div></td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
            </tr>
          </table>
        </form></td>
      </tr>
    </table></td>
  </tr>
</table></td>
</tr>
</table>
</div>
</div>
</body>
</html>
