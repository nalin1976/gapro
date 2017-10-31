<?php
 session_start();
 include "../../Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Fabric Content</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

</head>

<body>
 <table bgcolor="#FFFFFF" width="515" border="0" cellpadding="0" cellspacing="0">
    <tr bgcolor="#FDC042">
      <td width="488" height="21" class="mainHeading">Fabric Content</td>
      <td width="27"  ><div align="center"><img src="../../images/cross.png" width="17" height="17" class="mouseover" onclick="closeWindow();" /></div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="left">&nbsp; 
        <input name="txtContentName" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();"  onkeypress="return false;" type="text" class="txtbox" id="txtContentName" style="width:340px; visibility:hidden;" />
      </div></td>
    </tr>
    <tr>
      <td  colspan="2" align="left" class="mainHeading3">
          Available Fabric Categories : </td>
    </tr>
  </table>
<div id="divcons" style="overflow:scroll; height:230px; width:515px;">
  <table width="497" id="tblContent"  border="0" bgcolor="#FDC042" cellpadding="0" cellspacing="1" >
  <?php
  $SQL = "SELECT  intSubCatNo,StrCatName FROM matsubcategory  WHERE intCatNo = 1 ORDER BY StrCatName;";
	
	$result = $db->RunQuery($SQL);
	$pos = 0;
	while($row = mysql_fetch_array($result))
	{
  
  ?>
    <tr class="<?php 
			  if ($pos % 2 == 0)
					echo "bcgcolor-tblrow";
				else
					echo "bcgcolor-tblrowWhite";
			   ?>">
      <td width="355" class="normalfnt"><?php echo $row["StrCatName"];  ?></td>
      <td width="103" class="normalfnt"><input name="<?php echo $row["contentID"];  ?>" type="text" class="txtboxRightAllign" id="<?php echo $row["contentID"];  ?>" value="0" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();"  onkeypress="return isNumberKey(event);" size="8" onblur="generateContentName();" maxlength="3"  /> 
      % </td>
    </tr>
<?php
$pos ++;
	}
?>
  </table>
</div>
 <table width="515" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="334" class="mbari13" align="right"><img src="../../images/close.png" alt="Close" width="97" height="24" border="0" class="mouseover" onclick="closeWindow();" /></td>
      <td width="124" class="mbari13" align="right">
      <img src="../../images/next.png" width="100" height="24" class="mouseover" onclick="saveContentName();" /><!-- onclick="saveContentName();" --></td>
    </tr>
</table>

</body>
</html>
