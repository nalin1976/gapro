<?php
	session_start();
	include("../../Connector.php");
	$backwardseperator = "../../";	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cost WorkSheet</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table align="center" width="900">
	<tr>
		<td class="normalfnt_Header">ORIT TRADING LANKA (PVT) LTD</td>
	</tr>
</table>
<table class="mainspace" align="center" width="900">
	<tr>
		<td class="normalfnt_SubHeader">Cost WorkSheet</td>
	</tr>
</table>
<table class="mainspace" id="tblreportGrid" cellspacing="1" align="center" width="900">
	<thead>
		<tr>
			<td colspan="7" class="normalfnt_Sub">SHIPMENT DETAILS</td>
		</tr>
	</thead>
	<tbody>
    <?php 
	
	$styleId = 14;
			$sql = "select o.strOrderNo,o.strStyle,o.strDescription,c.strName
			from orders o inner join companies c on 
			c.intCompanyID = o.intCompanyID
			where o.intStyleId=$styleId";
			
			$result = $db->RunQuery($sql);	
						while($row = mysql_fetch_array($result))
						{
			
	?>
		<tr>
			<td width="6"></td>
			<td width="251" class="normalfntb">FACTORY: </td>
			<td width="331" class="normalfnt"><?php echo $row["strName"]; ?></td>
			<td width="72" class="normalfntb">Date</td>
			<td width="222" colspan="2" class="normalfnt">0000-00-00</td>
		</tr>
		<tr>
			<td></td>
			<td class="normalfntb">STYLE NUMBER: </td>
			<td colspan="4" class="normalfnt"><?php echo $row["strStyle"]; ?></td>
		</tr>
		<tr>
			<td></td>
			<td class="normalfntb">LEVIS PURCHASE ORDER NUMBER: </td>
			<td colspan="4" class="normalfnt"><?php echo $row["strOrderNo"];  ?></td>
		</tr>
		<tr>
			<td></td>
			<td class="normalfntb">PRODUCT DESCRIPTION: </td>
			<td colspan="4" class="normalfnt"><?php echo $row["strDescription"]; ?></td>
		</tr>
        <?php 
		}
		?>
		<tr>
			<td></td>
			<td class="normalfntb">MANUFACTURED FOR: </td>
			<td colspan="4" class="normalfnt">**************</td>
		</tr>
		<tr>
			<td></td>
			<td class="normalfntb">FINAL DESTINATION: </td>
			<td colspan="4" class="normalfnt">**************</td>
		</tr>
		<tr>
			<td></td>
			<td class="normalfntb">NUMBER OF PRODUCTS: In PCS : </td>
			<td colspan="4" class="normalfnt">**************</td>
		</tr>
	</tbody>
</table>
<table class="mainspace" id="tblreportGrid" cellspacing="1" align="center" width="900">
	<thead>
		<tr>
			<td colspan="7" class="normalfnt_Sub">BREAKDOWN OF MANUFACTURING COSTS</td>
		</tr>
		<tr>
			<td colspan="2">Costs of Assists</td>
			<td width="63">Unit</td>
			<td width="83">Unit Price for Assist in USD ($)</td>
			<td width="111">Quantity Consumed Per Product Unit of Measure:</td>
			<td width="111">Unit Price X Qty Consumed = Per Product Cost in USD</td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="7" class="normalfnt_tr">Material</td>
		</tr>
		<tr>
         <?php
		 $totValue=0;
		 $subtotValue=0; 
				$sqlMat = "select mil.strItemDescription,mil.strUnit,fcd.dblUnitPrice,fcd.reaConPc,fcd.dblValue
from matitemlist mil inner join firstsalecostworksheetdetail fcd on 
mil.intItemSerial = fcd.intMatDetailID
where fcd.intStyleId=$styleId and strType=1";

			$resultM = $db->RunQuery($sqlMat);	
						while($rowM = mysql_fetch_array($resultM))
						{
			?>
			<td width="4"></td>
           
			<td width="507" class="normalfnt"><?php echo $rowM["strItemDescription"]; ?></td>
			<td width="63" class="normalfntR"><?php echo $rowM["strUnit"]; ?></td>
			<td width="83" class="normalfntR"><?php echo number_format($rowM["dblUnitPrice"],4); ?></td>
			<td width="111" class="normalfntR"><?php echo number_format($rowM["reaConPc"],4); ?></td>
			<td width="111" class="normalfntR">$<?php echo number_format($rowM["dblValue"],4);
			$totValue += $rowM["dblValue"];
			$subtotValue += $rowM["dblValue"];
			 ?></td>
		</tr>
        <?php 
			}
		?>
		<!--<tr>
			<td width="4"></td>
			<td width="507" class="normalfnt">**************</td>
			<td width="63" class="normalfntR">Yds</td>
			<td width="83" class="normalfntR">0.00</td>
			<td width="111" class="normalfntR">0.00</td>
			<td width="111" class="normalfntR">0.00</td>
		</tr>-->
		<tr>
			<td colspan="5" class="normalfnt_trR">Sub Total 1</td>
			<td class="normalfnt_trR">$<?php echo number_format($subtotValue,4); $subtotValue=0; ?></td>
		</tr>
		<tr>
			<td colspan="7" class="normalfnt_tr">Accessories</td>
		</tr>
		<tr>
			<?php 
				$sqlMat = "select mil.strItemDescription,mil.strUnit,fcd.dblUnitPrice,fcd.reaConPc,fcd.dblValue
from matitemlist mil inner join firstsalecostworksheetdetail fcd on 
mil.intItemSerial = fcd.intMatDetailID
where fcd.intStyleId=$styleId and strType=2";

			$resultM = $db->RunQuery($sqlMat);	
						while($rowM = mysql_fetch_array($resultM))
						{
			?>
			<td width="4"></td>
           
			<td width="507" class="normalfnt"><?php echo $rowM["strItemDescription"]; ?></td>
			<td width="63" class="normalfntR"><?php echo $rowM["strUnit"]; ?></td>
			<td width="83" class="normalfntR"><?php echo number_format($rowM["dblUnitPrice"],4); ?></td>
			<td width="111" class="normalfntR"><?php echo number_format($rowM["reaConPc"],4); ?></td>
			<td width="111" class="normalfntR">$<?php echo number_format($rowM["dblValue"],4); 
			$totValue += $rowM["dblValue"];
			$subtotValue += $rowM["dblValue"];
			?></td>
		</tr>
        <?php 
			}
		?>
		<!--<tr>
			<td width="4"></td>
			<td width="507" class="normalfnt">**************</td>
			<td width="63" class="normalfntR">Pcs</td>
			<td width="83" class="normalfntR">0.00</td>
			<td width="111" class="normalfntR">0.00</td>
			<td width="111" class="normalfntR">0.00</td>
		</tr>-->
		<tr>
			<td colspan="5" class="normalfnt_trR">Sub Total 2</td>
			<td class="normalfnt_trR">$<?php echo number_format($subtotValue,4); $subtotValue=0; ?></td>
		</tr>
		<tr>
			<td colspan="7" style="background-color:#FFFFFF;">&nbsp;</td>
		</tr>
	</tbody>
	<thead>
		<tr>
			<td colspan="2">COST OF TRANSPORTING ASSISTS</td>
			<td width="63">Unit</td>
			<td width="83">Cost in USD for Transportation of Assists</td>
			<td width="111">Number of Products Produced Per Shipment of Assists</td>
			<td width="111">Cost / Products = Per Product Cost in USD</td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<?php 
				$sqlMat = "select mil.strItemDescription,mil.strUnit,fcd.dblUnitPrice,fcd.reaConPc,fcd.dblValue
from matitemlist mil inner join firstsalecostworksheetdetail fcd on 
mil.intItemSerial = fcd.intMatDetailID
where fcd.intStyleId=$styleId and strType=3";

			$resultM = $db->RunQuery($sqlMat);	
						while($rowM = mysql_fetch_array($resultM))
						{
			?>
			<td width="4"></td>
           
			<td width="507" class="normalfnt"><?php echo $rowM["strItemDescription"]; ?></td>
			<td width="63" class="normalfntR"><?php echo $rowM["strUnit"]; ?></td>
			<td width="83" class="normalfntR"><?php echo number_format($rowM["dblUnitPrice"],4); ?></td>
			<td width="111" class="normalfntR"><?php echo number_format($rowM["reaConPc"],4); ?></td>
			<td width="111" class="normalfntR">$<?php echo number_format($rowM["dblValue"],4); 
			$totValue += $rowM["dblValue"];
			$subtotValue += $rowM["dblValue"];
			?></td>
		</tr>
        <?php 
			}
		?>
		<tr>
			<td colspan="5" class="normalfnt_trR">Sub Total 3</td>
			<td class="normalfnt_trR">$<?php echo number_format($subtotValue,4); $subtotValue=0; ?></td>
		</tr>
		<tr>
			<td colspan="7" style="background-color:#FFFFFF;">&nbsp;</td>
		</tr>
	</tbody>
	<thead>
		<tr>
			<td colspan="2">CMPW COSTS</td>
			<td width="63">Unit</td>
			<td width="83">Total Cost in USD</td>
			<td width="111">Number of Products Produced</td>
			<td width="111">Per Product Cost in USD</td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<?php 
				$sqlMat = "select mil.strItemDescription,mil.strUnit,fcd.dblUnitPrice,fcd.reaConPc,fcd.dblValue
from matitemlist mil inner join firstsalecostworksheetdetail fcd on 
mil.intItemSerial = fcd.intMatDetailID
where fcd.intStyleId=$styleId and strType=4";

			$resultM = $db->RunQuery($sqlMat);	
						while($rowM = mysql_fetch_array($resultM))
						{
			?>
			<td width="4"></td>
           
			<td width="507" class="normalfnt"><?php echo $rowM["strItemDescription"]; ?></td>
			<td width="63" class="normalfntR"><?php echo $rowM["strUnit"]; ?></td>
			<td width="83" class="normalfntR"><?php echo number_format($rowM["dblUnitPrice"],4); ?></td>
			<td width="111" class="normalfntR"><?php echo number_format($rowM["reaConPc"],4); ?></td>
			<td width="111" class="normalfntR">$<?php echo number_format($rowM["dblValue"],4); 
			$totValue += $rowM["dblValue"];
			$subtotValue += $rowM["dblValue"];
			?></td>
		</tr>
        <?php 
			}
		?>
		<tr>
			<td colspan="5" class="normalfnt_trR">Sub Total 4</td>
			<td class="normalfnt_trR">$<?php echo number_format($subtotValue,4); $subtotValue=0; ?></td>
		</tr>
		<tr>
			<td colspan="7" style="background-color:#FFFFFF;">&nbsp;</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="5" class="normalfnt_trC">TOTAL FIRST SALE PRICE PER PRODUCT</td>
			<td class="normalfnt_trFooter">$<?php echo $totValue; ?></td>
		</tr>
	</tfoot>
</table>
<br />
<table class="mainspace" id="tblreportGrid" cellspacing="1" align="center" width="900">
	<thead>
		<tr>
			<td colspan="7" class="normalfnt_Sub">Signed Certification</td>
		</tr>
	</thead>
</table>
<table width="900" height="133" align="center" border="1" cellspacing="1" class="eReportFooter">
	<tr>
		<td width="513"></td>
		<td width="375">
			<table align="center">
				<tr>
					<td height="82" class="normalfnt">I certify that the above calculations are a true and accurate reflection of the manufacture of the style described and that the goods in question have been or will be sold to GV at the Invoice Price quoted.</td>
				</tr>
				<tr>
					<td  class="normalfnt">ORIT TRADING LANKA (PVT) LTD</td>
				</tr>
				<tr>
					<td class="normalfnt">Date :</td>
				</tr>
			</table>			
	  </td>
	</tr>
</table>

</body>
</html>
