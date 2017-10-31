<?php
 session_start();
include "../../../Connector.php";
$MatDetailID = $_GET["MatDetailID"];
$color = $_GET["color"];
$size = $_GET["size"];
$itemDesc = $_GET["itemDesc"];
//$tbl = $_GET["tbl"];
$StyleID = $_GET["StyleID"];
$mainStores = $_GET["mainStores"];
$x = $_GET["x"];
$OrderType = $_GET["OrderType"];
$withLeftVal = $_GET["withLeftVal"];
$Merchandiser = $_GET["Merchandiser"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Item Movement</title>
<link href="../../../css/erpstyle.css" type="text/css" rel="stylesheet" />
</head>

<body>
<table width="850" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td colspan="3" class="head1" align="center"><?php 
	$sql = "select strItemDescription from matitemlist where intItemSerial='$MatDetailID' ";
	$result = $db->RunQuery($sql);
	$rowM = mysql_fetch_array($result);
	echo $rowM["strItemDescription"]; ?> </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><table width="850" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="58" class="normalfnBLD1">Color :</td>
        <td width="399" class="normalfnBLD1"><?php echo $color; ?></td>
        <td width="49" class="normalfnBLD1">Size :</td>
        <td width="344" class="normalfnBLD1"><?php echo $size; ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><table width="1018" border="0" cellspacing="1" cellpadding="2" align="center" bgcolor="#000000">
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="119" height="25">PO No</th>
        <th width="134">GRN No</th>
        <th width="134">Invoice No</th>
        <th width="111">GRN Type</th>
        <th width="83">GRN Date</th>
        <th width="83">Price</th>
        <th width="91">Currency</th>
        <th width="67">Ex Rate</th>
       <!-- <th width="90">Invoice Price (USD)</th>-->
        <th width="70">Qty</th>
        <th width="75">Value (USD)</th>
      </tr>
      
      <?php 
	  $totQty=0;
	  $totValue=0;
	$grandTotal = 0;
	$grandTotalValue =0;
	//echo $sql;
	$result = getGRNDetails('stocktransactions',$MatDetailID,$color,$size,$mainStores,$StyleID,$OrderType,$Merchandiser);
	$rowCount = mysql_num_rows($result);
	if(($x == 'all' || $x =='running') && $rowCount>0)
	{
		while($row = mysql_fetch_array($result))
		{
			$totQty += $row["qty"];
			$grnType = $row["strGRNType"];
			switch($grnType)
			{
				case 'B':
				{
					$strGRNType = 'Bulk';
					break;
				}
				case 'S':
				{
					$strGRNType = 'Style';
					break;
				}
			}
			
			$resPODetails = getPODetails($row["intGrnNo"],$row["intGrnYear"],$grnType,$row["intStyleId"],$MatDetailID,$color,$size);
			$rowP = mysql_fetch_array($resPODetails);
			$grnPrice = round($rowP["grnPrice"]/$rowP["exRate"],4);	
			$grnValue = round($rowP["grnPrice"]/$rowP["exRate"]*$row["qty"],4);
			$totValue += $grnValue;
			
			if($row["intGrnNo"]<20)
				$PONo ='';
			else
				$PONo = $rowP["POYear"].'/'.$rowP["PONo"];
	  ?>
      <tr bgcolor="#FFFFFF" class="normalfnt">
        <td height="20"><?php echo $PONo; ?></td>
        <td><?php echo $row["intGrnYear"].'/'.$row["intGrnNo"]; ?></td>
        <td><?php echo $rowP["strInvoiceNo"]; ?></td>
        <td><?php echo $strGRNType; ?></td>
        <td ><?php echo $rowP["ConfirmedDate"]; ?></td>
        <td class="normalfntRite"><?php echo $rowP["grnPrice"]; ?></td>
        <td class="normalfntMid"><?php echo $rowP["strCurrency"]; ?></td>
        <td class="normalfntRite"><?php echo $rowP["exRate"]; ?></td>
      <!--  <td class="normalfntRite"><?php //echo $grnPrice; ?></td>-->
        <td class="normalfntRite"><?php echo number_format($row["qty"],2); ?></td>
        <td class="normalfntRite"><?php echo number_format($grnValue,4); ?></td>
      </tr>
      <?php 
		}
		
		$grandTotal +=$totQty;
		$grandTotalValue += $totValue;
		if($totValue>0) 
		{
	  ?>
      <tr bgcolor="#EBEBEB">
    <td class="normalfntMid" colspan="8"><b> Total</b></td>
    <td class="normalfntRite"><?php echo  number_format($totQty,2);?></td>
    <td class="normalfntRite"><?php echo number_format($totValue,4); ?></td>
  </tr>
  <?php 
  		}
	}
	 
	$result_t = getGRNDetails('stocktransactions_temp',$MatDetailID,$color,$size,$mainStores,$StyleID,$OrderType,$Merchandiser);
	$rowCount_t = mysql_num_rows($result_t);
	//echo $rowCount_t;
	if(($x == 'all' || $x =='running') && $rowCount_t>0)
	{
	?>
     <tr bgcolor="#FFFFFF">
    <td class="normalfnt" colspan="10"><b> Not Trim Inspected Data</b></td>
  </tr>
    <?php
	
		while($rowT = mysql_fetch_array($result_t))
		{
			$totTempQty += $rowT["qty"];
			$grnType = $rowT["strGRNType"];
			switch($grnType)
			{
				case 'B':
				{
					$strGRNType = 'Bulk';
					break;
				}
				case 'S':
				{
					$strGRNType = 'Style';
					break;
				}
			}
			
			$resPODetails = getPODetails($rowT["intGrnNo"],$rowT["intGrnYear"],$grnType,$rowT["intStyleId"],$MatDetailID,$color,$size);
			$rwT = mysql_fetch_array($resPODetails);
			$grnPrice = round($rwT["grnPrice"]/$rwT["exRate"],4);	
			$grnValue = round($rwT["grnPrice"]/$rwT["exRate"]*$rowT["qty"],4);
			$totTempValue += $grnValue;
			
			if($rowT["intGrnNo"]<20)
				$PONo ='';
			else
				$PONo = $rwT["POYear"].'/'.$rwT["PONo"];
			
  ?>
   <tr bgcolor="#FFFFFF" class="normalfnt">
        <td height="20"><?php echo $PONo; ?></td>
        <td><?php echo $rowT["intGrnYear"].'/'.$rowT["intGrnNo"]; ?></td>
         <td><?php echo $rwT["strInvoiceNo"]; ?></td>
        <td><?php echo $strGRNType; ?></td>
        <td><?php echo $rowP["ConfirmedDate"]; ?></td>
        <td class="normalfntRite"><?php echo $rwT["grnPrice"]; ?></td>
        <td class="normalfntMid"><?php echo $rwT["strCurrency"]; ?></td>
        <td class="normalfntRite"><?php echo $rwT["exRate"]; ?></td>
      <!--  <td class="normalfntRite"><?php //echo $grnPrice; ?></td>-->
        <td class="normalfntRite"><?php echo number_format($rowT["qty"],2); ?></td>
        <td class="normalfntRite"><?php echo number_format($grnValue,4); ?></td>
      </tr>
  <?php 
  		}
		$grandTotal +=$totTempQty;
		$grandTotalValue += $totTempValue;
	?>
     <tr bgcolor="#EBEBEB">
    <td class="normalfntMid" colspan="8"><b> Total</b></td>
    <td class="normalfntRite"><?php echo  number_format($totTempQty,2);?></td>
    <td class="normalfntRite"><?php echo number_format($totTempValue,4); ?></td>
  </tr>
    <?php	
  	}
  ?>
  <?php 
  		
	if($x == 'all' || $x=='leftOvers')
	{
		$result_l = getGRNDetails('stocktransactions_leftover',$MatDetailID,$color,$size,$mainStores,$StyleID,$OrderType,$Merchandiser);
		$rowCount_l = mysql_num_rows($result_l);
		if($rowCount_l>0)
		{	
	?>
    <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20" colspan="10"><b>Leftover Details</b></td>
       </tr>
    <?php
		}
		while($rowL = mysql_fetch_array($result_l))
		{
			$totleftQty += $rowL["qty"];
			$grnType = $rowL["strGRNType"];
			switch($grnType)
			{
				case 'B':
				{
					$strGRNType = 'Bulk';
					break;
				}
				case 'S':
				{
					$strGRNType = 'Style';
					break;
				}
			}
			if($rowL["intGrnNo"]<20)
			{
				$poNo = '';
				$unitprice = $rowL["dblUnitPrice"];
				$grnValue = $unitprice*$rowL["qty"];
				$currency = '';
				$exRate = '';
			}
			else
			{
				$resPODetails = getPODetails($rowL["intGrnNo"],$rowL["intGrnYear"],$grnType,$rowL["intStyleId"],$MatDetailID,$color,$size);
				$rowP = mysql_fetch_array($resPODetails);
				$grnPrice = round($rowP["grnPrice"]/$rowP["exRate"],4);	
				$grnValue = round($rowP["grnPrice"]/$rowP["exRate"]*$rowL["qty"],4);
				$poNo = $rowP["POYear"].'/'.$rowP["PONo"];
				$unitprice = $rowP["grnPrice"];
				$currency = $rowP["strCurrency"];
				$exRate = $rowP["exRate"];
			}
			if($withLeftVal=='false')
				$grnValue =0;
				
			$totLeftValue += $grnValue;	
		
  ?>
   <tr bgcolor="#FFFFFF" class="normalfnt">
        <td height="20"><?php echo $poNo; ?></td>
        <td><?php echo $rowL["intGrnYear"].'/'.$rowL["intGrnNo"]; ?></td>
         <td><?php echo $rowP["strInvoiceNo"]; ?></td>
        <td><?php echo $strGRNType; ?></td>
        <td ><?php echo $rowP["ConfirmedDate"]; ?></td>
        <td class="normalfntRite"><?php echo $unitprice; ?></td>
        <td class="normalfntMid"><?php echo $currency; ?></td>
        <td class="normalfntRite"><?php echo $exRate; ?></td>
      <!--  <td class="normalfntRite"><?php //echo $grnPrice; ?></td>-->
        <td class="normalfntRite"><?php echo number_format($rowL["qty"],2); ?></td>
        
        <td class="normalfntRite"><?php echo $grnValue; ?></td>
      </tr>
      <?php 
	  }
	  $grandTotal +=$totleftQty;
		$grandTotalValue += $totLeftValue;
	  if($totleftQty>0) 
		{
	  ?>
      <tr bgcolor="#EBEBEB">
    <td class="normalfntMid" colspan="8"><b> Total</b></td>
    <td class="normalfntRite"><?php echo  number_format($totleftQty,2);?></td>
    <td class="normalfntRite"><?php echo number_format($totLeftValue,4); ?></td>
  </tr>
  <?php 
  		}
	}
	$result_B = getGRNDetails('stocktransactions_bulk',$MatDetailID,$color,$size,$mainStores,$StyleID,$OrderType,$Merchandiser);
	$rowCount_B = mysql_num_rows($result_B);
	
	if(($x == 'all' || $x=='bulk') && $rowCount_B>0)
	{	
		?>
          <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td height="20" colspan="10"><b>Bulk Details</b></td>
       </tr>
        <?php 
		while($rowB = mysql_fetch_array($result_B))
		{
			$totbulkQty += $rowB["qty"];
			$grnType = $rowB["strGRNType"];
			switch($grnType)
			{
				case 'B':
				{
					$strGRNType = 'Bulk';
					break;
				}
				case 'S':
				{
					$strGRNType = 'Style';
					break;
				}
			}
			
				$resPODetails = getPODetails($rowB["intGrnNo"],$rowB["intGrnYear"],$grnType,$rowB["intStyleId"],$MatDetailID,$color,$size);
				$rowP = mysql_fetch_array($resPODetails);
				$grnPrice = round($rowP["grnPrice"]/$rowP["exRate"],4);	
				$grnValue = round($rowP["grnPrice"]/$rowP["exRate"]*$rowB["qty"],4);
				$poNo = $rowP["POYear"].'/'.$rowP["PONo"];
				$unitprice = $rowP["grnPrice"];
				$currency = $rowP["strCurrency"];
				$exRate = $rowP["exRate"];
			
			$totBulkValue += $grnValue;
	
		?>
         <tr bgcolor="#FFFFFF" class="normalfnt">
        <td height="20"><?php echo $poNo; ?></td>
        <td><?php echo $rowB["intGrnYear"].'/'.$rowB["intGrnNo"]; ?></td>
         <td><?php echo $rowP["strInvoiceNo"]; ?></td>
        <td><?php echo $strGRNType; ?></td>
        <td ><?php echo $rowP["ConfirmedDate"]; ?></td>
        <td class="normalfntRite"><?php echo $unitprice; ?></td>
        <td class="normalfntMid"><?php echo $currency; ?></td>
        <td class="normalfntRite"><?php echo $exRate; ?></td>
      <!--  <td class="normalfntRite"><?php //echo $grnPrice; ?></td>-->
        <td class="normalfntRite"><?php echo number_format($rowB["qty"],2); ?></td>
        <td class="normalfntRite"><?php echo $grnValue; ?></td>
      </tr>
        <?php 
		}
		 $grandTotal +=$totbulkQty;
		$grandTotalValue += $totBulkValue;
		?>
         <tr bgcolor="#EBEBEB">
    <td class="normalfntMid" colspan="8"><b> Total</b></td>
    <td class="normalfntRite"><?php echo  number_format($totbulkQty,2);?></td>
    <td class="normalfntRite"><?php echo number_format($totBulkValue,4); ?></td>
  </tr>
        <?php
	}	
	$result_L = getGRNDetails('stocktransactions_liability',$MatDetailID,$color,$size,$mainStores,$StyleID,$OrderType,$Merchandiser);
	$rowCount_L = mysql_num_rows($result_L);
	
	if(($x == 'all' || $x=='liability') && $rowCount_L>0)
	{		
		?>
        <tr bgcolor="#FFFFFF">
          <td class="normalfnt" colspan="8"><b>Liability Details</b></td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
        </tr>
        <?php 
		while($rowLB = mysql_fetch_array($result_L))
		{
			$totLBQty += $rowLB["qty"];
			$grnType = $rowLB["strGRNType"];
			switch($grnType)
			{
				case 'B':
				{
					$strGRNType = 'Bulk';
					break;
				}
				case 'S':
				{
					$strGRNType = 'Style';
					break;
				}
			}
			
				$resPODetails = getPODetails($rowLB["intGrnNo"],$rowLB["intGrnYear"],$grnType,$rowLB["intStyleId"],$MatDetailID,$color,$size);
				$rowP = mysql_fetch_array($resPODetails);
				$grnPrice = round($rowP["grnPrice"]/$rowP["exRate"],4);	
				$grnValue = round($rowP["grnPrice"]/$rowP["exRate"]*$rowLB["qty"],4);
				$poNo = $rowP["POYear"].'/'.$rowP["PONo"];
				$unitprice = $rowP["grnPrice"];
				$currency = $rowP["strCurrency"];
				$exRate = $rowP["exRate"];
			
			$totLBValue += $grnValue;
	
		?>
         <tr bgcolor="#FFFFFF" class="normalfnt">
        <td height="20"><?php echo $poNo; ?></td>
        <td><?php echo $rowLB["intGrnYear"].'/'.$rowLB["intGrnNo"]; ?></td>
         <td><?php echo $rowP["strInvoiceNo"]; ?></td>
        <td><?php echo $strGRNType; ?></td>
        <td ><?php echo $rowP["ConfirmedDate"]; ?></td>
        <td class="normalfntRite"><?php echo $unitprice; ?></td>
        <td class="normalfntMid"><?php echo $currency; ?></td>
        <td class="normalfntRite"><?php echo $exRate; ?></td>
      <!--  <td class="normalfntRite"><?php //echo $grnPrice; ?></td>-->
        <td class="normalfntRite"><?php echo number_format($rowLB["qty"],2); ?></td>
        <td class="normalfntRite"><?php echo $grnValue; ?></td>
      </tr>
        <?php 
		}
		 $grandTotal +=$totLBQty;
		$grandTotalValue += $totLBValue;
		?>
        <tr bgcolor="#EBEBEB">
          <td class="normalfntMid" colspan="8"><b> Total</b></td>
    <td class="normalfntRite"><?php echo  number_format($totLBQty,2);?></td>
    <td class="normalfntRite"><?php echo number_format($totLBValue,4); ?></td>
        </tr>
        <?php 
		}
		?>
        <tr bgcolor="#EBEBEB">
    <td class="normalfntMid" colspan="8"><b> Grand Total</b></td>
    <td class="normalfntRite"><b><?php echo  number_format($grandTotal,2);?></b></td>
    <td class="normalfntRite"><b><?php echo number_format($grandTotalValue,4); ?></b></td>
  </tr>
    </table></td>
  </tr>
  <tr >
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php 
function getPODetails($grnNo,$grnYear,$grnType,$styleId,$matDetailID,$color,$size)
{
	global $db;
	if($grnType == 'S')
	{
		$sqlSup = "select distinct s.strTitle,gd.dblInvoicePrice as grnPrice,c.strCurrency,gh.dblExRate as exRate,poh.intPONo as PONo, poh.intYear as POYear, gd.dblPoPrice as POprice,gh.strInvoiceNo,date(gh.dtmConfirmedDate) as ConfirmedDate
from grndetails gd 
inner join grnheader gh on gd.intGrnNo= gh.intGrnNo and gh.intGRNYear = gd.intGRNYear
inner join purchaseorderheader poh on poh.intPONo=gh.intPoNo and poh.intYear=gh.intYear
inner join suppliers s on s.strSupplierID = poh.strSupplierID
inner join currencytypes c on c.intCurID= poh.strCurrency
where gd.intGrnNo='$grnNo' and gd.intGRNYear='$grnYear'  and gd.intMatDetailID='$matDetailID' and gd.strColor='$color' and  gd.strSize = '$size' ";
			
	}
	else if($grnType == 'B')
	{
		$sqlSup = "select s.strTitle,gd.dblRate as grnPrice,c.strCurrency,gh.dblRate as exRate,poh.intBulkPoNo as PONo ,poh.intYear as POYear, gd.dblRate as POprice,gh.strInvoiceNo,date(gh.dtmConfirmedDate) as ConfirmedDate 
from bulkgrndetails gd 
inner join bulkgrnheader gh on gd.intBulkGrnNo= gh.intBulkGrnNo and gh.intYear = gd.intYear
inner join bulkpurchaseorderheader poh on poh.intBulkPoNo=gh.intBulkPoNo and poh.intYear=gh.intBulkPoYear
inner join suppliers s on s.strSupplierID = poh.strSupplierID
inner join currencytypes c on c.intCurID= poh.strCurrency
where gd.intBulkGrnNo='$grnNo' and gd.intYear='$grnYear'  and gd.intMatDetailID='$matDetailID' and gd.strColor ='$color'  and gd.strSize ='$size' ";
	}
	//echo $sqlSup;
	return $db->RunQuery($sqlSup);
}

function getGRNDetails($tbl,$MatDetailID,$color,$size,$mainStores,$StyleID,$OrderType,$Merchandiser)
{
	global $db;
	if($tbl != 'stocktransactions_bulk')
	{
		$sql = "select sum(dblQty) as qty,st.intGrnNo,st.intGrnYear,st.intStyleId,strGRNType from $tbl st 
		 inner join orders o on o.intStyleId = st.intStyleId ";
		if($tbl == 'stocktransactions_temp')
			$sql .= " inner join grnheader gh on gh.intGrnNo= st.intGrnNo and gh.intGRNYear=st.intGrnYear and gh.intStatus=1 and st.strType='GRN' ";
		$sql .= " where intMatDetailId='$MatDetailID' and strColor='$color' and strSize='$size' ";	
		if($mainStores !='')
			$sql .= " and strMainStoresID = '$mainStores' ";
		if($StyleID !='')
			$sql .= " and st.intStyleId = '$StyleID' ";
		if($OrderType !='')
			$sql .= " and o.intOrderType ='$OrderType' ";	
		$sql .= " group by st.intGrnNo,st.intGrnYear,strGRNType,st.intStyleId ";
		$sql .= " having qty>0 ";	
	}
	else
	{
		$sql = "select sum(st.dblQty) as qty ,st.intBulkGrnNo as intGrnNo,st.intBulkGrnYear as intGrnYear,'style' as intStyleId, 'B' as strGRNType
from  stocktransactions_bulk st 
inner join bulkgrndetails bgd on bgd.intMatDetailID = st.intMatDetailId 
inner join bulkgrnheader bgh on bgh.intBulkGrnNo = bgd.intBulkGrnNo and bgh.intYear= bgd.intYear
inner join bulkpurchaseorderheader bpo on bpo.intBulkPoNo = bgh.intBulkPoNo and bpo.intYear = bgh.intBulkPoYear
and st.intBulkGrnNo = bgd.intBulkGrnNo and st.intBulkGrnYear = bgd.intYear
 where st.intMatDetailId ='$MatDetailID' and st.strColor='$color' and st.strSize='$size'  ";
 		if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
		if($Merchandiser !='')	
			$sql .= " and bpo.intMerchandiser='$Merchandiser' ";
 		$sql .= " group by intGrnNo,intGrnYear,strGRNType
having qty>0 ";
	}
	
	return $db->RunQuery($sql);
}
?>
<script type="text/javascript">

var rowCount =<?php echo $rowCount?>;
var rowCount_l = <?php echo $rowCount_l ?>;
var rowCount_t = <?php echo $rowCount_t; ?>
var rowCount_B = <?php echo $rowCount_B; ?>
var x = "<?php echo $x ?>";
if(x=='all')
{
	if(rowCount<=0 && rowCount_l<=0 && rowCount_t<=0 && rowCount_B<=0){
	alert("Sorry!\nNo Records found in selected item.")
	window.close();
	}
}
else if(x=='running')
{
	if(rowCount<=0 && rowCount_t<=0){
	alert("Sorry!\nNo Records found in selected item.")
	window.close();
	}
}
else if(x=='leftOvers')
{
	if(rowCount_l<=0){
	alert("Sorry!\nNo Records found in selected item.")
	window.close();
	}
}
else if(x=='bulk')
{
	if(rowCount_B<=0){
	alert("Sorry!\nNo Records found in selected item.")
	window.close();
	}
}

</script>
</body>
</html>
