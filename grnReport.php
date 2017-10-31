
<?php
include "Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Good Received Note : : Report</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #666666}
-->
</style>
</head>

<body>
<table width="800" border="0" align="center">
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="20%"><img src="images/GaPro_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
        <td width="6%" class="normalfnt">&nbsp;</td>
        <td width="74%" class="tophead"><p class="head2BLCK">
		<?php
		//$grnno=$_GET["grnno"];
		$grnno="1487";
		$SQL_alldetails="select grnheader.intGrnNo,grnheader.intGRNYear,grnheader.strInvoiceNo,grnheader.dtmAdviceDate,grnheader.intConfirmedBy,grnheader.dtmConfirmedDate,grnheader.strBatchNO, grnheader.intUserId,grnheader.strSupAdviceNo, purchaseorderheader.intPONo,purchaseorderheader.intYear,purchaseorderheader.dtmDeliveryDate,purchaseorderheader.strPINO,purchaseorderheader.strShipmentMode,purchaseorderheader.strShipmentTerm,purchaseorderheader.strPayTerm,purchaseorderheader.strPayMode,suppliers.strTitle,suppliers.strAddress1,suppliers.strAddress2,suppliers.strStreet,suppliers.strCity,suppliers.strCountry,companies.strName,companies.strAddress1,companies.strAddress2,companies.strStreet,companies.strCity,companies.strCountry,companies.strZipCode,companies.strPhone,companies.strEMail,companies.strFax,companies.strWeb, (select useraccounts.Name from useraccounts where useraccounts.intUserID = grnheader.intConfirmedBy ) as ConfirmedPerson, (select shipmentmode.strDescription from shipmentmode where shipmentmode.intShipmentModeId= purchaseorderheader.strShipmentMode) as ShippingMode, (select shipmentterms.strShipmentTerm from shipmentterms where shipmentterms.strShipmentTermId = purchaseorderheader.strShipmentTerm ) as ShippingTerm, (select popaymentmode.strDescription from popaymentmode where popaymentmode.strPayModeId = purchaseorderheader.strPayMode) as PmntMode ,  (select popaymentterms.strDescription from  popaymentterms where popaymentterms.strPayTermId = purchaseorderheader.strPayTerm) as PmntTerm ,(select useraccounts.Name from useraccounts where useraccounts.intUserID = grnheader.intUserId) as preparedperson from grnheader,purchaseorderheader,suppliers,companies where grnheader.intGrnNo = '$grnno' AND purchaseorderheader.intPONo = grnheader.intPoNo AND purchaseorderheader.intYear = grnheader.intYear AND purchaseorderheader.strSupplierID = suppliers.strSupplierID AND purchaseorderheader.intDelToCompID = companies.intCompanyID;";


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
		}
		?>
		<?php echo $strName; ?></p><p class="normalfnt">
			<?php echo $comAddress1." ".$comAddress2." ".$comStreet." ".$comCity." ".$comCountry."."."Tel:".$comPhone." ".$comZipCode." Fax: ".$comFax." E-Mail: ".$comEMail." Web: ".$comWeb;?></p>
			</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="head2BLCK">
      <tr>
        <td width="82%" height="38" class="head2BLCK">GOODS RECEIVED NOTE</td>
        <td width="18%" class="head2BLCK">QAP -18-A</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="normalfnt2bldBLACKmid"><table width="100%" border="0">
      <tr>
        <td width="50%"><table width="100%" border="0">
            <tr>
              <td width="24%" valign="top" class="normalfnt2bldBLACK">SUPPLIER</td>
              <td width="76%" class="normalfnt"><?php echo $strTitle.".";?><br />
                <?php echo $strAddress1.",";?><br />
                <?php echo $strAddress2."<br/>".$strStreet.",";?><br />
                <?php echo $strCity."".$strCountry.".";?></td>
            </tr>

        </table></td>
        <td width="50%" valign="top"><table width="100%" border="0" class="tablez">
              <tr> 
                <td width="34%" class="normalfnt2bldBLACK">INVOICE NO:</td>
              <td width="66%" class="normalfnth2B"><?php echo $strInvoiceNo;?></td>
            </tr>

        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="22%" class="normalfnt2bldBLACK">G. R. N No</td>
        <td width="28%" class="normalfnt"><?php echo $intGRNYearnew."/".$intGrnNo;?></td>
        <td width="19%" class="normalfnt2bldBLACK">Merchandiser</td>
        <td width="31%" class="normalfnt"><?php echo $ConfirmedPerson;?></td>
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
    </table></td>
  </tr>
  <tr>
    <td class="normalfnt2bldBLACKmid">&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
        <tr> 
          <td width="9%" height="35" class="normalfntBtab">ORDER #</td>
          <td width="10%" class="normalfntBtab">BPONO</td>
          <td width="22%" class="normalfntBtab">ITEM DESCRIPTION</td>
          <td width="7%" class="normalfntBtab">UNIT</td>
          <td width="8%" class="normalfntBtab">COLOR</td>
          <td width="9%" class="normalfntBtab">SIZE</td>
          <td width="8%" class="normalfntBtab">RATE (USD)</td>
          <td width="9%" class="normalfntBtab">QTY</td>
          <td width="7%" class="normalfntBtab">EXCESS QTY</td>
          <td width="11%" class="normalfntBtab">VALUE (USD)</td>
        </tr>
        <?php
		$sum = 0;
		$sumexcessqty = 0;
		$sumvalue = 0;
		
		
		$SQL_RowData="select grnheader.intPoNo, grndetails.intStyleId,grndetails.intMatDetailID,grndetails.strColor,grndetails.strSize,grndetails.dblQty,grndetails.dblExcessQty, purchaseorderdetails.strUnit,purchaseorderdetails.dblUnitPrice,purchaseorderdetails.strBuyerPONO,purchaseorderdetails.intYear,(select matitemlist.strItemDescription from matitemlist where matitemlist.intItemSerial = grndetails.intMatDetailID) as Description from grnheader,grndetails, purchaseorderdetails where grndetails.intGrnNo = '$grnno' AND grndetails.intStyleId = purchaseorderdetails.intStyleId  AND grndetails.intMatDetailID = purchaseorderdetails.intMatDetailID AND grndetails.strColor = purchaseorderdetails.strColor AND grndetails.strSize = purchaseorderdetails.strSize AND grnheader.intPoNo = purchaseorderdetails.intPoNo and grnheader.intYear = purchaseorderdetails.intYear ;";
		$result_RowData = $db->RunQuery($SQL_RowData);

		
		while($row = mysql_fetch_array($result_RowData))
		{		
			$sum  += $row["dblQty"];
		    $sumexcessqty += $row["dblExcessQty"];
			$multi = $row["dblQty"] * $row["dblUnitPrice"];
			$sumvalue += $multi;
		?>
        <tr> 
          <td class="normalfntTAB"> 
            <?php echo $row["intStyleId"];?>
          </td>
          <td class="normalfntTAB"><?php echo $row["strBuyerPONO"];?></td>
          <td class="normalfntRiteTAB"> 
            <?php echo $row["Description"];?>
          </td>
          <td class="normalfntRiteTAB"><?php echo $row["strUnit"];?></td>
          <td class="normalfntRiteTAB"><?php echo $row["strColor"];?></td>
          <td class="normalfntRiteTAB"><?php echo $row["strSize"];?></td>
          <td class="normalfntRiteTAB"><?php echo $row["dblUnitPrice"];?></td>
          <td class="normalfntRiteTAB"><?php echo $row["dblQty"];?></td>
          <td class="normalfntRiteTAB"><?php echo $row["dblExcessQty"];?></td>
          <td class="normalfntRiteTAB"><?php echo $multi;?></td>
        </tr>
        <?php
		}
		?>
        <tr> 
          <td colspan="7" class="normalfnt2bldBLACKmid">TOTAL</td>
          <td class="normalfntRiteTAB"> 
            <?php echo $sum;?>
          </td>
          <td class="normalfntRiteTAB"><?php echo $sumexcessqty;?></td>
          <td class="normalfntRiteTAB"><?php echo $sumvalue;?></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><table width="39%" border="0">
        <tr> 
          <td width="45%" class="bcgl1txt1"><?php echo $preparedperson;?></td>
          <td width="9%">&nbsp;</td>
          <td width="46%" class="bcgl1txt1">&nbsp;</td>
        </tr>
        <tr> 
          <td class="normalfnth2Bm">Prepared By</td>
          <td class="normalfnth2Bm">&nbsp;</td>
          <td class="normalfnth2Bm">Checked By</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td class="normalfnt">GRN Status : CONFIRMED <?php  echo "(".$ConfirmedPerson."-".$dtmConfirmedDateNewDate."/".$dtmConfirmedDateNewMonth."/".$dtmConfirmedDateNewYear.")";?></td>
  </tr>
</table>
</body>
</html>
