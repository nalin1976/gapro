<html>
<?php 
include "Connector.php";


?>
<head>
</head>
<body>
<form action="" method="get">
	<table width="100%" border="1" cellspacing="1">

<?php

	$sql = "select * from(SELECT
				specification.intSRNO,
				stocktransactions.intStyleId,
				stocktransactions.strBuyerPoNo,
				stocktransactions.intMatDetailId,
				matitemlist.strItemDescription,
				stocktransactions.strColor,
				stocktransactions.strSize,
				round(Sum(stocktransactions.dblQty) ,2)AS Qty,
				mainstores.strName
				FROM
				stocktransactions
				Left Join specification ON specification.intStyleId = stocktransactions.intStyleId
				Left Join matitemlist ON matitemlist.intItemSerial = stocktransactions.intMatDetailId
				Inner Join mainstores ON mainstores.strMainID = stocktransactions.strMainStoresID
				GROUP BY
				stocktransactions.intStyleId,
				stocktransactions.strBuyerPoNo,
				stocktransactions.intMatDetailId,
				stocktransactions.strColor,
				stocktransactions.strSize
				) as stock where Qty<0";
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{

?>
    <tr>
      <th colspan="10" scope="col">stock (-)report<br>Record Count - <?php echo mysql_num_rows($result); ?></th>
    </tr>
	    <tr bgcolor="#FFF2F2">
      <th width="8%" >No</th>
      <th width="7%">SC</th>
      <th width="9%">Style No</th>
      <th width="14%">Buyer Po No</th>
	  <th width="10%">Serial</th>
      <th width="25%">Description</th>
      <th width="7%">Color</th>
      <th width="7%">Size</th>
	  <th width="6%">Qty</th>
	  <th width="7%">BalQty</th>
    </tr>
    <tr>
	  <td><?php echo ++$i; ?></td>
      <td><?php echo $row["intSRNO"]; ?></td>
      <td><?php echo $row["intStyleId"]; ?></td>
      <td><?php echo $row["strBuyerPoNo"]; ?></td>
      <td><?php echo $row["intMatDetailId"]; ?></td>
      <td><?php echo $row["strItemDescription"]; ?></td>
      <td><?php echo $row["strColor"]; ?></td>
      <td><?php echo $row["strSize"]; ?></td>
	  <td><?php echo $row["Qty"]; ?></td>
	  <td><?php echo $row["strName"]; ?></td>
    </tr>
	<tr>
	<td colspan="10">
		<table width="100%" border="0" cellspacing="0">
		<?php
				$sql1 = "SELECT
						stocktransactions.strType,
						Sum(stocktransactions.dblQty) AS Qty,
						intDocumentNo,
						intDocumentYear
						FROM
						stocktransactions
						WHERE
						stocktransactions.intStyleId =  '".$row["intStyleId"]."' AND
						stocktransactions.strBuyerPoNo =  '".$row["strBuyerPoNo"]."' AND
						stocktransactions.intMatDetailId =  '".$row["intMatDetailId"]."' AND
						stocktransactions.strColor =  '".$row["strColor"]."' AND
						stocktransactions.strSize =  '".$row["strSize"]."'
						GROUP BY
						stocktransactions.intStyleId,
						stocktransactions.strBuyerPoNo,
						stocktransactions.intMatDetailId,
						stocktransactions.strColor,
						stocktransactions.strSize,
						stocktransactions.strType,
						intDocumentNo,
						intDocumentYear";
						 
	$result1 = $db->RunQuery($sql1);
	while($row1=mysql_fetch_array($result1))
	{
		$type = $row1["strType"];
		$qty2 = $row1["Qty"];
		$documentNo = $row1["intDocumentNo"];
		$documentYear = $row1["intDocumentYear"];
		?>
		<tr>
			<td width="10%"><?php echo $type; ?></td>
			<td width="10%"><?php echo round($qty2,2); ?></td>
			<td width="10%">Document No :</td>
			<td width="10%"><?php echo $documentYear.'/'.$documentNo; ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<?php
	}
		?>
		</table>
	</td>
	</tr>
<?php
	}
?>
  </table>



</form>
</body>
</html>