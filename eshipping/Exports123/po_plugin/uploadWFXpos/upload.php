<?php
	session_start();
	include("../../../Connector.php");
	$backwardseperator = "../../../";
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Order Upload</title>
<script type="text/javascript"  src="../../../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript"  src="../../../js/jquery-1.4.4.min.js"></script>
<script type="text/javascript"  src="../../../js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript"  src="../../../js/jquery-ui-1.8.9.custom.min.js"></script>
<script type="text/javascript" src="../../../javascript/script.js"></script>
<script type="text/javascript" src="upload.js"></script>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
</head>

<body>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../../Header.php';?></td>
    
  </tr>
  <tr>
    <td align="center"><table width="500" border="0" cellspacing="0" cellpadding="0" style="padding:15px;">
      <tr>
        <th width="399" height="20" bgcolor="#316895" class="TitleN2white">Sample Order Upload(WFX)</th>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="2" class="normalfnt bcgl1">
          <tr>
            <td  colspan="2" ><table width="100%" cellpadding="2" cellspacing="0">
              
              <tr>
                <td height="25">&nbsp;</td>
                <td valign="middle" align="center">Type Style</td>
                <td width="49%"><input type="text" class="txtbox" id="txt_povalue" name="txt_povalue"/></td>
                <td width="5%">&nbsp;</td>
              </tr>
              <tr>
                <td width="4%" height="25">&nbsp;</td>
                <td width="42%" align="center"><img src="../../../images/search.png" onclick="loadPoDetails();" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td height="25">&nbsp;</td>
                
                <td colspan="2" rowspan="2">
                <div id="divcons"  style="overflow:scroll; height:200px; width:100%;">
                <table width="100%" border="0" cellspacing="1" cellpadding="0" id="tblPoDetails" bgcolor="#CCCCFF">
                 <thead>
               		<tr bgcolor="#498CC2" class="normaltxtmidb2">                  
                 	 <th width="67" height="25" style="text-align:center">Select</th>
                 	 <th width="228" style="text-align:center">Style No</th>
                 	 <th width="145" style="text-align:center">Po No</th>
                  </tr>
                </thead>
                 
                </table>
                </div></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td height="25">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td height="25">&nbsp;</td>
                <td colspan="2" align="center"><img src="../../../images/upload.jpg" /></td>
                <td>&nbsp;</td>
              </tr>
             
             
              </table></td>
          </tr>   
          </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>