<?php
 session_start();
 include "../../Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Bins</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
 <table width="715" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr  class="mainHeading">
      <td width="675">Manage Bin : <?php echo $_GET["binName"]; ?></div></td>
      <td width="30" ><div align="right"><img src="../../images/cross.png" width="17" height="17" class="mouseover" onclick="closeWindow();" /></td>
    </tr>
    <tr>
      <td height="23" colspan="2" class="normalfnt"><br>
      <div align="left" style="margin-left:10px;">Main Category  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 
        <select name="cboMainCategory" class="txtbox" id="cboMainCategory" onchange="LoadMaterialCategories(<?php echo $_GET["bin"]; ?>);" style="width:200px">
        <option value="0">Select One</option>
        <option value="1">Fabric</option>
        <option value="2">Accessories</option>
        <option value="3">Packing Material</option>
        <option value="4">Services</option>
        <option value="5">Other</option>
		 <option value="6">Washing</option>
        </select>
      </div></td>
    </tr>
    <tr>
      <td height="25" colspan="2" class="normalfnt"><div align="left" style="margin-left:10px;">Sub Category like :
          <input class="txtbox" type="text" name="txtSubCategory" id="txtSubCategory" value="" maxlength="10" style="width:200px"  onkeyup="doThis(event);" title="type sub category and press enter"/>
      </div></td>
    </tr>
  </table>
<div id="divcons" style="overflow:scroll; height:230px; width:715px;">
  <table width="690" id="tblCategories"  border="0" bgcolor="#CCCCFF" cellpadding="0" cellspacing="1" class="bcgl1" >
  

  </table>
</div>
<table width="715" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0">
<tr>
<td bgcolor="#498CC2" class="normaltxtmidb2L" width="30%" ><div style="width:300px;"><input type="checkbox" onClick="checkAll(this);"> 
Select/Unselect All</div></td>
<td bgcolor="#498CC2" class="normaltxtmidb2L" width="30%"><div style="width:150px;"><input type="checkbox" onClick="setSameUnit(this);"> Same Unit</div></td>
<td bgcolor="#498CC2" class="normaltxtmidb2L" width="30%"><div style="width:150px;"><input type="checkbox" onClick="setSameCapacity(this);"> Same Capacity</div></td>
<td bgcolor="#498CC2" class="normaltxtmidb2L" width="10%"></td>
</tr>
</table>
 <table width="715" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="334" bgcolor="#D6E7F5" id="message">&nbsp;</td>
      <td width="124" bgcolor="#D6E7F5"><img src="../../images/assign.png" width="100" height="24" class="mouseover" onclick="SaveCategoryAllocation(<?php echo $_GET["bin"]; ?>);" /></td>
    </tr>
</table>

</body>
</html>
