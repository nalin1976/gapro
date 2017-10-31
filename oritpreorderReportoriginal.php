<?php 
session_start();
if(!$authenticationApplied)
	include "authentication.inc";
include "Connector.php";
$xml = simplexml_load_file('config.xml');
$ReportISORequired = $xml->companySettings->ReportISORequired;
$BuyingOfficeMargin = $xml->companySettings->BuyingOfficeMargin;
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
		$mobileProfit = 0;
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
		$costinglabourCost = 0;
		$oderDate = "";
		$subcontractQty = 0;
//DATE_FORMAT(orders.dtmDate, '%Y %b %d')
		$SQL="SELECT orders.strOrderNo, orders.intStyleId, DATE_FORMAT(orders.dtmDate, '%Y-%b-%d')  AS dtmDate,date(orders.dtmDate) as orderDate,  orders.intCompanyID, orders.intBuyerID, orders.intStatus , orders.reaLabourCost , orders.intBuyingOfficeId, orders.intUserID, orders.reaECSCharge, orders.intCoordinator, orders.intDivisionId, orders.intApprovalNo, orders.strDescription, orders.intQty, orders.strCustomerRefNo, orders.intSeasonId, orders.strRPTMark, orders.reaExPercentage, orders.reaEfficiencyLevel, orders.reaCostPerMinute, orders.reaSMV, orders.reaSMVRate, orders.reaFinPercntage, orders.reaFOB, orders.reaProfit,orders.dblFacProfit,intCompanyOrderNo,dtmOrderDate
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
			$costinglabourCost = $row["reaLabourCost"]; 
			$odrStatus  = $row["intStatus"];
			$oderDate = $row["dtmDate"]; 
			$facProfit = $row["dblFacProfit"];
			$orderDate	= $row["orderDate"];
			$companyOrderNo	= $row["intCompanyOrderNo"];
			$companyOrderDate	= $row["dtmOrderDate"];
			//$companycostperminute = $row["reaFactroyCostPerMin"];
		}
		
		$SQL="SELECT     companies.strName, companies.strAddress1, companies.strAddress2, companies.strStreet, companies.strCity,companies.strState, companies.strCountry, companies.strZipCode, companies.strPhone, companies.strEMail, companies.strFax,companies.strWeb, companies.intCompanyID, orders.intStyleId FROM companies CROSS JOIN orders WHERE (orders.intStyleId = '".$strStyleID."') AND (companies.intCompanyID = '".$CompanyID."')";	
		
		$result = $db->RunQuery($SQL);
		
		while($row = mysql_fetch_array($result))
		{			
			echo $row["strName"] ;
			echo "</p><p class=\"normalfnt\">";
			echo $row["strAddress1"]." ".$row["strAddress2"]." ".$row["strStreet"]." ".$row["strCity"]." ".$row["strCountry"]." ".$row["strCountry"].". <br>"." Tel: ".$row["strPhone"]." Fax: ".$row["strFax"]." <br>E-Mail: ".$row["strEMail"]." Web: ".$row["strWeb"] ;
			echo "</p>";
		}
		 $report_companyId = $CompanyID;
		?>
        <td colspan="2"><?php include 'reportHeader.php'?></td>
        
       <!-- <td width="20%" class="tophead"><p class="topheadBLACK">
 		
          </td>-->
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
            <td height="36" colspan="7" class="head2">
            <?php
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
			else if($odrStatus == "13")
			{
				echo "Completed - Cost Sheet";
			}
			
   					if($ReportISORequired == "true")
   					{
   						$xmlISO = simplexml_load_file('iso.xml');
   						echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $xmlISO->ISOCodes->CostSheetReport;
						}              
	                 
                   ?> </td>
            </tr>
          <tr>
            <td width="17%" class="bcgl1txt1NB">BUYER</td>
            <td width="1%" class="normalfnt2Black"><b>:</b></td>
            <td width="33%" class="normalfnt2Black">
            <?php
			
			$SQL="SELECT strName,strDtFormat FROM  buyers WHERE (intBuyerID = ".$BuyerID.")";
			$result = $db->RunQuery($SQL);
			
			while($row = mysql_fetch_array($result))
			{
				echo $row["strName"] ;
				$dateFormat = $row["strDtFormat"] ;
						
			}
			?>            </td>
            <td width="1%">&nbsp;</td>
            <td width="16%" class="bcgl1txt1NB">MERCHANDISER</td>
            <td width="1%" class="bcgl1txt1NB"><b>:</b></td>
            <td width="31%" class="normalfnt2Black">
            <?php 			
			$SQL="SELECT Name FROM useraccounts WHERE (intUserID = ".$UserID.")";
			$result = $db->RunQuery($SQL);
			
			while($row = mysql_fetch_array($result))
			{
				echo $row["Name"] ;
						
			}
			
			if($strCoordinator != '')
				echo " Style Transferred From ".$strCoordinator;
			?>            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td class="normalfnt2Black">&nbsp;</td>
            <td class="normalfnt2Black">&nbsp;</td>
            <td>&nbsp;</td>
            <td class="bcgl1txt1NB">APPROVAL NO</td>
            <td class="bcgl1txt1NB"><b>:</b></td>
            <td class="normalfnt2Black"><?php echo $intApprovalNo;?></td>
          </tr>
          <tr>
            <td class="bcgl1txt1NB">BUYING OFFICE</td>
            <td class="normalfnt2Black"><b>:</b></td>
            <td class="normalfnt2Black">
               <?php
			$SQL="SELECT strName FROM buyerbuyingoffices WHERE (intBuyingOfficeId = ".$intBuyingOfficeId.") AND (intBuyerID = ".$BuyerID.")";
			
			$result = $db->RunQuery($SQL);
			
			if($row = mysql_fetch_array($result))						
				echo $row["strName"] ;		
		
			?>            </td>
            <td>&nbsp;</td>
            <td class="bcgl1txt1NB">DIVISION</td>
            <td class="bcgl1txt1NB"><b>:</b></td>
            <td class="normalfnt2Black">
            <?php 
				$SQL="SELECT strDivision FROM buyerdivisions WHERE (intDivisionId = ".$intDivisionId.")";
				
				$result = $db->RunQuery($SQL);
				
				while($row = mysql_fetch_array($result))
				{
					echo $row["strDivision"] ;	
					break ; 
				}
			?>            </td>
          </tr>
          <tr>
            <td class="bcgl1txt1NB">STYLE NO</td>
            <td class="normalfnt2Black"><b>:</b></td>
            <td class="normalfnt2Black">
			<?php 
				$sql_style = "select strStyle from orders where intStyleId='$strStyleID'";				
				$result_style = $db->RunQuery($sql_style);
				$row_style = mysql_fetch_array($result_style);
				echo $row_style["strStyle"];	
			?></td>
            <td rowspan="2">&nbsp;</td>
            <td class="bcgl1txt1NB">SEASON</td>
            <td class="bcgl1txt1NB"><b>:</b></td>
            <td class="normalfnt2Black">
            <?php 
			$SQL="SELECT  strSeason FROM seasons WHERE (intSeasonId = ".$intSeasonId.")";			
			$result = $db->RunQuery($SQL);
			
			if($row = mysql_fetch_array($result))
			{
				echo $row["strSeason"];
			}
			
			?>            </td>
          </tr>
          <tr>
            <td class="normalfnt2bld">&nbsp;</td>
            <td class="normalfnt2">&nbsp;</td>
            <td class="normalfnt2">&nbsp;</td>
            <td class="normalfnt2bld">&nbsp;</td>
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
            <td width="16%" bgcolor="#BED6E9" class="bcgl1txt1B">Excess QTY</td>
            <td width="18%" bgcolor="#BED6E9" class="bcgl1txt1B">Internal Order  No</td>
            <td colspan="2" bgcolor="#BED6E9" class="bcgl1txt1B">Initial/RPT Status </td>
          </tr>
          <tr>
            <td height="18" class="bcgl1txt1"><?php echo $strOrderNo; ?></td>
            <td class="bcgl1txt1"><?php echo $strDescription; ?></td>
            <td class="bcgl1txt1"><?php echo $intQty; ?></td>
            <td class="bcgl1txt1"><?php  echo $reaExPercentage; ?>%</td>
            <td class="bcgl1txt1"><?php 
			$arraycompanyOrderDate = explode('-',$companyOrderDate);
			echo $arraycompanyOrderDate[0].''.$arraycompanyOrderDate[1].''.$companyOrderNo; ?></td>
            <td colspan="2" class="bcgl1txt1">
			<?php 
				if($strRPTMark=="")
					echo "INITIAL";
				else
					echo $strRPTMark; 
			?></td>
          </tr>
          <tr>
            <td height="19" bgcolor="#BED6E9" class="bcgl1txt1B">Efficiency Level</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">Cost Per Used Minutes</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">SMV</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">$/SMV</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">Total Qty </td>
            <td width="14%" bgcolor="#BED6E9" class="bcgl1txt1B">Date</td>           
          </tr>
          <tr>
            <td height="20" class="bcgl1txt1">
			<?php echo $reaEfficiencyLevel."%";
			?></td>
            <td class="bcgl1txt1"><?php 			
			echo number_format(round($reaCostPerMinute,4));
			?></td>
            <td class="bcgl1txt1"><?php echo $reaSMV; ?></td>
            <td class="bcgl1txt1"><?php echo number_format($reaSMVRate,4); ?></td>
            <td class="bcgl1txt1"><?php
			$totalOrderQty= round($intQty + ($intQty * $reaExPercentage / 100));
			
			 echo $totalOrderQty;?></td>
            <td class="bcgl1txt1"><?php 
					$dFormatFletter = substr($dateFormat,0,1);
					$arrDformat = explode('-',$dateFormat);
					$arrOdate = explode('-',$oderDate);
					if($dFormatFletter == 'm' || $dFormatFletter == 'M')
					{
						$formatOrderDate = $arrOdate[1].'-'.$arrOdate[2].'-'.$arrOdate[0];
					}
					else if($dFormatFletter == 'd' || $dFormatFletter == 'D')
					{
						$formatOrderDate = $arrOdate[2].'-'.$arrOdate[1].'-'.$arrOdate[0];
					}
					else 
					{
						$formatOrderDate = $oderDate;
					}
			echo $formatOrderDate; ?></td>          
          </tr>    
          <tr>
            <td height="20" bgcolor="#BED6E9" class="bcgl1txt1B">Profit </td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">Factory OH Per Used Minute</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">GP / FOB</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B" >GP/CM</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">&nbsp;</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B" ></td>          
          </tr>    
          <tr><?php
		  $labrate = 0;
		   $netmargin = ($cmVal) - ($reaFOB * 0.05) - $labrate;
		  			$cmVal = round($upcharge + $reaFOB   - ( $TotaleDrectCost),4);
			//echo number_format($cmVal,4);
			$mobileCMUp = number_format($cmVal,4);
			$labsuboverheadcost = 0;
			$subcontractcost = 0;
			$labrate = (($labsuboverheadcost * ($totalOrderQty - $subcontractQty) / $totalOdrQty)) + (($subcontractcost * $subcontractQty)/ $totalOdrQty); ?>
            <td class="bcgl1txt1" id="npfob" >&nbsp;</td>
            <td class="bcgl1txt1" id="ohpm">&nbsp;</td>
            <td class="bcgl1txt1" id="gpfob">&nbsp; </td>
            <td class="bcgl1txt1" id="gpcm">&nbsp;</td>
            <td class="bcgl1txt1" >&nbsp;</td>
            <td class="bcgl1txt1" colspan="2">&nbsp;</td>
          </tr>
          <tr>
          <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="tablez">
        <thead>
          <tr>
            <td width="3%" bgcolor="#CCCCCC" class="bcgl1txt1B">&nbsp;</td>
            <td width="24%" bgcolor="#CCCCCC" class="bcgl1txt1B">ITEM DESCRIPTION</td>
            <td width="5%" bgcolor="#CCCCCC" class="bcgl1txt1">Origin</td>
            <td width="8%" bgcolor="#CCCCCC" class="bcgl1txt1B">UNIT</td>
            <td width="7%" bgcolor="#CCCCCC" class="bcgl1txt1B">CON/PC</td>
            <td width="7%" bgcolor="#CCCCCC" class="bcgl1txt1B">REQ QTY</td>
            <td width="4%" bgcolor="#CCCCCC" class="bcgl1txt1">waste %</td>
			<td width="7%" bgcolor="#CCCCCC" class="bcgl1txt1">Freight</td>
            <td width="11%" bgcolor="#CCCCCC" class="bcgl1txt1B">TOTAL QTY</td>
            <td width="7%" bgcolor="#CCCCCC" class="bcgl1txt1B">PRICE (USD)</td>
            <td width="10%" bgcolor="#CCCCCC" class="bcgl1txt1B">Total COST PC</td>
            <td width="8%" bgcolor="#CCCCCC" class="bcgl1txt1B">VALUE (USD)</td>
          </tr>
          </thead>
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
					
					$SQL_orderDetails="SELECT orderdetails.strOrderNo, orderdetails.intStyleId, orderdetails.strUnit, orderdetails.dblUnitPrice, orderdetails.reaConPc, orderdetails.reaWastage, orderdetails.strCurrencyID, orderdetails.intOriginNo, orderdetails.dblFreight ,orderdetails.dblTotalQty, orderdetails.dblReqQty, orderdetails.dblTotalValue, orderdetails.dbltotalcostpc, matitemlist.strItemDescription, matmaincategory.strDescription, itempurchasetype.strOriginType, matitemlist.intMainCatID, matitemlist.intItemSerial,itempurchasetype.intType
					  			   FROM ((orderdetails INNER JOIN matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial) INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID) INNER JOIN itempurchasetype ON orderdetails.intOriginNo = itempurchasetype.intOriginNo
					  			   WHERE (((orderdetails.intStyleId)='".$strStyleID."') AND ((matitemlist.intMainCatID)='".$row_Category["intID"]."'))
					  			   ORDER BY matitemlist.intMainCatID,matitemlist.strItemDescription;";
								  
					$result_order = $db->RunQuery($SQL_orderDetails);
					while($row_order = mysql_fetch_array($result_order))
					{
       					echo "<tr>";
						echo "<td class=\"normalfntTAB\">".$index."</td>";
						echo " <td class=\"normalfntTAB\">".$row_order["strItemDescription"]."</td>";
						
						//$strOriginType=$row_order["strOriginType"];
						
						/*if($strOriginType=="IMP-F")
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
							$strOriginType="L";*/
						//finance based on the type of itempurchase type.	
						/*$strOriginType=$row_order["intType"];	
						if($strOriginType=="0")
						{
							$strOriginType="F";							
						}
						else
						{
							$strOriginType="L";
						}	*/
							
						//$TotFabFinance Value
						//if($row_Category["strDescription"]=="FABRIC" & $row_order["strOriginType"]=="IMP-F")
						if($row_Category["strDescription"]=="FABRIC" & $row_order["intType"]=="0")
						{
							$FabFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotFabFinance+=$FabFinance;
						}
						/*else if($row_Category["strDescription"]=="FABRIC" & $row_order["intType"]=="LOC-F")
						{
							$FabFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotFabFinance+=$FabFinance;
						}*/
						
						//$TotTrimFinance Value
						if($row_Category["strDescription"]=="ACCESSORIES" & $row_order["intType"]=="0")
						{
							$TrimFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotTrimFinance+=$TrimFinance;
						}
						/*else if($row_Category["strDescription"]=="ACCESSORIES" & $row_order["strOriginType"]=="LOC-F")
						{
							$TrimFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotTrimFinance+=$TrimFinance;
						}*/
						else if($row_Category["strDescription"]=="PACKING MATERIALS" & $row_order["intType"]=="0")
						{
							$TrimFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotTrimFinance+=$TrimFinance;
						}
						/*else if($row_Category["strDescription"]=="PACKING MATERIALS" & $row_order["strOriginType"]=="LOC-F")
						{
							$TrimFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotTrimFinance+=$TrimFinance;
						}*/
							//number_format($row_order["dblReqQty"],4)
						echo " <td class=\"normalfntMidTAB\">".$row_order["strOriginType"]."</td>";
						echo "<td class=\"normalfntMidTAB\">".$row_order["strUnit"]."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["reaConPc"],4)." </td>";				
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblReqQty"],0)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["reaWastage"],2)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblFreight"],4)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblTotalQty"],0)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblUnitPrice"],4)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dbltotalcostpc"],4)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblTotalValue"],4)."</td>";
						
						$countusdValue+=$row_order["dblTotalValue"];
						$counttotalcostpc+=round($row_order["dbltotalcostpc"],4);
						
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
					if($row_Category["strDescription"]=="SERVICES" | $row_Category["strDescription"]=="OTHERS" | $row_Category["strDescription"]=="WASHING")
					{	
						$category[$loop]=$row_Category["strDescription"];		
						$loop++;
						
						echo "<tr>"."<td>&nbsp;</td><td class=\"normalfnt2BITAB\">";
						echo $row_Category["strDescription"];
						echo"</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
						
						$SQL_orderDetails="SELECT orderdetails.strOrderNo, orderdetails.intStyleId, orderdetails.strUnit, orderdetails.dblUnitPrice, orderdetails.reaConPc, orderdetails.reaWastage, orderdetails.strCurrencyID, orderdetails.intOriginNo, orderdetails.dblFreight, orderdetails.dblTotalQty, orderdetails.dblReqQty, orderdetails.dblTotalValue, orderdetails.dbltotalcostpc, matitemlist.strItemDescription, matmaincategory.strDescription, itempurchasetype.strOriginType, matitemlist.intMainCatID, matitemlist.intItemSerial,itempurchasetype.intType
					  			   FROM ((orderdetails INNER JOIN matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial) INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID) INNER JOIN itempurchasetype ON orderdetails.intOriginNo = itempurchasetype.intOriginNo
					  			   WHERE (((orderdetails.intStyleId)='".$strStyleID."') AND ((matitemlist.intMainCatID)='".$row_Category["intID"]."'))
					  			   ORDER BY matitemlist.intMainCatID,matitemlist.strItemDescription ;";
						
						$result_order = $db->RunQuery($SQL_orderDetails);
						while($row_order = mysql_fetch_array($result_order))
						{
							echo "<tr>";
							echo "<td class=\"normalfntTAB\">".$index."</td>";
							echo " <td class=\"normalfntTAB\">".$row_order["strItemDescription"]."</td>";
							$strOriginType=$row_order["strOriginType"];
							
							/*if($strOriginType=="IMP-F")
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
								$strOriginType="L";*/
								
						/*$strOriginType=$row_order["intType"];	
						if($strOriginType=="0")
						{
							$strOriginType="F";							
						}
						else
						{
							$strOriginType="L";
						}	*/
								
						echo " <td class=\"normalfntMidTAB\">".$row_order["strOriginType"]."</td>";
						echo "<td class=\"normalfntMidTAB\">".$row_order["strUnit"]."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["reaConPc"],4)." </td>";				
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblReqQty"],0)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".$row_order["reaWastage"]."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblFreight"],4)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblTotalQty"],0)."</td>";
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
			echo "Finance + Economic Service " . $reaESC .'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'. " Finance ".number_format($reaFinPercntage,4)."%";
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'."FAB Fin: ";
			echo "<span class=\"normalfnth2B\">";
			$totalFabFinance = round($TotFabFinance*$totalOrderQty,2);
			echo number_format($totalFabFinance,2);
			echo "</span>";
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'." TRIM Fin: ";
			echo "<span class=\"normalfnth2B\">";
			$totalTrimFinance = round($TotTrimFinance*$totalOrderQty,2);
			echo number_format($totalTrimFinance,2);
			echo "</span>";
			?>            </td>
            <td class="normalfntRiteTAB"><?php 
				$CountFinanace=round($totalFabFinance+$totalTrimFinance,4);
			//echo number_format(($CountFinanace/$intQty),4);
			echo number_format(($CountFinanace/$totalOrderQty+$reaESC),4);
				$totFinance = number_format(($CountFinanace + $reaESC ),4);
			?></td>
            <td class="normalfntRiteTAB"><?php 
			//$CountFinanace=$totalFabFinance+$totalTrimFinance;
			//echo number_format($CountFinanace,4); 16-11-2011 need to esc charge
			$A	= round(($CountFinanace/$totalOrderQty)+$reaESC,4);
			echo number_format($A*$totalOrderQty,4);
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
           
           <?php
          	$buyingOfficeProfit = $CMVAL - $costinglabourCost;
         	$requiredMinimumCM = ($CMVAL * $BuyingOfficeMargin / 100);
         	$bgColor = "";
         	if($buyingOfficeProfit < $requiredMinimumCM && $odrStatus == 10)
         		$bgColor = " bgcolor=\"#FF0000\" ";
          ?>
          <tr <?php echo $bgColor; ?>>
            <td colspan="10" class="normalfntTAB">C&amp;M Earned </td>
           
            <td class="normalfntRiteTAB"><?php
			echo number_format($reaSMV*$reaSMVRate,4);
			?></td>
			 <td class="normalfntRiteTAB">
			<?php
			echo number_format((($reaSMV*$reaSMVRate)*$intQty),4);
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
		              <td colspan="10" class="normalfnBLD1TAB">REQD FOB</td>
		              <td class="normalfntRiteTAB"><?php $ReqFOB = $reaFOB - $facProfit;
					  echo number_format($ReqFOB,4);
					  ?></td>
		              <td class="normalfntRiteTAB">&nbsp;</td>
              </tr>
		            <tr>
            <td colspan="10" class="normalfnBLD1TAB">Gross Profit</td>
            <td class="normalfntRiteTAB">
            <?php
			//echo "($reaFOB-($CMVAL+$TotaleDrectCost+$totFinance)";
			//start 2010-08-05 commented for orit----------------------------------------
			//echo number_format(($reaFOB-($CMVAL+$TotaleDrectCost+$totFinance)),4);
			echo number_format($facProfit,4);
			//-------------------end--------------------------------------------
			?></td>
            <td class="normalfntRiteTAB"><?php
			echo number_format(($facProfit*$intQty),4);
			?></td>
          </tr>
          <tr>
            <td colspan="9">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
			<td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="12"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez" >
              <tr>
                <td width="18%"  bgcolor="#CCCCCC" class="border-All-fntsize9">C &amp; M EARNED</td>
                <td width="5%"  class="border-top-bottom-right">&nbsp;</td>
				<td width="6%"  class="border-top-bottom-fntsize9">SMV 1</td>
                <td width="6%"  class="border-top-bottom-right"><div class="normalfntRite"><?php echo $reaSMV;?></div></td>
                <td width="7%" class="border-top-bottom-fntsize9">Effi % </td>
                <td width="5%" class="border-top-bottom-right"><div class="normalfntRite"><?php echo number_format($reaEfficiencyLevel,2);?></div></td>
                <td width="5%" class="border-top-bottom-fntsize9">Qty 1 </td>
                <td width="8%" class="border-top-bottom-right"><div class="normalfntRite"><?php echo $intQty; ?></div></td>
                <td width="6%" class="border-top-bottom-fntsize9">$/SMV</td>
                <td width="6%" class="border-top-bottom-right"><div class="normalfntRite"><?php echo number_format($reaSMVRate,4); ?></div></td>
                <td width="5%" class="border-top-bottom">$/UM</td>
                <td width="5%" class="border-top-bottom-right"><div class="normalfntRite">
				<?php 
					$um = ($reaSMV * $reaSMVRate)/($reaSMV/($reaEfficiencyLevel/100));  
					echo number_format($um,4);
				?></div></td>
                <td width="9%"   class="border-top-bottom-right"><div class="normalfntRite"><?php
					echo number_format($reaSMV*$reaSMVRate,4);
			?></div></td>
                <td width="9%" class="border-top-bottom-right"><div class="normalfntRite"><?php
			echo number_format((($reaSMV*$reaSMVRate)*$intQty),4);
			?></div></td>
              </tr>
              <tr>
                <td class="border-All-fntsize9"  bgcolor="#CCCCCC">INHOUSE LABOUR COST</td>
                <td   class="border-top-bottom-right-fntsize9">SMV 1</td>
                <td   class="border-top-bottom-fntsize9">OH/U.Min</td>
                <td width="6%"  class="border-top-bottom-right"><div class="normalfntRite"><?php echo number_format(round($reaCostPerMinute,4));?></div></td>
                <td  class="border-top-bottom-fntsize9">U.Min/Pc</td>
                <td width="5%"  class="border-top-bottom-right"><div class="normalfntRite">
				<?php 
				$MIn_Pc =  $reaSMV/($reaEfficiencyLevel/100);
				echo number_format($MIn_Pc,2);
				?></div></td>
                <td  class="border-top-bottom-fntsize9">OH/PC</td>
                <td width="8%"  class="border-top-bottom-right"><div class="normalfntRite"><?php echo number_format(($row["ohpc"]*100),2);?></div></td>
                <td   class="border-top-bottom-fntsize9">Qty</td>
                <td width="6%"  class="border-top-bottom-right"><div class="normalfntRite"><?php echo $intQty; ?></div></td>
                <td  class="border-top-bottom-fntsize9">&nbsp;</td>
                <td width="5%"  class="border-top-bottom-right"></td>
                <td width="9%"  class="border-top-bottom-right"><div class="normalfntRite">
				<?php echo number_format((($totalOrderQty - $row["intSubContractQty"] )*$row["ohpc"]*100),2);
				?>
				</div></td>
                <td width="9%"  class="border-top-bottom-right"><div class="normalfntRite">
				<?php echo number_format(($row["ohpc"]*100),4);
				?>
				</div></td>
              </tr>

              

            </table></td>
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
</body>
<script type="text/javascript">
document.getElementById("npfob").innerHTML = "<?php echo number_format(($netmargin/$reaFOB*100),1); $mobileProfit = number_format(($netmargin/$reaFOB*100),1); ?> %";

document.getElementById("gpfob").innerHTML = "<?php 
//$gpfob = (($cmVal -  $labsuboverheadcost) / $reaFOB )* 100;
$gpfob = (($cmVal -  $labrate) / $reaFOB )* 100;
echo number_format($gpfob,1);
$mobileGPFOB = number_format($gpfob,1);
 ?> %";
 
 document.getElementById("gpcm").innerHTML = "<?php 
 
 /*
 
 $gpcm = (($cmVal -  $labsuboverheadcost) / $cmVal) * 100;
if (($cmVal -  $labsuboverheadcost) < 0 && $cmVal < 0)
	$gpcm = $gpcm * -1;
	
 */
$gpcm = (($cmVal -  $labrate) / $cmVal) * 100;
if (($cmVal -  $labrate) < 0 && $cmVal < 0)
	$gpcm = $gpcm * -1;
			 echo number_format($gpcm,1);
			 $mobileGPCM = number_format($gpcm,1);
 ?> %";
 
document.getElementById("ohpm").innerHTML = "<?php 
			 echo number_format($companycostperminute,4);
			 $mobileFACOHUM = number_format($companycostperminute,4);
 ?>";



</script>
</html>
