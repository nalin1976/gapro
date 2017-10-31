<?php 
session_start();
	include "../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
	$backwardseperator = "../";
	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<table width="474" border="0" cellspacing="0" cellpadding="2" align="center" bgcolor="#FFFFFF">
  <tr>
    <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr class="mainHeading">
        <td width="455" height="22">LC - Request (PI No List)</td>
        <td width="29"><img src="../images/cross.png" width="17" height="17" onClick="CloseOSPopUp('popupLayer1');"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="51">&nbsp;</td>
    <td width="146">&nbsp;</td>
    <td width="62">&nbsp;</td>
    <td width="209">&nbsp;</td>
  </tr>
 <!-- <tr>
    <td colspan="4" height="250px;" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF" id="tblRpt">
    <thead>
  <tr class="mainHeading4">
    <th width="13%" height="20"><input type="checkbox" name="chkAllPI" id="chkAllPI" onClick="CheckAll(this,'tblRpt');"></th>
    <th width="87%">PI No List</th>
  </tr>
  </thead>
  <?php 
  $sql = "select distinct bpo.strPINO from bulkpurchaseorderheader bpo inner join lcrequestheader lc on 
lc.intBulkPoNo = bpo.intBulkPoNo and 
lc.intYear = bpo.intYear where bpo.strPINO <>''";
	$result = $db->RunQuery($sql);
			while($row = mysql_fetch_array($result))
			{
  ?>
   <tr class="bcgcolor-tblrowWhite">
  <td height="20" class="normalfntMid"><input name="" type="checkbox" value=""></td>
  <td class="normalfnt"><?php echo $row["strPINO"]; ?></td>
   </tr>
    <?php 
	}
	?>
</table></td>
  </tr>-->
  <tr>
    <td colspan="2"><input type="text" name="txtPINolist" id="txtPINolist" onKeyPress="enterLoadSelectedPIlist(event);"></td>
    <td class="normalfnt">Name </td>
    <td><input type="text" name="txtLCname" id="txtLCname" maxlength="30"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="normalfnt">LC No</td>
    <td><select name="cboLCNo" id="cboLCNo" style="width:147px;">
    <?php 
		$sql = "select intLCRequestNo,intRequestYear from lcrequest_pialloheader where intStatus=0 ";
		$result =  $db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{
			echo "<option value=\"". $row["intRequestYear"].'/'.$row["intLCRequestNo"] ."\">" . $row["intRequestYear"].'/'.$row["intLCRequestNo"]."</option>";
		}
	?>
    </select>
    </td>
  </tr>
   <tr>
    <td colspan="2"><select name="cboPIlist" id="cboPIlist" size="10" style="width:200px;" ondblclick="movePINoRight();" onkeypress="keyMovePINoRight(event);">
    <?php 
	 $sql = "select distinct bpo.strPINO from bulkpurchaseorderheader bpo inner join lcrequestheader lc on 
lc.intBulkPoNo = bpo.intBulkPoNo and 
lc.intYear = bpo.intYear where bpo.strPINO <>''";
	$result = $db->RunQuery($sql);
			while($row = mysql_fetch_array($result))
			{
	?>
    <option value="<?php echo $row["strPINO"] ?>"><?php echo $row["strPINO"]; ?></option>
    <?php 
	}
	?>
    </select>
    </td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td height="30" align="center"><img src="../images/bw.png" width="18" height="19" onClick="movePINoRight();"></td>
      </tr>
      <tr>
        <td height="30" align="center"><img src="../images/fw.png" width="18" height="19" onClick="movePINoLeft();"></td>
      </tr>
      <tr>
        <td height="30" align="center"><img src="../images/ff.png" width="18" height="19" onClick="moveAllPItoRight();"></td>
      </tr>
      <tr>
        <td height="30" align="center"><img src="../images/fb.png" width="18" height="19" onClick="moveAllPItoLeft();"></td>
      </tr>
    </table></td>
    <td><select name="cboLCPIlist" id="cboLCPIlist" size="10" style="width:200px;" ondblclick="movePINoLeft();" onkeypress="keyMovePINoLeft(event);">
    </select>
    </td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="2" class="tableFooter">
      <tr>
        <td align="center"><img src="../images/save.png" onClick="savePIDetails();"><img src="../images/send2app.png" onClick="viewLCrequest();">
        <!--<img src="../images/report.png" width="108" height="24" onClick="viewReport();">-->
       </td>
      </tr>
    </table></td>
  </tr>
</table>

</body>
</html>
