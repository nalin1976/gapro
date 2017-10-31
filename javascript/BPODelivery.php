<?php
 session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Style Wise Buyer PO Numbers</title>
<script type="text/javascript" src="javascript/aprovedPreoder.js"></script>
<script type="text/javascript" src="javascript/script.js"></script>
<script type="text/javascript" src="javascript/bom.js"></script>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}

-->
</style>
</head>
<?php

include "Connector.php";

//$SQL = "select specification.intSRNO,specification.intStyleId,specification.dblQuantity from specification where intStyleId  = '" . $_GET["styleID"]. "';";

$SQL = "select intStyleId,intQty,reaExPercentage,intBuyerID,strStyle from orders where intStyleId = '" . $_GET["styleID"]. "';";
	//echo $SQL;
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		$StyleNo =  $row["intStyleId"];
		$StyleName =  $row["strStyle"];
		$Qty =  $row["intQty"];
		$excessPercentage =  $row["reaExPercentage"];
		$excessQuantity = round($Qty + ($Qty * $excessPercentage / 100));
		$BuyerID = $row["intBuyerID"];
	}
?>

<body>
<form name="frmstylewise" id="frmstylewise">	
  <table width="795" border="0" align="left" bgcolor="#FFFFFF">
    <tr>
      <td><table width="791" border="0">
          <tr>
            
            <td width="62%"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr class="cursercross" onmousedown="grab(document.getElementById('frmstylewise'),event);">
                  <td width="96%" height="23" bgcolor="#498CC2" class="TitleN2white"><div align="left">Style Buyer PO - Delivery Schedule </div></td>
                  <td width="4%" bgcolor="#498CC2" class="TitleN2white"><img src="images/cross.png" class="mouseover" width="17" height="17" onClick="closeWindow('popupLayer1');<?php 
                  
                  if ($_GET["Type"] == "P")
                  {
                  	echo "reloadDeliverySchedue();";
                  }
					                  
                     ?>" /></td>
                </tr>
                <tr class="bcgl1">
                  <td colspan="2"><table width="100%" border="0" class="bcgl1">
                      <tr>
                        <td width="2%">&nbsp;</td>
                        <td width="15%" class="normalfnt">Style No</td>
                        <td width="33%" class="normalfnth2" style="text-align:left;"><?php echo $StyleName; ?><label id="lblStyleNo" style="visibility:hidden;"><?php echo $StyleNo; ?></label></td>
                        <td width="1%" class="normalfnt">&nbsp;</td>
                        <td width="8%" class="normalfnth2"><label></label></td>
                        <td width="25%" class="normalfnt">Order Qty</td>
                        <td width="16%" class="normalfnth2"><label id="lblTotalQty" ><?php echo $Qty; ?>

						</label></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td class="normalfnt">Excess Percentage </td>
                        <td class="normalfnth2" style="text-align:left;"><?php echo $excessPercentage; ?> % </td>
                        <td class="normalfnt">&nbsp;</td>
                        <td class="normalfnth2">&nbsp;</td>
                        <td class="normalfnt">Quantity With Excess </td>
                        <td class="normalfnth2" id="approvedQty"><?php echo $excessQuantity; ?></td>
                      </tr>
                  </table></td>
                </tr>
                
                <tr>
                  <td height="142" colspan="2">
				  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
				  		 <tr>
                        <td bgcolor="#9BBFDD">&nbsp;</td>
                        <td colspan="4" bgcolor="#9BBFDD"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td height="21" class="normalfnBLD1">New Buyer PO </td>
                            </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td width="1%" height="24">&nbsp;</td>
                        <td width="20%" class="normalfnt">Buyer PO No</td>
                        <td width="30%"><input name="txtbuyerpo" type="text" class="txtbox" style="width:150px" id="txtbuyerpo" /></td>
                        <td width="25%" class="normalfnt">Country</td>
                        <td width="24%"><select name="cbocountry" class="txtbox" id="cbocountry" style="width:150px">
                          <?php
	
	$SQL = "select strCountryCode,intConID,strCountry from country where intStatus != 0;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
			echo "<option value=\"". $row["intConID"] ."\">" . $row["strCountry"] ."</option>" ;
	}
	
	?>
                                                  </select>                        </td>
                      </tr>
                      <tr>
                        <td height="25">&nbsp;</td>
                        <td class="normalfnt">Quantity</td>
                        <td><input name="txtqty" type="text" class="txtbox" id="txtqty" style="width:150px"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();"  onkeypress="return isNumberKey(event);" value="1"></td>
                        <td class="normalfnt">Lead Time </td>
                        <td><select name="select" class="txtbox" id="cboLeadTime" style="width:150px">
                          <?php
	
	$SQL = "SELECT DISTINCT reaLeadTime,intSerialNO FROM eventtemplateheader WHERE intBuyerID = $BuyerID;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
			echo "<option value=\"". $row["intSerialNO"] ."\">" . $row["reaLeadTime"] ."</option>" ;
	}
	
	?>
                        </select></td>
                      </tr>
                      <tr>
                        <td height="25">&nbsp;</td>
                        <td class="normalfnt">Delivery Date </td>
                        <td><input type="reset" value=""  class="txtbox" style="visibility:hidden;"><input name="deliverydateDD" type="text" class="txtbox" id="deliverydateDD"  style="width:150px" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"></td>
                        <td class="normalfnt">Estimated  Date </td>
                        <td><input type="reset" value=""  class="txtbox" style="visibility:hidden;"><input name="estimatedDD" type="text" class="txtbox" id="estimatedDD"  style="width:150px" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"></td>
                      </tr>
                      <tr>
                        <td height="25">&nbsp;</td>
                        <td class="normalfnt">Shipping Mode </td>
                        <td><select name="cboShippingMode" id="cboShippingMode" class="txtbox" style="width:150px">
                          <?php
	
	$SQL ="SELECT intShipmentModeId,strDescription FROM shipmentmode s where intStatus=1;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
			echo "<option value=\"". $row["intShipmentModeId"] ."\">" . $row["strDescription"] ."</option>" ;
	}
	
	?>
                        </select></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td height="25">&nbsp;</td>
                        <td valign="top" class="normalfnt">Remarks</td>
                        <td colspan="3"><textarea name="txtremarks" cols="70" style="width:442px" rows="2" class="txtbox" id="txtremarks"></textarea>
                        <img src="images/addsmall.png" alt="Add" width="95" height="24" class="mouseover" onclick="addBPOToGrid();" /></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td colspan="2"><table width="100%" border="0" class="bcgl1">
                     <tr bgcolor="#9BBFDD">
                              <td height="21" class="normalfnBLD1" colspan="3" >Buyer PO Allocation </td>
                      </tr>
                      <tr>
                        <td colspan="3"><div id="divcons" style="overflow:scroll; height:160px; width:800px;">
                            <table id="BuyerPO" width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
                              <tr>
                                <td width="5%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">No</td>
                                <td width="15%" bgcolor="#498CC2" class="normaltxtmidb2L">Buyer PO No</td>
                                <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2R">Quantity</td>
                                <td width="20%" bgcolor="#498CC2" class="normaltxtmidb2">Country</td>
                                <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2L">Lead Time</td>
                                <td width="13%" bgcolor="#498CC2" class="normaltxtmidb2L">Delivery Date </td>
                                <td width="13%" bgcolor="#498CC2" class="normaltxtmidb2L">Estimated Date </td>
                                <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2L">Shipping Mode </td>
                                <td width="14%" bgcolor="#498CC2" class="normaltxtmidb2L">Remarks</td>
                              </tr>
                              <?php
                              
                              $totalQty = 0;
                              
                            $sql = "
SELECT bpodelschedule.intStyleId,  DATE_FORMAT(bpodelschedule.dtDateofDelivery, '%d/%m/%Y') as dtDateofDelivery ,style_buyerponos.strBuyerPoName, bpodelschedule.strBuyerPONO, bpodelschedule.intQty, bpodelschedule.strRemarks,
style_buyerponos.strCountryCode, country.strCountry, DATE_FORMAT(deliveryschedule.estimatedDate, '%d/%m/%Y') as estimatedDate, deliveryschedule.strShippingMode, shipmentmode.strDescription,
deliveryschedule.intSerialNO, eventtemplateheader.reaLeadTime,country.intConID
FROM
bpodelschedule
Inner Join style_buyerponos ON bpodelschedule.intStyleId = style_buyerponos.intStyleId AND bpodelschedule.strBuyerPONO = style_buyerponos.strBuyerPoName
Inner Join country ON style_buyerponos.strCountryCode = country.intConID
Inner Join deliveryschedule ON bpodelschedule.intStyleId = deliveryschedule.intStyleId AND deliveryschedule.intBPO = style_buyerponos.strBuyerPoName
Inner Join shipmentmode ON deliveryschedule.strShippingMode = shipmentmode.intShipmentModeId
Left Join eventtemplateheader ON deliveryschedule.intSerialNO = eventtemplateheader.intSerialNO
WHERE bpodelschedule.intStyleId =  '$StyleNo' GROUP BY
bpodelschedule.intStyleId,
bpodelschedule.dtDateofDelivery,
bpodelschedule.strBuyerPONO order by style_buyerponos.strBuyerPoName
";
$result = $db->RunQuery($sql);
	
	while($row = mysql_fetch_array($result))
	{
				$totalQty += $row["intQty"];
                              
                              ?>
                               <tr bgcolor="#FFFFFF">
                                <td><img src="images/del.png" alt="del" width="15" height="15" border="0" class="mouseover" onclick="RemovePONumberFromGrid(this);" /></td>
	<!--<td class="normalfntMid"><?php echo ++$i;?></td>-->
                       <td class="normalfnt" ondblclick="changeToTextBoxBPO(this);" id="<?php echo $row["strBuyerPONO"];?>"><?php echo $row["strBuyerPONO"];  ?></td>
                       <td class="normalfntRite" ondblclick="changeToTextBoxBPO(this);"><?php echo $row["intQty"];  ?></td>
                       <td class="normalfntMid" id="<?php echo $row["intConID"];  ?>"><?php echo $row["strCountry"];  ?></td>
                       <td class="normalfnt" id="<?php echo $row["intSerialNO"];  ?>"><?php echo $row["reaLeadTime"];  ?></td>
                       <td class="normalfnt"><?php echo $row["dtDateofDelivery"];  ?></td>
                       <td class="normalfnt"><?php echo $row["estimatedDate"];  ?></td>
                       <td class="normalfnt" id="<?php echo $row["strShippingMode"];  ?>"><?php echo $row["strDescription"];  ?></td>
                       <td class="normalfnt" NOWRAP><?php echo $row["strRemarks"];  ?></td>
                              </tr>
                              <?php 
                              }
                              
                              ?>
                            </table>
                        </div></td>
                      </tr>
                      <tr>
                        <td width="61%">&nbsp;</td>
                        <td width="13%" class="normalfnt">Total Qty</td>
                        <td width="26%"><input name="txttotalqty" type="text" class="txtbox" id="txttotalqty" disabled="disabled" size="20" value="<?php echo $totalQty ; ?>"  /></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="28%" bgcolor="#D6E7F5">&nbsp;</td>
                      <td width="27%" bgcolor="#D6E7F5">&nbsp;</td>
                      <td width="33%" bgcolor="#D6E7F5">&nbsp;</td>
                      <td width="12%" bgcolor="#D6E7F5"><img src="images/save.png" alt="Save" width="84" height="24" border="0" class="mouseover" onclick="saveDelBPO();" /></td>
                    </tr>
                  </table></td>
                </tr>
            </table></td>

          </tr>
      </table></td>
    </tr>
  </table>
</form>

</body>
</html>

