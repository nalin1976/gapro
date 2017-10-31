<?php
//session_start();
//include "authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<title>.:Wash Delails:.</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<link href="../../css/eWashStyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="957" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td width="951"><?php //include 'Header.php'; ?>
    <img src="../../image/eplan_logo.png" width="191" height="47" /></td>
  </tr>
  
  <tr>
    <td><table width="940" border="0" align="center" cellpadding="1" cellspacing="1" class="normalfnt">
      <tr>
      <td colspan="2" height="27" bgcolor="#316895" class="tophead">Wash Delails</td>
    </tr>
	<tr>
      <td colspan="2" height="8" ></td>
    </tr>
	  
	  <tr>
        <td width="460">
<fieldset class="fieldsetStyle" style="width:460px;">
		
		<table width="460" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="4">&nbsp;</td>
            <td width="85" height="25">GatePass No </td>
            <td width="169"><select name="gatePassNo" id="gatePassNo" class="txtbox" style="width:150px;" >
              <option value="0" selected="selected">Select Item</option>
            </select></td>
            <td width="53">Po No </td>
            <td width="149"><select name="PoNo" id="PoNo" class="txtbox" style="width:150px;" >
              <option value="0" selected="selected">Select Item</option>
            </select></td>
          </tr>
        </table></fieldset></td>
        <td width="464">
<fieldset class="fieldsetStyle" style="width:444px; ">
		
		<table width="440" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="2">&nbsp;</td>
            <td width="59" height="25">From </td>
            <td width="126"><input name="DFrom" type="text" class="txtbox" id="DFrom" size="20" /></td>
            <td width="43">&nbsp;</td>
            <td width="33">To </td>
            <td width="122"><input name="DTo" type="text" class="txtbox" id="DTo" size="20" /></td>
            <td width="29">&nbsp;</td>
          </tr>
        </table></fieldset></td>
      </tr>
      <tr>
        <td height="34">&nbsp;</td>
        <td><div align="right"><a href="washdetails.php"><img src="../../image/search.png" alt="search" width="84" height="24" border="0" /><img src="../../image/print.png" alt="print" width="84" height="24" border="0" /></a></div></td>
      </tr>
      <tr>
        <td colspan="2">
<fieldset class="fieldsetStyle" style="width:927px;">
<div id="txtemp"  style="overflow:scroll; width:925px; height:300px;">
<table width="1500" border="0" cellpadding="0" cellspacing="1" >
    <tr bgcolor="#498CC2" class="normalfntWhiteText">
      <td width="80" height="30">GatePass No</td>
      <td width="100">PO No</td>
      <td width="100">Factory</td>
      <td width="100">Style No</td>
      <td width="100">Cut No</td>
      <td width="100">Total Qty</td>
      <td width="100">Receive Qty</td>
	  <td width="100">Receive Date</td>
	  <td width="100">empty</td>
	  <td width="100">empty</td>
	  <td width="100">empty</td>
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
    <td height="18" background="../images/bcgdbar.png" class="copyright" align="right">&nbsp;</td>
  </tr>
</table>


</body>
</html>
