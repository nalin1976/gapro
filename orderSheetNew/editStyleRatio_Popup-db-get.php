<?php
include('../Connector.php');	
	 $type=trim($_GET["RequestType"]);
	 
$strStyleID=trim($_GET["strStyleID"]);
$buyerPO=trim($_GET["buyerPO"]);
	 
?>	 
	 
<table style="width:800px" id="tblStyleRatio" class="thetable" border="0" cellpadding="0" cellspacing="0" >
						<caption>Style Ratio</caption>
										 		
        <tr >
          <th width="160" class="normalfntBtab">Color/Size</th>
		  <?php
		  
		  $sqlsize = "select distinct strSize from styleratio where intStyleId = '$strStyleID' and strBuyerPONO = '" . $buyerPO . "';";
		  $resultsize = $db->RunQuery($sqlsize); 	
		  	$loop = 0;
			while($rowsize = mysql_fetch_array($resultsize))
			{
				$sizearray[$loop] = $rowsize["strSize"]; 
		  ?>
          <th width="75" class="normalfntBtab"><?php echo $rowsize["strSize"];  ?></th>
          <?php
		  	$loop ++;
		  	}
		  ?>
          <th width="75" class="normalfntBtab">Total</th>
        </tr>
		<?php
		$sqlcolor = "select distinct strColor from styleratio where intStyleId = '$strStyleID' and strBuyerPONO = '". $buyerPO . "';";
		$resultcolor = $db->RunQuery($sqlcolor); 
			$loopRow=0;
		while($rowcolor = mysql_fetch_array($resultcolor))
		{
				$colorarray[$loopRow] = $rowsizerowcolor["strColor"]; 
			$rowtot = 0;
			$loopRow++;
		?>
		<tr>
		  <td class="normalfntTAB"><?php echo $rowcolor["strColor"];  ?></td>
		  <?php
				$loopColom=0;
		  	foreach ($sizearray as $size)
			{
					$loopColom++;
					   $sql="SELECT
styleratio.dblExQty,
sum(editedStyleRatio.dblExQty) AS newExQty
FROM
styleratio
left Join editedStyleRatio ON styleratio.intStyleId = editedStyleRatio.intStyleId AND styleratio.strBuyerPONO = editedStyleRatio.strBuyerPONO AND styleratio.strColor = editedStyleRatio.strColor AND styleratio.strSize = editedStyleRatio.strSize
where styleratio.intStyleId = '$strStyleID' and styleratio.strBuyerPONO = '" . $buyerPO . "' and styleratio.strColor = '".$rowcolor["strColor"]."' and styleratio.strSize = '$size' and editedStyleRatio.intStatus='1' group by styleratio.intStyleId, styleratio.strBuyerPONO, styleratio.strColor, styleratio.strSize";
				///echo $sql = "select dblExQty from styleratio where intStyleId = '$strStyleID' and strBuyerPONO = '" . $buyerPO . "' and strColor = '".$rowcolor["strColor"]."' and strSize = '$size';";
				$resultqty = $db->RunQuery($sql); 
				while($rowqty= mysql_fetch_array($resultqty))
				{
					$exQtyReal=0;
					$exQtyNew=0;
					$exQtyBal=0;
					
					$exQtyReal=	$rowqty["dblExQty"];
					$exQtyNew=	$rowqty["newExQty"];
					if($rowqty["newExQty"]==''){
					$exQtyNew=	0;
					}
					
					$exQtyReal=round($exQtyReal,0);
					$exQtyNew=round($exQtyNew,0);
					$exQtyBal=$exQtyReal-$exQtyNew;
					
		  ?>
			<td class="normalfntRiteTAB" id="<?php echo $exQtyBal; ?>"><input type="text" class="txtbox" value="<?php echo round($exQtyBal,0);  ?>" style="width:60px; text-align:right"  onkeypress="return isNumberKey(event);" onkeyup="compQty(<?php echo $loopRow ?>,<?php echo $loopColom ?>);" /></td>
			<?php
					$rowtot += $exQtyBal;
				}
			}
			?>
			<td class="normalfntMidTAB">&nbsp;<?php echo number_format($rowtot,0);  ?>&nbsp;</td>
		</tr>
		<?php
		}
		$sumtot = 0;
		?>
		<tr>
		  <td class="normalfntTAB">Total</td>
		  <?php
		$sqlSize = "select distinct strSize from styleratio where intStyleId = '$strStyleID' and strBuyerPONO = '". $buyerPO . "';";
		$resultcolor = $db->RunQuery($sqlSize); 
		$loopRow=0;
		
		$exQtyReal=0;
		$exQtyNew=0;
		$exQtyBal=0;

		while($rowsize = mysql_fetch_array($resultcolor))
		{
				   $sql = "SELECT
sum(styleratio.dblExQty) AS sizetotal1
FROM styleratio where styleratio.intStyleId = '$strStyleID' and styleratio.strBuyerPONO = '" . $buyerPO . "' and styleratio.strSize = '".$rowsize["strSize"]."' group by styleratio.intStyleId, styleratio.strBuyerPONO, styleratio.strSize";
				$resulttotqty = $db->RunQuery($sql); 
				$rowtotqty= mysql_fetch_array($resulttotqty);
					
					 $exQtyReal=	$rowtotqty["sizetotal1"];
					
					
$sql2="SELECT
Sum(editedStyleRatio.dblExQty) AS sizetotal2
FROM styleratio left Join editedStyleRatio ON styleratio.intStyleId = editedStyleRatio.intStyleId AND styleratio.strBuyerPONO = editedStyleRatio.strBuyerPONO AND styleratio.strColor = editedStyleRatio.strColor AND styleratio.strSize = editedStyleRatio.strSize
where styleratio.intStyleId = '$strStyleID' and styleratio.strBuyerPONO = '" . $buyerPO . "' and styleratio.strSize = '".$rowsize["strSize"]."'
and editedStyleRatio.intStatus='1' group by styleratio.intStyleId, styleratio.strBuyerPONO, styleratio.strSize";			
$resulttotqty = $db->RunQuery($sql2); 
$rowtotqty2= mysql_fetch_array($resulttotqty);
					$exQtyNew=	$rowtotqty2["sizetotal2"];
					
					
					
					if($rowtotqty2["sizetotal2"]==''){
					$exQtyNew=	0;
					}
					$exQtyReal=round($exQtyReal,0);
					$exQtyNew=round($exQtyNew,0);
					
					$sizeTot=$exQtyReal-$exQtyNew;
					$sumtot += $sizeTot;
		  ?>
		  <td class="normalfntRiteTAB" align="right"><?php echo number_format($sizeTot,0);?></td>
		  <?php
			  }
		  ?>
		  <td class="normalfntMidTAB"><?php echo "  ".number_format($sumtot,0)."  ";  ?></td>
	    </tr>
    </table>	 
	 
	 
	<?php 
	 
/*	
//------------------------------------------------------
if($type=="loadRatios")
{
$strStyleID=trim($_GET["styleID"]);
$buyerPO=trim($_GET["buyerPO"]);

$ResponseXML ="";
		 $ResponseXML .= "<table style=\"width:500px\" id=\"tblStyleRatio\" class=\"thetable\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" >
						<caption>Style Ratio</caption>";
										 		
        $ResponseXML .= "<tr >
          <th width=\"150\" class=\"normalfntBtab\">Color/Size</th>";
		  
		   $sqlsize = "select distinct strSize from styleratio where intStyleId = '$strStyleID' and strBuyerPONO = '" . $buyerPO . "';";
		  $resultsize = $db->RunQuery($sqlsize); 	
		  	$loop = 0;
			while($rowsize = mysql_fetch_array($resultsize))
			{
				$sizearray[$loop] = $rowsize["strSize"]; 
          $ResponseXML .= "<th width=\"75\" class=\"normalfntBtab\"> ".$rowsize["strSize"]." </th>";
		  	$loop ++;
		  	}
          $ResponseXML .= "<th width=\"75\" class=\normalfntBtab\">Total</th>
        </tr>";
		$sqlcolor = "select distinct strColor from styleratio where intStyleId = '$strStyleID' and strBuyerPONO = '". $buyerPO . "';";
		$resultcolor = $db->RunQuery($sqlcolor); 
			$loopRow=0;
		while($rowcolor = mysql_fetch_array($resultcolor))
		{
			$rowtot = 0;
			$loopRow++;
		$ResponseXML .= "<tr>
		  <td class=\"normalfntTAB\">".$rowcolor["strColor"]."</td>";
				$loopColom=0;
		  	foreach ($sizearray as $size)
			{
					$loopColom++;
					$sql="SELECT
styleratio.dblExQty,
editedStyleRatio.dblExQty AS newExQty
FROM
styleratio
left Join editedStyleRatio ON styleratio.intStyleId = editedStyleRatio.intStyleId AND styleratio.strBuyerPONO = editedStyleRatio.strBuyerPONO AND styleratio.strColor = editedStyleRatio.strColor AND styleratio.strSize = editedStyleRatio.strSize
where styleratio.intStyleId = '$strStyleID' and styleratio.strBuyerPONO = '" . $buyerPO . "' and styleratio.strColor = '".$rowcolor["strColor"]."' and styleratio.strSize = '$size'";
				///echo $sql = "select dblExQty from styleratio where intStyleId = '$strStyleID' and strBuyerPONO = '" . $buyerPO . "' and strColor = '".$rowcolor["strColor"]."' and strSize = '$size';";
				$resultqty = $db->RunQuery($sql); 
				while($rowqty= mysql_fetch_array($resultqty))
				{
					$exQty=0;
					if($rowqty["newExQty"]!=''){
					$exQty=	$rowqty["newExQty"];
					}
					else{
					$exQty=	$rowqty["dblExQty"];
					}
					$rowtot += $exQty;
			$ResponseXML .="<td class=\"normalfntMidTAB\" id=\"".$exQty."\"><input type=\"text\" class=\"txtbox\" value=\"".$rowqty["dblExQty"]."\" style=\"width:100px; text-align:right\"  onkeypress=\"return isNumberKey(event);\" onkeyup=\"compQty($loopRow,$loopColom);\" /></td>";
				}
			}
			$ResponseXML .="<td class=\"normalfntMidTAB\">".number_format($rowtot,0)."</td>";
		$ResponseXML .="</tr>";
		$sumtot = 0;
		$ResponseXML .="<tr>
		  <td class=\"normalfntTAB\">Total</td>";
		  foreach ($sizearray as $size)
			{
				$sql = "select sum(dblExQty) as sizetotal from styleratio where intStyleId = '$strStyleID' and strBuyerPONO = '".$buyerPO."' and strSize = '$size'";
				$resulttotqty = $db->RunQuery($sql); 
				while($rowtotqty= mysql_fetch_array($resulttotqty))
				{
				$sumtot += $rowtotqty["sizetotal"];
		  $ResponseXML .="<td class=\"normalfntRiteTAB\" align=\"right\">".number_format($rowtotqty["sizetotal"],0)."</td>";
				}
			  }
		  $ResponseXML .="<td class=\"normalfntMidTAB\">".number_format($sumtot,0)."</td>";
	    $ResponseXML .="</tr>";
    $ResponseXML .="</table>";
	echo $ResponseXML;
	
}
*/
//------------------------------------------------------------------------------------


?>