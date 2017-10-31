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

$SCNo = $_GET["scno"];

include "Connector.php";

#==============================================
# Add On - 11/09/2015
# Add By - Nalin Jayakody
# Add For - Get Shipped delivery information from D2D 
#==============================================
include "d2dConnector.php";

$dbD2D = new ClassConnectD2D();
#==============================================
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
  <table width="1009" border="0" align="left" bgcolor="" >
    <tr>
      <td><table width="1009" border="0">
          <tr>
            
            <td width="62%"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr class="cursercross" onmousedown="grab(document.getElementById('frmstylewise'),event);">
                  <td width="96%" height="23" bgcolor="#498CC2" class="TitleN2white"><div align="left">&nbsp;Style Buyer PO - Delivery Schedule </div></td>
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
                        <td width="25%" class="normalfnth2" style="text-align:left;"><?php echo $StyleName; ?><label id="lblStyleNo" style="visibility:hidden;"><?php echo $StyleNo; ?></label></td>
                        <td width="7%" class="normalfnt">&nbsp;</td>
                        <td width="2%" class="normalfnth2"><label></label></td>
                        <td width="15%" class="normalfnt">Order Qty</td>
                        <td width="34%" class="normalfnth2" align="left"><label id="lblTotalQty" ><?php echo $Qty; ?>

						</label></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td class="normalfnt">Excess Percentage </td>
                        <td class="normalfnth2" style="text-align:left;"><?php echo $excessPercentage; ?> % </td>
                        <td class="normalfnt">&nbsp;</td>
                        <td class="normalfnth2">&nbsp;</td>
                        <td class="normalfnt">Quantity With Excess </td>
                        <td class="normalfnth2" id="approvedQty" align="left"><?php echo $excessQuantity; ?></td>
                      </tr>
                  </table></td>
                </tr>
                
                <tr>
                  <td height="132" colspan="2">
				  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
				  		 <tr>
                        <td bgcolor="#9BBFDD">&nbsp;</td>
                        <td colspan="5" bgcolor="#9BBFDD"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td height="21" class="normalfnBLD1"><span style="font-size:12px; font-weight:bold;">New Buyer PO</span> </td>
                            </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td width="0%" height="24">&nbsp;</td>
                        <td width="15%" class="normalfnt">Buyer PO No</td>
                        <td width="30%" align="left"><input name="txtbuyerpo" type="text" class="txtbox" style="width:150px" id="txtbuyerpo" /><input type="reset" value=""  class="txtbox" style="visibility:hidden;"><input type="hidden" id="hndOldBuyerPo" name="hndOldBuyerPo" /></td>
                        <td width="16%" class="normalfnt">Country</td>
                        <td width="30%" align="left"><select name="cbocountry" class="txtbox" id="cbocountry" style="width:150px">
                          <?php
	
	$SQL = "select strCountryCode,intConID,strCountry from country where intStatus != 0;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
			echo "<option value=\"". $row["intConID"] ."\">" . $row["strCountry"] ."</option>" ;
	}
	
	?>
                                                  </select><input type="reset" value=""  class="txtbox" style="visibility:hidden;">                        </td>
                      <td width="9%">&nbsp;</td>                            
                      </tr>
                      <tr>
                        <td height="25">&nbsp;</td>
                        <td class="normalfnt">Previous Buyer PO</td>
                        <td align="left">
                          <select name="cboPreviousBPO" id="cboPreviousBPO" class="txtbox" style="width:150px">
                              <option value="-1"></option>
                            <?php

                                $sql = " SELECT DISTINCT deliveryschedule.intBPO, deliveryschedule.prvBPO  FROM deliveryschedule WHERE
                                          deliveryschedule.intStyleId =  '".$_GET["styleID"]."'";
                                $resBPO = $db->RunQuery($sql); 
                                while($row = mysql_fetch_array($resBPO))
                                {
                                    echo "<option value=\"". $row["prvBPO"] ."\">" . $row["prvBPO"] ."</option>" ;
                                }         
                            ?>
                          </select>
                        </td>
                        <td class="normalfnt">T&A </td>
                        <td align="left"><select name="select" class="txtbox" id="cboLeadTime" style="width:150px">
                                <option value=""></option>
                          <?php
  # ===================================================================
  # Add By - Nalin Jayakody
  # Add On - 06/21/2016
  # Add For - List down events in the lead times instead of lead times.
  # =================================================================== 
  //$SQL = "SELECT DISTINCT reaLeadTime,intSerialNO FROM eventtemplateheader WHERE intBuyerID = $BuyerID;";
  # ===================================================================
                          
  $SQL = " SELECT DISTINCT events.strDescription, events.intEventID
           FROM events Inner Join eventtemplateheader ON events.intEventID = eventtemplateheader.intSerialNO
           WHERE eventtemplateheader.intBuyerID =  $BuyerID" ;                       
  $result = $db->RunQuery($SQL);
  
  
  
  while($row = mysql_fetch_array($result))
  {
      echo "<option value=\"". $row["intEventID"] ."\">" . $row["strDescription"] ."</option>" ;
  }
  
  ?>
                        </select><input type="reset" value=""  class="txtbox" style="visibility:hidden;"></td>
                      </tr>
                      <tr>
                        <td height="25">&nbsp;</td>
                        <td class="normalfnt">Quantity</td>
                        <td align="left"><input name="txtqty" type="text" class="txtbox" id="txtqty" style="width:150px"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();"  onkeypress="return isNumberKey(event);" value="1"><input type="reset" value=""  class="txtbox" style="visibility:hidden;"></td>
                        <td class="normalfnt">Estimated  Date </td>
                        <td align="left"><input name="estimatedDD" type="text" class="txtbox" id="estimatedDD"  style="width:150px" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"></td>
                        
                      </tr>
                      <tr>
                        <td height="25">&nbsp;</td>
                        <td class="normalfnt">Shipping Mode </td>
                        <td align="left"><select name="cboShippingMode" id="cboShippingMode" class="txtbox" style="width:150px">
                          <?php
	
	$SQL ="SELECT intShipmentModeId,strDescription FROM shipmentmode s where intStatus=1;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
			echo "<option value=\"". $row["intShipmentModeId"] ."\">" . $row["strDescription"] ."</option>" ;
	}
	
	?>
                        </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td class="normalfnt">Hand Over Date</td>
                        <td align="left"><input name="handoverDD" type="text" class="txtbox" id="handoverDD"  style="width:150px" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"></td>
                      </tr>
                      <tr>
                        <td height="25">&nbsp;</td>
                        <td class="normalfnt">Delivery Status </td>
                        <td align="left"><select id="cmbDeliveryStatus" class="txtbox" style="width:150px">
                        		<option value="-1"></option>
                                <option value="1">CONFIRMED</option>
                                <option value="2">BLOCKED</option>
                        	</select>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="hidden" id="hndShipStatus" name="hndShipStatus" /></td>
                        <td class="normalfnt">Delivery Date</td>
                        <td align="left"><input name="deliverydateDD" type="text" class="txtbox" id="deliverydateDD"  style="width:150px" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"></td>
                      </tr>
                      <tr>
                      	<td height="30">&nbsp;</td>
                        <td class="normalfnt">Cut off Date</td>
                        <td align="left"><input name="dtCutOff" type="text" class="txtbox" id="dtCutOff"  style="width:150px" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"></td>
                        <td class="normalfnt">Short Ship Reason</td>
                        <td align="left"><select name="cboShortShipReason" id="cboShortShipReason" class="txtbox" style="width:150px">
                            <option value="-1"></option>    
                            <?php
                                    $sql = "SELECT * FROM short_ship_reason";
                                    
                                    $resShortShip = $db->RunQuery($sql);
                                    
                                    while($row = mysql_fetch_array($resShortShip))
                                    {
                                       echo "<option value=\"". $row["reasonId"] ."\">" . $row["ShortShipReason"] ."</option>" ;
                                    }
                                
                                ?>
                            </select>    
                        </td>
                      </tr>
                      <tr>
                      	<td height="30">&nbsp;</td>
                        <td class="normalfnt">Production Location</td>
                        <td colspan="3" align="left">
                        	<select id="cmbProductionLocation" class="txtbox" style="width:300px">   
                            	<option value="-1"></option>                         
                            	<?php
	
									$SQL ="SELECT intCompanyID,strName FROM companies s where intStatus=1 AND intManufacturing = 1;";	
									$result = $db->RunQuery($SQL);
									
									while($row = mysql_fetch_array($result))
									{
											echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
									}
								
								?>
                        		
                        	</select>&nbsp;&nbsp;
                            <input type="checkbox" id="chkForAll" name="chlForAll" /> <span class="normalfnt">Apply for all deliveries</span>
                            &nbsp;&nbsp;
                            <input type="hidden" id="hndShipStatus" name="hndShipStatus" />&nbsp;&nbsp;
                            <input type="checkbox" id="chkShortShipped" name="chkShortShipped" /> <span class="normalfnt">Delivery Completed</span>
                        </td>
                      </tr>
                      <tr>
                        <td height="35">&nbsp;</td>
                        <td valign="top" class="normalfnt">Remarks</td>
                        <td colspan="3" align="left"><textarea name="txtremarks" cols="70" style="width:442px" rows="2" class="txtbox" id="txtremarks"></textarea>
                        <img src="images/addsmall.png" alt="Add" width="95" height="24" class="mouseover" onclick="addBPOToGrid();" /></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td colspan="2"><table width="100%" border="0" class="bcgl1" height="200">
                     <tr bgcolor="#9BBFDD">
                              <td height="21" class="normalfnBLD1" colspan="3" >Buyer PO Allocation </td>
                      </tr>
                      <tr>
                        <td colspan="3" valign="top">
                        	<div id="divcons" style="table-layout:fixed; height:260px; width:992px; margin:1; padding: 1; border-collapse:collapse; overflow:hidden; border:1px solid #000;">
                            <table id="BuyerPO1"  style="width:960px; margin:1; padding:1; border-collapse:collapse; table-layout:fixed;" cellpadding="0" cellspacing="1" bgcolor="">
                            	<colgroup>
                                  <col width="20px" />
                                  <col width="95px" />
                                  <col width="57px" />
                                  <col width="70px" />
                                  <col width="35px" />
                                  <col width="78px" />
                                  <col width="78px" />
                                  <col width="75px" />
                                  <col width="53px" />
                                  <col width="68px" />
                                  <col width="73px" />
                                  <col width="74px" />
                                  <col width="70px" />
                                  <col width="70px" />
                                  <col width="60px" />
                                  <col width="0px" />
                                  <col width="0px" />
                                </colgroup>
                                <tbody>
                                  <tr>
                                    <td width="" height="33" bgcolor="#498CC2" class="normaltxtmidb2" style="width:20px; border: 1px solid #CCC;">No</td>
                                    <td width="" bgcolor="#498CC2" class="normaltxtmidb2L" style="width:95px; word-wrap:break-word; border: 1px solid #CCC;">Buyer PO No</td>
                                    <td width="" bgcolor="#498CC2" class="normaltxtmidb2R" style="width:57px; border: 1px solid #CCC;">Quantity</td>
                                    <td width="%" bgcolor="#498CC2" class="normaltxtmidb2" style="width:70px; border: 1px solid #CCC;">Country</td>
                                    <td width="" bgcolor="#498CC2" class="normaltxtmidb2L" style="width:35px; border: 1px solid #CCC;">T&A</td>
                                    <td width="" bgcolor="#498CC2" class="normaltxtmidb2L" style="width:78px; border: 1px solid #CCC;">Delivery Date </td>
                                    <td width="" bgcolor="#498CC2" class="normaltxtmidb2L" style="width:78px; border: 1px solid #CCC;">Estimated Date </td>
                                    <td width="" bgcolor="#498CC2" class="normaltxtmidb2L" style="width:75px; word-wrap:break-word; border: 1px solid #CCC;">Hand Over Date </td>
                                    <td width="" bgcolor="#498CC2" class="normaltxtmidb2L" style="width:53px; word-wrap:break-word; border: 1px solid #CCC;">Shipping Mode </td>
                                    <td width="" bgcolor="#498CC2" class="normaltxtmidb2L" style="width:68px; border: 1px solid #CCC;">Remarks</td>
                                    <td width="" bgcolor="#498CC2" class="normaltxtmidb2L" style="width:73px; border: 1px solid #CCC;">Status</td>
                                    <td width="" bgcolor="#498CC2" class="normaltxtmidb2L" style="width:74px; border: 1px solid #CCC;">Cut Off Date</td>
                                    <td width="" bgcolor="#498CC2" class="normaltxtmidb2L" style="width:70px; border: 1px solid #CCC;">Shipped Status</td>
                                    <td width="" bgcolor="#498CC2" class="normaltxtmidb2L" style="width:70px; border: 1px solid #CCC;">Production Location</td>
                                    <td width="" bgcolor="#498CC2" class="normaltxtmidb2L" style="width:60px; border: 1px solid #CCC;">Previous BPO</td>
                                    <td width="" bgcolor="#498CC2" class="normaltxtmidb2L" style="width:0px; display:none; border: 1px solid #CCC;">&nbsp;</td>
                                    <td width="" bgcolor="#498CC2" class="normaltxtmidb2L" style="width:0px; display:none; border: 1px solid #CCC;">&nbsp;</td>
                                    
                                  </tr>
                                 <tbody> 
                             </table> 
                             <div id="divcons" style=" overflow-y:auto; height:220px; width:994px; border-collapse:collapse; margin:0; padding:2;">
                             <table id="BuyerPO" cellpadding="0" cellspacing="2" bgcolor="" style="margin: 0; padding: 2; border-collapse: collapse; width:910px; table-layout:fixed;">
                             	<colgroup>
                                  <col width="20px" />
                                  <col width="95px" />
                                  <col width="57px" />
                                  <col width="70px" />
                                  <col width="35px" />
                                  <col width="78px" />
                                  <col width="78px" />
                                  <col width="75px" />
                                  <col width="53px" />
                                  <col width="68px" />
                                  <col width="73px" />
                                  <col width="74px" />
                                  <col width="70px" />
                                  <col width="70px" />
                                  <col width="60px" />
                                  <col width="0px" />
                                  <col width="0px" />
                                </colgroup> 
                                <tbody>
                              <?php
                              
                              $totalQty = 0;
#=========================================================================
# Comment On - 03/31/2015
# Description - Remove 'style_buyerpo' table from the query
# Comment By - Nain Jayakody
#=========================================================================    
                       
/*                            $sql = "
SELECT bpodelschedule.intStyleId,  DATE_FORMAT(bpodelschedule.dtDateofDelivery, '%d/%m/%Y') as dtDateofDelivery ,style_buyerponos.strBuyerPoName, bpodelschedule.strBuyerPONO, bpodelschedule.intQty, bpodelschedule.strRemarks,
style_buyerponos.strCountryCode, country.strCountry, DATE_FORMAT(deliveryschedule.estimatedDate, '%d/%m/%Y') as estimatedDate,
DATE_FORMAT(deliveryschedule.dtmHandOverDate, '%d/%m/%Y') as handoverDate, deliveryschedule.strShippingMode, shipmentmode.strDescription,
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
bpodelschedule.strBuyerPONO order by bpodelschedule.dtDateofDelivery, style_buyerponos.strBuyerPoName
";*/
#======================================================================================
#===================================================#
 /* Change On - 11/25/2014 
    Description - List delivery details by accending 
                  order of delivery date instead of  
				  buyer po number. Therefore added 
				  'bpodelschedule.dtDateofDelivery' to 
				  the 'order by' clause in above query.
 */              

#===================================================#
                              
# ==============================================================
# Change On - 06/21/2016
# Change By - Nalin Jayakody
# Change For - To add event header list to the delivery schedule details
# ==============================================================                              

/*$sql = " SELECT bpodelschedule.intStyleId,  DATE_FORMAT(bpodelschedule.dtDateofDelivery, '%d/%m/%Y') as dtDateofDelivery , bpodelschedule.strBuyerPONO, bpodelschedule.intQty, bpodelschedule.strRemarks, country.strCountry, DATE_FORMAT(deliveryschedule.estimatedDate, '%d/%m/%Y') as estimatedDate, DATE_FORMAT(deliveryschedule.dtmHandOverDate, '%d/%m/%Y') as handoverDate, deliveryschedule.strShippingMode, shipmentmode.strDescription, deliveryschedule.intSerialNO, eventtemplateheader.reaLeadTime,country.intConID, DATE_FORMAT(deliveryschedule.dtmCutOffDate, '%d/%m/%Y') as cutOffDate, deliveryschedule.intDeliveryStatus, companies.strName, companies.intCompanyID, deliveryschedule.intShortShipped, deliveryschedule.prvBPO
FROM bpodelschedule Inner Join deliveryschedule ON bpodelschedule.intStyleId = deliveryschedule.intStyleId AND deliveryschedule.intBPO = bpodelschedule.strBuyerPONO Inner Join country ON deliveryschedule.intCountry = country.intConID
Inner Join shipmentmode ON deliveryschedule.strShippingMode = shipmentmode.intShipmentModeId
Left Join eventtemplateheader ON deliveryschedule.intSerialNO = eventtemplateheader.intSerialNO
Left Join companies ON deliveryschedule.intManufacturingLocation = companies.intCompanyID
WHERE bpodelschedule.intStyleId =  '$StyleNo' GROUP BY
bpodelschedule.intStyleId,
bpodelschedule.dtDateofDelivery,
bpodelschedule.strBuyerPONO order by bpodelschedule.dtDateofDelivery,  bpodelschedule.strBuyerPONO";*/
                              
$sql = " SELECT bpodelschedule.intStyleId, DATE_FORMAT(bpodelschedule.dtDateofDelivery,'%d/%m/%Y') AS dtDateofDelivery,
                bpodelschedule.strBuyerPONO, bpodelschedule.intQty, bpodelschedule.strRemarks, country.strCountry, DATE_FORMAT(deliveryschedule.estimatedDate,'%d/%m/%Y') AS estimatedDate,
                DATE_FORMAT(deliveryschedule.dtmHandOverDate,'%d/%m/%Y') AS handoverDate, deliveryschedule.strShippingMode, shipmentmode.strDescription,
                deliveryschedule.intSerialNO, country.intConID, DATE_FORMAT(deliveryschedule.dtmCutOffDate,'%d/%m/%Y') AS cutOffDate,
                deliveryschedule.intDeliveryStatus, companies.strName, companies.intCompanyID, deliveryschedule.intShortShipped,
                deliveryschedule.prvBPO, events.strDescription as LeadTime, deliveryschedule.shortShipId
         FROM  bpodelschedule Inner Join deliveryschedule ON bpodelschedule.intStyleId = deliveryschedule.intStyleId AND deliveryschedule.intBPO = bpodelschedule.strBuyerPONO
               Inner Join country ON deliveryschedule.intCountry = country.intConID Inner Join shipmentmode ON deliveryschedule.strShippingMode = shipmentmode.intShipmentModeId
               Left Join companies ON deliveryschedule.intManufacturingLocation = companies.intCompanyID Left Join events ON deliveryschedule.intSerialNO = events.intEventID
         WHERE bpodelschedule.intStyleId =  '$StyleNo'
         GROUP BY bpodelschedule.intStyleId, bpodelschedule.dtDateofDelivery, bpodelschedule.strBuyerPONO
         order by bpodelschedule.dtDateofDelivery,  bpodelschedule.strBuyerPONO ";                              

$result = $db->RunQuery($sql);
	
	while($row = mysql_fetch_array($result))
	{
				$totalQty += $row["intQty"];
				
				$intShippedQty = 0;
				
				$strBuyerPONo     = $row["strBuyerPONO"];
				$strManuLocation  = substr($row["strName"], strpos($row["strName"],"-")+1);
        $iShortShipped    = $row["intShortShipped"];
        //$prvBPO           = $row["prvBPO"];

        if(is_null($row["prvBPO"])){
          $prvBPO = $strBuyerPONo;
        }else{
          $prvBPO = $row["prvBPO"];
        }
				 
				
				$sqlD2D = " SELECT Sum(d2d_Pack_Export_Details.transferOutQty) AS Shipped_Qty 
							FROM d2d_Pack_Export_Header Inner Join d2d_Pack_Export_Details ON d2d_Pack_Export_Header.aodNo = d2d_Pack_Export_Details.serial AND d2d_Pack_Export_Header.location = d2d_Pack_Export_Details.locationId AND d2d_Pack_Export_Header.scNumber = d2d_Pack_Export_Details.scNumber
							WHERE d2d_Pack_Export_Header.scNumber =  '$SCNo' AND d2d_Pack_Export_Header.bpo =  '$strBuyerPONo' AND d2d_Pack_Export_Header.`status` =  'SEND'";
				
				$resD2D	= $dbD2D->RunQuery($sqlD2D);
				
				while($rowD2D = mysql_fetch_array($resD2D)){
					$intShippedQty = $rowD2D["Shipped_Qty"];
					
					
				}
				
				$dblShippedPer = CalShippedPercentage($row["intQty"], $intShippedQty);

                        if($iShortShipped == '1'){
                      ?>
                          <tr bgcolor="#ffb366" >

                      <?php

                        }else{

                      ?>
                        <tr <?php if($dblShippedPer>=95){ ?> bgcolor="#00CC33"  <?php }else{ ?> bgcolor="#FFFFFF" <?php } ?>>

                      <?php      

                        }
                              
                            ?>
                        


                       

                       <td style="width:20px; border: 1px solid #CCC;"><img src="images/del.png" alt="del" width="15" height="15" border="0" class="mouseover" onclick="RemovePONumberFromGrid(this);" /></td>
					   <!--<td class="normalfntMid"><?php echo ++$i;?></td>-->
                       <td style="width:95px; overflow:hidden; text-overflow:ellipsis;  border: 1px solid #CCC;" class="normalfnt" ondblclick="changeToTextBoxBPO(this);" id="<?php echo $strBuyerPONo;?>"><?php echo $strBuyerPONo;  ?></td>
                       <td style="width:57px; border: 1px solid #CCC;" class="normalfntRite" ondblclick="changeToTextBoxBPO(this);"><?php echo $row["intQty"];  ?></td>
                       <td style="width:70px; border: 1px solid #CCC;" class="normalfntMid" id="<?php echo $row["intConID"];  ?>"><?php echo $row["strCountry"];  ?></td>
                       <td style="width:35px; border: 1px solid #CCC;" class="normalfnt" id="<?php echo $row["intSerialNO"];  ?>"><?php echo $row["LeadTime"];  ?></td>
                       <td style="width:78px; border: 1px solid #CCC;" class="normalfnt"><?php echo $row["dtDateofDelivery"];  ?></td>
                       <td style="width:78px; border: 1px solid #CCC;" class="normalfnt"><?php echo $row["estimatedDate"];  ?></td>
                       <td style="width:75px; word-wrap:break-word; border: 1px solid #CCC;" class="normalfnt"><?php echo $row["handoverDate"];  ?></td>
                       <td style="width:53px; border: 1px solid #CCC;" class="normalfnt" id="<?php echo $row["strShippingMode"];  ?>"><?php echo $row["strDescription"];  ?></td>
                       <td style="width:68px; border: 1px solid #CCC; word-wrap:break-word;" class="normalfnt"><?php echo $row["strRemarks"];  ?></td>
                       <td style="width:73px; border: 1px solid #CCC;" class="normalfntBPO" id="<?php echo $row["intDeliveryStatus"];  ?>"><?php echo GetDeliveryStatus($row["intDeliveryStatus"]); ?></td>       
                       <td style="width:74px; border: 1px solid #CCC;" class="normalfnt"><?php echo $row["cutOffDate"];  ?></td>
                       <td style="width:70px; border: 1px solid #CCC;" class="normalfnt"><?php if($dblShippedPer>=95){ echo "Completed";} ?></td>
                       <td style="width:70px; border: 1px solid #CCC; word-wrap:break-word;" class="normalfnt" id="<?php echo $row["intCompanyID"];?>"><?php echo $strManuLocation;  ?> </td>
                       <td style="width:50px; border: 1px solid #CCC;" class="normalfnt"><?php echo $prvBPO;  ?></td>
                       <td style="width:0px; display:none; border: 1px solid #CCC;" class="normalfnt"><?php echo $iShortShipped;  ?></td>
                       <td style="width:0px; display:none; border: 1px solid #CCC;" class="normalfnt"><?php echo $row["shortShipId"];  ?></td>
                            
                       		  
                       </tr>
                              <?php 
                              }
                              
                              ?>
                              </tbody>
                            </table>
                        </div></td>
                      </tr>
                      
                      <tr>
                        <td width="68%">&nbsp;</td>
                        <td width="12%" class="normalfnt">Total Qty</td>
                        <td width="20%"><input name="txttotalqty" type="text" class="txtbox" id="txttotalqty" disabled="disabled" size="20" value="<?php echo $totalQty ; ?>"  /></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="28%" bgcolor="#D6E7F5">&nbsp;</td>
                      <td width="27%" bgcolor="#D6E7F5">&nbsp;</td>
                      <td width="33%" bgcolor="#D6E7F5">&nbsp;</td>
                       <td width="12%" bgcolor="#D6E7F5"><img src="images/upload.jpg" alt="Save" width="84" height="24" border="0" class="mouseover" onclick="uploadBuyerPO('<?php echo  $StyleNo ?> ','<?php echo $Qty; ?> ');" /></td>
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

<?php 

function GetDeliveryStatus($prmDeliveryStatus){
	
	$strDelivertStatus = '';
	
	switch($prmDeliveryStatus){
		
		case "1":
			$strDelivertStatus  = "CONFIRMED";
			break;	
			
		case "2":
			$strDelivertStatus  = "BLOCKED";
			break;	
		
	}
	
	return $strDelivertStatus;
}

function CalShippedPercentage($bpoQty, $bpoShippedQty){
	
	
	
	$dblShippedQty = ($bpoShippedQty/$bpoQty)*100;
	
	return $dblShippedQty;
	
}

?>