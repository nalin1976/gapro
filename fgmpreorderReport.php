<?php 
session_start();
if(!$authenticationApplied)
	include "authentication.inc";
include "Connector.php";
$xml = simplexml_load_file('config.xml');
$ReportISORequired = $xml->companySettings->ReportISORequired;
$DisplayImageInApprovalCostSheet = $xml->PreOrder->DisplayImageInApprovalCostSheet;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Pre Order Cost : : Report</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="js/lightbox.js"></script>
<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
<body>

<table width="800" align="center">
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0"><tr><td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="24%"><img src="images/eplan_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
        <td width="1%" class="normalfnt">&nbsp;</td>
        <td width="55%" class="tophead" style="text-align:center"><p class="topheadBLACK" >
 		<?php		
		$CompanyID=0;
		$strStyleID=$_GET["styleID"];
		//$strStyleID="4500014458";
		$BuyerID=0;
		$intBuyingOfficeId=0;
		$UserID=0;
		$strCoordinator="";
		$intDivisionId=0;
		$intApprovalNo=0;
		$strOrderNo="0";
		$strDescription="";
		$intQty=0;
		$strCustomerRefNo=0;
		$intSeasonId=0;
		$strRPTMark="";
		$reaExPercentage=0;
		$reaEfficiencyLevel=0;
		$reaCostPerMinute=0.0000;
		$reaSMV=0.00;
		$reaSMVRate =0.00;
		$reaFinPercntage=0.0;
		$reaFOB=0.0;
		$reaProfit=0.0;

		$SQL="SELECT orders.strOrderNo, orders.intStyleId, orders.intCompanyID, orders.intStatus, orders.intBuyerID, orders.intBuyingOfficeId, orders.intUserID, orders.reaECSCharge, orders.intCoordinator, orders.intDivisionId, orders.intApprovalNo, orders.strDescription, orders.intQty, orders.strCustomerRefNo, orders.intSeasonId, orders.strRPTMark, orders.reaExPercentage, orders.reaEfficiencyLevel, orders.reaCostPerMinute, orders.reaSMV, orders.reaSMVRate, orders.reaFinPercntage, orders.reaFOB, orders.reaProfit
FROM orders
WHERE (((orders.intStyleId)='".$strStyleID."'));";
		$result = $db->RunQuery($SQL);
		
		while($row = mysql_fetch_array($result))
		{			
			$CompanyID=$row["intCompanyID"] ;
			$BuyerID=$row["intBuyerID"];
			$intBuyingOfficeId=$row["intBuyingOfficeId"];
			$UserID=$row["intUserID"];	
			$strCoordinator=$row["UserName"];	
			$intDivisionId=	$row["intDivisionId"];	
			$intApprovalNo=$row["intApprovalNo"];	
			$strOrderNo=$row["strOrderNo"];
			$strDescription=$row["strDescription"];
			$strCustomerRefNo=$row["strCustomerRefNo"];
			$intSeasonId=$row["intSeasonId"];
			$strRPTMark=$row["strRPTMark"];
			$reaEfficiencyLevel=$row["reaEfficiencyLevel"];
			$reaCostPerMinute=$row["reaCostPerMinute"];
			$reaSMV=$row["reaSMV"];
			$reaSMVRate=$row["reaSMVRate"];
			$reaFinPercntage=$row["reaFinPercntage"];
			$intQty=$row["intQty"];
			$reaFOB=$row["reaFOB"];
			$reaESC=$row["reaECSCharge"];
			$reaProfit=$row["reaProfit"];
			$reaExPercentage=$row["reaExPercentage"];
			$odrStatus  = $row["intStatus"]; 
		}
		
		$SQL="SELECT     companies.strName, companies.strAddress1, companies.strAddress2, companies.strStreet, companies.strCity,companies.strState, companies.strCountry, companies.strZipCode, companies.strPhone, companies.strEMail, companies.strFax,companies.strWeb, companies.intCompanyID, orders.intStyleId FROM companies CROSS JOIN orders WHERE (orders.intStyleId = '".$strStyleID."') AND (companies.intCompanyID = '".$CompanyID."')";	
		
		$result = $db->RunQuery($SQL);
		
		while($row = mysql_fetch_array($result))
		{			
			echo $row["strName"] ;
			echo "</p><p class=\"normalfntMid\">";
			echo $row["strAddress1"]." ".$row["strAddress2"]." ".$row["strStreet"]."<br>".$row["strCity"]." ".$row["strCountry"]." ".$row["strCountry"].". <br>"." Tel: ".$row["strPhone"]." Fax: ".$row["strFax"]." <br>E-Mail: ".$row["strEMail"]." Web: ".$row["strWeb"] ;
			echo "</p>";
		}
		 
		?>
          </td>
		  
		  		 <?php if($DisplayImageInApprovalCostSheet=="true"){?>
                <td width="20%" rowspan="2" class="normalfntMid">
				
				<?php
				 if (file_exists("styles/" . $_GET["styleID"] . ".jpg"))	
				 {
				?>				
				<a href="styles/<?php echo $_GET["styleID"]; ?>.jpg" rel="lightbox"><img src="styles/<?php echo $_GET["styleID"]; ?>.jpg" name="imgStyle" width="150" height="120" border="0" id="imgStyle" alt=""/></a>
				<?php
				}
				else
				{
				?>
				<a href="#"><img src="images/noimg.png" name="imgStyle" width="55" height="65" border="0" id="imgStyle" /></a>
				<?php
				}				
				?>				</td>
				<?php } ?>
				
      </tr>
    </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="36" colspan="5" class="head2"> <?php
			if($odrStatus == "0")
			{
				echo "Pre Order Cost Sheet";
			}
			else if($odrStatus == "10")
			{
				echo "Approval Pending - Cost Sheet";
			}
			else if($odrStatus == "11")
			{
				echo "Approved - Cost Sheet";
			}
			else if($odrStatus == "10")
			{
				echo "Rejected - Cost Sheet";
			}
		
   					if($ReportISORequired == "true")
   					{
   						$xmlISO = simplexml_load_file('iso.xml');
   						echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $xmlISO->ISOCodes->CostSheetReport;
						}              
	                 
                   ?> </td>
            </tr>
          <tr>
            <td width="19%" class="normalfnt2bldBLACK">BUYER</td>
            <td width="29%" class="normalfnt2Black">
            <?php
			
			$SQL="SELECT strName FROM  buyers WHERE (intBuyerID = ".$BuyerID.")";
			$result = $db->RunQuery($SQL);
			
			while($row = mysql_fetch_array($result))
			{
				echo $row["strName"] ;
						
			}
			?>
            
            </td>
            <td width="6%">&nbsp;</td>
            <td width="19%" class="normalfnt2bldBLACK">MERCHANDISER</td>
            <td width="27%" class="normalfnt2Black">
            <?php 			
			$SQL="SELECT Name FROM useraccounts WHERE (intUserID = ".$UserID.")";
			$result = $db->RunQuery($SQL);
			
			while($row = mysql_fetch_array($result))
			{
				echo $row["Name"]." Style Transfered From " ;
						
			}
			echo $strCoordinator;
			?>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td class="normalfnt2Black">&nbsp;</td>
            <td>&nbsp;</td>
            <td class="normalfnt2bldBLACK">APPROVAL NO</td>
            <td class="normalfnt2Black"><?php echo $intApprovalNo;?></td>
          </tr>
          <tr>
            <td class="normalfnt2bldBLACK">BUYING OFFICE</td>
            <td class="normalfnt2Black">
               <?php
			$SQL="SELECT strName FROM buyerbuyingoffices WHERE (intBuyingOfficeId = ".$intBuyingOfficeId.") AND (intBuyerID = ".$BuyerID.")";
			
			$result = $db->RunQuery($SQL);
			
			if($row = mysql_fetch_array($result))						
				echo $row["strName"] ;		
		
			?>
            </td>
            <td>&nbsp;</td>
            <td class="normalfnt2bldBLACK">DIVISION</td>
            <td class="normalfnt2Black">
            <?php 
				$SQL="SELECT strDivision FROM buyerdivisions WHERE (intDivisionId = ".$intDivisionId.")";
				
				$result = $db->RunQuery($SQL);
				
				while($row = mysql_fetch_array($result))
				{
					echo $row["strDivision"] ;	
					break ; 
				}
			?>
            </td>
          </tr>
          <tr>
            <td class="normalfnt2bldBLACK">STYLE NO</td>
            <td class="normalfnt2Black"><?php echo $strStyleID;?></td>
            <td rowspan="2">&nbsp;</td>
            <td class="normalfnt2bldBLACK">SEASON</td>
            <td class="normalfnt2Black">
            <?php 
			$SQL="SELECT  strSeason FROM seasons WHERE (strSeasonId = ".$intSeasonId.")";
			$result = $db->RunQuery($SQL);
			
			if($row = mysql_fetch_array($result))
			{
				echo $strSeason;
			}
			
			?>
            </td>
          </tr>
          <tr>
            <td class="normalfnt2bld">&nbsp;</td>
            <td class="normalfnt2">&nbsp;</td>
            <td class="normalfnt2bld">&nbsp;</td>
            <td class="normalfnt2">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="17%" height="20" bgcolor="#BED6E9" class="bcgl1txt1B">Order No</td>
            <td width="22%" bgcolor="#BED6E9" class="bcgl1txt1B">Description</td>
            <td width="13%" bgcolor="#BED6E9" class="bcgl1txt1B">Order QTY</td>
            <td width="16%" bgcolor="#BED6E9" class="bcgl1txt1B">Excess QTY%</td>
            <td width="18%" bgcolor="#BED6E9" class="bcgl1txt1B">Running Ref No:</td>
            <td colspan="2" bgcolor="#BED6E9" class="bcgl1txt1B">Initial/RPT </td>
          </tr>
          <tr>
            <td height="18" class="bcgl1txt1"><?php echo $strOrderNo; ?></td>
            <td class="bcgl1txt1"><?php echo $strDescription; ?></td>
            <td class="bcgl1txt1"><?php echo $intQty; ?></td>
            <td class="bcgl1txt1"><?php  echo $reaExPercentage; ?></td>
            <td class="bcgl1txt1"><?php echo $strCustomerRefNo; ?></td>
            <td colspan="2" class="bcgl1txt1"><?php echo $strRPTMark; ?></td>
          </tr>
          <tr>
            <td height="19" bgcolor="#BED6E9" class="bcgl1txt1B">Efficiency Level</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">Cost Per Used Minutes</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">SMV</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">$/SMV</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">Total Qty </td>
            <td width="14%" bgcolor="#BED6E9" class="bcgl1txt1B">&nbsp;</td>           
          </tr>
          <tr>
            <td height="20" class="bcgl1txt1">
			<?php echo $reaEfficiencyLevel."%";
			?></td>
            <td class="bcgl1txt1">
			<?php 			
			echo number_format(round($reaCostPerMinute,4));
			?>            </td>
            <td class="bcgl1txt1"><?php echo $reaSMV; ?></td>
            <td class="bcgl1txt1"><?php echo number_format($reaSMVRate,4); ?></td>
            <td class="bcgl1txt1"><?php
			$totalOrderQty= round($intQty + ($intQty * $reaExPercentage / 100));
			
			 echo $totalOrderQty;?></td>
            <td class="bcgl1txt1">&nbsp;</td>          
          </tr>    
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="tablez">
          <tr>
            <td width="3%" bgcolor="#CCCCCC" class="bcgl1txt1B">&nbsp;</td>
            <td width="24%" bgcolor="#CCCCCC" class="bcgl1txt1B">ITEM DESCRIPTION</td>
            <td width="5%" bgcolor="#CCCCCC" class="bcgl1txt1">Origin</td>
            <td width="8%" bgcolor="#CCCCCC" class="bcgl1txt1B">UNIT</td>
            <td width="7%" bgcolor="#CCCCCC" class="bcgl1txt1B">CON/PC</td>
            <td width="7%" bgcolor="#CCCCCC" class="bcgl1txt1B">REQ QTY</td>
            <td width="4%" bgcolor="#CCCCCC" class="bcgl1txt1">waste %</td>
			<td width="7%" bgcolor="#CCCCCC" class="bcgl1txt1">Freigt</td>
            <td width="11%" bgcolor="#CCCCCC" class="bcgl1txt1B">TOTAL QTY</td>
            <td width="7%" bgcolor="#CCCCCC" class="bcgl1txt1B">PRICE (USD)</td>
            <td width="10%" bgcolor="#CCCCCC" class="bcgl1txt1B">COST PC</td>
            <td width="8%" bgcolor="#CCCCCC" class="bcgl1txt1B">VALUE (USD)</td>
          </tr>
          <?php
		  $index=1;	//for print IndexNo
		  $loop=0;  //for MainCategories
		  $count=0;	//for USD Value
		  
		  $countusdValue=0.0;
		  $counttotalcostpc=0.0;
		  $totalMaterialcost=0.0;
		  $totalMeterialCostpc=0.0;
		  $strOriginType="";
				  
		  $FabFinance=0.0;
		  $TotFabFinance=0.0;
		  $TrimFinance=0.0;
		  $TotTrimFinance=0.0;
		  $CountFinanace=0.0;
		  $AvgFinanace=0.0;
		  $TotaleDrectCost=0.0;

		  
		  //Categories
		  $category = array();
		  
		  //Total CostPC Value
		  $costpc = array();
		  
		  //USD Value 
		  $valueusd= array();
			
		  //get MainCategories	(matmaincategory / orderdetails / matitemlist / itempurchasetype)
		  $SQL_Cetegory="SELECT DISTINCT matmaincategory.strDescription, matmaincategory.intID
						 FROM ((orderdetails INNER JOIN matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial) INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID) INNER JOIN itempurchasetype ON orderdetails.intOriginNo = itempurchasetype.intOriginNo
						 WHERE  orderdetails.intStyleId='$strStyleID'
						 ORDER BY matmaincategory.intID;";
						
						//echo $SQL_Cetegory;
			// FABRIC,ACCESSORIES & PACKING MATERIALS			 
			$result_Category = $db->RunQuery($SQL_Cetegory);
			while($row_Category = mysql_fetch_array($result_Category))
			{
				if($row_Category["strDescription"]=="FABRIC" | $row_Category["strDescription"]=="ACCESSORIES" | $row_Category["strDescription"]=="PACKING MATERIALS")
				{	
					$category[$loop]=$row_Category["strDescription"];		
					$loop++;
					
					echo "<tr>"."<td>&nbsp;</td><td class=\"normalfnt2BITAB\">";
					echo $row_Category["strDescription"];
					echo"</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>"; 					
					
					//(orderdetails / matmaincategory / matitemlist / itempurchasetype )
					
					$SQL_orderDetails="SELECT orderdetails.strOrderNo, orderdetails.intStyleId, orderdetails.strUnit, orderdetails.dblUnitPrice, orderdetails.reaConPc, orderdetails.reaWastage, orderdetails.strCurrencyID, orderdetails.intOriginNo, orderdetails.dblFreight ,orderdetails.dblTotalQty, orderdetails.dblReqQty, orderdetails.dblTotalValue, orderdetails.dbltotalcostpc, matitemlist.strItemDescription, matmaincategory.strDescription, itempurchasetype.strOriginType, matitemlist.intMainCatID, matitemlist.intItemSerial
					  			   FROM ((orderdetails INNER JOIN matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial) INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID) INNER JOIN itempurchasetype ON orderdetails.intOriginNo = itempurchasetype.intOriginNo
					  			   WHERE (((orderdetails.intStyleId)='".$strStyleID."') AND ((matitemlist.intMainCatID)='".$row_Category["intID"]."'))
					  			   ORDER BY matitemlist.intMainCatID;";
								  
					$result_order = $db->RunQuery($SQL_orderDetails);
					while($row_order = mysql_fetch_array($result_order))
					{
       					echo "<tr>";
						echo "<td class=\"normalfntTAB\">".$index."</td>";
						echo " <td class=\"normalfntTAB\">".$row_order["strItemDescription"]."</td>";
						$strOriginType=$row_order["strOriginType"];
						
						if($strOriginType=="IMP-F")
						{
							$strOriginType="I-F";							
						}
						else if($strOriginType=="IMP")
						{
							$strOriginType="I";
						}
						else if($strOriginType=="LOC-F")
						{
							$strOriginType="L-F";							
						}
						else											
							$strOriginType="L";
							
						//$TotFabFinance Value
						if($row_Category["strDescription"]=="FABRIC" & $row_order["strOriginType"]=="IMP-F")
						{
							$FabFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotFabFinance+=$FabFinance;
						}
						else if($row_Category["strDescription"]=="FABRIC" & $row_order["strOriginType"]=="LOC-F")
						{
							$FabFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotFabFinance+=$FabFinance;
						}
						
						//$TotTrimFinance Value
						if($row_Category["strDescription"]=="ACCESSORIES" & $row_order["strOriginType"]=="IMP-F")
						{
							$TrimFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotTrimFinance+=$TrimFinance;
						}
						else if($row_Category["strDescription"]=="ACCESSORIES" & $row_order["strOriginType"]=="LOC-F")
						{
							$TrimFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotTrimFinance+=$TrimFinance;
						}
						else if($row_Category["strDescription"]=="PACKING MATERIALS" & $row_order["strOriginType"]=="IMP-F")
						{
							$TrimFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotTrimFinance+=$TrimFinance;
						}
						else if($row_Category["strDescription"]=="PACKING MATERIALS" & $row_order["strOriginType"]=="LOC-F")
						{
							$TrimFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotTrimFinance+=$TrimFinance;
						}
							
						echo " <td class=\"normalfntMidTAB\">".$strOriginType."</td>";
						echo "<td class=\"normalfntMidTAB\">".$row_order["strUnit"]."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["reaConPc"],4)." </td>";				
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblReqQty"],0)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".$row_order["reaWastage"]."</td>";
						echo "<td class=\"normalfntRiteTAB\">".$row_order["dblFreight"]."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblTotalQty"],0)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblUnitPrice"],4)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dbltotalcostpc"],4)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblTotalValue"],4)."</td>";
						
						$countusdValue+=$row_order["dblTotalValue"];
						$counttotalcostpc+=$row_order["dbltotalcostpc"];
						
						echo "</tr>";
						
						$index=$index+1;					
						
					}
					
					echo "<tr>";
					echo "<td colspan=\"10\" class=\"normalfntBtab\">Total</td>";
					echo "<td class=\"nfhighlite1\">".number_format($counttotalcostpc,4)."</td>";
					echo "<td class=\"nfhighlite1\">".number_format($countusdValue,4)."</td>";
					echo "</tr>";
					
					$valueusd[$count]=$countusdValue;
					$costpc[$count]=round($counttotalcostpc,4);
					$count++;
					
					$totalMaterialcost+=$countusdValue;
					$totalMeterialCostpc+=$counttotalcostpc;
					
					$countusdValue=0.0;
					$counttotalcostpc=0.0;
					
					
					
				}	
							   
			}
				
				
				//SERVICES and OTHERS Categories
				
				$result_Category1 = $db->RunQuery($SQL_Cetegory);
				while($row_Category = mysql_fetch_array($result_Category1))
				{					
					if($row_Category["strDescription"]=="SERVICES" | $row_Category["strDescription"]=="OTHERS")
					{	
						$category[$loop]=$row_Category["strDescription"];		
						$loop++;
						
						echo "<tr>"."<td>&nbsp;</td><td class=\"normalfnt2BITAB\">";
						echo $row_Category["strDescription"];
						echo"</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
						
						$SQL_orderDetails="SELECT orderdetails.strOrderNo, orderdetails.intStyleId, orderdetails.strUnit, orderdetails.dblUnitPrice, orderdetails.reaConPc, orderdetails.reaWastage, orderdetails.strCurrencyID, orderdetails.intOriginNo, orderdetails.dblFreight, orderdetails.dblTotalQty, orderdetails.dblReqQty, orderdetails.dblTotalValue, orderdetails.dbltotalcostpc, matitemlist.strItemDescription, matmaincategory.strDescription, itempurchasetype.strOriginType, matitemlist.intMainCatID, matitemlist.intItemSerial
					  			   FROM ((orderdetails INNER JOIN matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial) INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID) INNER JOIN itempurchasetype ON orderdetails.intOriginNo = itempurchasetype.intOriginNo
					  			   WHERE (((orderdetails.intStyleId)='".$strStyleID."') AND ((matitemlist.intMainCatID)='".$row_Category["intID"]."'))
					  			   ORDER BY matitemlist.intMainCatID;";
						
						$result_order = $db->RunQuery($SQL_orderDetails);
						while($row_order = mysql_fetch_array($result_order))
						{
							echo "<tr>";
							echo "<td class=\"normalfntTAB\">".$index."</td>";
							echo " <td class=\"normalfntTAB\">".$row_order["strItemDescription"]."</td>";
							$strOriginType=$row_order["strOriginType"];
							
							if($strOriginType=="IMP-F")
							{
								$strOriginType="I-F";								
							}
							else if($strOriginType=="IMP")
							{
								$strOriginType="I";
							}
							else if($strOriginType=="LOC-F")
							{
								$strOriginType="L-F";						
							}
							else											
								$strOriginType="L";
								
						echo " <td class=\"normalfntMidTAB\">".$strOriginType."</td>";
						echo "<td class=\"normalfntMidTAB\">".$row_order["strUnit"]."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["reaConPc"],4)." </td>";				
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblReqQty"],4)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".$row_order["reaWastage"]."</td>";
						echo "<td class=\"normalfntRiteTAB\">".$row_order["dblFreight"]."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblTotalQty"],4)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblUnitPrice"],4)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dbltotalcostpc"],4)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblTotalValue"],4)."</td>";	
										
						$countusdValue+=$row_order["dblTotalValue"];
						$counttotalcostpc+=$row_order["dbltotalcostpc"];				
						
						
						echo "</tr>";
						
						$index++;
							
						}
							
							$valueusd[$count]=$countusdValue;	
						$costpc[$count]=round($counttotalcostpc,4);
						$count++;
						
					echo "<tr>";
					echo "<td colspan=\"10\" class=\"normalfntBtab\">Total</td>";
					echo "<td class=\"nfhighlite1\">".number_format($counttotalcostpc,4)."</td>";
					echo "<td class=\"nfhighlite1\">".number_format($countusdValue,4)."</td>";
					echo "</tr>";
					$countusdValue=0.0;
					$counttotalcostpc=0.0;		
					
				}
				
				
				
			}

		  ?>
          <tr>
            <td colspan="10" class="normalfntTAB">
            <?php
			echo "Finance + Economic Service " . $reaESC . " Finance ".number_format($reaFinPercntage,4)."%";
			echo "FAB Fin: ";
			echo "<span class=\"normalfnth2B\">";
			echo number_format($TotFabFinance,4);
			echo "</span>";
			echo " TRIM Fin: ";
			echo "<span class=\"normalfnth2B\">";
			echo number_format($TotTrimFinance,4);
			echo "</span>";
			?>            </td>
            <td class="normalfntRiteTAB">
			<?php 
			//$AvgFinanace=$CountFinanace/$intQty;
			//echo number_format($AvgFinanace,4);
			$CountFinanace=$TotFabFinance+$TotTrimFinance;
			echo number_format(($CountFinanace + $reaESC ),4);
			?></td>
            <td class="normalfntRiteTAB"><?php 
			$CountFinanace=$TotFabFinance+$TotTrimFinance;
			echo number_format((($CountFinanace + $reaESC) * $totalOrderQty),4);
			?></td>
          </tr>
          <tr>
            <td colspan="10" class="normalfntTAB">Total Direct Cost</td>
            
            <td class="normalfntRiteTAB"><?php 
			for($loops=0;$loops< count($costpc);$loops++)
			{	 
				$TotaleDrectCost+=$costpc[$loops];				
			}	
				echo number_format($TotaleDrectCost,4);
			
			?></td>
			<td colspan="10" class="normalfntRiteTAB"><?php echo number_format(($TotaleDrectCost * $totalOrderQty),4);?></td>
          </tr>
          <tr>
            <td colspan="10" class="normalfntTAB">C&amp;M Earned</td>
           
            <td class="normalfntRiteTAB"><?php
			// echo round($reaSMV*$reaSMVRate,4);
			//echo $TotaleDrectCost . "<br>";
			echo number_format(round($reaFOB   - ( $TotaleDrectCost + $reaESC  + ($TotFabFinance+$TotTrimFinance) + $reaProfit),4),4);
			?></td>
			 <td class="normalfntRiteTAB">
			<?php
			echo  number_format(round(round($reaFOB   - ( $TotaleDrectCost + $reaESC  + ($TotFabFinance+$TotTrimFinance) + $reaProfit),4)*( $intQty + ($intQty * $reaExPercentage / 100) ),4),4);
			?></td>
          </tr>
          <tr>
            <td colspan="10" class="normalfntTAB">Margin</td>
            <td class="normalfntRiteTAB">
            <?php
			echo number_format($reaProfit,4);
			?></td>
            <td class="normalfntRiteTAB"><?php
			echo number_format($reaProfit*$intQty,4);
			?></td>
          </tr>
          <tr>
            <td colspan="10" class="normalfnBLD1TAB">Target FOB</td>
            <td class="normalfntRiteTAB">
            <?php
			echo number_format($reaFOB,4);
			?></td>
            <td class="normalfntRiteTAB"><?php
			echo number_format($reaFOB*$intQty,4);
			?></td>
          </tr>
          <tr>
            <td colspan="9">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>       
      </tr>
      <tr>
        <td></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0">
      <tr>
        <td width="60%"><table width="100%" border="0" cellpadding="0">
          <tr>
            <td height="26" class="head1">Percentage Ratio</td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="50%" class="normalfntMidTAB">&nbsp;</td>
                <td width="25%" bgcolor="#CCCCCC" class="bcgl1txt1B">%</td>
                <td width="25%" bgcolor="#CCCCCC" class="bcgl1txt1B">Cost / PC</td>
              </tr>
              <?php			 	
				$totPresenttage=0.0;
				$Access_Pack=0.0;
				$Access_Packrange=0.0;
				
			  		for($loops=0;$loops< count($category);$loops++)
					{
						if($category[$loops]=="ACCESSORIES" | $category[$loops]=="PACKING MATERIALS")
						{
							$Access_Pack+=($costpc[$loops]/$TotaleDrectCost*100);
							$Access_Packrange+=$costpc[$loops];
						}
						echo "<tr>";
						echo "<td class=\"normalfntTAB\">". $category[$loops]."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format(round(($costpc[$loops]/$TotaleDrectCost*100),2),4)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($costpc[$loops],4)."</td>";
						echo "</tr>";
						$totPresenttage+=round(($costpc[$loops]/$TotaleDrectCost*100),2);
					}
			  	  
			  ?>              
              <tr>
                <td class="normalfntTAB">&nbsp;</td>
                <td class="nfhighlite1"><?php echo number_format($totPresenttage,4);?></td>
                <td class="normalfntRiteTAB">&nbsp;</td>
              </tr>
              <tr>
                <td class="normalfntTAB">ACCESSORIES+PACKING METERIALS</td>
                <td class="normalfntRiteTAB"><?php echo number_format($Access_Pack,4);?></td>
                <td class="normalfntRiteTAB"><?php echo number_format($Access_Packrange,4);?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="40%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<?php
//print_r($costpc);

//echo $reaFOB . '  - ( ' . $TotaleDrectCost . ' + ' . $reaESC . ' + (  ' . $TotFabFinance . ' * ' . $TotTrimFinance . ' / ' . '100)),4),4)';
/*echo "$reaSMV |  $reaSMVRate  |  $intQty <br>";
echo '$reaFOB   - ( $TotaleDrectCost + $reaESC  + ($TotFabFinance*$TotTrimFinance <br>';
echo $reaFOB   . " | " . $TotaleDrectCost  . "  |  " . $reaESC   . "  | " . $TotFabFinance  . "  | " . $TotTrimFinance;
*/?>
</body>
</html>
