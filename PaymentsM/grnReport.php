<?php
 session_start();
include "../Connector.php";
$xml = simplexml_load_file('../config.xml');
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
<title>Gapro - Good Received Note : : Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="mootools/java.js" type="text/javascript"></script>
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
//echo " <style type=\"text/css\"> body {background-image: url(../../images/not-valid.png);} </style>"
?>

</head>

<body>
<table width="800" border="0" align="center" >
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="20%"><img src="../images/eplan_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
        <td width="6%" class="normalfnt">&nbsp;</td>
        <td width="74%" style="font-family: Arial;	font-size: 16pt;	color: #000000;font-weight: bold;" ><?php
		$grnno=$_GET["grnno"];
		$grnYear = $_GET["grnYear"];
		//$grnno="1487";
		$SQL_alldetails="select grnheader.intGrnNo,grnheader.intGRNYear,grnheader.strInvoiceNo, 
		grnheader.dtmRecievedDate,grnheader.intStatus as grnStatus,grnheader.dtmAdviceDate,
		grnheader.intConfirmedBy,grnheader.dtmConfirmedDate,grnheader.strBatchNO, 
		grnheader.intUserId,grnheader.strSupAdviceNo, purchaseorderheader.intPONo,
		purchaseorderheader.intYear,purchaseorderheader.dtmDeliveryDate,
		purchaseorderheader.strPINO,	purchaseorderheader.strShipmentMode,
		purchaseorderheader.strShipmentTerm,purchaseorderheader.strPayTerm,
		purchaseorderheader.strPayMode,	suppliers.strTitle as supTitle,suppliers.strAddress1 as supAddress1,
		suppliers.strAddress2 as supAddress2,suppliers.strStreet as supStreet,
		suppliers.strCity as supCity,suppliers.strCountry as supCountry,
		companies.strName,companies.strAddress1,companies.strAddress2,
		companies.strStreet,companies.strCity,
		suppliers.strCountry,
		companies.strZipCode,companies.strPhone,
		companies.strEMail,companies.strFax,companies.strWeb, (select useraccounts.Name from useraccounts 
		where useraccounts.intUserID = grnheader.intConfirmedBy ) as ConfirmedPerson, (select shipmentmode.strDescription from shipmentmode where shipmentmode.intShipmentModeId= purchaseorderheader.strShipmentMode) as ShippingMode, (select shipmentterms.strShipmentTerm from shipmentterms where shipmentterms.strShipmentTermId = purchaseorderheader.strShipmentTerm ) as ShippingTerm, (select popaymentmode.strDescription from popaymentmode where popaymentmode.strPayModeId = purchaseorderheader.strPayMode) as PmntMode ,  (select popaymentterms.strDescription from  popaymentterms where popaymentterms.strPayTermId = purchaseorderheader.strPayTerm) as PmntTerm ,(select useraccounts.Name from useraccounts where useraccounts.intUserID = grnheader.intUserId) as preparedperson, (select useraccounts.Name from useraccounts where useraccounts.intUserID = purchaseorderheader.intUserId) as merchandiser from grnheader,purchaseorderheader,suppliers,companies where grnheader.intGrnNo = '$grnno' AND purchaseorderheader.intPONo = grnheader.intPoNo AND purchaseorderheader.intYear = grnheader.intYear AND purchaseorderheader.strSupplierID = suppliers.strSupplierID AND purchaseorderheader.intDelToCompID = companies.intCompanyID;";
		
		//echo $SQL_alldetails;

$result_alldetails = $db->RunQuery($SQL_alldetails);

		
		while($row = mysql_fetch_array($result_alldetails))
		{		
		$intGrnNo=$row["intGrnNo"];
		$intGRNYear=$row["intGRNYear"];
		$intGRNYearnew= substr($intGRNYear, -2);
		$strInvoiceNo=$row["strInvoiceNo"];
		$strSupAdviceNo=$row["strSupAdviceNo"];
		$dtmAdviceDate=$row["dtmAdviceDate"];
		$dtmAdviceDateNew= substr($dtmAdviceDate,-19,10);
		$dtmAdviceDateNewDate= substr($dtmAdviceDateNew,-2);
		$dtmAdviceDateNewYear=substr($dtmAdviceDateNew,-10,4);
		$dtmAdviceDateNewmonth1=substr($dtmAdviceDateNew,-5);
		$dtmAdviceDateNewMonth=substr($dtmAdviceDateNewmonth1,-5,2);
		$strBatchNO=$row["strBatchNO"];
		$dtmConfirmedDate=$row["dtmConfirmedDate"];
		$dtmConfirmedDateNew= substr($dtmConfirmedDate,-19,10);
		$dtmConfirmedDateNewDate= substr($dtmConfirmedDateNew,-2);
		$dtmConfirmedDateNewYear=substr($dtmConfirmedDateNew,-10,4);
		$dtmConfirmedDateNewmonth1=substr($dtmConfirmedDateNew,-5);
		$dtmConfirmedDateNewMonth=substr($dtmConfirmedDateNewmonth1,-5,2);
		$strName=$row["strName"];
		$comAddress1=$row["strAddress1"];
		$comAddress2=$row["strAddress2"];
		$comStreet=$row["strStreet"];
		$comCity=$row["strCity"];
		$comCountry=$row["strCountry"];
		$comZipCode=$row["strZipCode"];
		$strPhone=$row["strPhone"];
		$comEMail=$row["strEMail"];
		$comFax=$row["strFax"];
		$comWeb=$row["strWeb"];
		$strTitle=$row["strTitle"];
		$strAddress1=$row["strAddress1"];
		$strAddress2=$row["strAddress2"];
		$strStreet=$row["strStreet"];
		$strCity=$row["strCity"];
		$strCountry=$row["strCountry"];
		$ConfirmedPerson=$row["ConfirmedPerson"];
		$ShippingMode=$row["ShippingMode"];
		$ShippingTerm=$row["ShippingTerm"];
		$PmntMode=$row["PmntMode"];
		$PmntTerm=$row["PmntTerm"];
		$dtmDeliveryDate=$row["dtmDeliveryDate"];
		$dtmDeliveryDateNew= substr($dtmDeliveryDate,-19,10);
		$dtmDeliveryDateNewDate= substr($dtmDeliveryDateNew,-2);
		$dtmDeliveryDateNewYear=substr($dtmDeliveryDateNew,-10,4);
		$dtmDeliveryDateNewmonth1=substr($dtmDeliveryDateNew,-5);
		$dtmDeliveryDateNewmonth=substr($dtmDeliveryDateNewmonth1,-5,2);
		$intPONo=$row["intPONo"];
		$intYear=$row["intYear"];
		$intYearnew= substr($intYear,-2);
		$strPINO=$row["strPINO"];
		$preparedperson=$row["preparedperson"];
		$grnStatus = $row["grnStatus"];
		$dtmRecievedDate = $row["dtmRecievedDate"];
		$merchandiser=$row["merchandiser"];
		
		$supTitle=$row["supTitle"];
		$subAddress1=$row["subAddress1"];
		$subAddress2=$row["subAddress2"];
		$supStreet=$row["supStreet"];
		$supCity=$row["supCity"];
		$supCountry=$row["supCountry"];
		}
		
		$colspan = 5;
		?>
<?php echo $strName; ?><p class="normalfnt">
			<?php echo $comAddress1." ".$comAddress2." ".$comStreet." ".$comCity." ".$comCountry."."."Tel:".$comPhone." ".$comZipCode." Fax: ".$comFax." E-Mail: ".$comEMail." Web: ".$comWeb;?></p>		  </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="head2BLCK">
      <tr>
        <td width="82%" height="38" class="head2BLCK">GOODS RECEIVED NOTE</td>
        <td width="18%" class="head2BLCK">&nbsp;<?php
			
   					if($ReportISORequired == "true")
   					{
   						//$xmlISO = simplexml_load_file('../../iso.xml');
   						//echo  $xmlISO->ISOCodes->StyleGRNReport;
						}          
         ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="normalfnt2bldBLACKmid"><table width="100%" border="0">
      <tr>
        <td width="50%" rowspan="2"><table width="100%" border="0">
            <tr>
              <td width="24%" valign="top" class="normalfnt2bldBLACK">SUPPLIER</td>
              <td width="76%" class="normalfnt"><?php echo $supTitle.".";?><br />
                <?php echo $subAddress1.",";?><br />
                <?php echo $subAddress2."<br/>".$supStreet.",";?><br />
                <?php echo $supCity." ".$supCountry.".";?></td>
            </tr>

        </table></td>
        <td width="50%" height="45" valign="top"><table width="100%" border="0" class="tablez">
              <tr> 
                <td width="34%" class="normalfnt2bldBLACK">INVOICE NO:</td>
              <td width="66%" class="normalfnth2B"><?php echo $strInvoiceNo;?></td>
            </tr>

        </table></td>
      </tr>
      <tr>
        <td valign="top">
		<?php 
		//echo $SQL_alldetails;
		if($grnStatus==10)
		{
			echo "<span class=\"style4\">Cancelled GRN ";
		}
		elseif($grnStatus==0)
		{
			echo "<span class=\"head2\">Not Approved";
		}
		?></span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="22%" class="normalfnt2bldBLACK">G. R. N No</td>
        <td width="28%" class="normalfnt"><?php echo $intGRNYearnew."/".$intGrnNo;?></td>
        <td width="19%" class="normalfnt2bldBLACK">Merchandiser</td>
        <td width="31%" class="normalfnt"><?php echo $merchandiser;?></td>
      </tr>
      <tr>
        <td class="normalfnt2bldBLACK">P.O. No</td>
        <td class="normalfnt"><?php echo $intYearnew."/".$intPONo;?></td>
        <td class="normalfnt2bldBLACK">P.I. No</td>
        <td class="normalfnt"><?php echo $strPINO;?>&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt2bldBLACK">PO PAYMENT MODE</td>
        <td class="normalfnt"><?php	echo $PmntMode;?></td>
        <td class="normalfnt2bldBLACK">PO PAYMENT TERM</td>
        <td class="normalfnt"><?php echo $PmntTerm;?></td>
      </tr>
      <tr>
        <td class="normalfnt2bldBLACK">SHIPMENT MODE</td>
        <td class="normalfnt"><?php echo $ShippingMode;?></td>
        <td class="normalfnt2bldBLACK">SHIPMENT TERM</td>
        <td class="normalfnt"><?php echo $ShippingTerm;?></td>
      </tr>
      <tr>
        <td class="normalfnt2bldBLACK">SUPPLIER ADVICE NO</td>
          <td class="normalfnt"><?php echo $strSupAdviceNo;?></td>
        <td class="normalfnt2bldBLACK">DELIVERY DATE</td>
        <td class="normalfnt"><?php echo $dtmDeliveryDateNewDate."/".$dtmDeliveryDateNewmonth."/".$dtmDeliveryDateNewYear;?></td>
      </tr>
      <tr>
        <td class="normalfnt2bldBLACK">SUPPLIER ADVICE DATE</td>
        <td class="normalfnt"><?php echo $dtmAdviceDateNewDate."/".$dtmAdviceDateNewMonth."/".$dtmAdviceDateNewYear;?></td>
        <td class="normalfnt2bldBLACK">SUPPLIER BATCH NO</td>
          <td class="normalfnt"><?php echo $strBatchNO;?></td>
      </tr>
      <tr>
        <td class="normalfnt2bldBLACK">GRN DATE</td>
        <td class="normalfnt"><?php echo $dtmRecievedDate;?></td>
        <td class="normalfnt2bldBLACK"></td>
          <td class="normalfnt"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="normalfnt2bldBLACKmid">&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
        <tr> 
        <?php
        
         if($DisplayRatioCodeInReport == "true")
         {        
         	$colspan ++; 
         ?>
         <td width="9%" height="35" class="normalfntBtab">Item Code</td>
         <?php
         }
         ?>
		 	<td width="9%" height="35" class="normalfntBtab">Style</td>
		 	<?php 
			
				
			
			if($DisplayScNo =='true')
			{
				$colspan ++;
         	echo	"<td width=\"3%\" height=\"35\" class=\"normalfntBtab\">SCNO</td>";
				
			}
			
			if ($DisplayReportBuyerPoNo == "true")
			{
				$colspan ++;
				echo	"<td width=\"11%\" class=\"normalfntBtab\">BPONO</td>";
			}
		  ?>
		 	
          
          <td width="18%" class="normalfntBtab">ITEM DESCRIPTION</td>
          <td width="5%" class="normalfntBtab">UNIT</td>
          <td width="7%" class="normalfntBtab">COLOR</td>
          <td width="9%" class="normalfntBtab">SIZE</td>
          <td width="8%" class="normalfntBtab">RATE (USD)</td>
          <td width="7%" class="normalfntBtab">QTY</td>
          <td width="8%" class="normalfntBtab">VALUE (USD)</td>
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
		
		
		
/*		$SQL_RowData="select grnheader.intPoNo, grndetails.intStyleId,grndetails.intMatDetailID,grndetails.strColor,grndetails.strSize,grndetails.dblQty,grndetails.dblExcessQty, purchaseorderdetails.strUnit,purchaseorderdetails.dblUnitPrice,purchaseorderdetails.strBuyerPONO,purchaseorderdetails.intYear,(select matitemlist.strItemDescription from matitemlist where matitemlist.intItemSerial = grndetails.intMatDetailID) as Description from grnheader,grndetails, purchaseorderdetails where grndetails.intGrnNo = '$grnno' AND grndetails.intStyleId = purchaseorderdetails.intStyleId  AND grndetails.intMatDetailID = purchaseorderdetails.intMatDetailID AND grndetails.strColor = purchaseorderdetails.strColor AND grndetails.strSize = purchaseorderdetails.strSize AND grnheader.intPoNo = purchaseorderdetails.intPoNo;";*/
		
		/*
		
		// This commented area will work without checking material ratio
		$SQL_RowData="select grnheader.intPoNo, grndetails.intStyleId,grndetails.intMatDetailID,grndetails.strColor,grndetails.strSize,grndetails.dblQty,grndetails.dblExcessQty, purchaseorderdetails.strUnit,purchaseorderdetails.dblUnitPrice,purchaseorderdetails.strBuyerPONO,purchaseorderdetails.intYear,(select matitemlist.strItemDescription from matitemlist where matitemlist.intItemSerial = grndetails.intMatDetailID) as Description
FROM
matitemlist
Inner Join grndetails ON matitemlist.intItemSerial = grndetails.intMatDetailID
Inner Join grnheader ON grndetails.intGrnNo = grnheader.intGrnNo AND grndetails.intGRNYear = grnheader.intGRNYear
Inner Join purchaseorderdetails ON grnheader.intPoNo = purchaseorderdetails.intPoNo AND grnheader.intYear = purchaseorderdetails.intYear and purchaseorderdetails.strBuyerPONO = grndetails.strBuyerPONO 
where grndetails.intGrnNo = '$grnno' AND grndetails.intGRNYear = '$grnYear' AND grndetails.intStyleId = purchaseorderdetails.intStyleId  AND grndetails.intMatDetailID = purchaseorderdetails.intMatDetailID AND grndetails.strColor = purchaseorderdetails.strColor AND grndetails.strSize = purchaseorderdetails.strSize AND grnheader.intPoNo = purchaseorderdetails.intPoNo";

*/
/*
		$SQL_RowData = "SELECT distinct grnheader.intPoNo, grndetails.intStyleId,grndetails.intMatDetailID,grndetails.strColor,grndetails.strSize,grndetails.dblQty,grndetails.dblExcessQty, 
purchaseorderdetails.strUnit,purchaseorderdetails.dblUnitPrice,purchaseorderdetails.strBuyerPONO,purchaseorderdetails.intYear,
(SELECT matitemlist.strItemDescription FROM matitemlist WHERE matitemlist.intItemSerial = grndetails.intMatDetailID) AS Description, materialratio.materialRatioID FROM 
matitemlist INNER JOIN grndetails ON matitemlist.intItemSerial = grndetails.intMatDetailID INNER JOIN grnheader ON 
grndetails.intGrnNo = grnheader.intGrnNo AND grndetails.intGRNYear = grnheader.intGRNYear INNER JOIN purchaseorderdetails ON 
grnheader.intPoNo = purchaseorderdetails.intPoNo AND grnheader.intYear = purchaseorderdetails.intYear AND 
purchaseorderdetails.strBuyerPONO = grndetails.strBuyerPONO INNER JOIN 
materialratio ON grndetails.strBuyerPONO = materialratio.strBuyerPONO AND grndetails.intStyleId = materialratio.intStyleId AND
grndetails.strColor = materialratio.strColor AND grndetails.strSize = materialratio.strSize
 WHERE grndetails.intGrnNo = '$grnno' AND grndetails.intGRNYear = '$grnYear' AND 
grndetails.intStyleId = purchaseorderdetails.intStyleId AND grndetails.intMatDetailID = purchaseorderdetails.intMatDetailID AND 
grndetails.strColor = purchaseorderdetails.strColor AND grndetails.strSize = purchaseorderdetails.strSize AND 
grnheader.intPoNo = purchaseorderdetails.intPoNo";
	*/		
			 $SQL_RowData = "  SELECT grndetails.intStyleId,
			 orders.strStyle,
			 grndetails.intMatDetailID,grndetails.strColor, grndetails.strBuyerPONO, grndetails.strSize,grndetails.dblQty, grndetails.dblExcessQty , 
grndetails.intGRNYear , grnheader.intPONo , matitemlist.strItemDescription, purchaseorderdetails.strUnit, purchaseorderdetails.dblUnitPrice, materialratio.materialRatioID
FROM
grndetails
Left Join grnheader ON grndetails.intGrnNo = grnheader.intGrnNo AND grnheader.intGRNYear = grndetails.intGRNYear
Left Join matitemlist ON grndetails.intMatDetailID = matitemlist.intItemSerial
Right Join purchaseorderdetails ON purchaseorderdetails.intPoNo = grnheader.intPoNo AND purchaseorderdetails.strColor = grndetails.strColor AND purchaseorderdetails.strSize = grndetails.strSize AND purchaseorderdetails.strBuyerPONO = grndetails.strBuyerPONO AND purchaseorderdetails.intStyleId = grndetails.intStyleId AND purchaseorderdetails.intMatDetailID = grndetails.intMatDetailID AND grnheader.intYear = purchaseorderdetails.intYear
Left Join materialratio ON materialratio.strColor = grndetails.strColor AND materialratio.strSize = grndetails.strSize AND materialratio.intStyleId = grndetails.intStyleId AND materialratio.strMatDetailID = grndetails.intMatDetailID AND materialratio.strSize = grndetails.strSize AND materialratio.strBuyerPONO = grndetails.strBuyerPONO AND materialratio.intStyleId = grndetails.intStyleId
Inner Join orders ON orders.intStyleId=grndetails.intStyleId
WHERE grndetails.intGrnNo = '$grnno' AND grndetails.intGRNYear = '$grnYear' ";

		//echo $SQL_RowData;
		$result_RowData = $db->RunQuery($SQL_RowData);
		
		while($row = mysql_fetch_array($result_RowData))
		{		
			$sum  += $row["dblQty"];
		    $sumexcessqty += $row["dblExcessQty"];
			$multi = $row["dblQty"] * $row["dblUnitPrice"];
			$sumvalue += $multi;
		?>
        <tr> 
        <?php
        
         if($DisplayRatioCodeInReport == "true")
         {         
         	
         ?>
         <td width="9%" height="35" class="normalfntTAB"><?php echo $row["materialRatioID"];?></td>
         <?php
		 }
         ?>
          
		  <td class="normalfntTAB"><?php echo $row["strStyle"];?></td>
		  <?PHP
$sqlscno="select intSRNO from specification where intStyleId='".$row["intStyleId"]."';";
$result_scno = $db->RunQuery($sqlscno);
while($row_scno=mysql_fetch_array($result_scno))
{
	$scno = $row_scno["intSRNO"];
}
?>	
		  <?php 
		  	if($DisplayScNo =='true')
			{
			
		  		echo "<td class=\"normalfntTAB\">$scno</td>";
				
			}
			if ($DisplayReportBuyerPoNo == "true")
			{
				echo "<td class=\"normalfntTAB\">".$row["strBuyerPONO"]."</td>";
			}
				
				
		  ?>
		  
         
          <td class="normalfntTAB"> 
            <?php echo $row["strItemDescription"];?>          </td>
          <td class="normalfntTAB"><?php echo $row["strUnit"];?></td>
          <td class="normalfntTAB"><?php echo $row["strColor"];?></td>
          <td class="normalfntTAB"><?php echo $row["strSize"];?></td>
          <td class="normalfntRiteTAB"><?php echo  number_format($row["dblUnitPrice"],2);?></td>
          <td class="normalfntRiteTAB"><?php echo  number_format($row["dblQty"],2);?></td>
          <td class="normalfntRiteTAB"><?php echo number_format($multi,2);?></td>
           <?php
        
         if($DisplayLocationInReport == "true")
         {       
         	
         ?>
			<td class="normalfntRiteTAB">
		<?php
          if($grnStatus==0)
          {
         	 $sqlLoc = "SELECT strBinName,storeslocations.strLocName FROM stocktransactions_temp 
		  INNER JOIN storesbinallocation ON stocktransactions_temp.strMainStoresID = storesbinallocation.strMainID 
		  Inner Join storeslocations ON storeslocations.strLocID = storesbinallocation.strLocID
AND stocktransactions_temp.strSubStores = storesbinallocation.strSubID AND stocktransactions_temp.strLocation = storesbinallocation.strLocID 
 AND stocktransactions_temp.strBin = storesbinallocation.strBinID INNER JOIN storesbins ON storesbinallocation.strBinID = storesbins.strBinID
WHERE intDocumentYear = '$grnYear' AND intStyleId = '" . $row["intStyleId"] . "' AND
strBuyerPoNo = '" . $row["strBuyerPONO"] . "' AND intDocumentNo ='$grnno' AND strColor =  '" . $row["strColor"]. "' AND strSize ='" . $row["strSize"]. "' AND strType = 'GRN' AND
intMatDetailId = '". $row["intMatDetailID"] ."'";
			}
			else
			{
				

 $sqlLoc = "SELECT strBinName,storeslocations.strLocName FROM stocktransactions 
		  INNER JOIN storesbinallocation ON stocktransactions.strMainStoresID = storesbinallocation.strMainID 
		  Inner Join storeslocations ON storeslocations.strLocID = storesbinallocation.strLocID
AND stocktransactions.strSubStores = storesbinallocation.strSubID AND stocktransactions.strLocation = storesbinallocation.strLocID 
 AND stocktransactions.strBin = storesbinallocation.strBinID INNER JOIN storesbins ON storesbinallocation.strBinID = storesbins.strBinID
WHERE intDocumentYear = '$grnYear' AND intStyleId = '" . $row["intStyleId"] . "' AND
strBuyerPoNo = '" . $row["strBuyerPONO"] . "' AND intDocumentNo ='$grnno' AND strColor =  '" . $row["strColor"]. "' AND strSize ='" . $row["strSize"]. "' AND strType = 'GRN' AND
intMatDetailId = '". $row["intMatDetailID"] ."'";
//echo  $sqlLoc;
			}	



  
	$resultLocation = $db->RunQuery($sqlLoc);
while($row_Location=mysql_fetch_array($resultLocation))
{      
	//echo $sqlLoc;
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
          <td class="normalfntRiteTAB">          </td>
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
    <td height="84"><table width="42%" border="0">
        <tr> 
          <td width="40%" height="35" class="bcgl1txt1"><?php echo $preparedperson;?></td>
          <td width="8%">&nbsp;</td>
          <td width="52%" class="bcgl1txt1">&nbsp;</td>
        </tr>
        <tr> 
          <td height="21" class="normalfnth2Bm">Prepared By</td>
          <td class="normalfnth2Bm">&nbsp;</td>
          <td class="normalfnth2Bm">Authorized By</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td class="normalfnt">GRN Status : CONFIRMED <?php  echo "(".$ConfirmedPerson."-".$dtmConfirmedDateNewDate."/".$dtmConfirmedDateNewMonth."/".$dtmConfirmedDateNewYear.")";?></td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
  </tr>

</table>
<?php 
if($grnStatus==10)
{
echo " <style type=\"text/css\"> body {background-image: url(../../images/not-valid.png);} </style>";
}

?>
</body>
</html>
