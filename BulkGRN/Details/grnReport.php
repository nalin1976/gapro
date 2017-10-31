<?php
 session_start();
include "../../Connector.php";
$backwardseperator = "../../";
$xml = simplexml_load_file('../../config.xml');
$DisplayRatioCodeInReport = $xml->GRN->DisplayRatioCodeInReport;
$DisplayLocationInReport = $xml->GRN->DisplayLocationInReport;
$ReportISORequired = $xml->companySettings->ReportISORequired;
$DisplayScNo = $xml->GRN->DisplayReportScNo;
$DisplayReportBuyerPoNo  = $xml->GRN->DisplayReportBuyerPoNo;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Good Received Note : : Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="java.js" type="text/javascript"></script>
<style type="text/css">
<!--
.style4 {
	font-size: xx-large;
	color: #FF0000;
}
.style3 {
	font-size: xx-large;
	color: #FF0000;
}
-->

</style>
<?php 

	$MainStoreCompanyID = $_GET["MainStoreID"];
	$SubStoreID 		= $_GET["SubStoreID"];
	
	$Sql_Store = "SELECT intAutomateCompany FROM mainstores WHERE strMainID='$MainStoreCompanyID' ";
	
	$result_StoreDet = $db->RunQuery($Sql_Store);

		
		while($rowS = mysql_fetch_array($result_StoreDet))
		{
			$Autocom = $rowS["intAutomateCompany"];
		}
?>

</head>

<body>
<table width="800" border="0" align="center" >
<?php
		$grnno=$_GET["grnno"];
		$grnYear = $_GET["grnYear"];
		//$grnno="1487";
		$SQL_alldetails="select GH.intBulkGrnNo,GH.intYear as poYear,GH.strInvoiceNo,DATE_FORMAT(GH.dtRecdDate,'%d-%m-%Y') as dtRecdDate,GH.intStatus as grnStatus,date_format(GH.dtAdviceDate,'%d-%m-%Y')as dtAdviceDate,GH.intConfirmedBy,DATE_FORMAT(GH.dtmConfirmedDate,'%d-%m-%Y') as dtmConfirmedDate, GH.intUserId,GH.strSupAdviceNo, 
PH.intBulkPoNo,PH.strCurrency,PH.intYear,date_format(PH.dtDeliveryDate,'%d-%m-%Y')as dtDeliveryDate,PH.strPINO, PH.intShipmentModeId,PH.strPayTerm,PH.intPayMode, S.strTitle as supTitle,S.strSupplierCode,S.strAddress1 as supAddress1,S.strAddress2 as supAddress2,S.strStreet as supStreet,S.strCity as supCity,S.strCountry as supCountry,C.strName, C.strAddress1,C.strAddress2,C.strStreet,C.strCity,C.strZipCode,C.strPhone, C.strEMail,C.strFax,C.strWeb, PH.intDeliverTo,
(select UA.Name from useraccounts UA where UA.intUserID = GH.intConfirmedBy ) as ConfirmedPerson, 
(select shipmentterms.strShipmentTerm from shipmentterms where shipmentterms.strShipmentTermId = PH.intShipmentTermID)
 as ShippingTerm,
(select SM.strDescription from shipmentmode SM where SM.intShipmentModeId= PH.intShipmentModeId) as ShippingMode, 
(select PM.strDescription from popaymentmode PM where PM.strPayModeId = PH.intPayMode) as PmntMode ,
(select PT.strDescription from popaymentterms PT where PT.strPayTermId = PH.strPayTerm) as PmntTerm ,(select UA.Name from useraccounts UA where UA.intUserID = GH.intUserId) as preparedperson, 
(select UA.Name from useraccounts UA where UA.intUserID = PH.intMerchandiser) as merchandiser 
from bulkgrnheader GH,bulkpurchaseorderheader PH,suppliers S,companies C where GH.intBulkGrnNo = '$grnno' AND GH.intYear='$grnYear' AND PH.intBulkPoNo = GH.intBulkPoNo AND PH.intYear = GH.intBulkPoYear AND PH.strSupplierID = S.strSupplierID AND PH.intDeliverTo = C.intCompanyID;";
$result_alldetails = $db->RunQuery($SQL_alldetails);		
		while($row = mysql_fetch_array($result_alldetails))
		{		
		$intGrnNo					= $row["intBulkGrnNo"];
		$intGRNYear					= $row["poYear"];
		$intGRNYearnew				= substr($intGRNYear, -2);
		$strInvoiceNo				= $row["strInvoiceNo"];
		$strSupAdviceNo				= $row["strSupAdviceNo"];
		$dtmAdviceDate				= $row["dtAdviceDate"];
		$strBatchNO					= $row["strBatchNO"];
		$dtmConfirmedDate			= $row["dtmConfirmedDate"];
		$strName					= $row["strName"];
		$comAddress1				= $row["strAddress1"];
		$comAddress2				= $row["strAddress2"];
		$comStreet					= $row["strStreet"];
		$comCity					= $row["strCity"];
		$comZipCode					= $row["strZipCode"];
		$strPhone					= $row["strPhone"];
		$comEMail					= $row["strEMail"];
		$comFax						= $row["strFax"];
		$comWeb						= $row["strWeb"];
		$strTitle					= $row["strTitle"];
		$strAddress1				= $row["strAddress1"];
		$strAddress2				= $row["strAddress2"];
		$strStreet					= $row["strStreet"];
		$strCity					= $row["strCity"];
		$strCountry					= $row["strCountry"];
		$ConfirmedPerson			= $row["ConfirmedPerson"];
		$ShippingMode				= $row["ShippingMode"];
		$ShippingTerm				= $row["ShippingTerm"];
		$PmntMode					= $row["PmntMode"];
		$PmntTerm					= $row["PmntTerm"];
		$dtmDeliveryDate			= $row["dtDeliveryDate"];
		$intPONo					= $row["intBulkPoNo"];
		$intYear					= $row["intYear"];
		$intYearnew					= substr($intYear,-2);
		$strPINO					= $row["strPINO"];
		$preparedperson				= $row["preparedperson"];
		$grnStatus 					= $row["grnStatus"];
		$dtmRecievedDate 			= $row["dtRecdDate"];
		$merchandiser				= $row["merchandiser"];		
		$supTitle					= $row["supTitle"];
		$subAddress1				= $row["supAddress1"];
		$subAddress2				= $row["supAddress2"];
		$supStreet					= $row["supStreet"];
		$supCity					= $row["supCity"];
		$supCountry					= $row["supCountry"];
		$poCurrency					= $row["strCurrency"];
		$currencyName 				= GetCurrencyName($poCurrency);
		$supplierCode				= $row["strSupplierCode"];		
		$intDeliverTo 				= $row["intDeliverTo"];
		$suppCountryName 			= GetCountryName($supCountry);
		}
		
$report_companyId = $intDeliverTo;
		$colspan = 6;
		?>
  <tr>
    <td><?php include $backwardseperator.'reportHeader.php';?></td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0">
      <!--<tr>
        <td width="20%"><img src="../../images/logo.jpg" alt="" class="normalfnt" /></td>
        <td width="6%" class="normalfnt">&nbsp;</td>
        <td width="74%" style="font-family: Arial;	font-size: 16pt;	color: #000000;font-weight: bold;" >
<?php //echo $strName; ?><p class="normalfnt">
			<?php //echo $comAddress1." ".$comAddress2." ".$comStreet." ".$comCity." ".$comCountry."."."Tel:".$comPhone." ".$comZipCode." Fax: ".$comFax." E-Mail: ".$comEMail." Web: ".$comWeb;?></p>		  </td>
      </tr>
-->    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="head2BLCK">
      <tr>
        <td width="85%" height="38" class="head2BLCK">BULK GOODS RECEIVED NOTE</td>
        <td width="15%" class="head2BLCK">&nbsp;<?php
			
   					if($ReportISORequired == "true")
   					{
   						$xmlISO = simplexml_load_file('../../iso.xml');
   						echo  $xmlISO->ISOCodes->StyleGRNReport;
						}          
         ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="normalfnt2bldBLACKmid"><table width="100%" border="0">
      <tr>
        <td width="53%" rowspan="2"><table width="100%" border="0">
            <tr>
              <td align="left" valign="top" class="normalfnBLD1">Supplier Code</td>
              <td class="normalfnt"><?php echo $supplierCode;?></td>
            </tr>
			<?php
			$suppDetails = ($supTitle=="" ? "":$supTitle.'<br/>');
			$suppDetails .= ($subAddress1=="" ? "":$subAddress1.'<br/>');
			$suppDetails .= ($subAddress2=="" ? "":$subAddress2.'<br/>');
			$suppDetails .= ($supStreet=="" ? "":$supStreet.'<br/>');
			$suppDetails .= ($suppCountryName=="" ? "":$suppCountryName.'.');
			?>
			
            <tr>
              <td width="26%" align="left" valign="top" class="normalfnBLD1">Supplier</td>
              <td width="74%" class="normalfnt"><?php echo $suppDetails;?>
                </td>
            </tr>

        </table></td>
        <td width="47%" height="45" valign="top"><table width="100%" border="0" class="tablez">
              <tr> 
                <td width="34%" class="normalfnBLD1">Invoice No :</td>
              <td width="66%" class="normalfnth2B" align="left"><?php echo $strInvoiceNo;?></td>
            </tr>

        </table></td>
      </tr>
      <tr>
        <td valign="top"></span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="19%" class="normalfnBLD1">GRN No</td>
        <td width="1%" class="normalfnt">:</td>
        <td width="29%" class="normalfnt"><?php echo $intGRNYear."/".$intGrnNo;?></td>
        <td width="16%" class="normalfnBLD1">Merchandiser</td>
        <td width="1%" class="normalfnt">:</td>
        <td width="34%" class="normalfnt"><?php echo $merchandiser;?></td>
      </tr>
      <tr>
        <td class="normalfnBLD1">PO No</td>
        <td class="normalfnt">:</td>
        <td class="normalfnt"><?php echo $intYear."/".$intPONo;?></td>
        <td class="normalfnBLD1">P.I. No</td>
        <td class="normalfnt">:</td>
        <td class="normalfnt"><?php echo $strPINO;?>&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnBLD1">PO Payment Mode</td>
        <td class="normalfnt">:</td>
        <td class="normalfnt"><?php	echo $PmntMode;?></td>
        <td class="normalfnBLD1">PO Payment Term</td>
        <td class="normalfnt">:</td>
        <td class="normalfnt"><?php echo $PmntTerm;?></td>
      </tr>
      <tr>
        <td class="normalfnBLD1">Shipment Mode</td>
        <td class="normalfnt">:</td>
        <td class="normalfnt"><?php echo $ShippingMode;?></td>
        <td class="normalfnBLD1">Shipment Term</td>
        <td class="normalfnt">:</td>
        <td class="normalfnt"><?php echo $ShippingTerm;?></td>
      </tr>
      <tr>
        <td class="normalfnBLD1">Supplier Advice No</td>
          <td class="normalfnt">:</td>
          <td class="normalfnt"><?php echo $strSupAdviceNo;?></td>
        <td class="normalfnBLD1">Delivery Date</td>
        <td class="normalfnt">:</td>
        <td class="normalfnt"><?php echo $dtmDeliveryDate;?></td>
      </tr>
      <tr>
        <td class="normalfnBLD1">Supplier Advice Date</td>
        <td class="normalfnt">:</td>
        <td class="normalfnt"><?php echo $dtmAdviceDate;?></td>
        <td class="normalfnBLD1">GRN Date</td>
          <td class="normalfnt">:</td>
          <td class="normalfnt"><?php echo $dtmRecievedDate;?></td>
      </tr>
      <tr style="visibility:hidden">
        <td class="normalfnBLD1">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnBLD1">Supplier Batch No</td>
          <td class="normalfnt"></td>
          <td class="normalfnt"><?php echo $strBatchNO;?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="normalfnt2bldBLACKmid"><?php 
		if($grnStatus==10)
		{
			echo "<span class=\"style4\">Cancelled GRN ";
		}
		elseif($grnStatus==0)
		{
			echo "<span class=\"head2\">Not Approved";
		}
		?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
        <tr> 
          <td width="22%" class="normalfntBtab">ITEM DESCRIPTION</td>
          <td width="5%" class="normalfntBtab">UNIT</td>
          <td width="7%" class="normalfntBtab">COLOR</td>
          <td width="9%" class="normalfntBtab">SIZE</td>
          <td width="8%" class="normalfntBtab">RATE <br/>(<?php echo $currencyName?>)</td>
          <td width="7%" class="normalfntBtab">PO </br>QTY</td>
          <td width="7%" class="normalfntBtab">GRN QTY</td>
          <td width="8%" class="normalfntBtab">VALUE <br/>(<?php echo $currencyName?>)</td>
          <?php
        
         if($DisplayLocationInReport == "true")
         {         
         ?>
         <td width="9%" height="35" class="normalfntBtab">Location</td>
         <?php
         }
         ?>
        </tr>
        <?php
		$sum = 0;
		$sumexcessqty = 0;
		$sumvalue = 0;
			 
			 $SQL_RowData ="SELECT GD.intMatDetailID,GD.strColor,GD.strSize,
GD.dblQty as grnQty, GD.dblExQty ,MIL.strItemDescription, GD.strUnit, GD.dblRate,PD.dblQty as POqty
FROM bulkgrndetails GD
Left Join bulkgrnheader GH ON GD.intBulkGrnNo = GH.intBulkGrnNo AND GH.intYear = GD.intYear 
Left Join matitemlist MIL ON GD.intMatDetailID = MIL.intItemSerial 
Right Join bulkpurchaseorderdetails PD ON PD.intBulkPoNo = GH.intBulkPoNo AND PD.strColor = GD.strColor AND PD.strSize = GD.strSize AND PD.intMatDetailId = GD.intMatDetailID AND GH.intBulkPoYear = PD.intYear 
WHERE GD.intBulkGrnNo = '$grnno' AND GD.intYear = '$grnYear'";

		$result_RowData = $db->RunQuery($SQL_RowData);
		
		while($row = mysql_fetch_array($result_RowData))
		{		
			$sum  += $row["grnQty"];
		    $sumexcessqty += $row["dblExQty"];
			$multi = $row["grnQty"] * $row["dblRate"];
			$sumvalue += $multi;
		?>
        <tr> 
      
          <td class="normalfntTAB"> 
            <?php echo $row["strItemDescription"];?>          </td>
          <td class="normalfntTAB"><?php echo $row["strUnit"];?></td>
          <td class="normalfntTAB"><?php echo $row["strColor"];?></td>
          <td class="normalfntTAB"><?php echo $row["strSize"];?></td>
          <td class="normalfntRiteTAB"><?php echo  number_format($row["dblRate"],4);?></td>
          <td class="normalfntRiteTAB"><?php echo $row["POqty"];?></td>
          <td class="normalfntRiteTAB"><?php echo  number_format($row["grnQty"],2);?></td>
          <td class="normalfntRiteTAB"><?php echo number_format($multi,2);?></td>
           <?php
        
         if($DisplayLocationInReport == "true")
         {       
         	
         ?>
			<td class="normalfntRiteTAB">
		<?php
          if($grnStatus==0)
          {
			$sqlLoc = "SELECT strBinName,SL.strLocName 
			FROM stocktransactions_bulk_temp ST 
			INNER JOIN mainstores MS ON ST.strMainStoresID = MS.strMainID
			INNER JOIN substores SS ON SS.strSubID = ST.strSubStores 
			Inner Join storeslocations SL ON SL.strLocID = ST.strLocation 
			INNER JOIN storesbins SB ON SB.strBinID = ST.strBin 
			WHERE intDocumentNo ='$grnno' AND intDocumentYear = '$grnYear'  AND strColor =  '" . $row["strColor"]. "' AND strSize ='" . $row["strSize"]. "' AND strType = 'GRN' AND intMatDetailId = '". $row["intMatDetailID"] ."'";
		}
		else
		{				
			$sqlLoc = "SELECT strBinName,SL.strLocName 
			FROM stocktransactions_bulk ST 
			INNER JOIN mainstores MS ON ST.strMainStoresID = MS.strMainID
			INNER JOIN substores SS ON SS.strSubID = ST.strSubStores 
			Inner Join storeslocations SL ON SL.strLocID = ST.strLocation 
			INNER JOIN storesbins SB ON SB.strBinID = ST.strBin 
			WHERE intDocumentNo ='$grnno' AND intDocumentYear = '$grnYear'  AND strColor =  '" . $row["strColor"]. "' AND strSize ='" . $row["strSize"]. "' AND strType = 'GRN' AND intMatDetailId = '". $row["intMatDetailID"] ."'";

		}
	$resultLocation = $db->RunQuery($sqlLoc);
while($row_Location=mysql_fetch_array($resultLocation))
{      
	echo $row_Location["strLocName"]. "<br/>" .$row_Location["strBinName"];
	break ;
}    
          
          ?>			</td>
          <?php
          }
          ?>
        </tr>
        <?php
		}
		?>
        <tr> 
          <td colspan="<?php echo $colspan; ?>" class="normalfnt2bldBLACKmid">TOTAL</td>
          <td class="normalfntRiteTAB" style="vertical-align:middle;"><b><?php echo $sum;?></b></td>
          <td class="normalfntRiteTAB" style="vertical-align:middle;"><b><?php echo  number_format($sumvalue,2);?></b></td>
			 <?php
        
         if($DisplayLocationInReport == "true")
         {         
         ?>
         <td width="9%" height="35" class="normalfntTAB"></td>
         <?php
         }
         ?>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="84"><table width="100%" border="0">
        <tr>
          <td width="6%" >&nbsp;</td> 
          <td width="25%" class="bcgl1txt1">&nbsp;<?php echo $preparedperson;?>&nbsp;</td>
          <td width="6%">&nbsp;</td>
          <td width="25%" class="bcgl1txt1">&nbsp;<?php echo $ConfirmedPerson;?>&nbsp;</td>
		  <td width="6%">&nbsp;</td>
          <td width="25%" class="bcgl1txt1">&nbsp;</td>
		  <td width="6%">&nbsp;</td>
        </tr>
        <tr>
          <td class="normalfnth2Bm">&nbsp;</td> 
          <td  class="normalfntMid"><?php echo $dtmRecievedDate;?></td>
          <td class="normalfnth2Bm">&nbsp;</td>
          <td class="normalfntMid"><?php echo $dtmConfirmedDate;?></td>
		  <td >&nbsp;</td>
          <td class="normalfnth2Bm">&nbsp;</td>
		  <td  >&nbsp;</td>
        </tr>
        <tr>
          <td class="normalfnth2Bm">&nbsp;</td>
          <td  class="normalfntMid">Prepared By</td>
          <td class="normalfnth2Bm">&nbsp;</td>
          <td class="normalfntMid">Comfirmed By </td>
		  <td >&nbsp;</td>
          <td class="normalfntMid">Authorized By</td>
          <td>&nbsp;</td>
        </tr>
		
    </table></td>
  </tr>
  <?php if($grnStatus!=0){?>
  <tr>
    <td class="normalfnt">GRN Status : CONFIRMED <?php  echo "(".$ConfirmedPerson."-".$dtmConfirmedDate.")";?></td>
  </tr>
 <?php }?>
  <tr>
    <td class="normalfnt"><?php
	if($grnStatus==0){
		//include "grnConfirmReport.php";
		echo 'GRN Status : Pending';
	}
	?></td>
  </tr>
</table>
<?php
function GetCurrencyName($currencyId)
{
global $db;
	$sql="select strCurrency from currencytypes where intCurID='$currencyId'";
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
return $row["strCurrency"];
}

function GetCountryName($supCountry)
{
global $db;
	$sql="select strCountry from country where intConID='$supCountry';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["strCountry"];
	}
}
?>
</body>
</html>
