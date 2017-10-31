<?php
//session_start();
//include "authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<title>.:OutSide Recerive:.</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<link href="../css/eWashStyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="957" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td width="951"><?php //include 'Header.php'; ?>
    <img src="../image/eplan_logo.png" width="191" height="47" /></td>
  </tr>
  
  <tr>
    <td><table width="940" border="0" align="center" cellpadding="0" cellspacing="0" class="normalfnt">
    <tr>
      <td colspan="2" height="27" bgcolor="#316895" class="tophead">OutSide Recerive</td>
    </tr>
	<tr>
      <td colspan="2" height="8" ></td>
    </tr>
	
	  
	  <tr>
        <td width="467" valign="top">
		
<fieldset class="fieldsetStyle" style="width:465px;">
<legend class="innertxt">Name Of from </legend>			
		<table width="465" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="5">&nbsp;</td>
            <td width="50" height="25">PO No </td>
            <td width="162"><select name="poNo" id="poNo" class="txtbox" style="width:150px;" >
                <option value="0" selected="selected">Select Item</option>
            </select></td>
            <td width="87">Style Name </td>
            <td width="152"><select name="styleName" id="styleName" class="txtbox" style="width:150px;" >
                <option value="0" selected="selected">Select Item</option>
            </select></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td height="25">Color</td>
            <td><input name="color" type="text" class="txtbox" id="color" size="20" /></td>
            <td>Mill</td>
            <td><input name="mill" type="text" class="txtbox" id="mill" size="20" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td height="25">Division</td>
            <td><input name="division" type="text" class="txtbox" id="division" size="20" /></td>
            <td>Factory</td>
            <td><input name="factory" type="text" class="txtbox" id="factory" size="20" /></td>
          </tr>
        </table></fieldset></td>
        <td width="472" rowspan="2" valign="top">
		
<fieldset  class="fieldsetStyle" style="width:444px;height:130px;">
<legend class="innertxt">Name of from</legend>		
		<table width="444" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="4">&nbsp;</td>
            <td width="77" height="25">Gatepass No </td>
            <td width="139"><input type="text" name="gatepassNo" id="gatepassNo" class="txtbox" size="20"/></td>
            <td width="71">Fab ID </td>
            <td width="149"><input name="fabId" type="text" class="txtbox" id="fabId" size="20" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td height="25">Cut No </td>
            <td><input name="cutNo" type="text" class="txtbox" id="cutNo" size="20" /></td>
            <td>Size</td>
            <td><input name="size" type="text" class="txtbox" id="size" size="20" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td height="25">Purpose</td>
            <td><input name="purpose" type="text" class="txtbox" id="purpose" size="20" /></td>
            <td>Qty </td>
            <td><input name="qty" type="text" class="txtbox" id="qty" size="20" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td height="25">PO Qty </td>
            <td><input name="poQty" type="text" class="txtbox" id="poQty" size="20" /></td>
            <td>Date</td>
            <td><select name="date" id="date" class="txtbox" style="width:150px;" >
                <option value="0" selected="selected">Select Item</option>
            </select></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td height="25">Terms</td>
            <td><input name="terms" type="text" class="txtbox" id="terms" size="20" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td height="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
</fieldset>
		
	<p align="right" ><a href="outSideRecerive.php"><img src="../image/new.png" alt="new" width="84" height="24" border="0" /></a><a href="outSideRecerive.php"><img src="../image/save.png" alt="save" width="84" height="24" border="0" /></a><a href="outSideRecerive.php"><img src="../image/print.png" alt="print" width="84" height="24" border="0" /></a><a href="outSideRecerive.php"><img src="../image/close.png" alt="close" width="84" height="24" border="0" /></a></p></td>
      </tr>
      <tr>
        <td height="85" valign="top">
		
<fieldset class="fieldsetStyle" style="width:465px;">
<legend class="innertxt">Name Of from </legend>	
		
		<table width="465" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="4">&nbsp;</td>
            <td width="43" height="25">PO No </td>
            <td width="149"><input name="poNo2" type="text" class="txtbox" id="poNo2" size="20" /></td>
            <td width="170">&nbsp;</td>
            <td width="99">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td height="25">From</td>
            <td><input type="text" name="Dfrom" id="Dfrom" class="txtbox" size="20"/></td>
            <td>To
              <input type="text" name="DTo" id="DTo" class="txtbox" size="20"/></td>
            <td><a href="washRecerive.php"><img src="../image/search.png" alt="search" width="84" height="24" border="0" /></a></td>
          </tr>
          
        </table>
</fieldset></td>
        </tr>
      <tr>
        <td height="264" colspan="2">
		
<fieldset class="fieldsetStyle" style="width:930px;">
<div id="txtemp"  style="overflow:scroll; width:930px; height:250px;">
<table width="1500" border="0" cellpadding="0" cellspacing="1" >
    <tr bgcolor="#498CC2" class="normalfntWhiteText">
      <td width="50" height="30">Date</td>
      <td width="80">Cut No</td>
      <td width="80">Size</td>
      <td width="80">GatePass No</td>
      <td width="80">Qty</td>
      <td width="80">Total</td>
	  <td width="80">Wash Type</td>
	  <td width="80">PO No</td>
	  <td width="80">empty</td>
	  <td width="80">empty</td>
    </tr>
	<?php
			for($count=1;$count<20;$count++)
			{
			?>
          <tr bgcolor="#9FFFFF">
            <td  height="22">Data</td>
            <td>Data.</td>
            <td>Data</td>
            <td>Data</td>
            <td>Data</td>
            <td>Data</td>
            <td>Data</td>
            <td>Data</td>
            <td>Data</td>
            <td>Data</td>
          </tr>
          <?php
			}
			?>
</table>  
</div>
</fieldset>	
		
		 </td>
        </tr>
    </table></td>
  </tr>
  
  
  <tr>
    <td height="10" background="images/bcgdbar.png" class="copyright" align="right">&nbsp;</td>
  </tr>
</table>


</body>
</html>
