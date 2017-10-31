<?php
include "authentication.inc";
include "Connector.php";
$xml = simplexml_load_file('config.xml');
$ReportISORequired = $xml->companySettings->ReportISORequired;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BOM - Item Status</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1100" border="0" align="center">
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="20%"><img src="images/GaPro_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
        <td width="6%" class="normalfnt">&nbsp;</td>
        <?php 
		
		$strStyleID=$_GET["styleID"];
		$subcontractor = $_GET["subcon"]; 
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
		$odrQty = 0;
		
		$SQL="SELECT orders.intStyleId, orders.intQty as odrQty, specification.intSRNO, orders.strDescription, useraccounts.Name, orders.intCompanyID, SUM(subcontractororders.intQty) AS subQty FROM subcontractororders INNER JOIN orders
ON orders.intStyleId = subcontractororders.intStyleId 
INNER JOIN specification ON specification.intStyleId =  orders.intStyleId 
 INNER JOIN useraccounts ON orders.intUserID = useraccounts.intUserID
 WHERE subcontractororders.intStyleId = '$strStyleID' AND intSubContractorID = '$subcontractor'";
     // echo $SQL;
		$result = $db->RunQuery($SQL);
		
		while($row = mysql_fetch_array($result))
		{
			$intQty=$row["subQty"];
			$intSRNO=$row["intSRNO"];
			$strDescription=$row["strDescription"];
			$usrnme=$row["Name"];
			$intCompanyID=$row["intCompanyID"];
			$odrQty = $row["odrQty"];
		}

		echo "<td width=\"74%\" class=\"tophead\">";
		echo "<p class=\"topheadBLACK\">";
		
		$Company="SELECT strName, strAddress1,strAddress2,strStreet,strState,strCity,strCountry,strZipCode,strPhone,strEMail,strFax,strWeb FROM subcontractors
 WHERE intSubContractorID = '$subcontractor';
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
		echo "E-Mail : ".$strEMail." Web: ".$strWeb."</p>";
		echo "</td>";
		echo "</tr>";
		?>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="36" colspan="7" class="head2">SUB CONTRACT BILL OF MATERIAL - ITEM STATUS <?php
   					if($ReportISORequired == "true")
   					{
   						$xmlISO = simplexml_load_file('iso.xml');
   						echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $xmlISO->ISOCodes->BOMReport;
						}              
	                 
                   ?> </td>
      </tr>
      <tr>
        <td width="19%" class="normalfnth2B">STYLE NO</td>
        <td colspan="3" class="normalfnt"><?php echo $strStyleID;?></td>
        <td width="6%">&nbsp;</td>
        <td width="19%" class="normalfnth2B">DISCRIPTION</td>
        <td width="27%" class="normalfnt"><?php echo $strDescription;?></td>
      </tr>
      <tr>
        <td height="13" class="normalfnth2B">SC NO</td>
        <td colspan="3" class="normalfnt"><?php echo $intSRNO;?></td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">MERCHANDISER</td>
        <td class="normalfnt"><?php echo $usrnme;?></td>
      </tr>
      <tr>
        <td height="13" class="normalfnth2B">SUB CONTRACTOR QTY</td>
        <td width="10%" class="normalfnt"><?php echo $intQty;?></td>
        <td width="9%" class="normalfnth2B"></td>
        <td width="10%" class="normalfnt"></td>
        <td>&nbsp;</td>
        <td class="normalfnth2B"></td>
        <td class="normalfnt"></td>
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
          <td width="100" class="normalfntBtab">BuyerPoNo</td>
          <td width="100" class="normalfntBtab">Qty</td>
        </tr>
		<?php
		$sql = "SELECT strBuyerPONO,intQty,deliveryDate FROM subcontractororders WHERE intStyleId = '$strStyleID' AND intSubContractorID = '$subcontractor'";
		$result = $db->RunQuery($sql); 	
		$totqty = 0;
		while($row = mysql_fetch_array($result))
		{			
			?>
			<tr>
			<td class="normalfntTAB"><?php echo date("jS F Y", strtotime($row["deliveryDate"]))  ?></td>
			<td class="normalfntTAB"><?php echo $row["strBuyerPONO"];  ?></td>
			<td class="normalfntRiteTAB"><?php echo $row["intQty"];  ?></td>
		</tr>			
			<?php
			
			
			$totqty += $row["intQty"]; 
		}
		
		?>
		<tr>
		  <td colspan="2" class="normalfntMidTAB">Total</td>
		  <td class="normalfntRiteTAB"><?php echo round($totqty);  ?></td>
	    </tr>
    </table></td>
    <td>&nbsp; </td>
  </tr>
  
  <TR>
  <TD class="normalfnth2B"> Item Details  </TD>
  </TR>
  <tr>
    <td>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
      <tr>
        <td width="31%" class="normalfntBtab">ITEM</td>
        <td width="9%" class="normalfntBtab">Buyer PO</td>
        <td width="9%" class="normalfntBtab">Color</td>
        <td width="5%" class="normalfntBtab">Size</td>
        <td width="5%" class="normalfntBtab">Unit</td>
        <td width="8%" class="normalfntBtab">Con/Pc</td>
        <td width="7%" class="normalfntBtab">Waste %</td>
        <td width="8%" class="normalfntBtab">Req. Qty</td>        
       <!--  <td width="8%" class="normalfntBtab">Orderd Qty</td>
        <td width="10%" class="normalfntBtab">BAL TO ORDER</td> -->
        </tr>
     
      <tr>
      <?php
	 	$Count_Req_Qty=0;
		$Count_Orderd_QTY=0;
		$Count_Bal_Orederd=0;
	  
	  $SQL_Category="SELECT DISTINCT matmaincategory.strDescription, matmaincategory.intID
FROM (orderdetails INNER JOIN matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial) INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID
WHERE (((orderdetails.intStyleId)='". $strStyleID."'))
ORDER BY matmaincategory.intID;
";

//echo $SQL_Category;

		$result_Category= $db->RunQuery($SQL_Category);
		while($row_Category = mysql_fetch_array($result_Category))
		{
		echo "<td height=\"20\" class=\"normalfnt2BITAB\">".$row_Category["strDescription"]."</td>";
		echo "<td>&nbsp;</td>"."<td>&nbsp;</td>"."<td>&nbsp;</td>"."<td>&nbsp;</td>"."<td>&nbsp;</td>";
		echo "<td>&nbsp;</td>"."</tr>";
		
			$Item="SELECT materialratio.intStyleId,  materialratio.strBuyerPONO, materialratio.strColor, materialratio.strSize, materialratio.dblQty, materialratio.dblBalQty, specificationdetails.strUnit, specificationdetails.sngConPc, matitemlist.strItemDescription, specificationdetails.sngWastage
FROM ((materialratio INNER JOIN matitemlist ON materialratio.strMatDetailID = matitemlist.intItemSerial) INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID) INNER JOIN specificationdetails ON materialratio.intStyleId = specificationdetails.intStyleId AND materialratio.strMatDetailID = specificationdetails.strMatDetailID
WHERE (((materialratio.intStyleId)='". $strStyleID."') AND ((matmaincategory.intID)=".$row_Category["intID"]."));";

			
			$result_Description= $db->RunQuery($Item);
			while($row_Descrip = mysql_fetch_array($result_Description))
			{
				echo "<tr>";
				echo "<td class=\"normalfntTAB\">".$row_Descrip["strItemDescription"]."</td>";
				echo "<td class=\"normalfntMidTAB\">".$row_Descrip["strBuyerPONO"]."</td>";
				echo "<td class=\"normalfntMidTAB\">".$row_Descrip["strColor"]."</td>";
				echo "<td class=\"normalfntMidTAB\">".$row_Descrip["strSize"]."</td>";
				echo "<td class=\"normalfntMidTAB\">".$row_Descrip["strUnit"]."</td>";
				echo "<td class=\"normalfntRiteTAB\">".number_format($row_Descrip["sngConPc"],4)."</td>";
				echo "<td class=\"normalfntMidTAB\">".$row_Descrip["sngWastage"]."%"."</td>";
				echo "<td class=\"normalfntRiteTAB\">".number_format(($row_Descrip["dblQty"] / $odrQty * $intQty ) ,4)."</td>";				
				//echo "<td class=\"normalfntRiteTAB\">" . number_format(($row_Descrip["dblQty"] - $row_Descrip["dblBalQty"]),4) . "</td>";
				//echo "<td class=\"normalfntRiteTAB\">" . number_format($row_Descrip["dblBalQty"],4) ."</td>";
				echo "</tr>";
				
				$Count_Req_Qty+=($row_Descrip["dblQty"] / $odrQty * $intQty );
				//$Count_Orderd_QTY+=($row_Descrip["dblQty"] - $row_Descrip["dblBalQty"]);
				//$Count_Bal_Orederd+=$row_Descrip["dblBalQty"];
			}
		}
		
	  ?>
		 <tr>
		   <td colspan="7" class="normalfntTAB">&nbsp;</td>
	    </tr>
		 <tr>
		   <td colspan="7" class="normalfntTAB"><strong>Grand Total </strong></td>
		   <td class="normalfntRiteTAB"><?php echo number_format($Count_Req_Qty,4); ?></td>
		<!--    <td class="normalfntRiteTAB"><?php echo number_format($Count_Orderd_QTY,4); ?></td>
		   <td class="normalfntRiteTAB"><?php echo number_format($Count_Bal_Orederd,4); ?></td> -->
	    </tr>
	  </table>	</td>
   </tr> 
</table>
</table>
</body>
</html>
