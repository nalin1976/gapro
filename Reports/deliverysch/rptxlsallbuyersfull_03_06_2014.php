<?php

session_start();
include "../../Connector.php";
include "EConnector.php";

//$detailContent = '';

$dblTarnsportCost = 0;
$dblClearingCost = 0;
$dblInterestCharges = 0;
$dblExporExpences = 0;

$intGrandTotalDeliveryQty = 0;
$dblGrandTotalFOB = 0;
$dblGrandTotalFabCost = 0;

$dtFromDate = $_GET['prmfrom'];
$dtToDate = $_GET['prmto'];
$intProductCategoryCode = $_GET['prmpc'];

$filename = 'allbuyerswithfull.xls';

header("Content-Description: File Transfer");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$filename");

//$headerContent = "Costing Date\tStyle No\tSC No\tDescription\tBuyer\tBuyer Division\tSeason\tBuying Office\tCosting SMV\tFOB\tEff.\tTotal Qty\tUser\tBuyer PO No\tBuyer PO Qty\tDelivery Date\tHand Over Date\tTot. SMV\tTot. FOB\tUpcharge\tFabric Cost\tOther Cost\tFinance Charge\tInterest Charge\tFac. Cost\tCop. Cost\tCM\tTot. CM\t$/SMV\tGP\tNP\tNP/FOB\n";

$headerContent = "<table><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td colspan='3' style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:18px;'>Buyer Purchase Order Listing</td></tr><tr><td>&nbsp;</td><td>From : &nbsp; ".date("Y-m-d",strtotime($dtFromDate))."</td><td>To :</td><td align='left'>".date("Y-m-d",strtotime($dtToDate))."</td></tr><tr><td>&nbsp;</td></tr>";

$headerContent .= "<tr><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Costing Date</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Style No</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>SC No</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Description</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Product Category</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Buyer</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Buyer Division</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Season</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Buying Office</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>User</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Total Qty</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Buyer PO No</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Delivery Date</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Hand Over Date</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Buyer PO Qty</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Eff.</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Costing SMV</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>FOB</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Total SMV</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Total FOB</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Upcharge</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Fabric Cost</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Other Cost</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Finance Charge</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Interest Charge</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Factory Cost</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Corporate Cost</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>CM Per Pc</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Total CM</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>$/SMV</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>CM/UM</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;' align='right'>UM</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>GP</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>NP</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>NP/FOB</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Invoice No</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Invoice Date</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Invoice Qty</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Invoice Value</td><td style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-top:#000000 thin solid;'>Sub Contract Charges</td></tr>";

print($headerContent);

$resOrderList = GetDeliveryOrderList($dtFromDate, $dtToDate, $intProductCategoryCode);

while($rowOrderList = mysql_fetch_array($resOrderList)){
	
	$dblTarnsportCost = 0;
	$dblClearingCost = 0;
	$dblInterestCharges = 0;
	$dblExporExpences = 0;
	
	$_dblFabricCost  = 0;
	$_dblLabourCost = 0;	
	$_dblCopCost = 0;
	$_dblSubContractCharges = 0;
	
	$_intStyelId = $rowOrderList['intStyleId'];
	$_intOrderQty = $rowOrderList['intQty'];
	$_intDeliveryQty = $rowOrderList['dblQty'];	
	$_intSubQty = $rowOrderList['intSubContractQty'];
	
	$_dblEFF = $rowOrderList['reaEfficiencyLevel'];
	$_dblSMV = $rowOrderList['reaSMV'];
	$_dblFOB = $rowOrderList['reaFOB'];
	
	$_strCategory = $rowOrderList['strCatName'];
	
	#------ Upcharge calculation area -----------------------------------	
	$_dblTotalUpCharge = (float)$rowOrderList['reaUPCharges'] * $_intDeliveryQty;
	#------ End upcharge calculation -------------------------------------
	
	#----------------------------------------------------------------------
	#========== ESC value calculation =====================================
	$_dblESCValue = ($_dblFOB/100)*0.25;
	$_dblESCTotalValue = $_dblESCValue * $_intDeliveryQty;
	#======================================================================
	
	
	$_dbl_total_smv = GetTotalSMV($_dblSMV, $_intDeliveryQty);
	
	$_dbl_total_fob = GetTotalFOB($_dblFOB, $_intDeliveryQty);
	
	$_dblFabricCost = CalculateFabricCost($_intStyelId, $_intOrderQty, $_intDeliveryQty);
	
	$_dblAccPackCost = CalculateAccPackCost($_intStyelId, $_intOrderQty, $_intDeliveryQty);
	
	$_dblServiceCost = CalculateServiceOtherCost($_intStyelId, $_intOrderQty, $_intDeliveryQty);
	
	$_dblOtherCost = floatval($_dblAccPackCost + $_dblServiceCost + $_dblESCTotalValue);
	
	$_dblFinanceCharges = $dblTarnsportCost + $dblClearingCost + $dblExporExpences; //$dblTarnsportCost
	
	$_dblLabourCost =  CalculateLabourCost($_dblEFF, $_dblSMV, $_intDeliveryQty, $_intSubQty, $_intOrderQty);
	
		
	$_dblSubContractCharges  = CalculateSubContractCost($_intStyelId, $_intOrderQty, $_intDeliveryQty);
	
	#----------------------------------------------------------------------------
	#========== Calculate of corporate cost =====================================
	$_dblCopCost = ($_intDeliveryQty * $_dblSMV) * 0.0234;
	#========== End of corperate cost calculation area ==========================  
	
	$_dblTotalDirectCost =  $_dblFabricCost +  $_dblOtherCost + $_dblFinanceCharges + $dblInterestCharges;
	
	$_dblTotCM = (($_dbl_total_fob - $_dblTotalDirectCost)+$_dblSubContractCharges) + $_dblTotalUpCharge;
	$_dblCMPerPc = $_dblTotCM/$_intDeliveryQty;
	$_dblSMVRate = $_dblCMPerPc/$_dblSMV;
	
	$_dblCMUM = ($_dblSMVRate/100)*$_dblEFF;
	$_dblUM = ($_dbl_total_smv/$_dblEFF)*100;
	
	$_dblGP = $_dblTotCM - $_dblLabourCost;
	$_dblNP = $_dblGP - $_dblCopCost;
	$_dblNPFOB = ($_dblNP/$_dbl_total_fob)*100;
	
	
	
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
	$dblInvoiceQty = '';
	$dblInvoiceValue = '';
	
	$result_invoice_info = GetInvoiceDetails($rowOrderList['intSRNO'], $rowOrderList['intBPO']);
	
	while($row_invoice = mysql_fetch_array($result_invoice_info)){
		$strInvoiceNo = $row_invoice['strInvoiceNo'];
		$dtInvoiceDate = date("Y-m-d",strtotime($row_invoice['dtmInvoiceDate']));
		$dblInvoiceQty = $row_invoice['dblQuantity'];
		$dblInvoiceValue = $row_invoice['dblAmount'];
	}
	
	
	
	
	//$detailContent .= date("Y-m-d",strtotime($rowOrderList['dtmDate']))."\t".$rowOrderList['strStyle']."\t".$rowOrderList['intSRNO']."\t".$rowOrderList['strDescription']."\t".$rowOrderList['strName']."\t".$rowOrderList['strDivision']."\t".$rowOrderList['strSeason']."\t".$rowOrderList['BuyingOffice']."\n";
	$detailContent .= "<tr height='25px'><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".date("Y-m-d",strtotime($rowOrderList['dtmDate']))."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$rowOrderList['strStyle']."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$rowOrderList['intSRNO']."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$rowOrderList['strDescription']."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$_strCategory."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$rowOrderList['strName']."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$rowOrderList['strDivision']."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$rowOrderList['strSeason']."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$rowOrderList['BuyingOffice']."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$rowOrderList['Name']."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$_intOrderQty."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$rowOrderList['intBPO']."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".date("Y-m-d", strtotime($rowOrderList['dtDateofDelivery']))."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$rowOrderList['dtmHandOverDate']."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$_intDeliveryQty."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$_dblEFF."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$_dblSMV."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$_dblFOB."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$_dbl_total_smv."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dbl_total_fob,2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$_dblTotalUpCharge."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dblFabricCost, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dblOtherCost,2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dblFinanceCharges, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($dblInterestCharges, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dblLabourCost, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dblCopCost, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dblCMPerPc, 4)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dblTotCM, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dblSMVRate, 4)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dblCMUM, 4)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dblUM, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dblGP, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dblNP, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dblNPFOB, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$strInvoiceNo."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$dtInvoiceDate."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".$dblInvoiceQty."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($dblInvoiceValue,2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid;'>".number_format($_dblSubContractCharges,2)."</td></tr>";
	
}

$detailContent .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; border-left:#000000 thin solid; font-weight:bold;'>".intval($intGrandTotalDeliveryQty)."</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; font-weight:bold; border-left:#000000 thin solid;'>".number_format($dblGrandTotalFOB, 2)."</td><td>&nbsp;</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; font-weight:bold; border-left:#000000 thin solid;'>".number_format($dblGrandTotalFabCost, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; font-weight:bold; border-left:#000000 thin solid;'>".number_format($dblGrandTotalOther, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; font-weight:bold; border-left:#000000 thin solid;'>".number_format($dblGrandTotalFinance, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; font-weight:bold; border-left:#000000 thin solid;'>".number_format($dblGrandTotalInterestCharge, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; font-weight:bold; border-left:#000000 thin solid;'>".number_format($dblGrandTotalFacCost, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; font-weight:bold; border-left:#000000 thin solid;'>".number_format($dblGrandTotalCopCost, 2)."</td><td>&nbsp;</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; font-weight:bold; border-left:#000000 thin solid;'>".number_format($dblGrandTotalCM, 2)."</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; font-weight:bold; border-left:#000000 thin solid;'>".number_format($dblGrandTotalGP, 2)."</td><td style='font-family:Arial, Helvetica, sans-serif; font-size:10px; border-right:#000000 thin solid; border-bottom:#000000 thin solid; font-weight:bold; border-left:#000000 thin solid;'>".number_format($dblGrandTotalNP, 2)."</td></tr>";

$detailContent .= "</table>";
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
		
		$_dblTotReqQty = intval($_dblReqQty + $_dblWastageQty);
		
		$_dblTotalValue = floatval($_dblTotReqQty * $_dblUnitPrice);
		
		$_dblCostPerPc = floatval($_dblTotalValue / $prmOrderQty);
		
		$_dblTotalFabricCost += floatval($_dblCostPerPc * $prmDeliveryQty);
		
		$_dblLineWiseFabricCost = floatval($_dblCostPerPc * $prmDeliveryQty);
		
		
		$dblTarnsportCost += CalculateTransportCharge($_intOriginType, $_dblLineWiseFabricCost);
		$dblClearingCost += CalculateClearingCost($_intOriginType, $_dblLineWiseFabricCost);
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
		$_intOriginType = $rowFabric['intOriginNo'];
		
		$_dblReqQty =  $prmOrderQty * $_dblConPerPc;
		$_dblWastageQty = ($_dblReqQty /100) * $_dblWastage;
		
		$_dblTotReqQty = intval($_dblReqQty + $_dblWastageQty);
		
		$_dblTotalValue = floatval($_dblTotReqQty * $_dblUnitPrice);
		
		$_dblCostPerPc = floatval($_dblTotalValue / $prmOrderQty);
		
		$_dblTotalAccPackCost += floatval($_dblCostPerPc * $prmDeliveryQty);
		
		$_dblLineWiseCost = floatval($_dblCostPerPc * $prmDeliveryQty);
		
		
		$dblClearingCost += CalculateClearingCost($_intOriginType, $_dblLineWiseCost);
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
		$_intOriginType = $rowFabric['intOriginNo'];
		
		$_dblReqQty =  $prmOrderQty * $_dblConPerPc;
		$_dblWastageQty = ($_dblReqQty /100) * $_dblWastage;
		
		$_dblTotReqQty = intval($_dblReqQty + $_dblWastageQty);
		
		$_dblTotalValue = floatval($_dblTotReqQty * $_dblUnitPrice);
		
		$_dblCostPerPc = floatval($_dblTotalValue / $prmOrderQty);
		
		$_dblTotalServiceOtherCost += floatval($_dblCostPerPc * $prmDeliveryQty);	
			
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

function CalculateClearingCost($prmOrignType, $prmItemCost){

	$_dblClearingCost = 0;
	
	switch((int)$prmOrignType){
		
		case 1:		
		case 2:
		
			$resCurrency = GetLKRExchangeValue();
			
			while($rowCurrency = mysql_fetch_array($resCurrency)){				
				$_dblExRate = $rowCurrency['dblRateq'];
			}
		
			$_dblUSDValue = floatval(10000/$_dblExRate);
		
			$_dblClearingCost = ((float)$prmItemCost/100)*1;
			
			if($_dblUSDValue > $_dblClearingCost){
				$_dblClearingCost = $_dblUSDValue;	
			}
			
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


function GetDeliveryOrderList($prmFromDate, $prmToDate, $prmProductCategoryCode){
	
global $db;

$strSql = " SELECT orders.strStyle, orders.strDescription, orders.intQty, orders.reaSMV, orders.reaFOB, orders.reaEfficiencyLevel, specification.intSRNO, ".
          "        deliveryschedule.dblQty, deliveryschedule.intBPO, deliveryschedule.dtDateofDelivery, buyers.strName, useraccounts.Name, ".
		  "        deliveryschedule.dtmHandOverDate, orders.dtmDate, orders.intStyleId, buyerdivisions.strDivision, seasons.strSeason,  ".
		  "        buyerbuyingoffices.strName AS BuyingOffice, orders.reaUPCharges, orders.intSubContractQty, productcategory.strCatName".
          " FROM   deliveryschedule Inner Join orders ON deliveryschedule.intStyleId = orders.intStyleId Inner Join specification ON ". 
		  "        orders.intStyleId = specification.intStyleId Inner Join buyers ON orders.intBuyerID = buyers.intBuyerID Inner Join useraccounts ON ".  
		  "        orders.intUserID = useraccounts.intUserID Left Join buyerdivisions ON buyers.intBuyerID = buyerdivisions.intBuyerID AND ".
		  "        orders.intDivisionId = buyerdivisions.intDivisionId Left Join seasons ON orders.intSeasonId = seasons.intSeasonId ".
		  "        Left Join buyerbuyingoffices ON buyers.intBuyerID = buyerbuyingoffices.intBuyerID AND orders.intBuyingOfficeId = ".
		  "        buyerbuyingoffices.intBuyingOfficeId Left Join productcategory ON orders.productSubCategory = productcategory.intCatId ".
          " WHERE  deliveryschedule.dtDateofDelivery between '$prmFromDate' AND '$prmToDate' AND deliveryschedule.strShippingMode <> '7' AND ".
		  "        orders.intStatus <> 14";
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







?>