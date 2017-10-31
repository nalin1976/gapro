<?php 
session_start();
if(!$authenticationApplied)
	include "../authentication.inc";
include "../Connector.php";
$xml = simplexml_load_file('../config.xml');
$ReportISORequired = $xml->companySettings->ReportISORequired;
$BuyingOfficeMargin = $xml->companySettings->BuyingOfficeMargin;
$DisplayImageInApprovalCostSheet = $xml->PreOrder->DisplayImageInApprovalCostSheet;
$backwardseperator ='../';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Recut : : Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<link rel="stylesheet" href="../css/lightbox.css" type="text/css" media="screen" />
<body>

<table width="800" align="center">
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0"><tr><td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
      <?php		
		$CompanyID=0;
		$strRecutNo=$_GET["recutNo"];
		$arrRecutNo = explode('/',$strRecutNo);
		$recutNo = $arrRecutNo[1];
		$recutYear = $arrRecutNo[0];
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
		$costinglabourCost = 0;
		$oderDate = "";
//DATE_FORMAT(orders.dtmDate, '%Y %b %d')
		$SQL="SELECT o.strOrderNo, o.intStyleId, DATE_FORMAT(orc.dtmDate, '%Y-%b-%d')  AS dtmDate,date(orc.dtmDate) as orderDate,  o.intCompanyID, o.intBuyerID, orc.intStatus , o.reaLabourCost , o.intBuyingOfficeId, orc.intUserID, o.reaECSCharge, o.intCoordinator, o.intDivisionId, o.intApprovalNo,
 o.strDescription, orc.intRecutQty as intQty, o.strCustomerRefNo, o.intSeasonId, o.strRPTMark, o.reaExPercentage, o.reaEfficiencyLevel,
 o.reaCostPerMinute, o.reaSMV, o.reaSMVRate, o.reaFinPercntage, o.reaFOB, o.reaProfit,o.dblFacProfit,intCompanyOrderNo,dtmOrderDate,orc.strRecutReason,orc.strEPFNo
FROM orders o inner join orders_recut orc on  o.intStyleId = orc.intStyleId
WHERE orc.intRecutNo='$recutNo' and intRecutYear='$recutYear' ";
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
			$strStyleID = $row["intStyleId"];
			$recutReason	= $row["strRecutReason"];
			$EPFNo		= $row["strEPFNo"];
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
        <td colspan="2"><?php include $backwardseperator.'reportHeader.php'?></td>
        
       <!-- <td width="20%" class="tophead"><p class="topheadBLACK">
 		
          </td>-->
		  		  		 <?php if($DisplayImageInApprovalCostSheet=="true"){?>
                <td width="20%" rowspan="2" class="normalfntMid">
				
				<?php
				 if (file_exists("../styles/" . $_GET["styleID"] . ".jpg"))	
				 {
				?>				
				<a href="../styles/<?php echo $_GET["styleID"]; ?>.jpg" ><img src="../styles/<?php echo $_GET["styleID"]; ?>.jpg" name="imgStyle" width="150" height="120" border="0" id="imgStyle" alt=""/></a>
				<?php
				}
				else
				{
				?>
				<a href="#"><img src="../images/noimg.png" name="imgStyle" width="55" height="65" border="0" id="imgStyle" /></a>
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
				echo "Pending - Recut Cost Sheet";
			}
			else if($odrStatus == "1" || $odrStatus=="2")
			{
				echo "Approval Pending - Recut Cost Sheet";
			}
			else if($odrStatus == "3")
			{
				echo "Approved - Recut Cost Sheet";
			}
			
			/*else if($odrStatus == "10")
			{
				echo "Rejected - Cost Sheet";
			}
			else if($odrStatus == "13")
			{
				echo "Completed - Cost Sheet";
			}*/
			
   					if($ReportISORequired == "true")
   					{
   						$xmlISO = simplexml_load_file('../iso.xml');
   						echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $xmlISO->ISOCodes->CostSheetReport;
						}              
	                 
                   ?> </td>
            </tr>
          <tr>
            <td width="17%" class="bcgl1txt1NB">BUYER</td>
            <td width="1%" class="bcgl1txt1NB"><b>:</b></td>
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
          <tr style="display:none">
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
            <td class="bcgl1txt1NB"><b>:</b></td>
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
            <td class="bcgl1txt1NB"><b>:</b></td>
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
            <td class="bcgl1txt1NB">RECUT REASON</td>
            <td class="bcgl1txt1NB"><b>:</b></td>
            <td class="normalfnt2Black"><?php echo $recutReason?></td>
            <td class="bcgl1txt1NB">RESPONCIBLE PERSON EPF NO</td>
            <td class="bcgl1txt1NB"><b>:</b></td>
            <td class="normalfnt2Black"><?php echo $EPFNo?></td>
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
            <td width="18%" bgcolor="#BED6E9" class="bcgl1txt1B">Orit Order  No</td>
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
        <td><table width="100%" border="0" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablez">
        <thead>
          <tr>
            <td width="2%" bgcolor="#CCCCCC" class="bcgl1txt1B">&nbsp;</td>
            <td width="28%" bgcolor="#CCCCCC" class="bcgl1txt1B">ITEM DESCRIPTION</td>
            <td width="6%" bgcolor="#CCCCCC" class="bcgl1txt1B">ORIGIN</td>
            <td width="5%" bgcolor="#CCCCCC" class="bcgl1txt1B">UNIT</td>
            <td width="7%" bgcolor="#CCCCCC" class="bcgl1txt1B">CON/PC</td>
            <td width="6%" bgcolor="#CCCCCC" class="bcgl1txt1B">REQ QTY</td>
            <td width="8%" bgcolor="#CCCCCC" class="bcgl1txt1B">WASTAGE %</td>
			<td width="8%" bgcolor="#CCCCCC" class="bcgl1txt1B">FREIGHT</td>
            <td width="7%" bgcolor="#CCCCCC" class="bcgl1txt1B">TOTAL QTY</td>
            <td width="7%" bgcolor="#CCCCCC" class="bcgl1txt1B">PRICE (USD)</td>
            <td width="8%" bgcolor="#CCCCCC" class="bcgl1txt1B">TOTAL COST PC</td>
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
		  $SQL_Cetegory="SELECT DISTINCT mc.strDescription, mc.intID
FROM ((orderdetails_recut odr INNER JOIN matitemlist m ON odr.intMatDetailID = m.intItemSerial)
 INNER JOIN matmaincategory mc 
ON m.intMainCatID = mc.intID) INNER JOIN itempurchasetype i ON odr.intOriginNo = i.intOriginNo
 WHERE  odr.intRecutNo='$recutNo' and odr.intRecutYear='$recutYear'
ORDER BY mc.intID;";
						
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
					
					$SQL_orderDetails="SELECT o.strOrderNo, o.intStyleId, odr.strUnit, odr.dblUnitPrice, odr.reaConPc,
 odr.reaWastage,  odr.intOriginNo, odr.dblFreight ,odr.dblTotalQty,
 odr.dblReqQty, odr.dblTotalValue, odr.dbltotalcostpc, m.strItemDescription,
 mc.strDescription, i.strOriginType, m.intMainCatID, m.intItemSerial,i.intType
FROM orders o inner join orders_recut orc on orc.intStyleId= o.intStyleId
 inner join orderdetails_recut odr on orc.intRecutNo= odr.intRecutNo and orc.intRecutYear = odr.intRecutYear 
INNER JOIN matitemlist m ON odr.intMatDetailID = m.intItemSerial
INNER JOIN matmaincategory mc ON m.intMainCatID = mc.intID
INNER JOIN itempurchasetype i ON odr.intOriginNo = i.intOriginNo
WHERE orc.intRecutNo='$recutNo' and orc.intRecutYear='$recutYear' AND m.intMainCatID='".$row_Category["intID"]."'
ORDER BY m.intMainCatID,m.strItemDescription";
								  
					$result_order = $db->RunQuery($SQL_orderDetails);
					while($row_order = mysql_fetch_array($result_order))
					{
       					echo "<tr>";
						echo "<td class=\"normalfntTAB\">".$index."</td>";
						echo " <td class=\"normalfntTAB\">".$row_order["strItemDescription"]."</td>";
						
						if($row_Category["strDescription"]=="FABRIC" & $row_order["intType"]=="0")
						{
							$FabFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotFabFinance+=$FabFinance;
						}
						
						if($row_Category["strDescription"]=="ACCESSORIES" & $row_order["intType"]=="0")
						{
							$TrimFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotTrimFinance+=$TrimFinance;
						}
						
						else if($row_Category["strDescription"]=="PACKING MATERIALS" & $row_order["intType"]=="0")
						{
							$TrimFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotTrimFinance+=$TrimFinance;
						}
						
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
					echo " <td class=\"normalfntTAB\" colspan=\"2\">&nbsp;</td>";	
					echo "<td colspan=\"8\" class=\"normalfntTAB\"><b>TOTAL</b></td>";
					echo "<td class=\"normalfntRiteTAB\"><b>".number_format($counttotalcostpc,4)."</b></td>";
					echo "<td class=\"normalfntRiteTAB\"><b>".number_format($countusdValue,4)."</b></td>";
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
						
						$SQL_orderDetails="SELECT o.strOrderNo, o.intStyleId, odr.strUnit, odr.dblUnitPrice, odr.reaConPc,
 odr.reaWastage,  odr.intOriginNo, odr.dblFreight ,odr.dblTotalQty,
 odr.dblReqQty, odr.dblTotalValue, odr.dbltotalcostpc, m.strItemDescription,
 mc.strDescription, i.strOriginType, m.intMainCatID, m.intItemSerial,i.intType
FROM orders o inner join orders_recut orc on orc.intStyleId= o.intStyleId
 inner join orderdetails_recut odr on orc.intRecutNo= odr.intRecutNo and orc.intRecutYear = odr.intRecutYear 
INNER JOIN matitemlist m ON odr.intMatDetailID = m.intItemSerial
INNER JOIN matmaincategory mc ON m.intMainCatID = mc.intID
INNER JOIN itempurchasetype i ON odr.intOriginNo = i.intOriginNo
WHERE orc.intRecutNo='$recutNo' and orc.intRecutYear='$recutYear' AND m.intMainCatID='".$row_Category["intID"]."'
ORDER BY m.intMainCatID,m.strItemDescription ";
						
						$result_order = $db->RunQuery($SQL_orderDetails);
						while($row_order = mysql_fetch_array($result_order))
						{
							echo "<tr>";
							echo "<td class=\"normalfntTAB\">".$index."</td>";
							echo " <td class=\"normalfntTAB\">".$row_order["strItemDescription"]."</td>";
							$strOriginType=$row_order["strOriginType"];
							
							
								
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
					echo " <td class=\"normalfntTAB\" colspan=\"2\">&nbsp;</td>";	
					echo "<td colspan=\"8\" class=\"normalfntTAB\"><b>TOTAL</b></td>";
					echo "<td class=\"normalfntRiteTAB\"><b>".number_format($counttotalcostpc,4)."</b></td>";
					echo "<td class=\"normalfntRiteTAB\"><b>".number_format($countusdValue,4)."</b></td>";
					echo "</tr>";
					$countusdValue=0.0;
					$counttotalcostpc=0.0;		
					
				}
				
				
				
			}
			
			
			for($loops=0;$loops< count($costpc);$loops++)
			{	 
				$TotaleDrectCost+=$costpc[$loops];				
			}	
				//echo number_format($TotaleDrectCost,4);
			
			
			echo "<tr>";	
			echo " <td class=\"normalfntTAB\" colspan=\"2\">&nbsp;</td>";	
			//echo " <td class=\"normalfntTAB\" >&nbsp;</td>";			
			echo " <td class=\"normalfntTAB\" colspan=\"8\"><b>GRAND TOTAL</b></td>";			
			echo "<td class=\"normalfntRiteTAB\"><b>".number_format($TotaleDrectCost,4)."</b></td>";
			echo "<td class=\"normalfntRiteTAB\"><b>".number_format(($TotaleDrectCost * $intQty),4)."</b></td>";	
			echo "</tr>";
		  ?>
         <!-- <tr>
            <td colspan="10" class="normalfntTAB">
            <?php
			//echo "Finance + Economic Service " . $reaESC .'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'. " Finance ".number_format($reaFinPercntage,4)."%";
			////echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'."FAB Fin: ";
			//echo "<span class=\"normalfnth2B\">";
			$totalFabFinance = round($TotFabFinance*$totalOrderQty,2);
			//echo number_format($totalFabFinance,2);
			//echo "</span>";
			//echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'." TRIM Fin: ";
			//echo "<span class=\"normalfnth2B\">";
			$totalTrimFinance = round($TotTrimFinance*$totalOrderQty,2);
			//echo number_format($totalTrimFinance,2);
			//echo "</span>";
			?>            </td>
            <td class="normalfntRiteTAB"><?php 
				$CountFinanace=round($totalFabFinance+$totalTrimFinance,4);
			//echo number_format(($CountFinanace/$intQty),4);
			//echo number_format(($CountFinanace/$totalOrderQty),4);
				$totFinance = number_format(($CountFinanace + $reaESC ),4);
			?></td>
            <td class="normalfntRiteTAB"><?php 
			//$CountFinanace=$totalFabFinance+$totalTrimFinance;
			//echo number_format($CountFinanace,4);
			?></td>
          </tr>
          <tr>
            <td colspan="10" class="normalfntTAB">Total Direct Cost</td>
            
            <td class="normalfntRiteTAB"><?php 
			for($loops=0;$loops< count($costpc);$loops++)
			{	 
				$TotaleDrectCost+=$costpc[$loops];				
			}	
				//echo number_format($TotaleDrectCost,4);
			
			?></td>
			<td colspan="10" class="normalfntRiteTAB"><?php //echo number_format(($TotaleDrectCost * $totalOrderQty),4);?></td>
          </tr>
           
           <?php
          	$buyingOfficeProfit = $CMVAL - $costinglabourCost;
         	$requiredMinimumCM = ($CMVAL * $BuyingOfficeMargin / 100);
         	$bgColor = "";
         	if($buyingOfficeProfit < $requiredMinimumCM && $odrStatus == 10)
         		$bgColor = " bgcolor=\"#FF0000\" ";
          ?>
          <tr <?php //echo $bgColor; ?>>
            <td colspan="10" class="normalfntTAB">C&amp;M Earned </td>
           
            <td class="normalfntRiteTAB"><?php
			//echo number_format($reaSMV*$reaSMVRate,4);
			?></td>
			 <td class="normalfntRiteTAB">
			<?php
			//echo number_format((($reaSMV*$reaSMVRate)*$intQty),4);
			?></td>
          </tr>
          <tr>
            <td colspan="10" class="normalfnBLD1TAB">Target FOB</td>
            <td class="normalfntRiteTAB">
            <?php
			//echo number_format($reaFOB,4);
			?></td>
            <td class="normalfntRiteTAB"><?php
			//echo number_format($reaFOB*$intQty,4);
			?></td>
          </tr>
		            <tr>
		              <td colspan="10" class="normalfnBLD1TAB">REQD FOB</td>
		              <td class="normalfntRiteTAB"><?php $ReqFOB = $reaFOB - $facProfit;
					 // echo number_format($ReqFOB,4);
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
			//echo number_format($facProfit,4);
			//-------------------end--------------------------------------------
			?></td>
            <td class="normalfntRiteTAB"><?php
			//echo number_format(($facProfit*$intQty),4);
			?></td>
          </tr>-->
          <tr>
            <td colspan="9">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
			<td>&nbsp;</td>
          </tr>
         <!-- <tr>
            <td colspan="12"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez" >
              <tr>
                <td width="18%"  bgcolor="#CCCCCC" class="border-All-fntsize9">C &amp; M EARNED</td>
                <td width="5%"  class="border-top-bottom-right">&nbsp;</td>
				<td width="6%"  class="border-top-bottom-fntsize9">SMV 1</td>
                <td width="6%"  class="border-top-bottom-right"><div class="normalfntRite"><?php// echo $reaSMV;?></div></td>
                <td width="7%" class="border-top-bottom-fntsize9">Effi % </td>
                <td width="5%" class="border-top-bottom-right"><div class="normalfntRite"><?php //echo number_format($reaEfficiencyLevel,2);?></div></td>
                <td width="5%" class="border-top-bottom-fntsize9">Qty 1 </td>
                <td width="8%" class="border-top-bottom-right"><div class="normalfntRite"><?php //echo $intQty; ?></div></td>
                <td width="6%" class="border-top-bottom-fntsize9">$/SMV</td>
                <td width="6%" class="border-top-bottom-right"><div class="normalfntRite"><?php //echo number_format($reaSMVRate,4); ?></div></td>
                <td width="5%" class="border-top-bottom">$/UM</td>
                <td width="5%" class="border-top-bottom-right"><div class="normalfntRite">
				<?php 
					$um = ($reaSMV * $reaSMVRate)/($reaSMV/($reaEfficiencyLevel/100));  
					//echo number_format($um,4);
				?></div></td>
                <td width="9%"   class="border-top-bottom-right"><div class="normalfntRite"><?php
					//echo number_format($reaSMV*$reaSMVRate,4);
			?></div></td>
                <td width="9%" class="border-top-bottom-right"><div class="normalfntRite"><?php
			//echo number_format((($reaSMV*$reaSMVRate)*$intQty),4);
			?></div></td>
              </tr>
              <tr>
                <td class="border-All-fntsize9"  bgcolor="#CCCCCC">INHOUSE LABOUR COST</td>
                <td   class="border-top-bottom-right-fntsize9">SMV 1</td>
                <td   class="border-top-bottom-fntsize9">OH/U.Min</td>
                <td width="6%"  class="border-top-bottom-right"><div class="normalfntRite"><?php //echo number_format(round($reaCostPerMinute,4));?></div></td>
                <td  class="border-top-bottom-fntsize9">U.Min/Pc</td>
                <td width="5%"  class="border-top-bottom-right"><div class="normalfntRite">
				<?php 
				$MIn_Pc =  $reaSMV/($reaEfficiencyLevel/100);
				//echo number_format($MIn_Pc,2);
				?></div></td>
                <td  class="border-top-bottom-fntsize9">OH/PC</td>
                <td width="8%"  class="border-top-bottom-right"><div class="normalfntRite"><?php //echo number_format(($row["ohpc"]*100),2);?></div></td>
                <td   class="border-top-bottom-fntsize9">Qty</td>
                <td width="6%"  class="border-top-bottom-right"><div class="normalfntRite"><?php //echo $intQty; ?></div></td>
                <td  class="border-top-bottom-fntsize9">&nbsp;</td>
                <td width="5%"  class="border-top-bottom-right"></td>
                <td width="9%"  class="border-top-bottom-right"><div class="normalfntRite">
				<?php //echo number_format((($totalOrderQty - $row["intSubContractQty"] )*$row["ohpc"]*100),2);
				?>
				</div></td>
                <td width="9%"  class="border-top-bottom-right"><div class="normalfntRite">
				<?php //echo number_format(($row["ohpc"]*100),4);
				?>
				</div></td>
              </tr>

              

            </table></td>
            </tr>-->
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
</html>
