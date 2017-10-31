<?php 
$itemId = $_GET["itemId"];
include "../Connector.php";
$possitionID = $_GET["possitionID"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
<link href="../css/erpstyle.css" rel="stylesheet"/>
</head>

<body>
<table width="550" border="0" cellspacing="0" cellpadding="2" bgcolor="#FFFFFF">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr class="mainHeading">
        <td width="96%" height="25">Edit Item - <?php echo getItemName($itemId); ?></td>
        <td width="4%"><img src="../images/cross.png" width="17" height="17" onClick="CloseOSPopUp('popupLayer1')"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="2" class="bcgl1">
    <tr><td>
    	<table width="100%" border="0" cellspacing="0" cellpadding="2" class="normalfnt">
      <tr>
       <td width="5%">&nbsp;</td>
        <td width="20%">Con./PC</td>
        <td width="31%"><input type="text" name="txtConpc" id="txtConpc" style="width:100px; text-align:right"></td>
        <td width="16%">Units</td>
        <td width="24%"><select name="cboUnits" id="cboUnits" style="width:100px;" disabled>
        <?php 
		$sql="SELECT strUnit FROM units u where u.intStatus=1 ORDER BY strUnit";
		$result = $db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{
			echo "<option value=\"". $row["strUnit"] ."\">".$row["strUnit"]."</option>\n";
		}
		?>
        </select>        </td>
        <td width="4%">&nbsp;</td>
      </tr>
      <tr>
       <td >&nbsp;</td>
        <td>Unit Price</td>
        <td><input type="text" name="txtUnitPrice" id="txtUnitPrice" style="width:100px; text-align:right" disabled></td>
        <td>Wastage</td>
        <td><input type="text" name="txtwastage" id="txtwastage" style="width:98px; text-align:right" disabled></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
      <td>&nbsp;</td>
        <td>Origin</td>
        <td><select name="cboOrigin" id="cboOrigin" style="width:102px;" disabled>
        <?php 
		$sql="select intOriginNo,strOriginType from itempurchasetype where intStatus=1 order by strOriginType";
		$result = $db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{
			echo "<option value=\"". $row["intOriginNo"] ."\">".$row["strOriginType"]."</option>\n";
		}
		?>
        </select>        </td>
        <td>Freight</td>
        <td><input type="text" name="txtfreight" id="txtfreight" style="width:98px; text-align:right" disabled></td>
        <td>&nbsp;</td>
      </tr>
     
    </table></td></tr></table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="2" class="tableFooter">
      <tr>
        <td align="center"><img src="../images/save.png" width="84" height="24" onClick="updateItemDetails(<?php echo $possitionID; ?>);"><img src="../images/close.png" width="97" height="24" onClick="CloseOSPopUp('popupLayer1')"></td>
      </tr>
    </table></td>
  </tr>
   <tr>
    <td height="5"></td>
  </tr>
</table>
<?php 
function getItemName($itemId)
{
	global $db;
	$sql = "Select strItemDescription from matitemlist where intItemSerial='$itemId' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["strItemDescription"];
}
?>
</body>
</html>
