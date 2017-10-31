<?php
$backwardseperator = "../../../";
session_start();
include('../../../Connector.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gender</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<script src="shipping.js"></script>
<script src="../../../javascript/script.js"></script>
</head>
<body>

<form name="frmGender" id="frmGender" method="post" action="">
  <table width="500" height="200" border="0" class="tableBorder" bgcolor="#FFFFFF">
    <tr class="cursercross" onmousedown="grab(document.getElementById('frmGender'),event);">
      <td height="35" class="mainHeading" colspan="3">Gender</td>
    </tr>
    <tr>
      <td height="96"><table width="100%" border="0">
          <tr>
            <td colspan="2" class="normalfnt"></td>
            <td width="67%">&nbsp;</td>
          </tr>
          <tr>
            <td width="8%" rowspan="4" class="normalfnt">&nbsp;</td>
            <td width="25%" height="11" class="normalfnt">Search </td>
            <td><select name="gender_cboSearch" id="gender_cboSearch" class="txtbox" onchange="LoadInformation(this);" style="width:160px" >
                <?php
	$SQL="SELECT  intGenderId,strGenderCode FROM gender ORDER BY strDescription";		
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intGenderId"] ."\">" . $row["strGenderCode"] ."</option>" ;
	}		  
			  
				  ?>
              </select>
            </td>
          </tr>
          <tr>
            <td  class="normalfnt">Code</td>
            <td><input name="textGenderCode" type="text"  class="textbox" id="textGenderCode" style="width:160px" maxlength="50" /></td>
          </tr>
          <tr>
            <td class="normalfnt">Description</td>
            <td><input name="textaDescription" type="text"  class="textbox" id="textaDescription" style="width:160px" maxlength="50" />
            </td>
          </tr>
          <tr>
            <td width="23%"  class="normalfnt">Active</td>
            <td><input type="checkbox" name="chkActive" id="chkActive" checked="checked" /></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td height="34"><table width="100%" border="0"class="bcgl1">
          <tr>
            <td width="100%"><table width="100%" border="0" class="tableFooter">
                <tr>
                  <td ><img src="../../../images/new.png" alt="New" name="New"  width="96" height="24" class="mouseover" id="New" onclick="butCommandas(this.name);" /></td>
                  <td ><img src="../../../images/save.png" alt="Save" name="Save" width="84" height="24" class="mouseover" id="Save" onclick="butCommandas(this.name);"/></td>
                  <td id="td_coDelete"><img src="../../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close" onclick="closeWindow()"/></td>
                </tr>
            </table></td>
          </tr>
      </table></td>
    </tr>
  </table>

</form>

</body>
</html>
