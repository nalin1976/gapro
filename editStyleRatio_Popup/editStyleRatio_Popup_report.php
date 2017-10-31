<?php
include "../authentication.inc";
include "../Connector.php";
$xml = simplexml_load_file('config.xml');
$ReportISORequired = $xml->companySettings->ReportISORequired;
$consumptionDecimalLength = $xml->SystemSettings->ConsumptionDecimalLength;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BOM - Item Status(Edited Style Ratio)</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1100" border="0" align="center">
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0">
     <?php 
		
		$strStyleID=$_GET["styleID"];
		$ratioOrderNos=$_GET["ratioOrderNos"];
		//$strStyleID='200998(6427)-TT-01';
		$intQty=0;
		$buyerName="";
		$intSRNO=0;
		$strDescription="";
		$usrnme="";
		$intCompanyID=0;
		
		//company
		$CompanyName="";
		$strAddress1="";
		$strAddress2="";
		$strStreet="";
		$strState="";
		$strCity="";
		$strCountry="";
		$strZipCode="";
		$strPhone="";
		$strEMail="";
		$strFax="";
		$strWeb="";
		$exPercentage = 0;
		$exQty = 0;
		
		$SQL="SELECT orders.strOrderNo,orders.intStyleId, orders.intQty, orders.reaExPercentage, buyers.strName, specification.intSRNO, orders.strDescription, useraccounts.Name, orders.intCompanyID
FROM ((orders INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID) INNER JOIN specification ON orders.intStyleId = specification.intStyleId) INNER JOIN useraccounts ON orders.intUserID = useraccounts.intUserID
WHERE (((orders.intStyleId)='".$strStyleID."'));";
     // echo $SQL;
		$result = $db->RunQuery($SQL);
		
		while($row = mysql_fetch_array($result))
		{
			$intQty			= $row["intQty"];
			$buyerName		= $row["strName"];
			$intSRNO		= $row["intSRNO"];
			$strDescription	= $row["strDescription"];
			$usrnme			= $row["Name"];
			$intCompanyID	= $row["intCompanyID"];
			$exPercentage 	= $row["reaExPercentage"];
			$orderNo		= $row["strOrderNo"];
		}
		$exQty = $intQty + ($intQty * $exPercentage / 100);
		/*echo "<td width=\"74%\" class=\"tophead\">";
		echo "<p class=\"topheadBLACK\">";
		
		$Company="SELECT companies.intCompanyID, companies.strName, companies.strAddress1, companies.strAddress2, companies.strStreet, companies.strState, companies.strCity, companies.strCountry, companies.strZipCode, companies.strPhone, companies.strEMail, companies.strFax, companies.strWeb
FROM companies
WHERE (((companies.intCompanyID)=".$intCompanyID."));
";		
    //echo $Company;
		$result_com = $db->RunQuery($Company);
		while($row_com = mysql_fetch_array($result_com))
		{
			$CompanyName=$row_com["strName"];
			$strAddress1=$row_com["strAddress1"];
			$strAddress2=$row_com["strAddress2"];
			$strStreet=$row_com["strStreet"];
			$strState=$row_com["strState"];
			$strCity=$row_com["strCity"];
			$strCountry=$row_com["strCountry"];
			$strZipCode=$row_com["strZipCode"];
			$strPhone=$row_com["strPhone"];
			$strEMail=$row_com["strEMail"];
			$strFax=$row_com["strFax"];
			$strWeb=$row_com["strWeb"];
		}
		echo $CompanyName;
		echo "</p>";
		echo "<p class=\"normalfnt\">".$strAddress1.",".$strAddress2.",".$strStreet.",".$strCity.",".$strCountry.".Tel: ".$strPhone." Fax: ".$strFax."</p>";
		
		echo "<p class=\"normalfnt\">";
		echo "E-Mail: ".$strEMail." Web: ".$strWeb."</p>";
		echo "</td>";
		echo "</tr>";*/
		
		$report_companyId = $intCompanyID;
		?>
      <tr>
        <td ><?php include 'reportHeader.php';?></td>
        <!--<td width="6%" class="normalfnt">&nbsp;</td>-->
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="36" colspan="7" class="head2">BILL OF MATERIAL - ITEM STATUS <?php
   					if($ReportISORequired == "true")
   					{
   						$xmlISO = simplexml_load_file('iso.xml');
   						//echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $xmlISO->ISOCodes->BOMReport;
						}              
	                 
                   ?> </td>
      </tr>
      <tr>
        <td width="13%" class="normalfnth2B">STYLE NO</td>
        <td class="normalfnt">
		<?php
		$sql_style="select strStyle from orders where intStyleId='$strStyleID'";
		$result_style=$db->RunQuery($sql_style);
		$row_style = mysql_fetch_array($result_style);
		echo $row_style["strStyle"];
		?></td>
        <td class="normalfnt"><span class="normalfnth2B">SC NO</span></td>
        <td class="normalfnt"><?php echo $intSRNO;?></td>
        <td width="6%">&nbsp;</td>
        <td width="19%" class="normalfnth2B">DESCRIPTION</td>
        <td width="27%" class="normalfnt"><?php echo $strDescription;?></td>
      </tr>
      <tr>
        <td height="13" class="normalfnth2B">ORDER NO </td>
        <td colspan="3" class="normalfnt"><?php echo $orderNo;?></td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">MERCHANDISER</td>
        <td class="normalfnt"><?php echo $usrnme;?></td>
      </tr>
      <tr>
        <td height="13" class="normalfnth2B">ORDER QTY</td>
        <td width="15%" class="normalfnt"><?php echo $intQty;?></td>
        <td width="9%" class="normalfnth2B">WITH EXCESS </td>
        <td width="11%" class="normalfnt"><?php echo $exQty; ?></td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">BUYER</td>
        <td class="normalfnt"><?php echo $buyerName;?></td>
      </tr>
      <tr>
        <td height="26" class="normalfnth2B">&nbsp;</td>
        <td colspan="3" class="normalfnt">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfnt2bldBLACK">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
      
      

    </table></td>
  </tr>
  <tr>
    <td class="normalfnth2B">Delivery Schedule </td>
  </tr>
  <tr>
    <td><table width="500" border="0" cellpadding="0" cellspacing="0" class="tablez">
        <tr >
          <td width="300" class="normalfntBtab">Delivery Date </td>
          <td width="100" class="normalfntBtab">BuyerPONo</td>
          <td width="100" class="normalfntBtab">Qty</td>
        </tr>
		<?php
		$sql = "select dtDateofDelivery,dblQty,dbExQty from deliveryschedule where intStyleId = '$strStyleID' order by dtDateofDelivery;";
		$result = $db->RunQuery($sql); 	
		$totqty = 0;
		while($row = mysql_fetch_array($result))
		{
			$delDate = $row["dtDateofDelivery"];
			$sql = "select dtDateofDelivery,strBuyerPONO,intQty from bpodelschedule  where intStyleId = '$strStyleID' and dtDateofDelivery = '$delDate'";
			$resultbpo = $db->RunQuery($sql); 
			$num_rows = mysql_num_rows($resultbpo);
			if ($num_rows > 0)
			{
				while($rowbpo = mysql_fetch_array($resultbpo))
				{
		?>
		<tr>
			<td class="normalfntTAB"><?php echo date("jS F Y", strtotime($rowbpo["dtDateofDelivery"])) ;  ?></td>
			<td class="normalfntTAB"><?php echo $rowbpo["strBuyerPONO"];  ?></td>
			<td class="normalfntRiteTAB"><?php echo $rowbpo["intQty"];  ?></td>
		</tr>
		<?php
				}
			}
			else
			{
			?>
			<tr>
			<td class="normalfntTAB"><?php echo date("jS F Y", strtotime($row["dtDateofDelivery"]))  ?></td>
			<td class="normalfntTAB">#Main Ratio#</td>
			<td class="normalfntRiteTAB"><?php echo $row["dbExQty"];  ?></td>
		</tr>
			
			<?php
			
			}
			$totqty += $row["dbExQty"]; 
		}
		
		?>
		<tr>
		  <td colspan="2" class="normalfntMidTAB">Total</td>
		  <td class="normalfntRiteTAB"><?php echo $totqty;  ?></td>
	    </tr>
    </table></td>
    <td>&nbsp; </td>
  </tr>
  <?php
 	$sql = "select distinct strBuyerPONO from styleratio where intStyleId = '$strStyleID'";
 	$resultbpo = $db->RunQuery($sql); 	
	while($rowbpo = mysql_fetch_array($resultbpo))
	{
		$sizearray = array();
  ?>
  <tr>
    <td><span class="normalfnth2B">Style Ratio - <?php echo $rowbpo["strBuyerPONO"];  ?> </span></td>
  </tr>
  <tr>
    <td><table width="500" border="0" cellpadding="0" cellspacing="0" class="tablez">
      <tr >
        <td width="200" class="normalfntBtab">Color/Size</td>
        <?php
		  $sqlsize = "select distinct strSize from styleratio where intStyleId = '$strStyleID' and strBuyerPONO = '" . $rowbpo["strBuyerPONO"] . "';";
		  $resultsize = $db->RunQuery($sqlsize); 	
		  	$loop = 0;
			while($rowsize = mysql_fetch_array($resultsize))
			{
				$sizearray[$loop] = $rowsize["strSize"]; 
		  ?>
        <td width="75" class="normalfntBtab">&nbsp;<?php echo $rowsize["strSize"];  ?>&nbsp;</td>
        <?php
		  	$loop ++;
		  	}
		  ?>
        <td width="75" class="normalfntBtab">Total</td>
      </tr>
      <?php
		$sqlcolor = "select distinct strColor from styleratio where intStyleId = '$strStyleID' and strBuyerPONO = '". $rowbpo["strBuyerPONO"] . "';";
		$resultcolor = $db->RunQuery($sqlcolor); 
		while($rowcolor = mysql_fetch_array($resultcolor))
		{
			$rowtot = 0;
		?>
      <tr>
        <td class="normalfntTAB"><?php echo $rowcolor["strColor"];  ?></td>
        <?php
		  	foreach ($sizearray as $size)
			{
				$sql = "select dblQty from styleratio where intStyleId = '$strStyleID' and strBuyerPONO = '" . $rowbpo["strBuyerPONO"] . "' and strColor = '".$rowcolor["strColor"]."' and strSize = '$size';";
				$resultqty = $db->RunQuery($sql); 
				while($rowqty= mysql_fetch_array($resultqty))
				{
					$rowtot += $rowqty["dblQty"];
		  ?>
        <td class="normalfntMidTAB">&nbsp;<?php echo number_format($rowqty["dblQty"],0);  ?>&nbsp;</td>
        <?php
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
		  foreach ($sizearray as $size)
			{
				$sql = "select sum(dblQty) as sizetotal from styleratio where intStyleId = '$strStyleID' and strBuyerPONO = '".$rowbpo["strBuyerPONO"]."' and strSize = '$size';";
				$resulttotqty = $db->RunQuery($sql); 
				while($rowtotqty= mysql_fetch_array($resulttotqty))
				{
				$sumtot += $rowtotqty["sizetotal"];
		  ?>
        <td class="normalfntMidTAB">&nbsp;<?php echo number_format($rowtotqty["sizetotal"],0);?>&nbsp;</td>
        <?php
				}
			  }
		  ?>
        <td class="normalfntMidTAB">&nbsp;<?php echo number_format($sumtot,0);  ?>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
<!--  <tr  style="visibility:hidden">
    <td>&nbsp;</td>
  </tr>-->
  <tr>
    <td><table width="500" border="0" cellpadding="0" cellspacing="0" class="tablez">
        <tr >
          <td width="200" class="normalfntBtab">Color/Size</td>
		  <?php
		  $sqlsize = "select distinct strSize from styleratio where intStyleId = '$strStyleID' and strBuyerPONO = '" . $rowbpo["strBuyerPONO"] . "';";
		  $resultsize = $db->RunQuery($sqlsize); 	
		  	$loop = 0;
			while($rowsize = mysql_fetch_array($resultsize))
			{
				$sizearray[$loop] = $rowsize["strSize"]; 
		  ?>
          <td width="75" class="normalfntBtab">&nbsp;<?php echo $rowsize["strSize"];  ?>&nbsp;</td>
          <?php
		  	$loop ++;
		  	}
		  ?>
          <td width="75" class="normalfntBtab">Total</td>
        </tr>
		<?php
		$sqlcolor = "select distinct strColor from styleratio where intStyleId = '$strStyleID' and strBuyerPONO = '". $rowbpo["strBuyerPONO"] . "';";
		$resultcolor = $db->RunQuery($sqlcolor); 
		while($rowcolor = mysql_fetch_array($resultcolor))
		{
			$rowtot = 0;
		?>
		<tr>
		  <td class="normalfntTAB"><?php echo $rowcolor["strColor"];  ?></td>
		  <?php
		  	foreach ($sizearray as $size)
			{
				//echo $sql = "select dblExQty from editedStyleRatio where intStyleId = '$strStyleID' and strBuyerPONO = '" . $rowbpo["strBuyerPONO"] . "' and strColor = '".$rowcolor["strColor"]."' and strSize = '$size';";
				  $sql="select styleratio.dblExQty as exQty1, 
editedStyleRatio.dblExQty as exQty2
FROM
styleratio
left Join editedStyleRatio ON styleratio.intStyleId = editedStyleRatio.intStyleId AND styleratio.strBuyerPONO = editedStyleRatio.strBuyerPONO AND styleratio.strColor = editedStyleRatio.strColor AND styleratio.strSize = editedStyleRatio.strSize
where editedStyleRatio.intOrderNo = '$ratioOrderNos' and styleratio.intStyleId = '$strStyleID' and styleratio.strBuyerPONO = '" . $rowbpo["strBuyerPONO"] . "' and styleratio.strColor = '".$rowcolor["strColor"]."' and styleratio.strSize = '$size'";
				$resultqty = $db->RunQuery($sql); 
				while($rowqty= mysql_fetch_array($resultqty))
				{
					if($rowqty["exQty2"]!=''){
						
						$qty=$rowqty["exQty2"];
					}
					else{
						$qty=$rowqty["exQty1"];
					}
					$rowtot += $qty;
		  ?>
			<td class="normalfntMidTAB">&nbsp;<?php echo number_format($qty,0);  ?>&nbsp;</td>
			<?php
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
		  foreach ($sizearray as $size)
			{
				 $sql = "select sum(styleratio.dblExQty) as exQty1, 
sum(editedStyleRatio.dblExQty) as exQty2
FROM
styleratio
left Join editedStyleRatio ON styleratio.intStyleId = editedStyleRatio.intStyleId AND styleratio.strBuyerPONO = editedStyleRatio.strBuyerPONO AND styleratio.strColor = editedStyleRatio.strColor AND styleratio.strSize = editedStyleRatio.strSize
where editedStyleRatio.intOrderNo = '$ratioOrderNos' and styleratio.intStyleId = '$strStyleID' and styleratio.strBuyerPONO = '".$rowbpo["strBuyerPONO"]."' and styleratio.strSize = '$size';";
				$resulttotqty = $db->RunQuery($sql); 
				while($rowtotqty= mysql_fetch_array($resulttotqty))
				{
					if($rowtotqty["exQty2"]!=''){
						
						$qty=$rowtotqty["exQty2"];
					}
					else{
						$qty=$rowtotqty["exQty1"];
					}
				$sumtot += $qty;
		  ?>
		  <td class="normalfntMidTAB">&nbsp;<?php echo number_format($qty,0);?>&nbsp;</td>
		  <?php
				}
			  }
		  ?>
		  <td class="normalfntMidTAB">&nbsp;<?php echo number_format($sumtot,0);  ?>&nbsp;</td>
	    </tr>
    </table></td>
    <td>&nbsp; </td>
  </tr>
  <?php
  }
  ?>
  <TR>
  <TD class="normalfnth2B"> Item Details  </TD>
  </TR>
  <tr>
    <td>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
    <thead>
      <tr>
        <td width="40%" class="normalfntBtab">Item</td>
        <td width="15%" class="normalfntBtab">Color</td>
        <td width="12%" class="normalfntBtab">Size</td>
        <td width="10%" class="normalfntBtab">Unit</td>
        <td width="8%" class="normalfntBtab">Con/Pc</td>
        <td width="7%" class="normalfntBtab">Waste %</td>
        <td width="8%" class="normalfntBtab">Req. Qty</td>        
        </tr>
     </thead>
      <tr>
      <?php
	 	$Count_Req_Qty=0;
		$Count_Orderd_QTY=0;
		$Count_Bal_Orederd=0;
	  
	  $SQL_Category="SELECT DISTINCT matmaincategory.strDescription, matmaincategory.intID
FROM (specificationdetails INNER JOIN matitemlist ON specificationdetails.strMatDetailID = matitemlist.intItemSerial) INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID
WHERE (((specificationdetails.intStyleId)='". $strStyleID."'))
ORDER BY matmaincategory.intID;
";

//echo $SQL_Category;

		$result_Category= $db->RunQuery($SQL_Category);
		while($row_Category = mysql_fetch_array($result_Category))
		{
		echo "<td height=\"20\" class=\"normalfnt2BITAB\">".$row_Category["strDescription"]."</td>";
		echo "<td>&nbsp;</td>"."<td>&nbsp;</td>"."<td>&nbsp;</td>"."<td>&nbsp;</td>"/*."<td>&nbsp;</td>"*/;
		echo "<td>&nbsp;</td>"."<td>&nbsp;</td>"."</tr>";
		
			  $Item="SELECT
materialratio.intStyleId,
materialratio.strBuyerPONO,
materialratio.strColor,
materialratio.strSize,
materialratio.dblQty,
materialratio.dblBalQty,
specificationdetails.strUnit,
specificationdetails.sngConPc,
matitemlist.strItemDescription,
specificationdetails.sngWastage,
editedStyleRatio.dblExQty
FROM
((materialratio
Inner Join matitemlist ON materialratio.strMatDetailID = matitemlist.intItemSerial)
Inner Join matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID)
Inner Join specificationdetails ON materialratio.intStyleId = specificationdetails.intStyleId AND materialratio.strMatDetailID = specificationdetails.strMatDetailID
left Join editedStyleRatio ON materialratio.intStyleId = editedStyleRatio.intStyleId AND materialratio.strBuyerPONO = editedStyleRatio.strBuyerPONO AND materialratio.strColor = editedStyleRatio.strColor AND materialratio.strSize = editedStyleRatio.strSize and editedStyleRatio.intOrderNo = '$ratioOrderNos' 
WHERE (((materialratio.intStyleId)='". $strStyleID."') AND ((matmaincategory.intID)=".$row_Category["intID"]."))

Order by matitemlist.strItemDescription,materialratio.strColor, materialratio.strSize;";

			
			$result_Description= $db->RunQuery($Item);
			while($row_Descrip = mysql_fetch_array($result_Description))
			{
				echo "<tr>";
				echo "<td class=\"normalfntTAB\">".$row_Descrip["strItemDescription"]."</td>";
				/*echo "<td class=\"normalfntMidTAB\">".$row_Descrip["strBuyerPONO"]."</td>";*/
				echo "<td class=\"normalfntMidTAB\">".$row_Descrip["strColor"]."</td>";
				echo "<td class=\"normalfntMidTAB\">".$row_Descrip["strSize"]."</td>";
				echo "<td class=\"normalfntMidTAB\">".$row_Descrip["strUnit"]."</td>";
				echo "<td class=\"normalfntRiteTAB\">".number_format($row_Descrip["sngConPc"],4)."</td>";
				echo "<td class=\"normalfntMidTAB\">".$row_Descrip["sngWastage"]."%"."</td>";
				
				$buyerPO=$row_Descrip["strBuyerPONO"];
				$color=$row_Descrip["strColor"];
				$size=$row_Descrip["strSize"];
				
				
				if(($row_Descrip["strColor"]!='N/A') && ($row_Descrip["strSize"]=='N/A')){
					$sqlQty = "SELECT
					Sum(editedStyleRatio.dblExQty) as Qty
					FROM
					editedStyleRatio
					WHERE 
					editedStyleRatio.intOrderNo = '$ratioOrderNos' AND 
					editedStyleRatio.intStyleId =  '$strStyleID' AND
					editedStyleRatio.strBuyerPONO =  '$buyerPO' AND
					editedStyleRatio.strColor =  '$color'";
					$resultQty = $db->RunQuery($sqlQty); 	
					$rowQty = mysql_fetch_array($resultQty);
					$exQty = $rowQty["Qty"]; 
				}
				else if(($row_Descrip["strColor"]=='N/A') && ($row_Descrip["strSize"]!='N/A')){
					$sqlQty = "SELECT
					Sum(editedStyleRatio.dblExQty) as Qty
					FROM
					editedStyleRatio
					WHERE
					editedStyleRatio.intOrderNo = '$ratioOrderNos' AND 
					editedStyleRatio.intStyleId =  '$strStyleID' AND
					editedStyleRatio.strBuyerPONO =  '$buyerPO' AND
					editedStyleRatio.strSize =  '$size'";
					$resultQty = $db->RunQuery($sqlQty); 	
					$rowQty = mysql_fetch_array($resultQty);
					$exQty = $rowQty["Qty"]; 
				}
				else if(($row_Descrip["strColor"]=='N/A') && ($row_Descrip["strSize"]=='N/A')){
					 $sqlQty = "SELECT
					Sum(editedStyleRatio.dblExQty) as Qty
					FROM
					editedStyleRatio
					WHERE 
					editedStyleRatio.intOrderNo = '$ratioOrderNos' AND 
					editedStyleRatio.intStyleId =  '$strStyleID' AND
					editedStyleRatio.strBuyerPONO =  '$buyerPO'";
					$resultQty = $db->RunQuery($sqlQty); 	
					$rowQty = mysql_fetch_array($resultQty);
					$exQty = $rowQty["Qty"]; 
				}
				else{
					$exQty=$row_Descrip["dblExQty"];
				}
				echo "<td class=\"normalfntRiteTAB\">".number_format($exQty*$row_Descrip["sngConPc"],0)."</td>";	
							
				//echo "<td  style=\"display:none\" class=\"normalfntRiteTAB\">" . number_format(($row_Descrip["dblQty"] - $row_Descrip["dblBalQty"]),0) . "</td>";
				//echo "<td  style=\"display:none\" class=\"normalfntRiteTAB\">" . number_format($row_Descrip["dblBalQty"],0) ."</td>";
				echo "</tr>";
				
				$Count_Req_Qty+=$exQty*$row_Descrip["sngConPc"];
				$Count_Orderd_QTY+=($row_Descrip["dblQty"] - $row_Descrip["dblBalQty"]);
				$Count_Bal_Orederd+=$row_Descrip["dblBalQty"];
			}
		}
		$Count_Req_Qty=round($Count_Req_Qty,0);
	  ?>
		 <tr>
		   <td colspan="9" class="normalfntTAB">&nbsp;</td>
	    </tr>
		 <tr>
		   <td colspan="6" class="normalfntTAB"><strong>Grand Total </strong></td>
		   <td class="normalfntRiteTAB"><?php echo number_format($Count_Req_Qty,2); ?></td>
	    </tr>
	  </table>	</td>
   </tr> 
</table>
</table>
</body>
</html>
