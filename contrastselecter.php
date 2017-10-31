<?php
session_start();
include "Connector.php";
$styleID = $_GET["styleID"];
$materialID = $_GET["itemCode"];

?>

<html>
<head>
	<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="javascript/script.js"></script>
</head>
<body style="background-color:#D6E7F5;">
	<table width="650" border="0"  bgcolor="#D6E7F5">
		<tr class="cursercross" onMouseDown="grab(document.getElementById('frmContrast'),event);">		
			<td colspan="4">
				<table width="100%" border="0" cellspacing="0" cellpadding="2">
					<tr bgcolor="#498CC2" class="TitleN2white">
						<td>Contrast - <?php
						$consumption = 0;
							$sql = "SELECT specificationdetails.sngConPc , matitemlist.strItemDescription
FROM specificationdetails 
INNER JOIN matitemlist ON specificationdetails.strMatDetailID = matitemlist.intItemSerial
WHERE specificationdetails.intStyleId = '$styleID' AND specificationdetails.strMatDetailID = '$materialID' ";
							$result = $db->RunQuery($sql);
							while($row = mysql_fetch_array($result))
							{
								echo  $row["strItemDescription"];
								$consumption = $row["sngConPc"];
								break;
							}
							
						?></td>		
						<td style="text-align:right;"><img src="images/cross.png" class="mouseover" onClick="closeWindow();" ></td>			
					</tr>
				</table>			
			</td>		
		</tr>	
		<tr>
			<td width="15%" height="30" class="normalfnt">Style : </td>	
			<td width="35%" class="normalfnt"><?php echo $styleID; ?></td>	
			<td width="15%" class="normalfnt">Buyer PO : </td>	
			<td width="35%" class="normalfnt"><select class="txtbox" id="contrastBuyerPO" style="width:150px;" onChange="changeContrastBuyerPO();removeCurrentContrastTable();">
			 <option value="Select One" selected="selected">Select One</option>
			<?php
			$sql = "SELECT DISTINCT strBuyerPONO  FROM styleratio WHERE intStyleId = '$styleID';";
			$result = $db->RunQuery($sql);
			while($row = mysql_fetch_array($result))
			{
				echo "<option value=\"". $row["strBuyerPONO"] ."\">" . $row["strBuyerPONO"] ."</option>" ;
								
			}
			?>			
			</select></td>		
		</tr>
		<tr>
			<td height="30" class="normalfnt">Garment Color : </td>	
			<td class="normalfnt"><select class="txtbox" onChange="changeGarmentColor();" id="mainColor" style="width:150px;">		
			</select></td>	
			<td class="normalfnt">Qty : </td>	
			<td class="normalfnt" id="colorQty"></td>		
		</tr>
		<tr>
			<td height="30" class="normalfnt" id="<?php echo $materialID; ?>">Consumption : </td>	
			<td class="normalfnt" id="totalconsumption"><?php echo number_format($consumption,4); ?></td>	
			<td class="normalfnt"></td>	
			<td class="normalfnt"></td>		
		</tr>
		<tr>
      <td height="99" colspan="4" valign="top">
      <table  width="100%" cellpadding="0" cellspacing="0">
        <tr>
          <td height="20" bgcolor="#9BBFDD"><div align="left" class="normalfnth2">Contrast Colors</div></td>
          <td height="20" bgcolor="#9BBFDD"><div align="right"><img src="images/add-new.png" onClick="showContrastColor();" width="109" height="18" border="0" class="mouseover" /></div></td>
        </tr>
        </table>
        <div style="overflow:scroll; height:220px; width:650px;background-color:#FFFFFF;">
        <table id="tblContrast"  bgcolor="#CCCCFF" width="100%" cellpadding="0" cellspacing="1">
        <tr>
          <td width="70%" height="24" bgcolor="#498CC2" class="normaltxtmidb2">Color</td>
          <td bgcolor="#498CC2" class="normaltxtmidb2">Consumption</td>
        </tr>
       </div>
      </table></td>
    </tr>
    <tr>
			<td height="30" class="normalfnt"></td>	
			<td class="normalfnt"></td>	
			<td class="normalfnt"></td>	
			<td class="normalfnt"><div align="right">
			<table>
				<tr>
					<td><img src="images/save.png" class="mouseover" onClick="saveContrast();" ></td>
					<td><img src="images/cancel.jpg" class="mouseover" onClick="closeWindow();"></td>				
				</tr>			
			</table>	</div>		
			</td>		
		</tr>
	</table>
</body>
</html>