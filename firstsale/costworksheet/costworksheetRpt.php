<?php
	session_start();
	include("../../Connector.php");
	$backwardseperator = "../../";
	include "../../eshipLoginDB.php";
	include $backwardseperator."authentication.inc";
	
	$eshipDB = new eshipLoginDB();	
	$styleId =$_GET["styleId"];	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cost WorkSheet</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php 
	$sql_fs = " select intStatus,intApprovedBy from  firstsalecostworksheetheader where intStyleId='$styleId' ";
	$result_fs = $db->RunQuery($sql_fs);
	$rowFS = mysql_fetch_array($result_fs);
	
	$fsStatus = $rowFS["intStatus"];
	$confirmBy = $rowFS["intApprovedBy"];
	if($fsStatus == 0 || $fsStatus==1)
	{
?>
<div style="position:absolute;top:200px;left:250px;">
<img src="../../images/pending.png">
</div>
<?php 
	}
	if($fsStatus ==11)
	{
?>
<div style="position:absolute;top:200px;left:400px;"><img src="../../images/cancelled.png" style="-moz-opacity:0.20;opacity:0.20;filter:alpha(opacity=20);" /></div>
<?php 
}
?>
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
	
	
			$sql = "select o.strOrderNo,o.strStyle,o.strDescription,c.strName,o.strOrderColorCode,o.intQty
			from orders o inner join companies c on 
			c.intCompanyID = o.intCompanyID
			where o.intStyleId=$styleId";
			
			$result = $db->RunQuery($sql);	
						while($row = mysql_fetch_array($result))
						{
						
						$strOrderNo = $row["strOrderNo"];
						$strColor = $row["strOrderColorCode"];
		if($strColor != '')
		{
			$colorLen = strlen($strColor)+1;
			$strOrderNo = substr($strOrderNo,0,($colorLen*-1));
		}
		$intQty = $row["intQty"];
		$style = $row["strStyle"];
		$productDescription = $row["strDescription"];
	}	
	?>
     <?php 
			$sql_shipData = "select b.strName as buyerName,c.strPortOfLoading,cid.strFabric,cid.strDescOfGoods,
cust.strName as Factory,cust.strMLocation
from commercial_invoice_header cih inner join buyers b on
b.strBuyerID = cih.strBuyerID 
inner join city c on c.strCityCode= cih.strFinalDest
inner join commercial_invoice_detail cid on cid.strInvoiceNo= cih.strInvoiceNo
inner join customers cust on cust.strCustomerID = cih.strCompanyID
where cid.strBuyerPONo='$strOrderNo' ";
//echo $sql_shipData;
	$result_shipData = $eshipDB->RunQuery($sql_shipData);	
	$row_s = mysql_fetch_array($result_shipData);
	$buyer = $row_s["buyerName"];
	$finalDestination =  $row_s["strPortOfLoading"];
	//$productDescription = $row_s["strFabric"].' '.$row_s["strDescOfGoods"];
	$factory =  $row_s["Factory"];
	$fac_city = strtoupper($row_s["strMLocation"]);
		?>
		<tr>
			<td width="6"></td>
			<td width="251" class="normalfntb">FACTORY: </td>
			<td width="331" class="normalfnt"><?php echo $factory.' - '.$fac_city; ?></td>
			<td width="72" class="normalfntb">&nbsp;</td>
		  <td width="222" colspan="2" class="normalfnt">&nbsp;</td>
	  </tr>
		<tr>
			<td></td>
			<td class="normalfntb">STYLE NUMBER: </td>
			<td colspan="4" class="normalfnt"><?php echo $style; ?></td>
		</tr>
		<tr>
			<td></td>
			<td class="normalfntb"> PURCHASE ORDER NUMBER: </td>
			<td colspan="4" class="normalfnt"><?php echo $strOrderNo;  ?></td>
		</tr>
         
       
		<tr>
		  <td></td>
		  <td class="normalfntb">COLOR</td>
		  <td colspan="4" class="normalfnt"><?php echo $strColor; ?></td>
	  </tr>
		<tr>
			<td></td>
			<td class="normalfntb">PRODUCT DESCRIPTION: </td>
			<td colspan="4" class="normalfnt"><?php echo $productDescription; ?></td>
		</tr>
       
		<tr>
			<td></td>
			<td class="normalfntb">MANUFACTURED FOR: </td>
			<td colspan="4" class="normalfnt"><?php echo $buyer; ?></td>
		</tr>
		<tr>
			<td></td>
			<td class="normalfntb">FINAL DESTINATION: </td>
			<td colspan="4" class="normalfnt"><?php echo $finalDestination; ?></td>
		</tr>
		<tr>
			<td></td>
			<td class="normalfntb">NUMBER OF PRODUCTS: In PCS : </td>
			<td colspan="4" class="normalfnt"><?php echo $intQty; ?></td>
		</tr>
	</tbody>
</table>
<table id="tblreportGrid" cellspacing="1" align="center" width="900" bgcolor="#000000">
	<thead>
		<tr bgcolor="#FFFFFF">
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
			
           
			<td width="507" class="normalfnt" colspan="2"><?php echo $rowM["strItemDescription"]; ?></td>
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
			<td colspan="5" class="normalfnt_trR">COST OF Material</td>
		  <td class="normalfnt_trR">$<?php echo number_format($subtotValue,4); $subtotValue=0; ?></td>
		</tr>
		<tr>
			<td colspan="7" class="normalfnt_tr">Accessories</td>
		</tr>
		<tr>
			<?php 
				/*$sqlMat = "select mil.strItemDescription,mil.strUnit,fcd.dblUnitPrice,fcd.reaConPc,fcd.dblValue
from matitemlist mil inner join firstsalecostworksheetdetail fcd on 
mil.intItemSerial = fcd.intMatDetailID
where fcd.intStyleId=$styleId and strType=2 order by mil.strItemDescription";*/
				 $sqlMat = "select mil.strItemDescription as itemDesc,mil.strUnit,fcd.dblUnitPrice,fcd.reaConPc,fcd.dblValue
from matitemlist mil inner join firstsalecostworksheetdetail fcd on 
mil.intItemSerial = fcd.intMatDetailID
where fcd.intStyleId='$styleId' and strType in (2,5,6)
union 
select wd.strDescription as itemDesc,fs.strUnit,fs.dblUnitprice,fs.dblConpc as reaConPc,fs.dblUnitprice as dblValue
from firstsale_invprocessdetails fs inner join was_dryprocess wd on
wd.intSerialNo = fs.intProcessId
where fs.intStyleId='$styleId' and fs.intFScategoryId in (2)
order by itemDesc";	
			$resultM = $db->RunQuery($sqlMat);	
						while($rowM = mysql_fetch_array($resultM))
						{
			?>
			
           
			<td width="507" colspan="2" class="normalfnt"><?php echo $rowM["itemDesc"]; ?></td>
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
			<td colspan="5" class="normalfnt_trR">COST OF Accessories</td>
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
				$sqlMat = "select mil.strItemDescription as itemDesc,mil.strUnit,fcd.dblUnitPrice,fcd.reaConPc,fcd.dblValue
from matitemlist mil inner join firstsalecostworksheetdetail fcd on 
mil.intItemSerial = fcd.intMatDetailID
where fcd.intStyleId='$styleId' and strType=3
union 
select wd.strDescription as itemDesc,fs.strUnit,fs.dblUnitprice,fs.dblConpc as reaConPc,fs.dblUnitprice as dblValue
from firstsale_invprocessdetails fs inner join was_dryprocess wd on
wd.intSerialNo = fs.intProcessId
where fs.intStyleId='$styleId' and fs.intFScategoryId=3
order by itemDesc";

			$resultM = $db->RunQuery($sqlMat);	
						while($rowM = mysql_fetch_array($resultM))
						{
			?>
		          
			<td width="507" colspan="2" class="normalfnt"><?php echo $rowM["itemDesc"]; ?></td>
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
			<td colspan="5" class="normalfnt_trR">COST OF Transport Assists &amp; Other Services</td>
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
				$sqlMat = "select mil.strItemDescription as itemDesc,mil.strUnit,fcd.dblUnitPrice,fcd.reaConPc,fcd.dblValue
from matitemlist mil inner join firstsalecostworksheetdetail fcd on 
mil.intItemSerial = fcd.intMatDetailID
where fcd.intStyleId='$styleId' and strType=4
union 
select wd.strDescription as itemDesc,fs.strUnit,fs.dblUnitprice,fs.dblConpc as reaConPc,fs.dblUnitprice as dblValue
from firstsale_invprocessdetails fs inner join was_dryprocess wd on
wd.intSerialNo = fs.intProcessId
where fs.intStyleId='$styleId' and fs.intFScategoryId=4
order by itemDesc";

			$resultM = $db->RunQuery($sqlMat);	
						while($rowM = mysql_fetch_array($resultM))
						{
			?>
		          
			<td width="507" colspan="2" class="normalfnt"><?php echo $rowM["itemDesc"]; ?></td>
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
			<td colspan="5" class="normalfnt_trR">COST OF CMPW</td>
		  <td class="normalfnt_trR">$<?php echo number_format($subtotValue,4); $subtotValue=0; ?></td>
		</tr>
		<tr>
			<td colspan="7" style="background-color:#FFFFFF;">&nbsp;</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="5" class="normalfnt_trC">TOTAL FIRST SALE PRICE PER PRODUCT</td>
			<td class="normalfnt_trFooter">$<?php echo number_format($totValue,4); ?></td>
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
		
<td width="900">
			<table align="center">
				<tr>
					<td height="82" class="normalfnt">I certify that the above calculations are a true and accurate reflection of the manufacture of the style described and that the goods in question have been or will be sold to <?php echo $buyer; ?> at the Invoice Price quoted.</td>
				</tr>
				<tr>
					<td  class="normalfnt"><table width="804" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="195" height="20" style="text-align:center;"><i>Signed :</i></td>
                         <?php 
			
			if($fsStatus == 10)
			{
			?>
           <td  class="normalfntTAB2"><img src="<?php echo '../../upload files/approvalImg/'. $confirmBy.'.jpg'; ?>" width="241" height="115"></td>
           <?php 
			}
			else
			{
			?>
            <td  class="normalfntTAB2">&nbsp;</td>
             <?php 
			 }
			 ?>
                       
                        <td width="151" style="text-align:center;"><i>Date :</i></td>
                        <td width="291" class="normalfntTAB2">&nbsp;</td>
                      </tr>
                      <tr>
                        <td height="20">&nbsp;</td>
                        <td align="center">Sureshinie Fernando</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                    </table></td>
			  </tr>
				<tr>
					<td class="normalfnt">&nbsp;</td>
			  </tr>
			</table>			
	  </td>
	</tr>
</table>

</body>
</html>
