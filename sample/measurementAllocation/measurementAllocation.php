<?php
	session_start();
	include "../../Connector.php";
	$backwardseperator = "../../";
	
	$styleid = $_POST['orderNo'];
	$styleName = $_POST['txtStyle'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Measurement Allocation</title>
<link  href="../../css/erpstyle.css"  rel="stylesheet" type="text/css" />
<link  href="../../css/tableGrib.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="measurementAllocation-js.js"></script>
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/tablegrid.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>

<!--calendar-->
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script type="text/javascript" src="../../javascript/calendar/calendar.js" ></script>
<script type="text/javascript" src="../../javascript/calendar/calendar-en.js" ></script>
<script type="text/javascript" src="../../javascript/calendar/functions.js" ></script>
</head>
<body>
<form id="frmGrid" action="measurementAllocation.php" method="post">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include '../../Header.php'; ?></td>
	</tr> 
</table>
<div>
	<div align="center">
		<div class="trans_layoutL">
		<div class="trans_text">Measurement Allocation </div>
        
		 <table align="center" width="92%" height="50" border="0" class="bcgl1">
         	<tr>
            	<td>
          <table align="center" width="88%" border="0">
				<tr>
					<td width="16%" class="normalfnt"></td>
					<td width="8%" class="normalfnt">Style Id </td>
		  	  	  	<td width="30%" class="normalfnt">
						<select style="width: 152px;" class="txtbox" id="txtStyle" name="txtStyle" onchange="loadOrders();">
							
							<?php
								echo "<option></option>";
								$sql="SELECT DISTINCT OD.strStyle,OD.intStyleId
											 FROM orders OD
											 WHERE OD.intStatus = 11 ORDER BY OD.strStyle";
								
								$result=$db->RunQuery($sql);
								while($row = mysql_fetch_array($result))
								{
									if($styleName==$row["strStyle"])
									{
							?>
                            			<option selected value="<?php echo $row["strStyle"]; ?>"><?php echo $row["strStyle"]; ?></option>
                            <?php
									}
									else
									{
							?>
                            		<option value="<?php echo $row["strStyle"]; ?>"><?php echo $row["strStyle"]; ?></option>
                            			
                            <?php
									}
								}
							?>
						</select>
			  	  </td>
				  <td width="9%" class="normalfnt">Order No</td>
		  	  	  	<td width="37%" class="normalfnt">
						<select style="width: 152px;" class="txtbox" id="orderNo" name="orderNo" onchange="submitForm();">
                        <option></option>
						<?php 
						
							$SQLod = "SELECT intStyleId,strOrderNo FROM orders where strStyle='$styleName' ORDER BY strOrderNo";
							
							$resultod = $db->RunQuery($SQLod);
								while($rowod = mysql_fetch_array($resultod))
								{
									if($styleid==$rowod['intStyleId'])
									{
						?>
                        
                        	<option selected value="<?php echo $rowod['intStyleId']; ?>"><?php echo $rowod['strOrderNo']; ?></option>
						<?php
						
									}
									else
									{
						?>
										<option value="<?php echo $rowod['intStyleId']; ?>"><?php echo $rowod['strOrderNo']; ?></option>
						<?php
									}
								}
						?>	
				  		</select>
			  	  	</td>
				</tr>
		  </table>
          </td>
            </tr>
            </table>
		    <br /><table align="center" width="787" border="0">
					<tr>
						<td width="500"></td>
						<td width="287"><img src="../../images/size.jpg" align="right" onclick="selectSize();" /><img src="../../images/measure.jpg" align="right"  onclick="selectOperator();"/></td>
						
					<!--</tr>
						<tr>
						<td width="697"></td>
						<td width="80"><img src="../../images/measurementUnit.jpg" align="right"  onclick="selectOperator();"/></td>
					</tr>-->
		  </table>
			
			
            <table width="80%" border="0" class="bcgl1">
            <tr>
            <td>	
			<div style="overflow:scroll; height:350px; width:780px;">
                <table width="25%" id="dataGrid" style="vertical-align:top" cellpadding="0" cellspacing="0" bgcolor="#CCCCFF">
				<!--/*<table style="width:100%" class="transGrid" border="1" cellspacing="1" id="dataGrid">*/-->
					<?php
						$sqlCountCol = "SELECT COUNT(DISTINCT MA.strSize) AS cnt FROM
										measurement_allocation MA WHERE MA.intStyleNo=$styleid";
						$resultCountCol  = $db->RunQuery($sqlCountCol);
						$rowCountCol = mysql_fetch_array($resultCountCol);
					?>
						
                        <tr class="mainHeading2">
							<td class="normaltxtmidb2" colspan="<?php echo $rowCountCol['cnt']+3; ?>" >Sizes</td>
						</tr>
					
						<tr>
                        	<td width="10" class="grid_header" bgcolor="#804000"><img src="../../images/del.png" name="deleteBut" id="butDel" class="mouseover" onclick="deleteGridRow(this);" /></td>
							<td width="10" class="grid_header" bgcolor="#804000"><input disabled="disabled" type="text" class="normalfntMid" style="text-align:center; background-color:#FFF3CF" size="10" value="Mes: Id" /></td>
							<td width="20" class="grid_header" bgcolor="#804000"><input disabled="disabled" type="text" size="20" style="text-align:center; background-color:#FFF3CF" class="normalfntMid" value="Description" /></td>
                            
                            <?php
							
								$sqlSize = "SELECT DISTINCT MA.strSize FROM measurement_allocation MA WHERE 																																																																																														                                            MA.intStyleNo=$styleid";
								$resultSize = $db->RunQuery($sqlSize);
								
								while($rowSize = mysql_fetch_array($resultSize))
								{
								
							?>
                            	<td class="grid_header" bgcolor="#804000"><?php echo $rowSize['strSize']; ?></td>
                            <?php
								}
							?>   
						</tr>
                        
                        <?php
			
							$sqlLoad1 = "SELECT
										 DISTINCT MA.intMeasurementId,
										 MP.strDescription
										 FROM measurement_allocation MA
										 Inner Join measurementpoint  MP ON MA.intMeasurementId = MP.intId
										 WHERE MA.intStyleNo=$styleid";
					
							$resultLoad1 = $db->RunQuery($sqlLoad1);
			
							while($rowLoad1 = mysql_fetch_array($resultLoad1))
							{
			
						?>			
                        
                        	<tr>
                                <td width="10" class="grid_header" bgcolor="#804000"><img src="../../images/del.png" name="deleteBut" id="butDel" class="mouseover" onclick="deleteGridRow(this);" /></td>
                            	<td width="10%" class="grid_header"><?php echo $rowLoad1['intMeasurementId']; ?></td>
                                <td width="20%" class="grid_header"><?php echo $rowLoad1['strDescription']; ?></td>	
                               <?php
							    $mesID = $rowLoad1['intMeasurementId'];
                                $sqlMes = "SELECT
										   MA.dblMeasurement
										   FROM measurement_allocation MA
										   WHERE MA.intStyleNo=$styleid AND MA.intMeasurementId=$mesID";
								$resultMes = $db->RunQuery($sqlMes);
								
								while($rowMes = mysql_fetch_array($resultMes))
								{
								
								?>
                                
                                <td bgcolor="#fff3cf"><input type="text" size="7" style="text-align:right" value="<?php echo $rowMes['dblMeasurement'];?>"/></td>
                                
                                <?php
								}
							   	?>
                            </tr>
			
						<?php 
						
							}
						?>	
                        		
			  	</table>
			</div>
            </td>
            </tr>
            </table>
				<br />
				<br />
			<table align="center" width="367" border="0">
      			<tr>
					<td width="15%">&nbsp;</td>
					<td width="26%"><img src="../../images/new.png" width="90" id="butNew" onclick=  "clearForm();"/></td>
					<td width="23%"><img src="../../images/save.png" width="80" id="butSave" onclick="validateGridData();"/></td>
					<td width="26%"><a href="../../main.php"><img src="../../images/close.png" alt="close" width="90" border="0" /></a></td>
					<td width="10%">&nbsp;</td>
      			</tr>
		  </table>
		</div>
	</div>
</div>
</form>
</body>
</html>
