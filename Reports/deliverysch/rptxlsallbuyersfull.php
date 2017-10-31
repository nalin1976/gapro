<?php

session_start();

set_time_limit(240);

include "../../Connector.php";
include "EConnector.php";
include "../../d2dConnector.php";

//$detailContent = '';

$d2dConnectClass = new ClassConnectD2D();

$dblTarnsportCost = 0;
$dblClearingCost = 0;
$dblInterestCharges = 0;
$dblExporExpences = 0;

$intGrandTotalDeliveryQty = 0;
$dblGrandTotalFOB = 0;
$dblGrandTotalFabCost = 0;

$dtFromDate 			= $_GET['prmfrom'];
$dtToDate 				= $_GET['prmto'];
$intProductCategoryCode = $_GET['prmpc'];
$iSelection 			= $_GET['selection'];

$filename = 'allbuyerswithfull.xls';

header("Content-Description: File Transfer");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$filename");

//$headerContent = "Costing Date\tStyle No\tSC No\tDescription\tBuyer\tBuyer Division\tSeason\tBuying Office\tCosting SMV\tFOB\tEff.\tTotal Qty\tUser\tBuyer PO No\tBuyer PO Qty\tDelivery Date\tHand Over Date\tTot. SMV\tTot. FOB\tUpcharge\tFabric Cost\tOther Cost\tFinance Charge\tInterest Charge\tFac. Cost\tCop. Cost\tCM\tTot. CM\t$/SMV\tGP\tNP\tNP/FOB\n";

// ==========================================================
# Modify By - Nalin Jayakody
# Modify On - 01/13/2015
# Modify For - Add AOD Qty and Qty variasions 
// ==========================================================

$headerContent = "<table><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td colspan='3' style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:18px;'>Buyer Purchase Order Listing</td></tr><tr><td>&nbsp;</td><td>From : &nbsp; ".date("Y-m-d",strtotime($dtFromDate))."</td><td>To :</td><td align='left'>".date("Y-m-d",strtotime($dtToDate))."</td></tr><tr><td>&nbsp;</td></tr>";

$headerContent .= "<tr><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Costing Date</td>"
        . "            <td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Style No</td>"
        . "            <td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>SC No</td>"
        . "            <td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Description</td>"
        . "            <td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Product Category</td>"
        . "            <td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Buyer</td>"
        . "            <td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Buyer Division</td>"
        . "            <td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Season</td>"
        . "            <td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Buying Office</td>"
        . "            <td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>User</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Total Qty</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Buyer PO No</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Delivery Date</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Hand Over Date</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Buyer PO Qty</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Eff.</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Costing SMV</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>FOB</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Total SMV</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Total FOB</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Upcharge</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Fabric Cost</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Other Cost</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Finance Charge</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Interest Charge</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Factory Cost</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Corporate Cost</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>CM Per Pc</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Total CM</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>$/SMV</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>CM/UM</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;' align='right'>UM</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>GP</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>NP</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>NP/FOB</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Invoice No</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Invoice Date</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Invoice Qty</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Invoice Value</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Sub Contract Charges</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Est. Delivery Date</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Delivery Status</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Cut Off Date</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Ship Status</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>AOD Qty</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Variance Qty</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Variance (%)</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>AOD Date</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Manufacturing Location</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Sales FOB Value</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>AOD Location</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>GP Date</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Short Ship Status</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Short Ship Reason</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Print</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Embroidery</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Heat Seat</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Handwork</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Other</td>"
        . "            <td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>PCD/BCD</td>"
        . "            <td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Sewing SMV</td>"
        . "            <td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Packing SMV</td>"
        . "         </tr>   ";


// Delivery Status and Cut Off Dates to the excel file
// Change On - 08/19/2015

print($headerContent);

$resOrderList = GetDeliveryOrderList($dtFromDate, $dtToDate, $intProductCategoryCode, $iSelection);

while($rowOrderList = mysql_fetch_array($resOrderList)){
	
	$dblTarnsportCost       = 0;
	$dblClearingCost        = 0;
	$dblInterestCharges     = 0;
	$dblExporExpences       = 0;
	
	$_dblFabricCost         = 0;
	$_dblLabourCost         = 0;	
	$_dblCopCost            = 0;
	$_dblSubContractCharges = 0;
	$intShippedFromHLC      = 0;
        
        $_IsPrint               = 0;
        $_IsEmbroidery          = 0;
        $_IsHeatSeal            = 0;
        $_IsHandWork            = 0;
        $_IsOther               = 0;
        $_ReasonForOther        = '';
        $_IsNA                  = 0;
        
        	
	$_intStyelId            = $rowOrderList['intStyleId'];
	$_intOrderQty           = $rowOrderList['intQty'];
	$_intDeliveryQty        = $rowOrderList['dblQty'];	
	$_intSubQty             = $rowOrderList['intSubContractQty'];
	
	$_dblEFF                = $rowOrderList['reaEfficiencyLevel'];
	//$_dblSMV                = $rowOrderList['reaSMV'];
	$_dblSMV                = $rowOrderList['reaSMV'] + $rowOrderList["reaPackSMV"];
	$_dblFOB                = $rowOrderList['reaFOB'];
	
	$_strCategory 		= $rowOrderList['strCatName'];
	
	$_strDeliveryStatus     = GetDeliveryStatus($rowOrderList['intDeliveryStatus']);
	$_dtCutOffDate		= $rowOrderList['dtmCutOffDate'];
        
        #------------------------------------------------------------------
        # Add By  - Nalin Jayakody
        # Add For - Display embellishment types
        # Add On  - 02/16/2017 
        #------------------------------------------------------------------
        
        $_IsPrint               = $rowOrderList['intPrint'];
        $_IsEmbroidery          = $rowOrderList['intEMB'];
        $_IsHeatSeal            = $rowOrderList['intHeatSeal'];
        $_IsHandWork            = $rowOrderList['intHW'];
        $_IsOther               = $rowOrderList['intOther'];        
        $_IsNA                  = $rowOrderList['intNA'];
        $dtPBCD                 = $rowOrderList['dtPCD'];
        
        $_PrintStatus           = ($_IsPrint == 1?'Yes':'No');
        $_EmbroideryStatus      = ($_IsEmbroidery == 1?'Yes':'No');
        $_HeatSealStatus        = ($_IsHeatSeal == 1?'Yes':'No');
        $_HandWorkStatus        = ($_IsHandWork == 1?'Yes':'No');
        
        if($_IsOther == 1){
          $_ReasonForOther      = $rowOrderList['strOther'];  
        }
        
        #------------------------------------------------------------------
	
	#------ Upcharge calculation area -----------------------------------	
	$_dblTotalUpCharge      = (float)$rowOrderList['reaUPCharges'] * $_intDeliveryQty;
	#------ End upcharge calculation -------------------------------------
	
	#----------------------------------------------------------------------
	#========== ESC value calculation =====================================
	$_dblESCValue           = ($_dblFOB/100)*0.25;
	$_dblESCTotalValue      = $_dblESCValue * $_intDeliveryQty;
	#======================================================================
	
	
	$_dbl_total_smv         = GetTotalSMV($_dblSMV, $_intDeliveryQty);
	
	$_dbl_total_fob         = GetTotalFOB($_dblFOB, $_intDeliveryQty);
	
	$_dblFabricCost         = CalculateFabricCost($_intStyelId, $_intOrderQty, $_intDeliveryQty);
	
	$_dblAccPackCost        = CalculateAccPackCost($_intStyelId, $_intOrderQty, $_intDeliveryQty);
	
	$_dblServiceCost        = CalculateServiceOtherCost($_intStyelId, $_intOrderQty, $_intDeliveryQty);
	
	$_dblOtherCost          = floatval($_dblAccPackCost + $_dblServiceCost + $_dblESCTotalValue);
	
	//$_dblFinanceCharges =  $dblTarnsportCost + $dblClearingCost + $dblExporExpences; //$dblTarnsportCost

	$_dblFinanceCharges     =  ($rowOrderList['reaFinance'] * $_intDeliveryQty) - $dblInterestCharges ;
	
	$_dblLabourCost         =  CalculateLabourCost($_dblEFF, $_dblSMV, $_intDeliveryQty, $_intSubQty, $_intOrderQty);
	
		
	$_dblSubContractCharges = CalculateSubContractCost($_intStyelId, $_intOrderQty, $_intDeliveryQty);
	
	#----------------------------------------------------------------------------
	#========== Calculate of corporate cost =====================================
	$_dblCopCost            = ($_intDeliveryQty * $_dblSMV) * 0.0234;
	#========== End of corperate cost calculation area ==========================  
	
        /*
         * Comment On - 05/30/2017
         * Comment By - Nalin Jayakody
         * Comment For - Exclude Finance charge from CM calculation
         * ================================================================================
         */
	// $_dblTotalDirectCost    =  $_dblFabricCost +  $_dblOtherCost + $_dblFinanceCharges + $dblInterestCharges;
        
        /* ================================================================================ */
        
        $_dblTotalDirectCost    =  $_dblFabricCost +  $_dblOtherCost;
	
	$_dblTotCM              = (($_dbl_total_fob - $_dblTotalDirectCost)+$_dblSubContractCharges) + $_dblTotalUpCharge;
	$_dblCMPerPc            = $_dblTotCM/$_intDeliveryQty;
	$_dblSMVRate            = $_dblCMPerPc/$_dblSMV;
	
	$_dblCMUM               = ($_dblSMVRate/100)*$_dblEFF;
	$_dblUM                 = ($_dbl_total_smv/$_dblEFF)*100;
	
	$_dblGP                 = $_dblTotCM - $_dblLabourCost;
	$_dblNP                 = $_dblGP - $_dblCopCost;
	$_dblNPFOB              = ($_dblNP/$_dbl_total_fob)*100;
	
	
	
	$intGrandTotalDeliveryQty += $_intDeliveryQty;
	$dblGrandTotalFOB += $_dbl_total_fob;
	$dblGrandTotalFabCost += $_dblFabricCost;
	$dblGrandTotalOther += $_dblOtherCost;
	$dblGrandTotalFinance += $_dblFinanceCharges;
	$dblGrandTotalInterestCharge += $dblInterestCharges;
	$dblGrandTotalFacCost += $_dblLabourCost;
	$dblGrandTotalCopCost += $_dblCopCost;
	$dblGrandTotalCM += $_dblTotCM;
	$dblGrandTotalGP += $_dblGP;
	$dblGrandTotalNP += $_dblNP;
	
	$strInvoiceNo = '';
	$dtInvoiceDate = '';
	$dblInvoiceQty = 0;
	$dblInvoiceValue = 0;
	
	$IsHLCAvailable = 0;
	
	/*$result_invoice_info = GetInvoiceDetails($rowOrderList['intSRNO'], $rowOrderList['intBPO']);
	
	while($row_invoice = mysql_fetch_array($result_invoice_info)){
		$strInvoiceNo = $row_invoice['strInvoiceNo'];
		$dtInvoiceDate = date("Y-m-d",strtotime($row_invoice['dtmInvoiceDate']));
		$dblInvoiceQty = $row_invoice['dblQuantity'];
		$dblInvoiceValue = $row_invoice['dblAmount'];
	}*/
	
	//=============================================================
	// Add On - 12/12/2015
	// Add By - Nalin Jayakody
	// Add For - Get produced qty from D2D
	//=============================================================
	
	$intProducedQty = GetShippedStatusFromD2D($rowOrderList['intSRNO'], $rowOrderList['intBPO'], $d2dConnectClass);
	
	$dblProducePer  = CalShippedPercentage($_intDeliveryQty, $intProducedQty);
	
	$strShipStatus = "Pending";
	
	if($dblProducePer>=95){		
		$trElement = "<tr height='25px' bgcolor='#BFFFDF'>";
		$strShipStatus = "Completed";
	}else{
		$trElement = "<tr height='25px'>";
	}
	
	
	// Get details where shipped directly from HLC warehouse
	$intShippedFromHLC = GetShippedFromHLC($rowOrderList['intSRNO'], $rowOrderList['intBPO'], $d2dConnectClass);
	
	if($intShippedFromHLC > 0){
			
		$dblProducePer  = CalShippedPercentage($_intDeliveryQty, $intShippedFromHLC);
		
		if($dblProducePer>=95){		
			$trElement = "<tr height='25px' bgcolor='#BFFFDF'>";
			$strShipStatus = "Completed";
		}else{
			$trElement = "<tr height='25px'>";
		}
	}
	
	if($intShippedFromHLC > 0){
		$intProducedQty = $intShippedFromHLC;
	}
	
	$iQtyVariation = ($_intDeliveryQty - $intProducedQty);
	
	$dblGrandTotalAODQty += $intProducedQty;
	
	//Get AOD Date from D2D
	$val = GetAODDate($rowOrderList['intSRNO'], $rowOrderList['intBPO'], $d2dConnectClass,$dtFromDate);
	
	
	if($val == 1){
		$trElement = "<tr height='25px' bgcolor='#0066FF'>"; 	
	}
	
	//Check if sotck in HLC and not shipped those by given SC & buyer PO
	$IsHLCAvailable = GetHLCBalance($rowOrderList['intSRNO'], $rowOrderList['intBPO'], $d2dConnectClass);
	
	if($IsHLCAvailable == 1){
		$trElement = "<tr height='25px' bgcolor='#E2CF8D'>"; 
		
	}
	//$dblProducePer     = 0;

	//==================================================================
	# Add On = 01/29/2016
	# Add By = Nalin Jayakody
	# Add For = Get Max delivery date from D2D 
	//==================================================================
	$dtLastAODDate = GetLastAODDate($rowOrderList['intSRNO'], $rowOrderList['intBPO'], $d2dConnectClass);

	//==================================================================

	//==================================================================

	$iShippStatus = $rowOrderList["intShortShipped"];
	$dblSalesValue = 0;

	if($iShippStatus == '1'){
		$dblSalesValue = $intProducedQty * $_dblFOB;
	}
	else{
		$dblSalesValue = $_dbl_total_fob;
	}

	$dblGrandTotalSales += $dblSalesValue;

	//==================================================================
	$strLocation 		= "";
	$GetHLCOutLocation 	= "";
	$dtGPOutDate = $dtLastAODDate;
	
	$strLocation = GetAODLocation($rowOrderList['intSRNO'], $rowOrderList['intBPO'], $d2dConnectClass);
	
	if($IsHLCAvailable == 1){

            $strLocation = "HLC";

	}else{

            $resGetHLCOutLocation = GetHLCOutLocation($rowOrderList['intSRNO'], $rowOrderList['intBPO'], $d2dConnectClass);
            $arrGetHLCOutLocation = explode("~", $resGetHLCOutLocation);

            $GetHLCOutLocation 	= $arrGetHLCOutLocation[0];
            $dtHLCOutDate 		= $arrGetHLCOutLocation[1];	

	}

	if($GetHLCOutLocation != ""){
            $strLocation = $GetHLCOutLocation;
            $dtGPOutDate = $dtHLCOutDate;
	}

        $sShortShipStatus = "";
	$iShortShipStatus = $rowOrderList["intShortShipped"];
        $sShortShipReason = $rowOrderList["ShortShipReason"]; 
        
        if($iShortShipStatus == '1'){
            $sShortShipStatus = "Short Shipped";
        }
        
	
	//$detailContent .= date("Y-m-d",strtotime($rowOrderList['dtmDate']))."\t".$rowOrderList['strStyle']."\t".$rowOrderList['intSRNO']."\t".$rowOrderList['strDescription']."\t".$rowOrderList['strName']."\t".$rowOrderList['strDivision']."\t".$rowOrderList['strSeason']."\t".$rowOrderList['BuyingOffice']."\n";
	$detailContent .= $trElement."<td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".date("Y-m-d",strtotime($rowOrderList['dtmDate']))."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$rowOrderList['strStyle']."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$rowOrderList['intSRNO']."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$rowOrderList['strDescription']."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$_strCategory."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$rowOrderList['strName']."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$rowOrderList['strDivision']."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$rowOrderList['strSeason']."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$rowOrderList['BuyingOffice']."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$rowOrderList['Name']."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$_intOrderQty."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$rowOrderList['intBPO']."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".date("Y-m-d", strtotime($rowOrderList['dtDateofDelivery']))."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$rowOrderList['dtmHandOverDate']."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$_intDeliveryQty."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$_dblEFF."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$_dblSMV."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$_dblFOB."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$_dbl_total_smv."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dbl_total_fob,2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$_dblTotalUpCharge."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dblFabricCost, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dblOtherCost,2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dblFinanceCharges, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($dblInterestCharges, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dblLabourCost, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dblCopCost, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dblCMPerPc, 4)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dblTotCM, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dblSMVRate, 4)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dblCMUM, 4)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dblUM, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dblGP, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dblNP, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dblNPFOB, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$strInvoiceNo."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$dtInvoiceDate."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$dblInvoiceQty."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($dblInvoiceValue,2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dblSubContractCharges,2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".date("Y-m-d", strtotime($rowOrderList['estimatedDate']))."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$_strDeliveryStatus."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$_dtCutOffDate."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$strShipStatus."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($intProducedQty)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($iQtyVariation)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($dblProducePer,2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$dtLastAODDate."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$rowOrderList['ManuLocation']."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($dblSalesValue,2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-left:#000000 thin solid;'>".$strLocation."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$dtGPOutDate."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$sShortShipStatus."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$sShortShipReason."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$_PrintStatus."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$_EmbroideryStatus."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$_HeatSealStatus."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$_HandWorkStatus."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$_ReasonForOther."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$dtPBCD."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$rowOrderList['reaSMV']."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$rowOrderList["reaPackSMV"]."</td>";

		/*if($IsHLCAvailable == 1){

			$detailContent .= "<td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-left:#000000 thin solid;'>".$strLocation."</td>";
		}else{  

			$detailContent .= "<td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; font-weight:bold; border-left:#000000 thin solid;'>".$strLocation."</td>";
		}*/

        $detailContent .="</tr>";

        $strLocation = "";
}
//========================================================================================================
// End Of Detail Section
//========================================================================================================

//========================================================================================================
// Print grand total section
//======================================================================================================== 
$detailContent .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-left:#000000 thin solid; font-weight:bold;'>".intval($intGrandTotalDeliveryQty)."</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; font-weight:bold; border-left:#000000 thin solid;'>".number_format($dblGrandTotalFOB, 2)."</td><td>&nbsp;</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; font-weight:bold; border-left:#000000 thin solid;'>".number_format($dblGrandTotalFabCost, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; font-weight:bold; border-left:#000000 thin solid;'>".number_format($dblGrandTotalOther, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; font-weight:bold; border-left:#000000 thin solid;'>".number_format($dblGrandTotalFinance, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; font-weight:bold; border-left:#000000 thin solid;'>".number_format($dblGrandTotalInterestCharge, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; font-weight:bold; border-left:#000000 thin solid;'>".number_format($dblGrandTotalFacCost, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; font-weight:bold; border-left:#000000 thin solid;'>".number_format($dblGrandTotalCopCost, 2)."</td><td>&nbsp;</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; font-weight:bold; border-left:#000000 thin solid;'>".number_format($dblGrandTotalCM, 2)."</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; font-weight:bold; border-left:#000000 thin solid;'>".number_format($dblGrandTotalGP, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; font-weight:bold; border-left:#000000 thin solid;'>".number_format($dblGrandTotalNP, 2)."</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; font-weight:bold; border-left:#000000 thin solid;'>".number_format($dblGrandTotalAODQty)."</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; font-weight:bold; border-left:#000000 thin solid;'>".number_format($dblGrandTotalSales,2)."</td>";


$detailContent .= "</tr></table>";
print($detailContent);

exit;

function GetTotalSMV($prmSMV, $prmDeliveryQty){
	
	$_dblTotalSMV = 0;
		
	$_dblTotalSMV = floatval($prmDeliveryQty * $prmSMV);
	
	return $_dblTotalSMV;
	
}

function GetTotalFOB($prmFOB, $prmDeliveryQty){

	$_dblTotalFOB = 0;
	
	$_dblTotalFOB = floatval($prmDeliveryQty * $prmFOB);
	
	return $_dblTotalFOB;	
}

function CalculateFabricCost($prmStyleCode, $prmOrderQty, $prmDeliveryQty){
	
	global $dblTarnsportCost;
	global $dblClearingCost;
	global $dblInterestCharges;
	global $dblExporExpences;
	
	$_dblTotalFabricCost = 0;
	
	$result = GetFabricCost($prmStyleCode);
		
	while($rowFabric = mysql_fetch_array($result)){
		
		$_dblConPerPc = $rowFabric['reaConPc'];
		$_dblWastage = $rowFabric['reaWastage'];
		$_dblUnitPrice = $rowFabric['dblUnitPrice'];
		$_intOriginType = $rowFabric['intOriginNo'];
		
		$_dblReqQty =  $prmOrderQty * $_dblConPerPc;
		$_dblWastageQty = ($_dblReqQty /100) * $_dblWastage;
		
		$_dblTotReqQty = ($_dblReqQty + $_dblWastageQty); //intval
		
		$_dblTotalValue = ($_dblTotReqQty * $_dblUnitPrice); //floatval
		
		$_dblCostPerPc = ($_dblTotalValue / $prmOrderQty); //floatval
		
		$_dblTotalFabricCost += ($_dblCostPerPc * $prmDeliveryQty); //floatval
		
		$_dblLineWiseFabricCost = ($_dblCostPerPc * $prmDeliveryQty); //floatval
		
		
		$dblTarnsportCost += CalculateTransportCharge($_intOriginType, $_dblLineWiseFabricCost);
		$dblClearingCost += CalculateClearingCost($_intOriginType, $_dblLineWiseFabricCost, $prmDeliveryQty, $prmOrderQty);
		$dblInterestCharges += CalculateInterestCharge($_dblLineWiseFabricCost);
		$dblExporExpences += CalculateExportExpences($_dblLineWiseFabricCost);
		
	}
	
	return $_dblTotalFabricCost;
}


function CalculateAccPackCost($prmStyleCode, $prmOrderQty, $prmDeliveryQty){
	
	global $dblClearingCost;
	global $dblInterestCharges;
	global $dblExporExpences;
	
	$_dblTotalAccPackCost = 0;
	
	$resultAccPack = GetAccePacking($prmStyleCode);
		
	while($rowAccPack = mysql_fetch_array($resultAccPack)){
		
		$_dblConPerPc = $rowAccPack['reaConPc'];
		$_dblWastage = $rowAccPack['reaWastage'];
		$_dblUnitPrice = $rowAccPack['dblUnitPrice'];
		$_intOriginType = $rowAccPack['intOriginNo'];
		
		$_dblReqQty =  $prmOrderQty * $_dblConPerPc;
		$_dblWastageQty = ($_dblReqQty /100) * $_dblWastage;
		
		$_dblTotReqQty = ($_dblReqQty + $_dblWastageQty); //intval
		
		$_dblTotalValue = ($_dblTotReqQty * $_dblUnitPrice); //floatval
		
		$_dblCostPerPc = ($_dblTotalValue / $prmOrderQty); //floatval
		
		$_dblTotalAccPackCost += ($_dblCostPerPc * $prmDeliveryQty); //floatval
		
		$_dblLineWiseCost = ($_dblCostPerPc * $prmDeliveryQty); //floatval
		
		
		$dblClearingCost += CalculateClearingCost($_intOriginType, $_dblLineWiseCost, $prmDeliveryQty, $prmOrderQty);
		$dblInterestCharges += CalculateInterestCharge($_dblLineWiseCost);
		$dblExporExpences += CalculateExportExpences($_dblLineWiseFabricCost);
				
	}
	
	return $_dblTotalAccPackCost;
}

function CalculateServiceOtherCost($prmStyleCode, $prmOrderQty, $prmDeliveryQty){
			
	$_dblTotalServiceOtherCost = 0;
	
	$resultService = GetServiceOtherCost($prmStyleCode);
		
	while($rowService = mysql_fetch_array($resultService)){
		
		$_dblConPerPc = $rowService['reaConPc'];
		$_dblWastage = $rowService['reaWastage'];
		$_dblUnitPrice = $rowService['dblUnitPrice'];
		$_intOriginType = $rowService['intOriginNo'];
		
		$_dblReqQty =  $prmOrderQty * $_dblConPerPc;
		$_dblWastageQty = ($_dblReqQty /100) * $_dblWastage;
		
		$_dblTotReqQty = ($_dblReqQty + $_dblWastageQty); //intval
		
		$_dblTotalValue = ($_dblTotReqQty * $_dblUnitPrice); //floatval
		
		$_dblCostPerPc = ($_dblTotalValue / $prmOrderQty); //floatval
		
		$_dblTotalServiceOtherCost += ($_dblCostPerPc * $prmDeliveryQty); //floatval
			
	}
	
	return $_dblTotalServiceOtherCost;
}

function CalculateSubContractCost($prmStyleCode, $prmOrderQty, $prmDeliveryQty){
			
	$_dblTotalSubContractCost = 0;
	
	$resultService = GetSubContractCharges($prmStyleCode);
		
	while($rowService = mysql_fetch_array($resultService)){
		
		$_dblConPerPc = $rowService['reaConPc'];
		$_dblWastage = $rowService['reaWastage'];
		$_dblUnitPrice = $rowService['dblUnitPrice'];
		$_intOriginType = $rowFabric['intOriginNo'];
		
		#=======================================================================
		# Comment On - 02/26/2014
		# Description - Chnage the subcontarct calculation formula
		#=======================================================================
		
		/*$_dblReqQty =  $prmOrderQty * $_dblConPerPc;
		$_dblWastageQty = ($_dblReqQty /100) * $_dblWastage;
		
		$_dblTotReqQty = intval($_dblReqQty + $_dblWastageQty);
		
		$_dblTotalValue = floatval($_dblTotReqQty * $_dblUnitPrice);
		
		$_dblCostPerPc = floatval($_dblTotalValue / $prmOrderQty);
		
		$_dblTotalSubContractCost += floatval($_dblCostPerPc * $prmDeliveryQty);	*/
		
		#=======================================================================
		
		# Get wastage % for delivery qty		
		$_dblWastageForDelivery = ($_dblWastage/$prmOrderQty)*$prmDeliveryQty;
		
		$_dblReqQty =  $prmDeliveryQty * $_dblConPerPc;
		
		$_dblWastageQty = ($_dblReqQty /100) * $_dblWastageForDelivery;
		
		$_dblTotReqQty = intval($_dblReqQty + $_dblWastageQty);
		
		$_dblTotalValue = floatval($_dblTotReqQty * $_dblUnitPrice);
		
		$_dblTotalSubContractCost = $_dblTotalValue;
		
			
	}
	
	return $_dblTotalSubContractCost;
}

function CalculateTransportCharge($prmOrignType, $prmFabricCost){	
	
	$_dblTransportCharge = 0;
	
	switch((int)$prmOrignType){
		
		case 3:		
		case 4:
			$_dblTransportCharge = ((float)$prmFabricCost/100)*1;
			break;
			
		default:
			$_dblTransportCharge = 0;
			break;
	}
	return $_dblTransportCharge;	
}

function CalculateClearingCost($prmOrignType, $prmItemCost, $prmDeliQty, $prmOrderQty){

	$_dblClearingCost = 0;
	
	switch((int)$prmOrignType){
		
		case 1:		
		case 2:
		
			$resCurrency = GetLKRExchangeValue();
			
			while($rowCurrency = mysql_fetch_array($resCurrency)){				
				$_dblExRate = $rowCurrency['dblRateq'];
			}
			
			//Get USD value of Rs.10000/=
			$_dblUSDValue = floatval(10000/$_dblExRate);
			
			//Get the per unit cost of the item
			$_dblUnitCost = (float)$prmItemCost/$prmDeliQty;
			
			
			//Calculate total cost
			$_totCost = (float)$_dblUnitCost*$prmOrderQty;
			
			//Get the rate of the clearing charge 		
			//$_dblClearingCost = ((float)$prmItemCost/100)*1;
			$_dblClearingCost = ((float)$_totCost/100)*1;	
			
			if($_dblUSDValue > $_dblClearingCost){
				$_dblClearingCost = $_dblUSDValue;	
			}
			
			//Calculate per rate clearing cost
			$_dblClearingCost = ($_dblClearingCost/$prmOrderQty);
			$_dblClearingCost = $_dblClearingCost * $prmDeliQty; 
			
			break;
			
		default:
			$_dblClearingCost = 0;
			break;
	}
	return $_dblClearingCost;			
	
}

function CalculateInterestCharge($prmItemCost){
	
	$_dblInterestCharges = ($prmItemCost/100)*2;
	
	return $_dblInterestCharges;
	
	
}

function CalculateExportExpences($prmItemCost){
	
	$_dblExportExpences = ($prmItemCost/100)*1;
	
	return $_dblExportExpences;
}

function CalculateLabourCost($prmEff, $prmSMV, $prmDeliveryQty, $prmSubQty, $prmOrderQty){
	
	$_dblLabourPerPc = 0;
	$_dblLabourCost = 0;
	
	$_dblLabourPerPc = ($prmSMV/($prmEff/100)) * 0.0350;
	
	if($prmSubQty > 0){
		if($prmSubQty == $prmOrderQty){
			$_dblLabourCost = 0; 
		}else{
		
			$varQty  = 	($prmDeliveryQty/$prmOrderQty)* $prmSubQty;
			$varInhouseQty = intval($prmDeliveryQty - $varQty);
			
			$_dblLabourCost = floatval($_dblLabourPerPc * $varInhouseQty);
		}
		
	}else{
		
		$_dblLabourCost = floatval($_dblLabourPerPc * $prmDeliveryQty);	
	}	
	
	return $_dblLabourCost;
}


function GetDeliveryOrderList($prmFromDate, $prmToDate, $prmProductCategoryCode, $prmSelection){
	
global $db;

$strSql = " SELECT orders.strStyle, orders.strDescription, orders.intQty, orders.reaSMV, orders.reaFOB, orders.reaEfficiencyLevel, specification.intSRNO, orders.reaFinance, ".
          "        deliveryschedule.dblQty, deliveryschedule.intBPO, deliveryschedule.dtDateofDelivery, buyers.strName, useraccounts.Name, ".
		  "        deliveryschedule.dtmHandOverDate, orders.dtmDate, orders.intStyleId, buyerdivisions.strDivision, seasons.strSeason,  ".
		  "        buyerbuyingoffices.strName AS BuyingOffice, orders.reaUPCharges, orders.intSubContractQty, productcategory.strCatName, ".
		  "        deliveryschedule.estimatedDate, deliveryschedule.intDeliveryStatus, deliveryschedule.dtmCutOffDate, companies.strName as ManuLocation,  ".
		  "   deliveryschedule.intShortShipped,orders.intPrint,orders.intEMB,orders.intHeatSeal,orders.intHW,orders.intOther,orders.strOther,orders.intNA, ".
		  " (SELECT companies.strName  FROM companies WHERE companies.intCompanyID = orders.intManufactureCompanyID )as ManufactureLocation, ".
                  " (SELECT short_ship_reason.ShortShipReason FROM short_ship_reason WHERE short_ship_reason.reasonId = deliveryschedule.shortShipId) as ShortShipReason, reaPackSMV, ".  
                  " orders.dtPCD ".
          " FROM   deliveryschedule Inner Join orders ON deliveryschedule.intStyleId = orders.intStyleId Inner Join specification ON ". 
		  "        orders.intStyleId = specification.intStyleId Inner Join buyers ON orders.intBuyerID = buyers.intBuyerID Inner Join useraccounts ON ".  
		  "        orders.intUserID = useraccounts.intUserID Left Join buyerdivisions ON buyers.intBuyerID = buyerdivisions.intBuyerID AND ".
		  "        orders.intDivisionId = buyerdivisions.intDivisionId Left Join seasons ON orders.intSeasonId = seasons.intSeasonId ".
		  "        Left Join buyerbuyingoffices ON buyers.intBuyerID = buyerbuyingoffices.intBuyerID AND orders.intBuyingOfficeId = ".
		  "        buyerbuyingoffices.intBuyingOfficeId Left Join productcategory ON orders.productSubCategory = productcategory.intCatId ".
		  "        Left Join companies ON deliveryschedule.intManufacturingLocation = companies.intCompanyID ".
          " WHERE   deliveryschedule.strShippingMode <> '7' AND orders.intStatus <> 14 AND orders.intCompanyID <> 15 "; //

		  //========================================================================================
		  # Comment By - Nalin Jayakody
		  # Comment On - 01/29/2016
		  # Comment For - To re-activate delivery schedule request by mail date on 01/29/2016
		  //========================================================================================
           # WHERE  deliveryschedule.dtmHandOverDate between '$prmFromDate' AND '$prmToDate' AND deliveryschedule.strShippingMode <> '7' AND   
		  //========================================================================================
		  
		  //========================================================================================
		  // Comment By - Nalin Jayakody
		  // Comment On - 11/11/2015
		  // Comment For - To change get delivery information by HandOver date instead of delivery date request by Emaali
		  //========================================================================================
		  //" WHERE  deliveryschedule.dtDateofDelivery between '$prmFromDate' AND '$prmToDate' AND deliveryschedule.strShippingMode <> '7' AND ".
		  //========================================================================================

//===================================================================================
# Add On - 02/03/2016
# Add By - Nalin Jayakody
# Adding - Base on users date selection, filter criteria change according
// ==================================================================================          

switch($prmSelection){

	case "1":
		$strSql .= " AND deliveryschedule.dtDateofDelivery between '$prmFromDate' AND '$prmToDate' ";
	break;

	case "2":
		$strSql .= " AND deliveryschedule.estimatedDate between '$prmFromDate' AND '$prmToDate' ";

	break;

	case "3":
		$strSql .= " AND deliveryschedule.dtmHandOverDate between '$prmFromDate' AND '$prmToDate' ";

	break;

}		  


if(intval($prmProductCategoryCode) != -1){

	$strSql .= " AND productcategory.intCatId = '$prmProductCategoryCode'";	
	
}
	$strSql .= " GROUP BY deliveryschedule.intStyleId, deliveryschedule.dtDateofDelivery, deliveryschedule.intBPO ".
               " ORDER BY deliveryschedule.dtDateofDelivery ";
	
return $db->RunQuery($strSql);
	
}

function GetFabricCost($prmStyleCode){
	
global $db;

$strSql = " SELECT orderdetails.reaConPc, orderdetails.reaWastage, orderdetails.dblUnitPrice, orderdetails.intstatus, orderdetails.intOriginNo ".
          " FROM   orderdetails Inner Join matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial ".
          " WHERE  matitemlist.intMainCatID =  '1' AND orderdetails.intStyleId = '$prmStyleCode' AND (orderdetails.intstatus = '1' OR orderdetails.intstatus IS NULL) ";
		  
return $db->RunQuery($strSql);
		  
}

function GetAccePacking($prmStyleCode){
	
global $db;
	
$strSql = " SELECT orderdetails.reaConPc, orderdetails.reaWastage, orderdetails.dblUnitPrice, orderdetails.intstatus, orderdetails.intOriginNo, ".
          "        matitemlist.intMainCatID ".
          " FROM   orderdetails Inner Join matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial  ".
          " WHERE  (matitemlist.intMainCatID = '2' OR matitemlist.intMainCatID = '3') AND orderdetails.intStyleId = '$prmStyleCode' AND " .
		  "        (orderdetails.intstatus = '1' OR orderdetails.intstatus IS NULL)".
          " ORDER BY matitemlist.intMainCatID ";
	
return $db->RunQuery($strSql);	
}

function GetServiceOtherCost($prmStyleCode){
	
global $db;

# Remove itemcode 18385 and 21253 in the serveice and other cost calculation 
# Remove subcontract charges from it
	
$strSql = " SELECT orderdetails.reaConPc, orderdetails.reaWastage, orderdetails.dblUnitPrice, orderdetails.intstatus, orderdetails.intOriginNo, ".
          "        matitemlist.intMainCatID ".
          " FROM   orderdetails Inner Join matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial  ".
          " WHERE (matitemlist.intMainCatID = '4' OR matitemlist.intMainCatID = '5') AND orderdetails.intStyleId = '$prmStyleCode' AND " .
		  "       (orderdetails.intstatus = '1' OR orderdetails.intstatus IS NULL) ".
		  "        AND (matitemlist.intItemSerial <> 18385 AND matitemlist.intItemSerial <> 21253) ".
          " ORDER BY matitemlist.intMainCatID ";
	
return $db->RunQuery($strSql);	
}

function GetSubContractCharges($prmStyleCode){
	
global $db;	

$strSql = " SELECT orderdetails.reaConPc, orderdetails.reaWastage, orderdetails.dblUnitPrice, orderdetails.intstatus, orderdetails.intOriginNo, ".
          "        matitemlist.intMainCatID FROM   orderdetails Inner Join matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial ". 
          " WHERE (matitemlist.intMainCatID = '5') AND orderdetails.intStyleId = '$prmStyleCode' AND ".
		  "       (orderdetails.intstatus = '1' OR orderdetails.intstatus IS NULL)  AND  ".
		  "       (matitemlist.intItemSerial = 18385 OR matitemlist.intItemSerial = 21253) ".
          " ORDER BY matitemlist.intMainCatID ";

return $db->RunQuery($strSql);		
	
}

function GetLKRExchangeValue(){
	
global $db;
	
$strSql = " SELECT currencytypes.dblRateq ".
          " FROM   currencytypes ".
		  " WHERE  currencytypes.strCurrency = 'LKR'";
	
return $db->RunQuery($strSql);	
}


function GetInvoiceDetails($prmSCNO, $prmBuyerPoNo){
	
global $edb;

$strSql = " SELECT
commercial_invoice_header.strInvoiceNo,
commercial_invoice_header.dtmInvoiceDate,
commercial_invoice_detail.dblQuantity,
commercial_invoice_detail.dblAmount
FROM
invoicedetail
Inner Join commercial_invoice_detail ON invoicedetail.strInvoiceNo = commercial_invoice_detail.strInvoiceNo AND invoicedetail.strStyleID = commercial_invoice_detail.strStyleID
Inner Join commercial_invoice_header ON commercial_invoice_detail.strInvoiceNo = commercial_invoice_header.strInvoiceNo
WHERE
invoicedetail.strSC_No =  '$prmSCNO' AND
commercial_invoice_detail.strBuyerPONo =  '$prmBuyerPoNo'";

return $edb->RunQuery($strSql);
	
}

function GetDeliveryStatus($prmDeliveryStatus){
	
	$strDeliveryStatus = '';
	
	switch($prmDeliveryStatus){
	
		case "1":
			$strDeliveryStatus = "CONFIRMED";
		break;	
		
		case "2":
			$strDeliveryStatus = "BLOCKED";
		break;
	}
	
	return $strDeliveryStatus;
}

function GetShippedStatusFromD2D($prmSCNo, $prmBuyerPONo, $prmD2DConnt){
	
		
	$intShippedQty = 0;
	
	$sqlD2D = " SELECT distinct Sum(d2d_Pack_Export_Details.transferOutQty) AS Shipped_Qty 
				FROM   d2d_Pack_Export_Header Inner Join d2d_Pack_Export_Details ON d2d_Pack_Export_Header.aodNo = d2d_Pack_Export_Details.serial AND d2d_Pack_Export_Header.location = d2d_Pack_Export_Details.locationId AND d2d_Pack_Export_Header.scNumber = d2d_Pack_Export_Details.scNumber
				WHERE d2d_Pack_Export_Header.scNumber =  '$prmSCNo' AND d2d_Pack_Export_Header.bpo =  '$prmBuyerPONo' AND d2d_Pack_Export_Header.`status` =  'SEND'
				GROUP BY d2d_Pack_Export_Details.styleComponent ";
				
				// AND d2d_Pack_Export_Header.destination <>  '20'";	
	
	$resD2D	= $prmD2DConnt->RunQuery($sqlD2D);
				
	while($rowD2D = mysql_fetch_array($resD2D)){
		$intShippedQty = $rowD2D["Shipped_Qty"];
		
	}
	
	return $intShippedQty;
	
}


function GetShippedFromHLC($prmSCNo, $prmBuyerPONo, $prmD2DConnt){
	
	$intShippedQty = 0;
	
	$sqlD2D = " SELECT distinct Sum(stock_aod_detail.qty) AS Shipped_Qty 
	            FROM   stock_aod_header Inner Join stock_aod_detail ON stock_aod_header.aodNo = stock_aod_detail.aodNo AND stock_aod_header.bpo = stock_aod_detail.bpoNo
                WHERE  stock_aod_header.scNo =  '$prmSCNo' AND stock_aod_header.bpo =  '$prmBuyerPONo'
				GROUP BY stock_aod_detail.component";
				
	$resD2D	= $prmD2DConnt->RunQuery($sqlD2D);
				
	while($rowD2D = mysql_fetch_array($resD2D)){
		$intShippedQty = $rowD2D["Shipped_Qty"];
		
	}
	
	return $intShippedQty;			
	
}


function CalShippedPercentage($bpoQty, $bpoShippedQty){
	
	$dblShippedQty = ($bpoShippedQty/$bpoQty)*100;
	
	return $dblShippedQty;
	
}

function GetAODDate($prmSCNo, $prmBuyerPONo, $prmD2DConnt, $prmFromDate){
	
	//Get Report Month
	$dateParts = explode("-",$prmFromDate);
	$repMonth  = $dateParts[1];
	
	$returnVal = 0;

	$strSql = "SELECT distinct
                      d2d_Pack_Export_Header.`date` as AODDate
               FROM   d2d_Pack_Export_Header
               WHERE d2d_Pack_Export_Header.scNumber = '$prmSCNo' AND d2d_Pack_Export_Header.bpo =  '$prmBuyerPONo' AND d2d_Pack_Export_Header.`status` =  'SEND' AND  (MONTH(d2d_Pack_Export_Header.`date`) < $repMonth)  ";

      //Remove check HLC destination 
      // 02/03/2016         
     // AND (d2d_Pack_Export_Header.destination <> 20)
			   
	$resD2D	= $prmD2DConnt->RunQuery($strSql);
	
	if(mysql_num_rows($resD2D)>0){
		$returnVal = 1;
	}
	
	return $returnVal;
	
}

function GetHLCBalance($prmSCNo, $prmBuyerPONo, $prmD2DConnt){
	
	$returnVal = 0;
	
	$sql = " SELECT distinct stock_grn_header.grnNo, stock_grn_header.scNo, stock_grn_header.bpo 
	         FROM   stock_grn_header Inner Join stock_grn_details ON stock_grn_header.grnNo = stock_grn_details.grnNo AND stock_grn_header.bpo = stock_grn_details.bpoNo
             WHERE   stock_grn_header.bpo NOT IN (select stock_aod_header.bpo from stock_aod_header) AND stock_grn_header.scNo = '$prmSCNo' AND stock_grn_header.bpo = '$prmBuyerPONo'";
	
	$resBalHLC = $prmD2DConnt->RunQuery($sql);
	
	if(mysql_num_rows($resBalHLC)>0){
		$returnVal = 1;
	}
	
	return $returnVal;		 
	
}

function GetLastAODDate($prmSCNo, $prmBuyerPONo, $prmD2DConnt){


	$sql = " SELECT Max(d2d_Pack_Export_Header.`date`) AS `AOD_Date`
             FROM   d2d_Pack_Export_Header
             WHERE  d2d_Pack_Export_Header.scNumber =  '$prmSCNo' AND d2d_Pack_Export_Header.bpo =  '$prmBuyerPONo' AND
             d2d_Pack_Export_Header.`status` =  'SEND'";

    $resAODMaxDate = $prmD2DConnt->RunQuery($sql);

    $arrDate = mysql_fetch_row($resAODMaxDate);

    $dtAODLastDate = $arrDate[0];

    return $dtAODLastDate;

}

function GetAODLocation($prmSCNo, $prmBuyerPONo, $prmD2DConnt){

	$sql = " SELECT d2d_master_gatepass_location.transferTo
             FROM d2d_master_gatepass_location Inner Join d2d_Pack_Export_Header ON d2d_Pack_Export_Header.destination = d2d_master_gatepass_location.id
             WHERE  d2d_Pack_Export_Header.scNumber =  '$prmSCNo' AND d2d_Pack_Export_Header.bpo =  '$prmBuyerPONo' AND
             d2d_Pack_Export_Header.`status` =  'SEND'";

    $resLocation =  $prmD2DConnt->RunQuery($sql);
    
    $arrLocation =  mysql_fetch_row($resLocation);       

    return $arrLocation[0];
}


function GetHLCOutLocation($prmSCNo, $prmBuyerPONo, $prmD2DConnt){

	$strHLCOutLocation = "";

	$sql = " SELECT stock_aod_header.transferTo, stock_aod_header.eneterDate
	         FROM stock_aod_header
	         WHERE stock_aod_header.scNo =  '$prmSCNo' AND stock_aod_header.bpo =  '$prmBuyerPONo'";

	$resHLCOutLocation = $prmD2DConnt->RunQuery($sql);

	if(mysql_num_rows($resHLCOutLocation)>0){

		$arrHLCOutLocation = mysql_fetch_row($resHLCOutLocation);

		$strHLCOutLocation = $arrHLCOutLocation[0]."~".$arrHLCOutLocation[1];
	}
	
	

	return $strHLCOutLocation;         
}

?>