<?php
 session_start();
 include "Connector.php";
?>
<!--<link href="css/erpstyle.css" rel="stylesheet" type="text/css">
-->
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />

<div id="divcons" style="overflow:scroll; height:130px; width:490px;">
  <table id="tblBuyerPO" width="470" cellpadding="0" cellspacing="1" bgcolor="#ccccff">
    <tr>
      <td width="28" bgcolor="#498CC2" class="normaltxtmidb2L"><div align="center"><img src="images/add.png" alt="add" width="16" height="16" /></div></td>
      <td width="119" bgcolor="#498CC2" class="normaltxtmidb2">Buyer PO No</td>
      <td width="83" height="33" bgcolor="#498CC2" class="normaltxtmidb2">Qty</td>
      <td width="83" bgcolor="#498CC2" class="normaltxtmidb2">With Ex Qty</td>
      <td width="81" bgcolor="#498CC2" class="normaltxtmidb2">Remarks</td>
      <td width="67" bgcolor="#498CC2" class="normaltxtmidb2">BPO Qty</td>
    </tr>
	<?php
		$styleNo = $_GET["styleID"];
		$dtDateofDelivery = $_GET["DelDate"];
		$SQL = "select strBuyerPoName,strBuyerPONO, dblQty from style_buyerponos where intStyleId = '$styleNo';";
		$result = $db->RunQuery($SQL);
		if ($dtDateofDelivery != "")
		{
			$year = substr($dtDateofDelivery,-4);
			$month = substr($dtDateofDelivery,-7,-5);
			$day = substr($dtDateofDelivery,-10,-8);
			$dtDateofDelivery = $year . "-" . $month . "-" . $day;
		}
		while($row = mysql_fetch_array($result))
		{
			$poNo = $row["strBuyerPONO"];
			$Qty = "";
			$ExQty = "";
			$remarks = "";
			$poName = $row["strBuyerPoName"];
			
			$SQL = "select dtDateofDelivery,intQty,strRemarks,intWithExcessQty  from bpodelschedule where intStyleId = '$styleNo' AND strBuyerPONO = '$poNo' AND dtDateofDelivery ='$dtDateofDelivery';";
			//echo $SQL;
			$POresult = $db->RunQuery($SQL);
			$isSelected= false;
	
			while($POrow = mysql_fetch_array($POresult))
			{
				$isSelected = true;
				$Qty = $POrow["intQty"];
				$ExQty = $POrow["intWithExcessQty"];
				$remarks = $POrow["strRemarks"];
			}
			
	?>
    <tr class="bcgcolor-tblrowWhite">
      <td class="normalfnt">
        <div align="center">
          <input type="checkbox" onClick="fillbpoData(this);" name="chkBPO" <?php if ($isSelected) echo  "checked=\"checked\""; ?> id="chkBPO" />
          </div></td>
      <td class="normalfnt" id='<?php echo $poNo; ?>'><?php echo $poName; ?></td>
      <td class="normalfntMid">
      <input name="textfield" type="text" class="txtboxRightAllign" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();"  onkeypress="return isNumberKey(event);" onBlur="checkExceedingBPOQty(this);" size="10" id="<?php echo $row["dblQty"]; ?>" value="<?php echo $Qty; ?>"></td>
      <td class="normalfntMid">
      <input name="textfield2" type="text" class="txtboxRightAllign" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();"  onkeypress="return isNumberKey(event);" onBlur="calculateTotalBPOQty();" size="10" value="<?php echo $ExQty; ?>"></td>
      <td class="normalfnt"><span class="normalfntMid">
        <input name="textfield3" type="text" class="txtboxRightAllign" size="10" value="<?php echo $remarks ; ?>">
      </span></td>
      <td class="normalfntRite"><?php
      
      $sql = "SELECT dblQty FROM style_buyerponos WHERE intStyleId = '$styleNo' AND strBuyerPONO = '$poNo'";
      $bpoqty = 0;
		$rst = $db->RunQuery($sql);
      while($qtyrow = mysql_fetch_array($rst))
		{
			$bpoqty = $qtyrow["dblQty"];
			break;
		}
      echo $bpoqty; 
       
       ?></td>
    </tr>
	
	<?php
		
		}
	?>
  </table>
  
</div>