<?php 
include "../../../Connector.php";
$userId			= $_SESSION["UserID"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<script src="weekShipSchedule.js" language="javascript" type="text/javascript"></script>
</head>

<body>
<table width="400" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td ><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="mainHeading">
    <td width="94%" height="25">Shipment Schedule - Destination</td>
    <td width="6%"><img src="../../../images/cross.png" width="17" height="17" onClick="CloseOSPopUp('popupLayer1');"></td>
  </tr>
</table>
</td>
  </tr>
 
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="400" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="181" class="normalfnt">Week Schedule No</td>
        <td width="219"><select name="cboWkSNo" id="cboWkSNo" style="width:150px;" onChange="loadDestinationList();">
        <option value=""></option>
        <?php 
			$sql = "Select intWkScheduleNo,strWkScheduleNo from finishing_week_schedule_header where intUserId='$userId' ";
			$result = $db->RunQuery($sql);
			while($row = mysql_fetch_array($result))
			{
				echo "<option value=".$row["intWkScheduleNo"].">".$row["strWkScheduleNo"]."</option>\n";
			}
		?>
        </select>        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div style="overflow:scroll; width:400px; height:150px;"><table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF" id="tblDestination">
      <tr class="mainHeading4">
        <td width="27" height="25"><input type="checkbox" name="chkDest" id="chkDest" onClick="CheckAll(this,'tblDestination')"></td>
        <td width="261"> Destination</td>
        <td width="58">Mode</td>
      </tr>
    </table></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><img src="../../../images/report.png" width="108" height="24" onClick="viewWkScheduleReport();"></td>
  </tr>
</table>
</body>
</html>
