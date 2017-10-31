<?php
	session_start();
	include("../../Connector.php");
	$backwardseperator = "../../";	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>

<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="documentList.js"></script>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="350" height="128" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
  <tr class="bcgcolor-row">
    <td width="10%" >&nbsp;</td>
    <td width="80%"><span  class="normaltxtmidb2L">Document Type</span></td>
    <td width="10%" align="right"><img src="../../images/cross.png" alt="c" width="17" height="17" onclick="closeWindow()" class="mouseover"/></td>
  </tr>
  
  <tr>
    <td  class="bcgcolor">&nbsp;</td>
    <td class="bcgcolor" ><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
      <tr>
        <td width="58" height="30">Document</td>
        <td colspan="6" >&nbsp;<select name="popDoc" style="width:200px" id="popDoc" class="txtbox" onchange="loadDoc(this)" tabindex="1">
        <option value=""></option>
		<!--Dynomically document names are populated in this place, on onclick event of the ADD button -->
        </select></td>
      </tr>
            <tr>
        <td colspan="5">&nbsp;</td>
        <td width="58" align="right">&nbsp;</td>
        <!-- this TD stores the intDocumentFormatId of the selected Document -->
        <td width="164" align="right"><input name="txDocumentFormatId"  class="normalfntRite txtbox" id="txDocumentFormatId" style="width:140px; hight:35px ;display:none"  ></td>
      </tr>
      <tr>
        <td height="25" colspan="6">Document</td>
        <td height="25"><input name="txtpopNewDoc"  class="txtbox" id="txtpopNewDoc" style="width:180px; hight:35px; "/></td>
        
        </tr>
         <tr>
           <td height="25" colspan="6">Description</td>
        <td><input name="txtpopDocDesc"  class="txtbox" id="txtpopDocDesc" style="width:180px ; hight:35px" /></td>
        </tr>
      <tr>
        <td colspan="5"><img src="../../images/delete.png" alt="" width="100" height="24"  onclick="deleterRecord();" /></td>
        <td width="58" align="right"><img src="../../images/add-new.png"  class="mouseover" align="right" onclick="refreshi()"/></td>
        <td width="164" align="right"><img src="../../images/save_small.jpg" alt="c" width="25" height="25" class="mouseover" align="right" onclick="saveDoc()"/></td>
      </tr>
      <tr>
      	<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td> 
      </tr>
    </table></td>
    <td valign="bottom"  class="bcgcolor">&nbsp;</td>
  </tr>
</table>

</body>
</html>
