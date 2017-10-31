<?php
session_start();
$backwardseperator = "../";
include "$backwardseperator".''."Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Style-Ratio Packing List Plug-in</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
	
}

-->
</style>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.3.2.min.js"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="styleratioplplugin.js" type="text/javascript"></script>
<script src="../../../javascript/tablednd.js" type="text/javascript"></script>
</head>

<body>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../Header.php'; 
 ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><table width="600" border="0" cellspacing="0" cellpadding="0" class="normalfnt bcgl1">
      <tr>
        <td colspan="4" bgcolor="#316895" class="TitleN2white">Style-Ratio Packing List Plug-in </td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><dd>Order #</dd></td>
        <td><input name="txtStyle" tabindex="4" type="text" class="txtbox" id="txtStyle"  style="width:158px" maxlength="20" onblur="focus_cell(1)" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="5%">&nbsp;</td>
        <td width="45%">&nbsp;</td>
        <td width="45%">&nbsp;</td>
        <td width="5%">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2"><div id="divcons"  style="overflow:scroll; height:300px; width:100%;">
                <table width="100%"  cellpadding="0" cellspacing="1" bgcolor="#ccccff" id="tblSizes">
                  <tr bgcolor="#498CC2" class="normaltxtmidb2">
                  		<td width="8%"   >&nbsp;</td>
                        <td width="18%" height="25" >Size</td>
                        <td width="18%" >Color</td>
                        <td width="12%" >PCS</td>
                        <td width="12%" >Net  </td>
                        <td width="20%" >Description</td>
                  </tr>
                  <tr class="mainHeading4" bgcolor="#FFFFFF">
                  		<td    class="normalfntMid"><img height="15" width="15" maxlength="15" alt="del" onclick="remove_detail_from_grid(this);" src="../images/del.png"></td>
                        <td  height="25" align="center"><input  type="text" tabindex="3" class="txtbox"  style="text-align:center; width:85px; " id="txtGarments2"  maxlength="10"  /></td>
                        <td  align="center" ><input  type="text" class="txtbox"   tabindex="3" style="text-align:center; width:85px; " id="txtGarments2"  maxlength="10"  /></td>
                        <td  align="center" ><input  type="text" class="txtbox"   tabindex="3" style="text-align:center; width:55px; " id="txtGarments2"  maxlength="10" onkeypress="return CheckforValidDecimal(this.value, 4,event);" /></td>
                        
                         <td  align="center" ><input  type="text" class="txtbox"   tabindex="3" style="text-align:center; width:55px; " id="txtGarments2"  maxlength="10" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
                        <td  align="center" ><input  type="text" class="txtbox"   tabindex="3" style="text-align:center; width:100px; " id="txtGarments2"  maxlength="10" onblur="add_row(this)" /></td>
                        
                  </tr>
                  </table>
          </div></td>
        <td>&nbsp;</td>
      </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2"><div align="center"><img src="../images/save.png" alt="save" name="butSave" width="84" height="24" class="mouseover" id="butSave" onclick="delete_first();" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/next.png" alt="save" name="butSave" width="84" height="24" class="mouseover" id="butSave" onclick="next_step();" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/new.png" alt="new" name="butNew" width="84" height="24" class="mouseover"  id="butNew" onclick="location.reload();"/></div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>