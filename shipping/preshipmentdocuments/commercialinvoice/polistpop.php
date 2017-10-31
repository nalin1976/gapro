<?php
	session_start();
	$backwardseperator = "../../../";
	include "../../../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
	$orderNo = $_GET["orderNo"];	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<table width="600" border="0" cellspacing="0" cellpadding="1" bgcolor="#FFFFFF" class="tableBorder">
  <tr>
    <td width="610" ><table width="700" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" class="mainHeading">&nbsp;</td>
        <td width="50%" class="mainHeading">PO List Search</td>
        <td width="25%" class="mainHeading"><img src="../../../images/cross.png" width="17" height="17" align="right" onClick="CloseOSPopUp('popupLayer1');"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="2" cellpadding="0" class="bcgl1">
      <tr bgcolor="#FAD163" class="tableBorder">
        <td ><table width="100%" border="0" cellspacing="2" cellpadding="0" >
          <tr>
            <td width="104" class="normalfnt">Weekly Schedule</td>
            <td width="120"  ><select name="cboWeeklyShedNo" id="cboWeeklyShedNo" style="width:120px;">
              <option value=""></option>
              <?php 
			
			$buyerstr="select intWkScheduleNo,strWkScheduleNo from finishing_week_schedule_header order by strWkScheduleNo;";
		
			$buyerresults=$db->RunQuery($buyerstr);
			
			while($buyerrow=mysql_fetch_array($buyerresults))
			{
		?>
              <option value="<?php echo $buyerrow['intWkScheduleNo'];?>"><?php echo $buyerrow['strWkScheduleNo'];?></option>
              <?php } ?>
            </select>
            </td>
            <td width="44"  class="normalfnt">Destination </td>
            <td width="120"  ><select name="cbopopDestination" id="cbopopDestination" style="width:120px;">
			<option value=""></option>
              <?php
				$sql_destination = "select intCityID,strCityName,strPort from finishing_final_destination 
									order by strCityName ";

				$result = $db->RunQuery($sql_destination);
				while($row = mysql_fetch_array($result))
				{
					 echo "<option value=".$row['intCityID'].">".$row['strCityName']." --> ".$row['strPort']."</option>";
				}
			?>
            </select>
            </td>
            <td width="40"  class="normalfnt">Mode</td>
            <td width="120"  ><select name="cbopopMode" id="cbopopMode" style="width:120px;">
              <option value=""></option>
          <?php
				 $sql="SELECT * FROM shipmentmode where intStatus='1' order by intShipmentModeId";
				 $result = $db->RunQuery($sql);
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=".$row["intShipmentModeId"].">".$row["strDescription"]."</option>\n";
				}
				?>
            </select></td>
            <td width="80"><img src="../../../images/search.png" alt="searchpop" align="right" onClick="loadPOData();"></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><div id="delPopup" style="width:700px; height:200px; overflow:scroll;">
      <table width="100%" border="0" cellspacing="1" cellpadding="0"  bgcolor="#CCCCFF" id="popupPOSearch">
        <tr class="mainHeading4">
          <td width="27" height="20"><input name="chkPOList" id="chkPOList" type="checkbox" onClick="checkAll(this);" ></td>
          <td>PO No </td>
          <td>Destination</td>
        </tr>
      </table>
    </div></td>
  </tr>
  <tr>
    <td height="5"><table width="100%" border="0" cellspacing="2" cellpadding="0" class="tableBorder">
  <tr>
    <td align="center"><img src="../../../images/addsmall.png" onClick="addToMainGrid();"><img src="../../../images/close.png" onClick="CloseOSPopUp('popupLayer1');"></td>
  </tr>
</table>
</td>
  </tr>
</table>
</body>
</html>
