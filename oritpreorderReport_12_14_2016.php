<?php 
session_start();
if(!$authenticationApplied)
	include "authentication.inc";
include "Connector.php";
include "HeaderConnector.php";
include "permissionProvider.php";
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
		$upcharge = 0;
//DATE_FORMAT(orders.dtmDate, '%Y %b %d')
		$SQL="SELECT orders.strOrderNo, orders.intStyleId, DATE_FORMAT(orders.dtmDate, '%Y-%b-%d')  AS dtmDate,date(orders.dtmDate) as orderDate,  orders.intCompanyID, orders.intBuyerID, orders.intStatus , orders.reaLabourCost , orders.intBuyingOfficeId, orders.intUserID, orders.reaECSCharge, orders.intCoordinator, orders.intDivisionId, orders.intApprovalNo, orders.strDescription, orders.intQty, orders.strCustomerRefNo, orders.intSeasonId, orders.strRPTMark, orders.reaExPercentage, orders.reaEfficiencyLevel, orders.reaCostPerMinute, orders.reaSMV, orders.reaSMVRate, orders.reaFinPercntage, orders.reaFOB, orders.strStyle,orders.reaProfit,orders.dblFacProfit,intCompanyOrderNo,dtmOrderDate,reaUPCharges,strUPChargeDescription,intSubContractQty,reaFinance,companies.reaFactroyCostPerMin,specification.intSRNO, productcategory.strCatName, dblFacOHCostMin

FROM
orders
Inner Join companies ON orders.intCompanyID = companies.intCompanyID
Left Join specification ON orders.intStyleId = specification.intStyleId
Inner Join productcategory ON orders.productSubCategory = productcategory.intCatId
WHERE (((orders.intStyleId)='".$strStyleID."'));";
		$result = $db->RunQuery($SQL);
		
		while($row = mysql_fetch_array($result))
		{			
			$CompanyID				= $row["intCompanyID"] ;
			$BuyerID   				= $row["intBuyerID"];
			$intBuyingOfficeId		= $row["intBuyingOfficeId"];
			$UserID					= $row["intUserID"];	
			//$strCoordinator=$row["UserName"];	
			$strCoordinator			= $row["intCoordinator"];
			$intDivisionId			= $row["intDivisionId"];	
			$intApprovalNo			= $row["intApprovalNo"];	
			$strOrderNo				= $row["strOrderNo"];
			$strDescription			= $row["strDescription"];
			$strCustomerRefNo		= $row["strCustomerRefNo"];
			$intSeasonId			= $row["intSeasonId"];
			$strRPTMark				= $row["strRPTMark"];
			$reaEfficiencyLevel		= $row["reaEfficiencyLevel"];
			$reaCostPerMinute		= $row["reaCostPerMinute"];
			$reaSMV					= $row["reaSMV"];
			$reaSMVRate				= $row["reaSMVRate"];
			$reaFinPercntage		= $row["reaFinPercntage"];
			$intQty					= $row["intQty"];
			$reaFOB					= $row["reaFOB"];
			$reaESC					= $row["reaECSCharge"];
			$reaProfit				= $row["reaProfit"];
			$reaExPercentage		= $row["reaExPercentage"];
			$costinglabourCost 		= $row["reaLabourCost"]; 
			$odrStatus  			= $row["intStatus"];
			$oderDate 				= $row["dtmDate"]; 
			$facProfit 				= $row["dblFacProfit"];
			$orderDate				= $row["orderDate"];
			$companyOrderNo			= $row["intCompanyOrderNo"];
			$companyOrderDate		= $row["dtmOrderDate"];
			$upcharge 				= $row["reaUPCharges"];
			$upchargereason 		= $row["strUPChargeDescription"];
			//$companycostperminute 	= $row["reaFactroyCostPerMin"];
			$companycostperminute 	= $row["dblFacOHCostMin"];
			$subcontractQty 		= $row["intSubContractQty"];
			$reaFinance 			= $row['reaFinance'];
			$strStyle 				= $row['strStyle'];
			$SCNo  					= $row['intSRNO'];
			$productCategory 		= $row['strCatName'];
		}
		
		//$SQL="SELECT     companies.strName, companies.strAddress1, companies.strAddress2, companies.strStreet, companies.strCity,companies.strState, companies.strCountry, companies.strZipCode, companies.strPhone, companies.strEMail, companies.strFax,companies.strWeb, companies.intCompanyID, orders.intStyleId FROM companies CROSS JOIN orders WHERE (orders.intStyleId = '".$strStyleID."') AND (companies.intCompanyID = '".$CompanyID."')";	
		
		//======================================================================================================================
		// Comment On - 2015-08-26
		// Comment By - Nalin Jayakody
		// Description - To avoid display company header information twice
		//======================================================================================================================
		/*$SQL="SELECT     companies.strName, companies.strAddress1, companies.strAddress2, companies.strStreet, companies.strCity,companies.strState, companies.intCountry, companies.strZipCode, companies.strPhone, companies.strEMail, companies.strFax,companies.strWeb, companies.intCompanyID, orders.intStyleId FROM companies CROSS JOIN orders WHERE (orders.intStyleId = '".$strStyleID."') AND (companies.intCompanyID = '".$CompanyID."')";	
		
		$result = $db->RunQuery($SQL);
		
		while($row = mysql_fetch_array($result))
		{			
			echo $row["strName"] ;
			echo "</p><p class=\"normalfnt\">";
			echo $row["strAddress1"]." ".$row["strAddress2"]." ".$row["strStreet"]." ".$row["strCity"]." ".$row["strCountry"]." ".$row["strCountry"].". <br>"." Tel: ".$row["strPhone"]." Fax: ".$row["strFax"]." <br>E-Mail: ".$row["strEMail"]." Web: ".$row["strWeb"] ;
			echo "</p>";
		}*/
		//======================================================================================================================
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
            <td height="36" colspan="5" class="head2">
            <?php
			if($odrStatus == "0")
			{
				echo "Pending for Approval";
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
			
			?>
             <?php

			if ($SCNo != "")
				echo " - SC$SCNo";
				
				if($ReportISORequired == "false")
   					{
   						$xmlISO = simplexml_load_file('iso.xml');
   						echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $xmlISO->ISOCodes->CostSheetReport;
						}   
						
			?></td>
            </tr>
          <tr>
            <td width="19%" height="24" class="bcgl1txt1NB">
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
            $SQL="SELECT Name FROM useraccounts WHERE (intUserID = ".$strCoordinator.")";
			$result = $db->RunQuery($SQL);
			
			while($row = mysql_fetch_array($result))
			{
				echo $row["Name"]."<br>" ;
				$mobileMerchandiser 	= $row["Name"];	
			}
			
			
			$SQL="SELECT Name FROM useraccounts WHERE (intUserID = ".$UserID.")";
			$result = $db->RunQuery($SQL);
			
			while($row = mysql_fetch_array($result))
			{
				echo "Costing prepared by : " . $row["Name"] ;
						
			}
			
			?>            </td>
          </tr>
          <tr>
            <td height="24" class="bcgl1txt1NB">COSTING DATE</td>
            <td class="normalfnt2Black">: <?php
			echo date("jS F Y", strtotime($orderDate)); 
		
			?></td>
            <td>&nbsp;</td>
            <td class="bcgl1txt1NB">APPROVAL NO</td>
            <td class="normalfnt2Black">: <?php echo $intApprovalNo;?></td>
          </tr>
          <tr>
            <td height="25" class="bcgl1txt1NB">BUYING OFFICE</td>
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
            <td height="21" class="bcgl1txt1NB">STYLE NO            </td>
            <td class="normalfnt2Black">: <?php echo $strStyle;?></td>
            <td rowspan="2">&nbsp;</td>
            <td class="bcgl1txt1NB">SEASON</td>
            <td class="normalfnt2Black">
            : <?php 
			 $SQL="SELECT  strSeason FROM seasons WHERE (intSeasonId = ".$intSeasonId.")";
			$result = $db->RunQuery($SQL);
			
			if($row = mysql_fetch_array($result))
			{
				echo $row["strSeason"];
			}
			
			?>            </td>
          </tr>
          <tr>
          	<td height="27" class="bcgl1txt1NB">DELIVERY PERIOD</td>
            <td class="normalfnt2Black">
            	: <?php 
					
					$SQL = " SELECT Min(deliveryschedule.dtDateofDelivery) AS First_Delivery, ".
                           "       (SELECT MAX(deliveryschedule.dtDateofDelivery) FROM deliveryschedule " .
						   "        WHERE deliveryschedule.intStyleId =  '$strStyleID') as Last_Delivery " .
						   " FROM   deliveryschedule ".
                           " WHERE  deliveryschedule.intStyleId =  '$strStyleID'";

					$result = $db->RunQuery($SQL);
					
					if($row = mysql_fetch_array($result))
					{
						echo date("d/m/Y", strtotime($row["First_Delivery"])). " - " . date("d/m/Y", strtotime($row["Last_Delivery"]));
					}
				
				?>
            </td>
          </tr>
          <tr>
            <td class="bcgl1txt1NB"><?php if($newstrStyleID!='')echo "NEW STYLE NO" ?>  </td>
            <td class="normalfnt2Black"><?php if($newstrStyleID!='')echo ": $newstrStyleID" ?>  </td>
            <td class="normalfnt2bld">&nbsp;</td>
            <td class="normalfnt2">&nbsp;</td>
          </tr>
          <tr>
            <td class="bcgl1txt1NB">&nbsp;</td>
            <td class="normalfnt2Black">&nbsp;</td>
            <td>&nbsp;</td>
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
            <td class="bcgl1txt1"><?php echo number_format($intQty,0);$mobileOdrQty = $intQty;?></td>
            <td class="bcgl1txt1"><?php  echo $reaExPercentage; $mobileecessxqty= $reaExPercentage; ?></td>
            <td class="bcgl1txt1"><?php echo $strCustomerRefNo; ?></td>
            <td colspan="2" class="bcgl1txt1"><?php echo $strRPTMark; ?></td>
          </tr>
          <tr>
            <td height="19" bgcolor="#BED6E9" class="bcgl1txt1B">Efficiency Level</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">Product Category  </td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">SMV</td>
            <!--<td bgcolor="#BED6E9" class="bcgl1txt1B">$/SMV</td>-->
            <td bgcolor="#BED6E9" class="bcgl1txt1B">EPM</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">Total Qty </td>
            <td width="14%" bgcolor="#BED6E9" class="bcgl1txt1B">Sub Contact Qty. </td>           
          </tr>
          <tr>
            <td height="20" class="bcgl1txt1"><?php echo $reaEfficiencyLevel."%"; $mobileEfflevel = $reaEfficiencyLevel;
			?></td>
            <td class="bcgl1txt1" ><?php echo $productCategory; ?></td>
            <td class="bcgl1txt1"><?php echo number_format($reaSMV,2); $mobileSMV = $reaSMV; ?></td>
            <td class="bcgl1txt1"><?php echo number_format($reaSMVRate,4); $mobileSMVRate= number_format($reaSMVRate,4);?></td>
            <td class="bcgl1txt1"><?php
			
			# ======================================================================
			# Change On - 2015/09/04
			# Change By - Nalin Jayakody
			# Description - Remove exccess quantity calculation from report
			# ======================================================================
			//$totalOrderQty= round($intQty + ($intQty * $reaExPercentage / 100));
			# ======================================================================
			$totalOrderQty= round($intQty);
			 echo number_format($intQty + ($intQty * $reaExPercentage / 100),0);
			 $mobiletotalqty = $totalOrderQty ; ?></td>
            <td class="bcgl1txt1"><?php echo $subcontractQty; $mobilesubQty = $subcontractQty; ?></td>
            </tr>
            <?php
            if ($canSeeCostManagementFigures)
            {
            ?>
          <tr>
            <td height="20" bgcolor="#BED6E9" class="bcgl1txt1B">NP %</td>
            <!--<td bgcolor="#BED6E9" class="bcgl1txt1B">Factory OH Per Used Minute</td>-->
            <td bgcolor="#BED6E9" class="bcgl1txt1B">Factory OH Per Available Minute</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">CM/FOB</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B" >GP/FOB</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">&nbsp;</td>
            <!--<td bgcolor="#BED6E9" class="bcgl1txt1B" >CM/UM</td>-->       
            <td bgcolor="#BED6E9" class="bcgl1txt1B" >CM/AM</td>   
          </tr>    
          <tr>
            <td class="bcgl1txt1" id="npfob" >&nbsp;</td>
            <td class="bcgl1txt1" id="ohpm">&nbsp;</td>
            <td class="bcgl1txt1" id="cmfob">&nbsp;</td>
            <td class="bcgl1txt1" id="gpfob">&nbsp; </td>
            <!--<td class="bcgl1txt1" id="gpcm">&nbsp;</td>-->
            <td class="bcgl1txt1" id="gpfobnet">&nbsp;</td>
            <td class="bcgl1txt1" id="cmum" colspan="2">&nbsp;</td>
          </tr>
          	<?php
          	}
 				else if ( $canSeeCostingProfitMargin)
            {
            ?>
          <tr>
            <!--<td height="20" bgcolor="#BED6E9" class="bcgl1txt1B">Profit </td>-->
            <td height="20" bgcolor="#BED6E9" class="bcgl1txt1B">&nbsp;</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B"></td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B"></td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B" ></td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B">&nbsp;</td>
            <td bgcolor="#BED6E9" class="bcgl1txt1B" ></td>          
          </tr>    
          <tr>
            <td class="bcgl1txt1" id="npfob" >&nbsp;</td>
            <td class="bcgl1txt1">&nbsp;</td>
            <td class="bcgl1txt1">&nbsp; </td>
            <td class="bcgl1txt1">&nbsp;</td>
            <td class="bcgl1txt1" >&nbsp;</td>
            <td class="bcgl1txt1" colspan="2">&nbsp;</td>
          </tr>
          	<?php
          	}
          	?>
          	
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
		  $mobileCMUp = 0;
		  
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
				if($row_Category["strDescription"]=="FABRIC" | $row_Category["strDescription"]=="ACCESSORIES" | $row_Category["strDescription"]=="PACKING  MATERIALS")
				{	
					$category[$loop]=$row_Category["strDescription"];		
					$loop++;
					
					echo "<tr>"."<td>&nbsp;</td><td class=\"normalfnt2BITAB\">";
					echo $row_Category["strDescription"];
					echo"</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>"; 					
					
					//(orderdetails / matmaincategory / matitemlist / itempurchasetype )
					
					$SQL_orderDetails="SELECT orderdetails.strOrderNo, orderdetails.intStyleId, orderdetails.strUnit, orderdetails.dblUnitPrice, orderdetails.reaConPc, orderdetails.reaWastage, orderdetails.strCurrencyID, orderdetails.intOriginNo, orderdetails.dblFreight ,orderdetails.dblTotalQty, orderdetails.dblReqQty, orderdetails.dblTotalValue, orderdetails.dbltotalcostpc, matitemlist.strItemDescription, matmaincategory.strDescription, itempurchasetype.strOriginType, matitemlist.intMainCatID, matitemlist.intItemSerial,itempurchasetype.intType
					  			   FROM ((orderdetails INNER JOIN matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial) INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID) INNER JOIN itempurchasetype ON orderdetails.intOriginNo = itempurchasetype.intOriginNo
					  			   WHERE (((orderdetails.intStyleId)='".$strStyleID."') AND ((matitemlist.intMainCatID)='".$row_Category["intID"]."')) AND (orderdetails.intstatus != '0' or orderdetails.intstatus IS NULL)
					  			   ORDER BY matitemlist.intMainCatID,matitemlist.strItemDescription;";
								  
					$result_order = $db->RunQuery($SQL_orderDetails);
					while($row_order = mysql_fetch_array($result_order))
					{
       					echo "<tr>";
						echo "<td class=\"normalfntTAB\">".$index."</td>";
						echo " <td class=\"normalfntTAB\">".$row_order["strItemDescription"]."</td>";
						
						//$strOriginType=$row_order["strOriginType"];
						
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
						//finance based on the type of itempurchase type.	
						$strOriginType=$row_order["intType"];	
						if($strOriginType=="0")
						{
							$strOriginType="F";							
						}
						else
						{
							$strOriginType="L";
						}	
							
						//$TotFabFinance Value
						/*if($row_Category["strDescription"]=="FABRIC" & $row_order["strOriginType"]=="IMP-F")
						//if($row_Category["strDescription"]=="FABRIC" & $row_order["intType"]=="0")
						{
							$FabFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotFabFinance+=$FabFinance;
						}
						else*/ if($row_Category["strDescription"]=="FABRIC" & $row_order["intType"]=="LOC-F")
						{
							$FabFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotFabFinance+=$FabFinance;
						}
						
						//$TotTrimFinance Value
						/*if($row_Category["strDescription"]=="ACCESSORIES" & $row_order["intType"]=="0")
						{
							$TrimFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotTrimFinance+=$TrimFinance;
						}*/
						/*else if($row_Category["strDescription"]=="ACCESSORIES" & $row_order["strOriginType"]=="LOC-F")
						{
							$TrimFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotTrimFinance+=$TrimFinance;
						}
						/*else if($row_Category["strDescription"]=="PACKING MATERIALS" & $row_order["intType"]=="0")
						{
							$TrimFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotTrimFinance+=$TrimFinance;
						}*/
						/*else if($row_Category["strDescription"]=="PACKING MATERIALS" & $row_order["strOriginType"]=="LOC-F")
						{
							$TrimFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
							$TotTrimFinance+=$TrimFinance;
						}*/
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
							//number_format($row_order["dblReqQty"],4)
						echo " <td class=\"normalfntMidTAB\">".$row_order["strOriginType"]."</td>";
						echo "<td class=\"normalfntMidTAB\">".$row_order["strUnit"]."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["reaConPc"],6)." </td>";				
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblReqQty"],0)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["reaWastage"],2)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblFreight"],4)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblTotalQty"],0)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblUnitPrice"],4)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dbltotalcostpc"],4)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblTotalValue"],2)."</td>";
						
						$countusdValue+=$row_order["dblTotalValue"];
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
					
					$dblIntValue = ($countusdValue / 100) * 2;
					
					$totIntersetValue += $dblIntValue;
					
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
					  			   WHERE (((orderdetails.intStyleId)='".$strStyleID."') AND ((matitemlist.intMainCatID)='".$row_Category["intID"]."')) AND (orderdetails.intstatus != '0' or orderdetails.intstatus IS NULL)
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
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["reaConPc"],6)." </td>";				
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblReqQty"],0)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".$row_order["reaWastage"]."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblFreight"],4)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblTotalQty"],0)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblUnitPrice"],4)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dbltotalcostpc"],4)."</td>";
						echo "<td class=\"normalfntRiteTAB\">".number_format($row_order["dblTotalValue"],2)."</td>";	
										
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
					echo "<td class=\"nfhighlite1\">".number_format($countusdValue,2)."</td>";
					echo "</tr>";
					$countusdValue=0.0;
					$counttotalcostpc=0.0;		
					
				}
				
				
				
			}

		  ?>
          <tr>
            <td colspan="10" class="normalfntTAB"><?php
			//echo "Finance + Economic Service " . $reaESC . " Finance ".number_format($reaFinPercntage,4)."%";
			echo "Finance + Economic Service " . $reaESC;
			echo " FAB Fin: ";
			echo "<span class=\"normalfnth2B\">";
			echo number_format($reaFinance,4);
			echo "</span>";
			//echo " TRIM Fin: ";
			//echo "<span class=\"normalfnth2B\">";
			//echo number_format($TotTrimFinance,4);
			//echo "</span>";
			echo "&nbsp;&nbsp;(Inetrest Charge of 2%: ";
			echo "<span class=\"normalfnth2B\">";
			echo number_format(($totIntersetValue / $intQty),4);
			echo "</span>";
			echo ")";
			
			
			?>         </td>
            <td class="normalfntRiteTAB"><?php 
			//$AvgFinanace=$CountFinanace/$intQty;
			//echo number_format($AvgFinanace,4);
			//$CountFinanace=$reaFinance+$TotTrimFinance;
			$CountFinanace=$reaFinance+$TotTrimFinance;
			echo number_format(($CountFinanace + $reaESC ),4);
			$mobileFINESC = number_format(($CountFinanace + $reaESC ),4);
			?></td>
            <td class="normalfntRiteTAB"><?php 
			$CountFinanace=$reaFinance+$TotTrimFinance + $reaESC ;
			echo number_format(($CountFinanace * $totalOrderQty),2);
			?></td>
          </tr>
          <tr>
            <td colspan="10" class="normalfntTAB">Total Direct Cost</td>
            
            <td class="normalfntRiteTAB"><?php 
			for($loops=0;$loops< count($costpc);$loops++)
			{	 
				$TotaleDrectCost+=$costpc[$loops];				
			}	
			$TotaleDrectCost+= $CountFinanace;
				echo number_format($TotaleDrectCost,4);
				$mobileDirectCOst = number_format($TotaleDrectCost,4);
			
			?></td>
			<td colspan="10" class="normalfntRiteTAB"><?php echo number_format(($TotaleDrectCost * $totalOrderQty),2);?></td>
          </tr>
           
           <?php
          	$buyingOfficeProfit = $CMVAL - $costinglabourCost;
         	$requiredMinimumCM = ($CMVAL * $BuyingOfficeMargin / 100);
         	$bgColor = "";
         	if($buyingOfficeProfit < $requiredMinimumCM && $odrStatus == 10)
         		$bgColor = " bgcolor=\"#FF0000\" ";
          ?>
          <tr <?php echo $bgColor; ?>>
            <td colspan="10" class="normalfntTAB">C&amp;M EARNED + (UPcharge (<?php echo number_format($upcharge,4);  ?>) Reason for Upcharge : <?php echo $upchargereason; ?> </td>
           
            <td class="normalfntRiteTAB"><?php
			$cmVal = round($upcharge + $reaFOB   - ( $TotaleDrectCost),4);
			echo number_format($cmVal,4);
			$mobileCMUp = number_format($cmVal,4);
			?></td>
            <td class="normalfntRiteTAB"><?php
			
			# =============================================================================
			# Change On - 2015/09/04
			# Change By - Nalin Jayakody
			# Description - Remove excess quantity from calculation
			# =============================================================================
			
			//echo  number_format(round(round($upcharge + $reaFOB   - ( $TotaleDrectCost),4)*( $intQty + ($intQty * $reaExPercentage / 100) ),2),2);			
			# =============================================================================
			echo  number_format(round(round($upcharge + $reaFOB   - ( $TotaleDrectCost),4)*( $intQty),2),2);
			?></td>
          </tr>
          <?php
          $coporatecost = $reaFOB * 0.05;
			$labsuboverheadcost = 0;
			$subcontractcost = 0;
			$inhouseStyle = true;
			$SQL = "select distinct stylepartdetails_sub.intStyleId,stylepartdetails_sub.intPartId,stylepartdetails_sub.intPartNo,stylepartdetails_sub.strPartName,dblCM,0 as dblTransportCost from stylepartdetails_sub inner join stylepartdetails on stylepartdetails_sub.intPartId = stylepartdetails.intPartId  where stylepartdetails_sub.intStyleId = '".$strStyleID."'";
			
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
			
			# =============================================================================
			# Change On - 2015/09/04
			# Change By - Nalin Jayakody
			# Description - Remove excess quantity from calculation
			# =============================================================================
			//$totalOdrQty = ($intQty + ($intQty * $reaExPercentage / 100));
			# =============================================================================
			$totalOdrQty = $intQty;
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
			$balqt = $totalOrderQty - $subcontractQty;
			if ($canSeeCostManagementFigures)
            {
          ?>
           <tr >
            <td colspan="10" class="normalfntTAB">LABOUR / SUB CONTRACT &amp; OVERHEAD COST </td>
            <td class="normalfntRiteTAB"><?php
			
			
			echo number_format($labrate,4); 
			$mobileLabSUb = number_format($labrate,4); 
			//echo "<br>$intQty   " . " $subcontractQty";
			//echo '   $reaSMV / $reaEfficiencyLevel / 100 * $companycostperminute <br>';
			//echo "   $reaSMV " . '/' . $reaEfficiencyLevel . '/' .  '100 * ' . $companycostperminute . '<br>';
			
			
			?></td>
            <td class="normalfntRiteTAB">
			<?php
			 
			 if ($balqt == 0)
			 {
			 	echo number_format(($labsuboverheadcost *  $subcontractQty),2); 
				$totalLabSubOverCost = ($labsuboverheadcost *  $subcontractQty);
			 }
			 else
			{
			 	echo number_format(($labsuboverheadcost * ($totalOrderQty - $subcontractQty) + ($subcontractcost * $subcontractQty)),2); 
				$totalLabSubOverCost = ($labsuboverheadcost * ($totalOrderQty - $subcontractQty) + ($subcontractcost * $subcontractQty));
			 }
			 
			 ?></td>
          </tr>
          <?php
          }
           if ($canSeeCostManagementFigures)
           {
          ?>
          <tr>
            <td colspan="10" class="normalfntTAB">CORPORATE COST </td>
            <td class="normalfntRiteTAB"><?php
			//echo number_format($reaFOB * 0.05,4);
			echo $mobileCorpCost = number_format($reaSMV * 0.0234,4);
			?></td>
            <td class="normalfntRiteTAB"><?php
			# ----- Changed by - Nalin ON - 05/17/2013
			# ----- Change Done - Corporate cost calculation method change request by management 
			# ----- Previous - 5% from FOB
			  //echo number_format((round($intQty + ($intQty * $reaExPercentage / 100)) * ($reaSMV * 0.234)),2);
			# --------------------------------------------------------------------------------------------------
			# ----- New - 0.0234 from SMV
			
			# =============================================================================
			# Change On - 2015/09/04
			# Change By - Nalin Jayakody
			# Description - Remove excess quantity from calculation
			# =============================================================================
			//echo number_format((round($intQty + ($intQty * $reaExPercentage / 100)) * ($reaSMV * 0.0234)),2);
			
			echo number_format((round($intQty) * ($reaSMV * 0.0234)),2);
			# --------------------------------------------------------------------------------------------------
			?></td>
          </tr>
          <?php
          }
		  # ----- Changed by - Nalin ON - 05/17/2013
		  # ----- Change Done - Change done for corporate cost calculation
		  # ----- Previous
            // $netmargin = ($cmVal) - ($reaFOB * 0.05) - $labrate;
			
		  # ------ New 
		     	$netmargin = ($cmVal) - $mobileCorpCost - $labrate;
           if ($canSeeCostManagementFigures || $canSeeCostingProfitMargin)
            {
          ?>
          <tr>
            <td colspan="10" class="normalfntTAB">NET MARGIN </td>
            <td class="normalfntRiteTAB"><?php
			//$netmargin = ($reaSMVRate * $reaSMV) - ($reaFOB * 0.05) -( $reaSMV / ($reaEfficiencyLevel / 100) * $companycostperminute) ;
			
			//echo '(' . $reaSMVRate . ' * ' . $reaSMV . ' ) - (' . $reaFOB .' 0.05 ) - ' . $labsuboverheadcost;
			echo number_format($netmargin,4);
			$mobileNetMargin = number_format($netmargin,4);
			//echo "<br>$reaSMVRate";
			
			?></td>
            <td class="normalfntRiteTAB"><?php echo number_format(($netmargin * $totalOrderQty),2); ?></td>
          </tr>
          <?php
          }
          ?>
          <tr>
            <td colspan="10" class="normalfnBLD1TAB">Target FOB</td>
            <td class="normalfntRiteTAB">
            <?php
			echo number_format($reaFOB,4);
			?></td>
            <td class="normalfntRiteTAB"><?php
			echo number_format($reaFOB*$intQty,2);
			?></td>
          </tr>
		          <!--  <tr>
		              <td colspan="10" class="normalfnBLD1TAB">REQD FOB</td>
		              <td class="normalfntRiteTAB"><?php $ReqFOB = $reaFOB - $facProfit;
					  echo number_format($ReqFOB,4);
					  ?></td>
		              <td class="normalfntRiteTAB">&nbsp;</td>
              </tr>-->
		           <!-- <tr>
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
			echo number_format(($facProfit*$intQty),2);
			?></td>
          </tr>-->
          <tr>
            <td colspan="9">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
			<td>&nbsp;</td>
          </tr>
         <tr>
            <td colspan="12"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez" >
              <tr>
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
			//echo  number_format(round(round($upcharge + $reaFOB   - ( $TotaleDrectCost),4)*( $intQty + ($intQty * $reaExPercentage / 100) ),2),2);
			echo  number_format(round(round($upcharge + $reaFOB   - ( $TotaleDrectCost),4)*( $intQty),2),2);	?></td>
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
            <td bordercolor="#666666" class="normalfntTAB">SMV <?php echo $row["intPartId"]. "<br>" . $row["strPartName"];  ?> </td>
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
			
			$SQL = "select distinct stylepartdetails_sub.intStyleId,stylepartdetails_sub.intPartId,stylepartdetails_sub.intPartNo,stylepartdetails_sub.strPartName,dblCM,0 as dblTransportCost from stylepartdetails_sub inner join stylepartdetails on stylepartdetails_sub.intPartId = stylepartdetails.intPartId  where stylepartdetails_sub.intStyleId = '$strStyleID';";
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
 
<!-- document.getElementById("gpcm").innerHTML = "<?php 
 
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
 ?> %"; -->
 
document.getElementById("cmfob").innerHTML = "<?php 
  
$cmfob = ($cmVal/ $reaFOB) * 100;
echo number_format($cmfob,1);
			 
 ?> %";
 
document.getElementById("ohpm").innerHTML = "<?php 
			 echo number_format($companycostperminute,4);
			 $mobileFACOHUM = number_format($companycostperminute,4);
 ?>";
 
 //=========================================================================
 // Change On - 09/04/2015
 // Chnage By - Nalin Jayakody
 // Description - Disable GP/FOB (net) calculation by management request
 //=========================================================================

 /*document.getElementById('gpfobnet').innerHTML = "<?php 
 
 $dbl_intCharge = $totIntersetValue / $intQty;
 
 $gp_fob = ((($cmVal + $dbl_intCharge) -  $labrate) / $reaFOB) * 100;
 
 echo number_format($gp_fob,1); ?> %";*/
 
  //=========================================================================
 
 document.getElementById('cmum').innerHTML = "<?php
 
 	$dbl_TotCM = $cmVal * $intQty;
	$dbl_prodMin = $intQty * $reaSMV;
	$dbl_um = $dbl_prodMin / $reaEfficiencyLevel;
	
	$dbl_cmum = ($dbl_TotCM / $dbl_um)/100;
 
 	echo number_format($dbl_cmum, 4);
 //$dblProdMin = 
 
 ?>"

</script>
</html>
