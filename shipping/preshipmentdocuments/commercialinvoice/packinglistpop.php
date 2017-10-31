<?php
	session_start();
	$backwardseperator = "../../../";
	include "../../../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
	$stlyeId = $_GET["stlyeId"];
	$weeklySheduId = $_GET["weeklySheduId"];	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<table width="550" border="0" cellspacing="0" cellpadding="1" bgcolor="#FFFFFF" class="tableBorder">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" class="mainHeading">&nbsp;</td>
        <td width="50%" class="mainHeading">PL List Search</td>
        <td width="25%" class="mainHeading"><img src="../../../images/cross.png" width="17" height="17" align="right" onClick="CloseOSPopUp('popupLayer1');"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="2" cellpadding="0" class="bcgl1">
      <tr bgcolor="#FAD163" class="tableBorder">
        <td ><table width="100%" border="0" cellspacing="2" cellpadding="0" >
          <tr>
            <td class="normalfnt">&nbsp;</td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><div id="delPopup" style="width:550px; height:200px; overflow:scroll;">
      <table width="100%" border="0" cellspacing="1" cellpadding="0"  bgcolor="#CCCCFF" id="popupPLSearch">
        <tr class="mainHeading4">
          <td width="5%" height="20">&nbsp;</td>
          <td width="24%">PL No </td>
          <td width="24%">PL Date </td>
          <td width="24%">Qty</td>
          <td width="23%">CBM</td>
        </tr>
		<?php
	$sql = "select FSPH.intPLNo,
			FSPH.strPLDate,
			sum(FSPD.dblQtyPcs) as Qty,
			sum(FSPD.dblNoofCTNS) as NoofCTNS,
			FOS.dblCTN_l,
			FOS.dblCTN_w,
			FOS.dblCTN_h
			from finishing_shipmentplheader FSPH
			inner join finishing_shipmentpldetail FSPD ON FSPD.intPLNo=FSPH.intPLNo
			left join finishing_order_spec FOS ON FOS.intStyleId=FSPH.intStyleId
			where FSPH.intStyleId='$stlyeId'
			AND intPreShipStatus = 0
			group by FSPH.intPLNo";
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$cbm_fm=$row["dblCTN_l"]*$row["dblCTN_w"]*$row["dblCTN_h"]*$row["NoofCTNS"]*.0000164;
	?>
		<tr class="bcgcolor-tblrowWhite">
          <td width="5%" height="20" class="normalfntMid"><input name="rdoPLNo" type="radio" id="rdoPLNo" ></td>
          <td width="24%" class="normalfnt" id="<?php echo $row["intPLNo"]; ?>"><?php echo $row["intPLNo"]; ?></td>
          <td width="24%" class="normalfnt"><?php echo $row["strPLDate"]; ?> </td>
          <td width="24%" class="normalfnt"><?php echo $row["Qty"]; ?></td>
          <td width="23%" class="normalfnt"><?php echo number_format($cbm_fm,2); ?></td>
        </tr>
		<?php
	}
	?>
		
      </table>
    </div></td>
  </tr>
  <tr>
    <td height="5"><table width="100%" border="0" cellspacing="2" cellpadding="0" class="tableBorder">
  <tr>
    <td align="center"><img src="../../../images/addsmall.png" onClick="addPLToMainGrid(<?php echo $stlyeId;?>,<?php echo $weeklySheduId;?>);"><img src="../../../images/close.png" onClick="CloseOSPopUp('popupLayer1');"></td>
  </tr>
</table>
</td>
  </tr>
</table>
</body>
</html>
