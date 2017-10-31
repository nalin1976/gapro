<?php
$backwardseperator = "../../";
include '../../Connector.php' ;
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Country</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="destination.js"></script>

</head>
<body>

<form id="notifyParty" name="notifyParty" >
  <table width ="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="600" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder" cellspacing="0">
    
    <tr>
      <td height="25"class="mainHeading"> Country </td>
	</tr>
	<tr>
		<td><table width="100%" border="0" cellspacing="10" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" align="center"  cellspacing="0" cellpadding="2">
  <tr>
    <td><table width="93%" border="0" align="center" class="bcgl1">
      <tr>
        <td colspan="3" class="normalfnt"><table width="100%" border="0" cellspacing="2" cellpadding="0" class="tableBorder">
          <tr>
            <td class="normalfnt"><table width="100%" border="0" cellspacing="4" cellpadding="0" bgcolor="#FAD163">
          <tr>
            <td width="2%" class="normalfnt">&nbsp;</td>
            <td width="14%" class="normalfnt">Country </td>
            <td width="84%" class="normalfnt"><select name="cboSearch" style="width:300px" id="cboSearch" tabindex="1" onchange="setData(this.value);">
              <?php
		$SQL =" SELECT intConID, strCountry FROM country where intStatus<>10 order by strCountry;";	
		
		$result = $db->RunQuery($SQL);
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intConID"] ."\">" . $row["strCountry"] ."</option>" ;
	}		  
		 ?>
            </select></td>
          </tr>
        </table></td>
            </tr>
        </table></td>
        </tr>
      
      <tr>
        <td colspan="3" class="normalfnt"><table width="98%" border="0" cellspacing="0" cellpadding="0">
           <tr>
        <td colspan="2" class="normalfnt"><div id="divcons" style="overflow:scroll; height:250px; width:600px;">
          <table id="tblNGMain" width="100%" bgcolor="#CCCCFF"  cellpadding="0" cellspacing="1" >
            <tr class="mainHeading4">
              <td width="7%" height="25">Edit</td>              
			  <td width="31%" >City </td>			  
              <td width="31%" >Port</td>
              <td width="31%" >Alternative City</td>
              </tr>
          </table>
        </div></td>
        </tr>
        </table></td>
        </tr>
      
      <tr>
        <td colspan="3" class="normalfnt">&nbsp;</td>
      </tr>

    </table></td>
  </tr>
  <tr>
  <td><table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" class="bcgl1">
  <tr>
    <td align="center"><img src="../../images/new.png" alt="New" name="New" class="mouseover" id="New" style="display:inline" onclick="AddNewCity(1);" tabindex="14"/><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" border="0" id="Close" style="display:inline" tabindex="16"/></a></td>
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
 </td>
 </tr>
 </table>  
 </form>
</body>
</html>
