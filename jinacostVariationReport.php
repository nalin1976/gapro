<?php
session_start();
include "authentication.inc";

$oldorderNo = "";
$oldodrDescription = "";
$oldodrQty = "";
$oldexPercentage = "";
$oldrunningRefNo = "";
$oldinitialRPT = "";
$oldeffLevel = "";
$oldnpfob = "";
$oldsmv = "";
$olddollarSMV = "";
$oldtotQty = "";
$oldsubContractQty = "";
$oldforeignComponent = "";
$oldfacOHcost = "";
$oldgpfob = "";
$oldgpcm = "";
$oldesc = "";
$oldfinancepercentage = "";
$oldfabricfinance = "";
$oldtrimfinance = "";
$oldupcharge = "";
$oldfinanceRate = "";
$oldfinanceValue = "";
$olddirectCosrRate = "";
$olddirectCostValue = "";
$oldCMRate = "";
$oldCMValue = "";
$oldOHCostRate = "";
$oldOHCostValue = "";
$oldcorporateRate = "";
$oldcorporateValue = "";
$oldnetMarginRate = "";
$oldnetMargeinValue = "";
$oldFOBRate = "";
$oldFOBValue = "";
$oldcostOfSaleRate = "";
$oldcostOfSaleValue = "";
$oldtotCostRate = "";
$oldtotCostValue = "";
$oldcostingLabourCost = "";

include "Connector.php";
$strStyleID=$_GET["styleID"];

$hasHistory = true;
/*		
$sql = "SELECT * FROM history_orders WHERE intStyleId = '$strStyleID'";
$result = $db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
	$hasHistory = true;
	break;
}
*/
ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Pre Order Cost : : Report</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>

<table width="800" align="center">
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0"><tr><td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="24%"><img src="images/GaPro_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
        <td width="5%" class="normalfnt">&nbsp;</td>
        <td width="55%" class="tophead"><p class="topheadBLACK">
 		<?php		
		
		$CompanyID=0;
		$maxApprovalNo = $_GET["revision"];
		
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
		$odrStatus = 0;
		
		$subcontractQty = 0;
		$odrDate = "";
		$upcharge = 0;
		$upchargereason = 0;
		$companycostperminute = 0;
		$strAppRemarks = "";
		
		$xml = simplexml_load_file('config.xml');
		$ScRequiredForReport = $xml->PreOrder->SCRequiredForCostingReport;
		$SCNo = "";
		
		$SQL = "select intSRNO from specification where intStyleId ='$strStyleID'";
		$result = $db->RunQuery($SQL);
		while($row = mysql_fetch_array($result))
		{
			
			$SCNo = $row["intSRNO"] ;
		}

	$SQL = "SELECT history_orders.intApprovalNo,history_orders.strOrderNo, history_orders.reaLabourCost, history_orders.intStyleId, history_orders.intStatus, history_orders.intCompanyID, history_orders.intBuyerID, history_orders.intBuyingOfficeId, history_orders.intUserID, history_orders.reaECSCharge, history_orders.intCoordinator, history_orders.intDivisionId, history_orders.intApprovalNo, history_orders.strDescription, history_orders.intQty, history_orders.strCustomerRefNo, history_orders.intSeasonId, history_orders.strRPTMark, history_orders.reaExPercentage, history_orders.reaEfficiencyLevel, history_orders.reaCostPerMinute, history_orders.reaSMV, history_orders.reaSMVRate, history_orders.reaFinPercntage, history_orders.reaFOB, history_orders.reaProfit, history_orders.dtmDate, history_orders.reaUPCharges, history_orders.strUPChargeDescription, history_orders.strAppRemarks,history_orders.intSubContractQty ,companies.reaFactroyCostPerMin FROM history_orders INNER JOIN companies ON history_orders.intCompanyID = companies.intCompanyID WHERE history_orders.intStyleId='$strStyleID' AND history_orders.intApprovalNo = '$maxApprovalNo' 
 ORDER BY 
history_orders.strOrderNo,
history_orders.reaLabourCost,
history_orders.intStyleId,
history_orders.intStatus,
history_orders.intCompanyID,
history_orders.intBuyerID,
history_orders.intBuyingOfficeId,
history_orders.intUserID,
history_orders.reaECSCharge,
history_orders.intCoordinator,
history_orders.intDivisionId,
history_orders.strDescription,
history_orders.intQty,
history_orders.strCustomerRefNo,
history_orders.intSeasonId,
history_orders.strRPTMark,
history_orders.reaExPercentage,
history_orders.reaEfficiencyLevel,
history_orders.reaCostPerMinute,
history_orders.reaSMV,
history_orders.reaSmvRate,
history_orders.reaFinPercntage,
history_orders.reaFOB,
history_orders.reaProfit,
history_orders.dtmDate,
history_orders.reaUPCharges,
history_orders.strUPChargeDescription,
history_orders.strAppRemarks,
history_orders.intSubContractQty,
companies.reaFactroyCostPerMin,
history_orders.intApprovalNo ;";

	
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
			$odrDate = $row["dtmDate"];
			$upcharge = $row["reaUPCharges"];
			$upchargereason = $row["strUPChargeDescription"];
			$companycostperminute = $row["reaFactroyCostPerMin"];
			$strAppRemarks = $row["strAppRemarks"];
			$subcontractQty = $row["intSubContractQty"];
			$odrStatus = $row["intStatus"];
			$maxApprovalNo = $row["intApprovalNo"];
			
			$olddollarSMV = $row["reaSMVRate"];
			$oldorderNo = $row["strOrderNo"];
			$oldodrDescription = $row["strDescription"];
			$oldodrQty = $row["intQty"];
			$oldexPercentage = $row["reaExPercentage"];
			$oldrunningRefNo = $row["strCustomerRefNo"];
			$oldinitialRPT = $row["strRPTMark"];
			$oldeffLevel = $row["reaEfficiencyLevel"];
			
			$oldsubContractQty = $row["intSubContractQty"];
			$oldforeignComponent = "";
			$oldsmv = $row["reaSMV"];

			$oldesc = $row["reaECSCharge"];
			$oldfinancepercentage = $row["reaFinPercntage"];
			
			$oldupcharge = $row["reaUPCharges"];
			$oldcostingLabourCost = $row["reaLabourCost"];
			
		}
		//$netmargin = ($reaSMVRate * $reaSMV) - ($reaFOB * 0.05) -( $reaSMV / ($reaEfficiencyLevel / 100) * $companycostperminute) ;
		$SQL="SELECT     companies.strName, companies.strAddress1, companies.strAddress2, companies.strStreet, companies.strCity,companies.strState, companies.strCountry, companies.strZipCode, companies.strPhone, companies.strEMail, companies.strFax,companies.strWeb, companies.intCompanyID, history_orders.intStyleId FROM companies CROSS JOIN history_orders WHERE (history_orders.intStyleId = '".$strStyleID."') AND (companies.intCompanyID = '".$CompanyID."') and history_orders.intApprovalNo = $maxApprovalNo; ";	
		
		$result = $db->RunQuery($SQL);
		
		while($row = mysql_fetch_array($result))
		{			
			echo $row["strName"] ;
			echo "</p><p class=\"normalfnt\">";
			echo $row["strAddress1"]." ".$row["strAddress2"]." ".$row["strStreet"]." ".$row["strCity"]." ".$row["strCountry"]." ".$row["strCountry"].". <br>"." Tel: ".$row["strPhone"]." Fax: ".$row["strFax"]." <br>E-Mail: ".$row["strEMail"]." Web: ".$row["strWeb"] ;
			echo "</p>";
		}
		 
		?>
          </td>
        <td width="16%" class="tophead">&nbsp;</td>
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
            <td height="36" colspan="5" class="head2">
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
			
			?>
             <?php

			if ($ScRequiredForReport == "true" && $SCNo != "")
				echo " - SC$SCNo";
			?></td>
            </tr>
          <tr>
            <td width="19%" class="bcgl1txt1NB">
              BUYER            </td>
            <td width="29%" class="normalfnt2Black">
            : <?php
			
			$SQL="SELECT strName FROM  buyers WHERE (intBuyerID = ".$BuyerID.")";
			$result = $db->RunQuery($SQL);
			
			while($row = mysql_fetch_array($result))
			{
				echo $row["strName"] ;
						
			}
			?>            </td>
            <td width="6%">&nbsp;</td>
            <td width="19%" class="bcgl1txt1NB">MERCHANDISER</td>
            <td width="27%" class="normalfnt2Black">
            : <?php 			
			$SQL="SELECT Name FROM useraccounts WHERE (intUserID = ".$UserID.")";
			$result = $db->RunQuery($SQL);
			
			while($row = mysql_fetch_array($result))
			{
				echo $row["Name"]." Style Transfered From " ;
						
			}
			echo $strCoordinator;
			?>            </td>
          </tr>
          <tr>
            <td class="bcgl1txt1NB">COSTING DATE</td>
            <td class="normalfnt2Black">: <?php
			echo date("jS F Y", strtotime($odrDate)); 
		
			?></td>
            <td>&nbsp;</td>
            <td class="bcgl1txt1NB">APPROVAL NO</td>
           <td class="normalfnt2Black">: <?php echo $maxApprovalNo;?></td>
          </tr>
          <tr>
            <td class="bcgl1txt1NB">BUYING OFFICE</td>
            <td class="normalfnt2Black">
               : <?php
			$SQL="SELECT strName FROM buyerbuyingoffices WHERE (intBuyingOfficeId = ".$intBuyingOfficeId.") AND (intBuyerID = ".$BuyerID.")";
			
			$result = $db->RunQuery($SQL);
			
			if($row = mysql_fetch_array($result))						
				echo $row["strName"] ;		
		
			?>            </td>
            <td>&nbsp;</td>
            <td class="bcgl1txt1NB">DIVISION</td>
            <td class="normalfnt2Black">
            : <?php 
				$SQL="SELECT strDivision FROM buyerdivisions WHERE (intDivisionId = ".$intDivisionId.")";
				
				$result = $db->RunQuery($SQL);
				
				while($row = mysql_fetch_array($result))
				{
					echo $row["strDivision"] ;	
				}
			?>            </td>
          </tr>
          <tr>
            <td class="bcgl1txt1NB">STYLE NO            </td>
            <td class="normalfnt2Black">: <?php echo $strStyleID;?></td>
            <td rowspan="2">&nbsp;</td>
            <td class="bcgl1txt1NB">SEASON</td>
            <td class="normalfnt2Black">
            : <?php 
			$SQL="SELECT  strSeason FROM seasons WHERE (strSeasonId = ".$intSeasonId.")";
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
            <td bgcolor="#BED6E9" class="bcgl1txt1B">NP / FOB </td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">SMV</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">$/SMV</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">Total Qty </td>
            <td width="14%" bgcolor="#BED6E9" class="bcgl1txt1B">Sub Contact Qty. </td>           
          </tr>
          <tr>
            <td height="20" class="bcgl1txt1"><?php echo $reaEfficiencyLevel."%";
			?></td>
            <td class="bcgl1txt1" id="npfob"></td>
            <td class="bcgl1txt1"><?php echo $reaSMV; ?></td>
            <td class="bcgl1txt1"><?php echo number_format($reaSMVRate,4); ?></td>
            <td class="bcgl1txt1"><?php
			$totalOrderQty= round($intQty + ($intQty * $reaExPercentage / 100));
			$oldtotQty = $totalOrderQty;
			 echo $totalOrderQty;?></td>
            <td class="bcgl1txt1"><?php echo $subcontractQty; ?></td>
            </tr>
          <tr>
            <td height="20" bgcolor="#BED6E9" class="bcgl1txt1B">Foreign Component </td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">Factory OH Per Used Minute</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">GP / FOB</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B" >GP/CM</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">&nbsp;</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B" ></td>          
          </tr>    
          <tr>
            <td class="bcgl1txt1" >&nbsp;</td>
            <td class="bcgl1txt1" id="ohpm">&nbsp;</td>
            <td class="bcgl1txt1" id="gpfob">&nbsp; </td>
            <td class="bcgl1txt1" id="gpcm">&nbsp;</td>
            <td class="bcgl1txt1" >&nbsp;</td>
            <td class="bcgl1txt1" colspan="2">&nbsp;</td>
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
		  $fabricCost = 0;
		  $serviceCost = 0;
		  $OtherCost = 0;
				  
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
						 FROM ((history_orderdetails INNER JOIN matitemlist ON history_orderdetails.intMatDetailID = matitemlist.intItemSerial) INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID) INNER JOIN itempurchasetype ON history_orderdetails.intOriginNo = itempurchasetype.intOriginNo
						 WHERE (((history_orderdetails.intStyleId)='".$strStyleID."'))  
						 AND history_orderdetails.intApprovalNo = $maxApprovalNo  
						 ORDER BY matmaincategory.intID;";
			
			
			// FABRIC,ACCESSORIES & PACKING MATERIALS			 
			$result_Category = $db->RunQuery($SQL_Cetegory);
			while($row_Category = mysql_fetch_array($result_Category))
			{
				if($row_Category["intID"]=="1" | $row_Category["intID"]=="2" | $row_Category["intID"]=="3")
				{	
					$category[$loop]=$row_Category["strDescription"];		
					$loop++;
					
					echo "<tr>"."<td>&nbsp;</td><td class=\"normalfnt2BITAB\">";
					echo $row_Category["strDescription"];
					echo"</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>"; 					
					
					//(orderdetails / matmaincategory / matitemlist / itempurchasetype )
					
					$SQL_orderDetails="SELECT history_orderdetails.strOrderNo, history_orderdetails.intStyleId, history_orderdetails.strUnit, history_orderdetails.dblUnitPrice, history_orderdetails.reaConPc, history_orderdetails.reaWastage, history_orderdetails.strCurrencyID, history_orderdetails.intOriginNo, history_orderdetails.dblFreight ,history_orderdetails.dblTotalQty, history_orderdetails.dblReqQty, history_orderdetails.dblTotalValue, history_orderdetails.dbltotalcostpc, matitemlist.strItemDescription, matmaincategory.strDescription, itempurchasetype.strOriginType, matitemlist.intMainCatID, matitemlist.intItemSerial
					  			   FROM ((history_orderdetails INNER JOIN matitemlist ON history_orderdetails.intMatDetailID = matitemlist.intItemSerial) INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID) INNER JOIN itempurchasetype ON history_orderdetails.intOriginNo = itempurchasetype.intOriginNo
					  			   WHERE (((history_orderdetails.intStyleId)='".$strStyleID."') AND ((matitemlist.intMainCatID)='".$row_Category["intID"]."')) AND history_orderdetails.intApprovalNo = $maxApprovalNo 
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
							
						if($row_Category["intID"]=="1" )
						{
							$fabricCost += $row_order["dbltotalcostpc"];
						}
						else if($row_Category["intID"]=="5" )
						{
							$OtherCost += $row_order["dbltotalcostpc"];
						}
						
					
							
						//$TotFabFinance Value
						if($row_Category["intID"]=="1" & $row_order["strOriginType"]=="IMP-F")
						{
							$FabFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotFabFinance+=$FabFinance;							
						}
						else if($row_Category["intID"]=="1" & $row_order["strOriginType"]=="LOC-F")
						{
							$FabFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotFabFinance+=$FabFinance;
						}
						
						//$TotTrimFinance Value
						if($row_Category["intID"]=="2" & $row_order["strOriginType"]=="IMP-F")
						{
							$TrimFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotTrimFinance+=$TrimFinance;
						}
						else if($row_Category["intID"]=="2" & $row_order["strOriginType"]=="LOC-F")
						{
							$TrimFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotTrimFinance+=$TrimFinance;
						}
						else if($row_Category["intID"]=="3" & $row_order["strOriginType"]=="IMP-F")
						{
							$TrimFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotTrimFinance+=$TrimFinance;
						}
						else if($row_Category["intID"]=="3" & $row_order["strOriginType"]=="LOC-F")
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
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblTotalValue"],2)."</td>";
						
						$countusdValue+=round($row_order["dblTotalValue"],2);
						//$countusdValue+=$row_order["dblTotalValue"];
						//$tmpVal = round($row_order["dblTotalValue"],2);
						//$countusdValue += $tmpVal;
						$counttotalcostpc+=round($row_order["dbltotalcostpc"],4);
						
						echo "</tr>";
						
						$index=$index+1;					
						
					}
					
					echo "<tr>";
					echo "<td colspan=\"10\" class=\"normalfntBtab\">Total</td>";
					echo "<td class=\"nfhighlite1\">".number_format($counttotalcostpc,4)."</td>";
					echo "<td class=\"nfhighlite1\">".number_format($countusdValue,2)."</td>";
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
					if($row_Category["intID"]=="4" | $row_Category["intID"]=="5")
					{	
						$category[$loop]=$row_order["strDescription"];		
						$loop++;
						
						echo "<tr>"."<td>&nbsp;</td><td class=\"normalfnt2BITAB\">";
						echo $row_Category["strDescription"];
						echo"</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
						
						$SQL_orderDetails="SELECT history_orderdetails.strOrderNo, history_orderdetails.intStyleId, history_orderdetails.strUnit, history_orderdetails.dblUnitPrice, history_orderdetails.reaConPc, history_orderdetails.reaWastage, history_orderdetails.strCurrencyID, history_orderdetails.intOriginNo, history_orderdetails.dblFreight, history_orderdetails.dblTotalQty, history_orderdetails.dblReqQty, history_orderdetails.dblTotalValue, history_orderdetails.dbltotalcostpc, matitemlist.strItemDescription, matmaincategory.strDescription, itempurchasetype.strOriginType, matitemlist.intMainCatID, matitemlist.intItemSerial
					  			   FROM ((history_orderdetails INNER JOIN matitemlist ON history_orderdetails.intMatDetailID = matitemlist.intItemSerial) INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID) INNER JOIN itempurchasetype ON history_orderdetails.intOriginNo = itempurchasetype.intOriginNo
					  			   WHERE (((history_orderdetails.intStyleId)='".$strStyleID."') AND ((matitemlist.intMainCatID)='".$row_Category["intID"]."')) AND history_orderdetails.intApprovalNo = $maxApprovalNo  
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
						$serviceCost += $row_order["dbltotalcostpc"];
						echo " <td class=\"normalfntMidTAB\">".$strOriginType."</td>";
						echo "<td class=\"normalfntMidTAB\">".$row_order["strUnit"]."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["reaConPc"],4)." </td>";				
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblReqQty"],0)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".$row_order["reaWastage"]."</td>";
						echo "<td class=\"normalfntRiteTAB\">".$row_order["dblFreight"]."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblTotalQty"],0)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblUnitPrice"],4)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dbltotalcostpc"],4)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblTotalValue"],2)."</td>";	
										
						$countusdValue+=round($row_order["dblTotalValue"],2);
						$counttotalcostpc+=round($row_order["dbltotalcostpc"],4);				
						
						
						echo "</tr>";
						
						$index++;
							
						}
							
							$valueusd[$count]=$countusdValue;	
						$costpc[$count]=round($counttotalcostpc,4);
						$count++;
						
					echo "<tr>";
					echo "<td colspan=\"10\" class=\"normalfntBtab\">Total</td>";
					echo "<td class=\"nfhighlite1\">".number_format($counttotalcostpc,4)."</td>";
					echo "<td class=\"nfhighlite1\">".number_format($countusdValue,2)."</td>";
					echo "</tr>";
					$countusdValue=0.0;
					$counttotalcostpc=0.0;		
					
				}
				
				
				
			}

		  ?>
          <tr>
            <td colspan="10" class="normalfntTAB"><?php
			echo "Finance + Economic Service " . $reaESC . " Finance ".number_format($reaFinPercntage,4)."%";
			echo "FAB Fin: ";
			echo "<span class=\"normalfnth2B\">";
			echo number_format($TotFabFinance,4);
			echo "</span>";
			echo " TRIM Fin: ";
			echo "<span class=\"normalfnth2B\">";
			echo number_format($TotTrimFinance,4);
			echo "</span>";
			$oldfabricfinance = $TotFabFinance;
			$oldtrimfinance = $TotTrimFinance;
			?>            </td>
            <td class="normalfntRiteTAB"><?php 
			//$AvgFinanace=$CountFinanace/$intQty;
			//echo number_format($AvgFinanace,4);
			$CountFinanace=$TotFabFinance+$TotTrimFinance;
			echo number_format(($CountFinanace + $reaESC ),4);
			$oldfinanceRate = $CountFinanace + $reaESC ;
			?></td>
            <td class="normalfntRiteTAB"><?php 
			$CountFinanace=$TotFabFinance+$TotTrimFinance + $reaESC ;
			echo number_format(($CountFinanace * $totalOrderQty),2);
			$oldfinanceValue = $CountFinanace * $totalOrderQty;
			?></td>
          </tr>
          <tr>
            <td colspan="10" class="normalfntTAB">TOTAL DIRECT COST </td>
            <td class="normalfntRiteTAB"><?php 
			for($loops=0;$loops< count($costpc);$loops++)
			{	 
				$TotaleDrectCost+=$costpc[$loops];				
			}	
			//$TotaleDrectCost+= $CountFinanace;
				echo number_format($TotaleDrectCost,4);
				$olddirectCosrRate = $TotaleDrectCost;
			
			?></td>
            <td colspan="10" class="normalfntRiteTAB"><?php 
			
			echo number_format(($TotaleDrectCost * $totalOrderQty),2);
			$olddirectCostValue = $TotaleDrectCost * $totalOrderQty;
			?></td>
          </tr>
          <tr>
            <td colspan="10" class="normalfntTAB">C&amp;M EARNED + (UPcharge (<?php echo number_format($upcharge,4);  ?>) Reason for Upcharge : <?php echo $upchargereason; ?> </td>
            <td class="normalfntRiteTAB"><?php
			// echo round($reaSMV*$reaSMVRate,4);
			//echo $TotaleDrectCost . "<br>";
			//$cmVal = round($upcharge + $reaFOB   - ( $TotaleDrectCost),4);
			$cmVal = round($upcharge + $reaFOB   - ( $TotaleDrectCost + $reaESC  + ($TotFabFinance+$TotTrimFinance)),4);
			echo number_format($cmVal,4);
			$oldCMRate = $cmVal;
			?></td>
            <td class="normalfntRiteTAB"><?php
			echo  number_format(round(round($upcharge + $reaFOB   - ( $TotaleDrectCost),4)*( $intQty + ($intQty * $reaExPercentage / 100) ),2),2);
			$oldCMValue = number_format(round(round($upcharge + $reaFOB   - ( $TotaleDrectCost),4)*( $intQty + ($intQty * $reaExPercentage / 100) ),2),2);
			$oldCostingCMSum = $oldcostingLabourCost * ( $intQty + ($intQty * $reaExPercentage / 100) );
			$oldCMValue = $oldCMRate * ( $intQty + ($intQty * $reaExPercentage / 100) );
			?></td>
          </tr>
          <tr>
            <td colspan="10" class="normalfntTAB">LABOUR / SUB CONTRACT &amp; OVERHEAD COST </td>
            <td class="normalfntRiteTAB"><?php
			
			$coporatecost = $reaFOB * 0.05;
			$labsuboverheadcost = 0;
			$subcontractcost = 0;
			$inhouseStyle = true;
			$SQL = "select distinct stylepartdetails_sub.intStyleId,stylepartdetails_sub.intPartId,stylepartdetails_sub.intPartNo,stylepartdetails_sub.strPartName,dblCM,dblTransportCost from stylepartdetails_sub inner join stylepartdetails on stylepartdetails_sub.intPartId = stylepartdetails.intPartId  where stylepartdetails_sub.intStyleId = '$strStyleID';";
			
			$result = $db->RunQuery($SQL);
			
			while($row = mysql_fetch_array($result))
			{
				if (($intQty + ($intQty * $reaExPercentage / 100)) == $subcontractQty)
					$inhouseStyle = false;
				if ($row["dblTransportCost"] == 0)
				{
					$subcontractcost += $row["dblCM"] ;
				}
				else
				{
					if($row["dblCM"]  == 0)
					{
						$subcontractcost += $row["dblTransportCost"] ;
					}
					else
					{
						$subcontractcost += ($row["dblCM"] + $row["dblTransportCost"]);
					}
				}
			}
			if (($intQty + ($intQty * $reaExPercentage / 100)) == $subcontractQty)
			{
			
					if ($inhouseStyle)
					{
						$labsuboverheadcost =  $reaSMV / ($reaEfficiencyLevel / 100 )* $companycostperminute;
						

					}
					else
					{
						$labsuboverheadcost = $subcontractcost;
					}
			}
			else
			{
				if ($inhouseStyle)
				{
					
					$labsuboverheadcost =  $reaSMV / ($reaEfficiencyLevel / 100) * $companycostperminute;
					////echo "   $reaSMV " . '/' . $reaEfficiencyLevel . '/' .  '100 * ' . $companycostperminute . '<br>';
					//echo $labsuboverheadcost . '<br>';
				}
				else
				{
					if ($subcontractQty == 0 || $subcontractQty == "")
					{
						$labsuboverheadcost =  $reaSMV / ($reaEfficiencyLevel / 100) * $companycostperminute;
					}
					else
					{
						$labsuboverheadcost = $subcontractcost + ( $reaSMV/ ($reaEfficiencyLevel / 100) * $companycostperminute) ;
					}
				}
			}
			
			$labrate = 0;
			$totalOdrQty = ($intQty + ($intQty * $reaExPercentage / 100));
			if ($totalOdrQty > $subcontractQty)
			{
				$totlabcost = $labsuboverheadcost * $totalOdrQty;
				$sublabcost = $labsuboverheadcost * $subcontractQty;
				$labcostdiff = $totlabcost - $sublabcost;
				//$labsuboverheadcost = $labcostdiff / $totalOdrQty ;
				//$labsuboverheadcost = $labsuboverheadcost ;
				//$labrate = $labsuboverheadcost + $subcontractcost;
				$labrate = (($labsuboverheadcost * ($totalOrderQty - $subcontractQty) / $totalOdrQty)) + (($subcontractcost * $subcontractQty)/ $totalOdrQty);
				
				//$labrate = $cmVal -$labrate - $coporatecost;
			}
			else
			{
				$labrate = $subcontractcost;
			}
			echo number_format($labrate,4); 
			
			$oldOHCostRate = $labrate;
			//echo "<br>$intQty   " . " $subcontractQty";
			//echo '   $reaSMV / $reaEfficiencyLevel / 100 * $companycostperminute <br>';
			//echo "   $reaSMV " . '/' . $reaEfficiencyLevel . '/' .  '100 * ' . $companycostperminute . '<br>';
			
			
			?></td>
            <td class="normalfntRiteTAB">
			<?php
			 $balqt = $totalOrderQty - $subcontractQty;
			 if ($balqt == 0)
			 {
			 	echo number_format(($labsuboverheadcost *  $subcontractQty),2); 
				$oldOHCostValue = number_format(($labsuboverheadcost *  $subcontractQty),2); 
			 }
			 else
			{
			 	echo number_format(($labsuboverheadcost * ($totalOrderQty - $subcontractQty) + ($subcontractcost * $subcontractQty)),2); 
				$oldOHCostValue = number_format(($labsuboverheadcost * ($totalOrderQty - $subcontractQty) + ($subcontractcost * $subcontractQty)),2); 
			 }
			 
			 ?></td>
          </tr>
          <tr>
            <td colspan="10" class="normalfntTAB">CORPORATE COST </td>
            <td class="normalfntRiteTAB"><?php
			echo number_format($reaFOB * 0.05,4);
			$oldcorporateRate =  number_format($reaFOB * 0.05,4);
			?></td>
            <td class="normalfntRiteTAB"><?php
			echo number_format((round($intQty + ($intQty * $reaExPercentage / 100)) * ($reaFOB * 0.05)),2);
			$oldcorporateValue = number_format((round($intQty + ($intQty * $reaExPercentage / 100)) * ($reaFOB * 0.05)),2);
			?></td>
          </tr>
          <tr>
            <td colspan="10" class="normalfntTAB">NET MARGIN </td>
            <td class="normalfntRiteTAB"><?php
			//$netmargin = ($reaSMVRate * $reaSMV) - ($reaFOB * 0.05) -( $reaSMV / ($reaEfficiencyLevel / 100) * $companycostperminute) ;
			$netmargin = ($cmVal) - ($reaFOB * 0.05) - $labrate;
			//echo '(' . $reaSMVRate . ' * ' . $reaSMV . ' ) - (' . $reaFOB .' 0.05 ) - ' . $labsuboverheadcost;
			echo number_format($netmargin,4);
			$oldnetMarginRate = number_format($netmargin,4);
			//echo "<br>$reaSMVRate";
			
			?></td>
            <td class="normalfntRiteTAB"><?php
			 echo number_format(($netmargin * $totalOrderQty),2); 
			 $oldnetMargeinValue = number_format(($netmargin * $totalOrderQty),2); 
			 ?></td>
          </tr>
          <tr>
            <td colspan="10" class="normalfntTAB"><strong>SELLING PRICE  (FOB / CIF / LDP ) </strong></td>
            <td class="normalfntRiteTAB"><?php
			echo number_format($reaFOB,4);
			$oldFOBRate = number_format($reaFOB,4);
			?></td>
            <td class="normalfntRiteTAB"><?php
			echo number_format(($reaFOB * $totalOrderQty),2);
			$oldFOBValue = ($reaFOB *  ($intQty + (($intQty * $reaExPercentage) / 100)));
			
			?></td>
          </tr>
		  <tr>
		    <td colspan="12">&nbsp;</td>
		    </tr>
		  <tr>
		    <td colspan="12">&nbsp;</td>
		    </tr>
		  <tr>
		    <td colspan="12">&nbsp;</td>
		    </tr>
		  <tr>
		  <td colspan="12">&nbsp;</td>
		  </tr>
          <tr>
            <td colspan="10" class="normalfntTAB">COST OF SALE  (RM + Serv. + Othr + Fin. + Esc + Lab.Oh + Sub.) </td>
            <td class="normalfntRiteTAB"><?php
			$costOfSale = $TotaleDrectCost + $labsuboverheadcost + $subcontractcost;
			echo number_format($costOfSale ,4);
			$oldcostOfSaleRate = number_format($costOfSale ,4);
			
			?></td>
            <td class="normalfntRiteTAB"><?php
			 echo number_format(($costOfSale * $totalOrderQty),2); 
			 $oldcostOfSaleValue = number_format(($costOfSale * $totalOrderQty),2); 
			 ?></td>
          </tr>
          <tr>
            <td colspan="10" class="normalfntTAB">TOTAL COST  ( Cost of Sales + Coporate Cost) </td>
            <td class="normalfntRiteTAB"><?php
			
			 echo number_format(($costOfSale + $coporatecost) ,4); 
			 $oldtotCostRate = number_format(($costOfSale + $coporatecost) ,4); 
			 ?></td>
            <td class="normalfntRiteTAB"><?php
			
			 echo number_format((($costOfSale + $coporatecost) * $totalOrderQty) ,2); 
			 $oldtotCostValue = number_format((($costOfSale + $coporatecost) * $totalOrderQty) ,2); 
			 ?></td>
          </tr>
          <tr>
            <td colspan="10" class="normalfntSMB">Approval Comments : </td>
          </tr>
          <tr>
            <td colspan="12" class="normalfntRiteTAB">
			<?php
			
			echo $strAppRemarks;
			
			?>			</td>
          </tr>
        </table></td>
      </tr>
      <tr>      </tr>
      <tr>
        <td></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0">
      
	   <tr class="tablez">
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr class="tablez">
        <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="tablez" >
		<?php
			$SQL = "select intStyleId,intPartId,intPartNo,strPartName,dblsmv,dblSmvRate,dblEffLevel from stylepartdetails where intStyleId = '$strStyleID'";
			$result = $db->RunQuery($SQL);
			$rowId = 0;
			while($row = mysql_fetch_array($result))
			{
		?>
          <tr>

		 
            <td width="16%" bordercolor="#666666"  <?php 
		  if ($rowId == 0) 
		  	echo "bgcolor=\"#CCCCCC\" ";
			
		  ?> class="normalfntTAB"><?php 
		  if ($rowId == 0) 
		  	echo "C &amp; M EARNED";
			
		  ?> </td>
            <td width="7%" bordercolor="#666666" class="normalfntTAB">&nbsp;</td>
            <td width="7%" bordercolor="#666666" class="normalfntTAB">SMV <?php echo $row["intPartId"];  ?> </td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"><?php echo number_format($row["dblsmv"],2);?> </td>
            <td width="7%" bordercolor="#666666" class="normalfntTAB">Effi % </td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"><?php echo number_format($row["dblEffLevel"],2);?> </td>
            <td width="7%" bordercolor="#666666" class="normalfntTAB">Qty </td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"><?php echo number_format($totalOrderQty,2);?></td>
            <td width="7%" bordercolor="#666666" class="normalfntTAB">$/SMV</td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"><?php echo number_format($reaSMVRate,4);?></td>
            <td width="7%" bordercolor="#666666" class="normalfntTAB">$/UM</td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"><?php $um = ($reaSMVRate * $reaSMV) / $reaSMV / ($reaEfficiencyLevel / 100);  
																		echo number_format($um,4);
																		?></td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"><?php
			echo  number_format(round(round($upcharge + $reaFOB   - ( $TotaleDrectCost),4)*( $intQty + ($intQty * $reaExPercentage / 100) ),2),2);
			?></td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB">
              <?php
			// echo round($reaSMV*$reaSMVRate,4);
			//echo $TotaleDrectCost . "<br>";
			echo number_format(round($upcharge + $reaFOB   - ( $TotaleDrectCost),4),4);
			?>            </td>
			</tr>
            
         
		  <?php
		  $rowId ++;
		  }
		  
		  $SQL = "select stylepartdetails.intStyleId,intPartId,intPartNo,strPartName,dblsmv,dblSmvRate,dblEffLevel,reaFactroyCostPerMin, dblsmv/dblEffLevel as umin, dblsmv/dblEffLevel * reaFactroyCostPerMin as ohpc, orders.intSubContractQty   from stylepartdetails inner join history_orders on stylepartdetails.intStyleId = history_orders.intStyleId inner join  companies on history_orders.intCompanyID =companies.intCompanyID  where stylepartdetails.intStyleId = '$strStyleID'";
		  $result = $db->RunQuery($SQL);
			$rowId = 0;
			while($row = mysql_fetch_array($result))
			{
				$subcontractQty = $row["intSubContractQty"];
		  ?>
          <tr>

            <td bordercolor="#666666" <?php 
		  if ($rowId == 0) 
		  	echo "bgcolor=\"#CCCCCC\" ";
			
		  ?> class="normalfntTAB"><?php 
		  if ($rowId == 0) 
		  	echo "INHOUSE LABOUR COST";
			
		  ?> </td>
            <td bordercolor="#666666" class="normalfntTAB">SMV <?php echo $row["intPartId"];  ?> </td>
            <td bordercolor="#666666" class="normalfntTAB"><span class="normalfntSM">OH/U.Min</span></td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"><?php echo number_format($row["reaFactroyCostPerMin"],4);?></td>
            <td bordercolor="#666666" class="normalfntTAB"><span class="normalfntSM">U.Min/Pc</span></td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"><?php echo number_format(($row["umin"] * 100),4);?></td>
            <td bordercolor="#666666" class="normalfntTAB"><span class="normalfntSM">OH/PC</span></td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"><?php echo number_format(($row["ohpc"]*100),4);?></td>
            <td bordercolor="#666666" class="normalfntTAB"><span class="normalfntSM">Qty </span></td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"><?php echo $totalOrderQty - $row["intSubContractQty"];?></td>
            <td bordercolor="#666666" class="normalfntTAB">&nbsp;</td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"></td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"><?php echo number_format((($totalOrderQty - $row["intSubContractQty"] )*$row["ohpc"]*100),2);?></td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"><?php echo number_format(($row["ohpc"]*100),4);?></td>
</tr>

		  <?php
		  $rowId ++;
		  	}
			
			$SQL = "select distinct stylepartdetails_sub.intStyleId,stylepartdetails_sub.intPartId,stylepartdetails_sub.intPartNo,stylepartdetails_sub.strPartName,dblCM,dblTransportCost from stylepartdetails_sub inner join stylepartdetails on stylepartdetails_sub.intPartId = stylepartdetails.intPartId  where stylepartdetails_sub.intStyleId = '$strStyleID';";
		  	$result = $db->RunQuery($SQL);
			$rowId = 0;
			while($row = mysql_fetch_array($result))
			{
		  ?>
         
          <tr>
            <td bordercolor="#666666" <?php 
		  if ($rowId == 0) 
		  	echo "bgcolor=\"#CCCCCC\" ";
			
		  ?>  class="normalfntTAB"><?php 
		  if ($rowId == 0) 
		  	echo "SUBCON COST";
			
		  ?> </td>
            <td bordercolor="#666666" class="normalfntTAB">&nbsp;</td>
            <td bordercolor="#666666" class="normalfntTAB"><span class="normalfntSM">C&amp;M/PC</span></td>
           <td width="5%" bordercolor="#666666" class="normalfntTAB"><?php echo number_format($row["dblCM"],4);?></td>
            <td colspan="3" bordercolor="#666666" class="normalfntTAB"><span class="normalfntSM">SUB TRANSPORT /PC </span></td>
            <td width="7%" bordercolor="#666666" class="normalfntTAB"><?php echo number_format($row["dblTransportCost"],4);?></td>
            <td bordercolor="#666666" class="normalfntTAB"><span class="normalfntSM">Qty </span></td>
            <td width="7%" bordercolor="#666666" class="normalfntTAB"><?php echo $subcontractQty;?></td>
            <td bordercolor="#666666" class="normalfntTAB">&nbsp;</td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"></td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"><?php echo number_format((($row["dblCM"] + $row["dblTransportCost"]) *$subcontractQty ),2);?></td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"><?php echo number_format(($row["dblCM"] + $row["dblTransportCost"] ),4);?></td>
          </tr>
		  <?php
		  
		  	$rowId ++;
		  	}
		  ?>
        </table></td>
        </tr>
      <tr class="tablez">
        <td colspan="2">&nbsp;</td>
      </tr>
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
						echo "<td class=\"normalfntRiteTAB\">".number_format(round(($costpc[$loops]/$TotaleDrectCost*100),2),2)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($costpc[$loops],4)."</td>";
						echo "</tr>";
						$totPresenttage+=round(($costpc[$loops]/$TotaleDrectCost*100),2);
					}
			  	  
			  ?>
                  <tr>
                    <td class="normalfntTAB">&nbsp;</td>
                    <td class="nfhighlite1"><?php echo number_format($totPresenttage,2);?></td>
                    <td class="normalfntRiteTAB">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="normalfntTAB">ACCESSORIES+PACKING METERIALS</td>
                    <td class="normalfntRiteTAB"><?php echo number_format($Access_Pack,2);?></td>
                    <td class="normalfntRiteTAB"><?php echo number_format($Access_Packrange,4);?></td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
        <td width="40%">&nbsp;</td>
      </tr>
      <tr class="tablez">
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr class="tablez">
        <td colspan="2">&nbsp;</td>
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
<script type="text/javascript">
document.getElementById("npfob").innerHTML = "<?php 
$oldnpfob = number_format(($netmargin/$reaFOB*100),1); 
echo $oldnpfob; ?> %";

document.getElementById("gpfob").innerHTML = "<?php 
$gpfob = ($cmVal -  $labsuboverheadcost) / $reaFOB * 100;
$oldgpfob = $gpfob;
echo number_format($gpfob,1);
 ?> %";
 
 document.getElementById("gpcm").innerHTML = "<?php 
$gpcm = ($cmVal -  $labsuboverheadcost) / $cmVal * 100;
if (($cmVal -  $labsuboverheadcost) < 0 && $cmVal < 0)
	$gpcm = $gpcm * -1;
			 echo number_format($gpcm,1);
$oldgpcm =$gpcm;
 ?> %";
 
document.getElementById("ohpm").innerHTML = "<?php 
			 echo number_format($companycostperminute,4);
$oldfacOHcost = number_format($companycostperminute,4);
 ?>";



</script>
</html>
<?php
ob_get_clean();

// --------------------------------------------------------------------------------------

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Pre Order Cost : : Report</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>

<table width="800" align="center">
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0"><tr><td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="24%"><img src="images/GaPro_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
        <td width="5%" class="normalfnt">&nbsp;</td>
        <td width="55%" class="tophead"><p class="topheadBLACK">
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
		$odrStatus = 0;
		
		$subcontractQty = 0;
		$odrDate = "";
		$upcharge = 0;
		$upchargereason = 0;
		$companycostperminute = 0;
		$strAppRemarks = "";
		$costingLabourCost = 0;
		
		$xml = simplexml_load_file('config.xml');
		$ScRequiredForReport = $xml->PreOrder->SCRequiredForCostingReport;
		$SCNo = "";
		
		$SQL = "select intSRNO from specification where intStyleId ='$strStyleID'";
		$result = $db->RunQuery($SQL);
		while($row = mysql_fetch_array($result))
		{
			
			$SCNo = $row["intSRNO"] ;
		}
		
		$SQL="SELECT orders.strOrderNo, orders.intStyleId, orders.intStatus, orders.reaLabourCost, orders.intCompanyID, orders.intBuyerID, orders.intBuyingOfficeId, orders.intUserID, orders.reaECSCharge, orders.intCoordinator, orders.intDivisionId, orders.intApprovalNo, orders.strDescription, orders.intQty, orders.strCustomerRefNo, orders.intSeasonId, orders.strRPTMark, orders.reaExPercentage, orders.reaEfficiencyLevel, orders.reaCostPerMinute, orders.reaSMV, orders.reaSMVRate, orders.reaFinPercntage, orders.reaFOB, orders.reaProfit, orders.dtmDate, orders.reaUPCharges, orders.strUPChargeDescription, orders.strAppRemarks,orders.intSubContractQty ,companies.reaFactroyCostPerMin 
FROM orders inner join companies on orders.intCompanyID = companies.intCompanyID 
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
			$odrDate = $row["dtmDate"];
			$upcharge = $row["reaUPCharges"];
			$upchargereason = $row["strUPChargeDescription"];
			$companycostperminute = $row["reaFactroyCostPerMin"];
			$strAppRemarks = $row["strAppRemarks"];
			$subcontractQty = $row["intSubContractQty"];
			$odrStatus = $row["intStatus"];
			$costingLabourCost = $row["reaLabourCost"];
			
		}
		//$netmargin = ($reaSMVRate * $reaSMV) - ($reaFOB * 0.05) -( $reaSMV / ($reaEfficiencyLevel / 100) * $companycostperminute) ;
		$SQL="SELECT     companies.strName, companies.strAddress1, companies.strAddress2, companies.strStreet, companies.strCity,companies.strState, companies.strCountry, companies.strZipCode, companies.strPhone, companies.strEMail, companies.strFax,companies.strWeb, companies.intCompanyID, orders.intStyleId FROM companies CROSS JOIN orders WHERE (orders.intStyleId = '".$strStyleID."') AND (companies.intCompanyID = '".$CompanyID."')";	
		
		$result = $db->RunQuery($SQL);
		
		while($row = mysql_fetch_array($result))
		{			
			echo $row["strName"] ;
			echo "</p><p class=\"normalfnt\">";
			echo $row["strAddress1"]." ".$row["strAddress2"]." ".$row["strStreet"]." ".$row["strCity"]." ".$row["strCountry"]." ".$row["strCountry"].". <br>"." Tel: ".$row["strPhone"]." Fax: ".$row["strFax"]." <br>E-Mail: ".$row["strEMail"]." Web: ".$row["strWeb"] ;
			echo "</p>";
		}
		 
		?>
          </td>
        <td width="16%" class="tophead"><img src="styles/<?php echo $strStyleID; ?>.jpg" name="imgStyle" width="56" height="63" border="0" id="imgStyle" /></td>
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
            <td height="36" colspan="5" class="head2">
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
			
			?>
             <?php

			if ($ScRequiredForReport == "true" && $SCNo != "")
				echo " - SC$SCNo";
			?></td>
            </tr>
          <tr>
            <td width="19%" class="bcgl1txt1NB">
              BUYER            </td>
            <td width="29%" class="normalfnt2Black">
            : <?php
			
			$SQL="SELECT strName FROM  buyers WHERE (intBuyerID = ".$BuyerID.")";
			$result = $db->RunQuery($SQL);
			
			while($row = mysql_fetch_array($result))
			{
				echo $row["strName"] ;
						
			}
			?>            </td>
            <td width="6%">&nbsp;</td>
            <td width="19%" class="bcgl1txt1NB">MERCHANDISER</td>
            <td width="27%" class="normalfnt2Black">
            : <?php 			
			$SQL="SELECT Name FROM useraccounts WHERE (intUserID = ".$UserID.")";
			$result = $db->RunQuery($SQL);
			
			while($row = mysql_fetch_array($result))
			{
				echo $row["Name"]." Style Transfered From " ;
						
			}
			echo $strCoordinator;
			?>            </td>
          </tr>
          <tr>
            <td class="bcgl1txt1NB">COSTING DATE</td>
            <td class="normalfnt2Black">: <?php
			echo date("jS F Y", strtotime($odrDate)); 
		
			?></td>
            <td>&nbsp;</td>
            <td class="bcgl1txt1NB"></td>
            <td class="normalfnt2Black"></td>
          </tr>
          <tr>
            <td class="bcgl1txt1NB">BUYING OFFICE</td>
            <td class="normalfnt2Black">
               : <?php
			$SQL="SELECT strName FROM buyerbuyingoffices WHERE (intBuyingOfficeId = ".$intBuyingOfficeId.") AND (intBuyerID = ".$BuyerID.")";
			
			$result = $db->RunQuery($SQL);
			
			if($row = mysql_fetch_array($result))						
				echo $row["strName"] ;		
		
			?>            </td>
            <td>&nbsp;</td>
            <td class="bcgl1txt1NB">DIVISION</td>
            <td class="normalfnt2Black">
            : <?php 
				$SQL="SELECT strDivision FROM buyerdivisions WHERE (intDivisionId = ".$intDivisionId.")";
				
				$result = $db->RunQuery($SQL);
				
				while($row = mysql_fetch_array($result))
				{
					echo $row["strDivision"] ;	
				}
			?>            </td>
          </tr>
          <tr>
            <td class="bcgl1txt1NB">STYLE NO            </td>
            <td class="normalfnt2Black">: <?php echo $strStyleID;?></td>
            <td rowspan="2">&nbsp;</td>
            <td class="bcgl1txt1NB">SEASON</td>
            <td class="normalfnt2Black">
            : <?php 
			$SQL="SELECT  strSeason FROM seasons WHERE (strSeasonId = ".$intSeasonId.")";
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
            <td class="normalfnt2bld">&nbsp;</td>
            <td class="normalfnt2">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
	  <td class="bcgl1txtLB">New Header</td>
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
            <td bgcolor="#BED6E9" class="bcgl1txt1B">NP / FOB </td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">SMV</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">$/SMV</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">Total Qty </td>
            <td width="14%" bgcolor="#BED6E9" class="bcgl1txt1B">Sub Contact Qty. </td>           
          </tr>
          <tr>
            <td height="20" class="bcgl1txt1"><?php echo $reaEfficiencyLevel."%";
			?></td>
            <td class="bcgl1txt1" id="npfob"></td>
            <td class="bcgl1txt1"><?php echo $reaSMV; ?></td>
            <td class="bcgl1txt1"><?php echo number_format($reaSMVRate,4); ?></td>
            <td class="bcgl1txt1"><?php
			$totalOrderQty= round($intQty + ($intQty * $reaExPercentage / 100));
			
			 echo $totalOrderQty;?></td>
            <td class="bcgl1txt1"><?php echo $subcontractQty; ?></td>
            </tr>
          <tr>
            <td height="20" bgcolor="#BED6E9" class="bcgl1txt1B">Foreign Component </td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">Factory OH Per Used Minute</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">GP / FOB</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B" >GP/CM</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">&nbsp;</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B" ></td>          
          </tr>    
          <tr>
            <td class="bcgl1txt1" >&nbsp;</td>
            <td class="bcgl1txt1" id="ohpm">&nbsp;</td>
            <td class="bcgl1txt1" id="gpfob">&nbsp; </td>
            <td class="bcgl1txt1" id="gpcm">&nbsp;</td>
            <td class="bcgl1txt1" >&nbsp;</td>
            <td class="bcgl1txt1" colspan="2">&nbsp;</td>
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
	  <?php
	  if ($hasHistory)
	  {	  
	  ?>
	  <tr>
	  <td class="bcgl1txtLB">Previous Header</td>
	  </tr>
	  <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="17%" height="20" bgcolor="#CCCCFF" class="bcgl1txt1B">Order No</td>
            <td width="22%" bgcolor="#CCCCFF" class="bcgl1txt1B">Description</td>
            <td width="13%" bgcolor="#CCCCFF" class="bcgl1txt1B">Order QTY</td>
            <td width="16%" bgcolor="#CCCCFF" class="bcgl1txt1B">Excess QTY%</td>
            <td width="18%" bgcolor="#CCCCFF" class="bcgl1txt1B">Running Ref No:</td>
            <td colspan="2" bgcolor="#CCCCFF" class="bcgl1txt1B">Initial/RPT </td>
          </tr>
          <tr>
            <td height="18" class="bcgl1txt1"><?php echo $oldorderNo; ?></td>
            <td class="bcgl1txt1"><?php echo $oldodrDescription; ?></td>
            <td class="bcgl1txt1"><?php echo $oldodrQty; ?></td>
            <td class="bcgl1txt1"><?php  echo $oldexPercentage; ?></td>
            <td class="bcgl1txt1"><?php echo $oldrunningRefNo; ?></td>
            <td colspan="2" class="bcgl1txt1"><?php echo $oldinitialRPT; ?></td>
          </tr>
          <tr>
            <td height="19" bgcolor="#CCCCFF" class="bcgl1txt1B">Efficiency Level</td>
            <td bgcolor="#CCCCFF" class="bcgl1txt1B">NP / FOB </td>
            <td bgcolor="#CCCCFF" class="bcgl1txt1B">SMV</td>
            <td bgcolor="#CCCCFF" class="bcgl1txt1B">$/SMV</td>
            <td bgcolor="#CCCCFF" class="bcgl1txt1B">Total Qty </td>
            <td width="14%" bgcolor="#CCCCFF" class="bcgl1txt1B">Sub Contact Qty. </td>           
          </tr>
          <tr>
            <td height="20" class="bcgl1txt1"><?php echo $oldeffLevel ."%";
			?></td>
            <td class="bcgl1txt1"> <?php echo $oldnpfob; ?> %</td>
            <td class="bcgl1txt1"><?php echo $oldsmv; ?></td>
            <td class="bcgl1txt1"><?php echo $olddollarSMV; ?></td>
            <td class="bcgl1txt1"><?php	 echo $oldtotQty;?></td>
            <td class="bcgl1txt1"><?php echo $oldsubContractQty; ?></td>
            </tr>
          <tr>
            <td height="20" bgcolor="#CCCCFF" class="bcgl1txt1B">Foreign Component </td>
            <td bgcolor="#CCCCFF" class="bcgl1txt1B">Factory OH Per Used Minute</td>
            <td bgcolor="#CCCCFF" class="bcgl1txt1B">GP / FOB</td>
            <td bgcolor="#CCCCFF" class="bcgl1txt1B" >GP/CM</td>
            <td bgcolor="#CCCCFF" class="bcgl1txt1B">&nbsp;</td>
            <td bgcolor="#CCCCFF" class="bcgl1txt1B" ></td>          
          </tr>    
          <tr>
            <td class="bcgl1txt1" ><?php echo $oldforeignComponent; ?></td>
            <td class="bcgl1txt1" ><?php echo $oldfacOHcost; ?></td>
            <td class="bcgl1txt1" ><?php echo number_format($oldgpfob,1); ?> %</td>
            <td class="bcgl1txt1" ><?php echo number_format($oldgpcm,1); ?> %</td>
            <td class="bcgl1txt1" >&nbsp;</td>
            <td class="bcgl1txt1" colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
		  <?php
		  }
		  ?>
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
		  $fabricCost = 0;
		  $serviceCost = 0;
		  $OtherCost = 0;
				  
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
						 WHERE (((orderdetails.intStyleId)='".$strStyleID."'))
						 ORDER BY matmaincategory.intID;";
						
			// FABRIC,ACCESSORIES & PACKING MATERIALS			 
			$result_Category = $db->RunQuery($SQL_Cetegory);
			while($row_Category = mysql_fetch_array($result_Category))
			{
				if($row_Category["intID"]=="1" | $row_Category["intID"]=="2" | $row_Category["intID"]=="3")
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
					//echo $SQL_orderDetails . "<br><br>";			  
					$result_order = $db->RunQuery($SQL_orderDetails);
					while($row_order = mysql_fetch_array($result_order))
					{
						$sqlNew = "SELECT intMatDetailID FROM history_orderdetails WHERE intApprovalNo = $maxApprovalNo AND intStyleId = '$strStyleID' AND intMatDetailID = '" .  $row_order["intItemSerial"] ."'";
					
					$result_new = $db->RunQuery($sqlNew);
					$isNew = true;
					while($row_new = mysql_fetch_array($result_new))
					{
						$isNew = false;
						break;
					}
						if (!$isNew)
       						echo "<tr>";
						else if ($hasHistory)
							echo "<tr bgcolor=\"#CCFF99\">";
						else
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
							
						if($row_Category["intID"]=="1" )
						{
							$fabricCost += $row_order["dbltotalcostpc"];
						}
						else if($row_Category["intID"]=="5" )
						{
							$OtherCost += $row_order["dbltotalcostpc"];
						}
						
					
							
						//$TotFabFinance Value
						if($row_Category["intID"]=="1" & $row_order["strOriginType"]=="IMP-F")
						{
							$FabFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotFabFinance+=$FabFinance;							
						}
						else if($row_Category["intID"]=="1" & $row_order["strOriginType"]=="LOC-F")
						{
							$FabFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotFabFinance+=$FabFinance;
						}
						
						//$TotTrimFinance Value
						if($row_Category["intID"]=="2" & $row_order["strOriginType"]=="IMP-F")
						{
							$TrimFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotTrimFinance+=$TrimFinance;
						}
						else if($row_Category["intID"]=="2" & $row_order["strOriginType"]=="LOC-F")
						{
							$TrimFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotTrimFinance+=$TrimFinance;
						}
						else if($row_Category["intID"]=="3" & $row_order["strOriginType"]=="IMP-F")
						{
							$TrimFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotTrimFinance+=$TrimFinance;
						}
						else if($row_Category["intID"]=="3" & $row_order["strOriginType"]=="LOC-F")
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
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblTotalValue"],2)."</td>";
						
						$countusdValue+=round($row_order["dblTotalValue"],2);
						//$countusdValue+=$row_order["dblTotalValue"];
						//$tmpVal = round($row_order["dblTotalValue"],2);
						//$countusdValue += $tmpVal;
						$counttotalcostpc+=round($row_order["dbltotalcostpc"],4);
						
						echo "</tr>";
						
						$prevOrigin = $row_order["intOriginNo"];
						$prevunit = $row_order["strUnit"];
						$prevConpc = $row_order["reaConPc"];
						$prevWastage = $row_order["reaWastage"] ;
						$prevFreight = $row_order["dblFreight"];
						$prevunitPrice = $row_order["dblUnitPrice"];
						
						
						$sqlOldItem = "SELECT strOrderNo,intApprovalNo,intStyleId,intMatDetailID,strUnit,dblUnitPrice,reaConPc,reaWastage,strCurrencyID,intOriginNo,dblReqQty,dblTotalQty,dblTotalValue,dblCostPC,dblFreight,dbltotalcostpc FROM history_orderdetails WHERE intApprovalNo = '$maxApprovalNo' AND intStyleId = '$strStyleID' AND intMatDetailID = '" . $row_order["intItemSerial"] . "'";
						
						
						$oldresult_order = $db->RunQuery($sqlOldItem);
						while($oldrow_order = mysql_fetch_array($oldresult_order))
						{
							if ($row_order["strUnit"] != $oldrow_order["strUnit"] || $row_order["intOriginNo"] != $oldrow_order["intOriginNo"] || $row_order["reaConPc"] != $oldrow_order["reaConPc"] || $row_order["reaWastage"] != $oldrow_order["reaWastage"] || $row_order["dblFreight"] != $oldrow_order["dblFreight"] || $row_order["dblUnitPrice"] != $oldrow_order["dblUnitPrice"] )
							{
							 	// --------------------------------------------------
								
								$prevOrigin = $oldrow_order["intOriginNo"];
								$prevunit = $oldrow_order["strUnit"];
								$prevConpc = $oldrow_order["reaConPc"];
								$prevWastage = $oldrow_order["reaWastage"] ;
								$prevFreight = $oldrow_order["dblFreight"];
								$prevunitPrice = $oldrow_order["dblUnitPrice"];
						
								echo "<tr bgcolor=\"#FFFFCC\">";
						echo "<td class=\"normalfntTAB\" bgcolor=\"#FFFFFF\" ><span class=\"error1\">$maxApprovalNo</span></td>";
						echo " <td class=\"normalfntTAB\">".$row_order["strItemDescription"]."</td>";
						$strOriginType=$oldrow_order["strOriginType"];
						
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
							
			
						if ($row_order["intOriginNo"] != $oldrow_order["intOriginNo"] )
							echo " <td class=\"normalfntMidTAB\"><span class=\"normalfntCentretRedSmall\">".$strOriginType."</span></td>";
						else
							echo " <td class=\"normalfntMidTAB\">".$strOriginType."</td>";
						
						if($row_order["strUnit"] != $oldrow_order["strUnit"])
							echo "<td class=\"normalfntMidTAB\"><span class=\"normalfntCentretRedSmall\">".$oldrow_order["strUnit"]."</span></td>";
						else
							echo "<td class=\"normalfntMidTAB\">".$oldrow_order["strUnit"]."</td>";
						
						if($row_order["reaConPc"] != $oldrow_order["reaConPc"])
							echo "<td class=\"normalfntRiteTAB\"><span class=\"normalfntRightRedSmall\">".number_format($oldrow_order["reaConPc"],4)."</span></td>";	
						else
							echo "<td class=\"normalfntRiteTAB\">".number_format($oldrow_order["reaConPc"],4)." </td>";	
										
						echo "<td class=\"normalfntRiteTAB\">".number_format($oldrow_order["dblReqQty"],0)."</td>";
						
						if($row_order["reaWastage"] != $oldrow_order["reaWastage"])
							echo "<td class=\"normalfntRiteTAB\"><span class=\"normalfntRightRedSmall\">".$oldrow_order["reaWastage"]."</span></td>";
						else
							echo "<td class=\"normalfntRiteTAB\">".$oldrow_order["reaWastage"]."</td>";
						
						if ($row_order["dblFreight"] != $oldrow_order["dblFreight"])
							echo "<td class=\"normalfntRiteTAB\"><span class=\"normalfntRightRedSmall\">".$oldrow_order["dblFreight"]."</span></td>";
						else
							echo "<td class=\"normalfntRiteTAB\">".$oldrow_order["dblFreight"]."</td>";
							
						echo "<td class=\"normalfntRiteTAB\">".number_format($oldrow_order["dblTotalQty"],0)."</td>";
						
						if($row_order["dblUnitPrice"] != $oldrow_order["dblUnitPrice"])
							echo "<td class=\"normalfntRiteTAB\"><span class=\"normalfntRightRedSmall\">".number_format($oldrow_order["dblUnitPrice"],4)."</span></td>";
						else
							echo "<td class=\"normalfntRiteTAB\">".number_format($oldrow_order["dblUnitPrice"],4)."</td>";
								
						echo "<td class=\"normalfntRiteTAB\">".number_format($oldrow_order["dbltotalcostpc"],4)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($oldrow_order["dblTotalValue"],2)."</td>";
					
						
						echo "</tr>";
								
								// --------------------------------------------------
							}
						}
						
						// This loop will never happen. If you need to see previous variations please change the initiation of the loop
						for ($inloop = $maxApprovalNo ; $inloop < $maxApprovalNo ; $inloop ++)
						{
							$sqlOldItem = "SELECT strOrderNo,intApprovalNo,intStyleId,intMatDetailID,strUnit,dblUnitPrice,reaConPc,reaWastage,strCurrencyID,intOriginNo,dblReqQty,dblTotalQty,dblTotalValue,dblCostPC,dblFreight,dbltotalcostpc FROM history_orderdetails WHERE intApprovalNo = '$inloop' AND intStyleId = '$strStyleID' AND intMatDetailID = '" . $row_order["intItemSerial"] . "'";
						
							
							$oldresult_order = $db->RunQuery($sqlOldItem);
							while($oldrow_order = mysql_fetch_array($oldresult_order))
							{
								if ($prevunit  != $oldrow_order["strUnit"] || $prevOrigin != $oldrow_order["intOriginNo"] || $prevConpc != $oldrow_order["reaConPc"] ||$prevWastage != $oldrow_order["reaWastage"] || $prevFreight  != $oldrow_order["dblFreight"] || $prevunitPrice != $oldrow_order["dblUnitPrice"] )
								{
									// --------------------------------------------------
									
									
									
									echo "<tr bgcolor=\"#FFFFCC\">";
						echo "<td class=\"normalfntTAB\" bgcolor=\"#FFFFFF\" ><span class=\"error1\">" . $oldrow_order["intApprovalNo"] . "</span></td>";
						echo " <td class=\"normalfntTAB\">".$row_order["strItemDescription"]."</td>";
						$strOriginType=$oldrow_order["strOriginType"];
						
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
							
			
						if ($prevOrigin != $oldrow_order["intOriginNo"] )
							echo " <td class=\"normalfntMidTAB\"><span class=\"normalfntCentretRedSmall\">".$strOriginType."</span></td>";
						else
							echo " <td class=\"normalfntMidTAB\">".$strOriginType."</td>";
						
						if($prevunit != $oldrow_order["strUnit"])
							echo "<td class=\"normalfntMidTAB\"><span class=\"normalfntCentretRedSmall\">".$oldrow_order["strUnit"]."</span></td>";
						else
							echo "<td class=\"normalfntMidTAB\">".$oldrow_order["strUnit"]."</td>";
						
						if($prevConpc != $oldrow_order["reaConPc"])
							echo "<td class=\"normalfntRiteTAB\"><span class=\"normalfntRightRedSmall\">".number_format($oldrow_order["reaConPc"],4)."</span></td>";	
						else
							echo "<td class=\"normalfntRiteTAB\">".number_format($oldrow_order["reaConPc"],4)." </td>";	
										
						echo "<td class=\"normalfntRiteTAB\">".number_format($oldrow_order["dblReqQty"],0)."</td>";
						
						if($prevWastage != $oldrow_order["reaWastage"])
							echo "<td class=\"normalfntRiteTAB\"><span class=\"normalfntRightRedSmall\">".$oldrow_order["reaWastage"]."</span></td>";
						else
							echo "<td class=\"normalfntRiteTAB\">".$oldrow_order["reaWastage"]."</td>";
						
						if ($prevFreight != $oldrow_order["dblFreight"])
							echo "<td class=\"normalfntRiteTAB\"><span class=\"normalfntRightRedSmall\">".$oldrow_order["dblFreight"]."</span></td>";
						else
							echo "<td class=\"normalfntRiteTAB\">".$oldrow_order["dblFreight"]."</td>";
							
						echo "<td class=\"normalfntRiteTAB\">".number_format($oldrow_order["dblTotalQty"],0)."</td>";
						
						if($prevunitPrice != $oldrow_order["dblUnitPrice"])
							echo "<td class=\"normalfntRiteTAB\"><span class=\"normalfntRightRedSmall\">".number_format($oldrow_order["dblUnitPrice"],4)."</span></td>";
						else
							echo "<td class=\"normalfntRiteTAB\">".number_format($oldrow_order["dblUnitPrice"],4)."</td>";
								
						echo "<td class=\"normalfntRiteTAB\">".number_format($oldrow_order["dbltotalcostpc"],4)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($oldrow_order["dblTotalValue"],2)."</td>";
					
						
						echo "</tr>";
						
						$prevOrigin = $oldrow_order["intOriginNo"];
						$prevunit = $oldrow_order["strUnit"];
						$prevConpc = $oldrow_order["reaConPc"];
						$prevWastage = $oldrow_order["reaWastage"] ;
						$prevFreight = $oldrow_order["dblFreight"];
						$prevunitPrice = $oldrow_order["dblUnitPrice"];
									
									// --------------------------------------------------
									
									
									
								}
							}
						}
						$index=$index+1;					
						
					}
					
					
					// ---------------------------------------
					
					$sqldeleted = "SELECT history_orderdetails.strOrderNo,history_orderdetails.intApprovalNo,history_orderdetails.intStyleId,
history_orderdetails.intMatDetailID,history_orderdetails.strUnit,history_orderdetails.dblUnitPrice,
history_orderdetails.reaConPc,history_orderdetails.reaWastage,history_orderdetails.strCurrencyID,
history_orderdetails.intOriginNo,history_orderdetails.dblReqQty,history_orderdetails.dblTotalQty,
history_orderdetails.dblTotalValue,history_orderdetails.dblCostPC,history_orderdetails.dblFreight,
history_orderdetails.dbltotalcostpc  , matitemlist.strItemDescription 
FROM ((history_orderdetails INNER JOIN matitemlist ON history_orderdetails.intMatDetailID = matitemlist.intItemSerial) INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID) INNER JOIN itempurchasetype ON history_orderdetails.intOriginNo = itempurchasetype.intOriginNo WHERE (((history_orderdetails.intStyleId)='$strStyleID') AND ((matitemlist.intMainCatID)='" .$row_Category["intID"] ."'))
AND history_orderdetails.intMatDetailID = (
SELECT matitemlist.intItemSerial FROM ((history_orderdetails INNER JOIN matitemlist ON history_orderdetails.intMatDetailID = matitemlist.intItemSerial) INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID) INNER JOIN itempurchasetype ON history_orderdetails.intOriginNo = itempurchasetype.intOriginNo WHERE (((history_orderdetails.intStyleId)='$strStyleID') AND ((matitemlist.intMainCatID)='" .$row_Category["intID"] ."')) AND intApprovalNo = $maxApprovalNo AND 
matitemlist.intItemSerial NOT IN 
(SELECT matitemlist.intItemSerial FROM ((orderdetails INNER JOIN matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial) INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID) INNER JOIN itempurchasetype ON orderdetails.intOriginNo = itempurchasetype.intOriginNo WHERE (((orderdetails.intStyleId)='$strStyleID') AND ((matitemlist.intMainCatID)='" .$row_Category["intID"] ."')))
) AND intApprovalNo = $maxApprovalNo  " ;
					
					$oldresult_order = $db->RunQuery($sqldeleted);
					while($oldrow_order = mysql_fetch_array($oldresult_order))
					{
										echo "<tr bgcolor=\"#FFCCFF\">";
						echo "<td class=\"normalfntTAB\" bgcolor=\"#FFFFFF\" ><span class=\"error1\">" . $oldrow_order["intApprovalNo"] . "</span></td>";
						echo " <td class=\"normalfntTAB\"><strike>".$oldrow_order["strItemDescription"]."</strike></td>";
						$strOriginType=$oldrow_order["strOriginType"];
						
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
							
			

							echo " <td class=\"normalfntMidTAB\"><strike>".$strOriginType."</strike></td>";
						

							echo "<td class=\"normalfntMidTAB\"><strike>".$oldrow_order["strUnit"]."</strike></td>";
						

							echo "<td class=\"normalfntRiteTAB\"><strike>".number_format($oldrow_order["reaConPc"],4)." </strike></td>";	
										
						echo "<td class=\"normalfntRiteTAB\"><strike>".number_format($oldrow_order["dblReqQty"],0)."</strike></td>";
						
							echo "<td class=\"normalfntRiteTAB\"><strike>".$oldrow_order["reaWastage"]."</strike></td>";
						
							echo "<td class=\"normalfntRiteTAB\"><strike>".$oldrow_order["dblFreight"]."</strike></td>";
							
						echo "<td class=\"normalfntRiteTAB\"><strike>".number_format($oldrow_order["dblTotalQty"],0)."</strike></td>";
						
							echo "<td class=\"normalfntRiteTAB\"><strike>".number_format($oldrow_order["dblUnitPrice"],4)."</strike></td>";
								
						echo "<td class=\"normalfntRiteTAB\"><strike>".number_format($oldrow_order["dbltotalcostpc"],4)."</strike></td>";
						echo "<td class=\"normalfntRiteTAB\"><strike>".number_format($oldrow_order["dblTotalValue"],2)."</strike></td>";
					
						
						echo "</tr>";
					}
					
					// ---------------------------------------
					
					echo "<tr>";
					echo "<td colspan=\"10\" class=\"normalfntBtab\">Total</td>";
					echo "<td class=\"nfhighlite1\">".number_format($counttotalcostpc,4)."</td>";
					echo "<td class=\"nfhighlite1\">".number_format($countusdValue,2)."</td>";
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
					if($row_Category["intID"]=="4" | $row_Category["intID"]=="5")
					{	
						$category[$loop]=$row_order["strDescription"];		
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
							$sqlNew = "SELECT intMatDetailID FROM history_orderdetails WHERE intApprovalNo = $maxApprovalNo AND intStyleId = '$strStyleID' AND intMatDetailID = '" .  $row_order["intItemSerial"] ."'";
					
					$result_new = $db->RunQuery($sqlNew);
					$isNew = true;
					while($row_new = mysql_fetch_array($result_new))
					{
						$isNew = false;
						break;
					}
						if (!$isNew)
       						echo "<tr>";
						else if ($hasHistory)
							echo "<tr bgcolor=\"#CCFF99\">";
						else
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
						$serviceCost += $row_order["dbltotalcostpc"];
						echo " <td class=\"normalfntMidTAB\">".$strOriginType."</td>";
						echo "<td class=\"normalfntMidTAB\">".$row_order["strUnit"]."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["reaConPc"],4)." </td>";				
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblReqQty"],0)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".$row_order["reaWastage"]."</td>";
						echo "<td class=\"normalfntRiteTAB\">".$row_order["dblFreight"]."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblTotalQty"],0)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblUnitPrice"],4)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dbltotalcostpc"],4)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblTotalValue"],2)."</td>";	
										
						$countusdValue+=round($row_order["dblTotalValue"],2);
						$counttotalcostpc+=round($row_order["dbltotalcostpc"],4);				
						
						
						echo "</tr>";
						
						// -------------------------------------------------------------------
						
						echo "</tr>";
						
						$prevOrigin = $row_order["intOriginNo"];
						$prevunit = $row_order["strUnit"];
						$prevConpc = $row_order["reaConPc"];
						$prevWastage = $row_order["reaWastage"] ;
						$prevFreight = $row_order["dblFreight"];
						$prevunitPrice = $row_order["dblUnitPrice"];
						
						
						$sqlOldItem = "SELECT strOrderNo,intApprovalNo,intStyleId,intMatDetailID,strUnit,dblUnitPrice,reaConPc,reaWastage,strCurrencyID,intOriginNo,dblReqQty,dblTotalQty,dblTotalValue,dblCostPC,dblFreight,dbltotalcostpc FROM history_orderdetails WHERE intApprovalNo = '$maxApprovalNo' AND intStyleId = '$strStyleID' AND intMatDetailID = '" . $row_order["intItemSerial"] . "'";
						
						
						$oldresult_order = $db->RunQuery($sqlOldItem);
						while($oldrow_order = mysql_fetch_array($oldresult_order))
						{
							if ($row_order["strUnit"] != $oldrow_order["strUnit"] || $row_order["intOriginNo"] != $oldrow_order["intOriginNo"] || $row_order["reaConPc"] != $oldrow_order["reaConPc"] || $row_order["reaWastage"] != $oldrow_order["reaWastage"] || $row_order["dblFreight"] != $oldrow_order["dblFreight"] || $row_order["dblUnitPrice"] != $oldrow_order["dblUnitPrice"] )
							{
							 	// --------------------------------------------------
								
								$prevOrigin = $oldrow_order["intOriginNo"];
								$prevunit = $oldrow_order["strUnit"];
								$prevConpc = $oldrow_order["reaConPc"];
								$prevWastage = $oldrow_order["reaWastage"] ;
								$prevFreight = $oldrow_order["dblFreight"];
								$prevunitPrice = $oldrow_order["dblUnitPrice"];
						
								echo "<tr bgcolor=\"#FFFFCC\">";
						echo "<td class=\"normalfntTAB\" bgcolor=\"#FFFFFF\" ><span class=\"error1\">$maxApprovalNo</span></td>";
						echo " <td class=\"normalfntTAB\">".$row_order["strItemDescription"]."</td>";
						$strOriginType=$oldrow_order["strOriginType"];
						
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
							
			
						if ($row_order["intOriginNo"] != $oldrow_order["intOriginNo"] )
							echo " <td class=\"normalfntMidTAB\"><span class=\"normalfntCentretRedSmall\">".$strOriginType."</span></td>";
						else
							echo " <td class=\"normalfntMidTAB\">".$strOriginType."</td>";
						
						if($row_order["strUnit"] != $oldrow_order["strUnit"])
							echo "<td class=\"normalfntMidTAB\"><span class=\"normalfntCentretRedSmall\">".$oldrow_order["strUnit"]."</span></td>";
						else
							echo "<td class=\"normalfntMidTAB\">".$oldrow_order["strUnit"]."</td>";
						
						if($row_order["reaConPc"] != $oldrow_order["reaConPc"])
							echo "<td class=\"normalfntRiteTAB\"><span class=\"normalfntRightRedSmall\">".number_format($oldrow_order["reaConPc"],4)."</span></td>";	
						else
							echo "<td class=\"normalfntRiteTAB\">".number_format($oldrow_order["reaConPc"],4)." </td>";	
										
						echo "<td class=\"normalfntRiteTAB\">".number_format($oldrow_order["dblReqQty"],0)."</td>";
						
						if($row_order["reaWastage"] != $oldrow_order["reaWastage"])
							echo "<td class=\"normalfntRiteTAB\"><span class=\"normalfntRightRedSmall\">".$oldrow_order["reaWastage"]."</span></td>";
						else
							echo "<td class=\"normalfntRiteTAB\">".$oldrow_order["reaWastage"]."</td>";
						
						if ($row_order["dblFreight"] != $oldrow_order["dblFreight"])
							echo "<td class=\"normalfntRiteTAB\"><span class=\"normalfntRightRedSmall\">".$oldrow_order["dblFreight"]."</span></td>";
						else
							echo "<td class=\"normalfntRiteTAB\">".$oldrow_order["dblFreight"]."</td>";
							
						echo "<td class=\"normalfntRiteTAB\">".number_format($oldrow_order["dblTotalQty"],0)."</td>";
						
						if($row_order["dblUnitPrice"] != $oldrow_order["dblUnitPrice"])
							echo "<td class=\"normalfntRiteTAB\"><span class=\"normalfntRightRedSmall\">".number_format($oldrow_order["dblUnitPrice"],4)."</span></td>";
						else
							echo "<td class=\"normalfntRiteTAB\">".number_format($oldrow_order["dblUnitPrice"],4)."</td>";
								
						echo "<td class=\"normalfntRiteTAB\">".number_format($oldrow_order["dbltotalcostpc"],4)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($oldrow_order["dblTotalValue"],2)."</td>";
					
						
						echo "</tr>";
								
								// --------------------------------------------------
							}
						}
						
						// This loop will never happen. If you need to see previous variations please change the initiation of the loop
						for ($inloop = $maxApprovalNo ; $inloop < $maxApprovalNo ; $inloop ++)
						{
							$sqlOldItem = "SELECT strOrderNo,intApprovalNo,intStyleId,intMatDetailID,strUnit,dblUnitPrice,reaConPc,reaWastage,strCurrencyID,intOriginNo,dblReqQty,dblTotalQty,dblTotalValue,dblCostPC,dblFreight,dbltotalcostpc FROM history_orderdetails WHERE intApprovalNo = '$inloop' AND intStyleId = '$strStyleID' AND intMatDetailID = '" . $row_order["intItemSerial"] . "'";
						
							
							$oldresult_order = $db->RunQuery($sqlOldItem);
							while($oldrow_order = mysql_fetch_array($oldresult_order))
							{
								if ($prevunit  != $oldrow_order["strUnit"] || $prevOrigin != $oldrow_order["intOriginNo"] || $prevConpc != $oldrow_order["reaConPc"] ||$prevWastage != $oldrow_order["reaWastage"] || $prevFreight  != $oldrow_order["dblFreight"] || $prevunitPrice != $oldrow_order["dblUnitPrice"] )
								{
									// --------------------------------------------------
									
									
									
									echo "<tr bgcolor=\"#FFFFCC\">";
						echo "<td class=\"normalfntTAB\" bgcolor=\"#FFFFFF\" ><span class=\"error1\">" . $oldrow_order["intApprovalNo"] . "</span></td>";
						echo " <td class=\"normalfntTAB\">".$row_order["strItemDescription"]."</td>";
						$strOriginType=$oldrow_order["strOriginType"];
						
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
							
			
						if ($prevOrigin != $oldrow_order["intOriginNo"] )
							echo " <td class=\"normalfntMidTAB\"><span class=\"normalfntCentretRedSmall\">".$strOriginType."</span></td>";
						else
							echo " <td class=\"normalfntMidTAB\">".$strOriginType."</td>";
						
						if($prevunit != $oldrow_order["strUnit"])
							echo "<td class=\"normalfntMidTAB\"><span class=\"normalfntCentretRedSmall\">".$oldrow_order["strUnit"]."</span></td>";
						else
							echo "<td class=\"normalfntMidTAB\">".$oldrow_order["strUnit"]."</td>";
						
						if($prevConpc != $oldrow_order["reaConPc"])
							echo "<td class=\"normalfntRiteTAB\"><span class=\"normalfntRightRedSmall\">".number_format($oldrow_order["reaConPc"],4)."</span></td>";	
						else
							echo "<td class=\"normalfntRiteTAB\">".number_format($oldrow_order["reaConPc"],4)." </td>";	
										
						echo "<td class=\"normalfntRiteTAB\">".number_format($oldrow_order["dblReqQty"],0)."</td>";
						
						if($prevWastage != $oldrow_order["reaWastage"])
							echo "<td class=\"normalfntRiteTAB\"><span class=\"normalfntRightRedSmall\">".$oldrow_order["reaWastage"]."</span></td>";
						else
							echo "<td class=\"normalfntRiteTAB\">".$oldrow_order["reaWastage"]."</td>";
						
						if ($prevFreight != $oldrow_order["dblFreight"])
							echo "<td class=\"normalfntRiteTAB\"><span class=\"normalfntRightRedSmall\">".$oldrow_order["dblFreight"]."</span></td>";
						else
							echo "<td class=\"normalfntRiteTAB\">".$oldrow_order["dblFreight"]."</td>";
							
						echo "<td class=\"normalfntRiteTAB\">".number_format($oldrow_order["dblTotalQty"],0)."</td>";
						
						if($prevunitPrice != $oldrow_order["dblUnitPrice"])
							echo "<td class=\"normalfntRiteTAB\"><span class=\"normalfntRightRedSmall\">".number_format($oldrow_order["dblUnitPrice"],4)."</span></td>";
						else
							echo "<td class=\"normalfntRiteTAB\">".number_format($oldrow_order["dblUnitPrice"],4)."</td>";
								
						echo "<td class=\"normalfntRiteTAB\">".number_format($oldrow_order["dbltotalcostpc"],4)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($oldrow_order["dblTotalValue"],2)."</td>";
					
						
						echo "</tr>";
						
						$prevOrigin = $oldrow_order["intOriginNo"];
						$prevunit = $oldrow_order["strUnit"];
						$prevConpc = $oldrow_order["reaConPc"];
						$prevWastage = $oldrow_order["reaWastage"] ;
						$prevFreight = $oldrow_order["dblFreight"];
						$prevunitPrice = $oldrow_order["dblUnitPrice"];
									
									// --------------------------------------------------
								}
							}
						}
						
						
						// -------------------------------------------------------------------
						
						$index++;
							
						}
							
							$valueusd[$count]=$countusdValue;	
						$costpc[$count]=round($counttotalcostpc,4);
						$count++;
					
					// ------------------------------------------------------
					
					// ---------------------------------------
					
					$sqldeleted = "SELECT history_orderdetails.strOrderNo,history_orderdetails.intApprovalNo,history_orderdetails.intStyleId,
history_orderdetails.intMatDetailID,history_orderdetails.strUnit,history_orderdetails.dblUnitPrice,
history_orderdetails.reaConPc,history_orderdetails.reaWastage,history_orderdetails.strCurrencyID,
history_orderdetails.intOriginNo,history_orderdetails.dblReqQty,history_orderdetails.dblTotalQty,
history_orderdetails.dblTotalValue,history_orderdetails.dblCostPC,history_orderdetails.dblFreight,
history_orderdetails.dbltotalcostpc  , matitemlist.strItemDescription 
FROM ((history_orderdetails INNER JOIN matitemlist ON history_orderdetails.intMatDetailID = matitemlist.intItemSerial) INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID) INNER JOIN itempurchasetype ON history_orderdetails.intOriginNo = itempurchasetype.intOriginNo WHERE (((history_orderdetails.intStyleId)='$strStyleID') AND ((matitemlist.intMainCatID)='" .$row_Category["intID"] ."'))
AND history_orderdetails.intMatDetailID = (
SELECT matitemlist.intItemSerial FROM ((history_orderdetails INNER JOIN matitemlist ON history_orderdetails.intMatDetailID = matitemlist.intItemSerial) INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID) INNER JOIN itempurchasetype ON history_orderdetails.intOriginNo = itempurchasetype.intOriginNo WHERE (((history_orderdetails.intStyleId)='$strStyleID') AND ((matitemlist.intMainCatID)='" .$row_Category["intID"] ."')) AND intApprovalNo = $maxApprovalNo AND 
matitemlist.intItemSerial NOT IN 
(SELECT matitemlist.intItemSerial FROM ((orderdetails INNER JOIN matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial) INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID) INNER JOIN itempurchasetype ON orderdetails.intOriginNo = itempurchasetype.intOriginNo WHERE (((orderdetails.intStyleId)='$strStyleID') AND ((matitemlist.intMainCatID)='" .$row_Category["intID"] ."')))
) AND intApprovalNo = $maxApprovalNo  " ;
					
					$oldresult_order = $db->RunQuery($sqldeleted);
					while($oldrow_order = mysql_fetch_array($oldresult_order))
					{
										echo "<tr bgcolor=\"#FFCCFF\">";
						echo "<td class=\"normalfntTAB\" bgcolor=\"#FFFFFF\" ><span class=\"error1\">" . $oldrow_order["intApprovalNo"] . "</span></td>";
						echo " <td class=\"normalfntTAB\"><strike>".$oldrow_order["strItemDescription"]."</strike></td>";
						$strOriginType=$oldrow_order["strOriginType"];
						
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
							
			

							echo " <td class=\"normalfntMidTAB\"><strike>".$strOriginType."</strike></td>";
						

							echo "<td class=\"normalfntMidTAB\"><strike>".$oldrow_order["strUnit"]."</strike></td>";
						

							echo "<td class=\"normalfntRiteTAB\"><strike>".number_format($oldrow_order["reaConPc"],4)." </strike></td>";	
										
						echo "<td class=\"normalfntRiteTAB\"><strike>".number_format($oldrow_order["dblReqQty"],0)."</strike></td>";
						
							echo "<td class=\"normalfntRiteTAB\"><strike>".$oldrow_order["reaWastage"]."</strike></td>";
						
							echo "<td class=\"normalfntRiteTAB\"><strike>".$oldrow_order["dblFreight"]."</strike></td>";
							
						echo "<td class=\"normalfntRiteTAB\"><strike>".number_format($oldrow_order["dblTotalQty"],0)."</strike></td>";
						
							echo "<td class=\"normalfntRiteTAB\"><strike>".number_format($oldrow_order["dblUnitPrice"],4)."</strike></td>";
								
						echo "<td class=\"normalfntRiteTAB\"><strike>".number_format($oldrow_order["dbltotalcostpc"],4)."</strike></td>";
						echo "<td class=\"normalfntRiteTAB\"><strike>".number_format($oldrow_order["dblTotalValue"],2)."</strike></td>";
					
						
						echo "</tr>";
					}
					
					// ---------------------------------------
					
					// ------------------------------------------------------
						
					echo "<tr>";
					echo "<td colspan=\"10\" class=\"normalfntBtab\">Total</td>";
					echo "<td class=\"nfhighlite1\">".number_format($counttotalcostpc,4)."</td>";
					echo "<td class=\"nfhighlite1\">".number_format($countusdValue,2)."</td>";
					echo "</tr>";
					$countusdValue=0.0;
					$counttotalcostpc=0.0;		
					
				}
				
				
				
			}

		  ?>
          <tr>
            <td colspan="10" class="normalfntTAB"><?php
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
            <td class="normalfntRiteTAB"><?php 
			//$AvgFinanace=$CountFinanace/$intQty;
			//echo number_format($AvgFinanace,4);
			$CountFinanace=$TotFabFinance+$TotTrimFinance;
			echo number_format(($CountFinanace + $reaESC ),4);
			?></td>
            <td class="normalfntRiteTAB"><?php 
			$CountFinanace=$TotFabFinance+$TotTrimFinance + $reaESC ;
			echo number_format(($CountFinanace * $totalOrderQty),2);
			?></td>
          </tr>
          <tr>
            <td colspan="10" class="normalfntTAB">TOTAL DIRECT COST </td>
            <td class="normalfntRiteTAB"><?php 
			for($loops=0;$loops< count($costpc);$loops++)
			{	 
				$TotaleDrectCost+=$costpc[$loops];				
			}	
			//$TotaleDrectCost+= $CountFinanace;
				echo number_format($TotaleDrectCost,4);
			
			?></td>
            <td colspan="10" class="normalfntRiteTAB"><?php echo number_format(($TotaleDrectCost * $totalOrderQty),2);?></td>
          </tr>
            <tr>
            <td colspan="10" class="normalfntTAB">Labour Cost</td>
            <td class="normalfntRiteTAB"><?php 
            $cmVal = round($costingLabourCost,4);
            //$cmVal = round($upcharge + $reaFOB   - ( $TotaleDrectCost),4);
            
            $MRtot = $costingLabourCost *( $intQty + ($intQty * $reaExPercentage / 100) );
				echo number_format($cmVal,4);
			
			?></td>
            <td colspan="10" class="normalfntRiteTAB"><?php echo number_format($MRtot,2);?></td>
          </tr>
          <tr>
            <td colspan="10" class="normalfntTAB">Import + Export + Freight + Other Charges</td>
            <td class="normalfntRiteTAB"><?php
			// echo round($reaSMV*$reaSMVRate,4);
			//echo $TotaleDrectCost . "<br>";
			$CMVAL = round($reaFOB   - ( $TotaleDrectCost + $reaESC  + ($TotFabFinance+$TotTrimFinance)),4);
			echo number_format(($CMVAL - $cmVal),4);
			?></td>
            <td class="normalfntRiteTAB"><?php
			echo  number_format((($CMVAL - $cmVal) * $totalOrderQty ),2);
			?></td>
          </tr>
          <tr>
            <td colspan="10" class="normalfntTAB">C&amp;M EARNED + (UPcharge (<?php echo number_format($upcharge,4);  ?>) Reason for Upcharge : <?php echo $upchargereason; ?> </td>
            <td class="normalfntRiteTAB"><?php
			// echo round($reaSMV*$reaSMVRate,4);
			//echo $TotaleDrectCost . "<br>";
			$CMVAL = round($reaFOB   - ( $TotaleDrectCost + $reaESC  + ($TotFabFinance+$TotTrimFinance)),4);
			echo number_format(($CMVAL),4);
			?></td>
            <td class="normalfntRiteTAB"><?php
			echo  number_format((($CMVAL) * $totalOrderQty ),2);
			?></td>
          </tr>



          <tr>
            <td colspan="10" class="normalfntTAB"><strong>Target FOB </strong></td>
            <td class="normalfntRiteTAB"><?php
			echo number_format($reaFOB,4);
			?></td>
            <td class="normalfntRiteTAB"><?php
			echo number_format(($reaFOB * $totalOrderQty),2);
			?></td>
          </tr>
		  <tr>
		    <td colspan="12">&nbsp;</td>
		    </tr>
		  <tr>
		    <td colspan="12">&nbsp;</td>
		    </tr>
		  <tr>
		    <td colspan="12">&nbsp;</td>
		    </tr>
		  <tr>
		  <td colspan="12">&nbsp;</td>
		  </tr>


          <tr>
            <td colspan="10" class="normalfntSMB">Approval Comments : </td>
          </tr>
          <tr>
            <td colspan="12" class="normalfntRiteTAB">
			<?php
			
			echo $strAppRemarks;
			
			?>			<br /></td>
          </tr>
		  
		  <!--------------------------------------------------------------------->
		  
		  <?php
		  if ($hasHistory)
		  {
		  
		  ?>
		  <tr bgcolor="#CCCCFF">
            <td colspan="12" class="normalfntSMB">Previous Version Figures </td>
          </tr>
		  <tr bgcolor="#CCCCFF">
            <td colspan="10" class="normalfntTAB"><?php
			echo "Finance + Economic Service " . $oldesc . " Finance ".number_format($oldfinancepercentage,4)."%";
			echo "FAB Fin: ";
			echo "<span class=\"normalfnth2B\">";
			echo number_format($oldfabricfinance,4);
			echo "</span>";
			echo " TRIM Fin: ";
			echo "<span class=\"normalfnth2B\">";
			echo number_format($oldtrimfinance,4);
			echo "</span>";
			?>            </td>
            <td class="normalfntRiteTAB"><?php 
			//$AvgFinanace=$CountFinanace/$intQty;
			//echo number_format($AvgFinanace,4);

			echo number_format($oldfinanceRate,4);
			?></td>
            <td class="normalfntRiteTAB"><?php 
			echo number_format($oldfinanceValue,2);
			?></td>
          </tr>
          <tr bgcolor="#CCCCFF">
            <td colspan="10" class="normalfntTAB">TOTAL DIRECT COST </td>
            <td class="normalfntRiteTAB"><?php 
				echo number_format($olddirectCosrRate,4);
			
			?></td>
            <td colspan="10" class="normalfntRiteTAB"><?php echo number_format($olddirectCostValue,2);?></td>
          </tr>
          <tr bgcolor="#CCCCFF">
            <td colspan="10" class="normalfntTAB">Labour Cost</td>
            <td class="normalfntRiteTAB"><?php 
				echo number_format($oldcostingLabourCost,4);
			
			?></td>
            <td colspan="10" class="normalfntRiteTAB"><?php echo number_format(($oldCostingCMSum),2);?></td>
          </tr>
          <tr bgcolor="#CCCCFF">
            <td colspan="10" class="normalfntTAB">Import + Export + Freight + Other Charges</td>
            <td class="normalfntRiteTAB"><?php
			// echo round($reaSMV*$reaSMVRate,4);
			//echo $TotaleDrectCost . "<br>";
		
			echo number_format(($oldCMRate - $oldcostingLabourCost),4);
			?></td>
            <td class="normalfntRiteTAB"><?php
			echo  number_format(($oldCMValue - $oldCostingCMSum ),2);
			?></td>
          </tr>
          <tr bgcolor="#CCCCFF">
            <td colspan="10" class="normalfntTAB">C&amp;M EARNED + (UPcharge (<?php echo number_format($oldupcharge,4);  ?>) </td>
            <td class="normalfntRiteTAB"><?php
			// echo round($reaSMV*$reaSMVRate,4);
			//echo $TotaleDrectCost . "<br>";
		
			echo number_format(($oldCMRate),4);
			?></td>
            <td class="normalfntRiteTAB"><?php
			echo  number_format(($oldCMValue),2);
			?></td>
          </tr>
          
         
         
          <tr bgcolor="#CCCCFF">
            <td colspan="10" class="normalfntTAB"><strong>Target FOB </strong></td>
            <td class="normalfntRiteTAB"><?php
			echo number_format($oldFOBRate,4);
			?></td>
            <td class="normalfntRiteTAB"><?php
			echo number_format($oldFOBValue,2);
			?></td>
          </tr>
		
          
        
     		<?php
			}
			?>
		  
		  <!--------------------------------------------------------------------->
		  
        </table></td>
      </tr>
      <tr>      </tr>
      <tr>
        <td></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0">
      
	   <tr class="tablez">
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr class="tablez">
        <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="tablez" >
		<?php
			$SQL = "select intStyleId,intPartId,intPartNo,strPartName,dblsmv,dblSmvRate,dblEffLevel from stylepartdetails where intStyleId = '$strStyleID'";
			$result = $db->RunQuery($SQL);
			$rowId = 0;
			while($row = mysql_fetch_array($result))
			{
		?>
          <tr>

		 
            <td width="16%" bordercolor="#666666"  <?php 
		  if ($rowId == 0) 
		  	echo "bgcolor=\"#CCCCCC\" ";
			
		  ?> class="normalfntTAB"><?php 
		  if ($rowId == 0) 
		  	echo "C &amp; M EARNED";
			
		  ?> </td>
            <td width="7%" bordercolor="#666666" class="normalfntTAB">&nbsp;</td>
            <td width="7%" bordercolor="#666666" class="normalfntTAB">SMV <?php echo $row["intPartId"];  ?> </td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"><?php echo number_format($row["dblsmv"],2);?> </td>
            <td width="7%" bordercolor="#666666" class="normalfntTAB">Effi % </td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"><?php echo number_format($row["dblEffLevel"],2);?> </td>
            <td width="7%" bordercolor="#666666" class="normalfntTAB">Qty </td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"><?php echo number_format($totalOrderQty,2);?></td>
            <td width="7%" bordercolor="#666666" class="normalfntTAB">$/SMV</td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"><?php echo number_format($reaSMVRate,4);?></td>
            <td width="7%" bordercolor="#666666" class="normalfntTAB">$/UM</td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"><?php $um = ($reaSMVRate * $reaSMV) / $reaSMV / ($reaEfficiencyLevel / 100);  
																		echo number_format($um,4);
																		?></td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"><?php
			echo  number_format(round(round($upcharge + $reaFOB   - ( $TotaleDrectCost),4)*( $intQty + ($intQty * $reaExPercentage / 100) ),2),2);
			?></td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB">
              <?php
			// echo round($reaSMV*$reaSMVRate,4);
			//echo $TotaleDrectCost . "<br>";
			echo number_format(round($upcharge + $reaFOB   - ( $TotaleDrectCost),4),4);
			?>            </td>
			</tr>
            
         
		  <?php
		  $rowId ++;
		  }
		  
		  $SQL = "select stylepartdetails.intStyleId,intPartId,intPartNo,strPartName,dblsmv,dblSmvRate,dblEffLevel,reaFactroyCostPerMin, dblsmv/dblEffLevel as umin, dblsmv/dblEffLevel * reaFactroyCostPerMin as ohpc, orders.intSubContractQty   from stylepartdetails inner join orders on stylepartdetails.intStyleId = orders.intStyleId inner join  companies on orders.intCompanyID =companies.intCompanyID  where stylepartdetails.intStyleId = '$strStyleID'";
		  $result = $db->RunQuery($SQL);
			$rowId = 0;
			while($row = mysql_fetch_array($result))
			{
				$subcontractQty = $row["intSubContractQty"];
		  ?>
          <tr>

            <td bordercolor="#666666" <?php 
		  if ($rowId == 0) 
		  	echo "bgcolor=\"#CCCCCC\" ";
			
		  ?> class="normalfntTAB"><?php 
		  if ($rowId == 0) 
		  	echo "INHOUSE LABOUR COST";
			
		  ?> </td>
            <td bordercolor="#666666" class="normalfntTAB">SMV <?php echo $row["intPartId"];  ?> </td>
            <td bordercolor="#666666" class="normalfntTAB"><span class="normalfntSM">OH/U.Min</span></td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"><?php echo number_format($row["reaFactroyCostPerMin"],4);?></td>
            <td bordercolor="#666666" class="normalfntTAB"><span class="normalfntSM">U.Min/Pc</span></td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"><?php echo number_format(($row["umin"] * 100),4);?></td>
            <td bordercolor="#666666" class="normalfntTAB"><span class="normalfntSM">OH/PC</span></td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"><?php echo number_format(($row["ohpc"]*100),4);?></td>
            <td bordercolor="#666666" class="normalfntTAB"><span class="normalfntSM">Qty </span></td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"><?php echo $totalOrderQty - $row["intSubContractQty"];?></td>
            <td bordercolor="#666666" class="normalfntTAB">&nbsp;</td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"></td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"><?php echo number_format((($totalOrderQty - $row["intSubContractQty"] )*$row["ohpc"]*100),2);?></td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"><?php echo number_format(($row["ohpc"]*100),4);?></td>
</tr>

		  <?php
		  $rowId ++;
		  	}
			
			$SQL = "select distinct stylepartdetails_sub.intStyleId,stylepartdetails_sub.intPartId,stylepartdetails_sub.intPartNo,stylepartdetails_sub.strPartName,dblCM,dblTransportCost from stylepartdetails_sub inner join stylepartdetails on stylepartdetails_sub.intPartId = stylepartdetails.intPartId  where stylepartdetails_sub.intStyleId = '$strStyleID';";
		  	$result = $db->RunQuery($SQL);
			$rowId = 0;
			while($row = mysql_fetch_array($result))
			{
		  ?>
         
          <tr>
            <td bordercolor="#666666" <?php 
		  if ($rowId == 0) 
		  	echo "bgcolor=\"#CCCCCC\" ";
			
		  ?>  class="normalfntTAB"><?php 
		  if ($rowId == 0) 
		  	echo "SUBCON COST";
			
		  ?> </td>
            <td bordercolor="#666666" class="normalfntTAB">&nbsp;</td>
            <td bordercolor="#666666" class="normalfntTAB"><span class="normalfntSM">C&amp;M/PC</span></td>
           <td width="5%" bordercolor="#666666" class="normalfntTAB"><?php echo number_format($row["dblCM"],4);?></td>
            <td colspan="3" bordercolor="#666666" class="normalfntTAB"><span class="normalfntSM">SUB TRANSPORT /PC </span></td>
            <td width="7%" bordercolor="#666666" class="normalfntTAB"><?php echo number_format($row["dblTransportCost"],4);?></td>
            <td bordercolor="#666666" class="normalfntTAB"><span class="normalfntSM">Qty </span></td>
            <td width="7%" bordercolor="#666666" class="normalfntTAB"><?php echo $subcontractQty;?></td>
            <td bordercolor="#666666" class="normalfntTAB">&nbsp;</td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"></td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"><?php echo number_format((($row["dblCM"] + $row["dblTransportCost"]) *$subcontractQty ),2);?></td>
            <td width="6%" bordercolor="#666666" class="normalfntTAB"><?php echo number_format(($row["dblCM"] + $row["dblTransportCost"] ),4);?></td>
          </tr>
		  <?php
		  
		  	$rowId ++;
		  	}
		  ?>
        </table></td>
        </tr>
      <tr class="tablez">
        <td colspan="2">&nbsp;</td>
      </tr>
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
						echo "<td class=\"normalfntRiteTAB\">".number_format(round(($costpc[$loops]/$TotaleDrectCost*100),2),2)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($costpc[$loops],4)."</td>";
						echo "</tr>";
						$totPresenttage+=round(($costpc[$loops]/$TotaleDrectCost*100),2);
					}
			  	  
			  ?>
                  <tr>
                    <td class="normalfntTAB">&nbsp;</td>
                    <td class="nfhighlite1"><?php echo number_format($totPresenttage,2);?></td>
                    <td class="normalfntRiteTAB">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="normalfntTAB">ACCESSORIES+PACKING METERIALS</td>
                    <td class="normalfntRiteTAB"><?php echo number_format($Access_Pack,2);?></td>
                    <td class="normalfntRiteTAB"><?php echo number_format($Access_Packrange,4);?></td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
        <td width="40%">&nbsp;</td>
      </tr>
      <tr class="tablez">
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr class="tablez">
        <td colspan="2">&nbsp;</td>
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
<script type="text/javascript">
document.getElementById("npfob").innerHTML = "<?php echo number_format(($netmargin/$reaFOB*100),1); ?> %";

document.getElementById("gpfob").innerHTML = "<?php 
$gpfob = ($cmVal -  $labrate) / $reaFOB * 100;
echo number_format($gpfob,1);
 ?> %";
 
 document.getElementById("gpcm").innerHTML = "<?php 
$gpcm = ($cmVal -  $labrate) / $cmVal * 100;
if (($cmVal -  $labrate) < 0 && $cmVal < 0)
	$gpcm = $gpcm * -1;
			 echo number_format($gpcm,1);
 ?> %";
 
document.getElementById("ohpm").innerHTML = "<?php 
			 echo number_format($companycostperminute,4);
 ?>";



</script>
</html>
