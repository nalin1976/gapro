<?php
	session_start();
	$backwardseperator = "../../";
	include "../../Connector.php";	
	$cityID		 = $_GET["cityID"];
	$conId 		 = $_GET["conId"];
	$CityName    = $_GET["CityName"];
	$Port 		 = $_GET["Port"];	
	$altCityName = $_GET["altCityName"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>City Search</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>


</head>
<body>

<form id="cityPopUp" name="cityPopUp" >
<table width="500" border="0" bgcolor="#FFFFFF" class="tableBorder" cellspacing="0"> 
  <tr>
    <td><table width="500" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="mainHeading">City Search </td>
    <td width="25" class="mainHeading"><img src="../../images/cross.png" width="17" height="17" align="right" onClick="CloseOSPopUp('popupLayer1');"></td>
  </tr>
</table></td>
  </tr>
	<tr>
		<td><table width="100%" border="0" cellspacing="10" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" align="center"  cellspacing="0" cellpadding="2">
  <tr>
    <td><table width="93%" border="0" align="center" class="bcgl1">
      
      <tr>
        <td colspan="4" class="normalfnt"></td>
        </tr>
      
      <tr>
        <td colspan="2" class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td width="2%" class="normalfnt">&nbsp;</td>
        <td width="23%" class="normalfnt">Search City </td>
        <td width="70%" class="normalfnt"><select name="cboCitySearch" style="width:300px" id="cboCitySearch" tabindex="1" onchange="setCityData(this.value,<?php echo $conId; ?>);">
          <?php
		$SQL =" SELECT intCityID,strCityName FROM finishing_final_destination ";	
		
		if($conId!="")
			$SQL.=" WHERE intConID='$conId'";
		$SQL.=" order by strCityName";

		$result = $db->RunQuery($SQL);
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		if($cityID==$row["intCityID"])
		echo "<option selected=\"selected\" value=\"". $row["intCityID"] ."\">" . $row["strCityName"] ."</option>" ;
		else
		echo "<option value=\"". $row["intCityID"] ."\">" . $row["strCityName"] ."</option>" ;
	}		  
		 ?>
        </select></td>
        <td width="5%" class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">City</td>
        <td class="normalfnt"><input name="txtCityName" type="text" class="txtbox" id="txtCityName"  style="width:300px" maxlength="20" tabindex="2" value="<?php echo $CityName; ?>"/></td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Port</td>
        <td class="normalfnt"><input name="txtPort" type="text" class="txtbox" id="txtPort"  style="width:300px" maxlength="20" tabindex="2" value="<?php echo $Port; ?>"/></td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Alternative City</td>
        <td class="normalfnt"><input name="txtDestination" type="text" class="txtbox" id="txtDestination"  style="width:300px" maxlength="20" tabindex="2" value="<?php echo $altCityName; ?>"/></td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>

    </table></td>
  </tr>
  <tr>
  <td><table width="93%" align="center" border="0" cellspacing="0" cellpadding="0" class="bcgl1">
  <tr>
    <td align="center"><img src="../../images/new.png" alt="New" name="New" class="mouseover" id="New" style="display:inline" onclick="ClearForm();" tabindex="14"/> <img src="../../images/save.png" alt="Save" name="Save" class="mouseover" id="Save" style="display:inline" onclick="SaveData(<?php echo $conId; ?>);" tabindex="13"/><img src="../../images/delete.png" alt="Delete" border="0"name="Delete" class="mouseover" id="Delete" onclick="deleteData(<?php echo $conId; ?>);" style="display:inline" tabindex="15"/><img src="../../images/close.png" alt="Close" name="Close" border="0" id="Close" style="display:inline" tabindex="16" onClick="CloseOSPopUp('popupLayer1');"/></td>
  </tr>
</table>
</td>
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
